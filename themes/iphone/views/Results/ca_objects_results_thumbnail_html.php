<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Results/ca_objects_results_thumbnail_html.php :
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
	$vn_num_hits = $this->getVar('num_hits');
	if (!$this->request->isAjax()) {
		print '<div class="resultCount">'._t('Your %1 found %2 %3.', $this->getVar('mode_type_singular'), $vn_num_hits, ($vn_num_hits == 1) ? _t('result') : _t('results'))."</div>";

		print '<div class="listItems">';
	}
		$vn_item_count = 0;
		
		$t_list = new ca_lists();
		while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
			$vn_object_id = $vo_result->get('object_id');
			$va_labels = $vo_result->getDisplayLabels();
			
			$vs_caption = "";
			foreach($va_labels as $vs_label){
				$vs_caption .= $vs_label;
			}
			
			print "<div class='item'><div class='thumb'>".caNavLink($this->request, $vo_result->getMediaTag('ca_object_representations.media', 'tiny'), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div><!-- end thumb -->";
			
			// Get thumbnail caption
			$this->setVar('object_id', $vn_object_id);
			$this->setVar('caption_title', $vs_caption);
			$this->setVar('caption_idno', $vo_result->get("ca_objects.idno"));
			
			print $this->render('Results/ca_objects_result_caption_html.php');
			print "<div style='clear:left;'><!--empty --></div></div>";
			
			$vn_item_count++;
		}
		if ($this->getVar('page') < $this->getVar('num_pages')) {
			print "<div id='moreObjectResults".$this->getVar('page')."'><div class='item more'><a href='#' onclick='jQuery(\"#moreObjectResults".$this->getVar('page')."\").load(\"".caNavUrl($this->request, '', $this->request->getController(), 'Index', array('page' => $this->getVar('page') + 1))."\"); return false;'>"._t("More Results")."</a></div></div>";
		}
	if (!$this->request->isAjax()) {	
		print "\n</div>\n";
	}
}
?>
