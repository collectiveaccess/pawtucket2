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
			<H1>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.</H1>
		</div><!--end col-sm-8-->
		<div class="col-sm-4">
<?php
		print $this->render("Front/gallery_set_links_html.php");
?>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->
<?php
	if ($this->request->session->getVar('visited') != 'has_visited') {		
?>	
		<div id="homePanel">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 col-md-4 col-lg-4 leftSide">
<?php
						print caGetThemeGraphic($this->request, 'homelogo.png');
?>					
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6 rightSide">			
						<h1>Welcome to the BAM Leon Levy Digital Archive</h1>
						<p>Please search the archive above or watch this informative video which outlines the basic structure and functionality of the archive.</p>
						<p>Looking for tickets to an upcoming event at BAM?  <a href='http://www.bam.org'>Click here</a>, you're close but in the wrong place.</p>
					</div>	
					<div class="col-sm-2 col-md-2 col-lg-2">
						<div class="close">
<?php
							print "<a href='#' onclick='$(\"#homePanel\").fadeOut(400);'>".caGetThemeGraphic($this->request, 'homex.png')."</a>";
?>	
						</div>			
					</div>
				</div><!-- end row -->
			</div> <!--end container-->	
		</div>	<!--end homePanel-->
<?php
	}
?>