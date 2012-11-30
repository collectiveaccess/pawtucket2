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

	if($t_occurrence->get("status") != 0){	
		# --- check for images of the exhibitions
		$va_exhibition_images = array_slice($t_occurrence->get("ca_objects", array('restrict_to_relationship_types' => array('describes'), "returnAsArray" => 1, 'checkAccess' => $va_access_values)), 0, 9);
		if(sizeof($va_exhibition_images) > 0){
			$vn_exhibition_image_id = "";
			$va_reps = array();
			foreach($va_exhibition_images as $vn_rel_id => $va_info){
				$vn_exhibition_image_id = $va_info["object_id"];
				$t_image_object = new ca_objects($vn_exhibition_image_id);
				if($t_rep = $t_image_object->getPrimaryRepresentationInstance()) {
					if (!sizeof($va_access_values) || in_array($t_rep->get('access'), $va_access_values)) {
						# --- build array of thumbnails on related images for display under main image
						$va_temp = array();
						
						$va_temp["representation_id"] = $t_rep->get("representation_id");
						$va_temp["rep_tinyicon"] = $t_rep->getMediaTag('media', 'tinyicon');
						$va_temp["object_id"] = $va_info["object_id"];
						$va_reps[$va_info["object_id"]] = $va_temp;
						
						# Media representations to display (objects only)
						if (!$vn_first_rep_set){
							$vn_first_rep_set = 1;
							$va_rep_display_info = caGetMediaDisplayInfo('detail', $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
								
							$vs_display_version = $va_rep_display_info['display_version'];
							unset($va_display_info['display_version']);
							$va_rep_display_info['poster_frame_url'] = $t_rep->getMediaUrl('media', $va_rep_display_info['poster_frame_version']);
							unset($va_display_info['poster_frame_version']);
							$va_display_options = $va_rep_display_info;
							$vs_display_rep = $t_rep->getMediaTag('media', $vs_display_version, $va_display_options);
							$vn_display_rep_id = $t_rep->get("representation_id");
							$vn_display_object_id = $va_info["object_id"];
							$vn_display_caption = $t_rep->get("image_credit_line");
							$va_display_media_info = $t_rep->getMediaInfo('media', $vs_display_version);
							$vn_display_media_width = $va_display_media_info["WIDTH"];
						}
					}
				}
			}
		}
	}

if (!$this->request->isAjax()) {
?>
<div id="pageHeading"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/t_exhibitions.gif' width='129' height='23' border='0'></div><!-- end pageHeading -->
	<div id="detailBody">
		<div id="pageNav">
<?php
			if(($t_occurrence->get("status") != 0) && ($t_rep && $t_rep->getPrimaryKey()) && !$this->request->config->get('disable_my_collections')){
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("Add to Lightbox +"), '', '', 'Sets', 'addItem', array('object_id' => $vn_display_object_id));
				}else{
					print caNavLink($this->request, _t("Add to Lightbox +"), '', '', 'LoginReg', 'form', array('site_last_page' => 'Sets', 'object_id' => $vn_display_object_id));
				}
				if ($this->request->config->get('enable_bookmarks')) {
					print "&nbsp;&nbsp;|&nbsp;&nbsp;";
				}
			}
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
		print "<H2>";
		if($this->getVar('label')){
			print $this->getVar('label');
		}
		if($va_primary_venue = $t_occurrence->get('ca_entities', array('restrict_to_relationship_types' => array('primary_venue'), "returnAsArray" => 1, 'checkAccess' => $va_access_values))){
			$va_primary_venue_name = array();
			foreach($va_primary_venue as $vn_relation_id => $va_primary_venue_info){
				$va_entities_output[] = $va_primary_venue_info["relation_id"];
				$va_primary_venue_name[] = $va_primary_venue_info["displayname"];
				$vn_venue_entity_id = $va_primary_venue_info["entity_id"];
			}
			print "<div class='subtitle'>".implode($va_primary_venue_name, ", ")."</div><!-- end subtitle -->";
		}
		if($vn_venue_entity_id){
			$t_venue = new ca_entities($vn_venue_entity_id);
			if($va_primary_venue_location = $t_venue->get('ca_places', array('restrict_to_relationship_types' => array('location'), "returnAsArray" => 1, 'checkAccess' => $va_access_values))){
				$va_primary_venue_location_name = array();
				foreach($va_primary_venue_location as $vn_relation_id => $va_primary_venue_location_info){
					$t_place = new ca_places($va_primary_venue_location_info["place_id"]);
					$va_primary_venue_location_name[] = $t_place->getLabelForDisplay();
					if($t_place->get('ca_places.parent.preferred_labels')){
						$va_primary_venue_location_name[] = $t_place->get('ca_places.parent.preferred_labels');
					}
					#$va_primary_venue_location_name[] = $va_primary_venue_location_info["name"];
				}
				print "<div class='subsubtitle'>".implode($va_primary_venue_location_name, ", ")."</div><!-- end subsubtitle -->";
			}
		}
		if($t_occurrence->get("ca_occurrences.date.display_date")){
			$va_date_info = array_pop($t_occurrence->get("ca_occurrences.date.parsed_date", array("rawDate" => true, "returnAsArray" => true)));
			if(($vn_start_date = intval($va_date_info["start"])) && ($vn_start_date >= 1904) && ($vn_start_date <= 1988)){
				print "<div class='subsubtitle'>".caNavLink($this->request, ($t_occurrence->get("ca_occurrences.date.display_date")), '', 'Chronology', 'Detail', '', array('year' => $vn_start_date))."</div>";
			}else{
				print "<div class='subsubtitle'>".$t_occurrence->get("ca_occurrences.date.display_date")."</div>";
			}
		}
		print "</H2>";

		print "<div class='unit'><a href='#' onclick='researchPendingPanel.showPanel(\"".caNavUrl($this->request, '', 'About', 'ResearchPendingExhibition')."\"); return false;' ><i>"._t("Research pending*")."</i></a></div><!-- end unit -->";
