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

	switch($vs_typecode){
		case "product":
		case "component":			
			print $t_item->getWithTemplate('<ifdef code="ca_objects.idno"><div class="unit text-center"><H6 class="text-center">Object ID: ^ca_objects.idno</H6></div></ifdef>');
			print $t_item->getWithTemplate('<ifdef code="ca_objects.type_id|ca_objects.brand|ca_objects.sub_brand"><div class="unit"><H6 class="text-center">^ca_objects.type_id<ifdef code="ca_objects.brand"> &rsaquo; <unit relativeTo="ca_objects" delimiter=", ">^ca_objects.brand</unit></ifdef><ifdef code="ca_objects.sub_brand"> &rsaquo; <unit relativeTo="ca_objects" delimiter=", ">^ca_objects.sub_brand</unit></ifdef></H6></div></ifdef>');
			
			print $t_item->getWithTemplate('<ifdef code="ca_objects.preferred_labels.name"><H6 class="text-center">^ca_objects.preferred_labels.name</H6></ifdef>');
		break;
		# ------------------------
		case "folder":
		case "item":
			
			
			print $t_item->getWithTemplate('<ifdef code="ca_objects.idno"><div class="unit text-center"><H6 class="text-center">Object ID: ^ca_objects.idno</H6></div></ifdef>');
			
			print $t_item->getWithTemplate('<ifdef code="ca_objects.type_id|ca_objects.archival_types|ca_objects.brand|ca_objects.sub_brand"><div class="unit"><H6 class="text-center">^ca_objects.type_id<ifdef code="ca_objects.archival_types"> &rsaquo; ^ca_objects.archival_types%delimiter=,_</ifdef><ifdef code="ca_objects.brand"><br/><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.brand</unit></ifdef><ifdef code="ca_objects.sub_brand"> &rsaquo; <unit relativeTo="ca_objects" delimiter=", ">^ca_objects.sub_brand</unit></ifdef></H6></div></ifdef>');
			
			
			print $t_item->getWithTemplate('<ifdef code="ca_objects.preferred_labels.name"><H6 class="text-center">^ca_objects.preferred_labels.name</H6></ifdef>');

		# ------------------------
	}
?>
	<div class="representationList">
		
