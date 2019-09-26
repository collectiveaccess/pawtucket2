'use strict';
import React from 'react';
const axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


/**
 *
 */
export class BrowseUI extends React.Component {
	constructor(props) {
		super(props);
		this.state = {

		};
	}

	componentDidMount() {
		let that = this;
		console.log("URL", this.props.baseUrl);
		// Fetch browse facet items
		axios.get("index.php/Browse/objects/getFacet/1/facet/type_facet")
			.then(function (response) {
				console.log("xxx", response);
			})
			.catch(function (error) {
				console.log("Error while loading browse navigation: ", error);
			})
	}
}

/**
 * Browse statistics display: # of hits, Etc.
 */
export class BrowseStatistics extends React.Component {
	render() {
		//let theme = this.context;
		return (
			<div>Stats</div>
	);
	}
}
//BrowseStatistics.contextType = ThemeContext;

/**
 * Browse filter: list of applied filters
 */
export class BrowseFilters extends React.Component {
	render() {
		return (
			<div>Filters</div>
	);
	}
}

/**
 * Browse results
 */
export class BrowseResults extends React.Component {
	render() {
		return (
			<div>Browse results</div>
	);
	}
}
//Browse.contextType = ThemeContext;
