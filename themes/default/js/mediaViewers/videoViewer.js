import Plyr from 'plyr';
require('plyr/dist/plyr.css');

let videoViewer = {
	// Properties
	viewers: {},
	urlPath: null,
	
	// Methods
	//
	//
	//
	init: function(options) {
		return videoViewer;
	},
	
	//
	//
	//
	load: function(id, source, options={}) {
		videoViewer.destroy(id);
		
		//
		let e = document.getElementById(id);
		e.innerHTML = "<div data-plyr-provider='html5'><video class='plyr__video-embed' preload='metadata' id='" + id + "_plyr' playsinline='1' controls data-poster='" + source.small + "' width='400' height='400'><source src='" + source.url + "' type='video/mp4' /></video></div>";
		
		let poptions = {
			debug: true,
			autoplay: false,
			fullscreen: {
				enabeled: true
			},
			loop: { 
				active: true 
			}
		};
		videoViewer.viewers[id] = new Plyr('#' + id + '_plyr', poptions);
	},
	
	//
	//
	//
	destroy: function(id) {
		if(videoViewer.viewers[id]) { 
			console.log('destroy', id, videoViewer.viewers);
			videoViewer.viewers[id].destroy(); 
			videoViewer.viewers[id] = null;
			let e = document.getElementById(id);
			e.innerHTML = "";
		}
	}
};

function init(options) {
	videoViewer.options = options;
	
	window.videoViewer = videoViewer;
	return videoViewer.init(options);
};

export default init;
