/**
* Renders select options
*
* Props are:
* 		<NONE>
*
* Used by:
*  	LightboxControls
*
* Uses context: LightboxContext
*/

import React from "react"
import ReactDOM from "react-dom";
import { LightboxContext } from '../../Lightbox'
import { appendItemstoNewLightbox, removeItemsFromLightbox, transferItemsToLightbox } from "../../../../default/js/lightbox";

import { confirmAlert } from 'react-confirm-alert';
import 'react-confirm-alert/src/react-confirm-alert.css';

const appData = pawtucketUIApps.Lightbox.data;
const baseUrl = appData.baseUrl; 
// const lightboxTerminology = appData.lightboxTerminology;

console.log("Lightbox: PUIApps", pawtucketUIApps.Lightbox);

class LightboxSelection extends React.Component {

	constructor(props) {
		super(props);

    LightboxSelection.contextType = LightboxContext;

		this.state= {
			transferItems: false,
			transferSubmit: false,
			searchedLightbox: '',
			selectedLightbox: '',
			selectedLightboxId: '',
			selectedLightboxCount: '',
		}

		this.clearSelectLightboxItems = this.clearSelectLightboxItems.bind(this);
		this.showSelectButtons = this.showSelectButtons.bind(this);

		this.addSelectedItemsToNewLightbox = this.addSelectedItemsToNewLightbox.bind(this);
		this.addSelectedItemsToExistingLightbox = this.addSelectedItemsToExistingLightbox.bind(this);
		this.deleteSelectedItems = this.deleteSelectedItems.bind(this);
		this.deleteLightboxItemsConfirm = this.deleteLightboxItemsConfirm.bind(this);

		this.clearInput = this.clearInput.bind(this);
		this.handleChange = this.handleChange.bind(this);
		this.toggleDropdown = this.toggleDropdown.bind(this);
		this.transferOption = this. transferOption.bind(this)

	}

	//removes items from selection
	clearSelectLightboxItems() {
		let state = this.context.state;
		state.showSelectButtons = false;
		state.selectedItems = [];
		this.context.setState(state);

		this.setState({transferItems: false})
		// this.context.reloadResults();
	}

	showSelectButtons() {
		let state = this.context.state;
		state.showSelectButtons = true;
		this.context.setState(state);
	}

	//Clears the input searchbox for lightboxes being searched for.
	clearInput(){
		document.getElementById('lightbox-input').value = ' '
		this.setState({searchedLightbox: ' '})
	}

	// on change handler for lightboxes being searched.
	handleChange(event) {
		const { value } = event.target;
		this.setState({ searchedLightbox: value });
	}

	addSelectedItemsToNewLightbox() {
		this.toggleDropdown()
		let that = this;

		appendItemstoNewLightbox(baseUrl, that.context.state.tokens, name, that.context.state.selectedItems.join(';'), function(data){
			// console.log("appendItemstoNewLightbox: ", data);
			let lightboxList = that.context.state.lightboxList;
			// TODO: after count of items is displayed, it shows undefined, need it to show objects
			lightboxList[data.id] = {id: data.id, count: data.count};
			that.context.setState({lightboxlist: lightboxList});
		});
		that.context.setState({selectedItems: []});

		this.context.setState({ showSelectButtons: false });
	}

	addSelectedItemsToExistingLightbox() {
		this.toggleDropdown()
		let that = this;
		let state = that.context.state;

		let selectedItems = that.context.state.selectedItems;
		let resultList = [...that.context.state.resultList];

		let selectedLightboxCount = that.state.selectedLightboxCount;
		// let selectedLightboxCurrentItems = this.state.context.lightboxList[this.state.selectedLightboxId];

		transferItemsToLightbox(baseUrl, this.context.state.tokens, this.context.state.id, this.state.selectedLightboxId, this.context.state.selectedItems.join(';'), function(data) {
			// console.log("transferItemsToLightbox: ", data);

			let newResultList = [];
			for(let i in resultList) {  //i is the index position of item in resultList
				let r = resultList[i].id; //r is the id of item in resultList
				if (!selectedItems.includes(r)) {
					newResultList.push(resultList[i]);
				}
			}
			that.context.setState({resultList: newResultList, totalSize: newResultList.length});

			let lightboxList = that.context.state.lightboxList;
			// TODO: after count of items is displayed, it shows undefined, need it to show objects
			let newItemCount = (selectedItems.length) + (selectedLightboxCount);
			lightboxList[that.state.selectedLightboxId] = {id: that.state.selectedLightboxId, title: that.state.selectedLightbox, count: newItemCount };
			lightboxList[that.context.state.id] = { id: that.context.state.id, title: that.context.state.lightboxTitle, count: that.context.state.totalSize }
			that.context.setState({ lightboxlist: lightboxList });
		});

		this.setState({transferItems: false});
		this.context.setState({ selectedItems: [] });
		this.context.setState({ showSelectButtons: false });
	}

	deleteSelectedItems(){
		this.toggleDropdown()

		let that = this;
		let state = that.context.state;

		let selectedItems = that.context.state.selectedItems;
		let set_id = that.context.state.id;

		let resultList = [...that.context.state.resultList];
		// if(!this.context.state.id) { return; }

		removeItemsFromLightbox(baseUrl, that.context.state.tokens, set_id, selectedItems.join(';'), function(data) {
			// console.log("removeItemFromLightbox: ", data);

			let lightboxList = that.context.state.lightboxList;
			// TODO: after count of items is displayed, it shows undefined, need it to show objects
			lightboxList[data.id] = {id: data.id, title: that.context.state.lightboxTitle, count: data.count};
			that.context.setState({lightboxlist: lightboxList});

			let newResultList = [];
			for(let i in resultList) {  //i is the index position of item in resultList
				let r = resultList[i].id; //r is the id of item in resultList
				if (!selectedItems.includes(r)) {
					newResultList.push(resultList[i]);
				}
			}
			that.context.setState({resultList: newResultList, totalSize: newResultList.length});
		});

		that.context.setState({ selectedItems: [] });
		this.context.setState({ showSelectButtons: false });
	}

