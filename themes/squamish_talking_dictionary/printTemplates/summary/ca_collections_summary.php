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
	<h1 class="title"><?php print $t_item->getLabelForDisplay();?></h1>
		
	<div class="unit"><H6>{{{^ca_collections.type_id}}}</H6></div>
	<div class="unit">
	{{{<ifdef code="ca_collections.parent_id"><div class="unit"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></H6></ifdef>}}}
	</div>
	{{{<ifdef code="ca_collections.idno"><div class="unit"><H6>Identifier</H6>^ca_collections.idno</div></ifdef>}}}
	{{{<ifdef code="ca_collections.display_date"><div class="unit"><H6>Date</H6>^ca_collections.display_date%delimiter=,_</div></ifdef>}}}
	{{{<ifnotdef code="ca_collections.display_date"><ifdef code="ca_collections.date"><div class="unit"><H6>Date</H6>^ca_collections.date%delimiter=,_</div></ifdef></ifnotdef>}}}
	{{{<ifdef code="ca_collections.date_note"><div class="unit"><H6>Date Note</H6><unit relativeTo="ca_collections.date_note" delimiter="<br/>">^ca_collections.date_note</unit></div></ifdef>}}}
	
	{{{<ifdef code="ca_collections.phys_desc"><div class="unit"><H6>Physical Description</H6>^ca_collections.phys_desc</div></ifdef>}}}
	{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="creator,contributor"><div class="unit"><H6>Creator<ifcount code="ca_entities" min="2" restrictToRelationshipTypes="creator,contributor">s</ifcount></H6>
		<unit relativeTo="ca_entities_x_collections" restrictToRelationshipTypes="creator,contributor" delimiter="<br/>">^ca_entities.preferred_labels.displayname<if rule='^ca_collections.type_id =~ /Collection/'><ifdef code="ca_entities.bio_history_container.bio_history"><br/>^ca_entities.bio_history_container.bio_history</ifdef></if></unit>
	</div></ifcount>}}}
	
	{{{<ifdef code="ca_collections.description"><div class="unit"><H6>Scope & Content</H6>^ca_collections.description</div></ifdef>}}}
	{{{<ifdef code="ca_collections.provenance"><div class="unit"><H6>Provenance</H6>^ca_collections.provenance</div></ifdef>}}}
	{{{<ifdef code="ca_collections.language"><div class="unit"><H6>Language</H6>^ca_collections.language%delimiter=,_</div></ifdef>}}}
	{{{<ifdef code="ca_collections.arrangement"><div class="unit"><H6>System of Arrangement</H6>^ca_collections.arrangement</div></ifdef>}}}
	{{{<ifdef code="ca_collections.accruals"><div class="unit"><H6>Accruals</H6>^ca_collections.accruals</div></ifdef>}}}
	{{{<ifdef code="ca_collections.descriptive_note"><div class="unit"><H6>Descriptive Notes</H6><unit relativeTo="ca_collections.descriptive_note" delimiter="<br/><br/>">^ca_collections.descriptive_note</unit></div></ifdef>}}}
	{{{<ifdef code="ca_collections.rights_container.access_conditions"><div class="unit"><H6>Access Conditions</H6>^ca_collections.rights_container.access_conditions</div></ifdef>}}}
	{{{<ifdef code="ca_collections.rights_container.use_reproduction"><div class="unit"><H6>Use and Reproduction Conditions</H6>^ca_collections.rights_container.use_reproduction</div></ifdef>}}}					

	
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><div class='title'>Table of Contents</div>";
		print "<div class='toc'>".caGetCollectionLevelSummaryTOCSquamish($this->request, array($t_item->get('ca_collections.collection_id')), 1)."</div>";
		
		print "<hr/><div class='title'>Collection Contents</div><div class='collectionContents'>";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummarySquamish($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
		print "</div>";
	}
	print $this->render("pdfEnd.php");
?>
