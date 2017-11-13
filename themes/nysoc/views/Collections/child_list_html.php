<?php
	$va_access_values = $this->getVar("access_values");
	$o_collections_config = $this->getVar("collections_config");
	$vs_desc_template = $o_collections_config->get("description_template");
	$t_item = $this->getVar("item");
	$vn_collection_id = $this->getVar("collection_id");
	$va_exclude_collection_type_ids = $this->getVar("exclude_collection_type_ids");
	$va_non_linkable_collection_type_ids = $this->getVar("non_linkable_collection_type_ids");
	$va_collection_type_icons = $this->getVar("collection_type_icons");
	
	$t_list = new ca_lists();
	$va_collection_types = array(
		"collection" => $t_list->getItemIDFromList("collection_types", "collection"),
		"record_group" => $t_list->getItemIDFromList("collection_types", "record_group"),
		"series" => $t_list->getItemIDFromList("collection_types", "series"),
		"subseries" => $t_list->getItemIDFromList("collection_types", "subseries"),
		"file" => $t_list->getItemIDFromList("collection_types", "file"),
		"box" => $t_list->getItemIDFromList("collection_types", "box"),
		"folder" => $t_list->getItemIDFromList("collection_types", "folder")
	);

function printLevel($po_request, $va_collection_ids, $o_config, $vn_level, $va_options = array()) {
	if($o_config->get("max_levels") && ($vn_level > $o_config->get("max_levels"))){
		return;
	}
	$va_access_values = caGetUserAccessValues($po_request);
	$vs_output = "";
	$vs_desc_template = $o_config->get("description_template");
	$qr_collections = caMakeSearchResult("ca_collections", $va_collection_ids);
	$o_search = caGetSearchInstance("ca_objects");
	if($qr_collections->numHits()){
		while($qr_collections->nextHit()) {
			$vs_icon = "";
			# --- related objects?
			#$vn_rel_object_count = sizeof($qr_collections->get("ca_objects.object_id", array("returnAsArray" => true, 'checkAccess' => $va_access_values)));
			$qr_res = $o_search->search("ca_collections.collection_id:".$qr_collections->get("collection_id"), array("sort" => "ca_object_labels.name", "sort_direction" => "desc", "checkAccess" => $va_access_values));
			$vn_rel_object_count = $qr_res->numHits();

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
			$vs_dates = "";
			if ($qr_collections->get('ca_collections.unitdate.date_value')) {
				$vs_dates = "<div class='collDates'>".$qr_collections->get('ca_collections.unitdate', array('convertCodesToDisplayText' => true, 'template' => '<unit><ifdef code="ca_collections.unitdate.dates_types"><span class="collectionLabel">^ca_collections.unitdate.dates_types:</span> </ifdef>^ca_collections.unitdate.date_value', 'delimiter' => '<br/>'))."</div>";
			}
					
			# ----- metadata based on collection record type --- this matches what is displayed in the collection detail page
			$vs_additional_md = "";
			switch($qr_collections->get("ca_collections.type_id")){
				case $va_collection_types['record_group']:
				case $va_collection_types['series']:
					#if ($qr_collections->get('ca_collections.unitdate.date_value')) {
					#	$vs_additional_md.= "<div class='unit'>".$qr_collections->get('ca_collections.unitdate', array('convertCodesToDisplayText' => true, 'template' => '<unit><span class="collectionLabel">^ca_collections.unitdate.dates_types:</span> ^ca_collections.unitdate.date_value', 'delimiter' => '<br/>'))."</div>";
					#}
					if ($vs_extent = $qr_collections->get('ca_collections.extentDACS')) {
						$vs_additional_md.= "<div class='unit'><span class='collectionLabel'>Extent: </span>".$vs_extent."</div>";
					}
					if ($vs_container = $qr_collections->get('ca_collections.archival_container')) {
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
						$vs_additional_md.= "<h3>Subjects:</h3>";
						$vs_additional_md.= "<div class='unit'>";
						$vs_additional_md.= join('<br/>',$va_subject_list);
						$vs_additional_md.= "</div>";
					}
			
				break;
				# ---------------------------
				case $va_collection_types['subseries']:
					#if ($qr_collections->get('ca_collections.unitdate.date_value')) {
					#	$vs_additional_md.= "<div class='unit'>".$qr_collections->get('ca_collections.unitdate', array('convertCodesToDisplayText' => true, 'template' => '<unit><span class="collectionLabel">^ca_collections.unitdate.dates_types:</span> ^ca_collections.unitdate.date_value', 'delimiter' => '<br/>'))."</div>";
					#}
					if ($vs_extent = $qr_collections->get('ca_collections.extentDACS')) {
						$vs_additional_md.= "<div class='unit'><span class='collectionLabel'>Extent: </span>".$vs_extent."</div>";
					}
					if ($vs_container = $qr_collections->get('ca_collections.archival_container')) {
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
					#if ($qr_collections->get('ca_collections.unitdate.date_value')) {
					#	$vs_additional_md.= "<div class='unit'>".$qr_collections->get('ca_collections.unitdate', array('convertCodesToDisplayText' => true, 'template' => '<unit><ifdef code="ca_collections.unitdate.dates_types"><span class="collectionLabel">^ca_collections.unitdate.dates_types:</span> </ifdef>^ca_collections.unitdate.date_value', 'delimiter' => '<br/>'))."</div>";
					#}
					# --- folder note with no heading
					if ($vs_extent = $qr_collections->get('ca_collections.extentDACS')) {
						$vs_additional_md.= "<div class='unit'><span class='collectionLabel'>Extent: </span>".$vs_extent."</div>";
					}
					if ($vs_container = $qr_collections->get('ca_collections.archival_container')) {
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
			if($vs_rel_objects = $qr_collections->getWithTemplate('<unit relativeTo="ca_objects" delimiter="<br/>"><l><i class="fa fa-object-group orange"></i> ^ca_objects.preferred_labels.name</l></unit>')){
				$vs_additional_md.= "<div class='unit'>".$vs_rel_objects."</div>";
			}
			if($vs_additional_md){
				if($vn_level > 1){
					$vs_additional_md = "<div id='md".$qr_collections->get("ca_collections.collection_id")."' class='collChildMd' style='display:none;'>".$vs_additional_md."</div>";
				}else{
					$vs_additional_md = "<div class='collChildMd'>".$vs_additional_md."</div>";
				}
			}
			

			$vs_output .= "<div style='margin-left:".(40*($vn_level - 1))."px;' class='collListItem'>";
			# --- should collection record be a link?
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
			if($vn_level == 1){
				$vs_output .= "<div class='label'>";
			}
			#if(($vs_additional_md || sizeof($va_child_ids)) && ($vn_level > 1)){
				# --- make show hide for additional md
			#	$vs_show_hide = '<a href="#" onCLick="$(\'#md'.$qr_collections->get("ca_collections.collection_id").'\').toggle(); $(\'#children'.$qr_collections->get("ca_collections.collection_id").'\').toggle(); return false;" style="margin-left:-18px;"><i class="fa fa-chevron-right" aria-hidden="true"></i></a> ';

			#}
			if($vn_level == 1){
				$vs_output .= caDetailLink($po_request, $vs_icon.' '.$qr_collections->get('ca_collections.preferred_labels'), '', 'ca_collections',  $qr_collections->get("ca_collections.collection_id"), null, array("target" => "_blank"));			
			}elseif(($vs_additional_md || sizeof($va_child_ids) || $vn_rel_object_count) && ($vn_level > 1)){
				$vs_output .= '<a href="#" onCLick="$(\'#md'.$qr_collections->get("ca_collections.collection_id").'\').toggle(); $(\'#children'.$qr_collections->get("ca_collections.collection_id").'\').toggle(); $(\'#chevron'.$qr_collections->get("ca_collections.collection_id").'\').toggleClass(\'fa-chevron-right fa-chevron-down\'); return false;" style="margin-left:-18px;"><i class="fa fa-chevron-right" aria-hidden="true" id="chevron'.$qr_collections->get("ca_collections.collection_id").'"></i> '.$vs_icon.' '.$qr_collections->get('ca_collections.preferred_labels').(($vn_rel_object_count) ? " <i class='fa fa-object-group' title='Portions of the collection have been digitized and are available online. Click to reveal.'></i>" : "").'</a>';
			}else{
				$vs_output .= "<span class='nonLinkedCollection'>".$vs_icon." ".$qr_collections->get("ca_collections.preferred_labels")."</span>";
			}
			if($vb_link){
				$vs_output .= " ".caDetailLink($po_request, (($o_config->get("link_out_icon")) ? $o_config->get("link_out_icon") : "link out"), '', 'ca_collections',  $qr_collections->get("ca_collections.collection_id"), null, array("target" => "_blank"));
			}
			if($vn_level == 1){
				$vs_output .= " <a href='#' onClick='$(\".collChildMd\").show(); $(\".collChildren\").show(); $(\".fa-chevron-right\").switchClass(\"fa-chevron-right\", \"fa-chevron-down\", 0); return false;' title='expand all levels'><i class='fa fa-expand'></i></a>";
			}
			if(($vn_level == 1) && ($vn_rel_object_count)){
				$vs_output .= " <a href='#' onClick='$(\".collChildMd\").show(); $(\".collChildren\").show(); $(\".fa-chevron-right\").switchClass(\"fa-chevron-right\", \"fa-chevron-down\", 0); return false;' title='Portions of the collection have been digitized and are available online. Click to reveal.'><i class='fa fa-object-group'></i></a>";
			}
			if($vn_level == 1){
				$vs_output .= "</div>";
			}
			if($vs_dates){
				$vs_output .= $vs_dates;
			}
			$vs_output .= $vs_additional_md."</div>";
			if(sizeof($va_child_ids)) {
				if($vn_level > 1){
					$vs_output .=  "<div id='children".$qr_collections->get("ca_collections.collection_id")."' style='display:none;' class='collChildren'><H3 style='margin-left:".(40*($vn_level - 1))."px;'>".$vs_collection_type." Contents</H3>";
				}else{
					$vs_output .=  "<H3 style='margin-left:".(40*($vn_level - 1))."px;'>".$vs_collection_type." Contents</H3>";
				}
				$vs_output .=  printLevel($po_request, $va_child_ids, $o_config, $vn_level + 1, $va_options);
				if($vn_level > 1){
					$vs_output .=  "</div>";
				}
			}
		}
	}
	return $vs_output;
}

if ($vn_collection_id) {
 	print printLevel($this->request, array($vn_collection_id), $o_collections_config, 1, array("exclude_collection_type_ids" => $va_exclude_collection_type_ids, "non_linkable_collection_type_ids" => $va_non_linkable_collection_type_ids, "collection_type_icons" => $va_collection_type_icons, "collection_types" => $va_collection_types));
}
if($this->request->getParameter("expandAll", pInteger)){
?>
	<script>
		$(document).ready(function(){
			$(".collChildMd").show();
			$(".collChildren").show();
			$(".fa-chevron-right").switchClass("fa-chevron-right", "fa-chevron-down", 0);
		});
	</script>
<?php
}

?>