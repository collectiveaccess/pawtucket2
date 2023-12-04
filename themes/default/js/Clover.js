import React, { useEffect, useContext, useState } from 'react'
import { createRoot } from 'react-dom/client';
import Viewer from "cloverIIIF";

const Clover = ({ manifestId, renderAbout, renderClips, showTitle, showIIIFBadge, showInformationToggle, renderResources }) => {
		let options = {
			renderAbout: renderAbout,
			showIIIFBadge: showIIIFBadge,
			showInformationToggle: showInformationToggle,
			showTitle: showTitle,
			renderResources: renderResources,
			renderClips: renderClips,
			showPdfToolBar: true,
			showPdfZoom: true,
			showPdfRotate: true,
			showPdfFullScreen: true,
			showPdfPaging: true,
			showPdfThumbnails: true,
			showPdfTwoPageSpread: true
		};

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
export default function _init(appData) {
	const container = document.getElementById(appData.id);
	
	const root = createRoot(container);
	root.render(
		<Clover
			manifestId={appData.url} 
			renderAbout={appData.renderAbout ?? false} 
			renderClips={appData.renderClips ?? true} 
			showTitle={appData.showTitle ?? false }
			showIIIFBadge={appData.showIIIFBadge ?? false }
			showInformationToggle={appData.showInformationToggle ?? false }
			renderResources={appData.renderResources ?? false }
		/>
	);
}
