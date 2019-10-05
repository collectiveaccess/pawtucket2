/*jshint esversion: 6 */
'use strict';
import React from "react"
const axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


/**
 *
 */
function initialState() {
	return {
		resultSize: null,
		resultList: null,
		key: null,
		start: 0,
		itemsPerPage: 60,
		availableFacets: null,
		facetList: null,
		criteria: null
	};
}

/**
 *
 * @param url
 * @param callback
 */
function fetchResults(url, callback) {
	// Fetch browse facet items
	axios.get(url + "/getResult/1")
		.then(function (resp) {
			let data = resp.data;
			let state = initialState();

			state.resultSize = data.size;
			state.resultList = data.hits;
			state.start = (data.start > 0) ? data.start : 0;
			state.itemsPerPage = data.itemsPerPage;
			state.availableFacets = data.availableFacets;
			state.facetList = data.facetList;
			state.key = data.key;
			state.criteria = data.criteria;
			callback(state);
		})
		.catch(function (error) {
			console.log("Error while loading browse results: ", error);
		});
}

/**
 *
 * @param url
 * @param callback
 */
function fetchFacetValues(url, callback) {
	// Fetch browse facet items
	axios.get(url + "/getFacet/1")
		.then(function (resp) {
			console.log("fetch facet", resp)
			let data = resp.data;
			callback(data);
		})
		.catch(function (error) {
			console.log("Error while loading browse facet: ", error);
		});
}

/**
 *
 * @param criteria
 * @returns {string}
 * @private
 */
function getCriteriaString(criteria) {
	let acc = [];
	for(let k in criteria) {
		if(criteria[k]) {
			acc.push(k + ':' + (Object.keys(criteria[k]).join('|')));
		}
	}
	return acc.join(';');
}

/**
 *
 */
function initBrowseContainer(instance, props) {
	let that = instance;
	that.state = initialState();

	that.loadResults = function(callback) {
		let that = this;
		let offset = (that.state.start + that.state.itemsPerPage);
		let criteriaString = getCriteriaString(that.state.criteria);
		fetchResults(that.props.baseUrl + '/' + that.props.endpoint + '/s/' +
			offset + (that.state.key ? '/key/' + that.state.key : '') + (criteriaString ? '/facets/' +
				criteriaString : ''), function(newState) {
			callback(newState);
		});
	};

	/**
	 *
	 * @param e
	 */
	that.loadMoreResults = function(e) {
		if(that.loadMoreRef && that.loadMoreRef.current) {
			that.loadMoreText = that.loadMoreRef.current.innerHTML;
			that.loadMoreRef.current.innerHTML = 'LOADING';
		}

		that.loadResults(function(newState) {
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
	 * @param criteria
	 */
	that.reloadResults = function(criteria, clearCriteria=false) {
		let that = this;
		let state = that.state;

		if (clearCriteria) {
			state.criteria = {};
		}

		for(let k in criteria) {
			state.criteria[k] = criteria[k];
		}
		state.key = null;
		state.start = 0;
		that.setState(state);
		that.loadResults(function(newState) {
			that.setState(newState);
		});
	};


	that.loadResults = that.loadResults.bind(that);
	that.loadMoreResults = that.loadMoreResults.bind(that);
	that.reloadResults = that.reloadResults.bind(that);

	if(props.initialCriteria) {
		that.state.criteria = props.initialCriteria;
	}

	that.loadResults(function(newState) {
		that.setState(newState);
	});


	that.loadMoreRef = React.createRef();
}


export { initialState, fetchResults, fetchFacetValues, getCriteriaString, initBrowseContainer };
