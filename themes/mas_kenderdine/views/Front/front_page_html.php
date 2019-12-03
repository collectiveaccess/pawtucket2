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
	<div class="row maxWrapper">
		<div class="col-sm-4">
<?php
			print "<div class='logo'>".caGetThemeGraphic($this->request, 'logo 2013.jpg')."</div>";
?>
		</div> <!--end col-sm-4-->	
		<div class="col-sm-8">
			The University of Saskatchewan Art Collection consists of art objects acquired over the last 100+ years.  The collection is quite varied, and represents the artistic work of many cultures and art movements throughout recent history.  Of note are important early Canadian works and modernist works from North America and Europe.  The collection is well represented by Saskatchewan based artists that include alumni, members of the academic community, and attendees of the Emma Lake / Kenderdine Campus.  There is a large prairie folk art collection, as well as a significant collection of Indigenous art objects.  You can link to our website here: <a href="https://artsandscience.usask.ca/galleries/">https://artsandscience.usask.ca/galleries/</a>.
		</div><!--end col-sm-8-->
	 
	 <?php
			print "<div class='row maxWrapper'><div class='sm-col-10 resize'>".caGetThemeGraphic($this->request, 'usask_usask_colour.png')."</div></div>";
?>
	</div><!-- end row -->
