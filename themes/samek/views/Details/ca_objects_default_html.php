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

	<div class="row mt-3">

		<div class="col-md-6">
			{{{media_viewer}}}
		</div>

		<div class="col-md-6">
			<div class="bg-body-tertiary py-3 px-4 mb-3">
				<div class="row">
					<div class="col">				
						{{{<dl class="mb-0">

							<H1 class="fs-3">^ca_objects.preferred_labels.name</H1>
							<hr class="mb-3">

							<?= $this->render("Details/snippets/related_entities_by_rel_type_html.php"); ?>

							<if rule="^ca_objects.creation_date_display !~ /-/">
								<ifdef code="ca_objects.creation_date_display">
									<dt><?= _t('Date'); ?></dt>
									<dd>^ca_objects.creation_date_display</dd>
								</ifdef>
							</if>
		
							<ifdef code="ca_objects.medium_container.display_medium_support">
								<dt><?= _t('Medium'); ?></dt>
								<dd>^ca_objects.medium_container.display_medium_support</dd>
							</ifdef>

							<ifdef code="ca_objects.dimensions.display_dimensions">
								<dt><?= _t('Dimensions'); ?></dt>
								<dd><unit delimiter="<br>">^ca_objects.dimensions.display_dimensions (^ca_objects.dimensions.Type)</unit></dd>
							</ifdef>

							<ifdef code="ca_objects.credit_line.credit_text">
								<dt><?= _t('Credit Line'); ?></dt>
								<dd>^ca_objects.credit_line.credit_text</dd>
							</ifdef>

							<ifdef code="ca_objects.idno">
								<dt><?= _t('Accession Number'); ?></dt>
								<dd>^ca_objects.idno</dd>
							</ifdef>

							<hr>

							<ifdef code="ca_objects.on_view.on_view_type">
								<dt><?= _t('On View/Off View'); ?></dt>
								<dd>^ca_objects.on_view.on_view_type</dd>
							</ifdef>

							<ifdef code="ca_objects.on_view.view_location">
								<dt><?= _t('View Location'); ?></dt>
								<dd>^ca_objects.on_view.view_location</dd>
							</ifdef>

							<ifdef code="ca_objects.copyright_text">
								<dt><?= _t('Copyright'); ?></dt>
								<dd>^ca_objects.copyright_type ^ca_objects.copyright_text</dd>
							</ifdef>

							<?php
								if($t_object->get("ca_objects.academic_tags")){
									if($acc_links = caGetBrowseLinks($t_object, 'ca_objects.academic_tags', ['template' => '<l>^ca_objects.academic_tags</l>', 'linkTemplate' => '^LINK'])) {
							?>
										<dt><?= _t('Academic Tags'); ?></dt>
										<dd><?= join(",", $acc_links); ?></dd>
							<?php
									}
								}
							?>

							<?php
								if($t_object->get("ca_objects.object_classification")){
									if($class_links = caGetBrowseLinks($t_object, 'ca_objects.object_classification', ['template' => '<l>^ca_objects.object_classification.hierarchy.preferred_labels.name_plural%delimiter=_➜_</l>', 'linkTemplate' => '^LINK'])) {
							?>
										<dt><?= _t('Object Classification'); ?></dt>
										<dd><?= join("<br>", $class_links); ?></dd>
							<?php
									}
								}
							?>

							<?php
								if($t_object->get("ca_objects.specific_subject.subject_AAT")){
									if($sub_links = caGetBrowseLinks($t_object, 'ca_objects.specific_subject.subject_AAT', ['template' => '<l>^ca_objects.specific_subject.subject_AAT</l>', 'linkTemplate' => '^LINK'])) {
							?>
										<dt><?= _t('Subject'); ?></dt>
										<dd><?= join("<br>", $sub_links); ?></dd>
							<?php
									}
								}
							?>

							<ifdef code="ca_objects.marks_inscription.marks_text">
								<dt><?= _t('Marks/Inscription'); ?></dt>
								<dd>^ca_objects.marks_inscription.marks_text</dd>
							</ifdef>

							<ifdef code="ca_objects.related_resources.resource_citation | ca_objects.related_resources.resource_url">
								<dt><?= _t('Related Resources'); ?></dt>
								<dd><unit delimiter="<br>">^ca_objects.related_resources.resource_citation, <a href="^ca_objects.related_resources.resource_url" target="_blank" rel="noopener noreferrer">^ca_objects.related_resources.resource_url</a></unit></dd>
							</ifdef>

							<ifdef code="ca_objects.label_copy.label_copy_text">
								<dt><?= _t('Label'); ?></dt>
								<dd>^ca_objects.label_copy.label_copy_text</dd>
							</ifdef>

						</dl>}}}

						{{{<dl class="mb-0">
							<ifcount code="ca_collections" min="1">
								<dt><ifcount code="ca_collections" min="1" max="1"><?= _t('Related Collection'); ?></ifcount><ifcount code="ca_collections" min="2"><?= _t('Related Collections'); ?></ifcount></dt>
								<unit relativeTo="ca_collections" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
							</ifcount>
						</dl>}}}
						
						
					</div>
				</div>
			</div>
			<div id="map" class="py-3">{{{map}}}</div>
		</div>
	</div>
