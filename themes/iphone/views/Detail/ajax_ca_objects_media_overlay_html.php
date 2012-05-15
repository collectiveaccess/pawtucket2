<?php
/* ----------------------------------------------------------------------
 * views/editor/objects/ajax_object_representation_info_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
 	$pn_object_id 			= $this->getVar('object_id');
	$t_rep 					= $this->getVar('t_object_representation');	
	$vn_representation_id 	= $t_rep->getPrimaryKey();
	
	$pn_previous_id 		= $this->getVar('previous_rep_id');
	$pn_next_id 			= $this->getVar('next_rep_id');
	
	$va_reps 				= $this->getVar('reps');
	$vs_display_version 	= $this->getVar('rep_display_version');
	$va_display_options		= $this->getVar('rep_display_options');
	
?>
	<div id="caMediaOverlayContent">
		<a href="#" onclick="window.location.reload();"><?php print $t_rep->getMediaTag('media', $vs_display_version, $va_display_options); ?></a>
		<div id="caMediaOverlayCaption"><?php print _t("pinch to zoom"); ?></div>
	</div><!-- end caMediaOverlayContent -->