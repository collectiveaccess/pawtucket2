import React, { useContext, useEffect } from 'react'
// import { DirectoryBrowseContext } from '../DirectoryBrowseContext';
// import { getBrowseBar, getBrowseContent } from '../DirectoryQueries';

const currentBrowse = pawtucketUIApps.DirectoryBrowse.currentBrowse;
const baseUrl = pawtucketUIApps.DirectoryBrowse.baseUrl;

const BrowseLoadMoreButton = () => {
  // const { browseBarData, setBrowseBarData, browseBarValue, setBrowseBarValue, browseContentData, setBrowseContentData, start, setStart, limit, setLimit, displayTitle, setDisplayTitle, totalSize, setTotalSize } = useContext(DirectoryBrowseContext);

  // const loadMoreResultItems = () => {
  //   let newLimit = limit + 20;
  //   setLimit(newLimit);

  //   getBrowseContent(baseUrl, currentBrowse, browseBarValue, start, newLimit, function (data) {
  //     console.log('browseContent data', data);
  //     const values = [];
  //     data.values.map((val) => {
  //       values.push(val.display);
  //     })
  //     setBrowseContentData(values);
  //     setTotalSize(data.total_size)
  //   })

  // }

  // console.log("limit", limit);
  // console.log("totalSize", totalSize);

  // if (limit < totalSize) {
  //   return (
  //     <div className="row m-2 justify-content-center">
  //       <button className="btn btn-secondary" onClick={(e) => loadMoreResultItems(e)}>Load More</button>
  //     </div>
  //   );
  // } else {
  //   return null;
  // }

}

export default BrowseLoadMoreButton
