<?php
/* ----------------------------------------------------------------------
 * views/bundles/mediaviewer_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2011-2013 Whirl-i-Gig
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
$t_object 					= $this->getVar('t_object');
$va_display_options		 	= $this->getVar('display_options');
$vs_display_type		 	= $this->getVar('display_type');
$vs_show_version 			= $this->getVar('version');
$vs_container_id 			= $this->getVar('containerID');
$va_reps 					= $this->getVar('reps');

if (!$t_object) { print caPrintStackTrace(); }
$vn_object_id = $t_object->getPrimaryKey();

# --- when linked to from authority detail pages, use session var to make next and previous nav between reps
$va_authority_objects_results = $this->request->session->getVar("repViewerResults");
	
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
				print "<a href='#' ".(($vn_rep_id == $vn_representation_id) ? "class='selectedRep' " : "")."onClick='jQuery(\"#{$vs_container_id}\").load(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('representation_id' => (int)$vn_rep_id, 'object_id' => (int)$vn_object_id))."\");'>".$va_rep_info['tags'][$vs_version]."</a>";
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
	<div class='close viewer'><a href="#" onclick="caMediaPanel.hidePanel(); return false;" title="close">&nbsp;X&nbsp;Close</a></div>

	<div class="caMediaOverlayControls">
<?php
			if(caObjectsDisplayDownloadLink($this->request)){
?>
				<div class='download'>
<?php 
						# -- get version to download configured in media_display.conf
						$va_download_display_info = caGetMediaDisplayInfo('download', $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
						$vs_download_version = $va_download_display_info['display_version'];
						print caNavLink($this->request, caGetThemeGraphic($this->request, 'buttons/downloadWhite.png', array('title' => _t("Download Media"))), '', '', 'Detail', 'DownloadRepresentation', array('representation_id' => $t_rep->getPrimaryKey(), "object_id" => $vn_object_id, "download" => 1, "version" => $vs_download_version));
?>				
				</div>
<?php
			}
?>
			<div class='objectInfo'>
<?php
			if ($t_object->get('ca_objects.nonpreferred_labels.type_id') == '515') {
				$vs_label = $t_object->get('ca_objects.nonpreferred_labels.name');
			} else {
				$vs_label = $t_object->getLabelForDisplay();
			}
				$vn_obj_id = $t_object->get('ca_objects.object_id');
				print (mb_strlen($vs_label) > 80) ? caNavLink($this->request, mb_substr($vs_label, 0, 80)."...", '', '', 'Detail', 'Objects/'.$vn_obj_id) : caNavLink($this->request, $vs_label, '', '', 'Detail', 'Objects/'.$vn_obj_id);
				
				if($t_object->get("idno")){
					print " [".$t_object->get("idno")."]";
				}
?>			
			</div>
			<div class='repNav'>
<?php
				if(is_array($va_authority_objects_results) && (sizeof($va_authority_objects_results) > 1)){
					$vn_previous_auth_result_object_id = "";
					$vn_previous_auth_result_representation_id = "";
					$vn_next_auth_result_object_id = "";
					$vn_next_auth_result_representation_id = "";
					foreach($va_authority_objects_results as $vn_key => $va_authority_objects_result){
						if($va_authority_objects_result["object_id"] == $t_object->get("object_id")){
							$vn_current_object_key = $vn_key;
							break;
						}
					}
					if($va_previous_auth = $va_authority_objects_results[$vn_current_object_key-1]){
						$vn_previous_auth_result_object_id = $va_previous_auth["object_id"];
						$vn_previous_auth_result_representation_id = $va_previous_auth["representation_id"];
					}
					if($va_next_auth = $va_authority_objects_results[$vn_current_object_key+1]){
						$vn_next_auth_result_object_id = $va_next_auth["object_id"];
						$vn_next_auth_result_representation_id = $va_next_auth["representation_id"];
					}
					if ($vn_previous_auth_result_object_id) {
						print "<a href='#' onClick='jQuery(\"#{$vs_container_id}\").load(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('representation_id' => (int)$vn_previous_auth_result_representation_id, 'object_id' => (int)$vn_previous_auth_result_object_id))."\");'>←</a>";
					}
					if (sizeof($va_authority_objects_results) > 1) {
						print ' '._t("%1 of %2", ($vn_current_object_key + 1), sizeof($va_authority_objects_results)).' ';
					}
					if ($vn_next_auth_result_object_id) {
						print "<a href='#' onClick='jQuery(\"#{$vs_container_id}\").load(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('representation_id' => (int)$vn_next_auth_result_representation_id, 'object_id' => (int)$vn_next_auth_result_object_id))."\");'>→</a>";
					}
				}else{
					if ($vn_id = $this->getVar('previous_representation_id')) {
						print "<a href='#' onClick='jQuery(\"#{$vs_container_id}\").load(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('representation_id' => (int)$vn_id, 'object_id' => (int)$vn_object_id))."\");'>←</a>";
					}
					if (sizeof($va_reps) > 1) {
						print ' '._t("%1 of %2", $this->getVar('representation_index'), sizeof($va_reps)).' ';
					}
					if ($vn_id = $this->getVar('next_representation_id')) {
						print "<a href='#' onClick='jQuery(\"#{$vs_container_id}\").load(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('representation_id' => (int)$vn_id, 'object_id' => (int)$vn_object_id))."\");'>→</a>";
					}
				}
?>
			</div>
	</div><!-- end caMediaOverlayControls -->
<?php
}
?>
	<div id="<?php print ($vs_display_type == 'media_overlay') ? 'caMediaOverlayContent' : 'caMediaDisplayContent'; ?>">
<?php
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
		print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $vn_object_id, 'representation_id' => $t_rep->getPrimaryKey(), 'overlay' => 1))."\"); return false;' >".$vs_tag."</a>";
	}
?>
	</div><!-- end caMediaOverlayContent/ caMediaDisplayContent -->