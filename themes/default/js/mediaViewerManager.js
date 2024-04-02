let mediaViewerManager = function(options=null) {
	let viewers = {};
	let that = {
		// Properties
		//
		id: null,
		options: {},
		index: 0,
		media_list: [],
		viewer: null,
		debug: true,
		
		//
		// Methods
		//
		
		//
		//
		//
		init: function(id, options={}) {
			if(that.debug) { console.trace('[mediaViewerManager::DEBUG] Init id ' + id + ' with options', options); }
			
			that.id = id;
			that.options = options;
			
			if(!window.mediaViewerManagers) { window.mediaViewerManagers = {}; }
			window.mediaViewerManagers[id] = that;
			
			
			let button_id = that.options['previous_button_id'];
			let e = null;
			if(button_id) {
				if(e = document.getElementById(button_id)) {
					options.previous_button_classname = e.className;
				}
			}
			button_id = that.options['next_button_id']
			if(button_id) {
				if(e = document.getElementById(button_id)) {
					options.next_button_classname = e.className;
				}
			}
			
			if(options.media_list) { that.setMediaList(options.media_list); }
			
			that.updateNextPreviousNavigation();
			return that;
		},
		
		//
		//
		//
		setMediaList: function(media_list) {
			if(that.debug) { console.log('[mediaViewerManager::DEBUG] Set media for id ', that.id, media_list); }
			
			that.media_list = media_list;
		},
		
		//
		//
		//
		getMediaList: function() {
			if(!that.media_list) { return null; }
			return that.media_list;
		},
		
		//
		//
		//
		render: function(index, options={}) {
			let media_list = that.media_list;
			if(media_list === undefined) { return false; }
			
			let m = media_list[index];
			
			let display_classes = [];
			for(let i in media_list) {
			  if (media_list[i] && media_list[i].display_class) {
				if (!display_classes.includes(media_list[i].display_class)) { display_classes.push(media_list[i].display_class); }
			  }
			}
			
			for(let d in display_classes) {
				document.getElementById(that.id + '_' + display_classes[d]).style.display = (display_classes[d] === m.display_class) ? 'block' : 'none';
			}
			if(m === undefined) {
				console.log('[mediaViewerManager::ERROR] Index ' + m + ' does not exist');
				return false;
			}
			
			if(!options['overlay']) {
				if(that.viewer) { that.viewer.destroy(m); }
			}
			
			let viewer;
			if(!options['overlay']) {
				viewer = that.getViewer(m.media_class, that.options);
			} else {
				viewer = viewers[that.id];
			}
			
			let load_options = {};
			Object.assign(load_options, options);
			Object.assign(load_options, that.options);
			viewer.load(m, load_options);
			
			viewers[that.id] = viewer;
			that.index = index;
			
			if(!options['overlay']) {
				that.hideOverlay();
			}
			that.viewer = viewer;
			return true;
		},
		
		//
		//
		//
		renderPrevious: function() {
			let media_list = that.media_list;
			let index = that.index;
			if(index > 0) {
				that.render(index-1);
			} 
			
			that.updateNextPreviousNavigation();
		},
		
		//
		//
		//
		renderNext: function() {
			let media_list = that.media_list;
			let index = that.index;
			
			if((index + 1) < media_list.length) {
				that.render(index+1);
			}
			
			that.updateNextPreviousNavigation();
		},
		
		//
		//
		//
		updateNextPreviousNavigation: function() {
			let media_list = that.media_list;
			let media_count = media_list.length;
			
			let e = null; 
			let next_button_id = that.options['next_button_id'];
			let next_button_class = that.options['next_button_classname'];
			let previous_button_id = that.options['previous_button_id'];
			let previous_button_class = that.options['previous_button_classname'];
			let index = that.index;
			
			if(next_button_id) { 
				e = document.getElementById(next_button_id);	
				if(e) {
					e.className = next_button_class + ((media_count <= 1) || (((index + 1) >= media_list.length)) ? '-disabled' : '');
				}
			}
			
			if(previous_button_id) { 
				e = document.getElementById(previous_button_id);
				if(e) {
					e.className = previous_button_class + ((media_count <= 1) || (((index - 1) < 0)) ? '-disabled' : '');
				}
			}
		},
		
		
		//
		//
		//
		showOverlay: function() {
			let m_id = that.options['media_overlay_id'] ?? null;
			let c_id = that.options['media_overlay_content_id'] ?? null;
			if(m_id && c_id) {
				let e = document.getElementById(m_id);
				if(e) {
					e.style.display = 'block';
				}
				
				let containerDivs = viewers[that.id].containerDivs(that.id, that.media_list[that.index], that.options);
				
				
				let c = document.getElementById(c_id);
				let cc = c.children;
				console.log('xxx', c_id, cc);
				for (let i = 0; i < cc.length; i++) {
				   cc[i].style.display = 'none';
				}
				containerDivs['overlay_content'].style.display = 'block';
				
				if(that.viewer.onShowOverlay) { that.viewer.onShowOverlay(); }
				that.render(that.index, {'overlay': true});
			}
		},
		
		//
		//
		//
		hideOverlay: function() {
			if(that.viewer) {
				let options = {...that.options};
				options['overlay'] = true;
				that.viewer.destroy(that.media_list[that.index], options);
			}
			let m_id = that.options['media_overlay_id'] ?? null;
			if(m_id) {
				let e = document.getElementById(m_id);
				if(e) {
					e.style.display = 'none';
				}
			}
		},
		
		
		//
		//
		//
		getViewer: function(viewer_class, options={}) {
			let viewer = null;
			let iv;
			switch(viewer_class) {
				case 'image':
					iv = require('mediaViewers/image.js') ;
					break;
				case 'audio':
					iv = require('mediaViewers/audio.js') ;
					break;
				case 'video':
					iv = require('mediaViewers/video.js') ;
					break;
				case 'document':
					iv = require('mediaViewers/document.js') ;
					break;
				case '3d':
					alert('3d not implemented (yet)');
					break;
				default:
					console.log('[mediaViewerManager::ERROR] Invalid media class ' + m.media_class);
					return;
			}
			let v = iv.default(options);
			return v.init(that.id, options);
		}
	};
	that.init(options.id, options);
	return that;
};

export default mediaViewerManager;
