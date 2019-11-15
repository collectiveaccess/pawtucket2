/*jshint esversion: 6 */
'use strict';
import React from "react";
import qs from 'qs';
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

/**
 * Create a new lightbox
 *
 * @param url URL send lightbox data to.
 * @param callback Function to call once lightbox is created. The first parameter of the callback will be an object
 * 			containing the result of the action.
 */
function addLightbox(url, data, callback) {
	axios.post(url + "/add", qs.stringify(data))
		.then(function (resp) {
			let data = resp.data;

			callback(data);
		})
		.catch(function (error) {
			console.log("Error while adding lightbox: ", error);
		});
}

/**
 * Edit lightbox information
 *
 * @param url URL send lightbox data to.
 * @param callback Function to call once edit is made. The first parameter of the callback will be an object
 * 			containing the result of the edit.
 */
function editLightbox(url, data, callback) {
	axios.post(url + "/edit", qs.stringify(data))
		.then(function (resp) {
			let data = resp.data;

			callback(data);
		})
		.catch(function (error) {
			console.log("Error while editing lightbox: ", error);
		});
}

/**
 * Delete lightbox permanently
 *
 * @param url URL send lightbox delete request to.
 * @param callback Function to call delete is completed. The first parameter of the callback will be an object
 * 			containing the result of the deletion.
 */
function deleteLightbox(url, set_id, callback) {
	axios.post(url + "/delete", qs.stringify({set_id: set_id }))
		.then(function (resp) {
			let data = resp.data;

			callback(data);
		})
		.catch(function (error) {
			console.log("Error while deleting lightbox: ", error);
		});
}

/**
 * Add item to lightbox
 *
 * @param url URL to send lightbox add item request to.
 * @param callback Function to call when add item request is completed. The first parameter of the callback will be an object
 * 			containing the result of the action.
 */
function addItemToLightbox(url, set_id, item_id, callback) {
	axios.post(url + "/addToLightbox", qs.stringify({set_id: set_id, item_id: item_id }))
		.then(function (resp) {
			let data = resp.data;

			callback(data);
		})
		.catch(function (error) {
			console.log("Error while adding item lightbox: ", error);
		});
}

/**
 * Remove item from lightbox
 *
 * @param url URL to send lightbox remove item request to.
 * @param callback Function to call when add item request is completed. The first parameter of the callback will be an object
 * 			containing the result of the action.
 */
function removeItemFromLightbox(url, set_id, item_id, callback) {
	axios.post(url + "/removeFromLightbox", qs.stringify({set_id: set_id, item_id: item_id }))
		.then(function (resp) {
			let data = resp.data;

			callback(data);
		})
		.catch(function (error) {
			console.log("Error while removing item lightbox: ", error);
		});
}

export { fetchLightboxList, addLightbox, editLightbox, deleteLightbox, addItemToLightbox, removeItemFromLightbox };
