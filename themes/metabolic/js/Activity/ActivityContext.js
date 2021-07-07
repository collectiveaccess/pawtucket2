import React, { createContext, useState } from 'react';
export const ActivityContext = createContext();

const ActivityContextProvider = (props) => {

  const [ currProject, setCurrProject ] = useState(); 
  const [ activityItems, setActivityItems ] = useState(); 
  const [ modalUrl, setModalUrl ] = useState();
  const [ modalClass, setModalClass ] = useState();
  const [ modalTitle, setModalTitle ] = useState();
  const [ detailUrl, setDetailUrl ] = useState();
  const [ activityListItems, setActivityListItems ] = useState();
  const [ facetValue, setFacetValue ] = useState();

  return (
    <ActivityContext.Provider
      value={{
        currProject, setCurrProject,
        activityItems, setActivityItems,
        modalUrl, setModalUrl,
        modalClass, setModalClass,
        modalTitle, setModalTitle,
        detailUrl, setDetailUrl,
        activityListItems, setActivityListItems,
        facetValue, setFacetValue,
      }}
    >
      {props.children}
    </ActivityContext.Provider>
  )
}

export default ActivityContextProvider;