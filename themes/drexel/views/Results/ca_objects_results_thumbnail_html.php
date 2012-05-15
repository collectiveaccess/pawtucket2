<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ca_objects_thumbnail_html.php :
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
	print '<table border="0" cellpadding="0px" cellspacing="0px" width="100%">'."\n<tr>\n";
		$vn_display_cols = 6;
		$vn_col = 0;
		$vn_item_count = 0;
		
		$t_list = new ca_lists();
		while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
			$vn_object_id = $vo_result->get('object_id');
			$va_labels = $vo_result->getDisplayLabels();
			
			$vs_caption = "";
			foreach($va_labels as $vs_label){
				$vs_caption .= $vs_label;
			}
			# --- get the height of the image so can calculate padding needed to center vertically
			$va_media_info = $vo_result->getMediaInfo('ca_object_representations.media', 'thumbnail');
			$vn_padding_top = 0;
			$vn_padding_top_bottom =  ((130 - $va_media_info["HEIGHT"]) / 2);
			
			print "<td align='center' valign='top' class='searchResultTd'><div class='searchThumbBg searchThumbnail".$vn_object_id."' style='padding: ".$vn_padding_top_bottom."px 0px ".$vn_padding_top_bottom."px 0px;'>";
			print caNavLink($this->request,  $vo_result->getMediaTag('ca_object_representations.media', 'thumbnail'), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
			
			// Get thumbnail caption
			$this->setVar('object_id', $vn_object_id);
			$this->setVar('caption_title', $vs_caption);
			$this->setVar('caption_idno', $vo_result->get("ca_objects.idno"));
			
			print "</div><div class='searchThumbCaption searchThumbnail".$vn_object_id."'>".$this->render('Results/ca_objects_result_caption_html.php')."</div>";
			print "</td>\n";
			
			// set view vars for tooltip
			$this->setVar('tooltip_representation',  $vo_result->getMediaTag('ca_object_representations.media', 'small'));
			$this->setVar('tooltip_title', $vs_caption);
			$this->setVar('tooltip_idno', $vo_result->get("ca_objects.idno"));
			TooltipManager::add(
				".searchThumbnail{$vn_object_id}", $this->render('Results/ca_objects_result_tooltip_html.php')
			);
			
			$vn_col++;
			if($vn_col < $vn_display_cols){
				print "<td align='center'>&nbsp;</td>\n";
			}
			if($vn_col == $vn_display_cols){
				print "</tr>\n";
				$vn_col = 0;
			}
			
			$vn_item_count++;
		}
		if($vn_col > 0){
			while($vn_col < $vn_display_cols){
				print "<td class='searchResultTd'><!-- empty --></td>\n";
				$vn_col++;
				if($vn_col < $vn_display_cols){
					print "<td><!-- empty --></td>\n";
				}
			}
			print "</tr>\n";
		}
		
		print "\n</table>\n";
	}
?>