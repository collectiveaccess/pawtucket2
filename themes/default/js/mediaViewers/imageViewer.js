import baseViewer from "./baseViewer.js";
let OpenSeadragon = require('openseadragon');

let imageViewer = {
	// Properties
	viewers: {},
	urlPath: null,
	containers: {},
	
	// Methods
	//
	//
	//
	init: function(options) {
		baseViewer(imageViewer);
		return imageViewer;
	},
	
	//
	//
	//
	load: function(id, source, options={}) {
		imageViewer.containers[id] = imageViewer.containerDivs(id, source);
		let c = imageViewer.containers[id];
		
		imageViewer.destroy(id);
		return imageViewer.viewers[id] = OpenSeadragon({
			element: c['viewer'],
			preserveViewport: true,
			visibilityRatio:    options['visibilityRatio'] ?? 1,
			minZoomLevel:       options['minZoomLevel'] ?? 1,
			defaultZoomLevel:   options['defaultZoomLevel'] ?? 1,
			sequenceMode:       false,
			prefixUrl: (imageViewer.options['urlPath'] ?? '') + '/node_modules/openseadragon/build/openseadragon/images/',
			tileSources:  [source.iiifUrl],
			zoomInButton:   "imageviewer-zoom-in",
			zoomOutButton:  "imageviewer-zoom-out",
			homeButton:     "imageviewer-home",
			fullPageButton: "imageviewer-full-page",
			nextButton:     "imageviewer-next",
			previousButton: "imageviewer-previous"
		});
	},
	
	//
	//
	//
	destroy: function(id) {
		let c = imageViewer.containers[id];
		
		if(imageViewer.viewers[id]) { 
			imageViewer.viewers[id].destroy(); 
			imageViewer.viewers[id] = null;
			
			c['viewer'].innerHTML = "";
		}
	}
};

function init(options) {
	window.imageViewer = imageViewer;
	imageViewer.options = options;
	return imageViewer.init(options);
};

export default init;
