<?php
/* ----------------------------------------------------------------------
 * app/templates/checklist.php
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
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Checklist with works
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_occurrences
 * @marginTop 0.75in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.5in
 * ----------------------------------------------------------------------
 */

	$t_display				= $this->getVar('t_display');
	$va_display_list 		= $this->getVar('display_list');
	$vo_result 				= $this->getVar('result');
	$vn_items_per_page 		= $this->getVar('current_items_per_page');
	$vs_current_sort 		= $this->getVar('current_sort');
	$vs_default_action		= $this->getVar('default_action');
	$vo_ar					= $this->getVar('access_restrictions');
	$vo_result_context 		= $this->getVar('result_context');
	$vn_num_items			= (int)$vo_result->numHits();
	$va_access_values = caGetUserAccessValues($this->request);
	
	$vn_start 				= 0;
	$vs_table = "ca_occurrences";
	$va_ids = array();
	while($vo_result->nextHit()) {
		$va_ids[] = $vo_result->get("ca_occurrences.occurrence_id");
	}

	$vo_result->seek(0);
	$va_images = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids, array('version' => 'thumbnail', 'relationshipTypes' => array("featured", "featured_simple"), 'checkAccess' => $va_access_values));

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");
?>
		<div id='body'>
<?php

		$vo_result->seek(0);
		
		$vn_line_count = 0;
		while($vo_result->nextHit()) {
			$vn_occ_id = $vo_result->get('ca_occurrences.occurrence_id');
			$vs_typecode = "";
			$t_list_item = new ca_list_items($vo_result->get("type_id"));
			$vs_typecode = $t_list_item->get("idno");
					
?>
			<div class="row">
			<table>
			<tr>
<?php
				if(!in_array($vs_typecode, array("literature"	))){
?>
				<td>
<?php 
					if ($vs_img = $va_images[$vn_occ_id]) {
						print "<div class=\"imageTiny\">".$vs_img."</div>";
					} else {
?>
						<div class="imageTinyPlaceholder">&nbsp;</div>
<?php					
					}	
?>								

				</td>
<?php
				}
?>
				<td>
					<div class="metaBlock">
<?php				
					
					$vs_idno = "";
					$vs_label = "";
					switch($vs_typecode){
						case "literature":
							$vs_tmp = $vo_result->get("{$vs_table}.lit_citation");
							$vs_label 	= ($vs_tmp) ? $vs_tmp : "No citation available.  Title: ".$vo_result->get("{$vs_table}.preferred_labels");
							
						break;
						# ------------------------
						case "exhibition":
							# --- no idno link
							# --- originating venue, exhibition title, date (display)
							$vs_originating_venue 	= $vo_result->getWithTemplate("<unit relativeTo='ca_entities' restrictToRelationshipTypes='originator' delimiter=', '>^ca_entities.preferred_labels</unit>", array("checkAccess" => $va_access_values));
							if($vs_venue_location = $vo_result->get("ca_occurrences.venue_location", array("delimiter" => ", "))){
								$vs_originating_venue .= ", ".$vs_venue_location;
							}
							$vs_title = $vo_result->get("{$vs_table}.preferred_labels");
							# --- add closing & opening <i> tags to un-italicize andy brackets
							$vs_title = italicizeTitle($vs_title);
							$vs_date = $vo_result->get("ca_occurrences.exhibition_dates_display", array("delimiter" => "<br/>"));
							if(!$vs_date){
								$vs_date = $vo_result->get("ca_occurrences.common_date");
							}
							$vs_travel_venues = $vo_result->getWithTemplate('<ifdef code="ca_occurrences.venues.venue_name|ca_occurrences.venues.venue_address|ca_occurrences.venues.venue_dates_display">
								<div style="padding-left:20px;"><div>Traveled To</div>
								<unit relativeTo="ca_occurrences.venues" delimiter="<br/>" sort="ca_occurrences.venues.venue_dates"><ifdef code="ca_occurrences.venues.venue_name">^ca_occurrences.venues.venue_name, </ifdef><ifdef code="ca_occurrences.venues.venue_address">^ca_occurrences.venues.venue_address<ifdef code="ca_occurrences.venues.venue_dates_display">, </ifdef></ifdef><ifdef code="ca_occurrences.venues.venue_dates_display">^ca_occurrences.venues.venue_dates_display</ifdef>.</unit>
								</div>
							</ifdef>');
							$vs_related_works = $vo_result->getWithTemplate('<unit relativeTo="ca_objects" restrictToTypes = "artwork,art_HFF,edition_HFF,art_nonHFF,edition_nonHFF" delimiter="; ">^ca_objects.preferred_labels.name<ifdef code="ca_objects.common_date">, ^ca_objects.common_date</ifdef></unit>');
							if($vs_related_works){
								$vs_related_works = '<div style="padding-left:20px;"><div>Works Exhibited</div>'.$vs_related_works.'</div>';
							}
							$vs_label 	.= (($vs_originating_venue) ? $vs_originating_venue.", " : "").$vs_title.(($vs_date) ? ", ".$vs_date : "").$vs_travel_venues.(($vs_travel_venues && $vs_related_works) ? "<br/>" : "").$vs_related_works;
						break;
						# ------------------------
						default:
							$vs_idno 	= "<small>".$vo_result->get("{$vs_table}.idno")."</small><br/>";
							$vs_label 	= $vo_result->get("{$vs_table}.preferred_labels");
					
						break;
						# ------------------------
					}
					
					
					print "<div>".$vs_idno.$vs_label."</div>"; 
					
?>
					</div>				
				</td>	
			</tr>
			</table>	
			</div>
<?php
		}
?>
		</div>
<?php
	print $this->render("pdfEnd.php");
?>