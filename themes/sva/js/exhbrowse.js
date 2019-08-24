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
    	'value': null
    };
    
    this.setBrowseResults = this.setBrowseResults.bind(this);
  }

  componentDidMount() {
	
  }

  componentWillUnmount() {
    
  }
  
  setBrowseResults(value, data) {
  	this.setState({'value': value , 'results': data});
  }

  render() {
  	let results = [];
  	for(var k in this.state.results) {
  		let result = this.state.results[k];
  		results.push(<li class="masonry-title--list" dangerouslySetInnerHTML={{ __html : result.detail_link }}></li>);
  	}
  
  
    return (
    	<div>
			<div className="row justify-content-center">
				<div className="col-md-7">       	
				<ul className="sortby"><ExhBrowseNavigation facetUrl={this.props.facetUrl} browseUrl={this.props.browseUrl} handleResults={this.setBrowseResults} /></ul>
				</div>
			</div>
			<br/><br/>
			<div className="row">
				<div className="col-sm-1">
					<img src="/themes/sva/assets/pawtucket/graphics/sharp-arrow_drop_down-24px.svg"/>
				</div>
				<ul className="select-list">
					<li><h2--list>{this.state.value}</h2--list></li>
					{results}
				</ul>
			</div>
		</div>
    );
  }
}

class ExhBrowseNavigation extends React.Component {
  constructor(props) {
    super(props); 
    this.state = {'items': null};
  }

  componentWillMount() {
  	let that = this;
	axios.get(this.props.facetUrl)
	.then(function (response) {
		that.setState({'items': response.data});		// set state with fetched nav items
	})
	.catch(function (error) {
		console.log("Error while loading browse navigation: ", error);
	})
  }

  componentWillUnmount() {
    
  }

  render() {
  	if(this.state.items === null) { return ""; }	// Don't render prior to load
  	let items = [];
  	for(var k in this.state.items) {
  		let item = this.state.items[k];
  		items.push(<ExhBrowseNavigationItem label={item.label} value={item.id} key={item.id} browseUrl={this.props.browseUrl}  handleResults={this.props.handleResults}/>);
  	}
  	
    return (
      <ul className="browseNav">
        {items}
      </ul>
    );
  }
}

class ExhBrowseNavigationItem extends React.Component {
  constructor(props) {
    super(props); 
    this.state = {};
    
    this.loadFacet = this.loadFacet.bind(this);
  }
  
  loadFacet(e) {
  	e.preventDefault();
  	
  	//console.log("load facet", decodeURI(this.props.browseUrl).replace("%value", this.props.value));
  	let that = this;
	axios.get(decodeURI(this.props.browseUrl).replace("%value", this.props.value))
	.then(function (response) {
		that.props.handleResults(that.props.value, response.data);
	})
	.catch(function (error) {
		console.log("Error while loading facet data: ", error);
	});
  }

  render() {
    return (
      <li className="browseNavItem">
       	<a href="#" onClick={this.loadFacet}>{this.props.label}</a>
      </li>
    );
  }
}


for(var k in selectors) {
	ReactDOM.render(<ExhBrowse facetUrl={selectors[k].facetUrl} browseUrl={selectors[k].browseUrl}/>, document.querySelector(k));
}
