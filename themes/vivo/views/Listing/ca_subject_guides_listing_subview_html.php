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
		
		print "<div class='row'><div class='col-sm-12'><h1>{$va_listing_info['displayName']}</h2></div></div>\n";
		if($vs_intro = $this->getVar("subject_guides_intro_text")){
			print "<p>".$vs_intro."</p>";
		}
		print "<div class='row'>";
		while($qr_list->nextHit()) {
			$vs_desc = $qr_list->get("ca_occurrences.content_description");
			if(strlen($vs_desc) > 125){
				$vs_desc = mb_substr($vs_desc, 0, 125)."...";
			}
			print $qr_list->getWithTemplate("<div class='col-sm-4'><l><div class='activation-block-wrapper'><unit relativeTo='ca_objects' restrictToRelationshipTypes='feature' length='1'>^ca_object_representations.media.large</unit><div class='activation-info-block'><label>^ca_occurrences.preferred_labels.name</label><p>".$vs_desc."</p></div><div style='clear:both;'></div></div></l></div>");
		}
		print "</div>";
	}
?>