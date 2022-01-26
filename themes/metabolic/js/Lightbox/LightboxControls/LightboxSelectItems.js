/**
* Renders select options
*
* Props are: <NONE>
*
* Used by: LightboxControls
*
* Uses context: LightboxContext
*/

import React, { useContext, useEffect, useState } from 'react'
import { LightboxContext } from '../LightboxContext'
import { appendItemstoNewLightbox, removeItemsFromLightbox, transferItemsToLightbox } from "../../../../default/js/lightbox";
import { confirmAlert } from 'react-confirm-alert';
import 'react-confirm-alert/src/react-confirm-alert.css';
// import { filter } from 'lodash';

const appData = pawtucketUIApps.Lightbox.data;
const baseUrl = appData.baseUrl;

const LightboxSelection = () => {

  const [transferItems, setTransferItems] = useState(false)
  // const [transferSubmit, setTransferSubmit] = useState(false)
  const [searchedLightbox, setSearchedLightbox] = useState('')
  const [selectedLightbox, setSelectedLightbox] = useState('')
  const [selectedLightboxId, setSelectedLightboxId] = useState('')
  const [selectedLightboxCount, setSelectedLightboxCount] = useState('')

  const { id, setId, tokens, setTokens, userAccess, setUserAccess, lightboxTitle, setLightboxTitle, totalSize, setTotalSize, lightboxList, setLightboxList, lightboxes, setLightboxes, resultList, setResultList, selectedItems, setSelectedItems, showSelectButtons, setShowSelectButtons, dragDropMode, setDragDropMode } = useContext(LightboxContext)

  const [filteredLightboxes, setFilteredLightboxes] = useState((lightboxes)? [...lightboxes] : [])
  const [numberOfSelectedItems, setNumberOfSelectedItems] = useState(0)

  // console.log("transferItems: ", transferItems);
  // console.log("transferSubmit: ", transferSubmit);
  // console.log("searchedLightbox: ", searchedLightbox);
  // console.log("selectedLightbox: ", selectedLightbox);
  // console.log("selectedLightboxId: ", selectedLightboxId);
  // console.log("selectedLightboxCount: ", selectedLightboxCount);

  // console.log("selectedItems: ", selectedItems);

  // console.log("numberOfSelectedItems: ", numberOfSelectedItems);

  // console.log("filteredLightboxes: ", filteredLightboxes);

  // console.log("resultList: ", resultList);
  // console.log("lightboxes", lightboxes);

  useEffect(() => {
    if (searchedLightbox && searchedLightbox.length > 0) {
      setFilteredLightboxes(lightboxes.filter(lightbox => (lightbox.props.data.title).toLowerCase().includes(searchedLightbox.toLowerCase())))
    } else {
      setFilteredLightboxes([...lightboxes])
    }
  }, [searchedLightbox])

  useEffect(() => {
    if (selectedItems && selectedItems.length) {
      setNumberOfSelectedItems(selectedItems.length)
    }
    if (selectedItems && selectedItems.length == 0) {
      setNumberOfSelectedItems(0)
    }
  }, [selectedItems])

  //removes items from selection
  const clearSelectLightboxItems = () => {
    setShowSelectButtons(false)
    setSelectedItems([])
    setTransferItems(false)
  }

  const showSelect = () => {
    setShowSelectButtons(true)
  }

  //Clears the input searchbox for lightboxes being searched for.
  const clearInput = () => {
    // document.getElementById('lightbox-input').value = ' '
    setSearchedLightbox('')
  }

  const addSelectedItemsToNewLightbox = () => {
    toggleDropdown()
    appendItemstoNewLightbox(baseUrl, tokens, name, selectedItems.join(';'), (data) => {
      console.log("appendItemstoNewLightbox: ", data);
      let tempLightboxList = { ...lightboxList };
      // TODO: after count of items is displayed, it shows undefined, need it to show objects
      tempLightboxList[data.id] = { id: data.id, count: data.count };
      setLightboxList(tempLightboxList)
    });
    setSelectedItems([])
    setShowSelectButtons(false)
  }

  const addSelectedItemsToExistingLightbox = () => {
    toggleDropdown()

    transferItemsToLightbox(baseUrl, tokens, id, selectedLightboxId, selectedItems.join(';'), (data) => {
      // console.log("transferItemsToLightbox: ", data);
      let newResultList = [];
      for (let i in resultList) {  //i is the index position of item in resultList
        let r = resultList[i].id; //r is the id of item in resultList
        if (!selectedItems.includes(r)) {
          newResultList.push(resultList[i]);
        }
      }
      setResultList(newResultList)
      setTotalSize(newResultList.length)

      let tempLightboxList = { ...lightboxList };
      // TODO: after count of items is displayed, it shows undefined, need it to show objects
      let newItemCount = (selectedItems.length) + (selectedLightboxCount);
      tempLightboxList[selectedLightboxId] = { id: selectedLightboxId, title: selectedLightbox, count: newItemCount };
      tempLightboxList[id] = { id: id, title: lightboxTitle, count: totalSize }
      setLightboxList(tempLightboxList)
    });

    setTransferItems(false)
    setSelectedItems([])
    setShowSelectButtons(false)
    // setId(id)
  }

  const deleteLightboxItemsConfirm = () => {
    confirmAlert({
      customUI: ({ onClose }) => {
        return (
          <div className='col info text-gray'>
            <p>Do you want to delete these items?</p>
            <div className='button' onClick={() => { deleteSelectedItems(); onClose(); }}>Yes</div>
            &nbsp;
            <div className='button' onClick={onClose}>No</div>
          </div>
        );
      }
    });
  }

  const deleteSelectedItems = () => {
    toggleDropdown()

    removeItemsFromLightbox(baseUrl, tokens, id, selectedItems.join(';'), (data) => {
      // console.log("removeItemFromLightbox: ", data);
      let tempLightboxList = { ...lightboxList }
      tempLightboxList[data.id] = { id: data.id, title: lightboxTitle, count: data.count };
      setLightboxList(tempLightboxList)

      let newResultList = [];
      for (let i in resultList) {  //i is the index position of item in resultList
        let r = resultList[i].id; //r is the id of item in resultList
        if (!selectedItems.includes(r)) {
          newResultList.push(resultList[i]);
        }
      }
      setResultList(newResultList);
      setTotalSize(newResultList.length);
    });
    setSelectedItems([])
    setShowSelectButtons(false)
  }

  const toggleDropdown = () => {
    $('.menu-option').click(function () {
      $(this).parents('.btn-group').find('button.dropdown-toggle').dropdown('toggle')
    });
  }

  // on change handler for lightboxes being searched.
  const handleChange = (event) => {
    const { value } = event.target;
    setSearchedLightbox(value)
  }

  const setLightboxData = (title, id, count) => {
    setSearchedLightbox(title)
    setSelectedLightbox(title)
    setSelectedLightboxId(id)
    setSelectedLightboxCount(count)
  }

  const transferOption = () => {
    console.log("func transferOption");
    if (transferItems == true) {
      setTransferItems(false)
    } else {
      setTransferItems(true)
    }
  }

  $(document).on('click', '#lb-option', (e) => {
    do {
      e.stopPropagation();
    } while (transferItems == true);
  });

  return (
    <div id="selectItems">

      <div className="btn-group">

        {showSelectButtons ?
          <button className="btn btn-outline-danger btn-sm" onClick={clearSelectLightboxItems} style={{ marginLeft: '6px' }}>Cancel Select</button>
        :
          (resultList && resultList.length > 0) && dragDropMode == false?
            <button className={`btn btn-secondary btn-sm ${(dragDropMode) ? "disabled" : ''}`} onClick={showSelect} style={{ marginLeft: '6px' }}> Select Items </button>
          : null
        }

        {(numberOfSelectedItems > 0) ?
          <button className="btn btn-outline-success dropdown-toggle dropdown-toggle-split btn-sm" id="optionsButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span className="sr-only">Toggle Dropdown</span>
          </button>
        : null}

        <ul className="dropdown-menu">

          <li className='menu-option'>
            <a className="dropdown-item" onClick={addSelectedItemsToNewLightbox}>Create Lightbox From Selected Items</a>
          </li>

          {(userAccess == 2) ?
            <>
              <div className="dropdown-divider"></div>

              <li className='menu-option'>
                <a className="dropdown-item" onClick={deleteLightboxItemsConfirm}>Delete Selected Items</a>
              </li>
              <div className="dropdown-divider"></div>

              <li className="dropdown-submenu ml-4">
                <a className='transfer-option' onClick={() => transferOption()}>
                  Transfer to Lightbox <span className="material-icons">expand_more</span>
                </a>

                <ul className="transfer-dropdown p-0">
                  <form className='form-inline' style={{ margin: '10px 10px 10px 0px' }}>
                    <input
                      id='lightbox-input'
                      type="text"
                      value={searchedLightbox}
                      onChange={handleChange}
                      name="searchedLightbox"
                      placeholder="Search Lightboxes"
                    ></input>
                    <button className="btn p-0" onClick={addSelectedItemsToExistingLightbox}>
                      <span className="material-icons">arrow_forward</span>
                    </button>
                  </form>

                  {filteredLightboxes ?
                    <div id={'lb-option'} className='lightbox-container w-100' style={{ overflow: 'auto', height: '200px' }}>
                      {filteredLightboxes.map((lightbox, index) => {
                        return (
                          <li className="mb-1" key={index} onClick={() => setLightboxData(lightbox.props.data.title, lightbox.props.data.id, lightbox.props.data.count)}>
                            <a style={{ cursor: 'pointer', backgroundColor: "#F0F0F0" }}>
                              {lightbox.props.data.title}
                            </a>
                          </li>
                        )
                      })}
                    </div>
                  : null}
                </ul>
              </li >
            </>
          : null}

        </ul> {/* dropdown-menu end */}

      </div> {/* btn-group end */}

    </div>
  );
}

export default LightboxSelection