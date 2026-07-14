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
			<H1 class="fs-3">{{{^ca_entities.preferred_labels.displayname}}}</H1>
			{{{<ifdef code="ca_entities.type_id|ca_entities.idno"><div class="fw-medium mb-3 text-capitalize"><ifdef code="ca_entities.type_id">^ca_entities.type_id</ifdef><ifdef code="ca_entities.idno">, ^ca_entities.idno</ifdef></div></ifdef>}}}
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
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_entities", "id" => $id));
				}
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
?>
<div class="row">
	<div class="col-md-6 col-lg-4 mb-4">
		{{{media_viewer}}}
	</div>
	<div class="col-md-6 col-lg-8 mb-4">		
			{{{<dl class="mb-0">
				<ifcount code="ca_entities.related" restrictToTypes="administration" min="1">
					<dt><ifcount code="ca_entities.related" restrictToTypes="administration" min="1" max="1"><?= _t('Administration Worked'); ?></ifcount><ifcount code="ca_entities.related" restrictToTypes="administration" min="2"><?= _t('Administrations Worked'); ?></ifcount></dt>
					<unit relativeTo="ca_entities.related" restrictToTypes="administration" delimiter=""><dd><l>^ca_entities.preferred_labels</l></dd></unit>
				</ifcount>
				<ifdef code="ca_entities.service_years">
					<dt><?= _t("Years in President's House"); ?></dt>
					<unit relativeTo="ca_entities.service_years" delimiter="">
						<dd>^ca_entities.service_years</dd>
					</unit>
				</ifdef>
				<ifdef code="ca_entities.positions">
					<dt><ifcount code="ca_entities.positions" max="1"><?= _t("Position"); ?></ifcount><ifcount code="ca_entities.positions" min="2"><?= _t("Positions"); ?></ifcount></dt>
					<unit relativeTo="ca_entities.positions" delimiter="">
						<dd><ifdef code="ca_entities.positions.position">^ca_entities.positions.position </ifdef><if rule="^ca_entities.positions.unclear !~ /No/">Unclear from Context</if></dd>
					</unit>
				</ifdef>
				<ifdef code="ca_entities.biography">
					<dt>Biography</dt>
					<dd>^ca_entities.biography</dd>
				</ifdef>
				<ifdef code="ca_entities.sources">
					<dt><button class="btn btn-lt btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFootnotes" aria-expanded="false" aria-controls="collapseFootnotes"><?= _t("Footnotes"); ?></button></dt>
					<dd id="collapseFootnotes" class="collapse">
					<unit relativeTo="ca_entities.sources" delimiter="">
						<div>^ca_entities.sources</div>
					</unit>
					</dd>
				</ifdef>
			</dl>}}}
	</div>
