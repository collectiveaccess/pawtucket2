/**
 * Sub-components are:
 *      <NONE>
 *
 * Props are:
 *      <NONE>
 *
 * Used by:
 *  	Lightbox
 *
 * Uses context: LightboxContext
 */

import React, { useContext } from 'react'
import { LightboxContext } from './LightboxContext'

const LightboxNavigation = () => {
	
	const { id, setId, tokens, setTokens, userAccess, setUserAccess, lightboxTitle, setLightboxTitle, totalSize, setTotalSize, sortOptions, setSortOptions, comments, setComments, itemsPerPage, setItemsPerPage, lightboxList, setLightboxList, key, setKey, view, setView, lightboxListPageNum, setLightboxListPageNum, lightboxSearchValue, setLightboxSearchValue, lightboxes, setLightboxes, resultList, setResultList, selectedItems, setSelectedItems, showSelectButtons, setShowSelectButtons, filters, setFilters } = useContext(LightboxContext)

	const backToList = () => {
		setId(null)
		setFilters(null)
		setLightboxTitle(null)
	}
	
	return(
		<button className='btn btn-secondary btn-sm' onClick={backToList}>
			<span className="material-icons">arrow_back_ios</span>
		</button>
	);
	
}
export default LightboxNavigation;

// <a href='#' className='btn btn-secondary' onClick={backToList}>
// 	<ion-icon name='ios-arrow-back'></ion-icon>
// </a>