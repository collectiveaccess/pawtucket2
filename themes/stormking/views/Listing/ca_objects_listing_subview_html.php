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
 		print "<p style='clear:both;'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus convallis, tortor at varius ultricies, lacus neque imperdiet orci, id bibendum mi lorem ac quam. Pellentesque iaculis eleifend faucibus. Aliquam mauris justo, mollis sed ante in, lacinia condimentum diam. Duis et rhoncus ligula. Vivamus arcu leo, pellentesque ut neque et, viverra dapibus ante. Quisque ac ultricies sapien. Sed eget dui elementum, dictum lorem sit amet, ullamcorper lacus. Integer ut lectus pharetra, eleifend risus a, luctus urna. Fusce leo lacus, rutrum vel tempor vel, volutpat eget ipsum. Curabitur maximus maximus eros, ac finibus ligula volutpat sed. Nulla porttitor, sem nec lacinia pharetra, diam mi interdum velit, in semper orci magna eu lacus. Praesent luctus porta dui, non maximus leo sodales at. Quisque congue, nisl sed venenatis ullamcorper, augue sapien blandit diam, eu dictum metus erat non mi. Aenean neque felis, tristique at ligula id, vestibulum auctor odio.</p>";
		
		while($qr_list->nextHit()) {
			if ( $vn_i == 0) { print "<div class='row'>"; } 
			print "<div class='col-sm-6'><div class='collectionTile'>";
			print "<div class='colImage'>".caDetailLink($this->request, $qr_list->get("ca_object_representations.media.widepreview"), "", "ca_objects",  $qr_list->get("ca_objects.object_id"))."</div>";
			print "<div class='title'>".caDetailLink($this->request, $qr_list->get("ca_objects.preferred_labels"), "", "ca_objects",  $qr_list->get("ca_objects.object_id"))."</div>";	
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