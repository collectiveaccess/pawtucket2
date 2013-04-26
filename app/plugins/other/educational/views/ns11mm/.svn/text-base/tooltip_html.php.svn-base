<?php
/* ----------------------------------------------------------------------
 * app/plugins/simpleGallery/tooltip_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
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
 
?>
<div class="tooltipText">
<?php
	if($this->getVar('tooltip_image')){
		print "<div style='text-align:center; margin-bottom:10px;'>".$this->getVar('tooltip_image');
		if($this->getVar('tooltip_image_name')){
			print "<div style='font-style:italic; font-size:11px;'>".$this->getVar('tooltip_image_name')."</div>";
		}
		print "</div>";
	}
	if($this->getVar('tooltip_text')){
		print "<div style='text-align:center; width:400px;'>".$this->getVar('tooltip_text')."</div>";
	}
?>
</div>