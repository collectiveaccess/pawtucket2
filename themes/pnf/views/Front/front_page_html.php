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
			<h1 class="entry-title">Database</h1>
			<p>
				The Database portion of Comedias Sueltas USA is the heart of the website. This searchable union catalog is a comprehensive source of comedias sueltas held in US academic and research libraries. Scholars working in this specialized field will are able to locate individual copies or groups of comedias using an array of search fields in addition to author and title: translator, printer, publisher, bookseller, place and date of publication, thematic content, provenance, holding institution, and other useful categories. We have made public the first iteration of this growing database, initially representing major collections of comedias sueltas. Please check the “Zarzuela” link above for regular updates about the status of the site, and thank you for visiting!
			</p>
		</div><!--end col-sm-8-->	
	</div><!-- end row -->
</div> <!--end container-->
<hr>
<?php
	print $this->render("Front/featured_set_slideshow_html.php");
?>