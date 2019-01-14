<?php
 function caNWSGetCollectionLevelSummary($po_request, $va_collection_ids, $vn_level) {
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
		$vs_output = "";
		$qr_collections = caMakeSearchResult("ca_collections", $va_collection_ids);
		
		#$vs_sub_collection_label_template = $o_collections_config->get("export_sub_collection_label_template");
		#$vs_sub_collection_desc_template = $o_collections_config->get("export_sub_collection_description_template");
		#$vs_object_template = $o_collections_config->get("export_object_label_template");
		#$va_collection_type_icons = array();
		#$va_collection_type_icons_by_idnos = $o_collections_config->get("export_collection_type_icons");
		#if(is_array($va_collection_type_icons_by_idnos) && sizeof($va_collection_type_icons_by_idnos)){
		#	foreach($va_collection_type_icons_by_idnos as $vs_idno => $vs_icon){
		#		$va_collection_type_icons[$t_list->getItemId("collection_types", $vs_idno)] = $vs_icon;
		#	}
		#}
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
				#$va_object_ids = $qr_collections->get("ca_objects.object_id", array("returnAsArray" => true, 'checkAccess' => $va_access_values));
				#$vn_rel_object_count = sizeof($va_object_ids);
				$va_child_ids = $qr_collections->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => "ca_collections.idno_sort"));
				$vs_output .= "<div class='unit' style='margin-left:".(40*($vn_level - 1))."px;'>";
				#if($vs_icon){
				#	$vs_output .= $vs_icon." ";
				#}
				if(!$qr_collections->get("ca_collections.parent.collection_id")){
					# --- top level of collection
					$vs_output .= "<div class='unit' style='font-size:16px;'><b>".$qr_collections->get("ca_collections.preferred_labels")."</b>";
					# --- subtitle
					$t_list_item = new ca_list_items($qr_collections->get("ca_collections.type_id"));
					if($t_list_item->get("idno") == "archive_collection"){
						$vs_output .= "<br/>A Collection Guide";
					}else{
						$vs_output .= "<br/>A Special Collection of The Northwest School";
					}
					$vs_output .= "</div>";
					
					$vs_repository_name = $qr_collections->get("ca_collections.repository.repositoryName");
					$vs_repository_location = $qr_collections->get("ca_collections.repository.repositoryLocation");
					if($vs_repository_name ||  $vs_repository_location){
						$vs_output .= "<div class='unit' style='font-size:12px;'><h6>Repository</h6>".$vs_repository_name.(($vs_repository_name && $vs_repository_location) ? "<br/>" : "").$vs_repository_location."</div>";
					}

				}else{	
					$vs_output .= "<div class='unit' style='font-size:14px; text-decoration:underline;'><b>".(($vs_tmp = $qr_collections->get("ca_collections.idno")) ? $vs_tmp.", " : "").$qr_collections->get("ca_collections.preferred_labels")."</b></div>";
				}
				#if($vn_rel_object_count){
				#	$vs_output .= " <span class='small'>(".$vn_rel_object_count." record".(($vn_rel_object_count == 1) ? "" : "s").")</span>";
				#}
				
				if ($vs_tmp = $qr_collections->getWithTemplate('<unit delimiter="<br/>"><ifdef code="ca_collections.unitDate.dacs_date_value">^ca_collections.unitDate.dacs_date_value ^ca_collections.unitDate.dacs_dates_types</ifdef></unit>')) {
					$vs_output .=  "<div class='unit' style='font-size:12px;'><h6>Date</h6>".$vs_tmp."</div>";
				}
				if ($vs_tmp = trim($qr_collections->get('ca_collections.extentDACS.extent_value')." ".$qr_collections->get('ca_collections.extentDACS.extent_type', array("convertCodesToDisplayText" => true)))) {
					$vs_output .= "<div class='unit' style='font-size:12px;'><h6>Extent</h6>".$vs_tmp."</div>";
				}					
				if ($vs_tmp = $qr_collections->get('ca_entities.preferred_labels', array('delimiter' => '<br/>', 'checkAccess' => $va_access_values))) {
					$vs_output .= "<div class='unit' style='font-size:12px;'><h6>Creator(s)</h6>".$vs_tmp."</div>";
				}	
				if ($vs_tmp = $qr_collections->get('ca_collections.adminbiohist')) {
					$vs_output .= "<div class='unit' style='font-size:12px;'><h6>Administrative/Biographical History</h6>".$vs_tmp."</div>";
				}
				# --- use description field for scope and content if not record group or collection
				$vs_record_group_type_id = $t_list->getItemIDFromList("collection_types", "recordgrp");
				$vs_collection_type_id = $t_list->getItemIDFromList("collection_types", "collection");
				if(!in_array($qr_collections->get('ca_collections.type_id'), array($vs_record_group_type_id, $vs_collection_type_id))){
					if ($vs_tmp = $qr_collections->get('ca_collections.description')) {
						$vs_output .= "<div class='unit' style='font-size:12px;'><h6>Scope and Content</h6>".$vs_tmp."</div>";
					}
				}else{
					if ($vs_tmp = $qr_collections->get('ca_collections.scopecontent')) {
						$vs_output .= "<div class='unit' style='font-size:12px;'><h6>Scope and Content</h6>".$vs_tmp."</div>";
					}
				}
				if ($vs_tmp = $qr_collections->get('ca_collections.accessrestrict')) {
					$vs_output .= "<div class='unit' style='font-size:12px;'><h6>Conditions Governing Access</h6>".$vs_tmp."</div>";
				}
				if ($vs_tmp = $qr_collections->get('ca_collections.langmaterial')) {
					$vs_output .= "<div class='unit' style='font-size:12px;'><h6>Languages and Scripts of the Material</h6>".$vs_tmp."</div>";
				}
				# --- objects
				#if(sizeof($va_object_ids)){
				#	$qr_objects = caMakeSearchResult("ca_objects", $va_object_ids);
				#	while($qr_objects->nextHit()){
				#		$vs_output .= "<div style='margin-left:20px;'>";
				#		if($vs_object_template){
				#			$vs_output .= $qr_objects->getWithTemplate($vs_object_template);
				#		}else{
				#			$vs_output .= $qr_objects->get("ca_objects.preferred_labels.name");
				#		}
				#		$vs_output .= "</div>";
				#	}
				#}
				$vs_output .= "</div>";
				if(sizeof($va_child_ids)) {
					if(!$qr_collections->get("ca_collections.parent.collection_id")){
						$vs_output .= "<br/><div style='font-size:14px;font-weight:bold;margin-bottom:5px;'>Collection Contents</div><hr/><br/>";
		
					}
					$vs_output .=  caNWSGetCollectionLevelSummary($po_request, $va_child_ids, $vn_level + 1);
				}
			}
		}
		return $vs_output;
	}
?>