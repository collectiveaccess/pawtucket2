'use strict';
import React from 'react';
import ReactDOM from 'react-dom';
const axios = require('axios');
import {addItemToLightbox, removeItemFromLightbox} from "../../default/js/lightbox";

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const selector = pawtucketUIApps.LightboxManagement.selector;
const appData = pawtucketUIApps.LightboxManagement.data;


class LightboxManagement extends React.Component {
	constructor(props){
		super(props);

		this.state = {lightboxList: this.props.lightboxes};

		this.addToLightbox = this.addToLightbox.bind(this);
		this.removeFromLightbox = this.removeFromLightbox.bind(this);
	}

	addToLightbox(set_id) {
		let that = this;
		addItemToLightbox(this.props.baseUrl, set_id, this.props.id, this.props.table, function(resp) {
			if (resp && resp['ok']) {
				let state = that.state;

				if(set_id === null) {
					state.lightboxList = [{'isMember':1, 'set_id':resp.set_id, 'label': resp.label}];
					that.setState(state);
				}

				for(let i in state.lightboxList) {
					if (state.lightboxList[i]['set_id'] == set_id) {
						state.lightboxList[i]['isMember'] = true;
						that.setState(state);
						break;
					}
				}

				return;
			}
			alert("Could not add item to lightbox: " + resp['err']);
		});
	}

	removeFromLightbox(set_id) {
		let that = this;
		removeItemFromLightbox(this.props.baseUrl, set_id, this.props.id, function(resp) {
			if (resp && resp['ok']) {
				let state = that.state;
				for(let i in state.lightboxList) {
					if (state.lightboxList[i]['set_id'] == set_id) {
						state.lightboxList[i]['isMember'] = false;
						that.setState(state);
						break;
					}
				}
				return;
			}
			alert("Could not remove item from lightbox: " + resp['err']);
		});
	}

	render() {
		let lightboxList = this.state.lightboxList;
		let inLightboxEntries = [], availableLightboxEntries = [];
		for(let i in lightboxList) {
			let entry = <LightboxEntry
				key={lightboxList[i].set_id}
				baseUrl={this.props.baseUrl}
				label={lightboxList[i].label}
				set_id={lightboxList[i].set_id}
				item_id={this.props.id}
				isMember={lightboxList[i].isMember}
				addToLightboxCallback={this.addToLightbox}
				removeFromLightboxCallback={this.removeFromLightbox}
			/>;
			if (lightboxList[i].isMember) {
				inLightboxEntries.push(entry);
			} else {
				availableLightboxEntries.push(entry);
			}
		}
		if ((availableLightboxEntries.length > 0) || (inLightboxEntries.length > 0)) {
			let availableLightboxList = null, inLightboxList = null;
			if (availableLightboxEntries.length > 0) {
				availableLightboxList = (<><div className="dropdown-header">Add to lightbox:</div>{availableLightboxEntries}</>);
			}
			if (inLightboxEntries.length > 0) {
				inLightboxList = (<><div className="dropdown-header">In lightbox:</div>{inLightboxEntries}</>);
			}
			return (
					<div className="dropdown">
							<a className="dropdown-toggle" role="button" id="LightboxButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Add to Lightbox</a>
							<div className="dropdown-menu" aria-labelledby="LightboxButton">
								{availableLightboxList}
								<div className="dropdown-divider"></div>
								{inLightboxList}
							</div>
					</div>
			);
		} else {
			return(<div className="utility-container">
				<div className="utility utility_menu">
					<a href="#" className="trigger collection">&nbsp;</a>
					<div className="options">
						<div className='lightbox_add_remove_list'>
							<div className='eyebrow'>Add to My Documents:</div>
							<LightboxEntry
								key={"new_lightbox"}
								baseUrl={this.props.baseUrl}
								label={"New collection"}
								set_id={null}
								item_id={this.props.id}
								isMember={false}
								addToLightboxCallback={this.addToLightbox}
								removeFromLightboxCallback={this.removeFromLightbox}
							/>
						</div>
					</div>
				</div>
			</div>);
		}
	}
}

class LightboxEntry extends React.Component {
	constructor(props){
		super(props);

		this.addToLightbox = this.addToLightbox.bind(this);
		this.removeFromLightbox = this.removeFromLightbox.bind(this);
	}

	addToLightbox(e) {
		this.props.addToLightboxCallback(this.props.set_id);
		e.preventDefault();
	}

	removeFromLightbox(e) {
		this.props.removeFromLightboxCallback(this.props.set_id);
		e.preventDefault();
	}

	render() {
		if(this.props.set_id === null) {
			return (
				<a href='#' className='dropdown-item' onClick={this.addToLightbox}><ion-icon name="add"></ion-icon> {this.props.label}</a>
			);
		} else if(this.props.isMember) {
			return (
				<a href='#' className='dropdown-item' onClick={this.removeFromLightbox}><ion-icon name="close-circle-outline"></ion-icon> {this.props.label}</a>
			);
		} else {
			return (
				<a href='#' className='dropdown-item' onClick={this.addToLightbox}><ion-icon name="add"></ion-icon> {this.props.label}</a>
			);
		}
	}
}



/**
 * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
	ReactDOM.render(<LightboxManagement baseUrl={appData.baseUrl} lightboxes={appData.lightboxes} table={appData.table} id={appData.id}  />, document.querySelector(selector));
}
