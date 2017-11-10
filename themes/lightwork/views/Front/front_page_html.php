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
	<div class="row">
		<div class="col-sm-12">
			<h1>
			<p>The Light Work Collection consists primarily of work made by artists who have participated in the Artist-in-Residence Program and past Light Work Grant recipients. Because we encourage participation by a variety of emerging and under-recognized artists, Light Work’s collection is an extensive and diverse archive for the mapping of trends and developments in contemporary photography. This noteworthy collection includes all genres of expression found in contemporary photography, including documentary, abstract, experimental, and conceptual work. Many of the images capture and document the social history of the Central and Upstate New York regions. The collection also serves as an important document of Light Work’s history of support for artists and their creative process.</p>
			<p>For more info <?php print caNavLink($this->request, 'click here', '', '', 'About', 'Index');?>.</p>
			</h1>
		</div><!--end col-sm-8-->
	
	</div><!-- end row -->