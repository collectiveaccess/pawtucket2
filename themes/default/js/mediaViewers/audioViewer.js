import baseViewer from "./baseViewer.js";
import Plyr from 'plyr';
require('plyr/dist/plyr.css');

let audioViewer = function(id, options=null) {
	let that = {
		// Properties
		id: null,
		viewer: null,
		options: null,
	
		// Methods
		//
		//
		//
		init: function(id, options) {
			baseViewer(that);
			that.id = id;
			that.options = options;
			return that;
		},
		
		//
		//
		//
		load: function(source, options={}) {
			let c = that.containerDivs(that.id, source);
			if(that.viewer) { that.viewer.destroy(source); }
			
			//
			let e = c['viewer'];
			e.innerHTML = "<div data-plyr-provider='html5'><audio class='plyr__audio-embed' id='" + that.id + '_' + source.display_class + "_plyr' controls width='100%' height='100%'></audio></div>";
			
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
		
			that.viewer = new Plyr('#' + that.id + '_' + source.display_class + '_plyr', poptions);
			
			that.viewer.source = {
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
				
			return that.viewer;
		},
		
		//
		//
		//
		destroy: function(source) {
			let c = that.containerDivs(that.id, source);
			
			if(that.viewer) { 
				that.viewer.destroy(); 
				that.viewer = null;
				
				c['viewer'].innerHTML = "";
			}
		}
	};
	that.init(id, options);
	
	return that;
};

export default audioViewer;
