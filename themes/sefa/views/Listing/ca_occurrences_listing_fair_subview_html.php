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
	print "<div class='fairList'>";
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		
		$va_ids = array();
		while($qr_list->nextHit()) {
			$va_ids[] = $qr_list->get("occurrence_id");	
		}
		$qr_list->seek(0);
		#$va_images = caGetDisplayImagesForAuthorityItems("ca_occurrences", $va_ids, array('version' => 'thumbnail300', 'relationshipTypes' => array("logo"), 'checkAccess' => $va_access_values, 'dontShowPrimary' => true));
		$vn_col = 1;
		while($qr_list->nextHit()) {
			if($vn_col == 1){
				print "<div class='row'>";
			}
			$vs_image = $qr_list->get("ca_object_representations.media.medium", array("restrictToRelationshipTypes" => array("logo")));
			#print "<div class='col-sm-4 fairListing'>".caDetailLink($this->request, $va_images[$qr_list->get("occurrence_id")], '', 'ca_occurrences', $qr_list->get("occurrence_id"), null, null, array("type_id" => $qr_list->get("type_id")))."<h2>".$qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels.name</l>')."</h2>".$qr_list->get('ca_occurrences.opening_closing')."</div>\n";	
			print "<div class='col-sm-3 fairListing'><div class='fairListingImg'>".caDetailLink($this->request, ($vs_image) ? $vs_image : "<h2>".$qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels.name</l>')."</h2>", '', 'ca_occurrences', $qr_list->get("occurrence_id"), null, null, array("type_id" => $qr_list->get("type_id")))."</div></div>\n";	
			if($vn_col == 4){
				print "</div>";
				$vn_col = 1;
			}else{
				$vn_col++;
			}
			
		}
		if($vn_col > 1){
			print "</div><!-- end row -->\n";
		}
	}
	print "</div><!-- end fairList -->\n";