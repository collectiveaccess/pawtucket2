<?php
	# --- right side panel in 2 pane hierarchy viewer on archival collection detail (fonds)
	
	$va_access_values = $this->getVar("access_values");
	$o_collections_config = $this->getVar("collections_config");
	$vs_desc_template = $o_collections_config->get("description_template_archival");
	$vs_desc_template_file = $o_collections_config->get("description_template_archival_file");
	$vs_rel_objects_template = $o_collections_config->get("rel_objects_template_archival");
	$vs_rel_objects_template_file = $o_collections_config->get("rel_objects_template_archival_file");
	$t_item = $this->getVar("item");
	$vn_collection_id = $this->getVar("collection_id");
	$va_exclude_collection_type_ids = $this->getVar("exclude_collection_type_ids");
	$va_non_linkable_collection_type_ids = $this->getVar("non_linkable_collection_type_ids");
	$va_collection_type_icons = $this->getVar("collection_type_icons");
	$vb_collapse_levels = $o_collections_config->get("collapse_levels_archival");
	
	
function printLevel($po_request, $va_collection_ids, $o_config, $vn_level, $va_options = array()) {
	if($o_config->get("max_levels") && ($vn_level > $o_config->get("max_levels"))){
		return;
	}
	$va_access_values = caGetUserAccessValues($po_request);
	$vs_output = "";
	$vs_desc_template = $o_config->get("description_template_archival");
	$vs_desc_template_file = $o_config->get("description_template_archival_file");
	$vs_rel_objects_template = $o_config->get("rel_objects_template_archival");
	$vs_rel_objects_template_file = $o_config->get("rel_objects_template_archival_file");
	
	$qr_collections = caMakeSearchResult("ca_collections", $va_collection_ids);
	
	# --- on series, sub-series records that are not the top level collection, we load the viewer showing the top level collection
	# --- but have it "opened" to the current record - this means don't collapse the ancestors of the current record
	$current_collection_id = $po_request->getParameter("current_collection_id", pInteger);	
	$t_current_collection = new ca_collections($current_collection_id);
	$va_current_collection_ancestors = $t_current_collection->get("ca_collections.hierarchy.collection_id", array("returnAsArray" => true));	

	
	if($qr_collections->numHits()){
		while($qr_collections->nextHit()) {			
			$vs_icon = "";
			# --- related objects?
			$vn_rel_object_count = sizeof($qr_collections->get("ca_objects.object_id", array('excludeTypes' => array('archival_file'), "restrictToRelationshipTypes" => array('archival_part'), "returnAsArray" => true, 'checkAccess' => $va_access_values)));
			if(is_array($va_options["collection_type_icons"])){
				$vs_icon = $va_options["collection_type_icons"][$qr_collections->get("ca_collections.type_id")];
			}
			$va_child_ids = $qr_collections->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => "ca_collections.idno_sort"));
			$va_child_file_ids = $qr_collections->get('ca_objects.object_id', array('restrictToTypes' => array('archival_file'), "restrictToRelationshipTypes" => array('archival_part'), 'returnAsArray' => true, 'checkAccess' => $va_access_values, 'sort' => 'ca_objects.idno_sort'));
			# --- check if collection record type is configured to be excluded
			if(($vn_level > 1) && is_array($va_options["exclude_collection_type_ids"]) && (in_array($qr_collections->get("ca_collections.type_id"), $va_options["exclude_collection_type_ids"]))){
				continue;
			}
			$vs_output .= "<div style='margin-left:".(20*($vn_level - 1))."px;'>";
			# --- should collection record link to detail?
			#$vb_link = true;
			# --- check if collection record type has been configured to not be a link to detail page
			#if(is_array($va_options["non_linkable_collection_type_ids"]) && (in_array($qr_collections->get("ca_collections.type_id"), $va_options["non_linkable_collection_type_ids"]))){
			#	$vb_link = false;
			#}
			#if(!$o_config->get("always_link_to_detail")){
			#	if(!sizeof($va_child_ids) && !$vn_rel_object_count){
			#		$vb_link = false;
			#	}
			#}
			# --- should collection record title open collapsed sub items?
			if(($vn_level > 1) && $va_options["collapse_levels"]){
				$vb_collapse_link = true;
			}else{
				$vb_collapse_link = false;
			}
			if(!sizeof($va_child_ids) && !$va_child_file_ids){
				$vb_collapse_link = false;
			}
			if($vn_level == 1){
				$vs_output .= "<div class='label'>";
			}
			#if($vb_link){
				$vs_output .= $vs_icon." ";
				if($vb_collapse_link){
					$vs_output .= "<a href='#' onClick='jQuery(\"#level".$qr_collections->get('ca_collections.collection_id')."\").toggle(); $(this).children(\".glyphicon\").toggleClass(\"glyphicon-collapse-up\"); $(this).children(\".glyphicon\").toggleClass(\"glyphicon-collapse-down\"); return false;'>".$qr_collections->get('ca_collections.preferred_labels')." <span class='glyphicon glyphicon-collapse-".((!in_array($qr_collections->get("ca_collections.collection_id"), $va_current_collection_ancestors)) ? "down" : "up")."' aria-hidden='true'></span></a>";
				}else{
					#$vs_output .= caDetailLink($po_request, $qr_collections->get('ca_collections.preferred_labels'), '', 'ca_collections',  $qr_collections->get("ca_collections.collection_id"));
					$vs_output .= (($vn_level != 1) ? "<span class='subCollectionName'>" : "").$qr_collections->get('ca_collections.preferred_labels').(($vn_level != 1) ? "</span>" : "");
				}
				$vs_output .= " ".caDetailLink($po_request, "View ".$qr_collections->get('ca_collections.type_id', array("convertCodesToDisplayText" => true))." ".(($o_config->get("link_out_icon")) ? $o_config->get("link_out_icon") : ""), 'btn btn-small btn-default', 'ca_collections',  $qr_collections->get("ca_collections.collection_id"));
			#}else{
			#	$vs_output .= "<span class='nonLinkedCollection'>".$vs_icon." ";
			#	if($vb_collapse_link){
			#		$vs_output .= "<a href='#' onClick='jQuery(\"#level".$qr_collections->get('ca_collections.collection_id')."\").toggle(); return false;'>".$qr_collections->get('ca_collections.preferred_labels')."</a>";
			#	}else{
			#		$vs_output .= $qr_collections->get("ca_collections.preferred_labels");
			#	}
			#	$vs_output .= "</span>";
			#}
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
			
			
			$vs_rel_objects = $qr_collections->getWithTemplate($vs_rel_objects_template);
			if($vs_rel_objects || sizeof($va_child_ids) || sizeof($va_child_file_ids)) {
				if($vb_collapse_link){
					$vs_output .= "<div id='level".$qr_collections->get("ca_collections.collection_id")."' ".((!in_array($qr_collections->get("ca_collections.collection_id"), $va_current_collection_ancestors)) ? "style='display:none;'" : "").">";
				}
			}
			if($vs_rel_objects){
				# --- related objects are displayed separate from the description so they can be collapsed with all sub records
				$vs_output .= "<div style='margin-left:".(20*($vn_level - 1))."px; padding-top:5px;'>".$vs_rel_objects."</div>";
			}
			if(sizeof($va_child_ids) || sizeof($va_child_file_ids)) {
				$vs_output .=  printLevel($po_request, $va_child_ids, $o_config, $vn_level + 1, $va_options);
				if(sizeof($va_child_file_ids)){
					
						$qr_collection_children_file = caMakeSearchResult("ca_objects", $va_child_file_ids);
						if($qr_collection_children_file->numHits()){
							while($qr_collection_children_file->nextHit()){
								$vs_output .= "<div style='margin-left:".(20*($vn_level))."px;'>";
								$vn_rel_object_count_file = sizeof($qr_collection_children_file->get("ca_objects.related.object_id", array('excludeTypes' => array('archival_file'), "restrictToRelationshipTypes" => array('archival_part'), 'returnAsArray' => true, 'checkAccess' => $va_access_values)));
								$vs_rel_objects_file = $qr_collection_children_file->getWithTemplate($vs_rel_objects_template_file);
								if($va_options["collapse_levels"] && $vs_rel_objects_file){
									$vs_output .= "<a href='#' onClick='jQuery(\"#levelFile".$qr_collection_children_file->get('ca_objects.object_id')."\").toggle(); $(this).children(\".glyphicon\").toggleClass(\"glyphicon-collapse-up\"); $(this).children(\".glyphicon\").toggleClass(\"glyphicon-collapse-down\"); return false;'>".$qr_collection_children_file->get("ca_objects.preferred_labels.name")." <span class='glyphicon glyphicon-collapse-down' aria-hidden='true'></span></a>";
								}else{
									#$vs_output .= caDetailLink($po_request, $qr_collection_children_file->get("ca_objects.preferred_labels.name"), '', 'ca_objects',  $qr_collection_children_file->get("ca_objects.object_id"));
									$vs_output .= "<span class='subCollectionName'>".$qr_collection_children_file->get("ca_objects.preferred_labels.name")."</span>";
								}
								$vs_output .= " ".caDetailLink($po_request, "View ".$qr_collection_children_file->get("ca_objects.type_id", array("convertCodesToDisplayText" => true))." ".(($o_config->get("link_out_icon")) ? $o_config->get("link_out_icon") : ""), 'btn btn-small btn-default', 'ca_objects',  $qr_collection_children_file->get("ca_objects.object_id"));
								if($vn_rel_object_count_file){
									$vs_output .= " <small>(".$vn_rel_object_count_file." record".(($vn_rel_object_count_file == 1) ? "" : "s").")</small>";
								}
								$vs_desc = "";
								if($vs_desc_template_file && ($vs_desc = $qr_collection_children_file->getWithTemplate($vs_desc_template_file))){
									$vs_output .= "<p>".$vs_desc."</p>";
								}
								if($va_options["collapse_levels"] && $vs_rel_objects_file){
									$vs_output .= "<div id='levelFile".$qr_collection_children_file->get('ca_objects.object_id')."' style='display:none; padding-top:5px;'>";
								}
								$vs_output .= $vs_rel_objects_file;
								if($va_options["collapse_levels"] && $vs_rel_objects_file){
									$vs_output .= "</div>";
								}
								$vs_output .= "</div>";						
							}
						}
				}
			}
			if($vs_rel_objects || sizeof($va_child_ids) || sizeof($va_child_file_ids)) {
				if($vb_collapse_link){
					$vs_output .= "</div>";
				}
			}
			# --- get sub collections that are object records (archival files)
			#if($vn_level != 1){
			#}

			
			
		}
	}
	return $vs_output;
}

if ($vn_collection_id) {
	print printLevel($this->request, array($vn_collection_id), $o_collections_config, 1, array("exclude_collection_type_ids" => $va_exclude_collection_type_ids, "non_linkable_collection_type_ids" => $va_non_linkable_collection_type_ids, "collection_type_icons" => $va_collection_type_icons, "collapse_levels" => $vb_collapse_levels));
}


?>

