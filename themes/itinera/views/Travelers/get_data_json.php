<?php
	$pn_levels = $this->getVar('levels');
	$pn_entity_id = $this->getVar('entity_id');
	$t_entity = $this->getVar('t_entity');
	
	
	$va_data = ['id' => $pn_entity_id, 'name' => $t_entity->get('ca_entities.preferred_labels.displayname'), 'children' => $va_children = [], 'size' => 1000];
	
	if (is_array($va_related_ids = $t_entity->get('ca_entities.related.entity_id', ['returnAsArray' => true])) && sizeof($va_related_ids)) {
		$qr_res = caMakeSearchResult('ca_entities', $va_related_ids);
	}
	
	$va_seen_list = [$pn_entity_id => 1];
	_getChildren($qr_res, $va_children, 0, $pn_levels, $va_seen_list);
	$va_data['children'] = $va_children;
	print json_encode($va_data);
	
	
	function _getChildren($pr_res, &$pa_data, $pn_level, $pn_max_levels, &$pa_seen_list) {
		if($pn_level > $pn_max_levels) { return false; }
		while($pr_res->nextHit()) {
			$vn_entity_id = $pr_res->get('ca_entities.entity_id');
			if ($pa_seen_list[$vn_entity_id]) { continue; }
			$va_entity = [
				'id' => $vn_entity_id,
				'name' => $pr_res->get('ca_entities.preferred_labels.displayname'),
				'children' => $va_children = []
			];
			
			$pa_seen_list[$vn_entity_id] = 1;
			
			if ($va_rel_ids = $pr_res->get('ca_entities.related.entity_id', ['returnAsArray' => true])) {
				$qr_children = caMakeSearchResult('ca_entities', $va_rel_ids);
				_getChildren($qr_children, $va_children, $pn_level + 1, $pn_max_levels, $pa_seen_list);
			}
			$va_entity['children'] = $va_children;
			$pa_data[] = $va_entity;
		}
		
		return true;
	}
?>