import React, { useContext, useEffect, useState } from 'react';
import FacetedBrowseContextProvider from './FacetedBrowse/FacetedBrowseContext';
import FacetedBrowseFilters from './FacetedBrowse/FacetedBrowseFilters';
import FacetedBrowseResults from './FacetedBrowse/FacetedBrowseResults';

const selector = pawtucketUIApps.FacetedBrowse.selector;

const FacetedBrowse = () => {

  const [ isLoading, setIsLoading ] = useState(true);

  useEffect(() => {
    setIsLoading(false);
  }, [])

  // console.log(selector);
  if(isLoading === true){
    return (
      <div>
        <h1>Loading...</h1>
      </div>
    )
  }else{
    return (
      <div className="row row-cols-1 row-cols-2-md">
        <FacetedBrowseResults />
        <FacetedBrowseFilters />
      </div>
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