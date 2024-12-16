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
$collection_detail = null;
if(strToLower($t_item->getWithTemplate("^ca_collections.type_id")) == "collection"){
	$collection_detail = true;
}
# --- get collections configuration
$collections_config = caGetCollectionsConfig();
$show_hierarchy_viewer = true;
if($collections_config->get("do_not_display_collection_browser")){
	$show_hierarchy_viewer = false;	
}
# --- get the collection hierarchy parent to use for exportin finding aid
$va_collection_hier_ids = $t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true));
# --- collections are under archives in this system
$top_level_collection_id = $va_collection_hier_ids[1];
?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
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
			<H1 class="fs-2">{{{^ca_collections.preferred_labels.name}}}</H1>
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
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_collections", "id" => $id));
				}
				if($pdf_enabled && ($top_level_collection_id == $id)) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Collection Guide'), "btn btn-sm ps-3 pe-0 fw-medium", "ca_collections", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'));
				}
				if($copy_link_enabled){
?>
				<button type="button" class="btn btn-sm ps-3 pe-0 fw-medium"><i class="bi bi-copy"></i> <?= _t('Copy Link'); ?></button>
<?php
				}
?>
			</div>
		</div>
	</div>
<?php
	}
if($t_item->get("ca_collections.parent_id") || $t_item->get("ca_collections.dates.dates_value") || $t_item->get("ca_collections.abstract")){
?>
	<div class="row row-cols-1">
		<div class="col">				
			<dl class="mb-0">
<?php
			if($t_item->get("ca_collections.parent_id")){
				$hier_path = $t_item->getWithTemplate('<unit relativeTo="ca_collections.hierarchy" delimiter=";"><l>^ca_collections.preferred_labels.name</l></unit>', array("checkAccess" => $access_values));
				$hier_parts = explode(";", $hier_path);
				array_pop($hier_parts);				
?>
				<dt>Part of</dt>
				<dd><?php print join(" > ", $hier_parts); ?></dd>
<?php
			}
?>				
			{{{
				<ifdef code="ca_collections.dates.dates_value">
					<dt><?= _t('Date'); ?></dt>
					<unit relativeTo="ca_collections.dates" delimiter=""><dd>^ca_collections.dates.dates_value<ifdef code="ca_collections.dates.dates_type"> (^ca_collections.dates.dates_type)</ifdef></dd></unit>
				</ifdef>
				<ifdef code="ca_collections.abstract">
					<dt><?= _t('Abstract'); ?></dt>
					<dd class="overflow-y-scroll" style="max-height: 200px;">
						<?php print caConvertLineBreaks($t_item->get("ca_collections.abstract")); ?>
					</dd>
				</ifdef>
			}}}	
			</dl>				
		</div>
	</div>
<?php
}
if($collection_detail){
?>
{{{<ifcount code="ca_objects" min="1" restrictToRelationshipTypes="featured">
	
	<div class="row pt-5">
		<div class="col"><h2 class="fs-4">Sample Images</h2><hr/></div>
	</div>
<?php
if($vs_collections_item_availablity = $this->getVar("collections_item_availablity")){
?>
	<div class="pb-4 fs-4 fst-italic">
		<?php print $vs_collections_item_availablity; ?>
	</div>
<?php
}
?>
	<div id="browseResultsContainer" class="row mb-3">
		<unit relativeTo="ca_objects" restrictToRelationshipTypes="featured" delimiter="" limit="8">
			<div class='col-sm-6 col-md-4 col-lg-3 d-flex'>
				<div class='card flex-grow-1 width-100 rounded-0 shadow-sm bg-white border-0 mb-4'>
				  <l>^ca_object_representations.media.large%class=' card-img-top object-fit-contain px-3 pt-3 rounded-0 '</l>
				  	<div class='card-body'>
						<l>^ca_objects.preferred_labels.name</l>
					</div>
				 </div>
			</div>
		</unit>
	</div>
	<div class="row row-cols-1 mb-4 pb-4">
		<div class="col text-center"><?php print caNavLink($this->request, "Browse All", "btn btn-primary", "", "Browse", "objects", array("facet" => "collection_facet", "id" => $id)); ?></div>
	</div>
</ifcount>}}}
<?php
}
	if ($show_hierarchy_viewer) {	
?>
		<div hx-trigger="load" hx-get="<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $t_item->get('collection_id'))); ?>"  ></div>
<?php				
	}	
if(!$collection_detail){								
?>							

{{{<ifcount code="ca_objects" min="1">
<div class="row pt-5">
	<div class="col"><h2 class="fs-3">Related Objects</h2><hr/></div>
</div>
<div class="row" id="browseResultsContainer">	
	<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_collections.collection_id:'.$t_item->get("ca_collections.collection_id"))); ?>">
		<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
	</div>
</ifcount>}}}
<?php
}
?>