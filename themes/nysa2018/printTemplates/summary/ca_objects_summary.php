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
 
 	$t_object = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	

?>
	<div class="title">
		<h1 class="title"><?php print $t_object->getLabelForDisplay();?></h1>
	</div>
	<div class="representationList">
		
<?php
	$va_reps = $t_object->getRepresentations(array("thumbnail", "medium"));

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
	<div class='tombstone'>
<?php
			if ($vs_description = $t_object->get('ca_objects.description')) {
				print "<div class='unit'>".$vs_description."</div>";
			}			
			# --- identifier

			if($vs_idno = $t_object->get('idno')){
				print "<div class='unit'><b>"._t("Identifier")."</b><br/>".$vs_idno."</div><!-- end unit -->";
			}
			if ($vs_altID_array = $t_object->get('ca_objects.alternateID', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
				print "<div class='unit'><b>Alternate Identifier</b><br/>";
				$i = 1;
				foreach ($vs_altID_array as $va_key => $va_altID_t) {
					foreach ($va_altID_t as $va_key => $vs_altID) {
						print "<b class='gray'>".$vs_altID['alternateIDdescription'].":</b> ".$vs_altID['alternateID'];
						if($i < sizeof($va_altID_t)){
							print "<br/>";
						}
						$i++;
					}
				}

				print "</div>";
			}
			if ($va_date_array = $t_object->get('ca_objects.date', array('returnWithStructure' => true))) {
				$t_list = new ca_lists();
				$vn_original_date_id = $t_list->getItemIDFromList("date_types", "dateOriginal");
				foreach ($va_date_array as $va_key => $va_date_array_t) {
					foreach ($va_date_array_t as $va_key => $va_date_array) {
						if ($va_date_array['dc_dates_types'] == $vn_original_date_id) {
							print "<div class='unit'><b>Date</b><br/>".$va_date_array['dates_value']."</div>";
						}
					}
				}
				
			}
			if ($va_contributor = $t_object->get('ca_objects.contributor', array('convertCodesToDisplayText' => true, 'returnWithStructure' => 'true'))) {
				$va_contributor = array_pop($va_contributor);
				$va_tmp = array();
				foreach($va_contributor as $va_contributor_info){
					$vs_tmp = "";
					$vs_tmp = $va_contributor_info["contributor"];
					if($vs_ctype = $va_contributor_info["contributorType"]){
						$vs_tmp .= " (".$vs_ctype.")";
					}
					if(trim($vs_tmp)){
						$va_tmp[] = $vs_tmp;
					}
				}
				if(sizeof($va_tmp)){
					print "<div class='unit'><b>Contributor</b><br/>";
					print join(", ", $va_tmp);
					print "</div>";
				}
			}
			#if ($vs_language = $t_object->get('ca_objects.language', array('convertCodesToDisplayText' => true))) {
			#	print "<div class='unit'><b>Language</b><br/>".$vs_language."</div>";
			#}			
			if ($vs_repository = $t_object->get('ca_objects.repository', array('convertCodesToDisplayText' => true))) {
				print "<div class='unit'><b>Repository</b><br/>".$vs_repository."</div>";
			}
			
			if ($vs_source = $t_object->get('ca_objects.source')) {
				print "<div class='unit'><b>Source</b><br/>".$vs_source."</div>";
			}						
			if ($va_rights_array = $t_object->get('ca_objects.rightsList', array('returnWithStructure' => true))) {
				$t_list = new ca_lists();
				$vn_nysa_id = $t_list->getItemIDFromList("rightsType", "NYSArights");
				$vn_nonnysa_id = $t_list->getItemIDFromList("rightsType", "nonNYSArights");
				foreach ($va_rights_array as $va_key => $va_rights_array_t) {
					foreach ($va_rights_array_t as $va_key => $va_rights_array) {
						if ($va_rights_array['rightsList'] == $vn_nysa_id) {
							print "<div class='unit'><b>Rights</b><br/>This image is provided for education and research purposes. Rights may be reserved. Responsibility for securing permissions to distribute, publish, reproduce or other use rest with the user. For additional information see our <a href='/index.php/About/Copyright'>Copyright and Use Statement</a></div>";
						} else if ($va_rights_array['rightsList'] == $vn_nonnysa_id) {
							print "<div class='unit'><b>Rights</b><br/>This record is not part of the New York State Archives' collection and is presented on our project partner's behalf for educational use only.  Please contact the home repository for information on copyright and reproductions.</div>";
						}
					}
				}
				
			}	
			if ($vs_special = $t_object->get('ca_objects.SpecialProject', array('convertCodesToDisplayText' => true))) {
				print "<div class='unit'><b>Special Project</b><br/>".$vs_special."</div>";
			}					
			# --- parent hierarchy info
			if($t_object->get('parent_id')){
				print "<div class='unit'><b>"._t("Part Of")."</b><br/>".$t_object->get("ca_objects.parent.preferred_labels.name")."</div>";
			}

			# --- Relation
				
			# --- collections
			if ($vs_collections = $t_object->getWithTemplate("<ifcount code='ca_collections' min='1'><unit relativeTo='ca_collections'>^ca_collections.preferred_labels</unit></ifcount>")){	
				print "<div class='unit'><b>"._t("More From This Series")."</b><br/>";
				print $vs_collections;
				print "</div><!-- end unit -->";
			}			
			# --- entities
			if ($vs_entities = $t_object->getWithTemplate("<ifcount code='ca_entities' min='1'><unit relativeTo='ca_entities'>^ca_entities.preferred_labels.displayname (^relationship_typename)</unit></ifcount>")){	
				print "<div class='unit'><b>"._t("Related entities")."</b><br/>";
				print $vs_entities;
				print "</div><!-- end unit -->";
			}
			
			# --- occurrences
			#$va_occ_array = array();
			#if ($va_occurrences = $t_object->get("ca_occurrences.occurrence_id", array("returnAsArray" => true, 'checkAccess' => $va_access_values))){
			#	foreach ($va_occurrences as $va_key => $va_occurrence_id) {
			#		$t_occ = new ca_occurrences($va_occurrence_id);
			#		$vn_type_id = $t_occ->get('ca_occurrences.type_id');
			#		$va_occ_array[$vn_type_id][$va_occurrence_id] = $t_occ->get('ca_occurrences.preferred_labels');
			#	}
			#	foreach ($va_occ_array as $va_type => $va_occ) {
			#		print "<div class='unit'><b>Related ".caGetListItemByIDForDisplay($va_type, true)."</b><br/>";
			#		foreach ($va_occ as $va_key => $va_occ_link) {
			#			print "<div>".$va_occ_link."</div>";
			#		}
			#		print "</div>";
			#	}
			#}
			
			# --- places
			$vs_places = $t_object->getWithTemplate("<unit relativeTo='ca_places' delimiter='<br/>'>^ca_places.preferred_labels.name (^relationship_typename)</unit>");
			
			if($vs_places){
				print "<div class='unit'><b>"._t("Geographic Locations")."</b><br/>";
				print $vs_places;
				print "</div><!-- end unit -->";
			}
			
			# --- lots
			$vs_object_lots = $t_object->getWithTemplate("<ifcount code='ca_lots' min='1'><unit relativeTo='ca_lots'>^ca_lots.preferred_labels.name (^ca_lots.idno_stub)</unit></ifcount>");
			if($vs_object_lots){
				print "<div class='unit'><b>"._t("Related lot")."</b><br/>";
				print $vs_object_lots;
				print "</div><!-- end unit -->";
			}
			
			# --- vocabulary terms
			$vs_terms = $t_object->getWithTemplate("<ifcount code='ca_list_items' min='1'><unit relativeTo='ca_list_items'>^ca_list_items.preferred_labels.name_plural (^relationship_typename)</unit></ifcount>");
			if($vs_terms){
				print "<div class='unit'><b>"._t("Subjects")."</b><br/>";
				print $vs_terms;
				print "</div><!-- end unit -->";
			}
			
					
			# --- output related object images as links
			if ($va_related_objects = $t_object->get("ca_objects.related.preferred_labels", array('checkAccess' => $va_access_values, 'delimiter' => '<br/>'))){
				print "<div class='unit'><b>Related Objects</b><br/>".$va_related_objects."</div>";
			}
?>
	</div>
<?php	
	print $this->render("pdfEnd.php");
