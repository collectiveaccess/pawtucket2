/*jshint esversion: 6 */
import React from "react"
import ReactDOM from "react-dom";
import { initBrowseContainer, initBrowseCurrentCriteriaList, initBrowseFilterList, initBrowseFilterPanel, fetchFacetValues } from "../../default/js/browse";

const selector = pawtucketUIApps.NoguchiArchiveBrowse.selector;
const appData = pawtucketUIApps.NoguchiArchiveBrowse.data;

/**
 * Component context making NoguchiArchiveBrowse internals accessible to all subcomponents
 *
 * @type {React.Context}
 */
const NoguchiArchiveBrowseContext = React.createContext();

/**
 * Top-level container for browse interface
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
				<main className="ca archive archive_landing">
					<NoguchiArchiveBrowseIntro headline={this.props.title} description={this.props.description}/>

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
 * 		headline
 * 		description
 */
class NoguchiArchiveBrowseIntro extends React.Component {
	render() {
		if (!this.props.headline || (this.props.headline.length === 0)) {
			return (<section className="intro"></section>);
		}
		return (<section className="intro">
			<div className="wrap block-large">
				<div className="wrap-max-content">
					<div className="block-half subheadline-bold text-align-center">{this.props.headline}</div>
					<div className="block-half body-text-l">{this.props.description}</div>
				</div>
			</div>
		</section>)
	}
}

/**
 * Browse result statistics display. Stats include a # results found indicator. May embed other
 * stats such as a list of currently applied browse criteria (via NoguchiArchiveBrowseCurrentCriteriaList)
 *
 * Props are:
 * 		<NONE>>
 */
class NoguchiArchiveBrowseStatistics extends React.Component {
	render() {
		return(<div className="current">
			<div className="body-sans">{(this.context.state.resultSize > 0) ? ((this.context.state.resultSize== 1) ?
				"Showing 1 Result"
				:
				"Showing " + this.context.state.resultSize + " Results") : "Loading..."}.</div>

				<NoguchiArchiveBrowseCurrentCriteriaList/>
		</div>
		);
	}
}
NoguchiArchiveBrowseStatistics.contextType = NoguchiArchiveBrowseContext;

/**
 * Display of current browse criteria. Each criterion includes a delete criterion button.
 *
 * Props are:
 * 		criteria
 * 		facetList
 */
class NoguchiArchiveBrowseCurrentCriteriaList extends React.Component {
	constructor(props) {
		super(props);

		initBrowseCurrentCriteriaList(this, props);
	}

	render() {
		let criteriaList = [];
		if(this.context.state.criteria) {
			for (let f in this.context.state.criteria) {
				let cv =  this.context.state.criteria[f];
				for(let c in cv) {
					let label = cv[c];
					let facetLabel = (this.context.state.facetList && this.context.state.facetList[f]) ? this.context.state.facetList[f]['label_singular'] : "";
					criteriaList.push((<a href='#'
										  className='browseRemoveFacet'><span className="">{facetLabel}</span>: {label}
						<span onClick={this.removeCriteria}
							  data-facet={f}
							  data-value={c}>&times;</span></a>));
				}
			}
		}
		return(<div className="tags">
			{criteriaList}
		</div>);
	}
}
NoguchiArchiveBrowseCurrentCriteriaList.contextType = NoguchiArchiveBrowseContext;

/**
 * Container for display and editing of applied browse filters. This component provides markup to
 *
 */
class NoguchiArchiveBrowseFilterControls extends React.Component {
	render() {
		return(
				<section className="ca_filters">
					<div className="wrap">
						<div className="filters_bar">
							<NoguchiArchiveBrowseStatistics/>
							<NoguchiArchiveBrowseFilterList facetLoadUrl={this.props.facetLoadUrl}/>
						</div>
					</div>
				</section>);
	}
}
NoguchiArchiveBrowseFilterControls.contextType = NoguchiArchiveBrowseContext;

/**
 *
 *
 * Props are:
 * 		facetLoadUrl
 */
class NoguchiArchiveBrowseFilterList extends React.Component {
	constructor(props) {
		super(props);
		initBrowseFilterList(this, props);
	};

