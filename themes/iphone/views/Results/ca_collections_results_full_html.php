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

if($vo_result) {
	if (!$this->request->isAjax()) {
		print '<div class="resultCount">'._t('Your %1 found %2 %3.', $this->getVar('mode_type_singular'), $vo_result->numHits(), ($vo_result->numHits() == 1) ? _t('result') : _t('results'))."</div>";

		print '<div class="listItems">';
	}
	$vn_item_count = 0;
	while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
		$vs_idno = $vo_result->get('ca_collections.idno');
		$vn_collection_id = $vo_result->get('ca_collections.collection_id');
		
		$va_labels = $vo_result->getDisplayLabels($this->request);
		print "<div class='item'>";
		print caNavLink($this->request, join($va_labels, "; "), '', 'Detail', 'Collection', 'Show', array('collection_id' => $vn_collection_id));
		if($vs_idno){
			print ", ".$vs_idno;
		}
		print "</div>\n";
		$vn_item_count++;
		
	}
	if ($this->getVar('page') < $this->getVar('num_pages')) {
		print "<div id='moreCollectionResults".$this->getVar('page')."'><div class='item more'><a href='#' onclick='jQuery(\"#moreCollectionResults".$this->getVar('page')."\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') + 1))."\"); return false;'>"._t("More Results")."</a></div></div>";
	}
	if (!$this->request->isAjax()) {
		print "</div>\n";
	}
}
?>