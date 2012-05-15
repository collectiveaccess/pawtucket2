<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ca_objects_full_html.php :
 * 		full search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2010 Whirl-i-Gig
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
 
$va_access_values =  	$this->getVar('access_values');
$vo_result 				= $this->getVar('result');
$vn_items_per_page		= $this->getVar('current_items_per_page');
$vs_research_pending_output = "";

if($vo_result) {
	$col = 0;
	print "<div id='artworkResults'>";
	while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
		
		if (!$vs_idno = $vo_result->get('ca_objects.idno')) {
			$vs_idno = "???";
		}
		
		$vn_object_id = $vo_result->get('ca_objects.object_id');
		if($col == 0){
			print "<table border='0' cellspacing='0' cellpaddin='0'><tr>";
		}
		print "<td valign='middle' class='searchFullImageCell'>";
		print "<div class='searchFullImageContainer result".$vn_object_id."'>";
		if($vo_result->getMediaTag('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values))){
			print caNavLink($this->request, $vo_result->getMediaTag('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values)), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
		}else{
			print "<div class='searchFullImageContainerPlaceHolder'>&nbsp;</div>";
		}
		print "</div><!-- END searchFullImageContainer --></td>";
		print "<td><div class='searchFullText'>";
		$va_labels = $vo_result->getDisplayLabels($this->request);
		$va_caption = array();
		$va_caption[] = "<span class='resultidno'>".trim($vo_result->get("ca_objects.idno"))."</span>";
		$va_caption[] = "<i>".join('; ', $va_labels)."</i>".(($vo_result->get('ca_objects.status') == 0) ? " <span class='pending'>*</span>" : "");
		$va_caption[] = $vo_result->get("ca_objects.date.display_date");
		$va_caption[] = $vo_result->get("ca_objects.technique");
		$vs_caption = join(', ', $va_caption);
		$vs_result = join('<br/>', $va_caption);
		print "<div class='searchFullTitle'>".caNavLink($this->request, $vs_result, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
		print "</div><!-- END searchFullText --></td>";
		// set view vars for tooltip if there is an image
		if($vo_result->getMediaTag('ca_object_representations.media', 'medium', array('checkAccess' => $va_access_values))){
			$this->setVar('tooltip_representation', $vo_result->getMediaTag('ca_object_representations.media', 'medium', array('checkAccess' => $va_access_values)));
			TooltipManager::add(
				".result{$vn_object_id}", $this->render('Results/ca_objects_result_tooltip_html.php')
			);
		}
		$vn_item_count++;
		$col++;
		if($col == 2){
			$col = 0;
			print "</tr></table>\n";
		}else{
			print "<td style='width:15px;'>&nbsp;</td>";
		}
		if(!$vs_research_pending_output && ($vo_result->get('ca_objects.status') == 0)){
			$vs_research_pending_output = 1;
		}
	}
	if($col == 1){
		print "</tr></table>\n"; 
	}
	print "</div>";
	if($vs_research_pending_output){
		print "<div class='pendingMessage'>* Research Pending</div>";
	}
}
?>