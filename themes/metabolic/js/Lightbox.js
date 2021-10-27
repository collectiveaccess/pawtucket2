/*jshint esversion: 6 */
import React from "react"
import ReactDOM from "react-dom";
import { fetchLightboxList, loadLightbox, createLightbox, deleteLightbox, newJWTToken, getLightboxAccessForCurrentUser } from "../../default/js/lightbox";

import LightboxNavigation from './Lightbox/LightboxNavigation';
import LightboxIntro from './Lightbox/LightboxIntro';
import LightboxControls from './Lightbox/LightboxControls';
import LightboxResults from './Lightbox/LightboxResults';
import LightboxList from './Lightbox/LightboxList';

const selector = pawtucketUIApps.Lightbox.selector;
const appData = pawtucketUIApps.Lightbox.data;
const refreshToken = pawtucketUIApps.Lightbox.key;
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

		this.state = {
			id: null,    // id of a lightbox

			numLoads: 1,			// total number of results sets we've fetched since loading

			totalSize: null,   // total number of objects within a lightbox

			resultList: null,  // current objects being displayed in a lightbox

      isLoading: false,  // Is a lightbox currently loading more objects

			key: null,
			start: 0,
			itemsPerPage: 24,   // inital number of objects being displayed in a lightbox
			availableFacets: null,
			facetList: null,
			filters: null,
			baseFilters: null,
			selectedFacet: null,

			// introduction: {
			// 	title: null,
			// 	description: null
			// },
			lightboxTitle: null, //Title of a Lightbox

			view: null,
			scrollToResultID: null,
			loadingMore: false,   //No longer being Used?
			hasAutoScrolled: false,

      sortOptions: null, //various options to sort the contents of an individual lightbox
			sort: null,          // Describes what the contents of a lightbox is sorted by
			sortDirection: null, // Ascending or Descending based on the value of sort.

			labelSingular: null,
			labelPlural: null,

			paginatedPageNumber: 1, //the current page of the list of lightboxes
			lightboxSearchValue: '', //the search value for the list of lightboxes

			selectedItems: [],     // id numbers of the selected objects within a lightbox

     	showSelectButtons: false, //checkmark buttons to select a lightbox item
      showSortSaveButton: false, // button appears when the user selected a sort option for the lightbox so they can choose to save that order
			dragDropMode: false,   // is the user currently in drag and drop mode for a lightbox
			userSort: false,       // true if user is customizing their sort, false if using a sort option

      userAccess: null, //null if user has no type of access, 1 if user has read-only access, 2 if user has read-write access

      comments: null,

			// API tokens (JWT)
			tokens: {
				refresh_token: refreshToken,		// from environment
				access_token: null
			}
		};

		this.componentDidMount = this.componentDidMount.bind(this);
		this.loadLightbox = this.loadLightbox.bind(this);
		this.newLightbox = this.newLightbox.bind(this);
		this.cancelNewLightbox = this.cancelNewLightbox.bind(this);
		this.deleteLightbox = this.deleteLightbox.bind(this);
	}

	/**
	 * Load lightbox content with set_id id
	 */
	loadLightbox(id) {
		let that = this;

    getLightboxAccessForCurrentUser(this.props.baseUrl, id, this.state.tokens, function(data) {
      // console.log('Load Lightbox Data: ', data);
      that.setState({userAccess: data.access.access});
    });

		loadLightbox(this.props.baseUrl, this.state.tokens, id, function(data) {
      // console.log('Load Lightbox Data: ', data);
			that.setState({id: id, lightboxTitle: data.title, resultList: data.items, totalSize: data.item_count, sortOptions: data.sortOptions, comments: data.comments});
		}, { start: 0, limit: that.state.itemsPerPage});
	}

	componentDidMount() {
		let that = this;
		let state = this.state;

		// load auth tokens
		newJWTToken(this.props.baseUrl, state.tokens, function(data) {
			state.tokens.access_token = data.data.refresh.jwt;
			that.setState(state);
			
			if(parseInt(that.props.showLastLightboxOnLoad)) {
				that.loadLightbox(parseInt(that.props.showLastLightboxOnLoad));
			}
			fetchLightboxList(that.props.baseUrl, state.tokens, function(data) {
				state.lightboxList = data ? data : {};
				that.setState(state);
			});
		});
	}

  newLightbox() {
    let state = this.state;
    state.lightboxList[-1] = {"id": -1, "label": ""};
    this.setState(state);
  }

  cancelNewLightbox() {
		let state = this.state;
		delete(state.lightboxList[-1]);
		this.setState(state);
	}

	deleteLightbox(lightbox) {
		let state = this.state;
		let that = this;

    deleteLightbox(this.props.baseUrl, state.tokens, lightbox.id, function(data) {
      // console.log("deleteLightbox ", data);
      delete(state.lightboxList[lightbox.id]);
      state.filters = null; // clear filters
      that.setState(state);
    });
	}

	render() {
		let facetLoadUrl = this.props.baseUrl + '/lightbox' + (this.state.key ? '?key=' + this.state.key : '');

		let content = (this.state.id) ? (
			<div>
				<div className="row">
					<div className="col-sm-8 bToolBar pt-4">
						<div className="float-left mr-2"><LightboxNavigation/></div>
            <LightboxIntro lightboxTitle={this.state.lightboxTitle}/>
						<LightboxControls facetLoadUrl={facetLoadUrl}/>
					</div>
				</div>
				<LightboxResults view={this.state.view} sort={this.state.sortBy} facetLoadUrl={facetLoadUrl}/>
			</div>)
			:
			 (<div className="row">
         		<div className="col-sm-12"><LightboxList lightboxes={this.state.lightboxList} paginatedPageNumber={this.state.paginatedPageNumber} searchValue={this.state.lightboxSearchValue}/></div>
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
		<Lightbox
      baseUrl={appData.baseUrl}
      endpoint='getContent'
			initialFilters={appData.initialFilters}
      view={appData.view}
      showLastLightboxOnLoad={appData.showLastLightboxOnLoad}
			browseKey={appData.key}
    />, document.querySelector(selector)
  );
}
