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
 
(function($) {
    $.hscroll = {
        defaults: {
            debug: false,
            itemCount: 0,
            itemWidth: 0,
            itemsPerLoad: 0,
            itemsPerColumn: 1,
            itemSort: '_natural',
            itemContainerSelector: '.blockResultsScroller',
            itemLoadURL: '',
            sortParameter: 'sort',
            sortControlSelector: null
        }
    };

    // Constructor
    var hScroll = function($e, options) {

		var _options = $.extend({}, $.hscroll.defaults, options || {})
		var start = 0;
        
        var data = $e.data('hscroll');
        if (!data) { data = {}; }
        data['initialized'] = true;
        data['sort'] = _options.itemSort;
        $e.data('hscroll', data);
        
        $e.find(_options.itemContainerSelector).css("width", _calculateWidth() + "px");
        
        $e.bind("scroll.hscroll", function(e) {
        	if (start + _options.itemsPerLoad  >= _options.itemCount) { return; }
        	
        	var left = parseInt($e.scrollLeft());
        	var loadWidth = _options.itemWidth * Math.ceil(_options.itemsPerLoad/_options.itemsPerColumn);
        	var loads = Math.ceil(start/_options.itemsPerLoad) + 1;
        	
        	if (((loadWidth * loads) - left) < loadWidth) {
        		start += _options.itemsPerLoad;
        		_load(start);
        	}
        });
        
         $e.bind("resort.hscroll", function(e) {
         	start = 0;
         	$e.find(_options.itemContainerSelector).html('').css("width", _calculateWidth() + "px");
         	$e.scrollLeft(0);
         	_load(0);
         });
         
         
		if (_options.sortControlSelector) {
			jQuery(_options.sortControlSelector).bind("change", function(e) {
				$e.hscroll({sort: jQuery(_options.sortControlSelector).val()});
			});
		}
        
        // Private

		//
		// Calculate width of scroll track
		//
		function _calculateWidth() {
        	var loads = Math.ceil(start/_options.itemsPerLoad) + 1;
			var w = loads * Math.ceil(_options.itemsPerLoad/_options.itemsPerColumn) * _options.itemWidth;
			
			// Add space for the next page if needed
			if ((loads * _options.itemsPerLoad) < _options.itemCount) {
				var d = _options.itemCount - (loads * _options.itemsPerLoad);
				if (d > _options.itemsPerLoad) { d = _options.itemsPerLoad; }
				
				w += Math.ceil(d/_options.itemsPerColumn) * _options.itemWidth;
			}
			
			if (w > (Math.ceil(_options.itemCount/_options.itemsPerColumn) * _options.itemWidth)) { w = Math.ceil(_options.itemCount/_options.itemsPerColumn) * _options.itemWidth; }
			
			return w;
		}
		
		function _load(start) {
			var opts = { s: start };
			opts[_options.sortParameter] = data.sort;
			
			jQuery.get(_options.itemLoadURL, opts, function(data, textStatus, jqXHR) {
				$e.find(_options.itemContainerSelector).append(data);
			});
			
			$e.find(_options.itemContainerSelector).css("width", _calculateWidth() + "px");
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
            	$this.trigger("resort");
            	return;
            }
            var hscroll = new hScroll($this, m);
        });
    };
})(jQuery);