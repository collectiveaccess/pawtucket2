
import React, { useEffect, useContext, useState } from 'react'
import { createRoot } from 'react-dom/client';
import Viewer from "@samvera/cloverIIIF/viewer";
import * as Annotorious from '@recogito/annotorious-openseadragon';

import '@recogito/annotorious-openseadragon/dist/annotorious.min.css';

import {
  InformationPanel,
  AnnotationEditor,
  EditorProvider,
} from "annotation-editor-clover";

const Clover = ({ options, iiifContent, iiifContentSearch, iiifClippingService, renderAbout, renderClips, showTitle, showIIIFBadge, showInformationToggle, renderResources, backgroundColor, height, plugins }) => {		
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
			
    <EditorProvider>
		<Viewer options={options} plugins={plugins} iiifContent={iiifContent} iiifContentSearch={iiifContentSearch} iiifClippingService={iiifClippingService} customTheme={customTheme} />		
    </EditorProvider>
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
			iiifClippingService={appData.clipUrl} 
			
			plugins={[
			  {
				id: "AnnotationEditor",
				imageViewer: {
				  menu: {
					component: AnnotationEditor,
					componentProps: {
					  annotationServer: appData.clipUrl,
					  token: "abc123"
					},
				  },
				},
				informationPanel: {
				  component: InformationPanel,
				  label: { none: ["Clippings"] },
				  componentProps: {
					annotationServer: appData.clipUrl,
					token: "abc123"
				  },
				},
			  } 
			]}
			
			options={{
				informationPanel: {
				  open: true, 
				  renderAbout: false, 
				  renderToggle: true,
				  renderAnnotation: true
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
					clickToZoom: true
				  },
				  maxZoomPixelRatio: 4
				}
			  }}
		/>
	);
}
