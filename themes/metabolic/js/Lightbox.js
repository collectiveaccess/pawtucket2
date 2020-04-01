/*jshint esversion: 6 */
import React from "react"
import ReactDOM from "react-dom";
import EasyEdit from 'react-easy-edit';
import { confirmAlert } from 'react-confirm-alert';
import 'react-confirm-alert/src/react-confirm-alert.css';

import { initBrowseContainer, initBrowseCurrentFilterList, initBrowseFilterList, initBrowseFacetPanel, initBrowseResults } from "../../default/js/browse";
import { fetchLightboxList, addLightbox, editLightbox, deleteLightbox, removeItemFromLightbox, getLightboxAccessForCurrentUser } from "../../default/js/lightbox";
import { CommentForm, CommentFormMessage, CommentsTagsList } from "./comment";

import ClampLines from 'react-clamp-lines';

const axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const selector = pawtucketUIApps.Lightbox.selector;
const appData = pawtucketUIApps.Lightbox.data;
const lightboxTerminology = appData.lightboxTerminology;
/**
 * Component context making Lightbox internals accessible to all subcomponents
 *
 * @type {React.Context}
 */
const LightboxContext = React.createContext();

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
						<div className="float-left mr-2"><LightboxNavigation/></div><LightboxIntro headline={this.state.introduction.title} description={this.state.introduction.description}/>
						<LightboxControls facetLoadUrl={facetLoadUrl}/>
					</div>
				</div>
				<LightboxResults view={this.state.view} sort={this.state.sortBy} facetLoadUrl={facetLoadUrl}/>
			</div>)
			:
			(<div className="row"><div className="col-sm-12"><LightboxList lightboxes={this.state.lightboxList}/></div></div>);
		return(
			<LightboxContext.Provider value={this}>
					{content}
			</LightboxContext.Provider>
		);
	}
}

/**
 *
 */
class LightboxNavigation extends React.Component{
	static contextType = LightboxContext;
	constructor(props) {
		super(props);

		this.backToList = this.backToList.bind(this);
	}

	backToList(e) {
		let state = this.context.state;

		state.set_id = null; // clear set
		state.filters = null; // clear filters
		state.introduction.title = null;

		this.context.setState(state);
	}
	render() {
		return(
			<a href='#' className='btn btn-secondary' onClick={this.backToList}><ion-icon name='ios-arrow-back'></ion-icon></a>
		);
	}
}

/**
 * Renders buttons to switch views cofigured in browse.conf
 *
 * Props are:
 * 		view : view format to use for display of results
 *
 * Used by:
 *  	LightboxControls
 *
 * Uses context: LightboxContext
 */
class LightboxViewList extends React.Component {
	static contextType = LightboxContext;

	render() {
		let viewButtonOptions = ["images", "list"]; // make this come from browse.conf
		let viewButtonIcons = {
								"images" : "<ion-icon name='apps'></ion-icon>",
								"list" : "<ion-icon name='ios-list-box'></ion-icon>"
							}
		let viewButtonList = [];
		if(viewButtonIcons) {
			for (let i in viewButtonIcons) {
				let b = viewButtonIcons.i;
				viewButtonList.push(<a href='#' className='disabled' key={i} dangerouslySetInnerHTML={{__html: viewButtonIcons[i]}}></a>);
			}
		}

		return (
			<div id="bViewButtons">{viewButtonList}</div>
		);
	}
}

/**
 * Renders select options
 *
 * Props are:
 * 		
 *
 * Used by:
 *  	LightboxControls
 *
 * Uses context: LightboxContext
 */
class LightboxSelectItemsOptions extends React.Component {
	static contextType = LightboxContext;

	constructor(props) {
		super(props);
		this.clearSelectLightboxItems = this.clearSelectLightboxItems.bind(this);
		this.showSelectButtons = this.showSelectButtons.bind(this);
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
	
	render() {
		return (
			<div id="bSelectOptions">
				<div className="dropdown show">
					<a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<ion-icon name="checkmark-circle-outline"></ion-icon>
					</a>

					<div className="dropdown-menu" aria-labelledby="dropdownMenuLink">
						{(this.context.state.showSelectButtons) ? <a className="dropdown-item" onClick={this.clearSelectLightboxItems}>Clear selection</a> : <a className="dropdown-item" onClick={this.showSelectButtons}>Select items</a> }
					</div>
				</div>
			</div>

		);
	}

}
/**
 * Renders export options
 *
 * Props are:
 * 		
 *
 * Used by:
 *  	LightboxControls
 *
 * Uses context: LightboxContext
 */
class LightboxExportOptions extends React.Component {
	static contextType = LightboxContext;
	constructor(props) {
		super(props);
	}
	
