import React, { useEffect, useContext, useState } from 'react'
import { createRoot } from 'react-dom/client';
import Viewer from "cloverIIIF";

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
	const container = document.getElementById(appData.id);
	const root = createRoot(container);
	root.render(
			<Clover
				baseUrl={appData.baseUrl}
			/>
	);
}
