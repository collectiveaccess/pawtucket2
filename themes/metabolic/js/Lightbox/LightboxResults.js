/**
* Renders search results using a LightboxResultItem component for each result.
* Includes navigation to load openitional pages on-demand.
*
* Sub-components are:
* 		LightboxResultItem
* 		LightboxResultLoadMoreButton
* 		LightboxFacetList
* 		LightboxCurrentFilterList
* 		LightboxCommentForm
*			LightboxShareBlock
*
* From react-sortable-hoc: for drag and drop capability
*    SortableHandle
*    SortableElement
* 	 SortableContainer
* 	 arrayMove
*
* Props are:
* 		facetLoadUrl: URL to use to load facet content
*
* Used by:
*  	Lightbox
*
* Uses context: LightboxContext
*/

import React, { useState, useContext, useEffect } from 'react'
import { LightboxContext } from './LightboxContext';

import { SortableContainer, SortableElement, SortableHandle } from 'react-sortable-hoc';
import arrayMove from 'array-move'; //used for the react-sortable-hoc

import LightboxCurrentFilterList from './LightboxResults/LightboxCurrentFilterList'
import LightboxFacetList from './LightboxResults/LightboxFacetList'
import LightboxResultItem from './LightboxResults/LightboxResultItem'
import LightboxResultLoadMoreButton from './LightboxResults/LightboxResultLoadMoreButton'
import LightboxCommentForm from './LightboxResults/LightboxCommentForm'
import LightboxShareBlock from './LightboxResults/LightboxShareBlock'

const DragHandle = SortableHandle(() => {
	return (<div style={{ outline: '1px solid darkgrey' }}>
		<p style={{ textAlign: 'center', color: 'darkgrey' }}>==</p>
	</div>)
});

const Item = SortableElement(({ value }) => {
	return (<div className="grid-item" style={{ padding: '5px' }}>
		<DragHandle />
		{value}
	</div>)
});

const ItemList = SortableContainer(({ items }) => {
	return (
		<div className='grid-container' style={{ display: 'grid', gridTemplateColumns: " auto auto auto", padding: '10px' }}>
			{items.map((value, index) => (
				<Item key={index} index={index} value={value} id={value.props.item.id} />
			))}
		</div>
	);
});

const LightboxResults = (props) => {

	const { id, setId, tokens, setTokens, userAccess, setUserAccess, lightboxTitle, setLightboxTitle, totalSize, setTotalSize, sortOptions, setSortOptions, comments, setComments, itemsPerPage, setItemsPerPage, lightboxList, setLightboxList, key, setKey, view, setView, lightboxListPageNum, setLightboxListPageNum, lightboxSearchValue, setLightboxSearchValue, lightboxes, setLightboxes, resultList, setResultList, selectedItems, setSelectedItems, showSelectButtons, setShowSelectButtons, showSortSaveButton, setShowSortSaveButton, start, setStart, dragDropMode, setDragDropMode, orderedIds, setOrderedIds } = useContext(LightboxContext)

	const [ resultItems, setResultItems ] = useState([])

	// console.log("resultList: ", resultList);
	// console.log("resultItems: ", resultItems);
	// console.log("orderedIds: ", orderedIds);

	useEffect(() => {
		let tempResultItems = [];
		let tempOrderedIds = []

		if (resultList && resultList.length > 0) {
			resultList.map((item, index) => {
				tempOrderedIds.push(item.id)
				tempResultItems.push(<LightboxResultItem key={index} item={item} />)
			});
		}

		setOrderedIds(tempOrderedIds)
		setResultItems(tempResultItems)

	}, [resultList])

	//required function for react-sortable-hoc, saves the newly drag-sorted position
	const onSortEnd = ({ oldIndex, newIndex }) => {
		setResultList(arrayMove(resultList, oldIndex, newIndex))
		setResultItems(arrayMove(resultItems, oldIndex, newIndex))
	};

	return (
		<div className="row" id="browseResultsContainer" style={{ scrollBehavior: 'smooth' }}>
			<div className="col-md-8 bResultList">

				{dragDropMode == true ?
					<div className="row">
						<ItemList axis="xy" items={resultItems} onSortEnd={onSortEnd} useDragHandle />
					</div>
					:
					<div className="row" style={{ display: 'grid', gridTemplateColumns: " auto auto auto", padding: '10px' }}>
						{resultItems}
					</div>
				}
			
				<LightboxResultLoadMoreButton	/>

			</div>

			<div className="col-md-4 col-lg-3 offset-lg-1">
				<div className="bRightCol position-fixed vh-100 w-100">
					<div id="accordion">

						<div className="card">
							<div className="card-header">
								<a data-toggle="collapse" href="#bRefine" role="button" aria-expanded="false" aria-controls="collapseFilter">Filter By</a>
							</div>
							<div id="bRefine" className="card-body collapse" data-parent="#accordion">
								<LightboxCurrentFilterList />
								<LightboxFacetList facetLoadUrl={props.facetLoadUrl} />
							</div>
						</div>

						<div className="card">
							<div className="card-header">
								<a data-toggle="collapse" href="#setComments" role="button" aria-expanded="false" aria-controls="collapseComments">Comments</a>
							</div>
							<div id="setComments" className="card-body collapse" data-parent="#accordion">
								{/* <LightboxCommentForm tableName="ca_sets" itemID={id} formTitle="" listTitle="" commentFieldTitle="" tagFieldTitle="" loginButtonText="login" commentButtonText="Add" noTags="1" showForm="1" /> */}
							</div>
						</div>

						<div className="card">
							<div className="card-header">
								<a data-toggle="collapse" href="#setShare" role="button" aria-expanded="false" aria-controls="collapseShare">Share</a>
							</div>
							<div id="setShare" className="card-body collapse" data-parent="#accordion">
								{/* <LightboxShareBlock setID={id} /> */}
							</div>
						</div>

					</div>
				</div>
			</div>

		</div>
	)
}

export default LightboxResults