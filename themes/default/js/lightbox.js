/*jshint esversion: 6 */
'use strict';
import React from 'react';
import { gql } from '@apollo/client';
import { getGraphQLClient } from 'graphqlClient';
import _ from 'lodash';


/**
 * Get access JWT using refresh token
 *
 * @param url URL of authentication endpoint
 * @param tokens
 * @param callback
 */
function newJWTToken(uri, tokens, callback) {
	const client = getGraphQLClient(uri + '/auth', tokens, { refresh: true });
	client
	  .query({
		query: gql`
		  query {
			refresh { jwt }
		  }
		`
	  })
	  .then(function(result) {
	  	callback(result);
		}).catch(function (error) {
			console.log("Error while attempting to get token: ", error);
		});
}

/**
 *
 */
function loadLightbox(uri, tokens, id, callback, options=null) {
	id = parseInt(id);

	let start = _.get(options, 'start', 0);
	let limit = _.get(options, 'limit', 100);
	let sort = _.get(options, 'sort', null);
	let sortDirection = _.get(options, 'sortDirection', null);

	const client = getGraphQLClient(uri + '/lightbox', tokens, { });
	client
	  .query({
		query: gql`
		  query ($id: Int!, $start: Int!, $limit: Int!, $sort: String, $sortDirection: String){ content(id: $id, mediaVersions: ["small"], start: $start, limit: $limit, sort: $sort, sortDirection: $sortDirection) { id, title, type, item_count, comments { content, email, fname, lname, created, user_id }, sortOptions { label, sort }, items { id, title, detailPageUrl, caption, identifier, rank, media { version, url, tag, width, height} } } }
		`, variables: { 'id': id, 'start': start, 'limit': limit, 'sort': sort, 'sortDirection': sortDirection }})
	  .then(function(result) {
		callback(result.data['content']);
		}).catch(function (error) {
			console.log("Error while attempting to loadLightbox: ", error);
		});
}

/**
 * Fetch list of available lightboxes and return via callback
 *
 * @param url URL to fetch list from.
 * @param callback Function to call once list is received. The first parameter of the callback will be an object
 * 			containing the list.
 */
function fetchLightboxList(uri, tokens, callback) {
	const client = getGraphQLClient(uri + '/lightbox', tokens, { });
	client
	  .query({
		query: gql`
		  query { list { title, id, author_lname, created, content_type, type, count, content_type_singular, content_type_plural } }
		`
	  })
	  .then(function(result) {
	  	// Index lightbox list by id
	  	let lightboxList = {};
	  	for(let i in result.data['list']) {
	  		lightboxList[result.data['list'][i].id] = result.data['list'][i];
	  	}
	  	callback(lightboxList);
		}).catch(function (error) {
			console.log("Error while attempting to fetchLightboxList: ", error);
		});
}

/**
 * Create a new lightbox
 *
 * @param url URL send lightbox data to.
 * @param callback Function to call once lightbox is created. The first parameter of the callback will be an object
 * 			containing the result of the action.
 */
function createLightbox(uri, tokens, name, callback) {
	const client = getGraphQLClient(uri + '/lightbox', tokens, { });
	client
	  .mutate({
		mutation: gql`
		  mutation ($data: String!){ create(data: { name: $data }) { id, name } }
		`, variables: { 'data': name }
	  })
	  .then(function(result) {
	  		callback(result.data['create']);
		}).catch(function (error) {
			console.log("Error while attempting to createLightbox: ", error);
		});
}

/**
 * Edit lightbox information
 *
 * @param url URL send lightbox data to.
 * @param callback Function to call once edit is made. The first parameter of the callback will be an object
 * 			containing the result of the edit.
 */
function editLightbox(uri, tokens, id, name, callback) {
	id = parseInt(id);

	const client = getGraphQLClient(uri + '/lightbox', tokens, { });
	client
	  .mutate({
		mutation: gql`
		  mutation ($id: Int!, $data: String!){ edit(id: $id, data: { name: $data }) { id, name } }
		`, variables: { 'id': id, 'data': name }
	  })
	  .then(function(result) {
	  		callback(result.data['edit']);
		}).catch(function (error) {
			console.log("Error while attempting to editLightbox: ", error);
		});
}

/**
 * Delete lightbox permanently
 *
 * @param url URL send lightbox delete request to.
 * @param callback Function to call delete is completed. The first parameter of the callback will be an object
 * 			containing the result of the deletion.
 */
function deleteLightbox(uri, tokens, id, callback) {
	id = parseInt(id);

	const client = getGraphQLClient(uri + '/lightbox', tokens, { });
	client
	  .mutate({
		mutation: gql`
		  mutation ($id: Int!){ delete(id: $id) { id } }
		`, variables: { 'id': id }
	  })
	  .then(function(result) {
	  		callback(result.data['delete']);
		}).catch(function (error) {
			console.log("Error while attempting to deleteLightbox: ", error);
		});
}

