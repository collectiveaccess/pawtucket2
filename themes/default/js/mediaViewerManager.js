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
		
		let display_classes = [];
		for(let i in media_list) {
		  if (media_list[i] && media_list[i].display_class) {
			if (!display_classes.includes(media_list[i].display_class)) { display_classes.push(media_list[i].display_class); }
		  }
		}
		
		for(let d in display_classes) {
			document.getElementById(id + '_' + display_classes[d]).style.display = (display_classes[d] === m.display_class) ? 'block' : 'none';
		}
		if(m === undefined) {
			console.log('[mediaViewerManager::ERROR] Index ' + m + ' does not exist');
			return false;
		}
		
		if(mediaViewerManager.viewers[id]['viewer']) { mediaViewerManager.viewers[id]['viewer'].destroy(m); }
		
		let viewer = mediaViewerManager.getViewer(id, m.media_class, mediaViewerManager.options);
		viewer.load(m);
	
		mediaViewerManager.viewers[id]['viewer'] = viewer;
		return true;
	},
	
	//
	//
	//
	getViewer: function(id, viewer_class, options={}) {
		let viewer = null;
		let iv;
		switch(viewer_class) {
			case 'image':
				iv = require('mediaViewers/imageViewer.js') ;
				break;
			case 'audio':
				iv = require('mediaViewers/audioViewer.js') ;
				break;
			case 'video':
				iv = require('mediaViewers/videoViewer.js') ;
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
		let v = iv.default(options);
		return v.init(id, options);
	}
  
};

function init(options) {
	mediaViewerManager.options = options;
	window.mediaViewerManager = mediaViewerManager;
	return mediaViewerManager.init(options);
};

export default init;
