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
			{{{<ifdef code="ca_objects.nomenclature"><div class='fs-5'>
<?php
			if($nomenclature = caGetBrowseLinks($t_object, 'ca_objects.nomenclature', ['template' => '<l>^ca_objects.nomenclature</l>', 'linkTemplate' => '^LINK'])) {
				print join("; ", $nomenclature);
			}
?>
			<?php print caNavLink($this->request, '<i class="bi bi-info-circle ms-1 small"></i>', "", "", "", "DataPolicyCopyright"); ?></div></ifdef>}}}
			{{{<ifdef code='ca_objects.spec_common_name'><div class='fs-5'><unit relativeTo='ca_objects.spec_common_name' delimiter='; '>^ca_objects.spec_common_name</unit></div></ifdef>}}}
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
		<div class="mb-4 col-md-6">
			{{{media_viewer}}}
		</div>
		<div class="mb-4 col-md-6">
			<div class="bg-light py-3 px-4 mb-3 h-100"><!-- height is to make the gray background of box same height as the containing row -->
				{{{<dl class="mb-0">
<?php
					if($t_object->get("source_id")){
						$vs_source_as_link = getSourceAsLink($this->request, $t_object->get("source_id"), null);
?>
						<dt><?= _t('From The Collection Of'); ?></dt>
						<dd><?php print $vs_source_as_link; ?></dd>
<?php
					}		
?>
					<ifdef code="ca_objects.accession_num">
						<dt><?= _t('Accession Number'); ?></dt>
						<dd>^ca_objects.accession_num</dd>
					</ifdef>
<?php
# --- Not sure if supposed to add specimen taxonomy to classification: Ctgy > Class > Subclass > Primary > Secondary > Tertiary
?>
					<ifdef code="ca_objects.discipline">
						<dt><?= _t('Discipline').caNavLink($this->request, '<i class="bi bi-info-circle ms-1 small"></i>', "", "", "", "DataPolicyCopyright"); ?></dt>
<?php
							if($discipline = caGetBrowseLinks($t_object, 'ca_objects.discipline', ['template' => '<dd><l>^ca_objects.discipline</l></dd>', 'linkTemplate' => '^LINK'])) {
								print join("", $discipline);
							}
?>						
					</ifdef>
					<ifdef code="ca_objects.classification|ca_objects.kingdom|ca_objects.phylum|ca_objects.class|ca_objects.order|ca_objects.family|ca_objects.genus|ca_objects.species">
						<dt><?= _t('Classification'); ?></dt>
						<ifdef code="ca_objects.classification"><unit relativeTo="ca_objects.classification" delimiter=""><dd>^ca_objects.classification</dd></unit></ifdef>
						<ifdef code="ca_objects.kingdom|ca_objects.phylum|ca_objects.class|ca_objects.order|ca_objects.family|ca_objects.genus|ca_objects.species">
							<dd><ifdef code="ca_objects.kingdom"><?= ($t_object->get("ca_objects.kingdom")) ? join("", caGetBrowseLinks($t_object, 'ca_objects.kingdom', ['template' => '<l>^ca_objects.kingdom</l>', 'linkTemplate' => '^LINK'])) : ""; ?></ifdef><ifdef code="ca_objects.phylum"> > <?= ($t_object->get("ca_objects.phylum")) ? join("", caGetBrowseLinks($t_object, 'ca_objects.phylum', ['template' => '<l>^ca_objects.phylum</l>', 'linkTemplate' => '^LINK'])) : ""; ?></ifdef><ifdef code="ca_objects.class"> > <?= ($t_object->get("ca_objects.order")) ? join("", caGetBrowseLinks($t_object, 'ca_objects.order', ['template' => '<l>^ca_objects.order</l>', 'linkTemplate' => '^LINK'])) : ""; ?></ifdef><ifdef code="ca_objects.family"> > <?= ($t_object->get("ca_objects.family")) ? join("", caGetBrowseLinks($t_object, 'ca_objects.family', ['template' => '<l>^ca_objects.family</l>', 'linkTemplate' => '^LINK'])) : ""; ?></ifdef><ifdef code="ca_objects.genus"> > <?= ($t_object->get("ca_objects.genus")) ? join("", caGetBrowseLinks($t_object, 'ca_objects.genus', ['template' => '<l>^ca_objects.genus</l>', 'linkTemplate' => '^LINK'])) : ""; ?></ifdef><ifdef code="ca_objects.species"> > <?= ($t_object->get("ca_objects.species")) ? join("", caGetBrowseLinks($t_object, 'ca_objects.species', ['template' => '<l>^ca_objects.species</l>', 'linkTemplate' => '^LINK'])) : ""; ?></ifdef></dd>
						</ifdef>
					</ifdef>
					<ifdef code="ca_objects.creator|ca_objects.manufacturer">
						<dt><?= _t('Artist / Manufacturer'); ?></dt>
						<ifdef code="ca_objects.creator">
<?php
							if($creator = caGetBrowseLinks($t_object, 'ca_objects.creator', ['template' => '<dd><l>^ca_objects.creator</l> (artist/maker)</dd>', 'linkTemplate' => '^LINK'])) {
								print join("", $creator);
							}
?>
						</ifdef>
						<ifdef code="ca_objects.manufacturer"><unit relativeTo="ca_objects.manufacturer" delimiter=""><dd>^ca_objects.manufacturer (manufacturer)</dd></unit></ifdef>
					</ifdef>
					<ifdef code="ca_objects.culture">
						<dt><?= _t('Culture').caNavLink($this->request, '<i class="bi bi-info-circle ms-1 small"></i>', "", "", "", "DataPolicyCopyright"); ?></dt>
<?php
							if($culture = caGetBrowseLinks($t_object, 'ca_objects.culture', ['template' => '<dd><l>^ca_objects.culture</l></dd>', 'linkTemplate' => '^LINK'])) {
								print join("", $culture);
							}
?>					</ifdef>
					<ifdef code="ca_objects.date_created|ca_objects.period|ca_objects.date_collected">
						<dt><ifdef code="ca_objects.date_created|ca_objects.date_collected|ca_objects.period"><?= _t('Date'); ?></if><ifdef code="ca_objects.date_created,ca_objects.period"> / </if><ifdef code="ca_objects.date_created"><?= _t('Period'); ?></if></dt>
						<ifdef code="ca_objects.date_created"><dd>^ca_objects.date_created (creation date)</dd></ifdef>
						<ifdef code="ca_objects.date_collected"><dd>^ca_objects.date_collected (collection date)</dd></ifdef>
						<ifdef code="ca_objects.period"><dd>^ca_objects.period (period)</dd></ifdef>
					</ifdef>
					<ifdef code="ca_objects.obj_material|ca_objects.obj_medium|ca_objects.obj_support|ca_objects.technique">
						<dt>Materials and Techniques</dt>
						<ifdef code="ca_objects.obj_material"><unit relativeTo="ca_objects.obj_material" delimiter=""><dd>^ca_objects.obj_material (material)</dd></unit></ifdef>
						<ifdef code="ca_objects.obj_medium"><unit relativeTo="ca_objects.obj_medium" delimiter=""><dd>^ca_objects.obj_medium (medium)</dd></unit></ifdef>
						<ifdef code="ca_objects.obj_support"><unit relativeTo="ca_objects.obj_support" delimiter=""><dd>^ca_objects.obj_support (support)</dd></unit></ifdef>
						<ifdef code="ca_objects.technique"><unit relativeTo="ca_objects.technique" delimiter=""><dd>^ca_objects.technique (technique)</dd></unit></ifdef>
					</ifdef>
					<ifdef code="ca_objects.specimen_type">
						<dt><?= _t('Type Status'); ?></dt>
						<unit relativeTo="ca_objects.specimen_type" delimiter=""><dd>^ca_objects.specimen_type</dd></unit>
					</ifdef>
					<ifdef code="ca_objects.origin_loc|ca_objects.use_location|ca_objects.collection_loc|ca_objects.loc_remark">
						<dt><?= _t("Place").caNavLink($this->request, '<i class="bi bi-info-circle ms-1 small"></i>', "", "", "", "DataPolicyCopyright"); ?></dt>
						<ifdef code="ca_objects.origin_loc">
<?php
							if($origin_loc = caGetBrowseLinks($t_object, 'ca_objects.origin_loc', ['template' => '<dd><l>^ca_objects.origin_loc</l> (creation)</dd>', 'linkTemplate' => '^LINK'])) {
								print join("", $origin_loc);
							}
?>
						</ifdef>
						<ifdef code="ca_objects.use_location"><unit relativeTo="ca_objects.use_location" delimiter=""><dd>^ca_objects.use_location (use)</dd></unit></ifdef>
						<ifdef code="ca_objects.collection_loc">
<?php
							if($collection_loc = caGetBrowseLinks($t_object, 'ca_objects.collection_loc', ['template' => '<dd><l>^ca_objects.collection_loc</l> (collection place)</dd>', 'linkTemplate' => '^LINK'])) {
								print join("", $collection_loc);
							}
?>
						</ifdef>
						<ifdef code="ca_objects.loc_remark"><unit relativeTo="ca_objects.loc_remark" delimiter=""><dd>^ca_objects.loc_remark (collection place remarks)</dd></unit></ifdef>
					</ifdef>
					<ifdef code="ca_objects.collector|ca_objects.identifier_name">
						<dt>Related People</dt>
						<ifdef code="ca_objects.collector"><unit relativeTo="ca_objects.collector" delimiter=""><dd>^ca_objects.collector (collector)</dd></unit></ifdef>
						<ifdef code="ca_objects.identifier_name">
<?php
							if($identifier_name = caGetBrowseLinks($t_object, 'ca_objects.identifier_name', ['template' => '<dd><l>^ca_objects.identifier_name</l> (identifier)</dd>', 'linkTemplate' => '^LINK'])) {
								print join("", $identifier_name);
							}
?>
						</ifdef>
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
						<ifdef code="ca_objects.brand_name"><unit relativeTo="ca_objects.brand_name" delimiter=""><dd>^ca_objects.brand_name (brand)</dd></unit></ifdef>
						<ifdef code="ca_objects.model"><unit relativeTo="ca_objects.model" delimiter=""><dd>^ca_objects.model (model)</dd></unit></ifdef>
					</ifdef>
					<ifdef code="ca_objects.military_rank_unit">
						<dt><?= _t('Related Military Unit'); ?></dt>
						<unit relativeTo="ca_objects.military_rank_unit" delimiter=""><dd>^ca_objects.military_rank_unit</dd></unit>
					</ifdef>
					<ifdef code="ca_objects.description">
						<dt><?= _t('Description'); ?></dt>
						<unit relativeTo="ca_objects.description" delimiter=""><dd>^ca_objects.description</dd></unit>
					</ifdef>
					<ifdef code="ca_objects.history_of_use">
						<dt><?= _t('History of Use'); ?></dt>
						<unit relativeTo="ca_objects.history_of_use" delimiter=""><dd>^ca_objects.history_of_use</dd></unit>
					</ifdef>
					<ifdef code="ca_objects.narrative">
						<dt><?= _t('Narrative'); ?></dt>
						<unit relativeTo="ca_objects.narrative" delimiter=""><dd>^ca_objects.narrative</dd></unit>
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
<?php
						if($va_tmp = $t_object->get("ca_objects.wikipedia_en", array("returnAsArray" => true))){
							foreach($va_tmp as $tmp){
								preg_match_all("/\\[(.*?)\\]/", $tmp, $matches);
								$url = $matches[1][0];
								print "<dd><a href='".$url."' target='_blank'>".$tmp."</a></dd>";
							}
						}
						if($va_tmp = $t_object->get("ca_objects.wikipedia_fr", array("returnAsArray" => true))){
							foreach($va_tmp as $tmp){
								preg_match_all("/\\[(.*?)\\]/", $tmp, $matches);
								$url = $matches[1][0];
								print "<dd><a href='".$url."' target='_blank'>".$tmp."</a></dd>";
							}
						}
?>
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
				<div><?php print ($t_object->get("ca_objects.origin_loc_geo")) ? "<div class='fw-bold pb-2'>"._t("Creation Place")."</div>" : ""; ?><?php print ($t_object->get("ca_objects.collection_loc")) ? "<div class='fw-bold pb-2'>"._t("Collection Location")."</div>" : ""; ?><div id="map" class="map">{{{map}}}</div></div>

			</div>
			
		</div>