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
?>
	<div class="row">
		<div class="col-md-12">
			<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
			{{{<ifdef code="ca_objects.type_id"><div class="fw-medium mb-3"><ifdef code="ca_objects.type_id">^ca_objects.type_id</ifdef></div></ifdef>}}}
			<hr class="mb-0">
		</div>
	</div>
<?php
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
		<div class="col-md-<?php print ($t_object->get("source_id") || $this->getVar("map")) ? "5" : "6"; ?>">
			{{{media_viewer}}}
		</div>
		<div class="col-md-<?php print ($t_object->get("source_id") || $this->getVar("map")) ? "4" : "6"; ?>">
			<div class="bg-light py-3 px-4 mb-3 h-100"><!-- height is to make the gray background of box same height as the containing row -->
				{{{<dl class="mb-0">
					<ifdef code="ca_objects.idno">
						<dt><?= _t('Accession Number'); ?></dt>
						<dd>^ca_objects.idno</dd>
					</ifdef>
<?php
# --- TODO: add specimen taxonomy to classification: Ctgy > Class > Subclass > Primary > Secondary > Tertiary
?>
					<ifdef code="ca_objects.classification">
						<dt><?= _t('Classification'); ?></dt>
						<unit relativeTo="ca_objects.classification" delimiter=""><dd>^ca_objects.classification</dd></unit>
					</ifdef>
					<ifdef code="ca_objects.creator|ca_objects.manufacturer">
						<dt><?= _t('Creator / Manufacturer'); ?></dt>
						<ifdef code="ca_objects.creator"><unit relativeTo="ca_objects.creator" delimiter=""><dd>^ca_objects.creator</dd></unit></ifdef>
						<ifdef code="ca_objects.manufacturer"><unit relativeTo="ca_objects.manufacturer" delimiter=""><dd>^ca_objects.manufacturer</dd></unit></ifdef>
					</ifdef>
					<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="creator">
						<dt><ifcount code="ca_entities" min="1" max="1" restrictToRelationshipTypes="creator"><?= _t('Artist / Manufacturer'); ?></ifcount><ifcount code="ca_entities" min="2" restrictToRelationshipTypes="creator"><?= _t('Artists / Manufacturers'); ?></ifcount></dt>
						<unit relativeTo="ca_entities" delimiter="" restrictToRelationshipTypes="creator"><dd><l>^ca_entities.preferred_labels.displayname</l></dd></unit>
					</ifcount>
					<ifdef code="ca_objects.culture">
						<dt><?= _t('Culture'); ?></dt>
						<unit relativeTo="ca_objects.culture" delimiter=""><dd>^ca_objects.culture</dd></unit>
					</ifdef>
					<ifdef code="ca_objects.date_created|ca_objects.period">
						<dt><ifdef code="ca_objects.date_created"><?= _t('Date'); ?></if><ifdef code="ca_objects.date_created,ca_objects.period"> / </if><ifdef code="ca_objects.date_created"><?= _t('Period'); ?></if></dt>
						<ifdef code="ca_objects.date_created"><dd>^ca_objects.date_created</dd></ifdef>
						<ifdef code="ca_objects.period"><dd>^ca_objects.period</dd></ifdef>
					</ifdef>
					<ifdef code="ca_objects.obj_material|ca_objects.obj_medium|ca_objects.obj_support|ca_objects.technique">
						<dt>Materials and Techniques</dt>
						<ifdef code="ca_objects.obj_material"><unit relativeTo="ca_objects.obj_material" delimiter=""><dd>^ca_objects.obj_material</dd></unit></ifdef>
						<ifdef code="ca_objects.obj_medium"><unit relativeTo="ca_objects.obj_medium" delimiter=""><dd>^ca_objects.obj_medium</dd></unit></ifdef>
						<ifdef code="ca_objects.obj_support"><unit relativeTo="ca_objects.obj_support" delimiter=""><dd>^ca_objects.obj_support</dd></unit></ifdef>
						<ifdef code="ca_objects.technique"><unit relativeTo="ca_objects.technique" delimiter=""><dd>^ca_objects.technique</dd></unit></ifdef>
					</ifdef>
					<ifdef code="ca_objects.origin_loc|ca_objects.use_location">
						<dt>Place</dt>
						<ifdef code="ca_objects.origin_loc"><unit relativeTo="ca_objects.origin_loc" delimiter=""><dd>^ca_objects.origin_loc</dd></unit></ifdef>
						<ifdef code="ca_objects.use_location"><unit relativeTo="ca_objects.use_location" delimiter=""><dd>^ca_objects.use_location</dd></unit></ifdef>
					</ifdef>
					<ifdef code="ca_objects.style">
						<dt><?= _t('School / Style'); ?></dt>
						<unit relativeTo="ca_objects.style" delimiter=""><dd>^ca_objects.style</dd></unit>
					</ifdef>
					<ifdef code="ca_objects.subject">
						<dt><?= _t('Image Subject'); ?></dt>
						<unit relativeTo="ca_objects.subject" delimiter=""><dd>^ca_objects.subject</dd></unit>
					</ifdef>
					<ifdef code="ca_objects.brand_name|ca_objects.model">
						<dt><?= _t('Brand / Model'); ?></dt>
						<ifdef code="ca_objects.brand_name"><unit relativeTo="ca_objects.brand_name" delimiter=""><dd>^ca_objects.brand_name</dd></unit></ifdef>
						<ifdef code="ca_objects.model"><unit relativeTo="ca_objects.model" delimiter=""><dd>^ca_objects.model</dd></unit></ifdef>
					</ifdef>
					<ifdef code="ca_objects.military_rank_unit">
						<dt><?= _t('Related Military Unit'); ?></dt>
						<unit relativeTo="ca_objects.military_rank_unit" delimiter=""><dd>^ca_objects.military_rank_unit</dd></unit>
					</ifdef>
					<ifdef code="ca_objects.description">
						<dt><?= _t('Description'); ?></dt>
						<unit relativeTo="ca_objects.description" delimiter=""><dd>^ca_objects.description</dd></unit>
					</ifdef>
					<ifdef code="ca_objects.description">
						<dt><?= _t('Description'); ?></dt>
						<unit relativeTo="ca_objects.description" delimiter=""><dd>^ca_objects.description</dd></unit>
					</ifdef>
					<ifdef code="ca_objects.history_of_use">
						<dt><?= _t('History of Use'); ?></dt>
						<unit relativeTo="ca_objects.history_of_use" delimiter=""><dd>^ca_objects.history_of_use</dd></unit>
					</ifdef>
					<ifdef code="ca_objects.operating_principle">
						<dt><?= _t('Operating Principle'); ?></dt>
						<unit relativeTo="ca_objects.operating_principle" delimiter=""><dd>^ca_objects.operating_principle</dd></unit>
					</ifdef>
					<ifcount code="ca_objects.related" min="1">
						<dt><ifcount code="ca_objects.related" min="1" max="1"><?= _t('Related Record'); ?></ifcount><ifcount code="ca_objects.related" min="2"><?= _t('Related Records'); ?></ifcount></dt>
						<unit relativeTo="ca_objects.related" delimiter=""><dd><l>^ca_objects.preferred_labels.name, (^ca_objects.idno)</l></dd></unit>
					</ifcount>
					<ifdef code="ca_objects.wikipedia_en|ca_objects.wikipedia_fr|ca_objects.external_link.url_entry">
						<dt><?= _t('See Elsewhere'); ?></dt>
						<ifdef code="ca_objects.wikipedia_en"><unit relativeTo="ca_objects.wikipedia_en" delimiter=""><dd>^ca_objects.wikipedia_en</dd></ifdef>
						<ifdef code="ca_objects.wikipedia_fr"><unit relativeTo="ca_objects.wikipedia_fr" delimiter=""><dd>^ca_objects.wikipedia_fr</dd></ifdef>
						<ifdef code="ca_objects.external_link.url_entry"><unit relativeTo="ca_objects.external_link" delimiter=""><ifdef code="ca_objects.external_link.url_entry"><dd><a href="^ca_objects.external_link.url_entry" target="_blank"><ifdef code="ca_objects.external_link.url_source">^ca_objects.external_link.url_source</ifdef><ifnotdef code="ca_objects.external_link.url_source">^ca_objects.external_link.url_entry</ifnotdef></a></dd></ifdef></unit></ifdef>
					</ifdef>
					<ifdef code="ca_objects.modified_on">
						<dt><?= _t('Record Updated'); ?></dt>
						<unit relativeTo="ca_objects.modified_on" delimiter=""><dd>^ca_objects.modified_on</dd></unit>
					</ifdef>
					<ifdef code="ca_objects.rights_holder|ca_objects.license">
						<dt><?= _t('Record Rights'); ?></dt>
						<ifdef code="ca_objects.rights_holder"><unit relativeTo="ca_objects.rights_holder" delimiter=""><dd>^ca_objects.rights_holder</dd></unit></ifdef>
						<ifdef code="ca_objects.license"><unit relativeTo="ca_objects.license" delimiter=""><dd>^ca_objects.license</dd></unit></ifdef>
					</ifdef>
					<?php #print $this->render("Details/snippets/related_entities_by_rel_type_html.php"); ?>

				</dl>}}}
			</div>
			
		</div>
