import React, { useContext, useEffect } from 'react';
import { ImportContext } from '../ImportContext';
import ImportMetadataForm from '../AddNewImportPage/ImportMetadataForm';
import ImportDropZone from '../AddNewImportPage/ImportDropZone';

import { getSession } from '../ImportQueries';
const baseUrl = pawtucketUIApps.Import.data.baseUrl;

const EditImportPage = (props) => {
  const { sessionKey, setFormData, formData } = useContext(ImportContext);

  const { setUploadStatus, setPreviousFilesUploaded } = useContext(ImportContext);

  useEffect(() => {
    if (sessionKey !== null) {
      getSession(baseUrl, sessionKey, function(data){
        // console.log("getSession: ", data);
        if (data.formData) {
          let prevFormData = JSON.parse(data.formData);
          // console.log('prev formData: ', prevFormData);
          setFormData(prevFormData.data);
          
          // Set list of previously uploaded files (not all are necessarily complete, and user may need to restart uploads)
          setPreviousFilesUploaded(data.filesUploaded);
          
          // If at least one existing upload is complete we can allow submission
          let nfiles = data.filesUploaded.length;
          if ((nfiles > 0) && (data.filesUploaded.filter((v) => v.complete).length > 0)) {
          	setUploadStatus('complete');
          }	
        }
      })
    }
  }, [])

  // console.log('Edit Session Key: ', sessionKey);
  return (
    <div className='container-fluid' style={{ maxWidth: '90%' }}>

      <button type='button' className='btn btn-secondary' style={{ marginBottom: "10px" }} onClick={(e) => props.setInitialState(e)}><ion-icon name="ios-arrow-back"></ion-icon>Your Imports</button>
      
      <div className="row justify-content-center">
        <div className="col-5">
          <ImportDropZone />
        </div>

        <div className="col-7">
          <ImportMetadataForm setInitialState={props.setInitialState} />
        </div>
      </div>
      
    </div>
  )
}

export default EditImportPage;