<?php

# ----- archival collection summary export
function printLevelArchivalCollectionExport($po_request, $va_collection_ids, $o_config, $vn_level) {
	$va_access_values = caGetUserAccessValues($po_request);
	$vs_output = "";
	$vs_desc_template = $o_config->get("description_template_archival_export");
	$vs_desc_template_file = $o_config->get("description_template_archival_file_export");
	
	$qr_collections = caMakeSearchResult("ca_collections", $va_collection_ids);
	
	if($qr_collections->numHits()){
		while($qr_collections->nextHit()) {			
			# --- related objects?
			$vn_rel_object_count = sizeof($qr_collections->get("ca_objects.object_id", array('excludeTypes' => array('archival_file'), "restrictToRelationshipTypes" => array('archival_part'), "returnAsArray" => true, 'checkAccess' => $va_access_values)));
			$va_child_ids = $qr_collections->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => "ca_collections.idno_sort"));
			$va_child_file_ids = $qr_collections->get('ca_objects.object_id', array('restrictToTypes' => array('archival_file'), "restrictToRelationshipTypes" => array('archival_part'), 'returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_objects.idno_sort'));
			$vs_output .= "<div class='unit' style='margin-left:".(20*($vn_level - 1))."px;'>";
			
			if($vn_level == 1){
				$vs_output .= "<div class='title' style='text-align:left;'>";
			}else{
				$vs_output .= "<div><b>";
			}
			$vs_output .= $qr_collections->get('ca_collections.preferred_labels');
				
			if($vn_rel_object_count){
				$vs_output .= " <small>(".$vn_rel_object_count." record".(($vn_rel_object_count == 1) ? "" : "s").")</small>";
			}
			if($vn_level == 1){
				$vs_output .= "</div>";
			}else{
				$vs_output .= "</b></div>";
			}
			$vs_desc = "";
			if($vs_desc_template && ($vs_desc = $qr_collections->getWithTemplate($vs_desc_template))){
				$vs_output .= "<p>".$vs_desc."</p>";
			}
			$vs_output .= "</div>";
			
			
			
			if(sizeof($va_child_ids) || sizeof($va_child_file_ids)) {
				$vs_output .=  printLevelArchivalCollectionExport($po_request, $va_child_ids, $o_config, $vn_level + 1, $va_options);
				if(sizeof($va_child_file_ids)){
					
						$qr_collection_children_file = caMakeSearchResult("ca_objects", $va_child_file_ids);
						if($qr_collection_children_file->numHits()){
							while($qr_collection_children_file->nextHit()){
								$vs_output .= "<div class='unit' style='margin-left:".(20*($vn_level))."px;'><div><b>";
								$vn_rel_object_count_file = sizeof($qr_collection_children_file->get("ca_objects.related.object_id", array('excludeTypes' => array('archival_file'), 'restrictToRelationshipTypes' => array('archival_part'), 'returnAsArray' => true, 'checkAccess' => $va_access_values)));
								$vs_output .= $qr_collection_children_file->get("ca_objects.preferred_labels.name");
								if($vn_rel_object_count_file){
									$vs_output .= " <small>(".$vn_rel_object_count_file." record".(($vn_rel_object_count_file == 1) ? "" : "s").")</small>";
								}
								$vs_output .= "</b></div>";
								$vs_desc = "";
								if($vs_desc_template_file && ($vs_desc = $qr_collection_children_file->getWithTemplate($vs_desc_template_file))){
									$vs_output .= "<p>".$vs_desc."</p>";
								}

								$vs_output .= "</div>";						
							}
						}
				}
			}

			
			
		}
	}
	return $vs_output;
}
?>