/*jshint esversion: 6 */
import React from "react"
import ReactDOM from "react-dom";
import { initBrowseContainer, initBrowseCurrentFilterList, initBrowseFilterList, initBrowseFacetPanel } from "../../default/js/browse";

const selector = pawtucketUIApps.NoguchiBibliographyBrowse.selector;
const appData = pawtucketUIApps.NoguchiBibliographyBrowse.data;
/**
 * Component context making NoguchiBibliographyBrowse internals accessible to all subcomponents
 *
 * @type {React.Context}
 */
const NoguchiBibliographyBrowseContext = React.createContext();

/**
 * Top-level container for browse interface. Is values for context NoguchiBibliographyBrowseContext.
 *
 * Props are:
 * 		<NONE>
 *
 * Sub-components are:
 * 		NoguchiBibliographyBrowseIntro
 * 		NoguchiBibliographySearch
 * 		NoguchiBibliographyBrowseFilterControls
 * 		NoguchiBibliographyBrowseResults
 */
class NoguchiBibliographyBrowse extends React.Component{
	constructor(props) {
		super(props);
		initBrowseContainer(this, props);
	}

	render() {
		let facetLoadUrl = this.props.baseUrl + '/' + this.props.endpoint + (this.state.key ? '/key/' + this.state.key : '');
		return(
			<NoguchiBibliographyBrowseContext.Provider value={this}>
				<main className="ca bibliography bibliography_landing">
					<NoguchiBibliographyBrowseIntro description={this.state.introduction.description}/>

					<NoguchiBibliographyBrowseFilterControls facetLoadUrl={facetLoadUrl}/>

					<NoguchiBibliographyBrowseResults/>
				</main>
			</NoguchiBibliographyBrowseContext.Provider>
		);
	}
}

/**
 * Bibliography browse collection information panel
 *
 * Props are:
 * 		
 * 		description : descriptive text for the browse (Eg. Bibliography intro comes from global value bibliographyIntro)
 *
 * Sub-components are:
 * 		<NONE>
 */
class NoguchiBibliographyBrowseIntro extends React.Component {
	static contextType = NoguchiBibliographyBrowseContext;
	constructor(props) {
		super(props);
	}

	render() {
		if (!this.props.description || (this.props.description.length === 0)) {
			return (<section className=""></section>);
		}else{
			this.context.state.description = this.props.description;
		}
		return (<section className="intro">
			<div className="wrap block-large">
				<div className="wrap-max-content">
					<div className="block-half body-text-l">{this.context.state.description}</div>
				</div>
			</div>
		</section>)
	}
}

/**
 * Browse result statistics display. Stats include a # results found indicator. May embed other
 * stats such as a list of currently applied browse filters (via NoguchiBibliographyBrowseCurrentFilterList)
 *
 * Props are:
 * 		<NONE>
 *
 * Sub-components are:
 * 		NoguchiBibliographyBrowseCurrentFilterList
 *
 * Uses context: NoguchiBibliographyBrowseContext
 */
class NoguchiBibliographyBrowseStatistics extends React.Component {
	static contextType = NoguchiBibliographyBrowseContext;

	render() {
		return(<div className="current">
			<div className="body-sans">{(this.context.state.resultSize > 0) ? ((this.context.state.resultSize== 1) ?
				"Showing 1 Result"
				:
				"Showing " + this.context.state.resultSize + " Results") : "Loading..."}.</div>

				<NoguchiBibliographyBrowseCurrentFilterList/>
		</div>
		);
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
 * 		NoguchiBibliographyBrowseCurrentFilterList
 *
 * Uses context: NoguchiBibliographyBrowseContext
 */
class NoguchiBibliographyBrowseCurrentFilterList extends React.Component {
	static contextType = NoguchiBibliographyBrowseContext;

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
					filterList.push((<a key={ f + '_' + c } href='#' className='browseRemoveFacet' onClick={this.removeFilter} data-facet={f} data-value={c}>{label} <span onClick={this.removeFilter} data-facet={f} data-value={c}>&times;</span></a>));
				}
			}
		}
		return(<div className="tags">
			{filterList}
		</div>);
	}
}

