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
				
				let modelUrls = [];
				if(source.sidecars) {
					for(let x in source.sidecars) {
						let s = source.sidecars[x];
						modelUrls.push(s.sidecarUrl);
					}
				}
				modelUrls.push(source.original_url);
				e.innerHTML = "<div class='online_3d_viewer threedViewer-viz' model='" + modelUrls.join(', ') + "' backgroundcolor='255,255,255,255' defaultcolor='200,200,200'></div>";
				OV.Init3DViewerElements();
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

export default threedViewer;
