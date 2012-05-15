<?php
/* ----------------------------------------------------------------------
 * app/plugins/simpleGallery/ajax_item_info_html.php : 
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
 
	$va_item 						= $this->getVar("item_info");
	$vn_set_id 					= $this->getVar("set_id");
	
	# --- this layout is based on use of a mediumlarge image
	$vn_no_link = "";
	# --- try and show video, if none then show still
	if($va_item['media_video']){
		$vs_media_tag = $va_item['media_video'];
		$vn_no_link = 1;
		$vs_caption = $va_item['media_video_caption'];
	}elseif($va_item['media_still']){
		$vs_media_tag = $va_item['media_still'];
		$vs_caption = $va_item['media_still_caption'];
	}
?>
	<div id="galleryOverlayNextPrevious">
<?php
	if($va_item['previous_id']){
		print "<a href='#' onclick=\"caMediaPanel.showPanel('".caNavUrl($this->request, 'clir2', $this->request->getController(), 'setItemInfo', array('set_item_id' => $va_item['previous_id'], 'set_id' => $vn_set_id))."'); return false;\">"._t("&lsaquo; Previous")."</a>";
	}else{
		print _t("&lsaquo; Previous");
	}
	print "&nbsp;&nbsp;|&nbsp;&nbsp;";
	if($va_item['next_id']){
		print "<a href='#' onclick=\"caMediaPanel.showPanel('".caNavUrl($this->request, 'clir2', $this->request->getController(), 'setItemInfo', array('set_item_id' => $va_item['next_id'], 'set_id' => $vn_set_id))."'); return false;\">"._t("Next &rsaquo;")."</a>";
	}else{
		print _t("Next &rsaquo;");
	}
	print "</div>";	
	if($vs_media_tag){
		if ($vn_no_link) {
			print "<div id='galleryOverlayVideo'>".$vs_media_tag."</div>";
		} else {
			print "<div id='galleryOverlayImage'>".caNavLink($this->request, $vs_media_tag, '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_item['row_id']))."</div>";
		}
	}
	if($vs_caption){
		print "<div id='galleryOverlayImageCaption'>".$vs_caption."</div>";
	}
	if($va_item['label'] || $va_item['description']){
?> 	
		<div class="galleryOverlayContent">
<?php
			
			if($va_item['label']){
				print "<div><b>".caNavLink($this->request, $va_item['label'], '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_item['row_id']))."</b></div>";
			}
			if($va_item['description']){
				print "<div>";
				print $va_item['description'];
				print "<br/>".caNavLink($this->request, _t('See this record in the archive'), '', 'Detail', 'Occurrence', 'Show', array('occurrence_id' => $va_item['row_id']))." &rsaquo;";
				print "</div>";				
			}
?>
		</div>
<?php
	}
?>