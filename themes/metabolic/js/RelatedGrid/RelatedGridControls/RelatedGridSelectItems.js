import React, { useContext } from 'react';
import { GridContext } from '../GridContext';

const RelatedGridSelectItems = (props) => {

  const { showSelectButtons, setShowSelectButtons, selectedGridItems, setSelectedGridItems, setCurrentlySelectedRow, setCurrentlySelectedItem } = useContext(GridContext);

  //removes items from selection
	const clearSelectedItems = (e) => {
    setShowSelectButtons(false);
    setSelectedGridItems([]);
    setCurrentlySelectedRow();
    setCurrentlySelectedItem();
    e.preventDefault();
	}

	const displaySelectButtons = (e) => {
    setShowSelectButtons(true);
    e.preventDefault();
  }

  return (
    <div id="bSelectOptions">
			<div className="dropdown show">
				<a href="#" role="button" id="selectItemsIcon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<ion-icon name="checkmark-circle-outline" color={(showSelectButtons) ? 'danger' : ''}></ion-icon>
				</a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="selectItemsIcon">
          {showSelectButtons ?
            <a class="dropdown-item" onClick={(e)=>clearSelectedItems(e)}>{(selectedGridItems.length >= 1) ? "Clear selection" : 'Cancel selection'}</a>
            :
            <a class="dropdown-item" onClick={(e)=>displaySelectButtons(e)}>Select items</a>
          }
        </div>
			</div>
		</div>
  )
}

export default RelatedGridSelectItems;
