<?php
	# ---------------------------------------
	/**
	 * Used to display full collection hierarchy as list on detail pages
	 * recursive loop to display all collection children
	 * 
	 */	
	function caGetCollectionHierarchyList($po_request, $va_collection_ids, $vn_level) {
		$va_access_values = caGetUserAccessValues($po_request);
		# --- get collections configuration
		$o_collections_config = caGetCollectionsConfig();
		if($o_collections_config->get("export_max_levels") && ($vn_level > $o_collections_config->get("export_max_levels"))){
			return null;
		}
		$t_list = new ca_lists();
		$va_exclude_collection_type_ids = array();
		if($va_exclude_collection_type_idnos = $o_collections_config->get("export_exclude_collection_types")){
			# --- convert to type_ids
			$va_exclude_collection_type_ids = $t_list->getItemIDsFromList("collection_types", $va_exclude_collection_type_idnos, array("dontIncludeSubItems" => true));
		}
		$vs_output = "";
		$qr_collections = caMakeSearchResult("ca_collections", $va_collection_ids);
		
		$vs_sub_collection_label_template = $o_collections_config->get("sub_collection_label_template_list");
		$vs_sub_collection_desc_template = $o_collections_config->get("sub_collection_description_template_list");
		$vs_sub_collection_sort = $o_collections_config->get("sub_collection_sort_list");
		if(!$vs_sub_collection_sort){
			$vs_sub_collection_sort = "ca_collections.idno_sort";
		}
		$vb_dont_show_top_level_description = false;
		if($o_collections_config->get("dont_show_top_level_description") && ($vn_level == 1)){
			$vb_dont_show_top_level_description = true;
		}
		$va_collection_type_icons = array();
		$va_collection_type_icons_by_idnos = $o_collections_config->get("export_collection_type_icons");
		if(is_array($va_collection_type_icons_by_idnos) && sizeof($va_collection_type_icons_by_idnos)){
			foreach($va_collection_type_icons_by_idnos as $vs_idno => $vs_icon){
				$va_collection_type_icons[$t_list->getItemId("collection_types", $vs_idno)] = $vs_icon;
			}
		}
		if($qr_collections->numHits()){
			while($qr_collections->nextHit()) {
				if($va_exclude_collection_type_ids && is_array($va_exclude_collection_type_ids) && (in_array($qr_collections->get("ca_collections.type_id"), $va_exclude_collection_type_ids))){
					continue;
				}
		
				$vs_icon = "";
				if(is_array($va_collection_type_icons) && $va_collection_type_icons[$qr_collections->get("ca_collections.type_id")]){
					$vs_icon = $va_collection_type_icons[$qr_collections->get("ca_collections.type_id")];
				}			
				# --- related items?
				$va_item_ids = $qr_collections->get("ca_collections.children.collection_id", array("restrictToTypes" => array("item"), "returnAsArray" => true, 'checkAccess' => $va_access_values));
				$vn_rel_item_count = sizeof($va_item_ids);
				$va_child_ids = $qr_collections->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => $vs_sub_collection_sort));
				$vs_output .= "<div class='unit' style='margin-left:".(30*($vn_level - 1))."px;'>";
				if($vs_icon){
					$vs_output .= $vs_icon." ";
				}
				$vs_output .= "<b class='hierLevel".$vn_level."'>";
				if($vs_sub_collection_label_template){
					$vs_output .= $qr_collections->getWithTemplate($vs_sub_collection_label_template);
				}else{
					$vs_output .= $qr_collections->get("ca_collections.preferred_labels");
				}
				$vs_output .= "</b>";
			
				#if($vn_rel_item_count){
				#	$vs_output .= " <span class='small'>(".$vn_rel_item_count." item".(($vn_rel_item_count == 1) ? "" : "s").")</span>";
				#}
				$vs_output .= "<br/>";
				if(!$vb_dont_show_top_level_description){
					$vs_desc = "";
					if($vs_sub_collection_desc_template && ($vs_desc = $qr_collections->getWithTemplate($vs_sub_collection_desc_template))){
						$vs_output .= "<p>".$vs_desc."</p>";
					}
				}
				$vs_output .= "</div>";
				if(sizeof($va_child_ids)) {
					$vs_output .=  caGetCollectionHierarchyList($po_request, $va_child_ids, $vn_level + 1);
				}
			}
		}
		return $vs_output;
	}
?>