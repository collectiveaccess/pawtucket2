import React, { useContext, useEffect, useState } from 'react';
import { ImportContext } from '../ImportContext';
import Dropzone from "react-dropzone";
import SelectedMediaList from './SelectedMediaList';
const tus = require("tus-js-client");

import { getNewSession } from '../ImportQueries';
const baseUrl = pawtucketUIApps.Import.data.baseUrl;
const siteBaseUrl = pawtucketUIApps.Import.data.siteBaseUrl;

const ImportDropZone = (props) => {

	const { queue, setQueue, uploadProgress, setUploadProgress, filesUploaded, setFilesUploaded, setUploadStatus, initialQueueLength, setInitialQueueLength, numFilesOnDrop, setNumFilesOnDrop, sessionKey, setSessionKey, filesSelected, setFilesSelected, formCode, setFormCode } = useContext(ImportContext);

	const [connections, setConnections] = useState([]) /* List of open tus upload connections */
	const [connectionIndex, setConnectionIndex] = useState(0) /* Index/key for next connection; changes for each allocated connection */
	const [maxConnections, setMaxConnections] = useState(2)
  
	useEffect(() => {
		if (sessionKey == null && queue.length > 0) { //if there is no session key AND there are files in queue, create a new session
		  initNewSession()
		}
	}, [sessionKey, queue])
	
	let progressValues = {}

	const initNewSession = () => {
		getNewSession(baseUrl, formCode, function (data) {
		  setSessionKey(data.sessionKey)
		})
	}

  useEffect(() => {
    processQueue();
  }),[queue];
  
  const selectFiles = (e) => {
    let q = [];
    if (e.target) {  // From <input type="file" ... />
      q.push(...e.target.files);
    }else {  // From dropzone
      q.push(...e);
    }
    
    q = q.filter(f => f.size > 0);
    
    let tempnumfiles = numFilesOnDrop;
    setNumFilesOnDrop(tempnumfiles + q.length);

    setQueue([...q]);

    let queueLength = initialQueueLength;
    setInitialQueueLength((q.length) + (queueLength));
  }

  const processQueue = () => {
    let tempFilesUploaded = [...filesUploaded];
    let tempFilesSelected = [...filesSelected];

    let tempConnectionIndex = connectionIndex;
    let tempConnections = [...connections];

    //maximum number of uploads happening at one time
    // const maxConnections = 4
    if (connections.length >= maxConnections) {
    	// console.log("max connections. skiping for now");
      return;
    }

    while(queue.length > 0 && sessionKey !== null){
      if(connections.length >= maxConnections){
        return;
      } else {
        queue.forEach((file) => {
          file = queue.shift();
          if (!file) { return; }

         progressValues[file.name] = 0;
  
          tempFilesSelected.push(file.name);
          setFilesSelected([...tempFilesSelected]);
  
          //https://master.tus.io/files/
          let tusEndpoint = siteBaseUrl + '/tus';
          
          var upload = new tus.Upload(file, {
            endpoint: tusEndpoint,
            retryDelays: [0, 1000, 3000, 5000],
            chunkSize: 52428800,      // TODO: make configurable
            metadata: {
              filename: file.name,
              filetype: file.type,
              sessionKey: sessionKey,
            },
            onBeforeRequest: function (req) {
              var xhr = req.getUnderlyingObject();
              xhr.setRequestHeader('x-session-key', sessionKey);
            },
            onError: (error) => {
              console.log("Failed because: " + error)
            },
            onProgress: (bytesUploaded, bytesTotal) => {
              setUploadStatus('in_progress');
              
              let percentage = parseFloat((parseInt(bytesUploaded) / parseInt(bytesTotal) * 100).toFixed(2));
			  progressValues[file.name] = percentage;
			  setUploadProgress({...progressValues});
            },
            onSuccess: () => {
              tempFilesUploaded.push(file);
              setFilesUploaded([...tempFilesUploaded]);

              //delete connection from connection index on success
              tempConnections.splice(tempConnectionIndex, 1)
              tempConnectionIndex--
  
              //set to state
              setConnections([...tempConnections])
              setConnectionIndex(tempConnectionIndex)

              if(sessionKey !== null){
                processQueue();
              }

            },
          })
  
          //this is a connection object to add to the connections array
          let tempConnection;
          tempConnection = {
            upload: upload,
            name: file.name
          }
  
          //add connection object to array at specified index
          tempConnections.splice(tempConnectionIndex, 0, tempConnection);
  
          //iterate connection index
          tempConnectionIndex++
  
          //set them to state
          setConnections([...tempConnections]);
          setConnectionIndex(tempConnectionIndex)
  
          upload.start();
        }); //foreach
        
      } //end of else

    } //while
    if ((initialQueueLength == filesUploaded.length) && (filesUploaded.length > 0)){
      setUploadStatus('complete');
    }
    
  }
  
  return (
    <div>
      <div className="mb-1" style={{ backgroundColor: '#D8D7CE', padding: '5px' }}>Import Media</div>

      <div className="row justify-content-center mt-3 mb-3 importUploaderDropZone">
        <Dropzone onDrop={acceptedFiles => { selectFiles(acceptedFiles);}}>
          {({ getRootProps, getInputProps }) => (
            <div {...getRootProps()} className='row importUploaderDropZoneInput'>
              <div className='col align-self-center'>
                <input {...getInputProps()} />
                <div>
                  <h4 style={{ textAlign: 'center' }}>
                    <span className="material-icons md-48">add_circle_outline</span> {' '}
                    Drag media here or click to browse</h4>
                </div>
              </div>                  
            </div>
          )}
        </Dropzone>
      </div>
       
      <SelectedMediaList />
    </div>
  )
}

export default ImportDropZone;