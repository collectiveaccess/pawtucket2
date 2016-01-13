<?php
	# ---------------------------------------
	/**
	 * Get list of entities associated with at least one tour stop
	 */
	function nysocGetReaders($ps_letter=null) {
		$ps_letter = strtolower($ps_letter);
		if (!preg_match("!^[a-z]{1}$!", $ps_letter)) { $ps_letter = null; }
		
		$va_params = array();
		if ($ps_letter) { $va_params = array("{$ps_letter}%"); }
		
		$o_db = new Db();
		$qr_res = $o_db->query("
			SELECT DISTINCT ctsxe.entity_id 
			FROM ca_objects_x_entities ctsxe
			INNER JOIN ca_entities AS e ON e.entity_id = ctsxe.entity_id
			INNER JOIN ca_entity_labels AS el ON e.entity_id = el.entity_id
			INNER JOIN ca_relationship_types AS rt ON rt.type_id = ctsxe.type_id
			WHERE
				rt.type_code = 'reader' AND el.is_preferred = 1 AND e.deleted = 0 ".
				(($ps_letter ? " AND (el.surname LIKE ?)" : ''))."
			ORDER BY el.surname, el.forename
		", $va_params);
		$va_entity_ids = $qr_res->getAllFieldValues('entity_id');
		return $qr_readers = caMakeSearchResult('ca_entities', $va_entity_ids, array('sort' => 'ca_entity_labels.surname'));
	}
	# ---------------------------------------
	/**
	 * Get list of objects associated with at least one tour stop
	 */
	function nysocGetBooks($ps_letter=null) {
		$ps_letter = strtolower($ps_letter);
		if (!preg_match("!^[a-z]{1}$!", $ps_letter)) { $ps_letter = null; }
		
		$va_params = array();
		if ($ps_letter) { $va_params = array("{$ps_letter}%"); }
		
		//$va_params[] = caGetListItemID('object_types', 'volume');
		
		$o_db = new Db();
		$qr_res = $o_db->query("
			SELECT DISTINCT ctsxo.object_id 
			FROM ca_objects_x_entities ctsxo
			INNER JOIN ca_objects AS o ON o.object_id = ctsxo.object_id
			INNER JOIN ca_object_labels AS ol ON o.object_id = ol.object_id
			INNER JOIN ca_relationship_types AS rt ON rt.type_id = ctsxo.type_id
			WHERE
				ol.is_preferred = 1 AND o.deleted = 0 AND rt.type_code = 'reader' ".
				(($ps_letter ? " AND (ol.name_sort LIKE ?)" : ''))."
			ORDER BY ol.name_sort
		", $va_params);
		$va_object_ids = $qr_res->getAllFieldValues('object_id');

		return caMakeSearchResult('ca_objects', $va_object_ids, array('sort' => 'ca_object_labels.name'));
	}
	# ---------------------------------------
	/**
	 * Get list of letters for entities associated with at least one book as reader
	 */
	function nysocGetReadersLetterBar() {
		$o_db = new Db();
		$qr_res = $o_db->query("
			SELECT DISTINCT substr(el.surname,1,1) l
			FROM ca_objects_x_entities ctsxe
			INNER JOIN ca_entities AS e ON e.entity_id = ctsxe.entity_id
			INNER JOIN ca_entity_labels AS el ON e.entity_id = el.entity_id
			INNER JOIN ca_relationship_types AS rt ON rt.type_id = ctsxe.type_id
			WHERE
				el.is_preferred = 1 AND e.deleted = 0 AND rt.type_code = 'reader'");
				
		$va_letters = $qr_res->getAllFieldValues('l');
		
		sort($va_letters);
		
		return $va_letters;
	}
	# ---------------------------------------
	/**
	 * Get list of letters for eobjects associated with at least one entity as reader
	 */
	function nysocGetBooksLetterBar() {
		$o_db = new Db();
		$qr_res = $o_db->query("
			SELECT DISTINCT substr(ol.name,1,1) l
			FROM ca_objects_x_entities ctsxe
			INNER JOIN ca_objects AS o ON o.object_id = ctsxe.object_id
			INNER JOIN ca_object_labels AS ol ON o.object_id = ol.object_id
			INNER JOIN ca_relationship_types AS rt ON rt.type_id = ctsxe.type_id
			WHERE
				ol.is_preferred = 1 AND o.deleted = 0 AND rt.type_code = 'reader'");
				
		$va_letters = $qr_res->getAllFieldValues('l');
		
		sort($va_letters);
		
		return $va_letters;
	}
	# ---------------------------------------
?>