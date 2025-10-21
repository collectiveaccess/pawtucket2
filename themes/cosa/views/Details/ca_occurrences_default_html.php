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
$media_options = $this->getVar('media_options') ?? [];
$media_options = array_merge($media_options, [
	'id' => 'mediaviewer'
]);
?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
	pawtucketUIApps['mediaViewerManager'] = <?= json_encode($media_options); ?>;
</script>

	<div class="row mt-n3">
		<div class="col-md-6 text-center text-md-start">
<?php
			if(caDisplayLightbox($this->request) || $inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
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
<?php
			}
?>
		</div>
<?php
if($show_nav){
?>
		<div class="col-md-6 text-center text-md-end">
			<nav aria-label="result">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</nav>
		</div>
<?php
}
?>
	</div>
	<div class="row mt-3">
		<div class="col-md-6 mb-4">
			{{{media_viewer}}}
		</div>
		<div class="col-md-6 mb-4">
			<H1 class="fs-2 mb-1">{{{<i>^ca_occurrences.preferred_labels.name</i>}}}</H1>
			{{{<ifdef code="ca_occurrences.date"><div class="fs-4">^ca_occurrences.date</div></ifdef>}}}
			{{{<ifdef code="ca_occurrences.summary"><hr><div>^ca_occurrences.summary</div></ifdef>}}}
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="bg-light pt-3 px-4 mb-4">			
				<div class="row">
					<div class="col-md-4 pb-3">
						{{{<dl class="mb-0">
							<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="curator">
								<dt><ifcount code="ca_entities" min="1" max="1" restrictToRelationshipTypes="curator"><?= _t('Curator'); ?></ifcount><ifcount code="ca_entities" min="2" restrictToRelationshipTypes="curator"><?= _t('Curators'); ?></ifcount></dt>
								<dd><unit relativeTo="ca_entities" restrictToRelationshipTypes="curator" delimiter=", ">^ca_entities.preferred_labels</unit></dd>
							</ifcount>
							<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="related">
								<dt><ifcount code="ca_entities" min="1" max="1" restrictToRelationshipTypes="related"><?= _t('Artist'); ?></ifcount><ifcount code="ca_entities" min="2" restrictToRelationshipTypes="related"><?= _t('Artists'); ?></ifcount></dt>
								<dd><unit relativeTo="ca_entities" restrictToRelationshipTypes="related" delimiter=", ">^ca_entities.preferred_labels</unit></dd>
							</ifcount>
							
						</dl>}}}
					</div>
					<div class="col-md-4 pb-3">
						{{{<dl>
							<ifcount code="ca_occurrences.related" restrictToTypes="publication" min="1">
								<dt><ifcount code="ca_occurrences.related" restrictToTypes="publication" min="1" max="1"><?= _t('Related Publication'); ?></ifcount><ifcount code="ca_occurrences.related" min="2" restrictToTypes="publication"><?= _t('Related Publications'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences.related" delimiter="" restrictToTypes="publication"><dd><ifdef code="ca_occurrences.documentation.document.original.url"><a href="^ca_occurrences.documentation.document.original.url"><i class='bi bi-download me-1'></i> ^ca_occurrences.preferred_labels</a></ifdef><ifnotdef code="ca_occurrences.documentation.document.url">^ca_occurrences.preferred_labels</ifnotdef>
									<ifdef code="ca_occurrences.author|ca_occurrences.publisher|ca_occurrences.date"><div><ifdef code="ca_occurrences.author">^ca_occurrences.author%delimiter=,_<ifdef code="ca_occurrences.publisher|ca_occurrences.date">, </ifdef></ifdef><ifdef code="ca_occurrences.publisher">^ca_occurrences.publisher<ifdef code="ca_occurrences.date">, </ifdef>^ca_occurrences.date</div></ifdef>
								</dd></unit>
							</ifcount>
							<ifcount code="ca_places" min="1">
								<dt><ifcount code="ca_places" min="1" max="1"><?= _t('Venue'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Venues'); ?></ifcount></dt>
								<unit relativeTo="ca_places" delimiter=""><dd><l>^ca_places.preferred_labels</l>
									<ifdef code="ca_places.address"><br/>
										<ifdef code="ca_places.address.address1">^ca_places.address.address1</ifdef>
										<ifdef code="ca_places.address.address2"><ifdef code="ca_places.address.address1"><br/></ifdef>^ca_places.address.address2</ifdef>
										<ifdef code="ca_places.address.city|ca_places.address.state|ca_places.address.zip|ca_places.address.country">
											<ifdef code="ca_places.address.address1|ca_places.address.address2"><br/></ifdef>
											<ifdef code="ca_places.address.city">^ca_places.address.city</ifdef><ifdef code="ca_places.address.state"><ifdef code="ca_places.address.city">, </ifdef>^ca_places.address.state</ifdef>
											<ifdef code="ca_places.address.zip"> ^ca_places.address.zip</ifdef>
											<ifdef code="ca_places.address.country"> ^ca_places.address.country</ifdef>
										</ifdef>
									</ifdef>
								</dd></unit>
							</ifcount>
						</dl>}}}
					</div>
					<div class="col-md-4 pb-3">
						<div><div id="map" class="map">{{{map}}}</div></div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
{{{<ifcount code="ca_objects" min="1">
	<div class="row">
		<div class="col"><h2 class="fs-4">Exhibited Artworks</h2><hr></div>
	</div>
	<div class="row" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'all_artworks', array('search' => 'ca_occurrences.occurrence_id:'.$t_item->get("ca_occurrences.occurrence_id"), '_advanced' => 0)); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
	</div>
</ifcount>}}}