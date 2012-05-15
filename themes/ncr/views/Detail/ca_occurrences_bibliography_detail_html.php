<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_occurrences_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
	$t_occurrence 		= $this->getVar('t_item');
	$vn_occurrence_id 	= $t_occurrence->getPrimaryKey();
	
	$vs_title 			= $this->getVar('label');
	$va_access_values	= $this->getVar('access_values');
	$vn_num_more_link = $this->request->config->get("num_items_before_more_link");
	JavascriptLoadManager::register('panel');

if (!$this->request->isAjax()) {
?>
<div id="pageHeading"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/t_bibliography.gif' width='146' height='23' border='0'></div><!-- end pageHeading -->
	<div id="detailBody">
		<div id="pageNav">
<?php
			if ($this->request->config->get('enable_bookmarks')) {
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("Bookmark +"), '', '', 'Bookmarks', 'addBookmark', array('row_id' => $vn_occurrence_id, 'tablename' => 'ca_occurrences'));
				}else{
					print caNavLink($this->request, _t("Bookmark +"), '', '', 'LoginReg', 'form', array('site_last_page' => 'Bookmarks', 'row_id' => $vn_occurrence_id, 'tablename' => 'ca_occurrences'));
				}
			}
			if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_occurrences', _t("Back"), ''))) {
				if ($this->request->config->get('enable_bookmarks')) {
					print "&nbsp;&nbsp;|&nbsp;&nbsp;";
				}
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "&lsaquo; "._t("Previous"), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}else{
					print "&lsaquo; "._t("Previous");
				}
				print "&nbsp;&nbsp;|&nbsp;&nbsp;{$vs_back_link}&nbsp;&nbsp;|&nbsp;&nbsp;";
				if ($this->getVar('next_id') > 0) {
					print caNavLink($this->request, _t("Next")." &rsaquo;", '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $this->getVar('next_id')), array('id' => 'next'));
				}else{
					print _t("Next")." &rsaquo;";
				}
			}
?>
		</div><!-- end nav -->
