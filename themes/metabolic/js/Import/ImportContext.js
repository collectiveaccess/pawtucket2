import React, { createContext, useState } from 'react';
export const ImportContext = createContext();

const ImportContextProvider = (props) => {

  const [ viewNewImportPage, setViewNewImportPage ] = useState(false); //boolean if newImportPage should be shown.

  const [ openViewSubmittedImportPage, setOpenViewSubmittedImportPage ] = useState(false); //boolean if ViewSubmittedImportPage should be shown.

  const [ openEditPage, setOpenEditPage ] = useState(false); //boolean if EditImportPage should be shown.

  const [ numFilesOnDrop, setNumFilesOnDrop ] = useState(0); //total number of files that has been dropped into the dropzone in session

  const [ initialQueueLength, setInitialQueueLength ] = useState(0); //number of files in queue to be uploaded

  const [files, setFiles] = useState([]);//files before they have been uploaded

  const [ filesUploaded, setFilesUploaded ] = useState([]); //array of files that have been successfully uploaded.
  
  const [ formData, setFormData ] = useState(null); //formData of the metadata form

  const [ queue, setQueue ] = useState([]); // array list of pending uploads

  const [ uploadProgress, setUploadProgress ] = useState(0); // progress percentage of uploads. ?? rethink the usage of this

  const [ uploadStatus, setUploadStatus ] = useState('not_started');  //status of an upload

  const [ isSubmitted, setIsSubmitted ] = useState(false); //boolean if import was submitted or not

  const [ submissionStatus, setSubmissionStatus ] = useState(); //??? may not be needed

  const [ sessionKey, setSessionKey ] = useState(null);

  const [ sessionList, setSessionList ] = useState([]); //List of All imports

  const [ currentImports, setCurrentImports ] = useState([]); //list of imports shown in Your Imports

  return (
    <ImportContext.Provider 
      value={{ 
        viewNewImportPage, setViewNewImportPage, 
        openViewSubmittedImportPage, setOpenViewSubmittedImportPage,
        openEditPage, setOpenEditPage,
        numFilesOnDrop, setNumFilesOnDrop,
        initialQueueLength, setInitialQueueLength,
        files, setFiles,
        filesUploaded, setFilesUploaded,
        formData, setFormData, 
        queue, setQueue, 
        uploadProgress, setUploadProgress, 
        uploadStatus, setUploadStatus, 
        isSubmitted, setIsSubmitted, 
        submissionStatus, setSubmissionStatus,
        sessionKey, setSessionKey,
        sessionList, setSessionList,
        currentImports, setCurrentImports,
    }}>
        {props.children}
    </ImportContext.Provider>
  )
}

export default ImportContextProvider;
