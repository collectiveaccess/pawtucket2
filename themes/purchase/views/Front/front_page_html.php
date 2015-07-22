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
		#print $this->render("Front/featured_set_slideshow_html.php");
?>
<div class="container">
	<div class="row">
		<div class="col-sm-6">
			<h2>Purchase College, SUNY Student Projects digital repository</h2>
			<p>Welcome to the Purchase College, SUNY Student Projects digital repository. Browse and search the culminating scholarly experiences of Purchase College graduate and undergraduate students including senior projects, capstone papers, and master’s theses. Projects from [# majors] from the School of Liberal Arts and Sciences, [# majors] from the School of the Arts, and the School of Liberal Studies & Continuing Education are represented in the digital repository. Presently, the digital repository includes projects from [YEAR] to the present. To request an older project, please contact us.</p>
		</div><!--end col-sm-8-->
		<div class="col-sm-6">
		<div class='searchDiv'>
<?php
		print "<h2>Find & Discover</h2>";  
		
		caSetAdvancedSearchFormInView($this, 'objects', "Search/ca_objects_advanced_search_html.php", array('controller' => 'Search', 'request' => $this->request));
		print $this->render("Search/ca_objects_advanced_search_html.php");
?>
		</div>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->