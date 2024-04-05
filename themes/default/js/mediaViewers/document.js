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
			let is_overlay = options['overlay'] ?? false;
			let c = that.containerDivs(that.id, source, options);
			if(that.viewer && !is_overlay) { that.destroy(source, options); }
			
			
			let e = is_overlay ? c['overlay_display'] : c['viewer'];
			let overlay_ext = is_overlay ? '_overlay' : '';
			let k = is_overlay ? 'viewer_overlay' : 'viewer';
			
			
			if(parseInt(source[options['overlay'] ? 'overlay_options' : 'options'].zoom) > 0) {
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
					zoomInButton:   is_overlay ? "documentviewer-overlay-zoom-in" : "documentviewer-zoom-in",
					zoomOutButton:  is_overlay ? "documentviewer-overlay-zoom-out" : "documentviewer-zoom-out",
					homeButton:     is_overlay ? "documentviewer-overlay-home" : "documentviewer-home",
					fullPageButton: is_overlay ? "documentviewer-overlay-full-page" : "documentviewer-full-page",
					nextButton:     is_overlay ? "documentviewer-overlay-next" : "documentviewer-next",
					previousButton: is_overlay ? "documentviewer-overlay-previous" : "documentviewer-previous"
				});
				
				document.getElementById(is_overlay ? "documentviewer-overlay-currentpage" : "documentviewer-currentpage").innerHTML = "1/" + source.pages.length;
				
				that[k].addHandler("page", function (data) {
					document.getElementById(is_overlay ? "documentviewer-overlay-currentpage" : "documentviewer-currentpage").innerHTML = ( data.page + 1 ) + "/" + source.pages.length;
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

export default documentViewer;