	render() {
		let exportOptions = [];
		let exportFormats = null;
		exportFormats = appData.exportFormats;
		if(exportFormats) {
			for (let i in exportFormats) {
				let r = exportFormats[i];
				exportOptions.push(<a className="dropdown-item" href={appData.baseUrl + '/getContent/getResult/1/download/1/view/' + r.type + '/export_format/' + r.code + '/key/' + this.context.state.key} key={i}>{r.name}</a>);
			}
		}
		if(this.context.state.selectedItems.length == 0){
			exportOptions.push(<a className="dropdown-item" href={appData.baseUrl + '/getSetMedia/set_id/' + this.context.state.set_id + '/key/' + this.context.state.key + '/sort/' + this.context.state.sort + '/sort_direction/' + this.context.state.sortDirection} key='dlMedia'>Download media</a>);
		}else{
			exportOptions.push(<a className="dropdown-item" href={appData.baseUrl + '/getSetMedia/set_id/' + this.context.state.set_id + '/record_ids/' + this.context.state.selectedItems.join(';')} key='dlMedia'>Download selected media</a>);
		}
		return (
			<div id="bExportOptions">
				<div className="dropdown show">
					<a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<ion-icon name="download"></ion-icon>
				  </a>

				  <div className="dropdown-menu" aria-labelledby="dropdownMenuLink">
					{exportOptions}
				  </div>
				</div>
			</div>
		);
	}

}

/**
 * Renders sort options
 *
 * Props are:
 * 		
 *
 * Used by:
 *  	LightboxControls
 *
 * Uses context: LightboxContext
 */
class LightboxSortOptions extends React.Component {
	static contextType = LightboxContext;

	constructor(props) {
		super(props);
		
		this.handleSort = this.handleSort.bind(this);
	}
	handleSort(e){
		let sort = e.target.attributes.getNamedItem('data-sort').value;
		let direction = e.target.attributes.getNamedItem('data-direction').value;
		this.context.sortResults(sort, direction);
		e.preventDefault();
	}
	render() {
		let sortOptions = [];
		let sortConfig = [];
		//let sortDirection = [];
		sortConfig = appData.browseConfig.sortBy;
		//sortDirection = browseConfig.sortDirection;
		if(sortConfig) {
			for (let i in sortConfig) {
				let r = sortConfig[i];
				let sortLinkText = "";
				let sortLinkActive = "";
				sortLinkText = ((this.context.state.sort == i) && (this.context.state.sortDirection == "asc")) ? <b>{i}  <ion-icon name="arrow-up"></ion-icon></b> : <>{i} <ion-icon name='arrow-up'></ion-icon></>;
				sortLinkActive = ((this.context.state.sort == i) && (this.context.state.sortDirection == "asc")) ? "active" : null;
				sortOptions.push(<a className={((this.context.state.sort == i) && (this.context.state.sortDirection == "asc")) ? "dropdown-item active" : "dropdown-item"} href="#" onClick={this.handleSort} data-sort={i} data-direction="asc" key={r + "asc"}>{sortLinkText}</a>);
				sortLinkText = ((this.context.state.sort == i) && (this.context.state.sortDirection == "desc")) ? <b>{i} <ion-icon name='arrow-down'></ion-icon></b> : <>{i} <ion-icon name='arrow-down'></ion-icon></>;
				sortOptions.push(<a className={((this.context.state.sort == i) && (this.context.state.sortDirection == "desc")) ? "dropdown-item active" : "dropdown-item"} href="#" onClick={this.handleSort} data-sort={i} data-direction="desc" key={r + "desc"}>{sortLinkText}</a>);
			}
		}
		return (
			<div id="bSortOptions">
				<div className="dropdown show">
					<a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<ion-icon name="funnel"></ion-icon>
				  </a>

				  <div className="dropdown-menu" aria-labelledby="dropdownMenuLink">
					{sortOptions}
				  </div>
				</div>
			</div>
		);
	}
}
/**
 * Archive browse collection information panel
 *
 * Props are:
 * 		headline : browse inteface headline (Ex. "Photography Collection")
 * 		description : descriptive text for the browse (Eg. text about the collection)
 *
 * Sub-components are:
 * 		<NONE>
 */
class LightboxIntro extends React.Component {
	static contextType = LightboxContext;
	constructor(props) {
		super(props);
	}

