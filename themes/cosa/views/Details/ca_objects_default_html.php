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
<div class="breadcrumb"><div class='container-xl'><div class="py-2 fs-6">
<?php
	if($resultURL = $this->getVar("resultsURL")){
		print "<a href='".$resultURL."' class='me-4'><i class='bi bi-chevron-left small'></i>Back</a>";
	}
	print caNavLink($this->request, _t("Art Collection"), '', '', '', '', '');
	print " / ".caNavLink($this->request, _t("Artworks"), '', '', 'Browse', 'artworks', '');
	print " / ".$t_object->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="artist"><unit relativeTo="ca_entities" restrictToRelationshipTypes="artist" delimiter=", ">^ca_entities.preferred_labels</unit>, </ifcount><i>^ca_objects.preferred_labels.name</i>');					
?>
</div></div></div>	
<div class='container-xl pt-4'>
<?php # --- this container is usually out put in header, but here so the breadcrumb trail can be output 
?>	

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
						<?= $this->render('Details/snippets/lightbox_list_html.php'); ?>
<?php
			}
?>
		</div>
<?php
if($show_nav){
?>
		<div class="col-md-6 text-center text-md-end">
			<nav aria-label="result">{{{previousLink}}}{{{nextLink}}}</nav>
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
			<H1 class="fs-2 mb-1">{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="artist"><unit relativeTo="ca_entities" restrictToRelationshipTypes="artist" delimiter=", ">^ca_entities.preferred_labels</unit><br/></ifcount><i>^ca_objects.preferred_labels.name</i>}}}</H1>
			{{{<ifdef code="ca_objects.date_completed"><div class="fs-4">^ca_objects.date_completed</div></ifdef>}}}
			{{{<ifdef code="ca_objects.media"><div class="fs-4">^ca_objects.media</div></ifdef>}}}
			{{{<ifdef code="ca_objects.narrative"><hr><div>^ca_objects.narrative</div></ifdef>}}}
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="bg-light pt-3 px-4 mb-4">			
				<div class="row">
					<div class="col-md-4 pb-3">
						{{{<dl class="mb-0">
							<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="artist">
								<dt><?= _t('Artist'); ?></dt>
								<dd><unit relativeTo="ca_entities" restrictToRelationshipTypes="artist" delimiter=", "><l>^ca_entities.preferred_labels</l></unit></dd>
							</ifcount>
							<ifdef code="ca_objects.dimensions">
								<dt><?= _t('Dimensions'); ?></dt>
								<dd><unit relativeTo="ca_objects.dimensions" delimiter="<br/>">
									<ifdef code="ca_objects.dimensions.height">^ca_objects.dimensions.height</ifdef>
									<ifdef code="ca_objects.dimensions.width"><ifdef code="ca_objects.dimensions.height"> X </ifdef>^ca_objects.dimensions.width</ifdef>
									<ifdef code="ca_objects.dimensions.length"><ifdef code="ca_objects.dimensions.height|ca_objects.dimensions.width"> X </ifdef>^ca_objects.dimensions.length</ifdef>
									<ifdef code="ca_objects.dimensions.diameter"><ifdef code="ca_objects.dimensions.height|ca_objects.dimensions.width|ca_objects.dimensions.length"> X </ifdef>^ca_objects.dimensions.diameter</ifdef>
									<ifdef code="ca_objects.dimensions.weight"><ifdef code="ca_objects.dimensions.height|ca_objects.dimensions.width|ca_objects.dimensions.length|ca_objects.dimensions.diameter"> X </ifdef>^ca_objects.dimensions.weight</ifdef>
									<ifdef code="ca_objects.dimensions.measurement_notes"> (^ca_objects.dimensions.measurement_notes)</ifdef>
								</unit></dd>
							</ifdef>
<?php
								if($t_object->get("ca_objects.artwork_type")){
									if($links = caGetBrowseLinks($t_object, 'ca_objects.artwork_type', ['template' => '<l>^ca_objects.artwork_type</l>', 'linkTemplate' => '^LINK'])) {
?>
										<dt><?= _t('Artwork Type'); ?></dt>
										<dd><?= join(", ", $links); ?></dd>
<?php
									}
								}
								if($t_object->get("ca_objects.artwork_category")){
									if($links = caGetBrowseLinks($t_object, 'ca_objects.artwork_category', ['template' => '<l>^ca_objects.artwork_category</l>', 'linkTemplate' => '^LINK'])) {
?>
										<dt><?= (sizeof($links) > 1) ? _t('Tags') : _t('Tag'); ?></dt>
										<dd><?= join(", ", $links); ?></dd>
<?php
									}
								}
?>
							<ifdef code="ca_objects.credit_line">
								<dt><?= _t('Credit Line'); ?></dt>
								<dd>^ca_objects.credit_line</dd>
							</ifdef>
							<ifdef code="ca_objects.idno">
								<dt><?= _t('Accession Number'); ?></dt>
								<dd>^ca_objects.idno</dd>
							</ifdef>
							
						</dl>}}}
					</div>
					<div class="col-md-4 pb-3">
						{{{<dl>
							<ifcount code="ca_occurrences" min="1">
								<dt><ifcount code="ca_occurrences" restrictToTypes="exhibition" min="1" max="1"><?= _t('Related Exhibition'); ?></ifcount><ifcount code="ca_occurrences" min="2" restrictToTypes="exhibition"><?= _t('Related Exhibitions'); ?></ifcount></dt>
								<unit relativeTo="ca_occurrences" restrictToTypes="exhibition" delimiter=""><dd><l>^ca_occurrences.preferred_labels</l></dd></unit>
							</ifcount>
							<ifdef code="ca_objects.on_display">
								<if rule='^ca_objects.on_display =~ /Yes/'>
									<ifcount code="ca_places" min="1">
										<dt><ifcount code="ca_places" min="1" max="1"><?= _t('Location'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Locations'); ?></ifcount></dt>
										<unit relativeTo="ca_places" delimiter=""><dd><l>^ca_places.preferred_labels</l>
											<ifdef code="ca_places.address"><br/>
												<ifdef code="ca_places.address.address1">^ca_places.address.address1</ifdef>
												<ifdef code="ca_places.address.address2"><ifdef code="ca_places.address.address1"><br/></ifdef>^ca_places.address.address2</ifdef>
												<ifdef code="ca_places.address.city|ca_places.address.state|ca_places.address.zip|ca_places.address.country">
													<ifdef code="ca_places.address.address1|ca_places.address.address2"><br/></ifdef>
													<ifdef code="ca_places.address.city">^ca_places.address.city</ifdef>
													<ifdef code="ca_places.address.state"><ifdef code="ca_places.address.city">, </ifdef>^ca_places.address.state</ifdef>
													<ifdef code="ca_places.address.zip"> ^ca_places.address.zip</ifdef>
													<ifdef code="ca_places.address.country"> ^ca_places.address.country</ifdef>
												</ifdef>
											</ifdef>
										</dd></unit>
									</ifcount>
								</if>
							</ifdef>
							<ifdef code="ca_objects.on_display">
								<if rule='^ca_objects.on_display =~ /Yes/'>
									<dt>Viewing Information</dt>
									<dd>On Display <ifdef code="ca_objects.inside_outside">^ca_objects.inside_outside</ifdef></dd>
									<ifcount code="ca_places" min="1"><unit relativeTo="ca_places">
										<if rule='^ca_places.restrictions.visitation =~ /Yes/'><ifdef code="ca_places.restrictions.restriction_details">
												<dt>Visitation Restrictions</dt>
												<dd>^ca_places.restrictions.restriction_details</dd>
										</if></if>
									</unit></ifcount>
								</if>
								<if rule='^ca_objects.on_display =~ /No/'>
									<dt>Viewing Information</dt>
									<dd>Not on display</dd>
								</if>
							</ifdef>
						</dl>}}}
					</div>
<?php
			if($t_object->get("ca_objects.on_display", array("convertCodesToDisplayText" => true)) == "Yes"){
?>
					<div class="col-md-4 pb-3">
						<div><div id="map" class="map">{{{map}}}</div></div>
					</div>
<?php
			}
?>
				</div>
			</div>
			
		</div>
	</div>
<?php
	$tags = array("Hidden Gem", "Que Chula!", "Selfie-worthy", "Puro San Antonio", "Honoring History", "Love this!", "Learned something new!", "I’ve seen this!");
?>
	<div class="row">
		<div class="col-md-4">
			<H2 class="fs-4">What People Are Saying</H2>
			<ul class="list-group list-group-flush mb-5">
  				<li class="list-group-item">3 people say <strong>Hidden Gem</strong></li>
				<li class="list-group-item">6 people say <strong>Que Chula!</strong></li>
				<li class="list-group-item">26 people say <strong>Selfie-worthy</strong></li>
			</ul>
		</div>
		<div class="col-md-8">
			<H2 class="fs-4">Add Your Review!</H2>
			<div role="group" class="text-center" aria-label="Tag reviews">
<?php
			foreach($tags as $tag){
				print "<button type='button' class='btn btn-light mx-2 mb-2'>".$tag."</button>";				
			}
?>
			</div>
		</div>
	</div>