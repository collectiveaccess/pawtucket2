<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/ca_collections_summary.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Collection Finding Aid
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_collections
 * @marginTop 0.75in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.75in
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	
	$va_fields = array(
		"Classification" => "^ca_collections.col_classification%delimiter=,_",
		#"Unit ID" => "^ca_collections.unit_id%delimiter=,_",
		"Container ID" => "^ca_collections.container_id",
		"Dates" => "<ifdef code='ca_collections.display_date'>^ca_collections.display_date%delimiter=,_</ifdef><ifnotdef code='ca_collections.display_date'><ifdef code='ca_collections.inclusive_dates'>^ca_collections.inclusive_dates%delimiter=,_</ifdef></ifnotdef>",
		"Additional Date Information" => "^ca_collections.date_info",
		"Material Type" => "^ca_collections.material_type%delimiter=,_",
		"Format" => "^ca_collections.format%delimiter=,_",
		"Contains Object Type" => "^ca_collections.contains_object_type%delimiter=,_",
		"Extent" => "<ifdef code='ca_collections.item_extent.extent_value'>^ca_collections.item_extent.extent_value </ifdef>^ca_collections.item_extent.extent_unit<ifdef code='ca_collections.item_extent.extent_value|ca_collections.item_extent.extent_unit'><br/></ifdef>^ca_collections.item_extent.extent_note",
		"Finding Aid Author" => "^ca_collections.finding_aid_author",
		"Related Creators" => "<ifcount code='ca_entities' restrictToRelationshipTypes='creator,primary_creator'><unit relativeTo='ca_entities' restrictToRelationshipTypes='creator,primary_creator' delimiter='<br/>'><if rule='^ca_entities.added_on_import =~ /Yes/'>^ca_entities.preferred_labels.displayname (^relationship_typename)</if><if rule='^ca_entities.added_on_import !~ /Yes/'>^ca_entities.preferred_labels.displayname (^relationship_typename)</if></unit></ifcount>",
		"Related People and Organizations" => "<ifcount code='ca_entities' restrictToRelationshipTypes='photographers,related,contributor'><unit relativeTo='ca_entities' restrictToRelationshipTypes='photographers,related,contributor' delimiter='<br/>'><if rule='^ca_entities.added_on_import =~ /Yes/'>^ca_entities.preferred_labels.displayname (^relationship_typename)</if><if rule='^ca_entities.added_on_import !~ /Yes/'>^ca_entities.preferred_labels.displayname (^relationship_typename)</if></unit></ifcount>",
		"Related Collections" => "<ifcount code='ca_collections.related' min='1'><unit relativeTo='ca_collections.related' delimiter='<br/>'>^ca_collections.type_id ^ca_collections.id_number<if rule='^ca_collections.preferred_labels.name !~ /BLANK/'>: ^ca_collections.preferred_labels</if><ifdef code='ca_collections.display_date'>, ^ca_collections.display_date%delimiter=,_</ifdef><ifnotdef code='ca_collections.display_date'><ifdef code='ca_collections.inclusive_dates'>, ^ca_collections.inclusive_dates%delimiter=,_</ifdef></ifnotdef></unit></ifcount>",
		"URL" => "<ifdef code='ca_collections.url.link_url'><unit relativeTo='ca_collections.url' delimiter='<br/>'><a href='^ca_collections.url.link_url' target='_blank'><ifdef code='ca_collections.url.link_text'>^ca_collections.url.link_text</ifdef><ifnotdef code='ca_collections.url.link_text'>^ca_collections.url.link_url</ifnotdef></a></unit></ifdef>",
		"Notes" => "^ca_collections.notes%delimiter=,_",
		"Scope and Content" => "<ifdef code='ca_collections.scope_content'><span class='trimText'>^ca_collections.scope_content</span></ifdef>",
		"System of Arrangement" => "^ca_collections.arrangement",
		"Biographical/Historical Note" => "^ca_collections.admin_bio_hist",
		"Biographical/Historical Note Author" => "^ca_collections.admin_bio_hist_auth",
		"Language" => "^ca_collections.language%delimiter=,_",
		"Event Type" => "^ca_collections.event_type%delimiter=,_",
		"Physical Description" => "^ca_collections.physical_description",
		"Conditions Governing Access" => "^ca_collections.accessrestrict",
		"Conditions Governing Reproduction and Use" => "^ca_collections.reproduction_conditions",
		"Physical Access" => "^ca_collections.physaccessrestrict",
		"Technical Access" => "^ca_collections.techaccessrestrict",
		"Related Materials" => "<ifdef code='ca_collections.related_materials'><span class='trimText'>^ca_collections.related_materials</span></ifdef>",
		"Related Materials URL" => "^ca_collections.related_materials_url",
		"Related Publications" => "^ca_collections.related_publications",
		"Separated Materials" => "^ca_collections.separated_materials",
		"Existence and Location of Originals/Copies" => "^ca_collections.copies_originals",
		"Originals/Copies URL" => "^ca_collections.copies_originals_url",
		"Preferred Citation" => "^ca_collections.citation",
		"Library of Congress Subject Headings" => "^ca_collections.lcsh_terms%delimiter=,_",
		"Key Terms" => "^ca_collections.key_terms",
		"Subjects" => "^ca_collections.local_subjects%delimiter=,_",
		"People Depicted" => "^ca_collections.people_depicted"
	);
?>
	<div class="title">
		<h1 class="title">Carleton College Archives<br/><?php print $t_item->getWithTemplate("^ca_collections.type_id ^ca_collections.id_number<if rule='^ca_collections.preferred_labels.name !~ /BLANK/'>: ^ca_collections.preferred_labels</if><ifdef code='ca_collections.display_date'>, ^ca_collections.display_date%delimiter=,_</ifdef><ifnotdef code='ca_collections.display_date'><ifdef code='ca_collections.inclusive_dates'>, ^ca_collections.inclusive_dates%delimiter=,_</ifdef></ifnotdef>");?></h1>
	</div>
		
	<div class="unit">
	{{{<ifdef code="ca_collections.parent_id"><div class="unit"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></H6></ifdef>}}}
	</div>
<?php
		foreach($va_fields as $vs_label => $vs_template){
			if($vs_tmp = $t_item->getWithTemplate($vs_template, array("checkAccess" => $va_access_values))){
				print "<div class='unit'><H6>".$vs_label."</H6>".caConvertLineBreaks($vs_tmp)."</div>";
			}
		}
?>
	
	
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><br/>Collection Contents";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
	}
	print $this->render("pdfEnd.php");
?>
