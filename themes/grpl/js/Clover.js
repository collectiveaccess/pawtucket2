import React, { useEffect, useContext, useState } from 'react'
import { createRoot } from 'react-dom/client';
import Viewer from "@samvera/cloverIIIF/viewer";

const Clover = ({ options, iiifContent, iiifContentSearch, renderAbout, renderClips, showTitle, showIIIFBadge, showInformationToggle, renderResources, backgroundColor, height }) => {
		// let options = {
// 			renderAbout: renderAbout,
// 			showIIIFBadge: showIIIFBadge,
// 			showInformationToggle: showInformationToggle,
// 			showTitle: showTitle,
// 			renderResources: renderResources,
// 			renderClips: renderClips,
// 			showPdfToolBar: true,
// 			showPdfZoom: true,
// 			showPdfRotate: true,
// 			showPdfFullScreen: true,
// 			showPdfPaging: true,
// 			showPdfThumbnails: true,
// 			showPdfTwoPageSpread: true,
// 			canvasBackgroundColor: backgroundColor,
// 			canvasHeight: height
// 		};
		
		const customTheme = {
			colors: {
			  /**
			   * Black and dark grays in a light theme.
			   * All must contrast to 4.5 or greater with `secondary`.
			   */
			  primary: "#2C2629",
			  primaryMuted: "#433A3F",
			  primaryAlt: "#211C1F",

			  /**
			   * Key brand color(s).
			   * `accent` must contrast to 4.5 or greater with `secondary`.
			   */
			  accent: "#3D5A6C",
			  accentMuted: "#6F96AE",
			  accentAlt: "#334C5B",

			  /**
			   * White and light grays in a light theme.
			   * All must must contrast to 4.5 or greater with `primary` and  `accent`.
			   */
			  secondary: "#FFFFFF",
			  secondaryMuted: "#E5ECF0",
			  secondaryAlt: "#D8E3E9"
			},
			fonts: {
			  sans: "'Rubik', Helvetica, sans-serif",
			  display: "'Domine', Helvetica, sans-serif"
			}
		  };

		return(
			<Viewer options={options} iiifContent={iiifContent} iiifContentSearch={iiifContentSearch} customTheme={customTheme} />
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
			iiifContent={appData.url} 
			iiifContentSearch={appData.searchUrl} 
			options={{
				informationPanel: {
				  open: true, 
				  renderAbout: true, 
				  renderToggle: true
				},
				showIIIFBadge: false,
				showTitle: true,
				annotationOverlays: {
					zoomLevel: 5
				},
				canvasHeight: (jQuery(window).height() - 120) + "px",
				openSeadragon: {
				  gestureSettingsMouse: {
					scrollToZoom: true,
				  },
				  maxZoomPixelRatio: 4
				}
			  }}
		/>
	);
	
// 	jQuery(document).ready(function() {
// 		jQuery('#newspaper-container').on('change', '#information-toggle', function(e) {
// 			alert('switch!'); 
// 		});
// 	});
}
