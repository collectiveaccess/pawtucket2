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
{{{				<ifdef code="ca_collections.formats">
					<div class="unit"><H6><?= _t('Formats'); ?></H6>
					^ca_collections.formats&delimiter=,_</div>
				</ifdef>
				<ifdef code="ca_collections.extent_medium">
					<div class="unit"><H6><?= _t('Extent and Medium'); ?></H6>
					^ca_collections.extent_medium</div>
				</ifdef>
				<ifdef code="ca_collections.abstract">
					<div class="unit"><H6><?= _t('Abstract'); ?></H6>
					^ca_collections.abstract</div>
				</ifdef>
				<ifdef code="ca_collections.description">
					<div class="unit"><H6><?= _t('Scope and Content'); ?></H6>
					^ca_collections.description</div>
				</ifdef>
				<ifdef code="ca_collections.bio_history">
					<div class="unit"><H6><?= _t('Biography / History'); ?></H6>
					^ca_collections.bio_history</div>
				</ifdef>
				<ifdef code="ca_collections.date.date_value">
					<div class="unit"><H6><?= _t('Date'); ?></H6>
					^ca_collections.date.date_value<ifdef code="ca_collections.date.date_type"> (^ca_collections.date.date_type)</ifdef></div>
				</ifdef>
				<ifdef code="ca_collections.language">
					<div class="unit"><H6><?= _t('Language'); ?></H6>
					^ca_collections.language</div>
				</ifdef>
				<ifdef code="ca_collections.arrangement">
					<div class="unit"><H6><?= _t('Arrangement'); ?></H6>
					^ca_collections.arrangement</div>
				</ifdef>
				<ifdef code="ca_collections.finging_aid">
					<div class="unit"><H6><?= _t('Finging Aid Authors'); ?></H6>
					^ca_collections.finging_aid</div>
				</ifdef>
				<ifdef code="ca_collections.citation">
					<div class="unit"><H6><?= _t('Preferred Citation'); ?></H6>
					^ca_collections.citation</div>
				</ifdef>
}}}
	<div class="unit">
	{{{<ifcount code="ca_collections.related" min="1" max="1"><br/><H6>Related collection</H6></ifcount>}}}
	{{{<ifcount code="ca_collections.related" min="2"><br/><H6>Related collections</H6></ifcount>}}}
	{{{<unit relativeTo="ca_collections.related">^ca_collections.related.preferred_labels.name (^relationship_typename)</unit>}}}
	
	{{{<ifcount code="ca_entities" min="1" max="1"><br/><H6>Related person</H6></ifcount>}}}
	{{{<ifcount code="ca_entities" min="2"><br/><H6>Related people</H6></ifcount>}}}
	{{{<unit relativeTo="ca_entities" delimiter="<br/>">^ca_entities.preferred_labels.displayname (^relationship_typename)</unit>}}}
	
	{{{<ifcount code="ca_places" min="1" max="1"><br/><H6>Related place</H6></ifcount>}}}
	{{{<ifcount code="ca_places" min="2"><br/><H6>Related places</H6></ifcount>}}}
	{{{<unit relativeTo="ca_places" delimiter="<br/>">^ca_places.preferred_labels.name (^relationship_typename)</unit>}}}

	</div>
	
	
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><br/>Collection Contents";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
	}
	print $this->render("pdfEnd.php");
?>
