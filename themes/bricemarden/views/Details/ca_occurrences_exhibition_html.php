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

	if($inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
	<div class="row">
		<div class="col text-center text-md-end">
			<div class="btn-group" role="group" aria-label="Detail Controls">
<?php
				if($inquire_enabled) {
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_occurrences", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_occurrences", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_occurrences_summary'));
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
	<div class="row row-cols-1 my-3">
		<div class="col">				
			{{{<H1 class="pb-3">^ca_occurrences.preferred_labels.name<ifdef code="ca_occurrences.exhibition_year">, ^ca_occurrences.exhibition_year</ifdef></H1>
				<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="venue"><unit relativeTo="ca_entities_x_occurrences" restrictToRelationshipTypes="venue" delimiter=""><div class="pb-3">^ca_entities.preferred_labels<if rule="^ca_entities.location_display.city_display =~ /yes/"><ifdef code="ca_entities.address.city">, ^ca_entities.address.city</ifdef></if><if rule="^ca_entities.location_display.state_display =~ /yes/"><ifdef code="ca_entities.address.stateprovence">, ^ca_entities.address.stateprovence</ifdef></if><if rule="^ca_entities.location_display.country_display =~ /yes/"><ifdef code="ca_entities.address.country">, ^ca_entities.address.country</ifdef></if><ifdef code="ca_entities_x_occurrences.common_date">, ^ca_entities_x_occurrences.common_date</ifdef></div></unit></ifcount>
				<dl class="mb-0">
					<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="curator">
						<dt><ifcount code="ca_entities" min="1" max="1" restrictToRelationshipTypes="curator"><?= _t('Curator'); ?></ifcount><ifcount code="ca_entities" min="2" restrictToRelationshipTypes="curator"><?= _t('Curators'); ?></ifcount></dt>
						<unit relativeTo="ca_entities" delimiter="" restrictToRelationshipTypes="curator"><dd>^ca_entities.preferred_labels</dd></unit>
					</ifcount>
					<ifdef code="ca_occurrences.exhibition_organizer">
						<dt><?= _t('Note'); ?></dt>
						<dd>^ca_occurrences.exhibition_organizer</dd>
					</ifdef>
					<ifcount code="ca_occurrences.related" min="1" restrictToTypes="literature" restrictToRelationshipTypes="related">
						<dt><?= _t('Literature'); ?></dt>
						<unit relativeTo="ca_occurrences.related" delimiter="" restrictToTypes="literature" restrictToRelationshipTypes="related"><dd><l>^ca_occurrences.lit_citation</l></dd></unit>
					</ifcount>
				</dl>}}}
		</div>
	</div>
{{{<ifcount code="ca_objects" min="1" restrictToRelationshipTypes="includes">
	<if rule="^ca_objects.classification =~ /painting/i">
	<div class="row">
		<div class="col"><h2>Exhibited Artworks</h2></div>
	</div>
	<div class="row" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Browse', 'artworks', array('facet' => 'exhibition_facet', 'id' => $t_item->get("ca_occurrences.occurrence_id"))); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
	</div>
	</if>
</ifcount>}}}