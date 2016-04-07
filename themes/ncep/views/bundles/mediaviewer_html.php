<?php
/* ----------------------------------------------------------------------
 * views/bundles/mediaviewer_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2011-2015 Whirl-i-Gig
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

$t_rep 						= $this->getVar('t_object_representation');
$vn_representation_id 		= $t_rep->getPrimaryKey();
$vn_item_id					= $this->getVar('item_id');
$t_object 					= $this->getVar('t_object');
$va_display_options		 	= $this->getVar('display_options');
$vs_display_type		 	= $this->getVar('display_type');
$vs_poster_version			= $this->getVar('poster_version');
$vs_show_version 			= $this->getVar('version');
$vs_container_id 			= $this->getVar('containerID');
$va_reps 					= $this->getVar('reps');
	
if($vs_display_type == 'media_overlay'){
	if(sizeof($va_reps) > 1){
		$vs_version = "icon";
		$vn_num_cols = 1;
		if(sizeof($va_reps) > 5){
			$vn_num_cols = 2;
		}
		if(sizeof($va_reps) > 14){
			$va_reps = $t_object->getRepresentations(array('tinyicon'), null, array("return_with_access" => $va_access_values));
			$vs_version = "tinyicon";
			$vn_num_cols = 2;
		}
		
?>
		<!-- multiple rep thumbnails - ONLY for media overlay -->
		<div class="caMediaOverlayRepThumbs">
<?php
			$i = 0;
			foreach($va_reps as $vn_rep_id => $va_rep_info){
				print "<a href='#' ".(($vn_rep_id == $vn_representation_id) ? "class='selectedRep' " : "")."onClick='jQuery(\"#{$vs_container_id}\").load(\"".caNavUrl($this->request, '', '*', 'GetRepresentationInfo', array('representation_id' => (int)$vn_rep_id, 'object_id' => (int)$t_object->getPrimaryKey()))."\");'>".$va_rep_info['tags'][$vs_version]."</a>";
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
	<!-- Controls - only for media overlay -->
	<div class="caMediaOverlayControls">
		<div class='close'><a href="#" onclick="caMediaPanel.hidePanel(); return false;" title="close"><i class="fa fa-times"></i></a></div>
<?php
			if(caObjectsDisplayDownloadLink($this->request, (int)$t_object->getPrimaryKey()) && $this->request->user->canDoAction('can_download_media')){
?>
				<div class='download'>
<?php 
						# -- get version to download configured in media_display.conf
						$va_download_display_info = caGetMediaDisplayInfo('download', $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
						$vs_download_version = $va_download_display_info['display_version'];
						print caNavLink($this->request, "<i class=\"fa fa-download\"></i>", '', '', '*', 'DownloadRepresentation', array('representation_id' => $t_rep->getPrimaryKey(), "object_id" => $t_object->getPrimaryKey(), "download" => 1, "version" => $vs_download_version));
?>				
				</div>
<?php
			}
?>
			<div class='objectInfo'>
<?php
				$vs_label = $t_object->getLabelForDisplay();
				print (mb_strlen($vs_label) > 80) ? mb_substr($vs_label, 0, 80)."..." : $vs_label;
				
				if($t_object->get("idno")){
					print " [".$t_object->get("idno")."]";
				}
?>			
			</div>
			<div class='repNav'>
<?php
				if ($vn_id = $this->getVar('previous_representation_id')) {
					print "<a href='#' onClick='jQuery(\"#{$vs_container_id}\").load(\"".caNavUrl($this->request, '', '*', 'GetRepresentationInfo', array('representation_id' => (int)$vn_id, 'object_id' => (int)$t_object->getPrimaryKey()))."\");'>←</a>";
				}
				if (sizeof($va_reps) > 1) {
					print ' '._t("%1 of %2", $this->getVar('representation_index'), sizeof($va_reps)).' ';
				}
				if ($vn_id = $this->getVar('next_representation_id')) {
					print "<a href='#' onClick='jQuery(\"#{$vs_container_id}\").load(\"".caNavUrl($this->request, '', '*', 'GetRepresentationInfo', array('representation_id' => (int)$vn_id, 'object_id' => (int)$t_object->getPrimaryKey()))."\");'>→</a>";
				}
?>
			</div>
	</div><!-- end caMediaOverlayControls -->
<?php
}
?>
	<div <?php print ($vs_display_type == 'media_overlay') ? 'id="caMediaOverlayContent"' : ''; ?>>
<?php
	// return standard tag
	if (!is_array($va_display_options)) { $va_display_options = array(); }
	
	$va_display_options['help_load_url'] = caNavUrl($this->request, '', 'Detail', 'ViewerHelp');
	if ($this->request->isLoggedIn()) {
		$va_display_options['annotation_load_url'] = caNavUrl($this->request, '', 'Detail', 'GetAnnotations', array('object_id' => $t_object->getPrimaryKey(), 'representation_id' => $t_rep->getPrimaryKey(), 'item_id' => $vn_item_id));
		$va_display_options['annotation_save_url'] = caNavUrl($this->request, '', 'Detail', 'SaveAnnotations', array('object_id' => $t_object->getPrimaryKey(), 'representation_id' => $t_rep->getPrimaryKey(), 'item_id' => $vn_item_id));
		$va_display_options['read_only'] = false;
		$va_display_options['scale'] = $t_rep->getMediaScale('media');
	} else {
		$va_display_options['read_only'] = true;
	}
	
	
	$vs_tag = $t_rep->getMediaTag('media', $vs_show_version, array_merge($va_display_options, array(
		'id' => ($vs_display_type == 'media_overlay') ? 'caMediaOverlayContentMedia_'.$t_rep->getPrimaryKey() : 'caMediaDisplayContentMedia_'.$t_rep->getPrimaryKey(), 
		'viewer_base_url' => $this->request->getBaseUrlPath(), 'class' => ($vs_display_type == 'media_overlay') ? 'caMediaOverlayContentMedia' : '',
		'poster' => $this->getVar('poster'), 'posterURL' => $this->getVar('posterURL')
	)));
	
	# --- should the media be clickable to open the overlay?
	if($va_display_options['no_overlay'] || $vs_display_type == 'media_overlay'){
		print $vs_tag;
	}else{
		if ($t_object && $t_rep) {
			// Images get zoomed on click; everything else requires a click on the magnifying glass icon
			print $t_rep->representationIsOfClass('image') ? "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $t_object->getPrimaryKey(), 'representation_id' => $t_rep->getPrimaryKey(), 'overlay' => 1))."\"); return false;' >".$vs_tag."</a>" : $vs_tag;
		}
	}
?>
	</div><!-- end caMediaOverlayContent/ caMediaDisplayContent -->