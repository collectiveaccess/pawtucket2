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
		$results_link = $previous_link = $next_link;
		if($this->getVar("nextID")){
			$next_link = "<a href='".$this->getVar("nextURL")."' class='pe-0 ".$options["detailNavLinkClass"]."'>".$options["nextLink"]."</a>";
		}
		if($this->getVar("previousID")){
			$previous_link = "<a href='".$this->getVar("previousURL")."' class='pe-0 ".$options["detailNavLinkClass"]."'>".$options["previousLink"]."</a>";
		}
		if($this->getVar("resultsURL")){
			$results_link = "<a href='".$this->getVar("resultsURL")."' class='".(($previous_link || $next_link) ? "pe-4 " : "").$options["detailNavLinkClass"]."'>".$options["resultsLink"]."</a>";
		}
		
	?>
		<div class="row mt-n4">
			<div class="col text-center text-md-end">
				<nav aria-label="result"><?= $results_link.$previous_link.$next_link; ?></nav>
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
			{{{<H1 class="pb-4 mb-0">^ca_places.preferred_labels<ifdef code="ca_places.common_date">, ^ca_places.common_date</ifdef></H1>}}}
			{{{<ifdef code="ca_places.description"><div class="pb-4">^ca_places.description</div></ifdef>}}}
		</div>
	</div>
{{{<ifcount code="ca_objects" min="1" restrictToRelationshipTypes="references">
	<if rule="^ca_objects.classification =~ /painting/i">
	<div class="row">
		<div class="col"><h2>Artworks</h2></div>
	</div>
	<div class="row" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Browse', 'artworks', array('facet' => 'creation_place_facet', 'id' => $t_item->get("ca_places.place_id"))); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
	</div>
	</if>
</ifcount>}}}