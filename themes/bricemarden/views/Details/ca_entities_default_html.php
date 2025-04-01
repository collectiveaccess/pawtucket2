<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_entities_default_html.php : 
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
 
$t_item = 		$this->getVar("item");
$access_values = 	$this->getVar("access_values");
$options = 			$this->getVar("config_options");
$comments = 		$this->getVar("comments");
$tags = 			$this->getVar("tags_array");
$comments_enabled = $this->getVar("commentsEnabled");
$pdf_enabled = 		$this->getVar("pdfEnabled");
$inquire_enabled = 	$this->getVar("inquireEnabled");
$copy_link_enabled = 	$this->getVar("copyLinkEnabled");
$id =				$t_item->get('ca_entities.entity_id');
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
			<H1 class="fs-3">{{{^ca_entities.preferred_labels.displayname}}}</H1>
			{{{<ifdef code="ca_entities.type_id|ca_entities.idno">
				<div class="fw-medium mb-3 text-capitalize">
					<ifdef code="ca_entities.type_id">^ca_entities.type_id</ifdef>
					<ifdef code="ca_entities.idno">, ^ca_entities.idno</ifdef>
				</div>
			</ifdef>}}}
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
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_entities", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_entities_summary'));
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
?>{{{<ifdef code="ca_object_representations.media.large">
	<div class="row justify-content-center mb-3">
		<div class="col">
			<div class='detailPrimaryImage object-fit-contain'>^ca_object_representations.media.large</div>
		</div>
	</div>
</ifdef>}}}
	<div class="row row-cols-1 row-cols-md-2">
		<div class="col">				
			{{{<dl class="mb-0">
				<ifdef code="ca_entities.biography">
					<dt><?= _t('Biography'); ?></dt>
					<dd>
						^ca_entities.biography
					</dd>
				</ifdef>
			</dl>}}}
		</div>
		<div class="col">
			{{{<dl class="mb-0">
				<ifcount code="ca_entities" min="1" restrictToTypes="ind">
					<dt>
						<ifcount code="ca_entities.related" min="1" max="1" restrictToTypes="ind"><?= _t('Related Person'); ?></ifcount>
						<ifcount code="ca_entities.related" min="2" restrictToTypes="ind"><?= _t('Related People'); ?></ifcount>
					</dt>
					<unit relativeTo="ca_entities.related" delimiter="" restrictToTypes="ind"><dd><l>^ca_entities.preferred_labels</l> (^relationship_typename)</dd></unit>
				</ifcount>

				<ifcount code="ca_entities" min="1" restrictToTypes="org">
					<dt>
						<ifcount code="ca_entities.related" min="1" max="1" restrictToTypes="org"><?= _t('Related Organization'); ?></ifcount>
						<ifcount code="ca_entities.related" min="2" restrictToTypes="org"><?= _t('Related Organizations'); ?></ifcount>
					</dt>
					<unit relativeTo="ca_entities.related" delimiter="" restrictToTypes="org"><dd><l>^ca_entities.preferred_labels</l> (^relationship_typename)</dd></unit>
				</ifcount>

				<ifcount code="ca_occurrences" min="1" restrictToTypes="exhibition">
					<dt>
						<ifcount code="ca_occurrences" min="1" max="1" restrictToTypes="exhibition"><?= _t('Related Exhibition'); ?></ifcount>
						<ifcount code="ca_occurrences" min="2" restrictToTypes="exhibition"><?= _t('Related Exhibitions'); ?></ifcount>
					</dt>
					<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="exhibition"><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
				</ifcount>

				<ifcount code="ca_occurrences" min="1" restrictToTypes="literature">
					<dt>
						<ifcount code="ca_occurrences" min="1" max="1" restrictToTypes="literature"><?= _t('Related Literature'); ?></ifcount>
						<ifcount code="ca_occurrences" min="2" restrictToTypes="literature"><?= _t('Related Literature'); ?></ifcount>
					</dt>
					<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="literature"><dd><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</dd></unit>
				</ifcount>
			</dl>}}}					
		</div>
	</div>

	{{{<ifcount code="ca_objects" min="1">
		<div class="row">
			<div class="col"><h2>Related Artworks</h2><hr></div>
		</div>
		<div class="row" id="browseResultsContainer">	
			<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_entities.entity_id:'.$t_item->get("ca_entities.entity_id"))); ?>">
				<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
			</div>
		</div>
	</ifcount>}}}