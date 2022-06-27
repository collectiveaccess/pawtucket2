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
 
	foreach($va_lists as $vn_type_id => $qr_list) {
		if(!$qr_list) { continue; }
		
		print "<div class='row'><div class='col-sm-12'><h2>{$va_listing_info['displayName']} <span class='resultCount'>/ ".$qr_list->numHits()." courses</span></h2></div></div>\n";
?>
		<div class='row'>
<?php		
		while($qr_list->nextHit()) {
			print "<div class='col-md-6 col-lg-4'><div class='listingResult'><div class='row'>";
			# --- show related item with "featured" rel type or default to icon
			#$vs_icon = $qr_list->getWithTemplate("<unit relativeTo='ca_objects' restrictToRelationshipTypes='featured' restrictToTypes='item' length='1'>^ca_object_representations.media.iconlarge</unit>");
			# --- get primary rep to show as icon
			$vs_icon = $qr_list->get("ca_object_representations.media.iconlarge", array("checkAccess" => $va_access_values, "primaryOnly" => 1));
			
			if(!$vs_icon){
				$vs_icon = caGetThemeGraphic($this->request, 'courseIcon.jpg');
			}
			print "<div class='col-xs-4'><div class='listingIcon'>".caDetailLink($this->request, $vs_icon, "", "ca_occurrences", $qr_list->get('ca_occurrences.occurrence_id'))."</div></div>";
			print "<div class='col-xs-8'><div class='listingTitle'>".$qr_list->getWithTemplate('<l>^ca_occurrences.preferred_labels.name</l>')."</div><div class='listingSubtitle'>".$qr_list->getWithTemplate('<l>^ca_occurrences.idno</l>')."</div>";
			$vs_desc_len = mb_strlen($qr_list->get('ca_occurrences.course_description'));
			print "<div class='listingDesc'>";
			if($vs_desc_len){
				print mb_substr($qr_list->get('ca_occurrences.course_description'), 0, 170);
				if($vs_desc_len > 170){
					print "...";
				}
			}
			print "</div>";
			print caDetailLink($this->request, _t("Learn More"), "btn-default", "ca_occurrences", $qr_list->get('ca_occurrences.occurrence_id'));
			print "</div></div></div></div>\n";
		}
?>
		</div>
<?php
	}
?>