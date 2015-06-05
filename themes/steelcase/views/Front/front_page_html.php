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
			<H1>Welcome to the beta release of the Steelcase digital art collection!</H1>
			<ul class="introText">
				<li>The site works best in Chrome, Safari, and Firefox</li>
				<li>Only works in storage are viewable at this time</li>
				<li>Inventory of works-on-display will begin in June 2015</li>
				<li>Newly inventoried artwork will appear in stages beginning in July allowing you to learn about the inspirational artwork surrounding your workspace</li>
				<li>A mobile app allowing for customer/employee walking tours of select works on display is planned for release in late 2015</li>
				<li>Your feedback is appreciated and is extremely important for making Art.Steelcase.com a useful resource</li>
				<li>Explore and have fun!</li>
			</ul>
<?php 
			if($this->request->user->getLastLogout()){
				$vs_last_logout_date = "after ".date("F j, Y", $this->request->user->getLastLogout());
				print "<H2 class='lastLogIn'>".caNavLink($this->request, _t("See what changed since your last login")." <i class='fa fa-caret-right'></i>", "", "", "Search", "objects", array("search" => "modified:\"".$vs_last_logout_date."\""))."</H2>";
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