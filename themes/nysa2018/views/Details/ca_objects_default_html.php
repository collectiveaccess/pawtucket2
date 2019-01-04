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
	<div class='col-xs-12 '><!--- only shown at small screen size -->
		<div class='pageNav'>
			{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
		</div>
	</div><!-- end detailTop -->
</div>
<div class="row">	
	<div class='col-xs-12'>
		<div class="container"><div class="row">
			<div class='col-sm-12'>
<?php
				print "<h2>".$t_object->get('ca_objects.preferred_labels')."</h2>";
?>
			</div>
			<div class='col-sm-7'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-5 rightCol'>
<?php
			if ($vs_description = $t_object->get('ca_objects.description')) {
				print "<div class='unit'>".$vs_description."</div>";
			}			
			# --- identifier
			if($t_object->get('idno')){
				if($vs_collection_idno = $t_object->get('ca_collections.idno')){
					#print_r(@get_headers("http://iarchives.nysed.gov/xtf/view?docId=tei/".$vs_collection_idno."/".$t_object->get('idno').".xml"));
					# get transcript y/n
					$va_attributes = $this->request->config->get('ca_objects_detail_display_attributes');
					if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
						foreach($va_attributes as $vs_attribute_code){
							if($vs_value = $t_object->get("ca_objects.{$vs_attribute_code}", array('convertCodesToDisplayText' => true, 'delimiter' => ',<br/> '))){
								if($vs_attribute_code == "transcript") {
									if($vs_value == "Yes") {
										print "<div class='unit'><a href='http://iarchives.nysed.gov/xtf/view?docId=tei/".$vs_collection_idno."/".$t_object->get('idno').".xml' target='_blank' class='cabutton'>&nbsp;&nbsp;&nbsp;"._t("Transcript / Translation")."&nbsp;&nbsp;&nbsp;</a></div>";
									}
								}
							}
						}
					}
#						print "<div class='unit'><a href='http://iarchives.nysed.gov/xtf/view?docId=tei/".$vs_collection_idno."/".$t_object->get('idno').".xml' target='_blank' class='cabutton'>&nbsp;&nbsp;&nbsp;"._t("Transcript / Translation")."&nbsp;&nbsp;&nbsp;</a></div>";
				}
				print "<div class='unit'><b>"._t("Identifier").":</b> ".$t_object->get('idno')."</div><!-- end unit -->";
			}
			if ($va_date_array = $t_object->get('ca_objects.date', array('returnWithStructure' => true))) {
				$t_list = new ca_lists();
				$vn_original_date_id = $t_list->getItemIDFromList("date_types", "dateOriginal");
				foreach ($va_date_array as $va_key => $va_date_array_t) {
					foreach ($va_date_array_t as $va_key => $va_date_array) {
						if ($va_date_array['dc_dates_types'] == $vn_original_date_id) {
							print "<div class='unit'><b>Date: </b>".$va_date_array['dates_value']."</div>";
						}
					}
				}
				
			}
			if ($vs_contributor = $t_object->get('ca_objects.contributor')) {
				print "<div class='unit'><b>Contributor: </b>".$vs_contributor."</div>";
			}
			if ($vs_repository = $t_object->get('ca_objects.repository', array('convertCodesToDisplayText' => true))) {
				print "<div class='unit'><b>Repository: </b>".$vs_repository."</div>";
			}
			if ($vs_language = $t_object->get('ca_objects.language', array('convertCodesToDisplayText' => true))) {
				print "<div class='unit'><b>Language: </b>".$vs_language."</div>";
			}			
			if ($vs_source = $t_object->get('ca_objects.description_source')) {
				print "<div class='unit'><b>Source: </b>".$vs_source."</div>";
			}						
			if ($va_rights_array = $t_object->get('ca_objects.rightsList', array('returnWithStructure' => true))) {
				$t_rights_list = new ca_lists();
				$vn_nysa_id = $t_list->getItemIDFromList("rightsType", "NYSArights");
				$vn_nonnysa_id = $t_list->getItemIDFromList("rightsType", "nonNYSArights");
				foreach ($va_rights_array as $va_key => $va_rights_array_t) {
					foreach ($va_rights_array_t as $va_key => $va_rights_array) {
						if ($va_rights_array['rightsList'] == $vn_nysa_id) {
							print "<div class='unit'><b>Rights: </b>This image is provided for education and research purposes. Rights may be reserved. Responsibility for securing permissions to distribute, publish, reproduce or other use rest with the user. For additional information see our <a href='/index.php/About/Copyright'>Copyright and Use Statement</a></div>";
						} else if ($va_rights_array['rightsList'] == $vn_nonnysa_id) {
							print "<div class='unit'><b>Rights: </b>This record is not part of the New York State Archives' collection and is presented on our project partner's behalf for educational use only.  Please contact the home repository for information on copyright and reproductions.</div>";
						}
					}
				}
				
			}	
			if ($vs_special = $t_object->get('ca_objects.SpecialProject', array('convertCodesToDisplayText' => true))) {
				print "<div class='unit'><b>Special Project: </b>".$vs_special."</div>";
			}					
			# --- parent hierarchy info
			if($t_object->get('parent_id')){
				print "<div class='unit'><b>"._t("Part Of")."</b>: ".caNavLink($this->request, $t_object->get("ca_objects.parent.preferred_labels.name"), '', 'Detail', 'Object', 'Show', array('object_id' => $t_object->get('parent_id')))."</div>";
			}

			# --- Relation
			#alternateID
			#nonpreferred_labels
			#SpecialProject
			#transcript
				
			# --- child hierarchy info
			$va_children = $t_object->get("ca_objects.children.preferred_labels", array('returnAsArray' => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_children) > 0){
				print "<div class='unit'><h3>"._t("Part%1", ((sizeof($va_children) > 1) ? "s" : ""))."</h3> ";
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
			# --- collections
			$vs_collections = $t_object->get("ca_collections", array("template" => "<unit relativeTo='ca_collections'><l>^ca_collections.preferred_labels.name</l> (^relationship_typename)</unit><br/>\n", 'checkAccess' => $va_access_values));
			if($vs_collections){
				print "<div class='unit'><h3>"._t("Related collections")."</h3>";
				print $vs_collections;
				print "</div><!-- end unit -->";
			}
			
			# --- entities
			if ($vs_entities = $t_object->getWithTemplate("<ifcount code='ca_entities' min='1'><unit relativeTo='ca_entities'><l>^ca_entities.preferred_labels.displayname</l> (^relationship_typename)</unit></ifcount>")){	
				print "<div class='unit'><h3>"._t("Related entities")."</h3>";
				print $vs_entities;
				print "</div><!-- end unit -->";
			}
			
			# --- occurrences
			$va_occurrences = $t_object->get("ca_occurrences", array("returnAsArray" => true, 'checkAccess' => $va_access_values));
			$va_sorted_occurrences = array();
			if(is_array($va_occurrences) && (sizeof($va_occurrences) > 0)){
				$t_occ = new ca_occurrences();
				$va_item_types = $t_occ->getTypeList();
				foreach($va_occurrences as $va_occurrence) {
					$t_occ->load($va_occurrence['occurrence_id']);
					$va_sorted_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = $va_occurrence;
				}
				
				foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
					print "<div class='unit'><h3>"._t("Related %1", $va_item_types[$vn_occurrence_type_id]['name_plural'])."</h3>";
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
						print "<div>".(($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info["label"], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"])." (".$va_info['relationship_typename'].")</div>";
					}
					print "</div><!-- end unit -->";
				}
			}
			
			# --- places
			$vs_places = $t_object->getWithTemplate("<unit relativeTo='ca_places'><l>^ca_places.preferred_labels.name</l> (^relationship_typename)</unit><br/>\n");
			
			if($vs_places){
				print "<div class='unit'><h3>"._t("Related places")."</h3>";
				print $vs_places;
				print "</div><!-- end unit -->";
			}
			
			# --- lots
			$vs_object_lots = $t_object->getWithTemplate("<ifcount code='ca_lots' min='1'><unit relativeTo='ca_lots'><l>^ca_lots.preferred_labels.name</l> (^ca_lots.idno_stub)</unit></ifcount>");
			if($vs_object_lots){
				print "<div class='unit'><h3>"._t("Related lot")."</h3>";
				print $vs_object_lots;
				print "</div><!-- end unit -->";
			}
			
			# --- vocabulary terms
			$vs_terms = $t_object->getWithTemplate("<ifcount code='ca_lots' min='1'><unit relativeTo='ca_lots'><l>^ca_list_items.preferred_labels.name_plural</l> (^relationship_typename)</unit></ifcount>");
			if($vs_terms){
				print "<div class='unit'><h3>"._t("Subjects")."</h3>";
				print $vs_terms;
				print "</div><!-- end unit -->";
			}
			
			# --- map
			if($this->request->config->get('ca_objects_map_attribute') && $t_object->get($this->request->config->get('ca_objects_map_attribute'))){
				$o_map = new GeographicMap(285, 200, 'map');
				$o_map->mapFrom($t_object, $this->request->config->get('ca_objects_map_attribute'));
				print "<div class='unit'>".$o_map->render('HTML')."</div>";
			}	
					
			# --- output related object images as links
			$va_related_objects = $t_object->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if (sizeof($va_related_objects)) {
				print "<div class='unit'><h3>"._t("Related objects")."</h3>";
				print "<table border='0' cellspacing='0' cellpadding='0' width='100%' id='objDetailRelObjects'>";
				$col = 0;
				$vn_numCols = 4;
				foreach($va_related_objects as $vn_rel_id => $va_info){
					$t_rel_object = new ca_objects($va_info["object_id"]);
					$va_reps = $t_rel_object->getPrimaryRepresentation(array('icon', 'small'), null, array('return_with_access' => $va_access_values));
					if($col == 0){
						print "<tr>";
					}
					print "<td align='center' valign='middle' class='imageIcon icon".$va_info["object_id"]."'>";
					print caNavLink($this->request, $va_reps['tags']['icon'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_info["object_id"]));
					
					// set view vars for tooltip
					$this->setVar('tooltip_representation', $va_reps['tags']['small']);
					$this->setVar('tooltip_title', $va_info['label']);
					$this->setVar('tooltip_idno', $va_info["idno"]);
					TooltipManager::add(
						".icon".$va_info["object_id"], $this->render('../Results/ca_objects_result_tooltip_html.php')
					);
					
					print "</td>";
					$col++;
					if($col < $vn_numCols){
						print "<td align='center'><!-- empty --></td>";
					}
					if($col == $vn_numCols){
						print "</tr>";
						$col = 0;
					}
				}
				if(($col != 0) && ($col < $vn_numCols)){
					while($col <= $vn_numCols){
						if($col < $vn_numCols){
							print "<td><!-- empty --></td>";
						}
						$col++;
						if($col < $vn_numCols){
							print "<td align='center'><!-- empty --></td>";
						}
					}
				}
				print "</table></div><!-- end unit -->";
			}
?>
				
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
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