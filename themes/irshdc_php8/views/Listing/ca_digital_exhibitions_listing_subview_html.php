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
<div class="exhibitionLanding">
	<div class="row exhibitionLandingIntro">
		<div class="col-sm-9">
			<H1>Exhibitions</H1>
			<p>
				{{{digital_exhibition_intro}}}
			</p>
		</div>
		<div class="col-sm-3 fullWidth">
<?php
			print caGetThemeGraphic($this->request, 'cedarWebRotated.jpg');
?>
		</div>
	</div>
	<div class='row bgSageGreen'>
		<div class="col-sm-12">
			<div class="exhibitionLandingListings">
			
<?php
	$va_col_content = array();
	$vs_current_date = date("Y.md");
	$va_current = array();
	$va_upcoming = array();
	$va_past = array();
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		while($qr_list->nextHit()) {
			$vs_tmp = "";
			switch(strToLower($qr_list->get("ca_occurrences.type_id", array("convertCodesToDisplayText" => true)))){
				case "exhibition":
					if(strToLower($qr_list->getWithTemplate("^ca_occurrences.exclude_explore_exhibitions")) == "yes"){
						continue;
					}
					
					$vs_image = $qr_list->getWithTemplate("^ca_object_representations.media.large", array("checkAccess" => $va_access_values, "limit" => 1));
					$vs_desc = $qr_list->get("ca_occurrences.description");
					$vs_display_date = $qr_list->get("ca_occurrences.displayDate");
					$vs_exhibition_type = $qr_list->get("ca_occurrences.exhibition_type", array("convertCodesToDisplayText" => true));
					$vs_link = $qr_list->get("ca_occurrences.online_exhibition");
					$vs_link_text = ($qr_list->get("ca_occurrences.nav_text")) ? $qr_list->get("ca_occurrences.nav_text") : "More Information";
					
					$vs_tmp = "
						<div class='listingContainer listingContainerExhibitions'>
							<div class='row vertAlignRow'>
								<div class='col-sm-12 col-md-7 exhibitionLandingListingsImgCol'>
									".caDetailLink($this->request, $vs_image, '', 'ca_occurrences', $qr_list->get("occurrence_id"))."
								</div>
								<div class='col-sm-12 col-md-5'>
									<div class='listingContainerDesc'>
									<H2>".$qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels.name</l>')."</H2>
									".(($vs_display_date || $vs_exhibition_type) ? "<p>".$vs_display_date.(($vs_display_date && $vs_exhibition_type) ? "<br/>" : "").$vs_exhibition_type."</p>" : "")."
									<p>
										".$vs_desc."
									</p>
									".(($vs_link) ? "<p class='text-center'><a href='".$vs_link."' class='btn-default' target='_blank'>".$vs_link_text."</a></p>" : "")."
									</div>
								</div>
							</div>
						</div>";
				
				break;
				# -----------------------------------------
				case "digital exhibition":
				default:
			
					#if(($this->request->isLoggedIn() && $this->request->user->hasRole("previewDigExh")) || (strToLower($qr_list->get('ca_occurrences.preview_only', array("convertCodesToDisplayText" => true))) != "yes")){
						$vs_image = $qr_list->getWithTemplate("<unit relativeTo='ca_objects' restrictToRelationshipTypes='featured'>^ca_object_representations.media.large</unit>", array("checkAccess" => $va_access_values, "limit" => 1));
						if(!$vs_image){
							$vs_image = $qr_list->getWithTemplate("<unit relativeTo='ca_objects'>^ca_object_representations.media.large</unit>", array("checkAccess" => $va_access_values, "limit" => 1));
						}
						$vs_desc = $qr_list->get("ca_occurrences.description");
						
						$vs_tmp = "
							<div class='listingContainer listingContainerExhibitions'>
								<div class='row vertAlignRow'>
									<div class='col-sm-12 col-md-7 exhibitionLandingListingsImgCol'>
										".caDetailLink($this->request, $vs_image, '', 'ca_occurrences', $qr_list->get("occurrence_id"))."
									</div>
									<div class='col-sm-12 col-md-5'>
										<div class='listingContainerDesc'>
											<H2>".$qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels.name</l>')."</H2>
											<p>Online Exhibition</p>
											<p>
												".$vs_desc."
											</p>
											<p class='text-center'>
												".caDetailLink($this->request, "View Exhibition", 'btn-default', 'ca_occurrences', $qr_list->get("occurrence_id"))."
											</p>
										</div>
									</div>
								</div>
							</div>";

					#}
				break;
				# -------------------------------------------
			}
			$va_date = $qr_list->get("ca_occurrences.occurrence_dates", array("returnWithStructure" => true));
			$vs_start_date = "";
			if(is_array($va_date) && sizeof($va_date)){
				$va_date = array_pop($va_date);
				foreach($va_date as $va_first_date){
					$va_date_pieces = explode("/", $va_first_date["occurrence_dates_sort_"]);
					$vs_start_date = $va_date_pieces[0];
					break;
				}
			}
			if($vs_tmp){
				if($qr_list->get("ca_occurrences.current_exhibition", array("convertCodesToDisplayText" => true)) == "Yes"){
					$va_current[] = $vs_tmp;
				}elseif($vs_start_date > $vs_current_date){
					$va_upcoming[] = $vs_tmp;
				}else{
					$va_past[] = $vs_tmp;
				}
			}
		}
	}
	if(sizeof($va_current) > 0){
?>
		<div class='row'>
			<div class="col-sm-12">
<?php
			foreach($va_current as $vs_block){
				print $vs_block;
			}
?>
			</div>
		</div>
<?php
	}
	if(sizeof($va_upcoming) > 0){
?>
		<div class='row'>
			<div class="col-sm-12">
<?php
			foreach($va_upcoming as $vs_block){
				print $vs_block;
			}
?>
			</div>
		</div>
<?php
	}
	if(sizeof($va_past) > 0){
?>
		<div class='row'>
			<div class="col-sm-12">
<?php
			foreach($va_past as $vs_block){
				print $vs_block;
			}
?>
			</div>
		</div>
<?php
	}
?>

			</div><!--end exhibitionLandingListings -->
		</div>
	</div>
</div><!--end exhibitionLanding -->