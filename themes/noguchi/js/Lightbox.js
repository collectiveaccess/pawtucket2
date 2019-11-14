/*jshint esversion: 6 */
import React from "react"
import ReactDOM from "react-dom";
import EasyEdit from 'react-easy-edit';
import { confirmAlert } from 'react-confirm-alert';
import 'react-confirm-alert/src/react-confirm-alert.css';

import { initBrowseContainer, initBrowseCurrentFilterList, initBrowseFilterList, initBrowseFacetPanel, initBrowseResults } from "../../default/js/browse";
import { fetchLightboxList, addLightbox, editLightbox, deleteLightbox } from "../../default/js/lightbox";

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
 * 		LightboxFilterControls
 * 		LightboxResults
 */
class Lightbox extends React.Component{
	constructor(props) {
		super(props);
		initBrowseContainer(this, props);

		this.state['set_id'] = null;
		this.state['filters'] = null;

		this.componentDidMount = this.componentDidMount.bind(this);
		this.newLightbox = this.newLightbox.bind(this);
		this.cancelNewLightbox = this.cancelNewLightbox.bind(this);
		this.saveNewLightbox = this.saveNewLightbox.bind(this);
		this.deleteLightbox = this.deleteLightbox.bind(this);

		this.dontUseDefaultKey = true;
	}

	componentDidMount() {
		let that = this;
		fetchLightboxList(this.props.baseUrl, function(data) {
			let state = that.state;
			state.lightboxList = data;
			that.setState(state);
		});
	}

	newLightbox(e) {
		let state = this.state;
		state.lightboxList.sets[-1] = {"set_id": -1, "label": ""};
		this.setState(state);
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
			<main className="ca archive archive_landing nomargin">
				<LightboxIntro headline={this.state.introduction.title} description={this.state.introduction.description}/>
				<LightboxNavigation/>
				<LightboxFilterControls facetLoadUrl={facetLoadUrl}/>
				<LightboxResults view={this.state.view}/>
			</main>)
			:
			(<main className="ca archive archive_landing nomargin"><LightboxList lightboxes={this.state.lightboxList}/></main>);
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

