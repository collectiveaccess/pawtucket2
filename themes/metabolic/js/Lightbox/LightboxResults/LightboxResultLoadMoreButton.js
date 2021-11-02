/**
 * Button triggering load of next page of results.
 *
 * Props are:
 * 		start : Offset in result set to begin display of results from. Defaults to 0 (start of result set).
 * 		itemsPerPage : Maximum number of items to load.
 * 		size : Total size of current result set.
 * 		loadMoreHandler : Function to call when clicked. Function should trigger load of results page and alter browse results state.
 * 		loadMoreRef : Ref to apply to load more button. Enables setting of "loading" text while results request is pending.
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 *  	LightboxResults
 *
 * Uses context: LightboxContext
 */

import React, { useState, useContext, useEffect } from 'react'
import { LightboxContext } from '../LightboxContext';
import { loadLightbox } from "../../../../default/js/lightbox";

const appData = pawtucketUIApps.Lightbox.data;
const baseUrl = appData.baseUrl;

const LightboxResultLoadMoreButton = (props) => {

  const { id, setId, tokens, setTokens, userAccess, setUserAccess, lightboxTitle, setLightboxTitle, totalSize, setTotalSize, sortOptions, setSortOptions, comments, setComments, itemsPerPage, setItemsPerPage, lightboxList, setLightboxList, key, setKey, view, setView, lightboxListPageNum, setLightboxListPageNum, lightboxSearchValue, setLightboxSearchValue, lightboxes, setLightboxes, resultList, setResultList, selectedItems, setSelectedItems, showSelectButtons, setShowSelectButtons, showSortSaveButton, setShowSortSaveButton, start, setStart, dragDropMode, setDragDropMode, isLoading, setIsLoading } = useContext(LightboxContext)

  // const [ currentItemsPerPage, setCurrentItemsPerPage ] = useState(props.itemsPerPage)

  const loadMoreLightboxes = (e) => {
    // this.context.setState({ isLoading: true });
    setIsLoading(true);

    let newLimit = itemsPerPage + 24;
    setItemsPerPage(newLimit)

    loadLightbox(baseUrl, tokens, id, (data) => {
      // console.log(data);
      setResultList(data.items)
    }, { start: 0, limit: newLimit });

    // setItemsPerPage(currentItemsPerPage)
    setIsLoading(false)
    e.preventDefault();
  }

  // let resultListLength;
  // useEffect(() => {
  //   if (resultList) {
  //     resultListLength = resultList.length;
  //   }
  // }, [resultList])

  // let loadingText = (isLoading) ? "LOADING" : "Load More";

  if (resultList && (resultList.length < totalSize)) {
    return (
      <div className="row bLoadMore">
        <div className="col-sm-12 text-center my-3">
          <a className="button btn btn-primary" href="#" onClick={loadMoreLightboxes} >{(isLoading) ? "LOADING" : "Load More"}</a>
        </div>
      </div>
    );
  } else {
    return null
  }
}

export default LightboxResultLoadMoreButton




// import React from "react";
// import ReactDOM from "react-dom";
// import { LightboxContext } from '../../Lightbox';
// import { loadLightbox } from "../../../../default/js/lightbox";

// class LightboxResultLoadMoreButton extends React.Component {
//   constructor(props) {
// 		super(props);
//     this.state = {
//       currentItemsPerPage: this.props.itemsPerPage,
//     };

//     LightboxResultLoadMoreButton.contextType = LightboxContext;
//     this.loadMoreLightboxes = this.loadMoreLightboxes.bind(this);
// 	}

//   loadMoreLightboxes(e){
//     this.context.setState({ isLoading: true });
//     let that = this;
//     let newLimit = this.state.currentItemsPerPage + 24;
//     this.setState({currentItemsPerPage: newLimit});

// 		loadLightbox(this.props.baseUrl, this.props.tokens, this.props.id, function(data) {
// 		  // console.log(data);
//       that.context.setState({ resultList: data.items });
// 		}, { start: 0, limit: newLimit});

//     this.context.setState({ itemsPerPage: this.state.currentItemsPerPage });
//     this.context.setState({ isLoading: false });
//     e.preventDefault();
//   }

// 	render() {
// 		//if (((this.props.start + this.props.itemsPerPage) < this.props.size) || (this.context.state.resultSize  === null)) {
// 		//	let loadingText = (this.context.state.resultSize === null) ? "LOADING" : "Load More";
// 		//	onClick={this.props.loadMoreHandler} ref={this.props.loadMoreRef}
// 		let resultListLength;
//     if(this.context.state.resultList){
//       resultListLength = this.context.state.resultList.length;
//     }

//     if ((resultListLength < this.props.size)) {
//       let loadingText = (this.context.state.isLoading) ? "LOADING" : "Load More";

// 			return (
// 				<div className="row bLoadMore">
// 				  <div className="col-sm-12 text-center my-3">
// 						  <a className="button btn btn-primary" href="#" onClick={this.loadMoreLightboxes} >{loadingText}</a>
// 						</div>
// 				</div>
// 			  );
// 		} else {
// 			return(<span></span>)
// 		}
// 	}
// }

// export default LightboxResultLoadMoreButton;
