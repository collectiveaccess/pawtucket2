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
$t_lists = new ca_lists();
$source_id = $t_lists->getItemIDFromList("object_sources", $t_item->get("ca_entities.idno"));
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
			{{{<ifdef code="ca_entities.contributor_type"><div class="fw-medium mb-3 text-capitalize">^ca_entities.contributor_type%useSingular=1&delimiter=,_</div></ifdef>}}}
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
				<div class='img-fluid mb-4'>^ca_object_representations.media.large<ifdef code='ca_object_representations.rights_holder|ca_object_representations.license'><div class='small text-center'>^ca_object_representations.rights_holder<ifdef code='ca_object_representations.rights_holder,ca_object_representations.license'><br/></ifdef><a href='^ca_object_representations.license' target='_blank'>^ca_object_representations.license</a></div></ifdef></div>
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
<?php
						if($va_tmp = $t_item->get("ca_entities.wikipedia_en", array("returnAsArray" => true))){
							foreach($va_tmp as $tmp){
								preg_match_all("/\\[(.*?)\\]/", $tmp, $matches);
								$url = $matches[1][0];
								print "<dd><a href='".$url."' target='_blank'>".$tmp."</a></dd>";
							}
						}
						if($va_tmp = $t_item->get("ca_entities.wikipedia_fr", array("returnAsArray" => true))){
							foreach($va_tmp as $tmp){
								preg_match_all("/\\[(.*?)\\]/", $tmp, $matches);
								$url = $matches[1][0];
								print "<dd><a href='".$url."' target='_blank'>".$tmp."</a></dd>";
							}
						}
?>
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
					<ifdef code="ca_entities.email"><dd><a href="mailto:^ca_entities.email">^ca_entities.email</a></dd></ifdef>
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
					<unit relativeTo="ca_entities.accessibility_features" delimiter=""><dd>^ca_entities.accessibility_features</dd></unit>
				</ifdef>
			</dl>}}}					
		</div>
	</div>
{{{<div class="row">
		<div class="col"><h2>Related Objects</h2><hr></div>
	</div>
	<div class="row" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('view' => 'images', 'facet' => 'source_facet', 'id' => $source_id)); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
	</div>}}}