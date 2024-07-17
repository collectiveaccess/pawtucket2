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

$collection_ids = $t_item->get("ca_collections.children.collection_id", array("restrictToTypes" => "collection", "checkAccess" => $access_values, "returnAsArray" => true));
if(is_array($collection_ids) && sizeof($collection_ids)){
	$qr_collections = caMakeSearchResult("ca_collections", $collection_ids);
}
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
			<nav aria-label="result navigation">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</nav>
		</div>
	</div>
<?php
	}
?>
	<div class="row<?php print ($show_nav) ? " mt-2 mt-md-n3" : ""; ?>">
		<div class="col-md-12">
			<H1 class="fs-3">{{{^ca_collections.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_collections.idno"><div class="fw-medium mb-3 text-capitalize">^ca_collections.idno</div></ifdef>}}}
			<hr class="mb-0 opacity-100">
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
				#if($pdf_enabled) {
				#	print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm ps-3 pe-0 fw-medium", "ca_collections", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'));
				#}
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
?>
	<div class="row">
		<div class="col-12">				
			{{{<dl class="mb-4">
				<ifdef code="ca_collections.description_archival">
					<dd>
						^ca_collections.description_archival
					</dd>
				</ifdef>
			</dl>}}}
		</div>
	</div>
<?php
	if($qr_collections && $qr_collections->numHits()) {
?>
		<div class="row">
<?php
		while($qr_collections->nextHit()) { 
			# --- image on collection record or related object?
			if($vs_image_class){
				if(!($vs_thumbnail = $qr_collections->get("ca_object_representations.media.medium", array("checkAccess" => $va_access_values, "class" => $vs_image_class)))){
					$vs_thumbnail = $qr_collections->getWithTemplate("<unit relativeTo='ca_objects' length='1'><ifdef code='ca_object_representations.media.medium'>^ca_object_representations.media.medium</ifdef></unit>", array("checkAccess" => $va_access_values, "class" => $vs_image_class));
				}
			}			
			
			print "<div class='col-sm-6 col-lg-4 d-flex'>";
			$vs_tmp = "<div class='card flex-grow-1 width-100 rounded-0 bg-white border-0 mb-4'>".$vs_thumbnail."
							<div class='card-body'>".$qr_collections->getWithTemplate("<div class='card-title fw-medium lh-sm fs-4 sansserif'>^ca_collections.preferred_labels</div><ifdef code='ca_collections.idno'><div class='card-text small text-body-secondary'>^ca_collections.idno</div></ifdef><ifdef code='ca_collections.abstract'><p class='card-text small lh-sm'>^ca_collections.abstract%truncate=250&ellipsis=1</p></ifdef>")."</div>
							<div class='card-footer text-end bg-transparent border-0'>
								<button class='btn btn-primary'>View <i class='bi bi-arrow-right small'></i></button>
							</div>
						</div>";
			print caDetailLink($this->request, $vs_tmp, "text-decoration-none d-flex w-100", "ca_collections",  $qr_collections->get("ca_collections.collection_id"));
			print "</div>";
		}
?>
		</div>
<?php
	}
?>				
{{{<ifcount code="ca_objects" min="1">
<div class="row">
	<div class="col"><h2>Related Objects</h2><hr/></div>
</div>
<div class="row" id="browseResultsContainer">	
	<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_collections.collection_id:'.$t_item->get("ca_collections.collection_id"))); ?>">
		<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
	</div>
</ifcount>}}}
