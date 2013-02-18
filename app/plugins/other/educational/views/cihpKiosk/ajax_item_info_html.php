<?php
/* ----------------------------------------------------------------------
 * app/plugins/simpleGallery/views/cihpKiosk/ajax_item_info_html.php : 
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
 
 # --- this view does not display metadata associated with the set item - it will NOT display label and description added to the set item, only the object's label

	$t_rep 							= $this->getVar('t_object_representation');
	$vs_display_version 		= $this->getVar('rep_display_version');
	$va_display_options	 	= $this->getVar('rep_display_options');
	
	$va_item 						= $this->getVar("item_info");
	$vn_set_id 					= $this->getVar("set_id");
	
	# --- this layout is based on use of a large image
	# --- get the height of the media being displayed - either the viewer height or the image height
	if($vs_display_version == 'large'){
		$va_media_info = $t_rep->getMediaInfo('media', $vs_display_version);
		$vn_media_height = $va_media_info["HEIGHT"];
	}else{
		$vn_media_height = $va_display_options['viewer_height'];
	}
	$vs_media_tag 				= $t_rep->getMediaTag('media', $vs_display_version, $va_display_options);
?>
<div id='galleryItemFrame'>
<?php
	if($vs_media_tag){
		# --- pad the top to center vertically
		$vs_padding_top = ceil((600 - $vn_media_height)/2);
		print "<div id='galleryItemImage'><div style='padding-top:".$vs_padding_top."px;'>";
		if($va_item['next_id']){
			print "<a href='#' onclick=\"$('#setSlideShow').load('".caNavUrl($this->request, 'simpleGallery', 'Show', 'setItemInfo', array('set_item_id' => $va_item['next_id'], 'set_id' => $vn_set_id))."'); return false;\">".$vs_media_tag."</a>";
		}else{
			print $vs_media_tag;
		}
		print "</div></div>";
	}
	if($va_item['object_label']){
		print "<div id='galleryItemImageCaption'>".$va_item['object_label']."</div>";
	}
?>
	</div>
	<div id="galleryItemNextPrevious">
<?php
	if($va_item['previous_id']){
		print "<a href='#' onclick=\"$('#setSlideShow').load('".caNavUrl($this->request, 'simpleGallery', 'Show', 'setItemInfo', array('set_item_id' => $va_item['previous_id'], 'set_id' => $vn_set_id))."'); return false;\" style='float:left;'><img src='".$this->request->getThemeUrlPath()."/graphics/b_previous.gif' border='0'></a>";
	}else{
		print "<img src='".$this->request->getThemeUrlPath()."/graphics/b_previous_off.gif' border='0' style='float:left;'>";
	}
	print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/b_back.gif' border='0'>", '', 'simpleGallery', 'Show', 'Index');
	if($va_item['next_id']){
		print "<a href='#' onclick=\"$('#setSlideShow').load('".caNavUrl($this->request, 'simpleGallery', 'Show', 'setItemInfo', array('set_item_id' => $va_item['next_id'], 'set_id' => $vn_set_id))."'); return false;\" style='float:right;'><img src='".$this->request->getThemeUrlPath()."/graphics/b_next.gif' border='0'></a>";
	}else{
		print "<img src='".$this->request->getThemeUrlPath()."/graphics/b_next_off.gif' border='0' style='float:right;'>";
	}
	print "</div>";	
?>