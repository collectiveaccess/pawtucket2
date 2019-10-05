'use strict';
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


export { initialState, fetchResults, fetchFacetValues };