<?php
	$va_reps = $t_item->getRepresentations(array("thumbnail", "small"));

	foreach($va_reps as $va_rep) {
		if(sizeof($va_reps) > 1){
			# --- more than one rep show thumbnails
			$vn_padding_top = ((120 - $va_rep["info"]["thumbnail"]["HEIGHT"])/2) + 5;
			print $va_rep['tags']['thumbnail']."\n";
		}else{
			# --- one rep - show medium rep
			print $va_rep['tags']['small']."\n";
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
							<ifdef code="ca_objects.codes.packaging_code"><div class="unit"><H6>Packaging Code</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.codes.product_code</unit></div></ifdef>
						
					
						<ifdef code="ca_objects.shade"><div class="unit"><H6>Shade</H6><unit relativeTo="ca_objects" delimiter="<br/>">^ca_objects.shade</unit></div></ifdef>
						<ifdef code="ca_objects.fragrance"><div class="unit"><H6>Fragrance</H6><unit relativeTo="ca_objects" delimiter="<br/>">^ca_objects.fragrance</unit></div></ifdef>
						
						<ifdef code="ca_objects.size"><div class="unit"><H6>Size/Weight</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.size</unit></div></ifdef>
						<ifdef code="ca_objects.application"><div class="unit"><H6>Application</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.application</unit></div></ifdef>
						
					
					</if>');
					print $t_item->getWithTemplate('<ifdef code="ca_objects.marketing"><div class="unit"><H6>Marketing Category</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.marketing</unit></div></ifdef>');
					
					print $t_item->getWithTemplate('<ifdef code="ca_objects.manufacture_display_date|ca_objects.manufacture_date"><div class="unit"><H6>Date</H6>^ca_objects.manufacture_display_date<ifdef code="ca_objects.manufacture_display_date,ca_objects.manufacture_date"> </ifdef>^ca_objects.manufacture_date</div></ifdef>');
					print $t_item->getWithTemplate('<ifdef code="ca_objects.launch_display_date|ca_objects.launch_date.launch_date_value"><div class="unit"><H6>Launch Date</H6>^ca_objects.launch_display_date<ifdef code="ca_objects.launch_display_date,ca_objects.launch_date.launch_date_value"> </ifdef>^ca_objects.launch_date.launch_date_value</div></ifdef>');
					print $t_item->getWithTemplate('<if rule="^ca_objects.type_id !~ /Component/">
						<ifdef code="ca_objects.price"><div class="unit"><H6>Sold for</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.price</unit></div></ifdef>
						<ifdef code="ca_objects.packaging"><div class="unit"><H6>Packaging Note</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.packaging</unit></div></ifdef>
					</if>');

					$vb_notes_output = false;
					$va_notes_filtered = array();
					$va_notes = $t_item->get("ca_objects.object_notes", array("returnWithStructure" => true, "convertCodesToDisplayText" => true));
					if(is_array($va_notes) && sizeof($va_notes)){
						$va_notes = array_pop($va_notes);
						foreach($va_notes as $va_note){
							$va_note["object_note_value"] = trim($va_note["object_note_value"]);
							if($va_note["object_note_value"] && strToLower($va_note["object_note_status"]) == "unrestricted"){
								$va_notes_filtered[] = $va_note["object_note_value"];
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
						print "<div class='parentObject'><h6>Is A ".$vs_part_label." Of</h6>";
						$vs_caption = "";
						$vs_caption .= $t_parent->get("ca_objects.preferred_labels").". ";
						if($vs_shade = $t_parent->get("ca_objects.shade")){
							$vs_caption .= $vs_shade;
						}
						if($vs_fragrance = $t_parent->get("ca_objects.fragrance")){
							if($vs_shade){
								$vs_caption .= "; ";
							}
							$vs_caption .= $vs_fragrance;
						}
						if($vs_shade || $vs_fragrance){
							$vs_caption .= ". ";
						}
						if($vs_man_date = trim($t_parent->get("ca_objects.manufacture_display_date")." ".$t_parent->get("ca_objects.manufacture_date"))){
							$vs_caption .= $vs_man_date." ";
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
							if($vs_tmp = $qr_related->get("ca_objects.archival_types", array("convertCodesToDisplayText" => true))){
								$vs_caption .= " - ".$vs_tmp;
							}
							$vs_caption .= "<br/>";
							if(($vs_brand = $qr_related->get("ca_objects.brand", array("convertCodesToDisplayText" => true))) || ($vs_subbrand = $qr_related->get("ca_objects.sub_brand", array("convertCodesToDisplayText" => true)))){
								$vs_caption .= $vs_brand.(($vs_brand && $vs_subbrand) ? ", " : "").$vs_subbrand."<br/>";
							}
							$vs_caption .= $qr_related->get('ca_objects.preferred_labels');
							if($vs_tmp = $qr_related->getWithTemplate('<ifdef code="ca_objects.manufacture_display_date|ca_objects.manufacture_date">^ca_objects.manufacture_display_date<ifdef code="ca_objects.manufacture_display_date,ca_objects.manufacture_date"> </ifdef>^ca_objects.manufacture_date</ifdef>')){
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
			
			
					print $t_item->getWithTemplate('<ifdef code="ca_objects.manufacture_date"><div class="unit"><H6>Date</H6><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.manufacture_date</unit></div></ifdef>');

					$vb_notes_output = false;
					$va_notes_filtered = array();
					$va_notes = $t_item->get("ca_objects.general_notes", array("returnWithStructure" => true, "convertCodesToDisplayText" => true));
					if(is_array($va_notes) && sizeof($va_notes)){
						$va_notes = array_pop($va_notes);
						foreach($va_notes as $va_note){
							$va_note["general_notes_text"] = trim($va_note["general_notes_text"]);
							if($va_note["general_notes_text"] && strToLower($va_note["internal_external"]) == "unrestricted"){
								$va_notes_filtered[] = $va_note["general_notes_text"];
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
					$vs_collection_hier = $t_item->getWithTemplate('<ifcount min="1" code="ca_collections.related"><unit relativeTo="ca_collections.related"><unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></unit></ifcount>');	
					if ($vn_parent_object_id = $t_item->get('ca_objects.parent_id')) {
						$t_parent = new ca_objects($vn_parent_object_id);
						$vs_caption = "";
						$vs_caption .= $t_parent->get("ca_objects.preferred_labels");
						if($t_parent->get("ca_objects.manufacture_date")){
							$vs_caption .= ", ".$t_parent->get("ca_objects.manufacture_date");
						}
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
					
					# --- collection parent display
					#  child archival items if this is a folder
				
					if ($va_child_object_ids = $t_item->get('ca_objects.children.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
						$qr_children = caMakeSearchResult('ca_objects', $va_child_object_ids);
						print "<div class='childObjects'><h6>Folder Contents</h6><br/>";
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
							if($vs_tmp = $qr_related->get("ca_objects.archival_types", array("convertCodesToDisplayText" => true))){
								$vs_caption .= " - ".$vs_tmp;
							}
							$vs_caption .= "<br/>";
							if(($vs_brand = $qr_related->get("ca_objects.brand", array("convertCodesToDisplayText" => true))) || ($vs_subbrand = $qr_related->get("ca_objects.sub_brand", array("convertCodesToDisplayText" => true)))){
								$vs_caption .= $vs_brand.(($vs_brand && $vs_subbrand) ? ", " : "").$vs_subbrand."<br/>";
							}
							$vs_caption .= $qr_related->get('ca_objects.preferred_labels');
							if($vs_tmp = $qr_related->getWithTemplate('<ifdef code="ca_objects.manufacture_display_date|ca_objects.manufacture_date">^ca_objects.manufacture_display_date<ifdef code="ca_objects.manufacture_display_date,ca_objects.manufacture_date"> </ifdef>^ca_objects.manufacture_date</ifdef>')){
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