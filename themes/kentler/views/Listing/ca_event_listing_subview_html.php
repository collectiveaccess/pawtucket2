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

	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		# --- get the current day- formatted like raw dates are returned so can see what events are upcoming
		$vn_today = date("Y.md");
		$va_ids = array();
		$va_upcoming = array();
		$va_years = array();
		$va_event_years = array();
		while($qr_list->nextHit()) {
			$va_ids[] = $qr_list->get("occurrence_id");	
			if($qr_list->get("exhibition_dates")){
				# --- get the year
				$va_event_date_raw = $qr_list->get("ca_occurrences.exhibition_dates", array("returnWithStructure" => true, "rawDate" => true));
				if(is_array($va_event_date_raw) && sizeof($va_event_date_raw)){
					$va_event_date_raw = array_shift($va_event_date_raw[$qr_list->get("ca_occurrences.occurrence_id")]);
					$vs_start_year = floor($va_event_date_raw["exhibition_dates"]["start"]);
					if($va_event_date_raw["exhibition_dates"]["start"] > $vn_today){
						$va_upcoming[$qr_list->get("occurrence_id")] = array("id" => $qr_list->get("occurrence_id"), "title_link" => $qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels.name</l>'), "date" => $qr_list->get("ca_occurrences.exhibition_dates")); 
					}
				}
				$va_years[$vs_start_year] = $vs_start_year;
				$va_event_years[$qr_list->get("ca_occurrences.occurrence_id")] = $vs_start_year;
			}
		}
		$qr_list->seek(0);
		# --- get the primary reps for the current events
		$va_reps = $t_occurrence->getPrimaryMediaForIDs($va_ids, array("medium"), array("checkAccess" => $va_access_values));		
	}
	# --- if there are upcoming events, feature them on top
	if(is_array($va_upcoming) && sizeof($va_upcoming)){
?>
	<br/><div class="container ltGrayBg">
		<div class="row">
			<div class="col-sm-12">
				<H1><?php print (sizeof($va_upcoming) > 1) ? _t("Upcoming Events") : _t("Upcoming Event"); ?></H1><br/>
			</div>
		</div>
<?php
		$vn_col = 0;
		foreach($va_upcoming as $va_event_info) {
			if($vn_col == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-6 exhibitionListing'>";
			if(is_array($va_reps) && $va_reps[$va_event_info["id"]]){
				print "<div class='row'><div class='col-sm-6'>".$va_reps[$va_event_info["id"]]["tags"]["medium"]."</div>";
				print "<div class='col-sm-6'>";
			}else{
				print "<div class='row'><div class='col-sm-12'>";
			}
			print "<h2>".$va_event_info["title_link"]."</h2>".$va_event_info["date"];
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
	}
?>
	<div class="row">
		<div class="col-sm-12">
			<div class="leader ltGrayBg"><!-- turqBg -->
				<H1><?php print _t("Events"); ?></H1>
				<p>
					Etiam pharetra, elit ac fermentum accumsan, ex lectus lacinia nisi, consequat auctor nulla urna ac enim. Vivamus feugiat massa sem, sed fringilla magna cursus sed. Cras laoreet est vitae arcu finibus, id volutpat elit vehicula.
				</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<ul class="nav nav-pills">
<?php
			if(sizeof($va_years) > 1){		
				#arsort($va_years);
				foreach($va_years as $vs_year){
					print "<li class='yearBar yearBar".$vs_year."'><a href='#' onClick='$(\".yearBar\").removeClass(\"active\"); $(this).parent().addClass(\"active\"); $(\".yearTab\").hide(); $(\"#yearTab".$vs_year."\").show(); return false;'>".$vs_year."</a></li>";
				}
			}else{
				print "<li>&nbsp;</li>";
			}
?>		
			</ul>
	
		</div><!--end col-sm-12-->
	</div><!--end row--><br/>
		
<?php
	if(is_array($va_lists) && sizeof($va_lists)){
		foreach($va_lists as $vn_type_id => $qr_list) {
			if(!$qr_list) { continue; }
			$vs_year = null;
			$vn_col = 0;
			while($qr_list->nextHit()) {
				if($vs_year != $va_event_years[$qr_list->get("ca_occurrences.occurrence_id")]){
					if($vs_year){
						print "</div><!-- end yearTab -->";
					}
					$vs_year = $va_event_years[$qr_list->get("ca_occurrences.occurrence_id")];
					if($vn_col > 0){
						print "</div><!-- end row -->";
					}
					$vn_col = 0;
					print "<div id='yearTab".$vs_year."' class='yearTab'>";
				}
				if($vn_col == 0){
					print "<div class='row'>";
				}
				print "<div class='col-sm-6 exhibitionListing'>";
				if(is_array($va_reps) && $va_reps[$qr_list->get("ca_occurrences.occurrence_id")]["tags"]["medium"]){
					print "<div class='row'><div class='col-sm-4'>".$va_reps[$qr_list->get("ca_occurrences.occurrence_id")]["tags"]["medium"]."</div><div class='col-sm-8'>";
				}else{
					print "<div class='row'><div class='col-sm-12'>";
				}
				print "<h2>".$qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels.name</l>')."</h2>".$qr_list->get("ca_occurrences.exhibition_dates")."</div>";
				print "</div><!-- end col --></div><!-- end row -->";
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
			print "</div><!-- end last yearTab -->";
		}
	}else{
		print "<div class='row'><div class='col-sm-12'><H2>There are no past events scheduled</H2></div></div>";
	}

	if(is_array($va_years)){
		$vs_first_year = array_shift($va_years);
?>
	<script type='text/javascript'>
		jQuery(document).ready(function() {		
			jQuery("#yearTab<?php print $vs_first_year; ?>").show();
			jQuery(".yearBar").removeClass("active");
			jQuery(".yearBar<?php print $vs_first_year; ?>").addClass("active");
		});
	</script>
<?php
	}
?>