/*jshint esversion: 6 */
import React from "react"
import ReactDOM from "react-dom";
import { initBrowseContainer, initBrowseCurrentFilterList, initBrowseFilterList, initBrowseFacetPanel } from "../../default/js/browse";

const selector = pawtucketUIApps.NoguchiArchiveBrowse.selector;
const appData = pawtucketUIApps.NoguchiArchiveBrowse.data;
/**
 * Component context making NoguchiArchiveBrowse internals accessible to all subcomponents
 *
 * @type {React.Context}
 */
const NoguchiArchiveBrowseContext = React.createContext();

/**
 * Top-level container for browse interface. Is values for context NoguchiArchiveBrowseContext.
 *
 * Props are:
 * 		<NONE>
 *
 * Sub-components are:
 * 		NoguchiArchiveBrowseIntro
 * 		NoguchiArchiveBrowseNavigation
 * 		NoguchiArchiveBrowseFilterControls
 * 		NoguchiArchiveBrowseResults
 */
class NoguchiArchiveBrowse extends React.Component{
	constructor(props) {
		super(props);
		initBrowseContainer(this, props);
	}

	render() {
		let facetLoadUrl = this.props.baseUrl + '/' + this.props.endpoint + (this.state.key ? '/key/' + this.state.key : '');
		return(
			<NoguchiArchiveBrowseContext.Provider value={this}>
				<main className="ca archive archive_landing nomargin">
					<NoguchiArchiveBrowseIntro headline={this.state.introduction.title} description={this.state.introduction.description}/>

					<NoguchiArchiveBrowseNavigation/>
					<NoguchiArchiveBrowseFilterControls facetLoadUrl={facetLoadUrl}/>

					<NoguchiArchiveBrowseResults/>
				</main>
			</NoguchiArchiveBrowseContext.Provider>
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
class NoguchiArchiveBrowseIntro extends React.Component {
	static contextType = NoguchiArchiveBrowseContext;
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
 * stats such as a list of currently applied browse filters (via NoguchiArchiveBrowseCurrentFilterList)
 *
 * Props are:
 * 		<NONE>
 *
 * Sub-components are:
 * 		NoguchiArchiveBrowseCurrentFilterList
 *
 * Uses context: NoguchiArchiveBrowseContext
 */
class NoguchiArchiveBrowseStatistics extends React.Component {
	static contextType = NoguchiArchiveBrowseContext;

	render() {
		return(<div className="current">
			<div className="body-sans">{(this.context.state.resultSize !== null) ? ((this.context.state.resultSize== 1) ?
				"Showing 1 Result"
				:
				"Showing " + this.context.state.resultSize + " Results") : "Loading..."}.</div>

				<NoguchiArchiveBrowseCurrentFilterList/>
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
 * 		NoguchiArchiveBrowseCurrentFilterList
 *
 * Uses context: NoguchiArchiveBrowseContext
 */
class NoguchiArchiveBrowseCurrentFilterList extends React.Component {
	static contextType = NoguchiArchiveBrowseContext;

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
 * markup wrapping both browse statistics (# of results found) (component <NoguchiArchiveBrowseStatistics>
 * as well as the list of available browse facets (component <NoguchiArchiveBrowseFacetList>).
 *
 * Props are:
 * 		facetLoadUrl : URL to use to load facet content
 *
 * Sub-components are:
 * 		NoguchiArchiveBrowseStatistics
 * 		NoguchiArchiveBrowseFacetList
 *
 * Uses context: NoguchiArchiveBrowseContext
 */
class NoguchiArchiveBrowseFilterControls extends React.Component {
	static contextType = NoguchiArchiveBrowseContext;

	render() {
		return(
				<section className="ca_filters">
					<div className="wrap">
						<div className="filters_bar">
							<NoguchiArchiveBrowseStatistics/>
							<NoguchiArchiveBrowseFacetList facetLoadUrl={this.props.facetLoadUrl}/>
						</div>
					</div>
				</section>);
	}
}

/**
 * List of available facets. Wraps both facet buttons, and the panel allowing selection of facet values for
 * application as browse filters. Each facet button is implemented using component <NoguchiArchiveBrowseFacetButton>.
 * The facet panel is implemented using component <NoguchiArchiveBrowseFacetPanel>.
 *
 * Props are:
 * 		facetLoadUrl : URL to use to load facet content
 *
 * Sub-components are:
 * 		NoguchiArchiveBrowseFacetButton
 * 		NoguchiArchiveBrowseFacetPanel
 *
 * Uses context: NoguchiArchiveBrowseContext
 */
class NoguchiArchiveBrowseFacetList extends React.Component {
	static contextType = NoguchiArchiveBrowseContext;

	constructor(props) {
		super(props);

		initBrowseFilterList(this, props);
	};

	render() {
		let facetButtons = [];
		let filterLabel = this.context.state.availableFacets ? "Filter by: " : "Loading...";

		if(this.context.state.availableFacets) {
			for (let n in this.context.state.availableFacets) {
				facetButtons.push((<NoguchiArchiveBrowseFacetButton key={n} text={this.context.state.availableFacets[n].label_plural}
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
				<NoguchiArchiveBrowseFacetPanel open={isOpen} facetName={this.state.selected}
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
 *  	NoguchiArchiveBrowseFacetList
 */
class NoguchiArchiveBrowseFacetButton extends React.Component {
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
 *  	NoguchiArchiveBrowseFacetList
 *
 * Uses context: NoguchiArchiveBrowseContext
 */
class NoguchiArchiveBrowseFacetPanel extends React.Component {
	static contextType = NoguchiArchiveBrowseContext;
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
						<NoguchiArchiveBrowseFacetPanelItem id={'facetItem' + i} data={item} callback={this.clickFilterItem} selected={this.state.selectedFacetItems[item.id]}/>
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
 *  	NoguchiArchiveBrowseFacetPanel
 *
 * Uses context: NoguchiArchiveBrowseFacetPanel
 */
class NoguchiArchiveBrowseFacetPanelItem extends React.Component {
	static contextType = NoguchiArchiveBrowseContext;

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
 *  	NoguchiArchiveBrowse
 *
 * Uses context: NoguchiArchiveBrowseContext
 */
class NoguchiArchiveBrowseNavigation extends React.Component {
	static contextType = NoguchiArchiveBrowseContext;

	constructor(props) {
		super(props);

		this.searchRef = React.createRef();
		this.state = {
			collections: [
				{ name: "Photography Collection", id: 432 },
				{ name: "Architectural Collection", id: 436 },
				{ name: "Manuscript Collection", id: 434 },
				{ name: "Business & Legal Collection", id: 437 },
				{ name: "Noguchi Fountain & Plaza", id: 438 },
				{ name: "Publication & Press Collection", id: 442 },
			]
		}
		this.loadCollection = this.loadCollection.bind(this);
		this.loadSearch = this.loadSearch.bind(this);
	}

	/**
	 *
	 * @returns {*}
	 */
	loadCollection(e) {
		let collection_id = e.target.attributes.getNamedItem('data-id').value;
		let collection_name = e.target.innerHTML;
		let filters = {
			collection_facet: {}
		};
		filters.collection_facet[collection_id] = collection_name;
		this.context.reloadResults(filters, true);
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
		let collections = [];
		for(let i in this.state.collections) {
			collections.push((<a href='#' key={this.state.collections[i].id} data-id={this.state.collections[i].id} onClick={this.loadCollection}>{this.state.collections[i].name}</a>));
		}
		return(
			<section className="ca_nav">
				<nav className="hide-for-mobile">
					<div className="wrap text-gray">
						<form action="#" onSubmit={this.loadSearch}>
							<div className="cell text"><a href='/index.php/Browse/Archive'>Browse</a></div>
							<div className="cell"><input name="search" type="text" placeholder="Search the Archive" ref={this.searchRef}
														 className="search"/></div>
							<div className="cell">
								<div className="utility-container">
									<div className="utility utility_menu">
										<a href="#" className="trigger">All Archival Collections</a>
										<div className="options">
											{collections}
										</div>
									</div>
								</div>
							</div>
							<div className="misc">
								<div className="cell text"><a href='/index.php/ArchiveInfo/UserGuide'>User Guide</a>
								</div>
								<div className="cell text"><a href='/index.php/ArchiveInfo/About'>About<span
									className='long'> The Archive</span></a></div>
							</div>
						</form>
					</div>
				</nav>
				<nav className="show-for-mobile wrap">
					<div className="module_accordion">
						<div className="items">
							<div className="item">
								<div className="trigger small">Archive Menu</div>            
								<div className="details">
									<div className="inner">

										<div className="module_filter_bar">
											<div className="wrap text-gray">
												<form action="#" onSubmit={this.loadSearch}>
													<div className="cell"><input name="search" type="text" placeholder="Search the Archive" className="search"/></div>
													<div className="misc">
													   <a href='/index.php/Browse/Archive'>Browse</a>
													   <a href='/index.php/ArchiveInfo/UserGuide'>User Guide</a>
													   <a href='/index.php/ArchiveInfo/About'>About The Archive</a>
													</div>
												</form>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</nav>
			</section>
		);
	}
}

/**
 * Renders search results using a NoguchiArchiveBrowseResultItem component for each result.
 * Includes navigation to load additional pages on-demand.
 *
 * Sub-components are:
 * 		NoguchiArchiveBrowseResultItem
 * 		NoguchiArchiveBrowseResultLoadMoreButton
 *
 * Props are:
 * 		<NONE>
 *
 * Used by:
 *  	NoguchiArchiveBrowse
 *
 * Uses context: NoguchiArchiveBrowseContext
 */
class NoguchiArchiveBrowseResults extends React.Component {
	static contextType = NoguchiArchiveBrowseContext;

	render() {
		let resultList = [];
		if(this.context.state.resultList && (this.context.state.resultList.length > 0)) {
			for (let i in this.context.state.resultList) {
				let r = this.context.state.resultList[i];
				resultList.push(<NoguchiArchiveBrowseResultItem key={r.id} data={r}/>)
			}
		} else if (this.context.state.resultSize === 0) {
			resultList.push(<h2>No results found</h2>)
		}

		return(
			<div>
				<section className="block block-quarter-top">
					<div className="wrap">
						<div className="grid-flexbox-layout grid-ca-archive">
							{resultList}
						</div>
					</div>
				</section>
				<NoguchiArchiveBrowseResultLoadMoreButton start={this.context.state.start} itemsPerPage={this.context.state.itemsPerPage}
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
 *  	NoguchiArchiveBrowseResults
 */
class NoguchiArchiveBrowseResultLoadMoreButton extends React.Component {
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
 *  	NoguchiArchiveBrowseResults
 */
class NoguchiArchiveBrowseResultItem extends React.Component {
	render() {
		let data = this.props.data;
		let styles = {
			"backgroundImage": "url(" + data.representation + ")"
		};

		return (
			<div className="item-grid">
				<a href={data.detailUrl}>
					<div className="img-wrapper archive_thumb block-quarter">
						<div className="bg-image"
							 style={styles}></div>
					</div>
					<div className="text">
						<div className="text_position">
							<div className="ca-identifier text-gray">{data.idno}</div>
							<div className="thumb-text clamp" data-lines="3">{data.label}</div>

							<div className="text_full">
								<div className="ca-identifier text-gray">{data.idno}</div>
								<div className="thumb-text">{data.label}</div>
							</div>
						</div>
					</div>
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
		<NoguchiArchiveBrowse baseUrl={appData.baseUrl} endpoint={appData.endpoint}
							  initialFilters={appData.initialFilters}
							  browseKey={appData.key}/>, document.querySelector(selector));
}