</div>
<div class="bg-light py-3 px-4 mb-5 h-100">
	<div class="row row-cols-1 row-cols-md-3">
		<div class="col">
			{{{<dl>
				<ifdef code="ca_entities.nonpreferred_labels">
					<dt>Alternate Name<ifcount code="ca_entities.nonpreferred_labels" min="2">s</ifcount></dt>
					<unit relativeTo="ca_entities.nonpreferred_labels" delimiter="">
						<dd>^ca_entities.preferred_labels.displayname</dd>
					</unit>
				</ifdef>
				<ifdef code="ca_entities.gender">
					<dt><?= _t("Gender"); ?></dt>
					<unit relativeTo="ca_entities.gender" delimiter="">
						<dd>^ca_entities.gender</dd>
					</unit>
				</ifdef>
				<ifdef code="ca_entities.legal_status">
					<dt><ifcount code="ca_entities.legal_status" max="1"><?= _t("Legal Status"); ?></ifcount><ifcount code="ca_entities.legal_status" min="2"><?= _t("Legal Statuses"); ?></ifcount></dt>
		<?php
					if($link = caGetBrowseLinks($t_item, 'ca_entities.legal_status', ['template' => '<dd><l>^ca_entities.legal_status</l></dd>', 'linkTemplate' => '^LINK'])) {
						print join("", $link);
					}
		?>		
				</ifdef>
				<ifdef code="ca_entities.race_ethnicity">
					<dt><ifcount code="ca_entities.race_ethnicity" max="1"><?= _t("Race/Ethnicity"); ?></ifcount><ifcount code="ca_entities.race_ethnicity" min="2"><?= _t("Races/Ethnicities"); ?></ifcount></dt>
		<?php
					if($link = caGetBrowseLinks($t_item, 'ca_entities.race_ethnicity', ['template' => '<dd><l>^ca_entities.race_ethnicity</l></dd>', 'linkTemplate' => '^LINK'])) {
						print join("", $link);
					}
		?>		
				</ifdef>
				<ifdef code="ca_entities.historical_periods">
					<dt><?= _t('Periods in U.S. History'); ?></dt>					
	<?php
				if($period = caGetBrowseLinks($t_item, 'ca_entities.historical_periods', ['template' => '<dd><l>^ca_entities.historical_periods</l></dd>', 'linkTemplate' => '^LINK'])) {
					print join("", $period);
				}
	?>					
				</ifdef>
				<ifdef code="ca_entities.page_citation">
					<dt><?= _t("Cite this Page"); ?></dt>
					<dd>^ca_entities.page_citation</dd>
				</ifdef>
			</dl>}}}
		</div>
		<div class="col">
			{{{<dl>
				<ifcount code="ca_entities.related" restrictToTypes="staff" min="1">
					<dt><ifcount code="ca_entities.related" restrictToTypes="staff" min="1" max="1"><?= _t('Related Staff'); ?></ifcount><ifcount code="ca_entities.related" restrictToTypes="staff" min="2"><?= _t('Related Staff'); ?></ifcount></dt>
					<unit relativeTo="ca_entities.related" restrictToTypes="staff" delimiter=""><dd><l>^ca_entities.preferred_labels</l></dd></unit>
				</ifcount>
				<ifdef code="ca_entities.website">
					<dt><?= _t("Related Association Content"); ?></dt>
					<unit relativeTo="ca_entities.website" delimiter="">
						<dd><a href="^ca_entities.website" target="_blank">^ca_entities.website <i class="bi bi-box-arrow-up-right"></i></a></dd>
					</unit>
				</ifdef>
				<ifdef code="ca_entities.public_documentation">
					<dt><?= _t("External Content"); ?></dt>
					<unit relativeTo="ca_entities.public_documentation" delimiter="">
						<dd><ifdef code="ca_entities.public_documentation.public_doc.original.url"><a href="^ca_entities.public_documentation.public_doc.original.url"><i class='bi bi-download me-1'></i> ^ca_entities.public_documentation.public_description</a></ifdef><ifnotdef code="ca_entities.public_documentation.public_doc.original.url">^ca_entities.public_documentation.public_description</ifnotdef></dd>
					</unit>
				</ifdef>
				<ifdef code="ca_entities.resource|ca_entities.resource_url">
					<dt><?= _t("Educational Resources"); ?></dt>
					<unit relativeTo="ca_entities.resource" delimiter="">
						<dd><ifdef code="ca_entities.resource.resource_description.original.url"><a href="^ca_entities.resource.resource_description.original.url"><i class='bi bi-download me-1'></i> ^ca_entities.resource.resource_description</a></ifdef><ifnotdef code="ca_entities.resource.resource_description.original.url">^ca_entities.resource.resource_description</ifnotdef></dd>
					</unit>
					<unit relativeTo="ca_entities.resource_url" delimiter="">
						<dd><a href="^ca_entities.resource_url.url" target="_blank">^ca_entities.resource_url.site_name <i class="bi bi-box-arrow-up-right"></i></a>
							<ifdef code="ca_entities.resource_url.site_description"><br/>^ca_entities.resource_url.site_description</ifdef>
						</dd>
					</unit>
				</ifdef>
			</dl>}}}
		</div>
		<div class="col">
			{{{<dl>
				<ifdef code="ca_entities.birthplace">
					<dt><?= _t("Birthplace"); ?></dt>
					<unit relativeTo="ca_entities.birthplace" delimiter="">
						<dd>^ca_entities.birthplace</dd>
					</unit>
				</ifdef>
			</dl>}}}
			<div><div id="map" class="map">{{{map}}}</div></div>
		</div>
	</div>			
</div>

{{{<ifcount code="ca_objects" min="1">
	<div class="row">
		<div class="col"><h2>Related Objects</h2><hr></div>
	</div>
	<div class="row" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_entities.entity_id:'.$t_item->get("ca_entities.entity_id"), '_advanced' => 0)); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
	</div>
</ifcount>}}}