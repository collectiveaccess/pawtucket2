<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_places_default_html.php : 
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
$id =				$t_item->get('ca_places.place_id');
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
			<H1 class="fs-3">{{{^ca_places.preferred_labels.name}}}</H1>
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
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_places", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_places", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_places_summary'));
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
<div class="bg-light pt-3 px-4 mb-4">
	<div class="row">
		<div class="col-md-4 pb-3">				
			{{{<dl class="mb-0">
					<ifdef code="ca_places.address">
						<dt><?= _t('Address'); ?></dt>
						<dd>
						<ifdef code="ca_places.address.address1">^ca_places.address.address1</ifdef>
						<ifdef code="ca_places.address.address2"><ifdef code="ca_places.address.address1"><br/></ifdef>^ca_places.address.address2</ifdef>
						<ifdef code="ca_places.address.city|ca_places.address.state|ca_places.address.zip|ca_places.address.country">
							<ifdef code="ca_places.address.address1|ca_places.address.address2"><br/></ifdef>
							<ifdef code="ca_places.address.city">^ca_places.address.city</ifdef>
							<ifdef code="ca_places.address.state"><ifdef code="ca_places.address.city">, </ifdef>^ca_places.address.state</ifdef>
							<ifdef code="ca_places.address.zip"> ^ca_places.address.zip</ifdef>
							<ifdef code="ca_places.address.country"> ^ca_places.address.country</ifdef>
						</ifdef>
						</dd>
					</ifdef>
				</dl>}}}
		</div>
		<div class="col-md-4 pb-3">
			{{{<dl class="mb-0">
				<ifdef code="ca_places.description">
					<dt><?= _t('Description'); ?></dt>
					<dd>
						^ca_places.description
					</dd>
				</ifdef>
				<ifdef code="ca_places.place_category">
					<dt><?= _t('Place Category'); ?></dt>
					<dd>
						^ca_places.place_category
					</dd>
				</ifdef>
				<ifdef code="ca_places.council_district">
					<dt><?= _t('Council District'); ?></dt>
					<dd>
						^ca_places.council_district
					</dd>
				</ifdef>
				<ifdef code="ca_places.idno">
					<dt><?= _t('Identifier'); ?></dt>
					<dd>
						^ca_places.idno
					</dd>
				</ifdef>
			</dl>}}}
		</div>
		<div class="col-md-4 pb-3">
			<div id="map" class="map">{{{map}}}</div>					
		</div>
	</div>
</div>
{{{<ifcount code="ca_objects" min="1">
	<div class="row">
		<div class="col"><h2 class="fs-4">Related Artwork</h2><hr></div>
	</div>
	<div class="row" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'all_artworks', array('search' => 'ca_places.place_id:'.$t_item->get("ca_places.place_id"), '_advanced' => 0)); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
	</div>
</ifcount>}}}