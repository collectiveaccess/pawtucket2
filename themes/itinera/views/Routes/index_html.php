<div id='travelerList' class='clearfix'>
	
</div>


<div class="container">
	<div class="row">
		<div class="col-sm-10" id='routeMap'>
			
		</div>
		<div class="col-sm-2" id='travelerContentContainer'>
			<div id='travelerContent' style="height: 600px;">
 			
			</div>
		</div>
	</div>
	<div class="row" id="routeMapSliderContainer">
		<div class="col-sm-1">
			<span id="routeMapYearSliderStart"></span> 
		</div>
		<div class="col-sm-10">
			<div id="routeMapYear"></div>
			<!--<input id="routeMapYear" data-slider-id="routeMapYearSlider" type="text" value="" data-slider-min="1700" data-slider-max="1900" data-slider-step="1" data-slider-value="[1740,1850]"/>-->
		</div>
		<div class="col-sm-1">
			<span id="routeMapYearSliderEnd"></span>
		</div>
	</div>
</div>


<script type="text/javascript">
	jQuery(document).ready(function() {
		
		// Load traveler index via ajax
		jQuery("#travelerList").load('<?php print caNavUrl($this->request, '*', '*', 'TravelerIndex'); ?>');
		
		// Load traveler list via ajax
		jQuery("#travelerContent").load('<?php print caNavUrl($this->request, '*', '*', 'Get'); ?>');
		
		//
		// Set up map 
		//
		var map = {l: null, data: null, locationMarkers: {}, baseLayer: null, startYear: null, endYear: null};
		map.generateMap = function(map, start, end) {
			map.l.eachLayer(function (layer) {
				if (layer != map.baseLayer) { map.l.removeLayer(layer); }
			});
			map.startYear = map.endYear = null;
			jQuery.each(map.data, function(id, map_data_for_location) {
				if(!map_data_for_location) { return; }
				map.locationMarkers[id] = L.featureGroup().addTo(map.l);
				if(!map_data_for_location['stops']) { return; }
				var stopContent = "";
				var stopContentFull = "";
				var count = 0;
				if(map_data_for_location['stops'].length > 1 && map_data_for_location['traveler_stop_info']){
					jQuery.each(map_data_for_location['traveler_stop_info'], function(k, traveler_stop_info) {
						stopContent = stopContent + '<div class="travelerMapItemSummary"><div class="travelerMapItemSummaryImg">' + traveler_stop_info['icon'] + '</div><div class="travelerMapItemSummaryText"><strong>' + traveler_stop_info['name'] + '</strong><br/>' + traveler_stop_info['dates'].join(', ') + '</div></div>';
					});
				}
				jQuery.each(map_data_for_location['stops'], function(k, stop) {
					count++;
					if (
						(start > 0) && (end > 0)
						&& (!(
						((start <= parseInt(stop['start']))
						&&
						(end >= parseInt(stop['start'])))
						||
						(
						(start <= parseInt(stop['end']))
						&&
						(end >= parseInt(stop['end'])))))
						
					) {
						return;
					}
					
					
					if (!map.startYear || (parseInt(stop['start']) < map.startYear)) {
						map.startYear = parseInt(stop['start']);
					}
					if (!map.endYear || (parseInt(stop['end']) > map.endYear)) {
						map.endYear = parseInt(stop['end']);
					}
					
					if(map_data_for_location['stops'].length == 1){
						stopContent = stop['text'];
					}else{
						//stopContent = stopContent + stop['short_text'];
						stopContentFull = stopContentFull + stop['text'];
					}
				});
				if(stopContent){
					var color = '#' + map_data_for_location['color'];
					var fillOpacity = 0.5;
					var radius = 7;
					if(map_data_for_location['stops'].length > 1){
						if(map_data_for_location['travelers'].length == 1){
							travelerTitle = map_data_for_location['travelers'].length + " Traveler";
						}else{
							travelerTitle = map_data_for_location['travelers'].length + " Travelers";
						}
						//stopContent = "<H3>" + map_data_for_location.name + " - " + map_data_for_location['stops'].length + " Events, " + travelerTitle + "</H3><div class='travelerMapMultipleItems' id='initialLoad" + count + "'>" + stopContent + "<br style='clear:both;'/><a href='#' onClick=\"jQuery('#initialLoad" + count + "').hide(); jQuery('#moreInfo" + count + "').show(); return false;\">See Location Timeline</a></div><div class='travelersMapMultipleItemsFull' id='moreInfo" + count + "'><div style='width:" + (360 * map_data_for_location['stops'].length) + "px;'>" + stopContentFull + "</div></div>";
						stopContent = "<H3>" + map_data_for_location.name + " - " + map_data_for_location['stops'].length + " Events, " + travelerTitle + "</H3><div class='travelerMapMultipleItems' id='initialLoad" + count + "'>" + stopContent + "<br style='clear:both;'/><a href='#' onClick=\"jQuery('#initialLoad" + count + "').hide(); jQuery('#moreInfo" + count + "').show(); return false;\">See Location Timeline</a></div><div class='travelersMapMultipleItemsFull' id='moreInfo" + count + "'><ul class='timeline timeline-horizontal'>" + stopContentFull + "</ul></div>";
						color = '#000000';
						radius = 10;
						fillOpacity = 0;
					}else{
						stopContent = "<H3>" + map_data_for_location.name + "</H3><ul class='timeline timeline-horizontal timeline-horizontalSingle'>" + stopContent + "</ul>";
					}
					stopContent = stopContent + "<br style='clear:both;'/>";
				
					var circle = L.circleMarker(map_data_for_location['coordinates'], {
						color: color, weight: 2, radius: radius,
						fillColor: color,
						fillOpacity: fillOpacity
					}).bindPopup(stopContent).addTo(map.locationMarkers[id]);
					if(map_data_for_location['stops'].length > 1){
						circle.bindTooltip(map_data_for_location['stops'].length + " events", {permanent: true});
					}
				}				
			});
			
			if (map.locationMarkers && (Object.keys(map.locationMarkers).length> 1)) {
				jQuery("#routeMapSliderContainer").show();
				var allMarkers = L.featureGroup();
				for(i in map.locationMarkers) {
					map.locationMarkers[i].addTo(allMarkers);
				}
				map.l.fitBounds(allMarkers.getBounds());
			} else {
				jQuery("#routeMapSliderContainer").hide();
			}
		};

		map.setMapSlider = function(map) {
			
			if (!map.startYear || !map.startYear) { return; }
			jQuery('#routeMapYearSliderStart').html(getDisplayDate(map.startYear));
			jQuery('#routeMapYearSliderEnd').html(getDisplayDate(map.endYear));
			
			jQuery('#routeMapYear').slider('option', 'min', map.startYear).slider('option', 'max', map.endYear);
			jQuery('#routeMapYear').slider('option', 'values', [map.startYear, map.endYear]);
		}
		

		// Load map data
		jQuery.getJSON('<?php print caNavUrl($this->request, '*', '*', 'GetMapData'); ?>', function(d) {
		
			if (d.length == 0) {
				d = {l: null, data: null, entityMarkers: {}, baseLayer: null, startYear: null, endYear: null};
			}
			map.data = d;
			map.l = L.map('routeMap').setView([51.505, -0.09], 2);
			map.baseLayer = L.tileLayer('http://{s}.tile.stamen.com/toner-lite/{z}/{x}/{y}.{ext}', {
				maxZoom: 18, 
				ext: 'png'
			}).addTo(map.l);

			map.generateMap(map);
			
			jQuery('#routeMap').data('_map_', map);
			
			jQuery("#routeMapYear").slider({min: map.startYear, max: map.endYear, values: [map.startYear, map.endYear]}).on('slide', function(event, v) {
				jQuery('#routeMapYearSliderStart').html(getDisplayDate(v.values[0]));
				jQuery('#routeMapYearSliderEnd').html(getDisplayDate(v.values[1]));
				// rebuild map
				//map.generateMap(map, v.value[0], v.value[1]);
			});
			jQuery("#routeMapYear").on( "slidestop", function( event, ui ) {
				map.generateMap(map, jQuery("#routeMapYear").slider( "values", 0 ), jQuery("#routeMapYear").slider( "values", 1 ));
			});
			
			map.setMapSlider(map);
		});
	});
	function getDisplayDate(numericDate){
		if(numericDate < 0){
			displayDate = numericDate * -1 + " BC";
		}else{
			displayDate = numericDate;
		}
		return displayDate;
	}
</script>