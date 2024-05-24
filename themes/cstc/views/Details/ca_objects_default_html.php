<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2023 Whirl-i-Gig
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
$id =				$t_object->get('ca_objects.object_id');
$show_nav = 		($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = $this->getVar('mapOptions') ?? [];
$media_options = $this->getVar('media_options') ?? [];

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
			{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
		</div>
	</div>
<?php
}
?>
	<div class="row<?php print ($show_nav) ? " mt-2 mt-md-n3" : ""; ?>">
		<div class="col-md-12">
			<H1 class="fs-3">{{{^ca_objects.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_objects.type_id|ca_objects.idno"><div class="fw-medium mb-3"><ifdef code="ca_objects.type_id">^ca_objects.type_id</ifdef><ifdef code="ca_objects.idno">, ^ca_objects.idno</ifdef></div></ifdef>}}}
			<hr class="mb-0"/>
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
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_objects", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_objects", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'));
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

	<div class="row">
		<div class="col-md-6">
<?php
		if($media_viewer = $this->getVar("media_viewer")){
			print $media_viewer;
		}elseif($t_object->get("ca_object_representations.representation_id")){
?>
			{{{digitized_media_message}}}
<?php
		}
?>
		</div>
		<div class="col-md-6">
			<div class="bg-light py-3 px-4 mb-3 h-100">
				<div class="row">
					<div class="col">				
						{{{<dl class="mb-0">
							<ifdef code="ca_objects.display_date">
								<dt><?= _t('Date'); ?></dt>
								<dd>^ca_objects.display_date%delimiter=,_</dd>
							</ifdef>
		
							<ifdef code="ca_objects.extent_text">
								<dt><?= _t('Extent and Medium'); ?></dt>
								<dd>^ca_objects.extent_text</dd>
							</ifdef>
							<ifdef code="ca_objects.material_designations">
								<dt><?= _t('Material Designation'); ?></dt>
								<dd>^ca_objects.material_designations</dd>
							</ifdef>
							<ifdef code="ca_objects.cartographic_format">
								<dt><?= _t('Format'); ?></dt>
								<dd>^ca_objects.cartographic_format</dd>
							</ifdef>
							<ifdef code="ca_objects.moving_image_type">
								<dt><?= _t('Format'); ?></dt>
								<dd>^ca_objects.moving_image_type</dd>
							</ifdef>
							<ifdef code="ca_objects.sound_recording_type">
								<dt><?= _t('Format'); ?></dt>
								<dd>^ca_objects.sound_recording_type</dd>
							</ifdef>
							<ifdef code="ca_objects.textual_format">
								<dt><?= _t('Format'); ?></dt>
								<dd>^ca_objects.textual_format</dd>
							</ifdef>
							<ifdef code="ca_objects.electronic_resource_format">
								<dt><?= _t('Format'); ?></dt>
								<dd>^ca_objects.electronic_resource_format</dd>
							</ifdef>
							<ifdef code="ca_objects.graphic_formats">
								<dt><?= _t('Format'); ?></dt>
								<dd>^ca_objects.graphic_formats</dd>
							</ifdef>
							<ifdef code="ca_objects.genre">
								<dt><?= _t('Genre'); ?></dt>
								<dd>^ca_objects.genre</dd>
							</ifdef>
							<ifdef code="ca_objects.scopecontent">
								<dt><?= _t('Scope and Content'); ?></dt>
								<dd>^ca_objects.scopecontent</dd>
							</ifdef>
							<ifdef code="ca_objects.cultural_narrative">
								<dt><?= _t('Cultural Narrative'); ?></dt>
								<dd>^ca_objects.cultural_narrative</dd>
							</ifdef>
							<ifdef code="ca_objects.traditional_knowledge">
								<dt><?= _t('Traditional Knowledge'); ?></dt>
								<dd>^ca_objects.traditional_knowledge</dd>
							</ifdef>
							<ifdef code="ca_objects.langmaterial">
								<dt><?= _t('Language'); ?></dt>
								<dd>^ca_objects.langmaterial%delimiter=,_</dd>
							</ifdef>
							<ifdef code="ca_objects.accessrestrict">
								<dt><?= _t('Conditions Governing Access'); ?></dt>
								<dd>^ca_objects.accessrestrict</dd>
							</ifdef>
							<ifdef code="ca_objects.reproduction">
								<dt><?= _t('Conditions Governing Reproduction'); ?></dt>
								<dd>^ca_objects.reproduction</dd>
							</ifdef>
							<ifdef code="ca_objects.restriction_statement">
								<dt><?= _t('Restrictions'); ?></dt>
								<dd>^ca_objects.restriction_statement%delimiter=,_</dd>
							</ifdef>
							<ifdef code="ca_objects.themes">
								<dt><?= _t('Themes'); ?></dt>
								<dd>^ca_objects.themes</dd>
							</ifdef>
							<ifdef code="ca_objects.keywords_text">
								<dt><?= _t('Keywords'); ?></dt>
								<dd>^ca_objects.keywords_text%delimiter=,_</dd>
							</ifdef>
							
						</dl>}}}
<?= $this->render("Details/snippets/related_entities_by_rel_type_html.php"); ?>						
						{{{<dl class="mb-0">
							<ifcount code="ca_collections" min="1">
								<dt><ifcount code="ca_collections" min="1" max="1"><?= _t('Related Collection'); ?></ifcount><ifcount code="ca_collections" min="2"><?= _t('Related Collections'); ?></ifcount></dt>
								<unit relativeTo="ca_collections" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
							</ifcount>
				
							<ifcount code="ca_places" min="1">
								<div class="unit">
									<dt><ifcount code="ca_places" min="1" max="1"><?= _t('Related Place'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Related Places'); ?></ifcount></dt>
									<unit relativeTo="ca_places" delimiter=""><dd>^ca_places.preferred_labels (^relationship_typename)</dd></unit>
								</div>
							</ifcount>
						</dl>}}}
						
					</div>
				</div>
			</div>
			<div id="map" class="py-3">{{{map}}}</div>
		</div>
	</div>
