let mediaViewerManager = {
	//
	// Properties
	//
	viewers: {},
	options: {},
	debug: true,
	
	//
	// Methods
	//
	
	//
	//
	//
	init: function(options={}) {
		if(mediaViewerManager.debug) { console.log('[mediaViewerManager::DEBUG] Init with options', options); }
		
		let id = options.id;
		mediaViewerManager.urlPath = options.urlPath;
		if(options.media_list) { mediaViewerManager.setMediaList(id, options.media_list); }
		return mediaViewerManager;
	},
	
	//
	//
	//
	setMediaList: function(id, media_list) {
		if(mediaViewerManager.debug) { console.log('[mediaViewerManager::DEBUG] Set media for id ', id, media_list); }
		
		if(!mediaViewerManager.viewers[id]) { mediaViewerManager.viewers[id] = {}; }
		mediaViewerManager.viewers[id]['media_list'] = media_list;
	},
	
	//
	//
	//
	getMediaList: function(id) {
		if(!mediaViewerManager.viewers[id]) { return null; }
		return mediaViewerManager.viewers[id]['media_list'];
	},
	
	//
	//
	//
	render: function(id, index) {
		if(!mediaViewerManager.viewers[id]) { return false; }
		let media_list = mediaViewerManager.viewers[id]['media_list'];
		if(media_list === undefined) { return false; }
		
		let m = media_list[index];
		if(m === undefined) {
			console.log('[mediaViewerManager::ERROR] Index ' + m + ' does not exist');
			return false;
		}
		
		if(mediaViewerManager.viewers[id]['viewer']) { mediaViewerManager.viewers[id]['viewer'].destroy(id); }
		
		let viewer = mediaViewerManager.getViewer(m.media_class, mediaViewerManager.options);
		viewer.load(id, m);
	
		mediaViewerManager.viewers[id]['viewer'] = viewer;
		return true;
	},
	
	//
	//
	//
	getViewer: function(viewer_class, options={}) {
		let viewer = null;
		let iv;
		switch(viewer_class) {
			case 'image':
				iv = require('mediaViewers/imageViewer.js') ;
				viewer = iv.default(options);
				break;
			case 'audio':
				alert('audio not implemented (yet)');
				break;
			case 'video':
				iv = require('mediaViewers/videoViewer.js') ;
				viewer = iv.default(options);
				break;
			case 'document':
				alert('document not implemented (yet)');
				break;
			case '3d':
				alert('3d not implemented (yet)');
				break;
			default:
				console.log('[mediaViewerManager::ERROR] Invalid media class ' + m.media_class);
				return;
		}
		return viewer;
	}
  
};

function init(options) {
	mediaViewerManager.options = options;
	window.mediaViewerManager = mediaViewerManager;
	return mediaViewerManager.init(options);
};

export default init;
