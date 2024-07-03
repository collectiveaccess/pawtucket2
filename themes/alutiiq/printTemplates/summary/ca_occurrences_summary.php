<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/summary.php
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
 * @name Object tear sheet
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
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

	if($t_item->get("ca_occurrences.type_id", array("convertCodesToDisplayText" => true)) == "Repatriation/Reburial"){
?>
	<div class="title">
		<h1 class="title">{{{^ca_occurrences.preferred_labels.name}}}</h1>
	</div>
	<div class="tombstone">
		<HR>
					{{{<ifdef code="ca_occurrences.idno"><div class="unit"><H6>Identifier</H6>^ca_occurrences.idno</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.repatriation_status"><div class="unit"><H6>Status</H6>^ca_occurrences.repatriation_status</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.repat_type"><div class="unit"><H6>Repatriation Type</H6>^ca_occurrences.repat_type</div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.min_number"><div class="unit"><H6>Minimum Number of Individuals</H6>^ca_occurrences.min_number</div></ifdef>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="repatriating_entity" min="1">
						<div class="unit"><H6>Holding Institution</H6>
						<unit relativeTo="ca_entities" restrictToRelationshipTypes="repatriating_entity" delimiter="<br>">
							^ca_entities.preferred_labels.displayname
						</unit>
						</div>
					</ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="potential_claimant" min="1">
						<div class="unit"><H6>Potential Claimant<ifcount code="ca_entities" restrictToRelationshipTypes="potential_claimant" min="2">s</ifcount></H6>
						<unit relativeTo="ca_entities" restrictToRelationshipTypes="potential_claimant" delimiter="<br>">
							^ca_entities.preferred_labels.displayname
						</unit>
						</div>
					</ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="claimant" min="1">
						<div class="unit"><H6>Final Claimant</H6>
						<unit relativeTo="ca_entities" restrictToRelationshipTypes="claimant" delimiter="<br>">
							^ca_entities.preferred_labels.displayname
						</unit>
						</div>
					</ifcount>}}}
					{{{<ifdef code="ca_occurrences.repat_notes"><div class="unit"><H6>Notes</H6>^ca_occurrences.repat_notes</div></ifdef>}}}
	</div>				

<?php	
	
	}else{
?>
	<div class="title">
		<h1 class="title">{{{^ca_occurrences.preferred_labels.name}}} &mdash; {{{^ca_occurrences.alutiiq_word}}}</h1>
	</div>
	<div class="tombstone">
		<HR>
		{{{<ifdef code="ca_occurrences.sentence"><div class="unit center"><H6>^ca_occurrences.sentence</H6></div></ifdef>}}}
		<HR>
		{{{<unit relativeTo='ca_object_representations' filterNonPrimaryRepresentations='1' length='1' sort='is_primary' sortDirection='desc' delimiter='<br/>'><ifdef code="ca_object_representations.media.medium"><div style="float:left; width:30%; padding-right:20px; padding-bottom:20px;"><div class="unit fullWidthImg">^ca_object_representations.media.large<if rule='^ca_object_representations.preferred_labels.name !~ /BLANK/'><div class='small text-center'>^ca_object_representations.preferred_labels.name</div></if></div></div></ifdef></unit>}}}
		{{{<ifdef code="ca_occurrences.description"><div class="unit">^ca_occurrences.description</div></ifdef>}}}
	</div>				

<?php	
	}
	print $this->render("pdfEnd.php");