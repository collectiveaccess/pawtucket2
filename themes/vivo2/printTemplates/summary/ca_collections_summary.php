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
		<h1 class="title"><?php print $t_item->getLabelForDisplay();?></h1>
		<h2>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</h2>
	</div>

	{{{<ifdef code="ca_collections.RAD_scopecontent"><div class="unit"><H2>Scope and Content</H2><span class="trimTextShort"><div>^ca_collections.RAD_scopecontent</div></span></div></ifdef>}}}
	{{{<ifdef code="ca_collections.RAD_admin_hist"><div class="unit"><H2>Administrative/Biographical History</H2><span class="trimTextShort"><div>^ca_collections.RAD_admin_hist</div></span></div></ifdef>}}}
	{{{<ifdef code="ca_collections.RAD_arrangement"><div class="unit"><H2>System of Arrangement</H2><span class="trimTextShort"><div>^ca_collections.RAD_arrangement</div></span></div></ifdef>}}}
	{{{<ifdef code="ca_collections.RAD_custodial"><div class="unit"><H2>Custodial History</H2><span class="trimTextShort"><div>^ca_collections.RAD_custodial</div></span></div></ifdef>}}}

	{{{<ifdef code="ca_collections.title_note"><div class="unit"><H2>Title Note</H2>^ca_collections.title_note</div></ifdef>}}}
	{{{<ifdef code="ca_collections.date_container.date"><div class="unit"><H2>Date</H2><unit relativeTo="ca_collections.date_container" delimiter="<br>">^ca_collections.date_container.date<ifdef code="ca_collections.date_container.date_note">, ^ca_collections.date_container.date_note</ifdef></unit></div></ifdef>}}}
	{{{<ifdef code="ca_collections.RAD_langMaterial"><div class="unit"><H2>Language</H2>^ca_collections.RAD_langMaterial%delimiter=;_</div></ifdef>}}}
	{{{<ifdef code="ca_collections.RAD_material"><div class="unit"><H2>Related Materials</H2>^ca_collections.RAD_material</div></ifdef>}}}
<?php
		if($this->request->isLoggedIn()){
?>
			{{{<ifdef code="ca_collections.catalogue_control.catalogued_by|ca_collections.catalogue_control.catalogued_date"><div class="unit"><H2>Descriptive Control</H2>^ca_collections.catalogue_control.catalogued_by<ifdef cde="ca_collections.catalogue_control.catalogued_date"> (^ca_collections.catalogue_control.catalogued_date)</ifdef></div></ifdef>}}}
			{{{<ifdef code="ca_collections.acquisition_date"><div class="unit"><H2>Date of Acquisition</H2>^ca_collections.acquisition_date</div></ifdef>}}}
<?php
		}
?>
	{{{<ifdef code="ca_collections.parent_id"><div class="unit">Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></div></ifdef>}}}
<?php
	$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
	if(is_array($va_entities) && sizeof($va_entities)){
		$va_entities_by_type = array();
		foreach($va_entities as $va_entity_info){
			$va_entities_by_type[$va_entity_info["relationship_typename"]][] = $va_entity_info["displayname"];
		}
		foreach($va_entities_by_type as $vs_type => $va_entity_links){
			print "<div class='unit'><H2>".$vs_type."</H2>".join(", ", $va_entity_links)."</div>";
		}
	}
?>					
					
					
	{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="subject_guide"><div class="unit"><H2>Related Subject Guide<ifcount code="ca_occurrences" min="2" restrictToTypes="subject_guide">s</ifcount></H2><div class="trimTextShort"><unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="subject_guide">^ca_occurrences.preferred_labels.name</unit></div></div></ifcount>}}}
	{{{<ifdef code="ca_collections.places"><div class="unit"><H2>Related Places</H2><unit relativeTo="ca_collections.places" delimiter=", ">^ca_collections.places</unit></div></ifdef>}}}
<?php
		if($this->request->isLoggedIn() && $this->request->user->hasRole("frontendRestricted")){
?>					
					{{{<ifdef code="ca_collections.internal_notes"><div class="unit"><H2>Archivist Note</H2>^ca_collections.internal_notes</div></ifdef>}}}
<?php
		}
?>
	{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="event"><div class="unit"><H2>Related Programs & Events</H2><div class="trimTextShort"><unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="event">^ca_occurrences.preferred_labels.name</unit></div></div></ifcount>}}}
	{{{<ifcount code="ca_collections.related" min="1"><div class="unit"><H2>Collections</H2><div class="trimTextShort"><unit relativeTo="ca_collections.related" delimiter="<br/>">^ca_collections.preferred_labels.name</unit></div></div></ifcount>}}}



	
	
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><br/>Collection Contents";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
	}
	print $this->render("pdfEnd.php");
?>
