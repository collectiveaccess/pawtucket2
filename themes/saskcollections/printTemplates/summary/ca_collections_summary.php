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
	{{{<ifdef code="ca_collections.label">^ca_collections.label<br/></ifdev>}}}
	</div>
	{{{
		<ifdef code="ca_collections.unitdate">
			<div class="unit"><H6>Date</H6><unit relativeTo="ca_collections.unitdate" delimiter="<br/>">^ca_collections.unitdate.dacs_date_value<ifdef code="ca_collections.unitdate.dacs_dates_types"> (^ca_collections.unitdate.dacs_dates_types)</ifdef></div></ifdef>
	}}}
<?php
	if($t_item->get("source_id")){
		$vs_source_as_text = getSourceAsText($this->request, $t_item->get("source_id"), null);
?>
		<div class="unit"><H6>Contributor</H6>
			<?php print $vs_source_as_text; ?>
		</div>
<?php
	}				
?>						
		
	{{{
		<ifdef code="ca_collections.adminbiohist"><div class="unit"><H6>Administrative/Biographical History Element</H6><span class="trimText"><unit relativeTo="ca_collections.adminbiohist" delimiter="<br/><br/>">^ca_collections.adminbiohist%convertLineBreaks=1</unit></span></div></ifdef>
		<ifdef code="ca_collections.scopecontent"><div class="unit"><H6>Scope & content</H6><span class="trimText">^ca_collections.scopecontent%convertLineBreaks=1</span></div></ifdef>
		<ifdef code="ca_collections.arrangement"><div class="unit"><H6>Arrangement</H6><span class="trimText">^ca_collections.arrangement%convertLineBreaks=1</span></div></ifdef>
	}}}

	{{{<ifcount code="ca_entities" min="1"><div class="unit"><H6>Related People/Institutions</H6>
			<unit relativeTo="ca_entities" delimiter="<br/>">^ca_entities.preferred_labels.displayname (^relationship_typename)</unit></div>
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
