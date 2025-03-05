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
?>
	<div class="row">
		<div class="col-md-12">
			<H1 class="fs-3">{{{^ca_occurrences.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_occurrences.type_id|ca_occurrences.idno">
				<div class="fw-medium mb-3 text-capitalize">
					<ifdef code="ca_occurrences.type_id">^ca_occurrences.type_id</ifdef>
					<ifdef code="ca_occurrences.idno">, ^ca_occurrences.idno</ifdef>
				</div>
			</ifdef>}}}
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
{{{<ifdef code="ca_object_representations.media.large">
	<div class="row justify-content-center mb-3">
		<div class="col">
			<div class='detailPrimaryImage object-fit-contain'>^ca_object_representations.media.large</div>
		</div>
	</div>
</ifdef>}}}
	<div class="row row-cols-1 row-cols-md-2">
		<div class="col">				
			{{{<dl class="mb-0">
				<ifcount code="ca_entities" min="1">
					<dt><?= _t('Venue'); ?></dt>
					<!-- <unit relativeTo="ca_entities" delimiter="<br>">
						<l>^ca_entities.preferred_labels.displayname</l><if rule="(^ca_entities.location_display.city_display =~ /yes/)">, ^ca_entities.address.city</if>
						<if rule="(^ca_entities.location_display.state_display =~ /yes/)">, ^ca_entities.address.stateprovince</if><if rule="(^ca_entities.location_display.country_display =~ /yes/)">, ^ca_entities.address.country</if>
					</unit> -->
					<unit relativeTo="ca_entities_x_occurrences" delimiter="<br>" sort="ca_entities_x_occurrences.common_date" direction="ASC">
						<unit relativeTo="ca_entities" restrictToRelationshipTypes="venue">
							<l>^ca_entities.preferred_labels.displayname</l>
							<if rule="(^ca_entities.location_display.city_display =~ /yes/)">, ^ca_entities.address.city</if>
							<if rule="(^ca_entities.location_display.state_display =~ /yes/)">, ^ca_entities.address.stateprovince</if>
							<if rule="(^ca_entities.location_display.country_display =~ /yes/)">, ^ca_entities.address.country</if>
						</unit>
						<unit relativeTo="ca_entities_x_occurrences">
							<ifdef code="ca_entities_x_occurrences.exhibition_name"><br/>^ca_entities_x_occurrences.exhibition_name<br/></ifdef>
							<ifdef code="ca_entities_x_occurrences.common_date"><br/>^ca_entities_x_occurrences.common_date<br/></ifdef>
							<ifdef code="ca_entities_x_occurrences.interstitial_notes">Notes: ^ca_entities_x_occurrences.interstitial_notes</ifdef>
						</unit>
					</unit>
				</ifcount>
<!-- 
				<ifcount code="ca_entities_x_occurrences" min="1">
					<dt><?= _t(''); ?></dt>
					<unit relativeTo="ca_entities_x_occurrences" delimiter="<br>">
						<ifdef code="ca_entities_x_occurrences.exhibition_name"><l>^ca_entities_x_occurrences.exhibition_name</l></ifdef>
						<ifdef code="ca_entities_x_occurrences.common_date">^ca_entities_x_occurrences.common_date</ifdef>
						<ifdef code="ca_entities_x_occurrences.interstitial_notes">Notes: ^ca_entities_x_occurrences.interstitial_notes</ifdef>
					</unit>
				</ifcount> -->
			</dl>}}}
		</div>
		<div class="col">
			{{{<dl class="mb-0">
				<ifcount code="ca_entities" min="1" restrictToTypes="ind" excludeRelationshipTypes="venue">
					<dt>
						<ifcount code="ca_entities" min="1" max="1" restrictToTypes="ind" excludeRelationshipTypes="venue"><?= _t('Related Person'); ?></ifcount>
						<ifcount code="ca_entities" min="2" restrictToTypes="ind" excludeRelationshipTypes="venue"><?= _t('Related People'); ?></ifcount>
					</dt>
					<unit relativeTo="ca_entities" delimiter="<br>" restrictToTypes="ind" excludeRelationshipTypes="venue">
						<dd><l>^ca_entities.preferred_labels</l> (^relationship_typename)</dd>
					</unit>
				</ifcount>

				<ifcount code="ca_entities" min="1" restrictToTypes="org" excludeRelationshipTypes="venue">
					<dt>
						<ifcount code="ca_entities" min="1" max="1" restrictToTypes="org" excludeRelationshipTypes="venue"><?= _t('Related Organization'); ?></ifcount>
						<ifcount code="ca_entities" min="2" restrictToTypes="org" excludeRelationshipTypes="venue"><?= _t('Related Organizations'); ?></ifcount>
					</dt>
					<unit relativeTo="ca_entities" delimiter="<br>" restrictToTypes="org" excludeRelationshipTypes="venue">
						<dd><l>^ca_entities.preferred_labels</l> (^relationship_typename)</dd>
					</unit>
				</ifcount>

				<ifcount code="ca_occurrences" min="1" restrictToTypes="literature">
					<dt>
						<ifcount code="ca_occurrences.related" min="1" max="1" restrictToTypes="literature"><?= _t('Related Occurrence'); ?></ifcount>
						<ifcount code="ca_occurrences.related" min="2" restrictToTypes="literature"><?= _t('Related Occurrences'); ?></ifcount>
					</dt>
					<unit relativeTo="ca_occurrences.related" delimiter="<br>" restrictToTypes="literature" sort="ca_occurrences.pub_date" sortDirection="ASC">
						<dd><l>^ca_occurrences.lit_citation</l></dd>
					</unit>
				</ifcount>
			</dl>}}}					
		</div>
	</div>

{{{<ifcount code="ca_objects" min="1">
	<div class="row mt-4">
		<div class="col"><h2>Related Artworks</h2><hr></div>
	</div>
	<div class="row" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_occurrences.occurrence_id:'.$t_item->get("ca_occurrences.occurrence_id"))); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
	</div>
</ifcount>}}}