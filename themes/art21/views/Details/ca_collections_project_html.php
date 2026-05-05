<?php
/* ----------------------------------------------------------------------
 * themes/art21/views/Details/ca_collections_series_html.php : 
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
$media_options = $this->getVar('media_options') ?? [];
$media_options = array_merge($media_options, [
	'id' => 'mediaviewer'
]);
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
	pawtucketUIApps['mediaViewerManager'] = <?= json_encode($media_options); ?>;
</script>
<?php 
	if($show_nav){
?>
	<div class="row mt-n3">
		<div class="col text-center text-md-end">
			<nav aria-label="result">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</nav>
		</div>
	</div>
<?php
	}
?>
	<div class="row">
		<div class="col-md-12">
			<H1 class="fs-3">{{{^ca_collections.preferred_labels.name}}}</H1>
			{{{<div class="fw-medium mb-3 text-capitalize">^ca_collections.type_id, <ifdef code="ca_collections.year">^ca_collections.year</ifdef><ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef></div>}}}
			<hr class="mb-0">
		</div>
	</div>
<?php
	if($inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
	<div class="row">
		<div class="col text-center text-md-end">
			<div class="btn-group" role="toolbar" aria-label="Detail Controls">
<?php
				if($inquire_enabled) {
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_collections", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_collections", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'));
				}
				if($copy_link_enabled){
					print $this->render('Details/snippets/copy_link_html.php');
				}
?>
			</div>
		</div>
	</div>
<?php
	}
?>
	<div class="row row-cols-1 row-cols-md-2">
		<div class="col">				
			{{{<dl class="mb-0">
				<ifcount code="ca_entities" restrictToRelationshipTypes="artist" min="1">
					<dt><ifcount code="ca_entities" restrictToRelationshipTypes="artist" min="1" max="1"><?= _t('Artist'); ?></ifcount><ifcount code="ca_entities" restrictToRelationshipTypes="artist" min="2"><?= _t('Artists'); ?></ifcount></dt>
					<unit relativeTo="ca_entities" restrictToRelationshipTypes="artist" delimiter=""><dd><l>^ca_entities.preferred_labels</l></dd></unit>
					<unit relativeTo="ca_entities" restrictToRelationshipTypes="artist" delimiter="">
						<ifcount code="ca_objects" restrictToTypes="video" restrictToRelationshipTypes="artist,subject" min="1">
							<dt>Finished Films for ^ca_entities.preferred_labels</dt>
							<unit relativeTo="ca_objects" restrictToTypes="video" restrictToRelationshipTypes="artist,subject">
								<dd><l>^ca_objects.preferred_labels.name</l></dd>
							</unit>
						</ifcount>
					</unit>
				</ifcount>
				<ifcount code="ca_collections.related" restrictToTypes="series" min="1">
					<dt><?= _t('Series'); ?></dt>
					<unit relativeTo="ca_collections.related" restrictToTypes="series" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter="<span aria-hidden='true'> > </span>"><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
				</ifcount>
				<ifcount code="ca_collections.related" restrictToTypes="project" min="1">
					<dt><ifcount code="ca_collections.related" restrictToTypes="project" min="1" max="1"><?= _t('Related Project'); ?></ifcount><ifcount code="ca_collections.related" restrictToTypes="project" min="2"><?= _t('Related Projects'); ?></ifcount></dt>
					<unit relativeTo="ca_collections.related" restrictToTypes="project" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter="<span aria-hidden='true'> > </span>"><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
				</ifcount>
			</dl>}}}
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
	<div class="col"><h2>Footage</h2><hr/></div>
</div>
<div class="row" id="browseResultsContainer">	
	<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_collections.collection_id:'.$t_item->get("ca_collections.collection_id"), '_advanced' => 0)); ?>">
		<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
	</div>
</ifcount>}}}
