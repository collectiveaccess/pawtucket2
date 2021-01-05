/*jshint esversion: 6 */
import React from "react"
import ReactDOM from "react-dom";
import { initBrowseContainer, initBrowseCurrentFilterList, initBrowseFilterList, initBrowseFacetPanel } from "../../default/js/browse";
import { fetchLightboxList, addItemsToLightbox, addResultsToLightbox } from "../../default/js/lightbox";

const selector = pawtucketUIApps.PawtucketBrowse.selector;
const appData = pawtucketUIApps.PawtucketBrowse.data;
const browseConfig = pawtucketUIApps.PawtucketBrowse.data.browseConfig;
const lightboxTerminology = appData.lightboxTerminology;
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
                <PawtucketBrowseResults view={this.state.view} sort={this.state.sort} facetLoadUrl={facetLoadUrl}/>
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
			return(<h1 className="my-4">No {browseConfig.labelPlural} found</h1>);
		}else{
			return(
				<h1 className="my-4">{(this.context.state.resultSize !== null) ? ((this.context.state.resultSize== 1) ?
					"1 " + browseConfig.labelSingular : this.context.state.resultSize + " " + browseConfig.labelPlural) : <div className="text-center">Loading...</div>}</h1>
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
		return(<div className="row">
				<div className="col-md-8 bToolBar">
					{(this.context.state.statusMessage) ? <div className='row'><div className='col-sm-12 col-md-6 offset-md-3'><div className='alert alert-primary mainNotification' role='alert'>{this.context.state.statusMessage}</div></div></div> : null}

					<div className="row">
						<div className="col-md-6"><PawtucketBrowseStatistics/></div>
						<div className="col-md-6">
{/* view doesn't work yet
							<PawtucketBrowseViewList/>
*/}
							<PawtucketBrowseExportOptions/>

							<PawtucketBrowseSortOptions/>
							{(appData.isLoggedIn) ? <PawtucketBrowseLightboxOptions/> : null}
							<PawtucketBrowseSelectItemsOptions/>
						</div>
					</div>
				</div>
			</div>);
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

		this.facetPanelRefs = {};
		if (this.context.state.availableFacets) {
			for (let n in this.context.state.availableFacets) {
				this.facetPanelRefs[n] = React.createRef();
			}
		}

		if(this.context.state.availableFacets) {
			for (let n in this.context.state.availableFacets) {
				let isOpen = ((this.context.state.selectedFacet !== null) && (this.context.state.selectedFacet === n)) ? 'true' : 'false';

				// Facet button-and-panel assemblies. Each button is paired with a panel it controls
				facetButtons.push((<div key={"facet_panel_container_" + n}>
					<PawtucketBrowseFacetButton key={"facet_panel_button_" + n} text={this.context.state.availableFacets[n].label_plural}
																	name={n} callback={this.toggleFacetPanel}/>

						<PawtucketBrowseFacetPanel key={"facet_panel_" + n} open={isOpen} facetName={n}
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
 *  	PawtucketBrowseFacetList
 */
class PawtucketBrowseFacetButton extends React.Component {
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
					<div className="col-sm-12 col-md-4 bRefineFacetItem py-2" key={'facetItem' + i}>
						<PawtucketBrowseFacetPanelItem id={'facetItem' + i} data={item} callback={this.clickFilterItem} selected={this.state.selectedFacetItems[item.id]}/>
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
				<div className="bSearchWithinContainer my-2">
					<form className="form-inline my-2 my-lg-0" role="search" id="searchWithin" action="#" onSubmit={this.loadSearch}>
						<input type="text" className="form-control bSearchWithin" placeholder="Search within results..." name="search" aria-label="Search"/>
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
				viewButtonList.push(<a href='#' className='disabled' dangerouslySetInnerHTML={{__html: viewButtonIcons[i]}}></a>);
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
 *  	BrowseControls
 *
 * Uses context: BrowseContext
 */
class PawtucketBrowseSelectItemsOptions extends React.Component {
	static contextType = PawtucketBrowseContext;

	constructor(props) {
		super(props);
		this.clearSelectBrowseItems = this.clearSelectBrowseItems.bind(this);
		this.showSelectButtons = this.showSelectButtons.bind(this);
	}

	clearSelectBrowseItems() {
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
						{(this.context.state.showSelectButtons) ? <a className="dropdown-item" onClick={this.clearSelectBrowseItems}>Clear selection</a> : <a className="dropdown-item" onClick={this.showSelectButtons}>Select items</a> }

					</div>
				</div>
			</div>

		);
	}

}
class PawtucketBrowseLightboxOptions extends React.Component {
	static contextType = PawtucketBrowseContext;
	constructor(props) {
		super(props);

		this.addSelectedItemsToNewLightbox = this.addSelectedItemsToNewLightbox.bind(this);
		this.addSelectedItemsToLightbox = this.addSelectedItemsToLightbox.bind(this);
		this.addResultsToLightbox = this.addResultsToLightbox.bind(this);
		this.addResultsToNewLightbox = this.addResultsToNewLightbox.bind(this);

	}
	componentDidMount() {
		let that = this;
		fetchLightboxList(appData.baseLightboxUrl, function(data) {
			let state = that.context.state;
			state.lightboxList = data ? data : {};
			that.context.setState(state);
		});

	}

	addSelectedItemsToNewLightbox(e) {
		let that = this;
		let state = that.context.state;
		addItemsToLightbox(appData.baseLightboxUrl, null, this.context.state.selectedItems.join(';'), 'ca_objects', function(resp) {
			if (resp && resp['ok']) {
				//state.selectedItems = [];
				//state.showSelectButtons = false;
				state.lightboxList.sets[resp.set_id] = {'set_id':resp.set_id, 'label': resp.label};
				state.statusMessage = "Added Items To New " + lightboxTerminology.singular;
				that.context.setState(state);
				setTimeout(function() {
					state.statusMessage = '';
					that.context.setState(state);
				}, 2000);
				return;
			}
			alert("Could not add item to lightbox: " + resp['err']);
		});
		e.preventDefault();
	}

	addSelectedItemsToLightbox(e) {
		let that = this;
		let state = that.context.state;
		let setID = e.target.attributes.getNamedItem('data-set-id').value;
		addItemsToLightbox(appData.baseLightboxUrl, setID, this.context.state.selectedItems.join(';'), 'ca_objects', function(resp) {
			if (resp && resp['ok']) {
				state.statusMessage = "Added Items To " + lightboxTerminology.singular + ": " + resp.label;
				that.context.setState(state);
				setTimeout(function() {
					state.statusMessage = '';
					that.context.setState(state);
				}, 2000);
				return;
			}
			alert("Could not add item to lightbox: " + resp['err']);
		});
		e.preventDefault();
	}

	addResultsToLightbox(e) {
		let that = this;
		let state = that.context.state;
		let setID = e.target.attributes.getNamedItem('data-set-id').value;
		addResultsToLightbox(appData.baseLightboxUrl, setID, 'ca_objects', function(resp) {
			if (resp && resp['ok']) {
				state.statusMessage = "Added Results To " + lightboxTerminology.singular;
				that.context.setState(state);
				setTimeout(function() {
					state.statusMessage = '';
					that.context.setState(state);
				}, 2000);
				return;
			}
			alert("Could not add results to lightbox: " + resp['err']);
		});
		e.preventDefault();
	}

	addResultsToNewLightbox(e) {
		let that = this;
		let state = that.context.state;
		addResultsToLightbox(appData.baseLightboxUrl, null, 'ca_objects', function(resp) {
			if (resp && resp['ok']) {
				state.lightboxList.sets[resp.set_id] = {'set_id':resp.set_id, 'label': resp.label};
				state.statusMessage = "Added Results To New " + lightboxTerminology.singular;
				that.context.setState(state);
				setTimeout(function() {
					state.statusMessage = '';
					that.context.setState(state);
				}, 2000);
				return;
			}
			alert("Could not add results to new lightbox: " + resp['err']);
		});
		e.preventDefault();
	}

	render() {
		let lightboxes = [];
		if (this.context.state.lightboxList && this.context.state.lightboxList.sets) {
			for(let k in this.context.state.lightboxList.sets) {
				let l = this.context.state.lightboxList.sets[k];
				lightboxes.push(<a className="dropdown-item" key={k} href="#" data-set-id={l.set_id} onClick={(this.context.state.selectedItems.length > 0) ? this.addSelectedItemsToLightbox : this.addResultsToLightbox}><ion-icon name="add"></ion-icon> {l.label}</a>);
			}
		}

		return (
			<div id="bSelectOptions">
				<div className="dropdown show">
					<a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<ion-icon name="folder"></ion-icon>
					</a>

					<div className="dropdown-menu" aria-labelledby="dropdownMenuLink">
						<a className="dropdown-item" onClick={(this.context.state.selectedItems.length > 0) ? this.addSelectedItemsToNewLightbox : this.addResultsToNewLightbox}><ion-icon name="add"></ion-icon> Create new {lightboxTerminology.singular} from {(this.context.state.selectedItems.length > 0) ? "selected" : "results"}</a>
						{(lightboxes.length) ? <div className="dropdown-divider"></div> : null}
						{(lightboxes.length) ? (this.context.state.selectedItems.length > 0) ? <><div className="dropdown-header">Add Selected Items To:</div><div className="dropdown-divider"></div></> : <><div className="dropdown-header">Add Results To {lightboxTerminology.singular}:</div><div className="dropdown-divider"></div></> : null}
						{lightboxes}

					</div>
				</div>
			</div>

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
 *  	PawtucketBrowse
 *
 * Uses context: PawtucketBrowseContext
 */
class PawtucketBrowseExportOptions extends React.Component {
	static contextType = PawtucketBrowseContext;
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
				exportOptions.push(<a className="dropdown-item" href={appData.baseUrl + '/' + appData.endpoint + '/getResult/1/download/1/view/' + r.type + '/export_format/' + r.code + '/key/' + this.context.state.key + '/record_ids/' + ((this.context.state.selectedItems.length > 0) ? this.context.state.selectedItems.join(';') : "")} key={i}>{r.name}</a>);
			}
		}

		return (
			<div id="bExportOptions">
				<div className="dropdown show">
					<a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<ion-icon name="download"></ion-icon>
				  </a>

				  <div className="dropdown-menu" aria-labelledby="dropdownMenuLink">
					{(this.context.state.selectedItems.length > 0) ? <><div className="dropdown-header">Export Selected Items As:</div><div className="dropdown-divider"></div></> : null}
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
 *  	PawtucketBrowse
 *
 * Uses context: PawtucketBrowseContext
 */
class PawtucketBrowseSortOptions extends React.Component {
	static contextType = PawtucketBrowseContext;
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
		sortConfig = browseConfig.sortBy;
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
							<div className="col-md-8 bResultList">
								<div className="row">
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
 *  	PawtucketBrowseResults
 */
class PawtucketBrowseResultItem extends React.Component {
	static contextType = PawtucketBrowseContext;

	constructor(props) {
		super(props);

		this.selectBrowseItem = this.selectBrowseItem.bind(this);
	}

	selectBrowseItem(e) {

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
					<div className="col-sm-6 col-md-3">
						<div className={'card mb-4 bResultImage' + ((this.context.state.selectedItems.includes(parseInt(data.id))) ? ' selected' : '')} ref={this.props.scrollToRef}>
							<a href={detail_url}><div dangerouslySetInnerHTML={{__html: data.representation}}/></a>
							<div className='card-body mb-2'>
								<a href={detail_url} dangerouslySetInnerHTML={{__html: data.caption}}></a>
								{(this.context.state.showSelectButtons) ?
                  <div className='float-left'>
                    <a onClick={this.selectBrowseItem} data-item_id={data.id} className={'selectItem' + ((this.context.state.selectedItems.includes(parseInt(data.id))) ? ' selected' : '')} role='button' aria-expanded='false' aria-controls='Select item'>
                      <ion-icon name='checkmark-circle' data-item_id={data.id}></ion-icon>
                    </a>
                  </div>
                : null}
							</div>
							<div className='card-footer bSetsSelectMultiple collapse text-right'><input type='checkbox' name='object_ids[]' value='{$vn_id}'/></div>
						</div>
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
