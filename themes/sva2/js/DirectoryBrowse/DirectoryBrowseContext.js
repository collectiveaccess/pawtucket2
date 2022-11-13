import React, { createContext, useState } from 'react';
export const DirectoryBrowseContext = createContext();

const DirectoryBrowseContextProvider = (props) => {

  const [ browseBarData, setBrowseBarData ] = useState(null); //data being loaded in the browseBar
  const [ browseBarValue, setBrowseBarValue ] = useState(null);
  const [ browseContentData, setBrowseContentData ] = useState(null); //data being loaded in the browseContent
  const [ start, setStart ] = useState(0); //start
  const [ limit, setLimit ] = useState(20); //limit
  const [ displayTitle, setDisplayTitle ] = useState(null);
  const [ totalSize, setTotalSize ] = useState(null) //total amount of items for a browseBar value

  return (
    <DirectoryBrowseContext.Provider
      value={{
        browseBarData, setBrowseBarData,
        browseBarValue, setBrowseBarValue,
        browseContentData, setBrowseContentData,
        start, setStart,
        limit, setLimit,
        displayTitle, setDisplayTitle,
        totalSize, setTotalSize
      }}>
      {props.children}
    </DirectoryBrowseContext.Provider>
  )

}

export default DirectoryBrowseContextProvider;