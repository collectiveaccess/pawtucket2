<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Gallery/set_detail_timeline_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2017 Whirl-i-Gig
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
 	
	$t_set = $this->getVar("set");
?>
	<div class="row">
		<div class="col-sm-12">
			<H1><?php print $this->getVar("section_name"); ?>: <?php print $this->getVar("label")."</H1>"; ?>
			<?php print ($this->getVar("description")) ? "<p>".$this->getVar("description")."</p>" : ""; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php print $this->getVar("map"); ?>
		</div>
	</div>
	<div style="clear:both;"><!-- empty --></div>
