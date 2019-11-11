/*jshint esversion: 6 */
'use strict';
import React from "react"
const axios = require('axios');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Fetch list of available lightboxes and return via callback
 *
 * @param url URL to fetch list from.
 * @param callback Function to call once list is received. The first parameter of the callback will be an object
 * 			containing the list.
 */
function fetchLightboxList(url, callback) {
	axios.get(url + "/list")
		.then(function (resp) {
			let data = resp.data;

			callback(data);
		})
		.catch(function (error) {
			console.log("Error while loading lightbox list: ", error);
		});
}

export { fetchLightboxList };
