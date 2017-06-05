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
 	<div id="page-name">
        <h1 id="archives" class="title">Archives</h1>
	</div>
<?php	
		print $this->render("Front/featured_set_slideshow_html.php");
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<p>The Noguchi Museum’s Archives on the life and work of Isamu Noguchi are comprised of Noguchi’s manuscripts, correspondence, exhibitions and project records, sketchbooks, architectural drawings and plans, as well as objects and artifacts that Noguchi collected during his travels throughout his lifetime.   </p>
			<h2>Photo Archives</h2>
			<p>The Museum's Archives house a vast photography collection of over 17,000 images dating from the early 1900s through the present day. Photographs depict Noguchi’s artworks, exhibitions, studios, portraits and travels in multiple formats.</p>
			<p>To request permission to publish a photograph, please email <a href="archives@noguchi.org">archives@noguchi.org</a>.</p>
			<h2>Information for On-Site Researchers</h2>
			<p>The Archives and Photo Archives are accessible by appointment only. Please contact the Archives at <a href="archives@noguchi.org">archives@noguchi.org</a>. Allow 2 to 4 weeks advance notice for appointments.</p>
			
		</div><!--end col-sm-12-->
	
	</div><!-- end row -->
</div> <!--end container-->