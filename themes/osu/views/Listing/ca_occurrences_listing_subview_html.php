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
		
		print "<h2>{$va_listing_info['displayName']}</h2>\n";
		print "<div class='row'>";
		while($qr_list->nextHit()) {
			$t_occurrence = new ca_occurrences($qr_list->get('ca_occurrences.occurrence_id'));	
			$va_related_objects = $t_occurrence->get('ca_objects.object_id', array('returnAsArray' => true));
			print "<div class='event col-sm-4 col-md-3 col-lg-2'>";
			$t_object = new ca_objects($va_related_objects[0]);
			if ($t_object->get('ca_object_representations.media.medium')) {
				print "<div class='eventImg'>".$t_object->get('ca_object_representations.media.medium')."</div>";
			} else {
				print "<div class='placeholder'></div>";
			}
			print $qr_list->get('ca_occurrences.preferred_labels.name');
			print "</div>";	
		}
		print "</div>";
	}
?>