	render() {
		if (!this.props.headline || (this.props.headline.length === 0)) {
			return (<section></section>);
		}else{
			this.context.state.headline = this.props.headline;
			this.context.state.description = this.props.description;
		}
		return (<h1>{lightboxTerminology.section_heading}: {this.props.headline}</h1>)
	}
}

/**
 * Browse result statistics display. Stats include a # results found indicator. May embed other
 * stats such as a list of currently applied browse filters (via LightboxCurrentFilterList)
 *
 * Props are:
 * 		<NONE>
 *
 * Sub-components are:
 * 		LightboxCurrentFilterList
 *
 * Uses context: LightboxContext
 */
class LightboxStatistics extends React.Component {
	static contextType = LightboxContext;
	constructor(props) {
		super(props);

	}

	render() {
		if (this.context.state.resultSize === 0) {
			return(<h2 className="my-2">No Items</h2>);
		}else{
			return(
				<h2 className="my-2">{(this.context.state.resultSize !== null) ? ((this.context.state.resultSize== 1) ?
					"1 Item" : this.context.state.resultSize + " Items") : <div className="text-center">Loading...</div>}</h2>
			);
		}
	}
}

/**
 * Display of current browse filters. Each filter includes a delete-filter button.
 *
 * Props are:
 * 		<NONE>
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 * 		LightboxCurrentFilterList
 *
 * Uses context: LightboxContext
 */
class LightboxCurrentFilterList extends React.Component {
	static contextType = LightboxContext;

	constructor(props) {
		super(props);

		initBrowseCurrentFilterList(this);
	}

	render() {
		let filterList = [];
		if(this.context.state.filters) {
			for (let f in this.context.state.filters) {
				let cv =  this.context.state.filters[f];
				for(let c in cv) {
					let label = cv[c];
					let m = label.match(/^ca_sets\.set_id:([\d]+)$/);
					if (!m){
						filterList.push((<a key={ f + '_' + c } href='#' onClick={this.removeFilter}
							  data-facet={f}
							  data-value={c}><button type='button' className='btn btn-primary btn-sm' data-facet={f} data-value={c}>{label} <ion-icon name='close-circle' data-facet={f} data-value={c}></ion-icon></button></a>));
					}
				}
			}
		}
		return(
			<div>{filterList}</div>
		);
	}
}

/**
 * Container for display and editing of applied browse filters. This component provides
 * markup wrapping both browse statistics (# of results found) (component <LightboxStatistics>
 * as well as the list of available browse facets (component <LightboxFacetList>).
 *
 * Props are:
 * 		facetLoadUrl : URL to use to load facet content
 *
 * Sub-components are:
 * 		LightboxStatistics
 * 		LightboxFacetList
 *
 * Uses context: LightboxContext
 */
class LightboxControls extends React.Component {
	static contextType = LightboxContext;

	constructor(props) {
		super(props);
	}
	
	render() {
		let c  = (this.context.state.resultSize === null);
		return(<div className="row">
					<div className="col-md-6"><LightboxStatistics/></div>
					<div className="col-md-6">
						
{/* view doesn't work yet
						<LightboxViewList/>
*/}
						<LightboxExportOptions/>
						<LightboxSortOptions/>
						<LightboxSelectItemsOptions/>
					</div>
				</div>);
	}
}

/**
 * List of available facets. Wraps both facet buttons, and the panel allowing selection of facet values for
 * application as browse filters. Each facet button is implemented using component <LightboxFacetButton>.
 * The facet panel is implemented using component <LightboxFacetPanel>.
 *
 * Props are:
 * 		facetLoadUrl : URL to use to load facet content
 *
 * Sub-components are:
 * 		LightboxFacetButton
 * 		LightboxFacetPanel
 *
 * Uses context: LightboxContext
 */
class LightboxFacetList extends React.Component {
	static contextType = LightboxContext;

	constructor(props) {
		super(props);
		initBrowseFilterList(this, props);
	}

