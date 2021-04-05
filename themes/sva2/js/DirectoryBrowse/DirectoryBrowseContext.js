import React, { createContext, useState } from 'react';
export const DirectoryBrowseContext = createContext();

const DirectoryBrowseContextProvider = (props) => {

  const [ currentBrowse, setCurrentBrowse ] = useState('people'); //the current type of Directory Browse, browse pages are people, exhibitions, dates

  const [ browseBarData, setBrowseBarData ] = useState(); //data being loaded in the browseBar
  const [ browseBarValue, setBrowseBarValue ] = useState();
  const [ browseContentData, setBrowseContentData ] = useState(); //data being loaded in the browseContent

  return (
    <DirectoryBrowseContext.Provider
      value={{
        currentBrowse, setCurrentBrowse,
        browseBarData, setBrowseBarData,
        browseBarValue, setBrowseBarValue,
        browseContentData, setBrowseContentData,
      }}>
      {props.children}
    </DirectoryBrowseContext.Provider>
  )

}

export default DirectoryBrowseContextProvider;