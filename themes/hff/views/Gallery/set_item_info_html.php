<?php
	$va_access_values = caGetUserAccessValues($this->request);	
	$t_item = $this->getVar("instance");
	$t_list_item = new ca_list_items();

	#print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>";
	
	$t_list_item->load($t_item->get("type_id"));
	$vs_typecode = $t_list_item->get("idno");
	
	$vs_idno_detail_link = "";
	$vs_label_detail_link = "";
	
	$vs_table = "ca_objects";
	$vn_id = $t_item->get("ca_objects.object_id");
	print "<H4>";
	switch($vs_typecode){
		case "literature":
			$vs_tmp = $t_item->get("ca_objects.lit_citation");
			print  ($vs_tmp) ? $vs_tmp : "No citation available.  Title:".$t_item->get("ca_objects.preferred_labels");
			# --- link to associated artworks -> do not link to literature detail page
			$va_rel_objects = $t_item->get("ca_objects.related", array("returnAsArray" => true, "restrictToTypes" => array("artwork", "art_HFF", "art_nonHFF", "edition", "edition_HFF", "edition_nonHFF"), array("checkAccess" => $va_access_values)));
			if(is_array($va_rel_objects) && sizeof($va_rel_objects)){
				print "<br/>".caNavLink($this->request, _t("View Related Artworks"), "", "", "browse", "artworks", array("facet" => "reference_facet", "id" => $t_item->get("ca_occurrences.occurrence_id")));
			}
		break;
		# ------------------------
		case "archival":
			print "<small>".caDetailLink($this->request, $t_item->get("ca_objects.idno"), '', $vs_table, $vn_id)."</small><br/>";
			print caDetailLink($this->request, $t_item->get("ca_objects.preferred_labels"), '', $vs_table, $vn_id).(($t_item->get("ca_objects.unitdate.dacs_date_text")) ? ", ".$t_item->get("ca_objects.unitdate.dacs_date_text") : "");
			$vs_tmp = $t_item->getWithTemplate("<unit relativeTo='ca_collections' delimiter=', '><l>^ca_collections.preferred_labels</l></unit>", array("checkAccess" => $va_access_values));				
			if($vs_tmp){
				print "<br/>Part of: ".$vs_tmp;
			}
		break;
		# ------------------------
		case "artwork":
		case "art_HFF":
		case "art_nonHFF":
		case "edition":
		case "edition_HFF":
		case "edition_nonHFF":
			print "<small>".caDetailLink($this->request, $t_item->get("ca_objects.idno"), '', $vs_table, $vn_id)."</small><br/>";
			print caDetailLink($this->request, italicizeTitle($t_item->get("ca_objects.preferred_labels")), '', $vs_table, $vn_id).(($t_item->get("ca_objects.common_date")) ? ", ".$t_item->get("ca_objects.common_date") : "");
		break;
		# ------------------------
		case "library":
			# --- no idno link
			# --- title, author, publisher, year, library, LC classification, Tags, Public Note
			$va_tmp = array();
			if($vs_tmp = $t_item->get("ca_objects.preferred_labels")){
				$va_tmp[] = $vs_tmp;
			}
			if($vs_tmp = $t_item->get("ca_objects.author.author_name", array("delimiter" => ", "))){
				$va_tmp[] = $vs_tmp;
			}
			if($vs_tmp = $t_item->getWithTemplate("<unit relativeTo='ca_entities' restrictToRelationshipTypes='publisher' delimiter=', '>^ca_entities.preferred_labels</unit>", array("checkAccess" => $va_access_values))){
				$va_tmp[] = $vs_tmp;
			}elseif($vs_tmp = $t_item->get("ca_objects.publisher", array("delimiter" => ", "))){
				$va_tmp[] = $vs_tmp;
			}
			if($vs_tmp = $t_item->get("ca_objects.common_date", array("delimiter" => ", "))){
				$va_tmp[] = $vs_tmp;
			}
			if($vs_tmp = $t_item->get("ca_objects.library", array("delimiter" => ", ", "convertCodesToDisplayText" => true))){
				$va_tmp[] = $vs_tmp;
			}
			if($vs_tmp = $t_item->get("ca_objects.call_number", array("delimiter" => ", "))){
				$va_tmp[] = $vs_tmp;
			}
			if($vs_tmp = $t_item->get("ca_objects.artwork_status", array("delimiter" => ", ", "convertCodesToDisplayText" => true))){
				$va_tmp[] = $vs_tmp;
			}
			if($vs_tmp = $t_item->get("ca_objects.remarks", array("delimiter" => ", "))){
				$va_tmp[] = $vs_tmp;
			}
			print caDetailLink($this->request, join(", ", $va_tmp), '', $vs_table, $vn_id);
		
		break;
		# ------------------------
	}
	print "</H4>";
	
	

	print "<br/><br/>".caDetailLink($this->request, _t("VIEW RECORD"), 'btn-default', $this->getVar("table"),  $this->getVar("row_id")); 
	
?>