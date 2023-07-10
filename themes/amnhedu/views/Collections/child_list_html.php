<?php
	$va_access_values = $this->getVar("access_values");
	$o_collections_config = $this->getVar("collections_config");
	$vs_desc_template = $o_collections_config->get("description_template");
	$t_item = $this->getVar("item");
	$vn_collection_id = $this->getVar("collection_id");
	$va_exclude_collection_type_ids = $this->getVar("exclude_collection_type_ids");
	$va_non_linkable_collection_type_ids = $this->getVar("non_linkable_collection_type_ids");
	$va_collection_type_icons = $this->getVar("collection_type_icons");
	$vb_collapse_levels = $o_collections_config->get("collapse_levels");
	
function printLevel($po_request, $va_collection_ids, $o_config, $vn_level, $va_options = array()) {
	if($o_config->get("max_levels") && ($vn_level > $o_config->get("max_levels"))){
		return;
	}
	$va_access_values = caGetUserAccessValues($po_request);
	$vs_output = "";
	$vs_desc_template = $o_config->get("description_template");
	$qr_collections = caMakeSearchResult("ca_collections", $va_collection_ids);
	
	if($qr_collections->numHits()){
		while($qr_collections->nextHit()) {
			$vs_icon = "";
			# --- related objects?
			$vn_rel_object_count = sizeof($qr_collections->get("ca_objects.object_id", array("returnAsArray" => true, 'checkAccess' => $va_access_values)));
			if(is_array($va_options["collection_type_icons"])){
				$vs_icon = $va_options["collection_type_icons"][$qr_collections->get("ca_collections.type_id")];
			}
			$va_child_ids = $qr_collections->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => "ca_collections.idno_sort"));
			# --- check if collection record type is configured to be excluded
			if(($vn_level > 1) && is_array($va_options["exclude_collection_type_ids"]) && (in_array($qr_collections->get("ca_collections.type_id"), $va_options["exclude_collection_type_ids"]))){
				continue;
			}
			$vs_output .= "<div style='margin-left:".(20*($vn_level - 1))."px;'>";
			# --- should collection record link to detail?
			$vb_link = true;
			# --- check if collection record type has been configured to not be a link to detail page
			if(is_array($va_options["non_linkable_collection_type_ids"]) && (in_array($qr_collections->get("ca_collections.type_id"), $va_options["non_linkable_collection_type_ids"]))){
				$vb_link = false;
			}
			if(!$o_config->get("always_link_to_detail")){
				if(!sizeof($va_child_ids) && !$vn_rel_object_count){
					$vb_link = false;
				}
			}
			# --- should collection record title open collapsed sub items?
			if(($vn_level > 1) && $va_options["collapse_levels"]){
				$vb_collapse_link = true;
			}else{
				$vb_collapse_link = false;
			}
			if(!sizeof($va_child_ids)){
				$vb_collapse_link = false;
			}
			if($vn_level == 1){
				$vs_output .= "<div class='label'>";
			}
			if($vb_link){
				$vs_output .= $vs_icon." ";
				if($vb_collapse_link){
					$vs_output .= "<a href='#' onClick='jQuery(\"#level".$qr_collections->get('ca_collections.collection_id')."\").toggle(); return false;'>".$qr_collections->get('ca_collections.preferred_labels')."</a>";
				}else{
					$vs_output .= caDetailLink($po_request, $qr_collections->get('ca_collections.preferred_labels'), '', 'ca_collections',  $qr_collections->get("ca_collections.collection_id"));
				}
				$vs_output .= " ".caDetailLink($po_request, (($o_config->get("link_out_icon")) ? $o_config->get("link_out_icon") : ""), '', 'ca_collections',  $qr_collections->get("ca_collections.collection_id"));
			}else{
				$vs_output .= "<span class='nonLinkedCollection'>".$vs_icon." ";
				if($vb_collapse_link){
					$vs_output .= "<a href='#' onClick='jQuery(\"#level".$qr_collections->get('ca_collections.collection_id')."\").toggle(); return false;'>".$qr_collections->get('ca_collections.preferred_labels')."</a>";
				}else{
					$vs_output .= $qr_collections->get("ca_collections.preferred_labels");
				}
				$vs_output .= "</span>";
			}
			if($vn_rel_object_count){
				$vs_output .= " <small>(".$vn_rel_object_count." record".(($vn_rel_object_count == 1) ? "" : "s").")</small>";
			}
			if($vn_level == 1){
				$vs_output .= "</div>";
			}
			$vs_desc = "";
			if($vs_desc_template && ($vs_desc = $qr_collections->getWithTemplate($vs_desc_template))){
				$vs_output .= "<p>".$vs_desc."</p>";
			}
			$vs_output .= "</div>";
			if(sizeof($va_child_ids)) {
				if($vb_collapse_link){
					$vs_output .= "<div id='level".$qr_collections->get("ca_collections.collection_id")."' style='display:none;'>";
				}
				$vs_output .=  printLevel($po_request, $va_child_ids, $o_config, $vn_level + 1, $va_options);
				if($vb_collapse_link){
					$vs_output .= "</div>";
				}
			}
		}
	}
	return $vs_output;
}

if ($vn_collection_id) {
	print printLevel($this->request, array($vn_collection_id), $o_collections_config, 1, array("exclude_collection_type_ids" => $va_exclude_collection_type_ids, "non_linkable_collection_type_ids" => $va_non_linkable_collection_type_ids, "collection_type_icons" => $va_collection_type_icons, "collapse_levels" => $vb_collapse_levels));
}


?>

