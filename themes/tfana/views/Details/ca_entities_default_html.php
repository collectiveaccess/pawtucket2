<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_entities_default_html.php : 
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
 
$t_item = 		$this->getVar("item");
$access_values = 	$this->getVar("access_values");
$options = 			$this->getVar("config_options");
$comments = 		$this->getVar("comments");
$tags = 			$this->getVar("tags_array");
$comments_enabled = $this->getVar("commentsEnabled");
$pdf_enabled = 		$this->getVar("pdfEnabled");
$inquire_enabled = 	$this->getVar("inquireEnabled");
$copy_link_enabled = 	$this->getVar("copyLinkEnabled");
$id =				$t_item->get('ca_entities.entity_id');
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
			<H1 class="fs-3">{{{^ca_entities.preferred_labels.displayname}}}</H1>
			{{{<ifdef code="ca_entities.type_id|ca_entities.idno"><div class="fw-medium mb-3 text-capitalize"><ifdef code="ca_entities.type_id">^ca_entities.type_id</ifdef><ifdef code="ca_entities.idno">, ^ca_entities.idno</ifdef></div></ifdef>}}}
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
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_entities", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_entities", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_entities_summary'));
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
?>{{{<ifdef code="ca_object_representations.media.large">
	<div class="row justify-content-center mb-3">
		<div class="col">
			<div class='detailPrimaryImage object-fit-contain'>^ca_object_representations.media.large</div>
		</div>
	</div>
</ifdef>}}}
	<div class="row row-cols-1">
		<div class="col">				
			{{{<dl class="mb-0">
				<ifdef code="ca_entities.role.company_start_date">
					<dt><?= _t('Company Dates'); ?></dt>
					<unit relativeTo="ca_entities.role" delimiter=""><dd>
						^ca_entities.role.company_start_date - <ifdef code="ca_entities.role.company_end_date_02">^ca_entities.role.company_end_date_02</ifdef><ifdef code="ca_entities.role.company_affiliation">, ^ca_entities.role.company_affiliation</ifdef>
					</dd></unit>
				</ifdef>
				<ifdef code="ca_entities.biography.bio_text">
					<dt><?= _t('Biography'); ?></dt>
					<dd>
						^ca_entities.biography.bio_text
						<ifdef code="ca_entities.biography.bio_source"><div class="pt-2"><i>^ca_entities.biography.bio_source</i></ifdef>
					</dd>
				</ifdef>
				<ifcount code="ca_collections" min="1">
					<dt><ifcount code="ca_collections" min="1" max="1"><?= _t('Related Collection'); ?></ifcount><ifcount code="ca_collections" min="2"><?= _t('Related Collections'); ?></ifcount></dt>
					<unit relativeTo="ca_collections" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
				</ifcount>
				<ifcount code="ca_entities.related" min="1">
					<dt><ifcount code="ca_entities.related" min="1" max="1"><?= _t('Related Person'); ?></ifcount><ifcount code="ca_entities.related" min="2"><?= _t('Related People'); ?></ifcount></dt>
					<unit relativeTo="ca_entities.related" delimiter=""><dd>
						<l>^ca_entities.preferred_labels</l>
					</dd></unit>
				</ifcount>
			</dl>}}}
							
			
		</div>
	</div>
	{{{<ifcount code="ca_occurrences" restrictToTypes="production" min="1">
		<dl class="row">
			<dt class="col-12 mt-3 mb-2"><ifcount code="ca_occurrences" restrictToTypes="production" min="1" max="1"><?= _t('Related Production'); ?></ifcount><ifcount code="ca_occurrences" restrictToTypes="production" min="2"><?= _t('Related Productions'); ?></ifcount></dt>
			<unit relativeTo="ca_entities_x_occurrences" sort="ca_entities_x_occurrences.rank" restrictToTypes="production" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_occurrences.preferred_labels<br> (<ifdef code="ca_entities_x_occurrences.source_info">^ca_entities_x_occurrences.source_info</ifdef><ifnotdef code="ca_entities_x_occurrences.source_info">^relationship_typename</ifnotdef>)</l></dd></unit>
		</dl>
	</ifcount>}}}
	{{{<ifcount code="ca_occurrences" restrictToTypes="event" min="1">
		<dl class="row">
			<dt class="col-12 mt-3 mb-2"><ifcount code="ca_occurrences" restrictToTypes="event" min="1" max="1"><?= _t('Related Event'); ?></ifcount><ifcount code="ca_occurrences" restrictToTypes="event" min="2"><?= _t('Related Events'); ?></ifcount></dt>
			<unit relativeTo="ca_occurrences" restrictToTypes="event" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_occurrences.preferred_labels<br>(^relationship_typename)</l></dd></unit>
		</dl>
	</ifcount>}}}
	{{{<ifcount code="ca_occurrences" restrictToTypes="education" min="1">
		<dl class="row">
			<dt class="col-12 mt-3 mb-2"><ifcount code="ca_occurrences" restrictToTypes="education" min="1" max="1"><?= _t('Related Education Program'); ?></ifcount><ifcount code="ca_occurrences" restrictToTypes="education" min="2"><?= _t('Related Education Programs'); ?></ifcount></dt>
			<unit relativeTo="ca_occurrences" restrictToTypes="education" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_occurrences.preferred_labels<br>(^relationship_typename)</l></dd></unit>
		</dl>
	</ifcount>}}}
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
				<?php print caNavLink($this->request, "Full Results  <i class='ps-2 bi bi-box-arrow-up-right' aria-label='link out'></i>", "btn btn-primary", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $t_item->get("ca_entities.entity_id"))); ?>
			</div>
		</div>
	</div>
</ifcount>}}}