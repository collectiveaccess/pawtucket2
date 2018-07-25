<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Lightbox/set_list_item_placeholder_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
 
	$vs_lightbox_displayname = $this->getVar('lightbox_displayname');	
	$vs_spacer = caGetThemeGraphic($this->request,'spacer.png');
?>
<a href='#' onclick='caMediaPanel.showPanel("<?php print caNavUrl($this->request, '', '*', 'setForm', array()); ?>"); return false;' >
<div class='lbSet'><div class='lbSetContent'>
	<H5><?php print _t("Create your first %1", $vs_lightbox_displayname); ?></H5>
	<div class='row'><div class='col-sm-6'><div class='lbSetImgPlaceholder'><br/><br/></div><!-- end lbSetImgPlaceholder --></div><div class='col-sm-6'>
		<div class='row lbSetThumbRow'>
			<div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumbPlaceholder'><?php print $vs_spacer; ?></div><!-- end lbSetThumbPlaceholder --></div>
			<div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumbPlaceholder'><?php print $vs_spacer; ?></div><!-- end lbSetThumbPlaceholder --></div>
			<div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumbPlaceholder'><?php print $vs_spacer; ?></div><!-- end lbSetThumbPlaceholder --></div>
			<div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumbPlaceholder'><?php print $vs_spacer; ?></div><!-- end lbSetThumbPlaceholder --></div>
		</div><!-- end row --></div><!-- end col -->
	</div><!-- end row -->
</div><!-- end lbSetContent --></div><!-- end lbSet -->
</a>
