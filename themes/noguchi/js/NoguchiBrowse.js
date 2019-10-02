import React from "react"
import ReactDOM from "react-dom";
import {initialState, fetchResults, fetchFacetValues} from "../../default/js/browse";



const selector = pawtucketUIApps.NoguchiBrowse.selector;
const appData = pawtucketUIApps.NoguchiBrowse.data;

/**
 *
 */
class NoguchiBrowse extends React.Component{
	constructor(props) {
		super(props);
		let that = this;

		this.state = initialState();
		if(props.initialCriteria) {
			this.state.criteria = props.initialCriteria;
		}

		this.loadResults(function(newState) {
			that.setState(newState);
		});

		this.loadResults = this.loadResults.bind(this);
		this.loadMoreResults = this.loadMoreResults.bind(this);
		this.reloadResults = this.reloadResults.bind(this);
		this.loadMoreRef = React.createRef();
	};

	/**
	 *
	 * @param callback
	 */
	loadResults(callback) {
		let offset = (this.state.start + this.state.itemsPerPage);
		let criteriaString = this._getCriteriaString(this.state.criteria);
		fetchResults(this.props.baseUrl + '/' + this.props.endpoint + '/s/' +
				offset + (this.state.key ? '/key/' + this.state.key : '') + (criteriaString ? '/facets/' +
				criteriaString : ''), function(newState) {
			callback(newState);
		});
	};

	/**
	 *
	 * @param e
	 */
	loadMoreResults(e) {
		let that = this;
		if(this.loadMoreRef && this.loadMoreRef.current) {
			this.loadMoreText = this.loadMoreRef.current.innerHTML;
			this.loadMoreRef.current.innerHTML = 'LOADING';
		}

		this.loadResults(function(newState) {
			let state = that.state;
			state.resultList.push(...newState.resultList);
			state.start += state.itemsPerPage;
			that.setState(state);
			that.loadMoreRef.current.innerHTML = that.loadMoreText;
		});
		e.preventDefault();
	};

	/**
	 *
	 * @param url
	 */
	reloadResults(criteria) {
		let that = this;
		let state = this.state;

		for(let k in criteria) {
			state.criteria[k] = criteria[k];
		}
		state.key = null;
		state.start = 0;
		this.setState(state);
		this.loadResults(function(newState) {
			that.setState(newState);
		});
	};

	/**
	 *
	 * @param criteria
	 * @returns {string}
	 * @private
	 */
	_getCriteriaString(criteria) {
		let acc = [];

		for(let k in criteria) {
			if(criteria[k] && (criteria[k].length > 0)) {
				acc.push(k + ':' + (Array.isArray(criteria[k]) ? criteria[k].join('|') : criteria[k]));
			}
		}
		return acc.join(';');
	};

	render() {
		let facetLoadUrl = this.props.baseUrl + '/' + this.props.endpoint + (this.state.key ? '/key/' + this.state.key : '');
		return(
			<main className="ca archive archive_landing">
				<NoguchiBrowseIntro headline={this.props.title} description={this.props.description}/>

				<NoguchiBrowseFilterList facetList={this.state.facetList} facetLoadUrl={facetLoadUrl}
										 loadResultsCallback={this.reloadResults}/>
				<NoguchiBrowseStatistics size={this.state.resultSize} criteria={this.state.criteria}
										 criteriaForDisplay={this.state.criteriaForDisplay}
										 loadResultsCallback={this.reloadResults}/>

				<NoguchiBrowseResults results={this.state.resultList} start={this.state.start}
									  size={this.state.resultSize} itemsPerPage={this.state.itemsPerPage}
									  loadMoreHandler={this.loadMoreResults} loadMoreRef={this.loadMoreRef}/>
			</main>
		);
	}
}

/**
 *
 */
class NoguchiBrowseIntro extends React.Component {
	constructor(props) {
		super(props);
	}
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
 *
 */
class NoguchiBrowseStatistics extends React.Component {
	render() {
		return(<div className="current">
			<div className="body-sans">{(this.props.size > 0) ? ((this.props.size == 1) ?
				"Showing 1 Result"
				:
				"Showing " + this.props.size + " Results") : "Loading..."}.</div>

			<NoguchiBrowseCurrentCriteriaList criteria={this.props.criteria}
											  criteriaForDisplay={this.props.criteriaForDisplay}
											  loadResultsCallback={this.props.loadResultsCallback}/>
		</div>);
	}
}

/**
 *
 */
class NoguchiBrowseCurrentCriteriaList extends React.Component {
	constructor(props) {
		super(props);
		this.removeCriteria = this.removeCriteria.bind(this);
	}

	removeCriteria(e) {
		let targetFacet = e.target.attributes.getNamedItem('data-facet').value;
		let targetValue = e.target.attributes.getNamedItem('data-value').value;

		let criteria = this.props.criteria;
		if (criteria[targetFacet]) {
			if(Array.isArray(criteria[targetFacet])) {
				for (let k in criteria[targetFacet]) {
					if(criteria[targetFacet][k] == targetValue) {
						delete(criteria[targetFacet][k]);
					}
				}
			} else if(criteria[targetFacet] == targetValue) {
				delete(criteria[targetFacet]);
			}
		}

		this.props.loadResultsCallback(criteria);
	}

	render() {
		let criteriaList = [];
		if(this.props.criteria) {
			for (let c in this.props.criteria) {
				let label = this.props.criteria[c];
				criteriaList.push((<a href='#'
									  className='browseRemoveFacet'>{c}: {label}
					<span onClick={this.removeCriteria}
						  data-facet={c}
						  data-value={this.props.criteria[c]}>&times;</span></a>));
			}
		}
		return(<div className="tags">
			{criteriaList}
		</div>);
	}
}

/**
 *
 */
class NoguchiBrowseFilterList extends React.Component {
	constructor(props) {
		super(props);
		this.filterPanelRef = React.createRef();
		this.state = {
			selected: null
		};

		this.toggleFilterPanel = this.toggleFilterPanel.bind(this);
		this.closeFilterPanel = this.closeFilterPanel.bind(this);
	};

