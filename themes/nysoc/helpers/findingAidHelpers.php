<?php
function printLevelPDF($po_request, $va_collection_ids, $o_config, $vn_level, $va_options = array()) {
	if($o_config->get("max_levels") && ($vn_level > $o_config->get("max_levels"))){
		return;
	}
	$vs_output = "";
	$qr_collections = caMakeSearchResult("ca_collections", $va_collection_ids);
	if($qr_collections->numHits()){
		while($qr_collections->nextHit()) {
		
			$vs_icon = "";
			# --- related objects?
			$vn_rel_object_count = sizeof($qr_collections->get("ca_objects.object_id", array("returnAsArray" => true, 'checkAccess' => $va_access_values)));
			if(is_array($va_options["collection_type_icons"])){
				$vs_icon = $va_options["collection_type_icons"][$qr_collections->get("ca_collections.type_id")];
			}
			if(is_array($va_options["collection_types"])){
				$va_collection_types = $va_options["collection_types"];
			}
			$vs_collection_type = $qr_collections->get('ca_collections.type_id', array('convertCodesToDisplayText' => true));
			$va_child_ids = $qr_collections->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values));
			# --- check if collection record type is configured to be excluded
			if(($vn_level > 2) && is_array($va_options["exclude_collection_type_ids"]) && (in_array($qr_collections->get("ca_collections.type_id"), $va_options["exclude_collection_type_ids"]))){
				continue;
			}
			$vn_type_id = $qr_collections->get('ca_collections.type_id');
			if(($vn_type_id == $va_collection_types['collection']) || ($vn_type_id == $va_collection_types['record_group']) || $vn_type_id == $va_collection_types['series']){
				$va_subject_list = array();
				if ($qr_collections->get('ca_collections.LcshNames') | $qr_collections->get('ca_collections.LcshTopical') | $qr_collections->get('ca_collections.LcshGeo')) {
					if($va_names = $qr_collections->get('ca_collections.LcshNames', array('returnAsArray' => true, 'returnWithStructure' => true))){
						foreach(array_pop($va_names) as $vn_item_id => $va_subject_info){
							$va_subject_parts = explode(' [',$va_subject_info["LcshNames"]);
							$va_subject_list[$va_subject_parts[0]] = $va_subject_parts[0];
						}
					}
					if($va_topical = $qr_collections->get('ca_collections.LcshTopical', array('returnAsArray' => true, 'returnWithStructure' => true))){
						foreach(array_pop($va_topical) as $vn_item_id => $va_subject_info){
							$va_subject_parts = explode(' [',$va_subject_info["LcshTopical"]);
							$va_subject_list[$va_subject_parts[0]] = $va_subject_parts[0];
						}
					}
					if($va_geo = $qr_collections->get('ca_collections.LcshGeo', array('returnAsArray' => true, 'returnWithStructure' => true))){
						foreach(array_pop($va_geo) as $vn_item_id => $va_subject_info){
							$va_subject_parts = explode(' [',$va_subject_info["LcshGeo"]);
							$va_subject_list[$va_subject_parts[0]] = $va_subject_parts[0];
						}
					}
					ksort($va_subject_list);
				}	
			}
			# ----- metadata based on collection record type --- this matches what is displayed in the collection detail page
			$vs_additional_md = "";
			switch($qr_collections->get("ca_collections.type_id")){
				case $va_collection_types['collection']:
					if ($vs_entities = $qr_collections->get('ca_entities.preferred_labels', array('delimiter' => '<br/>'))) {
						$vs_additional_md.= "<div class='unit'><span class='collectionLabel'>Creator(s): </span>".$vs_entities."</div>";
					}
					if ($qr_collections->get('ca_collections.unitdate.date_value')) {
						$vs_additional_md.= "<div class='unit'>".$qr_collections->get('ca_collections.unitdate', array('convertCodesToDisplayText' => true, 'template' => '<unit><span class="collectionLabel">^ca_collections.unitdate.dates_types:</span> ^ca_collections.unitdate.date_value', 'delimiter' => '<br/>'))."</div>";
					}
					if ($vs_extent = $qr_collections->get('ca_collections.extentDACS')) {
						$vs_additional_md.= "<div class='unit'><span class='collectionLabel'>Extent: </span>".$vs_extent."</div>";
					}
					if ($vs_container = $qr_collections->get('ca_collections.container')) {
						$vs_additional_md.= "<div class='unit'><span class='collectionLabel'>Container: </span>".$vs_container."</div>";
					}
					if ($vs_scope_content = $qr_collections->get('ca_collections.scopecontent')) {
						$vs_additional_md.= "<h3>Scope & Content</h3><div class='unit'>".$vs_scope_content."</div>";
					}
					if ($vs_historical = $qr_collections->get('ca_collections.adminbiohist')) {
						$vs_additional_md.= "<h3>Historical Note</h3><div class='unit'>".$vs_historical."</div>";
					}
					if (is_array($va_subject_list) && sizeof($va_subject_list)) {
						$vs_additional_md.= "<h3>Subjects</h3>";
						$vs_additional_md.= "<div class='unit'>";
						$vs_additional_md.= join('<br/>',$va_subject_list);
						$vs_additional_md.= "</div>";
					}
					if ($vs_processInfo = $qr_collections->get('ca_collections.processInfo')) {
						$vs_additional_md.= "<h3>Processing Note</h3><div class='unit'>".$vs_processInfo."</div>";
					}
					if ($vs_access = $qr_collections->get('ca_collections.accessrestrict')) {
						$vs_additional_md.= "<h3>Conditions Governing Access</h3><div class='unit'>".$vs_access."</div><br/>";
					}
					if ($vs_repo = $qr_collections->get('ca_collections.reproduction')) {
						$vs_additional_md.= "<h3>Conditions Governing Reproduction: </h3><div class='unit'>".$vs_repo."</div>";
					}
			
			
				break;
				# ---------------------------
				case $va_collection_types['record_group']:
				case $va_collection_types['series']:
					if ($qr_collections->get('ca_collections.unitdate.date_value')) {
						$vs_additional_md.= "<div class='unit'>".$qr_collections->get('ca_collections.unitdate', array('convertCodesToDisplayText' => true, 'template' => '<unit><span class="collectionLabel">^ca_collections.unitdate.dates_types:</span> ^ca_collections.unitdate.date_value', 'delimiter' => '<br/>'))."</div>";
					}
					if ($vs_extent = $qr_collections->get('ca_collections.extentDACS')) {
						$vs_additional_md.= "<div class='unit'><span class='collectionLabel'>Extent: </span>".$vs_extent."</div>";
					}
					if ($vs_container = $qr_collections->get('ca_collections.container')) {
						$vs_additional_md.= "<div class='unit'><span class='collectionLabel'>Container: </span>".$vs_container."</div>";
					}
					if ($vs_scope_content = $qr_collections->get('ca_collections.scopecontent')) {
						$vs_additional_md.= "<h3>Scope & Content</h3><div class='unit'>".$vs_scope_content."</div>";
					}
					if ($vs_historical = $qr_collections->get('ca_collections.adminbiohist')) {
						$vs_additional_md.= "<h3>Historical Note</h3><div class='unit'>".$vs_historical."</div>";
					}
					if ($vs_arrangement = $qr_collections->get('ca_collections.arrangement')) {
						$vs_additional_md.= "<h3>System of Arrangement</h3><div class='unit'>".$vs_arrangement."</div>";
					}
					if (is_array($va_subject_list) && sizeof($va_subject_list)) {
						$vs_additional_md.= "<h3>Subjects</h3>";
						$vs_additional_md.= "<div class='unit'>";
						$vs_additional_md.= join('<br/>',$va_subject_list);
						$vs_additional_md.= "</div>";
					}
			
				break;
				# ---------------------------
				case $va_collection_types['subseries']:
					if ($qr_collections->get('ca_collections.unitdate.date_value')) {
						$vs_additional_md.= "<div class='unit'>".$qr_collections->get('ca_collections.unitdate', array('convertCodesToDisplayText' => true, 'template' => '<unit><span class="collectionLabel">^ca_collections.unitdate.dates_types:</span> ^ca_collections.unitdate.date_value', 'delimiter' => '<br/>'))."</div>";
					}
					if ($vs_extent = $qr_collections->get('ca_collections.extentDACS')) {
						$vs_additional_md.= "<div class='unit'><span class='collectionLabel'>Extent: </span>".$vs_extent."</div>";
					}
					if ($vs_container = $qr_collections->get('ca_collections.container')) {
						$vs_additional_md.= "<div class='unit'><span class='collectionLabel'>Container: </span>".$vs_container."</div>";
					}
					if ($vs_scope_content = $qr_collections->get('ca_collections.scopecontent')) {
						$vs_additional_md.= "<h3>Scope & Content</h3><div class='unit'>".$vs_scope_content."</div>";
					}
					if ($vs_arrangement = $qr_collections->get('ca_collections.arrangement')) {
						$vs_additional_md.= "<h3>System of Arrangement</h3><div class='unit'>".$vs_arrangement."</div>";
					}		
				break;
				# ---------------------------
				default:
					# - file, box, folder
					if ($qr_collections->get('ca_collections.unitdate.date_value')) {
						$vs_additional_md.= "<div class='unit'>".$qr_collections->get('ca_collections.unitdate', array('convertCodesToDisplayText' => true, 'template' => '<unit><ifdef code="ca_collections.unitdate.dates_types"><span class="collectionLabel">^ca_collections.unitdate.dates_types:</span> </ifdef>^ca_collections.unitdate.date_value', 'delimiter' => '<br/>'))."</div>";
					}
					if ($vs_extent = $qr_collections->get('ca_collections.extentDACS')) {
						$vs_additional_md.= "<div class='unit'><span class='collectionLabel'>Extent: </span>".$vs_extent."</div>";
					}
					if ($vs_container = $qr_collections->get('ca_collections.container')) {
						$vs_additional_md.= "<div class='unit'><span class='collectionLabel'>Container: </span>".$vs_container."</div>";
					}
					if ($vs_idno = $qr_collections->get('ca_collections.idno')) {
						$vs_additional_md.= "<div class='unit'><span class='collectionLabel'>Identifier: </span>".$vs_idno."</div>";
					}
					if ($vs_scope_content = $qr_collections->get('ca_collections.scopecontent')) {
						$vs_additional_md.= "<div class='unit'>".$vs_scope_content."</div>";
					}			
				break;
				# ---------------------------
			}
			if($vs_additional_md){
				$vs_additional_md = "<div class='collChildMd'>".$vs_additional_md."</div>";
			}
			$vs_output .= "<div style='margin-left:".(40*($vn_level - 1))."px;'>";
			if($vn_level == 1){
				$vs_output .= "<h1>";
			}
			$vs_down_arrow = "";
			if($vs_additional_md && ($vn_level > 1)){
				# --- make show hide for additional md
				#$vs_down_arrow = '<img src="'.$po_request->getThemeDirectoryPath().'/assets/pawtucket/graphics/chevron.jpg" class="chevron">';

			}
			$vs_output .= $vs_down_arrow.$vs_icon." ".$qr_collections->get("ca_collections.preferred_labels");
			if($vn_rel_object_count){
				$vs_output .= " <small>(".$vn_rel_object_count." record".(($vn_rel_object_count == 1) ? "" : "s").")</small>";
			}
			if($vn_level == 1){
				$vs_output .= "</h1>";
			}
			$vs_output .= $vs_additional_md."</div>";
			if(sizeof($va_child_ids)) {
				if($vn_level > 1){
					$vs_output .=  "<div id='children".$qr_collections->get("ca_collections.collection_id")."'><h3 style='margin-left:".(40*($vn_level - 1))."px;'>".$vs_collection_type." Contents</h3>";
				}else{
					$vs_output .=  "<h3 style='margin-left:".(40*($vn_level - 1))."px;'>".$vs_collection_type." Contents</h3>";
				}
				$vs_output .=  printLevelPDF($po_request, $va_child_ids, $o_config, $vn_level + 1, $va_options);
				if($vn_level > 1){
					$vs_output .=  "</div>";
				}
			}
		}
	}
	return $vs_output;
}
?>