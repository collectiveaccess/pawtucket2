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

$lightboxes = $this->getVar('lightboxes') ?? [];
$in_lightboxes = $this->getVar('inLightboxes') ?? [];

$media_options = array_merge($media_options, [
	'id' => 'mediaviewer'
]);
$staff_role = $this->request->config->get("archive_staff_role");	# --- set in app.conf of theme
$vb_archive_staff = false;
if($this->request->user->hasRole($staff_role)){
	$vb_archive_staff = true;
}
?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
	pawtucketUIApps['mediaViewerManager'] = <?= json_encode($media_options); ?>;
</script>

<?php
if(!$vb_archive_staff){
?>
	<div class="row my-5">
		<div class="col-md-12">
			<div class="alert alert-danger text-center">Only archive staff may access this content</div>
		</div>
	</div>
<?php
}else{
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
			<H1 class="fs-3">{{{^ca_objects.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_objects.media_type"><div class="fw-medium mb-3">^ca_objects.media_type</div></ifdef>}}}
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
		</div>
	</div>
<?php
	}
?>

<ifdef code="ca_object_representations.media.large">
	<div class="row justify-content-center mb-3">
		<div class="col-12 col-md-6">
			{{{media_viewer}}}
		</div>
	</div>
</ifdef>
	<div class="row">
		<div class="col">
			<div class="bg-light py-3 px-4 mb-3">
				<div class="row row-cols-1 row-cols-md-3 gx-5">
					<div class="col">				
						{{{<dl class="mb-0">
							<ifcount code="ca_occurrences" min="1">
								<dt><ifcount code="ca_occurrences" min="1" max="1"><?= _t('Event'); ?></ifcount><ifcount code="ca_occurrences" min="2"><?= _t('Events'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences" delimiter=""><dd><l>^ca_occurrences.preferred_labels</l></dd></unit>
							</ifcount>
					
							<ifdef code="ca_objects.media_format">
								<dt><?= _t('Format'); ?></dt>
								<dd>^ca_objects.media_format</dd>
							</ifdef>
							<ifdef code="ca_objects.media_generation">
								<dt><?= _t('Generation'); ?></dt>
								<dd>^ca_objects.media_generation</dd>
							</ifdef>
							<ifdef code="ca_objects.media_size">
								<dt><?= _t('Quantity'); ?></dt>
								<dd>^ca_objects.media_size</dd>
							</ifdef>
							<ifcount code="ca_storage_locations" min="1">
								<dt><ifcount code="ca_storage_locations" min="1" max="1"><?= _t('Storage Location'); ?></ifcount><ifcount code="ca_storage_locations" min="2"><?= _t('Storage Locations'); ?></ifcount></dt>
								<unit relativeTo="ca_storage_locations" delimiter=""><dd><l>^ca_storage_locations.preferred_labels</l></dd></unit>
							</ifcount>
							<ifdef code="ca_objects.external_link.url_entry">
								<dt><?= _t('External Link'); ?></dt>
								<unit relativeTo="ca_objects.external_link" delimiter="">
									<dd><a href="^ca_objects.external_link.url_entry" target="blank"><ifdef code="ca_objects.external_link.url_source">^ca_objects.external_link.url_source <i class="bi bi-arrow-up-right-square"></i></ifdef><ifnotdef code="ca_objects.external_link.url_source">^ca_objects.external_link.url_entry <i class="bi bi-arrow-up-right-square"></i></ifdef></a></dd>
								</unit>
							</ifdef>
							
							<ifdef code="ca_objects.general_notes">
								<dt><?= _t('Notes'); ?></dt>
								<dd>^ca_objects.general_notes</dd>
							</ifdef>
							<ifdef code="ca_objects.conservation_notes">
								<dt><?= _t('Preservation Notes'); ?></dt>
								<dd>^ca_objects.general_notes</dd>
							</ifdef>					
						</dl>}}}
						<!-- {{{<ifdef code="ca_objects.work_description">
							<div class='unit'>
								<h6><?= _t('Description'); ?></h6>
								<div class="trim collapse" id="collapseExample">
									^ca_objects.work_description
								</div>
								<a class="btn btn-light btn-sm mt-2 read-more-btn" role="button" data-bs-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
					
								</a>
							</div>
						</ifdef>}}} -->
					</div>
					<div class="col">
<?php
						print $this->render("Details/snippets/related_entities_by_rel_type_html.php");
?>
											
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>