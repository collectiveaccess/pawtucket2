import React from "react"
import ReactDOM from "react-dom";
import * as Browse from "browse";


const selector = pawtucketUIApps.NoguchiBrowse.selector;
const appData = pawtucketUIApps.NoguchiBrowse.data;

class NoguchiBrowse extends Browse.BrowseUI{
	constructor(props) {
		super(props);
	}

	render() {
		return(
			<main className="ca archive archive_landing">
				<NoguchiBrowseIntro headline={this.props.title} description={this.props.description}/>

				<NoguchiBrowseFilters/>
				<NoguchiBrowseStatistics/>

				<NoguchiBrowseResults/>
			</main>
		);
	}
}

class NoguchiBrowseIntro extends React.Component {
	constructor(props) {
		super(props);
	}
	render() {
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

class NoguchiBrowseStatistics extends React.Component {
	render() {
		return(<div className="current">
			<div className="body-sans">Showing 16,373 Results.</div>

			<NoguchiBrowseCurrentCriteriaList/>
		</div>);
	}
}

class NoguchiBrowseCurrentCriteriaList extends React.Component {
	render() {
		return(<div className="tags">
			<a href='/index.php/Browse/archive/removeCriterion/collection_facet/removeID/432/view/images/key/b90f94881b0f3aeab6906aeb8beec39c'
			   className='browseRemoveFacet'>Photography Collection <span>&times;</span></a>
		</div>);
	}
}

class NoguchiBrowseFilters extends Browse.BrowseFilters {
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

class NoguchiBrowseResults extends Browse.BrowseResults {
	render() {
		return(
			<section className="block block-quarter-top">
				<div className="wrap">
					<div className="grid-flexbox-layout grid-ca-archive">
						<NoguchiBrowseResultItem/>
						<NoguchiBrowseResultItem/>
						<NoguchiBrowseResultItem/>
						<NoguchiBrowseResultItem/>
						<NoguchiBrowseResultItem/>
						<NoguchiBrowseResultItem/>
						<NoguchiBrowseResultItem/>
						<NoguchiBrowseResultItem/>
					</div>
				</div>
			</section>
		);
	}
}

class NoguchiBrowseResultItem extends React.Component {
	render() {
		let styles = {
			"background-image": "url(http://noguchi.whirl-i-gig.com:8081/media/nogarchive/images/8/8/1/64478_ca_object_representations_media_88192_medium.jpg)"
		};
		return (
			<div className="item-grid">
				<a href="/index.php/Detail/archival/72949">
					<div className="img-wrapper archive_thumb block-quarter">
						<div className="bg-image"
							 style={styles}></div>
					</div>
					<div className="text">
						<div className="text_position">
							<div className="ca-identifier text-gray">01</div>
							<div className="thumb-text clamp" data-lines="3">Isamu Noguchi in Mure studio,
								c.1980
							</div>


							<div className="text_full">
								<div className="ca-identifier text-gray">01</div>
								<div className="thumb-text">Isamu Noguchi in Mure studio, c.1980</div>


							</div>
						</div>
					</div>
				</a>
			</div>
		);
	}
}

ReactDOM.render(
	<NoguchiBrowse title={appData.title} description={appData.description}/>, document.querySelector(selector));
