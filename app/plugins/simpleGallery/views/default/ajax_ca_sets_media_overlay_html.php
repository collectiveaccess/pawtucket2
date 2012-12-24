<?php
/* ----------------------------------------------------------------------
 * views/ajax_ca_sets_media_overlay_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009 Whirl-i-Gig
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

	$pn_set_id 					= $this->getVar('set_id');
	$pn_set_item_id 			= $this->getVar('set_item_id');
	$ps_set_description_code	= $this->getVar('set_item_description');
	$pn_object_id 				= $this->getVar('object_id');
	$t_object 					= $this->getVar('t_object');
	$t_rep 						= $this->getVar('t_object_representation');
	$va_versions 				= $this->getVar('versions');	
	$vn_representation_id 		= $t_rep->getPrimaryKey();
	# --- in this mode, reps is actually an array of object representations related to the set
	$va_reps 					= $this->getVar('reps');
	
	$va_display_options		 	= $this->getVar('display_options');
	$vs_show_version 			= $this->getVar('version');
	
	// Get filename of originally uploaded file
	$va_media_info 				= $t_rep->getMediaInfo('media');
	$vs_original_filename 		= $va_media_info['ORIGINAL_FILENAME'];
	
	$vs_container_id 			= $this->getVar('containerID');
	$va_item 					= $this->getVar("item_info");
	
	$va_access_values = caGetUserAccessValues($this->request);



	if(sizeof($va_reps) > 1){
		$vs_version = "icon";
		$vn_num_cols = 1;
		if(sizeof($va_reps) > 5){
			$vn_num_cols = 2;
		}
		if(sizeof($va_reps) > 14){
			$vs_version = "tinyicon";
			$vn_num_cols = 2;
		}
		
?>
		<!-- multiple rep thumbnails - ONLY for media overlay -->
		<div class="caMediaOverlayRepThumbs">
<?php
			$i = 0;
			foreach($va_reps as $vn_object_id => $va_rep_info){
				print "<a href='#' ".(($pn_object_id == $va_rep_info['object_id']) ? "class='selectedRep' " : "")."onClick='jQuery(\"#{$vs_container_id}\").load(\"".caNavUrl($this->request, '', 'simpleGallery/SetsOverlay', 'getSetsOverlay', array('set_id' => $pn_set_id, 'object_id' => $va_rep_info['object_id'], 'representation_id' => $va_rep_info['representation_id']))."\");'>".$va_rep_info['rep_'.$vs_version]."</a>";
				$i++;
				if($i == $vn_num_cols){
					$i = 0;
					print "<br/>";
				}
			}
?>
		</div><!-- end caMediaOverlayRepThumbs -->
<?php
	}
?>
	<!-- Controls - ONLY for media overlay -->
	<div class="caMediaOverlayControls">
		<div class='close'><a href="#" onclick="caMediaPanel.hidePanel(); return false;" title="close">&nbsp;&nbsp;&nbsp;</a></div>
		<div class='simpleGalleryRepNav'>
<?php
			if ($this->getVar('previous_representation_id')) {
				print "<a href='#' onClick='jQuery(\"#{$vs_container_id}\").load(\"".caNavUrl($this->request, '', 'simpleGallery/SetsOverlay', 'getSetsOverlay', array('representation_id' => (int)$this->getVar('previous_representation_id'), 'object_id' => (int)$this->getVar('previous_object_id'), 'set_id' => (int)$pn_set_id))."\");'>←</a>";
			}
			if (sizeof($va_reps) > 1) {
				print ' '._t("%1 of %2", $this->getVar('representation_index'), sizeof($va_reps)).' ';
			}
			if ($this->getVar('next_representation_id')) {
				print "<a href='#' onClick='jQuery(\"#{$vs_container_id}\").load(\"".caNavUrl($this->request, '', 'simpleGallery/SetsOverlay', 'getSetsOverlay', array('representation_id' => (int)$this->getVar('next_representation_id'), 'object_id' => (int)$this->getVar('next_object_id'), 'set_id' => (int)$pn_set_id))."\");'>→</a>";
			}
?>
		</div>
<?php
		# --- caption text 
		$va_object_title = $t_object->get('ca_objects.preferred_labels');
			
		$t_set_item = new ca_set_items($pn_set_item_id);
		if ($vs_set_caption = $t_set_item->getLabelForDisplay()) {
			print "<div class='simpleGalleryCaption'>";
			print $vs_set_caption;
			print "</div>";
		}
		print "<div class='simpleGallerySetItemDescription'>";
		if($t_set_item->get("ca_set_items.{$ps_set_description_code}")){
			print $t_set_item->get("ca_set_items.{$ps_set_description_code}")."<br/><br/>";
		}
		print "<b>"._t('View this Object in the Collection').":</b> ".caNavLink($this->request, $va_object_title, '', 'Detail', 'Object', 'Show', array('object_id' => $pn_object_id));
		print "</div>";
?>			
	</div><!-- end caMediaOverlayControls -->

	<div id="caMediaOverlayContent">
<?php
	// return standard tag
	if (!is_array($va_display_options)) { $va_display_options = array(); }
	$vs_tag = $t_rep->getMediaTag('media', $vs_show_version, array_merge($va_display_options, array(
		'id' => 'caMediaOverlayContentMedia', 
		'viewer_base_url' => $this->request->getBaseUrlPath()
	)));
	# --- should the media be clickable to open the overlay?
	print $vs_tag;
?>
	</div><!-- end caMediaOverlayContent -->