	render() {
		let facetButtons = [];
		//let filterLabel = this.context.state.availableFacets ? "Filter By " : "";
		
		this.facetPanelRefs = {};
		if (this.context.state.availableFacets) {
			for (let n in this.context.state.availableFacets) {
				this.facetPanelRefs[n] = React.createRef();
			}
		}

		if(this.context.state.availableFacets) {
			for (let n in this.context.state.availableFacets) {
				if(!this.facetPanelRefs || !this.facetPanelRefs[n]) { continue; }
				let isOpen = ((this.context.state.selectedFacet !== null) && (this.context.state.selectedFacet === n)) ? 'true' : 'false';

				// Facet button-and-panel assemblies. Each button is paired with a panel it controls
				facetButtons.push((<div key={"facet_panel_container_" + n}>
					<LightboxFacetButton key={"facet_panel_button_" + n} text={this.context.state.availableFacets[n].label_plural}
																	name={n} callback={this.toggleFacetPanel}/>

						<LightboxFacetPanel key={"facet_panel_" + n} open={isOpen} facetName={n}
												   facetLoadUrl={this.props.facetLoadUrl} ref={this.facetPanelRefs[n]}
												   loadResultsCallback={this.context.loadResultsCallback}
												   closeFacetPanelCallback={this.closeFacetPanel}
												   arrowPosition={this.state.arrowPosition}/>
					</div>
				));
			}
			//if(facetButtons.length == 0){
			//	filterLabel = "";
			//}
		}


		if(this.context.state.availableFacets){
			return(
				<div>
					<div className='bRefineFacets'>{facetButtons}</div>
				</div>
			)
		}else{
			return(
				" "
			)
		}
	}
}

/**
 * Implements a facet button. Clicking on the button triggers an action for the represented facet (Eg. open
 * a panel displaying all facet values)
 *
 * Props are:
 * 		name : Facet code; used when applying filter values from this facet.
 * 		text : Display name for facet; used as text of button
 * 		callback : Method to call when filter is clicked
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 *  	LightboxFacetList
 */
class LightboxFacetButton extends React.Component {
	render() {
		return(
			<label data-option={this.props.name} onClick={this.props.callback} role='button' aria-expanded='false' aria-controls='collapseFacet'>{this.props.text}</label>
		);
	}
}

/**
 * Visible on-demand panel containing facet values and UI to select and apply values as browse filters.
 * A panel is created for each available facet.
 *
 * Props are:
 * 		open : controls visibility of panel; if set to a true value, or the string "true"  panel is visible.
 * 	  	facetName : Name of facet this panel will display
 * 	  	facetLoadUrl : URL used to load facet
 * 	  	ref : A ref for this panel
 * 	  	loadResultsCallback : Function to call when new filter are applied
 * 	  	closeFacetPanelCallback : Function to call when panel is closed
 *		arrowPosition : Horizontal coordinate to position facet arrow at. This will generally be at the point where the facet was clicked.
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 *  	LightboxFacetList
 *
 * Uses context: LightboxContext
 */
class LightboxFacetPanel extends React.Component {
	static contextType = LightboxContext;
	constructor(props) {
		super(props);
		initBrowseFacetPanel(this, props);
	};

	render() {
		let styles = {
			display: JSON.parse(this.props.open) ? 'block' : 'none'
		};

		let options = [], applyButton = null;
		if(this.state.facetContent) {
			// Render facet options when available
			for (let i in this.state.facetContent) {
				let item = this.state.facetContent[i];

				options.push((
					<div className="col-sm-12 col-md-4 bRefineFacetItem py-2" key={'facetItem' + i}>
						<LightboxFacetPanelItem id={'facetItem' + i} data={item} callback={this.clickFilterItem} selected={this.state.selectedFacetItems[item.id]}/>
					</div>
				));
			}
			applyButton = (options.length > 0) ? (<div className="col-sm-12 text-center my-3">
				<a className="btn btn-primary btn-sm" href="#" onClick={this.applyFilters}>Apply</a>
			</div>) : "";
		} else {
			// Loading message while fetching facet
			options.push(<div key={"facet_loading"} className="col-sm-12 text-center">Loading...</div>);
		}

		return(<div style={styles}>
					<div className="container">
						<div className="row bRefineFacet" data-values="type_facet">
							{options}
						</div>
						<div className="row">
							{applyButton}
						</div>
					</div>
			</div>);
	}
}

/**
 * Renders an individual item
 *
 * Props are:
 * 		id : item id; used as CSS id
 * 		data : object containing data for item; must include values for "id" (used as item value), "label" (display label) and "content_count" (number of results returned by this item)
 * 	    selected : render item as selected?
 * 	    callback : function to check when item is selected or unselected
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 *  	LightboxFacetPanel
 *
 * Uses context: LightboxContext
 */
class LightboxFacetPanelItem extends React.Component {
	static contextType = LightboxContext;

	constructor(props) {
		super(props);
	}

	render() {
		let { id, data } = this.props;
		let count = (data.content_count > 0) ? '(' + data.content_count + ')' : '';
		return(<>
			<input id={id} value={data.id} data-label={data.label} type="checkbox" name="facets[]" checked={this.props.selected} onChange={this.props.callback}/>
			<label htmlFor={id}>
				{data.label} &nbsp;
				<span className="number">{count}</span>
			</label>
		</>);
	}
}

/**
 * Renders search results using a LightboxResultItem component for each result.
 * Includes navigation to load openitional pages on-demand.
 *
 * Sub-components are:
 * 		LightboxResultItem
 * 		LightboxResultLoadMoreButton
 *
 * Props are:
 * 		view : view format to use for display of results
 *
 * Used by:
 *  	Lightbox
 *
 * Uses context: LightboxContext
 */
class LightboxResults extends React.Component {
	static contextType = LightboxContext;

