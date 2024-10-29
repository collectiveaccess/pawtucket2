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
	<div class="row pb-4">
		<div class="col-sm-12 col-md-8">
<?php
		if($t_object->get("ca_collections", array("checkAccess" => $access_values))){
			if($links = caGetBrowseLinks($t_object, 'ca_collections', ['template' => '<l>^ca_collections.preferred_labels</l>', 'linkTemplate' => '^LINK'])) {
?>
				<div class="serif fs-5 pb-2"><?= join(", ", $links); ?></div>
<?php
			}
		}
?>
			<H1 class="fs-2">{{{^ca_objects.preferred_labels.name}}}</H1>
		</div>
<?php
if($show_nav){
?>
		<div class="col-sm-12 col-md-4 text-center text-md-end">
			<nav aria-label="result">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</nav>
		</div>
<?php
}
?>

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
				<button class="btn btn-sm btn-white ps-3 pe-0 fw-medium"><i class="bi bi-copy"></i> <?= _t('Copy Link'); ?></button>
<?php
				}
?>
			</div>
		</div>
	</div>
<?php
	}
?>

	<div class="row mb-5">
		<div class="col-md-6">
			<div>
				{{{media_viewer}}}
			</div>
		</div>
		<div class="col-md-6 pt-1">
			<div class="row mb-3">
				<div class="col-sm-6 col-md-12 col-lg-6">	
					<dl>		
					
<?php						
						if($t_object->get("ca_objects.department")){
							if($links = caGetBrowseLinks($t_object, 'ca_objects.department', ['template' => '<l><div class="btn btn-secondary btn-sm me-4 fw-semibold">^ca_objects.department</div></l>', 'linkTemplate' => '^LINK'])) {
?>
								<dt class="serif fw-medium pb-1">Discipline</dt>
								<dd class="pb-4 fs-5 fw-semibold"><?= join(" ", $links); ?></dd>
<?php
							}
						}
						if($t_object->get("ca_objects.semester")){
							if($links = caGetBrowseLinks($t_object, 'ca_objects.semester', ['template' => '<l><div class="btn btn-secondary btn-sm me-4 fw-semibold">^ca_objects.semester</div></l>', 'linkTemplate' => '^LINK'])) {
?>
								<dt class="serif fw-medium pb-1">Semester</dt>
								<dd class="pb-4 fs-5 fw-semibold"><?= join(" ", $links); ?></dd>
<?php
							}
						}
?>

					{{{<ifnotdef code="ca_objects.semester"><ifdef code="ca_objects.date_regular">
							<dt class="serif fw-medium pb-1"><?= _t('Date'); ?></dt>
							<dd class="pb-4 fs-5 fw-semibold">^ca_objects.date_regular</dd>
						</ifdef></ifnotdef>}}}
<?php
						$va_courses = $t_object->get("ca_occurrences", array("returnWithStructure" => 1, "checkAccess" => $va_access_values, "restrictToTypes" => "course"));
						if(is_array($va_courses) && sizeof($va_courses)){
							print '<dt class="serif fw-medium pb-1">Course'.((sizeof($va_courses) > 1) ? "s" : "").'</dt><dd class="pb-4 fs-5 fw-semibold">';
							foreach($va_courses as $va_course_info){
								print caNavLink($this->request, $va_course_info["name"], "btn btn-secondary btn-sm me-4 fw-semibold mb-1", "", "Browse", "objects", array("facet" => "course_facet", "id" => $va_course_info["occurrence_id"]));

							}
							print "</dd>";
						}
?>
						
					</dl>
				</div>
				<div class="col-sm-6 col-md-12 col-lg-6">
					<dl>
<?php						
						if($t_object->get("ca_objects.work_type")){
							if($links = caGetBrowseLinks($t_object, 'ca_objects.work_type', ['template' => '<l><div class="btn btn-secondary btn-sm me-4 fw-semibold">^ca_objects.work_type</div></l>', 'linkTemplate' => '^LINK'])) {
?>
								<dt class="serif fw-medium pb-1">Work Type</dt>
								<dd class="pb-4 fs-5 fw-semibold"><?= join(" ", $links); ?></dd>
<?php
							}
						}
						print $this->render("Details/snippets/related_entities_by_rel_type_html.php");
						if($t_object->get("ca_objects.geonames", array("checkAccess" => $access_values))){
							if($links = caGetBrowseLinks($t_object, 'ca_objects.geonames', ['template' => '<l><div class="btn btn-secondary btn-sm me-4 fw-semibold">^ca_objects.geonames</div></l>', 'linkTemplate' => '^LINK'])) {
?>
								<dt class="serif fw-medium pb-1">Location<?= (sizeof($links) > 1 ) ? "s" : ""; ?></dt>
								<dd class="pb-4 fs-5 fw-semibold"><?= join(" ", $links); ?></dd>
<?php
							}
						}
?>						
					</dl>
				</div>
			</div>
				
				
				{{{<ifdef code="ca_objects.descriptionSet.discriptionText|ca_objects.notes|ca_objects.rightsSet.rightText">
					<dl>
						<ifdef code="ca_objects.descriptionSet.discriptionText">
							<dt class="serif fw-medium pb-1"><?= _t('Description'); ?></dt>
							<dd class="pb-4 fs-5">
								^ca_objects.descriptionSet.discriptionText
								<ifdef code="ca_objects.descriptionSet.descriptionSource"><div class="pt-2">^ca_objects.descriptionSet.descriptionSource</div></ifdef>
							</dd>
						</ifdef>
						<ifdef code="ca_objects.notes">
							<dt class="serif fw-medium pb-1"><?= _t('Notes'); ?></dt>
							<dd class="pb-4 fs-5">
								^ca_objects.notes
							</dd>
						</ifdef>
						<ifdef code="ca_objects.rightsSet.rightText">
							<dt class="serif fw-medium pb-1"><?= _t('Rights'); ?></dt>
							<dd class="pb-4 fs-5">
								^ca_objects.rightsSet.rightText
							</dd>
						</ifdef>
						</dl>
					
				</ifdef>}}}
		</div>
	</div>