	deleteLightboxItemsConfirm(){
		confirmAlert({
			customUI: ({ onClose }) => {
				return (
					<div className='col info text-gray'>
						<p>Do you want to delete these items?</p>
						<div className='button' onClick={() => {
							this.deleteSelectedItems();
							onClose(); }}> Yes </div>
						&nbsp;
						<div className='button' onClick={onClose}>No</div>
					</div>
				);
			}
		});
	}

	toggleDropdown() {
		$('.menu-option').click(function() {
  		$(this).parents('.btn-group').find('button.dropdown-toggle').dropdown('toggle')
		});
	}

	transferOption(){
		this.setState({transferItems:true})
	}

	render() {
		// console.log('Context State: ', this.context.state);
		// console.log('selectedLightboxCount: ', this.state.selectedLightboxCount)
		// console.log('exportFormats: ', appData.exportFormats);

		let lightboxes = [];
		if (this.context.state.lightboxList) {
			for(let k in this.context.state.lightboxList) {
				let l = this.context.state.lightboxList[k];
				lightboxes.unshift(l);
			}
		}

		let filteredLightboxes = lightboxes.filter((lightbox) => {
			if(lightbox.title){
				let title = lightbox.title.toLowerCase();
				let searchedLightbox = this.state.searchedLightbox.toLowerCase();
				return title.includes(searchedLightbox);
			}
	  });

		let numberOfSelectedItems;
		if(this.context.state.selectedItems && this.context.state.selectedItems.length){
			numberOfSelectedItems = this.context.state.selectedItems.length;
		}

		$(document).on('click', '#transferItemsOption', function (e) {
			do {
				e.stopPropagation();
			}while (this.state.transferItems == true);
		});

		return (
			<div id="selectItems" className="align-self-center">

				<div className="btn-group">

					{(this.context.state.showSelectButtons) ?
						<button className="btn btn-sm btn-danger" onClick={this.clearSelectLightboxItems} style={{marginLeft: '6px'}}>Cancel</button>
						:
						<button
							className={(this.context.state.dragDropMode) ? "btn btn-sm btn-secondary disabled" : "btn btn-sm btn-secondary"} disabled={(this.context.state.dragDropMode) ? "disabled" : ""}
							onClick={this.showSelectButtons}
							style={{marginLeft: '6px'}}>Select</button>
					}

					{(numberOfSelectedItems >= 1) ?
						<button className="btn btn-sm btn-success dropdown-toggle dropdown-toggle-split" id="optionsButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span className="sr-only">Toggle Dropdown</span>
					  </button>
						:
						' '
					}

				  <ul className="dropdown-menu">

				    <li className='menu-option'>
							<a className="dropdown-item" href="#" onClick={this.addSelectedItemsToNewLightbox}>Create Lightbox</a>
						</li>

						{(this.context.state.userAccess == 2) ?
							<>
								<div className="dropdown-divider"></div>
						    <li className='menu-option'>
									<a className="dropdown-item" href="#" onClick={this.deleteLightboxItemsConfirm}>Delete Items</a>
								</li>
								<div className="dropdown-divider"></div>
								<li className='menu-option' id='transferItemsOption'>
									<a className="dropdown-item" onClick={this.transferOption} href="#">Transfer to Lightbox</a>
								</li>
							</>
							:
							(' ')
						}

						{(this.state.transferItems) ?
								<div className='container' style={{marginBottom: '10px'}}>
									<div className='row justify-content-center'>
										<form className='form-inline' style={{margin: '10px'}}>
											<div style={{marginRight: '5px'}}>
												<button className="close" aria-label="Close" onClick={this.clearInput}>
												<span aria-hidden="true">&times;</span>
												</button>
											</div>

											<div style={{marginRight: '5px'}}>
												<input
													style={{marginTop: '2px'}}
													id='lightbox-input'
													type="text"
													value={this.state.searchedLightbox}
													onChange={this.handleChange}
													name="searchedLightbox"
													placeholder="Search Lightboxes"
												></input>
											</div>

											<div>
												<button className="btn" onClick={this.addSelectedItemsToExistingLightbox}>
													<svg width="1em" height="1em" viewBox="0 0 16 16" className="bi bi-arrow-right-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-11.5.5a.5.5 0 0 1 0-1h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5z"></path></svg>
												</button>
											</div>
										</form>
									</div>

									<div className='lightbox-container' style={{marginLeft: '30px' , overflow: 'auto',  width: '350px', height: '200px'}}>
										{filteredLightboxes.map(lightbox => {
											return (
												<li id='transferItemsOption' key={lightbox.id}>
													<a 
														id='transferItemsOption' 
														style={{marginBottom: '5px'}} 
														onClick={() => this.setState({searchedLightbox:lightbox.title, selectedLightbox:lightbox.title, selectedLightboxId:lightbox.id, selectedLightboxCount: lightbox.count})} 
														style={{cursor: 'pointer', backgroundColor:'#fafafa', marginBottom: '5px'}}
													> 
														{lightbox.title} 
													</a>
												</li>
											)
										})}
									</div>

								</div> /*container end*/
							:
							null
						}

				  </ul> {/* dropdown-menu end */}

				</div> {/* btn-group end */}

			</div>

		);
	}
}

export default LightboxSelection;
