import React, { createContext, useState } from 'react';
export const DirectoryBrowseContext = createContext();

const DirectoryBrowseContextProvider = (props) => {

  const [ browseBarData, setBrowseBarData ] = useState(); //data being loaded in the browseBar
  const [ browseBarValue, setBrowseBarValue ] = useState();
  const [ browseContentData, setBrowseContentData ] = useState(); //data being loaded in the browseContent

  return (
    <DirectoryBrowseContext.Provider
      value={{
        browseBarData, setBrowseBarData,
        browseBarValue, setBrowseBarValue,
        browseContentData, setBrowseContentData,
      }}>
      {props.children}
    </DirectoryBrowseContext.Provider>
  )

}

export default DirectoryBrowseContextProvider;