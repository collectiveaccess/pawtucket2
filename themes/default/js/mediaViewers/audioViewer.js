import Plyr from 'plyr';
require('plyr/dist/plyr.css');

let audioViewer = {
	// Properties
	viewers: {},
	urlPath: null,
	
	// Methods
	//
	//
	//
	init: function(options) {
		return audioViewer;
	},
	
	//
	//
	//
	load: function(id, source, options={}) {
		audioViewer.destroy(id);
		
		//
		let e = document.getElementById(id);
		e.innerHTML = "<div data-plyr-provider='html5'><audio class='plyr__audio-embed' id='" + id + "_plyr' controls width='100%' height='100%'><source src='" + source.url + "' type='" + source.mimetype+ "' /></audio></div>";
		
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
		return audioViewer.viewers[id] = new Plyr('#' + id + '_plyr', poptions);
	},
	
	//
	//
	//
	destroy: function(id) {
		if(audioViewer.viewers[id]) { 
			audioViewer.viewers[id].destroy(); 
			audioViewer.viewers[id] = null;
			let e = document.getElementById(id);
			e.innerHTML = "";
		}
	}
};

function init(options) {
	audioViewer.options = options;
	
	window.audioViewer = audioViewer;
	return audioViewer.init(options);
};

export default init;
