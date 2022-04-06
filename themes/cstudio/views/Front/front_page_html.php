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
		$va_access_values = $this->getVar("access_values");
		
		print $this->render("Front/featured_set_slideshow_html.php");
?>
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2">
			<div class='frontIntro'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec ligula erat. Pellentesque nibh leo, pharetra et posuere vel, accumsan vitae sapien.</div>
		</div><!--end col-sm-8-->	
	</div><!-- end row -->
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2">
<?php
# --- get the top level classifications to browse by
	$t_list = new ca_lists();
	$va_classifications = $t_list->getItemsForList("col_classification", array("directChildrenOnly" => 1, "extractValuesByUserLocale" => true, "checkAccess" => $va_access_values));

?>	
	<div class="row tanBg">
		<div class="col-md-12 col-lg-10 col-lg-offset-1">
			<H2>Explore the Catalogue</H2>
			<div class="row">
<?php
			print "<div class='col-sm-12 col-md-4 frontExploreCol'>".caNavLink($this->request, "<div class='frontExplore'>"._t("Artwork")."</div>", "", "", "Browse", "artwork")."</div>";
			print "<div class='col-sm-12 col-md-4 frontExploreCol'>".caNavLink($this->request, "<div class='frontExplore'>"._t("Bibliography")."</div>", "", "", "Browse", "bibliography")."</div>";
			print "<div class='col-sm-12 col-md-4 frontExploreCol'>".caNavLink($this->request, "<div class='frontExplore'>"._t("Exhibitions & Projects")."</div>", "", "", "Browse", "exhibitions")."</div>";

?>
			</div>
		</div>
	</div>

		</div><!--end col-sm-8-->	
	</div><!-- end row -->