/**
 * Renders sort options
 *
 * Props are:
 * 		<NONE>
 *
 * Used by:
 *  	LightboxControls
 *
 * Uses context: LightboxContext
 */

import React, { useContext, useEffect, useState } from 'react'
import { LightboxContext } from '../LightboxContext'
import { loadLightbox, reorderLightboxItems } from "../../../../default/js/lightbox";

const appData = pawtucketUIApps.Lightbox.data;
const baseUrl = appData.baseUrl;

const LightboxSortOptions = (props) => {

  const { id, setId, tokens, setTokens, userAccess, setUserAccess, lightboxTitle, setLightboxTitle, totalSize, setTotalSize, sortOptions, setSortOptions, comments, setComments, itemsPerPage, setItemsPerPage, lightboxList, setLightboxList, key, setKey, view, setView, lightboxListPageNum, setLightboxListPageNum, lightboxSearchValue, setLightboxSearchValue, lightboxes, setLightboxes, resultList, setResultList, selectedItems, setSelectedItems, showSelectButtons, setShowSelectButtons, dragDropMode, setDragDropMode, sort, setSort, sortDirection, setSortDirection, userSort, setUserSort, showSortSaveButton, setShowSortSaveButton } = useContext(LightboxContext)

  const [selectedField, setSelectedField] = useState('ca_object_labels.name')
  const [selectedSortDirection, setSelectedSortDirection] = useState('ASC')

  // Change select options handler
  const handleChange = (event) => {
    const { name, value } = event.target;
    if (name == "selectedSortDirection"){
      setSelectedSortDirection(value)
    }else{
      setSelectedField(value)
    }
  }

  const submitSort = (e) => {
    setSort(selectedField)
    setSortDirection(selectedSortDirection)
    setUserSort(false)
    setShowSortSaveButton(true)
    // TODO: is userSort being used?

    loadLightbox(baseUrl, tokens, id, (data) => {
      setResultList(data.items)
    }, { start: 0, limit: itemsPerPage, sort: selectedField, sortDirection: selectedSortDirection });

    e.preventDefault();
  }

  // saves the order of the results from the sort options dropdown
  const saveOrderFromSortOptions = () => {
    console.log("func saveOrderFromSortOptions");
    let tempOrderedIds = []
    resultList.map(item => {
      tempOrderedIds.push(item.id)
    });

    reorderLightboxItems(baseUrl, tokens, id, tempOrderedIds.join('&'), lightboxList[id].title, (data) => {
      console.log('reorderLightboxItems: ', data);
    });

    setShowSortSaveButton(false)
  }

  //Cancel saveOrderFromSortOptions
  const cancelSaveFromSortOptions = () => {
    console.log("func cancelSaveFromSortOptions");
    setShowSortSaveButton(false)
  }

  if (totalSize > 1) {
    return (
      <div id="bSortOptions">
        <div className="dropdown show">
          <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <ion-icon name="funnel"></ion-icon>
          </a>

          <div className="dropdown-menu" aria-labelledby="dropdownMenuLink">

            <div className='container' style={{ width: '250px' }}>
              <div className='row'>
                <form className='form-inline' style={{ margin: '10px' }}>

                  <div style={{ marginRight: '5px' }}>
                    <select name="selectedField" required value={selectedField} onChange={handleChange}>
                      {sortOptions ? sortOptions.map((option, index) => {
                        return(
                          <option key={index} value={option.sort}>{option.label}</option>
                        )
                      }) : null}
                    </select>
                  </div>

                  <div style={{ marginRight: '5px' }}>
                    <select name="selectedSortDirection" required value={selectedSortDirection} onChange={handleChange}>
                      <option value='ASC'>↑</option>
                      <option value='DESC'>↓</option>
                    </select>
                  </div>

                  <div>
                    <button type="button" className="btn" onClick={submitSort}>
                      <span className="material-icons">arrow_forward</span>
                    </button>
                  </div>

                </form>
              </div>

              {showSortSaveButton == true ?
                <div className={"row"}>
                  <button type="button" className="btn btn-outline-success btn-sm" onClick={() => saveOrderFromSortOptions()} style={{ marginLeft: '6px' }}> Save Sort Permanently</button>
                  <button type="button" className="btn btn-outline-danger btn-sm" onClick={() => cancelSaveFromSortOptions()} style={{ marginLeft: '6px' }}>Cancel</button>
                </div>
              : null}
            </div>{/*container end */}

          </div>
        </div>
      </div>
    ); //return end
  } else {
    return ('');
  }
}

