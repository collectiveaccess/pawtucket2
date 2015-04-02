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
	 * Get list of entities associated with at least one tour stop
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
				
		return $qr_res->getAllFieldValues('l');
	}
	# ---------------------------------------
?>