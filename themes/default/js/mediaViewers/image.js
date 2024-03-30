import baseViewer from "./baseViewer.js";
let OpenSeadragon = require('openseadragon');

let imageViewer = function(id, options=null) {
	let that = {
		// Properties
		id: null,
		viewer: null,
		options: null,
		
		// Methods
		//
		//
		//
		init: function(id, options=null) {
			baseViewer(that);
			that.id = id;
			that.options = options;
			return that;
		},
		
		//
		//
		//
		load: function(source, options={}) {
			let c = that.containerDivs(that.id, source);
			if(that.viewer) { thar.viewer.destroy(source); }
			
			return that.viewer = OpenSeadragon({
				element: c['viewer'],
				preserveViewport: true,
				visibilityRatio:    options['visibilityRatio'] ?? 1,
				minZoomLevel:       options['minZoomLevel'] ?? 1,
				maxZoomLevel:       options['maxZoomLevel'] ?? 15,
				defaultZoomLevel:   options['defaultZoomLevel'] ?? 1,
				sequenceMode:       false,
				prefixUrl: (that.options['urlPath'] ?? '') + '/node_modules/openseadragon/build/openseadragon/images/',
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
		destroy: function(source) {
			let c = that.containerDivs(that.id, source);
			
			if(that.viewer) { 
				that.viewer.destroy(); 
				that.viewer = null;
				
				c['viewer'].innerHTML = "";
			}
		}
	}
	
	that.init(id, options);
	return that;
};

export default imageViewer;
