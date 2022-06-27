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
	$va_access_values = caGetUserAccessValues($this->request);	
	$t_list = new ca_lists();
	$vn_collection_type_id = $t_list->getItemIDFromList("collection_types", "collection");
	$vn_series_type_id = $t_list->getItemIDFromList("collection_types", "series");
	$vn_subgroup_type_id = $t_list->getItemIDFromList("collection_types", "record_group");
	$vn_subseries_type_id = $t_list->getItemIDFromList("collection_types", "subseries");
	$vn_folder_type_id = $t_list->getItemIDFromList("collection_types", "folder");

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	
		$vs_collection_desc_template = 	'<div class="title">
									<br/><br/><h1 class="title"><ifdef code="ca_collections.fa_title">^ca_collections.fa_title</ifdef><ifnotdef code="ca_collections.fa_title">^ca_collections.preferred_labels</ifnotdef></h1>
								</div>
								<H7>Summary</H7>
								<div class="unit">^ca_collections.idno</div>	
								<ifdef code="ca_collections.unitdate.dacs_date_text"><div class="unit">Date: ^ca_collections.unitdate.dacs_date_text</div></ifdef>
	
								<ifdef code="ca_collections.extentDACS.extent_number|ca_collections.extentDACS.extent_type|ca_collections.extentDACS.container_summary|ca_collections.extentDACS.physical_details|ca_collections.extentDACS.extent_dimensions">
									<div class="unit">
										Extent:
										<unit relativeTo="ca_collections">
										<ifdef code="ca_collections.extentDACS.extent_number">^ca_collections.extentDACS.extent_number </ifdef><ifdef code="ca_collections.extentDACS.extent_type">^ca_collections.extentDACS.extent_type</ifdef>
										<ifdef code="ca_collections.extentDACS.container_summary"><br/>Container Summary: ^ca_collections.extentDACS.container_summary</ifdef>
										<ifdef code="ca_collections.extentDACS.physical_details"><br/>Physical Details: ^ca_collections.extentDACS.physical_details</ifdef>
										<ifdef code="ca_collections.extentDACS.extent_dimensions"><br/>Dimensions: ^ca_collections.extentDACS.extent_dimensions</ifdef>
										</div>
									</div>
								</ifdef>
								<ifdef code="ca_collections.fa_language"><div class="unit">Language of Description: ^ca_collections.fa_language</div></ifdef>
								<ifdef code="ca_collections.abstract"><div class="unit"><H6>Abstract</H6>^ca_collections.abstract</div></ifdef>
	
								<ifdef code="ca_collections.adminbiohist|ca_collections.scopecontent|ca_collections.arrangement|ca_collections.originalsloc|ca_collections.altformavail|ca_collections.general_notes|ca_collections.physical_description|ca_collections.physfacet|ca_collections.langmaterial"><H7>Description</H7></ifdef>
								<ifdef code="ca_collections.adminbiohist"><div class="unit"><H6>Administrative/Biographical History</H6>^ca_collections.adminbiohist</div></ifdef>
								<ifdef code="ca_collections.scopecontent"><div class="unit"><H6>Scope and Content</H6>^ca_collections.scopecontent</div></ifdef>
								<ifdef code="ca_collections.arrangement"><div class="unit"><H6>Arrangement</H6>^ca_collections.arrangement</div></ifdef>
								<ifdef code="ca_collections.originalsloc"><div class="unit"><H6>Existence of Originals</H6>^ca_collections.originalsloc</div></ifdef>
								<ifdef code="ca_collections.altformavail"><div class="unit"><H6>Existence of Copies</H6>^ca_collections.altformavail</div></ifdef>
								<ifdef code="ca_collections.general_notes"><div class="unit"><H6>General Notes</H6>^ca_collections.general_notes</div></ifdef>
								<ifdef code="ca_collections.physical_description"><div class="unit"><H6>Physical Description</H6>^ca_collections.physical_description</div></ifdef>
								<ifdef code="ca_collections.physfacet"><div class="unit"><H6>Physical Facet</H6>^ca_collections.physfacet</div></ifdef>
								<ifdef code="ca_collections.langmaterial"><div class="unit"><H6>Languages and Scripts on the Materials</H6>^ca_collections.langmaterial</div></ifdef>
	
								<ifdef code="ca_collections.loc_agent.loc_agent_value|ca_collections.fa_sponsor|ca_collections.fa_description_rules|ca_collections.fa_date|ca_collections.fa_author|ca_collections.preferCite|ca_collections.publication_note|ca_collections.otherfindingaid|ca_collections.separated_materials|ca_collections.relation|ca_collections.separated_materials|ca_collections.relation|ca_collections.related_materials|ca_collections.processInfo|ca_collections.processInfo|ca_collections.appraisal|ca_collections.custodhist|ca_collections.acqinfo|ca_collections.techaccessrestrict|ca_collections.physloc|ca_collections.physaccessrestrict|ca_collections.govtuse|ca_collections.accessrestrict"><H7>Administration</H7></ifdef>
								<ifdef code="ca_collections.accessrestrict"><div class="unit"><H6>Conditions Governing Access</H6>^ca_collections.accessrestrict</div></ifdef>
								<ifdef code="ca_collections.govtuse"><div class="unit"><H6>Conditions Governing Use</H6>^ca_collections.govtuse</div></ifdef>
								<ifdef code="ca_collections.physaccessrestrict"><div class="unit"><H6>Physical Access</H6>^ca_collections.physaccessrestrict</div></ifdef>
								<ifdef code="ca_collections.physloc"><div class="unit"><H6>Physical Location</H6>^ca_collections.physloc</div></ifdef>
								<ifdef code="ca_collections.techaccessrestrict"><div class="unit"><H6>Technical Access</H6>^ca_collections.techaccessrestrict</div></ifdef>
								<ifdef code="ca_collections.acqinfo"><div class="unit"><H6>Provenance</H6>^ca_collections.acqinfo</div></ifdef>
								<ifdef code="ca_collections.processInfo"><div class="unit"><H6>Processing Information</H6>^ca_collections.processInfo</div></ifdef>
								<ifdef code="ca_collections.related_materials"><div class="unit"><H6>Related Materials</H6>^ca_collections.related_materials</div></ifdef>
								<ifdef code="ca_collections.separated_materials"><div class="unit"><H6>Separated Materials</H6>^ca_collections.separated_materials</div></ifdef>
								<ifdef code="ca_collections.otherfindingaid"><div class="unit"><H6>Other Finding Aids</H6>^ca_collections.otherfindingaid</div></ifdef>
								
								<ifdef code="ca_collections.physfacet"><div class="unit"><H6>Physical Facet</H6><unit delimiter="<br/>">^ca_collections.physfacet</unit></div></ifdef>
								<ifdef code="ca_collections.separated_materials"><div class="unit"><H6>Separated Materials</H6><unit delimiter="<br/>">^ca_collections.separated_materials</unit></div></ifdef>
								<ifdef code="ca_collections.general_notes"><div class="unit"><H6>General Note</H6><unit delimiter="<br/>">^ca_collections.general_notes</unit></div></ifdef>
					
								<ifdef code="ca_collections.preferCite"><div class="unit"><H6>Preferred Citation</H6>^ca_collections.preferCite</div></ifdef>
								<ifdef code="ca_collections.fa_date|ca_collections.fa_author"><div class="unit"><H6>Finding Aid Created</H6>^ca_collections.fa_author<ifdef code="ca_collections.fa_date,ca_collections.fa_author">, ^ca_collections.fa_date</ifdef></div></ifdef>
								<ifdef code="ca_collections.fa_description_rules"><div class="unit"><H6>Description Rules</H6>^ca_collections.fa_description_rules</div></ifdef>
								<ifdef code="ca_collections.fa_sponsor"><div class="unit"><H6>Sponsor</H6>^ca_collections.fa_sponsor</div></ifdef>';

		$vs_series_subseries_desc_template = '<div class="title">
												<br/><br/><h1 class="title">^ca_collections.preferred_labels<ifdef code="ca_collections.unitdate.dacs_date_text">, ^ca_collections.unitdate.dacs_date_text</ifdef></h1>
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

		$vs_subgroup_desc_template = '<div class="title">
											<br/><br/><h1 class="title">^ca_collections.preferred_labels</h1>
										</div>';
		# --- folder level description
		$vs_folder_desc_template = '<div class="title">
										<br/><br/><h1 class="title">^ca_collections.preferred_labels<ifdef code="ca_collections.unitdate.dacs_date_text">, ^ca_collections.unitdate.dacs_date_text</ifdef></h1>
									</div>
									<ifcount code="ca_storage_locations">
										<div class="unit">
											<unit relativeTo="ca_storage_locations.related" delimiter="<br/>">^ca_storage_locations.parent.preferred_labels, ^ca_storage_locations.preferred_labels</unit>
										</div>
									</ifcount>
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
									';

?>
<div class="findingAid">
		
<?php
	switch($t_item->get("type_id")){
		case $vn_collection_type_id:
			print $t_item->getWithTemplate($vs_collection_desc_template);
		break;
		# ------------------------------
		case $vn_series_type_id:
		case $vn_subseries_type_id:
			print $t_item->getWithTemplate($vs_series_subseries_desc_template);
		break;
		# ------------------------------
		case $vn_subgroup_type_id:
			print $t_item->getWithTemplate($vs_subgroup_desc_template);
		break;
		# ------------------------------
		case $vn_folder_type_id:
			print $t_item->getWithTemplate($vs_folder_desc_template);
		break;
		# ------------------------------
	}
set_time_limit(360);
	if ($t_item->get("ca_collections.children.collection_id", array("checkAccess" => $va_access_values)) || $t_item->get("ca_objects.object_id", array("checkAccess" => $va_access_values))){
		print "<hr/><br/><H7>Collection Inventory</H7>";
		if ($t_item->get('ca_collections.collection_id')) {
			print hffGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
			#print caGetCollectionLevelSummary($this->request, $t_item->get("ca_collections.children.collection_id", array("returnAsArray" => true)), 1);
		}
	}
	print $this->render("pdfEnd.php");
?>
</div>