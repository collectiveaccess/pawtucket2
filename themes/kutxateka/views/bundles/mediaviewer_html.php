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
	
	if($vs_display_type == 'media_overlay'){
?>
		<div id="caMediaOverlayContent"><a href="#" class="close">&nbsp;</a>
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
		print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $t_object->getPrimaryKey(), 'representation_id' => $t_rep->getPrimaryKey()))."\"); return false;' >".$vs_tag."</a>";
	}
	if($vs_display_type == 'media_overlay'){
		print "</div><!-- end caMediaOverlayContent -->";
	}
?>