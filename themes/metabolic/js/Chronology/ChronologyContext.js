import React, { createContext, useState } from 'react';
export const ChronologyContext = createContext();

const ChronologyContextProvider = (props) => {

  const [browseType, setBrowseType] = useState('chronology'); //default browsetype
  const [facets, setFacets] = useState();
  const [filters, setFilters] = useState();
  const [key, setKey] = useState();
  const [resultItems, setResultItems] = useState();
  const [resultItemsPerPage, setResultItemsPerPage] = useState(20);
  const [totalResultItems, setTotalResultItems] = useState();
  const [years, setYears] = useState();
  const [currYear, setCurrYear] = useState();
  const [currentAction, setCurrentAction] = useState();
  const [currentActionTitle, setCurrentActionTitle] = useState();
  const [currentActionItem, setCurrentActionItem] = useState();

  return (
    <ChronologyContext.Provider
      value={{
        browseType, setBrowseType,
        facets, setFacets,
        filters, setFilters,
        key, setKey,
        resultItems, setResultItems,
        resultItemsPerPage, setResultItemsPerPage,
        totalResultItems, setTotalResultItems,
        years, setYears,
        currYear, setCurrYear,
        currentAction, setCurrentAction,
        currentActionTitle, setCurrentActionTitle,
        currentActionItem, setCurrentActionItem,
      }}>
      {props.children}
    </ChronologyContext.Provider>
  )
}

export default ChronologyContextProvider;