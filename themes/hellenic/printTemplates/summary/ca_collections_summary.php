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
 * @marginTop 1.25in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.75in
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");
	$t_list = new ca_lists();
	$vs_museum_id = $t_list->getItemIDFromList("collection_types", "museum_collection");	
		

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");
?>	
	<style>
	
		@font-face {
			font-family: Futura;
			src: url('<?php print $this->request->getThemeDirectoryPath()."/assets/pawtucket/css/fonts/";?>FuturaPTBook.ttf') format('truetype');
		}
		@font-face {
			font-family: Nunito;
			src: url('<?php print $this->request->getThemeDirectoryPath()."/assets/pawtucket/css/fonts/";?>Nunito-SemiBold.ttf') format('truetype');
		}				
		.unit, .collectionLink {font-family:Futura;}
		h6 { font-family: Nunito; }
		.relatedObj { width:350px; float:left; height:110px;display:inline-block;margin-top:10px;border-bottom:1px solid #ddd;margin-bottom:2px;}
		.icon img {height:100px; width:auto; max-width:150px;display:inline-block;}
		.icon {width:150px; height:110px; text-align:left;display:inline-block;}
		.text { width: 200px;display:inline-block; height:120px;vertical-align:middle;}
		
	</style>		
<?php
	if ($vs_type_id == $vs_museum_id) {
		print "<div class='unit'><h6>Collection Name</h6><div class='data'>".$t_item->get('ca_collections.preferred_labels')."</div></div>";
		if ($vs_description = $t_item->get('ca_collections.description')) {
			print "<div class='unit'><h6>Collection Description</h6>".$vs_description."</div>";
		}
	} else {
		print "<div class='unit'><h6>Collection Title</h6>".$t_item->get('ca_collections.preferred_labels')."</div>";
		if ($vs_idno = $t_item->get('ca_collections.idno')) {
			print "<div class='unit'><h6>Collection Identifier</h6>".$vs_idno."</div>";
		}
		if ($vs_dates = $t_item->get('ca_collections.unitdate', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
			$va_dates_array = array();
			foreach ($vs_dates as $va_key => $vs_date_info) {
				foreach ($vs_date_info as $va_key => $vs_date) {
					if ($vs_date['dacs_date_value']) {
						$va_dates_array[$vs_date['dacs_dates_types']][] = $vs_date['dacs_date_value'];
					}
				}
			}
			if ($va_dates_array) {
				foreach ($va_dates_array as $va_date_type => $va_date) {
					print "<div class='unit'><h6>".$va_date_type."</h6>".join('<br/>',$va_date)."</div>";
				}
			}
		}
		if ($vs_extent = $t_item->get('ca_collections.extentDACS', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Extent</h6>".$vs_extent."</div>";
		}
		if ($vs_creator = $t_item->get('ca_entities.preferred_labels', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Creator</h6>".$vs_creator."</div>";
		}
		if ($vs_admin = $t_item->get('ca_collections.adminbiohist', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Biographical Note</h6>".$vs_admin."</div>";
		}
		if ($vs_scope = $t_item->get('ca_collections.scopecontent', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Scope and Content Note</h6>".$vs_scope."</div>";
		}	
		if ($vs_arrangement = $t_item->get('ca_collections.arrangement', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Arrangement</h6>".$vs_arrangement."</div>";
		}	
		if ($vs_accessrestrict = $t_item->get('ca_collections.accessrestrict', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Access Restrictions</h6>".$vs_accessrestrict."</div>";
		}
		if ($vs_langmaterial = $t_item->get('ca_collections.langmaterial', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Language Note</h6>".$vs_langmaterial."</div>";
		}
		if ($vs_custodhist = $t_item->get('ca_collections.custodhist', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Custodial History Note</h6>".$vs_custodhist."</div>";
		}	
		if ($vs_acqinfo = $t_item->get('ca_collections.acqinfo', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Source of Acquisition</h6>".$vs_acqinfo."</div>";
		}	
		if ($vs_relation = $t_item->get('ca_collections.relation', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Related Archival Materials</h6>".$vs_relation."</div>";
		}
		if ($vs_originalsloc = $t_item->get('ca_collections.originalsloc', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Existence and Location of Orginals</h6>".$vs_originalsloc."</div>";
		}
		if ($vs_altformavail = $t_item->get('ca_collections.altformavail', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Existence and Location of Copies</h6>".$vs_altformavail."</div>";
		}
		if ($vs_processInfo = $t_item->get('ca_collections.processInfo', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Processing Information</h6>".$vs_processInfo."</div>";
		}	
		if ($vs_preferCite = $t_item->get('ca_collections.preferCite', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Preferred Citation</h6>".$vs_preferCite."</div>";
		}
		if ($vs_rel_ent = $t_item->get('ca_entities.preferred_labels', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Related Entities</h6>".$vs_rel_ent."</div>";
		}	
																																																																																												
	}
	print "<div class='collectionLink'>";				
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<div style='border-top:1px solid #ddd;'><br/>Collection Contents";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
	}
	print "</div>";
	print $this->render("pdfEnd.php");
?>
