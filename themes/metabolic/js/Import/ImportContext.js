import React, { createContext, useState } from 'react';
 
const ImportContext = createContext();
const ImportContextProvider = (props) => {

  const [ filesSelected, setFilesSelected ] = useState([]);//files selected before they have been uploaded

  const [ filesUploaded, setFilesUploaded ] = useState([]); //array of files that have been successfully uploaded.

  const [ formCode, setFormCode ] = useState(null); //formcode to indicate what form is being loaded
  
  const [ formData, setFormData ] = useState(null); //formData of the metadata form
  
  const [ initialQueueLength, setInitialQueueLength ] = useState(0); //number of files in queue to be uploaded
  
  const [ isSubmitted, setIsSubmitted ] = useState(false); //boolean if import was submitted or not
  
  const [ numFilesOnDrop, setNumFilesOnDrop ] = useState(0); //total number of files that has been dropped into the dropzone in session
  
  const [ previousFilesUploaded, setPreviousFilesUploaded ] = useState([]); // List of previously uploaded files for form 
  
  const [ queue, setQueue ] = useState([]); // array list of pending uploads

  const [ schema, setSchema ] = useState(); //schema of the form
  
  const [ sessionKey, setSessionKey ] = useState(null); //the sessionKey of an import
  
  const [ sessionList, setSessionList ] = useState([]); //List of all imports
  
  const [ uploadProgress, setUploadProgress ] = useState({}); // progress percentage per each individual upload.
  
  const [ uploadStatus, setUploadStatus ] = useState('not_started');  //status of an upload, default "not_started", other values are "in_progress" and "complete"
  
  const [ viewMode, setViewMode ] = useState('import_list') // values are "import_list", "edit_import_page", "view_import_page" and "add_new_import_page". Used to render various components or "views".

  const [importErrors, setImportErrors] = useState()

  const [importWarnings, setImportWarnings] = useState()

  return (
    <ImportContext.Provider 
      value={{ 
        filesSelected, setFilesSelected,
        filesUploaded, setFilesUploaded,
        formCode, setFormCode,
        formData, setFormData, 
        initialQueueLength, setInitialQueueLength,
        isSubmitted, setIsSubmitted, 
        numFilesOnDrop, setNumFilesOnDrop,
        previousFilesUploaded, setPreviousFilesUploaded,
        queue, setQueue, 
        schema, setSchema,
        sessionKey, setSessionKey,
        sessionList, setSessionList,
        uploadProgress, setUploadProgress, 
        uploadStatus, setUploadStatus, 
        viewMode, setViewMode,
        importErrors, setImportErrors,
        importWarnings, setImportWarnings
    }}>
        {props.children}
    </ImportContext.Provider>
  )
}

export { ImportContextProvider, ImportContext }