/**
 * Reorder the items within a lightbox
 *
 * @param url URL send lightbox data to.
 * @param callback Function to call once edit is made. The first parameter of the callback will be an object
 * 			containing the result of the edit.
 */
function reorderLightboxItems(uri, tokens, id, sorted_ids, name, callback) {
	id = parseInt(id);

	const client = getGraphQLClient(uri + '/lightbox', tokens, { });
	client
	  .mutate({
		mutation: gql`
		  mutation ($id: Int!, $data: String!){ reorder(id: $id, data: { sorted_ids: $data }) { id, name } }
		`, variables: { 'id': id, 'data': sorted_ids }
	  })
	  .then(function(result) {
	  		callback(result.data['reorder']);
		}).catch(function (error) {
			console.log("Error while attempting to reorderLightboxItems: ", error);
		});
}

function appendItemsToLightbox(uri, tokens, id, items, callback) {
	const client = getGraphQLClient(uri + '/lightbox', tokens, { });
	client
	  .mutate({
		mutation: gql`
		  mutation ($id: Int!, $items: String!){ appendItems(id: $id , items: { ids: $items }) { id, name, count } }
		`, variables: { 'id': id, 'items': items }
	  })
	  .then(function(result) {
	  		callback(result.data['appendItems']);
		}).catch(function (error) {
			console.log("Error while attempting to append items to lightbox ", error);
		});
}

function appendItemstoNewLightbox(uri, tokens, name, items, callback){
	const client = getGraphQLClient(uri + '/lightbox', tokens, { });
	client
	  .mutate({
		mutation: gql`
		  mutation ($lightbox: String!, $items: String!){ appendItems(lightbox: { name: $lightbox } , items: { ids: $items }) { id, name, count } }
		`, variables: { 'lightbox': name, 'items': items }
	  })
	  .then(function(result) {
	  		callback(result.data['appendItems']);
		}).catch(function (error) {
			console.log("Error while attempting to append items to new lightbox: ", error);
		});
}

function removeItemsFromLightbox(uri, tokens, id, items, callback){
	id = parseInt(id);

	const client = getGraphQLClient(uri + '/lightbox', tokens, { });
	client
	  .mutate({
		mutation: gql`
		  mutation ($id: Int!, $items: String!){ removeItems(id: $id, items:{ ids: $items }) { id, name, count } }
		`, variables: { 'id': id, 'items': items }
	  })
	  .then(function(result) {
	  		callback(result.data['removeItems']);
		}).catch(function (error) {
			console.log("Error while attempting to removeItemsFromLightbox: ", error);
		});
}

function transferItemsToLightbox(uri, tokens, id, toId, items, callback){
	id = parseInt(id);
	toId = parseInt(toId);

	const client = getGraphQLClient(uri + '/lightbox', tokens, { });
	client
	  .mutate({
		mutation: gql`
		  mutation ($id: Int!, $toId: Int!, $items: String!){ transferItems(id: $id, toId: $toId, items:{ ids: $items }) { id, name, count } }
		`, variables: { 'id': id, 'toId': toId, 'items': items }
	  })
	  .then(function(result) {
	  		callback(result.data['transferItems']);
		}).catch(function (error) {
			console.log("Error while attempting to transferItemsToLightbox: ", error);
		});
}

function createLightboxComments(uri, tokens, id, content, callback){
	id = parseInt(id);
	content = String(content);
	
	const client = getGraphQLClient(uri + '/lightbox', tokens, { });
	client
		.mutate({
			mutation: gql`
				mutation ($id: Int!, $content: String!){ comment(id: $id, comment: { content: $content }) { id, name, comment { user_id, fname, lname, email, content, created } } }
			`, variables: { 'id': id, 'content': content }
		})
		.then(function(result) {
			callback(result.data['comment']);
		}).catch(function (error) {
			console.log("Error while attempting to submit comment: ", error);
		});
}

/**
 * Get ligthbox access For current users
 *
 * @param url URL to send lightbox remove item request to.
 * @param callback Function to call when add item request is completed. The first parameter of the callback will be an object
 * 			containing the result of the action.
 */
function getLightboxAccessForCurrentUser(uri, id, tokens, callback) {
	const client = getGraphQLClient(uri + '/lightbox', tokens, { });
	client
	  .query({
		query: gql`
		  query($id: Int!) { access(id: $id) { access } }
		`
	  , variables: { id: parseInt(id) }})
	  .then(function(result) {
	  	let access = { access: result.data.access.access};
	  	callback(access);
		}).catch(function (error) {
			console.log("Error while attempting to getLightboxAccessForCurrentUser: ", error);
		});
}

export {
	fetchLightboxList, loadLightbox, createLightbox, editLightbox, deleteLightbox,
	getLightboxAccessForCurrentUser, newJWTToken, reorderLightboxItems,
	appendItemstoNewLightbox, appendItemsToLightbox, transferItemsToLightbox, removeItemsFromLightbox, createLightboxComments,
};
