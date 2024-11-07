import React, { useContext } from 'react';
import { ImportContext, ImportContextProvider } from './Import/ImportContext';
import ImportList from './Import/ImportList';
import AddNewImportPage from './Import/AddNewImportPage';
import ViewImportPage from './Import/ImportList/ViewImportPage';
import EditImportPage from './Import/ImportList/EditImportPage';
import '../css/main.scss';
import { createRoot } from 'react-dom/client';

// import 'bootstrap/dist/css/bootstrap.min.css';
// import 'bootstrap/dist/js/bootstrap.bundle.min.js';

const selector = pawtucketUIApps.Import.selector;
const pUIImport = pawtucketUIApps.Import;
// console.log('pUIImport', pUIImport);

const Import = () => {
  
  const { viewMode, setFilesSelected, setFilesUploaded, setFormCode, setFormData, setInitialQueueLength, 
          setIsSubmitted, setNumFilesOnDrop, setPreviousFilesUploaded, setQueue, setSchema, setSessionKey, 
          setSessionList, setUploadProgress, setUploadStatus, setViewMode 
        } = useContext(ImportContext);
   
  const setInitialState = (e) => {
    setFilesSelected([]);
    setFilesUploaded([]);
    setFormCode(null);
    setFormData(null);
    setInitialQueueLength(0);
    setIsSubmitted(false);
    setNumFilesOnDrop(0);
    setPreviousFilesUploaded([]);
    setQueue([]);
    setSchema();
    setSessionKey(null);
    setSessionList([]);
    setUploadProgress({});
    setUploadStatus("not_started");
    setViewMode("import_list");
    e.preventDefault();
  }

  console.log("viewMode: ", viewMode);
  
 
  if(viewMode === "import_list"){
    return (
      <div className='import-list'>
        <ImportList />
      </div>
    )
  }else if (viewMode === "edit_import_page"){
    return (
      <div className='edit-import-page'>
        <EditImportPage setInitialState={(e) => setInitialState(e)}/>
      </div>
    )
  }else if (viewMode === "view_import_page"){
    return (
      <div className='view-import-page'>
        <ViewImportPage setInitialState={(e) => setInitialState(e)} />
      </div>
    )
  }else if(viewMode === "add_new_import_page"){
    return (
      <div className='new-import-page'>
        <AddNewImportPage setInitialState={(e) => setInitialState(e)}/>
      </div >
    )
  }
 }

// /**
//  * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
//  * app loaders to insert this application into the current view.
//  */
// export default function _init() {
// 	ReactDOM.render(<ImportContextProvider> <Import /> </ImportContextProvider> , document.querySelector(selector));
// }

export default function _init() {
  const container = document.querySelector(selector);
  const root = createRoot(container);
  root.render(
    <ImportContextProvider>
      <Import />
    </ImportContextProvider>
  );
}