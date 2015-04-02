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
	<div class="row">
		<div class="col-sm-1">
			<span id="routeMapYearSliderStart"></span> 
		</div>
		<div class="col-sm-10">
			<input id="routeMapYear" data-slider-id="routeMapYearSlider" type="text" value="" data-slider-min="1700" data-slider-max="1900" data-slider-step="1" data-slider-value="[1740,1850]"/>
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
		var map = {l: null, data: null, entityMarkers: {}, baseLayer: null, startYear: null, endYear: null};
		map.generateMap = function(map, start, end) {
			map.l.eachLayer(function (layer) {
				if (layer != map.baseLayer) { map.l.removeLayer(layer); }
			});
			map.startYear = map.endYear = null;
			jQuery.each(map.data, function(entity_id, map_data_for_entity) {
				if(!map_data_for_entity) { return; }
				map.entityMarkers[entity_id] = L.featureGroup().addTo(map.l);
				if(!map_data_for_entity['stops']) { return; }
				jQuery.each(map_data_for_entity['stops'], function(k, stop) {
				
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
					
					var circle = L.circleMarker(stop['coordinates'], {
						color: '#' + map_data_for_entity['color'], weight: 2, radius: 7,
						fillColor: '#' + map_data_for_entity['color'],
						fillOpacity: 0.5
					}).bindPopup(stop['text']).addTo(map.entityMarkers[entity_id]);
					
					if (!map.startYear || (parseInt(stop['start']) < map.startYear)) {
						map.startYear = parseInt(stop['start']);
					}
					if (!map.endYear || (parseInt(stop['end']) > map.endYear)) {
						map.endYear = parseInt(stop['end']);
					}
				});
			});
			
			if (map.entityMarkers && (Object.keys(map.entityMarkers).length> 0)) {
				var allMarkers = L.featureGroup();
				for(i in map.entityMarkers) {
					map.entityMarkers[i].addTo(allMarkers);
				}
				map.l.fitBounds(allMarkers.getBounds());
			}
		};
		map.setMapSlider = function(map) {
			
			jQuery('#routeMapYearSliderStart').html(map.startYear);
			jQuery('#routeMapYearSliderEnd').html(map.endYear);
			
			jQuery('#routeMapYear').slider('setAttribute', 'min', map.startYear).slider('setAttribute', 'max', map.endYear);
			jQuery('#routeMapYear').slider('setValue', [map.startYear, map.endYear]);
		}
		

		// Load map data
		jQuery.getJSON('<?php print caNavUrl($this->request, '*', '*', 'GetMapData'); ?>', function(d) {
			map.data = d;
			map.l = L.map('routeMap').setView([51.505, -0.09], 13);
			map.baseLayer = L.tileLayer('http://{s}.tile.stamen.com/toner-lite/{z}/{x}/{y}.{ext}', {
				maxZoom: 18, 
				ext: 'png'
			}).addTo(map.l);

			map.generateMap(map);
			
			jQuery('#routeMap').data('_map_', map);
			
			 jQuery("#routeMapYear").slider({min: map.startYear, max: map.endYear}).on('slide', function(v) {
				jQuery('#routeMapYearSliderStart').html(v.value[0]);
				jQuery('#routeMapYearSliderEnd').html(v.value[1]);
				// rebuild map
				map.generateMap(map, v.value[0], v.value[1]);
			});
			
			map.setMapSlider(map);
		});
	});
</script>