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
 * @marginTop 0.5in
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

	$t_list_item = new ca_list_items($t_item->get("type_id"));
	$vs_typecode = $t_list_item->get("idno");	

	$vs_idno_detail_link = "";
	$vs_label_detail_link = "";
	
	$va_access_values = caGetUserAccessValues($this->request);

	switch($vs_typecode){
		case "product":
		case "component":			
			print $t_item->getWithTemplate('<ifdef code="ca_objects.idno"><div class="unit text-center"><H6 class="text-center">Object ID: ^ca_objects.idno</H6></div></ifdef>');
			
			$va_product_info = array();
			if($vs_type = $t_item->get("ca_objects.type_id", array("convertCodesToDisplayText" => true))){
				$va_product_info[] = $vs_type;
			}
			if($vs_brand = $t_item->get("ca_objects.brand", array("convertCodesToDisplayText" => true, "delimiter" => ", "))){
				$va_product_info[] = $vs_brand;
			}
			if(sizeof($va_product_info)){
				print "<div class='unit'><H6 class='text-center'>";
				print join(" &rsaquo; ", $va_product_info);
				print "</H6></div>";
			}
			
			print $t_item->getWithTemplate('<ifdef code="ca_objects.preferred_labels.name"><H6 class="text-center">^ca_objects.preferred_labels.name</H6></ifdef>');
		break;
		# ------------------------
		case "folder":
		case "item":
		case "av_item":
			
			
			print $t_item->getWithTemplate('<ifdef code="ca_objects.idno"><div class="unit text-center"><H6 class="text-center">Object ID: ^ca_objects.idno</H6></div></ifdef>');
			
			$va_product_info = array();
			if($vs_type = $t_item->get("ca_objects.type_id", array("convertCodesToDisplayText" => true))){
				$va_product_info[] = $vs_type;
			}
			if($vs_brand = $t_item->get("ca_objects.brand", array("convertCodesToDisplayText" => true, "delimiter" => ", "))){
				$va_product_info[] = $vs_brand;
			}
			if(sizeof($va_product_info)){
				print "<div class='unit'><H6 class='text-center'>";
				print join(" &rsaquo; ", $va_product_info);
				print "</H6></div>";
			}
			
			
			print $t_item->getWithTemplate('<ifdef code="ca_objects.preferred_labels.name"><H6 class="text-center">^ca_objects.preferred_labels.name</H6></ifdef>');

		# ------------------------
	}
?>
	<hr class="top"/><div class="representationList">
		
<?php
	$va_reps = $t_item->getRepresentations(array("thumbnail", "small"), array("checkAccess" => $va_access_values));

	foreach($va_reps as $va_rep) {
		if(sizeof($va_reps) > 1){
			# --- more than one rep show thumbnails
			$vn_padding_top = ((120 - $va_rep["info"]["thumbnail"]["HEIGHT"])/2) + 5;
			print "<img src='".$va_rep['paths']['thumbnail']."'>\n";
		}else{
			# --- one rep - show medium rep
			print "<img src='".$va_rep['paths']['small']."'>\n";
		}
	}
	?>
		<div class="clear"></div>
	</div>
	
