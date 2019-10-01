'use strict';
const axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


/**
 *
 */
function initialState() {
	return {
		'resultSize': null,
		'resultList': null,
		'start': 0,
		'itemsPerPage': 60
	};
}

/**
 *
 * @param url
 * @param callback
 */
function fetchResults(url, callback) {
	let that = this;
	// Fetch browse facet items
	axios.get(url + "/getResult/1")
		.then(function (resp) {
			let data = resp.data;
			let state = initialState();
			state.resultSize = data.size;
			state.resultList = data.hits;
			state.start = data.start;
			state.itemsPerPage = data.itemsPerPage;
			callback(state);
		})
		.catch(function (error) {
			console.log("Error while loading browse navigation: ", error);
		});
}


export { initialState, fetchResults };
