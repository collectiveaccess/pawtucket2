import React, { useContext, useState, useEffect } from 'react';
import { DirectoryBrowseContext } from './DirectoryBrowseContext';
import BrowseBar from "./BrowseBar";
import BrowseContentContainer from './BrowseContentContainer';

import { getBrowseBar, getBrowseContent } from './DirectoryQueries';

const currentBrowse = pawtucketUIApps.DirectoryBrowse.currentBrowse;
const baseUrl = pawtucketUIApps.DirectoryBrowse.baseUrl;

// import exhibitions from './exhibitiondata';
// import { alphabetical } from "./browsebardata";

const ExhibitionsBrowse = () => {

  const { browseBarData, setBrowseBarData, browseContentData, setBrowseContentData } = useContext(DirectoryBrowseContext);
  const [displayTitle, setDisplayTitle] = useState();

  useEffect(() => {
    getBrowseBar(baseUrl, currentBrowse, function (data) {
      console.log('browseBar data', data);
      const values = [];
      data.values.map((val) => {
        values.push(val);
      })
      setBrowseBarData(values);
      setDisplayTitle(data.displayTitle)

    });

    getBrowseContent(baseUrl, currentBrowse, "A", function (data) {
      console.log('browseContent data', data);
      const values = [];
      data.values.map((val) => {
        values.push(val.display);
      })
      setBrowseContentData(values);
    })
  }, [setBrowseBarData])

  // console.log(currentBrowse);

  return (
    <div className="exhibitions-browse">
      <div className="row mb-2">
        <h2>Browse All {displayTitle}</h2>
      </div>
      <BrowseBar data={browseBarData} />
      <BrowseContentContainer data={browseContentData} />
    </div>
  )
}

export default ExhibitionsBrowse;
