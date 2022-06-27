<?php
	
function italicizeTitle($vs_title){
	# --- returned italicized title, but make sure all brackets [] are NOT italic
	if(strpos($vs_title, "[") !== false){
		$vs_title = str_replace("[", "</i>[<i>", $vs_title);
	}
	if(strpos($vs_title, "]") !== false){
		$vs_title = str_replace("]", "</i>]<i>", $vs_title);
	}
	return "<i>".$vs_title."</i>";
}

#  ---------------------------------------------------------------------------------


	function hffGetCollectionLevelSummary($po_request, $va_collection_ids, $vn_level) {
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
		$t_list = new ca_lists();
		$vn_series_type_id = $t_list->getItemIDFromList("collection_types", "series");
		$vn_subgroup_type_id = $t_list->getItemIDFromList("collection_types", "record_group");
		$vn_subseries_type_id = $t_list->getItemIDFromList("collection_types", "subseries");
		$vn_folder_type_id = $t_list->getItemIDFromList("collection_types", "folder");

		#$vs_sub_collection_label_template = $o_collections_config->get("export_sub_collection_label_template");
		# --- all levels other than folder
		$vs_subgroup_desc_template = '';
		
		$vs_series_subseries_desc_template = '<ifdef code="ca_collections.extentDACS.extent_number|ca_collections.extentDACS.extent_type|ca_collections.extentDACS.container_summary|ca_collections.extentDACS.physical_details|ca_collections.extentDACS.extent_dimensions">
												<div class="unit">
													<unit relativeTo="ca_collections" delimiter=" ">
													<ifdef code="ca_collections.extentDACS.extent_number|ca_collections.extentDACS.extent_type"><div>Extent: ^ca_collections.extentDACS.extent_number <ifdef code="ca_collections.extentDACS.extent_type">^ca_collections.extentDACS.extent_type</ifdef></div></ifdef>
													<ifdef code="ca_collections.extentDACS.container_summary"><div>Container Summary: ^ca_collections.extentDACS.container_summary</div></ifdef>
													<ifdef code="ca_collections.extentDACS.physical_details"><div>Physical Details: ^ca_collections.extentDACS.physical_details</div></ifdef>
													<ifdef code="ca_collections.extentDACS.extent_dimensions"><div>Dimensions: ^ca_collections.extentDACS.extent_dimensions</div></ifdef>
													</unit>
												</div>
											</ifdef>
											<ifdef code="ca_collections.scopecontent">
												<div class="unit"><H6>Scope and Content</H6>^ca_collections.scopecontent</div>
											</ifdef>
											<ifdef code="ca_collections.arrangement">
												<div class="unit"><H6>Arrangement</H6>^ca_collections.arrangement</div>
											</ifdef>
											<ifdef code="ca_collections.accessrestrict">
												<div class="unit"><H6>Conditions Governing Access</H6>^ca_collections.accessrestrict</div>
											</ifdef>
											<ifdef code="ca_collections.physaccessrestrict">
												<div class="unit"><H6>Physical Access</H6>^ca_collections.physaccessrestrict</div>
											</ifdef>
											<ifdef code="ca_collections.processInfo">
												<div class="unit"><H6>Processing Information</H6>^ca_collections.processInfo</div>
											</ifdef>';
		# --- folder level description
		$vs_folder_desc_template = '<div style="float:left; width:25%;" class="folder">
										<ifcount code="ca_storage_locations">
											<div class="unit">
												<unit relativeTo="ca_storage_locations.related" delimiter="<br/>">^ca_storage_locations.parent.preferred_labels, ^ca_storage_locations.preferred_labels</unit>
											</div>
										</ifcount>
									</div>
									<div style="float:left; width:70%; padding-left:5%;" class="folder">
										<div class="unit">
											<b>^ca_collections.preferred_labels<ifdef code="ca_collections.unitdate.dacs_date_text">, ^ca_collections.unitdate.dacs_date_text</b></ifdef>
										</div>
										<ifdef code="ca_collections.extentDACS.extent_number|ca_collections.extentDACS.extent_type|ca_collections.extentDACS.container_summary|ca_collections.extentDACS.physical_details|ca_collections.extentDACS.extent_dimensions">
											<div class="unit">
												<unit relativeTo="ca_collections" delimiter=" ">
												<ifdef code="ca_collections.extentDACS.extent_number|ca_collections.extentDACS.extent_type"><div>Extent: ^ca_collections.extentDACS.extent_number <ifdef code="ca_collections.extentDACS.extent_type">^ca_collections.extentDACS.extent_type</ifdef></div></ifdef>
												<ifdef code="ca_collections.extentDACS.container_summary"><div>Container Summary: ^ca_collections.extentDACS.container_summary</div></ifdef>
												<ifdef code="ca_collections.extentDACS.physical_details"><div>Physical Details: ^ca_collections.extentDACS.physical_details</div></ifdef>
												<ifdef code="ca_collections.extentDACS.extent_dimensions"><div>Dimensions: ^ca_collections.extentDACS.extent_dimensions</div></ifdef>
												</unit>
											</div>
										</ifdef>
										<ifdef code="ca_collections.scopecontent">
											<div class="unit"><H6>Scope and Content</H6>^ca_collections.scopecontent</div>
										</ifdef>
										<ifdef code="ca_collections.adminbiohist"><div class="unit"><H6>Administrative/Biographical History</H6>^ca_collections.adminbiohist</div></ifdef>
										<ifdef code="ca_collections.general_notes"><div class="unit"><H6>General Notes</H6>^ca_collections.general_notes</div></ifdef>
										<ifdef code="ca_collections.arrangement">
											<div class="unit"><H6>Arrangement</H6>^ca_collections.arrangement</div>
										</ifdef>
										<ifdef code="ca_collections.accessrestrict"><div class="unit"><H6>Conditions Governing Access</H6>^ca_collections.accessrestrict</div></ifdef>
										<ifdef code="ca_collections.govtuse"><div class="unit"><H6>Conditions Governing Use</H6>^ca_collections.govtuse</div></ifdef>
										<ifdef code="ca_collections.physical_description"><div class="unit"><H6>Physical Description</H6>^ca_collections.physical_description</div></ifdef>
										<ifdef code="ca_collections.physfacet"><div class="unit"><H6>Physical Facet</H6>^ca_collections.physfacet</div></ifdef>
										<ifdef code="ca_collections.techaccessrestrict"><div class="unit"><H6>Technical Access</H6>^ca_collections.techaccessrestrict</div></ifdef>
										<ifdef code="ca_collections.originalsloc"><div class="unit"><H6>Existence and Location of Originals</H6>^ca_collections.originalsloc</div></ifdef>
										<ifdef code="ca_collections.altformavail"><div class="unit"><H6>Existence and Location of Copies</H6>^ca_collections.altformavail</div></ifdef>
										<ifdef code="ca_collections.langmaterial"><div class="unit"><H6>Languages and Scripts on the Material</H6>^ca_collections.langmaterial</div></ifdef>
										<ifdef code="ca_collections.related_materials"><div class="unit"><H6>Related Materials</H6>^ca_collections.related_materials</div></ifdef>
										<ifdef code="ca_collections.separated_materials"><div class="unit"><H6>Separated Materials</H6>^ca_collections.separated_materials</div></ifdef>
										
										
									</div>';
		#$vs_sub_collection_sort = $o_collections_config->get("export_sub_collection_sort");
		#if(!$vs_sub_collection_sort){
		#	$vs_sub_collection_sort = "ca_collections.idno_sort";
		#}
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
		$vs_exclude_objects_from_finding_aid = "";
		$vn_top_level_collection_id = "";
		if($qr_collections->numHits()){
			while($qr_collections->nextHit()) {
				if($va_exclude_collection_type_ids && is_array($va_exclude_collection_type_ids) && (in_array($qr_collections->get("ca_collections.type_id"), $va_exclude_collection_type_ids))){
					continue;
				}
				$vs_icon = "";
				if(is_array($va_collection_type_icons) && $va_collection_type_icons[$qr_collections->get("ca_collections.type_id")]){
					$vs_icon = $va_collection_type_icons[$qr_collections->get("ca_collections.type_id")];
				}
				# --- do not show related objects if top level collection has fa_exclude_objects checkbox selected
				if(!$vn_top_level_collection_id){
					$vn_top_level_collection_id = array_shift($qr_collections->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));
					$t_parent_collection = new ca_collections($vn_top_level_collection_id);
					$vs_exclude_objects_from_finding_aid = $t_parent_collection->get("fa_exclude_objects", array("convertCodesToDisplayText" => true));				
				}
				# yes no values switched
				if($vs_exclude_objects_from_finding_aid == "no"){
					$va_object_ids= array();
				}else{
					# --- related objects?
					$va_object_ids = $qr_collections->get("ca_objects.object_id", array("returnAsArray" => true, 'checkAccess' => $va_access_values));
				}
				$vn_rel_object_count = sizeof($va_object_ids);
				$va_child_ids = $qr_collections->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => "ca_collections.rank"));
				if(!$vb_dont_show_top_level_description){
					$vs_output .= "<div class='unit' style='margin-left:".(40*($vn_level - 2))."px;'>";
					if($qr_collections->get("ca_collections.type_id") != $vn_folder_type_id){
						if($vs_icon){
							$vs_output .= $vs_icon." ";
						}				
						$vs_output .= "<b>";
						$vs_output .= $qr_collections->getWithTemplate('^ca_collections.preferred_labels');
						if($qr_collections->get("ca_collections.type_id") != $vn_subgroup_type_id){
							$vs_output .= $qr_collections->getWithTemplate('<ifdef code="ca_collections.unitdate.dacs_date_text">, ^ca_collections.unitdate.dacs_date_text</ifdef>');
						}
						$vs_output .= "</b>";
			
						if($vn_rel_object_count){
							$vs_output .= " <span class='small'>(".$vn_rel_object_count." record".(($vn_rel_object_count == 1) ? "" : "s").")</span>";
						}
						$vs_output .= "</br>";
					}				
					$vs_desc = "";
					switch($qr_collections->get("ca_collections.type_id")){
						case $vn_folder_type_id:
							$vs_desc = $qr_collections->getWithTemplate($vs_folder_desc_template);
						break;
						# -----------------------------------------------
						case $vn_subgroup_type_id:
							$vs_desc = $qr_collections->getWithTemplate($vs_subgroup_desc_template);
						break;
						# -----------------------------------------------
						case $vn_series_type_id:
						case $vn_subseries_type_id:
							$vs_desc = $qr_collections->getWithTemplate($vs_series_subseries_desc_template);
						break;
						# -----------------------------------------------	
					}
					if(trim($vs_desc)){
						$vs_output .= "<p>".$vs_desc."</p>";
					}
				}
				# --- objects
				if(sizeof($va_object_ids)){
					$qr_objects = caMakeSearchResult("ca_objects", $va_object_ids);
					$vs_output .= "<div class='unit'><div style='margin-left:25%'><H6>Digital Items</H6>";
					$t_object = new ca_objects();
					while($qr_objects->nextHit()){
						$vs_output .= "<div>";
						$vs_rep_type = "";
						$t_object->load($qr_objects->get("ca_objects.object_id"));
						if($va_rep = $t_object->getPrimaryRepresentation(array('original'), null, array('return_with_access' => $va_access_values))){
							$vs_rep_type = " (".str_replace(array("application/", "image/", "video/", "audio/"), "", $va_rep['mimetype']).")";
						}
						
						
	
						if($vs_object_template){
							$vs_output .= $qr_objects->getWithTemplate($vs_object_template).$vs_rep_type;
						}else{
							$vs_output .= $qr_objects->get("ca_objects.preferred_labels.name").$vs_rep_type;
						}
						$vs_output .= "</div>";
					}
					$vs_output .= "</div></div>";
				}
				$vs_output .= "</div>";
				if(sizeof($va_child_ids)) {
					$vs_output .=  hffGetCollectionLevelSummary($po_request, $va_child_ids, $vn_level + 1);
				}
			}
		}
		return $vs_output;
	}

?>