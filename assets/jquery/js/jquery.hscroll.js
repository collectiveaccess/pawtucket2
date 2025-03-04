/* ----------------------------------------------------------------------
 * jquery.hscroll : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * jQuery plugin for horizontal infinite scrolling of a result set
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
"use strict";
 
(function($) {
    $.hscroll = {
        defaults: {
            debug: false,
            name: 'hscroll',
            itemCount: 0,
            preloadCount: 0,
            itemWidth: 0,
            itemsPerLoad: 0,
            itemsPerColumn: 1,
            itemSort: '_natural',
            itemContainerSelector: '.blockResultsScroller',
            itemLoadURL: '',
            sortParameter: 'sort',
            sortControlSelector: null,
            sortDirectionParameter: 'sortDirection',
            sortDirectionSelector: null,
            sortDirection: 'asc',
            
            scrollPreviousControlSelector: null,
            scrollNextControlSelector: null,
            scrollControlDisabledOpacity: 0.25,
            scrollControlEnabledOpacity: 0.7,
            scrollControlDuration: 350,
            
            cacheKey: null
        }
    };

    // Constructor
    var hScroll = function($e, options) {

		var _options = $.extend({}, $.hscroll.defaults, options || {})
		
		var loadedTo = _options.preloadCount;
		var loading = false;
		var isScrolling = false;
		
		
        var data = $e.data('hscroll');
        
        if (!data) { data = {}; }
        data['initialized'] = true;
        data['sort'] = _options.itemSort;
        data['sortDirection'] = _options.itemSortDirection;
        if (_options.sortControlSelector) {
        	if (jQuery(_options.sortControlSelector).find('li').length) {
        		// is a list
        		if (jQuery(_options.sortControlSelector).find('li.selectedSort').length) {
        			data['sort'] = jQuery(_options.sortControlSelector).find('li.selectedSort a').attr('rel');
        		} else {
        			data['sort'] = jQuery(_options.sortControlSelector).find('li a').attr('rel');
        		}
        	} else {
        		data['sort'] = jQuery(_options.sortControlSelector).val();
        	}
        }
        
        $e.data('hscroll', data);
      	
      	var jar = jQuery.cookieJar(_options.name+"_hscrollData");
      	if (jar.get('cacheKey') !== (_options.cacheKey + '_' + data['sort'] + '_' + data['sortDirection'])) {
      		jar.set('scrollPos', 0);
      		jar.set('cacheKey', (_options.cacheKey + '_' + data['sort'] + '_' + data['sortDirection']));
      	}
      	var scrollPos = jar.get('scrollPos');
      	
        $e.find(_options.itemContainerSelector).css("width", _calculateWidth() + "px");
        
    	if (scrollPos > 0) {
      		_getScrollLeft(scrollPos);
        }
        if (_needsLoad()) {
			_load(loadedTo + _options.itemsPerLoad);
		}
		
		_setScrollControls();
        
        $e.on("scroll.hscroll", function(e) {
        	var left = parseInt(_getScrollLeft());
        	jar.set('scrollPos', left);
        	
        	if (loadedTo >= _options.itemCount) { 
        		_setScrollControls();
        		return; 
        	}
        	if (_needsLoad()) {									
        		_load(loadedTo + _options.itemsPerLoad);
        	}
        	
        	_setScrollControls();
        });
        $e.on("jsp-scroll-x", function(e) {
        	var left = parseInt(_getScrollLeft());
        	jar.set('scrollPos', left);
        	
        	if (loadedTo >= _options.itemCount) { 
        		_setScrollControls();
        		return; 
        	}
        	if (_needsLoad()) {								
        		_load(loadedTo + _options.itemsPerLoad);
        	}
        	
        	_setScrollControls();
        });
                
         $e.on("resort.hscroll", function(e) {
         	loadedTo = 0;
         	$e.find(_options.itemContainerSelector).html('').css("width", _calculateWidth() + "px");
         	_getScrollLeft(0);
         	jar.set('scrollPos', 0);
      		jar.set('cacheKey', (_options.cacheKey + '_' + data['sort'] + '_' + data['sortDirection']));
         	_load(0);
         });
         
          $e.on("jsp-initialised", function (e, isScrollable) {
 	         	_setScrollControls();
          });
         
		if (_options.sortControlSelector) {
			var li = jQuery(_options.sortControlSelector).find('li');
			if (li.length) {
				li.find("a").on('click', function(e) {
					jQuery(this).parent().parent().find('li').removeClass('selectedSort');
					jQuery(this).parent().addClass('selectedSort');
					$e.hscroll({sort: jQuery(this).attr('rel')});
					e.stopPropagation();
					return false;
				});
				
			} else {
				jQuery(_options.sortControlSelector).on("change", function(e) {
					$e.hscroll({sort: jQuery(_options.sortControlSelector).val()});
				});
			}
		}
		
		if (_options.sortDirectionSelector) {
			jQuery(_options.sortDirectionSelector).on('click', function(e) {
				if (_options.sortDirection == 'asc') {
					jQuery(this).find('span').removeClass('glyphicon-sort-by-alphabet').addClass('glyphicon-sort-by-alphabet-alt');
					_options.sortDirection = 'desc';
				} else {
					jQuery(this).find('span').removeClass('glyphicon-sort-by-alphabet-alt').addClass('glyphicon-sort-by-alphabet');
					_options.sortDirection = 'asc';
				}
				$e.hscroll({sortDirection: _options.sortDirection});
				e.stopPropagation();
				return false;
			});
		}
		
		if (_options.scrollPreviousControlSelector) {
			jQuery(_options.scrollPreviousControlSelector).on("click", function(e) {
				if (isScrolling) { return false; }
				isScrolling = true;
				
				if (_usingJScrollPane()) {
					var api = $e.data('jsp');
					if (!api)  return false;
        			api.scrollToX(_getScrollLeft() - $e.width(), true);
        			isScrolling = false;
				} else {
					$e.animate({ scrollLeft: _getScrollLeft() - $e.width() + "px" }, { duration: _options.scrollControlDuration, easing: "swing", complete: function(e) {
						_setScrollControls();
						isScrolling = false;
					}});
				}
				return false;
			});
		}
		
		if (_options.scrollNextControlSelector) {
			jQuery(_options.scrollNextControlSelector).on("click", function(e) {
				if (isScrolling) { return false; }
				isScrolling = true;
				
				if (_usingJScrollPane()) {
					var api = $e.data('jsp');
					if (!api)  return false;
        			api.scrollToX(_getScrollLeft() + $e.width(), true);
        			isScrolling = false;
				} else {
					$e.animate({ scrollLeft: _getScrollLeft() + $e.width() + "px" }, { duration: _options.scrollControlDuration, easing: "swing", complete: function(e) {
						_setScrollControls();
						isScrolling = false;
					}});
				}
				return false;
			});
		}
        
        // Private

		//
		// Determine visibility of scrolling controls
		//
		function _setScrollControls() {
			var sl = _getScrollLeft();
			var sw = _calculateWidth();
			jQuery(_options.scrollPreviousControlSelector).css("opacity", (sl <= 0) ? _options.scrollControlDisabledOpacity : _options.scrollControlEnabledOpacity);
			jQuery(_options.scrollNextControlSelector).css("opacity", (sl + $e.width() >= sw) ? _options.scrollControlDisabledOpacity : _options.scrollControlEnabledOpacity);
		}
		
		//
		// Do we need to load more content given the current scroll position?
		//
		function _needsLoad() {
			if (options.itemsPerLoad >= options.itemCount) { return false; }
			var left = parseInt(_getScrollLeft());
			var loadWidth = _options.itemWidth * Math.ceil(_options.itemsPerLoad/_options.itemsPerColumn);	// width in pixels of an ajax load with the full item count
        	var loads = Math.floor(loadedTo/_options.itemsPerLoad);											// number of loaded completed (or preloaded)
        	
        	if (((loadWidth * loads) - left) < loadWidth) {													// if there's less than a load width perform a load
        		return true;
        	}
        	return false;
		}
		
		//
		// Current scroll position
		//
		function _getScrollLeft(pos) {
			if (_usingJScrollPane()) {
				// using jScrollPane
        		var api = $e.data('jsp');
        		if (!api)  return 0;
        		var left = api.getContentPositionX();
        		
        		if((pos !== null) && (pos !== undefined)) {
        			api.scrollToX(pos, true);
        		}
        		return left;
        	} else {
        		if((pos !== null) && (pos !== undefined)) {
        			$e.scrollLeft(pos);
        		}
        		return $e.scrollLeft();
        	}
		}
		
		//
		// Is the area we're scrolling a JScrollPane area or a plain-old <div>?
		//
		function _usingJScrollPane() {
			return (jQuery($e).find(".jspContainer").length > 0);
		}
		
		//
		// Calculate width of scroll track
		//
		function _calculateWidth() {
			var loadWidth = _options.itemWidth * Math.ceil(_options.itemsPerLoad/_options.itemsPerColumn);	// width in pixels of an ajax load with the full item count
        	var loads = Math.floor(loadedTo/_options.itemsPerLoad);
			var w = loads * loadWidth;
			
			// Add space for the next page if needed
			if ((loads * _options.itemsPerLoad) < _options.itemCount) {
				var d = _options.itemCount - (loads * _options.itemsPerLoad);
				if (d > _options.itemsPerLoad) { d = _options.itemsPerLoad; }
				
				w += Math.ceil(d/_options.itemsPerColumn) * _options.itemWidth;
			}
			
			if (w > (Math.ceil(_options.itemCount/_options.itemsPerColumn) * _options.itemWidth)) { w = Math.ceil(_options.itemCount/_options.itemsPerColumn) * _options.itemWidth; }
			
			return w;
		}
		
		function _load(to) {
			if(loading) { return; }
			loading = true;
			
			if (to < loadedTo) { return; }
			
			data = $e.data('hscroll'); 
			
			var opts = { s: loadedTo };
			opts[_options.sortParameter] = data.sort;
			opts[_options.sortDirectionParameter] = data.sort_direction;
			
			jQuery.get(_options.itemLoadURL, opts, function(data, textStatus, jqXHR) {
				$e.find(_options.itemContainerSelector).append(data);
				loadedTo += _options.itemsPerLoad;
				
				if (to > loadedTo) {
					loading = false;
					_load(loadedTo + _options.itemsPerLoad);
				} else {
					$e.find(_options.itemContainerSelector).css("width", _calculateWidth() + "px");
					
					loading = false;
				}
				
				if (_usingJScrollPane()) {
					$e.jScrollPane();
				}
			});
			
			
		}
		
		// Remove the hscroll events
        function _destroy() {
            return _$e.unbind('.hscroll').removeData('hscroll');
        }
       
        // Expose API methods 
        $.extend($e.hscroll, {
            destroy: _destroy
        });
        return $e;
    };


    $.fn.hscroll = function(m) {
        return this.each(function() {
            var $this = $(this),
                data = $this.data('hscroll');
                
            if (data && data.initialized && m.sort) {
            	data.sort = m.sort;
                $this.data('hscroll', data);
            	$this.trigger("resort");
            	return;
            }
            if (data && data.initialized && m.sortDirection) {
            	data.sort_direction = m.sortDirection;
                $this.data('hscroll', data);
            	$this.trigger("resort");
            	return;
            }
            var hscroll = new hScroll($this, m);
        });
    };
})(jQuery);