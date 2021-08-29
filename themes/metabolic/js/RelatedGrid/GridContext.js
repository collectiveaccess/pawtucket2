import React, { createContext, useState } from 'react';
export const GridContext = createContext();

const GridContextProvider = (props) => {

  const [currentlySelectedItem, setCurrentlySelectedItem] = useState(); // the id of item that is currently selected to be displayed

  const [currentlySelectedRow, setCurrentlySelectedRow] = useState(); //the index of the row that we want to display the panel for

  const [data, setData] = useState([]); //An array of arrays that represent a row containing grid items

  const [lightboxCreated, setLightboxCreated] = useState(false); //boolean if lightbox was created from grid items successfully

  const [itemIds, setItemIds] = useState([]); //array of ids of the currently displayed items in the related grid

  const [itemsPerPage, setItemsPerPage] = useState(18); //number of items to show in related grid

  const [rawData, setRawData] = useState([]); //the data before being chunked into an array of arrays

  const [selectedGridItems, setSelectedGridItems] = useState([]); //array of the currently selected items.

  const [showSelectButtons, setShowSelectButtons] = useState(false); //boolean, show buttons to indicate if an item had been select.

  const [start, setStart] = useState(0); //start variable for loading initial number of grid items

  const [totalItems, setTotalItems] = useState(0); // Total number of items in a related grid
  
  const [sort, setSort] = useState(null); // Sort criteria
  
  const [sortDirection, setSortDirection] = useState('ASC'); // Sort direction

  return (
    <GridContext.Provider
    value={{currentlySelectedItem, setCurrentlySelectedItem, data, setData, rawData, setRawData, start, setStart,
        itemsPerPage, setItemsPerPage, totalItems, setTotalItems, currentlySelectedRow, setCurrentlySelectedRow, itemIds, setItemIds, showSelectButtons, setShowSelectButtons, 
        selectedGridItems, setSelectedGridItems, lightboxCreated, setLightboxCreated, sort, setSort, sortDirection, setSortDirection}}>
        {props.children}
    </GridContext.Provider>
  )
}

export default GridContextProvider;
