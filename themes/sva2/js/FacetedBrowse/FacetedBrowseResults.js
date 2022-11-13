import React, { useContext, useState, useEffect } from 'react';
import { FacetedBrowseContext } from './FacetedBrowseContext';
import FacetedBrowseControls from './FacetedBrowseControls';
import { addFilterValue, getResult } from './FacetedQueries';

const serviceUrl = pawtucketUIApps.FacetedBrowse.data.serviceUrl;

const FacetedBrowseResults = () => {

  const { browseType, setFilters, resultItems, setResultItems, resultItemsPerPage, setResultItemsPerPage, totalResultItems, setTotalResultItems, key, setKey, sort, contentTypeDisplay, setContentTypeDisplay, availableSorts, setAvailableSorts} = useContext(FacetedBrowseContext)

  useEffect(() => {
    if(key){
      getResult(serviceUrl, browseType, key, 0, resultItemsPerPage, sort , (data) => {
        // console.log("getResult: ", data);
        setResultItems(data.items);
        setTotalResultItems(data.item_count);
        setFilters(data.filters)
        setKey(data.key);
        setAvailableSorts(data.available_sorts)
        setContentTypeDisplay(data.content_type_display)
      });
    }
  }, [key, resultItemsPerPage])

  const loadMoreResultItems = () => {
    let newLimit = resultItemsPerPage + 30;
    setResultItemsPerPage(newLimit);
  }

  if (resultItems) {
    return (
      <div className="col-8 pl-0 faceted-browse-results">
        <FacetedBrowseControls />
        <div className="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 fb-results-row">
          {resultItems.map((item, index) => {
            console.log("Browse Item: ", item);
            return (
              <div className="col card fb-result-card" key={index}> 
                {(item.media) ? 
                  <a href={item.detailUrl} role="link" aria-label={`link to ${(item.title) ? item.title : item.value}`}>
                    <img className="fb-result-img" src={item.media[2].url} alt={item.title} />
                  </a> 
                  : 

                  <a href={item.detailUrl} role="link" aria-label={`link to ${(item.title) ? item.title : item.value}`}>
                    <div style={{ width: '100%', height: '200px', margin: 'auto', backgroundColor: '#c8c8c8', textAlign: 'center' }}>
                      <p className='no-image' style={{ paddingTop: '85px', textDecoration: 'none' }}>
                        No Image Available
                      </p>
                    </div>
                  </a> 
                }
                {/* <a href={item.detailUrl}>{(item.title) ? item.title : item.value}</a> */}
                <a>{(item.title) ? item.title : item.value}</a>
              </div>
            )
          })}
        </div>

        {resultItemsPerPage < totalResultItems?
          <div className="row m-0 justify-content-center">
            <button type="button" className="btn btn-outline-secondary fb-results-load-more-button" onClick={loadMoreResultItems}>Load More</button>
          </div>
        : null}
      </div>
    )
  } else {
    return null;
  }
}

export default FacetedBrowseResults
