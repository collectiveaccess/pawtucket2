/**
 * Allows Drag and Drop Capability for lightbox items
 *
 * Props are:
 * 		<NONE>
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Uses context: LightboxContext
 */
import React, { useContext, useState } from 'react'
import { LightboxContext } from '../LightboxContext'
import { reorderLightboxItems } from "../../../../default/js/lightbox";

const baseUrl = pawtucketUIApps.Lightbox.data.baseUrl;

const LightboxDragAndDrop = () => {

  const [currentlyDragging, setCurrentlyDragging] = useState(false)

  const { id, setId, tokens, setTokens, userAccess, setUserAccess, totalSize, setTotalSize, showSelectButtons, setShowSelectButtons, dragDropMode, setDragDropMode, lightboxList, setLightboxList, orderedIds, setOrderedIds } = useContext(LightboxContext)

  const changeDragDrop = () => {
    setDragDropMode(true);
    setCurrentlyDragging(true)
  }

  const saveDragDrop = () => {
    reorderLightboxItems(baseUrl, tokens, id, orderedIds.join('&'), lightboxList[id].title, (data) => {
      // console.log('reorderLightboxItems: ', data);
    });

    setDragDropMode(false);
    setCurrentlyDragging(false)
    setShowSelectButtons(false)
  }

  if (userAccess == 2 && totalSize > 1) {
    return (
      <div id='dragAndDrop'>
        {currentlyDragging == false ? 
          <button
            className={`btn btn-secondary btn-sm ${(showSelectButtons) ? 'disabled' : ''}`}
            onClick={changeDragDrop} style={{ marginLeft: '6px' }}
          >
            Drag Sort 
          </button>
        : ' '}

        {dragDropMode == true ?
          <button className='btn btn-outline-success btn-sm' onClick={saveDragDrop} style={{ marginLeft: '6px' }}>Save Sort</button>
        : ' ' }
      </div>
    )
  } else {
    return null;
  }
}

export default LightboxDragAndDrop