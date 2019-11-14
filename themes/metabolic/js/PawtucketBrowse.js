/*jshint esversion: 6 */
import React from "react"
import ReactDOM from "react-dom";
import { initBrowseContainer, initBrowseCurrentFilterList, initBrowseFilterList, initBrowseFacetPanel } from "../../default/js/browse";

const selector = pawtucketUIApps.PawtucketBrowse.selector;
const appData = pawtucketUIApps.PawtucketBrowse.data;
/**
 * Component context making PawtucketBrowse internals accessible to all subcomponents
 *
 * @type {React.Context}
 */
const PawtucketBrowseContext = React.createContext();


/**
 * Top-level container for browse interface. Is values for context PawtucketBrowseContext.
 *
 * Props are:
 * 		baseUrl : Base Url to browse web service
 *		initialFilters : Optional dictionary of filters to apply upon load
 *		view : Optional results view specifier
 * 		browseKey : Optional browse cache key. If supplied the initial load state will be the referenced browse criteria and result set.
 *
 * Sub-components are:
 * 		PawtucketBrowseNavigation
 * 		PawtucketBrowseFilterControls
 * 		PawtucketBrowseResults
 */
class PawtucketBrowse extends React.Component{
	constructor(props) {
		super(props);
		initBrowseContainer(this, props);
	}

	render() {
		let facetLoadUrl = this.props.baseUrl + '/' + this.props.endpoint + (this.state.key ? '/key/' + this.state.key : '');

		return(
			<PawtucketBrowseContext.Provider value={this}>	
                <PawtucketBrowseFilterControls facetLoadUrl={facetLoadUrl}/>
                <PawtucketBrowseResults view={this.state.view} facetLoadUrl={facetLoadUrl}/>
			</PawtucketBrowseContext.Provider>
		);
	}
}


/**
 * Browse result statistics display. Stats include a # results found indicator. May embed other
 * stats such as a list of currently applied browse filters (via PawtucketBrowseCurrentFilterList)
 *
 * Props are:
 * 		<NONE>
 *
 * Sub-components are:
 * 		PawtucketBrowseCurrentFilterList
 *
 * Uses context: PawtucketBrowseContext
 */
class PawtucketBrowseStatistics extends React.Component {
	static contextType = PawtucketBrowseContext;

