import baseViewer from "./baseViewer.js";
let OpenSeadragon = require('openseadragon');

let imageViewer = function(id, options=null) {
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
			
			if(parseInt(source[options['overlay'] ? 'overlay_options' : 'options'].zoom) > 0) {
				that[k] = OpenSeadragon({
					element: e,
					preserveViewport: true,
					visibilityRatio:    options['visibilityRatio'] ?? 1,
					minZoomLevel:       options['minZoomLevel'] ?? 0,
					maxZoomLevel:       options['maxZoomLevel'] ?? 15,
					defaultZoomLevel:   options['defaultZoomLevel'] ?? 0,
					sequenceMode:       false,
					prefixUrl: (that.options['urlPath'] ?? '') + '/node_modules/openseadragon/build/openseadragon/images/',
					tileSources:  [source.iiifUrl],					
					minZoomImageRatio: 0.4,
					maxZoomPixelRatio: 4,
					zoomInButton:   options['overlay'] ? "imageviewer-overlay-zoom-in" : "imageviewer-zoom-in",
					zoomOutButton:  options['overlay'] ? "imageviewer-overlay-zoom-out" : "imageviewer-zoom-out",
					homeButton:     options['overlay'] ? "imageviewer-overlay-home" : "imageviewer-home",
					fullPageButton: options['overlay'] ? "imageviewer-overlay-full-page" : "imageviewer-full-page",
					nextButton:     options['overlay'] ? "imageviewer-overlay-next" : "imageviewer-next",
					previousButton: options['overlay'] ? "imageviewer-overlay-previous" : "imageviewer-previous",
					tabIndex:	-1
				});
			} else {
				that[k] = null;
				e.innerHTML = source.tag;
				e.onclick = function() { options.mediaViewer.showOverlay(); };
			}
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

export default imageViewer;
