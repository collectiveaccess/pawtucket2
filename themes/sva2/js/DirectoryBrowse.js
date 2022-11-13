import React, { useContext } from 'react';
import DirectoryBrowseContextProvider from './DirectoryBrowse/DirectoryBrowseContext';
import { DirectoryBrowseContext } from './DirectoryBrowse/DirectoryBrowseContext';

import BrowseBar from "./DirectoryBrowse/BrowseBar";
import BrowseContentContainer from './DirectoryBrowse/BrowseContentContainer';

const selector = pawtucketUIApps.DirectoryBrowse.selector;
const currentBrowse = pawtucketUIApps.DirectoryBrowse.currentBrowse;

const DirectoryBrowse = () => {

  const { displayTitle, setDisplayTitle } = useContext(DirectoryBrowseContext);

  if(currentBrowse){
    return (
      <div className="main-browse">
        <div className="row mb-2">
          <h1 >{displayTitle}</h1>
          <div className='row ml-auto mr-0 align-items-center'>
            <a href="#main-content" className="go-down" tabIndex="1" role="button" aria-label="arrow button to skip to main content"><span className="material-icons down-icon">keyboard_arrow_down</span></a>
            <p className="skip-btn mb-2">SKIP TO MAIN CONTENT</p>
          </div> 	

        </div>
        <BrowseBar />
        <BrowseContentContainer />
      </div>
    )
  }
}

/**
 * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
  ReactDOM.render(<DirectoryBrowseContextProvider> <DirectoryBrowse /> </DirectoryBrowseContextProvider>, document.querySelector(selector));
}
