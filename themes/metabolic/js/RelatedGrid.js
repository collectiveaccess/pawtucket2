import React from 'react';
import GridContextProvider from './RelatedGrid/GridContext';
import RelatedGridList from './RelatedGrid/RelatedGridList';
import '../css/main.scss';

const selector = pawtucketUIApps.RelatedGrid.selector;
const appData = pawtucketUIApps.RelatedGrid.data;

const RelatedGrid = (props) => {
  return(
    <div>
      <RelatedGridList {...props}/>
    </div>
  );
}

/**
 * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
	ReactDOM.render(
    <GridContextProvider>
  		<RelatedGrid
        baseUrl={pawtucketUIApps.RelatedGrid.baseUrl}
        id={pawtucketUIApps.RelatedGrid.id}
        table={pawtucketUIApps.RelatedGrid.table}
        gridTable={pawtucketUIApps.RelatedGrid.gridTable}
        fetch={pawtucketUIApps.RelatedGrid.fetch}
      />
    </GridContextProvider> , document.querySelector(selector));
}
