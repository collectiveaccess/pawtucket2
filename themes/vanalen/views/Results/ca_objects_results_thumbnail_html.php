<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ca_objects_thumbnail_html.php :
 * 		thumbnail search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2009 Whirl-i-Gig
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
 
 	
$vo_result 			= $this->getVar('result');
$vn_items_per_page 	= $this->getVar('current_items_per_page');

if($vo_result) {
	print '<table border="0" cellpadding="0px" cellspacing="0px" width="100%">'."\n<tr>\n";
		$vn_display_cols = 7;
		$vn_col = 0;
		$vn_item_count = 0;
		
		$t_list = new ca_lists();
		while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
			$vn_object_id = $vo_result->get('object_id');
			$va_labels = $vo_result->getDisplayLabels();
			
			# get related occ and keep loading parent occ till hit the competition
			$vs_competition = "";
			$vs_competition_date = "";
			$vn_comp_occ_type_id = $t_list->getItemIDFromList('occurrence_types', 'competitions');

			$va_occs = $vo_result->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$t_occ = new ca_occurrences();
			foreach($va_occs as $va_occ){
				$t_occ->load($va_occ['occurrence_id']);
				$vn_parent_occ = $t_occ->get("parent_id");
				if($t_occ->get("type_id") == $vn_comp_occ_type_id){
					$vs_competition = $t_occ->getLabelForDisplay();
					$vs_competition_date = $t_occ->get("ca_occurrences.competition_date");
				}
				break;
			}
			# --- get parent occ
			if(!$vs_competition && $vn_parent_occ && $t_occ->load($vn_parent_occ)){
				$vn_grandparent_id = $t_occ->get("parent_id");
				if($t_occ->get("type_id") == $vn_comp_occ_type_id){
					$vs_competition = $t_occ->getLabelForDisplay();
					$vs_competition_date = $t_occ->get("ca_occurrences.competition_date");
				}
			}
			# --- get grandparent occ
			if(!$vs_competition && $vn_grandparent_id && $t_occ->load($vn_grandparent_id)){
				if($t_occ->get("type_id") == $vn_comp_occ_type_id){
					$vs_competition = $t_occ->getLabelForDisplay();
					$vs_competition_date = $t_occ->get("ca_occurrences.competition_date");
				}
			}
				
			
			print "<td align='center' valign='top' class='searchResultTd'><div class='searchThumbBg searchThumbnail".$vn_object_id."'>";
			print caNavLink($this->request, $vo_result->getMediaTag('ca_object_representations.media','thumbnail'), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
			print "</div>";
			print "</td>\n";
			
			$vn_program_type_id = $t_list->getItemIDFromList('object_types', 'program');
			$vn_comp_entry_type_id = $t_list->getItemIDFromList('object_types', 'competition_entries');

			$vs_caption = "";
			$vs_creator = "";
			$vs_prize = "";
			switch($vo_result->get("ca_objects.type_id")){
				case $vn_program_type_id:
					$vs_caption = _t("Competition Brief").": ".$vs_competition.(($vs_competition_date) ? " (".$vs_competition_date.")" : "");
					$vs_comp = $vo_result->get("ca_occurrences", array("restrict_to_relationship_types" => array("created"), "returnAsArray" => 0, 'checkAccess' => $va_access_values));
					
				break;
				# -----------------------------------
				case $vn_comp_entry_type_id:
					$vs_caption = _t("Competition Submission").": ".$vs_competition.(($vs_competition_date) ? " (".$vs_competition_date.")" : "");
					$vs_creator = $vo_result->get("ca_entities", array("restrict_to_relationship_types" => array("created"), "returnAsArray" => 0, 'checkAccess' => $va_access_values));
					if($vo_result->get("ca_objects.award")){
						$vs_prize = $vo_result->get("ca_objects.award", array('convertCodesToDisplayText' => true));
					}
				break;
				# -----------------------------------
			}
	
			// Get thumbnail caption
			$this->setVar('object_id', $vn_object_id);
			$this->setVar('caption_title', $vs_caption);
			$this->setVar('caption_idno', $vo_result->get("ca_objects.idno"));
			
			// set view vars for tooltip
			$this->setVar('tooltip_representation', $vo_result->getMediaTag('ca_object_representations.media','small'));
			$this->setVar('tooltip_title', $vs_caption);
			$this->setVar('tooltip_creator', $vs_creator);
			$this->setVar('tooltip_prize', $vs_prize);
			TooltipManager::add(
				".searchThumbnail{$vn_object_id}", $this->render('Results/ca_objects_result_tooltip_html.php')
			);
			
			$vn_col++;
			if($vn_col < $vn_display_cols){
				print "<td align='center'>&nbsp;</td>\n";
			}
			if($vn_col == $vn_display_cols){
				print "</tr>\n";
				$vn_col = 0;
			}
			
			$vn_item_count++;
		}
		if($vn_col > 0){
			while($vn_col < $vn_display_cols){
				print "<td class='searchResultTd'><!-- empty --></td>\n";
				$vn_col++;
				if($vn_col < $vn_display_cols){
					print "<td><!-- empty --></td>\n";
				}
			}
			print "</tr>\n";
		}
		
		print "\n</table>\n";
	}
?>