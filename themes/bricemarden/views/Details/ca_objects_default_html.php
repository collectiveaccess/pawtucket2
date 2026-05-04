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
?>
	<div class="row mt-n3">
		<div class="col text-center text-md-end">
			<nav aria-label="result">{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</nav>
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

	<div class="row align-items-center">
		<div class="col-md-6">
			{{{media_viewer}}}
		</div>
		<div class="col-md-6 pb-5">
			{{{<ifdef code='ca_objects.sort_number'><div class="fs-4 pb-3">^ca_objects.sort_number</div></ifdef>
				<H1 class="pb-3">^ca_objects.preferred_labels.name</H1>
				<div class="pb-3">
					<ifdef code='ca_objects.print_date'>^ca_objects.print_date<br/></ifdef>
					<ifdef code='ca_objects.medium.medium_notes_text'>^ca_objects.medium.medium_notes_text<br/></ifdef>
					<ifdef code='ca_objects.master_dimensions'>^ca_objects.master_dimensions%delimiter=;_<br/></ifdef>
					<ifdef code="ca_objects.inscription_text"><br/>^ca_objects.inscription_text</ifdef>
				</ifdef>
				</div>
			}}}
		</div>
	</div>
	<div class="row mt-5">
		<div class="col-md-4">
			{{{<dl>
				<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="provenance">
					<dt><?= _t('Provenance'); ?></dt>
					<dd>
					<unit relativeTo="ca_objects_x_entities" delimiter="<br/>" restrictToRelationshipTypes="provenance">^ca_objects_x_entities.interstitial_notes</unit>
					</dd>
				</ifcount>
				<ifdef code='ca_objects.nonpreferred_labels'>
					<dt>Alternate Title</dt>
					<dd>^ca_objects.nonpreferred_labels%delimiter=<br/></dd>
				</ifdef>
				<ifdef code='ca_objects.creation_location'>
					<dt>Studio</dt>
					<unit relativeTo="ca_objects.creation_location"><dd>^ca_objects.creation_location</dd></unit>
				</ifdef>
				<ifdef code="ca_objects.notes">
					<dt><?= _t('Notes'); ?></dt>
					<dd>^ca_objects.notes</dd>
				</ifdef>
			</dl>}}}
		</div>
	{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="exhibition" restrictToRelationshipTypes="includes">
		<div class="col-md-4">
			<dl>
				<ifcount code="ca_occurrences" min="1" restrictToTypes="exhibition" restrictToRelationshipTypes="includes">
					<if rule="^ca_occurrences.solo_group =~ /solo/i"><dt><?= _t('Solo Exhibitions'); ?></dt></if>
					<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="exhibition" restrictToRelationshipTypes="includes" skipIfExpression="^ca_occurrences.solo_group =~ /group/i"><dd><l><i>^ca_occurrences.preferred_labels</i><ifdef code='ca_occurrences.exhibition_year'>, ^ca_occurrences.exhibition_year</ifdef><ifcount code='ca_entities' min='1' restrictToRelationshipTypes='venue'>, <unit relativeTo='ca_entities_x_occurrences' restrictToRelationshipTypes='venue' delimiter='; '>^ca_entities.preferred_labels<if rule='^ca_entities.location_display.city_display =~ /yes/'><ifdef code='ca_entities.address.city'>, ^ca_entities.address.city</ifdef></if><if rule='^ca_entities.location_display.state_display =~ /yes/'><ifdef code='ca_entities.address.stateprovence'>, ^ca_entities.address.stateprovence</ifdef></if><if rule='^ca_entities.location_display.country_display =~ /yes/'><ifdef code='ca_entities.address.country'>, ^ca_entities.address.country</ifdef></if><ifdef code='ca_entities_x_occurrences.common_date'>, ^ca_entities_x_occurrences.common_date</ifdef></unit></ifcount></l></dd></unit>
				</ifcount>
				<ifcount code="ca_occurrences" min="1" restrictToTypes="exhibition" restrictToRelationshipTypes="includes">
					<if rule="^ca_occurrences.solo_group =~ /group/i"><dt><?= _t('Group Exhibitions'); ?></dt></if>
					<unit relativeTo="ca_occurrences" delimiter="" restrictToTypes="exhibition" restrictToRelationshipTypes="includes" skipIfExpression="^ca_occurrences.solo_group =~ /solo/i"><dd><l><i>^ca_occurrences.preferred_labels</i><ifdef code='ca_occurrences.exhibition_year'>, ^ca_occurrences.exhibition_year</ifdef><ifcount code='ca_entities' min='1' restrictToRelationshipTypes='venue'>, <unit relativeTo='ca_entities_x_occurrences' restrictToRelationshipTypes='venue' delimiter='; '>^ca_entities.preferred_labels<if rule='^ca_entities.location_display.city_display =~ /yes/'><ifdef code='ca_entities.address.city'>, ^ca_entities.address.city</ifdef></if><if rule='^ca_entities.location_display.state_display =~ /yes/'><ifdef code='ca_entities.address.stateprovence'>, ^ca_entities.address.stateprovence</ifdef></if><if rule='^ca_entities.location_display.country_display =~ /yes/'><ifdef code='ca_entities.address.country'>, ^ca_entities.address.country</ifdef></if><ifdef code='ca_entities_x_occurrences.common_date'>, ^ca_entities_x_occurrences.common_date</ifdef></unit></ifcount></l></dd></unit>
				</ifcount>
			</dl>
		</div>
	</ifount>}}}
	{{{<ifcount code="ca_occurrences" min="1" restrictToTypes="literature" restrictToRelationshipTypes="references">
		<div class="col-md-4">
			<dl>
				<dt><?= _t('Literature'); ?></dt>
				<?php print str_replace(array("<p>", "</p>"), array("", ""), $t_object->getWithTemplate('<unit relativeTo="ca_objects_x_occurrences" delimiter="" restrictToTypes="literature" restrictToRelationshipTypes="references"><dd><l>^ca_occurrences.lit_citation<ifdef code="ca_objects_x_occurrences.citation">, ^ca_objects_x_occurrences.citation</ifdef><if rule="^ca_objects_x_occurrences.illustrated =~ /yes/"> (Illustrated)</if></l></dd></unit>')); ?>
			</dl>
		</div>
	</ifcount>}}}			
	</div>
{{{<ifcount code="ca_objects.related" min="1">
	<div class="row mt-5"><div class="col"><h2>Related Artwork<ifcount code="ca_objects.related" min="s">s</ifcount></h2></div></div>
	<div class="row">
		<unit relativeTo="ca_objects.related" delimiter="">
			<div class="col-md-6 col-lg-4 d-flex">
				<div class="card flex-grow-1 width-100 rounded-0 shadow border-0 mb-4">
					<l>^ca_object_representations.media.medium%class=card-img-top,object-fit-contain,px-3,pt-3,rounded-0</l>
					<div class="card-body">
						<div class='card-title mb-1'><div class='fw-medium lh-sm fs-5'><l>^ca_objects.preferred_labels</l></div></div><p class='card-text small lh-sm'><ifdef code='ca_objects.print_date'>^ca_objects.print_date</ifdef></p>
					</div>
				 </div>	
			</div>
		</unit>
	</div>	
</ifcount>}}}
