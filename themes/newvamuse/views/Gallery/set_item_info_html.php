<?php 
	$va_set_item = $this->getVar("set_item");
	$pn_item_id = $this->request->getParameter('item_id', pInteger);
 	$t_set_item = new ca_set_items($pn_item_id);
 	$va_set_item_comments = $t_set_item->getComments();
 	
	$t_object = $this->getVar("object");
	print "(".$this->getVar("set_item_num")."/".$this->getVar("set_num_items").")<br/>"; 
?>
	<h6><?php print $t_object->get("ca_entities", array("restrictToRelationshipTypes" => array("repository"), "returnAsLink" => true, "checkAccess" => $va_access_values));?></h6>
	<H4>{{{ca_objects.preferred_labels.name}}}</H4>
	<HR>
<?php
	print "<div style='max-height:400px; margin-bottom:15px; overflow-y:auto;'>";				
	# --- identifier
	if($t_object->get('idno')){
		print "<div class='unit'><span class='name'>"._t("Accession number").": </span><span class='data'>".$t_object->get('idno')."</span></div>";
	}
	if($va_alt_name = $t_object->get('ca_objects.nonpreferred_labels', array('delimiter' => '<br/>'))){
		print "<div class='unit'><span class='name'>"._t("Alternate Title").": </span><span class='data'>".$va_alt_name."</span></div>";
	}
	# --- parent hierarchy info
	if($t_object->get('parent_id')){
		print "<div class='unit'><span class='name'>"._t("Part Of").":</span><span class='data'> ".caNavLink($this->request, $t_object->get("ca_objects.parent.preferred_labels.name"), '', '', 'Detail', 'objects/'.$t_object->get('parent_id'))."</span></div>";
	}
	# --- category
	if($t_object->get('ns_category')){
		print "<div class='unit'><span class='name'>"._t("Category").": </span><span class='data'>".caNavLink($this->request, $t_object->get('ns_category', array('convertCodesToDisplayText' => true)), "", "", "Browse/objects", "facet/category_facet/id/".$t_object->get('ns_category'))."</span></div>";
	}
	if ($t_object->get('ns_objectType')) {
		print "<div class='unit'><span class='name'>"._t("Object type").": </span><span class='data'>".$t_object->get('ns_objectType')."</span></div>"; 
	}
	if ($t_object->get('ns_objectSubType')) {
		print "<div class='unit'><span class='name'>"._t("Object subtype").": </span><span class='data'>".$t_object->get('ns_objectSubType')."</span></div>"; 
	}				
	if ($va_entities = $t_object->getWithTemplate("<ifcount min='1' relativeTo='ca_objects_x_entities'><div class='unit'><unit relativeTo='ca_objects_x_entities' delimiter='<br/>' excludeRelationshipTypes='repository,source,conservator'><span class='upper name'>^relationship_typename<span>:</span> </span><span class='data'><unit relativeTo='ca_entities'><l>^ca_entities.preferred_labels</l></span></unit></unit></div></ifcount>")){
		print 	$va_entities;
	}
	
	if ($vs_date = $t_object->get('ca_objects.date')) {
		print "<div class='unit'><span class='name'>"._t("Date").": </span><span class='data'>".$vs_date."</span></div>";
	}
	if ($vs_materials = $t_object->get('ca_objects.materials')) {
		print "<div class='unit'><span class='name'>"._t("Materials").": </span><span class='data'>".$vs_materials."</span></div>";
	}
	if ($va_measurements = $t_object->get('ca_objects.measurements', array('returnWithStructure' => true))) {
		$va_meas = array();
		foreach ($va_measurements as $va_key => $va_measurements_t) {
			foreach ($va_measurements_t as $va_key => $va_measurement) {
				if ($va_measurement['dimensions_length']) {
					$va_meas[] = $va_measurement['dimensions_length']." L";
				}
				if ($va_measurement['dimensions_width']) {
					$va_meas[] = $va_measurement['dimensions_width']." W";
				}	
				if ($va_measurement['dimensions_height']) {
					$va_meas[] = $va_measurement['dimensions_height']." H";
				}	
				if ($va_measurement['dimensions_thick']) {
					$va_meas[] = $va_measurement['dimensions_thick']." Thick";
				}
				if ($va_measurement['dimensions_diam']) {
					$va_meas[] = $va_measurement['dimensions_diam']." Diameter";
				}
				if ($va_measurement['dimensions_depth']) {
					$va_meas[] = $va_measurement['dimensions_depth']." Depth";
				}
				if (sizeof($va_meas) > 0 ) {
					print "<div class='unit'><span class='name'>"._t("Measurements").": </span><span class='data'>".join(' x ', $va_meas);
					if ($va_measurement['dimensions_remarks']) {
						print $va_measurement['dimensions_remarks'];
					}
					print "</span></div>";	
				}																																	
			}
		}
	}							
	if ($vs_manuTech = $t_object->get('ca_objects.manuTech')) {
		print "<div class='unit'><span class='name'>"._t("Manufacturing Technique").": </span><span class='data'>".$vs_manuTech."</span></div>";
	}	
	if ($vs_brand = $t_object->get('ca_objects.brand')) {
		print "<div class='unit'><span class='name'>"._t("Brand").": </span><span class='data'>".$vs_brand."</span></div>";
	}
	if ($vs_model = $t_object->get('ca_objects.model')) {
		print "<div class='unit'><span class='name'>"._t("Model").": </span><span class='data'>".$vs_model."</span></div>";
	}
	if ($vs_signature = $t_object->get('ca_objects.signature')) {
		print "<div class='unit'><span class='name'>"._t("Signature").": </span><span class='data'>".$vs_signature."</span></div>";
	}
	if ($vs_marksLabel = $t_object->get('ca_objects.marksLabel')) {
		print "<div class='unit'><span class='name'>"._t("Marks/Label").": </span><span class='data'>".$vs_marksLabel."</span></div>";
	}
	if ($vs_serialNos = $t_object->get('ca_objects.serialNos')) {
		print "<div class='unit'><span class='name'>"._t("Serial Numbers").": </span><span class='data'>".$vs_serialNos."</span></div>";
	}
	if ($vs_patent = $t_object->get('ca_objects.patent')) {
		print "<div class='unit'><span class='name'>"._t("Patent").": </span><span class='data'>".$vs_patent."</span></div>";
	}	
	if ($vs_group = $t_object->get('ca_objects.group')) {
		print "<div class='unit'><span class='name'>"._t("Group").": </span><span class='data'>".$vs_group."</span></div>";
	}
	if ($vs_militUnit = $t_object->get('ca_objects.militUnit')) {
		print "<div class='unit'><span class='name'>"._t("Military Unit").": </span><span class='data'>".$vs_militUnit."</span></div>";
	}
	if ($vs_vesName = $t_object->get('ca_objects.vesName')) {
		print "<div class='unit'><span class='name'>"._t("Vessel Name").": </span><span class='data'>".$vs_vesName."</span></div>";
	}
	if ($vs_culture = $t_object->get('ca_objects.culture')) {
		print "<div class='unit'><span class='name'>"._t("Culture").": </span><span class='data'>".$vs_culture."</span></div>";
	}	
	if ($vs_fondsTitle = $t_object->get('ca_objects.fondsTitle')) {
		print "<div class='unit'><span class='name'>"._t("Fonds Title").": </span><span class='data'>".$vs_fondsTitle."</span></div>";
	}
	if ($vs_series = $t_object->get('ca_objects.series')) {
		print "<div class='unit'><span class='name'>"._t("Series").": </span><span class='data'>".$vs_series."</span></div>";
	}
	if ($vs_subSeries = $t_object->get('ca_objects.subSeries')) {
		print "<div class='unit'><span class='name'>"._t("Subseries").": </span><span class='data'>".$vs_subSeries."</span></div>";
	}
	if ($vs_file = $t_object->get('ca_objects.file')) {
		print "<div class='unit'><span class='name'>"._t("File").": </span><span class='data'>".$vs_file."</span></div>";
	}
	if ($vs_scopeContent = $t_object->get('ca_objects.scopeContent')) {
		print "<div class='unit'><span class='name'>"._t("Scope & Content").": </span><span class='data'>".$vs_scopeContent."</span></div>";
	}
	if ($vs_subject = $t_object->get('ca_objects.subject')) {
		print "<div class='unit'><span class='name'>"._t("Subject").": </span><span class='data'>".$vs_subject."</span></div>";
	}																																																																	
	if($t_object->get("narrative")){
?>
		<div class='unit'><span class='name'><?php print _t("Narrative"); ?>: </span><span class='data'><?php print $t_object->get("narrative", array("convertHTMLBreaks" => true)); ?></span></div>
<?php
	}
	if($t_object->get("description")){
?>
		<div class='unit'><span class='name'><?php print _t("Description"); ?>: </span><span class='data'><?php print $t_object->get("description", array("convertHTMLBreaks" => true)); ?></span></div>
<?php
	}
	if($t_object->get("historyUse")){
?>
		<div class='unit'><span class='name'><?php print _t("History of Use"); ?>: </span><span class='data'><?php print $t_object->get("historyUse", array("convertHTMLBreaks" => true)); ?></span></div>
<?php
	}
	if($t_object->get("cataloguerRem")){
?>
		<div class='unit'><span class='name'><?php print _t("Notes"); ?>: </span><span class='data'><?php print $t_object->get("cataloguerRem", array("convertHTMLBreaks" => true)); ?></span></div>
<?php
	}
	if ($va_manufacturer = $t_object->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => ', ', 'restrictToRelationshipTypes' => 'manufacturer'))) {
		print "<div class='unit'><span class='name'>"._t("Manufacturer").": </span><span class='data'>".$va_manufacturer."</span></div>";
	}
	print "</div>";
	print "<p>".caDetailLink($this->request, _t("VIEW RECORD"), 'btn-default', 'ca_objects',  $this->getVar("object_id"))."</p>"; 

	if(is_array($va_set_item_comments) && sizeof($va_set_item_comments)){
		print "<br/><H6>Comments</H6><div style='max-height:200px; overflow-y:auto;'>";
		foreach($va_set_item_comments as $va_set_item_comment){
			print "<p>".$va_set_item_comment["comment"]."</p>";
		}
		print "</div>";
	}
?>