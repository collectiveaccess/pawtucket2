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
			button_id = that.options['next_button_id'];
			if(button_id) {
				if(e = document.getElementById(button_id)) {
					options.next_button_classname = e.className;
				}
			}
			
			button_id = that.options['overlay_previous_button_id'];
			if(button_id) {
				if(e = document.getElementById(button_id)) {
					options.overlay_previous_button_classname = e.className;
				}
			}
			button_id = that.options['overlay_next_button_id'];
			if(button_id) {
				if(e = document.getElementById(button_id)) {
					options.overlay_next_button_classname = e.className;
				}
			}
			
			button_id = that.options['show_overlay_button_id'];
			if(button_id) {
				if(e = document.getElementById(button_id)) {
					options.show_overlay_button_classname = e.className;
				}
			}
			
			
			if(options.media_list) { that.setMediaList(options.media_list); }
			
			that.updateNextPreviousNavigation();
			return that;
		},
		
		//
		//
		//
		setup: function() {
			that.render(0);
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
			console.log("xxx", media_list);
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
			
			let viewer;
			
			if(!options['overlay']) {
				if(that.viewer) { that.viewer.destroy(m); }
				viewer = that.getViewer(m.media_class, that.options);
			} else {
				viewer = viewers[that.id];
			}
			
			let k = options['overlay'] ? 'media_overlay_caption_id' : 'media_caption_id';
			if(that.options[k]) {
				let e = document.getElementById(that.options[k]);
				if(e) {
					e.innerHTML = m.caption;
				}
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
			that.updateNextPreviousNavigation();
			return true;
		},
		
		//
		//
		//
		renderPrevious: function(overlay=false) {
			let media_list = that.media_list;
			let index = that.index;
			if(index > 0) {
				that.render(index-1);
				if(overlay) { that.showOverlay(); }
				let overlay_previous_button_id = that.options['overlay_previous_button_id'];
				let e = null;
				e = document.getElementById(overlay_previous_button_id);
				if(e) {
					e.focus();
				}
			} else {
				return;
			}
			that.updateNextPreviousNavigation();
		},
		
		//
		//
		//
		renderNext: function(overlay=false) {
			let media_list = that.media_list;
			let index = that.index;
			
			if((index + 1) < media_list.length) {
				that.render(index+1);
				if(overlay) { that.showOverlay(); }
				let overlay_next_button_id = that.options['overlay_next_button_id'];
				let e = null;
				e = document.getElementById(overlay_next_button_id);
				if(e) {
					e.focus();
				}
			} else {
				return
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
			
			let overlay_next_button_id = that.options['overlay_next_button_id'];
			let overlay_next_button_class = that.options['overlay_next_button_classname'];
			let overlay_previous_button_id = that.options['overlay_previous_button_id'];
			let overlay_previous_button_class = that.options['overlay_previous_button_classname'];
			
			let show_overlay_button_id = that.options['show_overlay_button_id'];
			let download_button_id = that.options['download_button_id'];
			
			let media_count_id = that.options['media_count_id'];
			
			let index = parseInt(that.index);
			
			if(media_count_id) {
				if(media_count > 1){
					e = document.getElementById(media_count_id);
					if(e) {
						e.innerHTML = (index + 1) + '/' + media_count;
					}
				}
			}
			if(show_overlay_button_id) {
				e = document.getElementById(show_overlay_button_id);
				if(e) {
					e.style.display = (media_list[index] && media_list[index]['no_overlay']) ? 'none' : 'inline';
					
				}
			}
			
			if(download_button_id) {
				e = document.getElementById(download_button_id);
				if(e) {
					e.style.display = (media_list[index] && media_list[index]['download_version']) ? 'inline' : 'none';
					e.href = that.options.media_download_url + "&version=" + media_list[index]['download_version'] + "&representation_id=" + media_list[index]['representation_id'];
				}
			}
			
			
			if(next_button_id) { 
				e = document.getElementById(next_button_id);	
				if(e) {
					if (media_count <= 1) {
						e.style.display = 'none';
					} else {
						e.className = next_button_class + ((((index + 1) >= media_list.length)) ? ' disabled' : '');
						if((index + 1) >= media_list.length){
							e.setAttribute("aria-disabled", "true");
						}else{
							e.setAttribute("aria-disabled", "false");
						}
					}
				}
			}
			
			if(previous_button_id) { 
				e = document.getElementById(previous_button_id);
				if(e) {
					if (media_count <= 1) {
						e.style.display = 'none';
					} else {
						e.className = previous_button_class + ((((index - 1) < 0)) ? ' disabled' : '');
						if((index - 1) < 0){
							e.setAttribute("aria-disabled", "true");
						}else{
							e.setAttribute("aria-disabled", "false");
						}
					}
				}
			}
			
			if(overlay_next_button_id) { 
				e = document.getElementById(overlay_next_button_id);	
				if(e) {
					if (media_count <= 1) {
						e.style.display = 'none';
					} else {
						e.className = overlay_next_button_class + ((((index + 1) >= media_list.length)) ? ' disabled' : '');
						if((index + 1) >= media_list.length){
							e.setAttribute("aria-disabled", "true");
						}else{
							e.setAttribute("aria-disabled", "false");
						}
					}
				}
			}
			
			if(overlay_previous_button_id) { 
				e = document.getElementById(overlay_previous_button_id);
				if(e) {
					if (media_count <= 1) {
						e.style.display = 'none';
					} else {
						e.className = overlay_previous_button_class + ((((index - 1) < 0)) ? ' disabled' : '');
						if((index - 1) < 0){
							e.setAttribute("aria-disabled", "true");
						}else{
							e.setAttribute("aria-disabled", "false");
						}
					}
				}
			}
			if(that.options.media_selector_id && that.options.media_selector_item_class) {
				e = document.getElementById(that.options.media_selector_id);
				if(e) {
					let selector_items = e.getElementsByClassName(that.options.media_selector_item_class);
					
					for(let i=0; i < selector_items.length; i++) {
						selector_items[i].className = that.options.media_selector_item_class + ((i === index) ? ' ' + that.options.media_selector_item_class_active : '');
					}
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
					//e.style.display = 'block';
					e.showModal();
					//e.focus();
					document.body.style.overflow = "hidden";
					e.setAttribute("aria-modal", "true");
				}
				
				let containerDivs = viewers[that.id].containerDivs(that.id, that.media_list[that.index], that.options);
				
				
				let c = document.getElementById(c_id);
				let cc = c.children;
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
					e.close();
					//e.style.display = 'none';
					document.body.style.overflow = "scroll";
					e.removeAttribute("aria-modal");
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
					iv = require('mediaViewers/threed.js') ;
					break;
				default:
					console.log('[mediaViewerManager::ERROR] Invalid media class ' + viewer_class);
					return;
			}
			options['mediaViewer'] = that;
			let v = iv.default(options);
			return v.init(that.id, options);
		}
	};
	that.init(options.id, options);
	return that;
};

export default mediaViewerManager;
