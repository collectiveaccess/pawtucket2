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
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire/Give Feedback"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_objects", "id" => $id));
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
		<div class="col-md-6">
			{{{media_viewer}}}
		</div>
		<div class="col-md-6 mb-5">
			<div class="bg-light py-3 px-4 mb-3 h-100"><!-- height is to make the gray background of box same height as the containing row -->			
				{{{<dl class="mb-0">
					<ifdef code="ca_objects.serial_name">
						<dt><?= _t('Serial Name'); ?></dt>
						<dd>^ca_objects.serial_name</dd>
					</ifdef>
					<ifdef code="ca_objects.vol_issue">
						<dt><?= _t('Volume-Issue'); ?></dt>
						<dd>^ca_objects.vol_issue</dd>
					</ifdef>
					<ifdef code="ca_objects.ephemera_type">
						<dt><?= _t('Ephemera Type'); ?></dt>
						<dd>^ca_objects.ephemera_type</dd>
					</ifdef>
					<ifdef code="ca_objects.extent_medium">
						<dt><?= _t('Extent and Medium'); ?></dt>
						<dd>^ca_objects.extent_medium</dd>
					</ifdef>
					<ifdef code="ca_objects.dimensions.height|ca_objects.dimensions.width|ca_objects.dimensions.depth">
						<dt><?= _t('Dimensions'); ?></dt>
						<dd>
							<ifdef code="ca_objects.dimensions.height">^ca_objects.dimensions.height<ifdef code="ca_objects.dimensions.width|ca_objects.dimensions.depth"> X </ifdef></ifdef>
							<ifdef code="ca_objects.dimensions.width">^ca_objects.dimensions.width<ifdef code="ca_objects.dimensions.depth"> X </ifdef></ifdef>
							<ifdef code="ca_objects.dimensions.depth">^ca_objects.dimensions.depth</ifdef>
						</dd>
					</ifdef>
					<ifdef code="ca_objects.description">
						<dt><?= _t('Scope and Content'); ?></dt>
						<dd>^ca_objects.description</dd>
					</ifdef>
					<ifdef code="ca_objects.date.date_value">
						<dt><?= _t('Date'); ?></dt>
						<dd>^ca_objects.date.date_value<ifdef code="ca_objects.date.date_type"> (^ca_objects.date.date_type)</ifdef></dd>
					</ifdef>
					<?= $this->render("Details/snippets/related_entities_by_rel_type_html.php"); ?>
					<ifdef code="ca_objects.language">
						<dt><?= _t('Ephemera Language'); ?></dt>
						<dd>^ca_objects.language</dd>
					</ifdef>
					<ifdef code="ca_objects.rights.copyright_logo|ca_objects.rights.rights_holder">
						<dt><?= _t('Rights'); ?></dt>
						<dd><ifdef code="ca_objects.rights.copyright_logo">^ca_objects.rights.copyright_logo<ifdef code="ca_objects.rights.rights_holder">, </ifdef></ifdef><ifdef code="ca_objects.rights.rights_holder">^ca_objects.rights.rights_holder</ifdef></dd>
					</ifdef>
					<ifdef code="ca_objects.citation">
						<dt><?= _t('Preferred Citation'); ?></dt>
						<dd>^ca_objects.citation</dd>
					</ifdef>
					
					<ifcount code="ca_collections" min="1">
						<dt><ifcount code="ca_collections" min="1" max="1"><?= _t('Related Collection'); ?></ifcount><ifcount code="ca_collections" min="2"><?= _t('Related Collections'); ?></ifcount></dt>
						<unit relativeTo="ca_collections" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter="<span aria-hidden='true'> > </span>"><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
					</ifcount>
		
					<ifcount code="ca_places" min="1">
						<dt><ifcount code="ca_places" min="1" max="1"><?= _t('Related Place'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Related Places'); ?></ifcount></dt>
						<unit relativeTo="ca_places" delimiter=""><dd><l>^ca_places.preferred_labels</l> (^relationship_typename)</dd></unit>
					</ifcount>
				</dl>}}}
				<div><div id="map" class="map">{{{map}}}</div></div>
			</div>
			
		</div>
	</div>