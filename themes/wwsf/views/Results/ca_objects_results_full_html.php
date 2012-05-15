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
 
 	
$vo_result 				= $this->getVar('result');
$vn_items_per_page		= $this->getVar('current_items_per_page');

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
				if($vo_result->get('ca_objects.type_id') == 5){
			# --- video so print out icon
			print "<div class='videoIcon' style='margin-left:0px;'><img src='".$this->request->getThemeUrlPath()."/graphics/video.gif' width='26' height='26' border='0'></div>";
			# --- if this is a video, show a smaller image so there is a thumbnail to show, otherwise the quicktime icon shows up
			print caNavLink($this->request, $vo_result->getMediaTag('ca_object_representations.media', 'preview160'), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
		}else{
			print caNavLink($this->request, $vo_result->getMediaTag('ca_object_representations.media', 'small'), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
		}
		
		print "</div><!-- END searchFullImageContainer -->";
		print "<div class='searchFullText'>";
		$va_labels = $vo_result->getDisplayLabels($this->request);
		$vs_caption = join('<br/>', $va_labels);
		print "<div class='searchFullTitle'>".caNavLink($this->request, $vs_caption, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
		if($vo_result->get("ca_objects.wann_aufgen")){
			print "<div class='searchFullTextTextBlock'>".$vo_result->get("ca_objects.wann_aufgen", array('convertLineBreaks' => true))."</div>";
		}
		if($vo_result->get("ca_objects.wo_aufgen")){
			print "<div class='searchFullTextTextBlock'>".$vo_result->get("ca_objects.wo_aufgen", array('convertLineBreaks' => true))."</div>";
		}
		
		$va_photographers = $vo_result->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, 'restrict_to_relationship_types' => array('creator')));
		if(sizeof($va_photographers) > 0){
			$va_photographers_for_display = array();
			foreach($va_photographers as $va_entity){
				$va_photographers_for_display[] = $va_entity["label"];
			}
			print "<div class='searchFullTextTextBlock'>".implode(", ", $va_photographers_for_display)."</div>";
		}			
		
		if($vo_result->get("ca_objects.description")){
			print "<div class='searchFullTextTextBlock'>".$vo_result->get("ca_objects.description", array('convertLineBreaks' => true))."</div>";
		}
		print "</div><!-- END searchFullText -->\n";
		$vn_item_count++;
		if($vn_item_count < $vn_items_per_page){
			print "<div class='divide' style='clear:left;'><!-- empty --></div>\n";
		}
		
	}
}
?>