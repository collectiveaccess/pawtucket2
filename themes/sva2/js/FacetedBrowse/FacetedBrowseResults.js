import React, { useContext, useState, useEffect } from 'react';
import { FacetedBrowseContext } from './FacetedBrowseContext';
import FacetedBrowseControls from './FacetedBrowseControls';
import FacetedBrowseResultsLoadMoreButton from './FacetedBrowseResultsLoadMoreButton';
import { addFilterValue, getResult } from './FacetedQueries';

const serviceUrl = pawtucketUIApps.FacetedBrowse.data.serviceUrl;
const search_value = pawtucketUIApps.FacetedBrowse.data.search;

const FacetedBrowseResults = () => {

  const { browseType, setFilters, resultItems, setResultItems, resultItemsPerPage, setTotalResultItems, key, setKey, sort, contentTypeDisplay, setContentTypeDisplay, availableSorts, setAvailableSorts} = useContext(FacetedBrowseContext)
  
  useEffect(() => {
    addFilterValue(serviceUrl, browseType, '', "_search", search_value, function (data) {
      console.log("addFilterValue: ", data);
      setResultItems(data.items);
      setTotalResultItems(data.item_count);
      setFilters(data.filters)
      setKey(data.key);
    })
  }, [])

  useEffect(() => {
    if(key){
      getResult(serviceUrl, browseType, key, 0, resultItemsPerPage, sort ,function (data) {
        console.log("getResult: ", data);
        setResultItems(data.items);
        setTotalResultItems(data.item_count);
        setFilters(data.filters)
        setAvailableSorts(data.available_sorts)
        setContentTypeDisplay(data.content_type_display)
        setKey(data.key);
      });
    }
  }, [key])

  if (resultItems) {
    return (
      <div className="col-8 pl-0 faceted-browse-results">
        <FacetedBrowseControls />
        <div className="row row-cols-2 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 fb-results-row">
          {resultItems.map((item, index) => {
            // console.log("Browse Item: ", item.media);
            return (
              <div className="col card fb-result-card" key={index}> 
                {(item.media) ? <a href={item.detailUrl}><img className="fb-result-img" src={item.media[0].url} alt={item.title} /></a> : <a href={item.detailUrl}><img src="http://placehold.jp/24/cccccc/ffffff/150x150.png?text=No Image Available" /></a>}
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
