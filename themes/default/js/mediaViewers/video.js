import baseViewer from "./baseViewer.js";
import Plyr from 'plyr';
require('plyr/dist/plyr.css');

let videoViewer = function(id, options=null) {
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
			
			let tracks = [];
			if(source.vttCaptions) {
				for(let i in source.vttCaptions) {
					let c = source.vttCaptions[i];
					tracks.push({
						'kind': 'captions',
      					'label': c['locale'],
      					'srclang': c['language'],
      					'src': c['url'],
     					 'default': true
					});
				}
			}
			
			e.innerHTML = "<div data-plyr-provider='html5'><video class='plyr__video-embed' preload='metadata' id='" + that.id + '_' + source.display_class + overlay_ext + "_plyr' playsinline='1' controls data-poster='" + source.small + "' width='400' height='400'>" + tracks + "</video></div>";
	
			let poptions = {
				debug: false,
				autoplay: false,
				fullscreen: {
					enabled: false
				},
				loop: { 
					active: true 
				},
				controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings']
			};
			
			
			that[k] = new Plyr('#' + that.id + '_' + source.display_class + overlay_ext + '_plyr', poptions);
		 
			that[k].source = {
				  type: 'video',
				  title: 'Track',
				  sources: [
					{
					  src: source.url,
					  type: source.mimetype,
					}
				  ],
				  tracks: tracks,
				  poster: source.small
				};
			return that[k];
		},
		
		//
		//
		//
		onShowOverlay: function() {
			if(that.viewer) {
				that.viewer.stop();
			}
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
	};
	
	that.init(id, options);
	return that;
};

export default videoViewer;
