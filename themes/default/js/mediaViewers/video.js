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
				autoplay: true,
				muted: true,
				fullscreen: {
					enabled: true,
					fallback: true
				},
				loop: { 
					active: true 
				},
				controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'captions', 'settings', 'fullscreen']
			};
			
			
			that[k] = new Plyr('#' + that.id + '_' + source.display_class + overlay_ext + '_plyr', poptions);
		 	that[k].canPlay = false;
		 	
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
			that[k].seek_for_transcript = false;
			if(source.start && (source.start > 0)) {
				that[k].on('playing', (event) => {
					if(!that[k].seek_for_transcript) {
				  		that[k].currentTime = parseFloat(source.start);
						that.viewer.pause();
				  		that[k].seek_for_transcript = true;
				  	}
				});
			}
			that[k].viewerIsReady = false;
			
			that[k].on('ready', (event) => {
				if(!that[k].viewerIsReady) {
					console.log("[DEBUG] Viewer is ready");
					that[k].viewerIsReady = true;
				}
			});
			that[k].on('canplay', (event) => {
				console.log("[DEBUG] Can play video");
				that[k].canPlay = true;
			});
			
			if(options.transcript_container_id && options.transcript_id) {
				const el = document.getElementById(options.transcript_container_id);
				console.log("el", el);
				if(source.vttCaptions) {
					const transcript_url = options.transcript_url.replace(/%25representation_id/, '' + source.id);	
					htmx.ajax('GET', transcript_url, '#' + options.transcript_id);
					if(el) {
						el.style.display = 'block';
					}
				} else if(el) {
					el.style.display = 'none';	
				}
			} 
			
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
		seek: function(t) {
			if(that.viewer) {
				that.viewer.pause();
				if(!that.viewer.canPlay || !that.viewer.viewerIsReady) {
					that.viewer.seekTo = t;
					that.viewer.on('playing', (event) => {
						if(that.viewer.seekTo) {
							that.viewer.currentTime = parseFloat(that.viewer.seekTo);
							that.viewer.play();
							that.viewer.seekTo = null;
						}
					});
				} else {
					console.log("[DEBUG] Set seek to", t);
					that.viewer.seekTo = null;
					that.viewer.currentTime = t;
					that.viewer.play();
				}
			}
		},
		
		play: function(t) {
			if(that.viewer) {
				that.viewer.play();
			}
		},
		
		pause: function(t) {
			if(that.viewer) {
				that.viewer.pause();
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
