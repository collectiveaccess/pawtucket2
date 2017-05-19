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
 
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
?>
	<div class="row">
		<div class='col-md-12 col-lg-12 collectionsList'>
<?php		
		print "<h1>{$va_listing_info['displayName']}</h1>\n";
		
		$vn_i = 0;
		if($qr_list && $qr_list->numHits()) {
			while($qr_list->nextHit()) {
				if ( $vn_i == 0) { print "<div class='row'>"; } 
				print "<div class='col-sm-6'><div class='collectionTile'><div class='title'>".$qr_list->getWithTemplate('<l>^ca_entities.preferred_labels.displayname</l>')."</div>";	
				print "</div></div>";
				$vn_i++;
				if ($vn_i == 2) {
					print "</div><!-- end row -->\n";
					$vn_i = 0;
				}
			}
			if (($vn_i < 2) && ($vn_i != 0) ) {
				print "</div><!-- end row -->\n";
			}
		}
	}
?>
		</div>
	</div>