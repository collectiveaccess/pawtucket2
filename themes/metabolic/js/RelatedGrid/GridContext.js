import React, { createContext, useState } from 'react';
export const GridContext = createContext();

const GridContextProvider = (props) => {

  const [currentlySelectedItem, setCurrentlySelectedItem] = useState(0); // the id of item that is currently selected to be displayed

  const [currentlySelectedRow, setCurrentlySelectedRow] = useState(0); //the index of the row that we want to display the panel for

  // const [currentlySelectedItemIndex, setCurrentlySelectedItemIndex] = useState(); // the index of the item that is currently selected to be displayed
  // const [currentlySelectedItemRowIndex, setCurrentlySelectedItemRowIndex] = useState(); // the item that is currently selected to be displayed

  const [data, setData] = useState([]); //An array of arrays that represent a row containing grid items

  const [itemIds, setItemIds] = useState([]); //array of ids of the currently displayed items in the related grid

  const [itemsPerPage, setItemsPerPage] = useState(18); //number of items to show in related grid

  const [rawData, setRawData] = useState([]); //the data before being chunked into an array of arrays

  const [start, setStart] = useState(0); //start variable for loading initial number of grid items

  const [totalItems, setTotalItems] = useState(0); // Total number of items in a related grid

  return (
    <GridContext.Provider
    value={{currentlySelectedItem, setCurrentlySelectedItem, data, setData, rawData, setRawData, start, setStart,
        itemsPerPage, setItemsPerPage, totalItems, setTotalItems, currentlySelectedRow, setCurrentlySelectedRow, itemIds, setItemIds}}>
        {props.children}
    </GridContext.Provider>
  )
}

export default GridContextProvider;
