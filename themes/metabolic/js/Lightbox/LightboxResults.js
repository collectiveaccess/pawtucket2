/**
* Renders search results using a LightboxResultItem component for each result.
* Includes navigation to load openitional pages on-demand.
*
* Sub-components are:
* 		LightboxResultItem
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
import { loadLightbox } from "../../../default/js/lightbox";

import { SortableContainer, SortableElement, SortableHandle } from 'react-sortable-hoc';
import arrayMove from 'array-move'; //used for the react-sortable-hoc

import LightboxCurrentFilterList from './LightboxResults/LightboxCurrentFilterList'
import LightboxFacetList from './LightboxResults/LightboxFacetList'
import LightboxResultItem from './LightboxResults/LightboxResultItem'
import LightboxCommentForm from './LightboxResults/LightboxCommentForm'
import LightboxShareBlock from './LightboxResults/LightboxShareBlock'

const appData = pawtucketUIApps.Lightbox.data;
const baseUrl = appData.baseUrl;

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

	const { id, setId, tokens, setTokens, userAccess, setUserAccess, shareAccess, setShareAccess, comments, setComments, totalSize, setTotalSize, itemsPerPage, setItemsPerPage, resultList, setResultList, isLoading, setIsLoading, dragDropMode, setDragDropMode, orderedIds, setOrderedIds } = useContext(LightboxContext)

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

	const loadMoreLightboxes = (e) => {
		setIsLoading(true);
		let newLimit = itemsPerPage + 24;
		setItemsPerPage(newLimit)

		loadLightbox(baseUrl, tokens, id, (data) => {
			// console.log("loadLightbox: ", data);
			setResultList(data.items)
		}, { start: 0, limit: newLimit });

		setIsLoading(false)
		e.preventDefault();
	}

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
			
				{resultList && resultList.length < totalSize? 
					<div className="row bLoadMore">
						<div className="col-sm-12 text-center my-3">
							<a className="button btn btn-primary" href="#" onClick={loadMoreLightboxes} >{(isLoading) ? "LOADING" : "Load More"}</a>
						</div>
					</div>
				: null}

			</div>

			<div className="col-md-4 col-lg-3 offset-lg-1">
				{/* className="bRightCol position-fixed vh-100 w-100" */}
				<div className="bRightCol position-fixed vh-100 mr-3">
					<div id="accordion">

						<div className="card">
							<div className="card-header" style={{ padding: "15px 10px 15px 10px" }} >
								<a data-toggle="collapse" href="#bRefine" role="button" aria-expanded="false" aria-controls="collapseFilter">Filter By</a>
							</div>
							<div id="bRefine" className="card-body collapse" style={{ padding: "0 10px 5px 10px" }}  data-parent="#accordion">
								<LightboxCurrentFilterList />
								<LightboxFacetList facetLoadUrl={props.facetLoadUrl} />
							</div>
						</div>

						<div className="card pr-1">
							<div className="card-header" style={{ padding: "15px 10px 15px 10px" }} >
								<a data-toggle="collapse" href="#setComments" role="button" aria-expanded="false" aria-controls="collapseComments">
									Comments {comments && comments.length > 0? <span>({comments.length})</span> : null}
								</a>
							</div>
							<div id="setComments" className="card-body collapse" style={{ padding: "0 10px 5px 10px"}} data-parent="#accordion">
								<LightboxCommentForm />
							</div>
						</div>

						{shareAccess == "edit" && userAccess == 2?  
							<div className="card">
								<div className="card-header" style={{ padding: "15px 10px 15px 10px" }} >
									<a data-toggle="collapse" href="#setShare" role="button" aria-expanded="false" aria-controls="collapseShare">Share</a>
								</div>
								<div id="setShare" className="card-body collapse" style={{ padding: "0 10px 5px 10px"}}  data-parent="#accordion">
									<LightboxShareBlock />
								</div>
							</div>
						:null}

					</div>
					<div className="forceWidth">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</div>
				</div>
			</div>

		</div>
	)
}

export default LightboxResults