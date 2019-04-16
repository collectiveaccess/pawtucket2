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
?>