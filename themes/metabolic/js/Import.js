import React, {useContext} from 'react';
import ImportContextProvider from './Import/ImportContext';
import { ImportContext } from './Import/ImportContext';
import ImportList from './Import/ImportList';
import AddNewImportPage from './Import/AddNewImportPage';
import '../css/main.scss';
import ViewSubmittedImportPage from './Import/ImportList/ViewSubmittedImportPage';
import EditImportPage from './Import/ImportList/EditImportPage';

const selector = pawtucketUIApps.Import.selector;
const pUIImport = pawtucketUIApps.Import;
console.log('pUIImport', pUIImport);

const Import = (props) => {
  const { viewNewImportPage, openViewSubmittedImportPage, openEditPage } = useContext(ImportContext);

  if(viewNewImportPage == true){
    return(
      <div className='new-import-page'>
        <AddNewImportPage />
      </div >
    )
  }else if(openViewSubmittedImportPage == true){
    return(
      <div className='submitted-import-page'>
        <ViewSubmittedImportPage />
      </div>
    )
  }else if(openEditPage == true){
    return(
      <div className='edit-import-page'>
        <EditImportPage />
      </div>
    )
  }else{
    return(
      <div className='import-list'>
        <ImportList />
      </div>
    )
  }
}

/**
 * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
	ReactDOM.render(
    <ImportContextProvider>
  		<Import />
    </ImportContextProvider> , document.querySelector(selector));
}
