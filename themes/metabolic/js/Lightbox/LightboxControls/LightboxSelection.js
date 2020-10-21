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
import { addItemsToLightbox } from "../../../../default/js/lightbox";
import { removeItemFromLightbox } from "../../../../default/js/lightbox";

const appData = pawtucketUIApps.Lightbox.data;
const lightboxTerminology = appData.lightboxTerminology;
const baseUrl = appData.baseUrl; // =  /index.php/Lightbox

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
		}

		this.clearSelectLightboxItems = this.clearSelectLightboxItems.bind(this);
		this.showSelectButtons = this.showSelectButtons.bind(this);
		this.addSelectedItemsToNewLightbox = this.addSelectedItemsToNewLightbox.bind(this);

		this.addSelectedItemsToExistingLightbox = this.addSelectedItemsToExistingLightbox.bind(this);
		this.deleteSelectedItems = this.deleteSelectedItems.bind(this);

		this.clearInput = this.clearInput.bind(this);

		this.handleChange = this.handleChange.bind(this);

		this.toggleDropdown = this.toggleDropdown.bind(this);

		this.transferOption = this. transferOption.bind(this)

	}

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
		let state = that.context.state;
    // TODO: For some reason it gives type error when using this.context.state
		addItemsToLightbox(appData.baseUrl, null, this.context.state.selectedItems.join(';'), 'ca_objects', function(resp) {
			if (resp && resp['ok']) {
				state.lightboxList.sets[resp.set_id] = {isMember:true, set_id:resp.set_id, label: resp.label, count: resp.count, item_type_singular: resp.item_type_singular, item_type_plural: resp.item_type_plural };
				state.set_id = resp.set_id;
				state.filters = {'_search': {}};
				state.filters['_search']['ca_sets.set_id:' + resp.set_id] = 'Lightbox: ' + resp.label;
				state.selectedItems = [];
				state.showSelectButtons = false;
				that.context.setState(state);
        // TODO: For some reason it gives type error when using this.context.setState
				that.context.reloadResults(state.filters, false);
				state.statusMessage = "Added Item To " + lightboxTerminology.singular;
				that.setState(state);
				setTimeout(function() {
					state.statusMessage = '';
					that.setState(state);
				}, 2000);
				return;
			}
			alert("Could not add item to lightbox: " + resp['err']);
		});
	}

	addSelectedItemsToExistingLightbox() {
		this.toggleDropdown()
		let that = this;
		let state = that.context.state;
    // TODO: For some reason it gives type error when using this.context.state
		addItemsToLightbox(appData.baseUrl, this.state.selectedLightboxId, this.context.state.selectedItems.join(';'), 'ca_objects', function(resp) {
			if (resp && resp['ok']) {
        // TODO: For some reason it gives type error when using this.context.setState
				that.context.reloadResults(state.filters, false);
				state.statusMessage = "Added Item To " + lightboxTerminology.singular;
				that.setState(state);
				setTimeout(function() {
					state.statusMessage = '';
					that.setState(state);
				}, 2000);
				return;
			}
			alert("Could not add item to lightbox: " + resp['err']);
		});

		this.setState({transferItems: false})
		this.context.setState({
			showSelectButtons: false,
			selectedItems: [],
		});

	}

	deleteSelectedItems(){
		this.toggleDropdown()

		let selectedItems = this.context.state.selectedItems;
		let set_id = this.context.state.set_id;

		let that = this;
		if(!this.context.state.set_id) { return; }

		selectedItems.forEach(element =>
			removeItemFromLightbox(baseUrl, set_id, element, function(resp) {
				if(resp && resp['ok']) {
					let state = that.context.state;
					for(let i in state.resultList) {
						let r = state.resultList[i];
						if (r.id == element) {
							delete(state.resultList[i]);
							state.resultSize--;
							let x = null;
							x = state.selectedItems.indexOf(element);
							if(i > -1){
								state.selectedItems.splice(x, 1);
							}
							that.setState(state);
							break;
						}
					}
					return;
				}
				alert('Could not remove item: ' + resp['err']);
			})
		);  {/* end of for each */}

		// setTimeout(this.context.reloadResults(), 2000)

		this.context.setState({
			showSelectButtons: false,
			selectedItems: [],
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

		// $(document).on('click', '#transferItemsOption', function (e) {
		// 		e.stopPropagation();
		// });

		let lightboxes = [];
		if (this.context.state.lightboxList && this.context.state.lightboxList.sets) {
			for(let k in this.context.state.lightboxList.sets) {
				let l = this.context.state.lightboxList.sets[k];
				lightboxes.unshift(l);
			}
		}
		// console.log('List of lightboxes for selection', lightboxes);

		let filteredLightboxes = lightboxes.filter((lightbox) => {
      return lightbox.label
        .toLowerCase()
        .includes(this.state.searchedLightbox.toLowerCase());
    });

		let numberOfSelectedItems;
		if(this.context.state.selectedItems && this.context.state.selectedItems.length){
			numberOfSelectedItems = this.context.state.selectedItems.length;
		}

		// console.log("numberOfSelectedItems: ", numberOfSelectedItems);

		return (
			<div id="selectItems">

				<div className="btn-group">

					{(this.context.state.showSelectButtons) ?
						<button type="button" className="btn btn-danger" onClick={this.clearSelectLightboxItems} style={{marginLeft: '6px'}}>Cancel Select</button>
						:
						<button type="button" className="btn btn-secondary" onClick={this.showSelectButtons} style={{marginLeft: '6px'}}>Select Items</button>
					}

					{(numberOfSelectedItems >= 1) ?
						<button type="button" className="btn btn-success dropdown-toggle dropdown-toggle-split" id="optionsButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span className="sr-only">Toggle Dropdown</span>
					  </button>
						:
						' '
					}

				  <ul className="dropdown-menu">

				    <li className='menu-option'>
							<a className="dropdown-item" href="#" onClick={this.addSelectedItemsToNewLightbox}>Create Lightbox From Selected Items</a>
						</li>
						<div className="dropdown-divider"></div>

				    <li className='menu-option'>
							<a className="dropdown-item" href="#" onClick={this.deleteSelectedItems}>Delete Selected Items</a>
						</li>
						<div className="dropdown-divider"></div>

						<li className='menu-option' id='transferItemsOption'>
							<a className="dropdown-item" onClick={this.transferOption} href="#">Transfer to Lightbox</a>
						</li>

						{(this.state.transferItems) ?
								<div className='container' id='transferItemsOption' style={{marginBottom: '10px'}}>
									<div className='row justify-content-center'>
										<form className='form-inline' style={{margin: '10px'}}>
											<div style={{marginRight: '5px'}}>
												<button type="button" className="close" aria-label="Close" onClick={this.clearInput}>
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
												<button type="button" className="btn" onClick={this.addSelectedItemsToExistingLightbox}>
													<svg width="1em" height="1em" viewBox="0 0 16 16" className="bi bi-arrow-right-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fillRule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-11.5.5a.5.5 0 0 1 0-1h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5z"></path></svg>
												</button>
											</div>
										</form>
									</div>


									<div className='lightbox-container' style={{marginLeft: '30px' , overflow: 'auto',  width: '350px', height: '200px'}}>
									{filteredLightboxes.map(lightbox => {
										return <li key={lightbox.set_id}><a style={{marginBottom: '5px'}} onClick={() => this.setState({searchedLightbox:lightbox.label, selectedLightbox:lightbox.label, selectedLightboxId:lightbox.set_id})} style={{cursor: 'pointer', backgroundColor:'#fafafa', marginBottom: '5px'}}> {lightbox.label} </a></li>
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
