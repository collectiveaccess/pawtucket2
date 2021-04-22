import React, { useContext, useState, useEffect } from 'react';
import { FacetedBrowseContext } from './FacetedBrowseContext';
import FacetedBrowseControls from './FacetedBrowseControls';
import FacetedBrowseResultsLoadMoreButton from './FacetedBrowseResultsLoadMoreButton';
import { getResult } from './FacetedQueries';

const serviceUrl = pawtucketUIApps.FacetedBrowse.data.serviceUrl;

const FacetedBrowseResults = () => {

  const { browseType, setFilters, resultItems, setResultItems, resultItemsPerPage, totalResultItems, setTotalResultItems, key, setKey } = useContext(FacetedBrowseContext)

  useEffect(() => {
    getResult(serviceUrl, browseType, key, 0, resultItemsPerPage, function (data) {
      console.log("getResult: ", data);
      setResultItems(data.items);
      setTotalResultItems(data.item_count);
      setFilters(data.filters)
      setKey(data.key);
    });
  }, [key, setKey, resultItemsPerPage])


  if (resultItems) {
    return (
      <div className="col-8 pl-0 faceted-browse-results">
        <div className="row total-items-row"> <h2 className="total-items">{totalResultItems} Items</h2> </div>
        <FacetedBrowseControls />
        <div className="row row-cols-2 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 fb-results-row">
          {resultItems.map((item, index) => {
            // console.log("Browse Item: ", item.media);
            return (
              <div className="col card fb-result-card" key={index}> 
                {(item.media) ? <img className="fb-result-img" src={item.media[0].url} alt={item.title}></img> : null}
                <div className="card-text fb-result-title"> <a href={item.detailUrl}>{(item.title) ? item.title : item.value}</a> </div>
              </div>
            )
          })}
        </div>
        <FacetedBrowseResultsLoadMoreButton />
      </div>
    )
  } else {
    return null;
  }
}

export default FacetedBrowseResults
