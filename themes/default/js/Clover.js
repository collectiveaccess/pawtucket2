import React, { useEffect, useContext, useState } from 'react'
import Viewer from "cloverIIIF";

const selector = pawtucketUIApps.Clover.selector;
const baseUrl = pawtucketUIApps.Clover.selector;
const appData = pawtucketUIApps.Clover;

const Clover = ({ baseUrl }) => {

// 	useEffect(() => {
// 		
// 	}, [id])	

		let options = {
			renderAbout: false,
			showIIIFBadge: false,
			showInformationToggle: false,
			showTitle: false,
			renderResources: false,
			renderClips: true,
			showPdfToolBar: true,
			showPdfZoom: true,
			showPdfRotate: true,
			showPdfFullScreen: true,
			showPdfPaging: true,
			showPdfThumbnails: true,
			showPdfTwoPageSpread: true
		};
		
		let manifestId = appData.url;

		return(
			<div>
				<Viewer options={options} id={manifestId} />
			</div>
		);
	}

/**
 * Initialize browse and render into DOM. This function is exported to allow the Pawtucket
 * app loaders to insert this application into the current view.
 */
export default function _init() {
	ReactDOM.render(
			<Clover
				baseUrl={appData.baseUrl}
			/>, document.querySelector(selector)
	);
}
