<?php
/* ----------------------------------------------------------------------
 * views/chronology/ajax_chronology_representation_info_html.php : 
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
	$pn_object_id 				= $this->getVar('object_id');
	$t_rep 						= $this->getVar('t_object_representation');
	$vs_display_version 		= $this->getVar('display_version');
	$va_display_options	 		= $this->getVar('display_options');
	
	$va_versions 				= $this->getVar('versions');	
	$vn_representation_id 		= $t_rep->getPrimaryKey();
	$va_reps 					= $this->getVar('reps');
	$pn_year					= $this->getVar('year');
	$vs_caption					= $this->getVar('caption');
	$vs_photographer			= $this->getVar('photographer');
	$vs_container_id 			= $this->getVar('containerID');
	
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
				print "<a href='#' ".(($pn_object_id == $vn_object_id) ? "class='selectedRep' " : "")."onClick='jQuery(\"#caMediaPanelContentArea\").load(\"".caNavUrl($this->request, '', 'Chronology', 'GetChronologyMediaOverlay', array('representation_id' => (int)$va_rep_info["representation_id"], 'object_id' => (int)$vn_object_id, 'year' => (int)$pn_year))."\");'>".$va_rep_info['rep_'.$vs_version]."</a>";
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
			# --- caption text
			if($vs_caption || $vs_photographer){
				# --- get width of image so caption matches
				$va_media_info = $t_rep->getMediaInfo('media', $vs_display_version);
				if($vs_caption){
					print "<i>".$vs_caption."</i>";
				}
				if($vs_caption && $vs_photographer){
					print " &ndash; ";
				}
				if($vs_photographer){
					print _t("Photograph").": ".$vs_photographer;
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
					print "<a href='#' onClick='jQuery(\"#caMediaPanelContentArea\").load(\"".caNavUrl($this->request, '', 'Chronology', 'GetChronologyMediaOverlay', array('representation_id' => (int)$this->getVar('previous_representation_id'), 'object_id' => (int)$this->getVar('previous_object_id'), 'year' => (int)$pn_year))."\");'>←</a>";
				}
				if (sizeof($va_reps) > 1) {
					print ' '._t("%1 of %2", $this->getVar('representation_index'), sizeof($va_reps)).' ';
				}
				if ($this->getVar('next_representation_id')) {
					print "<a href='#' onClick='jQuery(\"#caMediaPanelContentArea\").load(\"".caNavUrl($this->request, '', 'Chronology', 'GetChronologyMediaOverlay', array('representation_id' => (int)$this->getVar('next_representation_id'), 'object_id' => (int)$this->getVar('next_object_id'), 'year' => (int)$pn_year))."\");'>→</a>";
				}
?>
			</div>
	</div><!-- end caMediaOverlayControls -->
	<div id="caMediaOverlayContent">
		<div class='closeUpperLeft'><a href="#" onclick="caMediaPanel.hidePanel(); return false;" title="close">&nbsp;&nbsp;&nbsp;</a></div>
<?php
	// return standard tag
	if (!is_array($va_display_options)) { $va_display_options = array(); }
	print $t_rep->getMediaTag('media', $vs_display_version, array_merge($va_display_options, array(
		'id' => 'caMediaOverlayContentMedia', 
		'viewer_base_url' => $this->request->getBaseUrlPath()
	)));

?>
</div><!-- end caMediaOverlayContent -->