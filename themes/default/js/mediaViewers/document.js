import baseViewer from "./baseViewer.js";
let OpenSeadragon = require('openseadragon');

let documentViewer = function(id, options=null) {
	let that = {
		// Properties
		id: null,
		viewer: null,
		viewer_overlay: null,
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
			let c = that.containerDivs(that.id, source, options);
			if(that.viewer && !options['overlay']) { that.destroy(source, options); }
			
			let e = options['overlay'] ? c['overlay_display'] : c['viewer'];
			let overlay_ext = options['overlay'] ? '_overlay' : '';
			let k = options['overlay'] ? 'viewer_overlay' : 'viewer';
			
			
			that[k] = OpenSeadragon({
				element: e,
				preserveViewport: true,
				visibilityRatio:    options['visibilityRatio'] ?? 1,
				minZoomLevel:       options['minZoomLevel'] ?? 0,
				maxZoomLevel:       options['maxZoomLevel'] ?? 15,
				defaultZoomLevel:   options['defaultZoomLevel'] ?? 0,
				minZoomImageRatio: 0.4,
				maxZoomPixelRatio: 4,
				sequenceMode:       true,
				prefixUrl: (that.options['urlPath'] ?? '') + '/node_modules/openseadragon/build/openseadragon/images/',
				tileSources:  source.pages,
				zoomInButton:   options['overlay'] ? "documentviewer-overlay-zoom-in" : "documentviewer-zoom-in",
				zoomOutButton:  options['overlay'] ? "documentviewer-overlay-zoom-out" : "documentviewer-zoom-out",
				homeButton:     options['overlay'] ? "documentviewer-overlay-home" : "documentviewer-home",
				fullPageButton: options['overlay'] ? "documentviewer-overlay-full-page" : "documentviewer-full-page",
				nextButton:     options['overlay'] ? "documentviewer-overlay-next" : "documentviewer-next",
				previousButton: options['overlay'] ? "documentviewer-overlay-previous" : "documentviewer-previous"
			});
			
			document.getElementById(options['overlay'] ? "documentviewer-overlay-currentpage" : "documentviewer-currentpage").innerHTML = "1/" + source.pages.length;
			that.viewer.addHandler("page", function (data) {
				document.getElementById(options['overlay'] ? "documentviewer-overlay-currentpage" : "documentviewer-currentpage").innerHTML = ( data.page + 1 ) + "/" + source.pages.length;
			});
			
			return that[k];
		},
		
		//
		//
		//
		destroy: function(source, options={}) {
			let c = that.containerDivs(that.id, source, options);
			if(that.viewer_overlay && c['overlay_display']) {
				that.viewer_overlay.destroy(); 
				that.viewer_overlay = null;
				
				c['overlay_display'].innerHTML = "";
			}
			if(!options['overlay'] && that.viewer && c['viewer']) { 
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
