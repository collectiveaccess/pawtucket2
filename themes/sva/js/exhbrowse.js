'use strict';
import React from 'react';
import ReactDOM from 'react-dom';
const axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


let selectors = pawtucketUIApps.exhbrowse;

class ExhBrowse extends React.Component {
  constructor(props) {
    super(props); 
    this.state = {
    	'results': [], 
    	'navItem': null,
		'value': '',
		'sortDirection': 'ASC'
    };

    this.setBrowseResults = this.setBrowseResults.bind(this);
    this.setSortDirection = this.setSortDirection.bind(this);
  }
  
  setBrowseResults(navItem, data) {
  	this.setState({'navItem': navItem , 'results': data, 'value': navItem.props.value});
  }

  setSortDirection(s) {
  	let state = this.state;
  	state.sortDirection = (s === 'DESC') ? 'DESC' : 'ASC';
  	this.setState(state);
  }

  render() {
  	let results = [], lastYear = null;
  	let hits = [...this.state.results];
  	if (this.state.sortDirection === 'DESC') { hits = hits.reverse(); }
  	for(var k in hits) {
  		let result = hits[k];
  		if(this.props.groupByYear) {
			if (parseInt(result.year) !== lastYear) {
				results.push(<li className="masonry-title--list dateBrowseHeader" dangerouslySetInnerHTML={{__html: result.year}}></li>);
				lastYear = parseInt(result.year);
			}
		}
  		results.push(<li className=" masonry-title--list" dangerouslySetInnerHTML={{ __html : result.detail_link }}></li>);
  	}

    return (
    	<div>
			<div className="row justify-content-center">
				<div className="col-sm-12 col-md-12 text-center">       	
				<ul className="sortby"><ExhBrowseNavigation facetUrl={this.props.facetUrl} browseUrl={this.props.browseUrl} handleResults={this.setBrowseResults} /></ul>
				</div>
			</div>
				
			<div className="nameBrowse">
			<div className="row justify-content-center"><h2--list>{this.state.value}</h2--list></div>
				<div className="card-columns">
					<ul className="select-list browseResults">		
					{results}
					</ul>
				</div>
			</div>
		</div>
    );
  }
}

class ExhBrowseNavigation extends React.Component {
  constructor(props) {
    super(props); 
    this.state = {'navItems': null, 'navItemRefs': [], 'selected': null};

    this.handleClick = this.handleClick.bind(this);
  }

  componentDidMount() {
  	let that = this;

  	// Fetch browse facet items
	axios.get(this.props.facetUrl)
	.then(function (response) {
		let navItems = [], navItemRefs = [];
		for(var k in response.data) {
			let navItem = response.data[k];
			let r = React.createRef();
			navItemRefs.push(r);
			navItems.push(<ExhBrowseNavigationItem ref={r} label={navItem.label} value={navItem.id} key={navItem.id} browseUrl={that.props.browseUrl} handleClick={that.handleClick}/>);
		}
		that.setState({'navItems': navItems, 'navItemRefs': navItemRefs});
	})
	.catch(function (error) {
		console.log("Error while loading browse navigation: ", error);
	})
  }

  componentDidUpdate(prevProps, prevState, snapshot) {
	  if (this.state.selected === null) {
	  	this.state.navItemRefs[0].current.loadFacetResults();
	  }
  }

	handleClick(navItem, data) {
	if(this.state.navItems === null) { return; }

	for(var k in this.state.navItemRefs) {
		this.state.navItemRefs[k].current.isSelected(false);
	}
	navItem.isSelected(true);

	let state = this.state;
	state['selected'] = navItem;
	this.setState(state);

	this.props.handleResults(navItem, data);
  }

  render() {
  	if(this.state.navItems === null) { return ""; }	// Don't render prior to load

    return (
      <ul className="browseNav">
        {this.state.navItems}
      </ul>
    );
  }
}

class ExhBrowseNavigationItem extends React.Component {
  constructor(props) {
    super(props); 
    this.state = {
    	"selected": false
	};

    this.loadFacetResults = this.loadFacetResults.bind(this);
    this.isSelected = this.isSelected.bind(this);
  }

  // Load results when navigation item is clicked
  loadFacetResults(e=null) {
  	if (e !== null) { e.preventDefault(); }

  	let that = this;
	axios.get(decodeURI(this.props.browseUrl).replace("%value", escape(this.props.value)))
	.then(function (response) {
		that.props.handleClick(that, response.data);
	})
	.catch(function (error) {
		console.log("Error while loading facet data: ", error);
	});
  }

  isSelected(s) {
  	s = !!s;
  	this.setState({"selected": s});
  }

  render() {
    return (
     <li className="browseNavItem">
       	<a href="#" onClick={this.loadFacetResults} className={this.state["selected"] ? "browseNavItemSelected" : ""}>{this.props.label}</a>
      </li>
    );
  }
}

class ExhBrowseSortButton extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			"sortDirection": 'ASC'
		};

		this.toggleSortDirection = this.toggleSortDirection.bind(this);
	}

	toggleSortDirection() {
		if (this.state.sortDirection === 'ASC') {
			this.setState({"sortDirection": 'DESC'});
			this.props.doSort('DESC');
		} else {
			this.setState({"sortDirection": 'ASC'});
			this.props.doSort('ASC');
		}
	}

	render() {
		let r = (this.state.sortDirection === 'DESC') ? "rotate(0deg)" : "rotate(180deg)";
		return (
			<img src="/themes/sva/assets/pawtucket/graphics/sharp-arrow_drop_down-24px.svg" style={{transform: r}} onClick={this.toggleSortDirection}/>
		);
	}
}

export default function _init() {
	for(var k in selectors) {
		ReactDOM.render(<ExhBrowse facetUrl={selectors[k].facetUrl} browseUrl={selectors[k].browseUrl} groupByYear={selectors[k].groupByYear}/>, document.querySelector(k));
	}
}
