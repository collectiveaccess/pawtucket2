import baseViewer from "./baseViewer.js";
import * as OV from 'online-3d-viewer';

let threedViewer = function(id, options=null) {
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
				that[k] = null;
				e.innerHTML = "viewer goes here";
			} else {
				that[k] = null;
				e.innerHTML = "<div class='online_3d_viewer' model='" + source.original_url + "'></div>";
				OV.Init3DViewerElements();
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

export default threedViewer;
