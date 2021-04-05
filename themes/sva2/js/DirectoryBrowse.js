import React, { useContext, useEffect } from 'react';
import DirectoryBrowseContextProvider from './DirectoryBrowse/DirectoryBrowseContext';
import { DirectoryBrowseContext } from './DirectoryBrowse/DirectoryBrowseContext';

import PeopleBrowse from './DirectoryBrowse/PeopleBrowse';
import ExhibitionsBrowse from './DirectoryBrowse/ExhibitionsBrowse';
import DatesBrowse from './DirectoryBrowse/DatesBrowse';

const selector = pawtucketUIApps.DirectoryBrowse.selector;
const directoryPage = pawtucketUIApps.DirectoryBrowse.currentBrowse;

const DirectoryBrowse = () => {
  const { currentBrowse, setCurrentBrowse } = useContext(DirectoryBrowseContext);

  useEffect(() => { 
    setCurrentBrowse(directoryPage)
  }, [currentBrowse])

  if(currentBrowse){
    if(currentBrowse == 'people'){
      return ( <PeopleBrowse /> )
    } else if(currentBrowse == 'exhibitionsByName'){
      return ( <ExhibitionsBrowse /> )
    } else if (currentBrowse == 'exhibitionsByYear') {
      return ( <DatesBrowse /> )
    }
  }else{
    return null;
  }

}

/**
 * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
  ReactDOM.render(<DirectoryBrowseContextProvider> <DirectoryBrowse /> </DirectoryBrowseContextProvider>, document.querySelector(selector));
}
