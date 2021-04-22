import React, { createContext, useState } from 'react';
export const FacetedBrowseContext = createContext();

const FacetedBrowseContextProvider = (props) => {

  const [ browseType, setBrowseType ] = useState('exhibitions'); //default browsetype
  const [ facets, setFacets ] = useState();
  const [ filters, setFilters ] = useState();
  const [ key, setKey ] = useState();
  const [ resultItems, setResultItems ] = useState();
  const [ resultItemsPerPage, setResultItemsPerPage ] = useState(20);
  const [ totalResultItems, setTotalResultItems ] = useState();

  return (
    <FacetedBrowseContext.Provider
      value={{
        browseType, setBrowseType,
        facets, setFacets,
        filters, setFilters,
        key, setKey,
        resultItems, setResultItems,
        resultItemsPerPage, setResultItemsPerPage,
        totalResultItems, setTotalResultItems,
      }}>
      {props.children}
    </FacetedBrowseContext.Provider>
  )
}

export default FacetedBrowseContextProvider;