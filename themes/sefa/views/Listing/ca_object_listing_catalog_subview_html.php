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
	print "<div class='pubList'>";
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		
		print "<div class='row'>";
		while($qr_list->nextHit()) {
			print "<div class='col-sm-3 pubListing'><div class='pubListingImg'>".caDetailLink($this->request, $qr_list->get("ca_object_representations.media.small", array("checkAccess" => $va_access_values)), '', 'ca_objects', $qr_list->get("object_id"), null, null, array("type_id" => $qr_list->get("type_id")))."</div><h2>".$qr_list->getWithTemplate('<l>^ca_objects.preferred_labels.name</l>')."</h2></div>\n";	
		}
		print "</div><!-- end row -->\n";
	}
	print "</div><!-- end pubList -->\n";
?>