/**
 * Container for display and editing of applied browse filters. This component provides
 * markup wrapping both browse statistics (# of results found) (component <NoguchiBibliographyBrowseStatistics>
 * as well as the list of available browse facets (component <NoguchiBibliographyBrowseFacetList>).
 *
 * Props are:
 * 		facetLoadUrl : URL to use to load facet content
 *
 * Sub-components are:
 * 		NoguchiBibliographyBrowseStatistics
 * 		NoguchiBibliographyBrowseFacetList
 *
 * Uses context: NoguchiBibliographyBrowseContext
 */
class NoguchiBibliographyBrowseFilterControls extends React.Component {
	static contextType = NoguchiBibliographyBrowseContext;
	constructor(props) {
		super(props);

		this.searchRef = React.createRef();
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
		return(
				<section className="ca_filters">
					<div className="wrap">
						<div className="filters_bar">
							<NoguchiBibliographyBrowseStatistics/>
							<NoguchiBibliographyBrowseFacetList facetLoadUrl={this.props.facetLoadUrl}/>
							<NoguchiBibliographySearch/>
						</div>
					</div>
				</section>);
	}
}

/**
 * List of available facets. Wraps both facet buttons, and the panel allowing selection of facet values for
 * application as browse filters. Each facet button is implemented using component <NoguchiBibliographyBrowseFacetButton>.
 * The facet panel is implemented using component <NoguchiBibliographyBrowseFacetPanel>.
 *
 * Props are:
 * 		facetLoadUrl : URL to use to load facet content
 *
 * Sub-components are:
 * 		NoguchiBibliographyBrowseFacetButton
 * 		NoguchiBibliographyBrowseFacetPanel
 *
 * Uses context: NoguchiBibliographyBrowseContext
 */
class NoguchiBibliographyBrowseFacetList extends React.Component {
	static contextType = NoguchiBibliographyBrowseContext;

	constructor(props) {
		super(props);

		initBrowseFilterList(this, props);
	};

