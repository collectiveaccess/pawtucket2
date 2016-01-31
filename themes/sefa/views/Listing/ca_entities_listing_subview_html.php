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
 	$va_access_values = caGetUserAccessValues($this->request);
	print "<div class='artistList'>";
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		
		print "<div class='row'>";
		$va_ids = array();
		while($qr_list->nextHit()) {
			$va_ids[] = $qr_list->get("entity_id");	
		}
		$qr_list->seek(0);
		$va_images = caGetDisplayImagesForAuthorityItems("ca_entities", $va_ids, array('version' => 'thumbnail300', 'relationshipTypes' => array("creator_website"), 'checkAccess' => $va_access_values, 'useRelatedObjectRepresentations' => true));
		while($qr_list->nextHit()) {
			print "<div class='col-sm-4 artistListing'>".caDetailLink($this->request, $va_images[$qr_list->get("entity_id")], '', 'ca_entities', $qr_list->get("entity_id"))."<h2>".$qr_list->getWithTemplate('<l>^ca_entities.preferred_labels.displayname</l>', null, null, array("type_id" => $qr_list->get("type_id")))."</h2></div>\n";	
		}
		print "</div><!-- end row -->\n";
	}
	print "</div><!-- end artistList -->\n";
?>