/**
 * Display of current browse filters. Each filter includes a delete-filter button.
 *
 * Props are:
 * 		<NONE>
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 * 		LightboxResults
 *
 * Uses context: LightboxContext
 */


import React, { useState, useContext, useEffect } from 'react'
import { LightboxContext } from '../LightboxContext';
import { initBrowseCurrentFilterList } from "../../../../default/js/browse";

const LightboxCurrentFilterList = () => {

	const { id, setId, tokens, setTokens, userAccess, setUserAccess, lightboxTitle, setLightboxTitle, totalSize, setTotalSize, sortOptions, setSortOptions, comments, setComments, itemsPerPage, setItemsPerPage, lightboxList, setLightboxList, key, setKey, view, setView, lightboxListPageNum, setLightboxListPageNum, lightboxSearchValue, setLightboxSearchValue, lightboxes, setLightboxes, resultList, setResultList, selectedItems, setSelectedItems, showSelectButtons, setShowSelectButtons, showSortSaveButton, setShowSortSaveButton, start, setStart, dragDropMode, setDragDropMode, isLoading, setIsLoading, filters, setFilters } = useContext(LightboxContext)

	let filterList = [];
	useEffect(() => {
		if (filters) {
			for (let f in filters) {
				let cv = filters[f];
				for (let c in cv) {
					let label = cv[c];
					let m = label.match(/^ca_sets\.set_id:([\d]+)$/);
					if (!m) {
						filterList.push((<a key={f + '_' + c} href='#'
							data-facet={f}
							data-value={c}><button type='button' className='btn btn-primary btn-sm' data-facet={f} data-value={c}>{label} <ion-icon name='close-circle' data-facet={f} data-value={c}></ion-icon></button></a>));
					}
				}
			}
		}
	}, [])

	return (
		<div>{filterList}</div>
	);
}

export default LightboxCurrentFilterList



// import React from "react";
// import ReactDOM from "react-dom";
// import { LightboxContext } from '../../Lightbox';

// import { initBrowseCurrentFilterList } from "../../../../default/js/browse";

// class LightboxCurrentFilterList extends React.Component {
// 	constructor(props) {
// 		super(props);

//     LightboxCurrentFilterList.contextType = LightboxContext;
    
// 		initBrowseCurrentFilterList(this);
// 	}

// 	render() {
// 		let filterList = [];
// 		if(this.context.state.filters) {
// 			for (let f in this.context.state.filters) {
// 				let cv =  this.context.state.filters[f];
// 				for(let c in cv) {
// 					let label = cv[c];
// 					let m = label.match(/^ca_sets\.set_id:([\d]+)$/);
// 					if (!m){
// 						filterList.push((<a key={ f + '_' + c } href='#' onClick={this.removeFilter}
// 							  data-facet={f}
// 							  data-value={c}><button type='button' className='btn btn-primary btn-sm' data-facet={f} data-value={c}>{label} <ion-icon name='close-circle' data-facet={f} data-value={c}></ion-icon></button></a>));
// 					}
// 				}
// 			}
// 		}
// 		return(
// 			<div>{filterList}</div>
// 		);
// 	}
// }

// export default LightboxCurrentFilterList;
