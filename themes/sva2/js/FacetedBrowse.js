import React, { useContext, useEffect, useState } from 'react';
import FacetedBrowseContextProvider from './FacetedBrowse/FacetedBrowseContext';
import FacetedBrowseFilters from './FacetedBrowse/FacetedBrowseFilters';
import FacetedBrowseResults from './FacetedBrowse/FacetedBrowseResults';

const selector = pawtucketUIApps.FacetedBrowse.selector;
const search = pawtucketUIApps.FacetedBrowse.data.search;

const FacetedBrowse = () => {

  console.log("search: ", search);
  const [ isLoading, setIsLoading ] = useState(true);

  useEffect(() => {
    setIsLoading(false);
  }, [])

  if(isLoading === true){
    return (
      <div>
        <h1>Loading...</h1>
      </div>
    )
  }else{
    return (
      <>
        <div className='skip-controls row ml-auto mr-0 align-items-center'>
          <a href="#main-content" className="go-down" tabIndex="1" role="button" aria-label="arrow button to skip to main content"><span className="material-icons down-icon">keyboard_arrow_down</span></a>
          <p className="skip-btn mb-2">SKIP TO MAIN CONTENT</p>
        </div> 	
        <div className="row row-cols-1 row-cols-2-md">
          <FacetedBrowseResults />
          <FacetedBrowseFilters />
        </div>
      </>
    )
  }
}

/**
 * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
  ReactDOM.render(<FacetedBrowseContextProvider> <FacetedBrowse /> </FacetedBrowseContextProvider>, document.querySelector(selector));
}