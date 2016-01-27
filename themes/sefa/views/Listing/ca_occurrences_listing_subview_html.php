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
?>
	

	<div class="row contentbody_sub">

		<div class="col-sm-3 subnav">
<?php 
			print $this->render("SubNav/exhibitions_html.inc");
?>
		</div>			
		<div class="col-sm-9">
			<div class="row">
				<div class="col-sm-12">
					<ul class="nav nav-pills">
<?php
			foreach($va_lists as $vn_type_id => $qr_list) {
				if(!$qr_list) { continue; }
				
				$va_ids = array();
				$va_years = array();
				while($qr_list->nextHit()) {
					$va_ids[] = $qr_list->get("occurrence_id");	
					if($qr_list->get("exhibition_year")){
						$va_years[$qr_list->get("exhibition_year")] = $qr_list->get("exhibition_year");
					}
				}
				$qr_list->seek(0);
				$va_images = caGetDisplayImagesForAuthorityItems("ca_occurrences", $va_ids, array('version' => 'thumbnail300', 'relationshipTypes' => array("used_website"), 'checkAccess' => $va_access_values, 'useRelatedObjectRepresentations' => true));
			}
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
			
				</div><!--end col-sm-9-->
			</div><!--end row-->

		
		
		
		
		
<?php
	if(is_array($va_lists) && sizeof($va_lists)){
		foreach($va_lists as $vn_type_id => $qr_list) {
			if(!$qr_list) { continue; }
			$vs_year = null;
			while($qr_list->nextHit()) {
				if($vs_year != $qr_list->get("exhibition_year")){
					if($vs_year){
						print "</div><!-- end yearTab -->";
					}
					$vs_year = $qr_list->get("exhibition_year");
					print "<div id='yearTab".$vs_year."' class='yearTab'>";
				}
				print "<div class='row'>";
				print "<div class='col-sm-4 exhibitionListing'>".caDetailLink($this->request, $va_images[$qr_list->get("occurrence_id")], '', 'ca_occurrences', $qr_list->get("occurrence_id"), null, null, array("type_id" => $qr_list->get("type_id")))."</div>\n";
				print "<div class='col-sm-8 exhibitionListing'><h2><strong>".$qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels.name</l>')."</strong></h2>".$qr_list->get("ca_occurrences.opening_closing")."</div>";
				print "</div><!-- end row -->\n";
			}
			print "</div><!-- end last yearTab -->";
		}
	}else{
		print "<H2>There are no upcoming exhibitions scheduled</H2>";
	}
?>
		</div><!--end col-sm-9-->
		<div class="row">
			<div class="col-sm-3 btmsubnav">
<?php 
			print $this->render("SubNav/exhibitions_html.inc");
?>			
			</div><!-- end col -->
		</div><!-- end row -->		
	</div><!--end row contentbody-->
<?php
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