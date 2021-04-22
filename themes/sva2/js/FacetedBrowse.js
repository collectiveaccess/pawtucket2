import React, { useContext, useEffect } from 'react';
import FacetedBrowseContextProvider from './FacetedBrowse/FacetedBrowseContext';
import FacetedBrowseFilters from './FacetedBrowse/FacetedBrowseFilters';
import FacetedBrowseResults from './FacetedBrowse/FacetedBrowseResults';

const selector = pawtucketUIApps.FacetedBrowse.selector;

const FacetedBrowse = () => {
  // console.log(selector);
  return (
    <div className="row">
      <FacetedBrowseResults />
      <FacetedBrowseFilters />
    </div>
  )
}

/**
 * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
  ReactDOM.render(<FacetedBrowseContextProvider> <FacetedBrowse /> </FacetedBrowseContextProvider>, document.querySelector(selector));
}