<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Results/ca_objects_results_full_html.php :
 * 		full search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2011 Whirl-i-Gig
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
 
 	
$vo_result 					= $this->getVar('result');
$vn_items_per_page		= $this->getVar('current_items_per_page');
$va_access_values 		= $this->getVar('access_values');

if($vo_result) {
	$vn_item_count = 0;
	$va_tooltips = array();
	$t_list = new ca_lists();
	while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
		if (!$vs_idno = $vo_result->get('ca_objects.idno')) {
			$vs_idno = "???";
		}
		
		$vn_object_id = $vo_result->get('ca_objects.object_id');
		
		print "<div class='searchFullImageContainer'>";
		print caNavLink($this->request, $vo_result->getMediaTag('ca_object_representations.media', 'small', array('checkAccess' => $va_access_values)), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
		print "</div><!-- END searchFullImageContainer -->";
		print "<div class='searchFullText'>";
		$va_labels = $vo_result->getDisplayLabels($this->request);
		$vs_caption = join('<br/>', $va_labels);
		print "<div class='searchFullTitle'>".caNavLink($this->request, $vs_caption, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
		print "<div class='searchFullTextTitle'>"._t("ID")."</div>\n";
		print "<div class='searchFullTextTextBlock'>".$vo_result->get("ca_objects.idno")."</div>";
		print "</div><!-- END searchFullText -->\n";
		$vn_item_count++;
		if(!$vo_result->isLastHit()){
			print "<div class='divide' style='clear:left;'><!-- empty --></div>\n";
		}
		
	}
}
?>