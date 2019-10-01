import React from "react"
import ReactDOM from "react-dom";
import {initialState, fetchResults } from "../../default/js/browse";



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

		let criteriaString = (this.props.initialCriteria) ?  this._getCriteriaString(this.props.initialCriteria) : '';
		fetchResults(this.props.baseUrl + "/" + this.props.endpoint + (criteriaString ? '/s/0/facets/' + criteriaString : ''), function(newState) {
			that.setState(newState);
		});
		this.loadMoreResults = this.loadMoreResults.bind(this);
		this.loadMoreRef = React.createRef();
	};

	loadMoreResults(e) {
		console.log('load more!', e);
		let that = this;
		let criteriaString = (this.props.initialCriteria) ?  this._getCriteriaString(this.props.initialCriteria) : '';
		let offset = (this.state.start + this.state.itemsPerPage);

		if(this.loadMoreRef && this.loadMoreRef.current) {
			this.loadMoreText = this.loadMoreRef.current.innerHTML;
			this.loadMoreRef.current.innerHTML = 'LOADING';
		}
		fetchResults(this.props.baseUrl + '/' + this.props.endpoint + (criteriaString ? '/s/' + offset + '/facets/' + criteriaString : '/s/' + offset), function(newState) {
			let state = that.state;
			state.resultList.push(...newState.resultList);
			state.start += state.itemsPerPage;
			that.setState(state);
			that.loadMoreRef.current.innerHTML = that.loadMoreText;

		});
		e.preventDefault();
	};

	_getCriteriaString(criteria) {
		return Object.keys(criteria).map(key => key + ':' + criteria[key]).join(';');
	};

	render() {
		return(
			<main className="ca archive archive_landing">
				<NoguchiBrowseIntro headline={this.props.title} description={this.props.description}/>

				<NoguchiBrowseFilters/>
				<NoguchiBrowseStatistics size={this.state.resultSize}/>

				<NoguchiBrowseResults results={this.state.resultList} start={this.state.start} size={this.state.resultSize} itemsPerPage={this.state.itemsPerPage} loadMoreHandler={this.loadMoreResults} loadMoreRef={this.loadMoreRef}/>
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
			<div className="body-sans">{(this.props.size > 0) ? ((this.props.size == 1) ? "Showing 1 Result" : "Showing " + this.props.size + " Results") : "Loading..."}.</div>

			<NoguchiBrowseCurrentCriteriaList/>
		</div>);
	}
}

/**
 *
 */
class NoguchiBrowseCurrentCriteriaList extends React.Component {
	render() {
		return(<div className="tags">
			<a href='/index.php/Browse/archive/removeCriterion/collection_facet/removeID/432/view/images/key/b90f94881b0f3aeab6906aeb8beec39c'
			   className='browseRemoveFacet'>Photography Collection <span>&times;</span></a>
		</div>);
	}
}

/**
 *
 */
class NoguchiBrowseFilters extends React.Component {
	render() {
		return(
			<section className="ca_filters">
				<NoguchiBrowseNavigation/>

				<div className="options-filter-widget">
					<div className="options text-gray">
						<span className="caption-text">Filter By:</span>
						<a href='#' data-option='type_facet'>type</a>
						<a href='#' data-option='decade_facet'>decade</a>
					</div>
					<div className="option_values wrap-negative">
						<div className="arrow"></div>
						<div className="inner">
							<div className="inner-crop">
								<div className="wrap">
									<ul className="ul-options" data-values="type_facet">
										<li>
											<div className="checkbox">
												<input id="artwork" data-category="" className="option-input"
													   type="checkbox"/>
													<label htmlFor="artwork">
														<span className="title"><a
															href='/index.php/Browse/archive/key//facet/type_facet/id/1085/view/'>Digital &nbsp;
															<span className="number">(614)</span></a></span>
													</label>
											</div>
										</li>
										<li>
											<div className="checkbox">
												<input id="artwork" data-category="" className="option-input"
													   type="checkbox"/>
													<label htmlFor="artwork">
														<span className="title"><a
															href='/index.php/Browse/archive/key//facet/type_facet/id/29/view/'>Documents &nbsp;
															<span className="number">(26)</span></a></span>
													</label>
											</div>
										</li>
										<li>
											<div className="checkbox">
												<input id="artwork" data-category="" className="option-input"
													   type="checkbox"/>
													<label htmlFor="artwork">
														<span className="title"><a
															href='/index.php/Browse/archive/key//facet/type_facet/id/1069/view/'>Photographs &nbsp;
															<span className="number">(3)</span></a></span>
													</label>
											</div>
										</li>
									</ul>
									<ul className="ul-options" data-values="decade_facet">
										<li>
											<div className="checkbox">
												<input id="artwork" data-category="" className="option-input"
													   type="checkbox"/>
													<label htmlFor="artwork">
														<span className="title"><a
															href='/index.php/Browse/archive/key//facet/decade_facet/id/1880s/view/'>1880s &nbsp;
															<span className="number">(1)</span></a></span>
													</label>
											</div>
										</li>
										<li>
											<div className="checkbox">
												<input id="artwork" data-category="" className="option-input"
													   type="checkbox"/>
													<label htmlFor="artwork">
														<span className="title"><a
															href='/index.php/Browse/archive/key//facet/decade_facet/id/1890s/view/'>1890s &nbsp;
															<span className="number">(2)</span></a></span>
													</label>
											</div>
										</li>
										<li>
											<div className="checkbox">
												<input id="artwork" data-category="" className="option-input"
													   type="checkbox"/>
													<label htmlFor="artwork">
														<span className="title"><a
															href='/index.php/Browse/archive/key//facet/decade_facet/id/1900s/view/'>1900s &nbsp;
															<span className="number">(15)</span></a></span>
													</label>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		)
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
				<NoguchiBrowseResultLoadMoreButton start={this.props.start} itemsPerPage={this.props.itemsPerPage} size={this.props.size} loadMoreHandler={this.props.loadMoreHandler} loadMoreRef={this.props.loadMoreRef}/>
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
