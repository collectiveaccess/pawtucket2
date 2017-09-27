/* ----------------------------------------------------------------------
 * js/ca/ca.googlemaps.js
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010-2013 Whirl-i-Gig
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
	caUI.initGoogleMap = function(options) {
		// --------------------------------------------------------------------------------
		// setup options
		var that = jQuery.extend({
			map: null,
			id: 'map',
			mapType: 'TERRAIN',
			
			navigationControl: true,
  			mapTypeControl: true,
 			scaleControl: true,
 			zoomControl: true
		}, options);
		
		that.infoWindow = new google.maps.InfoWindow();
		that.map = new google.maps.Map(document.getElementById(that.id), { disableDefaultUI: true, mapTypeId: google.maps.MapTypeId[that.mapType], navigationControl: that.navigationControl, mapTypeControl: that.mapTypeControl, scaleControl: true, zoomControl: that.zoomControl });
		
		// --------------------------------------------------------------------------------
		// Define methods
		// --------------------------------------------------------------------------------
		that.openMarkerInfoWindow = function(marker) {
			var markerLatLng = marker.getPosition();
			
			if(marker.ajaxContentUrl.length > 0) {
				jQuery.ajax(marker.ajaxContentUrl, { success: function(data, textStatus, jqXHR) { 
					that.infoWindow.setContent(data); 
				}});
			} else {
				that.infoWindow.setContent(marker.content);
			}
			that.infoWindow.open(that.map, marker);
		};
		
		that.openCircleInfoWindow = function(circle) {
			var circleLat = circle.getCenter().lat();
			var circleLng = circle.getCenter().lng();
			var circleLatLng = new google.maps.LatLng(circleLat, circleLng);
			if(circle.ajaxContentUrl.length > 0) {
				jQuery.ajax(circle.ajaxContentUrl, { success: function(data, textStatus, jqXHR) { that.infoWindow.setContent(data); }})
			} else {
				that.infoWindow.setContent(circle.content);
			}
			that.infoWindow.setPosition(circleLatLng);
			that.infoWindow.open(that.map, circle);
		};
		// --------------------------------------------------------------------------------
		that.openPathInfoWindow = function(latlng, path) {
			that.infoWindow.setContent(path.content);
			that.infoWindow.setPosition(latlng);
			that.infoWindow.open(that.map);
		};
		// --------------------------------------------------------------------------------
		that.makeMarker = function(lat, lng, label, content, ajaxContentUrl, options) {
			var pt = new google.maps.LatLng(lat, lng);
			var opts = {
				position: pt,
				map: that.map,
				title: label + ' ',
				content: content + ' ',
				ajaxContentUrl: ajaxContentUrl,
			};
			if (options && options.icon) { opts['icon'] = options.icon; }
			var marker = new google.maps.Marker(opts);
			
			if(label || content || ajaxContentUrl){
				google.maps.event.addListener(marker, 'click', function(e) { 
					that.map.setCenter(marker.getPosition());
					that.openMarkerInfoWindow(marker); 
				});
			}
			return marker;
		};
		// --------------------------------------------------------------------------------
		that.makeCircle = function(lat, lng, label, content, ajaxContentUrl, options) {
			var pt = new google.maps.LatLng(lat, lng);
			var opts = {
				map: that.map,
      			center: pt,
      			radius: 500,
				title: label + ' ',
				content: content + ' ',
				ajaxContentUrl: ajaxContentUrl
			};
			if (options) {
				if (options.strokeColor) {opts['strokeColor'] = options.strokeColor;}
				if (options.strokeOpacity) {opts['strokeOpacity'] = options.strokeOpacity;}
				if (options.strokeWeight) {opts['strokeWeight'] = options.strokeWeight;}
				if (options.fillColor) {opts['fillColor'] = options.fillColor;}
				if (options.fillOpacity) {opts['fillOpacity'] = options.fillOpacity;}
				if (options.radius) {opts['radius'] = options.radius;}
			}
			var circle = new google.maps.Circle(opts);
			
			google.maps.event.addListener(circle, 'click', function(e) { that.openCircleInfoWindow(circle); });
			
			return circle;
		};
		// --------------------------------------------------------------------------------
		that.makePath = function(pathArray, label, content, opts) {
			var path = new google.maps.Polyline(opts);
			path.setPath(pathArray);
			path.setMap(that.map);
			path.label = label;
			path.content = content;
			
			google.maps.event.addListener(path, 'click', function(e) { that.openPathInfoWindow(e.latLng, path); });
			return path;
		};
		// --------------------------------------------------------------------------------
		that.closeInfoWindow = function() { 
			that.infoWindow.close(); 
		}
		// --------------------------------------------------------------------------------
		that.fitBounds = function(n, s, e, w) {
			that.map.fitBounds(new google.maps.LatLngBounds(new google.maps.LatLng(s,w), new google.maps.LatLng(n,e)));
		}
		// --------------------------------------------------------------------------------
		
		// Add self to div containing map; this is useful for external callers
		jQuery("#" + that.id).data('mapInstance', that);
		return that;
	};	
})(jQuery);
