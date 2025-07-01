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
			<nav aria-label="result navigation">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</nav>
		</div>
	</div>
<?php
}
?>
	<div class="row">
		<div class="col-md-12">
			<H1 class="fs-3">{{{^ca_objects.preferred_labels.name}}}</H1>
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

	<div class="row mb-4">
		<div class="col-md-6">
				
				{{{media_viewer}}}
		</div>
		<div class="col-md-6">
			<div class="bg-light py-3 px-4 mb-3 h-100"><!-- height is to make the gray background of box same height as the containing row -->
				<div class="row">
					<div class="col">				
						{{{<dl class="mb-0">
							<ifdef code="ca_objects.date">
								<dt><?= _t('Date'); ?></dt>
								<dd>^ca_objects.date%delimiter=,_</dd>
							</ifdef>
							<ifdef code="ca_objects.format_corres">
								<dt><?= _t('Format'); ?></dt>
								<dd>^ca_objects.format_corres%delimiter=,_</dd>
							</ifdef>
							<ifdef code="ca_objects.format_ephemera">
								<dt><?= _t('Format'); ?></dt>
								<dd>^ca_objects.format_ephemera%delimiter=,_</dd>
							</ifdef>
							<ifdef code="ca_objects.photograph_format">
								<dt><?= _t('Format'); ?></dt>
								<dd>^ca_objects.photograph_format%delimiter=,_</dd>
							</ifdef>
							<ifdef code="ca_objects.color_bw">
								<dt><?= _t('Color'); ?></dt>
								<dd>^ca_objects.color_bw</dd>
							</ifdef>
							<ifdef code="ca_objects.format_type_press">
								<dt><?= _t('Format'); ?></dt>
								<dd>^ca_objects.format_type_press%delimiter=,_</dd>
							</ifdef>
							<ifdef code="ca_objects.format_production">
								<dt><?= _t('Format'); ?></dt>
								<dd>^ca_objects.format_production%delimiter=,_</dd>
							</ifdef>
							<ifdef code="ca_objects.format_av_analog">
								<dt><?= _t('Original Format'); ?></dt>
								<dd>^ca_objects.format_av_analog%delimiter=,_</dd>
							</ifdef>
							<ifdef code="ca_objects.TapeRuntime">
								<dt><?= _t('Runtime'); ?></dt>
								<dd>^ca_objects.TapeRuntime%delimiter=,_</dd>
							</ifdef>
							<ifdef code="ca_objects.descriptionWithSource.prodesc_text">
								<dt><?= _t('Description'); ?></dt>
								<dd>
									^ca_objects.descriptionWithSource.prodesc_text
									<ifdef code="ca_objects.descriptionWithSource.prodesc_source">
										<div class="mt-3"><i>^ca_objects.descriptionWithSource.prodesc_source</i></div>
									</ifdef>
								</dd>
							</ifdef>
							<ifdef code="ca_objects.language">
								<dt><?= _t('Language'); ?></dt>
								<dd>^ca_objects.language%delimiter=,_</dd>
							</ifdef>
							<ifdef code="ca_objects.dimensions">
								<dt><?= _t('Dimensions'); ?></dt>
								<dd>^ca_objects.dimensions</dd>
							</ifdef>
							<ifdef code="ca_objects.number_of_copies">
								<dt><?= _t('Number of Copies'); ?></dt>
								<dd>^ca_objects.number_of_copies</dd>
							</ifdef>
						</dl>}}}
						<?= $this->render("Details/snippets/related_entities_by_rel_type_html.php"); ?>

							
						{{{<dl>			
							<ifcount code="ca_collections" min="1">
								<dt><ifcount code="ca_collections" min="1"><?= _t('Part of'); ?></ifcount></dt>
								<unit relativeTo="ca_collections" delimiter=""><dd><unit relativeTo="ca_collections.hierarchy" delimiter=" ➔ "><l>^ca_collections.preferred_labels.name</l></unit></dd></unit>
							</ifcount>
							<ifcount code="ca_occurrences" restrictToTypes="production" min="1">
								<dt><ifcount code="ca_occurrences" restrictToTypes="production" min="1" max="1" unique="1"><?= _t('Related Production'); ?></ifcount><ifcount code="ca_occurrences" restrictToTypes="production" min="2"><?= _t('Related Productions'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences" restrictToTypes="production" delimiter="" unique="1"><dd>
									<l>^ca_occurrences.preferred_labels</l>
								</dd></unit>
							</ifcount>
							<ifcount code="ca_occurrences" restrictToTypes="event" min="1">
								<dt><ifcount code="ca_occurrences" restrictToTypes="event" min="1" max="1"><?= _t('Related Event'); ?></ifcount><ifcount code="ca_occurrences" restrictToTypes="event" min="2"><?= _t('Related Events'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences" restrictToTypes="event" delimiter=""><dd>
									<l>^ca_occurrences.preferred_labels</l>
								</dd></unit>
							</ifcount>
							<ifcount code="ca_occurrences" restrictToTypes="education" min="1">
								<dt><ifcount code="ca_occurrences" restrictToTypes="education" min="1" max="1"><?= _t('Related Education Program'); ?></ifcount><ifcount code="ca_occurrences" restrictToTypes="education" min="2"><?= _t('Related Education Programs'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences" restrictToTypes="education" delimiter=""><dd>
									<l>^ca_occurrences.preferred_labels</l>
								</dd></unit>
							</ifcount>
							
							<ifdef code="ca_objects.rightsStatement.rightsStatement_text">
								<dt><?= _t('Rights Statement'); ?></dt>
								<dd>^ca_objects.rightsStatement.rightsStatement_text</dd>
							</ifdef>
						</dl>}}}
						
					</div>
				</div>
			</div>
		</div>
	</div>
