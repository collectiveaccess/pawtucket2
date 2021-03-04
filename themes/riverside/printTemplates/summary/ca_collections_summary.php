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
		
	<div class="unit text-center"><H6>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H6></div>
	<div class="unit">
	{{{<ifdef code="ca_collections.parent_id"><div class="unit"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></H6></ifdef>}}}
	{{{<ifdef code="ca_collections.label">^ca_collections.label<br/></ifdev>}}}
	</div>
	{{{<ifdef code="ca_collections.coverageDates"><div class="unit"><H6>Coverage Dates</H6>^ca_collections.coverageDates%convertLineBreaks=1</div></ifdef>}}}
	{{{<ifdef code="ca_collections.coverageSpacial"><div class="unit"><H6>Spacial Coverage</H6>^ca_collections.coverageSpacial%convertLineBreaks=1</div></ifdef>}}}
	{{{<ifdef code="ca_collections.extent_text"><div class="unit"><H6>Extent</H6>^ca_collections.extent_text%convertLineBreaks=1</div></ifdef>}}}
	{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="creator"><div class="unit"><H6>Creators</H6><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="creator">^ca_entities.preferred_labels.displayname</unit></div></ifcount>}}}
	{{{<ifdef code="ca_collections.adminbiohist"><div class="unit"><H6>Administrative/biographical history element</H6>^ca_collections.adminbiohist%convertLineBreaks=1</div></ifdef>}}}
	{{{<ifdef code="ca_collections.originals_location"><div class="unit"><H6>Existence and Location of Originals</H6>^ca_collections.originals_location%convertLineBreaks=1</div></ifdef>}}}
	{{{<ifdef code="ca_collections.scopecontent"><div class="unit"><H6>Scope and Content</H6>^ca_collections.scopecontent%convertLineBreaks=1</div></ifdef>}}}
	{{{<ifdef code="ca_collections.arrangement"><div class="unit"><H6>System of Arrangement</H6>^ca_collections.arrangement%convertLineBreaks=1</div></ifdef>}}}
	{{{<ifdef code="ca_collections.accessrestrict"><div class="unit"><H6>Conditions governing access</H6>^ca_collections.accessrestrict%convertLineBreaks=1</div></ifdef>}}}
	{{{<ifdef code="ca_collections.physaccessrestrict"><div class="unit"><H6>Physcial access</H6>^ca_collections.physaccessrestrict%convertLineBreaks=1</div></ifdef>}}}
	{{{<ifdef code="ca_collections.techaccessrestrict"><div class="unit"><H6>Technical access</H6>^ca_collections.techaccessrestrict%convertLineBreaks=1</div></ifdef>}}}
	{{{<ifdef code="ca_collections.reproduction_conditions"><div class="unit"><H6>Conditions Governing Reproduction</H6>^ca_collections.reproduction_conditions%convertLineBreaks=1</div></ifdef>}}}
	{{{<ifdef code="ca_collections.langmaterials"><div class="unit"><H6>Languages and Scripts of the Material</H6>^ca_collections.langmaterials%convertLineBreaks=1</div></ifdef>}}}
	{{{<ifdef code="ca_collections.otherfindingaid"><div class="unit"><H6>Other Finding Aids</H6>^ca_collections.otherfindingaid%convertLineBreaks=1</div></ifdef>}}}
	{{{<ifdef code="ca_collections.url.link_url"><div class="unit"><H6>External Link</H6><unit delimiter="<br/>"><ifdef code="ca_collections.url.link_text">^ca_collections.url.link_text: </ifdef><ifdef code="ca_collections.url.link_text">^ca_collections.url.link_url</ifdef></div></ifdef>}}}

	{{{<ifdef code="ca_collections.lcsh_terms|ca_collections.internal_keywords"><div class="unit"><H6>Subjects/Keywords</H6><ifdef code="ca_collections.lcsh_terms">^ca_collections.lcsh_terms%delimiter=,_</ifdef><ifdef code="ca_collections.lcsh_terms,ca_collections.internal_keywords">, </ifdef><ifdef code="ca_collections.internal_keywords">^ca_collections.internal_keywords%delimiter=,_</ifdef></div></ifdef>}}}
	{{{<ifcount code="ca_entities" excludeRelationshipTypes="creator" min="1"><div class="unit"><H6>Related Entities</H6><unit relativeTo="ca_entities" delimiter="<br/>" excludeRelationshipTypes="creator">^ca_entities.preferred_labels.displayname (^relationship_typename)</unit></div></ifcount>}}}
				

	
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><br/>Collection Contents<br/><br/>";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
	}
	print $this->render("pdfEnd.php");
?>
