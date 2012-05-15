<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Results/search_secondary_results/ca_occurrences_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source occurrences management software
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
	
	if ($this->request->config->get('do_secondary_search_for_ca_occurrences')) {
		$vo_occurrence_result = $this->getVar('secondary_search_ca_occurrences');
		if (($vn_num_occurrence_results = $vo_occurrence_result->numHits()) > 0) {
			$vn_items_per_page	= $this->getVar('secondaryItemsPerPage');
			$vn_page 			= $this->getVar('page_ca_occurrences');
			$vn_start_result = (($vn_page) * $vn_items_per_page) + 1;
			$vn_end_result = (($vn_page + 1) * $vn_items_per_page);
			if($vn_end_result > $vn_num_occurrence_results){
				$vn_end_result = $vn_num_occurrence_results;
			}
			print "<div id='occurrencesSecondaryResults'>";
			print "<div class='searchCount'>"._t("Showing %1 - %2 of %3:", $vn_start_result, $vn_end_result, $vn_num_occurrence_results)."</div>";
		
			print '<div id="occurrenceResults">';
			
			$vn_item_count = 0;
			$vn_item_num_label = $vn_start_result;
			$va_tooltips = array();
			$t_list = new ca_lists();
			while($vo_occurrence_result->nextHit() && $vn_item_count < $vn_items_per_page) {
				$vs_idno = $vo_occurrence_result->get('ca_occurrences.idno');
				
				$vn_occurrence_id = $vo_occurrence_result->get('ca_occurrences.occurrence_id');
				$vs_description =  $vo_occurrence_result->get('ca_occurrences.pbcoreDescription.description_text');
				if(strlen($vs_description) > 185){
					$vs_description = trim(substr($vs_description, 0, 185))."...";
				}
				$va_labels = $vo_occurrence_result->getDisplayLabels($this->request);
				print "<div class='result'>".$vn_item_num_label.") ";
				print caNavLink($this->request, join($va_labels, "; "), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_occurrence_id));
				print "<div class='resultDescription'>".$vs_description;
				print "<img src='".$this->request->getThemeUrlPath()."/graphics/nhf/cross.gif' width='8' height='8' border='0' style='margin: 0px 3px 0px 15px;'>";
				print caNavLink($this->request, _t("more"), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $vn_occurrence_id));
				print "</div><!-- end description -->";
				print "</div>\n";
				$vn_item_count++;
				$vn_item_num_label++;
				
			}
			print "</div>\n";
			
			
			
?>			
			<div class='searchNav'>
<?php		
			$vn_total_pages = ceil($vn_num_occurrence_results/$vn_items_per_page);
			if($vn_total_pages > 1){
				print "<div class='nav'>";
				if ($vn_page > 0) {
					print "<a href='#' onclick='jQuery(\"#occurrencesSecondaryResults\").load(\"".caNavUrl($this->request, '', 'Search', 'secondarySearch', array('spage' => $vn_page - 1, 'type' => 'ca_occurrences'))."\"); return false;'>&lt; "._t("Previous")."</a>&nbsp;&nbsp;<span class='turqPipe'>|</span>&nbsp;&nbsp;";
				}else{
					print "&lt;&lt; "._t("Previous")."&nbsp;&nbsp;<span class='grayPipe'>|</span>&nbsp;&nbsp;";
				}
				
				
				$vn_p = $vn_page + 1;
				if($vn_p > ($vn_total_pages-3)){
					$vn_p = $vn_total_pages-3;
					if($vn_p < 1){
						$vn_p = 1;
					}
				}
				$vn_link_count = 1;
				print _t("Page: ");
				while(($vn_p <= $vn_total_pages) && ($vn_link_count <= 4)){
					if($vn_p == $vn_page + 1){
						print $vn_p;
					}else{
						print "<a href='#' onclick='jQuery(\"#occurrencesSecondaryResults\").load(\"".caNavUrl($this->request, '', 'Search', 'secondarySearch', array('spage' => $vn_p - 1, 'type' => 'ca_occurrences'))."\"); return false;'>".$vn_p."</a>";
					}
					if($vn_p != $vn_total_pages){
						print "&nbsp;&nbsp;";
					}
					$vn_p++;
					$vn_link_count++;
				}
				#print $vn_p;
				if($vn_p <= $vn_total_pages){
					print "<span class='turq'>...</span>";
				}
				if (($vn_page + 1) < $vn_total_pages) {
					print "&nbsp;&nbsp;<span class='turqPipe'>|</span>&nbsp;&nbsp;<a href='#' onclick='jQuery(\"#occurrencesSecondaryResults\").load(\"".caNavUrl($this->request, '', 'Search', 'secondarySearch', array('spage' => $vn_page + 1, 'type' => 'ca_occurrences'))."\"); return false;'>"._t("Next")." &gt;&gt;</a>";
				}else{
					print "&nbsp;&nbsp;<span class='grayPipe'>|</span>&nbsp;&nbsp;"._t("Next")." &gt;&gt;";
				}
				print '</div>';
			}
?>
	</div><!-- end searchNav --></div><!-- end occurrencesSecondaryResults -->
<?php			
			
			
			
		}
	}
?>