<?php
	$va_access_values = $this->getVar("access_values");
	$o_locations_config = $this->getVar("locations_config");
	$vs_desc_template = $o_locations_config->get("description_template");
	$t_item = $this->getVar("item");
	$vn_location_id = $this->getVar("location_id");
	$va_exclude_location_type_ids = $this->getVar("exclude_location_type_ids");
	$va_non_linkable_location_type_ids = $this->getVar("non_linkable_location_type_ids");
	$va_location_type_icons = $this->getVar("location_type_icons");
	$vb_collapse_levels = $o_locations_config->get("collapse_levels");
	
function printLevel($po_request, $va_location_ids, $o_config, $vn_level, $va_options = array()) {
	if($o_config->get("max_levels") && ($vn_level > $o_config->get("max_levels"))){
		return;
	}
	$va_access_values = caGetUserAccessValues($po_request);
	$vs_output = "";
	$vs_desc_template = $o_config->get("description_template");
	$qr_locations = caMakeSearchResult("ca_storage_locations", $va_location_ids);
	
	if($qr_locations->numHits()){
		while($qr_locations->nextHit()) {
			$vs_icon = "";
			# --- related objects?
			$va_object_ids = $qr_locations->get("ca_objects.object_id", array("returnAsArray" => true, 'checkAccess' => $va_access_values));
			$vn_rel_object_count = sizeof($va_object_ids);
			if(is_array($va_options["location_type_icons"])){
				$vs_icon = $va_options["location_type_icons"][$qr_locations->get("ca_storage_locations.type_id")];
			}
			$va_child_ids = $qr_locations->get("ca_storage_locations.children.location_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => "ca_storage_locations.idno_sort"));
			# --- check if location record type is configured to be excluded
			if(($vn_level > 1) && is_array($va_options["exclude_location_type_ids"]) && (in_array($qr_locations->get("ca_storage_locations.type_id"), $va_options["exclude_location_type_ids"]))){
				continue;
			}
			$vs_output .= "<div style='margin-left:".(20*($vn_level - 1))."px;'>";
			# --- should location record link to detail?
			$vb_link = true;
			# --- check if location record type has been configured to not be a link to detail page
			if(is_array($va_options["non_linkable_location_type_ids"]) && (in_array($qr_locations->get("ca_storage_locations.type_id"), $va_options["non_linkable_location_type_ids"]))){
				$vb_link = false;
			}
			if(!$o_config->get("always_link_to_detail")){
				if(!sizeof($va_child_ids) && !$vn_rel_object_count){
					$vb_link = false;
				}
			}
			# --- should location record title open collapsed sub items?
			if(($vn_level > 1) && $va_options["collapse_levels"]){
				$vb_collapse_link = true;
			}else{
				$vb_collapse_link = false;
			}
			if(!sizeof($va_child_ids) && !$vn_rel_object_count){
				$vb_collapse_link = false;
			}
			if($vn_level == 1){
				$vs_output .= "<div class='label'>";
			}
			if($vb_link){
				$vs_output .= $vs_icon." ";
				if($vb_collapse_link){
					$vs_output .= "<a href='#' onClick='jQuery(\"#level".$qr_locations->get('ca_storage_locations.location_id')."\").toggle(); return false;'><i class='fa fa-sort' aria-hidden='true'></i> ".$qr_locations->get('ca_storage_locations.preferred_labels')."</a>";
				}else{
					$vs_output .= caDetailLink($po_request, $qr_locations->get('ca_storage_locations.preferred_labels'), '', 'ca_storage_locations',  $qr_locations->get("ca_storage_locations.location_id"));
				}
				$vs_output .= " ".caDetailLink($po_request, (($o_config->get("link_out_icon")) ? $o_config->get("link_out_icon") : ""), '', 'ca_storage_locations',  $qr_locations->get("ca_storage_locations.location_id"));
			}else{
				$vs_output .= "<span class='nonLinkedCollection'>".$vs_icon." ";
				if($vb_collapse_link){
					$vs_output .= "<a href='#' onClick='jQuery(\"#level".$qr_locations->get('ca_storage_locations.location_id')."\").toggle(); return false;'><i class='fa fa-sort' aria-hidden='true'></i> ".$qr_locations->get('ca_storage_locations.preferred_labels')."</a>";
				}else{
					$vs_output .= $qr_locations->get("ca_storage_locations.preferred_labels");
				}
				$vs_output .= "</span>";
			}
			if($vn_rel_object_count){
				$vs_output .= "<br/><small>(".$vn_rel_object_count." artwork".(($vn_rel_object_count == 1) ? "" : "s").")</small>";
			}
			if($vn_level == 1){
				$vs_output .= "</div>";
			}
			$vs_desc = "";
			if($vs_desc_template && ($vs_desc = $qr_locations->getWithTemplate($vs_desc_template)) && ($vs_desc != $qr_locations->get("ca_storage_locations.preferred_labels"))){
				$vs_output .= "<p>".$vs_desc."</p>";
			}
			$vs_output .= "</div>";
			if(sizeof($va_child_ids) || sizeof($va_object_ids)) {
				if($vb_collapse_link){
					$vs_output .= "<div id='level".$qr_locations->get("ca_storage_locations.location_id")."' style='display:none;'>";
				}
				if(sizeof($va_object_ids)){
					$qr_objects = caMakeSearchResult("ca_objects", array_slice($va_object_ids, 0, 12));
					$vs_output .= "<div style='margin-left:".(20*($vn_level - 1))."px;'><div class='container'><div class='row'>";
					while($qr_objects->nextHit()){
						$vs_output .= "<div class='col-xs-4 col-md-2 fullWidth'>".$qr_objects->getWithTemplate("<l>^ca_object_representations.media.icon<div class='locationArtworkCaption'>^ca_objects.preferred_labels.name%ellipsis=1&truncate=25</div></l>")."</div>";
					}
					$vs_output .= "</div>";
					if($vn_rel_object_count > $qr_objects->numHits()){
						$vs_output  .= "<div class='row'><div class='col-sm-12 text-center'>".caDetailLink($po_request, "View All ".(($o_config->get("link_out_icon")) ? $o_config->get("link_out_icon") : ""), 'btn btn-default', 'ca_storage_locations',  $qr_locations->get("ca_storage_locations.location_id"))."</div></div>";
					}
					$vs_output  .= "</div></div>";
				}
				if(sizeof($va_child_ids)){
					$vs_output .=  printLevel($po_request, $va_child_ids, $o_config, $vn_level + 1, $va_options);
				}
				if($vb_collapse_link){
					$vs_output .= "</div>";
				}
			}
		}
	}
	return $vs_output;
}

if ($vn_location_id) {
	print printLevel($this->request, array($vn_location_id), $o_locations_config, 1, array("exclude_location_type_ids" => $va_exclude_location_type_ids, "non_linkable_location_type_ids" => $va_non_linkable_location_type_ids, "location_type_icons" => $va_location_type_icons, "collapse_levels" => $vb_collapse_levels));
}


?>

