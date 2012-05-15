<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Detail/related_objects_grid.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
 
	$qr_hits = $this->getVar('browse_results');
	$vn_c = 0;
	$vn_itemc = 0;
	$vn_numCols = 4;
	
	$va_access_values	= $this->getVar('access_values');
	
	if ($qr_hits->numHits()) {
		$v_i = 0;
		$qr_hits->nextHit();
		print "<div style='text-align: center; padding:5px; border: 2px solid #e6e6e6; background-color:#eee; margin-bottom:15px;'>".caNavLink($this->request, $qr_hits->getMediaTag('ca_object_representations.media', 'mediumlarge', array('checkAccess' => $va_access_values)), '', 'Detail', 'Object', 'Show', array('object_id' => $qr_hits->get('ca_objects.object_id')))."</div>";
		$qr_hits->seek(0);
		print "<div id='relatedRecords'>";
			while ($qr_hits->nextHit()) {
				if ($v_i == 0) {
					print "<div class='slide' style='width: 100%;'>";
				}
				$vn_height = $qr_hits->getMediaInfo('ca_object_representations.media', 'thumbnail', 'HEIGHT');
				
				$vn_padding_top = (120 - $vn_height)/2;
				print "<span id='relatedRecordsImage'>".caNavLink($this->request, $qr_hits->getMediaTag('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values)), '', 'Detail', 'Object', 'Show', array('object_id' => $qr_hits->get('ca_objects.object_id')))."</span>";
				$v_i++;
				
				if ($v_i == 5) {
					 print "</div>\n";
					 $v_i = 0;
				}	
			}
			if ($v_i != 0 ) { 
				print "</div>\n";
			}
		print "</div>\n";
		print "<div id='navigation'></div>";
		
	
	
	/*
		while(($vn_itemc < $this->getVar('items_per_page')) && ($qr_hits->nextHit())) {
			if ($vn_c == 0) { print "<tr>\n"; }
			$vn_object_id = $qr_hits->get('object_id');
			$va_labels = $qr_hits->getDisplayLabels();
			$vs_caption = "";
			foreach($va_labels as $vs_label){
				$vs_caption .= $vs_label;
			}
			# --- get the height of the image so can calculate padding needed to center vertically
			$va_media_info = $qr_hits->getMediaInfo('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values));
			$vn_padding_top = 0;
			$vn_padding_top_bottom =  ((130 - $va_media_info["HEIGHT"]) / 2);
			print "<td align='center' valign='top' class='searchResultTd'><div class='searchThumbBg searchThumbnail".$vn_object_id."' style='padding: ".$vn_padding_top_bottom."px 0px ".$vn_padding_top_bottom."px 0px;'>";
			print caNavLink($this->request, $qr_hits->getMediaTag('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values)), '', 'Detail', 'Object', 'Show', array('object_id' => $qr_hits->get('ca_objects.object_id')));
			
			// Get thumbnail caption
			$this->setVar('object_id', $vn_object_id);
			$this->setVar('caption_title', $vs_caption);
			$this->setVar('caption_idno', $qr_hits->get('idno'));
			
			print "</div><div class='searchThumbCaption searchThumbnail".$vn_object_id."'>".$this->render('../Results/ca_objects_result_caption_html.php')."</div>\n</td>\n";
	
			
			// set view vars for tooltip
			$this->setVar('tooltip_representation', $qr_hits->getMediaTag('ca_object_representations.media', 'small', array('checkAccess' => $va_access_values)));
			$this->setVar('tooltip_title', $vs_caption);
			$this->setVar('tooltip_idno', $qr_hits->get('idno'));
			TooltipManager::add(
				".searchThumbnail{$vn_object_id}", $this->render('../Results/ca_objects_result_tooltip_html.php')
			);
			
			$vn_c++;
			$vn_itemc++;
			
			if ($vn_c == $vn_numCols) {
				print "</tr>\n";
				$vn_c = 0;
			}else{
				print "<td><!-- empty for spacing --></td>";
			}
		}
		if(($vn_c > 0) && ($vn_c < $vn_numCols)){
			while($vn_c < $vn_numCols){
				print "<td class='searchResultTd'><!-- empty --></td>\n";
				$vn_c++;
				if($vn_c < $vn_numCols){
					print "<td><!-- empty for spacing --></td>";
				}
			}
			print "</tr>\n";
		}
		*/
	
		//print $this->render('paging_controls_html.php');
		
		JavascriptLoadManager::register('cycle');		// load "ca.cycle" javascript library
	?>
	
	<script type="text/javascript">
	$(document).ready(function() {
	   $('#relatedRecords').cycle({
				   fx: 'scrollLeft', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
				   speed:  1000,
				   timeout: 0,
				   pager: '#navigation'
		   });
	});
	</script>
<?php
 }
?>
