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


			{{{<dl class="mb-0">
				<ifdef code="ca_collections.parent_id">
					<dt>Part of</dt>
					<dd><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></dd>
				</ifdef>
				<ifdef code="ca_collections.unitDate.unitDate_value">
					<dt><?= _t('Date'); ?></dt>
					<unit relativeTo="ca_collections.unitDate">
					<dd>
						^ca_collections.unitDate.unitDate_value<ifdef code="ca_collections.unitDate.unitDate_types"> (^ca_collections.unitDate.unitDate_types)</ifdef>
					</dd>
					</unit>
				</ifdef>
				<ifdef code="ca_collections.coll_extent.extent_number">
					<dt>Extent</dt>
					<dd>
						^ca_collections.coll_extent.extent_number<ifdef code="ca_collections.coll_extent.extent_type"> ^ca_collections.coll_extent.extent_type</ifdef>
						<ifdef code="ca_collections.coll_extent.extent_details"><div class="pt-2">ca_collections.coll_extent.extent_details</div></ifdef>
					</dd>
				</ifdef>
				<ifdef code="ca_collections.scope_content">
					<dt><?= _t('Scope and Content'); ?></dt>
					<dd>
						^ca_collections.scope_content
					</dd>
				</ifdef>
				<ifdef code="ca_collections.historical_note">
					<dt><?= _t('Historical Note'); ?></dt>
					<dd>
						^ca_collections.historical_note
					</dd>
				</ifdef>
			</dl>}}}
<?php
	$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => $va_restrict_to_relationship_types));
	if(is_array($va_entities) && sizeof($va_entities)){
?>
		<dl class="mb-0">
<?php
		$va_entities_by_type = array();
		foreach($va_entities as $va_entity_info){
			$va_entities_by_type[$va_entity_info["relationship_typename"]][] = $va_entity_info["displayname"];
		}
		foreach($va_entities_by_type as $vs_type => $va_entity_output){
			print "<dt class='text-capitalize'>".$vs_type."</dt><dd>".join(", ", $va_entity_output)."</dd>";
		}
?>
		</dl>
<?php
	}
?>
			{{{<dl class="mb-0">
				<ifcount code="ca_occurrences" restrictToTypes="production" min="1">
					<dt><ifcount code="ca_occurrences" restrictToTypes="production" min="1" max="1"><?= _t('Related Production'); ?></ifcount><ifcount code="ca_occurrences" restrictToTypes="production" min="2"><?= _t('Related Productions'); ?></ifcount></dt>
					<unit relativeTo="ca_occurrences" restrictToTypes="production" delimiter=""><dd>
						^ca_occurrences.preferred_labels
					</dd></unit>
				</ifcount>
				<ifcount code="ca_occurrences" restrictToTypes="event" min="1">
					<dt><ifcount code="ca_occurrences" restrictToTypes="event" min="1" max="1"><?= _t('Related Event'); ?></ifcount><ifcount code="ca_occurrences" restrictToTypes="event" min="2"><?= _t('Related Events'); ?></ifcount></dt>
					<unit relativeTo="ca_occurrences" restrictToTypes="event" delimiter=""><dd>
						^ca_occurrences.preferred_labels
					</dd></unit>
				</ifcount>
				<ifcount code="ca_occurrences" restrictToTypes="education" min="1">
					<dt><ifcount code="ca_occurrences" restrictToTypes="education" min="1" max="1"><?= _t('Related Education Program'); ?></ifcount><ifcount code="ca_occurrences" restrictToTypes="education" min="2"><?= _t('Related Education Program'); ?></ifcount></dt>
					<unit relativeTo="ca_occurrences" restrictToTypes="education" delimiter=""><dd>
						^ca_occurrences.preferred_labels
					</dd></unit>
				</ifcount>

				<ifdef code="ca_collections.rightsStatement.rightsStatement_text">
					<dt><?= _t('Rights Statement'); ?></dt>
					<dd>^ca_collections.rightsStatement.rightsStatement_text</dd>
				</ifdef>
			</dl>}}}					

	</div>
	
	
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><br/>Collection Contents";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummaryTFANA($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
	}
	print $this->render("pdfEnd.php");
?>
