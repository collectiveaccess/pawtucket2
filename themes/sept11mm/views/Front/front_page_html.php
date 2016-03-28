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
?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<H1>Collection Highlights</H1>
			</div>
		</div>
	</div>
<?php
		print $this->render("Front/featured_set_slideshow_html.php");
?>
<div class="container">
	<div class="row">
		<div class="col-sm-4">
			<H2>Features</H2>
<?php
		print $this->render("Front/gallery_set_links_html.php");
?>
		</div> <!--end col-sm-4-->
		<div class="col-sm-8 frontIntroText">
			<p>
				The Museum collects, preserves, documents, exhibits, interprets and makes available as a public learning resource the material evidence, primary testimony and expanding historical record of response to the terrorist events of February 26, 1993, and September 11, 2001, and their global repercussions.
 			</p>
 			<p>
				With the goal of serving as an authoritative gateway of information about these incidents, the Museum acquires wide-ranging materials in various media, for commemoration, education, display, publication and scholarship. The Permanent Collection functions as an extensive reservoir of historical facts, trustworthy content and cumulative insight that will deepen over time, with uses beyond physical exhibition.
 			</p>
 			<p>
				This website highlights a portion of the Permanent Collection including objects visible in the Museum but also highlighting objects that are currently not on display.  The content on this site is intended to expand to include the majority of our holdings and will eventually incorporate digital media and Oral Histories.
 			</p>
 			<p>
				The Collections Policy is available for review on the 9/11 Memorial’s website: <a href="http://www.911memorial.org" target="_blank">www.911memorial.org</a>.</p>
			</p>
		</div><!--end col-sm-8-->
	
	</div><!-- end row -->
</div> <!--end container-->