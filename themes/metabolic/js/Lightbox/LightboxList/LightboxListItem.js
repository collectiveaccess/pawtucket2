/**
* Formats each item in the browse result using data passed in the "data" prop.
*
* Props are:
* 		data : object containing data to display for result item
* 		view : view format to use for display of results
*
* Sub-components are:
* 		<NONE>
*
* Used by:
*  	Lightbox
*
* Uses context: LightboxContext
*/

import React from "react"
import ReactDOM from "react-dom";
import { LightboxContext } from '../../Lightbox'

import EasyEdit from 'react-easy-edit';
import { confirmAlert } from 'react-confirm-alert';
import 'react-confirm-alert/src/react-confirm-alert.css';
import { editLightbox, getLightboxAccessForCurrentUser } from "../../../../default/js/lightbox";

class LightboxListItem extends React.Component {
	constructor(props) {
		super(props);
   		LightboxListItem.contextType = LightboxContext

		this.state = {
			deleting: false,
			userAccess: null
		};

		this.openLightbox = this.openLightbox.bind(this);
		this.saveLightboxEdit = this.saveLightboxEdit.bind(this);
		this.saveNewLightbox = this.saveNewLightbox.bind(this);
		this.deleteLightboxConfirm = this.deleteLightboxConfirm.bind(this);
	}

	openLightbox(e) {
		this.context.state.resultList = null;
		let set_id = e.target.attributes.getNamedItem('data-set_id').value;
		let state = this.context.state;
		state.set_id = set_id;
		if(!state.filters) { state.filters = {}; }
		if(!state.filters['_search']) { state.filters = {'_search': {}}; }
		state.filters['_search']['ca_sets.set_id:' + set_id] = 'Lightbox: ' + state.lightboxList.sets[set_id].label;
		state.selectedItems = [];
		state.showSelectButtons = false;
		this.context.setState(state);
		this.context.reloadResults(state.filters, false);

		let that = this;
		getLightboxAccessForCurrentUser(this.context.props.baseUrl, set_id, function(resp) {
			if(resp && resp['ok']) {
				let state = that.state;
				// TODO: For some reason it gives type error when using this.state

				if(resp['access']){
					state.userAccess = resp['access'];
					that.context.setState(state);
				}
			}
		});
	}

	saveNewLightbox(name) {
		// let that = this;
		this.context.saveNewLightbox({'name': name}, function(resp) {
			let state = this.state;
			if (resp && resp['err']) {
				state['newLightboxError'] = resp['err'];
				if(this.props.newLightboxRef && this.props.newLightboxRef.current) {
					this.props.newLightboxRef.current.onClick();
				}
			} else {
				state['newLightboxError'] = null;
			}
			this.setState(state);
		});
	}

	saveLightboxEdit(name) {
		// let that = this;
		editLightbox(this.context.props.baseUrl, {'name': name, set_id: this.props.data.set_id }, function(resp) {
			// TODO: display potential errors

			// Update name is context state
			let state = this.context.state;
			state.lightboxList.sets[this.props.data.set_id]['label'] = name;
			this.context.setState(state);
		});
	}

	deleteLightboxConfirm(e) {
		let that = this;
		confirmAlert({
			customUI: ({ onClose }) => {
				return (
					<div className='col info text-gray'>
						<p>Really delete collection <em>{this.props.data.label}</em>?</p>

						<div className='button'
							onClick={() => {
								let state = that.state;
								state.deleting = true;
								that.setState(state);
								// TODO: For some reason it gives type error when using this.setState

								this.props.deleteCallback(this.props.data);
								onClose();
							}}>
							Yes
						</div>
						&nbsp;
						<div className='button' onClick={onClose}>No</div>
					</div>
				);
			}
		});
	}

	render(){
		let count_text = (this.props.count == 1) ? this.props.count + " " + this.props.data.item_type_singular : this.props.count + " " + this.props.data.item_type_plural;

		if (this.state.deleting) {
			return (
        <div className="row my-1">
  				<div className="col-sm-4">
  					<EasyEdit
  						type="text"
  						onSave={this.saveLightboxEdit}
  						saveButtonLabel="Save"
  						saveButtonStyle="btn btn-primary btn-sm"
  						cancelButtonLabel="Cancel"
  						cancelButtonStyle="btn btn-primary btn-sm"
  						attributes={{name: "name", id: "lightbox_name" + this.props.data.set_id}}
  						value={this.props.data.label}
  					/>
  				</div>
  				<div className="col-sm-4">{count_text}</div>
  				<div className="col-sm-4 info">
  					<div className="spinner">
  						<div className="bounce1"></div>
  						<div className="bounce2"></div>
  						<div className="bounce3"></div>
  					</div>
  				</div>
  			</div>
       );

		}else if(this.props.data.set_id > 0) {

			if(!this.state.userAccess){

				let that = this;
				getLightboxAccessForCurrentUser(this.context.props.baseUrl, this.props.data.set_id, function(resp) {
					if(resp && resp['ok']) {
						let state = that.state;
						state.userAccess = resp['access'];
						that.setState(state);
						// TODO: For some reason it gives type error when using this.setState
					}
				});
			}

			return(
        <li className="list-group-item">
          <div className="row my-4">
    				<div className="col-sm-12 col-md-6 label">
    					{(this.state.userAccess == 2) ?
                <EasyEdit
      						type="text"
      						onSave={this.saveLightboxEdit}
      						saveButtonLabel="Save"
      						saveButtonStyle="btn btn-primary btn-sm"
      						cancelButtonLabel="Cancel"
      						cancelButtonStyle="btn btn-primary btn-sm"
      						attributes={{name: "name", id: "lightbox_name" + this.props.data.set_id}}
      						value={this.props.data.label}
    					  />
              : this.props.data.label}
    				</div>
  				  <div className="col-sm-6 col-md-3 infoNarrow">{count_text}</div>
  				  <div className="col-sm-6 col-md-3 info text-right">
    					<a href='#' data-set_id={this.props.data.set_id} className='btn btn-secondary btn-sm' onClick={this.openLightbox}>View</a>
    					&nbsp;
    					{(this.state.userAccess == 2) ?
                <a href='#' data-set_id={this.props.data.set_id} className='btn btn-secondary btn-sm' onClick={this.deleteLightboxConfirm}>Delete</a>
               : null}
  				  </div>
  			  </div>
        </li>
      );
		}else{
			return(
        <li className="list-group-item">
          <div className="row my-4">
  					<div className="col-sm-12 col-md-6 label">
    						<EasyEdit ref={this.props.newLightboxRef}
    							type="text"
    							onSave={this.saveNewLightbox}
    							onCancel={this.context.cancelNewLightbox}
    							saveButtonLabel="Save"
    							saveButtonStyle="btn btn-primary btn-sm"
    							cancelButtonLabel="Cancel"
    							cancelButtonStyle="btn btn-primary btn-sm"
    							placeholder="Enter name"
    							attributes={{name: "name", id: "lightbox_name" + this.props.data.set_id}}
    							value={this.props.data.label}
    						/>
  						<div>{this.state.newLightboxError}</div>
  					</div>
  					<div className="col-sm-4 infoNarrow"></div>
  					<div className="col-sm-4 info"></div>
  				</div>
        </li>);
		}
	}
}

export default LightboxListItem;
