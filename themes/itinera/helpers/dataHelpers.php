<?php
	# ---------------------------------------
	/**
	 * Get list of entities associated with at least one tour stop
	 */
	function itineraGetTravelers($ps_letter=null) {
		$ps_letter = strtolower($ps_letter);
		if (!preg_match("!^[a-z]{1}$!", $ps_letter)) { $ps_letter = null; }
		
		$va_params = array();
		if ($ps_letter) { $va_params = array("{$ps_letter}%"); }
		
		$o_db = new Db();
		$qr_res = $o_db->query("
			SELECT DISTINCT ctsxe.entity_id 
			FROM ca_tour_stops_x_entities ctsxe
			INNER JOIN ca_entities AS e ON e.entity_id = ctsxe.entity_id
			INNER JOIN ca_entity_labels AS el ON e.entity_id = el.entity_id
			WHERE
				el.is_preferred = 1 AND e.deleted = 0 ".
				(($ps_letter ? " AND (el.surname LIKE ?)" : ''))."
		", $va_params);
		$va_entity_ids = $qr_res->getAllFieldValues('entity_id');
		return $qr_travelers = caMakeSearchResult('ca_entities', $va_entity_ids, array('sort' => 'ca_entity_labels.surname'));
	}
	# ---------------------------------------
	/**
	 * Get list of objects associated with at least one tour stop
	 */
	function itineraGetObjects($ps_letter=null) {
		$ps_letter = strtolower($ps_letter);
		if (!preg_match("!^[a-z]{1}$!", $ps_letter)) { $ps_letter = null; }
		
		$va_params = array();
		if ($ps_letter) { $va_params = array("{$ps_letter}%"); }
		
		$o_db = new Db();
		$qr_res = $o_db->query("
			SELECT DISTINCT ctsxo.object_id 
			FROM ca_tour_stops_x_objects ctsxo
			INNER JOIN ca_objects AS o ON o.object_id = ctsxo.object_id
			INNER JOIN ca_object_labels AS ol ON o.object_id = ol.object_id
			WHERE
				ol.is_preferred = 1 AND o.deleted = 0 ".
				(($ps_letter ? " AND (ol.name LIKE ?)" : ''))."
		", $va_params);
		$va_object_ids = $qr_res->getAllFieldValues('object_id');
		return caMakeSearchResult('ca_objects', $va_object_ids, array('sort' => 'ca_object_labels.name'));
	}
	# ---------------------------------------
	/**
	 * Get entity_id for random traveler
	 */
	function itineraGetRandomTravelerID() {
		$va_params = array();
		if ($ps_letter) { $va_params = array("{$ps_letter}%"); }
		
		$o_db = new Db();
		$qr_res = $o_db->query("
			SELECT DISTINCT ctsxe.entity_id 
			FROM ca_tour_stops_x_entities ctsxe
			INNER JOIN ca_entities AS e ON e.entity_id = ctsxe.entity_id
			INNER JOIN ca_entity_labels AS el ON e.entity_id = el.entity_id
			WHERE
				el.is_preferred = 1 AND e.deleted = 0 ".
				(($ps_letter ? " AND (el.surname LIKE ?)" : ''))."
		", $va_params);
		$va_entity_ids = $qr_res->getAllFieldValues('entity_id');
		return $va_entity_ids[rand(0, sizeof($va_entity_ids) - 1)];
	}
	# ---------------------------------------
	/**
	 * Get entity_id for random object
	 */
	function itineraGetRandomObjectID() {
		$va_params = array();
		if ($ps_letter) { $va_params = array("{$ps_letter}%"); }
		
		$o_db = new Db();
		$qr_res = $o_db->query("
			SELECT DISTINCT ctsxo.object_id 
			FROM ca_tour_stops_x_objects ctsxo
			INNER JOIN ca_objects AS o ON o.object_id = ctsxo.object_id
			INNER JOIN ca_object_labels AS ol ON o.object_id = ol.object_id
			WHERE
				ol.is_preferred = 1 AND o.deleted = 0 ".
				(($ps_letter ? " AND (ol.name LIKE ?)" : ''))."
		", $va_params);
		$va_object_ids = $qr_res->getAllFieldValues('object_id');
		return $va_object_ids[rand(0, sizeof($va_object_ids) - 1)];
	}
	# ---------------------------------------
	/**
	 * Get list of letters for entities and objects associated with at least one tour stop
	 */
	function itineraGetTravelersLetterBar() {
		$o_db = new Db();
		$qr_res = $o_db->query("
			SELECT DISTINCT substr(el.surname,1,1) l
			FROM ca_tour_stops_x_entities ctsxe
			INNER JOIN ca_entities AS e ON e.entity_id = ctsxe.entity_id
			INNER JOIN ca_entity_labels AS el ON e.entity_id = el.entity_id
			WHERE
				el.is_preferred = 1 AND e.deleted = 0");
				
		$va_letters = $qr_res->getAllFieldValues('l');
		
		$qr_res = $o_db->query("
			SELECT DISTINCT substr(ol.name,1,1) l
			FROM ca_tour_stops_x_objects ctsxo
			INNER JOIN ca_objects AS o ON o.object_id = ctsxo.object_id
			INNER JOIN ca_object_labels AS ol ON o.object_id = ol.object_id
			WHERE
				ol.is_preferred = 1 AND o.deleted = 0");
		while($qr_res->nextRow()) {
			if (!in_array($vs_l = $qr_res->get('l'), $va_letters)) {
				$va_letters[] = $vs_l;
			}
		}
		sort($va_letters);
		
		return $va_letters;
	}
	# ---------------------------------------
	/**
	 *
	 */
	function itineraGetUnusedColor($pa_used_colors, $ps_color=null) {
		while(!$ps_color || isset($pa_used_colors[$ps_color])) {
			$ps_color = str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT).str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT).str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
		}
		return $ps_color;
	}
	# ---------------------------------------
	/**
	 *
	 */
	function itineraGetRelationshipWeights($pn_entity_id, $pa_related_entity_ids, $pa_weights) {
		$o_db = new Db();
		$qr_res = $o_db->query("
			SELECT exe.entity_left_id, exe.entity_right_id, exe.type_id, rt.type_code
			FROM ca_entities_x_entities exe
			INNER JOIN ca_relationship_types AS rt ON rt.type_id = exe.type_id
			WHERE
				((exe.entity_left_id = ?) OR (exe.entity_right_id = ?))
				AND
				((exe.entity_left_id IN (?)) OR (exe.entity_right_id IN (?)))
		", array($pn_entity_id, $pn_entity_id, $pa_related_entity_ids, $pa_related_entity_ids));
		
		$va_weights = array();
		while($qr_res->nextRow()) {
			$va_row = $qr_res->getRow();
			if (!($vn_weight = (int)$pa_weights[$va_row['type_code']])) { $vn_weight = 1; }
			if ($va_row['entity_left_id'] == $pn_entity_id) {
				$va_weights[$va_row['entity_right_id']] += $vn_weight;
			} else {
				$va_weights[$va_row['entity_left_id']] += $vn_weight;
			}
		}
		return $va_weights;
	}
	# ---------------------------------------
?>