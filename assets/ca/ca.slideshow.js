/* ----------------------------------------------------------------------
 * js/ca/ca.slideshow.js
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2024 Whirl-i-Gig
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
 
var caUI = caUI || {};

(function ($) {
	caUI.initSlideshow = function(options) {
		// --------------------------------------------------------------------------------
		// setup options
		var that = jQuery.extend({
			index: 0,
			slideList: [],
			containerID: null,
			nextClass: null,
			prevClass: null,
			mediaClass: null,
			thumbClass: null,
			thumbPrefixID: null,
		}, options);
		
		// --------------------------------------------------------------------------------
		
		that.nextItem = function() {
			if(that.index < (that.slideList.length - 1)) {
				that.index = that.index + 1;
				that.setItem(that.index);
			}
			return false;
		};
		that.previousItem = function() {
			if(that.index > 0) {
				that.index = that.index - 1;
				that.setItem(that.index);
			}
			return false;
		};
		
		that.setItem = function(index) {
			if((index >= 0) && (index < that.slideList.length)) {
				jQuery('#' + that.containerID + ' .' + that.mediaClass).html(that.slideList[index]);
				
				if(that.thumbPrefixID) {
					jQuery('#' + that.containerID + ' .' + that.thumbClass).removeClass('active');
					jQuery('#' + that.thumbPrefixID + '_' + index).addClass('active');
				}
			}
			if(index == (that.slideList.length - 1)) {
				jQuery('#' + that.containerID + ' .' + that.nextClass).css('opacity', 0.5);
			} else {
				jQuery('#' + that.containerID + ' .' + that.nextClass).css('opacity', 1.0);
			}
			if(index == 0) {
				jQuery('#' + that.containerID + ' .' + that.prevClass).css('opacity', 0.5);
			} else {
				jQuery('#' + that.containerID + ' .' + that.prevClass).css('opacity', 1.0);
			}
			return false;
		};
		
		that.setItem(0);
		
		jQuery('#' + that.containerID + ' .' + that.prevClass).on('click', function(e) {
			that.previousItem();
			e.preventDefault();
		});
		jQuery('#' + that.containerID + ' .' + that.nextClass).on('click', function(e) {
			that.nextItem();
			e.preventDefault();
		});
		
		if(that.slideList.length <= 1) {
			jQuery('#' + that.containerID + ' .' + that.prevClass).hide();
			jQuery('#' + that.containerID + ' .' + that.nextClass).hide();
		} else {
			jQuery('#' + that.containerID + ' .' + that.prevClass).show();
			jQuery('#' + that.containerID + ' .' + that.nextClass).show();
		}
		
		// --------------------------------------------------------------------------------
		
		return that;
	};	
})(jQuery);
