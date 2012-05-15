<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ca_occurrences_full_html.php :
 * 		full search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
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
 
 	
$vo_result 				= $this->getVar('result');
$vn_items_per_page		= $this->getVar('current_items_per_page');

$t_list = new ca_lists();
$vn_bib_type_id = $t_list->getItemIDFromList('occurrence_types', 'bibliography');
$vn_exhibition_type_id = $t_list->getItemIDFromList('occurrence_types', 'exhibition');
$vn_chronology_type_id = $t_list->getItemIDFromList('occurrence_types', 'chronology');

$vs_research_pending_output = "";

$t_occ = new ca_occurrences();
if($vo_result) {
	print '<div id="occurrenceResults">';
	$vn_item_count = $vn_items_output = 0;
	while(($vn_items_output < $vn_items_per_page) && ($vo_result->nextHit())) {
		$vs_class = "";
		$vn_item_count++; $vn_items_output++;
		if($vn_item_count == 2){
			$vs_class = "resultBg";
			$vn_item_count = 0;
		}
		
		$vn_occurrence_id = $vo_result->get('ca_occurrences.occurrence_id');
		
		
		$va_labels = $vo_result->getDisplayLabels($this->request);
		print "<div".(($vs_class) ? " class='$vs_class'" : "").">";
		switch($vo_result->get("ca_occurrences.type_id")){
			# ----------------
			# --- bibliography
			case $vn_bib_type_id:
				print caNavLink($this->request, $vo_result->get('ca_occurrences.bib_full_citation'), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_occurrence_id));
			break;
			# ----------------
			# --- exhibitions
			case $vn_exhibition_type_id:
				$vs_result = "";
				$vs_result .=  "\"".join($va_labels, "; ").",\" ";			
				# --- get venue
				$t_occ->load($vo_result->get('ca_occurrences.occurrence_id'));
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
				if($vs_venue){
					$vs_result .= $vs_venue;
				}
				if($vo_result->get("ca_occurrences.date.display_date")){
					$vs_result .=  ", ".$vo_result->get("ca_occurrences.date.display_date");
				}
				print caNavLink($this->request, $vs_result, '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_occurrence_id));
			break;
			# ----------------
			# --- chronology
			case $vn_chronology_type_id:
				$vn_year = "";
				$va_date_info = array();
				$vs_result = "";
				$o_time_parser = new timeExpressionParser();
				if($o_time_parser->parse($vo_result->get('ca_occurrences.date.parsed_date'))){
					$va_date_info = $o_time_parser->getHistoricTimestamps();
					$vn_year = intval($va_date_info["start"]);
				}
				$vs_result .=  "<b>".$vn_year."</b> - ".$vo_result->get('ca_occurrences.event_text');
				if($vn_year){
					print caNavLink($this->request, $vs_result, '', '', 'Chronology', 'Detail', array('year' => $vn_year));
				}else{
					$vs_result;
				}
			break;
			# ----------------
			default:
				if($vo_result->get('ca_occurrences.idno')){
					print caNavLink($this->request, $vo_result->get('ca_occurrences.idno'), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_occurrence_id));
					print ", ";
				}
				print caNavLink($this->request, join($va_labels, "; "), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_occurrence_id));			
			break;
		}
		if(($vo_result->get("ca_occurrences.type_id") != $vn_chronology_type_id) && ($vo_result->get('ca_occurrences.status') == 0)){
			print " <span class='pending'>*</span>";
			if(!$vs_research_pending_output){
				$vs_research_pending_output = 1;
			}
		}
		print "</div>\n";
		
	}
	print "</div>\n";
	if($vs_research_pending_output){
		print "<div class='pendingMessage'>* Research Pending</div>";
	}
}
?>