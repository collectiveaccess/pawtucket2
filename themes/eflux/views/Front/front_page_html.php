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
			<H1>The e-flux reading room is a continuously growing collection of publications related to contemporary art donated by institutions and individuals from around the world. Browse selections from the library above and access digital publications in PDF format via the link to the right. For more information about the project click <?php print caNavLink($this->request, 'HERE', '', '', 'About', 'Index');?></H1>
		</div><!--end col-sm-8-->
		<div class="col-sm-4 borderleft">
<?php
		print caNavLink($this->request, caGetThemeGraphic($this->request, 'browsedigi.png'), '', 'Browse', 'objects', '/facet/category_facet/id/317');
		print "<div class='browsedigi'>".caNavLink($this->request, 'Browse Digital Publications', '', 'Browse', 'objects', '/facet/category_facet/id/317')."</div>";
?>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
</div> <!--end container-->