?>	
	</div>
<?php
	}else{
	# ---------------------------------------------------
	# --- DISPLAY FULL INFO
	# ---------------------------------------------------
		if ($vn_display_rep_id) {		
?>
			<div id="rightCol">
				<div id="objDetailImage">
<?php
				print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'OccurrenceMediaOverlay', 'GetOccurrenceMediaOverlay', array('occurrence_id' => $vn_occurrence_id, 'object_id' => $vn_display_object_id, 'representation_id' => $vn_display_rep_id))."\"); return false;' >".$vs_display_rep."</a>";
				if($vn_display_caption){
					if($vn_display_media_width){
						print "<div class='objDetailImageCaption' style='width:".$vn_display_media_width."px'>";
					}else{
						print "<div class='objDetailImageCaption'>";
					}
					print "<i>".$vn_display_caption."</i>";
					print " &ndash; &copy; INFGM</div>";
				}
				if(sizeof($va_reps) > 1){
					print "<div class='objDetailImageThumbs'>";
					$i = 1;
					foreach($va_reps as $vn_object_id => $va_rep){
						if(($vn_display_rep_id != $va_rep["representation_id"]) && ($i < 9)){
							print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'OccurrenceMediaOverlay', 'GetOccurrenceMediaOverlay', array('occurrence_id' => $vn_occurrence_id, 'object_id' => $vn_object_id, 'representation_id' => $va_rep["representation_id"]))."\"); return false;' >".$va_rep['rep_tinyicon']."</a>";
							$i++;
						}
					}
					print "</div>";
				}
?>
				</div><!-- end objDetailImage -->
			</div><!-- end rightCol -->
<?php
		}
?>
		<div>	
