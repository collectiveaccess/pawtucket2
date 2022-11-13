import React, { useContext, useState, useEffect } from 'react';
// import { DirectoryBrowseContext } from './DirectoryBrowseContext';

// import BrowseBar from "./BrowseBar";
// import BrowseContentContainer from './BrowseContentContainer';

// import { getBrowseBar, getBrowseContent } from './DirectoryQueries';

const currentBrowse = pawtucketUIApps.DirectoryBrowse.currentBrowse;
const baseUrl = pawtucketUIApps.DirectoryBrowse.baseUrl;

const MainBrowse = () => {

  // const { browseBarData, setBrowseBarData, browseContentData, setBrowseContentData, start, setStart, limit, setLimit, value, setValue } = useContext(DirectoryBrowseContext);

  // const [displayTitle, setDisplayTitle] = useState();

  // useEffect(() => {
  //   getBrowseBar(baseUrl, currentBrowse, function (data) {
  //     // console.log('browseBar data', data);
  //     const values = [];
  //     data.values.map((val) => {
  //       values.push(val);
  //     })
  //     setBrowseBarData(values);
  //     setDisplayTitle(data.displayTitle)
  //   });
  // }, [setBrowseBarData])

  // useEffect(() => {
  //   let tempVal
  //   if (currentBrowse == 'exhibitionsByYear' ){
  //     tempVal = "1950"
  //   }else{
  //     tempVal = "A"
  //   }
  //   getBrowseContent(baseUrl, currentBrowse, tempVal, start, limit, (data) => {
  //     // console.log('browseContent data', data);
  //     const values = [];
  //     data.values.map((val) => {
  //       values.push(val.display);
  //     })
  //     setBrowseContentData(values);
  //   })
  // }, [setBrowseContentData])

  return (
    <div className="main-browse">
      <div className="row mb-2">
        <h2>{displayTitle}</h2>
      </div>
      <BrowseBar />
      <BrowseContentContainer />
    </div>
  )
}

export default MainBrowse;
