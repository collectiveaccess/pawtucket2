<?php
	$t_item = 			$this->getVar("item");
	$va_access_values = 	$this->getVar("access_values");
	$va_restrict_to_relationship_types = 	$this->getVar("restrict_to_relationship_types");
	
	$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => $va_restrict_to_relationship_types));
	# --- note this needs to be placed within <dl></dl> tags
	if(is_array($va_entities) && sizeof($va_entities)){
		$va_entities_by_type = array();
		foreach($va_entities as $va_entity_info){
			$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caDetailLink($this->request, $va_entity_info["displayname"], "", "ca_entities", $va_entity_info["entity_id"]);
		}
		foreach($va_entities_by_type as $vs_type => $va_entity_links){
			print "<dt class='text-capitalize'>".$vs_type."</dt><dd>".join(", ", $va_entity_links)."</dd>";
		}
	}
?>					
