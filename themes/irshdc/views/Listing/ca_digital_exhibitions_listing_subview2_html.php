<?php
/** ---------------------------------------------------------------------
 * themes/default/Listings/listing_html : 
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
 	$va_access_values = $this->getVar("access_values");
 	AssetLoadManager::register("soundcite");
?>

	<div class="row tanBg exploreRow exploreResourcesRow exploreDigitalExhibitionsRow">
		<div class="col-sm-12">
			<H1>Exhibitions Test Layout</H1>
			<p>
				{{{digital_exhibition_intro}}}
			</p>
		</div>
	</div>
	<div class='row'>
		<div class="col-lg-10 col-lg-offset-1 col-md-12">
		<H2 class="exhibitionSection">Current</H2>
<?php
	$i = 0;
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		while($qr_list->nextHit()) {
			switch(strToLower($qr_list->get("ca_occurrences.type_id", array("convertCodesToDisplayText" => true)))){
				case "exhibition":
					if(strToLower($qr_list->getWithTemplate("^ca_occurrences.exclude_explore_exhibitions")) == "yes"){
						continue;
					}
					
					$vs_image_url = $qr_list->getWithTemplate("^ca_object_representations.media.large.url", array("checkAccess" => $va_access_values, "limit" => 1));
					$vs_display_date = $qr_list->get("ca_occurrences.displayDate");
					$vs_exhibition_type = $qr_list->get("ca_occurrences.exhibition_type", array("convertCodesToDisplayText" => true));
					$vs_link = $qr_list->get("ca_occurrences.online_exhibition");
					$vs_link_text = ($qr_list->get("ca_occurrences.nav_text")) ? $qr_list->get("ca_occurrences.nav_text") : "More Information";
					
					if($i == 0){
						print "<div class='row'>";
					}
					print "<div class='col-sm-4'><div class='listingContainer listingContainerExhibitions coverImg' style='background-image: url(\"".$vs_image_url."\");'>".caDetailLink($this->request, "<div class='listingContainerDesc'>
								<H2>".$qr_list->getWithTemplate('^ca_occurrences.preferred_labels.name')."</H2>
								".(($vs_display_date || $vs_exhibition_type) ? "<p><b>".$vs_display_date.(($vs_display_date && $vs_exhibition_type) ? "<br/>" : "").$vs_exhibition_type."<br/>March 2021</b></p>" : "")."
							</div>", 'listingExhibitionsImageLink', 'ca_occurrences', $qr_list->get("ca_occurrences.occurrence_id"))."</div></div>";
					$i++;
					
					if($i == 3){
						print "</div>";
						$i = 0;
					}
				
				break;
				# -----------------------------------------
				case "digital exhibition":
				default:
			
					if(($this->request->isLoggedIn() && $this->request->user->hasRole("previewDigExh")) || (strToLower($qr_list->get('ca_occurrences.preview_only', array("convertCodesToDisplayText" => true))) != "yes")){
						$vs_image_url = $qr_list->getWithTemplate("<unit relativeTo='ca_objects' restrictToRelationshipTypes='featured'>^ca_object_representations.media.large.url</unit>", array("checkAccess" => $va_access_values, "limit" => 1));
						if(!$vs_image_url){
							$vs_image_url = $qr_list->getWithTemplate("<unit relativeTo='ca_objects'>^ca_object_representations.media.large.url</unit>", array("checkAccess" => $va_access_values, "limit" => 1));
						}
						
						if($i == 0){
							print "<div class='row'>";
						}
						print "<div class='col-sm-4'><div class='listingContainer listingContainerExhibitions coverImg' style='background-image: url(\"".$vs_image_url."\");'>".caDetailLink($this->request, "<div class='listingContainerDesc'>
									<H2>".$qr_list->get("ca_occurrences.preferred_labels.name")."</H2>
									<p><b>Online Exhibition</b></p>
								</div>", 'listingExhibitionsImageLink', 'ca_occurrences', $qr_list->get("ca_occurrences.occurrence_id"))."</div></div>";

						$i++;
					
						if($i == 3){
							print "</div>";
							$i = 0;
						}
					}
				break;
				# -------------------------------------------
			}
# --- SIMULATING HAVING ONLY ONE CURRENT EXHIBIT - JUST FOR TESTING
			break;
		}
		if($i > 0){
			print "</div>";
		}
	}
?>

	</div>
	</div>
		<div class='row'>
		<div class="col-lg-10 col-lg-offset-1 col-md-12">
		
		<br/><H2 class="exhibitionSection">Upcoming</H2>
<?php
	$qr_list->seek(0);
	$i = 0;
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		while($qr_list->nextHit()) {
			switch(strToLower($qr_list->get("ca_occurrences.type_id", array("convertCodesToDisplayText" => true)))){
				case "exhibition":
					if(strToLower($qr_list->getWithTemplate("^ca_occurrences.exclude_explore_exhibitions")) == "yes"){
						continue;
					}
					
					$vs_image_url = $qr_list->getWithTemplate("^ca_object_representations.media.large.url", array("checkAccess" => $va_access_values, "limit" => 1));
					$vs_display_date = $qr_list->get("ca_occurrences.displayDate");
					$vs_exhibition_type = $qr_list->get("ca_occurrences.exhibition_type", array("convertCodesToDisplayText" => true));
					$vs_link = $qr_list->get("ca_occurrences.online_exhibition");
					$vs_link_text = ($qr_list->get("ca_occurrences.nav_text")) ? $qr_list->get("ca_occurrences.nav_text") : "More Information";
					
					if($i == 0){
						print "<div class='row'>";
					}
					print "<div class='col-sm-4'><div class='listingContainer listingContainerExhibitions coverImg' style='background-image: url(\"".$vs_image_url."\");'>".caDetailLink($this->request, "<div class='listingContainerDesc'>
								<H2>".$qr_list->getWithTemplate('^ca_occurrences.preferred_labels.name')."</H2>
								".(($vs_display_date || $vs_exhibition_type) ? "<p><b>".$vs_display_date.(($vs_display_date && $vs_exhibition_type) ? "<br/>" : "").$vs_exhibition_type."<br/>March 2021</b></p>" : "")."
							</div>", 'listingExhibitionsImageLink', 'ca_occurrences', $qr_list->get("ca_occurrences.occurrence_id"))."</div></div>";
					$i++;
					
					if($i == 3){
						print "</div>";
						$i = 0;
					}
				
				break;
				# -----------------------------------------
				case "digital exhibition":
				default:
			
					if(($this->request->isLoggedIn() && $this->request->user->hasRole("previewDigExh")) || (strToLower($qr_list->get('ca_occurrences.preview_only', array("convertCodesToDisplayText" => true))) != "yes")){
						$vs_image_url = $qr_list->getWithTemplate("<unit relativeTo='ca_objects' restrictToRelationshipTypes='featured'>^ca_object_representations.media.large.url</unit>", array("checkAccess" => $va_access_values, "limit" => 1));
						if(!$vs_image_url){
							$vs_image_url = $qr_list->getWithTemplate("<unit relativeTo='ca_objects'>^ca_object_representations.media.large.url</unit>", array("checkAccess" => $va_access_values, "limit" => 1));
						}
						
						if($i == 0){
							print "<div class='row'>";
						}
						print "<div class='col-sm-4'><div class='listingContainer listingContainerExhibitions coverImg' style='background-image: url(\"".$vs_image_url."\");'>".caDetailLink($this->request, "<div class='listingContainerDesc'>
									<H2>".$qr_list->get("ca_occurrences.preferred_labels.name")."</H2>
									<p><b>Online Exhibition</b></p>
								</div>", 'listingExhibitionsImageLink', 'ca_occurrences', $qr_list->get("ca_occurrences.occurrence_id"))."</div></div>";

						$i++;
					
						if($i == 3){
							print "</div>";
							$i = 0;
						}
					}
				break;
				# -------------------------------------------
			}
		}
		if($i > 0){
			print "</div>";
		}
	}
?>

		</div>
	</div>