<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ca_collections_full_html.php :
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
$vn_page				= $this->getVar('page');

if($vo_result) {
	$vn_num_results = $this->getVar('num_hits');
	$vn_start_result = (($vn_page - 1) * $vn_items_per_page) + 1;
	$vn_end_result = ($vn_page * $vn_items_per_page);
	if($vn_end_result > $vn_num_results){
		$vn_end_result = $vn_num_results;
	}
	print "<div id='searchCount'>"._t("Showing %1 - %2 of %3:", $vn_start_result, $vn_end_result, $vn_num_results)."</div>";

	print '<div id="collectionResults">';
	
	$vn_item_count = 0;
	$vn_item_num_label = $vn_start_result;
	$va_tooltips = array();
	$t_list = new ca_lists();
	while($vo_result->nextHit() && $vn_item_count < $vn_items_per_page) {
		$vs_idno = $vo_result->get('ca_collections.idno');
		
		$vn_collection_id = $vo_result->get('ca_collections.collection_id');
		$vs_description =  $vo_result->get('ca_collections.collection_summary');
		if(strlen($vs_description) > 185){
			$vs_description = trim(substr($vs_description, 0, 185))."...";
		}
		$va_labels = $vo_result->getDisplayLabels($this->request);
		print "<div class='result'>".$vn_item_num_label.") ";
		print caNavLink($this->request, join($va_labels, "; "), '', 'Detail', 'Collection', 'Show', array('collection_id' => $vn_collection_id));
		print "<div class='resultDescription'>".$vs_description;
		print "<img src='".$this->request->getThemeUrlPath()."/graphics/nhf/cross.gif' width='8' height='8' border='0' style='margin: 0px 3px 0px 15px;'>";
		print caNavLink($this->request, _t("more"), '', 'Detail', 'Collection', 'Show', array('collection_id' => $vn_collection_id));
		print "</div><!-- end description -->";
		print "</div>\n";
		$vn_item_count++;
		$vn_item_num_label++;
		
	}
	print "</div>\n";
}
?>