	render() {
		let facetButtons = [];
		let filterLabel = this.context.state.availableFacets ?  "Filter by: " : "Loading...";

		if(this.context.state.availableFacets) {
			for (let n in this.context.state.availableFacets) {
				facetButtons.push((<NoguchiArchiveBrowseFilterButton text={this.context.state.availableFacets[n].label_plural}
															  name={n}
															  callback={this.toggleFilterPanel}/>));
			}
		}

		let isOpen = (this.state.selected !== null) ? 'true' : 'false';

		return(
			<div className="options-filter-widget">
				<div className="options text-gray">
					<span className="caption-text">{filterLabel}</span>
					{facetButtons}
				</div>
				<NoguchiArchiveBrowseFilterPanel open={isOpen} facetName={this.state.selected}
										  facetLoadUrl={this.props.facetLoadUrl} ref={this.filterPanelRef}
										  loadResultsCallback={this.context.loadResultsCallback}
										  closeFilterPanelCallback={this.closeFilterPanel}/>
			</div>
		)
	}
}
NoguchiArchiveBrowseFilterList.contextType = NoguchiArchiveBrowseContext;

/**
 *
 *
 * Props are:
 * 		name
 * 		text
 * 		callback
 */
class NoguchiArchiveBrowseFilterButton extends React.Component {
	render() {
		return(<a href="#" data-option={this.props.name} onClick={this.props.callback}>{this.props.text}</a>);
	}
}

/**
 *
 */
class NoguchiArchiveBrowseFilterPanel extends React.Component {
	constructor(props) {
		super(props);
		initBrowseFilterPanel(this, props);
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
				let id = 'facetItem' + i;
				options.push((
					<li>
						<div className="checkbox">
							<input id={id} value={item.id} data-label={item.label}  className="option-input" type="checkbox" onClick={this.clickFilterItem}/>
							<label htmlFor={id}>
								<span className="title">
									<a href='#'>
										{item.label} &nbsp;
										<span className="number">({item.content_count})</span>
									</a>
								</span>
							</label>
						</div>
					</li>
				));
			}
		}

		return(<div className="option_values wrap-negative" style={styles}>
					<div className="arrow"></div>
					<div className="inner">
						<div className="inner-crop">
							<div className="wrap">
								<ul className="ul-options" data-values="type_facet">
									{options}
								</ul>
								<a className="button load-more" href="#" onClick={this.applyFilters}>Apply</a>
							</div>
						</div>
					</div>
			</div>);
	}
}
NoguchiArchiveBrowseFilterPanel.contextType = NoguchiArchiveBrowseContext;

/**
 *
 */
class NoguchiArchiveBrowseNavigation extends React.Component {
	constructor(props) {
		super(props);

		this.loadCollection = this.loadCollection.bind(this);

		this.state = {
			collections: [
				{ name: "Photography Collection", id: 432 },
				{ name: "Architectural Collection", id: 436 },
				{ name: "Manuscript Collection", id: 434 },
				{ name: "Business & Legal Collection", id: 437 },
				{ name: "Noguchi Foundation & Plaza", id: 438 },
				{ name: "Publication & Press Collection", id: 442 },
			]
		}
	}

	/**
	 *
	 * @returns {*}
	 */
	loadCollection(e) {
		let collection_id = e.target.attributes.getNamedItem('data-id').value;
		let collection_name = e.target.innerHTML;
		let criteria = {
			collection_facet: {}
		};
		criteria.collection_facet[collection_id] = collection_name;
		this.context.reloadResults(criteria, true);
	}

	render() {
		let collections = [];
		for(let i in this.state.collections) {
			collections.push((<a href='#' data-id={this.state.collections[i].id} onClick={this.loadCollection}>{this.state.collections[i].name}</a>));
		}
		return(
			<section className="ca_nav">
				<nav className="hide-for-mobile">
					<div className="wrap text-gray">
						<form action="/index.php/Search/archive">
							<div className="cell text"><a href='/index.php/Browse/Archive'>Browse</a></div>
							<div className="cell"><input name="search" type="text" placeholder="Search the Archive"
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
			</section>
		);
	}
}
NoguchiArchiveBrowseNavigation.contextType = NoguchiArchiveBrowseContext;

/**
 *
 */
class NoguchiArchiveBrowseResults extends React.Component {
	render() {
		let resultList = [];
		for (let i in this.context.state.resultList) {
			let r = this.context.state.resultList[i];
			resultList.push(<NoguchiArchiveBrowseResultItem key={r.id} data={r}/>)
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
NoguchiArchiveBrowseResults.contextType = NoguchiArchiveBrowseContext;

/**
 *
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
 *
 */
class NoguchiArchiveBrowseResultItem extends React.Component {
	render() {
		let data = this.props.data;
		let styles = {
			"backgroundImage": "url(" + data.representation + ")"
		};
		let detail_url = "/index.php/Detail/archival/" + data.id;	// TODO: generalize

		return (
			<div className="item-grid">
				<a href={detail_url}>
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


ReactDOM.render(
	<NoguchiArchiveBrowse baseUrl={appData.baseUrl} endpoint={appData.endpoint} initialCriteria={appData.initialCriteria} title={appData.title} description={appData.description}/>, document.querySelector(selector));