<?php	

	switch($vs_typecode){
		case "product":
		case "component":
			
			
					print $t_item->getWithTemplate('<if rule="^ca_objects.type_id !~ /Component/">
							<ifdef code="ca_objects.codes.product_code"><div class="unit"><H6>Product Code</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.codes.product_code</unit></div></ifdef>
							<ifnotdef code="ca_objects.codes.product_code"><div class="unit"><H6>Product Code</H6>Not Available</div></ifnotdef>
							<ifdef code="ca_objects.codes.batch_code"><div class="unit"><H6>Batch Code</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.codes.batch_code</unit></div></ifdef>
							<ifdef code="ca_objects.codes.packaging_code"><div class="unit"><H6>Packaging Code</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.codes.product_code</unit></div></ifdef></if>');
						
					if($vs_sub_brand = $t_item->get("ca_objects.sub_brand", array("delimiter" => ", "))){
						if(!preg_match("/[a-z]/", $vs_sub_brand)){
							$vs_sub_brand = ucwords(mb_strtolower($vs_sub_brand));
						}
						$vs_sub_brand = "<span style='text-transform:none;'>".$vs_sub_brand."</span>";
						print "<div class='unit'><H6>Sub-brand</H6>".$vs_sub_brand."</div>";
					}
					if($t_item->get("ca_objects.type_id", array("convertCodesToDisplayText" => true)) != "Component"){
						if($vs_tmp = $t_item->get("ca_objects.shade", array("delimiter" => "<br/>"))){
							print "<div class='unit'><H6>Shade</H6>".ucwords(strtolower($vs_tmp))."</div>";
						}
						if($vs_tmp = $t_item->get("ca_objects.fragrance", array("delimiter" => "<br/>"))){
							print "<div class='unit'><H6>Fragrance</H6>".ucwords(strtolower($vs_tmp))."</div>";
						}
					}
					
					print $t_item->getWithTemplate('<if rule="^ca_objects.type_id !~ /Component/">	
						<ifdef code="ca_objects.size"><div class="unit"><H6>Size/Weight</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.size</unit></div></ifdef>
						<ifdef code="ca_objects.application"><div class="unit"><H6>Application</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.application</unit></div></ifdef>
						
					
					</if>');
					print $t_item->getWithTemplate('<ifdef code="ca_objects.marketing"><div class="unit"><H6>Marketing Category</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.marketing</unit></div></ifdef>');
					
					print $t_item->getWithTemplate('<div class="unit"><H6>Date</H6>^ca_objects.manufacture_date<ifnotdef code="ca_objects.manufacture_date">Undated</ifnotdef></div>');
					print $t_item->getWithTemplate('<ifdef code="ca_objects.launch_display_date|ca_objects.launch_date.launch_date_value"><div class="unit"><H6>Launch Date</H6>^ca_objects.launch_display_date<ifdef code="ca_objects.launch_display_date,ca_objects.launch_date.launch_date_value"> </ifdef>^ca_objects.launch_date.launch_date_value</div></ifdef>');
					print $t_item->getWithTemplate('<ifdef code="ca_objects.season_list"><div class="unit"><H6>Season</H6>^ca_objects.season_list</div></ifdef>');
					print $t_item->getWithTemplate('<if rule="^ca_objects.type_id !~ /Component/">
						<ifdef code="ca_objects.price"><div class="unit"><H6>Sold for</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.price</unit></div></ifdef>
						<ifdef code="ca_objects.packaging"><div class="unit"><H6>Packaging Note</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.packaging</unit></div></ifdef>
					</if>');

					print $t_item->getWithTemplate('<ifcount code="ca_entities" restrictToRelationshipTypes="photographer" min="1"><div class="unit"><H6>Photographer</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="photographer" delimiter=", ">^ca_entities.preferred_labels.displayname</unit></div></ifcount><ifcount code="ca_entities" restrictToRelationshipTypes="designer" min="1"><div class="unit"><H6>Designer</H6><unit relativeTo="ca_entities" restrictToRelationshipTypes="designer" delimiter=", ">^ca_entities.preferred_labels.displayname</unit></div></ifcount>', array("checkAccess" => $va_access_values));

					$vb_notes_output = false;
					$va_notes_filtered = array();
					$va_notes = $t_item->get("ca_objects.object_notes", array("returnWithStructure" => true, "convertCodesToDisplayText" => true));
					if(is_array($va_notes) && sizeof($va_notes)){
						$va_notes = array_pop($va_notes);
						foreach($va_notes as $va_note){
							$va_note["object_note_value"] = trim($va_note["object_note_value"]);
							if($va_note["object_note_value"] && strToLower($va_note["object_note_status"]) == "unrestricted"){
								$va_notes_filtered[] = ucfirst(strtolower($va_note["object_note_value"]));
							}
						}
						if(sizeof($va_notes_filtered)){
							print '<div class="unit"><H6>Notes</H6>';
							print join("<br/>", $va_notes_filtered);
							print '</div>';
							$vb_notes_output = true;
						}
					}
					

					#  parent
				
					if ($vn_parent_object_id = $t_item->get('ca_objects.parent.object_id', array('checkAccess' => $va_access_values))) {
						$t_parent = new ca_objects($vn_parent_object_id);
						# - if this is a product child of another product, label it part
						$vs_part_label = "Component";
						if(strToLower($t_item->get("ca_objects.type_id")) != "component"){
							$vs_part_label = "Part";
						}
						print "<div class='unit'><h6>Is A ".$vs_part_label." Of</h6>";
						$vs_caption = "";
						$vs_caption .= $t_parent->get("ca_objects.preferred_labels").". ";
						if($vs_shade = ucwords(strtolower($t_parent->get("ca_objects.shade")))){
							$vs_caption .= $vs_shade;
						}
						if($vs_fragrance = ucwords(strtolower($t_parent->get("ca_objects.fragrance")))){
							if($vs_shade){
								$vs_caption .= "; ";
							}
							$vs_caption .= $vs_fragrance;
						}
						if($vs_shade || $vs_fragrance){
							$vs_caption .= ". ";
						}
						if($vs_man_date = $t_parent->get("ca_objects.manufacture_date")){
							$vs_caption .= $vs_man_date." ";
						}else{
							$vs_caption .= "Undated ";
						}
						if($vs_product_code = $t_parent->get("ca_objects.codes.product_code")){
							$vs_caption .= "(".$vs_product_code.")";
						}
						
						print $vs_caption;
						print "</div>";
					}
					
					#  child components (can be product or product component)
				
					if ($va_child_object_ids = $t_item->get('ca_objects.children.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
						$qr_children = caMakeSearchResult('ca_objects', $va_child_object_ids);
						
						$va_child_info_fields = array("shade", "fragrance", "codes.product_code");
						if($qr_children->numHits()){
							$vb_heading_output = false;
							while ($qr_children->nextHit()) {
								if(!$vb_heading_output){
									$t_list_item = new ca_list_items($qr_children->get("type_id"));
									$vs_tmp = "";
									switch($t_list_item->get("idno")){
										case "component":
											$vs_tmp = "Component".((sizeof($va_child_object_ids) > 1) ? "s" : "");
										break;
										# -------------------
										case "product":
											$vs_tmp = "Includes";
										break;
										# -------------------
									}
									print "<div class='childObjects unit'><h6>".$vs_tmp."</h6><br/>";
									$vb_heading_output = true;
								}
								$vs_icon = $qr_children->get('ca_object_representations.media.iconlarge', array('checkAccess' => $va_access_values));
								print "<div class='unit'>";
								if($vs_icon){
									print "<div class='icon'>";
									print $vs_icon;
									print "</div>";
								}
								print $qr_children->get('ca_objects.preferred_labels');
								$va_child_info = array();
								foreach($va_child_info_fields as $vs_child_info_field){
									if($vs_tmp = $qr_children->get("ca_objects.".$vs_child_info_field, array("delimiter" => ", ")) ){
										if(in_array($vs_child_info_field, array("fragrance", "shade"))){
											$va_child_info[] = ucwords(strtolower($vs_tmp));
										}else{
											$va_child_info[] = $vs_tmp;
										}
									}
								}
								if(sizeof($va_child_info)){
									print "<br/>".join("; ", $va_child_info);
								}
								print "</div>";
							}
						}
						print "</div>";
					}
				#  related objects
				
				if ($va_related_object_ids = $t_item->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
					$qr_related = caMakeSearchResult('ca_objects', $va_related_object_ids);
					print "<br/><hr></hr><div class='relatedObjects'><h6>Related Item".((sizeof($va_related_object_ids) > 1) ? "s" : "")."</h6><br/>";
					$va_related_info_fields = array("shade", "fragrance", "codes.product_code");
					if($qr_related->numHits()){
						$vn_c = 0;
						while ($qr_related->nextHit()) {
							$vn_c++;
							if($vn_c == 1){
								print "<div class='unit'>";
							}
							print "<div class='relatedIcon'>";
							if($vs_icon = $qr_related->get('ca_object_representations.media.iconlarge', array('checkAccess' => $va_access_values))){
								print $qr_related->get('ca_object_representations.media.iconlarge');
								print "<br/><br/>";
							}
							$vs_caption = "";
							$vs_caption .= $qr_related->get('ca_objects.type_id', array('convertCodesToDisplayText' => true));
							if($vs_tmp = $qr_related->get("ca_objects.archival_formats", array("convertCodesToDisplayText" => true))){
								$vs_caption .= " - ".$vs_tmp;
							}
							$vs_caption .= "<br/>";
							if(($vs_brand = $qr_related->get("ca_objects.brand", array("convertCodesToDisplayText" => true))) || ($vs_subbrand = ucwords(strtolower($qr_related->get("ca_objects.sub_brand", array("convertCodesToDisplayText" => true)))))){
								$vs_caption .= $vs_brand.(($vs_brand && $vs_subbrand) ? ", " : "").$vs_subbrand."<br/>";
							}
							$vs_caption .= $qr_related->get('ca_objects.preferred_labels');
							$vs_tmp = $qr_related->getWithTemplate('<if rule="^ca_objects.type_id =~ /Container/">
																<div class="unit"><ifdef code="ca_objects.display_date"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.display_date</unit></ifdef><ifnotdef code="ca_objects.display_date"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.manufacture_date</unit></ifnotdef><ifnotdef code="ca_objects.display_date,ca_objects.manufacture_date">Undated</ifnotdef></div>
															</if>
															<if rule="^ca_objects.type_id !~ /Container/">
																<div class="unit"><unit relativeTo="ca_objects" delimiter=", "><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.manufacture_date</unit><ifnotdef code="ca_objects.manufacture_date">Undated</ifnotdef></div>
															</if>');
							if($vs_tmp){
								$vs_caption .= " (".$vs_tmp.")";
							}
							print $vs_caption;
							
							
							print "</div>";
							
							
							if($vn_c == 4){
								print "</div><!-- end unit -->";
								$vn_c = 0;
							}
						}
						if($vn_c > 0){
							print "</div><!-- end unit -->";
						}
					}
					print "</div>";
				}


			
			
			
			
			
			
			
		break;
		# ------------------------
		case "folder":
		case "item":
			
			
					print $t_item->getWithTemplate('<if rule="^ca_objects.type_id =~ /Container/">
							<div class="unit"><H6>Date</H6><ifdef code="ca_objects.display_date"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.display_date</unit></ifdef><ifnotdef code="ca_objects.display_date"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.manufacture_date</unit></ifnotdef><ifnotdef code="ca_objects.display_date,ca_objects.manufacture_date">Undated</ifnotdef></div>
						</if>
						<if rule="^ca_objects.type_id !~ /Container/">
							<div class="unit"><H6>Date</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.season_list</unit><ifdef code="ca_objects.manufacture_date,ca_objects.season_list"> </ifdef><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.manufacture_date</unit><ifnotdef code="ca_objects.manufacture_date">Undated</ifnotdef></div>
						</if>');
						
					print $t_item->getWithTemplate('<ifdef code="ca_objects.archival_formats"><div class="unit"><H6>Archvial Format</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.archival_formats</unit></div></ifdef>
													<ifdef code="ca_objects.select_categories"><div class="unit"><H6>Select Categories</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.select_categories</unit></div></ifdef>');

					
					$va_entities = $t_item->get("ca_entities", array('returnWithStructure' => true, 'checkAccess' => $va_access_values));
					if(is_array($va_entities) && sizeof($va_entities)){
						$va_entities_by_type = array();
						$va_entities_sort = array();
						foreach($va_entities as $va_entity){
							$va_entities_sort[$va_entity["relationship_typename"]][] = $va_entity["displayname"];	
						}
						foreach($va_entities_sort as $vs_entity_type => $va_entities_by_type){
							print "<div class='unit'><H6>".ucfirst($vs_entity_type)."</H6>";
							print join(", ", $va_entities_by_type);
							print "</div>";
						}				
					}
					
					$vb_notes_output = false;
					$va_notes_filtered = array();
					$va_notes = $t_item->get("ca_objects.general_notes", array("returnWithStructure" => true, "convertCodesToDisplayText" => true));
					if(is_array($va_notes) && sizeof($va_notes)){
						$va_notes = array_pop($va_notes);
						foreach($va_notes as $va_note){
							$va_note["general_notes_text"] = trim($va_note["general_notes_text"]);
							if($va_note["general_notes_text"] && strToLower($va_note["internal_external"]) == "unrestricted"){
								$va_notes_filtered[] = ucfirst(strtolower($va_note["general_notes_text"]));
							}
						}
						if(sizeof($va_notes_filtered)){
							print '<div class="unit"><H6>Notes</H6>';
							print join("<br/>", $va_notes_filtered);
							print '</div>';
							$vb_notes_output = true;
						}
					}
					

					#  parent - displayed as collection hierarchy and folder if available
					$vs_collection_hier = $t_item->getWithTemplate('<ifcount min="1" code="ca_collections.related"><unit relativeTo="ca_collections.related"><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></unit></ifcount>', array("checkAccess" => $va_access_values));	
					if ($vn_parent_object_id = $t_item->get('ca_objects.parent_id', array("checkAccess" => $va_access_values))) {
						$t_parent = new ca_objects($vn_parent_object_id);
						$vs_caption = "";
						$vs_caption .= $t_parent->get("ca_objects.preferred_labels");
						$vs_caption .= ", ".$t_parent->getWithTemplate('<ifdef code="ca_objects.display_date"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.display_date</unit></ifdef><ifnotdef code="ca_objects.display_date"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.manufacture_date</unit></ifnotdef><ifnotdef code="ca_objects.display_date,ca_objects.manufacture_date">Undated</ifnotdef>');
						$vs_parent_folder = $vs_caption;
					}
					if($vs_collection_hier || $vs_parent_folder){
						print "<div class='unit'><h6>This ".$t_item->get('ca_objects.type_id', array("convertCodesToDisplayText" => true))." Is Part Of</h6>";
						print $vs_collection_hier;
						if($vs_parent_folder && $vs_collection_hier){
							print " > "; 
						}
						print $vs_parent_folder;
						print "</div>";
					}
					if($vs_tmp = $t_item->get("ca_objects.box_folder")){
						print '<div class="unit"><H6>Container</H6>'.$vs_tmp.'</div>';
					}
					$va_bulk_items = $t_item->get("ca_objects.related.object_id", array("checkAccess" => $va_access_values, "restrictToTypes" => array("bulk"), "returnAsArray" => true));
					$vs_bulk_items = "";
					if(is_array($va_bulk_items) && sizeof($va_bulk_items)){
						$vs_bulk_items = sizeof($va_bulk_items)." file".((sizeof($va_bulk_items) > 1) ? "s" : "");
						print '<div class="unit"><H6>Contents</H6>'.$vs_bulk_items.'</div>';
					}
					
					# --- collection parent display
					#  child archival items if this is a folder
				
					if ($va_child_object_ids = $t_item->get('ca_objects.children.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
						$qr_children = caMakeSearchResult('ca_objects', $va_child_object_ids);
						print "<div class='childObjects'><h6>Container Contents</h6>";
						$va_child_info_fields = array("shade", "fragrance", "codes.product_code");
						if($qr_children->numHits()){
							while ($qr_children->nextHit()) {
								$vs_icon = $qr_children->get('ca_object_representations.media.iconlarge', array('checkAccess' => $va_access_values));
								print "<div class='unit'>";
								if($vs_icon){
									print "<div class='icon'>";
									print $vs_icon;
									print "</div>";
								}
								print $qr_children->get('ca_objects.preferred_labels');
								$va_child_info = array();
								foreach($va_child_info_fields as $vs_child_info_field){
									if($vs_tmp = $qr_children->get("ca_objects.".$vs_child_info_field, array("delimiter" => ", ")) ){
										$va_child_info[] = $vs_tmp;
									}
								}
								if(sizeof($va_child_info)){
									print "<br/>".join("; ", $va_child_info);
								}
								print "</div>";
							}
						}
						print "</div>";
					}

				#  related objects
				
				if ($va_related_object_ids = $t_item->get('ca_objects.related.object_id', array('excludeTypes' => array('bulk'), 'returnAsArray' => true, 'checkAccess' => $va_access_values))) {
					$qr_related = caMakeSearchResult('ca_objects', $va_related_object_ids);
					print "<br/><hr></hr><div class='relatedObjects'><h6>Related Item".((sizeof($va_related_object_ids) > 1) ? "s" : "")."</h6><br/>";
					$va_related_info_fields = array("shade", "fragrance", "codes.product_code");
					if($qr_related->numHits()){
						$vn_c = 0;
						while ($qr_related->nextHit()) {
							$vn_c++;
							if($vn_c == 1){
								print "<div class='unit'>";
							}
							print "<div class='relatedIcon'>";
							if($vs_icon = $qr_related->get('ca_object_representations.media.iconlarge', array('checkAccess' => $va_access_values))){
								print $qr_related->get('ca_object_representations.media.iconlarge');
								print "<br/><br/>";
							}
							$vs_caption = "";
							$vs_caption .= $qr_related->get('ca_objects.type_id', array('convertCodesToDisplayText' => true));
							if($vs_tmp = $qr_related->get("ca_objects.archival_formats", array("convertCodesToDisplayText" => true))){
								$vs_caption .= " - ".$vs_tmp;
							}
							$vs_caption .= "<br/>";
							if(($vs_brand = $qr_related->get("ca_objects.brand", array("convertCodesToDisplayText" => true))) || ($vs_subbrand = ucwords(strtolower($qr_related->get("ca_objects.sub_brand", array("convertCodesToDisplayText" => true)))))){
								$vs_caption .= $vs_brand.(($vs_brand && $vs_subbrand) ? ", " : "").$vs_subbrand."<br/>";
							}
							$vs_caption .= $qr_related->get('ca_objects.preferred_labels');
							$vs_tmp = $qr_related->getWithTemplate('<if rule="^ca_objects.type_id =~ /Container/">
																<div class="unit"><ifdef code="ca_objects.display_date"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.display_date</unit></ifdef><ifnotdef code="ca_objects.display_date"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.manufacture_date</unit></ifnotdef><ifnotdef code="ca_objects.display_date,ca_objects.manufacture_date">Undated</ifnotdef></div>
															</if>
															<if rule="^ca_objects.type_id !~ /Container/">
																<div class="unit"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.manufacture_date</unit><ifnotdef code="ca_objects.manufacture_date">Undated</ifnotdef></div>
															</if>');
							if($vs_tmp){
								$vs_caption .= " (".$vs_tmp.")";
							}
							print $vs_caption;
							
							
							print "</div>";
							
							
							if($vn_c == 4){
								print "</div><!-- end unit -->";
								$vn_c = 0;
							}
						}
						if($vn_c > 0){
							print "</div><!-- end unit -->";
						}
					}
					print "</div>";
				}
				
				# --- bulk media
				if(is_array($va_bulk_items) && sizeof($va_bulk_items)){
					$qr_res = caMakeSearchResult('ca_objects', $va_bulk_items);	
					if($qr_res->numHits()){
						while ($qr_res->nextHit()) {
							print "<div style='clear:both; padding-top:15px; margin-bottom:15px; padding-bottom:15px; border-top:1px solid #DEDEDE;'>";
							$vs_image = "";
							if($vs_image = $qr_res->getMediaTag("ca_object_representations.media", 'small', array("checkAccess" => $va_access_values))){
								print "<div style='float:left; width:300px; text-align:center;'>".$vs_image."</div>";	
							}
							
							print "<div style='float:left;'>";
							print "<h6>".$qr_res->get('ca_objects.preferred_labels')."</h6>";
							if(($vs_brand = $qr_res->get("ca_objects.brand", array("convertCodesToDisplayText" => true))) || ($vs_subbrand = $qr_res->get("ca_objects.sub_brand", array("convertCodesToDisplayText" => true)))){
								print "<div class='unitSmall'><b>Brand: </b>".$vs_brand.(($vs_brand && $vs_subbrand) ? ", " : "").$vs_subbrand."</div>";
							}
							if(($vs_tmp = $qr_res->get("ca_objects.season_list", array("convertCodesToDisplayText" => true, "delimiter" => ", ")))){
								print "<div class='unitSmall'><b>Season: </b>".$vs_tmp."</div>";
							}
							if($vs_tmp = $qr_res->get('ca_objects.transferred_date', array("delimeter" => ", "))){
								print "<div class='unitSmall'><b>Publication Date: </b>".$vs_tmp."</div>";
							}
							$va_entities = $qr_res->get("ca_entities", array('returnWithStructure' => true, 'checkAccess' => $va_access_values));
							if(is_array($va_entities) && sizeof($va_entities)){
								$va_entities_by_type = array();
								$va_entities_sort = array();
								foreach($va_entities as $va_entity){
									$va_entities_sort[$va_entity["relationship_typename"]][] = $va_entity["displayname"];	
								}
								foreach($va_entities_sort as $vs_entity_type => $va_entities_by_type){
									print "<div class='unitSmall'><b>".ucfirst($vs_entity_type).": </b>";
									print join(", ", $va_entities_by_type);
									print "</div>";
								}
							}
							if($vs_tmp = $qr_res->get('ca_objects.page_number', array("delimeter" => ", "))){
								print "<div class='unitSmall'><b>Page Number: </b>".$vs_tmp."</div>";
							}
							if($vs_tmp = $qr_res->get('ca_objects.page_count', array("delimeter" => ", "))){
								print "<div class='unitSmall'><b>Page Count: </b>".$vs_tmp."</div>";
							}
							if($vs_tmp = $qr_res->getMediaInfo("ca_object_representations.media", 'ORIGINAL_FILENAME')){
								print "<div class='unitSmall'><b>File Name: </b>".$vs_tmp."</div>";
							}
							print "</div>";
							print "<div style='clear:both;'></div></div>";
						}
					}
				}

			
			
			
		break;
		# ------------------------
		case "av_item":
			
					print $t_item->getWithTemplate('<div class="unit"><H6>Date</H6>^ca_objects.season_list ^ca_objects.manufacture_date<ifnotdef code="ca_objects.manufacture_date">Undated</ifnotdef></div>');
					print $t_item->getWithTemplate('<ifdef code="ca_objects.run_time"><div class="unit"><H6>Run Time</H6>^ca_objects.run_time</div></ifdef>');
					
					$va_entities = $t_item->get("ca_entities", array('returnWithStructure' => true, 'checkAccess' => $va_access_values));
					if(is_array($va_entities) && sizeof($va_entities)){
						$va_entities_by_type = array();
						$va_entities_sort = array();
						foreach($va_entities as $va_entity){
							$va_entities_sort[$va_entity["relationship_typename"]][] = $va_entity["displayname"];	
						}
						foreach($va_entities_sort as $vs_entity_type => $va_entities_by_type){
							print "<div class='unit'><H6>".ucfirst($vs_entity_type)."</H6>";
							print join(", ", $va_entities_by_type);
							print "</div>";
						}					
					}
					$vb_notes_output = false;
					$va_notes_filtered = array();
					$va_notes = $t_item->get("ca_objects.general_notes", array("returnWithStructure" => true, "convertCodesToDisplayText" => true));
					if(is_array($va_notes) && sizeof($va_notes)){
						$va_notes = array_pop($va_notes);
						foreach($va_notes as $va_note){
							$va_note["general_notes_text"] = trim($va_note["general_notes_text"]);
							if($va_note["general_notes_text"] && strToLower($va_note["internal_external"]) == "unrestricted"){
								$va_notes_filtered[] = ucfirst(strtolower($va_note["general_notes_text"]));
							}
						}
						if(sizeof($va_notes_filtered)){
							print '<div class="unit"><H6>Notes</H6>';
							print join("<br/>", $va_notes_filtered);
							print '</div>';
							$vb_notes_output = true;
						}
					}
					

					#  parent - displayed as collection hierarchy and folder if available
					$vs_collection_hier = $t_item->getWithTemplate('<ifcount min="1" code="ca_collections.related"><unit relativeTo="ca_collections.related"><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></unit></ifcount>', array("checkAccess" => $va_access_values));	
					if($vs_collection_hier){
						print "<div class='unit'><h6>This ".$t_item->get('ca_objects.type_id', array("convertCodesToDisplayText" => true))." Is Part Of</h6>";
						print $vs_collection_hier;
						print "</div>";
					}
					

				#  related objects
				
				if ($va_related_object_ids = $t_item->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
					$qr_related = caMakeSearchResult('ca_objects', $va_related_object_ids);
					print "<br/><hr></hr><div class='relatedObjects'><h6>Related Item".((sizeof($va_related_object_ids) > 1) ? "s" : "")."</h6><br/>";
					$va_related_info_fields = array("shade", "fragrance", "codes.product_code");
					if($qr_related->numHits()){
						$vn_c = 0;
						while ($qr_related->nextHit()) {
							$vn_c++;
							if($vn_c == 1){
								print "<div class='unit'>";
							}
							print "<div class='relatedIcon'>";
							if($vs_icon = $qr_related->get('ca_object_representations.media.iconlarge', array('checkAccess' => $va_access_values))){
								print $qr_related->get('ca_object_representations.media.iconlarge');
								print "<br/><br/>";
							}
							$vs_caption = "";
							$vs_caption .= $qr_related->get('ca_objects.type_id', array('convertCodesToDisplayText' => true));
							if($vs_tmp = $qr_related->get("ca_objects.archival_formats", array("convertCodesToDisplayText" => true))){
								$vs_caption .= " - ".$vs_tmp;
							}
							$vs_caption .= "<br/>";
							if(($vs_brand = $qr_related->get("ca_objects.brand", array("convertCodesToDisplayText" => true))) || ($vs_subbrand = ucwords(strtolower($qr_related->get("ca_objects.sub_brand", array("convertCodesToDisplayText" => true)))))){
								$vs_caption .= $vs_brand.(($vs_brand && $vs_subbrand) ? ", " : "").$vs_subbrand."<br/>";
							}
							$vs_caption .= $qr_related->get('ca_objects.preferred_labels');
							$vs_tmp = $qr_related->getWithTemplate('<if rule="^ca_objects.type_id =~ /Container/">
																<div class="unit"><ifdef code="ca_objects.display_date"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.display_date</unit></ifdef><ifnotdef code="ca_objects.display_date"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.manufacture_date</unit></ifnotdef><ifnotdef code="ca_objects.display_date,ca_objects.manufacture_date">Undated</ifnotdef></div>
															</if>
															<if rule="^ca_objects.type_id !~ /Container/">
																<div class="unit"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.manufacture_date</unit><ifnotdef code="ca_objects.manufacture_date">Undated</ifnotdef></div>
															</if>');
							if($vs_tmp){
								$vs_caption .= " (".$vs_tmp.")";
							}
							print $vs_caption;
							
							
							print "</div>";
							
							
							if($vn_c == 4){
								print "</div><!-- end unit -->";
								$vn_c = 0;
							}
						}
						if($vn_c > 0){
							print "</div><!-- end unit -->";
						}
					}
					print "</div>";
				}

			
			
			
		break;
		# ------------------------
	}

	print $this->render("pdfEnd.php");