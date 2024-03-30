import baseViewer from "./baseViewer.js";
let OpenSeadragon = require('openseadragon');

let documentViewer = function(id, options=null) {
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
			
			that.viewer = OpenSeadragon({
				element: c['viewer'],
				preserveViewport: true,
				visibilityRatio:    options['visibilityRatio'] ?? 1,
				minZoomLevel:       options['minZoomLevel'] ?? 1,
				maxZoomLevel:       options['maxZoomLevel'] ?? 15,
				defaultZoomLevel:   options['defaultZoomLevel'] ?? 1,
				sequenceMode:       true,
				prefixUrl: (that.options['urlPath'] ?? '') + '/node_modules/openseadragon/build/openseadragon/images/',
				tileSources:  source.pages,
				zoomInButton:   "documentviewer-zoom-in",
				zoomOutButton:  "documentviewer-zoom-out",
				homeButton:     "documentviewer-home",
				fullPageButton: "documentviewer-full-page",
				nextButton:     "documentviewer-next",
				previousButton: "documentviewer-previous"
			});
			
			document.getElementById("documentviewer-currentpage").innerHTML = "1/" + source.pages.length;
			that.viewer.addHandler("page", function (data) {
				document.getElementById("documentviewer-currentpage").innerHTML = ( data.page + 1 ) + "/" + source.pages.length;
			});
			
			return that.viewer;
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

export default documentViewer;
