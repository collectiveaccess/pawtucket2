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
							<ifdef code="ca_objects.MARC_isbn">
								<dt><?= _t('ISBN'); ?></dt>
								<dd>^ca_objects.MARC_isbn</dd>
							</ifdef>
							<ifdef code="ca_objects.MARC_issn">
								<dt><?= _t('ISSN'); ?></dt>
								<dd>^ca_objects.MARC_issn</dd>
							</ifdef>
							<ifdef code="ca_objects.library_collection">
								<dt><?= _t('Library Location'); ?></dt>
								<dd>^ca_objects.library_collection</dd>
							</ifdef>
							<ifdef code="ca_objects.call_number">
								<dt><?= _t('Call Number'); ?></dt>
								<dd><ifdef code="ca_objects.call_number.classification_code">Brian Deer Classification Code: ^ca_objects.call_number.classification_code<br/></ifdef>
									<ifdef code="ca_objects.call_number.cutter">Cutter Number: ^ca_objects.call_number.cutter<br/></ifdef>
									<ifdef code="ca_objects.call_number.MARC_localNo">Brian Deer Call Number: ^ca_objects.call_number.MARC_localNo</ifdef>
								</dd>
							</ifdef>
							<ifdef code="ca_objects.nonpreferred_labels">
								<dt><?= _t('Varying Form of Title'); ?></dt>
								<dd><unit relativeTo="ca_objects.nonpreferred_labels" delimiter="<br/>">^ca_objects.nonpreferred_labels</unit></dd>
							</ifdef>
							<ifdef code="ca_objects.MARC_pubinfo">
								<dt><?= _t('Publisher Information'); ?></dt>
								<dd>^ca_objects.MARC_pubinfo%delimiter=,_</dd>
							</ifdef>
							<ifdef code="ca_objects.MARC_pubdate">
								<dt><?= _t('Publication or Copyright Date'); ?></dt>
								<dd>^ca_objects.MARC_pubdate</dd>
							</ifdef>
							<ifdef code="ca_objects.MARC_physical">
								<dt><?= _t('Physical Description'); ?></dt>
								<dd>^ca_objects.MARC_physical</dd>
							</ifdef>
							<ifdef code="ca_objects.MARC_formofwork">
								<dt><?= _t('Form of Work'); ?></dt>
								<dd>^ca_objects.MARC_formofwork.formofwork<ifdef code="ca_objects.MARC_formofwork.formofwork,ca_objects.MARC_formofwork.genres_library">, </ifdef>^ca_objects.MARC_formofwork.genres_library</dd>
							</ifdef>
							<ifdef code="ca_objects.MARC_summary">
								<dt><?= _t('Summary'); ?></dt>
								<dd>^ca_objects.MARC_summary</dd>
							</ifdef>
							<ifdef code="ca_objects.langmaterial">
								<dt><?= _t('Language'); ?></dt>
								<dd>^ca_objects.langmaterial%delimiter=,_</dd>
							</ifdef>
							<ifdef code="ca_objects.language_note">
								<dt><?= _t('Language Note'); ?></dt>
								<dd>^ca_objects.language_note%delimiter=,_</dd>
							</ifdef>
							<ifdef code="ca_objects.accessrestrict">
								<dt><?= _t('Conditions Governing Access'); ?></dt>
								<dd>^ca_objects.accessrestrict</dd>
							</ifdef>
							<ifdef code="ca_objects.reproduction">
								<dt><?= _t('Conditions Governing Reproduction'); ?></dt>
								<dd>^ca_objects.reproduction</dd>
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
		</div>
	</div>
