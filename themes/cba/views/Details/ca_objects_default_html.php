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
	$va_access_values = caGetUserAccessValues($this->request);
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
		<div class="row detailMainRow">
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<div id="detailRepresentationThumbnails"><?php print join("", caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "array", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-2 col-md-2 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0))); ?></div>
				
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
			
			<div class='col-sm-6 col-md-6 col-lg-5 <?php print (trim($this->getVar("representationViewer"))) ? "detailRightCol" : ""; ?>'>
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
<?php
			if($t_object->get("ca_objects.type_id")){
				print '<H2>'.caNavLink($this->request, $t_object->get("ca_objects.type_id", array("convertCodesToDisplayText" => true)), '', '', 'Browse', 'objects', array('facet' => 'type_facet', 'id' => $t_object->get("ca_objects.type_id"))).'</H2>';
			}
?>
				<HR>
			{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Identifier:</label>^ca_objects.idno</div></ifdef>}}}
<?php
			if($t_object->get("ca_objects.source_id")){
				print '<div class="unit"><label>Collection:</label>'.caNavLink($this->request, $t_object->get("ca_objects.source_id", array("convertCodesToDisplayText" => true)), '', '', 'Browse', 'objects', array('facet' => 'source_facet', 'id' => $t_object->get("ca_objects.source_id"))).'</div>';
			}
?>
			{{{<ifdef code="ca_objects.dimensions_as_text"><div class="unit"><label>Dimensions:</label><unit relativeTo="ca_objects.dimensions_as_text" delimiter="; ">^ca_objects.dimensions_as_text</unit></div></ifdef>}}}
			{{{<ifdef code="ca_objects.dates.dates_value"><unit relativeTo="ca_objects.dates" delimiter=" "><div class="unit"><label>^ca_objects.dates.dates_type:</label>^ca_objects.dates.dates_value</div></unit></ifdef>}}}
<?php
			# --- entities
			$va_entities = $t_object->get("ca_entities", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values, 'sort' => array('surname',' forename')));
			if(sizeof($va_entities) > 0){	
				$va_entities_by_type = array();
				foreach($va_entities as $va_entity) {
					$va_entities_by_type[$va_entity['relationship_typename']][] = caNavLink($this->request, $va_entity["label"], '', '', 'Browse', 'objects', array('facet' => 'entity_facet', 'id' => $va_entity["entity_id"]));
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
					$va_places_by_type[$va_place_info['relationship_typename']][] = caNavLink($this->request, $va_place_info["label"], '', '', 'Browse', 'objects', array('facet' => 'place_facet', 'id' => $va_place_info["place_id"]));
				}
				ksort($va_places_by_type);
				foreach($va_places_by_type as $vs_type => $va_place_links){
					print "<div class='unit'><label>".$vs_type.": </label>".join($va_place_links, ", ")."</div><!-- end unit -->";
				}
			}
			# --- collections
			$va_collections = $t_object->get("ca_collections", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_collections) > 0){
				print "<div class='unit'><label>"._t("Related Collection").((sizeof($va_collections) > 1) ? "s" : "")."</label>";
				foreach($va_collections as $va_collection_info){
					print "<div>".$va_collection_info['label']."</div>";
				}
				print "</div><!-- end unit -->";
			}
			# --- vocabulary terms
			$va_terms = $t_object->get("ca_list_items", array("returnWithStructure" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_terms) > 0){
				$va_terms_labels = array();
				foreach($va_terms as $va_term_info){
					$va_terms_labels[$va_term_info['label']] = caNavLink($this->request, $va_term_info['label'], '', '', 'browse', 'objects', array('facet' => 'term_facet', 'id' => $va_term_info["item_id"]));
				}
				print "<div class='unit'><label>"._t("Subject").((sizeof($va_terms) > 1) ? "s" : "").": </label>";
				$i = 0;
				ksort($va_terms_labels);
				foreach($va_terms_labels as $vs_term){
					print $vs_term;
					$i++;
					if($i < sizeof($va_terms_labels)){
						print ", ";
					}
				}
				print "</div><!-- end unit -->";
			}
			
				$va_LcshSubjects = $t_object->get("ca_objects.lcsh_terms", array("returnAsArray" => true));
				$va_LcshSubjects_processed = array();
				if(is_array($va_LcshSubjects) && sizeof($va_LcshSubjects)){
					foreach($va_LcshSubjects as $vs_LcshSubjects){
						if($vs_LcshSubjects && (strpos($vs_LcshSubjects, " [") !== false)){
							$vs_LcshSubjects = mb_substr($vs_LcshSubjects, 0, strpos($vs_LcshSubjects, " ["));
						}
						#$va_LcshSubjects_processed[] = caNavLink($this->request, $vs_LcshSubjects, "", "", "Search", "objects", array("search" => "ca_objects.lcsh_terms: ".$vs_LcshSubjects));
						$va_LcshSubjects_processed[] = $vs_LcshSubjects;
					}
					if($vs_tmp = join(", ", $va_LcshSubjects_processed)){
						print '<div class="unit"><label>Library of Congress Subject Headings:</label>'.$vs_tmp.'</div>';
					}
				}
?>
				{{{<ifdef code="ca_objects.external_link"><div class="unit"><label>Link:</label><unit relativeTo="ca_objects.external_link" delimiter="<br/>"><a href='^ca_objects.external_link.url_entry' target='_blank'>^ca_objects.external_link.url_source</a></unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.description"><div class="unit"><label>Description:</label>^ca_objects.description%convertLinkBreaks=1</div></ifdef>}}}
				{{{<ifdef code="ca_objects.parent_id"><div class="unit"><label>Part of:</label><unit relativeTo="ca_objects.parent"><l>^ca_objects.parent.preferred_labels.name</l></unit></div></ifdef>}}}
				

			{{{<ifcount code="ca_objects.children" min="1"><div class="unit"><label>Part<ifcount code="ca_objects.children" min="2">s</ifcount></label><unit relativeTo="ca_objects.children" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit></div></ifcount>}}}
			
			{{{<ifcount code="ca_objects.related" min="1"><div class="unit"><label>Related Objects</label><unit relativeTo="ca_objects.related" delimiter="<br/>"><l>^ca_objects.preferred_labels.name</l></unit></div></ifcount>}}}
						
			</div><!-- end col -->
		</div><!-- end row -->
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