	constructor(props) {
		super(props);

		initBrowseResults(this, props);
	}

	render() {
		let resultList = [];
		if(this.context.state.resultList && (this.context.state.resultList.length > 0)) {
			for (let i in this.context.state.resultList) {
				let r = this.context.state.resultList[i];
				resultList.push(<LightboxResultItem view={this.props.view} key={r.id} data={r}/>)
			}
		}

		switch(this.props.view) {
			default:
				return (
					<div className="row"  id="browseResultsContainer">
							<div className="col-md-8 bResultList">
								<div className="row">
									{resultList}
								</div>
								<LightboxResultLoadMoreButton start={this.context.state.start}
															 itemsPerPage={this.context.state.itemsPerPage}
															 size={this.context.state.resultSize}
															 loadMoreHandler={this.context.loadMoreResults}
															 loadMoreRef={this.context.loadMoreRef}/>	
							</div>
							<div className="col-md-4 col-lg-3 offset-lg-1">
								<div className="bRightCol position-fixed vh-100 mr-3">
									<div id="accordion">
										<div className="card">
											<div className="card-header">
												<a data-toggle="collapse" href="#bRefine" role="button" aria-expanded="false" aria-controls="collapseFilter">Filter By</a>
											</div>
											<div id="bRefine" className="card-body collapse" data-parent="#accordion">
												<LightboxCurrentFilterList/>
												<LightboxFacetList facetLoadUrl={this.props.facetLoadUrl}/>
											</div>
										</div>
										<div className="card">
											<div className="card-header">
												<a data-toggle="collapse" href="#setComments" role="button" aria-expanded="false" aria-controls="collapseComments">Comments</a>
											</div>
											<div id="setComments" className="card-body collapse" data-parent="#accordion">
												<CommentForm tableName="ca_sets" itemID={this.context.state.set_id} formTitle="" listTitle="" commentFieldTitle="" tagFieldTitle="" loginButtonText="login" commentButtonText="Add" noTags="1" showForm="1" />
											</div>
										</div>
										<div className="card">
											<div className="card-header">
												<a data-toggle="collapse" href="#setShare" role="button" aria-expanded="false" aria-controls="collapseShare">Share</a>
											</div>
											<div id="setShare" className="card-body collapse" data-parent="#accordion">
												<ShareBlock setID={this.context.state.set_id} />
											</div>
										</div>
									</div>
									<div className="forceWidth">- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</div>
								</div>
							</div>
						
					</div>
				);
				break;
		}
	}
}

/**
 * Button triggering load of next page of results.
 *
 * Props are:
 * 		start : Offset in result set to begin display of results from. Defaults to 0 (start of result set).
 * 		itemsPerPage : Maximum number of items to load.
 * 		size : Total size of current result set.
 * 		loadMoreHandler : Function to call when clicked. Function should trigger load of results page and alter browse results state.
 * 		loadMoreRef : Ref to apply to load more button. Enables setting of "loading" text while results request is pending.
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 *  	LightboxResults
 *
 * Uses context: LightboxContext
 */
class LightboxResultLoadMoreButton extends React.Component {
	static contextType = LightboxContext;

	render() {
		if (((this.props.start + this.props.itemsPerPage) < this.props.size) || (this.context.state.resultSize  === null)) {
			let loadingText = (this.context.state.resultSize === null) ? "LOADING" : "Load More";

			return (<div className="row bLoadMore"><div className="col-sm-12 text-center my-3">
				<a className="button btn btn-primary" href="#" onClick={this.props.loadMoreHandler} ref={this.props.loadMoreRef}>{loadingText}</a>
				</div></div>);
		} else {
			return(<span></span>)
		}
	}
}

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
 *  	LightboxResults
 */
class LightboxResultItem extends React.Component {
	static contextType = LightboxContext;

	constructor(props) {
		super(props);	
		
		this.selectLightboxItem = this.selectLightboxItem.bind(this);
	}

	selectLightboxItem(e) {
		
		let state = this.context.state;
		let item_id = parseInt(e.target.attributes.getNamedItem('data-item_id').value);
		if(!item_id) { return; }
		let i = null;
		i = state.selectedItems.indexOf(item_id);
		if(i > -1){
			state.selectedItems.splice(i, 1);
		}else{
			state.selectedItems.push(item_id);
		}
		this.context.setState(state);
		console.log("selectedItems: " + item_id + " : " + this.context.state.selectedItems.indexOf(item_id), this.context.state.selectedItems);
	}

