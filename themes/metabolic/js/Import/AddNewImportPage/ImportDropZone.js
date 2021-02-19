import React, { useContext, useEffect } from 'react';
import { ImportContext } from '../ImportContext';
import Dropzone from "react-dropzone";
import SelectedMediaList from './SelectedMediaList';
const tus = require("tus-js-client");

import { getNewSession } from '../ImportQueries';
const baseUrl = pawtucketUIApps.Import.data.baseUrl;

const ImportDropZone = (props) => {

  const { queue, setQueue, setUploadProgress, filesUploaded, setFilesUploaded, uploadStatus, setUploadStatus, initialQueueLength, setInitialQueueLength, numFilesOnDrop, setNumFilesOnDrop, sessionKey, setSessionKey, files, setFiles } = useContext(ImportContext);
  
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
    
    setQueue(q);
    let queueLength = initialQueueLength;
    setInitialQueueLength((q.length) + (queueLength));
  }

  const initNewSession = () => {
    getNewSession(baseUrl, function(data){
      console.log('newSession: ', data);
      setSessionKey(data.sessionKey)
    })
  } 

  useEffect(() => {
    if (sessionKey == null && queue.length > 0) { //if there is no session key AND there are files in queue, create a new session
      initNewSession()
    }
  }, [sessionKey, queue])

  const processQueue = () => {
    let tempFilesUploaded = [...filesUploaded];
    let tempFiles = [...files];
    while(queue.length > 0 && sessionKey !== null){
      // setUploadStatus('in_progress');
      queue.forEach((file) => {
        file == queue.shift();

        tempFiles.push(file);
        setFiles([...tempFiles]);

        //https://master.tus.io/files/
        let tusEndpoint = "http://metabolic3.whirl-i-gig.com:8085/index.php/Import/tus";
        console.log("Upload to", tusEndpoint, sessionKey);

        var upload = new tus.Upload(file, {
          endpoint: tusEndpoint,
          retryDelays: [0, 1000, 3000, 5000],
          chunkSize: 1024 * 512,      // TODO: make configurable
          metadata: {
            filename: file.name,
            filetype: file.type,
            sessionKey: sessionKey,
          },
          onBeforeRequest: function (req) {
            var xhr = req.getUnderlyingObject();
            // console.log("set x-session-key to", sessionKey);
            xhr.setRequestHeader('x-session-key', sessionKey);
          },
          onError: (error) => {
            console.log("Failed because: " + error)
          },
          onProgress: (bytesUploaded, bytesTotal) => {
            setUploadStatus('in_progress');

            var percentage = (bytesUploaded / bytesTotal * 100).toFixed(2);
            setUploadProgress(percentage);
            // console.log(bytesUploaded, bytesTotal, "Percentage: " + percentage + "%")
          },
          onSuccess: () => {
            tempFilesUploaded.push(file);
            setFilesUploaded([...tempFilesUploaded]);
            // console.log("Download %s from %s", upload.file.name, upload.url)
          },
        })
        upload.start();

      }); //foreach

    } //while
    if ((initialQueueLength == filesUploaded.length) && (filesUploaded.length > 0)){
      setUploadStatus('complete');
    }
  }

  // console.log('====================================');
  console.log("uploadStatus : ", uploadStatus);

  return (
    <div>
      <div className="mb-3" style={{ backgroundColor: '#D8D7CE', paddingLeft: '5px' }}>Import Files</div>

      <div className="row justify-content-center mt-5 mb-5 importUploaderDropZone">
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
       
      {(uploadStatus == 'in_progress' || uploadStatus == 'complete') ? <SelectedMediaList/> : '' }
    </div>
  )
}

export default ImportDropZone;