	/**
	 *
	 * @param e Event
	 */
	toggleFilterPanel(e) {
		let targetOpt = e.target.attributes.getNamedItem('data-option').value;
		let state = this.state;

		if (targetOpt === state.selected) {
			state.selected = null;			// toggle closed
		} else {
			state.selected = targetOpt;		// toggle open to new facet
		}
		this.setState(state);
		e.preventDefault();
	}

	closeFilterPanel() {
		let state = this.state;
		state.selected = null;
		this.setState(state);
	}

	render() {
		let facetButtons = [];
		let filterLabel = this.props.facetList ?  "Filter by: " : "Loading...";

		if(this.props.facetList) {
			for (let n in this.props.facetList) {
				facetButtons.push((<NoguchiBrowseFilterButton text={this.props.facetList[n].label_plural}
															  name={n}
															  callback={this.toggleFilterPanel}/>));
			}
		}

		let isOpen = (this.state.selected !== null) ? 'true' : 'false';

		return(
			<section className="ca_filters">
				<NoguchiBrowseNavigation/>
				<div className="options-filter-widget">
					<div className="options text-gray">
						<span className="caption-text">{filterLabel}</span>
						{facetButtons}
					</div>
					<NoguchiBrowseFilterPanel open={isOpen} facetName={this.state.selected}
											  facetLoadUrl={this.props.facetLoadUrl} ref={this.filterPanelRef}
											  loadResultsCallback={this.props.loadResultsCallback}
											  closeFilterPanelCallback={this.closeFilterPanel}/>
				</div>
			</section>
		)
	}
}

/**
 *
 */
class NoguchiBrowseFilterButton extends React.Component {
	render() {
		return(<a href="#" data-option={this.props.name} onClick={this.props.callback}>{this.props.text}</a>);
	}
}

/**
 *
 */
class NoguchiBrowseFilterPanel extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			facet: null,
			facetContent: null,
			selectedFacetItems: []
		};

		this.loadFacetContent = this.loadFacetContent.bind(this);
		this.clickFilterItem = this.clickFilterItem.bind(this);
		this.applyFilters = this.applyFilters.bind(this);
	};

	/**
	 *
	 * @param facet Name of facet to load
	 */
	loadFacetContent(facet) {
		let that = this;
		fetchFacetValues(this.props.facetLoadUrl + '/facet/' + facet, function(resp) {
			let state = that.state;
			state.facet = facet;
			state.facetContent = resp.content;
			state.selectedFacetItems = {};	// reset selected items
			that.setState(state);
		});
	};

	/**
	 *
	 */
	clickFilterItem(e) {
		let targetItem = e.target.attributes.getNamedItem('value').value;
		let isChecked = e.target.checked;

		let state = this.state;
		state.selectedFacetItems[targetItem] = isChecked;
		this.setState(state);
	};

	/**
	 *
	 */
	applyFilters(facet) {
		let activeFilters = [];
		for(let k in this.state.selectedFacetItems) {
			if(this.state.selectedFacetItems[k]) { activeFilters.push(k); }
		}
		let filterBlock = {};
		filterBlock[this.state.facet] = activeFilters;
 		this.props.loadResultsCallback(filterBlock);
 		this.props.closeFilterPanelCallback();
	};

	/**
	 *  Load facet content on change in facetName prop
	 *
	 * @param prevProps
	 */
	componentDidUpdate(prevProps) {
		if(prevProps.facetName !== this.props.facetName) {	// trigger load of facet content
			this.loadFacetContent(this.props.facetName);
		}
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
				let id = 'facetItem' + i ;
				options.push((
					<li>
						<div className="checkbox">
							<input id={id} value={item.id} className="option-input" type="checkbox" onClick={this.clickFilterItem}/>
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

/**
 *
 */
class NoguchiBrowseNavigation extends React.Component {
	render() {
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
											<a href='/index.php/Browse/archive/facet/collection_facet/id/432'>Photography
												Collection</a>
											<a href='/index.php/Browse/archive/facet/collection_facet/id/434'>Manuscript
												Collection</a>
											<a href='/index.php/Browse/archive/facet/collection_facet/id/436'>Architectural
												Collection</a>
											<a href='/index.php/Browse/archive/facet/collection_facet/id/437'>Business &
												Legal Collection</a>
											<a href='/index.php/Browse/archive/facet/collection_facet/id/438'>Noguchi
												Fountain & Plaza</a>
											<a href='/index.php/Browse/archive/facet/collection_facet/id/442'>Publication
												& Press Collection</a>
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

/**
 *
 */
class NoguchiBrowseResults extends React.Component {
	render() {
		let resultList = [];
		for (let i in this.props.results) {
			let r = this.props.results[i];
			resultList.push(<NoguchiBrowseResultItem key={r.id} data={r}/>)
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
				<NoguchiBrowseResultLoadMoreButton start={this.props.start} itemsPerPage={this.props.itemsPerPage}
												   size={this.props.size} loadMoreHandler={this.props.loadMoreHandler}
												   loadMoreRef={this.props.loadMoreRef}/>
			</div>
		);
	}
}

/**
 *
 */
class NoguchiBrowseResultLoadMoreButton extends React.Component {
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
class NoguchiBrowseResultItem extends React.Component {
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
	<NoguchiBrowse baseUrl={appData.baseUrl} endpoint={appData.endpoint} initialCriteria={appData.initialCriteria} title={appData.title} description={appData.description}/>, document.querySelector(selector));
