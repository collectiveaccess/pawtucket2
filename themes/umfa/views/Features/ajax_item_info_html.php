<?php
/* ----------------------------------------------------------------------
 * Features/ajax_item_info_html.php : 
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
 
	$t_rep 							= $this->getVar('t_object_representation');
	
	$va_item 						= $this->getVar("item_info");
	$vn_set_id 					= $this->getVar("set_id");
	
	# --- this layout is based on use of a medium image
	# --- get the height of the media being displayed
	$va_media_info = $t_rep->getMediaInfo('media', 'mediumlarge');
	$vn_media_height = $va_media_info["HEIGHT"];
	
	if($vn_media_height <= 450){
		$vn_text_height	= 100 + (450 - $vn_media_height);
	}
	$vs_media_tag 				= $t_rep->getMediaTag('media', "mediumlarge", $va_display_options);

	if($va_item['previous_id']){
		print "<div id='featuresPrevious'><a href='#' onclick=\"caMediaPanel.showPanel('".caNavUrl($this->request, '', 'Features', 'setItemInfo', array('set_item_id' => $va_item['previous_id'], 'set_id' => $vn_set_id))."'); return false;\"><img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_lt.gif' width='20' height='31' border='0' alt='Previous'></a></div>";
	}else{
		print "<div id='featuresPrevious'></div>";
	}
	if($va_item['next_id']){
		print "<div id='featuresNext'><a href='#' onclick=\"caMediaPanel.showPanel('".caNavUrl($this->request, '', 'Features', 'setItemInfo', array('set_item_id' => $va_item['next_id'], 'set_id' => $vn_set_id))."'); return false;\"><img src='".$this->request->getThemeUrlPath()."/graphics/browse_arrow_large_gr_rt.gif' width='20' height='31' border='0' alt='Next'></a></div>";
	}else{
		print "<div id='featuresNext'></div>";
	}	
	if($vs_media_tag){
		if ($va_display_options['no_overlay']) {
			print "<div id='featuresOverlayImage'>".$vs_media_tag."</div>";
		} else {
			print "<div id='featuresOverlayImage'>".caNavLink($this->request, $vs_media_tag, '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id']))."</div>";
		}
	}
	$va_caption = array();
	if($va_item['object_artist']){
		$va_caption[] = $va_item['object_artist'];
	}
	if($va_item['object_label']){
		$va_caption[] = "<i>".$va_item['object_label']."</i>";
	}
	if($va_item['object_medium']){
		$va_caption[] = $va_item['object_medium'];
	}
	if($va_item['object_idno']){
		$va_caption[] = $va_item['object_idno'];
	}
	$vs_caption = join(", ", $va_caption);
	if($vs_caption){
		print "<div id='featuresOverlayImageCaption'>".caNavLink($this->request, $vs_caption, '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id']))."</div>";
	}
	if($va_item['label'] || $va_item['description']){
?> 	
		<div class="featuresOverlayContent" <?php print ($vn_text_height) ? "style='height:".$vn_text_height."px;'" : ""; ?>>
<?php
			if($va_item['label']){
				print "<div><b>".$va_item['label']."</b></div>";
			}
			if($va_item['description']){
				print "<div>";
				print $va_item['description'];
				print "<br/><br/>".caNavLink($this->request, _t('See this object in the archive'), '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id']))." &rsaquo";
				print "</div>";				
			}
?>
		</div>
<?php
	}
?>