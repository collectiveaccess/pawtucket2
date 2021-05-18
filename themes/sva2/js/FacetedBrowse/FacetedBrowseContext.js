import React, { createContext, useState } from 'react';
export const FacetedBrowseContext = createContext();

const FacetedBrowseContextProvider = (props) => {


  const [ availableSorts, setAvailableSorts ] = useState();
  const [ browseType, setBrowseType ] = useState('exhibitions'); //default browsetype
  const [ contentTypeDisplay, setContentTypeDisplay ] = useState();
  const [ facets, setFacets ] = useState();
  const [ filters, setFilters ] = useState();
  const [ key, setKey ] = useState();
  const [ resultItems, setResultItems ] = useState();
  const [ resultItemsPerPage, setResultItemsPerPage ] = useState(16);
  const [ sort, setSort ] = useState('');
  const [ totalResultItems, setTotalResultItems ] = useState();


  return (
    <FacetedBrowseContext.Provider
      value={{
        availableSorts, setAvailableSorts,
        browseType, setBrowseType,
        contentTypeDisplay, setContentTypeDisplay,
        facets, setFacets,
        filters, setFilters,
        key, setKey,
        resultItems, setResultItems,
        resultItemsPerPage, setResultItemsPerPage,
        sort, setSort,
        totalResultItems, setTotalResultItems,
      }}>
      {props.children}
    </FacetedBrowseContext.Provider>
  )
}

export default FacetedBrowseContextProvider;