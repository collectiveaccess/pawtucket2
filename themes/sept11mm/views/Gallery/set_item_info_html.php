<?php 
	$t_object = $this->getVar("object");
?>
	<H2>{{{ca_objects.preferred_labels.name}}}</H2>
	{{{<ifdef code="ca_objects.idno"><div class="unit"><b>Accession Number:</b> ^ca_objects.idno</unit></ifdef>}}}
	{{{<ifdef code="ca_objects.public_title"><div class="unit"><b>Title:</b> ^ca_objects.public_title</unit></ifdef>}}}
				
<?php
	if($va_sources = $t_object->get("ca_entities", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("donor"), "checkAccess" => caGetUserAccessValues($this->request)))){
		if(is_array($va_sources) && sizeof($va_sources)){
			print "<div class='unit'>";
			print "<b>Source".((sizeof($va_sources) > 1) ? "s" : "").": </b>";
			$va_source_display = array();
			foreach($va_sources as $va_source){
				$va_source_display[] = caNavLink($this->request, $va_source["displayname"], "", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $va_source["entity_id"]));
			}
			print implode(", ", $va_source_display)."</div>";
		}

	}
	if($t_object->get("ca_object_lots.credit_line")){
		print "<div class='unit'><b>Credit Line:</b> <i>".$t_object->get("ca_object_lots.credit_line")."</i></div>";
	}
	if($va_subjects = $t_object->get("ca_list_items", array("returnWithStructure" => true, "restrictToLists" => array("voc_6"), "checkAccess" => caGetUserAccessValues($this->request)))){
	if(is_array($va_subjects) && sizeof($va_subjects)){
		# --- loop through to order alphebeticaly
		$va_subjects_sorted = array();
		foreach($va_subjects as $va_subject){
			$va_subjects_sorted[$va_subject["name_singular"]] = caNavLink($this->request, $va_subject["name_singular"], "", "", "Browse", "objects", array("facet" => "term_facet", "id" => $va_subject["item_id"]));
		}
		ksort($va_subjects_sorted);
		print "<div class='unit'>";
		print "<b>Keyword".((sizeof($va_subjects) > 1) ? "s" : "")."</b><br/>";
		print join($va_subjects_sorted, "<br/>");
		print "</div>";
	}
}
?>
	{{{<ifdef code="ca_objects.public_description"><div class="unit"><b>Description</b><br/>^ca_objects.public_description</unit></ifdef>}}}

<?php print caDetailLink($this->request, _t("VIEW FULL RECORD"), 'btn btn-default', 'ca_objects',  $this->getVar("object_id")); ?>