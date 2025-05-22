<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_occurrences_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
 
$t_item = 			$this->getVar("item");
$access_values = 	$this->getVar("access_values");
$options = 			$this->getVar("config_options");
$comments = 		$this->getVar("comments");
$tags = 			$this->getVar("tags_array");
$comments_enabled = $this->getVar("commentsEnabled");
$pdf_enabled = 		$this->getVar("pdfEnabled");
$inquire_enabled = 	$this->getVar("inquireEnabled");
$copy_link_enabled = 	$this->getVar("copyLinkEnabled");
$id =				$t_item->get('ca_occurrences.occurrence_id');
$show_nav = 		($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = $this->getVar('mapOptions') ?? [];
?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
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
			<H1 class="fs-3">{{{^ca_occurrences.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_occurrences.dateProduced"><div class="fw-medium mb-3">^ca_occurrences.dateProduced</div></ifdef>}}}
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
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_occurrences", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_occurrences", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_occurrences_summary'));
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
	<div class="row row-cols-1 row-cols-md-2">
		<div class="col-md-6 col-lg-7">
				{{{<ifdef code="ca_occurrences.abstract"><div class="mb-2 fs-4">^ca_occurrences.abstract</div></ifdef>
				<dl class="mb-0">
					<ifdef code="ca_occurrences.externalLink.url_entry"><dt>External Links</dt><unit relativeTo="ca_occurrences.externalLink" delimiter=""><dd><a href="^ca_occurrences.externalLink.url_entry" target="_blank">^ca_occurrences.externalLink.url_source <i class="bi bi-link-45deg"></i></a></dd></ifdef>
				</dl>}}}
		</div>
		<div class="col-md-6 col-lg-5 imgList">				
			{{{
				<ifdef code="ca_occurrences.embed_code"><unit relativeTo="ca_occurrences.embed_code" delimiter=""><div class="mb-3 p-3 bg-white text-center">^ca_occurrences.embed_code</div></unit></ifdef>
				<ifcount code="ca_object_representations" min="1"><unit relativeTo="ca_object_representations" filterNonPrimaryRepresentations="0" delimiter=""><div class="mb-3 p-3 bg-white text-center">^ca_object_representations.media.large<if rule='^ca_object_representations.preferred_labels.name !~ /BLANK/'><div class="fs-5 py-1 fst-italic">^ca_object_representations.preferred_labels</div></if></div></unit></ifcount>
			}}}
		</div>
	</div>