'use strict';
import React from 'react';
import ReactDOM from 'react-dom';

import { appendItemsToLightbox, removeItemsFromLightbox, appendItemstoNewLightbox, newJWTToken } from "../../default/js/lightbox";

const selector = pawtucketUIApps.LightboxManagement.selector;
const appData = pawtucketUIApps.LightboxManagement.data;
const lightboxTerminology = appData.lightboxTerminology;

//*
// console.log("LM: PUIApps", pawtucketUIApps.LightboxManagement);
const baseUrl = pawtucketUIApps.LightboxManagement.data.baseUrl;
const refreshToken = pawtucketUIApps.LightboxManagement.key;

class LightboxManagement extends React.Component {
	constructor(props){
		super(props);
		this.state = {lightboxList: this.props.lightboxes, statusMessage: null, 
			// API tokens (JWT)
			tokens: {
				refresh_token: refreshToken,		// from environment
				access_token: null
			}
		};

		this.addToLightbox = this.addToLightbox.bind(this);
		this.addToNewLightbox = this.addToNewLightbox.bind(this);
		this.removeFromLightbox = this.removeFromLightbox.bind(this);
	}

	componentDidMount(){
		let that = this;
		let state = this.state;

		// load auth tokens
		newJWTToken(baseUrl, this.state.tokens, function (data) {
			console.log("newJWTToken Data: ", data);
			state.tokens.access_token = data.data.refresh.jwt;
			that.setState(state);
		});
	}


	//-------------NEW CODE-----------------------

	addToLightbox(set_id) {
		let that = this;
		let object_id = this.props.id;
		appendItemsToLightbox(baseUrl, this.state.tokens, parseInt(set_id), object_id.toString() , function (data) {
			let state = that.state;

			if (set_id === null) {
				state.lightboxList[state.lightboxList.length] = { 'isMember': true, 'set_id': data.set_id, 'label': data.label };
				that.setState(state);
			}
			for (let i in state.lightboxList) {
				if (state.lightboxList[i]['set_id'] == set_id) {
					state.lightboxList[i]['isMember'] = true;
					that.setState(state);
					break;
				}
			}
			state.statusMessage = "Added Item To " + lightboxTerminology.singular;
			that.setState(state);
			setTimeout(function () {
				state.statusMessage = '';
				that.setState(state);
			}, 2000);
			return;
		
		});
	}

	addToNewLightbox(set_id) {
		let that = this;
		let object_id = this.props.id;
		appendItemstoNewLightbox(baseUrl, that.state.tokens, "New Lightbox", object_id.toString(), function (data) {
			console.log("appendItemstoNewLightbox: ", data);
			let state = that.state;

			if (set_id === null) {
				state.lightboxList[state.lightboxList.length] = { 'isMember': true, 'set_id': data.id, 'label': data.name };
				that.setState(state);
			}
			for (let i in state.lightboxList) {
				if (state.lightboxList[i]['set_id'] == data.id) {
					state.lightboxList[i]['isMember'] = true;
					that.setState(state);
					break;
				}
			}
			state.statusMessage = "Added Item To " + lightboxTerminology.singular;
			that.setState(state);
			setTimeout(function () {
				state.statusMessage = '';
				that.setState(state);
			}, 2000);
			return;

		});
	}

	removeFromLightbox(set_id) {
		let that = this;
		let object_id = this.props.id;
		removeItemsFromLightbox(baseUrl, this.state.tokens, parseInt(set_id), object_id.toString(), function (data) {
			let state = that.state;
			state.statusMessage = "Removed Item From " + lightboxTerminology.singular;
			setTimeout(function () {
				state.statusMessage = '';
				that.setState(state);
			}, 2000);
			for (let i in state.lightboxList) {
				if (state.lightboxList[i]['set_id'] == set_id) {
					state.lightboxList[i]['isMember'] = false;
					that.setState(state);
					break;
				}
			}
			return;
		});
	}


	//--------------------------------------------

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
				addToNewLightboxCallback={this.addToNewLightbox}
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
				availableLightboxList = (<><div className="dropdown-header">Add to {lightboxTerminology.singular}:</div>{availableLightboxEntries}</>);
			}
			if (inLightboxEntries.length > 0) {
				inLightboxList = (<><div className="dropdown-header">In {lightboxTerminology.singular}:</div>{inLightboxEntries}</>);
			}
			return (
					<div className="dropdown">
							{(this.state.statusMessage) ? <a><ion-icon name="alert"></ion-icon> <b>{this.state.statusMessage}</b></a> : <a className="dropdown-toggle" role="button" id="LightboxButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Add to {lightboxTerminology.singular}</a>}
							<div className="dropdown-menu" aria-labelledby="LightboxButton">
								{availableLightboxList}
								{(availableLightboxList) ? <div className="dropdown-divider"></div> : null}
								<div className="dropdown-header">Add to new {lightboxTerminology.singular}:</div>
								<LightboxEntry
									key={"new_lightbox"}
									baseUrl={this.props.baseUrl}
									label={"New" + lightboxTerminology.singular}
									set_id={null}
									item_id={this.props.id}
									isMember={false}
									addToLightboxCallback={this.addToLightbox}
									addToNewLightboxCallback={this.addToNewLightbox}
									removeFromLightboxCallback={this.removeFromLightbox}
								/>
								{(inLightboxList) ? <div className="dropdown-divider"></div> : null}
								{inLightboxList}
							</div>
					</div>
			);
		} else {
			return(
				<div className="dropdown">
							<a className="dropdown-toggle" role="button" id="LightboxButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Add to {lightboxTerminology.singular}</a>
							<div className="dropdown-menu" aria-labelledby="LightboxButton">
								<div className="dropdown-header">Add to new {lightboxTerminology.singular}:</div>
								<LightboxEntry
									key={"new_lightbox"}
									baseUrl={this.props.baseUrl}
									label={"New " + lightboxTerminology.singular}
									set_id={null}
									item_id={this.props.id}
									isMember={false}
									addToLightboxCallback={this.addToLightbox} 
									addToNewLightboxCallback={this.addToNewLightbox}
									removeFromLightboxCallback={this.removeFromLightbox}
								/>
							</div>
					</div>
				);
		}
	}
}

class LightboxEntry extends React.Component {
	constructor(props){
		super(props);

		this.addToLightbox = this.addToLightbox.bind(this);
		this.addToNewLightbox = this.addToNewLightbox.bind(this);
		this.removeFromLightbox = this.removeFromLightbox.bind(this);
	}

	addToLightbox(e) {
		this.props.addToLightboxCallback(this.props.set_id);
		e.preventDefault();
	}

	addToNewLightbox(e) {
		this.props.addToNewLightboxCallback(this.props.set_id);
		e.preventDefault();
	}

	removeFromLightbox(e) {
		this.props.removeFromLightboxCallback(this.props.set_id);
		e.preventDefault();
	}

	render() {
		if(this.props.set_id === null) {
			return (
				<a href='#' className='dropdown-item' onClick={this.addToNewLightbox}><ion-icon name="add"></ion-icon> {this.props.label}</a>
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
