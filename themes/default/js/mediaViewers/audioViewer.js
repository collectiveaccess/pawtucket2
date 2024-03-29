import baseViewer from "./baseViewer.js";
import Plyr from 'plyr';
require('plyr/dist/plyr.css');

let audioViewer = {
	// Properties
	viewers: {},
	urlPath: null,
	containers: {},
	
	// Methods
	//
	//
	//
	init: function(options) {
		baseViewer(audioViewer);
		return audioViewer;
	},
	
	//
	//
	//
	load: function(id, source, options={}) {
		audioViewer.containers[id] = audioViewer.containerDivs(id, source);
		let c = audioViewer.containers[id];
		
		audioViewer.destroy(id);
		
		//
		let e = c['viewer'];
		e.innerHTML = "<div data-plyr-provider='html5'><audio class='plyr__audio-embed' id='" + id + '_' + source.display_class + "_plyr' controls width='100%' height='100%'></audio></div>";
		
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
	
		let viewer = audioViewer.viewers[id] = new Plyr('#' + id + '_' + source.display_class + '_plyr', poptions);
		
		viewer.source = {
			  type: 'audio',
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
		let c = audioViewer.containers[id];
		
		if(audioViewer.viewers[id]) { 
			audioViewer.viewers[id].destroy(); 
			audioViewer.viewers[id] = null;
			
			c['viewer'].innerHTML = "";
		}
	}
};

function init(options) {
	audioViewer.options = options;
	
	window.audioViewer = audioViewer;
	return audioViewer.init(options);
};

export default init;
