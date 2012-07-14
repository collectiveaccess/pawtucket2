<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_objects_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009 Whirl-i-Gig
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
	$t_object = 					$this->getVar('t_item');
	$vn_object_id = 				$t_object->get('object_id');
	$vs_title = 						$this->getVar('label');
		
	$va_access_values = 				$this->getVar('access_values');
	$t_rep = 							$this->getVar('t_primary_rep');
	$vn_num_reps = 						$t_object->getRepresentationCount(array("return_with_access" => $va_access_values));
	$vs_display_version =				$this->getVar('primary_rep_display_version');
	$va_display_options =				$this->getVar('primary_rep_display_options');
	
	$vn_num_more_link = $this->request->config->get("num_items_before_more_link");
	
?>	
<div id="pageHeading"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/t_artworks.gif' width='111' height='23' border='0'></div><!-- end pageHeading -->
	<div id="detailBody">
		<div id="pageNav">
<?php
			
			if ($this->request->config->get('enable_bookmarks')) {
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("Bookmark +"), '', '', 'Bookmarks', 'addBookmark', array('row_id' => $vn_object_id, 'tablename' => 'ca_objects'));
				}else{
					print caNavLink($this->request, _t("Bookmark +"), '', '', 'LoginReg', 'form', array('site_last_page' => 'Bookmarks', 'row_id' => $vn_object_id, 'tablename' => 'ca_objects'));
				}
			}
			if (($this->getVar('is_in_result_list')) && ($vs_back_link = ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', _t("Back"), ''))) {
				if ($this->request->config->get('enable_bookmarks')) {
					print "&nbsp;&nbsp;|&nbsp;&nbsp;";
				}
				if ($this->getVar('previous_id')) {
					print caNavLink($this->request, "&lsaquo; "._t("Previous"), '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('previous_id')), array('id' => 'previous'));
				}else{
					print "&lsaquo; "._t("Previous");
				}
				print "&nbsp;&nbsp;|&nbsp;&nbsp;{$vs_back_link}&nbsp;&nbsp;|&nbsp;&nbsp;";
				if ($this->getVar('next_id') > 0) {
					print caNavLink($this->request, _t("Next")." &rsaquo;", '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('next_id')), array('id' => 'next'));
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
	if($t_object->get("status") == 0){
		if ($t_rep && $t_rep->getPrimaryKey()) {
?>
				<div id="objDetailImage" style="float:left; margin-right:20px; margin-bottom:20px;">
<?php
				print $t_rep->getMediaTag('media', "preview", $this->getVar('primary_rep_display_options'));
				if($t_rep->get("image_credit_line")){
					# --- get width of image so caption matches
					$va_media_info = $t_rep->getMediaInfo('media', 'preview');
					print "<div class='objDetailImageCaption' style='width:".$va_media_info["WIDTH"]."px;'>";
					if($t_rep->get("image_credit_line")){
						print "<i>".$t_rep->get("image_credit_line")."</i>";
					}
					print " &ndash; &copy; INFGM</div>";
				}
?>
				</div><!-- end objDetailImage -->
<?php
				// set view vars for tooltip if there is an image
				if($t_rep->getMediaTag('media', "medium", $this->getVar('primary_rep_display_options'))){
					$this->setVar('tooltip_representation', $t_rep->getMediaTag('ca_object_representations.media', 'medium', $this->getVar('primary_rep_display_options')));
					TooltipManager::add(
						"#objDetailImage", $this->render('../Results/ca_objects_result_tooltip_html.php')
					);
				}
		}else{
			print "<div id='objDetailImagePlaceHolderSmall' style='float:left; margin-right:20px; margin-bottom:20px;'><!-- empty --></div>";
		}
?>
	<div>
		<div class="pendingInfo">
<?php
			if($t_object->get('ca_objects.idno')){
				print "<div class='unit'><b>".$t_object->get('ca_objects.idno')."</b></div>";
			}
			print "<H2>";
			# --- identifier
			if($this->getVar('label')){
				print $this->getVar('label');
			}
			# --- secondary and tertiary titles
			$va_secondary_titles = $t_object->getNonPreferredLabels(null, false, array("restrict_to_types" => array("secondary"), "extractValuesByUserLocale" => true, "forDisplay" => true));
			if(is_array($va_secondary_titles) && (sizeof($va_secondary_titles) > 0)){
				foreach($va_secondary_titles as $vs_secondary_title){
					print "<div class='alternateTitle'>".$vs_secondary_title."</div>";
				}
			}
			$va_tertiary_titles = $t_object->getNonPreferredLabels(null, false, array("restrict_to_types" => array("tertiary"), "extractValuesByUserLocale" => true, "forDisplay" => true));
			if(is_array($va_tertiary_titles) && (sizeof($va_tertiary_titles) > 0)){
				foreach($va_tertiary_titles as $vs_tertiary_title){
					print "<div class='alternateTitle'>".$vs_tertiary_title."</div>";
				}
			}
			print "</H2>";
			if($t_object->get("ca_objects.date.display_date") || $t_object->get("ca_objects.technique")){
				print "<div class='unit'>";
				if($t_object->get("ca_objects.date.display_date")){
					# --- get the start date to link the date to the chronology
					$va_date_info = array_pop($t_object->get("ca_objects.date.parsed_date", array("rawDate" => true, "returnAsArray" => true)));
					if($vn_start_date = intval($va_date_info["start"])){
						print caNavLink($this->request, ($t_object->get("ca_objects.date.display_date")), '', 'Chronology', 'Detail', '', array('year' => $vn_start_date))."<br/>";
					}else{
						print ($t_object->get("ca_objects.date.display_date"))."<br/>";
					}
				}
				if($t_object->get("ca_objects.technique")){
					print $t_object->get("ca_objects.technique");
				}
				print "</div><!-- end unit -->";
			}
			if($t_object->get("ca_objects.description")){
				print "<div class='unit'>";
				print $t_object->get("ca_objects.description", array('convertLineBreaks' => true));
				print "</div><!-- end unit -->";
			}
			print "<div class='unit'><a href='#' onclick='researchPendingPanel.showPanel(\"".caNavUrl($this->request, '', 'About', 'ResearchPendingArtwork')."\"); return false;' ><i>"._t("Research pending*")."</i></a></div><!-- end unit -->";
?>
		</div>	
<?php
			# --- output related object images as links
			$va_related_objects = $t_object->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if (sizeof($va_related_objects)) {
				print "<div class='unit' style='clear:both;'><H3 style='margin-bottom:8px;'>"._t("Associated Artworks")."</H3>";
				$va_rel_objs_by_type = array();
				$va_related_objs = array();
	            $t_rel_types = new ca_relationship_types();
				$va_related_rel_type_ids = array($t_rel_types->getRelationshipTypeID('ca_objects_x_objects', 'related'), $t_rel_types->getRelationshipTypeID('ca_objects_x_objects', 'related_edition'), $t_rel_types->getRelationshipTypeID('ca_objects_x_objects', 'related_version'), $t_rel_types->getRelationshipTypeID('ca_objects_x_objects', 'related_element'));
				
				foreach($va_related_objects as $vn_rel_id => $va_info){
					# --- grab objects with type related works, related editions, related elements or related versions and put in separate array - will merge them later so related works appear last in list of related objects
					if(in_array($va_info['relationship_type_id'], $va_related_rel_type_ids)){
						$va_related_objs[$va_info['relationship_typename']][$vn_rel_id] = $va_info;
					}else{
						$va_rel_objs_by_type[$va_info['relationship_typename']][$vn_rel_id] = $va_info;
					}
				}
				if(sizeof($va_related_objs) > 0){
					$va_rel_objs_by_type = array_merge($va_rel_objs_by_type, $va_related_objs);
				}
				$t_rel_object = new ca_objects();
				foreach($va_rel_objs_by_type as $vs_relationship_typename => $va_rel_obj_by_type){
					$i = 0;
					if(($vs_relationship_typename == "Study") && (sizeof($va_rel_obj_by_type) > 1)){
						print "<H3 style='clear:left;'>Studies</H3>";
					}else{
						print "<H3 style='clear:left;'>".$vs_relationship_typename.((sizeof($va_rel_obj_by_type) > 1) ? "s" : "")."</H3>";
					}
					foreach($va_rel_obj_by_type as $vn_rel_id => $va_info){
						if($i == $vn_num_more_link){
							print "<div id='artworkMore".str_replace(" ", "_", $vs_relationship_typename)."' class='relatedMoreItems'>";
						}
						$vn_rel_object_id = $va_info['object_id'];
						$t_rel_object->load($vn_rel_object_id);
						print "<div id='relArtwork".$vn_rel_object_id."'  class='relArtwork' ".(((($i/2) - floor($i/2)) == 0) ? "style='clear:left;'" : "").">";
						$va_rep = array();
						$vs_rep = "";
						if($t_rel_object->getPrimaryRepresentation(array('tiny'), null, array('return_with_access' => $va_access_values))){
							$va_rep = $t_rel_object->getPrimaryRepresentation(array('tiny'), null, array('return_with_access' => $va_access_values));
							$vs_rep = $va_rep["tags"]["tiny"];
							print "<div class='relArtworkImage' id='relArtworkImage".$vn_rel_object_id."'>".caNavLink($this->request, $vs_rep, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id))."</div>";
						}else{
							print "<div class='relArtworkImagePlaceHolder'><!-- empty --></div>";
						}
						print "<div>";
						if($t_rel_object->get("ca_objects.idno")){
							print "<span class='resultidno'>".trim($t_rel_object->get("ca_objects.idno"))."</span><br/>";
						}
						if($this->request->config->get('allow_detail_for_ca_objects')){
							print caNavLink($this->request, "<i>".$va_info['label']."</i>", '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id))."<br/>";
						}else{
							print "<i>".$va_info['label']."</i><br/>";
						}
						
						if($t_rel_object->get("ca_objects.date.display_date")){
							print $t_rel_object->get("ca_objects.date.display_date")."<br/>";
						}
						if($t_rel_object->get("ca_objects.technique")){
							print $t_rel_object->get("ca_objects.technique");
						}
						#print " (".unicode_ucfirst($va_info['relationship_typename']).")";
						print "</div></div>";
						// set view vars for tooltip
						
						$va_rep = $t_rel_object->getPrimaryRepresentation(array('small'), null, array('return_with_access' => $va_access_values));
						if($va_rep['tags']['small']){
							$this->setVar('tooltip_representation', $va_rep['tags']['small']);
							TooltipManager::add(
								"#relArtworkImage{$vn_rel_object_id}", $this->render('../Results/ca_objects_result_tooltip_html.php')
							);
						}
						$i++;
						
					}
					if($i > $vn_num_more_link){
						print "</div>";
						print "<div class='moreLink'><a href='#' id='artworkMoreLink".str_replace(" ", "_", $vs_relationship_typename)."' onclick='jQuery(\"#artworkMore".str_replace(" ", "_", $vs_relationship_typename)."\").slideDown(250); jQuery(\"#artworkMoreLink".str_replace(" ", "_", $vs_relationship_typename)."\").hide(); return false;'>".(sizeof($va_rel_obj_by_type) - $vn_num_more_link)._t(" More like this")." &rsaquo;</a></div>";
					}
				}
				print "</div><!-- end unit -->";
			}
?>
		</div>
<?php
	}else{
	# ---------------------------------------------------
	# --- DISPLAY FULL INFO
	# ---------------------------------------------------
?>
		
		<div id="rightCol">
<?php
		if ($t_rep && $t_rep->getPrimaryKey()) {
?>
				<div id="objDetailImage">
<?php
				if($va_display_options['no_overlay']){
					print $t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'));
				}else{
					#print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetObjectMediaOverlay', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >".$t_rep->getMediaTag('media', $vs_display_version, $this->getVar('primary_rep_display_options'))."</a>";
					$va_opts = array('display' => 'detail', 'object_id' => $vn_object_id, 'containerID' => 'cont');
					print "<div id='cont'>".$t_rep->getRepresentationViewerHTMLBundle($this->request, $va_opts)."</div>";
				}
?>
				</div><!-- end objDetailImage -->
<?php
				// if($t_rep->get("image_credit_line")){
// 					# --- get width of image so caption matches
// 					$va_media_info = $t_rep->getMediaInfo('media', $vs_display_version);
// 					print "<div class='objDetailImageCaption' style='width:".$va_media_info["WIDTH"]."px'>";
// 					if($t_rep->get("image_credit_line")){
// 						print "<i>".$t_rep->get("image_credit_line")."</i>";
// 					}
// 					print " &ndash; &copy; INFGM</div>";
// 				}
?>
				<div id="objDetailImageNav">
<?php					
					#print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetObjectMediaOverlay', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >".(($vn_num_reps > 1) ? _t("Zoom/more media") : _t("Zoom"))." +</a>";
						
					print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'Object', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >".(($vn_num_reps > 1) ? _t("Zoom/more media") : _t("Zoom"))." +</a>";

?>		
				</div><!-- end objDetailImageNav -->
<?php
		}else{
			print "<div id='objDetailImagePlaceHolder'><!-- empty --></div>";
		}
?>
		</div><!-- end rightCol -->
		<div>
<?php
			if($t_object->get('ca_objects.idno')){
				print "<div class='unit'><b>".$t_object->get('ca_objects.idno')."</b></div>";
			}
			print "<H2>";
			# --- identifier
			if($this->getVar('label')){
				print $this->getVar('label');
			}
			# --- secondary and tertiary titles
			$va_secondary_titles = $t_object->getNonPreferredLabels(null, false, array("restrict_to_types" => array("secondary"), "extractValuesByUserLocale" => true, "forDisplay" => true));
			if(is_array($va_secondary_titles) && (sizeof($va_secondary_titles) > 0)){
				foreach($va_secondary_titles as $vs_secondary_title){
					print "<div class='alternateTitle'>".$vs_secondary_title."</div>";
				}
			}
			$va_tertiary_titles = $t_object->getNonPreferredLabels(null, false, array("restrict_to_types" => array("tertiary"), "extractValuesByUserLocale" => true, "forDisplay" => true));
			if(is_array($va_tertiary_titles) && (sizeof($va_tertiary_titles) > 0)){
				foreach($va_tertiary_titles as $vs_tertiary_title){
					print "<div class='alternateTitle'>".$vs_tertiary_title."</div>";
				}
			}
			print "</H2>";
			print "<div class='unit'>";
			if($t_object->get("ca_objects.date.display_date")){
				# --- get the start date to link the date to the chronology
				$va_date_info = array_pop($t_object->get("ca_objects.date.parsed_date", array("rawDate" => true, "returnAsArray" => true)));
				if($vn_start_date = intval($va_date_info["start"])){
					print caNavLink($this->request, ($t_object->get("ca_objects.date.display_date")), '', 'Chronology', 'Detail', '', array('year' => $vn_start_date));
					print "<br/>";
				}else{
					print ($t_object->get("ca_objects.date.display_date"))."<br/>";
				}
			}
			if($t_object->get("ca_objects.technique")){
				print ($t_object->get("ca_objects.technique"))."<br/>";
			}
			if($va_dimensions = $t_object->get("ca_objects.display_dimensions", array("returnAsArray" => true))){
				$va_dimensions_display = array();
				foreach($va_dimensions as $id => $va_dimension){
					$va_dimensions_display[] = $va_dimension["display_dimensions"];
				}
				print join("<br/>", $va_dimensions_display)."<br/>";
			}
			if($t_object->get("ca_objects.base")){
				print ($t_object->get("ca_objects.base"))."<br/>";
			}
			if($t_object->get("ca_objects.num_of_elements")){
				print ($t_object->get("ca_objects.num_of_elements"))."<br/>";
			}
			if($t_object->get("ca_objects.inscriptions")){
				print ($t_object->get("ca_objects.inscriptions"))."<br/>";
			}
			print "</div><!-- end unit -->";
			
			$va_entities = $t_object->get("ca_entities", array("exclude_relationship_types" => array('sitter'), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(($t_object->get("ca_objects.description")) || ($t_object->get("ca_objects.edition")) || (sizeof($va_entities) > 0)){
				print "<div class='unit'>";
				if($t_object->get("ca_objects.description")){
					print $t_object->get("ca_objects.description", array('convertLineBreaks' => true))."<br/>";
				}
				if($t_object->get("ca_objects.edition")){
					print ($t_object->get("ca_objects.edition"))."<br/>";
				}
				# --- entities
				if(sizeof($va_entities) > 0){	
					foreach($va_entities as $va_entity) {
?>
						<?php print ucfirst($va_entity['relationship_typename'])." ".$va_entity["displayname"]; ?><br/>
<?php
					}
				}
				print "</div><!-- end unit -->";
			}
			if($t_object->get("ca_objects.catalogue_notes")){
				print "<H3>Comments</H3><div class='unit'>";
				print $t_object->get("ca_objects.catalogue_notes", array('convertLineBreaks' => true));
				print "</div><!-- end unit -->";
			}
			if($t_object->get("ca_objects.current_collection")){
				print "<H3>Collection</H3><div class='unit'>";
				print $t_object->get("ca_objects.current_collection", array('convertLineBreaks' => true));
				print "</div><!-- end unit -->";
			}
			if($t_object->get("ca_objects.provenance")){
				print "<H3>Provenance</H3><div class='unit'>";
				print $t_object->get("ca_objects.provenance", array('convertLineBreaks' => true));
				print "</div><!-- end unit -->";
			}
			
			# --- occurrences
			$va_sorted_occurrences = array();
			$va_occurrences = $t_object->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'sort' => array('ca_occurrences.date.parsed_date')));
			if(sizeof($va_occurrences)){
				$t_occ = new ca_occurrences();
				$va_item_types = $t_occ->getTypeList();
				foreach($va_occurrences as $va_occurrence) {
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
					$va_sorted_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = array("label" => $va_occurrence['label'], "date" => $t_occ->get("ca_occurrences.date.display_date"), "year_published" => $t_occ->get("ca_occurrences.bib_year_published"), "venue" => $vs_venue, "bib_full_citation" => $t_occ->get("ca_occurrences.bib_full_citation"), "idno" => $t_occ->get("ca_occurrences.idno"), "source_info" => caUnserializeForDatabase($va_occurrence['source_info']), "status" => $t_occ->get("ca_occurrences.status"));
				}
				
				foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
					$vs_title = "";
					switch($va_item_types[$vn_occurrence_type_id]['idno']){
						case "bibliography":
							$vs_title = "Bibliography";
						break;
						# --------------------------------------
						case "exhibition":
							$vs_title = $va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : "");
						break;
						# --------------------------------------
					}
					if($vs_title){
?>
						<div class="unit"><H3><?php print $vs_title; ?></H3>
<?php
					}
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
								$va_source_info = $va_info["source_info"];
								if($va_info["status"] > 0){
									$va_illustration_info = array();
									$vs_illustration_info = "";
									if($va_source_info["page_number"]){
										$va_illustration_info[] = _t("p. ").$va_source_info["page_number"];
									}
									if($va_source_info["catalogue_number"]){
										$va_illustration_info[] = _t("no. ").$va_source_info["catalogue_number"];
									}
									if($va_source_info["figure_number"]){
										$va_illustration_info[] = _t("fig. ").$va_source_info["figure_number"];
									}
									$vs_illustration_info = implode(", ", $va_illustration_info);
									if($vs_illustration_info){
										$va_info['bib_full_citation'] = $va_info['bib_full_citation']." ".$vs_illustration_info.".";
									}
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
					# --- check for title becuase we're skipping chronology occ records
					if($vs_title){
						print "</div><!-- end unit -->";
					}
				}
			}
			# --- collections
			#$va_collections = $t_object->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			#if(sizeof($va_collections) > 0){
			#	print "<div class='unit'><H3>"._t("Collection").((sizeof($va_collections) > 1) ? "s" : "")."</H3>";
			#	$i = 0;
			#	foreach($va_collections as $va_collection_info){
			#		if($i == $vn_num_more_link){
			#			print "<div id='collectionMore' class='relatedMoreItems'>";
			#		}
			#		print "<div>";
			#		print (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." (".unicode_ucfirst($va_collection_info['relationship_typename']).")";
			#		print "</div>";
			#		$i++;
			#	}
			#	if($i > $vn_num_more_link){
			#		print "</div>";
			#		print "<div class='class='moreLink'><a href='#' id='collectionMoreLink' onclick='jQuery(\"#collectionMore\").slideDown(250); jQuery(\"#collectionMoreLink\").hide(); return false;'>".(sizeof($va_collections) - $vn_num_more_link)._t(" More like this")." &rsaquo;</a></div>";
			#	}
			#	print "</div><!-- end unit -->";
			#}
			
			# --- output related object images as links
			$va_related_objects = $t_object->get("ca_objects", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if (sizeof($va_related_objects)) {
				print "<div class='unit' style='clear:both;'><H3 style='margin-bottom:8px;'>"._t("Associated Artworks")."</H3>";
				$va_rel_objs_by_type = array();
				$va_related_objs = array();
	            $t_rel_types = new ca_relationship_types();
				$va_related_rel_type_ids = array($t_rel_types->getRelationshipTypeID('ca_objects_x_objects', 'related'), $t_rel_types->getRelationshipTypeID('ca_objects_x_objects', 'related_edition'), $t_rel_types->getRelationshipTypeID('ca_objects_x_objects', 'related_version'), $t_rel_types->getRelationshipTypeID('ca_objects_x_objects', 'related_element'));
				
				foreach($va_related_objects as $vn_rel_id => $va_info){
					# --- grab objects with type related works, related editions, related elements or related versions and put in separate array - will merge them later so related works appear last in list of related objects
					if(in_array($va_info['relationship_type_id'], $va_related_rel_type_ids)){
						$va_related_objs[$va_info['relationship_typename']][$vn_rel_id] = $va_info;
					}else{
						$va_rel_objs_by_type[$va_info['relationship_typename']][$vn_rel_id] = $va_info;
					}
				}
				if(sizeof($va_related_objs) > 0){
					$va_rel_objs_by_type = array_merge($va_rel_objs_by_type, $va_related_objs);
				}
				$t_rel_object = new ca_objects();
				foreach($va_rel_objs_by_type as $vs_relationship_typename => $va_rel_obj_by_type){
					$i = 0;
					if(($vs_relationship_typename == "Study") && (sizeof($va_rel_obj_by_type) > 1)){
						print "<H3 style='clear:left;'>Studies</H3>";
					}else{
						print "<H3 style='clear:left;'>".$vs_relationship_typename.((sizeof($va_rel_obj_by_type) > 1) ? "s" : "")."</H3>";
					}
					foreach($va_rel_obj_by_type as $vn_rel_id => $va_info){
						if($i == $vn_num_more_link){
							print "<div id='artworkMore".str_replace(" ", "_", $vs_relationship_typename)."' class='relatedMoreItems'>";
						}
						$vn_rel_object_id = $va_info['object_id'];
						$t_rel_object->load($vn_rel_object_id);
						print "<div id='relArtwork".$vn_rel_object_id."'  class='relArtwork' ".(((($i/2) - floor($i/2)) == 0) ? "style='clear:left;'" : "").">";
						$va_rep = array();
						$vs_rep = "";
						if($t_rel_object->getPrimaryRepresentation(array('tiny'), null, array('return_with_access' => $va_access_values))){
							$va_rep = $t_rel_object->getPrimaryRepresentation(array('tiny'), null, array('return_with_access' => $va_access_values));
							$vs_rep = $va_rep["tags"]["tiny"];
							print "<div class='relArtworkImage' id='relArtworkImage".$vn_rel_object_id."'>".caNavLink($this->request, $vs_rep, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id))."</div>";
						}else{
							print "<div class='relArtworkImagePlaceHolder'><!-- empty --></div>";
						}
						print "<div>";
						if($t_rel_object->get("ca_objects.idno")){
							print "<span class='resultidno'>".trim($t_rel_object->get("ca_objects.idno"))."</span><br/>";
						}
						if($this->request->config->get('allow_detail_for_ca_objects')){
							print caNavLink($this->request, "<i>".$va_info['label']."</i>", '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id))."<br/>";
						}else{
							print "<i>".$va_info['label']."</i><br/>";
						}
						
						if($t_rel_object->get("ca_objects.date.display_date")){
							print $t_rel_object->get("ca_objects.date.display_date")."<br/>";
						}
						if($t_rel_object->get("ca_objects.technique")){
							print $t_rel_object->get("ca_objects.technique");
						}
						#print " (".unicode_ucfirst($va_info['relationship_typename']).")";
						print "</div></div>";
						// set view vars for tooltip
						
						$va_rep = $t_rel_object->getPrimaryRepresentation(array('small'), null, array('return_with_access' => $va_access_values));
						if($va_rep['tags']['small']){
							$this->setVar('tooltip_representation', $va_rep['tags']['small']);
							TooltipManager::add(
								"#relArtworkImage{$vn_rel_object_id}", $this->render('../Results/ca_objects_result_tooltip_html.php')
							);
						}
						$i++;
						
					}
					if($i > $vn_num_more_link){
						print "</div>";
						print "<div class='moreLink'><a href='#' id='artworkMoreLink".str_replace(" ", "_", $vs_relationship_typename)."' onclick='jQuery(\"#artworkMore".str_replace(" ", "_", $vs_relationship_typename)."\").slideDown(250); jQuery(\"#artworkMoreLink".str_replace(" ", "_", $vs_relationship_typename)."\").hide(); return false;'>".(sizeof($va_rel_obj_by_type) - $vn_num_more_link)._t(" More like this")." &rsaquo;</a></div>";
					}
				}
				print "</div><!-- end unit -->";
			}
			print "<div style='clear:both; height:10px;'><!-- empty --></div>";
			
			if($t_object->get("ca_objects.published_on") || $t_object->get("ca_objects.last_updated_on")){
				print "<div class='unit' style='font-size:11px; color:#828282;'>";
				if($t_object->get("ca_objects.published_on")){
					print "<i>Published ".$t_object->get("ca_objects.published_on")."</i>";
				}
				if($t_object->get("ca_objects.published_on") != $t_object->get("ca_objects.last_updated_on")){
					if($t_object->get("ca_objects.published_on") && $t_object->get("ca_objects.last_updated_on")){
						print "<br/>";
					}
					if($t_object->get("ca_objects.last_updated_on")){
						print "<i>Last updated on ".$t_object->get("ca_objects.last_updated_on")."</i>";
					}
				}
				print "</div>";
			}
?>
		</div><!-- end leftCol-->
<?php
	}
?>
	</div><!-- end detailBody -->
