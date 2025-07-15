<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_occurrences_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
 
$t_item = 			$this->getVar("item");
$access_values = 	$this->getVar("access_values");
$options = 			$this->getVar("config_options");
$comments = 		$this->getVar("comments");
$tags = 			$this->getVar("tags_array");
$comments_enabled = $this->getVar("commentsEnabled");
$pdf_enabled = 		$this->getVar("pdfEnabled");
$inquire_enabled = 	$this->getVar("inquireEnabled");
$copy_link_enabled = 	$this->getVar("copyLinkEnabled");
$id =				$t_item->get('ca_occurrences.occurrence_id');
$show_nav = 		($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = $this->getVar('mapOptions') ?? [];
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
			<H1 class="fs-3">{{{^ca_occurrences.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_occurrences.type_id"><div class="fw-medium mb-3 text-capitalize">^ca_occurrences.type_id</div></ifdef>}}}
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
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_occurrences", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_occurrences", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_occurrences_summary'));
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
	{{{<ifcount code="ca_occurrences.children" min="1">
		<dl class="row">
			<ifcount code="ca_occurrences.children" restrictToTypes="production" min="1">
				<dt class="col-12 mt-3 mb-2"><ifcount code="ca_occurrences.children" restrictToTypes="production" min="1" max="1"><?= _t('Production'); ?></ifcount><ifcount code="ca_occurrences.children" restrictToTypes="production" min="2"><?= _t('Productions'); ?></ifcount></dt>
				<unit relativeTo="ca_occurrences.children" restrictToTypes="production" delimiter="">
					<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center">
						<l class="pt-3 pb-4 px-3 align-items-center justify-content-center h-100 w-100 text-black detailRelatedImage d-block bg-light">
							<ifcount code="ca_objects" restrictToRelationshipTypes="select" min="1"><unit relativeTo="ca_objects" restrictToRelationshipTypes="select" limit="1" delimiter=" ">
								<ifdef code="ca_object_representations.media.large"><div>
									^ca_object_representations.media.large
								</div></ifdef>
							</unit></ifcount>
							<div class="fw-bold">^ca_occurrences.preferred_labels</div><ifdef code="ca_occurrences.date"><div class="small">^ca_occurrences.date%delimiter=,_</div></ifdef>
						</l>
					</dd>
				</unit>
			</ifcount>
			<ifcount code="ca_occurrences.children" restrictToTypes="event" min="1">
				<dt class="col-12 mt-3 mb-2"><ifcount code="ca_occurrences.children" restrictToTypes="event" min="1" max="1"><?= _t('Event'); ?></ifcount><ifcount code="ca_occurrences.children" restrictToTypes="event" min="2"><?= _t('Events'); ?></ifcount></dt>
				<unit relativeTo="ca_occurrences.children" restrictToTypes="event" delimiter="">
					<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center">
						<l class="pt-3 pb-4 px-3 align-items-center justify-content-center h-100 w-100 text-black detailRelatedImage d-block bg-light">
							<ifcount code="ca_objects" restrictToRelationshipTypes="select" min="1"><unit relativeTo="ca_objects" restrictToRelationshipTypes="select" limit="1" delimiter=" ">
								<ifdef code="ca_object_representations.media.large"><div>
									^ca_object_representations.media.large
								</div></ifdef>
							</unit></ifcount>
							<div class="fw-bold">^ca_occurrences.preferred_labels</div><ifdef code="ca_occurrences.date"><div class="small">^ca_occurrences.date%delimiter=,_</div></ifdef>
						</l>
					</dd>
				</unit>
			</ifcount>
			<ifcount code="ca_occurrences.children" restrictToTypes="education" min="1">
				<dt class="col-12 mt-3 mb-2"><ifcount code="ca_occurrences.children" restrictToTypes="education" min="1" max="1"><?= _t('Education Program'); ?></ifcount><ifcount code="ca_occurrences.children" restrictToTypes="education" min="2"><?= _t('Education Programs'); ?></ifcount></dt>
				<unit relativeTo="ca_occurrences.children" restrictToTypes="education" delimiter="">
					<dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center">
						<l class="pt-3 pb-4 px-3 align-items-center justify-content-center h-100 w-100 text-black detailRelatedImage d-block bg-light">
							<ifcount code="ca_objects" restrictToRelationshipTypes="select" min="1"><unit relativeTo="ca_objects" restrictToRelationshipTypes="select" limit="1" delimiter=" ">
								<ifdef code="ca_object_representations.media.large"><div>
									^ca_object_representations.media.large
								</div></ifdef>
							</unit></ifcount>
							<div class="fw-bold">^ca_occurrences.preferred_labels</div><ifdef code="ca_occurrences.date"><div class="small">^ca_occurrences.date%delimiter=,_</div></ifdef>
						</l>
					</dd>
				</unit>
			</ifcount>
		</dl>
	</ifcount>}}}
<?php
if($rel_object_ids = $t_item->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $access_values))){
	$o_context = new ResultContext($this->request, 'ca_objects', 'detailrelated');
	$o_context->setAsLastFind();
	$o_context->setResultList($rel_object_ids);
	$o_context->saveContext();
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
							<div class='card-title'><small class='text-body-secondary'>^ca_objects.type_id, ^ca_objects.idno</small><div class='fw-medium lh-sm fs-5'><l>^ca_objects.preferred_labels</l></div></div><ifdef code='ca_objects.date'><p class='card-text small lh-sm text-truncate'>^ca_objects.date%delimiter=,_</p></ifdef>
						</div>
						<div class='card-footer text-end bg-transparent'>
							<l class="link-dark mx-1"><i class='bi bi-arrow-right-square' aria-label='view record'></i></l>
						</div>
					 </div>	
				</div><!-- end col -->

		
		</unit>
	</div>
	<ifcount code="ca_objects" min="9">
		<div class="row">
			<div class="col text-center pb-4 mb-4">
				<?php print caNavLink($this->request, "Full Results  <i class='ps-2 bi bi-box-arrow-up-right' aria-label='link out'></i>", "btn btn-primary", "", "Browse", "objects", array("facet" => "occ_facet", "id" => $t_item->get("ca_occurrences.occurrence_id"))); ?>
			</div>
		</div>
	</div>
</ifcount>}}}