	render() {
		let facetButtons = [];
		let filterLabel = this.context.state.availableFacets ? "Filter by: " : "Loading...";

		if(this.context.state.availableFacets) {
			for (let n in this.context.state.availableFacets) {
				facetButtons.push((<NoguchiBibliographyBrowseFacetButton key={n} text={this.context.state.availableFacets[n].label_plural}
															  name={n} callback={this.toggleFacetPanel}/>));
			}
			if(facetButtons.length == 0){
				filterLabel = "";
			}
		}

		let isOpen = (this.state.selected !== null) ? 'true' : 'false';

		return(
			<div className="options-filter-widget">
				<div className="options text-gray">
					<span className="caption-text">{filterLabel}</span>
					{facetButtons}
				</div>
				<NoguchiBibliographyBrowseFacetPanel open={isOpen} facetName={this.state.selected}
										  facetLoadUrl={this.props.facetLoadUrl} ref={this.facetPanelRef}
										  loadResultsCallback={this.context.loadResultsCallback}
										  closeFacetPanelCallback={this.closeFacetPanel}
												arrowPosition={this.state.arrowPosition}
				/>
			</div>
		)
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
 *  	NoguchiBibliographyBrowseFacetList
 */
class NoguchiBibliographyBrowseFacetButton extends React.Component {
	render() {
		return(<a href="#" data-option={this.props.name} onClick={this.props.callback}>{this.props.text}</a>);
	}
}

/**
 * Visible on-demand panel containing facet values and UI to select and apply values as browse filters.
 *
 * Props are:
 * 		open : controls visibility of panel; if set to a true value, or the string "true"  panel is visible.
 * 	  	panelArrowRef :
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 *  	NoguchiBibliographyBrowseFacetList
 *
 * Uses context: NoguchiBibliographyBrowseContext
 */
class NoguchiBibliographyBrowseFacetPanel extends React.Component {
	static contextType = NoguchiBibliographyBrowseContext;
	constructor(props) {
		super(props);
		initBrowseFacetPanel(this, props);
	};

	render() {
		let styles = {
			display: JSON.parse(this.props.open) ? 'block' : 'none'
		};

		let options = [];
		if(this.state.facetContent) {
			// Render facet options when available
			for (let i in this.state.facetContent) {
				let item = this.state.facetContent[i];

				options.push((
					<li key={'facetItem' + i}>
						<NoguchiBibliographyBrowseFacetPanelItem id={'facetItem' + i} data={item} callback={this.clickFilterItem} selected={this.state.selectedFacetItems[item.id]}/>
					</li>
				));
			}
		}
		let arrowStyles = {
			"left": this.props.arrowPosition + "px"
		};

		return(<div className="option_values wrap-negative" style={styles}>
					<div className="arrow" style={arrowStyles}></div>
					<div className="inner">
						<div className="inner-crop">
							<div className="wrap">
								<ul className="ul-options" data-values="type_facet">
									{options}
								</ul>
								<div className="text-align-center"><br/><a className="button load-more" href="#" onClick={this.applyFilters}>Apply</a></div>
							</div>
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
 *  	NoguchiBibliographyBrowseFacetPanel
 *
 * Uses context: NoguchiBibliographyBrowseFacetPanel
 */
class NoguchiBibliographyBrowseFacetPanelItem extends React.Component {
	static contextType = NoguchiBibliographyBrowseContext;

	constructor(props) {
		super(props);
	}

	render() {
		let { id, data } = this.props;

		return(<div className="checkbox">
			<input id={id} value={data.id} data-label={data.label}  className="option-input" type="checkbox" checked={this.props.selected} onChange={this.props.callback}/>
			<label htmlFor={id}>
				<span className="title">
					<a href='#'>
						{data.label} &nbsp;
						<span className="number">({data.content_count})</span>
					</a>
				</span>
			</label>
		</div>);
	}
}

/**
 * Noguchi Bibliography section-specific navigation. Includes collection drop-down with hard-coded criteria, as well
 * as a search box.
 *
 * Props are:
 * 		<NONE>
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 *  	NoguchiBibliographyBrowse
 *
 * Uses context: NoguchiBibliographyBrowseContext
 */
class NoguchiBibliographySearch extends React.Component {
	static contextType = NoguchiBibliographyBrowseContext;

	constructor(props) {
		super(props);

		this.searchRef = React.createRef();
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
		return(
			<div className="search hide-for-mobile">
					<form action="#" onSubmit={this.loadSearch}>
							<input name="search" type="text" placeholder="Search the Bibliography" ref={this.searchRef}
														 className="search"/>
						</form>
				</div>
		);
	}
}

/**
 * Renders search results using a NoguchiBibliographyBrowseResultItem component for each result.
 * Includes navigation to load additional pages on-demand.
 *
 * Sub-components are:
 * 		NoguchiBibliographyBrowseResultItem
 * 		NoguchiBibliographyBrowseResultLoadMoreButton
 *
 * Props are:
 * 		<NONE>
 *
 * Used by:
 *  	NoguchiBibliographyBrowse
 *
 * Uses context: NoguchiBibliographyBrowseContext
 */
class NoguchiBibliographyBrowseResults extends React.Component {
	static contextType = NoguchiBibliographyBrowseContext;

	render() {
		let resultList = [];
		for (let i in this.context.state.resultList) {
			let r = this.context.state.resultList[i];
			resultList.push(<NoguchiBibliographyBrowseResultItem key={r.id} data={r}/>)
		}

		return(
			<div>
				<section className="block block-top">
					<div className="wrap results">
						<div className="block-half-top">
							{resultList}
						</div>
					</div>
				</section>
				<NoguchiBibliographyBrowseResultLoadMoreButton start={this.context.state.start} itemsPerPage={this.context.state.itemsPerPage}
												   size={this.context.state.resultSize} loadMoreHandler={this.context.loadMoreResults}
												   loadMoreRef={this.context.loadMoreRef}/>
			</div>
		);
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
 *  	NoguchiBibliographyBrowseResults
 */
class NoguchiBibliographyBrowseResultLoadMoreButton extends React.Component {
	render() {
		if ((this.props.start + this.props.itemsPerPage) < this.props.size) {
			return (
				<section className="block text-align-center">
				<a className="button load-more" href="#" onClick={this.props.loadMoreHandler} ref={this.props.loadMoreRef}>Load More +</a>
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
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 *  	NoguchiBibliographyBrowseResults
 */
class NoguchiBibliographyBrowseResultItem extends React.Component {
	render() {
		let data = this.props.data;
		let styles = {
			"backgroundImage": "url(" + data.representation + ")"
		};

		return (
			<div className="block-half">
				<a href={data.detailUrl} className="columns">
					<div className="col title clamp" data-lines="2">{data.citation}</div>
					<div className="col type text-gray">{data.format}</div>
				</a>
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
		<NoguchiBibliographyBrowse baseUrl={appData.baseUrl} endpoint={appData.endpoint}
							  initialFilters={appData.initialFilters}
							  browseKey={appData.key}/>, document.querySelector(selector));
}
