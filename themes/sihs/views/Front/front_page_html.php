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
		<div class="col-sm-4">
			<H1>Welcome to the Digital Archive of the Shelter Island Historical Society</H1>
		</div><!--end col-sm-8-->
		<div class="col-sm-8">
			<p>The images displayed above represent a randomly selected portion of the Shelter Island Historical Society's Collective Access database. They have been reduced in resolution for this display.   Feel free to scroll left or right to view all of them.</p> 

			<p>These images are intended only to provide an overview of the increasing collection of digital images the Society is creating.  In the near future, all of the Society's digital images will become available at significantly higher resolution (typically 300 pixels per inch) to selected researchers, at fees yet to be determined.  Please contact the <?php print caNavLink($this->request, _t("Archivist"), "", "", "Contact", "Form"); ?> for information on any image/subject that might be of interest to you.</p>
<?php
		#print $this->render("Front/gallery_set_links_html.php");
?>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->