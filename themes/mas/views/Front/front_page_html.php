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
			print caGetThemeGraphic($this->request, '50logo.jpeg');
?>
		</div> <!--end col-sm-4-->	
		<div class="col-sm-8">
			Discover the rich history of the Museums Association of Saskatchewan (MAS) through our online collection of photographs, documents and oral histories. Search our entire collection of records to learn more about the association’s 50 years of supporting Saskatchewan museums including oral history interviews from past and present members of the MAS community, up to date photographs of our member museums and archival photographs from previous MAS conferences and celebrations.
		</div><!--end col-sm-8-->
	
	</div><!-- end row -->