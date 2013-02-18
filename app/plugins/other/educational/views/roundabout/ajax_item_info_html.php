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
 
	$t_rep 							= $this->getVar('t_object_representation');
	$vs_display_version 		= $this->getVar('rep_display_version');
	$va_display_options	 	= $this->getVar('rep_display_options');
	
	$va_item 						= $this->getVar("item_info");
	$vn_set_id 					= $this->getVar("set_id");
	
	# --- this layout is based on use of a mediumlarge image
	# --- get the height of the media being displayed - either the viewer height or the image height
	if($vs_display_version == 'mediumlarge'){
		$va_media_info = $t_rep->getMediaInfo('media', $vs_display_version);
		$vn_media_height = $va_media_info["HEIGHT"];
	}else{
		$vn_media_height = $va_display_options['viewer_height'];
	}
	if($vn_media_height <= 450){
		$vn_text_height	= 100 + (450 - $vn_media_height);
	}
	$vs_media_tag 				= $t_rep->getMediaTag('media', $vs_display_version, $va_display_options);
?>

		
<?php
	print '<div class="prev-arr">';
				if($va_item['previous_id']){
					print "<a href='#' class='ir' onclick=\"caMediaPanel.showPanel('".caNavUrl($this->request, 'simpleGallery', 'Show', 'setItemInfo', array('set_item_id' => $va_item['previous_id'], 'set_id' => $vn_set_id))."'); return false;\">Previous</a>";
				}else{
					print '<span class="ir">'._t("Previous").'</span>';
				}
	print 	"</div><!-- end .prev-arr-->";	
	print	'<div class="next-arr">';

				if($va_item['next_id']){
					print "<a href='#' class='ir' onclick=\"caMediaPanel.showPanel('".caNavUrl($this->request, 'simpleGallery', 'Show', 'setItemInfo', array('set_item_id' => $va_item['next_id'], 'set_id' => $vn_set_id))."'); return false;\">Next</a>";
				}else{
					print '<span class="ir">'._t("Next").'</span>';
				}
	print 	"</div><!-- end .next-arr-->";	
	
	if($vs_media_tag){
		if ($va_display_options['no_overlay']) {
			print "<div id='galleryOverlayImage'>".$vs_media_tag."</div>";
		} else {
			print "<div id='galleryOverlayImage'>".caNavLink($this->request, $vs_media_tag, 'thumb-link', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id']))."</div>";
		}
	}
	if($va_item['object_label']){
		print "<div id='galleryOverlayImageCaption'>".caNavLink($this->request, $va_item['object_label'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id']))."</div>";
	}
	if($va_item['label'] || $va_item['description']){
?> 	
		<div class="galleryOverlayContent" <?php print ($vn_text_height) ? "style='height:".$vn_text_height."px;'" : ""; ?>>
<?php
			if($va_item['label']){
				print "<div><b>".$va_item['label']."</b></div>";
			}
			if($va_item['description']){
				print "<div>";
				print $va_item['description'];
				print "<br/>".caNavLink($this->request, _t('See this object in the archive'), '', 'Detail', 'Object', 'Show', array('object_id' => $va_item['row_id']))." &rsaquo";
				print "</div>";				
			}
?>
		</div>
<?php
	}
?>