	render() {
		let data = this.props.data;
		switch(this.props.view) {
			default:
				return(
					<div className="col-sm-6 col-md-3">
						<div className={'card mb-4 bResultImage' + ((this.context.state.selectedItems.includes(data.id)) ? ' selected' : '')} ref={this.props.scrollToRef}>
							<a href={data.detailUrl}><div dangerouslySetInnerHTML={{__html: data.representation}}/></a>
							{(this.context.state.showSelectButtons) ? <div className='float-left'><a onClick={this.selectLightboxItem} data-item_id={data.id} className={'selectItem' + ((this.context.state.selectedItems.includes(data.id)) ? ' selected' : '')} role='button' aria-expanded='false' aria-controls='Select item'><ion-icon name='checkmark-circle' data-item_id={data.id}></ion-icon></a></div> : null}
							{(this.context.state.userAccess == 2) ? <div className='float-right'><a data-toggle='collapse' href={`#deleteConfirm${data.id}`} className='removeItemInitial' role='button' aria-expanded='false' aria-controls='collapseExample'><ion-icon name='close-circle'></ion-icon></a></div> : null}
							<div className='card-body mb-2'><a href={data.detailUrl} dangerouslySetInnerHTML={{__html: data.caption}}></a></div>
							<div className='card-footer collapse text-center' id={`deleteConfirm${data.id}`}><a data-item_id={data.id} onClick={this.context.removeItemFromLightbox}>Remove Item From {lightboxTerminology.singular}</a></div>
						</div>
					</div>
					);
				break;
		}
	}
}

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
class LightboxList extends React.Component {
	static contextType = LightboxContext;

	constructor(props) {
		super(props);

		this.newLightboxRef = React.createRef();
		this.componentDidUpdate = this.componentDidUpdate.bind(this);
	}

	componentDidUpdate(prevProps, prevState, snapshot) {
		if (this.newLightboxRef && this.newLightboxRef.current) {
			this.newLightboxRef.current.onClick();
		}
	}

	render(){
		let lightboxes = [];
		if (this.props.lightboxes && this.props.lightboxes.sets) {
			for(let k in this.props.lightboxes.sets) {
				let l = this.props.lightboxes.sets[k];
				lightboxes.push(<LightboxListItem key={k} data={l} count={l.count} deleteCallback={this.context.deleteLightbox} newLightboxRef={this.newLightboxRef}/>);
			}
		}
		if(lightboxes.length == 0){
			lightboxes = <li className="list-group-item"><div className="row my-4"><div className="col-sm-12 label">Use the link above to create a {lightboxTerminology.section_heading}.</div></div></li>
		}
		return(
			<div className='row'>
				<div className='col-sm-12 mt-3 mb-2'>
					<div className='row'>
						<div className='col-sm-12 col-md-4 offset-md-2 col-lg-3 offset-lg-3'>
							<h1>My {lightboxTerminology.plural}</h1>
						</div>
						<div className='col-sm-12 col-md-4 col-lg-3 text-right'>
							<a href='#' className='btn btn-primary' onClick={this.context.newLightbox}>New +</a>
						</div>
					</div>
					<div className='row'>
						<div className='col-sm-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3'>
							<ul className="list-group list-group-flush">
								{lightboxes}
							</ul>
						</div>
					</div>
				</div>
			</div>
		);
	}
}

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
class LightboxListItem extends React.Component {
	static contextType = LightboxContext;