<?php
	if($t_object->get("source_id") || $this->getVar("map")){
?>
		<div class="col-md-3">
<?php
					if($t_object->get("source_id")){
						$vs_source_as_link = getSourceAsLink($this->request, $t_object->get("source_id"), null);
?>
						<div class="bg-light py-3 px-4 mb-3">
							<div class="fw-bold pb-2">From The Collection Of</div>
							<div><?php print $vs_source_as_link; ?></div>
						</div>
<?php
					}		
?>
					<div><div id="map" class="map">{{{map}}}</div></div>
		</div>
<?php
	}
?>
	</div>
	{{{<ifcount code="ca_entities" min="1">
		<dl class="row">
			<dt class="col-12 mt-3 mb-2"><ifcount code="ca_entities" min="1" max="1"><?= _t('Related Person / Organization'); ?></ifcount><ifcount code="ca_entities" min="2"><?= _t('Related People / Organizations'); ?></ifcount></dt>
			<unit relativeTo="ca_entities" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 px-3 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_entities.preferred_labels<br>^relationship_typename</l></dd></unit>		
		</dl>
	</ifcount>}}}
	{{{<ifcount code="ca_places" min="1">
		<dl class="row">
			<dt class="col-12 mt-3 mb-2"><ifcount code="ca_places" min="1" max="1"><?= _t('Related Place'); ?></ifcount><ifcount code="ca_places" min="2"><?= _t('Related Places'); ?></ifcount></dt>
			<unit relativeTo="ca_places" delimiter=""><dd class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 text-center"><l class="pt-3 pb-4 px-3 d-flex align-items-center justify-content-center bg-body-tertiary h-100 w-100 text-black">^ca_places.preferred_labels<br>^relationship_typename</l></dd></unit>
		</dl>
	</ifcount>}}}
