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

	print "<div class='container'>";
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		
		print "<div class='row'><div class='col-sm-12' style='padding-bottom:25px;'><h1>{$va_listing_info['displayName']}</h1></div></div>\n";
		$r = 0;
		while($qr_list->nextHit()) {
			if($r == 0){
				print "<div class='row'>";
			}
			print $qr_list->getWithTemplate('<div class="col-sm-4"><div class="interviewThumb"><l><unit relativeTo="ca_object_representations">^ca_object_representations.media.largewidepreview<br/></unit></l><div class="caption"><l>^ca_objects.preferred_labels.name</l></div></div></div>');	
			$r++;
			if($r == 3){
				$r = 0;
				print "</div>";
			}
		}
		if($r > 0){
			print "</div>";
		}
	}
	print "</div>";
?>