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
	<div class="col-sm-12" style="background-color: lightblue; padding: 20px 20px 5px 20px;">
			<p>The UAG is closed to the public until further notice. All programs, events and tours have been canceled. For more information about the UAG’s response to COVID-19, <a href="https://uag.pitt.edu/index.php/About/covidresponse">please click here</a>.</p>
		</div><!--end col-sm-12-->
			<div class="col-sm-8">
			<p>&nbsp;</p>
			<p>The University Art Gallery (UAG) is located in the Frick Fine Arts Building in the heart of Pittsburgh’s Oakland neighborhood.  Administered by the Department of History of Art and Architecture, the UAG is the major repository of art at the University of Pittsburgh, with a collection of more than 3,000 objects from around the world and from a diverse range of periods. Gallery holdings include some valuable American paintings, a rich collection of European, British and American works on paper, Inuit carvings, and Japanese and Chinese scrolls and sculpture.</p>
			<p>The UAG showcases the work of faculty and students in the history of art and architecture and in studio arts. As a teaching gallery, the UAG is deeply involved in the development of aspiring museum professionals and oversees training in areas of curating and collection management.  </p>
		</div><!--end col-sm-8-->
		<div class="col-sm-4">
		<p>&nbsp;</p>
<?php
		print $this->render("Front/gallery_set_links_html.php");
?>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->