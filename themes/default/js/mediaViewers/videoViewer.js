import baseViewer from "./baseViewer.js";
import Plyr from 'plyr';
require('plyr/dist/plyr.css');


let videoViewer = {
	// Properties
	viewers: {},
	urlPath: null,
	containers: {},
	
	// Methods
	//
	//
	//
	init: function(options) {
		baseViewer(videoViewer);
		return videoViewer;
	},
	
	//
	//
	//
	load: function(id, source, options={}) {
		videoViewer.containers[id] = videoViewer.containerDivs(id, source);
		let c = videoViewer.containers[id];
		videoViewer.destroy(id);
		
		
		let e = c['viewer'];
		e.innerHTML = "<div data-plyr-provider='html5'><video class='plyr__video-embed' preload='metadata' id='" + id + '_' + source.display_class + "_plyr' playsinline='1' controls data-poster='" + source.small + "' width='400' height='400'></video></div>";

		let poptions = {
			debug: false,
			autoplay: false,
			fullscreen: {
				enabeled: true
			},
			loop: { 
				active: true 
			}
		};
		let viewer = videoViewer.viewers[id] = new Plyr('#' + id + '_' + source.display_class + '_plyr', poptions);
	
		viewer.source = {
			  type: 'video',
			  title: 'Track',
			  sources: [
				{
				  src: source.url,
				  type: source.mimetype,
				}
			  ],
			  poster: source.small
			};
		return viewer;
	},
	
	//
	//
	//
	destroy: function(id) {
		let c = videoViewer.containers[id];
		
		if(videoViewer.viewers[id]) { 
			videoViewer.viewers[id].destroy(); 
			videoViewer.viewers[id] = null;
			c['viewer'].innerHTML = "";
		}
	}
};

function init(options) {
	videoViewer.options = options;
	
	window.videoViewer = videoViewer;
	return videoViewer.init(options);
};

export default init;
