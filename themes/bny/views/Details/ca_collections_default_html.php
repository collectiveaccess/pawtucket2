<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_collections_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2024 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
$t_item = 				$this->getVar("item");
$access_values = 		$this->getVar("access_values");
$options = 				$this->getVar("config_options");
$comments = 			$this->getVar("comments");
$tags = 				$this->getVar("tags_array");
$comments_enabled = 	$this->getVar("commentsEnabled");
$pdf_enabled = 			$this->getVar("pdfEnabled");
$inquire_enabled = 		$this->getVar("inquireEnabled");
$copy_link_enabled = 	$this->getVar("copyLinkEnabled");
$id =					$t_item->get('ca_collections.collection_id');
$show_nav = 			($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = 			$this->getVar('mapOptions') ?? [];

# --- get collections configuration
$collections_config = caGetCollectionsConfig();
$show_hierarchy_viewer = true;
if($collections_config->get("do_not_display_collection_browser")){
	$show_hierarchy_viewer = false;	
}
# --- get the collection hierarchy parent to use for exportin finding aid
$top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));
?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
</script>
<?php 
	if($show_nav){
?>
	<div class="row mt-n3">
		<div class="col text-center text-md-end">
			{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
		</div>
	</div>
<?php
	}
?>
	<div class="row<?php print ($show_nav) ? " mt-2 mt-md-n3" : ""; ?>">
		<div class="col-md-12">
			<H1 class="fs-3">{{{^ca_collections.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_collections.type_id|ca_collections.idno"><div class="fw-medium mb-3 text-capitalize"><ifdef code="ca_collections.type_id">^ca_collections.type_id</ifdef><ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef></div></ifdef>}}}
			<hr class="mb-0">
		</div>
	</div>
<?php
	if($inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
	<div class="row">
		<div class="col text-center text-md-end">
			<div class="btn-group" role="group" aria-label="Detail Controls">
<?php
				if($inquire_enabled) {
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_collections", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_collections", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'));
				}
				if($copy_link_enabled){
?>
				<button type="button" class="btn btn-sm btn-white ps-3 pe-0 fw-medium"><i class="bi bi-copy"></i> <?= _t('Copy Link'); ?></button>
<?php
				}
?>
			</div>
		</div>
	</div>
<?php
	}
?>
<div class="bg-light pt-1 pb-3 px-4 mb-3">
	<div class="row row-cols-1 row-cols-md-2">
		<div class="col">				
			{{{<dl class="mb-0">
				<ifdef code="ca_collections.parent_id">
					<dt>Part of</dt>
					<dd><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></dd>
				</ifdef>
<?php
			$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("creator")));
			if(is_array($va_entities) && sizeof($va_entities)){
?>
				<dl class="mb-0">
					<dt>Creator:</dt>
					<dd>
<?php
				$va_tmp = array();
				foreach($va_entities as $va_entity_info){
					$va_tmp[] = caNavLink($this->request, $va_entity_info["displayname"], "", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $va_entity_info["entity_id"]));
				}
				print join(", ", $va_tmp);
?>
					</dd>
				</dl>
<?php
			}
?>							
				<ifdef code="ca_collections.unitdate">
					<unit relativeto="ca_collections.unitdate" delimiter="">
						<dt>^ca_collections.unitdate.dacs_dates_types</dt>
						<dd>
							^ca_collections.unitdate.dacs_date_value
						</dd>
					</unit>
				</ifdef>
				<ifdef code="ca_collections.extentDACS">
					<dt><?= _t('Quantity'); ?></dt>
					<dd>
						^ca_collections.extentDACS
					</dd>
				</ifdef>
				<ifdef code="ca_collections.langmaterial">
					<dt><?= _t('Language of Materials'); ?></dt>
					<dd>
						^ca_collections.langmaterial
					</dd>
				</ifdef>
				<ifdef code="ca_collections.idno">
					<dt><?= _t('Call Number'); ?></dt>
					<dd>
						^ca_collections.idno
					</dd>
				</ifdef>
			</dl>}}}
			{{{<dl class="mb-0">
				<ifdef code="ca_collections.adminbiohist">
					<dt><?= _t('Administrative/Biographical History'); ?></dt>
					<dd>
						^ca_collections.adminbiohist
					</dd>
				</ifdef>
				<ifdef code="ca_collections.scopecontent">
					<dt><?= _t('Scope and Content'); ?></dt>
					<dd>
						^ca_collections.scopecontent
					</dd>
				</ifdef>
				
				<ifdef code="ca_collections.originalsloc|ca_collections.altformavail|ca_collections.relation|ca_collections.publication_note">
					<dt><?= _t('Related Materials'); ?></dt>
					<ifdef code="ca_collections.originalsloc"><dd><span class="fw-medium">Existence and Location of Originals: </span>
						^ca_collections.originalsloc
					</dd></ifdef>
					<ifdef code="ca_collections.altformavail"><dd><span class="fw-medium">Existence and Location of Copies: </span>
						^ca_collections.altformavail
					</dd></ifdef>
					<ifdef code="ca_collections.relation"><dd><span class="fw-medium">Related Archival Materials: </span>
						^ca_collections.relation
					</dd></ifdef>
					<ifdef code="ca_collections.publication_note"><dd><span class="fw-medium">Publication Note: </span>
						^ca_collections.publication_note
					</dd></ifdef>
				</ifdef>				
			</dl>}}}
			

		</div>
		<div class="col">
			{{{<dl class="mb-0">
				<ifdef code="ca_collections.arrangement">
					<dt><?= _t('System of Arrangement'); ?></dt>
					<dd>
						^ca_collections.arrangement
					</dd>
				</ifdef>
<?php

			if($t_item->get("ca_list_items")){
				if($links = caGetBrowseLinks($t_item, 'ca_list_items', ['template' => '<l>^ca_list_items.preferred_labels</l>', 'linkTemplate' => '^LINK'])) {
?>
					<dt>Access Points</dt>
						<dd><?= join(", ", $links); ?></dd>
<?php
				}
			}
?>
				<ifdef code="ca_collections.processInfo|ca_collections.acqinfo|ca_object_lots.idno_stub">
					<dt><?= _t('Administrative Information'); ?></dt>
					<ifdef code="ca_object_lots.idno_stub"><dd><span class="fw-medium">Related Lots: </span>
						^ca_object_lots.idno_stub%delimiter=,_
					</dd></ifdef>
					<ifdef code="ca_collections.acqinfo"><dd><span class="fw-medium">Acquisition Notes: </span>
						^ca_collections.acqinfo
					</dd></ifdef>
					<ifdef code="ca_collections.processInfo"><dd><span class="fw-medium">Processing Notes: </span>
						^ca_collections.processInfo
					</dd></ifdef>
				</ifdef>
				
				
				
				
				<ifdef code="ca_collections.processInfo|ca_collections.acqinfo|ca_object_lots.idno_stub">
					<dt><?= _t('Access and Use'); ?></dt>	
				
					<ifdef code="ca_collections.accessrestrict">
						<dd><span class="fw-medium"><?= _t('Conditions Governing Access'); ?></span>
							^ca_collections.accessrestrict
						</dd>
					</ifdef>
					<ifdef code="ca_collections.physaccessrestrict">
						<dd><span class="fw-medium"><?= _t('Physical Access'); ?></span>
							^ca_collections.physaccessrestrict
						</dd>
					</ifdef>
					<ifdef code="ca_collections.techaccessrestrict">
						<dd><span class="fw-medium"><?= _t('Technical Access'); ?></span>
							^ca_collections.techaccessrestrict
						</dd>
					</ifdef>
					<ifdef code="ca_collections.reproduction">
						<dd><span class="fw-medium"><?= _t('Conditions Governing Reproduction'); ?></span>
							^ca_collections.reproduction
						</dd>
					</ifdef>
					<ifdef code="ca_collections.otherfindingaid">
						<dd><span class="fw-medium"><?= _t('Other Finding Aids'); ?></span>
							^ca_collections.otherfindingaid
						</dd>
					</ifdef>
					<ifdef code="ca_collections.preferCite">
						<dd><span class="fw-medium"><?= _t('Preferred Citation'); ?></span>
							^ca_collections.preferCite
						</dd>
					</ifdef>
				</ifdef>
				<ifcount code="ca_collections.related" min="1">
					<dt><ifcount code="ca_collections.related" min="1" max="1"><?= _t('Related Collections'); ?></ifcount><ifcount code="ca_collections.related" min="2"><?= _t('Related Collections'); ?></ifcount></dt>
					<unit relativeTo="ca_collections.related" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
				</ifcount>
			</dl>}}}				
<?php
			$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("related")));
			if(is_array($va_entities) && sizeof($va_entities)){
?>
				<dl class="mb-0">
					<dt>Related People and Organizations:</dt>
					<dd>
<?php
				$va_tmp = array();
				foreach($va_entities as $va_entity_info){
					$va_tmp[] = caNavLink($this->request, $va_entity_info["displayname"], "", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $va_entity_info["entity_id"]));
				}
				print join(", ", $va_tmp);
