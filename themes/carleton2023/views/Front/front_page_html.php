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
			<div class='frontIntro'>{{{home_page_intro}}}</div>
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
			<H2>Explore the Collection</H2>
			<div class="row">
<?php
	if(is_array($va_classifications) && sizeof($va_classifications)){
		foreach($va_classifications as $vn_item_id => $va_classification){
			#print "<pre>";
			#print_r($va_classification);
			#print "</pre>";
			if(strToLower($va_classification["name_singular"]) == "default"){
				continue;
			}
			print "<div class='col-sm-12 col-md-6 frontClassificationCol'>";
			print caNavLink($this->request, "<div class='frontClassification'>".$va_classification["name_singular"]."</div>", "", "", "Browse", "collections", array("facet" => "classification_facet", "id" => $vn_item_id));
			print "</div>";
		}
	}
?>
			</div>
		</div>
	</div>

		</div><!--end col-sm-8-->	
	</div><!-- end row -->