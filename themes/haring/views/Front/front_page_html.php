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
	#print "<div class='banner'>".caGetThemeGraphic($this->request, 'banner.jpg')."</div>";
?>
<div class="container">
	<div class="row" style='margin-top:20px;'>
		<div class="col-sm-8">
			<H1>Welcome to the Keith Haring Foundation Research Portal.</H1>
			<div style='padding-bottom:10px;'>
				To begin, select a Lightbox from the list at right, or access your user profile from the main menu. Access to this Lightbox is for a limited period of time and may be subject to change.
			</div>
			<div>
				The material that is accessed through this portal is for noncommercial, educational and scholarly uses only. Unauthorized reproduction of images and content is strictly prohibited. If you would like to reprint or distribute the material you access on this site for any reason, please contact The Keith Haring Foundation to seek permission.
			</div>
		</div><!--end col-sm-8-->
		<div class="col-sm-4">
<?php
		print $this->render("Front/gallery_set_links_html.php");
?>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->