export default LightboxSortOptions



// import React from "react";
// import ReactDOM from "react-dom";
// import { LightboxContext } from '../../Lightbox';
// import { loadLightbox } from "../../../../default/js/lightbox";

// const appData = pawtucketUIApps.Lightbox.data;
// const baseUrl = appData.baseUrl;

// class LightboxSortOptions extends React.Component {
// 	constructor(props) {
// 		super(props);
//     LightboxSortOptions.contextType = LightboxContext;

//     this.state={
//       selectedField: 'ca_object_labels.name',
//       selectedSortDirection: 'ASC',
//     }

// 		this.handleChange = this.handleChange.bind(this);
//     this.submitSort = this.submitSort.bind(this);
// 	}

  // // Change select options handler
  // handleChange(event) {
  //   const { name, value } = event.target;
  //   this.setState({ [name]: value });
  // }

  // submitSort(e){

  //   this.context.setState({sort: this.state.selectedField, sortDirection: this.state.selectedSortDirection, userSort: false, showSortSaveButton: true});
  //   // this.context.setState({userSort: false, showSortSaveButton: true})
  //   // TODO: is userSort being used?

  //   let that = this;
	// 	loadLightbox(baseUrl, that.context.state.tokens, that.context.state.id, function(data) {
	// 		that.context.setState({resultList: data.items});
	// 	}, { start: 0, limit: that.context.state.itemsPerPage, sort: that.state.selectedField, sortDirection: that.state.selectedSortDirection});

  //   e.preventDefault();
  // }

// 	render() {
//     // console.log('sort: ', this.state.selectedField + ' ' + this.state.selectedSortDirection);

//     let initialSortValue;
//     let sortOptions = [];
//     if(this.context.state.sortOptions){
//       this.context.state.sortOptions.forEach(option => {
//         sortOptions.push(<option value={option.sort} key={option.label}>{option.label}</option>)
//       });
//       initialSortValue = this.context.state.sortOptions[0].sort;
//     }

//     if(this.context.state.totalSize > 1){
//       return (
//         <div id="bSortOptions">
//           <div className="dropdown show">
//             <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
//             <ion-icon name="funnel"></ion-icon>
//             </a>

//             <div className="dropdown-menu" aria-labelledby="dropdownMenuLink">

//               <div className='container' style={{width: '250px'}}>
//                 <div className='row'>
//                   <form className='form-inline' style={{margin: '10px'}}>

//                       <div style={{marginRight: '5px'}}>
//                         <select name="selectedField" required value={this.state.selectedField} onChange={this.handleChange}>
//                           {sortOptions}
//                         </select>
//                       </div>

//                       <div style={{marginRight: '5px'}}>
//                         <select name="selectedSortDirection" required value={this.state.selectedSortDirection} onChange={this.handleChange}>
//                           <option value='ASC'>↑</option>
//                           <option value='DESC'>↓</option>
//                         </select>
//                       </div>

//                       <div>
//                         <button type="button" className="btn" onClick={this.submitSort}>
//                           <svg width="1em" height="1em" viewBox="0 0 16 16" className="bi bi-arrow-right-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-11.5.5a.5.5 0 0 1 0-1h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5z"></path></svg>
//                         </button>
//                       </div>

//                   </form>
//                 </div>
//               </div>{/*container end */}

//             </div>
//           </div>
//         </div>
//       ); //return end
//     }else{
//       return('');
//     }
// 	} //render end
// }

// export default LightboxSortOptions;