		this.context.setState(state);
	}
	render() {
		return(
			<div className="current"><div className='wrap'>
				<div className="body-sans"><a href='#' onClick={this.backToList}>Back to set list</a></div></div>
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
		return(<div className="current">
			<div className="body-sans">{(this.context.state.resultSize !== null) ? ((this.context.state.resultSize== 1) ?
				"Showing 1 Result."
				:
				"Showing " + this.context.state.resultSize + " Results.") : ""}</div>

				<LightboxCurrentFilterList/>
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
					let facetLabel = (this.context.state.facetList && this.context.state.facetList[f]) ? this.context.state.facetList[f]['label_singular'] : "";
					filterList.push((<a key={ f + '_' + c } href='#' className='browseRemoveFacet' onClick={this.removeFilter} data-facet={f} data-value={c}><span dangerouslySetInnerHTML={{__html: label}}></span> <span onClick={this.removeFilter} data-facet={f} data-value={c}>&times;</span></a>));
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
class LightboxFilterControls extends React.Component {
	static contextType = LightboxContext;

	render() {
		let c  = (this.context.state.resultSize === null);
		return(
				<section className="ca_filters">
					<div className="wrap">
						<div className="filters_bar">
							<LightboxStatistics/>
							<LightboxFacetList facetLoadUrl={this.props.facetLoadUrl}/>
						</div>
					</div>
				</section>);
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
		let facetButtons = [], facetPanels = [];
		let filterLabel = this.context.state.availableFacets ? "Filter by: " : "";

		if(this.context.state.availableFacets) {
			for (let n in this.context.state.availableFacets) {
				if(!this.facetPanelRefs || !this.facetPanelRefs[n]) { continue; }
				facetButtons.push((<LightboxFacetButton key={n} text={this.context.state.availableFacets[n].label_plural}
															  name={n} callback={this.toggleFacetPanel}/>));

				let isOpen = ((this.context.state.selectedFacet !== null) && (this.context.state.selectedFacet === n)) ? 'true' : 'false';
				facetPanels.push((<LightboxFacetPanel open={isOpen} facetName={n} key={n}
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
 *  	LightboxFacetList
 */
class LightboxFacetButton extends React.Component {
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

		let options = [];
		if(this.state.facetContent) {
			// Render facet options when available
			for (let i in this.state.facetContentSort) {
				let item = this.state.facetContent[this.state.facetContentSort[i]];

				options.push((
					<li key={'facetItem' + i}>
						<LightboxFacetPanelItem id={'facetItem' + i} data={item} callback={this.clickFilterItem} selected={this.state.selectedFacetItems[item.id]}/>
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

		return(<div className="checkbox">
			<input id={id} value={data.id} data-label={data.label}  className="option-input" type="checkbox" checked={this.props.selected} onChange={this.props.callback}/>
			<label htmlFor={id}>
				<span className="title">
					<span dangerouslySetInnerHTML={{__html: data.label}}></span> &nbsp;
					<span className="number">({data.content_count})</span>
				</span>
			</label>
		</div>);
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
		if((this.context.state.resultSize === null) && !this.context.state.loadingMore) {
			resultList.push((<div className="spinner">
				<div className="bounce1"></div>
				<div className="bounce2"></div>
				<div className="bounce3"></div>
			</div>));
		} else if(this.context.state.resultList && (this.context.state.resultList.length > 0)) {
			for (let i in this.context.state.resultList) {
				let r = this.context.state.resultList[i];
				let ref = (parseInt(r.id) === parseInt(this.context.state.scrollToResultID)) ? this.scrollToRef : null;

				resultList.push(<LightboxResultItem view={this.props.view} key={r.id} data={r} scrollToRef={ref}/>)
			}
		} else if (this.context.state.resultSize === 0) {
			resultList.push(<h2 key='no_results'>No results found</h2>)
		}

		switch(this.props.view) {
			default:
				return (
					<div>
						<section className="wrap block block-quarter-top grid">
							<div className="wrap">
								<div className="grid-flexbox-layout grid-ca-archive">
									{resultList}
								</div>
							</div>
						</section>
						<LightboxResultLoadMoreButton start={this.context.state.start}
																  itemsPerPage={this.context.state.itemsPerPage}
																  size={this.context.state.totalSize}
																  loadMoreHandler={this.context.loadMoreResults}
																  loadMoreRef={this.context.loadMoreRef}/>
					</div>);
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
		if ((this.props.start + this.props.itemsPerPage) < this.props.size)  {
			let loadingText = (this.context.state.resultSize === null) ? "LOADING" : "Load More +";

			return (<section className="block text-align-center">
				<a className="button load-more" href="#" onClick={this.props.loadMoreHandler} ref={this.props.loadMoreRef}>{loadingText}</a>
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
 *  	LightboxResults
 */
class LightboxResultItem extends React.Component {
	render() {
		let data = this.props.data;
		let styles = {
			"backgroundImage": "url(" + data.representation + ")"
		};

		switch(this.props.view) {
			default:
				return(
						<div className="item-grid" ref={this.props.scrollToRef}>
							<a href={data.detailUrl}>
								<div className="img-wrapper archive_thumb block-quarter">
									<div className="bg-image"
										 style={styles}></div>
								</div>
								<div className="text">
									<div className="text_position">
										<div className="ca-identifier text-gray">{data.idno}</div>
										<ClampLines
											text={data.label}
											id={"browse_label_" + data.id}
											lines="3"
											ellipsis="..."
											buttons={false}
											className="thumb-text clamp"
											innerElement="div"
										/>

										<div className="text_full">
											<div className="ca-identifier text-gray">{data.idno}</div>
											<div className="thumb-text">{data.label}</div>
										</div>
									</div>
								</div>
							</a>
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

		return(
			<main className="ca my_documents_landing">
				<section className="block block-large-top">
					<div className="wrap-max-content">
						<div className="block">
							<h1 className="headline-s text-align-center">My Documents</h1>
						</div>
					</div>
				</section>
				<section className="block block-top">
					<div className="wrap results">

						<div className="block-half-top">
							<div className="block-half columns text-align-right">
								<a href='#' className='button' onClick={this.context.newLightbox}>New Collection +</a>
							</div>

							{lightboxes}
						</div>

					</div>
				</section>
			</main>
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
		state.filters['_search']['ca_sets.set_id:' + set_id] = 'Set ' + set_id;
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
		editLightbox(this.context.props.baseUrl, {'name': name, set_id: this.props.data.set_id }, function(resp) {
			// TODO: display potential errors
			//console.log("got", resp);
		});
	}

	deleteLightboxConfirm(e) {
		let that = this;
		confirmAlert({
			customUI: ({ onClose }) => {
				return (
					<div className='col info text-gray'>
						<p>Really delete lightbox <em>{this.props.data.label}</em>?</p>

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
			return (<div className="block-half columns">
				<div className="col title">
					<EasyEdit
						type="text"
						onSave={this.saveLightboxEdit}
						saveButtonLabel="Save"
						cancelButtonLabel="Cancel"
						attributes={{name: "name", id: "lightbox_name" + this.props.data.set_id}}
						value={this.props.data.label}
					/>
				</div>
				<div className="col infoNarrow text-gray">{count_text}</div>
				<div className="col info text-gray">
					<div className="spinner">
						<div className="bounce1"></div>
						<div className="bounce2"></div>
						<div className="bounce3"></div>
					</div>
				</div>
			</div>);
		} else if(this.props.data.set_id > 0) {
			return (<div className="block-half columns">
				<div className="col title">
					<EasyEdit
						type="text"
						onSave={this.saveLightboxEdit}
						saveButtonLabel="Save"
						cancelButtonLabel="Cancel"
						attributes={{name: "name", id: "lightbox_name" + this.props.data.set_id}}
						value={this.props.data.label}
					/>
				</div>
				<div className="col infoNarrow text-gray">{count_text}</div>
				<div className="col info text-gray">
					<a href='#' data-set_id={this.props.data.set_id} className='button'
					   onClick={this.openLightbox}>View</a>
					&nbsp;
					<a href='#' data-set_id={this.props.data.set_id} className='button'
					   onClick={this.deleteLightboxConfirm}>Delete</a>
				</div>
			</div>);
		} else{
			return(<div className="block-half columns">
				<div className="col title">
					<EasyEdit ref={this.props.newLightboxRef}
							  type="text"
							  onSave={this.saveNewLightbox}
							  onCancel={this.context.cancelNewLightbox}
							  saveButtonLabel="Save"
							  cancelButtonLabel="Cancel"
							  placeholder="Enter lightbox name"
							  attributes={{name: "name", id: "lightbox_name" + this.props.data.set_id}}
							  value={this.props.data.label}
					/>
					<div>{this.state.newLightboxError}</div>
				</div>
				<div className="col infoNarrow text-gray"></div>
				<div className="col info text-gray">

				</div>
			</div>);
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
							  initialFilters={appData.initialFilters} view={appData.view}
							  browseKey={appData.key}/>, document.querySelector(selector));
}
