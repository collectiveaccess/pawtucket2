'use strict';
const axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


/**
 *
 */

function initialState() {
	return {
		'resultSize': null,
		'resultList': null
	};
}

function fetchResults(url, callback) {
	let that = this;
	console.log("Load result URL", url);
	// Fetch browse facet items
	axios.get("index.php/Browse/objects/getResult/1/facet/type_facet")
		.then(function (resp) {
			let data = resp.data;
			console.log("Load result", data);
			let state = initialState();
			state.resultSize = data.size;
			state.resultList = data.hits;
			callback(state);
		})
		.catch(function (error) {
			console.log("Error while loading browse navigation: ", error);
		})
}

export { initialState, fetchResults };
