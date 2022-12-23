import React, { useState, useContext, useEffect, useRef } from 'react'
import { DirectoryBrowseContext } from './DirectoryBrowseContext';
import { getBrowseContent } from './DirectoryQueries';

const currentBrowse = pawtucketUIApps.DirectoryBrowse.currentBrowse;
const baseUrl = pawtucketUIApps.DirectoryBrowse.baseUrl;

const BrowseContentContainer = () => {
  const { browseBarValue, setBrowseBarValue, browseContentData, setBrowseContentData, start, setStart, limit, setLimit, totalSize, setTotalSize } = useContext(DirectoryBrowseContext);
  
  const [isLoaded, setIsLoaded] = useState(false)
  const [lastListValue, setLastListValue] = useState()

  const loadRef = useRef(null);
  
  useEffect(() => {
    if(loadRef.current){
      loadRef.current.focus();
    }
  }, [loadRef.current]);

  useEffect(() => {
      getBrowseContent(baseUrl, currentBrowse, browseBarValue, start, limit, (data) => {
        console.log('browseContent data', data);

        const values = [];

        data.values.map((val, index) => {
          values.push([val.value, val.display]);
        })
        
        setBrowseContentData(values);
        setTotalSize(data.total_size);

        // if(browseBarValue != null){
        //   setLastListValue(String(values[values.length - 1][0]))
        // }

      })
  }, [browseBarValue, limit])
  
  const loadMoreResultItems = () => {

    setLastListValue(String(browseContentData[browseContentData.length - 1][0]))

    let newLimit = limit + 50;
    setLimit(newLimit);

    setIsLoaded(true)
    setTimeout(() => {
      $('.alert').alert('close');
      setIsLoaded(false)
    }, 2000);
  }

  console.log("loadref: ", loadRef.current);
  console.log("lastListValue: ", lastListValue);

  return (
    <>
      <div className="row browse-content-container">
        <div className="column-container" 
          ref={currentBrowse == "exhibitionsByYear" && browseBarValue != null ? loadRef : null} 
          tabIndex={currentBrowse == "exhibitionsByYear" && browseBarValue != null ? "1" : "-1"}
        >
          {browseContentData? browseContentData.map((item, index) => {
            return(
              <div 
                ref={lastListValue == item[0] ? loadRef : null}
                id={item[0]}
                tabIndex={browseBarValue != null ? "1" : "0"} className="browse-item" 
                aria-labelledby={`browse item by year ${browseBarValue}`} 
                key={index} 
                dangerouslySetInnerHTML={{__html: item[1] }}>
              </div>
          )}) : null}
        </div>
      </div>
      {isLoaded?
        <div className="alert alert-success alert-dismissible fade show w-50 m-auto text-center" role="alert">
          <strong>More Items loaded</strong>
        </div> 
      : null}
      {(limit < totalSize)?
        // tabIndex = {`${browseContentData.length + 1}` }
        <div className="row m-2 justify-content-center">
          <a href='#' role='button' id='load' className="btn btn-secondary" tabIndex="2" onClick={loadMoreResultItems} aria-label={`Load More button - 10 additional section ${browseBarValue} results`}>Load More</a>
        </div>
      : null} 
    </>
  )
  
}

export default BrowseContentContainer
