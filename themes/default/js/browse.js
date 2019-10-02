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
		facetList: null,
		criteria: null,
		criteriaForDisplay: null
	};
}

/**
 *
 * @param url
 * @param callback
 */
function fetchResults(url, callback) {
	// Fetch browse facet items
	//console.log("get results", url);
	axios.get(url + "/getResult/1")
		.then(function (resp) {
			let data = resp.data;
			let state = initialState();
			let criteria = {};
			for(let k in data.criteria) {
				criteria[k] = Object.keys(data.criteria[k]).join(";");
			}
			state.resultSize = data.size;
			state.resultList = data.hits;
			state.start = (data.start > 0) ? data.start : 0;
			state.itemsPerPage = data.itemsPerPage;
			state.facetList = data.facetList;
			state.key = data.key;
			state.criteria = criteria;
			state.criteriaForDisplay = data.criteriaForDisplay;
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
