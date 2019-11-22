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
			<H1>Welcome to the Steelcase digital art collection!</H1>
			<ul class="introText">
				<li>The database works best in Chrome, Safari, and Firefox</li>
				<li>The digital collection provides employees the opportunity to view works in the collection beyond your workspace</li>
				<li>The majority of the collection is copyright protected by the artist, please adhere to copyright laws when downloading images</li>
				<li>For information on use of photographs/images of copyrighted works read this <a href="http://www.wipo.int/wipo_magazine/en/2006/02/article_0010.html">article</a> by the WIPO or contact the <a href="https://spark.steelcase.com/docs/DOC-38047">Steelcase Legal Team</a></li>
				<li>For any questions, comments or artwork requests, contact <a href="mailto:art@steelcase.com">art@steelcase.com</a></li>
				<li>Explore, become inspired, and have fun!</li>
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
