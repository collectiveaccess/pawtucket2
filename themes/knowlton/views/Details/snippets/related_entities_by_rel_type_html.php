<?php
	$t_object = 			$this->getVar("item");
	$va_access_values = 	$this->getVar("access_values");
	$va_restrict_to_relationship_types = 	$this->getVar("restrict_to_relationship_types");
	
	$va_entities = $t_object->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => $va_restrict_to_relationship_types));
	if(is_array($va_entities) && sizeof($va_entities)){
		$va_entities_by_type = array();
		foreach($va_entities as $va_entity_info){
			$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caNavLink($this->request, $va_entity_info["displayname"], "btn btn-secondary btn-sm me-4 fw-semibold mb-1", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $va_entity_info["entity_id"]));
		}
		foreach($va_entities_by_type as $vs_type => $va_entity_links){
			print "<dt class='text-capitalize serif fw-medium pb-1'>".$vs_type."</dt><dd class='pb-4 fs-5 fw-semibold'>".join(" ", $va_entity_links)."</dd>";
		}

	}
?>					