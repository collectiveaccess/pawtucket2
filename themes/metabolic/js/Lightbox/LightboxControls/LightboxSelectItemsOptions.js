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
import { appendItemstoNewLightbox  } from "../../../../default/js/lightbox";

const appData = pawtucketUIApps.Lightbox.data;
const lightboxTerminology = appData.lightboxTerminology;

class LightboxSelectItemsOptions extends React.Component {

	constructor(props) {
		super(props);

    	LightboxSelectItemsOptions.contextType = LightboxContext;

		this.clearSelectLightboxItems = this.clearSelectLightboxItems.bind(this);
		this.showSelectButtons = this.showSelectButtons.bind(this);
		this.addSelectedItemsToNewLightbox = this.addSelectedItemsToNewLightbox.bind(this);
		this.addSelectedItemsToExistingLightbox = this.addSelectedItemsToExistingLightbox.bind(this);
	}

	clearSelectLightboxItems() {
		let state = this.context.state;
		
		state.showSelectButtons = false;
		state.selectedItems = [];
		this.context.setState(state);
	}

	showSelectButtons() {
		let state = this.context.state;
		
		state.showSelectButtons = true;
		this.context.setState(state);
	}

	addSelectedItemsToNewLightbox() {
		let that = this;
		let state = that.context.state;
    	
    	// TODO: For some reason it gives type error when using this.context.state
    	appendItemstoNewLightbox(appData.baseUrl, this.context.state.tokens, 'My new lightbox', this.context.state.selectedItems.join(';'), function(resp) { 
			if (resp && resp['ok']) {
				state.lightboxList.sets[resp.set_id] = {isMember:true, set_id:resp.set_id, label: resp.label, count: resp.count, item_type_singular: resp.item_type_singular, item_type_plural: resp.item_type_plural };
				state.set_id = resp.set_id;
				state.selectedItems = [];
				state.showSelectButtons = false;
				that.context.setState(state);
        // TODO: For some reason it gives type error when using this.context.setState
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

	addSelectedItemsToExistingLightbox() {}

	render() {
		return (
			<div id="bSelectOptions">
				<div className="dropdown show">
					<a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<ion-icon name="checkmark-circle-outline"></ion-icon>
					</a>

					<div className="dropdown-menu" aria-labelledby="dropdownMenuLink">
						{(this.context.state.showSelectButtons) ? <a className="dropdown-item" onClick={this.clearSelectLightboxItems}>Clear selection</a> : <a className="dropdown-item" onClick={this.showSelectButtons}>Select items</a> }
						{(this.context.state.selectedItems.length > 0) ? <a className="dropdown-item" onClick={this.addSelectedItemsToNewLightbox}>Create {lightboxTerminology.singular} From Selection</a> : null }
					</div>
				</div>
			</div>

		);
	}
}

export default LightboxSelectItemsOptions;
