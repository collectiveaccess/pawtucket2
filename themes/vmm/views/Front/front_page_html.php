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
		<div class="col-sm-12 col-md-6 col-md-offset-3 text-center">
			<br/><H1>{{{home_page_tagline}}}</H1>
			<p>
				{{{home_page_intro}}}
			</p>
			<br/><br/><br/>
		</div><!--end col-sm-8-->
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2 text-center">
			<H2>Explore the Collection</H2>
			<div class="row tileLinks">
				<div class="col-sm-4">
		<?php
					print caNavLink($this->request, caGetThemeGraphic($this->request, 'compass.jpg'), "", "", "Browse", "artworks");
					print "<br/>".caNavLink($this->request, "Collection Objects", "", "", "Browse", "collection_objects");
		?>
				</div><!--end col-sm-4-->
				<div class="col-sm-4">
		<?php
					print caNavLink($this->request, caGetThemeGraphic($this->request, 'ship.jpeg'), "", "", "Browse", "archival");
					print "<br/>".caNavLink($this->request, "Archival Items", "", "", "Browse", "archival_items");
		?>
				</div> <!--end col-sm-4-->
				<div class="col-sm-4">
		<?php
					print caNavLink($this->request, caGetThemeGraphic($this->request, 'shipinterior_web.png'), "", "", "Browse", "exhibitions");
					print "<br/>".caNavLink($this->request, "Collections", "", "", "Collections", "Index");
		?>			
				</div> <!--end col-sm-4-->	
			</div><!-- end row -->	
		</div>
	</div>
</div><!-- end container -->
	<div class="bgLtGray">
<?php
		print $this->render("Front/gallery_slideshow_html.php");
?>	
	</div><!-- end bgGray -->