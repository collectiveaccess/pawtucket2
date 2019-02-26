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
 * @marginTop 1.25in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.75in
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");
	$va_access_values = caGetUserAccessValues($this->request);
	
	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	

?>
	<div class="representationList">
		
<?php
	$va_reps = $t_item->getRepresentations(array("small", "medium"));

	foreach($va_reps as $va_rep) {
		if(sizeof($va_reps) > 1){
			# --- more than one rep show thumbnails
			$vn_padding_top = ((120 - $va_rep["info"]["thumbnail"]["HEIGHT"])/2) + 5;
			print $va_rep['tags']['small']."\n";
		}else{
			# --- one rep - show medium rep
			print $va_rep['tags']['medium']."\n";
		}
	}
?>
	</div>
	<div class='tombstone'>
<?php	
				if ($vs_idno = $t_item->get('ca_objects.idno')) {
					print "<div class='unit'><h6>Object ID</h6><div class='data'>".$vs_idno."</div></div>";
				}
				if ($vs_call = $t_item->get('ca_objects.call_number')) {
					print "<div class='unit'><h6>Call Number</h6><div class='data'>".$vs_call."</div></div>";
				}
				if ($vs_name = $t_item->get('ca_objects.preferred_labels')) {
					print "<div class='unit'><h6>Object Name</h6><div class='data'>".$vs_name."</div></div>";
				}	
				if ($vs_title = $t_item->get('ca_objects.title')) {
					print "<div class='unit'><h6>Title</h6><div class='data'>".$vs_title."</div></div>";
				}				
				if ($vs_author = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'delimiter' => ', ', 'returnAsLink' => true))) {
					print "<div class='unit'><h6>Author</h6><div class='data'>".$vs_author."</div></div>";
				}
				if ($vs_language = $t_item->get('ca_objects.language', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Language</h6><div class='data'>".$vs_language."</div></div>";
				}					
				if ($va_collection = $t_item->getWithTemplate('<unit delimiter="<br/>"><unit relativeTo="ca_collections">^ca_collections.preferred_labels (^relationship_typename)</unit></unit>')) {
					print "<div class='unit'><h6>Object Collection</h6><div class='data'>".$va_collection."</div></div>";
				}
				if ($vs_date = $t_item->get('ca_objects.date_created', array('delimiter' => '; '))) {
					if ($vs_type_id == $vs_oh_id) {
						print "<div class='unit'><h6>Date of Interview</h6><div class='data'>".$vs_date."</div></div>";
					} else {
						print "<div class='unit'><h6>Date Created</h6><div class='data'>".$vs_date."</div></div>";
					}
				}
				if ($vs_alt_name = $t_item->get('ca_objects.alternate_object_name', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Alternative Name</h6><div class='data'>".$vs_alt_name."</div></div>";
				}	
				if ($vs_credit_line = $t_item->get('ca_objects.credit_line', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Donor</h6><div class='data'>".$vs_credit_line."</div></div>";
				}	
				if ($vs_restrictions = $t_item->get('ca_objects.restrictions', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Restrictions</h6><div class='data'>".$vs_restrictions."</div></div>";
				}					
				if ($vs_format = $t_item->get('ca_objects.format', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Format</h6><div class='data'>".$vs_format."</div></div>";
				}
				if ($vs_event = $t_item->get('ca_objects.event', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Event</h6><div class='data'>".$vs_event."</div></div>";
				}
				if ($va_dims_array = $t_item->get('ca_objects.dimensions', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
					$vs_buf_dims = "";
					$va_dims_info = array();
					foreach ($va_dims_array as $va_key => $va_dims_t) {
						foreach ($va_dims_t as $va_key => $vs_dims) {
							if ($vs_dims['dimensions_height']) {
								$va_dims_info[] = $vs_dims['dimensions_height']." H";
							}
							if ($vs_dims['dimensions_width']) {
								$va_dims_info[] = $vs_dims['dimensions_width']." W";
							}							
							if ($vs_dims['dimensions_depth']) {
								$va_dims_info[] = $vs_dims['dimensions_depth']." D";
							}							
							if ($vs_dims['dimensions_length']) {
								$va_dims_info[] = $vs_dims['dimensions_length']." L";
							}
							if ($vs_dims['dimensions_diameter']) {
								$va_dims_info[] = $vs_dims['dimensions_diameter']." Diameter";
							}
							$vs_buf_dims.= join(" x ", $va_dims_info);							
							if ($vs_dims['measurement_notes']) {
								$vs_buf_dims.= " ".$vs_dims['measurement_notes'];
							}	
							if ($vs_dims['measurement_type']) {
								$vs_buf_dims.= ", ".$vs_dims['measurement_type'];
							}														
						}
					}
					
					if (sizeof($va_dims_info) > 0) {
						print "<div class='unit'><h6>Measurements</h6><div class='data'>".$vs_buf_dims."</div></div>";
					}
				}											
				if ($vs_medium = $t_item->get('ca_objects.medium', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Medium</h6><div class='data'>".$vs_medium."</div></div>";
				}
				if ($vs_material = $t_item->get('ca_objects.material', array('delimiter' => '; '))) {
					print "<div class='unit'><h6>Material</h6><div class='data'>".$vs_material."</div></div>";
				}
				if ($va_entities = $t_item->getWithTemplate('<unit delimiter="<br/>"><unit relativeTo="ca_entities">^ca_entities.preferred_labels.surname, ^ca_entities.preferred_labels.forename (^relationship_typename)</unit></unit>')) {
					print "<div class='unit'><h6>Object Entities</h6><div class='data'>".$va_entities."</div></div>";
				}
				if ($va_interviewer = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_objects_x_entities" restrictToRelationshipTypes="interviewer">^ca_entities.preferred_labels.surname, ^ca_entities.preferred_labels.forename</unit>')) {
					print "<div class='unit'><h6>Interviewer</h6><div class='data'>".$va_interviewer."</div></div>";
				}
				if ($va_interviewee = $t_item->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_objects_x_entities" restrictToRelationshipTypes="interviewee">^ca_entities.preferred_labels.surname, ^ca_entities.preferred_labels.forename</unit>')) {
					print "<div class='unit'><h6>Interviewee</h6><div class='data'>".$va_interviewee."</div></div>";
				}								
				if ($va_collection = $t_item->getWithTemplate('<unit delimiter="<br/>"><unit relativeTo="ca_collections">^ca_collections.preferred_labels (^relationship_typename)</unit></unit>')) {
					print "<div class='unit'><h6>Related Collections</h6><div class='data'>".$va_collection."</div></div>";
				}	
				if ($va_object = $t_item->getWithTemplate('<unit delimiter="<br/>"><unit relativeTo="ca_objects.related">^ca_objects.preferred_labels, ^ca_objects.idno</unit></unit>')) {
					print "<div class='unit'><h6>Related Items</h6><div class='data'>".$va_object."</div></div>";
				}
				#if ($vs_subjects = $t_item->get('ca_list_items.preferred_labels', array('delimiter' => '; '))) {
				#	print "<div class='unit'><h6>Access Points</h6><div class='data'>".$vs_subjects."</div></div>";
				#}
				#if ($vs_lcsh = $t_item->get('ca_objects.lcsh_terms', array('delimiter' => '; '))) {
				#	print "<div class='unit'><h6>Library of Congress Subject Headings</h6><div class='data'>".$vs_lcsh."</div></div>";
				#}
				#if ($vs_getty = $t_item->get('ca_objects.aat', array('delimiter' => '; '))) {
				#	print "<div class='unit'><h6>Getty AAT</h6><div class='data'>".$vs_getty."</div></div>";
				#}
				# --- access points
				$va_access_points = array();
				$va_subjects = $t_object->get('ca_list_items.preferred_labels', array('returnAsArray' => true));
				$va_getty = $t_object->get('ca_objects.aat', array('returnAsArray' => true));
				$va_lcsh = $t_object->get('ca_objects.lcsh_terms', array('returnAsArray' => true));
				$va_access_points = array_merge($va_subjects, $va_getty, $va_lcsh);
				if (sizeof($va_access_points)) {
					$va_access_points_sorted = array();
					foreach($va_access_points as $vs_access_point){
						$vs_access_point = trim(preg_replace("/\[[^\]]*\]/", "", $vs_access_point));
						$va_access_points_sorted[$vs_access_point] = $vs_access_point;
					}
					ksort($va_access_points_sorted);
					print "<div class='unit'><h6>Access Points</h6><div class='data'>";
					print join("<br/>", $va_access_points_sorted);
					print "</div></div>";
				}												
				if ($vs_description = $t_item->get('ca_objects.description', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Object Description</h6><div class=''>".$vs_description."</div></div>";
				}
				if ($vs_prov = $t_item->get('ca_objects.provenance', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Origin</h6><div class=''>".$vs_prov."</div></div>";
				}
?>				
	</div>
<?php	
	print $this->render("pdfEnd.php");