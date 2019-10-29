/*jshint esversion: 6 */
import React from "react"
import ReactDOM from "react-dom";
import {
	initBrowseContainer,
	initBrowseCurrentFilterList,
	initBrowseFilterList,
	initBrowseFacetPanel,
	fetchFacetValues
} from "../../default/js/browse";

const selector = pawtucketUIApps.NoguchiCrBrowse.selector;
const appData = pawtucketUIApps.NoguchiCrBrowse.data;
/**
 * Component context making NoguchiCrBrowse internals accessible to all subcomponents
 *
 * @type {React.Context}
 */
const NoguchiCrBrowseContext = React.createContext();

/**
 * Top-level container for browse interface. Is values for context NoguchiCrBrowseContext.
 *
 * Props are:
 * 		baseUrl : Base Url to browse web service
 *		initialFilters : Optional dictionary of filters to apply upon load
 *		view : Optional results view specifier
 * 		browseKey : Optional browse cache key. If supplied the initial load state will be the referenced browse criteria and result set.
 *
 * Sub-components are:
 * 		NoguchiCrBrowseIntro
 * 		NoguchiCrBrowseNavigation
 * 		NoguchiCrBrowseFilterControls
 * 		NoguchiCrBrowseResults
 */
class NoguchiCrBrowse extends React.Component{
	constructor(props) {
		super(props);
		initBrowseContainer(this, props);
	}

	componentDidMount() {
		let that = this;
		if(!this.state.decades) {
			let facetLoadUrl = this.props.baseUrl + '/' + this.props.endpoint;
			fetchFacetValues(facetLoadUrl + '/facet/decade_facet', function (resp) {
				let state = that.state;
				state.decades = [];	// reset selected items
				for (let k in resp.content) {
					state.decades.push(resp.content[k].id);
				}
				that.setState(state);
			}, false);
		}
	}

