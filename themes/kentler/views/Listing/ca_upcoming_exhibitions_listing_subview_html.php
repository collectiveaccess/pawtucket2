<?php
/** ---------------------------------------------------------------------
 * themes/default/Listings/ca_occurrences_listing_html : 
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 	$va_lists = $this->getVar('lists');
 	$va_type_info = $this->getVar('typeInfo');
 	$va_listing_info = $this->getVar('listingInfo');
 	$va_access_values = caGetUserAccessValues($this->request);
 	$t_occurrence = new ca_occurrences();
	# --- loop through to grab current exhibitions and display on top
 	# --- build array of upcomig to list below
 	$va_current = array();
 	$va_upcoming = array();
 	$va_current_ids = array();
 	if(is_array($va_lists) && sizeof($va_lists)){
		foreach($va_lists as $vn_type_id => $qr_list) {
			if(!$qr_list) { continue; }
			while($qr_list->nextHit()) {
				if($qr_list->get("on_view", array("convertCodesToDisplayText" => true)) == "yes"){
					$va_current[] = array("id" => $qr_list->get("ca_occurrences.occurrence_id"), "title_link" => $qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels.name</l>'), "date" => $qr_list->get("ca_occurrences.exhibition_dates"), "opening" => $qr_list->get("ca_occurrences.opening_date"));
					$va_current_ids[] = $qr_list->get("ca_occurrences.occurrence_id");
				}else{
					$va_upcoming[] = array("id" => $qr_list->get("ca_occurrences.occurrence_id"), "title_link" => $qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels.name</l>'), "date" => $qr_list->get("ca_occurrences.exhibition_dates"));
				}
			}
		}
	}
	if(is_array($va_current) && sizeof($va_current)){
?>
	<br/><div class="container ltGrayBg">
		<div class="row">
			<div class="col-sm-12">
				<H1><?php print (sizeof($va_current) > 1) ? _t("Current Exhibitions") : _t("Current Exhibition"); ?></H1><br/>
			</div>
		</div>
<?php
		# --- get the primary reps for the current exhibitions
		$va_current_reps = $t_occurrence->getPrimaryMediaForIDs($va_current_ids, array("medium"), array("checkAccess" => $va_access_values));
		$vn_col = 0;
		foreach($va_current as $va_exhibit_info) {
			if($vn_col == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-6 exhibitionListing'>";
			if(is_array($va_current_reps) && $va_current_reps[$va_exhibit_info["id"]]){
				print "<div class='row'><div class='col-sm-6'>".$va_current_reps[$va_exhibit_info["id"]]["tags"]["medium"]."</div>";
				print "<div class='col-sm-6'>";
			}else{
				print "<div class='row'><div class='col-sm-12'>";
			}
			print "<h2>".$va_exhibit_info["title_link"]."</h2>".$va_exhibit_info["date"];
			if($va_exhibit_info["opening"]){
				print "<br/>Reception: ".$va_exhibit_info["opening"];
			}
			print "</div><!-- end col --></div><!-- end col --></div><!-- end row -->";
			$vn_col++;
			if($vn_col == 2){
				print "</div><!-- end row -->\n";
				$vn_col = 0;
			}
		}
		# --- close trailing row
		if($vn_col > 0){
			print "</div><!-- end row -->\n";
		}
?>
	</div><br/><!--- end container -->
<?php
		$vb_output = 1;
	}

	if(is_array($va_upcoming) && sizeof($va_upcoming)){
?>
	<div class="row artistList">
		<div class="col-sm-12">
			<H1><?php print _t("Upcoming Exhibitions"); ?></H1><br/>
		</div>
	</div>
<?php
		$vn_col = 0;
		foreach($va_upcoming as $vn_occ_id => $va_exhibit_info) {
			if($vn_col == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-6 exhibitionListing''><h2>".$va_exhibit_info["title_link"]."</h2>".$va_exhibit_info["date"]."</div>";
			$vn_col++;
			if($vn_col == 2){
				print "</div><!-- end row -->\n";
				$vn_col = 0;
			}
		}
		# --- close trailing row
		if($vn_col > 0){
			print "</div><!-- end row -->\n";
		}
		$vb_output = 1;
	}
	if(!$vb_output){
		print "<div class='row'><div class='col-sm-12'><H2>There are no upcoming exhibitions scheduled</H2></div></div>";
	}
?>