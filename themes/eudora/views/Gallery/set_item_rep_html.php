<?php
	$pn_previous_item_id = $this->getVar("previous_item_id");
	$pn_next_item_id = $this->getVar("next_item_id");
	$pn_set_id = $this->getVar("set_id");
	$pn_row_id = $this->getVar("row_id");
	$ps_table = $this->getVar("table");
	$t_object = new ca_objects($pn_row_id);
	
	$va_access_values = caGetUserAccessValues($this->request);
	$t_list = new ca_lists();
	$vn_obverse_type_id = $t_list->getItemIDFromList("object_representation_types", "obverse");
	$vn_reverse_type_id = $t_list->getItemIDFromList("object_representation_types", "reverse");
		
	# --- get representations
	$va_reps_obverse = $t_object->getRepresentations(array("large"), null, array("restrictToTypes" => array("obverse"), "checkAccess" => $va_access_values));
	$va_reps_reverse = $t_object->getRepresentations(array("large"), null, array("restrictToTypes" => array("reverse"), "checkAccess" => $va_access_values));
	$va_reps = array();
	if(is_array($va_reps_obverse) && sizeof($va_reps_obverse)){
		foreach($va_reps_obverse as $vn_rep_id => $va_rep_info){
			$va_reps[$vn_rep_id] = array("media" => $va_rep_info["tags"]["large"], "type" => "Obverse");
		}
	}
	if(is_array($va_reps_reverse) && sizeof($va_reps_reverse)){
		foreach($va_reps_reverse as $vn_rep_id => $va_rep_info){
			$va_reps[$vn_rep_id] = array("media" => $va_rep_info["tags"]["large"], "type" => "Reverse");
		}
	}


	if($pn_previous_item_id){
		print "<a href='#' class='galleryDetailPrevious' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pn_previous_item_id, 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pn_previous_item_id, 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pn_previous_item_id."\"); return false;'><i class='fa fa-angle-left'></i></a>";
	}else{
		print "<a href='#' class='galleryDetailPrevious inactive' onClick='return false;'><i class='fa fa-angle-left'></i></a>";
	}
	if($pn_next_item_id){
		print "<a href='#' class='galleryDetailNext' onclick='jQuery(\"#galleryDetailImageArea\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemRep', array('item_id' => $pn_next_item_id, 'set_id' => $pn_set_id))."\"); jQuery(\"#galleryDetailObjectInfo\").load(\"".caNavUrl($this->request, '', 'Gallery', 'getSetItemInfo', array('item_id' => $pn_next_item_id, 'set_id' => $pn_set_id))."\"); galleryHighlightThumbnail(\"galleryIcon".$pn_next_item_id."\"); return false;'><i class='fa fa-angle-right'></i></a>";
	}else{
		print "<a href='#' class='galleryDetailNext inactive' onClick='return false;'><i class='fa fa-angle-right'></i></a>";
	}
	#print "<div id='galleryDetailImageWrapper'>".caDetailLink($this->request, $this->getVar("rep"), '', $ps_table,  $this->getVar("row_id")).$this->getVar("repToolBar")."</div>";	


	$t_rep = new ca_object_representations();
	$vn_col = 0;
	foreach($va_reps as $vn_rep_id => $va_rep){
		if($vn_col == 0){
			print "<div class='row detailMedia'>\n";
		}
		print "<div class='col-xs-6 col-sm-5".(($vn_col == 0) ? " col-sm-offset-1" : "")."'>";
		$t_rep->load($vn_rep_id);
		print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, "Detail", "GetMediaOverlay", null, array("id" => $t_object->get("object_id"), "representation_id" => $vn_rep_id, "display" => "detail", "context" => "coins", "overlay" => 1))."\"); return false;'>".$va_rep["media"]."</a>";
		print "<div class='detailMediaCaption'>".$va_rep["type"]."</div>";
		print caRepToolbar($this->request, $t_rep, $t_object, array("display" => "detail", "context" => "coins"));
		print "</div>\n";
		if($vn_col == 1){
			$vn_col = 0;
			print "</div><!-- end row-->\n";
		}else{
			$vn_col++;
		}
	}
	if($vn_col > 0){
		print "</div><!-- end row-->\n";
	}
?>