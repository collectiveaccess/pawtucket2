<?php
	$va_added_entity_ids = $this->getVar('added_entity_ids');
	$va_removed_entity_ids = $this->getVar('removed_entity_ids');
?>
	<script type="text/javascript">
		var map = jQuery('#routeMap').data('_map_');
		
		if (map) {
<?php
	if(is_array($va_added_entity_ids) && sizeof($va_added_entity_ids)) {
?>
		// get data for entity
		jQuery.getJSON('<?php print caNavUrl($this->request, '*', '*', 'GetMapData', array('ids' => join(';', $va_added_entity_ids))); ?>', function(d) {
			// add to map.data
			for(var i in d) {
				map.data[i] = d[i];
			}
			jQuery('#routeMap').data('_map_', map);
			map.generateMap(map);
			map.setMapSlider(map);
		});
<?php
	}

	if(is_array($va_removed_entity_ids) && sizeof($va_removed_entity_ids)) {
		foreach($va_removed_entity_ids as $vn_removed_entity_id) {
?>
			var entity_to_remove = map.entityMarkers[<?php print $vn_removed_entity_id; ?>];
			if (entity_to_remove) { 
				map.l.removeLayer(entity_to_remove);
				map.data[<?php print $vn_removed_entity_id; ?>] = null;
			}
<?php
		}
	}
?>
		jQuery('#routeMap').data('_map_', map);	
		map.generateMap(map);
		map.setMapSlider(map);
	}
	</script>
<?php

	$va_entity_list = $this->getVar('entity_list');
	
	if (is_array($va_entity_list) && sizeof($va_entity_list)) {
		$qr_res = caMakeSearchResult('ca_entities', array_values($va_entity_list));
		
		$va_used_colors = array_flip($va_entity_list);
		while($qr_res->nextHit()) {
			$vn_entity_id = $qr_res->get('ca_entities.entity_id');
			if (!($vs_image_tag = $qr_res->get('ca_entities.agentMedia', array('version' => 'icon')))) {
				$vs_image_tag = "<div class='travelerMapListImagePlaceholder'>&nbsp;</div>";
			}
			
			print "<div class='travelerMapList clearfix'>";
			print "<div class='travelerMapListRemove' data-entity_id='{$vn_entity_id}'>&#10006;</div>";
			print "<div class='travelerMapListColorKey' style='background-color: #".$va_used_colors[$vn_entity_id].";'>&nbsp;</div>";
			print "<div class='travelerMapListImage'>".caNavLink($this->request, $vs_image_tag, '', '', 'Travelers', 'Index', array('id' => $vn_entity_id))."</div>";
		
			print "<div class='travelerMapListArtistName'>".caNavLink($this->request, $qr_res->get('ca_entities.preferred_labels'), '', '', 'Travelers', 'Index', array('id' => $vn_entity_id))."</div>";
			
			$va_entity_roles = $qr_res->get('ca_entities.agentLifeRoleSet.agentLifeRoleType', array('useSingular' => true, 'convertCodesToDisplayText' => true, 'returnAsArray' => 'true'));

			print "<div class='travelerMapListArtistRoles'>".join(", " , $va_entity_roles)."</div>";

			if(is_array($va_dates_array = $qr_res->get('ca_entities.agentLifeDateSet', array('returnAsArray' => true)))) {
				$va_date_set = array();
				foreach ($va_dates_array as $va_dates) {
					$va_date_set[] = $va_dates['agentLifeDisplayDate'];
				}
				print "<div class='travelerMapListArtistDates'>".join($va_date_set, ' - ')."</div>";
			}
										
			
			print "</div>";
		}
?>
	<script type="text/javascript">
		jQuery(".travelerMapListRemove").bind("click", function() {
			jQuery('#travelerContent').load('<?php print caNavUrl($this->request, '*', '*', 'Get', array('m' => 'remove')); ?>/id/' + jQuery(this).data('entity_id'));
		});
	</script>
<?php
	} else {
?>
		<h2>To start select a traveler from the index</h2>
<?php
	}
?>