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
	$t_object = $this->getVar('t_subject');
	$t_rep = $this->getVar('t_object_representation');
	$vs_show_version = $this->getVar('version');
	$va_versions = $this->getVar('versions');
	
	if (!$vs_show_version) { $vs_show_version = 'tilepic'; }
?>
	<div class="objectRepresentationOverlayControls">
		
	</div>
	<div id="objectRepresentationOverlayContent">
<?php
		switch($vs_show_version) {
			case 'tilepic':
				print $t_rep->getMediaTag('media', $vs_show_version, array(
					'viewer_base_url' => __CA_URL_ROOT__, 'id' => 'objectRepresentationOverlayContentMedia', 'directly_embed_flash' => true, 'viewer_width' => "100%", 'viewer_height' => "95%"))."<br/>";
				break;
			case 'flv':
				print $t_rep->getMediaTag('media', $vs_show_version, array(
					'viewer_base_url' => __CA_URL_ROOT__,
					'id' => 'objectRepresentationOverlayContentMedia', 
					'directly_embed_flash' => true, 
					'viewer_width' => "100%", 'viewer_height' => "95%",
					'data_url' => caNavUrl($this->request, '', 'ObjectDetail', 'getRepresentationInfoAsJSON', array('representation_id' => $t_rep->getPrimaryKey(), 'object_id' => $t_object->getPrimaryKey()))
				))."<br/>";
				break;
			default:
				print $t_rep->getMediaTag('media', $vs_show_version, array('viewer_base_url' => __CA_URL_ROOT__, 'id' => 'objectRepresentationOverlayContentMedia', 'viewer_width' => '800', 'viewer_height' => '525', 'embed' => true, 'poster_frame_url' => $t_rep->getMediaUrl('media', 'medium')))."<br/>";
				
				break;
		}
?>
	</div>