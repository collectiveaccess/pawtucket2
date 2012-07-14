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
	$vs_display_version 		= $this->getVar('rep_display_version');
	$va_display_options	 		= $this->getVar('rep_display_options');
	
	$va_versions 				= $this->getVar('versions');	
	$vn_representation_id 		= $t_rep->getPrimaryKey();
	$va_thumbnails 				= $this->getVar('thumbnails');
	$pn_year					= $this->getVar('year');
	$vs_caption					= $this->getVar('caption');
	$vs_photographer			= $this->getVar('photographer');
	# --- view height is in % not pixels!
	# --- take some % off the viewer height to accommodate the capiton text
	$va_display_options['viewer_height'] = ($va_display_options['viewer_height'] - 3)."%";
	# --- if there are more than one reps, make the viewer height shorter to accommodate the thumbnails at the bottom
	if(sizeof($va_thumbnails) > 1){
		$va_display_options['viewer_height'] = ($va_display_options['viewer_height'] - 15)."%";
	}
?>
	<div class="caMediaOverlayControls"><!-- empty - need spaceer so can see close button --></div>
	<div id="caMediaOverlayContent">
<?php
		$va_display_options['id'] = '_caMediaOverlayMediaDisplay';
		print $t_rep->getMediaTag('media', $vs_display_version, $va_display_options);
		if($vs_caption || $vs_photographer){
			# --- get width of image so caption matches
			$va_media_info = $t_rep->getMediaInfo('media', $vs_display_version);
			print "<div class='chronologyImageCaption'>";
			if($vs_caption){
				print "<i>".$vs_caption."</i>";
			}
			if($vs_caption && $vs_photographer){
				print " &ndash; ";
			}
			if($vs_photographer){
				print _t("Photograph").": ".$vs_photographer;
			}
			print " &ndash; &copy; INFGM</div>";
		}
?>
<?php
	# --- get all reps and if there are more than one to display thumbnail links
	if(sizeof($va_thumbnails) > 1){
		print "<div id='caMediaOverlayThumbnails'>";
		# --- calculate with of div - we set the width so we can force side to side scrolling if there are a lot of reps
		print "<div style='width:".(74*(sizeof($va_thumbnails)))."px;'>";
		foreach($va_thumbnails as $vn_thumb_object_id => $va_rep_info){
			print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Chronology', 'GetChronologyMediaOverlay', array('object_id' => $vn_thumb_object_id, 'representation_id' => $va_rep_info['representation_id'], 'year' => $pn_year))."\"); return false;' >".$va_rep_info["rep"]."</a>";
		}
		print "</div></div><!-- caMediaOverlayThumbnails -->";
	}
?>
</div><!-- end caMediaOverlayContent -->