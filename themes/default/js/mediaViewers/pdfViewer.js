

let pdfViewer = {
	// Properties
	viewers: {},
	urlPath: null,
	
	// Methods
	//
	//
	//
	init: function(options) {
		return pdfViewer;
	},
	
	//
	//
	//
	load: function(id, source, options={}) {
		pdfViewer.destroy(id);
		
		//
		let e = document.getElementById(id);
		e.innerHTML = "<div data-plyr-provider='html5'><audio class='plyr__audio-embed' id='" + id + "_plyr' controls width='100%' height='100%'><source src='" + source.url + "' type='" + source.mimetype+ "' /></audio></div>";
		
		let poptions = {};
		return pdfViewer.viewers[id] = new Plyr('#' + id + '_plyr', poptions);
	},
	
	//
	//
	//
	destroy: function(id) {
		if(pdfViewer.viewers[id]) { 
			pdfViewer.viewers[id].destroy(); 
			pdfViewer.viewers[id] = null;
			let e = document.getElementById(id);
			e.innerHTML = "";
		}
	}
};

function init(options) {
	pdfViewer.options = options;
	
	window.pdfViewer = pdfViewer;
	return pdfViewer.init(options);
};

export default init;
