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
		
		print "<h4>{$va_listing_info['displayName']}</h4>\n";
 		print "<p style='clear:both;'>The Storm King Art Center Oral History Program includes interviews with artists and institutional leaders integral to the evolution of Storm King since its founding in 1960. Artist oral histories focus on the role of Storm King in the career of the artist, as well as on the artists’ work located at Storm King. Oral histories with institutional leaders focus on efforts to shape Storm King with regard to movements in contemporary art, arts education, and sustainability. Short videos created from each oral history offer an entry point to the full interview transcripts, and are presented here alongside some of the physical items from Storm King’s Archives that illustrate the development of artworks, exhibitions, and programming. </p>";
		
		while($qr_list->nextHit()) {
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			print "<div class='col-sm-6'><div class='collectionTile'>";
			print "<div class='colImage'>".caNavLink($this->request, $qr_list->get("ca_object_representations.media.widepreview"), "", "Detail", "oralhistory",  $qr_list->get("ca_objects.object_id"))."</div>";
			print "<div class='title'>".caNavLink($this->request, $qr_list->get("ca_objects.preferred_labels"), "", "Detail", "oralhistory",  $qr_list->get("ca_objects.object_id"))."</div>";	
			print "<div class='collectionDetail'>".$qr_list->get("ca_objects.description")."</div>";

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
?>