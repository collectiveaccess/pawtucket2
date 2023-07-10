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
import { editLightbox, deleteLightbox, createLightbox, getLightboxAccessForCurrentUser } from "../../../../default/js/lightbox";

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
		let id = e.target.attributes.getNamedItem('data-id').value;
		let state = this.context.state;
		state.id = id;

		// if(!state.filters) { state.filters = {}; }
		// if(!state.filters['_search']) { state.filters = {'_search': {}}; }
		// state.filters['_search']['ca_sets.set_id:' + id] = 'Lightbox: ' + state.lightboxList[id].title;

		state.selectedItems = [];
		state.showSelectButtons = false;
		state.paginatedPageNumber = this.props.currentPage;
		state.lightboxSearchValue = this.props.searchValue;
		
		this.context.setState(state);
		this.context.loadLightbox(id);

		let that = this;
		getLightboxAccessForCurrentUser(this.context.props.baseUrl, id, this.context.state.tokens, function(resp) {
			if(resp && (resp['access'] !== undefined)) {
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
		let that = this;
		createLightbox(this.props.baseUrl, this.props.tokens, name, function(resp) {
  		delete(that.context.state.lightboxList[-1]);

  		let lightboxList = that.context.state.lightboxList;
  		lightboxList[resp.id] = {
  			id: resp.id, title: resp.name, count: 0
  		// TODO: add author_lname and created
	  	};
			that.context.setState({lightboxlist: lightboxList});
		});
	}

	saveLightboxEdit(name) {
		let that = this;
		editLightbox(this.context.props.baseUrl, this.context.state.tokens, this.props.data.id, name, function(data) {
			// console.log("saveLightboxEdit ", data);
			// Update name is context state
			let lightboxList = that.context.state.lightboxList;
			lightboxList[that.props.data.id]['title'] == name;
			that.context.setState({lightboxlist: lightboxList});
		});
	}

	deleteLightboxConfirm(e) {
		let that = this;
		confirmAlert({
			customUI: ({ onClose }) => {
				return (
					<div className='col info text-gray'>
						<p>Really delete <em>{this.props.data.title}</em>?</p>
						<div className='button' onClick={() => {
							that.props.deleteCallback(that.props.data);
							onClose(); }}> Yes </div>
						&nbsp;
						<div className='button' onClick={onClose}>No</div>
					</div>
				);
			}
		});
	}

	render(){
		let count_text = (this.props.count == 1) ? this.props.count + " " + this.props.data.content_type_singular : this.props.count + " " + this.props.data.content_type_plural;

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
								attributes={{name: "name", id: "lightbox_name" + this.props.data.id}}
								value={this.props.data.title}
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
		} else if(this.props.data.id > 0) {
			if(!this.state.userAccess){
				let that = this;
				getLightboxAccessForCurrentUser(this.context.props.baseUrl, this.props.data.id, this.context.state.tokens, function(resp) {
					if(resp && (resp['access'] !== undefined)) {
						let state = that.state;
						state.userAccess = resp['access'];
						that.setState(state);
						// TODO: For some reason it gives type error when using this.setState
					}
				});
			}

			return(
        <li className="list-group-item">
          <div className="row my-2">

    				<div className="col-sm-12 col-md-6 label">
    					{(this.state.userAccess == 2) ?
                <EasyEdit
      						type="text"
      						onSave={this.saveLightboxEdit}
      						saveButtonLabel="Save"
      						saveButtonStyle="btn btn-primary btn-sm"
      						cancelButtonLabel="Cancel"
      						cancelButtonStyle="btn btn-primary btn-sm"
      						attributes={{name: "name", id: "lightbox_name" + this.props.data.id}}
      						value={this.props.data.title}
    					  />
              : this.props.data.title}
    				</div>

  				  <div className="col-sm-6 col-md-3 infoNarrow">{count_text}</div>

  				  <div className="col-sm-6 col-md-3 info text-right">
    					<a href='#' data-id={this.props.data.id} className='btn btn-secondary btn-sm' onClick={this.openLightbox}>View</a>
    					&nbsp;
    					{(this.state.userAccess == 2) ?
                <a href='#' data-id={this.props.data.id} className='btn btn-secondary btn-sm' onClick={this.deleteLightboxConfirm}>Delete</a>
              : null}
  				  </div>
						
  			  </div> {/* row-end */}
        </li>
      );
		}else{
			return(
        <li className="list-group-item">
          <div className="row my-2">
  					<div className="col-sm-12 col-md-8 label">
    						<EasyEdit
									ref={this.props.newLightboxRef}
    							type="text"
    							onSave={this.saveNewLightbox}
    							onCancel={this.context.cancelNewLightbox}
    							saveButtonLabel="Save"
    							saveButtonStyle="btn btn-primary btn-sm"
    							cancelButtonLabel="Cancel"
    							cancelButtonStyle="btn btn-primary btn-sm"
    							placeholder="Enter name"
    							attributes={{name: "name", id: "lightbox_name" + this.props.data.id}}
    							value={this.props.data.title}
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
