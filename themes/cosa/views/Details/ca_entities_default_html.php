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
?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
</script>
<div class="breadcrumb"><div class='container-xl'><div class="py-2 fs-6">
<?php
	if($resultURL = $this->getVar("resultsURL")){
		print "<a href='".$resultURL."' class='me-4'><i class='bi bi-chevron-left small'></i>Back</a>";
	}
	print caNavLink($this->request, _t("Art Collection"), '', '', '', '', '');
	print " / ".$t_item->get("ca_entities.preferred_labels.displayname");					
?>
</div></div></div>	
<div class='container-xl pt-4'><?php # --- this container is usually out put in header, but here so the breadcrumb trail can be output
?>
<?php
	if($show_nav){
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
		<div class="col-md-6 text-center text-md-end">
			<nav aria-label="result">{{{previousLink}}}{{{nextLink}}}</nav>
		</div>
	</div>
<?php
	}
?>
	<div class="row">
		<div class="col-md-12">
			<H1 class="fs-2">{{{^ca_entities.preferred_labels.displayname}}}</H1>
			{{{<ifdef code="ca_entities.artist_registry"><div class="mb-3"><a href="^ca_entities.artist_registry" target="_blank">Artist Registry Profile <i class='bi bi-box-arrow-up-right ms-1'></i></a></ifdef></div>}}}
			{{{<ifnotdef code="ca_entities.artist_registry"><div class="mb-3"><a href="https://events.getcreativesanantonio.com/artist/" target="_blank">Artist Registry <i class='bi bi-box-arrow-up-right ms-1'></i></a></div>}}}
<?php
			if($exhibitions = $t_item->getWithTemplate('<unit relativeTo="ca_objects" restrictToRelationshipTypes="artist" delimiter=";"><ifcount code="ca_occurrences" restrictToTypes="exhibition" min="1"><unit relativeTo="ca_occurrences" restrictToTypes="exhibition" delimiter=";"><l>^ca_occurrences.preferred_labels</l></unit></ifcount></unit>')){
				$va_exhibitions = array_unique(explode(";", $exhibitions));
				if(is_array($va_exhibitions) && sizeof($va_exhibitions)){
					print "<dl><dt>Related Exhibition".((sizeof($va_exhibitions) > 1) ? "s":"")."</dt>";
					foreach($va_exhibitions as $exhibition_link){
						print "<dd>".$exhibition_link."</dd>";
					}
					print "</dl>";
				}
			}
?>
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
?>
{{{
	<ifcount code="ca_objects" min="1">
		<div class="row">
			<div class="col"><h2 class="fs-4">Related Artworks</h2><hr></div>
		</div>
		<div class="row" id="browseResultsContainer">	
			<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', 'all_artworks', array('search' => 'ca_entities.entity_id:'.$t_item->get("ca_entities.entity_id"), '_advanced' => 0)); ?>">
				<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
			</div>
		</div>
	</ifcount>}}}