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
	<div class="row">
		<div class="col-md-12">
			<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
			<hr class="mb-0 opacity-100">
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
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_objects", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm ps-3 pe-0 fw-medium", "ca_objects", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'));
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

	<div class="row">
		<div class="col-md-6">
				{{{media_viewer}}}
		</div>
		<div class="col-md-6">
			<div class="bg-light py-3 px-4 mb-3 h-100"><!-- height is to make the gray background of box same height as the containing row -->
				<div class="row">
					<div class="col">				
						{{{<dl class="mb-0">
							<?= $this->render("Details/snippets/related_entities_by_rel_type_html.php"); ?>

							<ifdef code="ca_objects.dates.dates_value">
								<dt><?= _t('Date'); ?></dt>
								<unit relativeTo="ca_objects.dates" delimiter=""><dd>^ca_objects.dates.dates_value (^ca_objects.dates.dates_type)</dd></unit>
							</ifdef>
		
							<ifdef code="ca_objects.type_id">
								<dt><?= _t('Item Type'); ?></dt>
								<dd>^ca_objects.type_id</dd>
							</ifdef>
<?php
							if($t_object->get("ca_objects.series")){
								if($links = caGetBrowseLinks($t_object, 'ca_objects.series', ['template' => '<l>^ca_objects.series</l>', 'linkTemplate' => '^LINK'])) {
?>
									<dt><?= _t('Classification'); ?></dt>
									<dd><?= join(" ", $links); ?></dd>
<?php
								}
							}
?>
							<ifdef code="ca_objects.dimensions">
								<dt><?= _t('Dimensions'); ?></dt>
								<dd>
									<ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height<ifdef code="ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_depth"> x </ifdef></ifdef>
									<ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width<ifdef code="ca_objects.dimensions.dimensions_depth"> x </ifdef></ifdef>
									<ifdef code="ca_objects.dimensions.dimensions_depth">^ca_objects.dimensions.dimensions_depth</ifdef>
								</dd>
							</ifdef>
							<ifdef code="ca_objects.materials">
								<dt><?= _t('Materials'); ?></dt>
								<dd>^ca_objects.materials</dd>
							</ifdef>
							<ifdef code="ca_item_tags.tag">
								<dt><?= _t('Keywords'); ?></dt>
								<dd>^ca_item_tags.tag%delimiter=,_</dd>
							</ifdef>
							<ifdef code="ca_objects.description_public">
								<dt><?= _t('Notes'); ?></dt>
								<dd>
									^ca_objects.description_public
								</dd>
							</ifdef>
							<ifdef code="ca_objects.idno">
								<dt><?= _t('ID'); ?></dt>
								<dd>^ca_objects.idno</dd>
							</ifdef>
							<ifdef code="ca_objects.location">
								<dt><?= _t('Location'); ?></dt>
								<dd>
									<ifdef code="ca_objects.location.box">Box ^ca_objects.location.box </ifdef>
									<ifdef code="ca_objects.location.drawer">Drawer ^ca_objects.location.drawer </ifdef>
									<ifdef code="ca_objects.location.folder">Folder ^ca_objects.location.folder </ifdef>
									<ifdef code="ca_objects.location.item_location">Item ^ca_objects.location.item_location </ifdef>
									<ifdef code="ca_objects.location.location_description"><div>^ca_objects.location.location_description</div></ifdef>
								</dd>
							</ifdef>
							<ifcount code="ca_collections" min="1">
								<dt><ifcount code="ca_collections" min="1" max="1"><?= _t('Part of'); ?></ifcount></dt>
								<unit relativeTo="ca_collections" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
							</ifcount>
							<ifcount code="ca_occurrences" min="1" restrictToTypes="exhibitions">
								<dt><ifcount code="ca_occurrences" min="1" max="1" restrictToTypes="exhibitions"><?= _t('Exhibition'); ?></ifcount><ifcount code="ca_occurrences" min="2" restrictToTypes="exhibitions"><?= _t('Exhibitions'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="exhibitions"><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
							</ifcount>
							<ifcount code="ca_occurrences" min="1" restrictToTypes="events">
								<dt><ifcount code="ca_occurrences" min="1" max="1" restrictToTypes="events"><?= _t('Event'); ?></ifcount><ifcount code="ca_occurrences" min="2" restrictToTypes="events"><?= _t('Events'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="events"><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
							</ifcount>
							
						</dl>}}}
						
						
						{{{<dl class="mb-0">
							
				
							<ifcount code="ca_occurrences" min="1">
								<dt><ifcount code="ca_occurrences" min="1" max="1"><?= _t('Related Occurrence'); ?></ifcount><ifcount code="ca_occurrences" min="2"><?= _t('Related Occurrences'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences" delimiter=""><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
							</ifcount>

						</dl>}}}
						
					</div>
				</div>
			</div>
		</div>
	</div>