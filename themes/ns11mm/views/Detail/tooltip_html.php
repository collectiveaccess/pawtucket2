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
<div class="tooltipText" style="width:250px; text-align:center;">
<?php
	if($this->getVar('tooltip_displayname')){
		print "<div style='text-align:center; font-size:14px;'>".$this->getVar('tooltip_displayname');
		print "</div>";
	}
	if($this->getVar('tooltip_lifespan')){
		print "<div style='text-align:center; font-size:11px; font-style:italic;'>".$this->getVar('tooltip_lifespan')."</div>";
	}	
	print "<div style='height:10px;'></div>";
	if($this->getVar('tooltip_relationship')){
		print "<div><b>".ucfirst($this->getVar('tooltip_relationship'))."</b></div>";
	}
	if($this->getVar('tooltip_birthplace')){
		print "<div><b>Birthplace: </b>".$this->getVar('tooltip_birthplace')."</div>";
	}	
	if($this->getVar('tooltip_residence')){
		print "<div><b>Residence: </b>".$this->getVar('tooltip_residence')."</div>";
	}
	if($this->getVar('tooltip_employer')){
		print "<div><b>Employer: </b>".$this->getVar('tooltip_employer')."</div>";
	}	
	if($this->getVar('tooltip_occupation')){
		print "<div><b>Occupation: </b>".$this->getVar('tooltip_occupation')."</div>";
	}	
	if($this->getVar('tooltip_floor')){
		print "<div><b>WTC floor worked: </b>".$this->getVar('tooltip_floor')."</div>";
	}	
?>
</div>