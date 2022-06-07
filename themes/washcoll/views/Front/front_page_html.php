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
		$t_lists = new ca_lists();
		$va_capstone = $t_lists->getItemFromList("object_types", "capstone");
		$vn_capstone_id = $va_capstone["item_id"];
		$va_archival_items = $t_lists->getItemFromList("object_types", "item");
		$vn_archival_item_id = $va_archival_items["item_id"];
?>
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2">
			<H1>{{{home_page_introduction}}}</H1>
		</div><!--end col-sm-8-->	
	</div><!-- end row -->
	<div class="row">
		<div class="col-xs-12 text-center">
			<H2>Explore</H2>
		</div>
	</div>
	<div class="row hpExploreButtons">
		<div class="col-xs-12 col-sm-4 <?php print ($this->request->isLoggedIn()) ? "" : "col-sm-offset-2"; ?> col-md-2 col-md-offset-<?php print ($this->request->isLoggedIn()) ? "3" : "4"; ?>">
			<?php print caNavLink($this->request, "Archival Items", "btn-default", "", "Browse", "objects", array("facet" => "type_facet", "id" => $vn_archival_item_id)); ?>
		</div><!--end col-sm-8-->
<?php
		if($this->request->isLoggedIn()){
?>
		<div class="col-xs-12 col-sm-4  col-md-2">
			<?php print caNavLink($this->request, "Capstones", "btn-default", "", "Browse", "objects", array("facet" => "type_facet", "id" => $vn_capstone_id)); ?>
		</div><!--end col-sm-8-->
<?php
		}
?>
		<div class="col-xs-12 col-sm-4  col-md-2">
			<?php print caNavLink($this->request, "Collections", "btn-default", "", "Collections", "Index"); ?>
		</div><!--end col-sm-8-->	
	</div><!-- end row -->
