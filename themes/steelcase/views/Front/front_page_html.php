<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
	print $this->render("Front/featured_set_slideshow_html.php");
?>
<div class="container">
	<div class="row">
		<div class="col-sm-8">
			<H1>Welcome to the beta site for the Steelcase digital art collection!</H1>

			<H2>Only works that have been lightly inventoried are viewable in this phase of the project. Please note that some records may be incomplete or inaccurate.<br/><br/>
			If you can provide information for records such as title, creation date, artist, medium or anything else, please contact us at <a href="mailto:art@steelcase.com">art@steelcase.com</a>.<br/><br/>
			Explore and have fun. Your feedback is important for making this site a useful resource!</H2>
			<br/><br/>
<?php 
			if($this->request->user->getLastLogout()){
				$vs_last_logout_date = "after ".date("F j, Y", $this->request->user->getLastLogout());
				print "<H2>".caNavLink($this->request, _t("See what changed since your last login")." <i class='fa fa-caret-right'></i>", "", "", "Search", "objects", array("search" => "modified:\"".$vs_last_logout_date."\""))."</H2>";
			}
?>
		</div><!--end col-sm-8-->
		<div class="col-sm-4">
<?php
		print $this->render("Front/gallery_set_links_html.php");
?>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->