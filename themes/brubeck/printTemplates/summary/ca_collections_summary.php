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
	</div>
		
	<div class="unit"><H6>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H6></div>
	<div class="unit">
	{{{<ifdef code="ca_collections.parent_id"><div class="unit"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></H6></ifdef>}}}
	</div>
	
	
	{{{<ifdef code="ca_collections.date_container.date"><div class="unit"><h6>Date</h6><unit relativeTo="ca_collections.date_container" delimiter="<br/>"><ifdef code="ca_collections.date_container.date_type">^ca_collections.date_container.date_type </ifdef>^ca_collections.date_container.date<ifdef code="ca_collections.date_container.date_certainty"> (^ca_collections.date_container.date_certainty)</ifdef><ifdef code="ca_collections.date_container.date_note"><br/>^ca_collections.date_container.date_note</ifdef></unit></div></ifdef>}}}
	{{{<ifdef code="ca_collections.extent_medium"><div class="unit"><h6>Extent and Medium</h6>^ca_collections.extent_medium%delimiter=,_</div></ifdef>}}}
	{{{<ifdef code="ca_collections.description">
		<div class='unit'><h6>Description</h6>
			<span class="trimText">^ca_collections.description</span>
		</div>
	</ifdef>}}}
	{{{<ifdef code="ca_collections.descriptive_note"><div class="unit"><h6>Descriptive Note</h6><unit relativeto="ca_collections.descriptive_note" delimiter="<br/>">^ca_collections.descriptive_note</unit></div></ifdef>}}}
	{{{<ifdef code="ca_collections.language"><div class="unit"><h6>Language</h6>^ca_collections.language%delimiter=,_</div></ifdef>}}}
	{{{<ifdef code="ca_collections.lcna"><div class="unit"><h6>LOC Names</h6>^ca_collections.lcna%delimiter=,_</div></ifdef>}}}
	{{{<ifdef code="ca_collections.lcsh"><div class="unit"><h6>LOC Subjects</h6>^ca_collections.lcsh%delimiter=,_</div></ifdef>}}}

	{{{<ifdef code="ca_collections.rights"><div class="unit"><h6>Rights</h6>^ca_collections.rights%delimiter=,_</div></ifdef>}}}
	{{{<ifdef code="ca_collections.access_conditions"><div class="unit"><h6>Access Conditions</h6>^ca_collections.access_conditions%delimiter=,_</div></ifdef>}}}
	{{{<ifdef code="ca_collections.use_reproduction"><div class="unit"><h6>Use and Reproduction Conditions</h6>^ca_collections.use_reproduction%delimiter=,_</div></ifdef>}}}
<?php
				$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
				if(is_array($va_entities) && sizeof($va_entities)){
					print "<div class='col-sm-12 col-md-4'>";
					$va_entities_by_type = array();
					foreach($va_entities as $va_entity_info){
						$va_entities_by_type[$va_entity_info["relationship_typename"]][] = $va_entity_info["displayname"];
					}
					foreach($va_entities_by_type as $vs_type => $va_entity_links){
						print "<div class='unit'><h6>".$vs_type."</h6>".join(", ", $va_entity_links)."</div>";
					}
					print "</div>";
				}
?>
				{{{<ifcount code="ca_occurrences" restrictToTypes="album,song" min="1"><div class="col-sm-12 col-md-4">
					<ifcount code="ca_occurrences" restrictToTypes="album" min="1"><div class="unit"><h6>Album<ifcount code="ca_occurrences" restrictToTypes="album" min="2">s</ifcount></h6>
						<unit relativeTo="ca_occurrences" restrictToTypes="album" delimiter="<br/>" sort="ca_occurrences.date_occurrence_container.date_occurrence">^ca_occurrences.preferred_labels.name</unit></div>
					</ifcount>
					<ifcount code="ca_occurrences" restrictToTypes="song" min="1"><div class="unit"><h6>Song<ifcount code="ca_occurrences" restrictToTypes="song" min="2">s</ifcount></h6>
						<unit relativeTo="ca_occurrences" restrictToTypes="song" delimiter="<br/>" sort="ca_occurrences.date_occurrence_container.date_occurrence">^ca_occurrences.preferred_labels.name</unit></div>
					</ifcount>
					</div>
				</ifcount>}}}

				{{{<ifcount code="ca_occurrences" restrictToTypes="tour,studio_session,appearance" min="1"><div class="col-sm-12 col-md-4">
					<ifcount code="ca_occurrences" restrictToTypes="tour" min="1"><div class="unit"><h6>Tour<ifcount code="ca_occurrences" restrictToTypes="tour" min="2">s</ifcount></h6>
						<unit relativeTo="ca_occurrences" restrictToTypes="tour" delimiter="<br/>" sort="ca_occurrences.date_occurrence_container.date_occurrence">^ca_occurrences.preferred_labels.name</unit></div>
					</ifcount>
					<ifcount code="ca_occurrences" restrictToTypes="studio_session" min="1"><div class="unit"><h6>Studio Session<ifcount code="ca_occurrences" restrictToTypes="studio_session" min="2">s</ifcount></h6>
						<unit relativeTo="ca_occurrences" restrictToTypes="studio_session" delimiter="<br/>" sort="ca_occurrences.date_occurrence_container.date_occurrence">^ca_occurrences.preferred_labels.name</unit></div>
					</ifcount>
					<ifcount code="ca_occurrences" restrictToTypes="appearance" min="1"><div class="unit"><h6>Related Appearance<ifcount code="ca_occurrences" restrictToTypes="appearance" min="2">s</ifcount></h6>
						<unit relativeTo="ca_occurrences" restrictToTypes="appearance" delimiter="<br/>" sort="ca_occurrences.date_occurrence_container.date_occurrence"><ifcount code="ca_occurrences.related" restrictToTypes="tour" restrictToRelationshipTypes="included" min="1"><unit relativeTo="ca_occurrences.related" restrictToTypes="tour" restrictToRelationshipTypes="included" delimiter=", ">^ca_occurrences.preferred_labels.name</unit>: </ifcount>^ca_occurrences.preferred_labels.name<ifdef code="ca_occurrences.date_occurrence_container.date_occurrence">, ^ca_occurrences.date_occurrence_container.date_occurrence<ifdef code="ca_occurrences.date_occurrence_container.date_note_occurrence"> (^ca_occurrences.date_occurrence_container.date_note_occurrence)</ifdef></ifdef></unit></div>
					</ifcount>
					</div>
				</ifcount>}}}

	
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><br/>Collection Contents";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
	}
	print $this->render("pdfEnd.php");
?>
