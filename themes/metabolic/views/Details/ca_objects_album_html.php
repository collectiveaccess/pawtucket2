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
				{{{media_viewer}}}
		</div>
		<div class="col-md-6">
			<div class="bg-light py-3 px-4 mb-3 h-100"><!-- height is to make the gray background of box same height as the containing row -->
				<div class="row">
					<div class="col">

						<?= $this->render("Details/snippets/related_entities_by_rel_type_html.php"); ?>		
							
						{{{<dl class="mb-0">

							<ifdef code="ca_objects.date">
								<dt><?= _t('Date'); ?></dt>
								<dd>^ca_objects.date%delimiter=,_</dd>
							</ifdef>

							<ifdef code="ca_objects.idno">
								<dt><?= _t('Identifier'); ?></dt>
								<dd>^ca_objects.idno</dd>
							</ifdef>

							<ifdef code="ca_objects.altID">
								<dt><?= _t('Alternate Identifier'); ?></dt>
								<dd>^ca_objects.altID</dd>
							</ifdef>

							<ifdef code="ca_objects.description">
								<dt><?= _t('Description'); ?></dt>
								<dd>^ca_objects.description</dd>
							</ifdef>

							<ifdef code="ca_objects.url">
								<dd>
									<unit relativeTo="ca_objects.url" delimiter="<br/>">
										<a href="^ca_objects.url" target="_blank" rel="noopener">^ca_objects.url</a> 
									</unit>
								</dd>
							</ifdef>

							<?php
								if($t_object->get("ca_objects.bio_regions")){
									if($bio_links = caGetBrowseLinks($t_object, 'ca_objects.bio_regions', ['template' => '<l>^ca_objects.bio_regions</l>', 'linkTemplate' => '^LINK'])) {
							?>
										<dt><?= _t('Bio Regions'); ?></dt>
										<dd><?= join(", ", $bio_links); ?></dd>
							<?php
									}
								}
							?>

							<?php
								if($t_object->get("ca_objects.subject")){
									if($subs = caGetBrowseLinks($t_object, 'ca_objects.subject', ['template' => '<l>^ca_objects.subject</l>', 'linkTemplate' => '^LINK'])) {
							?>
										<dt><?= _t('Themes'); ?></dt>
										<dd><?= join(", ", $subs); ?></dd>
							<?php
									}
								}
							?>

						</dl>}}}
						
						{{{<dl class="mb-0">
							<ifcount code="ca_collections" min="1">
								<dt><ifcount code="ca_collections" min="1" max="1"><?= _t('Actions'); ?></ifcount><ifcount code="ca_collections" min="2"><?= _t('Actions'); ?></ifcount></dt>
								<unit relativeTo="ca_collections" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
							</ifcount>

							<ifcount code="ca_occurrences" min="1" restrictToTypes="action">
								<dt><ifcount code="ca_occurrences" min="1" max="1" restrictToTypes="action"><?= _t('Event'); ?></ifcount><ifcount code="ca_occurrences" min="2" restrictToTypes="action"><?= _t('Events'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="action"><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
							</ifcount>
							<ifcount code="ca_occurrences" min="1" restrictToTypes="exhibition">
								<dt><ifcount code="ca_occurrences" min="1" max="1" restrictToTypes="exhibition"><?= _t('Exhibition'); ?></ifcount><ifcount code="ca_occurrences" min="2" restrictToTypes="exhibition"><?= _t('Exhibitions'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="exhibition"><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
							</ifcount>
							<ifcount code="ca_occurrences" min="1" restrictToTypes="lecture_presentation">
								<dt><ifcount code="ca_occurrences" min="1" max="1" restrictToTypes="lecture_presentation"><?= _t('Lecture/Presentation'); ?></ifcount><ifcount code="ca_occurrences" min="2" restrictToTypes="lecture_presentation"><?= _t('Lectures/Presentations'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="lecture_presentation"><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
							</ifcount>
							<ifcount code="ca_occurrences" min="1" restrictToTypes="publication">
								<dt><ifcount code="ca_occurrences" min="1" max="1" restrictToTypes="publication"><?= _t('Publication'); ?></ifcount><ifcount code="ca_occurrences" min="2" restrictToTypes="publication"><?= _t('Publications'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="publication"><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
							</ifcount>
						</dl>}}}
						
					</div>
				</div>
			</div>
		</div>
	</div>

	{{{<ifcount code="ca_objects.children" min="1">
		<div class="row">
			<div class="col"><h2>Assets</h2><hr></div>
		</div>
		<div class="row" id="browseResultsContainer">	
			<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_objects.parent_id:'.$t_object->get("ca_objects.object_id"))); ?>">
				<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
			</div>
		</div>
	</ifcount>}}}