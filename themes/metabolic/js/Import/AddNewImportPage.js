import React, { useContext, useEffect } from 'react';
import { ImportContext } from './ImportContext';
import ImportMetadataForm from './AddNewImportPage/ImportMetadataForm';
import ImportDropZone from './AddNewImportPage/ImportDropZone';

const AddNewImportPage = (props) => {
  const { setViewNewImportPage, setOpenViewSubmittedImportPage, uploadStatus } = useContext(ImportContext);
  const { setNumFilesOnDrop, setInitialQueueLength, setFilesUploaded, setQueue, setUploadProgress, setUploadStatus, setSubmissionStatus, setSessionKey, setIsSubmitted, setFormData } = useContext(ImportContext);
  
  const backToImportList = (e) => {
    setViewNewImportPage(false);
    setOpenViewSubmittedImportPage(false);

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

  useEffect( () => {
    $(window).on("beforeunload", function () {
      return "Are you sure? You didn't finish the form!";
    });
  
    $(document).ready(function () {
      $("#form-submit-button").on("submit", function (e) {
        $(window).off("beforeunload");
        return true;
      });
    });
  }, [])

  console.log('uploadStatus: ', uploadStatus);

  return (
    <div className='container-fluid' style={{ maxWidth: '60%' }}>

      {(uploadStatus == 'in_progress') ?
        <button type='button' className='btn btn-secondary mb-5' disabled onClick={(e) => backToImportList(e)}><ion-icon name="ios-arrow-back"></ion-icon>Your Imports</button>
        :
        <button type='button' className='btn btn-secondary mb-5' onClick={(e) => backToImportList(e)}><ion-icon name="ios-arrow-back"></ion-icon>Your Imports</button>
      }
      <ImportDropZone />
      <ImportMetadataForm />
      
    </div>
  )
}

export default AddNewImportPage;
