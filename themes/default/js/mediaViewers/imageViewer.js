let OpenSeadragon = require('openseadragon');

let imageViewer = {
	// Properties
	viewers: {},
	urlPath: null,
	
	// Methods
	//
	//
	//
	init: function(options) {
		return imageViewer;
	},
	
	//
	//
	//
	load: function(id, source, options={}) {
		imageViewer.destroy(id);
		imageViewer.viewers[id] = OpenSeadragon({
			id: id,
			preserveViewport: true,
			visibilityRatio:    options['visibilityRatio'] ?? 1,
			minZoomLevel:       options['minZoomLevel'] ?? 1,
			defaultZoomLevel:   options['defaultZoomLevel'] ?? 1,
			sequenceMode:       false,
			prefixUrl: (imageViewer.options['urlPath'] ?? '') + '/node_modules/openseadragon/build/openseadragon/images/',
			tileSources:  [source.iiifUrl]
		});
	},
	
	//
	//
	//
	destroy: function(id) {
		if(imageViewer.viewers[id]) { 
			console.log('destroy', id, imageViewer.viewers);
			
			imageViewer.viewers[id].destroy(); 
			imageViewer.viewers[id] = null;
			
			let e = document.getElementById(id);
			e.innerHTML = "";
		}
	}
};

function init(options) {
	window.imageViewer = imageViewer;
	imageViewer.options = options;
	return imageViewer.init(options);
};

export default init;
