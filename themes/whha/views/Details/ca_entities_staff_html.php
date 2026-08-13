<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_entities_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2026 Whirl-i-Gig
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
$t_item 			= $this->getVar("item");
$access_values 		= $this->getVar("access_values");
$options 			= $this->getVar("config_options");
$comments 			= $this->getVar("comments");
$tags 				= $this->getVar("tags_array");
$comments_enabled 	= $this->getVar("commentsEnabled");
$pdf_enabled 		= $this->getVar("pdfEnabled");
$inquire_enabled 	= $this->getVar("inquireEnabled");
$copy_link_enabled 	= $this->getVar("copyLinkEnabled");
$id 				= $t_item->get('ca_entities.entity_id');
$show_nav 			= ($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options 		= $this->getVar('mapOptions') ?? [];
$media_options 		= $this->getVar('media_options') ?? [];

$lightboxes 		= $this->getVar('lightboxes') ?? [];
$in_lightboxes 		= $this->getVar('inLightboxes') ?? [];

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
			<H1 class="text-center">{{{^ca_entities.preferred_labels.displayname}}}</H1>
			<hr class="mb-0">
		</div>
	</div>
<?php
	if(caDisplayLightbox($this->request) || $inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
	<div class="row">
		<div class="col text-center">
			<div class="btn-group" role="group" aria-label="Detail Controls">
<?php
				if($inquire_enabled) {
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Ask a Historian"), "btn btn-sm btn-white ps-2 pe-2 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_entities", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-2 pe-2 fw-medium", "ca_entities", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_entities_summary'));
				}
				if($copy_link_enabled){
					print $this->render('Details/snippets/copy_link_html.php');
				}
				if($t_item->get("ca_entities.page_citation")){
					$citation = $t_item->get("ca_entities.page_citation").", ".$this->request->config->get("site_host").caDetailUrl($this->request, "ca_entities", $id).".";
?>
				<button class="btn btn-sm btn-white ps-3 pe-0 fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCitation" aria-expanded="false" aria-controls="collapseCitation"><i class="bi bi-copy"></i> <?= _t("Citation"); ?></button>
				<script>
					function copyCitation() {
						var inputc = document.body.appendChild(document.createElement("input"));
						inputc.value = '<?php print strip_tags($citation); ?>';
						inputc.select();
						document.execCommand('copy');
						inputc.parentNode.removeChild(inputc);
					}
				</script>
<?php
				} 
				print $this->render('Details/snippets/lightbox_list_html.php');
?>
			</div>
		</div>
	</div>
	{{{<ifdef code="ca_entities.page_citation">
		<div id="collapseCitation" class="row justify-content-center collapse">
			<div class="col-12 col-md-6 text-center">
				<div class="bg-light py-3 px-4 my-4">
					<div class="fw-bold"><?= _t("Cite this Page"); ?></div>
					<div class="pt-1"><?php print $citation ?></div>
					<div class="pt-1"><button type="button" class="btn btn-lt btn-sm" onClick="copyCitation();" data-bs-toggle="modal" data-bs-target="#copyCitationModal"><i class="bi bi-copy"></i> <?= _t('Copy'); ?></button></div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="copyCitationModal" tabindex="-1" aria-labelledby="copyCitationModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content text-start">
					<div class="modal-body">
						<div id="copyCitationModalLabel"><?= _t("Citation Copied to Clipboard."); ?></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= _t('Close'); ?></button>
					</div>
				</div>
			</div>
		</div>
	</ifdef>}}}
<?php
	}
?>
<div class="row mt-3 mb-4 justify-content-center">
<?php
	if(trim($this->getVar("media_viewer"))){
?>
		<div class="col-md-6 col-lg-4 mb-4">
			{{{media_viewer}}}
		</div>
<?php
	}
?>
	<div class="col-md-6 col-lg-8 mb-4">		
		<div class="bg-light py-3 pt-2 px-4 mb-4 h-100">
			{{{<dl class="mb-0">
				<div class="row">
					<div class="col-12 col-md-6">
						<ifdef code="ca_entities.positions">
							<dt><ifcount code="ca_entities.positions" max="1"><?= _t("Position"); ?></ifcount><ifcount code="ca_entities.positions" min="2"><?= _t("Positions"); ?></ifcount></dt>
							<unit relativeTo="ca_entities.positions" delimiter="">
								<dd><ifdef code="ca_entities.positions.position">^ca_entities.positions.position </ifdef><if rule="^ca_entities.positions.unclear !~ /No/">Unclear from Context</if></dd>
							</unit>
						</ifdef>
						<ifdef code="ca_entities.service_years">
							<dt><?= _t("Years in President's House"); ?></dt>
							<unit relativeTo="ca_entities.service_years" delimiter="">
								<dd>^ca_entities.service_years</dd>
							</unit>
						</ifdef>
						<ifdef code="ca_entities.legal_status">
							<dt><ifcount code="ca_entities.legal_status" max="1"><?= _t("Legal Status"); ?></ifcount><ifcount code="ca_entities.legal_status" min="2"><?= _t("Legal Statuses"); ?></ifcount></dt>
								<unit relativeTo="ca_entities.legal_status" delimiter="">
									<dd>^ca_entities.legal_status</dd>
								</unit>
						</ifdef>
						<ifdef code="ca_entities.gender">
							<dt><?= _t("Gender"); ?></dt>
							<unit relativeTo="ca_entities.gender" delimiter="">
								<dd>^ca_entities.gender</dd>
							</unit>
						</ifdef>
						<ifdef code="ca_entities.race_ethnicity">
							<dt><ifcount code="ca_entities.race_ethnicity" max="1"><?= _t("Race/Ethnicity"); ?></ifcount><ifcount code="ca_entities.race_ethnicity" min="2"><?= _t("Races/Ethnicities"); ?></ifcount></dt>
								<unit relativeTo="ca_entities.race_ethnicity" delimiter="">
									<dd>^ca_entities.race_ethnicity</dd>
								</unit>
						</ifdef>
					</div>
					<div class="col-12 col-md-6">
						<ifcount code="ca_entities.related" restrictToTypes="administration" min="1">
							<dt><ifcount code="ca_entities.related" restrictToTypes="administration" min="1" max="1"><?= _t('Presidency'); ?></ifcount><ifcount code="ca_entities.related" restrictToTypes="administration" min="2"><?= _t('Presidencies'); ?></ifcount></dt>
							<unit relativeTo="ca_entities.related" restrictToTypes="administration" delimiter=""><dd><l>^ca_entities.preferred_labels</l></dd></unit>
						</ifcount>
					</div>
				</div>				
				<ifdef code="ca_entities.biography">
					<dt>Biography</dt>
					<dd>^ca_entities.biography</dd>
				</ifdef>
				<ifdef code="ca_entities.sources">
					<dt class="text-center p-2"><button class="btn btn-lt btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFootnotes" aria-expanded="false" aria-controls="collapseFootnotes"><?= _t("Footnotes"); ?></button></dt>
					<dd>
						<div id="collapseFootnotes" class="collapse">
							<unit relativeTo="ca_entities.sources" delimiter="">
								<div>^ca_entities.sources</div>
							</unit>
						</div>
					</dd>
				</ifdef>
				<ifdef code="ca_entities.birthplace">
					<dt><?= _t("Birthplace"); ?></dt>
					<unit relativeTo="ca_entities.birthplace" delimiter="">
						<dd>^ca_entities.birthplace</dd>
					</unit>
				</ifdef>
				<ifdef code="ca_entities.burial_place">
					<dt><?= _t("Burial Place"); ?></dt>
					<unit relativeTo="ca_entities.burial_place" delimiter="">
						<dd>^ca_entities.burial_place</dd>
					</unit>
				</ifdef>
				<ifdef code="ca_entities.birthplace_geonames|ca_entities.burial_geoname">
					<dd><div id="map" class="map mt-3"><?php print $this->getVar("map"); ?></div></dd>
				</ifdef>
			</dl>}}}
		</div>
	</div>
</div>
{{{<ifcount code="ca_entities.related" restrictToTypes="staff" min="1">
	<dl class="row">
		<dt class="fs-3"><ifcount code="ca_entities.related" restrictToTypes="staff" min="1" max="1"><?= _t('Related Worker'); ?></ifcount><ifcount code="ca_entities.related" restrictToTypes="staff" min="2"><?= _t('Related Workers'); ?></ifcount></dt>
		<unit relativeTo="ca_entities.related" restrictToTypes="staff" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center">
			<l class="w-100 h-100 d-flex flex-grow-1">
				<div class="card w-100 h-100 rounded-0 border-0 mb-4">
					<div class="card-body">
						<div class='card-title text-center'><div class='fw-bold lh-sm fs-3'>^ca_entities.preferred_labels</div></div><ifdef code='ca_entities.service_years|ca_entities.occupation'><div class='fw-medium lh-sm fs-5'><ifdef code='ca_entities.occupation'>^ca_entities.occupation%delimiter=,_</ifdef><ifdef code='ca_entities.service_years,ca_entities.occupation'>, </ifdef><ifdef code='ca_entities.service_years'>^ca_entities.service_years%delimiter=,_</ifdef></div></ifdef>
					</div>
				</div>
			</l>
		</dd></unit>
	</dl>
</ifcount>}}}

{{{<dl class="row row-cols-1 row-cols-md-3">
	<ifdef code="ca_entities.assoc_content">
		<div class="col">
			<dt class="fs-3"><?= _t("Related Association Content"); ?></dt>
			<unit relativeTo="ca_entities.assoc_content" delimiter="">
				<ifdef code="ca_entities.assoc_content.assoc_doc.original.url">
					<dd class="mb-4">
						<a href="^ca_entities.assoc_content.assoc_doc.original.url" class="double-border text-black p-3 d-block"><i class='bi bi-download me-1'></i> <ifdef code="ca_entities.assoc_content.assoc_title">^ca_entities.assoc_content.assoc_title</ifdef><ifdef code="ca_entities.assoc_content.assoc_title,ca_entities.assoc_content.assoc_description"><br/></ifdef><ifdef code="ca_entities.assoc_content.assoc_description">^ca_entities.assoc_content.assoc_description</ifdef></a>
					</dd>
				</ifdef>
				<ifdef code="ca_entities.assoc_content.assoc_url">
					<dd class="mb-4">
						<a href="^ca_entities.assoc_content.assoc_url" class="double-border text-black p-3 d-block"><ifdef code="ca_entities.assoc_content.assoc_title">^ca_entities.assoc_content.assoc_title</ifdef> <i class="ms-1 bi bi-box-arrow-up-right"></i><ifdef code="ca_entities.assoc_content.assoc_title,ca_entities.assoc_content.assoc_description"><br/></ifdef><ifdef code="ca_entities.assoc_content.assoc_description">^ca_entities.assoc_content.assoc_description</ifdef></a>
					</dd>
				</ifdef>
			</unit>
		</div>
	</ifdef>	
	<ifdef code="ca_entities.public_documentation">
		<div class="col">
			<dt class="fs-3"><?= _t("External Content"); ?></dt>
			<unit relativeTo="ca_entities.public_documentation" delimiter="">
				<ifdef code="ca_entities.public_documentation.public_doc.original.url">
					<dd class="mb-4">
						<a href="^ca_entities.public_documentation.public_doc.original.url" class="double-border text-black p-3 d-block"><i class='bi bi-download me-1'></i> <ifdef code="ca_entities.public_documentation.public_title">^ca_entities.public_documentation.public_title</ifdef><ifdef code="ca_entities.public_documentation.public_title,ca_entities.public_documentation.public_description"><br/></ifdef><ifdef code="ca_entities.public_documentation.public_description">^ca_entities.public_documentation.public_description</ifdef></a>
					</dd>
				</ifdef>
				<ifdef code="ca_entities.public_documentation.public_url">
					<dd class="mb-4">
						<a href="^ca_entities.public_documentation.public_url" class="double-border text-black p-3 d-block"><ifdef code="ca_entities.public_documentation.public_title">^ca_entities.public_documentation.public_title</ifdef> <i class="ms-1 bi bi-box-arrow-up-right"></i><ifdef code="ca_entities.public_documentation.public_title,ca_entities.public_documentation.public_description"><br/></ifdef><ifdef code="ca_entities.public_documentation.public_description">^ca_entities.public_documentation.public_description</ifdef></a>
					</dd>
				</ifdef>
			</unit>
		</div>
	</ifdef>
	<ifdef code="ca_entities.resource|ca_entities.resource_url">
		<div class="col">
			<dt><?= _t("Educational Resources"); ?></dt>
			<unit relativeTo="ca_entities.resource" delimiter="">
				<dd class="mb-4"><ifdef code="ca_entities.resource.resource_description.original.url"><a href="^ca_entities.resource.resource_description.original.url" class="double-border text-black p-3 d-block"><i class='bi bi-download me-1'></i> ^ca_entities.resource.resource_description</a></ifdef><ifnotdef code="ca_entities.resource.resource_description.original.url">^ca_entities.resource.resource_description</ifnotdef></dd>
			</unit>
			<unit relativeTo="ca_entities.resource_url" delimiter="">
				<dd class="mb-4"><a href="^ca_entities.resource_url.url" target="_blank" class="double-border text-black p-3 d-block">^ca_entities.resource_url.site_name <i class="bi bi-box-arrow-up-right"></i>
					<ifdef code="ca_entities.resource_url.site_description"><br/>^ca_entities.resource_url.site_description</ifdef></a>
				</dd>
			</unit>
		</div>
	</ifdef>
</dl>}}}
