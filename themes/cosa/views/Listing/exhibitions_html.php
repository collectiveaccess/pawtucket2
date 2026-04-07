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
 
 	$lists = $this->getVar('lists');
 	$type_info = $this->getVar('typeInfo');
 	$listing_info = $this->getVar('listingInfo');
 	$access_values = caGetUserAccessValues($this->request);
 
	foreach($lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		
		print "<h1>{$listing_info['displayName']}</h1>\n";
		print "<div class='row'>";
		while($qr_list->nextHit()) {
?>
			<div class="col-md-6 mb-4">
				
<?php
				# --- for contain $image = $qr_list->get('ca_object_representations.media.large', array("checkAccess" => $access_values, "class" => "card-img-top object-fit-contain px-3 pt-3 rounded-0"));
				$image = $qr_list->get('ca_object_representations.media.large', array("checkAccess" => $access_values, "class" => "card-img-top object-fit-cover rounded-0"));
				print $qr_list->getWithTemplate("<l><div class='card h-100 width-100 rounded-0 shadow border-0'>".$image."<div class='card-body'><div class='card-title fw-medium lh-sm fs-4'>^ca_occurrences.preferred_labels</div><ifdef code='ca_occurrences.date'><div class='card-text small text-body-secondary'>^ca_occurrences.date</div></ifdef></div><div class='card-footer text-end bg-transparent border-0'><button class='btn btn-primary'>View <i class='bi bi-arrow-right small'></i></button></div></div></div></l>")."\n";
?>
				 
			</div>
<?php
		}
		print "</div>";
	}
?>