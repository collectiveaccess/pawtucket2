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

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	
	

?>

	<div class="title">
		<h1 class="title" style='font-size:16px;'><?php print $t_item->getLabelForDisplay();?></h1>
	</div>
		
<?php
	if ($vs_extent = $t_item->getWithTemplate('<unit relativeTo="ca_collections.extentDACS"><ifdef code="ca_collections.extentDACS.extent_value">^ca_collections.extentDACS.extent_value ^ca_collections.extentDACS.extent_type</ifdef></unit>')) {
		print "<div class='unit' style='font-size:12px;'><h6>Extent of Holdings</h6>".$vs_extent."</div>";
	}
	if ($vs_admin = $t_item->get('ca_collections.adminbiohist')) {
		print "<div class='unit' style='font-size:12px;'><h6>About</h6>".$vs_admin."</div>";
	}
	if ($vs_scope = $t_item->get('ca_collections.scopecontent')) {
		print "<div class='unit' style='font-size:12px;'><h6>Description</h6>".$vs_scope."</div>";
	}	
	if ($vs_subjects = $t_item->get('ca_collections.lcsh_terms', array('delimiter' => '<br/>'))) {
		print "<div class='unit' style='font-size:12px;'><h6>Subjects</h6>".$vs_subjects."</div>";
	}
	if ($vs_tgm = $t_item->get('ca_collections.tgm', array('delimiter' => '<br/>'))) {
		print "<div class='unit' style='font-size:12px;'><h6>Thesaurus for Graphic Materials</h6>".$vs_tgm."</div>";
	}
	if ($vs_lc = $t_item->get('ca_collections.lc_names', array('delimiter' => '<br/>'))) {
		print "<div class='unit' style='font-size:12px;'><h6>Library of Congress Name Authority File</h6>".$vs_lc."</div>";
	}
	if ($vs_aat = $t_item->get('ca_collections.aat', array('delimiter' => '<br/>'))) {
		print "<div class='unit' style='font-size:12px;'><h6>Getty Art and Architecture Thesarus</h6>".$vs_aat."</div>";
	}
	if ($vs_ca_list = $t_item->get('ca_list_items.preferred_labels', array('delimiter' => '<br/>'))) {
		print "<div class='unit' style='font-size:12px;'><h6>North West Subjects</h6>".$vs_ca_list."</div>";
	}					
	if ($vs_entities = $t_item->get('ca_entities.preferred_labels', array('delimiter' => '<br/>', 'checkAccess' => $va_access_values))) {
		print "<div class='unit' style='font-size:12px;'><h6>Related People/Organizations</h6>".$vs_entities."</div>";
	}	
?>
	
	
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><div style='font-size:14px;font-weight:bold;margin-bottom:12px;'>Collection Contents</div>";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
	}
	print $this->render("pdfEnd.php");
?>
