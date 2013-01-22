<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Results/ca_objects_result_tooltip_html.php :
 * 		thumbnail search results
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
?>
<div class="tooltipImage">
<?php
	if(!$this->getVar('tooltip_no_image')){
		print $this->getVar('tooltip_representation');
	}
?>
</div>
<div class="tooltipCaption">
<?php
	if($this->getVar('tooltip_title')){
		print "<div><b>TITLE:</b> ";
		print (unicode_strlen($this->getVar('tooltip_title')) > 200) ? substr(strip_tags($this->getVar('tooltip_title')), '0', '200')."..." : $this->getVar('tooltip_title');
		print "</div>";
	}
	if($this->getVar('tooltip_idno')){
		print "<div><b>ID:</b> ";
		print $this->getVar('tooltip_idno');
		print "</div>";
	}	
	if($this->getVar('tooltip_caption')){
		print "<div>".$this->getVar('tooltip_caption')."<br/><br/></div>";
	}
	if($this->getVar('tooltip_vaga')){
		print "<div>Reproduction of this image, including downloading, is prohibited without written authorization from VAGA, 350 Fifth Avenue, Suite 2820, New York, NY 10118. Tel: 212-736-6666; Fax: 212-736-6767; e-mail:info@vagarights.com; web: <a href='www.vagarights.com' target='_blank'>www.vagarights.com</a></div>";
	}
?>
</div>