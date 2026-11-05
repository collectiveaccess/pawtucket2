import baseViewer from "./baseViewer.js";
import CI360 from '@cloudimage/360-view';
import '@cloudimage/360-view/css';

let panoramaViewer = function(id, options=null) {
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
			
			if(source.pages_previews && (source.pages_previews.length > 0)) {
				that[k] = null;
				const viewer = window.CI360;	
				const config = {
				  imageListX: source.pages_original,
				  amountX: source.pages_original.length,
				  autoplay: false,
				  speed: 100,
				  dragSpeed: 150,
				  fullscreen: true,
				  zoomMax: 8,
				  inertia: true,
				  draggable: true,
				  keys: true,
				};
				let r = viewer.init(e, config);
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

export default panoramaViewer;
