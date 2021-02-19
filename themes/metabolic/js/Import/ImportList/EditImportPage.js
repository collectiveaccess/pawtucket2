import React, { useContext, useEffect } from 'react';
import { ImportContext } from '../ImportContext';
import ImportMetadataForm from '../AddNewImportPage/ImportMetadataForm';
import ImportDropZone from '../AddNewImportPage/ImportDropZone';

import { getSession } from '../ImportQueries';
const baseUrl = pawtucketUIApps.Import.data.baseUrl;

const EditImportPage = () => {
  const { setOpenEditPage, setViewNewImportPage, sessionKey, formData, setFormData } = useContext(ImportContext);

  const { setNumFilesOnDrop, setInitialQueueLength, setFilesUploaded, setQueue, setUploadProgress, setUploadStatus, setSubmissionStatus, setSessionKey, setIsSubmitted } = useContext(ImportContext);

  useEffect(() => {
    if (sessionKey !== null) {
      getSession(baseUrl, sessionKey, function(data){
        console.log("getSession: ", data);
        if (data.formData !== "null") {
          let prevFormData = JSON.parse(data.formData);
          console.log('prev formData: ', prevFormData);
          setFormData(prevFormData);
        }
      })
    }
  }, [])

  const backToImportList = (e) => {
    setOpenEditPage(false);
    setViewNewImportPage(false)

    setIsSubmitted(false);
    setSessionKey(null);
    setFormData(null)
    setNumFilesOnDrop(0);
    setInitialQueueLength(0);
    setFilesUploaded([]);
    setQueue([]);
    setUploadProgress(0);
    setUploadStatus('not_started');
    setSubmissionStatus();

    e.preventDefault();
  }

  // console.log('Edit Session Key: ', sessionKey);
  return (
    <div className='container-fluid' style={{ maxWidth: '60%' }}>
      <button type='button' className='btn btn-secondary mb-5' onClick={(e) => backToImportList(e)}><ion-icon name="ios-arrow-back"></ion-icon>Your Imports</button>
      <ImportDropZone /><ImportMetadataForm />
    </div>
  )
}

export default EditImportPage;