?>
					</dd>
				</dl>
<?php
			}
			if($t_item->get("ca_places")){
				if($links = caGetBrowseLinks($t_item, 'ca_places', ['template' => '<l>^ca_places.preferred_labels</l>', 'linkTemplate' => '^LINK'])) {
?>
					<dl class="mb-0">
						<dt>Place<?= (sizeof($links) > 1 ) ? "s" : ""; ?></dt>
						<dd><?= join(", ", $links); ?></dd>
					</dl>
<?php
				}
			}
?>
					
		</div>
	</div>
</div>
<?php
	if ($show_hierarchy_viewer) {	
?>
		<div hx-trigger="load" hx-get="<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $t_item->get('collection_id'))); ?>"  ></div>
<?php				
	}									
?>				
{{{<ifcount code="ca_objects" min="1">
<div class="row mt-5">
	<div class="col-sm-6"><h2 class="fs-3">Related Objects</h2></div>
	<div class="col-sm-6 text-sm-end"><?php print caNavLink($this->request, "Browse All", "btn btn-primary btn-sm", "", "Browse", "objects", array("facet" => "collection_facet", "id" => $t_item->get("ca_collections.collection_id"))); ?></div>
</div>
<div class="row">
	<div class="col"><hr class='mt-0'></div>
</div>
<div class="row" id="browseResultsContainer">	
	<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_collections.collection_id:'.$t_item->get("ca_collections.collection_id"))); ?>">
		<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
	</div>
</ifcount>}}}