	render() {
		if (this.context.state.resultSize === 0) {
			return(<h1 className="my-4">No results found</h1>);
		}else{
			return(
				<h1 className="my-4">{(this.context.state.resultSize !== null) ? ((this.context.state.resultSize== 1) ?
					"1 Result" : this.context.state.resultSize + " Results") : <div className="text-center">Loading...</div>}</h1>
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
 * 		PawtucketBrowseCurrentFilterList
 *
 * Uses context: PawtucketBrowseContext
 */
class PawtucketBrowseCurrentFilterList extends React.Component {
	static contextType = PawtucketBrowseContext;

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
					let facetLabel = (this.context.state.facetList && this.context.state.facetList[f]) ? this.context.state.facetList[f]['label_singular'] : "";
					filterList.push(<a key={ f + '_' + c } href='#' onClick={this.removeFilter}
							  data-facet={f}
							  data-value={c}><button type='button' className='btn btn-primary btn-sm' data-facet={f} data-value={c}>{label} <ion-icon name='close-circle' data-facet={f} data-value={c}></ion-icon></button></a>);
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
 * markup wrapping both browse statistics (# of results found) (component <PawtucketBrowseStatistics>
 * as well as the list of available browse facets (component <PawtucketBrowseFacetList>).
 *
 * Props are:
 * 		facetLoadUrl : URL to use to load facet content
 *
 * Sub-components are:
 * 		PawtucketBrowseStatistics
 * 		PawtucketBrowseFacetList
 *
 * Uses context: PawtucketBrowseContext
 */
class PawtucketBrowseFilterControls extends React.Component {
	static contextType = PawtucketBrowseContext;

	render() {
		return(
				<PawtucketBrowseStatistics/>
				);
	}
}

/**
 * List of available facets. Wraps both facet buttons, and the panel allowing selection of facet values for
 * application as browse filters. Each facet button is implemented using component <PawtucketBrowseFacetButton>.
 * The facet panel is implemented using component <PawtucketBrowseFacetPanel>.
 *
 * Props are:
 * 		facetLoadUrl : URL to use to load facet content
 *
 * Sub-components are:
 * 		PawtucketBrowseFacetButton
 * 		PawtucketBrowseFacetPanel
 *
 * Uses context: PawtucketBrowseContext
 */
class PawtucketBrowseFacetList extends React.Component {
	static contextType = PawtucketBrowseContext;

	constructor(props) {
		super(props);

		initBrowseFilterList(this, props);
	};

	render() {
		let facetButtons = [];
		let filterLabel = this.context.state.availableFacets ? "Filter By " : "";

		if(this.context.state.availableFacets) {
			for (let n in this.context.state.availableFacets) {
				let isOpen = ((this.context.state.selectedFacet !== null) && (this.context.state.selectedFacet === n)) ? 'true' : 'false';

				// Facet button-and-panel assemblies. Each button is paired with a panel it controls
				facetButtons.push((<li key={"facet_panel_container_" + n}>
					<PawtucketBrowseFacetButton key={"facet_panel_button_" + n} text={this.context.state.availableFacets[n].label_plural}
																	name={n} callback={this.toggleFacetPanel}/>

						<PawtucketBrowseFacetPanel key={"facet_panel_" + n} open={isOpen} facetName={n}
												   facetLoadUrl={this.props.facetLoadUrl} ref={this.facetPanelRefs[n]}
												   loadResultsCallback={this.context.loadResultsCallback}
												   closeFacetPanelCallback={this.closeFacetPanel}
												   arrowPosition={this.state.arrowPosition}/>
					</li>
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
					<ul>{facetButtons}</ul>
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
 *  	PawtucketBrowseFacetList
 */
class PawtucketBrowseFacetButton extends React.Component {
	render() {
		return(<div className="options-filters">
		<a href="#" data-option={this.props.name} onClick={this.props.callback}>{this.props.text}</a>
		</div>);
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
 *  	PawtucketBrowseFacetList
 *
 * Uses context: PawtucketBrowseContext
 */
class PawtucketBrowseFacetPanel extends React.Component {
	static contextType = PawtucketBrowseContext;
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
					<li key={'facetItem' + i}>
						<PawtucketBrowseFacetPanelItem id={'facetItem' + i} data={item} callback={this.clickFilterItem} selected={this.state.selectedFacetItems[item.id]}/>
					</li>
				));
			}
			applyButton = (options.length > 0) ? (<div className="d-flex justify-content-left pb-5">
				<a className="button" href="#" onClick={this.applyFilters}>Apply</a>
			</div>) : "";
		} else {
			// Loading message while fetching facet
			options.push(<li key={"facet_loading"}><h5>Loading...</h5></li>);
		}

		return(<div style={styles}>
					<ul className="filters" data-values="type_facet">
						{options}
					</ul>
					{applyButton}
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
 *  	PawtucketBrowseFacetPanel
 *
 * Uses context: PawtucketBrowseFacetPanel
 */
class PawtucketBrowseFacetPanelItem extends React.Component {
	static contextType = PawtucketBrowseContext;

	constructor(props) {
		super(props);
	}

	render() {
		let { id, data } = this.props;
		let count = (data.content_count > 0) ? '(' + data.content_count + ')' : '';
		return(<div className="checkbox">
			<input id={id} value={data.id} data-label={data.label}  className="option-input" type="checkbox" checked={this.props.selected} onChange={this.props.callback}/>
			<label htmlFor={id}>
				<span className="title">
					<a href='#'>
						{data.label} &nbsp;
						<span className="number">{count}</span>
					</a>
				</span>
			</label>
		</div>);
	}
}

/**
 * Navigation bar + search
 *
 * Props are:
 * 		<NONE>
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 *  	PawtucketBrowse
 *
 * Uses context: PawtucketBrowseContext
 */
class PawtucketBrowseNavigation extends React.Component {
	static contextType = PawtucketBrowseContext;

	constructor(props) {
		super(props);

		this.searchRef = React.createRef();
		this.state = {};
		this.loadSearch = this.loadSearch.bind(this);
	}

	/**
	 *
	 * @returns {*}
	 */
	loadSearch(e) {
		let search = this.searchRef.current.value;
		let filters = {
			_search: {}
		};
		filters._search[search] = search;
		this.context.reloadResults(filters, true);

		e.preventDefault();
	}

	render() {
		if ((this.context.state.availableFacets !== null) || (this.context.state.resultSize !== null)){
			return(
				<div className="bSearchWithinContainer mb-2">
					<form className="form-inline my-2 my-lg-0" role="search" id="searchWithin" action="#" onSubmit={this.loadSearch}>
						<input type="text" className="form-control bSearchWithin" placeholder="Search within..." name="search" aria-label="Search"/>
						<button className="btn" type="submit"><i className="material-icons">search</i></button>
					</form>
				</div>
			);
		}else{
			return(
				" "
			);
		}
	}
}
/**
 * Renders buttons to switch views cofigured in browse.conf
 *
 * Props are:
 * 		view : view format to use for display of results
 *
 * Used by:
 *  	PawtucketBrowse
 *
 * Uses context: PawtucketBrowseContext
 */
class PawtucketBrowseViewList extends React.Component {
	static contextType = PawtucketBrowseContext;

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
				viewButtonList.push(<a href='#' class='disabled' dangerouslySetInnerHTML={{__html: viewButtonIcons[i]}}></a>);
			}
		}

		return (
			<div id="bViewButtons" className="my-2 text-right">{viewButtonList}</div>
		);
	}
}

/**
 * Renders search results using a PawtucketBrowseResultItem component for each result.
 * Includes navigation to load additional pages on-demand.
 *
 * Sub-components are:
 * 		PawtucketBrowseResultItem
 * 		PawtucketBrowseResultLoadMoreButton
 *
 * Props are:
 * 		view : view format to use for display of results
 *
 * Used by:
 *  	PawtucketBrowse
 *
 * Uses context: PawtucketBrowseContext
 */
class PawtucketBrowseResults extends React.Component {
	static contextType = PawtucketBrowseContext;

	render() {
		let resultList = [];
		if(this.context.state.resultList && (this.context.state.resultList.length > 0)) {
			for (let i in this.context.state.resultList) {
				let r = this.context.state.resultList[i];
				resultList.push(<PawtucketBrowseResultItem view={this.props.view} key={r.id} data={r}/>)
			}
		}

		switch(this.props.view) {
			default:
				return (
					<div className="row"  id="browseResultsContainer">
							<div className="col-md-8 col-lg-8">
								<div className="card-columns">
									{resultList}
								</div>
								<PawtucketBrowseResultLoadMoreButton start={this.context.state.start}
															 itemsPerPage={this.context.state.itemsPerPage}
															 size={this.context.state.resultSize}
															 loadMoreHandler={this.context.loadMoreResults}
															 loadMoreRef={this.context.loadMoreRef}/>	
							</div>
							<div className="bRightCol col-md-4 col-lg-3 offset-lg-1">
								<div className="position-fixed vh-100 mr-3 pt-3">
									<PawtucketBrowseViewList/>
									<PawtucketBrowseNavigation/>
									<div id="bRefine">
										<PawtucketBrowseCurrentFilterList/>
										<PawtucketBrowseFacetList facetLoadUrl={this.props.facetLoadUrl}/>
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
 *  	PawtucketBrowseResults
 *
 * Uses context: PawtucketBrowseContext
 */
class PawtucketBrowseResultLoadMoreButton extends React.Component {
	static contextType = PawtucketBrowseContext;

	render() {
		if ((this.props.start + this.props.itemsPerPage) < this.props.size)  {
			let loadingText = (this.context.state.resultSize === null) ? "LOADING" : "Load More +";

			return (<section className="block text-align-center">
				<div className="row"><div className="col-lg-12 d-flex mx-auto justify-content-center">
				<a className="button load-more" href="#" onClick={this.props.loadMoreHandler} ref={this.props.loadMoreRef}>{loadingText}</a>
				</div></div>
				</section>);
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
 *  	PawtucketBrowseResults
 */
class PawtucketBrowseResultItem extends React.Component {
	render() {
		let data = this.props.data;

		let detail_url = data.detailUrl;

		switch(this.props.view) {
			case 'list':
				return(
					<div className="card mx-auto" ref={this.props.scrollToRef}>
						<div className="masonry-title">
							<a href={detail_url} dangerouslySetInnerHTML={{__html: data.label}}></a>
						</div>
					</div>);
				break;
			default:
				return (
					<div className='card mb-4 bResultImage' ref={this.props.scrollToRef}>
						<a href={detail_url}><div dangerouslySetInnerHTML={{__html: data.representation}}/></a>
						<div className='card-body mb-2'><a href={detail_url} dangerouslySetInnerHTML={{__html: data.caption}}></a></div>
						<div className='card-footer bSetsSelectMultiple collapse text-right'><input type='checkbox' name='object_ids[]' value='{$vn_id}'/></div>
					</div>
				);
				break;
		}
	}
}

/**
 * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
	ReactDOM.render(
		<PawtucketBrowse baseUrl={appData.baseUrl} endpoint={appData.endpoint}
							  initialFilters={appData.initialFilters} title={appData.title}
							  browseKey={appData.key} view={appData.view}
							  description={appData.description}/>, document.querySelector(selector));
}
