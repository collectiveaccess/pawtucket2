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

if($vo_result) {
	print '<div id="occurrenceResults">';
	
	$vn_item_count = 0;
	$va_tooltips = array();
	$t_list = new ca_lists();
	$vn_abstract_id = $t_list->getItemIDFromList('pbcore_description_types', 'abstract');
		
	$vn_i = 0;
	while(($vn_i < $vn_items_per_page) && ($vo_result->nextHit())) {
		$va_stills = array();
		$vs_still = "";
		$vs_repository = "";
		$vs_repository = $vo_result->get("CLIR2_institution", array('convertCodesToDisplayText' => true));
		$va_descriptions = array();
		$va_descriptions = $vo_result->get("pbcoreDescription", array("returnAsArray" => 1));
		$vs_abstract = "";
		if(sizeof($va_descriptions) > 0){
			foreach($va_descriptions as $vn_x => $va_description){
				if($va_description["descriptionType"] == $vn_abstract_id){
					$vs_abstract = $va_description["description_text"];
				}
			}
		}
		$vs_class = "";
		$vn_item_count++;
		if($vn_item_count == 2){
			$vs_class = "Bg";
			$vn_item_count = 0;
		}
		
		$vn_occurrence_id = $vo_result->get('ca_occurrences.occurrence_id');
				
		$va_labels = $vo_result->getDisplayLabels($this->request);
		print "<div class='resultItem".(($vs_class) ? "$vs_class" : "")."'>";
		$va_stills = $vo_result->get('ca_occurrences.ic_stills.ic_stills_media', array('version' => "preview", "showMediaInfo" => false, "returnAsArray" => true));
		if(sizeof($va_stills) > 0){
			$vs_still =  array_shift($va_stills);
			print $vs_still;
		}
		print caNavLink($this->request, join($va_labels, "; "), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_occurrence_id));
		if($vs_repository){
			print "<br><b>"._t("Repository")."</b>: ".$vs_repository;
		}
		$va_collections = $vo_result->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
		if($va_collections){
			print "<br/><b>"._t("Collection")."</b>: ";
			$va_collections_display = array();
			foreach($va_collections as $va_collection_info){
				$va_collections_display[] = caNavLink($this->request, $va_collection_info['label'], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_collection_info['collection_id']));
			}
			print join(", ", $va_collections_display);
		}
		
		if($vs_abstract){
			print "<div class='occResultDescription'>".$vs_abstract."</div>";
		}
		print "<div style='clear:both; height:1px;'>&nbsp;</div></div>\n";
		$vn_i++;
		
	}
	print "</div>\n";
}
?>