	constructor(props) {
		super(props);

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
				if(resp['access']){
					state.userAccess = resp['access'];
					that.context.setState(state);
				}
			}
		});
	}

	saveNewLightbox(name) {
		let that = this;
		this.context.saveNewLightbox({'name': name}, function(resp) {
			let state = that.state;
			if (resp && resp['err']) {
				state['newLightboxError'] = resp['err'];
				if(that.props.newLightboxRef && that.props.newLightboxRef.current) {
					that.props.newLightboxRef.current.onClick();
				}
			} else {
				state['newLightboxError'] = null;
			}
			that.setState(state);
		});
	}

	saveLightboxEdit(name) {
		let that = this;
		editLightbox(this.context.props.baseUrl, {'name': name, set_id: this.props.data.set_id }, function(resp) {
			// TODO: display potential errors

			// Update name is context state
			let state = that.context.state;
			state.lightboxList.sets[that.props.data.set_id]['label'] = name;
			that.context.setState(state);
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

								that.props.deleteCallback(that.props.data);
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
			return (<div className="row my-1">
				<div className="col-sm-4">
					<EasyEdit
						type="text"
						onSave={this.saveLightboxEdit}
						saveButtonLabel="Save"
						cancelButtonLabel="Cancel"
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
			</div>);
		} else if(this.props.data.set_id > 0) {			
			
			if(!this.state.userAccess){
				let that = this;
				getLightboxAccessForCurrentUser(this.context.props.baseUrl, this.props.data.set_id, function(resp) {
					if(resp && resp['ok']) {
						let state = that.state;
						state.userAccess = resp['access'];
						that.setState(state);
					}
				});
			}			
			
			return (<li className="list-group-item"><div className="row my-4">
				<div className="col-sm-12 col-md-6 label">
					{(this.state.userAccess == 2) ? <EasyEdit
						type="text"
						onSave={this.saveLightboxEdit}
						saveButtonLabel="Save"
						cancelButtonLabel="Cancel"
						attributes={{name: "name", id: "lightbox_name" + this.props.data.set_id}}
						value={this.props.data.label}
					/> : this.props.data.label}
				</div>
				<div className="col-sm-6 col-md-3 infoNarrow">{count_text}</div>
				<div className="col-sm-6 col-md-3 info text-right">
					<a href='#' data-set_id={this.props.data.set_id} className='btn btn-secondary btn-sm'
					   onClick={this.openLightbox}>View</a>
					&nbsp;
					{(this.state.userAccess == 2) ? <a href='#' data-set_id={this.props.data.set_id} className='btn btn-secondary btn-sm'
					   onClick={this.deleteLightboxConfirm}>Delete</a> : null}
				</div>
			</div></li>);
		} else{
			return(<li className="list-group-item"><div className="row my-4">
					<div className="col-sm-4">
						<EasyEdit ref={this.props.newLightboxRef}
								  type="text"
								  onSave={this.saveNewLightbox}
								  onCancel={this.context.cancelNewLightbox}
								  saveButtonLabel="Save"
								  cancelButtonLabel="Cancel"
								  placeholder="Enter name"
								  attributes={{name: "name", id: "lightbox_name" + this.props.data.set_id}}
								  value={this.props.data.label}
						/>
						<div>{this.state.newLightboxError}</div>
					</div>
					<div className="col-sm-4 infoNarrow"></div>
					<div className="col-sm-4 info"></div>

				</div></li>);
		}
	}
}

class SetUserList extends React.Component {
	render() {
		//let setUsers = (this.props.setUsers.length) ? this.props.setUsers : null;
		return (
			<div>
				{(this.props.setUsers.owner.length || this.props.setUsers.users.length) ? <ul className='list-group list-group-flush mb-4'>{this.props.setUsers.owner}{this.props.setUsers.users}</ul> : null}
			</div>
		);
	}
}
class ShareFormMessage extends React.Component {
	render() {
		return (
			(this.props.message) ? <div className={`alert alert-${(this.props.messageType == 'error') ? 'danger' : 'success'}`}>{this.props.message}</div> : null
		);
	}
}
class SetUserListMessage extends React.Component {
	render() {
		return (
			(this.props.message) ? <div className={`alert alert-${(this.props.messageType == 'error') ? 'danger' : 'success'}`}>{this.props.message}</div> : null
		);
	}
}
class ShareBlock extends React.Component {
	static contextType = LightboxContext;
	constructor(props) {
		super(props);
		let users = [];
		let owner = [];
		this.state = {
			statusMessage: '',
			statusMessageUserList: '',
			values: this.initializeValues(),
			errors: this.initializeValues(),
			setUsers: {users, owner},
			settings: {
				...props
			}
		}
		this.handleForm = this.handleForm.bind(this);
		this.submitForm = this.submitForm.bind(this);
		this.initializeList = this.initializeList.bind(this);
		this.removeUser = this.removeUser.bind(this);
		
		this.initializeList();
	}

	initializeValues() {
		return {
			users: '',
			access: '',
			set_id: this.props.setID
		};
	}
	
	initializeList() {
		let state = this.state;
		let that = this;
		axios.get("/index.php/Lightbox/getUsers/set_id/" + this.props.setID)
			.then(function (resp) {
				let data = resp.data;
				if (data.status == 'ok') {
					state.setUsers.users = [];
					state.setUsers.owner = [];
					if (data.users) {
						for(let k in data.users) {
							let c = data.users[k];
							if(c.name.length){
								if(c.owner){
									state.setUsers.owner.push(<li className='list-group-item' key={k}>{c.name} ({c.email}) <b>Owner</b></li>);
								}else{
									state.setUsers.users.push(<li className='list-group-item' key={k}><a href='#' className='float-right' onClick={that.removeUser} data-user-id={c.user_id} data-set-id={that.props.setID}><ion-icon name='close-circle' data-user-id={c.user_id} data-set-id={that.props.setID}></ion-icon></a>{c.name} ({c.email})<br/><i>Can {(c.access == 2) ? "edit" : "read"}</i></li>);
								}
							}
						}
					}
				}
				that.setState(state);
			})
			.catch(function (error) {
				console.log("Error while getting set users: ", error);
			});
	}
	updateList() {
		let state = this.state;
		state.setUsers = initializeList();
		this.setState(state);
	}

