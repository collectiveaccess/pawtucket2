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
		<div class="col-sm-7">
			<H4>Welcome to the Collection</H4>
			<p>Through dedicated funding from the Leon Levy Foundation, the Roundabout Theatre Company Archives launched in 2008. During your visit, you'll discover production photographs, publicity materials, set and costume sketches, scripts, audio and video, cast recordings, costumes, institutional records, theatre reconstruction documentation, and records chronicling our education program.</p>
			<p>This collection reflects the scope of our work as a producing company managing five unique stages, both on and off Broadway. Whether you've come to discover more of our rich history, search our records for your own research, or just relive past productions, we hope you'll enjoy learning about Roundabout's growth from a small off-Broadway theatre to our place today as one of the country's most influential not-for-profit cultural organizations.</p>
		</div><!--end col-sm-8-->
		<div class="col-sm-1"></div>
		<div class="col-sm-4">
			<div class="promo-block">
				<div class="shadow"></div>
				<h3>Contact the <br/>Archivist</h3>
				<p>Call 212.719.9393 or <a href="mailto:archives@roundabouttheatre.org">email us</a>.</p>
				<p>Want access to our physical archives?</p>
<?php
				print "<p><a class='downloadAccess' href='".$this->request->getThemeUrlPath()."/assets/pawtucket/files/RoundaboutTheatreCompany_Archives_PhysicalAccessForm.pdf'>Download Access Form</a></p>";

?>	
			<!--end .promo-block -->
    		</div>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->