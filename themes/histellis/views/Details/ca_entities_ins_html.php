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
			{{{<ifdef code="ca_entities.type_id|ca_entities.contributor_type"><div class="fw-medium mb-3 text-capitalize"><ifdef code="ca_entities.type_id">^ca_entities.type_id</ifdef><ifdef code="ca_entities.contributor_type">, ^ca_entities.contributor_type</ifdef></div></ifdef>}}}
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
	<div class="row row-cols-1 row-cols-md-2">
		<div class="col">				
			{{{<ifdef code="ca_object_representations.media.large">
				<div class='img-fluid mb-4'>^ca_object_representations.media.large</div>
			</ifdef>}}}
			{{{<dl class="mb-3">
				<ifdef code="ca_entities.biography">
					<dd>
						^ca_entities.biography
					</dd>
				</ifdef>
				<ifdef code="ca_entities.collection_desc">
					<dt><?= _t('Scope of Collection'); ?></dt>
					<dd>
						^ca_entities.collection_desc
					</dd>
				</ifdef>
				<ifdef code="ca_entities.wikipedia_en">
					<dt><?= _t('Wikipedia'); ?></dt>
					<dd>
						^ca_entities.wikipedia_en
					</dd>
				</ifdef>
			</dl>}}}
		</div>
		<div class="col">
			
			{{{<dl class="mb-3">
				<ifdef code="ca_entities.address">
					<dt><?= _t('Address'); ?></dt>
					<unit relativeTo="ca_entities.address" delimiter=""><dd><ifdef code="ca_entities.address.address1">^ca_entities.address.address1</ifdef><ifdef code="ca_entities.address.address2"><ifdef code="ca_entities.address.address1">, </ifdef>^ca_entities.address.address2</ifdef><ifdef code="ca_entities.address.city"><ifdef code="ca_entities.address.address1|ca_entities.address.address2">, </ifdef>^ca_entities.address.city</ifdef><ifdef code="ca_entities.address.stateprovince"><ifdef code="ca_entities.address.address1|ca_entities.address.address2|ca_entities.address.city">, </ifdef>^ca_entities.address.stateprovince</ifdef><ifdef code="ca_entities.address.postalcode"><ifdef code="ca_entities.address.address1|ca_entities.address.address2|ca_entities.address.city|ca_entities.address.stateprovince">, </ifdef>^ca_entities.address.postalcode</ifdef><ifdef code="ca_entities.address.country"><ifdef code="ca_entities.address.address1|ca_entities.address.address2|ca_entities.address.city|ca_entities.address.stateprovince|ca_entities.address.postalcode">, </ifdef>^ca_entities.address.country</ifdef></dd></unit>
				</ifdef>
				<ifdef code="ca_entities.georeference">
					<dd><div id="map" class="map">^map</div></dd>
				</ifdef>
				<ifdef code="ca_entities.telephone|ca_entities.email">
					<dt><?= _t('Contact'); ?></dt>
					<ifdef code="ca_entities.telephone"><dd>^ca_entities.telephone</dd></ifdef>
					<ifdef code="ca_entities.email"><dd>^ca_entities.email</dd></ifdef>
				</ifdef>
				<ifdef code="ca_entities.external_link">
					<dt><?= _t('Website'); ?></dt>
					<ifdef code="ca_entities.external_link.url_entry"><unit relativeTo="ca_entities.external_link" delimiter=""><ifdef code="ca_entities.external_link.url_entry"><dd><a href="^ca_entities.external_link.url_entry" target="_blank"><ifdef code="ca_entities.external_link.url_source">^ca_entities.external_link.url_source</ifdef><ifnotdef code="ca_entities.external_link.url_source">^ca_entities.external_link.url_entry</ifnotdef></a></dd></ifdef></unit></ifdef>
				</ifdef>
				<ifdef code="ca_entities.social_media">
					<dt><?= _t('Social Media'); ?></dt>
					<ifdef code="ca_entities.social_media.sm_url"><unit relativeTo="ca_entities.social_media" delimiter=""><dd><a href="^ca_entities.social_media.sm_url" target="_blank">^ca_entities.social_media.sm_url</a></dd></unit></ifdef>
				</ifdef>
				<ifdef code="ca_entities.network_container">
					<dt><?= _t('Network'); ?></dt>
					<ifdef code="ca_entities.network_container.network_url"><unit relativeTo="ca_entities.network_container" delimiter=""><ifdef code="ca_entities.network_container.network_url"><dd><a href="^ca_entities.network_container.network_url" target="_blank"><ifdef code="ca_entities.network_container.network_name">^ca_entities.network_container.network_url</ifdef><ifnotdef code="ca_entities.network_container.network_name">^ca_entities.external_link.network_url</ifnotdef></a></dd></ifdef></unit></ifdef>
				</ifdef>
				<ifdef code="ca_entities.accessibility_features">
					<dt><?= _t('Accessibility'); ?></dt>
					<dd>^accessibility_features%delimiter=,_</dd>
				</ifdef>
			</dl>}}}					
		</div>
	</div>
	{{{<ifcount code="ca_entities.related" min="1">
		<dl class="row">
			<dt class="col-12 mt-3 mb-2"><ifcount code="ca_entities.related" min="1" max="1"><?= _t('Related Person'); ?></ifcount><ifcount code="ca_entities.related" min="2"><?= _t('Related People'); ?></ifcount></dt>
			<unit relativeTo="ca_entities.related" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_entities.preferred_labels<br>^relationship_typename</l></dd></unit>
		</dl>
	</ifcount>}}}
	{{{<ifcount code="ca_occurrences" min="1">
		<dl class="row">
			<dt class="col-12 mt-3 mb-2"><ifcount code="ca_occurrences" min="1" max="1"><?= _t('Related Occurrence'); ?></ifcount><ifcount code="ca_occurrences" min="2"><?= _t('Related Occurrences'); ?></ifcount></dt>
			<unit relativeTo="ca_occurrences" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_occurrences.preferred_labels<br>^relationship_typename</l></dd></unit>
		</dl>
	</ifcount>}}}
	{{{<ifcount code="ca_places" min="1">
		<dl class="row">
			<dt class="col-12 mt-3 mb-2"><ifcount code="ca_places" min="1" max="1"><?= _t('Related Place'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Related Places'); ?></ifcount></dt>
			<unit relativeTo="ca_places" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_places.preferred_labels<br>^relationship_typename</l></dd></unit>
		</dl>
	</ifcount>}}}
{{{<ifcount code="ca_objects" min="1">
	<div class="row">
		<div class="col"><h2>Related Records</h2><hr></div>
	</div>
	<div class="row" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_entities.entity_id:'.$t_item->get("ca_entities.entity_id"), '_advanced' => 0)); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
	</div>
</ifcount>}}}