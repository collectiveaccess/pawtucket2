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
$vs_search 				= $this->getVar('search');
$vn_items_per_page		= $this->getVar('current_items_per_page');

$va_access_values = caGetUserAccessValues($this->request);

if($vo_result) {
	$vs_buf = '<div style="padding:10px 0px 0px 0px;">';
	
	$vn_item_count = 0;
	$t_list = new ca_lists();
	while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
		if (!$vs_idno = $vo_result->get('ca_objects.idno')) {
			$vs_idno = "???";
		}
		
		$vn_object_id = $vo_result->get('ca_objects.object_id');
		
		# --- get the height of the image so can calculate padding needed to center vertically
		$va_media_info = $vo_result->getMediaInfo('ca_object_representations.media', 'small');
		$vn_padding_top = 0;
		$vn_padding_top_bottom =  ((250 - $va_media_info["HEIGHT"]) / 2);
		
		$vs_buf .= "<div class='objectFullImageContainer searchThumbnail".$vn_object_id."' style='padding: ".$vn_padding_top_bottom."px 0px ".$vn_padding_top_bottom."px 0px;'>";
		$vs_buf .= caNavLink($this->request, $vo_result->getMediaTag('ca_object_representations.media', 'small'), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
		$vs_buf .= "</div><!-- END objectFullImageContainer -->";
		$vs_buf .= "<div class='objectFullText'>";
		$va_labels = $vo_result->getDisplayLabels($this->request);
		$vs_caption = join('<br/>', $va_labels);
		$vs_caption_link = caNavLink($this->request, $vs_caption, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
		$vs_buf .= "<div class='objectFullTextTitle searchThumbnail".$vn_object_id."'>{$vs_caption_link}</div>\n";
		$vs_buf .= "<div class='objectFullTextTextBlock'>";

		// get thumbnail caption
		if (!is_array($va_entities = $vo_result->get('ca_entity_labels.displayname', array('return_all_values' => true)))) { $va_entities = array(); }
		if (!is_array($va_dates = $vo_result->get('ca_objects.dates/dates_value', array('return_all_values' => true)))) { $va_dates = array(); }
		$this->setVar('tooltip_caption', caNavLink($this->request, $vs_caption, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id)));
		$this->setVar('tooltip_artist_list', $vs_artist_list = join(', ', $va_entities));
		$this->setVar('tooltip_date_list', $vs_date_list = join(', ', array_flip(array_flip($va_dates))));
		$this->setVar('tooltip_description', $t_list->getItemFromListForDisplayByItemID('object_types', $vo_result->get('ca_objects.type_id')));
		
		$vs_buf .= $this->render('Results/ca_objects_result_caption_html.php');
		
		$vs_buf .= "</div>";
		$vs_buf .= "</div><!-- END objectFullText -->\n";
		$vs_buf .= "<br/><div class='divide' style='clear:left;'><!-- empty --></div>\n";
		$vn_item_count++;
		
		// set view vars for tooltip
		$this->setVar('tooltip_representation', $vo_result->getMediaTag('ca_object_representations.media', 'small'));
		$this->setVar('tooltip_caption', $vs_caption);
		$this->setVar('tooltip_artist_list', $vs_artist_list);
		$this->setVar('tooltip_date_list', $vs_date_list);
		$this->setVar('tooltip_description', $vo_result->get('ca_objects.description_public'));
		TooltipManager::add(
			".searchThumbnail{$vn_object_id}", $this->render('ca_objects_result_tooltip_html.php')
		);
		
		// get exhibitions
		if (in_array($vo_result->get('ca_occurrences.access'), $va_access_values) && ($vs_exhibition = trim($vo_result->get('ca_occurrence_labels.name')))) {
			$va_exhibitions[$vo_result->get('ca_occurrence_labels.occurrence_id')] = $vo_result->get('ca_occurrence_labels.name');
		}
	}
	
	$vs_buf .= "</div>\n";
	
	print $vs_buf;
}
?>