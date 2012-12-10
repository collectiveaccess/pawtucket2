<?php
/* ----------------------------------------------------------------------
 * views/editor/objects/ajax_object_representation_info_html.php : 
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

	$pn_occurrence_id 			= $this->getVar('occurrence_id');
	$pn_object_id 				= $this->getVar('object_id');
	$t_object 					= $this->getVar('t_object');
	$t_rep 						= $this->getVar('t_object_representation');
	$va_versions 				= $this->getVar('versions');	
	$vn_representation_id 		= $t_rep->getPrimaryKey();
	# --- in this mode, reps is actually an array of object representations related to the occurrence
	$va_reps 					= $this->getVar('reps');
	
	$vs_display_type		 	= $this->getVar('display_type');
	$va_display_options		 	= $this->getVar('display_options');
	$vs_show_version 			= $this->getVar('version');
	
	// Get filename of originally uploaded file
	$va_media_info 				= $t_rep->getMediaInfo('media');
	$vs_original_filename 		= $va_media_info['ORIGINAL_FILENAME'];
	
	$vs_container_id 			= $this->getVar('containerID');
	
	$va_pages = $va_sections = array();
	$vb_use_book_reader = false;
	$vn_open_to_page = 1;
	$va_access_values = caGetUserAccessValues($this->request);


		
	if($vs_display_type == 'media_overlay'){
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
				print "<a href='#' ".(($pn_object_id == $vn_object_id) ? "class='selectedRep' " : "")."onClick='jQuery(\"#{$vs_container_id}\").load(\"".caNavUrl($this->request, '', 'OccurrenceMediaOverlay', 'GetOccurrenceMediaOverlay', array('representation_id' => (int)$va_rep_info["representation_id"], 'object_id' => (int)$vn_object_id, 'occurrence_id' => (int)$pn_occurrence_id))."\");'>".$va_rep_info['rep_'.$vs_version]."</a>";
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
			<div class='objectInfo'>
<?php
			# --- caption text - Noguchi NCR specific!
			if($t_rep->get("image_credit_line")){
				if($t_rep->get("image_credit_line")){
					print "<i>".$t_rep->get("image_credit_line")."</i>";
				}
				print " &ndash; &copy; INFGM";
			}

?>			
			</div>
			<div class='overlayLightboxLink'>
<?php
			if($this->request->isLoggedIn()){
				print caNavLink($this->request, _t("Add to Lightbox +"), '', '', 'Sets', 'addItem', array('object_id' => $pn_object_id));
			}else{
				print caNavLink($this->request, _t("Add to Lightbox +"), '', '', 'LoginReg', 'form', array('site_last_page' => 'Sets', 'object_id' => $pn_object_id));
			}
?>
			</div>
			<div class='repNav'>
<?php
				if ($this->getVar('previous_representation_id')) {
					print "<a href='#' onClick='jQuery(\"#{$vs_container_id}\").load(\"".caNavUrl($this->request, '', 'OccurrenceMediaOverlay', 'GetOccurrenceMediaOverlay', array('representation_id' => (int)$this->getVar('previous_representation_id'), 'object_id' => (int)$this->getVar('previous_object_id'), 'occurrence_id' => (int)$pn_occurrence_id))."\");'>←</a>";
				}
				if (sizeof($va_reps) > 1) {
					print ' '._t("%1 of %2", $this->getVar('representation_index'), sizeof($va_reps)).' ';
				}
				if ($this->getVar('next_representation_id')) {
					print "<a href='#' onClick='jQuery(\"#{$vs_container_id}\").load(\"".caNavUrl($this->request, '', 'OccurrenceMediaOverlay', 'GetOccurrenceMediaOverlay', array('representation_id' => (int)$this->getVar('next_representation_id'), 'object_id' => (int)$this->getVar('next_object_id'), 'occurrence_id' => (int)$pn_occurrence_id))."\");'>→</a>";
				}
?>
			</div>
	</div><!-- end caMediaOverlayControls -->
<?php
			}
?>
	<div id="<?php print ($vs_display_type == 'media_overlay') ? 'caMediaOverlayContent' : 'caMediaDisplayContent'; ?>">
<?php
	if($vs_display_type == 'media_overlay'){
?>
		<div class='closeUpperLeft'><a href="#" onclick="caMediaPanel.hidePanel(); return false;" title="close">&nbsp;&nbsp;&nbsp;</a></div>
<?php
	}
	// return standard tag
	if (!is_array($va_display_options)) { $va_display_options = array(); }
	$vs_tag = $t_rep->getMediaTag('media', $vs_show_version, array_merge($va_display_options, array(
		'id' => ($vs_display_type == 'media_overlay') ? 'caMediaOverlayContentMedia' : 'caMediaDisplayContentMedia', 
		'viewer_base_url' => $this->request->getBaseUrlPath()
	)));
	# --- should the media be clickable to open the overlay?
	if($va_display_options['no_overlay'] || $vs_display_type == 'media_overlay'){
		print $vs_tag;
	}else{
		print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'OccurrenceMediaOverlay', 'GetOccurrenceMediaOverlay', array('object_id' => $t_object->getPrimaryKey(), 'representation_id' => $t_rep->getPrimaryKey(), 'occurrence_id' => $pn_occurrence_id))."\"); return false;' >".$vs_tag."</a>";
	}
?>
	</div><!-- end caMediaOverlayContent -->