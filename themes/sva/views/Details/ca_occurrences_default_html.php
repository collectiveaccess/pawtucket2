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
			<nav aria-label="result">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</nav>
		</div>
	</div>
<?php
	}
?>
	<div class="row<?php print ($show_nav) ? " mt-2 mt-md-n3" : ""; ?>">
		<div class="col-md-12">
			<H1 class="fs-3">{{{^ca_occurrences.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_occurrences.type_id|ca_occurrences.idno"><div class="fw-medium mb-3 text-capitalize"><ifdef code="ca_occurrences.type_id">^ca_occurrences.type_id</ifdef><ifdef code="ca_occurrences.idno">, ^ca_occurrences.idno</ifdef></div></ifdef>}}}
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
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm  ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_occurrences", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm  ps-3 pe-0 fw-medium", "ca_occurrences", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_occurrences_summary'));
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
?>

	<div class="row mb-4">
		<div class="col">				
			{{{<dl class="mb-0">
				
				<ifdef code="ca_occurrences.Ex_type">
					<dt><?= _t('Exhibition Type'); ?></dt>
					<dd>
						^ca_occurrences.Ex_type
					</dd>
				</ifdef><ifdef code="ca_occurrences.event_type">
					<dt><?= _t('Event Type'); ?></dt>
					<dd>
						^ca_occurrences.event_type
					</dd>
				</ifdef>
				<ifcount code="ca_places" min="1">
					<dt><ifcount code="ca_places" min="1" max="1"><?= _t('Place'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Places'); ?></ifcount></dt>
					<unit relativeTo="ca_places" delimiter=""><dd>^ca_places.preferred_labels</dd></unit>
				</ifcount>
				<ifdef code="ca_occurrences.dates.dates_value">
					<dt><?= _t('Date'); ?></dt>
					<unit relativeTo="ca_occurrences.dates" delimiter=""><if rule="^ca_occurrences.dates.dates_type !~ /Reception/"><dd>^ca_occurrences.dates.dates_value (^ca_occurrences.dates.dates_type)</dd></if></unit>
				</ifdef>
				<ifdef code="ca_occurrences.description_public">
					<dt><?= _t('Description'); ?></dt>
					<dd>
						^ca_occurrences.description_public
					</dd>
				</ifdef>
				<ifdef code="ca_occurrences.external_link.url_entry">
					<dt><?= _t('External Link'); ?></dt>
					<unit relativeTo="ca_occurrences.external_link" delimiter=""><dd><a href="^ca_occurrences.external_link.url_entry"><ifdef code="ca_occurrences.external_link.url_source">^ca_occurrences.external_link.url_entry</ifdef><ifnotdef code="ca_occurrences.external_link.url_source">^ca_occurrences.external_link.url_source</ifnotdef></a></dd></unit>
				</ifdef>
				<ifcount code="ca_collections" min="1">
					<dt><ifcount code="ca_collections" min="1"><?= _t('Related Collections'); ?></ifcount></dt>
					<unit relativeTo="ca_collections" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
				</ifcount>
				<ifcount code="ca_occurrences" min="1">
					<dt><ifcount code="ca_occurrences.related" min="1"><?= _t('Related Exhibitions & Events'); ?></ifcount></dt>
					<unit relativeTo="ca_occurrences.related" delimiter=""><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
				</ifcount>
			</dl>}}}
		</div>
	</div>
	{{{<ifcount code="ca_objects" min="1">
	
	<div class="row">
		<div class="col"><h2 class="fs-3">Related Objects</h2><hr></div>
	</div>
	<div id="browseResultsContainer" class="row mb-3">
		<unit relativeTo="ca_objects" delimiter="" limit="8">
			<div class='col-sm-6 col-md-4 col-lg-3 d-flex'>
				<div class='card flex-grow-1 width-100 rounded-0 shadow-sm bg-white border-0 mb-4'>
				  <l>^ca_object_representations.media.large%class='card-img-top object-fit-contain px-3 pt-3 rounded-0'</l>
				  	<div class='card-body'>
						<l>^ca_objects.preferred_labels.name</l>
					</div>
				 </div>
			</div>
		</unit>
	</div>
	<ifcount code="ca_objects" min="9">
		<div class="row row-cols-1 mb-4">
			<div class="col text-center"><?php print caNavLink($this->request, "Browse All Objects", "btn btn-primary", "", "Browse", "objects", array("facet" => "occurrence_facet", "id" => $id)); ?></div>
		</div>
	</ifcount>
</ifcount>}}}
	{{{<ifcount code="ca_entities" min="1">
		<dl class="row">
			<dt class="col-12 mt-3 mb-2"><ifcount code="ca_entities" min="1"><h2 class="fs-3"><?= _t('Related People & Organizations'); ?></h2><hr></ifcount></dt>
			<unit relativeTo="ca_entities" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 px-2 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black"><div class="d-block">^ca_entities.preferred_labels<br><i>^relationship_typename</i></div></l></dd></unit>
		</dl>
	</ifcount>}}}