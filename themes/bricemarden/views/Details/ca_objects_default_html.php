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
<?php
if($show_nav){
	$results_link = $previous_link = $next_link;
	if($this->getVar("resultsURL")){
		$results_link = "<a href='".$this->getVar("resultsURL")."' class='".(($previous_link || $next_link) ? "pe-4 " : "").$options["detailNavLinkClass"]."'>".$options["resultsLink"]."</a>";
	}
	if($this->getVar("nextID")){
		$next_link = "<a href='".$this->getVar("nextURL")."' class='pe-0 ".$options["detailNavLinkClass"]."'>".$options["nextLink"]."</a>";
	}
	if($this->getVar("previousID")){
		$previous_link = "<a href='".$this->getVar("previousURL")."' class='pe-0 ".$options["detailNavLinkClass"]."'>".$options["previousLink"]."</a>";
	}
	
	
?>
	<div class="row mt-n4">
		<div class="col text-center text-md-end">
			<nav aria-label="result"><?= $results_link.$previous_link.$next_link; ?></nav>
		</div>
	</div>
<?php
}
	if(caDisplayLightbox($this->request) || $inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
	<div class="row">
		<div class="col text-center text-md-end">
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
		</div>
	</div>
<?php
	}
?>

	<div class="row">
		<div class="col-md-6">
			{{{media_viewer}}}
		</div>
		<div class="col-md-6 pb-lg-5">
			{{{<H1 class="pb-4 mb-0">^ca_objects.preferred_labels.name</H1>
				<div class="pb-4">
					<ifdef code='ca_objects.print_date'>^ca_objects.print_date<br/></ifdef>
					<ifdef code='ca_objects.medium.medium_notes_text'>^ca_objects.medium.medium_notes_text<br/></ifdef>
					<ifdef code='ca_objects.master_dimensions'>^ca_objects.master_dimensions%delimiter=;_<br/></ifdef>
					<ifdef code="ca_objects.inscription_text"><br/>^ca_objects.inscription_text</ifdef>
				</div>
				<ifdef code='ca_objects.sort_number'><div class="pb-4 fullHeightNumbers"><div class='fst-italic'>Catalogue Number</div>^ca_objects.sort_number</div></ifdef>
				<ifdef code="ca_objects.creation_location">
					<div class='pb-4'><div class='fst-italic'>Studio (list field)</div>
<?php
					if($creation_location = caGetBrowseLinks($t_object, 'ca_objects.creation_location', ['template' => '<div><l>^ca_objects.creation_location</l></div>', 'linkTemplate' => '^LINK'])) {
						print join("", $creation_location);
					}
?>
					</div>
				</ifdef>
				<ifcount code="ca_places" restrictToRelationshipTypes="created" min="1">
					<dt><?= _t('Studio'); ?></dt>
					<unit relativeTo="ca_places" delimiter="" restrictToRelationshipTypes="created"><dd><l>^ca_places.preferred_labels</l></dd></unit>
				</ifcount>
			}}}
		</div>
	</div>
	<div class="row mt-lg-5">
		<div class="col-md-4">
			<div id="col1">
			{{{<dl>
				<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="provenance">
					<dt class='pt-3 mb-2'><?= _t('Provenance'); ?></dt>
<?php
					$provenances = array();
					$provenances = $t_object->getWithTemplate('<unit relativeTo="ca_objects_x_entities" delimiter=";;" restrictToRelationshipTypes="provenance" sort="ca_objects_x_entities.rank">^ca_objects_x_entities.entity_id::^ca_objects_x_entities.interstitial_notes</unit>');
					$provenances = explode(";;", $provenances);
					foreach($provenances as $provenance){
						$pieces = explode("::", $provenance);
						print "<dd class='mb-2'>".caNavLink($this->request, $pieces[1], '', 'Browse', 'artworks', '', array('facet'=>'provenance_facet', 'id' => $pieces[0]))."</dd>";
					}
?>
				</ifcount>
				<ifdef code='ca_objects.nonpreferred_labels'>
					<dt class='pt-3 mb-2'>Alternate Title</dt>
					<dd class='mb-2'>^ca_objects.nonpreferred_labels%delimiter=<br/></dd>
				</ifdef>
				<ifdef code="ca_objects.group">
					<dt class='pt-3 mb-2'><?= _t('Group'); ?></dt>
<?php
					if($group = caGetBrowseLinks($t_object, 'ca_objects.group', ['template' => '<dd class="mb-2"><l>^ca_objects.group</l></dd>', 'linkTemplate' => '^LINK'])) {
						print join("", $group);
					}
?>	
				</ifdef>
				<ifdef code="ca_objects.notes">
					<dt class='pt-3 mb-2'><?= _t('Notes'); ?></dt>
					<dd class='mb-2'>^ca_objects.notes</dd>
				</ifdef>
			</dl>}}}
			</div>
		</div>
	{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="exhibition" restrictToRelationshipTypes="includes">
		<div class="col-md-4">
			<div id="readMoreCol2" class="readMore">
				<dl>
					<ifcount code="ca_occurrences" min="1" restrictToTypes="exhibition" restrictToRelationshipTypes="includes">
						<if rule="^ca_occurrences.solo_group =~ /solo/i"><dt class='pt-3 mb-2'><?= _t('Solo Exhibitions'); ?></dt></if>
						<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="exhibition" restrictToRelationshipTypes="includes" skipIfExpression="^ca_occurrences.solo_group =~ /group/i"><dd class="mb-2"><l><i>^ca_occurrences.preferred_labels</i><ifdef code='ca_occurrences.exhibition_year'>, ^ca_occurrences.exhibition_year</ifdef><ifcount code='ca_entities' min='1' restrictToRelationshipTypes='venue'>, <unit relativeTo='ca_entities_x_occurrences' restrictToRelationshipTypes='venue' delimiter='; '>^ca_entities.preferred_labels<if rule='^ca_entities.location_display.city_display =~ /yes/'><ifdef code='ca_entities.address.city'>, ^ca_entities.address.city</ifdef></if><if rule='^ca_entities.location_display.state_display =~ /yes/'><ifdef code='ca_entities.address.stateprovence'>, ^ca_entities.address.stateprovence</ifdef></if><if rule='^ca_entities.location_display.country_display =~ /yes/'><ifdef code='ca_entities.address.country'>, ^ca_entities.address.country</ifdef></if><ifdef code='ca_entities_x_occurrences.common_date'>, ^ca_entities_x_occurrences.common_date</ifdef></unit></ifcount></l></dd></unit>
					</ifcount>
					<ifcount code="ca_occurrences" min="1" restrictToTypes="exhibition" restrictToRelationshipTypes="includes">
						<if rule="^ca_occurrences.solo_group =~ /group/i"><dt class='pt-3 mb-2'><?= _t('Group Exhibitions'); ?></dt></if>
						<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="exhibition" restrictToRelationshipTypes="includes" skipIfExpression="^ca_occurrences.solo_group =~ /solo/i"><dd class="mb-2"><l><i>^ca_occurrences.preferred_labels</i><ifdef code='ca_occurrences.exhibition_year'>, ^ca_occurrences.exhibition_year</ifdef><ifcount code='ca_entities' min='1' restrictToRelationshipTypes='venue'>, <unit relativeTo='ca_entities_x_occurrences' restrictToRelationshipTypes='venue' delimiter='; '>^ca_entities.preferred_labels<if rule='^ca_entities.location_display.city_display =~ /yes/'><ifdef code='ca_entities.address.city'>, ^ca_entities.address.city</ifdef></if><if rule='^ca_entities.location_display.state_display =~ /yes/'><ifdef code='ca_entities.address.stateprovence'>, ^ca_entities.address.stateprovence</ifdef></if><if rule='^ca_entities.location_display.country_display =~ /yes/'><ifdef code='ca_entities.address.country'>, ^ca_entities.address.country</ifdef></if><ifdef code='ca_entities_x_occurrences.common_date'>, ^ca_entities_x_occurrences.common_date</ifdef></unit></ifcount></l></dd></unit>
					</ifcount>
				</dl>
			</div>
			<div><button id="readMoreCol2Btn" class="btn btn-white btn-sm px-0 mt-2 readMoreButton d-none" hx-on:click="htmx.toggleClass(htmx.find('#readMoreCol2'), 'readMoreExpanded'); htmx.toggleClass(htmx.find('#readMoreCol2Btn'), 'readMoreButtonExpanded');" aria-label="Read More / Less"></button></div>				
		</div>
	</ifcount>}}}
	{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="literature" restrictToRelationshipTypes="references">
		<div class="col-md-4">
			<div id="readMoreCol3" class="readMore">
				<dl>
					<dt class='pt-3 mb-2'><?= _t('Literature'); ?></dt>
					<?php print str_replace(array("<p>", "</p>"), array("", ""), $t_object->getWithTemplate('<unit relativeTo="ca_objects_x_occurrences" delimiter="" restrictToTypes="literature" restrictToRelationshipTypes="references"><dd class="mb-2"><l>^ca_occurrences.lit_citation<ifdef code="ca_objects_x_occurrences.citation">, ^ca_objects_x_occurrences.citation</ifdef><if rule="^ca_objects_x_occurrences.illustrated =~ /yes/"> (Illustrated)</if></l></dd></unit>')); ?>
				</dl>
			</div>			
			<div><button id="readMoreCol3Btn" class="btn btn-white btn-sm px-0 mt-2 readMoreButton d-none" hx-on:click="htmx.toggleClass(htmx.find('#readMoreCol3'), 'readMoreExpanded'); htmx.toggleClass(htmx.find('#readMoreCol3Btn'), 'readMoreButtonExpanded');" aria-label="Read More / Less"></button></div>	
		</div>
	</ifcount>}}}			
	</div>
