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
			<H1>{{{^ca_objects.public_title}}}</H1>
			<hr class="mb-0">
		</div>
	</div>
<?php
	if(caDisplayLightbox($this->request) || $pdf_enabled){
?>
	<div class="row">
		<div class="col text-center text-md-end">
			<div class="btn-group" role="group" aria-label="Detail Controls">
<?php
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_objects", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'));
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
		<div class="col-md-6 py-3">
			{{{<ifdef code="ca_objects.ts_storyid"><iframe width="100%" height="720" src="https://share.theirstory.io/story/^ca_objects.ts_storyid" title="Karen Sandler interview with FOSSDA" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe></ifdef>}}}
		</div>
		<div class="col-md-6 pt-3">
			<div class="bg-light py-3 px-4 mb-3 h-100"><!-- height is to make the gray background of box same height as the containing row -->			
				{{{<dl class="mb-0">
					<ifdef code="ca_objects.public_description">
						<dt>Description</dt>
						<dd>
<?php
						if(mb_strlen($t_object->get("ca_objects.public_description")) > 800){
?>
							<div id="readMoreDiv_public_description" class="readMore readMoreOralHistory">^ca_objects.public_description</div>
							<button id="readMoreBtn" class="btn btn-white btn-sm mt-2 readMoreButton" hx-on:click="htmx.toggleClass(htmx.find('#readMoreDiv_public_description'), 'readMoreExpanded'); htmx.toggleClass(htmx.find('#readMoreBtn'), 'readMoreButtonExpanded');" aria-label="Read More / Less"></button>		
<?php
						}else{
?>
							^ca_objects.public_description		
<?php						
						}
?>
						</dd>
					</ifdef>
				</dl>}}}


			</div>
		</div>

	</div>
	<div class="row">
		<div class="col-md-6 offset-md-6 text-center">
			<div class="pt-4">
				{{{<ifdef code="ca_objects.curators_comment"><span id="curatorCommentsButton" class="curatorCommentsShowHide collapse show"><button class="btn btn-primary me-4 mb-2" type="button" data-bs-toggle="collapse" data-bs-target=".curatorCommentsShowHide" aria-expanded="false" aria-controls="curatorComments curatorCommentsButton"><i class='bi bi-justify'></i> Curator's Comment</button></span></ifdef>}}}
<?php
				if($inquire_enabled) {
					print caNavLink($this->request, "<i class='bi bi-chat-left'></i> "._t("Feedback"), "btn btn-primary me-4 mb-2", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_objects", "id" => $id));
				}
				if($copy_link_enabled){
					print $this->render('Details/snippets/copy_link_html.php');
				}
?>
			</div>
		</div>
	</div>
{{{<ifdef code="ca_objects.curators_comment">
	<div id="curatorComments" class="row curatorCommentsShowHide collapse pt-3">
		<div class="fw-bold">Curator's Comment</div>
		<div class="pt-2">
			^ca_objects.curators_comment
			<div class="pt-2"><button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target=".curatorCommentsShowHide" aria-expanded="false" aria-controls="curatorCommentsLabel curatorComments curatorCommentsButton">Hide</button></div>
		</div>
	</div>
</ifdef>}}}
	<div class="row mb-5">
		<div class="col-md-6 mt-4">
			<div class="bg-light py-3 px-4 mb-3">
				<ul class="list-group small">
					{{{<ifdef code="ca_objects.idno"><li class='list-group-item p-0 border-0 bg-transparent'><span class="fw-bold">Accession Number: </span>^ca_objects.idno</li></ifdef>}}}
<?php
					$va_dimensions_fields = array("dimensions_height", "dimensions_width", "dimensions_depth", "Dimensions_Length", "Dimensions_Diameter");
					$va_dimensions_informations = array_pop($t_object->get("ca_objects.dimensions", array("returnWithStructure" => true)));
					if(is_array($va_dimensions_informations) && sizeof($va_dimensions_informations)){
						$va_dimensions_formatted = array();
						$va_dimensions_metric_formatted = array();
						foreach($va_dimensions_informations as $va_dimensions_information){
							$va_dimensions_pieces = array();
							$va_dimensions_pieces_metric = array();
							foreach($va_dimensions_fields as $vs_field){
								if(trim($va_dimensions_information[$vs_field])){
									$va_dimensions_pieces[] = trim($va_dimensions_information[$vs_field]);
									$vn_dimension = trim(str_replace("in", "", $va_dimensions_information[$vs_field]));
									$va_dimensions_pieces_metric[] = ($vn_dimension * 2.54)." cm";
								}
							}
							if(sizeof($va_dimensions_pieces)){
								$va_dimensions_formatted[] = ($va_dimensions_information["dimension_text"] ? trim($va_dimensions_information["dimension_text"]).": " : "").join(" X ", $va_dimensions_pieces);
								$va_dimensions_metric_formatted[] = ($va_dimensions_information["dimension_text"] ? trim($va_dimensions_information["dimension_text"]).": " : "").join(" X ", $va_dimensions_pieces_metric);
							}
							# --- break to only show first dimension
							break;
						}
					}				
				
					if(sizeof($va_dimensions_formatted)){
						print "<li class='list-group-item p-0 border-0 bg-transparent'><span class='fw-bold'>Dimensions: </span>".join("; ", $va_dimensions_formatted)."</li>";
						if(sizeof($va_dimensions_metric_formatted)){
							print "<li class='list-group-item p-0 border-0 bg-transparent'><span class='fw-bold'>Dimensions (Metric): </span>".join("; ", $va_dimensions_metric_formatted)."</li>";
						}
					}		
				$vn_source_id = null;
				if($t_object->get("ca_objects.credit_line")){
					$vs_credit_line = $t_object->get("ca_objects.credit_line");
				}else{
					$vs_credit_line = $t_object->get("ca_object_lots.credit_line");
				}
				if(strpos(strtolower($vs_credit_line), "anonymous") === false){
					if($va_sources = $t_object->get("ca_entities", array("returnWithStructure" => true, "restrictToRelationshipTypes" => array("donor"), "checkAccess" => caGetUserAccessValues($this->request)))){
						if(is_array($va_sources) && sizeof($va_sources)){
							print "<li class='list-group-item p-0 border-0 bg-transparent'><span class='fw-bold'>Source".((sizeof($va_sources) > 1) ? "s" : "").":</span> ";
							$va_source_display = array();
							foreach($va_sources as $va_source){
								$va_source_display[] = caNavLink($this->request, $va_source["displayname"], "", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $va_source["entity_id"]));
							}
							print implode(", ", $va_source_display)."</li>";
							$vn_source_id = $va_source["entity_id"];
						}

					}
				}else{
					$vb_anon_donor = true;
				}
				if($vs_credit_line){
					print "<li class='list-group-item p-0 border-0 bg-transparent'><span class='fw-bold'>Credit Line: </span><i>".$vs_credit_line."</i></li>";
				}		
?>
				</ul>
			</div>
		</div>
		<div class="col-md-6 mt-4">
<?php
			$va_list_ids = array();
			if($va_subjects = $t_object->get("ca_list_items", array("returnWithStructure" => true, "restrictToLists" => array("voc_6"), "checkAccess" => caGetUserAccessValues($this->request)))){
				if(is_array($va_subjects) && sizeof($va_subjects)){
					# --- loop through to order alphebeticaly
					$va_subjects_sorted = array();
					$t_list_item = new ca_list_items();
					foreach($va_subjects as $va_subject){
						$t_list_item->load($va_subject["item_id"]);
						$va_popover = array();
						if($t_list_item->get("ca_list_item_labels.description")){
							#$va_popover = array("data-container" => "body", "data-toggle" => "popover", "data-placement" => "auto", "data-html" => "true", "data-title" => $va_subject["name_singular"], "data-content" => $t_list_item->get("ca_list_item_labels.description"),  "data-trigger" => "hover");
							$va_popover = array("data-container" => "body", "data-bs-toggle" => "tooltip", "data-bs-placement" => "top", "data-bs-html" => "true", "title" => $t_list_item->get("ca_list_item_labels.description"));							
						}
						$va_subjects_sorted[$va_subject["name_singular"]] = caNavLink($this->request, $va_subject["name_singular"], "btn btn-small btn-light me-2 mb-2", "", "Browse", "objects", array("facet" => "term_facet", "id" => $va_subject["item_id"]), $va_popover);
						$va_list_ids[] = $va_subject["item_id"];
					}
					ksort($va_subjects_sorted);
					print "<div class='pb-3'><div class='fw-bold mb-2'>Keyword".((sizeof($va_subjects) > 1) ? "s" : "")." ".caNavLink($this->request, "<i class='bi bi-info-circle'></i>", "", "", "About", "keywords", null, array("data-container" => "body", "data-toggle" => "popover", "data-placement" => "auto", "data-html" => "true", "data-content" => _t("Click for keyword definitions"),  "data-trigger" => "hover"))."</div>";
					print join("", $va_subjects_sorted);
					print "</div>";
				}
			}
?>								
			<div><div class='fw-bold mb-2'>This item is protected by copyright and/or related rights. <a data-bs-toggle="collapse" href="#rightsStatement" role="button" aria-expanded="false" aria-controls="rightsStatement"><i class='bi bi-info-circle'></i></a></div>
				<div id="rightsStatement" class="collapse">{{{detail_rights_statement}}}</div>
			</div>
		</div>
	</div>
<?php
	# --- Related Items
	# --- items from same donor (source set above) - if not anonymous
	# --- then related objects on backend
	# --- then same title

# --- build the search terms
$va_search = array();
if($vn_source_id){
	$va_search[] = "entity_id:".$vn_source_id;
}
# --- do the search and see if there are decent results....otherwise broaden it
$vn_hits = 0;
$va_related_ids = array();
if($vn_source_id){
	$vs_search_term = "entity_id:".$vn_source_id;
	$t_entity = new ca_entities($vn_source_id);
	$donor_related_ids = $t_entity->get("ca_objects.related.object_id", array("returnAsArray" => true, "checkAccess" => caGetUserAccessValues($this->request), "restrictToRelationshipTypes" => array("donor")));
	if(is_array($donor_related_ids) && sizeof($donor_related_ids)){
		# --- delete current item from array
		if (($key = array_search($id, $donor_related_ids)) !== false) {
			unset($donor_related_ids[$key]);
		}
		shuffle($donor_related_ids);
		$va_related_ids = array_slice($donor_related_ids, 0, 6);
	}
}
$vb_search_again = false;

if(sizeof($va_related_ids) < 6){
	$vb_search_again = true;
}
# add more search terms for broadening and more link
$va_related_objects = $t_object->get("ca_objects.related.object_id", array("returnAsArray" => true, "checkAccess" => caGetUserAccessValues($this->request)));
if(is_array($va_related_objects) && sizeof($va_related_objects)){
	if(is_array($va_related_ids) && sizeof($va_related_ids)){
		$va_related_ids = array_unique(array_merge($va_related_ids, $va_related_objects));
	}else{
		$va_related_ids = $va_related_objects;
	}
}

# --- not sure how to add related objects to the more link


if(sizeof($va_related_ids) < 6){
	$vb_search_again = true;
}
# add more search terms for broadening and more link
$va_search3 = array();
if($t_object->get("ca_objects.preferred_labels.name")){
	$va_search3[] = "ca_objects.preferred_labels.name:'".$t_object->get("ca_objects.preferred_labels.name")."'";
}
if($vb_search_again){
	$vs_search_term = join(" OR ", $va_search3);
	$o_search = caGetSearchInstance("ca_objects");
	$qr_res = $o_search->search($vs_search_term, array("checkAccess" => caGetUserAccessValues($this->request), "sort" => "_rand"));
	$va_related_more = array();
	if($qr_res->numHits()){
		while($qr_res->nextHit()){
			if($qr_res->get("ca_objects.object_id") != $t_object->get("object_id")){
				$va_related_more[] = $qr_res->get("ca_objects.object_id");
			}
		}
		shuffle($va_related_more);
		if(is_array($va_related_ids) && sizeof($va_related_ids)){
			$va_related_ids = array_unique(array_merge($va_related_ids, $va_related_more));
		}else{
			$va_related_ids = $va_related_more;
		}
	}
}

if(sizeof($va_related_ids)){
	$browse_target = "objects";
	switch(strToLower($t_object->get("ca_objects.type_id", array("convertCodesToDisplayText" => true)))){
		case "lmdc boards":
			$browse_target = "boards";
		break;
		# -----------------------
		case "oral history":
			$browse_target = "oral_histories";
		break;
		# -----------------------
		default:
			$browse_target = "objects";
		break;
		# -----------------------
	}
	$vb_show_more_link = false;
	if(sizeof($va_related_ids) > 6){
		$vb_show_more_link = true;
	}
	$i = 0;
	$tmp = "";
	$va_tmp = array();
	foreach($va_related_ids as $rel_object_id){
		$tmp = "ca_objects.object_id:".$rel_object_id;
		$va_tmp[] = $tmp;
		$i++;
		if($i == 6){
			break;
		}
	}
	$search_term = join(" OR ", $va_tmp);
	#$qr_res = caMakeSearchResult("ca_objects", $va_related_ids);
?>
	<div class="row">
		<div class='col-6'>
			<H2>Related Item<?php print (sizeof($va_related_ids) > 2) ? "s" : ""; ?></H2>
		</div><!-- end col -->
		<div class='col-6 text-end'>
		<?php
		if($vb_show_more_link){
			$vs_search_term = join(" OR ", array_merge($va_search, $va_search3));
			#print caNavLink($this->request, _t("More"), "btn btn-primary", "", "Search", $browse_target, array("search" => $vs_search_term));
		}
?>
		</div>
	</div>

	<div class="row" id="browseResultsContainer">	
		<div hx-trigger='load' hx-swap='outerHTML' hx-get="<?php print caNavUrl($this->request, '', 'Search', $browse_target, array('search' => $search_term, '_advanced' => 0)); ?>">
			<div class="spinner-border htmx-indicator m-3" role="status" class="text-center"><span class="visually-hidden">Loading...</span></div>
		</div>
	</div>
<?php
}
?>
<script>
	htmx.onLoad(function(e) {
		var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
		var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		  return new bootstrap.Tooltip(tooltipTriggerEl)
		});
	});
</script>