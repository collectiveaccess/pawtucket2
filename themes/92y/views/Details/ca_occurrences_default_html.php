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

$vb_archive_staff = false;
if($this->request->user->hasRole("front_archive_staff")){
	$vb_archive_staff = true;
}

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
			{{{<ifdef code="ca_occurrences.event_type_id"><div class="fw-medium mb-3 text-capitalize">^ca_occurrences.event_type</div></ifdef>}}}
			<hr class="mb-0 bg-black">
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
				<ifdef code="ca_occurrences.common_date">
					<dt><?= _t('Date'); ?></dt>
					<dd>
						^ca_occurrences.common_date
					</dd>
				</ifdef>
				<ifdef code="ca_occurrences.ev_location">
					<dt><?= _t('Location'); ?></dt>
					<dd>
						^ca_occurrences.ev_location
					</dd>
				</ifdef>
				<ifdef code="ca_occurrences.ev_season">
					<dt><?= _t('Season'); ?></dt>
					<dd>
						^ca_occurrences.ev_season
					</dd>
				</ifdef>
				<ifdef code="ca_occurrences.general_notes">
					<dt><?= _t('Note'); ?></dt>
					<dd>
						^ca_occurrences.general_notes
					</dd>
				</ifdef>
				<ifdef code="ca_occurrences.idno">
					<dt><?= _t('Identifier'); ?></dt>
					<dd>
						^ca_occurrences.idno
					</dd>
				</ifdef>
			</dl>}}}
		</div>
		<div class="col">
			{{{<dl class="mb-0">
				<ifdef code="ca_occurrences.description">
					<dt><?= _t('Abstract'); ?></dt>
					<dd>
						^ca_occurrences.description
					</dd>
				</ifdef>
				<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="sponsor">
					<dt><ifcount code="ca_entities" restrictToRelationshipTypes="sponsor" min="1" max="1"><?= _t('Sponsor'); ?></ifcount><ifcount code="ca_entities" restrictToRelationshipTypes="sponsor" min="2"><?= _t('Sponsors'); ?></ifcount></dt>
					<unit relativeTo="ca_entities" restrictToRelationshipTypes="sponsor" delimiter=""><dd><l><ifdef code="ca_entities.ev_sponsor_credit">^ca_entities.ev_sponsor_credit</ifdef><ifnotdef code="ca_entities.ev_sponsor_credit">^ca_entities.preferred_labels</ifnotdef></l></dd></unit>
				</ifcount>
				<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="center">
					<dt><ifcount code="ca_entities" restrictToRelationshipTypes="center" min="1" max="1"><?= _t('Center'); ?></ifcount><ifcount code="ca_entities" restrictToRelationshipTypes="center" min="2"><?= _t('Centers'); ?></ifcount></dt>
					<unit relativeTo="ca_entities" restrictToRelationshipTypes="center" delimiter=""><dd><l>^ca_entities.preferred_labels</l></dd></unit>
				</ifcount>
				<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="broadcast">
					<dt><ifcount code="ca_entities" restrictToRelationshipTypes="broadcast" min="1" max="1"><?= _t('Broadcast Outlet'); ?></ifcount><ifcount code="ca_entities" restrictToRelationshipTypes="broadcast" min="2"><?= _t('Broadcast Outlets'); ?></ifcount></dt>
					<unit relativeTo="ca_entities" restrictToRelationshipTypes="broadcast" delimiter=""><dd><l>^ca_entities.preferred_labels</l></dd></unit>
				</ifcount>
				<ifdef code="ca_occurrences.ev_primary_series">
					<dt><?= _t('Primary Series'); ?></dt>
					<dd>
						^ca_occurrences.ev_primary_series
					</dd>
				</ifdef>
				<ifdef code="ca_occurrences.ev_secondary_series">
					<dt><?= _t('Secondary Series'); ?></dt>
					<dd>
						^ca_occurrences.ev_secondary_series
					</dd>
				</ifdef>
				<ifdef code="ca_occurrences.ev_series_type">
					<dt><?= _t('Series'); ?></dt>
					<dd>
						^ca_occurrences.ev_series_type
					</dd>
				</ifdef>
				<ifdef code="ca_occurrences.ev_topic">
					<dt><?= _t('Topic'); ?></dt>
					<dd>
						^ca_occurrences.ev_topic
					</dd>
				</ifdef>
				<ifdef code="ca_occurrences.ev_subtopic">
					<dt><?= _t('Subtopic'); ?></dt>
					<dd>
						^ca_occurrences.ev_subtopic
					</dd>
				</ifdef>
				
			</dl>}}}					
		</div>
	</div>
	{{{<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="performer">
		<dl class="row">
			<dt class="col-12 mt-3 mb-2"><ifcount code="ca_entities" restrictToRelationshipTypes="performer" min="1" max="1"><?= _t('Performer'); ?></ifcount><ifcount code="ca_entities"  restrictToRelationshipTypes="performer" min="2"><?= _t('Performers'); ?></ifcount></dt>
			<unit relativeTo="ca_entities" delimiter="" restrictToRelationshipTypes="performer"><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 px-2 d-flex align-items-center justify-content-center bg-light h-100 w-100 text-black">^ca_entities.preferred_labels</l></dd></unit>
		</dl>
	</ifcount>}}}
{{{<ifcount code="ca_objects" min="1">
	<div class="row">
		<div class="col"><h2>Event Media</h2><hr></div>
	</div>
	<div class="row" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_occurrences.occurrence_id:'.$t_item->get("ca_occurrences.occurrence_id"), '_advanced' => 0)); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
	</div>
</ifcount>}}}