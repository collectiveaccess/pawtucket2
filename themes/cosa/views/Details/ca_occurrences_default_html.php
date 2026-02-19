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

<div class="breadcrumb"><div class='container-xl'><div class="py-2 fs-6">
<?php
	if($resultURL = $this->getVar("resultsURL")){
		print "<a href='".$resultURL."' class='me-4'><i class='bi bi-chevron-left small'></i>Back</a>";
	}
	print caNavLink($this->request, _t("Art Collection"), '', '', '', '', '');
	print " / ";			
	$url = $this->getVar("resultsURL");
	if($url && (str_contains($url, "Listing"))){
		print "<a href='".$url."'>"._t("Current Exhibitions")."</a>";
	}elseif($url && (str_contains($url, "Browse"))){
		print "<a href='".$url."'>"._t("Past Exhibitions")."</a>";
	}else{
		print caNavLink($this->request, _t("Exhibitions"), '', '', 'Browse', 'exhibitions', '');
	}
	print " / ".$t_item->get("ca_occurrences.preferred_labels.name");					
?>
</div></div></div>	
<div class='container-xl pt-4'><?php # --- this container is usually out put in header, but here so the breadcrumb trail can be output
?>	
	<div class="row mt-n3">
		<div class="col-md-6 text-center text-md-start">
<?php
			if($inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
				<div class="btn-group" role="group" aria-label="Detail Controls">
<?php
							if($inquire_enabled) {
								print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_occurrences", "id" => $id));
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
			<H1 class="fs-2 mb-1">{{{<i>^ca_occurrences.preferred_labels.name</i>}}}</H1>
			{{{<ifdef code="ca_occurrences.date"><div class="fs-4">^ca_occurrences.date</div></ifdef>}}}
			{{{<ifdef code="ca_occurrences.summary"><hr><div>^ca_occurrences.summary</div></ifdef>}}}
		</div>
	</div>
<?php
	$artists = array();
	$artist_list = $t_item->getWithTemplate('<ifcount code="ca_objects" min="1"><unit relativeTo="ca_objects" delimiter=", "><ifcount code="ca_entities" min="1" restrictToRelationshipTypes="artist"><unit relativeTo="ca_entities" restrictToRelationshipTypes="artist" delimiter=", "><l>^ca_entities.preferred_labels</l></unit></ifcount></unit></ifcount>', array("checkAccess" => $access_values));
	if($artist_list){
		$artists = explode(", ", $artist_list);
		$artists = array_unique($artists);
		$artist_list = join(", ", $artists);
	}
?>
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
<?php
								if($artist_list){
									print "<dt>Artists</dt><dd>".$artist_list."</dd>";
								}
?>
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
								<if rule='^ca_places.restrictions.visitation =~ /Yes/'><ifdef code="ca_places.restrictions.restriction_details">
										<dt>Visitation Restrictions</dt>
										<dd>^ca_places.restrictions.restriction_details</dd>
								</if></if>
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
{{{<ifcount code="ca_objects" min="1" restrictToRelationshipTypes="featured">
	<div class="row">
		<div class="col"><hr class="pb-4"></div>
	</div>
	<div class="row exhibitionsDetail" id="browseResultsContainer">	
		<unit relativeTo="ca_objects" restrictToRelationshipTypes="featured" delimiter="">
			<div class="col-md-6 d-flex pb-4">
				<div class="card flex-grow-1 w-100 h-100 rounded-0 shadow border-0">
					<l><div class="row g-0 align-items-center">
						<div class="col-6">
							^ca_object_representations.media.medium%class=card-img-top,object-fit-contain,p-3,rounded-0
						</div>
						<div class="col-6">
							<div class="card-body px-0">
								<div class='card-title'>
									<div class='fw-medium lh-sm fs-5'><ifcount code='ca_entities' min='1' restrictToRelationshipTypes='artist'><unit relativeTo='ca_entities' restrictToRelationshipTypes='artist' delimiter=', '>^ca_entities.preferred_labels</unit><br/></ifcount><i>^ca_objects.preferred_labels.name</i>
									</div>
								</div><ifdef code='ca_objects.date_completed|ca_objects.media'><div class='card-text small lh-sm'>^ca_objects.date_completed%format=Y<ifdef code='ca_objects.date_completed,ca_objects.media'>, </ifdef><ifdef code='ca_objects.date_completed,ca_objects.media'>^ca_objects.media%delimiter=,_</ifdef></div></ifdef>
							</div>
						</div>
					</div></l>
					<div class="row">
						<div class="col-12">
							<div class="card-footer text-end bg-transparent">
								<l class="btn btn-white px-2 ms-1" title="View Record" aria-label="View Record"><i class="bi bi-arrow-right-square"></i> Get Details</l>
							</div>
						</div>
					</div>
				 </div>		
			</div>
		</unit>
	</div>
</ifcount>}}}