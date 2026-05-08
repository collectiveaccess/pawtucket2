<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
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
$t_object = 		$this->getVar("item");
$access_values = 	$this->getVar("access_values");
$options = 			$this->getVar("config_options");
$comments = 		$this->getVar("comments");
$tags = 			$this->getVar("tags_array");
$comments_enabled = $this->getVar("commentsEnabled");
$pdf_enabled = 		$this->getVar("pdfEnabled");
$inquire_enabled = 	$this->getVar("inquireEnabled");
$copy_link_enabled = 	$this->getVar("copyLinkEnabled");
$id =				$t_object->getPrimaryKey();
$show_nav = 		($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = $this->getVar('mapOptions') ?? [];
$media_options = $this->getVar('media_options') ?? [];

$lightboxes = $this->getVar('lightboxes') ?? [];
$in_lightboxes = $this->getVar('inLightboxes') ?? [];

$media_options = array_merge($media_options, [
	'id' => 'mediaviewer'
]);
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
			<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_objects.type_id|ca_objects.idno"><div class="fw-medium mb-3"><ifdef code="ca_objects.type_id">^ca_objects.type_id</ifdef><ifdef code="ca_objects.idno">, ^ca_objects.idno</ifdef></div></ifdef>}}}
			<hr class="mb-0">
		</div>
	</div>
<?php
	if(caDisplayLightbox($this->request) || $inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
	<div class="row">
		<div class="col text-center text-md-end">
			<div class="btn-group" role="group" aria-label="Detail Controls">
<?php
				if($inquire_enabled) {
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_objects", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_objects", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'));
				}
				if($copy_link_enabled){
					print $this->render('Details/snippets/copy_link_html.php');
				}
?>				
			</div>
			<?= $this->render('Details/snippets/lightbox_list_html.php'); ?>
		</div>
	</div>
<?php
	}
?>

	<div class="row">
<?php
	if(trim($this->getVar("media_viewer"))){
?>
		<div class="col-md-6">
			{{{media_viewer}}}
		</div>
<?php
	}
?>
		<div class="col-md-6 pb-4">
			<div class="bg-light py-3 px-4 mb-3 h-100"><!-- height is to make the gray background of box same height as the containing row -->			
				{{{<dl class="mb-0">
					<ifcount code="ca_collections" min="1">
						<dt><?= _t('Part of'); ?></dt>
						<unit relativeTo="ca_collections" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name (^ca_collections.type_id)</l></unit></dd></unit>
					</ifcount>
					<ifdef code="ca_objects.legacy_num">
						<dt><?= _t('Legacy Number'); ?></dt>
						<dd>^ca_objects.legacy_num</dd>
					</ifdef>
					<ifdef code="ca_objects.tech_spec">
						<dt><?= _t('Technical Specifications'); ?></dt>
						<dd><ifdef code="ca_objects.tech_spec.tech_cambrand|ca_objects.tech_spec.tech_cam_num|ca_objects.tech_spec.tech_camcard_num"><div><ifdef code="ca_objects.tech_spec.tech_cambrand"><span class='fw-bolder'>Camera:</span> ^ca_objects.tech_spec.tech_cambrand </ifdef><ifdef code="ca_objects.tech_spec.tech_cam_num"><span class='fw-bolder'>Camera #:</span> ^ca_objects.tech_spec.tech_cam_num </ifdef><ifdef code="ca_objects.tech_spec.tech_camcard_num"><span class='fw-bolder'>Camera Card #:</span> ^ca_objects.tech_spec.tech_camcard_num </ifdef></div></ifdef>
							<ifdef code="ca_objects.tech_spec.tech_wrapper|ca_objects.tech_spec.tech_codec|ca_objects.tech_spec.tech_res|ca_objects.tech_spec.tech_rate"><div><ifdef code="ca_objects.tech_spec.tech_wrapper"><span class='fw-bolder'>Wrapper:</span> ^ca_objects.tech_spec.tech_wrapper </ifdef><ifdef code="ca_objects.tech_spec.tech_codec"><span class='fw-bolder'>Codec:</span> ^ca_objects.tech_spec.tech_codec </ifdef><ifdef code="ca_objects.tech_spec.tech_res"><span class='fw-bolder'>Frame Size:</span> ^ca_objects.tech_spec.tech_res </ifdef><ifdef code="ca_objects.tech_spec.tech_rate"><span class='fw-bolder'>Frame Rate:</span> ^ca_objects.tech_spec.tech_rate </ifdef></div></ifdef>
							<ifdef code="ca_objects.tech_spec.tech_note"><div><span class='fw-bolder'>Notes:</span> ^ca_objects.tech_spec.tech_note</div></ifdef>
						</dd>
					</ifdef>
					<ifdef code="ca_objects.acquired_from">
						<dt><?= _t('Acquired From'); ?></dt>
						<unit relativeTo="ca_objects.acquired_from" delimiter="">
							<dd><ifdef code="ca_objects.acquired_from.acq_name">^ca_objects.acquired_from.acq_name </ifdef><ifdef code="ca_objects.acquired_from.acq_title">(^ca_objects.acquired_from.acq_title) </ifdef><ifdef code="ca_objects.acquired_from.acq_org">^ca_objects.acquired_from.acq_org</ifdef></dd>
						</unit>
					</ifdef>
					<ifdef code="ca_objects.common_date">
						<dt><?= _t('Date'); ?></dt>
						<dd>^ca_objects.common_date</dd>
					</ifdef>
					<ifdef code="ca_objects.runtime">
						<dt><?= _t('Duration'); ?></dt>
						<dd>^ca_objects.runtime</dd>
					</ifdef>
					<ifdef code="ca_objects.instantiationFileSizee">
						<dt><?= _t('File Size'); ?></dt>
						<dd>^ca_objects.instantiationFileSize</dd>
					</ifdef>
					<ifdef code="ca_objects.num_clips">
						<dt><?= _t('Number of Clips'); ?></dt>
						<dd>^ca_objects.num_clips</dd>
					</ifdef>
					<ifdef code="ca_objects.timecode_type">
						<dt><?= _t('Timecode Type'); ?></dt>
						<dd>^ca_objects.timecode_type</dd>
					</ifdef>
					<ifdef code="ca_objects.jammed_cam">
						<dt><?= _t('Does Camera and audio Mixer Timecode Match?'); ?></dt>
						<dd>^ca_objects.jammed_cam</dd>
					</ifdef>
					<ifdef code="ca_objects.track">
						<dt><?= _t('Tracks'); ?></dt>
						<unit relativeTo="ca_objects.track" delimiter=""><dd><ifdef code="ca_objects.track.audio_track_no">^ca_objects.track.audio_track_no</ifdef><ifdef code="ca_objects.track.audio_track_options"><ifdef code="ca_objects.track.audio_track_no">, </ifdef>^ca_objects.track.audio_track_options</ifdef></dd></unit>
					</ifdef>
					
				</dl>}}}
				<div><div id="map" class="map">{{{map}}}</div></div>
			</div>
			
		</div>
	</div>
	{{{<ifcount code="ca_entities" min="1">
		<dl class="row">
			<dt class="col-12 mt-3 mb-2"><ifcount code="ca_entities" min="1" max="1"><?= _t('Related Person'); ?></ifcount><ifcount code="ca_entities" min="2"><?= _t('Related People'); ?></ifcount></dt>
			<unit relativeTo="ca_entities" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 px-3 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_entities.preferred_labels<br>^relationship_typename</l></dd></unit>		
		</dl>
	</ifcount>}}}
	{{{<ifcount code="ca_occurrences" min="1">
		<dl class="row">
			<dt class="col-12 mt-3 mb-2"><ifcount code="ca_occurrences" min="1" max="1"><?= _t('Related Occurrence'); ?></ifcount><ifcount code="ca_occurrences" min="2"><?= _t('Related Occurrences'); ?></ifcount></dt>
			<unit relativeTo="ca_occurrences" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 px-3 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_occurrences.preferred_labels<br>^relationship_typename</l></dd></unit>
		</dl>
	</ifcount>}}}
	{{{<ifcount code="ca_places" min="1">
		<dl class="row">
			<dt class="col-12 mt-3 mb-2"><ifcount code="ca_places" min="1" max="1"><?= _t('Related Place'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Related Places'); ?></ifcount></dt>
			<unit relativeTo="ca_places" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 px-3 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_places.preferred_labels<br>^relationship_typename</l></dd></unit>
		</dl>
	</ifcount>}}}
