import React, { useEffect, useContext, useState } from 'react'
import { fetchLightboxList, newJWTToken, loadLightbox } from "../../default/js/lightbox";
import LightboxContextProvider from './Lightbox/LightboxContext';
import { LightboxContext } from './Lightbox/LightboxContext';

import LightboxIntro from './Lightbox/LightboxIntro';
import LightboxControls from './Lightbox/LightboxControls';
import LightboxResults from './Lightbox/LightboxResults';
import LightboxList from './Lightbox/LightboxList';

const selector = pawtucketUIApps.Lightbox.selector;
const appData = pawtucketUIApps.Lightbox.data;
const refreshToken = pawtucketUIApps.Lightbox.key;

const Lightbox = ({ baseUrl, endpoint, initialFilters, propView, showLastLightboxOnLoad, browseKey }) => {

	const { id, setId, tokens, setTokens, lightboxList, setLightboxList, key, setKey, userAccess, setUserAccess, shareAccess, setShareAccess, itemsPerPage, setItemsPerPage, lightboxTitle, setLightboxTitle, resultList, setResultList, totalSize, setTotalSize, sortOptions, setSortOptions, comments, setComments, setAnonymousAccessUrl, anonymousAccessUrl } = useContext(LightboxContext)

	const [ loadId, setLoadId ] = useState(parseInt(showLastLightboxOnLoad));

	// console.log("loadId: ", loadId);
	// console.log('id', id)
	
	useEffect(() => {
		// load auth tokens
		newJWTToken(baseUrl, tokens, (data) => {
			console.log("newJWTToken", data);
			const newTokens = { refresh_token: refreshToken, access_token: data.data.refresh.jwt };
			setTokens(newTokens)
					
			fetchLightboxList(baseUrl, { refresh_token: refreshToken, access_token: data.data.refresh.jwt }, (data) => {
				// console.log("fetchLightboxList", data);
				setLightboxList(data);
			});
		
		});
		setShareAccess(appData.shareAccess)
	}, [id])

	useEffect(() => {
		if(loadId && tokens.access_token) {
			loadLightbox(baseUrl, tokens , parseInt(showLastLightboxOnLoad), (data) => {
				console.log('Load Lightbox Data: ', data);
				setId(loadId)
				setLoadId(null) // only load once
				setLightboxTitle(data.title)
				setResultList(data.items)
				setTotalSize(data.item_count)
				setSortOptions(data.sortOptions)
				setComments(data.comments)
				setAnonymousAccessUrl(data.anonymousAccessUrl)
				setUserAccess(data.access)
			}, { start: 0, limit: itemsPerPage });
		}
	}, [tokens])

	let facetLoadUrl = baseUrl + '/lightbox' + (key ? '?key=' + key : '');
	
	if (loadId && !id) {
		return(
			<div className="row">
				<div className="col-sm-8 bToolBar pt-4">
					<div className="col-sm-12"><h2>Loading</h2></div>
				</div>
			</div>
		)
	} else if(id){
		return(
			<div>
				<div className="row">
					<div className="col-sm-8 bToolBar pt-4">
						<LightboxIntro />
						<LightboxControls facetLoadUrl={facetLoadUrl} />
					</div>
				</div>
				<LightboxResults facetLoadUrl={facetLoadUrl} />
			</div>
		)
	}else{
		return(
			<div className="row">
				<div className="col-sm-12"><LightboxList/></div>
			</div>
		)
	}
}

/**
 * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
	ReactDOM.render(
		<LightboxContextProvider>
			<Lightbox
				baseUrl={appData.baseUrl}
				endpoint='getContent'
				initialFilters={appData.initialFilters}
				propView={appData.view}
				showLastLightboxOnLoad={appData.showLastLightboxOnLoad}
				browseKey={appData.key}
			/>
		</LightboxContextProvider>, document.querySelector(selector)
	);
}

// import { fetchLightboxList, loadLightbox, createLightbox, deleteLightbox, newJWTToken, getLightboxAccessForCurrentUser } from "../../default/js/lightbox";
/**
	 * Load lightbox content with set_id id
	 */
	// const loadLightboxContent = (id) => {
	// 	getLightboxAccessForCurrentUser(baseUrl, id, tokens, (data) => {
	// 		// console.log('Load Lightbox Data: ', data);
	// 		setUserAccess(data.access.access)
	// 	});

	// 	loadLightbox(baseUrl, tokens, id, (data) => {
	// 		// console.log('Load Lightbox Data: ', data);
	// 		setId(id)
	// 		setLightboxTitle(data.title)
	// 		setResultList(data.items)
	// 		setTotalSize(data.item_count)
	// 		setSortOptions(data.sortOptions)
	// 		setComments(data.comments)
	// 	}, { start: 0, limit: itemsPerPage });
	// }

	// const newLightbox = () => {
	// 	let tempLightboxList = {...lightboxList}
	// 	tempLightboxList[-1] = { "id": -1, "label": "" }
	// 	setLightboxList(tempLightboxList)
	// }

	// const cancelNewLightbox = () => {
	// 	let tempLightboxList = lightboxList
	// 	delete (tempLightboxList[-1]);
	// 	setLightboxList(tempLightboxList)
	// }

	// const deleteEntireLightbox = (lightbox) => {
	// 	deleteLightbox(baseUrl, tokens, lightbox.id, (data) => {
	// 		// console.log("deleteLightbox ", data);
	// 		let tempLightboxList = lightboxList
	// 		delete (tempLightboxList[lightbox.id]);
	// 		setLightboxList(tempLightboxList)
	// 	});
	// }