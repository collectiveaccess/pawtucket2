<?php
function printOverviewLevel($po_request, $va_collection_ids, $o_config, $vn_level, $va_options = array()) {
	if($o_config->get("max_levels") && ($vn_level > $o_config->get("max_levels"))){
		return;
	}
	$va_access_values = caGetUserAccessValues($po_request);
	$vs_output = "";
	$vs_desc_template = $o_config->get("description_template");
	$qr_collections = caMakeSearchResult("ca_collections", $va_collection_ids);
	
	if($qr_collections->numHits()){
		while($qr_collections->nextHit()) {
			$va_child_ids = $qr_collections->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => "ca_collections.rank"));
			if($vn_level > 1){
				$vs_output .= "<div style='margin-left:".(($vn_level == 2) ? 5 : ((15*($vn_level - 2)) + 5))."px;'>";
				$vs_output .= "<a href='#' onClick='scrollToDiv(\"".$qr_collections->get("ca_collections.collection_id")."\"); return false;'>".$qr_collections->get("ca_collections.preferred_labels")."</a>";
				$vs_output .= "</div>";
			}
			if(sizeof($va_child_ids)) {
				$vs_output .=  printOverviewLevel($po_request, $va_child_ids, $o_config, $vn_level + 1, $va_options);
			}
		}
	}
	return $vs_output;
}

function caGetCollectionLevelSummaryEstee($po_request, $va_collection_ids, $vn_level) {
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
	
	$vs_sub_collection_label_template = $o_collections_config->get("export_sub_collection_label_template");
	$vs_sub_collection_desc_template = $o_collections_config->get("export_sub_collection_description_template");
	$vs_sub_collection_sort = $o_collections_config->get("export_sub_collection_sort");
	if(!$vs_sub_collection_sort){
		$vs_sub_collection_sort = "ca_collections.idno_sort";
	}
	$vb_dont_show_top_level_description = false;
	if($o_collections_config->get("dont_show_top_level_description") && ($vn_level == 1)){
		$vb_dont_show_top_level_description = true;
	}
	$vs_object_template = $o_collections_config->get("export_object_label_template");
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
			# --- related objects?
			$va_object_ids = $qr_collections->get("ca_objects.object_id", array("excludeTypes" => "item", "returnAsArray" => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_objects.rank'));
			#$vn_rel_object_count = sizeof($va_object_ids);
			$va_child_ids = $qr_collections->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => $vs_sub_collection_sort));
			$vs_output .= "<div class='unit' style='margin-left:".(40*($vn_level - 1))."px;'>";
			if($vs_icon){
				$vs_output .= $vs_icon." ";
			}
			$vs_output .= "<a name='CollectionID".$qr_collections->get("ca_collections.collection_id")."'>&nbsp;</a><b>";
			if($vs_sub_collection_label_template){
				$vs_output .= $qr_collections->getWithTemplate($vs_sub_collection_label_template);
			}else{
				$vs_output .= $qr_collections->get("ca_collections.preferred_labels");
			}
			$vs_output .= "</b>";
		
			#if($vn_rel_object_count){
			#	$vs_output .= " <span class='small'>(".$vn_rel_object_count." record".(($vn_rel_object_count == 1) ? "" : "s").")</span>";
			#}
			$vs_output .= "<br/>";
			if(!$vb_dont_show_top_level_description){
				$vs_desc = "";
				if($vs_sub_collection_desc_template && ($vs_desc = $qr_collections->getWithTemplate($vs_sub_collection_desc_template))){
					$vs_output .= "<div class='unit'>".$vs_desc."</div>";
				}
			}
			# --- objects
			if(sizeof($va_object_ids)){
				$qr_objects = caMakeSearchResult("ca_objects", $va_object_ids);
				while($qr_objects->nextHit()){
					$vs_output .= "<div style='margin-left:20px;'>";
					if($vs_object_template){
						$vs_output .= $qr_objects->getWithTemplate($vs_object_template);
					}else{
						$vs_output .= $qr_objects->get("ca_objects.preferred_labels.name");
					}
					$vs_output .= "</div>";
				}
			}
			$vs_output .= "</div>";
			if(sizeof($va_child_ids)) {
				$vs_output .=  caGetCollectionLevelSummaryEstee($po_request, $va_child_ids, $vn_level + 1);
			}
		}
	}
	return $vs_output;
}

function caGetCollectionLevelSummaryTOCEstee($po_request, $va_collection_ids, $vn_level) {
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
	
	$vs_sub_collection_label_template = $o_collections_config->get("export_sub_collection_label_template");
	$vs_sub_collection_desc_template = $o_collections_config->get("export_sub_collection_description_template");
	$vs_sub_collection_sort = $o_collections_config->get("export_sub_collection_sort");
	if(!$vs_sub_collection_sort){
		$vs_sub_collection_sort = "ca_collections.idno_sort";
	}
	if($qr_collections->numHits()){
		while($qr_collections->nextHit()) {
			if($va_exclude_collection_type_ids && is_array($va_exclude_collection_type_ids) && (in_array($qr_collections->get("ca_collections.type_id"), $va_exclude_collection_type_ids))){
				continue;
			}
			$va_child_ids = $qr_collections->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => $vs_sub_collection_sort));
			if(strToLower($qr_collections->getWithTemplate("^ca_collections.type_id")) != "collection"){
				$vs_output .= "<div class='unit' style='margin-left:".(20*($vn_level - 2))."px;'>";
				$vs_output .= "<b>";
				if($vs_sub_collection_label_template){
					$vs_output .= "<a href='#CollectionID".$qr_collections->get("ca_collections.collection_id")."'>".$qr_collections->getWithTemplate($vs_sub_collection_label_template)."</a>";
				}else{
					$vs_output .= "<a href='#CollectionID".$qr_collections->get("ca_collections.collection_id")."'>".$qr_collections->get("ca_collections.preferred_labels")."</a>";
				}
				$vs_output .= "</b>";
		
				$vs_output .= "<br/>";
				$vs_output .= "</div>";
			}
			if(sizeof($va_child_ids)) {
				$vs_output .=  caGetCollectionLevelSummaryTOCEstee($po_request, $va_child_ids, $vn_level + 1);
			}
		}
	}
	return $vs_output;
}
?>