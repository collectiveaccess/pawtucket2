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
{{{<ifdef code="ca_object_representations.media.large">
	<div class="row justify-content-center mb-3">
		<div class="col">
			<div class='detailPrimaryImage object-fit-contain'>^ca_object_representations.media.large</div>
		</div>
	</div>
</ifdef>}}}
	<div class="row row-cols-1 row-cols-md-2">
		<div class="col">				
			{{{<dl class="mb-0">
				<ifdef code="ca_collections.parent_id">
					<dt>Part of</dt>
					<dd><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></dd>
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
		</div>
		<div class="col">
			<?= $this->render("Details/snippets/related_entities_by_rel_type_html.php"); ?>

			{{{<dl class="mb-0">
				<ifcount code="ca_occurrences" restrictToTypes="production" min="1">
					<dt><ifcount code="ca_occurrences" restrictToTypes="production" min="1" max="1"><?= _t('Related Production'); ?></ifcount><ifcount code="ca_occurrences" restrictToTypes="production" min="2"><?= _t('Related Productions'); ?></ifcount></dt>
					<unit relativeTo="ca_occurrences" restrictToTypes="production" delimiter=""><dd>
						<l>^ca_occurrences.preferred_labels</l>
					</dd></unit>
				</ifcount>
				<ifcount code="ca_occurrences" restrictToTypes="event" min="1">
					<dt><ifcount code="ca_occurrences" restrictToTypes="event" min="1" max="1"><?= _t('Related Event'); ?></ifcount><ifcount code="ca_occurrences" restrictToTypes="event" min="2"><?= _t('Related Events'); ?></ifcount></dt>
					<unit relativeTo="ca_occurrences" restrictToTypes="event" delimiter=""><dd>
						<l>^ca_occurrences.preferred_labels</l>
					</dd></unit>
				</ifcount>
				<ifcount code="ca_occurrences" restrictToTypes="education" min="1">
					<dt><ifcount code="ca_occurrences" restrictToTypes="education" min="1" max="1"><?= _t('Related Education Program'); ?></ifcount><ifcount code="ca_occurrences" restrictToTypes="education" min="2"><?= _t('Related Education Program'); ?></ifcount></dt>
					<unit relativeTo="ca_occurrences" restrictToTypes="education" delimiter=""><dd>
						<l>^ca_occurrences.preferred_labels</l>
					</dd></unit>
				</ifcount>

				<ifdef code="ca_collections.rightsStatement.rightsStatement_text">
					<dt><?= _t('Rights Statement'); ?></dt>
					<dd>^ca_collections.rightsStatement.rightsStatement_text</dd>
				</ifdef>
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
	<div class="row">
		<div class="col"><h2>Related Objects</h2><hr></div>
	</div>
	<div class="row" id="browseResultsContainer">	
		<unit relativeTo="ca_objects" delimiter="" limit="8">



				<div class='col-sm-6 col-md-4 col-lg-3 d-flex'>
					<div class='card flex-grow-1 width-100 rounded-0 shadow border-0 mb-4'>
					  <l>^ca_object_representations.media.medium%class="card-img-top object-fit-contain px-3 pt-3 rounded-0"</l>
						<div class='card-body'>
							<div class='card-title'><small class='text-body-secondary'>^ca_objects.type_id, ^ca_objects.idno</small><div class='fw-medium lh-sm fs-5'><l>^ca_objects.preferred_labels</l></div></div><ifdef code='ca_objects.date'><p class='card-text small lh-sm text-truncate'>^ca_objects.date</p></ifdef>
						</div>
						<div class='card-footer text-end bg-transparent'>
							<l class="link-dark mx-1"><i class='bi bi-arrow-right-square'></i></l>
						</div>
					 </div>	
				</div><!-- end col -->

		
		</unit>
	</div>
	<ifcount code="ca_objects" min="9">
		<div class="row">
			<div class="col text-center pb-4 mb-4">
				<?php print caNavLink($this->request, "Full Results  <i class='ps-2 bi bi-box-arrow-up-right' aria-label='link out'></i>", "btn btn-primary", "", "Browse", "objects", array("facet" => "collection_facet", "id" => $t_item->get("ca_collections.collection_id"))); ?>
			</div>
		</div>
	</div>
</ifcount>}}}