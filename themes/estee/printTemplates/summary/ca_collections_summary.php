<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/ca_collections_summary.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Collection Finding Aid
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_collections
 * @marginTop 0.75in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.75in
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");
	
	if($va_brand = $t_item->get('ca_collections.brand', array("returnAsArray" => true))){
		$vn_brand = $va_brand[0];
	}
	$vs_brand_img = "";
	if($vn_brand){
		$t_list_item = new ca_list_items();
		$t_list_item->load($vn_brand);
		$vs_brand_img = $t_list_item->get("ca_list_items.icon.large.path");
		if($vs_brand_img == "No media available"){
			$vs_brand_img = $t_list_item->get("ca_list_items.icon.square400.path");
		}
		$vs_brand_description = $t_list_item->get("ca_list_items.description");
	}

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	

?>
	<div class="title">
		<h1 class="title collectionLogo"><?php print ($vs_brand_img) ? "<img src='".$vs_brand_img."'>" : $t_item->getLabelForDisplay();?></h1>
	</div>
	
	
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><br/><div class='unit'>Exported on: ".date("d/m/Y")."</div><div class='unit'><H4>Table of Contents</H4></div>";
		print "<div class='toc'>".caGetCollectionLevelSummaryTOCEstee($this->request, array($t_item->get('ca_collections.collection_id')), 1)."</div>";
		print "<br/><div class='unit'><H4>Collection Contents</H4></div>";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummaryEstee($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
	}
	print $this->render("pdfEnd.php");





?>
