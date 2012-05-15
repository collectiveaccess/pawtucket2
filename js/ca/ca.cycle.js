/* ----------------------------------------------------------------------
 * js/ca/ca.cycle.js
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2011 Whirl-i-Gig
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
	caUI.initCycle = function(container, options) {
		var that = jQuery.extend({
			container: container,
			imageList: [],
			
			// conveyor-specific options
			duration: 2000, 						// time in milliseconds for conveyor to run end-to-end
			rewind: true,								// if true conveyor will rewind at end and restart
			rewindDuration: 1000,				// time in milliseconds in which to perform rewind of conveyor
			repetitions: 0,							// number of times to run through conveyor before stopping; for no limit set to zero 
			margin: 0,									// space, in pixels, between images in conveyor
			easing: 'linear'							// easing function to use for conveyor motion; values can be 'linear' and 'swing'
		}, options);
		
		// ----------------------------
		// Methods
		// ----------------------------
		// Add images to display cycle. addImage() is a synonym for addImages()
		//
		// @param mixed imageList Single image <img> string or list of tags to display
		// @return boolean Always returns true
		that.addImages = function(imageList) {
			if (!jQuery.isArray(imageList)) {
				imageList = [imageList];
			}
			jQuery.each(imageList, function(i, v) {
				that.imageList.push(v);
			});
			return true;
		}
		that.addImage = that.addImages;
		
		// Remove all images from display cycle
		//
		// @return boolean Always return true
		that.clearImages = function() {
			that.imageList = [];
			return true;
		}
		
		//
		//
		//
		var conveyorLoopCount = 0;
		that.animateConveyor = function(rewind, totalWidth, direction) {
			if ((that.repetitions > 0) && (that.repetitions <= conveyorLoopCount)) { return; }
		
			var gTotalWidth = totalWidth;
			
			var startPoint = 0;
			var endPoint = 0;
			if (direction == 'right') {
				startPoint = -1 * ((totalWidth - jQuery(that.container).width()));
				endPoint =  -1 * (totalWidth - jQuery(that.container).width())
			} else {
				startPoint = 0;
				endPoint = (totalWidth - jQuery(that.container).width());
			}
			
			if (rewind) {
				jQuery(that.container + " div._ca_cycle_inner_group").animate({
						left: startPoint
					}, that.rewindDuration, that.easing, function() {
					that.animateConveyor(false, gTotalWidth, direction);
				});
			} else {
				
				jQuery(that.container + " div._ca_cycle_inner_group").css("left", startPoint);
				jQuery(that.container + " div._ca_cycle_inner_group").animate({
						left: "-=" + endPoint,
					}, that.duration, that.easing, function() {
						conveyorLoopCount++
						that.animateConveyor(that.rewind, gTotalWidth, direction);
				});
			}
		}
		
		
		if ((that.fx == 'conveyorLeft') || (that.fx == 'conveyorRight')) {
			// custom "conveyor belt" cycle
			
			
			// Set container to position: relative so we can absolutely position stuff
			jQuery(that.container).css('position', 'relative');
			
			// Layout images
			jQuery.each(that.imageList, function(i, v) {
				jQuery(that.container).append(v);
			});
			
			var left = 0;
			jQuery(that.container + "> a," + that.container + "> img").each(function(i, e) {
				jQuery(this).css('position', 'absolute').css('top', 0).css('left', left);
				
				left += jQuery(this).width() + that.margin;
			});
			
			jQuery(that.container + "> a," + that.container + "> img").wrapAll("<div class='_ca_cycle_inner_group' style='position: absolute'/>");
			
			// animate
			that.animateConveyor(false, left, ((that.fx == 'conveyorRight') ? 'right' : 'left'));
			
		} else {
			// Standard jCycle display
			jQuery(that.container).empty().html(that.imageList.join("\n"));
			jQuery(that.container).cycle(that);
		}
		
		return that;
	};
})(jQuery);