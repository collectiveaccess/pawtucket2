<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
				<H2>{{{<unit>^ca_objects.type_id</unit>}}}</H2>
				<HR>
			{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Identifier:</label>^ca_objects.idno</div></ifdef>}}}
			{{{<ifdef code="ca_objects.source_id"><div class="unit"><label>Collection:</label>^ca_objects.source_id</div></ifdef>}}}
			{{{<ifdef code="ca_objects.dimensions_as_text"><div class="unit"><label>Dimensions:</label>^ca_objects.dimensions_as_text%delimiter=<br/></div></ifdef>}}}
			{{{<ifdef code="ca_objects.dates.dates_value"><unit relativeTo="ca_objects.dates" delimiter=" "><div class="unit"><label>^ca_objects.dates_type:</label>^ca_objects.dates_value</div></unit></ifdef>}}}
<?php
			# --- entities
			$va_entities = $t_object->get("ca_entities", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values, 'sort' => array('surname',' forename')));
			if(sizeof($va_entities) > 0){	
				$va_entities_by_type = array();
				foreach($va_entities as $va_entity) {
					$va_entities_by_type[$va_entity['relationship_typename']][] = caNavLink($this->request, $va_entity["label"], '', '', 'Search', 'Index', array('search' => $va_entity["label"]));
				}
				ksort($va_entities_by_type);
				foreach($va_entities_by_type as $vs_type => $va_ent_links){
					print "<div class='unit'><label>".$vs_type.": </label>".join($va_ent_links, ", ")."</div><!-- end unit -->";
				}
			}
			# --- places
			$va_places = $t_object->get("ca_places", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_places) > 0){
				$va_places_by_type = array();
				foreach($va_places as $va_place_info){
					$va_places_by_type[$va_place_info['relationship_typename']][] = caNavLink($this->request, $va_place_info["label"], '', '', 'Search', 'Index', array('search' => $va_place_info["label"]));
				}
				ksort($va_places_by_type);
				foreach($va_places_by_type as $vs_type => $va_place_links){
					print "<div class='unit'><label>".$vs_type.": </label>".join($va_place_links, ", ")."</div><!-- end unit -->";
				}
			}
			# --- occurrences
			$va_occurrences = $t_object->get("ca_occurrences", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			$va_sorted_occurrences = array();
			if(sizeof($va_occurrences) > 0){
				$t_occ = new ca_occurrences();
				$va_item_types = $t_occ->getTypeList();
				foreach($va_occurrences as $va_occurrence) {
					$t_occ->load($va_occurrence['occurrence_id']);
					$va_sorted_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = $va_occurrence;
				}
				
				foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
?>
						<div class="unit"><h2><?php print _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></h2>
<?php
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
						print "<div>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])." (".$va_info['relationship_typename'].")</div>";
					}
					print "</div><!-- end unit -->";
				}
			}
			# --- collections
			$va_collections = $t_object->get("ca_collections", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_collections) > 0){
				print "<div class='unit'><h2>"._t("Related Collection").((sizeof($va_collections) > 1) ? "s" : "")."</h2>";
				foreach($va_collections as $va_collection_info){
					print "<div>".(($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." (".$va_collection_info['relationship_typename'].")</div>";
				}
				print "</div><!-- end unit -->";
			}
			# --- vocabulary terms
			$va_terms = $t_object->get("ca_list_items", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_terms) > 0){
				$va_terms_labels = array();
				foreach($va_terms as $va_term_info){
					$va_terms_labels[] = $va_term_info['label'];
				}
				print "<div class='unit'><label>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "").": </label>";
				$i = 0;
				asort($va_terms_labels);
				foreach($va_terms_labels as $vs_term){
					print caNavLink($this->request, $vs_term, '', '', 'Search', 'Index', array('search' => $vs_term));
					$i++;
					if($i < sizeof($va_terms_labels)){
						print ", ";
					}
				}
				print "</div><!-- end unit -->";
			}
			
?>
				{{{<ifdef code="ca_objects.lcsh_terms"><div class="unit"><label>Library of Congress Subject Headings:</label>^ca_objects.lcsh_terms%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.external_link"><div class="unit"><label>Link:</label><unit relativeTo="ca_objects.external_link" delimiter="<br/>"><a href='^ca_objects.external_link.url_entry' target='_blank'>^ca_objects.external_link.url_source</a></unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.descritpion"><div class="unit"><label>Description:</label>^ca_objects.description%convertLinkBreaks=1</div></ifdef>}}}
				{{{<ifdef code="ca_objects.parent_id"><div class="unit"><label>Part of:</label><unit relativeTo="ca_objects.parent"><l>^ca_objects.parent.preferred_labels.name</l></unit></div></ifdef>}}}
				
<?php				
			# --- child hierarchy info
			$va_children = $t_object->get("ca_objects.children.preferred_labels", array('returnWithStructure' => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_children) > 0){
				print "<div class='unit'><h2>"._t("Part%1", ((sizeof($va_children) > 1) ? "s" : ""))."</h2> ";
				$i = 0;
				foreach($va_children as $va_child){
					# only show the first 5 and have a more link
					if($i == 5){
						print "<div id='moreChildrenLink'><a href='#' onclick='$(\"#moreChildren\").slideDown(250); $(\"#moreChildrenLink\").hide(1); return false;'>["._t("More")."]</a></div><!-- end moreChildrenLink -->";
						print "<div id='moreChildren' style='display:none;'>";
					}
					print "<div>".caNavLink($this->request, $va_child['name'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_child['object_id']))."</div>";
					$i++;
					if($i == sizeof($va_children)){
						print "</div><!-- end moreChildren -->";
					}
				}
				print "</div><!-- end unit -->";
			}	
			# --- output related object images as links
			$va_related_objects = $t_object->get("ca_objects", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if (sizeof($va_related_objects)) {
				print "<div class='unit'><h2>"._t("Related Objects")."</h2>";
				foreach($va_related_objects as $vn_rel_id => $va_info){
					$t_rel_object = new ca_objects($va_info["object_id"]);
					$va_reps = $t_rel_object->getPrimaryRepresentation(array('icon', 'small'), null, array('return_with_access' => $va_access_values));
					print "<div class='relObj".$va_info["object_id"]."'>".caNavLink($this->request, $va_info['label'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_info["object_id"]))."</div>";
					
					// set view vars for tooltip
					$this->setVar('tooltip_representation', $va_reps['tags']['small']);
					$this->setVar('tooltip_title', $va_info['label']);
					$this->setVar('tooltip_idno', $va_info["idno"]);
					TooltipManager::add(
						".relObj".$va_info["object_id"], $this->render('../Results/ca_objects_result_tooltip_html.php')
					);
					
					
				}
				
				print "</div><!-- end unit -->";
			}
?>
						
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>