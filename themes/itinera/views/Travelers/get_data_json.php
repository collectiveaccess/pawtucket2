<?php
	$pn_levels = $this->getVar('levels');
	$pn_entity_id = $this->getVar('entity_id');
	$t_entity = $this->getVar('t_entity');
	
	$va_weight_chart = [
		'familial' => 3, 'child' => 15, 'sibling' => 10, 'spouse' => 15,
		'professional' => 3, 'VOC14011001_al' => 10, 'VOC13111501_al' => 10, 'employee' => 8, 'fellow' => 8, 'member' => 10, 'VOC13110601_al' => 15, 'sat' => 6, 'student' => 8, 'VOC14010503_al' => 8, 'VOC14010501_al' => 10,
		'social' => 3, 'acquaintance' => 3, 'guest' => 5, 'patron' => 15, 'travel_companion' => 15
	];
	
	$va_data = ['id' => $pn_entity_id, 'name' => $t_entity->get('ca_entities.preferred_labels.displayname'), 'children' => $va_children = [], 'size' => 1000];
	
	
	if (is_array($va_related_ids = $t_entity->get('ca_entities.related.entity_id', ['returnAsArray' => true])) && sizeof($va_related_ids)) {
		$qr_res = caMakeSearchResult('ca_entities', $va_related_ids);
	}
	
	$va_rel_weights = (sizeof($va_related_ids) > 0) ? itineraGetRelationshipWeights($pn_entity_id, $va_related_ids, $va_weight_chart) : array();
	
	$va_seen_list = [$pn_entity_id => 1];
	_getChildren($qr_res, $va_children, 0, $pn_levels, $va_seen_list, $va_rel_weights, $va_weight_chart);
	$va_data['children'] = $va_children;
	print json_encode($va_data);
	
	
	function _getChildren($pr_res, &$pa_data, $pn_level, $pn_max_levels, &$pa_seen_list, $pa_weights, $pa_weight_chart) {
		if($pn_level > $pn_max_levels) { return false; }
		while($pr_res->nextHit()) {
			$vn_entity_id = $pr_res->get('ca_entities.entity_id');
			if ($pa_seen_list[$vn_entity_id]) { continue; }
			$va_entity = [
				'id' => $vn_entity_id,
				'name' => $pr_res->get('ca_entities.preferred_labels.displayname'),
				'weight' => $pa_weights[$vn_entity_id],
				'children' => $va_children = []
			];
			
			$pa_seen_list[$vn_entity_id] = 1;
			
			if ($va_rel_ids = $pr_res->get('ca_entities.related.entity_id', ['returnAsArray' => true])) {
				$va_rel_weights = (sizeof($va_rel_ids) > 0) ? itineraGetRelationshipWeights($vn_entity_id, $va_rel_ids, $pa_weight_chart) : array();
				$qr_children = caMakeSearchResult('ca_entities', $va_rel_ids);
				_getChildren($qr_children, $va_children, $pn_level + 1, $pn_max_levels, $pa_seen_list, $va_rel_weights, $pa_weight_chart);
			}
			$va_entity['children'] = $va_children;
			$pa_data[] = $va_entity;
		}
		
		return true;
	}
?>