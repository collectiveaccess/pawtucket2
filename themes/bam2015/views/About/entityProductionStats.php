<?php
	$o_db = new Db();
	$q_entities = $o_db->query("SELECT entity_id from ca_entities where access = 1 AND deleted = 0");
	if($q_entities->numRows()){
		$t_entity = new ca_entities();
		$va_production_counts = array();
		print "<b>".$q_entities->numRows()."</b><br/>";
		while($q_entities->nextRow()){
			$t_entity->load($q_entities->get("entity_id"));
			#print $t_entity->get("ca_entities.preferred_labels")."<br/>";
			$va_productions = $t_entity->get("ca_occurrences", array("returnWithStructure" => true, "checkAccess" => caGetUserAccessValues($this->request), 'restrictToTypes' => array('production', 'special_event')));
			$va_productions_dedupped = array();
			foreach($va_productions as $va_production){
				$va_productions_dedupped[$va_production["occurrence_id"]] = $va_production["name"];
			}
			$va_production_counts[sizeof($va_productions_dedupped)][] = $t_entity->get("ca_entities.preferred_labels"); 
		}
		ksort($va_production_counts);
		foreach($va_production_counts as $vn_num_productions => $va_entities){
			print sizeof($va_entities)." entities with <b>".$vn_num_productions." productions/special events</b><br/>";
			if($vn_num_productions > 100){
				print "&nbsp;&nbsp;&nbsp;-&nbsp;".join(", ", $va_entities)."<br/>";
			}
		}
	}
?>