<?php
			$va_entities_output = array();
			print "<H2>";
			if($this->getVar('label')){
				print $this->getVar('label');
			}
			if($va_primary_venue = $t_occurrence->get('ca_entities', array('restrict_to_relationship_types' => array('primary_venue'), "returnAsArray" => 1, 'checkAccess' => $va_access_values))){
				$va_primary_venue_name = array();
				foreach($va_primary_venue as $vn_relation_id => $va_primary_venue_info){
					$va_entities_output[] = $va_primary_venue_info["relation_id"];
					$va_primary_venue_name[] = $va_primary_venue_info["displayname"];
					$vn_venue_entity_id = $va_primary_venue_info["entity_id"];
				}
				print "<div class='subtitle'>".implode($va_primary_venue_name, ", ")."</div><!-- end subtitle -->";
			}			
			if($vn_venue_entity_id){
				$t_venue = new ca_entities($vn_venue_entity_id);
				if($va_primary_venue_location = $t_venue->get('ca_places', array('restrict_to_relationship_types' => array('location'), "returnAsArray" => 1, 'checkAccess' => $va_access_values))){
					$va_primary_venue_location_name = array();
					foreach($va_primary_venue_location as $vn_relation_id => $va_primary_venue_location_info){
						$t_place = new ca_places($va_primary_venue_location_info["place_id"]);
						$va_primary_venue_location_name[] = $t_place->getLabelForDisplay();
						if($t_place->get('ca_places.parent.preferred_labels')){
							$va_primary_venue_location_name[] = $t_place->get('ca_places.parent.preferred_labels');
						}
						#$va_primary_venue_location_name[] = $va_primary_venue_location_info["name"];
					}
					print "<div class='subsubtitle'>".implode($va_primary_venue_location_name, ", ")."</div><!-- end subsubtitle -->";
				}
			}
			if($t_occurrence->get("ca_occurrences.date.display_date")){
				$va_date_info = array_pop($t_occurrence->get("ca_occurrences.date.parsed_date", array("rawDate" => true, "returnAsArray" => true)));
				if(($vn_start_date = intval($va_date_info["start"])) && ($vn_start_date >= 1904) && ($vn_start_date <= 1988)){
					print "<div class='subsubtitle'>".caNavLink($this->request, ($t_occurrence->get("ca_occurrences.date.display_date")), '', 'Chronology', 'Detail', '', array('year' => $vn_start_date))."</div>";
				}else{
					print "<div class='subsubtitle'>".$t_occurrence->get("ca_occurrences.date.display_date")."</div>";
				}
			}
			print "</H2>";
			if($va_curator = $t_occurrence->get('ca_entities', array('restrict_to_relationship_types' => array('curator'), "returnAsArray" => 1, 'checkAccess' => $va_access_values))){
				$va_curator_name = array();
				foreach($va_curator as $vn_relation_id => $va_curator_info){
					$va_entities_output[] = $va_curator_info["relation_id"];
					$va_curator_name[] = $va_curator_info["displayname"];
				}
				print "<div class='unit'>"._t("Curated by")." ".implode($va_curator_name, ", ")."</div><!-- end unit -->";
			}
			if($t_occurrence->get("ca_occurrences.publication")){
				print "<div class='unit'><b>"._t("available for publication").":</b> ".$t_occurrence->get("ca_occurrences.publication")."</div><!-- end unit -->";
			}
			if($va_venue = $t_occurrence->get('ca_entities', array('restrict_to_relationship_types' => array('travel_venue'), "returnAsArray" => 1, 'checkAccess' => $va_access_values))){
				print "<H3>".((sizeof($va_venue) > 1) ? _t("Travel venues") : _t("Travel venue"))."</H3>";
				print "<div class='unit'>";
				$va_venues = array();
				foreach($va_venue as $vn_relation_id => $va_venue_info){
					$va_entities_output[] = $va_venue_info["relation_id"];
					$vs_travel_venue_temp = "";
					$vs_travel_venue_temp = $va_venue_info["displayname"];
					if($va_venue_info["effective_date"]){
						$vs_travel_venue_temp .= ", ".$va_venue_info["effective_date"];
					}
					$va_venues[] = $vs_travel_venue_temp;
				}
				print implode($va_venues, "<br/>");
				print "</div><!-- end unit -->";
			}
			# --- other artists in exhibition
			if($va_artists = $t_occurrence->get('ca_entities', array('restrict_to_relationship_types' => array('artist'), "returnAsArray" => 1, 'checkAccess' => $va_access_values))){
				print "<H3>"._t("Group exhibition with")."</H3><div class='unit'>";
				$va_artists_display = array();
				foreach($va_artists as $vn_relation_id => $va_artist_info){
					$va_entities_output[] = $va_artist_info["relation_id"];
					$va_artists_display[] = $va_artist_info["displayname"];
				}
				print join(", ", $va_artists_display);
				print "</div><!-- end unit -->";
			}
			
			
			# --- entities - displayed by type
			$va_entities = $t_occurrence->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if(sizeof($va_entities)){	
				print "<div class='unit'>";
				$va_related_entities = array();
				foreach($va_entities as $va_entity) {
					if(!in_array($va_entity["relation_id"], $va_entities_output)){
						$va_related_entities[$va_entity["relationship_typename"]][] = $va_entity["displayname"];
					}
				}
				if(sizeof($va_related_entities) > 0){
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
				}
				print "</div><!-- end unit -->";
			}
			if(trim($t_occurrence->get("ca_occurrences.internal_notes"))){
				print "<H3>Comments</H3><div class='unit'>";
				print $t_occurrence->get("ca_occurrences.internal_notes", null, array('convertLinkBreaks' => true));
				print "</div><!-- end unit -->";
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
			
// 			# --- related documents
// 			$va_documents = $t_occurrence->get("ca_objects", array('restrict_to_relationship_types' => array('describes'), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
// 			if(sizeof($va_documents) > 0){
// 				$t_rel_object = new ca_objects();
// 				print "<div class='unit'><H3>"._t("Related Document").((sizeof($va_documents) > 1) ? "s" : "")."</H3>";
// 				$i = 0;
// 				foreach($va_documents as $vn_rel_id => $va_info){
// 					if($i == $vn_num_more_link){
// 						print "<div id='docMore' class='relatedMoreItems'>";
// 					}
// 					$vn_rel_object_id = $va_info['object_id'];
// 					$t_rel_object->load($vn_rel_object_id);
// 					print "<div id='relObject".$vn_rel_object_id."'>- ";
// 					if($t_rel_object->get("ca_objects.idno")){
// 						print "<b>".trim($t_rel_object->get("ca_objects.idno"))."</b>, ";
// 					}
// 					if($this->request->config->get('allow_detail_for_ca_objects')){
// 						print caNavLink($this->request, "<i>".$va_info['label']."</i>", '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id)).", ";
// 					}else{
// 						print "<i>".$va_info['label']."</i>, ";
// 					}
// 					if($t_rel_object->get("ca_objects.date.display_date")){
// 						print $t_rel_object->get("ca_objects.date.display_date");
// 					}
// 					print "</div>";
// 					// set view vars for tooltip
// 					
// 					$va_rep = $t_rel_object->getPrimaryRepresentation(array("small"));
// 					$this->setVar('tooltip_representation', $va_rep['tags']['small']);
// 					if($va_rep['tags']['small']){
// 						TooltipManager::add(
// 							"#relObject{$vn_rel_object_id}", $this->render('../Results/ca_objects_result_tooltip_html.php')
// 						);
// 					}					
// 					$i++;
// 				}
// 				if($i > $vn_num_more_link){
// 					print "</div>";
// 					print "<div class='moreLink'><a href='#' id='docMoreLink' onclick='jQuery(\"#docMore\").slideDown(250); jQuery(\"#docMoreLink\").hide(); return false;'>".(sizeof($va_documents) - $vn_num_more_link)._t(" More like this")." &rsaquo;</a></div>";
// 				}
// 				print "</div><!-- end unit -->";
// 			}
			
// 			# --- output related object images as links
// 			$qr_hits = $this->getVar('browse_results');
// 			if($qr_hits->numHits() > 0){
// 				if($qr_hits->numHits() > 1){
// 					$vs_title = _t("Artworks Included (%1 artworks)", $qr_hits->numHits());
// 				}else{
// 					$vs_title = _t("Artwork Included");
// 				}
// 				print "<div class='unit' style='clear:right;'><H3>".$vs_title."</H3>";
// 				$i = 0;
// 				while($qr_hits->nextHit()){
// 					if($i == $vn_num_more_link){
// 						print "<div id='artworkMore' class='relatedMoreItems'>";
// 					}
// 					$vn_rel_object_id = $qr_hits->get("object_id");
// 					print "<div id='relArtwork".$vn_rel_object_id."'  class='relArtwork' ".(((($i/2) - floor($i/2)) == 0) ? "style='clear:left;'" : "").">";
// 					if($qr_hits->getMediaTag('ca_object_representations.media', 'tiny', array('checkAccess' => $va_access_values))){
// 						if($this->request->config->get('allow_detail_for_ca_objects')){
// 							print "<div class='relArtworkImage'>".caNavLink($this->request, $qr_hits->getMediaTag('ca_object_representations.media', 'tiny', array('checkAccess' => $va_access_values)), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id))."</div>";
// 						}else{
// 							print "<div class='relArtworkImage'>".$qr_hits->getMediaTag('ca_object_representations.media', 'tiny', array('checkAccess' => $va_access_values))."</div>";
// 						}
// 					}else{
// 						print "<div class='relArtworkImagePlaceHolder'><!-- empty --></div>";
// 					}
// 					print "<div>";
// 					if($qr_hits->get("ca_objects.idno")){
// 						print "<span class='resultidno'>".trim($qr_hits->get("ca_objects.idno"))."</span><br/>";
// 					}
// 					$va_labels = $qr_hits->getDisplayLabels($this->request);
// 					$vs_title = join('; ', $va_labels);
// 					if($this->request->config->get('allow_detail_for_ca_objects')){
// 						print caNavLink($this->request, "<i>".$vs_title."</i>", '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id))."<br/>";
// 					}else{
// 						print "<i>".$vs_title."</i><br/>";
// 					}
// 					if($qr_hits->get("ca_objects.date.display_date")){
// 						print $qr_hits->get("ca_objects.date.display_date")."<br/>";
// 					}
// 					if($qr_hits->get("ca_objects.technique")){
// 						print $qr_hits->get("ca_objects.technique");
// 					}
// 					print "</div><div style='clear:left;'><!-- empty --></div></div>";
// 					// set view vars for tooltip
// 					
// 					$vs_tooltip_image = $qr_hits->getMediaTag('ca_object_representations.media', 'small', array('checkAccess' => $va_access_values));
// 					if($vs_tooltip_image){
// 						$this->setVar('tooltip_representation', $vs_tooltip_image);
// 						TooltipManager::add(
// 							"#relArtwork{$vn_rel_object_id}", $this->render('../Results/ca_objects_result_tooltip_html.php')
// 						);
// 					}
// 					$i++;
// 				}
// 				if($i > $vn_num_more_link){
// 					print "</div>";
// 					print "<div class='moreLink'><a href='#' id='artworkMoreLink' onclick='jQuery(\"#artworkMore\").slideDown(250); jQuery(\"#artworkMoreLink\").hide(); return false;'>".($qr_hits->numHits() - $vn_num_more_link)._t(" More like this")." &rsaquo;</a></div>";
// 				}
// 				print "</div><!-- end unit -->";
// 			}
			# --- output related object images as links
			$va_related_artworks = $t_occurrence->get("ca_objects", array("restrict_to_relationship_types" => array("part"), "returnAsArray" => 1, 'checkAccess' => $va_access_values));
			if (sizeof($va_related_artworks)) {
				print "<div class='unit' style='clear:right;'><H3>"._t("Checklist of Artworks")."</H3>";
				$t_rel_object = new ca_objects();
				$i = 0;
				foreach($va_related_artworks as $vn_rel_id => $va_info){
					if($i == $vn_num_more_link){
						print "<div id='artworkMore' class='relatedMoreItems'>";
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
					print "<div class='moreLink'><a href='#' id='artworkMoreLink' onclick='jQuery(\"#artworkMore\").slideDown(250); jQuery(\"#artworkMoreLink\").hide(); return false;'>".(sizeof($va_related_artworks) - $vn_num_more_link)._t(" More like this")." &rsaquo;</a></div>";
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