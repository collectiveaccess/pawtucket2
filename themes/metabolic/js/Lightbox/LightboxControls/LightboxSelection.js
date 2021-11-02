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

	const [ filteredLightboxes, setFilteredLightboxes ] = useState([...lightboxes])
	const [ numberOfSelectedItems, setNumberOfSelectedItems ] = useState(0)

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
		}else{
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
			let tempLightboxList = {...lightboxList};
			// TODO: after count of items is displayed, it shows undefined, need it to show objects
			tempLightboxList[data.id] = { id: data.id, count: data.count };
			setLightboxList(tempLightboxList)
		});
		setSelectedItems([])
		setShowSelectButtons(false)
	}
	
	const addSelectedItemsToExistingLightbox = () => {
		toggleDropdown()
	
		transferItemsToLightbox(baseUrl, tokens, id, selectedLightboxId, selectedItems.join(';'),(data) => {
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
			
			let tempLightboxList = {...lightboxList};
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
		confirmAlert({ customUI: ({ onClose }) => {
			return (
				<div className='col info text-gray'>
					<p>Do you want to delete these items?</p>
					<div className='button' onClick={() => {deleteSelectedItems(); onClose();}}>Yes</div>
					&nbsp;
					<div className='button' onClick={onClose}>No</div>
				</div>
			);
		}});
	}
	
	const deleteSelectedItems = () => {
		toggleDropdown()
		
		removeItemsFromLightbox(baseUrl, tokens, id, selectedItems.join(';'), (data) => {
			// console.log("removeItemFromLightbox: ", data);
			let tempLightboxList = {...lightboxList}
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

	const transferOption = () =>{
		console.log("func transferOption");
		if(transferItems){
			setTransferItems(false)
		}else{
			setTransferItems(true)
		}
		// setTransferItems(true)
	}
	
	$(document).on('click', '#lb-option', (e) => {
		do {
			e.stopPropagation();
		} while (transferItems == true);
	});

	$(document).ready(function () {
		$('.dropdown-submenu #transferItemsOption').on("click", function (e) {
			$(this).next('ul').toggle();
			e.stopPropagation();
			e.preventDefault();
		});
	});
	
	return (
		<div id="selectItems">

			<div className="btn-group">

				{showSelectButtons ?
					<button className="btn btn-outline-danger btn-sm" onClick={clearSelectLightboxItems} style={{ marginLeft: '6px' }}>Cancel Select</button>
				:
					(resultList && resultList.length > 0) ?
						<button
							className={`btn btn-secondary btn-sm ${(dragDropMode) ? "disabled" : ''}`}
							onClick={showSelect}
							style={{ marginLeft: '6px' }}>Select Items</button>
					: null
				}

				{(numberOfSelectedItems > 0) ?
					<button className="btn btn-outline-success dropdown-toggle dropdown-toggle-split btn-sm" id="optionsButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span className="sr-only">Toggle Dropdown</span>
					</button>
				: null }

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
								<a id='transferItemsOption' onClick={transferOption} style={{ cursor: "pointer", textDecoration: "none" }}>
									Transfer to Lightbox <span className="material-icons">expand_more</span>
								</a>
								<ul className="dropdown-menu">
									<form className='form-inline' style={{ margin: '10px' }}>
										<input
											style={{ marginLeft: '10px' }}
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
										<div id={'lb-option'} className='lightbox-container w-100 pl-4' style={{ overflow: 'auto', height: '200px' }}>
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
					: null }

				</ul> {/* dropdown-menu end */}

			</div> {/* btn-group end */}

		</div>
	);
}

export default LightboxSelection


	// < li className = "dropdown-submenu ml-4" style = {{ position: 'relative' }}>
	// 	<a id='transferItemsOption' className="text-decoration-none">
	// 		Transfer to Lightbox <span className="material-icons">expand_more</span>
	// 	</a>
	// 	<ul className="dropdown-menu">
	// 		<form className='form-inline' style={{ margin: '10px' }}>
	// 			<input
	// 				style={{ marginLeft: '10px' }}
	// 				id='lightbox-input'
	// 				type="text"
	// 				value={searchedLightbox}
	// 				onChange={handleChange}
	// 				name="searchedLightbox"
	// 				placeholder="Search Lightboxes"
	// 			></input>
	// 			<button className="btn p-0" onClick={addSelectedItemsToExistingLightbox}>
	// 				<span className="material-icons">arrow_forward</span>
	// 			</button>
	// 		</form>

	// 		{filteredLightboxes?
	// 			<div className='lightbox-container w-100 pl-4' style={{ overflow: 'auto', height: '200px' }}>
	// 				{filteredLightboxes.map((lightbox, index) => {
	// 					return (
	// 						<li className="mb-1" key={index} onClick={() => setLightboxData(lightbox.props.data.title, lightbox.props.data.id, lightbox.props.data.count)}>
	// 							<a style={{cursor: 'pointer', backgroundColor:"#F0F0F0"}}>
	// 								{lightbox.props.data.title}
	// 							</a>
	// 						</li>
	// 					)
	// 				})}
	// 			</div>
	// 		: null}
	// 	</ul>
	// </li >



// import React from "react"
// import ReactDOM from "react-dom";
// import { LightboxContext } from '../../Lightbox'
// import { appendItemstoNewLightbox, removeItemsFromLightbox, transferItemsToLightbox } from "../../../../default/js/lightbox";

// import { confirmAlert } from 'react-confirm-alert';
// import 'react-confirm-alert/src/react-confirm-alert.css';

// const appData = pawtucketUIApps.Lightbox.data;
// const baseUrl = appData.baseUrl; 
// const lightboxTerminology = appData.lightboxTerminology;

// console.log("Lightbox: PUIApps", pawtucketUIApps.Lightbox);

// class LightboxSelection extends React.Component {

// 	constructor(props) {
// 		super(props);

//     LightboxSelection.contextType = LightboxContext;

// 		this.state= {
// 			transferItems: false,
// 			transferSubmit: false,
// 			searchedLightbox: '',
// 			selectedLightbox: '',
// 			selectedLightboxId: '',
// 			selectedLightboxCount: '',
// 		}

// 		this.clearSelectLightboxItems = this.clearSelectLightboxItems.bind(this);
// 		this.showSelectButtons = this.showSelectButtons.bind(this);

// 		this.addSelectedItemsToNewLightbox = this.addSelectedItemsToNewLightbox.bind(this);
// 		this.addSelectedItemsToExistingLightbox = this.addSelectedItemsToExistingLightbox.bind(this);
// 		this.deleteSelectedItems = this.deleteSelectedItems.bind(this);
// 		this.deleteLightboxItemsConfirm = this.deleteLightboxItemsConfirm.bind(this);

// 		this.clearInput = this.clearInput.bind(this);
// 		this.handleChange = this.handleChange.bind(this);
// 		this.toggleDropdown = this.toggleDropdown.bind(this);
// 		this.transferOption = this. transferOption.bind(this)

// 	}

	// //removes items from selection
	// clearSelectLightboxItems() {
	// 	let state = this.context.state;
	// 	state.showSelectButtons = false;
	// 	state.selectedItems = [];
	// 	this.context.setState(state);

	// 	this.setState({transferItems: false})
	// 	// this.context.reloadResults();
	// }

	// showSelectButtons() {
	// 	let state = this.context.state;
	// 	state.showSelectButtons = true;
	// 	this.context.setState(state);
	// }

	// //Clears the input searchbox for lightboxes being searched for.
	// clearInput(){
	// 	document.getElementById('lightbox-input').value = ' '
	// 	this.setState({searchedLightbox: ' '})
	// }

	// // on change handler for lightboxes being searched.
	// handleChange(event) {
	// 	const { value } = event.target;
	// 	this.setState({ searchedLightbox: value });
	// }

	// addSelectedItemsToNewLightbox() {
	// 	this.toggleDropdown()
	// 	let that = this;

	// 	appendItemstoNewLightbox(baseUrl, that.context.state.tokens, name, that.context.state.selectedItems.join(';'), function(data){
	// 		// console.log("appendItemstoNewLightbox: ", data);
	// 		let lightboxList = that.context.state.lightboxList;
	// 		// TODO: after count of items is displayed, it shows undefined, need it to show objects
	// 		lightboxList[data.id] = {id: data.id, count: data.count};
	// 		that.context.setState({lightboxlist: lightboxList});
	// 	});
	// 	that.context.setState({selectedItems: []});

	// 	this.context.setState({ showSelectButtons: false });
	// }

	// addSelectedItemsToExistingLightbox() {
	// 	this.toggleDropdown()
	// 	let that = this;
	// 	let state = that.context.state;

	// 	let selectedItems = that.context.state.selectedItems;
	// 	let resultList = [...that.context.state.resultList];

	// 	let selectedLightboxCount = that.state.selectedLightboxCount;
	// 	// let selectedLightboxCurrentItems = this.state.context.lightboxList[this.state.selectedLightboxId];

	// 	transferItemsToLightbox(baseUrl, this.context.state.tokens, this.context.state.id, this.state.selectedLightboxId, this.context.state.selectedItems.join(';'), function(data) {
	// 		// console.log("transferItemsToLightbox: ", data);

	// 		let newResultList = [];
	// 		for(let i in resultList) {  //i is the index position of item in resultList
	// 			let r = resultList[i].id; //r is the id of item in resultList
	// 			if (!selectedItems.includes(r)) {
	// 				newResultList.push(resultList[i]);
	// 			}
	// 		}
	// 		that.context.setState({resultList: newResultList, totalSize: newResultList.length});

	// 		let lightboxList = that.context.state.lightboxList;
	// 		// TODO: after count of items is displayed, it shows undefined, need it to show objects
	// 		let newItemCount = (selectedItems.length) + (selectedLightboxCount);
	// 		lightboxList[that.state.selectedLightboxId] = {id: that.state.selectedLightboxId, title: that.state.selectedLightbox, count: newItemCount };
	// 		lightboxList[that.context.state.id] = { id: that.context.state.id, title: that.context.state.lightboxTitle, count: that.context.state.totalSize }
	// 		that.context.setState({ lightboxlist: lightboxList });
	// 	});

	// 	this.setState({transferItems: false});
	// 	this.context.setState({ selectedItems: [] });
	// 	this.context.setState({ showSelectButtons: false });
	// }

	// deleteSelectedItems(){
	// 	this.toggleDropdown()

	// 	let that = this;
	// 	let state = that.context.state;

	// 	let selectedItems = that.context.state.selectedItems;
	// 	let set_id = that.context.state.id;

	// 	let resultList = [...that.context.state.resultList];
	// 	// if(!this.context.state.id) { return; }

	// 	removeItemsFromLightbox(baseUrl, that.context.state.tokens, set_id, selectedItems.join(';'), function(data) {
	// 		// console.log("removeItemFromLightbox: ", data);

	// 		let lightboxList = that.context.state.lightboxList;
	// 		// TODO: after count of items is displayed, it shows undefined, need it to show objects
	// 		lightboxList[data.id] = {id: data.id, title: that.context.state.lightboxTitle, count: data.count};
	// 		that.context.setState({lightboxlist: lightboxList});

	// 		let newResultList = [];
	// 		for(let i in resultList) {  //i is the index position of item in resultList
	// 			let r = resultList[i].id; //r is the id of item in resultList
	// 			if (!selectedItems.includes(r)) {
	// 				newResultList.push(resultList[i]);
	// 			}
	// 		}
	// 		that.context.setState({resultList: newResultList, totalSize: newResultList.length});
	// 	});

	// 	that.context.setState({ selectedItems: [] });
	// 	this.context.setState({ showSelectButtons: false });
	// }

	// deleteLightboxItemsConfirm(){
	// 	confirmAlert({
	// 		customUI: ({ onClose }) => {
	// 			return (
	// 				<div className='col info text-gray'>
	// 					<p>Do you want to delete these items?</p>
	// 					<div className='button' onClick={() => {
	// 						this.deleteSelectedItems();
	// 						onClose(); }}> Yes </div>
	// 					&nbsp;
	// 					<div className='button' onClick={onClose}>No</div>
	// 				</div>
	// 			);
	// 		}
	// 	});
	// }

	// toggleDropdown() {
	// 	$('.menu-option').click(function() {
  // 		$(this).parents('.btn-group').find('button.dropdown-toggle').dropdown('toggle')
	// 	});
	// }

	// transferOption(){
	// 	this.setState({transferItems:true})
	// }

	// render() {
		// console.log('Context State: ', this.context.state);
		// console.log('selectedLightboxCount: ', this.state.selectedLightboxCount)
		// console.log('exportFormats: ', appData.exportFormats);

		// let lightboxes = [];
		// if (this.context.state.lightboxList) {
		// 	for(let k in this.context.state.lightboxList) {
		// 		let l = this.context.state.lightboxList[k];
		// 		lightboxes.unshift(l);
		// 	}
		// }

		// let filteredLightboxes = lightboxes.filter((lightbox) => {
		// 	if(lightbox.title){
		// 		let title = lightbox.title.toLowerCase();
		// 		let searchedLightbox = this.state.searchedLightbox.toLowerCase();
		// 		return title.includes(searchedLightbox);
		// 	}
	  // });

		// let numberOfSelectedItems;
		// if(this.context.state.selectedItems && this.context.state.selectedItems.length){
		// 	numberOfSelectedItems = this.context.state.selectedItems.length;
		// }

		// $(document).on('click', '#transferItemsOption', function (e) {
		// 	do {
		// 		e.stopPropagation();
		// 	}while (this.state.transferItems == true);
		// });

		// return (
		// 	<div id="selectItems">

		// 		<div className="btn-group">

		// 			{(this.context.state.showSelectButtons) ?
		// 				<button type="button" className="btn btn-danger" onClick={this.clearSelectLightboxItems} style={{marginLeft: '6px'}}>Cancel Select</button>
		// 				:
		// 				<button
		// 					type="button"
		// 					className={(this.context.state.dragDropMode) ? "btn btn-secondary disabled" : "btn btn-secondary"} disabled={(this.context.state.dragDropMode) ? "disabled" : ""}
		// 					onClick={this.showSelectButtons}
		// 					style={{marginLeft: '6px'}}>Select Items</button>
		// 			}

		// 			{(numberOfSelectedItems >= 1) ?
		// 				<button type="button" className="btn btn-success dropdown-toggle dropdown-toggle-split" id="optionsButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		// 					<span className="sr-only">Toggle Dropdown</span>
		// 			  </button>
		// 				:
		// 				' '
		// 			}

		// 		  <ul className="dropdown-menu">

		// 		    <li className='menu-option'>
		// 					<a className="dropdown-item" href="#" onClick={this.addSelectedItemsToNewLightbox}>Create Lightbox From Selected Items</a>
		// 				</li>

		// 				{(this.context.state.userAccess == 2) ?
		// 					<>
		// 						<div className="dropdown-divider"></div>
		// 				    <li className='menu-option'>
		// 							<a className="dropdown-item" href="#" onClick={this.deleteLightboxItemsConfirm}>Delete Selected Items</a>
		// 						</li>
		// 						<div className="dropdown-divider"></div>
		// 						<li className='menu-option' id='transferItemsOption'>
		// 							<a className="dropdown-item" onClick={this.transferOption} href="#">Transfer to Lightbox</a>
		// 						</li>
		// 					</>
		// 					:
		// 					(' ')
		// 				}

		// 				{(this.state.transferItems) ?
		// 						<div className='container' style={{marginBottom: '10px'}}>
		// 							<div className='row justify-content-center'>
		// 								<form className='form-inline' style={{margin: '10px'}}>
		// 									<div style={{marginRight: '5px'}}>
		// 										<button type="button" className="close" aria-label="Close" onClick={this.clearInput}>
		// 										<span aria-hidden="true">&times;</span>
		// 										</button>
		// 									</div>

		// 									<div style={{marginRight: '5px'}}>
		// 										<input
		// 											style={{marginTop: '2px'}}
		// 											id='lightbox-input'
		// 											type="text"
		// 											value={this.state.searchedLightbox}
		// 											onChange={this.handleChange}
		// 											name="searchedLightbox"
		// 											placeholder="Search Lightboxes"
		// 										></input>
		// 									</div>

		// 									<div>
		// 										<button type="button" className="btn" onClick={this.addSelectedItemsToExistingLightbox}>
		// 											<svg width="1em" height="1em" viewBox="0 0 16 16" className="bi bi-arrow-right-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-11.5.5a.5.5 0 0 1 0-1h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5z"></path></svg>
		// 										</button>
		// 									</div>
		// 								</form>
		// 							</div>

		// 							<div className='lightbox-container' style={{marginLeft: '30px' , overflow: 'auto',  width: '350px', height: '200px'}}>
		// 								{filteredLightboxes.map(lightbox => {
		// 									return <li id='transferItemsOption' key={lightbox.id}><a id='transferItemsOption' style={{marginBottom: '5px'}} onClick={() => this.setState({searchedLightbox:lightbox.title, selectedLightbox:lightbox.title, selectedLightboxId:lightbox.id, selectedLightboxCount: lightbox.count})} style={{cursor: 'pointer', backgroundColor:'#fafafa', marginBottom: '5px'}}> {lightbox.title} </a></li>
		// 								})}
		// 							</div>

		// 						</div> /*container end*/
		// 					:
		// 					null
		// 				}

		// 		  </ul> {/* dropdown-menu end */}

		// 		</div> {/* btn-group end */}

		// 	</div>

		// );
// 	}
// }

// export default LightboxSelection;
