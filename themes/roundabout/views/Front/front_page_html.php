<?php
/** ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2019 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
	$access_values = caGetUserAccessValues();
	$o_front_config = caGetFrontConfig();
	
	$sets = $this->getVar('sets');
	
?>
	<div class="row">
		<div class="col-sm-12 pt-3 pb-3">
			<p class="tagline">{{{hometagline}}}</p>
		</div><!--end col -->	
	</div><!-- end row -->

	
<?php	
	if(is_array($sets) && sizeof($sets)){		
	    foreach($sets as $set) {
	        print "<pre>".print_R($set, true)."</pre>\n";
?>
	<div class="row mt-5">
		<div class="col-md-6 mt-5">
			<H1><?php print $set['name']; ?></H1>
		</div>
		<div class="col-md-6 mt-5 text-right">
<?php
			print caNavLink(_t("View All"), "btn btn-sm btn-primary", "", "Gallery", "Index");
?>
		</div>
	</div>

<?php
        }
	}
