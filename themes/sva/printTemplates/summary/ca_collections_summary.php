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
	<div class="unit">
		<dl class="mb-0">
			<dt>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</dt>
			{{{<ifdef code="ca_collections.parent_id"><dt>Part of</dt><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></dd></ifdef>}}}
	
<?php
	$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => $va_restrict_to_relationship_types));
	if(is_array($va_entities) && sizeof($va_entities)){
		$va_entities_by_type = array();
		foreach($va_entities as $va_entity_info){
			$va_entities_by_type[$va_entity_info["relationship_typename"]][] = $va_entity_info["displayname"];
		}
		foreach($va_entities_by_type as $vs_type => $va_entity_links){
			print "<dt class='text-capitalize'>".$vs_type."</dt><dd>".join(", ", $va_entity_links)."</dd>";
		}
	}
?>					

{{{
		<ifdef code="ca_collections.extent.extent_amount">
			<dt><?= _t('Extent'); ?></dt>
			<unit relativeTo="ca_collections.extent" delimiter="">
				<dd>
					<ifdef code="ca_collections.extent.extent_type">^ca_collections.extent.extent_type </ifdef>^ca_collections.extent.extent_amount<ifdef code="ca_collections.extent.extent_type">^ca_collections.extent.extent_type </ifdef>
				</dd>
			</unit>
		</ifdef>
		<ifdef code="ca_collections.dates.dates_value">
			<dt><?= _t('Date'); ?></dt>
			<unit relativeTo="ca_collections.dates" delimiter=""><dd>^ca_collections.dates.dates_value<ifdef code="ca_collections.dates.dates_type"> (^ca_collections.dates.dates_type)</ifdef></dd></unit>
		</ifdef>
		<ifdef code="ca_collections.abstract">
			<dt><?= _t('Abstract'); ?></dt>
			<dd>
				<?php print caConvertLineBreaks($t_item->get("ca_collections.abstract")); ?>
			</dd>
		</ifdef>
		<ifdef code="ca_collections.biography">
			<dt><?= _t('Biographical / Historical note'); ?></dt>
			<dd>
				<?php print caConvertLineBreaks($t_item->get("ca_collections.biography")); ?>
			</dd>
		</ifdef>
		<ifdef code="ca_collections.scope_contents">
			<dt><?= _t('Scope and Contents'); ?></dt>
			<dd>
				<?php print caConvertLineBreaks($t_item->get("ca_collections.scope_contents")); ?>
			</dd>
		</ifdef>

		<ifdef code="ca_collections.arrangement">
			<dt><?= _t('Arrangement'); ?></dt>
			<dd>
				^ca_collections.arrangement
			</dd>
		</ifdef>
		<ifdef code="ca_collections.gen_physical_description">
			<dt><?= _t('General Physical Description'); ?></dt>
			<dd>
				^ca_collections.gen_physical_description
			</dd>
		</ifdef>
		<ifdef code="ca_collections.restrictions">
			<dt><?= _t('Restrictions'); ?></dt>
			<dd>
				^ca_collections.restrictions
			</dd>
		</ifdef>
		<ifdef code="ca_collections.copyright_text">
			<dt><?= _t('Copyright'); ?></dt>
			<dd>
				^ca_collections.copyright_text
			</dd>
		</ifdef>
		<ifdef code="ca_collections.citation">
			<dt><?= _t('Preferred Citation'); ?></dt>
			<dd>
				^ca_collections.citation
			</dd>
		</ifdef>
		<ifdef code="ca_collections.acquisition_info">
			<dt><?= _t('Acquisition Information'); ?></dt>
			<dd>
				^ca_collections.acquisition_info
			</dd>
		</ifdef>
		<ifdef code="ca_collections.processor">
			<dt><?= _t('Author/Processed by'); ?></dt>
			<dd>
				^ca_collections.processor
			</dd>
		</ifdef>
		<ifcount code="ca_collections.related" min="1">
			<dt><ifcount code="ca_collections.related" min="1" max="1"><?= _t('Related Collections'); ?></ifcount><ifcount code="ca_collections.related" min="2"><?= _t('Related Collections'); ?></ifcount></dt>
			<unit relativeTo="ca_collections.related" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ ">^ca_collections.preferred_labels.name</unit></dd></unit>
		</ifcount>
		
		<ifcount code="ca_occurrences" min="1">
			<dt><ifcount code="ca_occurrences" min="1"><?= _t('Related Exhibitions & Events'); ?></ifcount></dt>
			<unit relativeTo="ca_occurrences" delimiter=""><dd>^ca_occurrences.preferred_labels (^relationship_typename)</dd></unit>
		</ifcount>

		<ifcount code="ca_places" min="1">
			<dt><ifcount code="ca_places" min="1" max="1"><?= _t('Related Place'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Related Places'); ?></ifcount></dt>
			<unit relativeTo="ca_places" delimiter=""><dd>^ca_places.preferred_labels (^relationship_typename)</dd></unit>
		</ifcount>
}}}
		</dl>
	</div>
	
	
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<br/><h1 class='title'>Collection Contents</h1><div class='collectionContents'>";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummarySVA($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
		print "</div>";
	}
	print $this->render("pdfEnd.php");
?>
