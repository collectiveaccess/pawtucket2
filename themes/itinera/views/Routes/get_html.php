<?php
	$va_entity_list = $this->getVar('entity_list');
	$va_added_entity_ids = $this->getVar('added_entity_ids');
	$va_removed_entity_ids = $this->getVar('removed_entity_ids');
	
	$va_object_list = $this->getVar('object_list');
	$va_added_object_ids = $this->getVar('added_object_ids');
	$va_removed_object_ids = $this->getVar('removed_object_ids');
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
			var entity_to_remove = map.entityMarkers['entity_<?php print $vn_removed_entity_id; ?>'];
			if (entity_to_remove) { 
				map.l.removeLayer(entity_to_remove);
				map.data['entity_<?php print $vn_removed_entity_id; ?>'] = null;
			}
<?php
		}
	}
	
	
	if(is_array($va_added_object_ids) && sizeof($va_added_object_ids)) {
?>
		// get data for object
		jQuery.getJSON('<?php print caNavUrl($this->request, '*', '*', 'GetMapData', array('object_ids' => join(';', $va_added_object_ids))); ?>', function(d) {
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

	if(is_array($va_removed_object_ids) && sizeof($va_removed_object_ids)) {
		foreach($va_removed_object_ids as $vn_removed_object_id) {
?>
			var object_to_remove = map.entityMarkers['object_<?php print $vn_removed_object_id; ?>'];
			if (object_to_remove) { 
				map.l.removeLayer(object_to_remove);
				map.data['object_<?php print $vn_removed_object_id; ?>'] = null;
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

	
	if (true) {
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

				if(is_array($va_dates_array = $qr_res->get('ca_entities.agentLifeDateSet', array('returnWithStructure' => true, 'returnAsArray' => true)))) {
					$va_date_set = array();
					foreach (array_shift($va_dates_array) as $va_dates) {
						$va_date_set[] = $va_dates['agentLifeDisplayDate'];
					}
					print "<div class='travelerMapListArtistDates'>".join($va_date_set, ' - ')."</div>";
				}
										
			
				print "</div>";
			}
		}
		if (is_array($va_object_list) && sizeof($va_object_list)) {
			$qr_res = caMakeSearchResult('ca_objects', array_values($va_object_list));
		
			$va_used_colors = array_flip($va_object_list);
			while($qr_res->nextHit()) {
				$vn_object_id = $qr_res->get('ca_objects.object_id');
				if (!($vs_image_tag = $qr_res->get('ca_object_representations.media.icon'))) {
					$vs_image_tag = "<div class='travelerMapListImagePlaceholder'>&nbsp;</div>";
				}
			
				print "<div class='travelerMapList clearfix'>";
				print "<div class='travelerMapListRemove' data-object_id='{$vn_object_id}'>&#10006;</div>";
				print "<div class='travelerMapListColorKey' style='background-color: #".$va_used_colors[$vn_object_id].";'>&nbsp;</div>";
				print "<div class='travelerMapListImage'>".caNavLink($this->request, $vs_image_tag, '', '', 'Detail', 'object', array('id' => $vn_object_id))."</div>";
		
				print "<div class='travelerMapListArtistName'>".caNavLink($this->request, $qr_res->get('ca_objects.preferred_labels'), '', '', 'Detail', 'object', array('id' => $vn_object_id))."</div>";									
			
				print "</div>";
			}
		}
?>
		<script type="text/javascript">
			jQuery(".travelerMapListRemove").bind("click", function() {
				var id = jQuery(this).data('entity_id');
				var idname; 
				if (id) {
					idname = 'id';
				} else {
					if (id = jQuery(this).data('object_id')) { 
						idname = 'object_id';
					}
				}
				jQuery('#travelerContent').load('<?php print caNavUrl($this->request, '*', '*', 'Get', array('m' => 'remove')); ?>/' + idname + '/' + id);
			});
		</script>
<?php
	} else {
?>
		<h2>To start select a traveler from the index</h2>
<?php
	}
?>