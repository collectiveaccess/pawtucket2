/*jshint esversion: 6 */
import React from "react"
import ReactDOM from "react-dom";
import EasyEdit from 'react-easy-edit';
import { confirmAlert } from 'react-confirm-alert';
import 'react-confirm-alert/src/react-confirm-alert.css';

import { initBrowseContainer, initBrowseCurrentFilterList, initBrowseFilterList, initBrowseFacetPanel, initBrowseResults } from "../../default/js/browse";
import { fetchLightboxList, addLightbox, editLightbox, deleteLightbox, removeItemFromLightbox } from "../../default/js/lightbox";

import ClampLines from 'react-clamp-lines';

const selector = pawtucketUIApps.Lightbox.selector;
const appData = pawtucketUIApps.Lightbox.data;
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
				<LightboxResults view={this.state.view} facetLoadUrl={facetLoadUrl}/>
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
 * Renders download options
 *
 * Props are:
 * 		
 *
 * Used by:
 *  	LightboxControls
 *
 * Uses context: LightboxContext
 */
class LightboxDownloadOptions extends React.Component {
	static contextType = LightboxContext;

	render() {
		return (
			<div id="bDownloadOptions">
				<div className="dropdown show">
					<a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<ion-icon name="download"></ion-icon>
				  </a>

				  <div className="dropdown-menu" aria-labelledby="dropdownMenuLink">
					<a className="dropdown-item" href="#">PDF</a>
					<a className="dropdown-item" href="#">XCEL</a>
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

	render() {
		return (
			<div id="bSortOptions">
				<div className="dropdown show">
					<a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<ion-icon name="funnel"></ion-icon>
				  </a>

				  <div className="dropdown-menu" aria-labelledby="dropdownMenuLink">
					<a className="dropdown-item" href="#">Identifier</a>
					<a className="dropdown-item" href="#">Name</a>
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
		return (<h1>Lightbox: {this.props.headline}</h1>)
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

	render() {
		let c  = (this.context.state.resultSize === null);
		return(<div className="row">
					<div className="col-md-6"><LightboxStatistics/></div>
					<div className="col-md-6">
{/* view download sort don't work yet
						<LightboxViewList/>
						<LightboxDownloadOptions/>
						<LightboxSortOptions/>
*/}					</div>
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
		let filterLabel = this.context.state.availableFacets ? "Filter By " : "";
		
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
			if(facetButtons.length == 0){
				filterLabel = "";
			}
		}


		if(this.context.state.availableFacets){
			return(
				<div>
					<h2>{filterLabel}</h2>
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
								<div className="card-columns">
									{resultList}
								</div>
								<LightboxResultLoadMoreButton start={this.context.state.start}
															 itemsPerPage={this.context.state.itemsPerPage}
															 size={this.context.state.resultSize}
															 loadMoreHandler={this.context.loadMoreResults}
															 loadMoreRef={this.context.loadMoreRef}/>	
							</div>
							<div className="bRightCol col-md-4 col-lg-3 offset-lg-1">
								<div className="position-fixed vh-100 mr-3 pt-3">
									<div id="bRefine">
										<LightboxCurrentFilterList/>
										<LightboxFacetList facetLoadUrl={this.props.facetLoadUrl}/>
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
	render() {
		let data = this.props.data;

		switch(this.props.view) {
			default:
				return(
					<div className='card mb-4 bResultImage' ref={this.props.scrollToRef}>
						<a href={data.detailUrl}><div dangerouslySetInnerHTML={{__html: data.representation}}/></a>
						<div className='float-right'><a data-toggle='collapse' href={`#deleteConfirm${data.id}`} className='removeItemInitial' role='button' aria-expanded='false' aria-controls='collapseExample'><ion-icon name='close-circle'></ion-icon></a></div>
						<div className='card-body mb-2'><a href={data.detailUrl} dangerouslySetInnerHTML={{__html: data.caption}}></a></div>
						<div className='card-footer collapse text-center' id={`deleteConfirm${data.id}`}><a data-item_id={data.id} onClick={this.context.removeItemFromLightbox}>Remove Item From Set</a></div>
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
			lightboxes = <li className="list-group-item"><div className="row my-4"><div className="col-sm-12 label">Use the link above to create a ligthbox.</div></div></li>
		}
		return(
			<div className='row'>
				<div className='col-sm-12 mt-3 mb-2'>
					<div className='row'>
						<div className='col-sm-12 col-md-4 offset-md-2 col-lg-3 offset-lg-3'>
							<h1>My Lightboxes</h1>
						</div>
						<div className='col-sm-12 col-md-4 col-lg-3 text-right'>
							<a href='#' className='btn btn-primary' onClick={this.context.newLightbox}>New Collection +</a>
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
			deleting: false
		};

		this.openLightbox = this.openLightbox.bind(this);
		this.saveLightboxEdit = this.saveLightboxEdit.bind(this);
		this.saveNewLightbox = this.saveNewLightbox.bind(this);
		this.deleteLightboxConfirm = this.deleteLightboxConfirm.bind(this);
	}

	openLightbox(e) {
		let set_id = e.target.attributes.getNamedItem('data-set_id').value;
		let state = this.context.state;
		state.set_id = set_id;
		if(!state.filters) { state.filters = {}; }
		if(!state.filters['_search']) { state.filters = {'_search': {}}; }
		state.filters['_search']['ca_sets.set_id:' + set_id] = 'Lightbox: ' + state.lightboxList.sets[set_id].label;
		this.context.setState(state);
		this.context.reloadResults(state.filters, false);
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
			return (<li className="list-group-item"><div className="row my-4">
				<div className="col-sm-12 col-md-6 label">
					<EasyEdit
						type="text"
						onSave={this.saveLightboxEdit}
						saveButtonLabel="Save"
						cancelButtonLabel="Cancel"
						attributes={{name: "name", id: "lightbox_name" + this.props.data.set_id}}
						value={this.props.data.label}
					/>
				</div>
				<div className="col-sm-6 col-md-3 infoNarrow">{count_text}</div>
				<div className="col-sm-6 col-md-3 info text-right">
					<a href='#' data-set_id={this.props.data.set_id} className='btn btn-secondary btn-sm'
					   onClick={this.openLightbox}>View</a>
					&nbsp;
					<a href='#' data-set_id={this.props.data.set_id} className='btn btn-secondary btn-sm'
					   onClick={this.deleteLightboxConfirm}>Delete</a>
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