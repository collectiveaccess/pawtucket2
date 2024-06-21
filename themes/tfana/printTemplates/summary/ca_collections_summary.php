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
				<ifdef code="ca_collections.display_date">
					<dt><?= _t('Date'); ?></dt>
					<dd>
						^ca_collections.display_date%delimiter=,_
					</dd>
				</ifdef>
				<ifdef code="ca_collections.extent_text">
					<dt><?= _t('Extent and Medium'); ?></dt>
					<dd>
						^ca_collections.extent_text
					</dd>
				</ifdef>
				<ifdef code="ca_collections.material_designations">
					<dt><?= _t('Material Designation'); ?></dt>
					<dd>
						^ca_collections.material_designations%delimiter=,_
					</dd>
				</ifdef>
				<ifdef code="ca_collections.scopecontent">
					<dt><?= _t('Scope and Content'); ?></dt>
					<dd>
						^ca_collections.scopecontent
					</dd>
				</ifdef>
				<ifdef code="ca_collections.adminbiohist">
					<dt><?= _t('Administrative/Biographical History'); ?></dt>
					<dd>
						^ca_collections.adminbiohist
					</dd>
				</ifdef>
				<ifdef code="ca_collections.arrangement">
					<dt><?= _t('System of Arrangement'); ?></dt>
					<dd>
						^ca_collections.arrangement
					</dd>
				</ifdef>
				<ifdef code="ca_collections.accessrestrict">
					<dt><?= _t('Conditions Governing Access'); ?></dt>
					<dd>
						^ca_collections.accessrestrict
					</dd>
				</ifdef>
				<ifdef code="ca_collections.physaccessrestrict">
					<dt><?= _t('Physical and Technical Access Notes'); ?></dt>
					<dd>
						^ca_collections.physaccessrestrict
					</dd>
				</ifdef>
				<ifdef code="ca_collections.reproduction">
					<dt><?= _t('Conditions Governing Reproduction'); ?></dt>
					<dd>
						^ca_collections.reproduction
					</dd>
				</ifdef>
				<ifdef code="ca_collections.langmaterial">
					<dt><?= _t('Language'); ?></dt>
					<dd>
						^ca_collections.langmaterial
					</dd>
				</ifdef>
				<ifdef code="ca_collections.themes">
					<dt><?= _t('Themes'); ?></dt>
					<dd>
						^ca_collections.themes%delimiter=",_"
					</dd>
				</ifdef>
				<ifdef code="ca_collections.keywords_text">
					<dt><?= _t('Keywords'); ?></dt>
					<dd>
						^ca_collections.keywords_text%delimiter=",_"
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
				<ifcount code="ca_places" min="1">
					<div class="unit">
						<dt><ifcount code="ca_places" min="1" max="1"><?= _t('Related Place'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Related Places'); ?></ifcount></dt>
						<unit relativeTo="ca_places" delimiter=""><dd>^ca_places.preferred_labels (^relationship_typename)</dd></unit>
					</div>
				</ifcount>
			</dl>}}}					

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
