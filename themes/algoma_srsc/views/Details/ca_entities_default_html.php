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
	if($show_nav){
?>
	<div class="row">
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
			{{{<ifdef code="ca_entities.type_id"><div class="fw-medium mb-3 text-capitalize">^ca_entities.type_id</div></ifdef>}}}
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
?>{{{<ifdef code="ca_object_representations.media.large">
	<div class="row justify-content-center mb-3">
		<div class="col">
			<div class='detailPrimaryImage object-fit-contain'>^ca_object_representations.media.large</div>
		</div>
	</div>
</ifdef>}}}
	<div class="row row-cols-1 row-cols-md-2">
		<div class="col">				
			{{{<dl class="mb-0">
				<ifdef code="ca_entities.bio_history.bio">
					<dt><?= _t('Biography/History'); ?></dt>
					<dd>
						^ca_entities.bio_history.bio
						<ifdef code="ca_entities.bio_history.bio_note"><div class="mt-1 small"><i>^ca_entities.bio_history.bio_note</i></div></ifdef>
					</dd>
				</ifdef>
			</dl>}}}
			{{{<dl class="mb-0">
				<ifdef code="ca_entities.life_dates.dates">
					<dt><?= _t('Life Dates'); ?></dt>
					<dd>
						^ca_entities.life_dates.dates<ifdef code="ca_entities.life_dates.life_note">, ^ca_entities.life_dates.life_note</ifdef>
					</dd>
				</ifdef>
			</dl>}}}
			
		</div>
		<div class="col">
			{{{<dl class="mb-0">
				<ifcount code="ca_entities" min="1">
					<dt><ifcount code="ca_entities.related" restrictToTypes="group,individual" min="1" max="1"><?= _t('Related Person/Group'); ?></ifcount><ifcount code="ca_entities.related" restrictToTypes="group,individual" min="2"><?= _t('Related People/Groups'); ?></ifcount></dt>
					<unit relativeTo="ca_entities.related" restrictToTypes="group,individual" delimiter=""><dd><l>^ca_entities.preferred_labels</l> (^relationship_typename)</dd></unit>
				</ifcount>
				<ifcount code="ca_entities" restrictToTypes="school" min="1">
					<dt><ifcount code="ca_entities.related" restrictToTypes="school" min="1" max="1"><?= _t('Related School'); ?></ifcount><ifcount code="ca_entities.related" restrictToTypes="school" min="2"><?= _t('Related Schools'); ?></ifcount></dt>
					<unit relativeTo="ca_entities.related" restrictToTypes="school" delimiter=""><dd><l>^ca_entities.preferred_labels</l> (^relationship_typename)</dd></unit>
				</ifcount>

				<ifcount code="ca_places" min="1">
					<dt><ifcount code="ca_places" min="1" max="1"><?= _t('Related Place'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Related Places'); ?></ifcount></dt>
					<unit relativeTo="ca_places" delimiter=""><dd><l>^ca_places.preferred_labels</l></dd></unit>
				</ifcount>
			</dl>}}}					
		</div>
	</div>
{{{<ifcount code="ca_collections" excludeTypes="file" min="1" restrictToSources="SRSC">
	<dl class="row">
		<dt class="col-12 mt-3 mb-2"><H2 class="d-inline"><?= _t('Related Collections, Sous-Fonds, & Series'); ?></H2> <ifcount code="ca_collections" excludeTypes="file" min="9" restrictToSources="SRSC"><?php print caNavLink($this->request, 'Browse All', 'btn btn-light ms-3 mt-n3', '', 'Browse', 'collections_non_files', array('facet' => 'entity_facet', 'id' => $t_item->get("ca_entities.entity_id"))); ?></ifcount></dt>
		<unit relativeTo="ca_collections" excludeTypes="file" unique="1" delimiter="" limit="8" restrictToSources="SRSC"><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black px-2">^ca_collections.preferred_labels</l></dd></unit>
	</dl>
</ifcount>}}}
{{{<ifcount code="ca_collections" restrictToTypes="file" min="1" restrictToSources="SRSC">
	<div class="row">
		<div class="col"><h2 class="d-inline">Related Files</h2> <?php print caNavLink($this->request, 'Browse All', 'btn btn-light ms-3 mt-n3', '', 'Browse', 'files', array('facet' => 'entity_facet', 'id' => $t_item->get("ca_entities.entity_id"), 'view' => 'images')); ?></div>
	</div>
	<div class="row">
		<div class="col"><hr></div>
	</div>
	<div class="row" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Browse', 'files', array('facet' => 'entity_facet', 'id' => $t_item->get("ca_entities.entity_id"), 'view' => 'images', 'sort' => 'Identifier')); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
	</div>
</ifcount>}}}