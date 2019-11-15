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
		addItemToLightbox(this.props.baseUrl, set_id, this.props.id, function(resp) {
			if (resp && resp['ok']) {
				let state = that.state;
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
		let lightboxEntries = [];
		for(let i in lightboxList) {
			lightboxEntries.push(<LightboxEntry
				key={lightboxList[i].set_id}
				baseUrl={this.props.baseUrl}
				label={lightboxList[i].label}
				set_id={lightboxList[i].set_id}
				item_id={this.props.id}
				isMember={lightboxList[i].isMember}
				addToLightboxCallback={this.addToLightbox}
				removeFromLightboxCallback={this.removeFromLightbox}
			/>);
		}
		if (lightboxEntries.length > 0) {
			return (
				<div className="block-quarter">
					<div className="eyebrow text-gray">Lightboxes</div>
					<div className="ca-data">
					{lightboxEntries}
					</div>
				</div>
			);
		} else {
			return(<div></div>);
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
		if(this.props.isMember) {
			return (
				<div>
					{this.props.label} <a href='#' onClick={this.removeFromLightbox} className='eyebrow'>(Remove)</a>
				</div>
			);
		} else {
			return (
				<div>
					{this.props.label} <a href='#' onClick={this.addToLightbox} className='eyebrow'>(Add)</a>
				</div>
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

