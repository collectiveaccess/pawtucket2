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
 	$vs_placeholder = "<div class='bSimplePlaceholder'>".caGetThemeGraphic($this->request, 'spacer.png')."</div>";
 	$va_lists = $this->getVar('lists');
 	$va_type_info = $this->getVar('typeInfo');
 	$va_listing_info = $this->getVar('listingInfo');
 	$va_access_values = caGetUserAccessValues($this->request);
 	$t_occurrence = new ca_occurrences();
	# --- loop through to grab current exhibitions and display on top
 	# --- build array of upcomig to list below
 	$va_current = array();
 	$va_past = array();
 	$va_ids = array();
 	$va_reps = array();
 	if(is_array($va_lists) && sizeof($va_lists)){
		# --- get current date in right format to use to hide "upcoming exhibitions" that are just exhibitions with no real end date
		$vs_current_date = date("Y.md");
		foreach($va_lists as $vn_type_id => $qr_list) {
			if(!$qr_list) { continue; }
			while($qr_list->nextHit()) {
				$va_raw_dates = $qr_list->get("ca_occurrences.exhibition_dates", array("rawDate" => true, "returnWithStructure" => true));
				$va_raw_dates = array_pop($va_raw_dates[$qr_list->get("ca_occurrences.occurrence_id")]);
				$va_ids[] = $qr_list->get("ca_occurrences.occurrence_id");
				if($qr_list->get("view_status", array("convertCodesToDisplayText" => true)) == "on view"){
					$va_current[] = array("id" => $qr_list->get("ca_occurrences.occurrence_id"), "title_link" => $qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels.name</l>'), "date" => $qr_list->get("ca_occurrences.exhibition_dates"), "short_desc" => $qr_list->get("ca_occurrences.short_description"));
				}else{
					#if($va_raw_dates["exhibition_dates"][0] > $vs_current_date){
						$va_past[] = array("id" => $qr_list->get("ca_occurrences.occurrence_id"), "title_link" => $qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels.name</l>'), "date" => $qr_list->get("ca_occurrences.exhibition_dates"));
					#}
				}
				if(sizeof($va_past) == 3){
					break;
				}
			}
		}
		#$va_reps = $t_occurrence->getPrimaryMediaForIDs($va_ids, array("medium"), array("checkAccess" => $va_access_values));
		$va_reps = caGetDisplayImagesForAuthorityItems('ca_occurrences', $va_ids, array('version' => 'widepreview', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_listing_info, null), 'checkAccess' => $va_access_values));
			
	}
?>
	<div class="container browse exhibitions">
<?php
	if(is_array($va_current) && sizeof($va_current)){
?>
		<div class="row">
			<div class="col-sm-12">
				<H4><?php print (sizeof($va_current) > 1) ? _t("Current & Upcoming Exhibitions") : _t("Current & Upcoming Exhibition"); ?></H4><br/>
			</div>
		</div>
<?php
		# --- get the primary reps for the current exhibitions
		$vn_col = 0;
		foreach($va_current as $va_exhibit_info) {
?>
			<div class='row rowSpacing upcomingExhibitions'>
<?php			
			if(is_array($va_reps) && $va_reps[$va_exhibit_info["id"]]){
				$vs_rep = caDetailLink($this->request, $va_reps[$va_exhibit_info["id"]], "", "ca_occurrences",  $va_exhibit_info["id"]);
			}else{
				$vs_rep = caDetailLink($this->request, $vs_placeholder, "", "ca_occurrences",  $va_exhibit_info["id"]);
			}
?>
				<div class='col-xs-12 col-sm-6'>
					<div class='fullWidth'><?php print $vs_rep; ?></div>
				</div>
				<div class='col-xs-12 col-sm-6'>
<?php
					print "<div class='upcomingTitle'>".$va_exhibit_info["title_link"]."</div>";
					print "<div class='upcomingDate'>".$va_exhibit_info["date"]."</div>";
					print "<div class='upcomingDesc'>".$va_exhibit_info["short_desc"]."</div>";
?>
				</div>
			</div><!-- end row -->
<?php
		}
		$vb_output = 1;
	}
	if ($blah) { // removed from display but saving this unless we need to put it back
	if(is_array($va_past) && sizeof($va_past)){
?>
	<div class="row">
		<div class="col-sm-12">
			<H4><?php print _t("Past Exhibitions"); ?></H4><br/>
		</div>
	</div>
	<div class="row">
<?php
		$va_past_reps = $t_occurrence->getPrimaryMediaForIDs($va_current_ids, array("medium"), array("checkAccess" => $va_access_values));
		$vn_col = 0;
		foreach($va_past as $vn_occ_id => $va_exhibit_info) {
			if(is_array($va_reps) && $va_reps[$va_exhibit_info["id"]]){
				$vs_rep = caDetailLink($this->request, $va_reps[$va_exhibit_info["id"]], "", "ca_occurrences",  $va_exhibit_info["id"]);
			}else{
				$vs_rep = caDetailLink($this->request, $vs_placeholder, "", "ca_occurrences",  $va_exhibit_info["id"]);
			}
			print "<div class='bResultListItemCol col-xs-12 col-sm-6 col-md-6 col-lg-4'>
					<div class='bResultListItem'>
						<div class='bResultListItemContent'><div class='text-center bResultListItemImg'>{$vs_rep}</div>
							<div class='bResultListItemTextContainer'><div class='bResultListItemText'>
								".$va_exhibit_info["title_link"]."<br/>".$va_exhibit_info["date"]."
							</div><!-- end bResultListItemText --></div><!-- end bResultListItemTextContainer -->
						</div><!-- end bResultListItemContent -->
					</div><!-- end bResultListItem -->
				</div><!-- end col -->";
		}
		# --- close trailing row
		$vb_output = 1;
	}
	}
?>
	</div><!-- end row -->
<?php
	if(!$vb_output){
		print "<div class='row'><div class='col-sm-12'><H2>There are no upcoming exhibitions scheduled</H2></div></div>";
	}
?>

	</div><br/><!--- end container -->