<?php
	# ---------------------------------------------------
	# --- DISPLAY PLACEHOLDER INFO IF STATUS == 0
	# ---------------------------------------------------
	if($t_occurrence->get("status") == 0){
?>
	<div>
<?php
		if($t_occurrence->get("ca_occurrences.citation_format")){
				print "<div class='unit'><b>".$t_occurrence->get("ca_occurrences.citation_format", array('convertCodesToDisplayText' => true))."</b></div><!-- end unit -->";
			}
		if($this->getVar('label')){
			print "<H2><i>".$this->getVar('label')."</i></H2>";
		}
		if($t_occurrence->get("ca_occurrences.bib_full_citation")){
			print "<div class='unit'>".($t_occurrence->get("ca_occurrences.bib_full_citation"))."</div><!-- end unit -->";
		}
		print "<div class='unit'><a href='#' onclick='researchPendingPanel.showPanel(\"".caNavUrl($this->request, '', 'About', 'ResearchPendingBibliography')."\"); return false;' ><i>"._t("Research pending*")."</i></a></div><!-- end unit -->";
		
?>	
	</div><!-- end placeholder text -->
<?php
	}else{
	# ---------------------------------------------------
	# --- DISPLAY FULL INFO
	# ---------------------------------------------------
?>
		<div>	
<?php
			if($t_occurrence->get("ca_occurrences.citation_format")){
				print "<div class='unit'><b>".$t_occurrence->get("ca_occurrences.citation_format", array('convertCodesToDisplayText' => true))."</b></div><!-- end unit -->";
			}
			if($this->getVar('label')){
				print "<H2><i>".$this->getVar('label')."</i></H2>";
			}
			print "<div class='unit'>";
			$va_entities_output = array();
			if($va_authors = $t_occurrence->get('ca_entities', array('restrict_to_relationship_types' => array('author'), "returnAsArray" => 1, 'checkAccess' => $va_access_values))){
				$va_author_name = array();
				foreach($va_authors as $vn_relation_id => $va_author_info){
					$va_entities_output[] = $va_author_info["relation_id"];
					$va_author_name[] = $va_author_info["displayname"];
				}
				print _t("By")." ".implode($va_author_name, ", ")."<br/>";
			}
			if($va_editors = $t_occurrence->get('ca_entities', array('restrict_to_relationship_types' => array('editor'), "returnAsArray" => 1, 'checkAccess' => $va_access_values))){
				$va_editor_name = array();
				foreach($va_editors as $vn_relation_id => $va_editor_info){
					$va_entities_output[] = $va_editor_info["relation_id"];
					$va_editor_name[] = $va_editor_info["displayname"];
				}
				print _t("Edited by")." ".implode($va_editor_name, ", ")."<br/>";
			}
			if($va_contributors = $t_occurrence->get('ca_entities', array('restrict_to_relationship_types' => array('contributing_author'), "returnAsArray" => 1, 'checkAccess' => $va_access_values))){
				$va_contributor_name = array();
				foreach($va_contributors as $vn_relation_id => $va_contributor_info){
					$va_entities_output[] = $va_contributor_info["relation_id"];
					print $va_contributor_info["source_info"]." ".$va_contributor_info["displayname"]."<br/>";
				}
			}
			if($t_occurrence->get("ca_occurrences.bib_copyright")){
				print _t("Published by")." ".$t_occurrence->get("ca_occurrences.bib_copyright");
				if($t_occurrence->get("ca_occurrences.bib_year_published")){
					if((intval($t_occurrence->get("ca_occurrences.bib_year_published")) >= 1904) && (intval($t_occurrence->get("ca_occurrences.bib_year_published")) <= 1988)){
						print ", ".caNavLink($this->request, ($t_occurrence->get("ca_occurrences.bib_year_published")), '', 'Chronology', 'Detail', '', array('year' => intval($t_occurrence->get("ca_occurrences.bib_year_published"))));
					}else{
						print ", ".$t_occurrence->get("ca_occurrences.bib_year_published");
					}
				}
				print "<br/>";
			}
			if($t_occurrence->get("ca_occurrences.bib_language") && ($t_occurrence->get("ca_occurrences.bib_language", array('convertCodesToDisplayText' => true)) != "English")){
				print _t("Text in")." ".$t_occurrence->get("ca_occurrences.bib_language", array('convertCodesToDisplayText' => true));
			}
			print "</div><!-- end unit -->";
			
			if($t_occurrence->get("ca_occurrences.bib_full_citation")){
				print "<H3>Citation</H3><div class='unit'>".($t_occurrence->get("ca_occurrences.bib_full_citation"))."</div><!-- end unit -->";
			}
			if($t_occurrence->get("ca_occurrences.bib_notes")){
				print "<H3>Comments</H3><div class='unit'>";
				print $t_occurrence->get("ca_occurrences.bib_notes", null, array('convertLinkBreaks' => true));
				print "</div><!-- end unit -->";
			}
			
			# --- entities - displayed by type
			$va_entities = $t_occurrence->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities)){	
				$va_related_entities = array();
				foreach($va_entities as $va_entity) {
					if(!in_array($va_entity["relation_id"], $va_entities_output)){
						$va_related_entities[$va_entity["relationship_typename"]][] = $va_entity["displayname"];
					}
				}
				if(sizeof($va_related_entities) > 0){
					print "<div class='unit'>";
					$i = 0;
					foreach($va_related_entities as $vs_relationship_typename => $va_entities_by_rel_type){
						if($i == $vn_num_more_link){
							print "<div id='entitiesMore' class='relatedMoreItems'>";
						}
						print "<b>".$vs_relationship_typename.((sizeof($va_entities_by_rel_type) > 1) ? "s" : "").":</b> ";
						print implode($va_entities_by_rel_type, ", ")."<br/>";
						$i++;
					}
					if($i > $vn_num_more_link){
						print "</div>";
						print "<div class='moreLink'><a href='#' id='entitiesMoreLink' onclick='jQuery(\"#entitiesMore\").slideDown(250); jQuery(\"#entitiesMoreLink\").hide(); return false;'>".(sizeof($va_entities) - $vn_num_more_link)._t(" More like this")." &rsaquo;</a></div>";
					}
					print "</div><!-- end unit -->";
				}
			}
		
			# --- occurrences
			$va_occurrences = $t_occurrence->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => array('ca_occurrences.date.parsed_date')));
			$va_sorted_occurrences = array();
			if(sizeof($this->getVar('occurrences'))){
				$t_occ = new ca_occurrences();
				$va_item_types = $t_occ->getTypeList();
				foreach($this->getVar('occurrences') as $va_occurrence) {
					$t_occ->load($va_occurrence['occurrence_id']);
					$vs_venue = "";
					$va_venues = array();
					$va_venues = $t_occ->get('ca_entities', array('restrict_to_relationship_types' => array('primary_venue'), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
					if(sizeof($va_venues) > 0){
						$va_venue_name = array();
						foreach($va_venues as $va_venue_info){
							$va_venue_name[] = $va_venue_info["displayname"];
						}
						$vs_venue = implode($va_venue_name, ", ");
					}
					$va_sorted_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = array("label" => $va_occurrence['label'], "date" => $t_occ->get("ca_occurrences.date.display_date"), "year_published" => $t_occ->get("ca_occurrences.bib_year_published"), "venue" => $vs_venue, "relationship_type_id" => $va_occurrence['relationship_type_id'], "bib_full_citation" => $t_occ->get("ca_occurrences.bib_full_citation"));
				}
				
				$va_occ_rel_types = $t_rel_types->getRelationshipInfo('ca_objects_x_occurrences');
				foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
					switch($va_item_types[$vn_occurrence_type_id]['idno']){
						case "bibliography":
							$vs_title = "Related Text";
						break;
						# --------------------------------------
						case "exhibition":
							$vs_title = "Related exhibition";
						break;
						# --------------------------------------
						default:
							$vs_title = $va_item_types[$vn_occurrence_type_id]['name_singular'];
						break;
						# --------------------------------------
					}
?>
						<div class="unit"><H3><?php print $vs_title.((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></H3>
<?php
					$i = 0;
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info){
						switch($va_item_types[$vn_occurrence_type_id]['idno']){
							case "exhibition":
								$vs_exhibition_title = "\"".$va_info['label'].",\" ";
								if($va_info["venue"]){
									$vs_exhibition_title .= $va_info["venue"];
								}
								if($va_info["date"]){
									$vs_exhibition_title .= ", ".$va_info["date"];
								}
								if($i == $vn_num_more_link){
									print "<div id='exhibitionMore' class='relatedMoreItems'>";
								}
								print "<div class='indent'>";
								print (($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $vs_exhibition_title, '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"]);
								
								print "</div>";

							break;
							# ------------------------------
							case "bibliography":
								if($i == $vn_num_more_link){
									print "<div id='bibliographyMore' class='relatedMoreItems'>";
								}
								print "<div class='indent'>";
								print (($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info['bib_full_citation'], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["bib_full_citation"]);
								print "</div>";

							break;
							# ------------------------------
						}
						$i++;

					}
					if($i > $vn_num_more_link){
						print "</div>";
						print "<div class='moreLink'><a href='#' id='occ".$va_item_types[$vn_occurrence_type_id]['idno']."MoreLink' onclick='jQuery(\"#".$va_item_types[$vn_occurrence_type_id]['idno']."More\").slideDown(250); jQuery(\"#occ".$va_item_types[$vn_occurrence_type_id]['idno']."MoreLink\").hide(); return false;'>".(sizeof($va_occurrence_list) - $vn_num_more_link)._t(" More like this")." &rsaquo;</a></div>";
					}
					print "</div><!-- end unit -->";
				}
			}
			# --- collections
			$va_collections = $t_occurrence->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_collections) > 0){
				print "<div class='unit'><H2>"._t("Related Collection").((sizeof($va_collections) > 1) ? "s" : "")."</H2>";
				$i = 0;
				foreach($va_collections as $va_collection_info){
					if($i == $vn_num_more_link){
						print "<div id='collectionMore' class='relatedMoreItems'>";
					}
					print "<div>";
					print (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." (".unicode_ucfirst($va_collection_info["relationship_typename"]).")";
					print "</div>";
					$i++;
				}
				if($i > $vn_num_more_link){
					print "</div>";
					print "<div class='class='moreLink'><a href='#' id='collectionMoreLink' onclick='jQuery(\"#collectionMore\").slideDown(250); jQuery(\"#collectionMoreLink\").hide(); return false;'>".(sizeof($va_collections) - $vn_num_more_link)." "._t("More like this")." &rsaquo;</a></div>";
				}
				print "</div><!-- end unit -->";
			}		
			# --- output related object images as links
			$qr_hits = $this->getVar('browse_results');
			if($qr_hits->numHits() > 0){
				if($qr_hits->numHits() > 1){
					$vs_title = _t("Artworks Cited");
				}else{
					$vs_title = _t("Artwork Cited");
				}
				print "<div class='unit'><H3>".$vs_title."</H3>";
				$i = 0;
				while($qr_hits->nextHit()){
					if($i == $vn_num_more_link){
						print "<div id='artworkMore' class='relatedMoreItems'>";
					}
					$vn_rel_object_id = $qr_hits->get("object_id");
					print "<div id='relArtwork".$vn_rel_object_id."'  class='relArtwork' ".(((($i/2) - floor($i/2)) == 0) ? "style='clear:left;'" : "").">";
					if($qr_hits->getMediaTag('ca_object_representations.media', 'tiny', array('checkAccess' => $va_access_values))){
						print "<div class='relArtworkImage' id='relArtworkImage".$vn_rel_object_id."'>".caNavLink($this->request, $qr_hits->getMediaTag('ca_object_representations.media', 'tiny', array('checkAccess' => $va_access_values)), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id))."</div>";
					}else{
						print "<div class='relArtworkImagePlaceHolder'><!-- empty --></div>";
					}
					print "<div style='float:left; width:250px;'>";
					if($qr_hits->get("ca_objects.idno")){
						print "<span class='resultidno'>".trim($qr_hits->get("ca_objects.idno"))."</span><br/>";
					}
					$va_labels = $qr_hits->getDisplayLabels($this->request);
					$vs_title = join('; ', $va_labels);
					if($this->request->config->get('allow_detail_for_ca_objects')){
						print caNavLink($this->request, "<i>".$vs_title."</i>", '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id))."<br/>";
					}else{
						print "<i>".$vs_title."</i><br/>";
					}
					if($qr_hits->get("ca_objects.date.display_date")){
						print $qr_hits->get("ca_objects.date.display_date")."<br/>";
					}
					if($qr_hits->get("ca_objects.technique")){
						print $qr_hits->get("ca_objects.technique")."<br/>";
					}
					
					$va_source_info = caUnserializeForDatabase($qr_hits->get("ca_objects_x_occurrences.source_info", array('returnAsArray' => false, 'where' => array('occurrence_id' => $vn_occurrence_id))));
					
					$va_illustration_info1 = array();
					$va_illustration_info2 = array();
					$vs_illustration_info1 = "";
					$vs_illustration_info2 = "";
					if($va_source_info["page_number"]){
						$va_illustration_info1[] = _t("p. ").$va_source_info["page_number"];
					}
					if($va_source_info["catalogue_number"]){
						$va_illustration_info1[] = _t("no. ").$va_source_info["catalogue_number"];
					}
					if($va_source_info["illustrated"]){
						$va_illustration_info2[] = _t("illustrated");
					}
					if($va_source_info["figure_number"]){
						$va_illustration_info2[] = _t("fig. ").$va_source_info["figure_number"];
					}
					$vs_illustration_info1 = implode(", ", $va_illustration_info1);
					$vs_illustration_info2 = implode(", ", $va_illustration_info2);
					if($vs_illustration_info1){
						print $vs_illustration_info1."<br/>";
					}
					if($vs_illustration_info2){
						print $vs_illustration_info2;
					}
					
					print "</div><div style='clear:left;'><!-- empty --></div></div>";
					// set view vars for tooltip
					$vs_tooltip_image = $qr_hits->getMediaTag('ca_object_representations.media', 'small', array('checkAccess' => $va_access_values));
					if($vs_tooltip_image){
						$this->setVar('tooltip_representation', $vs_tooltip_image);
						TooltipManager::add(
							"#relArtworkImage{$vn_rel_object_id}", $this->render('../Results/ca_objects_result_tooltip_html.php')
						);
					}
					$i++;
				}
				if($i > $vn_num_more_link){
					print "</div>";
					print "<div class='moreLink'><a href='#' id='artworkMoreLink' onclick='jQuery(\"#artworkMore\").slideDown(250); jQuery(\"#artworkMoreLink\").hide(); return false;'>".($qr_hits->numHits() - $vn_num_more_link)._t(" More like this")." &rsaquo;</a></div>";
				}
				print "</div><!-- end unit -->";
			}
			
			print "<div style='clear:both; height:10px;'><!-- empty --></div>";
			
			if($t_occurrence->get("ca_occurrences.published_on") || $t_occurrence->get("ca_occurrences.last_updated_on")){
				print "<div class='unit' style='font-size:11px; color:#828282;'>";
				if($t_occurrence->get("ca_occurrences.published_on")){
					print "<i>Published ".$t_occurrence->get("ca_occurrences.published_on")."</i>";
				}
				if($t_occurrence->get("ca_occurrences.published_on") != $t_occurrence->get("ca_occurrences.last_updated_on")){
					if($t_occurrence->get("ca_occurrences.published_on") && $t_occurrence->get("ca_occurrences.last_updated_on")){
						print "<br/>";
					}
					if($t_occurrence->get("ca_occurrences.last_updated_on")){
						print "<i>Last updated on ".$t_occurrence->get("ca_occurrences.last_updated_on")."</i>";
					}
				}
				print "</div>";
			}
?>
	</div><!-- end column containing all text -->
<?php
	}
?>
</div><!-- end detailBody -->
<?php
}
?>