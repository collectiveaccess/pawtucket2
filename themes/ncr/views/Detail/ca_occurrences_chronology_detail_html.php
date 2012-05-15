<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_occurrences_chronology_detail_html.php : 
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
	
	$t_rel_types 		= $this->getVar('t_relationship_types');

if (!$this->request->isAjax()) {
?>
	<div id="detailBody">
		<div id="pageNav">
<?php
			print ResultContext::getResultsLinkForLastFind($this->request, 'ca_occurrences', "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_up_grey.gif' width='11' height='10' border='0'> "._t("BACK"), '');

			if (($this->getVar('next_id')) || ($this->getVar('previous_id'))) {	
				print "&nbsp;&nbsp;&nbsp;";
			}
			if ($this->getVar('previous_id')) {
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_grey_left.gif' width='10' height='10' border='0'> "._t("PREVIOUS"), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $this->getVar('previous_id')), array('id' => 'previous'));
			}
			if (($this->getVar('next_id')) && ($this->getVar('previous_id'))) {	
				print "&nbsp;&nbsp;|&nbsp;&nbsp;";
			}
			if ($this->getVar('next_id') > 0) {
				print caNavLink($this->request, _t("NEXT")." <img src='".$this->request->getThemeUrlPath()."/graphics/arrow_grey_right.gif' width='10' height='10' border='0'>", '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $this->getVar('next_id')), array('id' => 'next'));
			}
?>
		</div><!-- end nav -->
		<div id="leftCol">
<?php
			# --- identifier
			if($this->getVar('label')){
				print "<H2>".$this->getVar('label')."</H2>";
			}
			print "<div class='unit'>";
			if($this->getVar('idno')){
				print "<b>".$this->getVar('idno')."</b><br/>";
			}
			if($t_occurrence->getAttributesForDisplay("date")){
				print "<b>"._t("date").":</b> ".($t_occurrence->getAttributesForDisplay("date", "^display_date"))."<br/>";
			}
			
			print "</div><!-- end unit -->";
			
			if($t_occurrence->getAttributesForDisplay("event_text")){
				print "<H3>Event text</H3><div class='unit'>";
				print $t_occurrence->getAttributesForDisplay("event_text", null, array('convertLinkBreaks' => true));
				print "</div><!-- end unit -->";
			}


			# --- entities
			$va_entities = array();
			if(sizeof($this->getVar('entities'))){	

				$va_entity_rel_types = $t_rel_types->getRelationshipInfo('ca_entities_x_occurrences');
				$va_related_entities = array();
				
				foreach($this->getVar('entities') as $va_entity) {
					$va_related_entities[] = "<div>".$va_entity["label"]." (".unicode_ucfirst($va_entity_rel_types[$va_entity['relationship_type_id']]['typename_reverse']).")</div>";					
				}
				if(sizeof($va_related_entities) > 0){
?>
				<div class="unit"><H3><?php print _t("Related")." ".((sizeof($this->getVar('entities') > 1)) ? _t("Entities") : _t("Entity")); ?></H3>
<?php
					print implode($va_related_entities, "\n");
?>
				</div><!-- end unit -->
<?php

				}
			}
		
			# --- occurrences
			$va_occurrences = array();
			if(sizeof($this->getVar('occurrences'))){
				$t_occ = new ca_occurrences();
				$va_item_types = $t_occ->getTypeList();
				foreach($this->getVar('occurrences') as $va_occurrence) {
					$t_occ->load($va_occurrence['occurrence_id']);
					$vs_venue = "";
					$va_venues = array();
					$va_venues = $t_occ->getRelatedItemsForDisplay('ca_entities', array('restrict_to_relationship_types' => array('venue')));
					if(sizeof($va_venues) > 0){
						$va_venue_name = array();
						foreach($va_venues as $va_venue_info){
							$va_venue_name[] = $va_venue_info["displayname"];
						}
						$vs_venue = implode($va_venue_name, ", ");
					}
					$va_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = array("label" => $va_occurrence['label'], "date" => $t_occ->getAttributesForDisplay("date", '^display_date'), "year_published" => $t_occ->getAttributesForDisplay("bib_year_published "), "venue" => $vs_venue, "relationship_type_id" => $va_occurrence['relationship_type_id'], "bib_full_citation" => $t_occ->getAttributesForDisplay("bib_full_citation"));
				}
				
				$va_occ_rel_types = $t_rel_types->getRelationshipInfo('ca_objects_x_occurrences');
				foreach($va_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
?>
						<div class="unit"><H3><?php print $va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></H3>
<?php
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info){
						switch($va_item_types[$vn_occurrence_type_id]['idno']){
							case "exhibition":
								print "<div>- ";
								print (($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, "\"".$va_info['label']."\"", '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : "\"".$va_info["label"]."\"");
								if($va_info["venue"]){
									print ", ".$va_info["venue"];
								}
								if($va_info["date"]){
									print ", ".$va_info["date"];
								}
								print "</div>";

							break;
							# ------------------------------
							case "bibliography":
								print "<div>- ";
								print (($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info['bib_full_citation'], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["bib_full_citation"]);
								print "</div>";

							break;
							# ------------------------------
							default:
?>
								<div><?php print (($this->request->config->get('allow_detail_for_ca_occurrences')) ? caNavLink($this->request, $va_info['label'], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_rel_occurrence_id)) : $va_info["label"]); ?></div>
<?php							break;
							# ------------------------------
						}
					

					}
					print "</div><!-- end unit -->";
				}
			}
			# --- places
			if($this->getVar('places')){
				print "<div class='unit'><H3>"._t("Related Place").((sizeof($this->getVar('places')) > 1) ? "s" : "")."</H3>";
				$va_place_rel_types = $t_rel_types->getRelationshipInfo('ca_places_x_occurrences');
				foreach($this->getVar('places') as $va_place_info){
					print "<div>";
					print (($this->request->config->get('allow_detail_for_ca_places')) ? caNavLink($this->request, $va_place_info['label'], '', 'Detail', 'Place', 'Show', array('place_id' => $va_place_info['place_id'])) : $va_place_info['label'])." (".unicode_ucfirst($va_place_rel_types[$va_place_info['relationship_type_id']]['typename']).")";
					print "</div>";
				}
				print "</div><!-- end unit -->";
			}
			# --- collections
			if($this->getVar('collections')){
				print "<div class='unit'><H3>"._t("Related Collection").((sizeof($this->getVar('collections')) > 1) ? "s" : "")."</H3>";
				$va_collection_rel_types = $t_rel_types->getRelationshipInfo('ca_occurrences_x_collections');
				foreach($this->getVar('collections') as $va_collection_info){
					print "<div>";
					print (($this->request->config->get('allow_detail_for_ca_collections')) ? caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id'])) : $va_collection_info['label'])." (".unicode_ucfirst($va_collection_rel_types[$va_collection_info['relationship_type_id']]['typename']).")";
					print "</div>";
				}
				print "</div><!-- end unit -->";
			}
			
			# --- output related object images as links
			$qr_hits = $this->getVar('browse_results');
			if($qr_hits->numHits() > 0){
				print "<div class='unit'><H3>"._t("Related Artworks")."</H3>";
				while($qr_hits->nextHit()){
					
					# --- gather caption info for tooltip
					$va_caption = array();
					$vn_rel_object_id = $qr_hits->get("object_id");
					print "<div id='relArtwork".$vn_rel_object_id."'>- ";
					if($qr_hits->get("ca_objects.idno")){
						print "<b>".trim($qr_hits->get("ca_objects.idno"))."</b>, ";
						$va_caption[] = "<b>".trim($qr_hits->get("ca_objects.idno"))."</b>";
					}
					$va_labels = $qr_hits->getDisplayLabels($this->request);
					$vs_title = join('; ', $va_labels);
					if($this->request->config->get('allow_detail_for_ca_objects')){
						print caNavLink($this->request, "<i>".$vs_title."</i>", '', 'Detail', 'Object', 'Show', array('object_id' => $vn_rel_object_id)).", ";
					}else{
						print "<i>".$vs_title."</i>, ";
					}
					$va_caption[] = "<i>".$vs_title."</i>";
					if($qr_hits->get("ca_objects.date")){
						print $qr_hits->get("ca_objects.date").", ";
						$va_caption[] = $qr_hits->get("ca_objects.date");
					}
					if($qr_hits->get("ca_objects.technique")){
						print $qr_hits->get("ca_objects.technique");
						$va_caption[] = $qr_hits->get("ca_objects.technique");
					}
					print "</div>";
					// set view vars for tooltip
					
					$vs_caption = join(', ', $va_caption);
					$this->setVar('tooltip_representation', $qr_hits->getMediaTag('ca_object_representations.media','small'));
					$this->setVar('tooltip_title', $vs_caption);
					TooltipManager::add(
						"#relArtwork{$vn_rel_object_id}", $this->render('../Results/ca_objects_result_tooltip_html.php')
					);		
				}
				print "</div><!-- end unit -->";
			}

?>
	</div><!-- end leftCol -->
			
	<div id="rightCol">
<?php
	# --- need to figure out what images should be displayed here....
?>

	</div><!-- end rightCol -->
</div><!-- end detailBody -->
<?php
}
?>