	handleForm(e) {
		let n = e.target.name;
		let v = e.target.value;

		let state = this.state;
		state.values[n] = v;
		this.setState(state);
	}

	submitForm(e) {
		let state = this.state;
		let that = this;
		state.statusMessage = "Submitting...";
		state.statusMessageType = "success";
		this.setState(state);
		let formData = new FormData();
		for(let k in this.state.values) {
			formData.append(k, this.state.values[k]);
		}
		axios.post("/index.php/Lightbox/shareSet", formData)
			.then(function (resp) {
				let data = resp.data;

				if (data.status !== 'ok') {
					// error
					state.statusMessage = data.error;
					state.statusMessageType = "error";
					state.errors = that.initializeValues();
					if(data.fieldErrors) {
						for(let k in data.fieldErrors) {
							if((state.errors[k] !== undefined)) {
								state.errors[k] = data.fieldErrors[k];
							}
						}
					}
					that.setState(state);
				} else {
					// success
					if(data.message){
						state.statusMessage = data.message;
					}
					if(data.error){
						if(data.message){
							state.statusMessage = state.statusMessage + '; ';
						}
						state.statusMessage = state.statusMessage + data.error;
					}
					state.statusMessageType = "success";
					state.values = that.initializeValues();	// Clear form elements
					state.errors = that.initializeValues();	// Clear form errors
					that.setState(state);
					that.initializeList();
					if(!data.error){
						setTimeout(function() {
							state.statusMessage = '';
							that.setState(state);
						}, 3000);
					}
				}

			})
			.catch(function (error) {
				console.log("Error while attempting to invite users: ", error);
			});

		e.preventDefault();
	}

	removeUser(e) {
		let state = this.state;
		let that = this;
		let userID = e.target.attributes.getNamedItem('data-user-id').value;
		let setID = e.target.attributes.getNamedItem('data-set-id').value;
		state.statusMessageUserList = "Removing User...";
		state.statusMessageTypeUserList = "error";
		this.setState(state);
					axios.get("/index.php/Lightbox/removeUserAccess/set_id/" + setID + "/user_id/" + userID)
			.then(function (resp) {
				let data = resp.data;
				if (data.status !== 'ok') {
					// error
					state.statusMessageUserList = data.error;
					state.statusMessageTypeUserList = "error";
					that.setState(state);
				} else {
					// success
					state.statusMessageTypeUserList = "success";
					state.statusMessageUserList = data.message;
					that.setState(state);
					that.initializeList();
					setTimeout(function() {
						state.statusMessageUserList = '';
						that.setState(state);
					}, 3000);
				}
				that.setState(state);
			})
			.catch(function (error) {
				console.log("Error while getting set users: ", error);
			});
	}


	render() {
		return (
			<div>
				<SetUserListMessage message={this.state.statusMessageUserList} messageType={this.state.statusMessageTypeUserList} />
				<SetUserList setUsers={this.state.setUsers} />
				<ShareFormMessage message={this.state.statusMessage} messageType={this.state.statusMessageType} />
				<b>Invite Users</b>
				<form className='ca-form'>
					<div className="form-group"><textarea className={`form-control  form-control-sm${(this.state.errors.users) ? ' is-invalid' : ''}`} id='users' name='users' value={this.state.values.users} onChange={this.handleForm} placeholder='Enter user email address separated by comma' title='Enter user email address separated by comma' />{(this.state.errors.users) ? <div className='invalid-feedback'>{this.state.errors.users}</div> : null}</div>
					<div className="form-group"><select name='access' id='access' title='Select and access level' className={`form-control  form-control-sm${(this.state.errors.access) ? ' is-invalid' : ''}`} onChange={this.handleForm}><option value=''>Select and Access Level</option><option value='1'>Read only</option><option value='2'>Edit</option></select>{(this.state.errors.access) ? <div className='invalid-feedback'>{this.state.errors.access}</div> : null}</div>
					<div className="form-group"><input type='submit' className='btn btn-primary btn-sm' value='Add' onClick={this.submitForm} /></div>
				</form>
			</div>
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