import React, { useContext, useState, useEffect } from 'react';
import { GridContext } from '../GridContext';

import { newJWTToken } from "../../../../default/js/lightbox";
const lightboxBaseUrl = pawtucketUIApps.RelatedGrid.lightboxBaseUrl;
const refreshToken = pawtucketUIApps.RelatedGrid.key;
const serviceUrl = '/service.php/';

import { gql } from '@apollo/client';
import { getGraphQLClient } from 'graphqlClient';

function createLightbox(uri, tokens , name, ids, callback) {
	const client = getGraphQLClient(uri, tokens, { });
	client
	  .mutate({
		mutation: gql`
		  mutation ($name: String!, $ids: String!){ create(data: { name: $name }, items:{ ids: $ids }) { id, name } }
		`, variables: { 'name': name, 'ids': ids }
	  })
	  .then(function(result) {
	  		callback(result.data['create']);
	  }).catch(err => console.log(err));
}

const RelatedGridLightboxOptions = (props) => {
  const { selectedGridItems, itemIds, setLightboxCreated } = useContext(GridContext);

	// Auth Tokens in Local State
	const [tokens, setTokens] = useState({
		refresh_token: refreshToken,
		access_token: null
	});

	useEffect(() => {
		// Load Auth Tokens
		newJWTToken(serviceUrl, tokens, function(data) {
			setTokens({
				refresh_token: refreshToken,
				access_token: data.data.refresh.jwt,
			});
		});
  }, []);	// [] = run once on startuo

  const addSelectedItemsToNewLightbox = (e) => {
		let ids = String(selectedGridItems.join(','));
		createLightbox(lightboxBaseUrl, tokens, 'New Lightbox', ids, function(data){
		});
		setLightboxCreated(true);
		e.preventDefault();
	};

  const addResultsToNewLightbox = (e) => {
		let ids = String(itemIds.join(','));
		createLightbox(lightboxBaseUrl, tokens, 'New Lightbox', ids, function(data) {
			// noop
		});
		setLightboxCreated(true);
		e.preventDefault();
  };


  return (
    <div id="bLightboxOptions">
      <div className="dropdown show">
        <a href="#" role="button" id="lightboxOptionIcon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <ion-icon name="folder"></ion-icon>
        </a>

        <div className="dropdown-menu dropdown-menu-right" aria-labelledby="lightboxOptionIcon">
          <a className="dropdown-item" onClick={(selectedGridItems.length > 0) ? (e) => addSelectedItemsToNewLightbox(e) : (e) => addResultsToNewLightbox(e)}>
          <ion-icon name="add"></ion-icon> Create new lightbox from {(selectedGridItems.length > 0) ? "selected items" : "results"}</a>
        </div>
      </div>
    </div>
  )
}

export default RelatedGridLightboxOptions
