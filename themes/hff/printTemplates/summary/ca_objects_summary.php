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
 * @name Object tear sheet
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
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

?>
	<div class="representationList">
		
<?php
	$va_reps = $t_item->getRepresentations(array("thumbnail", "medium"));

	foreach($va_reps as $va_rep) {
		if(sizeof($va_reps) > 1){
			# --- more than one rep show thumbnails
			$vn_padding_top = ((120 - $va_rep["info"]["thumbnail"]["HEIGHT"])/2) + 5;
			print $va_rep['tags']['thumbnail']."\n";
		}else{
			# --- one rep - show medium rep
			print $va_rep['tags']['medium']."\n";
		}
	}
?>
	</div>
<?php






					$vs_typecode = "";
					$t_list_item = new ca_list_items($t_item->get("type_id"));
					$vs_typecode = $t_list_item->get("idno");
					
					$vs_idno_detail_link = "";
					$vs_label_detail_link = "";
					switch($vs_typecode){
						# ------------------------
						case "archival":
							print "<H4>".$t_item->get("ca_objects.preferred_labels.name")."</H4>";
							print $t_item->getWithTemplate('<ifdef code="ca_objects.unitdate.dacs_date_text"><div class="unit"><H6>Date</H6>^ca_objects.unitdate.dacs_date_text</div></ifdef>');
							print $t_item->getWithTemplate('<ifnotdef code="ca_objects.unitdate.dacs_date_text"><ifdef code="ca_objects.unitdate.dacs_date_value"><div class="unit"><H6>Date</H6>^ca_objects.unitdate.dacs_date_value</div></ifdef></ifnotdef>');
							print $t_item->getWithTemplate('<ifdef code="ca_objects.idno"><div class="unit"><H6>Identifier</H6>^ca_objects.idno</div></ifdef>');
							print $t_item->getWithTemplate('<ifdef code="ca_object_representations.media_types"><div class="unit"><H6>Media Type</H6>^ca_object_representations.media_types%delimiter=,_</div></ifdef>', array("checkAccess" => $va_access_values));
							print $t_item->getWithTemplate('<ifdef code="ca_object_representations.caption"><div class="unit"><H6>Preferred Caption</H6>^ca_object_representations.caption</div></ifdef>', array("checkAccess" => $va_access_values));
				
							print $t_item->getWithTemplate('<ifdef code="ca_objects.extentDACS.extent_number|ca_objects.extentDACS.extent_type|ca_objects.extentDACS.physical_details|ca_objects.extentDACS.extent_dimensions">
								<div class="unit"><H6>Extent & Medium</H6>
									<unit relativeTo="ca_objects.extentDACS" delimiter="<br/>">
										<ifdef code="ca_objects.extentDACS.extent_number">^ca_objects.extentDACS.extent_number </ifdef>
										<ifdef code="ca_objects.extentDACS.extent_type">^ca_objects.extentDACS.extent_type: </ifdef>
										<ifdef code="ca_objects.extentDACS.physical_details">^ca_objects.extentDACS.physical_details</ifdef><ifdef code="ca_objects.extentDACS.physical_details,ca_objects.extentDACS.extent_dimensions">; </ifdef>
										<ifdef code="ca_objects.extentDACS.extent_dimensions">^ca_objects.extentDACS.extent_dimensions </ifdef>
									</unit>
								</div>
							</ifdef>');
				
				
							print $t_item->getWithTemplate('<ifdef code="ca_object_representations.copyright_statement"><div class="unit"><H6>Rights</H6>^ca_object_representations.copyright_statement</div></ifdef>', array("checkAccess" => $va_access_values));
				
							if($va_rel_entities = $t_item->get("ca_entities", array("checkAccess" => $va_access_values, "returnWithStructure" => true))){
								$va_entities_by_type = array();
								foreach($va_rel_entities as $va_rel_entity){
									$va_entities_by_type[$va_rel_entity["relationship_typename"]][] = $va_rel_entity["displayname"];
								}
								foreach($va_entities_by_type as $vs_rel_type => $va_ents){
									print "<div class='unit'><H6>".ucfirst($vs_rel_type)."</H6>".join("<br/>", $va_ents)."</div>";
								}
							}
				
							print $t_item->getWithTemplate('<ifcount code="ca_collections" min="1"><div class="unit"><H6>Location in Archives Collection</H6><unit relativeTo="ca_collections" delimiter=" > ">^ca_collections.hierarchy.preferred_labels</unit></div></ifcount>', array("checkAccess" => $va_access_values));
							
						break;
						# ------------------------
						case "artwork":
						case "art_HFF":
						case "art_nonHFF":
						case "edition":
						case "edition_HFF":
						case "edition_nonHFF":






?>
				<div class="unit">
					<small><?php print $t_item->get('ca_objects.idno'); ?></small>
					<?php print $t_item->getWithTemplate('<ifdef code="ca_objects.art_numbers.id_value"><unit relativeTo="ca_objects" delimiter="; "><if rule="^ca_objects.art_numbers.id_types =~ /Studio/"><br/>^ca_objects.art_numbers.id_value</if></unit></ifdef>'); ?>
					<br/><?php print $t_item->getWithTemplate('<unit>^ca_objects.type_id</unit>'); ?>
				</div>
				<HR>
				<div class="unit">
<?php
					$va_artists = $t_item->get("ca_entities", array("checkAccess" => $va_access_value, "returnWithStructure" => true, "restrictToRelationshipTypes" => array("artist")));
					if(is_array($va_artists) && sizeof($va_artists)){
						$va_tmp = array();
						foreach($va_artists as $va_artist){
							$va_tmp[] = $va_artist["displayname"];
						}
						print join(", ",$va_tmp)."<br/>";
					}
					$vs_title = $t_item->get("ca_objects.preferred_labels.name");
					if($vs_title){
						print italicizeTitle($vs_title)."<br/>";
					}
					$vs_alt_title = $t_item->get("ca_objects.nonpreferred_labels.name", array("delimiter" => ", "));
					if($vs_alt_title){
						print "<small>".italicizeTitle($vs_alt_title)."</small><br/>";
					}

					print $t_item->getWithTemplate('<ifdef code="ca_objects.common_date">^ca_objects.common_date<br/></ifdef>');				
					print $t_item->getWithTemplate('<ifdef code="ca_objects.medium_notes.medium_notes_text">^ca_objects.medium_notes.medium_notes_text<br/></ifdef>');				

					$vs_dimensions = trim(str_replace("artwork", "", $t_item->get("ca_objects.dimensions.display_dimensions")));
					if($vs_dimensions){
						print $vs_dimensions."<br/>";
					}

					print $t_item->getWithTemplate('<ifdef code="ca_objects.recto_inscriptions.inscriptions_text">^ca_objects.recto_inscriptions.inscriptions_text<br/></ifdef>');				
					print $t_item->getWithTemplate('<ifdef code="ca_objects.verso_inscriptions.verso_text">^ca_objects.verso_inscriptions.verso_text<br/></ifdef>');				
?>
				</div>
				<HR>
				
<?php
				if($va_provenance = $t_item->get("ca_occurrences", array("checkAccess" => $va_access_value, "returnWithStructure" => true, "restrictToTypes" => array("provenance")))){
					$t_obj_x_occ = new ca_objects_x_occurrences();
					$va_current_collection = array();
					$va_provenance_display = array();
					foreach($va_provenance as $va_provenance_info){
						$t_obj_x_occ->load($va_provenance_info["relation_id"]);
						$vs_credit_accession = $t_obj_x_occ->get("interstitial_notes");
						if($vs_credit_accession){
							if(strToLower($t_obj_x_occ->get("ca_objects_x_occurrences.current_collection", array("convertCodesToDisplayText" => true))) == "yes"){
								$va_current_collection[] = $vs_credit_accession;
							
							}else{
								$va_provenance_display[] = $vs_credit_accession;
							}
						}
					}
					if(sizeof($va_current_collection)){
						print "<div class='unit'><H6>Current Collection</H6>".join("<br/>", $va_current_collection)."</div>";
					}
					if(sizeof($va_provenance_display)){
						print "<div class='unit'><H6>Provenance</H6>".join("<br/>", $va_provenance_display)."</div>";
					}
				}
				if($va_exhibitions = $t_item->get("ca_occurrences", array("checkAccess" => $va_access_value, "returnWithStructure" => true, "restrictToTypes" => array("exhibition")))){
					$t_occ = new ca_occurrences();
					print "<div class='unit'><H6>Exhibition History</H6>";
					$t_objects_x_occurrences = new ca_objects_x_occurrences();
					foreach($va_exhibitions as $va_exhibition){
						$t_occ->load($va_exhibition["occurrence_id"]);
						$vs_originating_venue 	= $t_occ->getWithTemplate("<unit relativeTo='ca_entities' restrictToRelationshipTypes='originator' delimiter=', '>^ca_entities.preferred_labels</unit>", array("checkAccess" => $va_access_values));
						$vs_title = italicizeTitle($va_exhibition["name"]);
						$vs_date = $t_occ->get("ca_occurrences.exhibition_dates_display", array("delimiter" => "<br/>"));
						if(!$vs_date){
							$vs_date = $t_occ->get("ca_occurrences.common_date");
						}
						# --- interstitial
						$va_relations = $t_occ->get("ca_objects_x_occurrences.relation_id", array("checkAccess" => $va_access_values, "returnAsArray" => true));
						foreach($va_relations as $vn_relationship_id){
							$t_objects_x_occurrences->load($vn_relationship_id);
							if($t_objects_x_occurrences->get("object_id") == $t_item->get("ca_objects.object_id")){
								break;
							}
						}
						$vs_citation = "";
						if($vs_citation = $t_objects_x_occurrences->get("checklist_number")){
							$vs_citation = ", ".$vs_citation;
						}
						$vs_travel_venues = $t_occ->getWithTemplate('<ifdef code="ca_occurrences.venues.venue_name|ca_occurrences.venues.venue_address|ca_occurrences.venues.venue_dates_display">
						<div class="travelVenue"><div>Traveled To</div>
						<unit relativeTo="ca_occurrences.venues" delimiter="<br/><br/>">
								<ifdef code="ca_occurrences.venues.venue_name">^ca_occurrences.venues.venue_name, </ifdef>
								<ifdef code="ca_occurrences.venues.venue_address">^ca_occurrences.venues.venue_address, </ifdef>
								<ifdef code="ca_occurrences.venues.venue_dates_display">^ca_occurrences.venues.venue_dates_display </ifdef>
						</unit>
						</div>
					</ifdef>');
						print (($vs_originating_venue) ? $vs_originating_venue.", " : "").$vs_title.(($vs_date) ? ", ".$vs_date : "").$vs_citation.$vs_travel_venues.(($vs_travel_venues) ? "" : "<br/><br/>");
					}
					print "</div>";
				}
				if($va_literatures = $t_item->get("ca_occurrences", array("checkAccess" => $va_access_value, "returnWithStructure" => true, "restrictToTypes" => array("literature")))){
					$t_occ = new ca_occurrences();
					print "<div class='unit'><H6>Literature References</H6>";
					$t_objects_x_occurrences = new ca_objects_x_occurrences();
					foreach($va_literatures as $va_literature){
						$t_occ->load($va_literature["occurrence_id"]);
						$vs_title = "";
						if($vs_tmp = $t_occ->get("ca_occurrences.lit_citation")){
							$vs_title = $vs_tmp;
						}else{
							$vs_title = $t_occ->get("ca_occurrences.preferred_labels");
						}
						# --- interstitial
						$va_relations = $t_occ->get("ca_objects_x_occurrences.relation_id", array("checkAccess" => $va_access_values, "returnAsArray" => true));
						foreach($va_relations as $vn_relationship_id){
							$t_objects_x_occurrences->load($vn_relationship_id);
							if($t_objects_x_occurrences->get("object_id") == $t_item->get("ca_objects.object_id")){
								break;
							}
						}
						$vs_interstitial = "";
						if($vs_tmp = $t_objects_x_occurrences->get("source")){
							$vs_interstitial = ", ".$vs_tmp;
						}
						print $vs_title.$vs_interstitial."<br/><br/>";
					}
					print "</div>";
				}			
				print $t_item->getWithTemplate('<ifdef code="ca_objects.remarks"><div class="unit"><h6>Remarks</h6>^ca_objects.remarks</div></ifdef>');
				

				$va_rel_artworks = $t_item->get("ca_objects.related.object_id", array("checkAccess" => $va_access_values, "restrictToTypes" => array("artwork", "art_HFF", "edition_HFF", "art_nonHFF", "edition_nonHFF"), "returnAsArray" => true));
				if(is_array($va_rel_artworks) && sizeof($va_rel_artworks)){
					$qr_res = caMakeSearchResult("ca_objects", $va_rel_artworks);
					$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'><i class='fa fa-picture-o fa-2x'></i></div>";
?>
					<div style="page-break-after: always;"></div><hr/><br/><H6>Related Works</H6><br/>
					
<?php
					
					$i = 0;
					while($qr_res->nextHit()){
						if($i == 0){
							print "<div class='unit'>";
						}
						$vn_id = $qr_res->get("ca_objects.object_id");
						$vs_idno_detail_link 	= "<small>".$qr_res->get("ca_objects.idno")."</small><br/>";
						$vs_label_detail_link 	= italicizeTitle($qr_res->get("ca_objects.preferred_labels")).(($qr_res->get("ca_objects.common_date")) ? ", ".$qr_res->get("ca_objects.common_date") : "");
						if(!($vs_thumbnail = $qr_res->get('ca_object_representations.media.thumbnail', array("checkAccess" => $va_access_values)))){
							$vs_thumbnail = $vs_default_placeholder_tag;
						}
						$vs_info = null;
						$vs_rep_detail_link 	= $vs_thumbnail;				

						print "<div class='bResultItemCol'>
			<div class='bResultItem'>
				<div class='text-center bResultItemImg'>{$vs_rep_detail_link}</div>
					<div class='bResultItemText'>
						{$vs_idno_detail_link}{$vs_label_detail_link}
					</div><!-- end bResultItemText -->
			</div><!-- end bResultItem -->
		</div><!-- end col -->";
						$i++;
						if($i == 4){
							$i = 0;
							print "</div><!-- end unit -->";
						}
					}
					if($i > 0){
						print "</div><!-- end unit -->";
					}
					
					
				}
	








						break;
						# ------------------------
						case "library":
							
							
							
							
							
							
							
				print $t_item->getWithTemplate('<ifdef code="ca_objects.preferred_labels"><div class="unit"><H6>Title</H6>^ca_objects.preferred_labels</div></ifdef>');
				print $t_item->getWithTemplate('<ifdef code="ca_objects.author.author_name"><div class="unit"><H6>Author</H6>^ca_objects.author.author_name</div></ifdef>');

				$vs_pub = $t_item->getWithTemplate("<unit relativeTo='ca_entities' restrictToRelationshipTypes='publisher' delimiter=', '>^ca_entities.preferred_labels</unit>", array("checkAccess" => $va_access_values));
				if(!$vs_pub){
					$vs_pub = $t_item->get("ca_objects.publisher", array("delimiter" => ", "));
				}
				if($vs_pub){
					print "<div class='unit'><H6>Publisher</H6>".$vs_pub."</div>";
				}

				print $t_item->getWithTemplate('<ifdef code="ca_objects.common_date"><div class="unit"><H6>Year</H6>^ca_objects.common_date%delimiter=,_</div></ifdef>');
				print $t_item->getWithTemplate('<ifdef code="ca_objects.library"><div class="unit"><H6>Library</H6>^ca_objects.library%delimiter=,_</div></ifdef>');
				print $t_item->getWithTemplate('<ifdef code="ca_objects.book_category"><div class="unit"><H6>Media Type</H6>^ca_objects.book_category%delimiter=,_</div></ifdef>');
				print $t_item->getWithTemplate('<ifdef code="ca_objects.call_number"><div class="unit"><H6>Call Number</H6>^ca_objects.call_number%delimiter=,_</div></ifdef>');
				print $t_item->getWithTemplate('<ifdef code="ca_objects.artwork_status"><div class="unit"><H6>Tags</H6>^ca_objects.artwork_status%delimiter=,_</div></ifdef>');
				print $t_item->getWithTemplate('<ifdef code="ca_objects.remarks"><div class="unit"><H6>Notes</H6>^ca_objects.remarks%delimiter=,_</div></ifdef>');

							

				$va_rel_artworks = $t_item->get("ca_objects.related.object_id", array("checkAccess" => $va_access_values, "restrictToRelationshipTypes" => array("references"), "returnAsArray" => true));
				if(is_array($va_rel_artworks) && sizeof($va_rel_artworks)){
					$qr_res = caMakeSearchResult("ca_objects", $va_rel_artworks);
					$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'><i class='fa fa-picture-o fa-2x'></i></div>";
?>
					<div style="page-break-after: always;"></div><hr/><br/><H6>Works Referenced</H6><br/>
					<div class='unit'>
<?php
					$i = 0;
					while($qr_res->nextHit()){
						if($i == 0){
							print "<div class='unit'>";
						}
						$vn_id = $qr_res->get("ca_objects.object_id");
						$vs_idno_detail_link 	= "<small>".$qr_res->get("ca_objects.idno")."</small><br/>";
						$vs_label_detail_link 	= italicizeTitle($qr_res->get("ca_objects.preferred_labels")).(($qr_res->get("ca_objects.common_date")) ? ", ".$qr_res->get("ca_objects.common_date") : "");
						if(!($vs_thumbnail = $qr_res->get('ca_object_representations.media.thumbnail', array("checkAccess" => $va_access_values)))){
							$vs_thumbnail = $vs_default_placeholder_tag;
						}
						$vs_info = null;
						$vs_rep_detail_link 	= $vs_thumbnail;				

						print "<div class='bResultItemCol'>
			<div class='bResultItem'>
				<div class='text-center bResultItemImg'>{$vs_rep_detail_link}</div>
					<div class='bResultItemText'>
						{$vs_idno_detail_link}{$vs_label_detail_link}
					</div><!-- end bResultItemText -->
			</div><!-- end bResultItem -->
		</div><!-- end col -->";
						$i++;
						if($i == 4){
							$i = 0;
							print "</div><!-- end unit -->";
						}
					}
					if($i > 0){
						print "</div><!-- end unit -->";
					}
					
				}
							
							
							
							
						
						break;
						# ------------------------
					}













	
	print $this->render("pdfEnd.php");