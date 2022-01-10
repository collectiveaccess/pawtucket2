<?php
	$t_object = $this->getVar("object");
	$t_set_item = $this->getVar("t_set_item");
	$va_access_values = caGetUserAccessValues($this->request);
	$vb_last = $this->getVar("last");
	$vn_theme_id = $this->getVar("theme_id");
	$vs_theme = $this->getVar("theme");
	$t_set = $this->getVar("set");
	$vs_set_type = strToLower($t_set->get("ca_sets.type_id", array("convertCodesToDisplayText" => true)));
	
	$vs_type = $t_object->get('ca_objects.type_id', array("convertCodesToDisplayText" => true));
	print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>";
	if(($vs_set_caption = $t_set_item->get("ca_set_items.preferred_labels")) && ($vs_set_caption != "[BLANK]")){
		print "<div class='unit targetCatch'>".$vs_set_caption."</div>";
	}
	if($vs_set_description = $t_set_item->get("ca_set_items.set_item_description")){
		print "<div class='unit targetCatch'>".$vs_set_description."</div>";
	}
	if(strpos(strToLower($vs_type), "artwork") !== false){
		if ($vs_artist = $t_object->getWithTemplate('<unit relativeTo="ca_entities" delimiter="<br/>"><div class="artistName"><l>^ca_entities.preferred_labels</l></div><div><ifdef code="ca_entities.nationality_text">^ca_entities.nationality_text</ifdef><ifdef code="ca_entities.nationality_text|ca_entities.entity_display_date">, </ifdef><ifdef code="ca_entities.entity_display_date">^ca_entities.entity_display_date</ifdef></div></unit>')) { 
			print "<div>".$vs_artist."</div>";
		}
		print "<div class='spacer'></div>";
		print "<div class='artTitle'>";
		if ($t_object->get('ca_objects.preferred_labels') == "Untitled") {
			print $t_object->get('ca_objects.preferred_labels');
		} else {
			print "<i>".$t_object->get('ca_objects.preferred_labels')."</i>";
		}
		if ($va_date = $t_object->get('ca_objects.display_date')) {
			print ", ".$va_date;
		}
		print "</div>";
		if ($va_medium = $t_object->get('ca_objects.medium')) {
			print "<div>".$va_medium."</div>";
		}
		if ($vs_dimensions = $t_object->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_objects.dimensions">^ca_objects.dimensions.display_dimensions <ifdef code="ca_objects.dimensions.dimensions_type">(^ca_objects.dimensions.dimensions_type)</ifdef></unit>')) {
			print "<div>".$vs_dimensions."</div>";
		}				
		if ($va_credit = $t_object->get('ca_objects.credit_line')) {
			print "<div>".$va_credit."</div>";
		}	
		print "<div class='spacer'></div>";	
		if ($va_photo_credit = $t_object->get('ca_object_representations.caption')) {
			print "<div>".$va_photo_credit."</div>";
		}
		if ($va_photo_copyright = $t_object->get('ca_object_representations.caption_copyright')) {
			print "<div>".$va_photo_copyright."</div>";  
		}	
		if ($va_photo_name = $t_object->getWithTemplate('<unit relativeTo="ca_object_representations"><unit relativeTo="ca_entities" restrictToRelationshipTypes="photographer">^ca_entities.preferred_labels</unit></unit>')) {
			print "<div>Photo by ".$va_photo_name."</div>";
		}
	}
	if(($t_set->get("ca_sets.set_code") != "2020.1") && (strpos(strToLower($vs_type), "archival") !== false)){
		print "<div id='featuredShowMoreLink' class='viewAll'><a href='#' onClick='$(\"#featuredShowMore\").toggle(); $(\"#featuredShowMoreLink\").toggle(); return false;'>+ Show More</a></div>";
		print "<div id='featuredShowMore' style='display:none;'>";
		$vs_record_title = $t_object->get('ca_objects.preferred_labels.name');
		print "<div class='artTitle'>";
		if ($vs_record_title != "Untitled") {
			print "<i>".$vs_record_title."</i>";
		} else {
			print $vs_record_title;
		}
		if ($vs_date = $t_object->get('ca_objects.display_date')) {
			print ", ".$vs_date;
		}				
		print "</div>";
		
		if ($vs_date = $t_object->getWithTemplate('<unit relativeTo="ca_objects.unitdate" delimiter="<br/>"><ifdef code="ca_objects.unitdate.dacs_date_value">^ca_objects.unitdate.dacs_date_value<ifdef code="ca_objects.unitdate.dacs_dates_types"> (^ca_objects.unitdate.dacs_dates_types)</ifdef></ifdef></unit>')) {
			print "<div class='unit'><h6>Date</h6>".$vs_date."</div>";
		}
		if ($vs_extent = $t_object->get('ca_objects.extentDACS')) {
			print "<div class='unit'><h6>Extent</h6>".$vs_extent."</div>";
		}
		if ($va_medium = $t_object->get('ca_objects.medium')) {
			print "<div class='unit'><h6>Medium</h6>".$va_medium."</div>";
		}
		if ($vs_dimensions = $t_object->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_objects.dimensions"><ifdef code="ca_objects.dimensions.display_dimensions">^ca_objects.dimensions.display_dimensions <ifdef code="ca_objects.dimensions.dimensions_type">(^ca_objects.dimensions.dimensions_type)</ifdef></ifdef></unit>')) {
			print "<div class='unit'><h6>Dimensions</h6>".$vs_dimensions."</div>";
		}
		if ($va_creator = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('creator'), 'returnAsArray' => true, 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
			print "<div class='unit'><h6>Creator".((sizeof($va_creator) > 1) ? "s" : "")."</h6>".join("<br/>", $va_creator)."</div>";
		}
		if($vn_rep_id = $t_object->get("ca_object_representations.representation_id", array("checkAccess" => $va_access_values))){
			$t_rep = new ca_object_representations($vn_rep_id);
			if($t_rep){
				if ($vs_photographer = $t_rep->get('ca_entities.preferred_labels', array('checkAccess' => $va_access_values, 'delimiter' => '<br/>', 'restrictToRelationshipTypes' => array('photographer')))) {
					print "<div class='unit'><h6>Photographer</h6>".$vs_photographer."</div>";
				}
				if ($vs_credit = $t_rep->get('ca_object_representations.caption')) {
					print "<div class='unit'><h6>Image Credit Line</h6>".$vs_credit."</div>";
				}
				if ($va_photo_copyright = $t_rep->get('ca_object_representations.caption_copyright')) {
					print "<div class='unit'><h6>Copyright</h6>".$va_photo_copyright."</div>";   
				}
			}
		}
		if ($vs_conditions_access = $t_object->get('ca_objects.accessrestrict')) {
			print "<div class='unit'><h6>Conditions Governing Access</h6>".$vs_conditions_access."</div>";
		}
		if ($vs_conditions_repro = $t_object->get('ca_objects.reproduction')) {
			print "<div class='unit'><h6>Conditions Governing Reproduction</h6>".$vs_conditions_repro."</div>";
		}
		print "<div class='viewAll' id='featuredShowLessLink'><a href='#' onClick='$(\"#featuredShowMore\").toggle(); $(\"#featuredShowMoreLink\").toggle(); return false;'>+ Show Less</a></div>";
		print "</div>";																								
																							
	
	}
	if($vs_set_type == "public presentation"){
		print "<div class='viewAll'>".caDetailLink($this->request, _t("View Record").' <i class="fa fa-angle-right"></i>', '', $this->getVar("table"),  $this->getVar("row_id"))."</div>";
	}
	print "<div class='viewAll'>";
	if($vn_theme_id){
		print caNavLink($this->request, "All ".$vs_theme." <i class='fa fa-angle-right'></i>", "", "", "Featured", "Theme", array("theme_id" => $vn_theme_id))."&nbsp;&nbsp;&nbsp;";
	}
	if($vs_set_type == "public presentation"){
		print caNavLink($this->request, "Home <i class='fa fa-angle-right'></i>", "", "", "Featured", "Index");
	}else{
		print caNavLink($this->request, "Home <i class='fa fa-angle-right'></i>", "", "", "Featured", "Archives");
	}
	print "</div>";
?>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$(".targetCatch a").attr("target", "_BLANK");
	});
	
</script>