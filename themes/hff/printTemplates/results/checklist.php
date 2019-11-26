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
 * @name Checklist
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
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
	$vs_table = "ca_objects";
	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");
?>
		<div id='body'>
<?php

		$vo_result->seek(0);
		
		$vn_line_count = 0;
		while($vo_result->nextHit()) {
			$vn_object_id = $vo_result->get('ca_objects.object_id');
			$vs_typecode = "";
			$t_list_item = new ca_list_items($vo_result->get("type_id"));
			$vs_typecode = $t_list_item->get("idno");
					
?>
			<div class="row">
			<table>
			<tr>
<?php
				if(!in_array($vs_typecode, array("library"	))){
?>
				<td class="imageTinyCol">
<?php 
					if ($vs_path = $vo_result->getMediaPath('ca_object_representations.media', 'thumbnail')) {
						print "<div class=\"imageTiny\"><img src='{$vs_path}'/></div>";
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
						# ------------------------
						case "archival":
							# --- no idno link
							#title, display date, DB#, Extent and Medium, Caption, Rights, and location (including the collection level)
							$va_parts = array();
							if($vs_tmp = $vo_result->get("ca_objects.preferred_labels")){
								$va_parts[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->get("ca_objects.unitdate.dacs_date_text", array("delimiter" => ", "))){
								$va_parts[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->get("ca_objects.idno", array("delimiter" => ", "))){
								$va_parts[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->getWithTemplate("<unit relativeTo='ca_objects.extentDACS' delimiter='<br/>'><ifdef code='ca_objects.extentDACS.extent_number'>^ca_objects.extentDACS.extent_number </ifdef><ifdef code='ca_objects.extentDACS.extent_type'>^ca_objects.extentDACS.extent_type: </ifdef><ifdef code='ca_objects.extentDACS.physical_details'>^ca_objects.extentDACS.physical_details</ifdef><ifdef code='ca_objects.extentDACS.physical_details,ca_objects.extentDACS.extent_dimensions'>; </ifdef><ifdef code='ca_objects.extentDACS.extent_dimensions'>^ca_objects.extentDACS.extent_dimensions </ifdef></unit>", array("delimiter" => ", "))){
								$va_parts[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->get("ca_object_representations.caption", array("delimiter" => ", "))){
								$va_parts[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->get("ca_object_representations.copyright_statement", array("delimiter" => ", "))){
								$va_parts[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->getWithTemplate("<unit relativeTo='ca_collections' delimiter=' > '>^ca_collections.hierarchy.preferred_labels</unit>", array("delimiter" => ", "))){
								$va_parts[] = $vs_tmp;
							}
							print join("<br/><br/>", $va_parts);
						break;
						# ------------------------
						case "artwork":
						case "art_HFF":
						case "art_nonHFF":
						case "edition":
						case "edition_HFF":
						case "edition_nonHFF":
							#Identifier, Type, Artist, Title, Date, Medium, Dimensions, and Current Collection
							$vs_idno 	= $vo_result->get("{$vs_table}.idno").", ";
							$va_label_tmp = array();
							if($vs_tmp = $vo_result->get("ca_objects.type_id", array("convertCodesToDisplayText" => true))){
								$va_label_tmp[] = $vs_tmp;
							}
							$va_artists = $vo_result->get("ca_entities", array("checkAccess" => $va_access_value, "returnWithStructure" => true, "restrictToRelationshipTypes" => array("artist")));
							if(is_array($va_artists) && sizeof($va_artists)){
								$va_tmp = array();
								foreach($va_artists as $va_artist){
									$va_tmp[] = trim($va_artist["displayname"]);
								}
								$va_label_tmp[] = join(", ",$va_tmp);
							}
							$va_label_tmp[] = italicizeTitle($vo_result->get("{$vs_table}.preferred_labels"));
							if($vs_tmp = $vo_result->get("{$vs_table}.common_date")){
								$va_label_tmp[] = $vs_tmp;
							}
							if($vs_medium = $vo_result->getWithTemplate('<ifdef code="ca_objects.medium_notes.medium_notes_text">^ca_objects.medium_notes.medium_notes_text</ifdef>')){
								$va_label_tmp[] = $vs_medium;
							}				
							if($vs_dimensions = trim(str_replace("artwork", "", $vo_result->get("ca_objects.dimensions.display_dimensions")))){
								$va_label_tmp[] = $vs_dimensions;
							}
							if($va_provenance = $vo_result->get("ca_occurrences", array("checkAccess" => $va_access_value, "returnWithStructure" => true, "restrictToTypes" => array("provenance")))){
								$t_obj_x_occ = new ca_objects_x_occurrences();
								$va_current_collection = array();
								foreach($va_provenance as $va_provenance_info){
									$t_obj_x_occ->load($va_provenance_info["relation_id"]);
									$vs_date = $t_obj_x_occ->get("effective_date");
									# --- yes no values are switched in this list
									if(strToLower($t_obj_x_occ->get("ca_objects_x_occurrences.current_collection", array("convertCodesToDisplayText" => true))) == "no"){
										$va_current_collection[] = $va_provenance_info["name"].(($vs_date) ? ", ".$vs_date : "");
							
									}
								}
								if(sizeof($va_current_collection)){
									$va_label_tmp[] = join("; ", $va_current_collection);
								}
							}
							
							$vs_label = join("<br/>", $va_label_tmp);
						break;
						# ------------------------
						case "library":
							# --- no idno link
							# --- title, author, publisher, year, library, LC classification, Tags, Public Note
							$va_tmp = array();
							if($vs_tmp = $vo_result->get("ca_objects.preferred_labels")){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->get("ca_objects.author.author_name", array("delimiter" => ", "))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->getWithTemplate("<unit relativeTo='ca_entities' restrictToRelationshipTypes='publisher' delimiter=', '>^ca_entities.preferred_labels</unit>", array("checkAccess" => $va_access_values))){
								$va_tmp[] = $vs_tmp;
							}elseif($vs_tmp = $vo_result->get("ca_objects.publisher", array("delimiter" => ", "))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->get("ca_objects.common_date", array("delimiter" => ", "))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->get("ca_objects.library", array("delimiter" => ", ", "convertCodesToDisplayText" => true))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->get("ca_objects.call_number", array("delimiter" => ", "))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->get("ca_objects.artwork_status", array("delimiter" => ", ", "convertCodesToDisplayText" => true))){
								$va_tmp[] = $vs_tmp;
							}
							if($vs_tmp = $vo_result->get("ca_objects.remarks", array("delimiter" => ", "))){
								$va_tmp[] = $vs_tmp;
							}
							$vs_label 	.= join("<br/>", $va_tmp);
						
# --- should the publisher be the text field or the rel entity
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