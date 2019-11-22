<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/summary.php
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
 * @name Exhibition tear sheet
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_occurrences
 * @types exhibition
 * @marginTop 0.75in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.75in
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	
	$va_access_values 	= $this->getVar('access_values');

	switch(strToLower($t_item->get("ca_occurrences.type_id", array("convertCodesToDisplayText" => true)))){
		case "exhibition":
			print "<H4>".italicizeTitle($t_item->get("ca_occurrences.preferred_labels.name"))."</H4>";
	
			print $t_item->getWithTemplate('<ifdef code="ca_occurrences.solo_group"><div class="unit"><H6>Exhibition Type</H6>^ca_occurrences.solo_group</div></ifdef>
							<ifdef code="ca_occurrences.exhibition_dates_display"><div class="unit"><H6>Dates</H6><unit relativeTo="ca_occurrences" delimiter="<br/>">^ca_occurrences.exhibition_dates_display</unit></div></ifdef>
							<ifnotdef code="ca_occurrences.exhibition_dates_display"><ifdef code="ca_occurrences.common_date"><div class="unit"><H6>Dates</H6>^ca_occurrences.common_date</div></ifdef></ifnotdef>
							<ifcount code="ca_entities" restrictToRelationshipTypes="originator" min="1"><div class="unit"><H6>Organizing Venue</H6><unit relativeTo="ca_entities_x_occurrences" restrictToRelationshipTypes="originator" delimiter="<br/>">^ca_entities.preferred_labels.displayname<unit relativeTo="ca_occurrences"><ifdef code="ca_occurrences.venue_location">, ^ca_occurrences.venue_location</ifdef></unit></unit></div></ifcount>
							<ifdef code="ca_occurrences.venues.venue_name|ca_occurrences.venues.venue_address|ca_occurrences.venues.venue_dates_display">
								<div class="unit"><H6>Traveled To</H6>
								<unit relativeTo="ca_occurrences.venues" delimiter="<br/>">
									<ifdef code="ca_occurrences.venues.venue_name">^ca_occurrences.venues.venue_name, </ifdef>
									<ifdef code="ca_occurrences.venues.venue_address">^ca_occurrences.venues.venue_address, </ifdef>
									<ifdef code="ca_occurrences.venues.venue_dates_display">^ca_occurrences.venues.venue_dates_display </ifdef>
								</unit>
								</div>
							</ifdef>
					
							<ifcount code="ca_occurrences.related" restrictToTypes="chronology" min="1"><H6>Chronology Links</H6></ifcount>
							<unit relativeTo="ca_occurrences.related" delimiter="<br/>" restrictToTypes="chronology">^ca_occurrences.preferred_labels.name</unit>

							<ifcount code="ca_occurrences.related" min="1" restrictToTypes="literature"><div class="unit"><H6>Literature References</H6><unit relativeTo="ca_occurrences.related" restrictToTypes="literature" delimiter="<br/>"><ifdef code="ca_occurrences.lit_citation">^ca_occurrences.lit_citation</ifdef><ifnotdef code="ca_occurrences.lit_citation">^ca_occurrences.preferred_labels</ifnotdef></unit></div></ifcount>
					
							<ifcount code="ca_objects" min="1" restrictToTypes="archival"><div class="unit"><H6>Related Digital Items</H6><unit relativeTo="ca_objects" restrictToTypes="archival" delimiter="<br/>">^ca_objects.preferred_labels<ifdef code="ca_objects.unitdate.dacs_date_text">, ^ca_objects.unitdate.dacs_date_text</ifdef></unit></div></ifcount>
					
							<ifcount code="ca_objects" min="1" restrictToTypes="library">
								<div class="unit"><H6>Related Library Items</H6>
									<unit relativeTo="ca_objects" restrictToTypes="library" delimiter="<br/>">
										^ca_objects.preferred_labels
								
									</unit>
								</div>
							</ifcount>');
		break;
		# --------------------------------
		case "literature":
			print "<H4>".italicizeTitle($t_item->get("ca_occurrences.lit_citation"))."</H4>";
	
			print $t_item->getWithTemplate('<ifdef code="ca_occurrences.idno"><div class="unit"><H6>Identifier</H6>^ca_occurrences.idno</div></ifdef>
											<ifdef code="ca_occurrences.pubType"><div class="unit"><H6>Type</H6>^ca_occurrences.pubType</div></ifdef>');
				if($va_exhibitions = $t_item->get("ca_occurrences.related", array("checkAccess" => $va_access_value, "returnWithStructure" => true, "restrictToTypes" => array("exhibition"), "sort" => "ca_occurrences.common_date"))){
					$t_occ = new ca_occurrences();
					print "<div class='unit'><H6>Exhibitions Referenced</H6>";
					foreach($va_exhibitions as $va_exhibition){
						$t_occ->load($va_exhibition["occurrence_id"]);
						$vs_originating_venue 	= $t_occ->getWithTemplate("<unit relativeTo='ca_entities' restrictToRelationshipTypes='originator' delimiter=', '>^ca_entities.preferred_labels</unit>", array("checkAccess" => $va_access_values));
						if($vs_venue_location = $t_occ->get("ca_occurrences.venue_location", array("delimiter" => ", "))){
							$vs_originating_venue .= ", ".$vs_venue_location;
						}
						$vs_title = italicizeTitle($va_exhibition["name"]);
						$vs_date = $t_occ->get("ca_occurrences.exhibition_dates_display", array("delimiter" => "<br/>"));
						if(!$vs_date){
							$vs_date = $t_occ->get("ca_occurrences.common_date");
						}
						$vs_travel_venues = $t_occ->getWithTemplate('<ifdef code="ca_occurrences.venues.venue_name|ca_occurrences.venues.venue_address|ca_occurrences.venues.venue_dates_display">
								<div class="travelVenue"><div>Traveled To</div>
								<unit relativeTo="ca_occurrences.venues" delimiter="<br/>"><ifdef code="ca_occurrences.venues.venue_name">^ca_occurrences.venues.venue_name, </ifdef><ifdef code="ca_occurrences.venues.venue_address">^ca_occurrences.venues.venue_address<ifdef code="ca_occurrences.venues.venue_dates_display">, </ifdef></ifdef><ifdef code="ca_occurrences.venues.venue_dates_display">^ca_occurrences.venues.venue_dates_display</ifdef>.</unit>
								</div>
							</ifdef>');
						print (($vs_originating_venue) ? $vs_originating_venue.", " : "").$vs_title.(($vs_date) ? ", ".$vs_date : "").".".$vs_travel_venues.(($vs_travel_venues) ? "" : "<br/><br/>");
					}
					print "</div>";
				}
				
				
		break;
		# --------------------------------
	}
				
				$va_rel_artworks = $t_item->get("ca_objects.related.object_id", array("checkAccess" => $va_access_values, "restrictToTypes" => array("artwork", "art_HFF", "edition_HFF", "art_nonHFF", "edition_nonHFF"), "returnAsArray" => true));
				if(is_array($va_rel_artworks) && sizeof($va_rel_artworks)){
					$qr_res = caMakeSearchResult("ca_objects", $va_rel_artworks);
?>
					<div class='unit'><H6><?php print (strToLower($t_item->get("ca_occurrences.type_id", array("convertCodesToDisplayText" => true))) == "literature") ? "Works Referenced" : "Works Exhibited"; ?></H6>
<?php
					$t_objects_x_occurrences = new ca_objects_x_occurrences();
					while($qr_res->nextHit()){
						$va_relations = $qr_res->get("ca_objects_x_occurrences.relation_id", array("checkAccess" => $va_access_values, "restrictToTypes" => array("artwork", "art_HFF", "edition_HFF", "art_nonHFF", "edition_nonHFF"), "returnAsArray" => true));
						foreach($va_relations as $vn_relationship_id){
							$t_objects_x_occurrences->load($vn_relationship_id);
							if($t_objects_x_occurrences->get("occurrence_id") == $t_item->get("ca_occurrences.occurrence_id")){
								break;
							}
						}
				
						$vn_id = $qr_res->get("ca_objects.object_id");
						$vs_idno_detail_link 	= "<small>".$qr_res->get("ca_objects.idno")."</small><br/>";
						$vs_label_detail_link 	= italicizeTitle($qr_res->get("ca_objects.preferred_labels")).(($qr_res->get("ca_objects.common_date")) ? ", ".$qr_res->get("ca_objects.common_date") : "");
						$vs_rep_detail_link = $qr_res->get('ca_object_representations.media.thumbnail', array("checkAccess" => $va_access_values));
						
						$va_interstitial = array();
						if(strToLower($t_item->get("ca_occurrences.type_id", array("convertCodesToDisplayText" => true))) == "literature"){
							if($vs_tmp = $t_objects_x_occurrences->get("source")){
								$va_interstitial[] = "Citation: ".$vs_tmp;
							}
						}
						if(strToLower($t_item->get("ca_occurrences.type_id", array("convertCodesToDisplayText" => true))) == "exhibition"){
							if($vs_tmp = $t_objects_x_occurrences->get("checklist_number")){
								$va_interstitial[] = $vs_tmp;
							}
						}						
						print "<div class='relArtwork'>{$vs_rep_detail_link}<div class='relArtworkCaption'>{$vs_idno_detail_link}{$vs_label_detail_link}".((is_array($va_interstitial) && sizeof($va_interstitial)) ? "<br/>".join("<br/>", $va_interstitial) : "")."</div></div>";

						
					}
					print "</div>";
					
				}

		


	
	print $this->render("pdfEnd.php");
?>