<script>
window.addEventListener('load', function(evt) {
     // Select elements by class name
	const col1 = document.querySelector('#col1');
	const readMoreColDivs = document.querySelectorAll('.readMore');
	const readMoreButtons = document.querySelectorAll('.readMoreButton');
	const height = col1.offsetHeight;
	if(height && readMoreColDivs){
		readMoreColDivs.forEach((readMoreCol) => {
			const colBtn = document.querySelector('#' + readMoreCol.id + 'Btn');
			if(height < readMoreCol.offsetHeight){
				readMoreCol.style.maxHeight = height + 'px';
				colBtn.classList.remove('d-none');
				colBtn.classList.add('d-block');
			}else{
				colBtn.classList.remove('d-block');
				colBtn.classList.add('d-none');
				readMoreCol.style.maxHeight = none;
			}
		});
    }   
});
</script>
{{{<ifcount code="ca_objects.related" min="1">
	<div class="row mt-5"><div class="col"><h2>Related Artwork<ifcount code="ca_objects.related" min="s">s</ifcount></h2></div></div>
	<div class="row" id="browseResultsContainer">
		<unit relativeTo="ca_objects.related" delimiter="">
			<div class="col-md-6 col-lg-4 d-flex">
				<div class="card flex-grow-1 width-100 rounded-0 border-0 mb-4 px-0">
					<l>^ca_object_representations.media.large%class=card-img-top,object-fit-contain,pt-3,rounded-0</l>
					<div class="card-body px-0">
						<div class='card-title mb-1'><div class='fw-medium lh-sm fs-5'><l>^ca_objects.preferred_labels</l></div></div><p class='card-text small lh-sm'><ifdef code='ca_objects.print_date'>^ca_objects.print_date</ifdef></p>
					</div>
				 </div>	
			</div>
		</unit>
	</div>	
</ifcount>}}}