	render(){
		let facetLoadUrl = this.props.baseUrl + '/' + this.props.endpoint + (this.state.key ? '/key/' + this.state.key : '');

		return(
			<NoguchiCrBrowseContext.Provider value={this}>
				<main className="ca cr cr_browse nomargin">
					<NoguchiCrBrowseIntro headline={this.state.introduction.title} description={this.state.introduction.description}/>

					<NoguchiCrBrowseNavigation/>
					<NoguchiCrBrowseFilterControls facetLoadUrl={facetLoadUrl}/>

					<NoguchiCrBrowseResults view={this.state.view}/>
				</main>
			</NoguchiCrBrowseContext.Provider>
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
class NoguchiCrBrowseIntro extends React.Component {
	static contextType = NoguchiCrBrowseContext;
	constructor(props) {
		super(props);
	}

	render() {
		if (!this.props.headline || (this.props.headline.length === 0)) {
			return (<section className=""></section>);
		}else{
			this.context.state.headline = this.props.headline;
			this.context.state.description = this.props.description;
		}
		return (<section className="intro">
			<div className="wrap block-large">
				<div className="wrap-max-content">
					<div className="block-half subheadline-bold text-align-center">{this.context.state.headline}</div>
					<div className="block-half body-text-l">{this.context.state.description}</div>
				</div>
			</div>
		</section>)
	}
}

/**
 * Browse result statistics display. Stats include a # results found indicator. May embed other
 * stats such as a list of currently applied browse filters (via NoguchiCrBrowseCurrentFilterList)
 *
 * Props are:
 * 		<NONE>
 *
 * Sub-components are:
 * 		NoguchiCrBrowseCurrentFilterList
 *
 * Uses context: NoguchiCrBrowseContext
 */
class NoguchiCrBrowseStatistics extends React.Component {
	static contextType = NoguchiCrBrowseContext;

	render() {
		return(<div className="current">
			<div className="body-sans">{(this.context.state.resultSize !== null) ? ((this.context.state.resultSize== 1) ?
				"Showing 1 Result"
				:
				"Showing " + this.context.state.resultSize + " Results") : "Loading..."}.</div>

				<NoguchiCrBrowseCurrentFilterList/>
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
 * 		NoguchiCrBrowseCurrentFilterList
 *
 * Uses context: NoguchiCrBrowseContext
 */
class NoguchiCrBrowseCurrentFilterList extends React.Component {
	static contextType = NoguchiCrBrowseContext;

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
 * markup wrapping both browse statistics (# of results found) (component <NoguchiCrBrowseStatistics>
 * as well as the list of available browse facets (component <NoguchiCrBrowseFacetList>).
 *
 * Props are:
 * 		facetLoadUrl : URL to use to load facet content
 *
 * Sub-components are:
 * 		NoguchiCrBrowseStatistics
 * 		NoguchiCrBrowseFacetList
 *
 * Uses context: NoguchiCrBrowseContext
 */
class NoguchiCrBrowseFilterControls extends React.Component {
	static contextType = NoguchiCrBrowseContext;
	constructor(props) {
		super(props);

		this.loadDecade = this.loadDecade.bind(this);
	}
	loadDecade(e) {
		let targetDecade = e.target.attributes.getNamedItem('data-decade').value;
		if (targetDecade) {
			let c = {};
			c[targetDecade] = targetDecade;
			this.context.reloadResults({decade_facet: c}, true);
		} else {
			this.context.reloadResults({}, true);
		}
		e.preventDefault();
	}
	render() {
		let decades = [];
		if (this.context.state && this.context.state.decades) {
			for(let k in this.context.state.decades) {
				decades.push(<li><a href='#' data-decade={this.context.state.decades[k]} onClick={this.loadDecade}>{this.context.state.decades[k]}</a></li>);
			}
		}

		return(
				<section className="ca_filters">
					<div className="wrap">

						<nav className="hide-for-mobile xblock-half">
							<div className="years_bar">
								<ul>
									<li className="selected"><a href="#" data-decade='' onClick={this.loadDecade}>All Years</a></li>
									{decades}
								</ul>
							</div>
						</nav>

						<div className="filters_bar">
							<NoguchiCrBrowseStatistics/>
							<NoguchiCrBrowseFacetList facetLoadUrl={this.props.facetLoadUrl}/>
						</div>
					</div>
				</section>);
	}
}

/**
 * List of available facets. Wraps both facet buttons, and the panel allowing selection of facet values for
 * application as browse filters. Each facet button is implemented using component <NoguchiCrBrowseFacetButton>.
 * The facet panel is implemented using component <NoguchiCrBrowseFacetPanel>.
 *
 * Props are:
 * 		facetLoadUrl : URL to use to load facet content
 *
 * Sub-components are:
 * 		NoguchiCrBrowseFacetButton
 * 		NoguchiCrBrowseFacetPanel
 *
 * Uses context: NoguchiCrBrowseContext
 */
class NoguchiCrBrowseFacetList extends React.Component {
	static contextType = NoguchiCrBrowseContext;

	constructor(props) {
		super(props);

		initBrowseFilterList(this, props);
	};

	render() {
		let facetButtons = [], facetPanels = [];
		let filterLabel = this.context.state.availableFacets ? "Filter by: " : "Loading...";

		if(this.context.state.availableFacets) {
			for (let n in this.context.state.availableFacets) {
				facetButtons.push((<NoguchiCrBrowseFacetButton key={n} text={this.context.state.availableFacets[n].label_plural}
															  name={n} callback={this.toggleFacetPanel}/>));


				let isOpen = ((this.context.state.selectedFacet !== null) && (this.context.state.selectedFacet === n)) ? 'true' : 'false';
				facetPanels.push((<NoguchiCrBrowseFacetPanel open={isOpen} facetName={n} key={n}
																  facetLoadUrl={this.props.facetLoadUrl} ref={this.facetPanelRefs[n]}
																  loadResultsCallback={this.context.loadResultsCallback}
																  closeFacetPanelCallback={this.closeFacetPanel}
																  arrowPosition={this.state.arrowPosition}
				/>));
			}
			if(facetButtons.length == 0){
				filterLabel = "";
			}
		}

		return(
			<div className="options-filter-widget">
				<div className="options text-gray">
					<span className="caption-text">{filterLabel}</span>
					{facetButtons}
				</div>
				{facetPanels}
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
 *  	NoguchiCrBrowseFacetList
 */
class NoguchiCrBrowseFacetButton extends React.Component {
	render() {
		return(<a href="#" data-option={this.props.name} onClick={this.props.callback}>{this.props.text}</a>);
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
 *  	NoguchiCrBrowseFacetList
 *
 * Uses context: NoguchiCrBrowseContext
 */
class NoguchiCrBrowseFacetPanel extends React.Component {
	static contextType = NoguchiCrBrowseContext;
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
						<NoguchiCrBrowseFacetPanelItem id={'facetItem' + i} data={item} callback={this.clickFilterItem} selected={this.state.selectedFacetItems[item.id]}/>
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
							</div>
						</div>
						<div className="filter-apply"><a className="button load-more" href="#" onClick={this.applyFilters}>Apply</a></div>
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
 *  	NoguchiCrBrowseFacetPanel
 *
 * Uses context: NoguchiCrBrowseFacetPanel
 */
class NoguchiCrBrowseFacetPanelItem extends React.Component {
	static contextType = NoguchiCrBrowseContext;

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
 * Noguchi Archive section-specific navigation. Includes collection drop-down with hard-coded criteria, as well
 * as a search box.
 *
 * Props are:
 * 		<NONE>
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 *  	NoguchiCrBrowse
 *
 * Uses context: NoguchiCrBrowseContext
 */
class NoguchiCrBrowseNavigation extends React.Component {
	static contextType = NoguchiCrBrowseContext;

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

		return(
			<section className="ca_nav">
				<nav className="hide-for-mobile">
					<div className="wrap text-gray">
						<form action="#" onSubmit={this.loadSearch}>
							<div className="cell text"><a href='/index.php/Browse/CR'>Browse</a></div>
							<div className="cell"><input name="search" type="text" placeholder="Search the Catalogue" ref={this.searchRef}
														 className="search"/></div>

							<div className="misc">
								<div className="cell text"><a href='/index.php/CR/Foreword'>Foreword</a></div>
								<div className="cell text"><a href='/index.php/CR/UserGuide'>User Guide</a></div>
								<div className="cell text"><a href='/index.php/CR/About'>About<span className='long'> The Catalogue</span></a></div>
							</div>
						</form>
					</div>
				</nav>

			</section>
		);
	}
}

/**
 * Renders search results using a NoguchiCrBrowseResultItem component for each result.
 * Includes navigation to load additional pages on-demand.
 *
 * Sub-components are:
 * 		NoguchiCrBrowseResultItem
 * 		NoguchiCrBrowseResultLoadMoreButton
 *
 * Props are:
 * 		view : view format to use for display of results
 *
 * Used by:
 *  	NoguchiCrBrowse
 *
 * Uses context: NoguchiCrBrowseContext
 */
class NoguchiCrBrowseResults extends React.Component {
	static contextType = NoguchiCrBrowseContext;

	render() {
		let resultList = [];
		if(this.context.state.resultList && (this.context.state.resultList.length > 0)) {
			for (let i in this.context.state.resultList) {
				let r = this.context.state.resultList[i];
				resultList.push(<NoguchiCrBrowseResultItem view={this.props.view} key={r.id} data={r} count={i} />)
			}
		} else if (this.context.state.resultSize === 0) {
			resultList.push(<h2>No results found</h2>)
		}

		switch(this.props.view) {
			default:
				return (
					<div>
						<section className="wrap block block-top grid">
							<div className="grid-flex grid-cr-browse">
								{resultList}
							</div>
						</section>
						<NoguchiCrBrowseResultLoadMoreButton start={this.context.state.start}
															 itemsPerPage={this.context.state.itemsPerPage}
															 size={this.context.state.totalSize}
															 loadMoreHandler={this.context.loadMoreResults}
															 loadMoreRef={this.context.loadMoreRef}/>
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
 *  	NoguchiCrBrowseResults
 */
class NoguchiCrBrowseResultLoadMoreButton extends React.Component {
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
 * 		view : view format to use for display of results
 *
 * Sub-components are:
 * 		<NONE>
 *
 * Used by:
 *  	NoguchiCrBrowseResults
 */
class NoguchiCrBrowseResultItem extends React.Component {
	render() {
		let data = this.props.data;
		let count = this.props.count;
		var remainder = count % 9;
		var itemClass = "item-grid";
		if(remainder == 0){
			itemClass = "item-grid item-large"; 
		}

		switch(this.props.view) {
			default:
				return (
					<div class={itemClass}>
						<a href={data.detailUrl}>
							<div className="block-quarter"
								 dangerouslySetInnerHTML={{__html: data.representation}}></div>
							<div className="text block-quarter">
								<div className="ca-identifier text-gray">{data.idnoStatus}</div>
								<div className="thumb-text clamp" data-lines="2">{data.label}</div>
								<div className="ca-identifier text-gray">{data.date}</div>
							</div>
						</a>
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
		<NoguchiCrBrowse baseUrl={appData.baseUrl} endpoint={appData.endpoint}
							  initialFilters={appData.initialFilters} view={appData.view}
							  browseKey={appData.key}/>, document.querySelector(selector));
}
