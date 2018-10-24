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

?>
	<div class="title">
		<h1 class="title">{{{<ifdef code="ca_collections.fa_title">^ca_collections.fa_title</ifdef><ifnotdef code="ca_collections.fa_title">^ca_collections.preferred_labels</ifnotdef>}}}</h1>
	</div>
	<div class="unit"><H6>{{{^ca_collections.idno}}}{{{<ifdef code="ca_collections.fa_sponsor">, ^ca_collections.fa_sponsor</ifdef>}}}</H6></div>	
			
	{{{<ifdef code="ca_collections.unitdate.dacs_date_text"><div class="unit"><H6>Date</H6>^ca_collections.unitdate.dacs_date_text</div></ifdef>}}}
	{{{<ifdef code="ca_collections.extentDACS.portion_label|ca_collections.extentDACS.extent_number|ca_collections.extentDACS.extent_type|ca_collections.extentDACS.container_summary|ca_collections.extentDACS.physical_details|ca_collections.extentDACS.extent_dimensions">
		<div class="unit">
			<H6>Extent</H6>
			<unit relativeTo="ca_collections">
			<ifdef code="ca_collections.extentDACS.portion_label">^ca_collections.extentDACS.portion_label </ifdef><ifdef code="ca_collections.extentDACS.extent_number">^ca_collections.extentDACS.extent_number </ifdef><ifdef code="ca_collections.extentDACS.extent_type">^ca_collections.extentDACS.extent_type</ifdef>
			<ifdef code="ca_collections.extentDACS.container_summary"><br/>Container Summary: ^ca_collections.extentDACS.container_summary</ifdef>
			<ifdef code="ca_collections.extentDACS.physical_details"><br/>Physical Details: ^ca_collections.extentDACS.physical_details</ifdef>
			<ifdef code="ca_collections.extentDACS.extent_dimensions"><br/>Dimensions: ^ca_collections.extentDACS.extent_dimensions</ifdef>
			</div>
		</div>
	</ifdef>}}}
	{{{<ifcount code="ca_storage_locations">
		<div class="unit">
			<ifcount code="ca_storage_locations" min="1" max="1">
				<H6>Location</H6>
			</ifcount>
			<ifcount code="ca_storage_locations" min="2">
				<H6>Locations</H6>
			</ifcount>
			<unit relativeTo="ca_storage_locations.related" delimiter="<br/>">
				<unit relativeTo="ca_storage_locations.hierarchy" delimiter=" &gt; ">^ca_storage_locations.preferred_labels</unit>
			</unit>
		</div>
	</ifcount>}}}
	{{{<ifdef code="ca_collections.abstract"><div class="unit"><H6>Abstract</H6>^ca_collections.abstract</div></ifdef>}}}
	{{{<ifdef code="ca_collections.accessrestrict"><div class="unit"><H6>Conditions Governing Access</H6>^ca_collections.accessrestrict</div></ifdef>}}}
	
	{{{<ifdef code="ca_collections.adminbiohist"><div class="unit"><H6>Administrative/Biographical History Element</H6>^ca_collections.adminbiohist</div></ifdef>}}}
	{{{<ifdef code="ca_collections.scopecontent"><div class="unit"><H6>Scope and Content</H6>^ca_collections.scopecontent</div></ifdef>}}}
	{{{<ifdef code="ca_collections.arrangement"><div class="unit"><H6>System of Arrangement</H6>^ca_collections.arrangement</div></ifdef>}}}
	{{{<ifdef code="ca_collections.govtuse"><div class="unit"><H6>Conditions Governing Use</H6>^ca_collections.govtuse</div></ifdef>}}}
	{{{<ifdef code="ca_collections.related_materials"><div class="unit"><H6>Related Materials</H6>^ca_collections.related_materials</div></ifdef>}}}
	{{{<ifdef code="ca_collections.acqinfo"><div class="unit"><H6>Provenance</H6>^ca_collections.acqinfo</div></ifdef>}}}
	{{{<ifdef code="ca_collections.fa_language"><div class="unit"><H6>Language of Description</H6>^ca_collections.fa_language</div></ifdef>}}}
	{{{<ifdef code="ca_collections.preferCite"><div class="unit"><H6>Preferred Citation</H6>^ca_collections.preferCite</div></ifdef>}}}
	{{{<ifdef code="ca_collections.fa_author"><div class="unit"><H6>Finding Aid Author</H6>^ca_collections.fa_author</div></ifdef>}}}
	{{{<ifdef code="ca_collections.fa_date"><div class="unit"><H6>Finding Aid Date</H6>^ca_collections.fa_date</div></ifdef>}}}
	{{{<ifcount code="ca_entities.related" min="1" restrictToRelationshipTypes="creator,subject,source"><div class="unit"><H6>Creator Agent (Collective Access Agent)</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="creator,subject,source" delimiter="<br/>">^ca_entities.preferred_labels.displayname</unit></div></ifcount>}}}
	{{{<ifdef code="ca_collections.loc_agent.loc_agent_value"><div class="unit"><H6>Agents (LOC)</H6><unit relativeTo="ca_collections" delimiter="<br/>">^ca_collections.loc_agent.loc_agent_value</unit></div></ifdef>}}}

	<div class="unit">
	{{{<ifdef code="ca_collections.parent_id"><div class="unit"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></H6></ifdef>}}}
	{{{<ifdef code="ca_collections.label">^ca_collections.label<br/></ifdev>}}}
	</div>
	
	
	
	
	
<?php

	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><br/>Collection Inventory";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
			#print caGetCollectionLevelSummary($this->request, $t_item->get("ca_collections.children.collection_id", array("returnAsArray" => true)), 1);
		}
	}
	print $this->render("pdfEnd.php");
?>
