'use strict';
import React from 'react';


/**
 *
 */
export class BrowseUI extends React.Component {
	constructor(props) {
		super(props);
		this.state = {

		}
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
