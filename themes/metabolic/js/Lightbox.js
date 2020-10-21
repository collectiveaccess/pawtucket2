/*jshint esversion: 6 */
import React from "react"
import ReactDOM from "react-dom";
import { initBrowseContainer } from "../../default/js/browse";
import { fetchLightboxList, addLightbox, deleteLightbox, removeItemFromLightbox } from "../../default/js/lightbox";
// import ClampLines from 'react-clamp-lines';

import LightboxNavigation from './Lightbox/LightboxNavigation';
import LightboxIntro from './Lightbox/LightboxIntro';
import LightboxControls from './Lightbox/LightboxControls';
import LightboxResults from './Lightbox/LightboxResults';
import LightboxList from './Lightbox/LightboxList';

const selector = pawtucketUIApps.Lightbox.selector;
const appData = pawtucketUIApps.Lightbox.data;
const lightboxTerminology = appData.lightboxTerminology;

/**
 * Component context making Lightbox internals accessible to all subcomponents
 *
 * @type {React.Context}
 */
export const LightboxContext = React.createContext();

/**
 * Top-level container for lightbox interface. Is values for context LightboxContext.
 *
 * Props are:
 * 		baseUrl : Base Url to browse web service
 *		initialFilters : Optional dictionary of filters to apply upon load
 *		view : Optional results view specifier
 * 		browseKey : Optional browse cache key. If supplied the initial load state will be the referenced browse criteria and result set.
 *
 * Sub-components are:
 * 		LightboxIntro
 * 		LightboxControls
 * 		LightboxResults
 * 		LightBoxNavigation
 * 		LightboxList
 */
class Lightbox extends React.Component{
	constructor(props) {
		super(props);
		let that = this;

		this.dontUseDefaultKey =  !props.showLastLightboxOnLoad;	// try to display by default last lightbox on load?

		initBrowseContainer(this, props, !this.dontUseDefaultKey, function(d) {
			// If loading with last lightbox visible by default then try to set set_id state after initial load
			if (d.filters['_search']) {
				let state = that.state;
				let vals = Object.values(d.filters['_search']);
				for(let i in vals) {
					let m = vals[i].match(/^ca_sets\.set_id:([\d]+)$/);
					if(m && (parseInt(m[1]) > 0)) {
						state['set_id'] = parseInt(m[1]);
					}
				}
				that.setState(state);
			}
		});

		this.state['set_id'] = props.showLastLightboxOnLoad ? -1 : null;
		this.state['filters'] = null;
		this.state.selectedItems = [];

		this.state.dragDropMode = false;
		this.state.userSort = true;
		this.state.showSortSaveButton = false;

		this.componentDidMount = this.componentDidMount.bind(this);
		this.newLightbox = this.newLightbox.bind(this);
		this.cancelNewLightbox = this.cancelNewLightbox.bind(this);
		this.saveNewLightbox = this.saveNewLightbox.bind(this);
		this.deleteLightbox = this.deleteLightbox.bind(this);

		this.removeItemFromLightbox = this.removeItemFromLightbox.bind(this);

	}

	componentDidMount() {
		let that = this;
		fetchLightboxList(this.props.baseUrl, function(data) {
			let state = that.state;
			state.lightboxList = data ? data : {};
			that.setState(state);
		});
	}

	removeItemFromLightbox(e) {
		let that = this;
		if(!this.state.set_id) { return; }

		let item_id = e.target.attributes.getNamedItem('data-item_id').value;
		if(!item_id) { return; }
		removeItemFromLightbox(this.props.baseUrl, this.state.set_id, item_id, function(resp) {
			if(resp && resp['ok']) {
				let state = that.state;
				for(let i in state.resultList) {
					let r = state.resultList[i];
					if (r.id == item_id) {
						delete(state.resultList[i]);
						state.resultSize--;
						let x = null;
						x = state.selectedItems.indexOf(item_id);
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
		});
	}

	newLightbox(e) {
		let state = this.state;
		state.lightboxList.sets[-1] = {"set_id": -1, "label": ""};
		this.setState(state);

		e.preventDefault();
	}

	cancelNewLightbox(e) {
		let state = this.state;
		delete(state.lightboxList.sets[-1]);
		this.setState(state);
	}

	saveNewLightbox(data, callback) {
		let that = this;
		addLightbox(this.props.baseUrl, {'name': data['name'], 'table': 'ca_objects'}, function(resp) {
			if(resp['ok']) {
				let state = that.state;
				delete(state.lightboxList.sets[-1]);
				state.lightboxList.sets[resp.set_id] = { set_id: resp.set_id, label: resp.name, count: 0, item_type_singular: resp.item_type_singular, item_type_plural: resp.item_type_plural };
				that.setState(state);
			}
			callback(resp);
		});
	}

	deleteLightbox(lightbox) {
		let state = this.state;
		let that = this;

		if(state.lightboxList && state.lightboxList.sets) {
			deleteLightbox(this.props.baseUrl, lightbox.set_id, function(resp) {
				if(resp && resp.ok) {
					delete(state.lightboxList.sets[lightbox.set_id]);
					state.filters = null; // clear filters
					that.setState(state);
				}
			});
		}
	}

	render() {
		let facetLoadUrl = this.props.baseUrl + '/' + this.props.endpoint + (this.state.key ? '/key/' + this.state.key : '');

		let content = (this.state.set_id) ? (
			<div>
				<div className="row">
					<div className="col-sm-8 bToolBar pt-4">
						<div className="float-left mr-2">
              				<LightboxNavigation/>
            			</div>
            			<LightboxIntro headline={this.state.introduction.title} description={this.state.introduction.description}/>
						<LightboxControls facetLoadUrl={facetLoadUrl}/>
					</div>
				</div>
				<LightboxResults view={this.state.view} sort={this.state.sortBy} facetLoadUrl={facetLoadUrl}/>
			</div>)
			:
			 (<div className="row">
         		<div className="col-sm-12"><LightboxList lightboxes={this.state.lightboxList}/></div>
        </div>);

		return(
			<LightboxContext.Provider value={this}>
					{content}
			</LightboxContext.Provider>
		);
	}
}

/**
 * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
	ReactDOM.render(
		<Lightbox baseUrl={appData.baseUrl} endpoint='getContent'
							  initialFilters={appData.initialFilters} view={appData.view} showLastLightboxOnLoad={appData.showLastLightboxOnLoad}
							  browseKey={appData.key}/>, document.querySelector(selector));
}
