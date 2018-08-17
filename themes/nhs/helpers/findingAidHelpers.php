<?php
	function caNewportGetCollectionLevelSummary($po_request, $va_collection_ids, $vn_level) {
		$va_access_values = caGetUserAccessValues($po_request);
		# --- get collections configuration
		$o_collections_config = caGetCollectionsConfig();
		if($o_collections_config->get("export_max_levels") && ($vn_level > $o_collections_config->get("export_max_levels"))){
			return;
		}
		$t_list = new ca_lists();
		$va_exclude_collection_type_ids = array();
		if($va_exclude_collection_type_idnos = $o_collections_config->get("export_exclude_collection_types")){
			# --- convert to type_ids
			$va_exclude_collection_type_ids = $t_list->getItemIDsFromList("collection_types", $va_exclude_collection_type_idnos, array("dontIncludeSubItems" => true));
		}
		$t_list = new ca_lists();
		$vs_series_type_id = $t_list->getItemIDFromList("collection_types", "series");
		$vs_file_type_id = $t_list->getItemIDFromList("collection_types", "file");
		$vs_collection_type_id = $t_list->getItemIDFromList("collection_types", "collection");
		
		$vs_output = "";
		$qr_collections = caMakeSearchResult("ca_collections", $va_collection_ids);
		
		if($qr_collections->numHits()){
			while($qr_collections->nextHit()) {
				if($va_exclude_collection_type_ids && is_array($va_exclude_collection_type_ids) && (in_array($qr_collections->get("ca_collections.type_id"), $va_exclude_collection_type_ids))){
					continue;
				}
				$va_child_ids = $qr_collections->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => "ca_collections.idno_sort"));
				if($qr_collections->get("type_id") != $vs_collection_type_id){
					# --- only show parts of identifier based on record type
					$vs_idno = "";
					if($qr_collections->get("type_id") == $vs_series_type_id){
						$vs_idno = mb_substr($qr_collections->get("idno"), -2, 2);
					}
					$vb_file = false;
					if($qr_collections->get("type_id") == $vs_file_type_id){
						$vs_idno = mb_substr($qr_collections->get("idno"), -6, 6);
						$vb_file = true;
					}
					if(!$vs_idno){
						$vs_idno = $qr_collections->get("idno");
					}
		
					$vs_output .= "<div style='margin-left:".(40*($vn_level - 1))."px;'>";
					$vs_output .= "<div class='inventoryLabel'>";
					if($vb_file){
						$vs_output .= "<i>";
					}
					$vs_output .= ucfirst($qr_collections->get("ca_collections.type_id", array("convertCodesToDisplayText" => true)))." ".$vs_idno.": ".$qr_collections->get("ca_collections.preferred_labels");
					$vs_date = $qr_collections->get("ca_collections.collection_date2.collection_date_inclusive");
					if($qr_collections->get("ca_collections.collection_date2.collection_date_bulk")){
						$vs_date .= " (bulk ".$qr_collections->get("ca_collections.collection_date2.collection_date_bulk").")";
					}
					if($vs_date){
						$vs_output .= ", ".trim($vs_date);
					}
					if($vb_file){
						$vs_output .= "</i>";
					}
					$vs_output .= "</div>";
					
					$vs_inventory_content = "";
					if(($vs_scope = $qr_collections->get("scope_content")) | ($vs_arrangement = $qr_collections->get("arrangement"))){
						$vs_inventory_content .= $vs_scope;
						if($qr_collections->get("type_id") != $vs_file_type_id){
							if($vs_scope && $vs_arrangement){
								$vs_inventory_content .= "<br/><br/>";
							}
						}
						$vs_inventory_content .= $vs_arrangement;
					}
					if($vs_inventory_content){
						$vs_output .= "<div class='inventoryContent'>".$vs_inventory_content."</div>";
					}
					$vs_output .= "</div>";
				}
				if(sizeof($va_child_ids)) {
					$vs_output .=  caNewportGetCollectionLevelSummary($po_request, $va_child_ids, $vn_level + 1);
				}
			}
		}
		return $vs_output;
	}
?>