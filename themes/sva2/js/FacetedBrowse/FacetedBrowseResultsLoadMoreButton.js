import React, { useContext } from 'react';
import { FacetedBrowseContext } from './FacetedBrowseContext';
import { getResult } from './FacetedQueries';

const serviceUrl = pawtucketUIApps.FacetedBrowse.data.serviceUrl;

const FacetedBrowseResultsLoadMoreButton = () => {
  const { resultItemsPerPage, setResultItemsPerPage, totalResultItems, browseType, key, sort, setTotalResultItems, setFilters, setKey, setResultItems } = useContext(FacetedBrowseContext)

  const loadMoreResultItems = (e) => {
    let newLimit = resultItemsPerPage + 30;
    setResultItemsPerPage(newLimit);

    getResult(serviceUrl, browseType, key, 0, newLimit, sort, function (data) {
      console.log("getResult: ", data);
      setResultItems(data.items);
      setTotalResultItems(data.item_count);
      setFilters(data.filters)
      setKey(data.key);
    });

    e.preventDefault();
  }

  if ((resultItemsPerPage < totalResultItems)) {
    return (
      <div className="row m-0 justify-content-center">
        <button type="button" className="btn btn-outline-secondary fb-results-load-more-button" onClick={(e) => loadMoreResultItems(e)}>Load More</button>
      </div>
    );
  } else {
    return null;
  }
}

export default FacetedBrowseResultsLoadMoreButton;
