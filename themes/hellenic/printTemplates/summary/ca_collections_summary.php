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
	$va_access_values = caGetUserAccessValues($this->request);

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");

	if ($vs_type_id == $vs_museum_id) {
		print "<div class='unit'><h6>Collection Name</h6><div class='data'>".$t_item->get('ca_collections.preferred_labels')."</div></div>";
		if ($vs_description = $t_item->get('ca_collections.description')) {
			print "<div class='unit'><h6>Collection Description</h6>".$vs_description."</div>";
		}
		if ($vs_rel_ent = $t_item->get('ca_entities.preferred_labels', array('checkAccess' => $va_access_values, 'delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Related Entities</h6><div class='data'>".$vs_rel_ent."</div></div>";
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
				print "<div class='unit'><h6>Extent</h6><div class='data'>".$vs_extent."</div></div>";
			}
			if ($vs_creator = $t_item->get('ca_entities.preferred_labels', array('checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array("creator"), 'delimiter' => '<br/>'))) {
				print "<div class='unit'><h6>Creator</h6><div class='data'>".$vs_creator."</div></div>";
			}
			if ($vs_rel_ent = $t_item->get('ca_entities.preferred_labels', array('excludeRelationshipTypes' => array("creator"), 'delimiter' => '<br/>'))) {
				print "<div class='unit'><h6>Related Entities</h6><div class='data'>".$vs_rel_ent."</div></div>";
			}
			if ($vs_rel_collections = $t_item->get('ca_collections.preferred_labels', array('checkAccess' => $va_access_values, 'delimiter' => '<br/>'))) {
				print "<div class='unit'><h6>Related Collections</h6><div class='data'>".$vs_rel_collections."</div></div>";
			}
			# --- access points
			# --- access points
			$va_access_points = array();
			$va_subjects = $t_item->get('ca_list_items.preferred_labels', array('returnAsArray' => true));
			$va_getty = $t_item->get('ca_collections.aat', array('returnAsArray' => true));
			$va_ulan = $t_item->get('ca_collections.ulan', array('returnAsArray' => true));
			$va_lcsh = $t_item->get('ca_collections.lcsh_terms', array('returnAsArray' => true));
			$va_tgn = $t_item->get('ca_collections.tgn', array('returnAsArray' => true));
			$va_access_points = array_merge($va_subjects, $va_getty, $va_ulan, $va_lcsh, $va_tgn);
			if (sizeof($va_access_points)) {
				$va_access_points_sorted = array();
				foreach($va_access_points as $vs_access_point){
					$vs_access_point = trim(preg_replace("/\[[^\]]*\]/", "", $vs_access_point));
					if($vs_access_point){
						$va_access_points_sorted[$vs_access_point] = $vs_access_point;
					}
				}
				ksort($va_access_points_sorted, SORT_NATURAL | SORT_FLAG_CASE);
				print "<div class='unit'><h6>Access Points</h6><div class='data'>";
				print join("<br/>", $va_access_points_sorted);
				print "</div></div>";
			}
			
			if ($vs_admin = $t_item->get('ca_collections.adminbiohist', array('delimiter' => '<br/>'))) {
				print "<div class='unit'><h6>Biographical Note</h6><div>".$vs_admin."</div></div>";
			}
			if ($vs_scope = $t_item->get('ca_collections.scopecontent', array('delimiter' => '<br/>'))) {
				print "<div class='unit'><h6>Scope and Content Note</h6><div>".$vs_scope."</div></div>";
			}	
			if ($vs_arrangement = $t_item->get('ca_collections.arrangement', array('delimiter' => '<br/>'))) {
				print "<div class='unit'><h6>Arrangement</h6><div>".$vs_arrangement."</div></div>";
			}	
			if ($vs_accessrestrict = $t_item->get('ca_collections.accessrestrict', array('delimiter' => '<br/>'))) {
				print "<div class='unit'><h6>Access Restrictions</h6><div>".$vs_accessrestrict."</div></div>";
			}
			if ($vs_langmaterial = $t_item->get('ca_collections.langmaterial', array('delimiter' => '<br/>'))) {
				print "<div class='unit'><h6>Language Note</h6><div>".$vs_langmaterial."</div></div>";
			}
			if ($vs_custodhist = $t_item->get('ca_collections.custodhist', array('delimiter' => '<br/>'))) {
				print "<div class='unit'><h6>Custodial History Note</h6><div>".$vs_custodhist."</div></div>";
			}	
			if ($vs_acqinfo = $t_item->get('ca_collections.acqinfo', array('delimiter' => '<br/>'))) {
				print "<div class='unit'><h6>Source of Acquisition</h6><div>".$vs_acqinfo."</div></div>";
			}	
			if ($vs_relation = $t_item->get('ca_collections.relation', array('delimiter' => '<br/>'))) {
				print "<div class='unit'><h6>Related Archival Materials</h6><div>".$vs_relation."</div></div>";
			}
			if ($vs_originalsloc = $t_item->get('ca_collections.originalsloc', array('delimiter' => '<br/>'))) {
				print "<div class='unit'><h6>Existence and Location of Orginals</h6><div>".$vs_originalsloc."</div></div>";
			}
			if ($vs_altformavail = $t_item->get('ca_collections.altformavail', array('delimiter' => '<br/>'))) {
				print "<div class='unit'><h6>Existence and Location of Copies</h6><div>".$vs_altformavail."</div></div>";
			}
			if ($vs_processInfo = $t_item->get('ca_collections.processInfo', array('delimiter' => '<br/>'))) {
				print "<div class='unit'><h6>Processing Information</h6><div>".$vs_processInfo."</div></div>";
			}	
			if ($vs_preferCite = $t_item->get('ca_collections.preferCite', array('delimiter' => '<br/>'))) {
				print "<div class='unit'><h6>Preferred Citation</h6><div>".$vs_preferCite."</div></div>";
			}
																																																																																													
		}
	print "<div class='collectionLink'>";				
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<div><br/>Collection Contents";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
		print "</div>";
	}
	print $this->render("pdfEnd.php");
?>
