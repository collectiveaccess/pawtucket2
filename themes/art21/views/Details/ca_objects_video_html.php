<?php
/* ----------------------------------------------------------------------
 * themes/art21/views/Details/ca_objects_video_html.php : 
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
			{{{<ifdef code="ca_objects.type_id|ca_objects.pub_type|ca_objects.idno"><div class="fw-medium mb-3"><ifdef code="ca_objects.type_id">^ca_objects.type_id</ifdef><ifdef code="ca_objects.pub_type"> - ^ca_objects.pub_type</ifdef><ifdef code="ca_objects.idno">, ^ca_objects.idno</ifdef></div></ifdef>}}}
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
	<div class="row justify-content-center mb-3">
		<div class="col-lg-8">
			<div class='detailPrimaryImage object-fit-contain'>{{{media_viewer}}}</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="bg-light py-3 px-4 mb-3">
				<div class="row row-cols-1 row-cols-md-3 gx-5">
					<div class="col">				
						{{{<dl class="mb-0">
							<ifdef code="ca_objects.legacy_num">
								<dt><?= _t('Legacy Number'); ?></dt>
								<unit relativeTo="ca_objects.legacy_num" delimiter="">
									<dd>^ca_objects.legacy_num</dd>
								</unit>
							</ifdef>
							<ifcount code="ca_entities" restrictToRelationshipTypes="artist,subject" min="1">
								<dt><ifcount code="ca_entities" restrictToRelationshipTypes="artist,subject" min="1" max="1"><?= _t('Artist'); ?></ifcount><ifcount code="ca_entities" restrictToRelationshipTypes="artist,subject" min="2"><?= _t('Artists'); ?></ifcount></dt>
								<unit relativeTo="ca_entities" restrictToRelationshipTypes="artist,subject" delimiter=""><dd><l>^ca_entities.preferred_labels</l></dd></unit>
							</ifcount>
							<ifcount code="ca_collections" restrictToTypes="series" min="1">
							<dt><?= _t('Series'); ?></dt>
								<unit relativeTo="ca_collections" restrictToTypes="series" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter="<span aria-hidden='true'> > </span>"><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
							</ifcount>
							<ifcount code="ca_collections" restrictToTypes="project" min="1">
								<dt><ifcount code="ca_collections" restrictToTypes="project" min="1" max="1"><?= _t('Project'); ?></ifcount><ifcount code="ca_collections" restrictToTypes="project" min="2"><?= _t('Projects'); ?></ifcount></dt>
								<unit relativeTo="ca_collections" restrictToTypes="project" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter="<span aria-hidden='true'> > </span>"><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
							</ifcount>
							<ifcount code="ca_collections" restrictToTypes="shoot" min="1">
								<dt><ifcount code="ca_collections" restrictToTypes="shoot" min="1" max="1"><?= _t('Shoot'); ?></ifcount><ifcount code="ca_collections" restrictToTypes="project" min="2"><?= _t('Shoots'); ?></ifcount></dt>
								<unit relativeTo="ca_collections" restrictToTypes="shoot" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter="<span aria-hidden='true'> > </span>"><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
							</ifcount>
							<ifdef code="ca_objects.common_date">
								<dt><?= _t('Date'); ?></dt>
								<dd>^ca_objects.common_date</dd>
							</ifdef>
							<ifdef code="ca_objects.pbs_container">
								<dt><?= _t('PBS Project'); ?></dt>
								<dd>^ca_objects.pbs_container.pbs_type<ifdef code="ca_objects.pbs_container.pbs_type,ca_objects.pbs_container.pbs_note"><br/></ifdef>^ca_objects.pbs_container.pbs_note</dd>
							</ifdef>
							<ifdef code="ca_objects.filename">
								<dt><?= _t('Filename'); ?></dt>
								<dd>^ca_objects.filename</dd>
							</ifdef>
							<ifdef code="ca_objects.runtime">
								<dt><?= _t('Duration'); ?></dt>
								<dd>^ca_objects.runtime</dd>
							</ifdef>
						</dl>}}}
					</div>
					<div class="col">
<?php
						#print $this->render("Details/snippets/related_entities_by_rel_type_html.php");
?>
						{{{<dl class="mb-0">
							<ifdef code="ca_objects.description">
								<dt><?= _t('description'); ?></dt>
								<dd>^ca_objects.description</dd>
							</ifdef>
							<ifdef code="ca_objects.theme">
								<dt><?= _t('Theme'); ?></dt>
								<unit relativeTo="ca_objects.theme" delimiter="">
									<dd>^ca_objects.theme</dd>
								</unit>
							</ifdef>
							<ifdef code="ca_objects.medium">
								<dt><?= _t('Medium'); ?></dt>
								<unit relativeTo="ca_objects.medium" delimiter="">
									<dd>^ca_objects.medium</dd>
								</unit>
							</ifdef>
							<ifdef code="ca_objects.narratives">
								<dt><?= _t('Narrative'); ?></dt>
								<unit relativeTo="ca_objects.narratives" delimiter="">
									<dd>^ca_objects.narratives</dd>
								</unit>
							</ifdef>
						</dl>}}}					
					</div>
					<div class="col">
						{{{<dl class="mb-0">
							<ifcount code="ca_entities" restrictToRelationshipTypes="crew" min="1">
								<dt><ifcount code="ca_entities" restrictToRelationshipTypes="crew" min="1" max="1"><?= _t('Credits'); ?></ifcount><ifcount code="ca_entities" restrictToRelationshipTypes="crew" min="2"><?= _t('Crew'); ?></ifcount></dt>
								<unit relativeTo="ca_entities" restrictToRelationshipTypes="crew" delimiter=""><dd>^ca_entities.preferred_labels</dd></unit>
							</ifcount>
							<ifcount code="ca_entities" restrictToRelationshipTypes="funder" min="1">
								<dt><ifcount code="ca_entities" restrictToRelationshipTypes="funder" min="1" max="1"><?= _t('Funder'); ?></ifcount><ifcount code="ca_entities" restrictToRelationshipTypes="funder" min="2"><?= _t('Funders'); ?></ifcount></dt>
								<unit relativeTo="ca_entities" restrictToRelationshipTypes="funder" delimiter=""><dd>^ca_entities.preferred_labels</dd></unit>
							</ifcount>
							<ifdef code="ca_objects.credit_line">
								<dt><?= _t('More Information'); ?></dt>
								<dd>^ca_objects.credit_line</dd>
							</ifdef>
							
						</dl>}}}
					</div>
				</div>
			</div>
		</div>
	</div>
