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
	<div class="row">
		<div class="col-md-12">
			<H1 class="fs-3 fw-medium text-transform-none">{{{^ca_objects.preferred_labels.name}}}</H1>
			<hr class="mb-0">
		</div>
	</div>
<?php
//	if($inquire_enabled || $pdf_enabled || $copy_link_enabled){
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

				<?= $this->render('Details/snippets/lightbox_list_html.php'); ?>
			</div>
		</div>
	</div>
<?php
	//}
?>

	<div class="row mb-5">
		<div class="col-md-6">
				{{{media_viewer}}}
		</div>
		<div class="col-md-6">
			<div class="bg-light pt-1 pb-3 px-4 mb-3 h-100">
				<div class="row">
					<div class="col">				
						{{{<dl class="mb-0">
							<ifdef code="ca_objects.type_id">
								<dt><?= _t('Object Type'); ?></dt>
								<dd>^ca_objects.type_id</dd>
							</ifdef>
							<ifdef code="ca_objects.idno">
								<dt><?= _t('Object ID'); ?></dt>
								<dd>^ca_objects.idno</dd>
							</ifdef>
							<ifdef code="ca_objects.creation_date">
								<dt><?= _t('Date'); ?></dt>
								<dd>^ca_objects.creation_date</dd>
							</ifdef>
							<ifdef code="ca_objects.plan">
								<dt><?= _t('Plan Type'); ?></dt>
								<dd>^ca_objects.plan</dd>
							</ifdef>
							</dl>}}}
<?php
							$va_entities = $t_object->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $va_access_values));
							if(is_array($va_entities) && sizeof($va_entities)){
?>
								<dl class="mb-0">
<?php
								$va_entities_by_type = array();
								foreach($va_entities as $va_entity_info){
									$va_entities_by_type[$va_entity_info["relationship_typename"]][] = caNavLink($this->request, $va_entity_info["displayname"], "", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $va_entity_info["entity_id"]));
								}
								foreach($va_entities_by_type as $vs_type => $va_entity_links){
									print "<dt class='text-capitalize'>".$vs_type."</dt><dd>".join(", ", $va_entity_links)."</dd>";
								}
?>
								</dl>
<?php
							}

?>						
						{{{<dl class="mb-0">
							<ifdef code="ca_objects.description">
								<dt><?= _t('Description'); ?></dt>
								<dd>^ca_objects.description</dd>
							</ifdef>
							<ifcount code="ca_collections" min="1">
								<dt><ifcount code="ca_collections" min="1" max="1"><?= _t('Related Collection'); ?></ifcount><ifcount code="ca_collections" min="2"><?= _t('Related Collections'); ?></ifcount></dt>
								<unit relativeTo="ca_collections" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
							</ifcount>
							<ifdef code="ca_objects.navalClassification">
								<dt><?= _t('Naval ID'); ?></dt>
								<dd>^ca_objects.navalClassification.navalClassNumber</dd>
							</ifdef>
							<ifdef code="ca_objects.photographer">
								<dt><?= _t('Photographer'); ?></dt>
								<dd>^ca_objects.photographer</dd>
							</ifdef>
							<ifdef code="ca_objects.yardBusiness">
								<dt><?= _t('Yard Business'); ?></dt>
								<dd>^ca_objects.yardBusiness</dd>
							</ifdef>
							<ifdef code="ca_objects.copyright">
								<dt><?= _t('Copyright'); ?></dt>
								<dd>^ca_objects.copyright</dd>
							</ifdef>
							<ifdef code="ca_objects.use">
								<dt><?= _t('Use'); ?></dt>
								<dd>^ca_objects.use</dd>
							</ifdef>
						</dl>}}}
				<?php
					if($t_object->get("ca_objects.discipline")){
						if($links = caGetBrowseLinks($t_object, 'ca_objects.discipline', ['template' => '<l>^ca_objects.discipline</l>', 'linkTemplate' => '^LINK'])) {
				?>
							<dl class="mb-0">
								<dt>Keywords</dt>
								<dd><?= join(", ", $links); ?></dd>
							</dl>
				<?php
						}
					}
					if($t_object->get("ca_list_items")){
						if($links = caGetBrowseLinks($t_object, 'ca_list_items', ['template' => '<l>^ca_list_items.preferred_labels</l>', 'linkTemplate' => '^LINK'])) {
				?>
							<dl class="mb-0">
								<dt>Subject<?= (sizeof($links) > 1 ) ? "s" : ""; ?></dt>
								<dd><?= join(", ", $links); ?></dd>
							</dl>
				<?php
						}
					}
					if($t_object->get("ca_places", array("restrictToRelationshipTypes" => "building"))){
						if($links = caGetBrowseLinks($t_object, 'ca_places', ['restrictToRelationshipTypes' => 'building', 'template' => '<l>^ca_places.hierarchy.preferred_labels%delimiter=_→_</l>', 'linkTemplate' => '^LINK'])) {
				?>
							<dl class="mb-0">
								<dt>Building<?= (sizeof($links) > 1 ) ? "s" : ""; ?></dt>
								<dd><?= join(", ", $links); ?></dd>
							</dl>
				<?php
						}
					}
				?>
						
					</div>
				</div>
				<div id="map" style="height: 200px; class="py-3">{{{map}}}</div>
			</div>
		</div>
	</div>
