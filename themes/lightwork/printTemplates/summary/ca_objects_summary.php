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

?>
	<div class="representationList">
		
<?php
	$va_reps = $t_item->getRepresentations(array("thumbnail", "medium"), [], ['usePath' => true]);

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
		if ($va_entities = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist')))) {
			print "<div class='unit'><h6>Artist</H6>".$va_entities."</div>";
		}
		print "<div class='unit'><h6>Title</h6>".$t_item->get('ca_objects.preferred_labels')."</div>";
		if ($va_date = $t_item->get('ca_objects.date')) {
			print "<div class='unit'><h6>Date</h6>".$va_date."</div>";
		}
		if ($va_dimensions = $t_item->get('ca_objects.dimensions', array('returnWithStructure' => true))) {		
			print "<div class='unit'><h6>Dimensions</h6>";
			foreach ($va_dimensions as $va_key => $va_dimension_t) {
				foreach ($va_dimension_t as $va_key => $va_dimension) {
					$va_dims = array();
					if ($va_dimension['dimensions_height']) {
						$va_dims[] = $va_dimension['dimensions_height']." H";
					}
					if ($va_dimension['dimensions_width']) {
						$va_dims[] = $va_dimension['dimensions_width']." W";
					}
					if ($va_dimension['dimensions_length']) {
						$va_dims[] = $va_dimension['dimensions_length']." L";
					}
					if ($va_dimension['dimensions_thickness']) {
						$va_dims[] = $va_dimension['dimensions_thickness']." thick";
					}	
					print join(' x ', $va_dims);
					if ($va_dimension['dimensions_weight']) {
						$va_dims[] = "<br/>".$va_dimension['dimensions_weight']." weight";
					}
					if ($va_dimension['measurement_notes']) {
						$va_dims[] = "<br/>".$va_dimension['measurement_notes'];
					}																																			
				}						
			}
			print "</div>";
		}
		if ($va_mediums = $t_item->get('ca_objects.medium', array('delimiter' => ', ', 'convertCodesToDisplayText' => true))) {
			print "<div class='unit'><h6>Medium</h6>".$va_mediums."</div>";
		}	
		if ($vs_image_notes = $t_item->get('ca_objects.image_notes')) {
			print "<div class='unit'><h6>Image Notes</h6>".$vs_image_notes."</div>";
		}
		if ($vs_accession = $t_item->get('ca_objects.accession')) {
			print "<div class='unit'><h6>Catalogue Number</h6>".$vs_accession."</div>";
		}
		if ($vs_current_loc = $t_item->get('ca_storage_locations.preferred_labels', array('delimiter' => '<br>'))) {
			print "<div class='unit'><h6>Current Location</h6>".$vs_current_loc."</div>";
		}																
		if ($vs_description = $t_item->get('ca_objects.description')) {
			print "<div class='unit'><h6>Description</h6>".$vs_description."</div>";
		}				
		if ($va_related_pub = $t_item->get('ca_objects.related.preferred_labels', array('restrictToTypes' => array('publication'), 'delimiter' => ', '))) {
			print "<div class='unit'><h6>Related Publications</h6>".$va_related_pub."</div>";
		}

		if ($va_artist = $t_item->get('ca_entities.entity_id', array('restrictToRelationshipTypes' => array('artist')))) {
			$t_entity = new ca_entities($va_artist);
		}
	if (($t_entity) && ($t_item->get('ca_objects.type_id') != $vn_pub_type_id)) {		
?>				
		<hr>
<?php
		print "<h6>".$t_entity->get('ca_entities.preferred_labels')."</h6>";
	
		if ($vs_birthdate = $t_entity->get('ca_entities.birthday')) {
			print "<div class='unit'><h6>Born</h6><span class='data'>".$vs_birthdate."</span></div>";
		}
		if ($vs_deathdate = $t_entity->get('ca_entities.deathdate')) {
			print "<div class='unit'><h6>Died</h6><span class='data'>".$vs_deathdate."</span></div>";
		}			
		if ($vs_birthplace = $t_entity->get('ca_entities.birthplace')) {
			print "<div class='unit'><h6>Birthplace</h6><span class='data'>".$vs_birthplace."</span></div>";
		}

		if ($vs_gender = $t_entity->get('ca_entities.gender', array('convertCodesToDisplayText' => true))) {
			print "<div class='unit'><h6>Gender</h6><span class='data'>".$vs_gender."</span></div>";
		}	
		if ($vs_citizenship = $t_entity->get('ca_entities.citizenship', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))) {
			print "<div class='unit'><h6>Citizenship</h6><span class='data'>".$vs_citizenship."</span></div>";
		}
		if ($vs_cultural = $t_entity->get('ca_entities.cultural', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))) {
			print "<div class='unit'><h6>Cultural Heritage</h6><span class='data'>".$vs_cultural."</span></div>";
		}					

		if ($vs_lw_relationship = $t_entity->get('ca_entities.lw_relationship', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
			print "<div class='unit'><h6>Light Work Relationship</h6><span class='data'>";
			foreach ($vs_lw_relationship as $vs_key => $vs_lw_relationships) {
				foreach ($vs_lw_relationships as $vs_key => $vs_lw_relationship) {
					if ($vs_lw_relationship['Relationship']) {
						print $vs_lw_relationship['Relationship'];
					}
					if ($vs_lw_relationship['lwdate']) {
						print ", ".$vs_lw_relationship['lwdate']."<br/>";
					}
					if ($vs_lw_relationship['relationship_notes']) {
						print $vs_lw_relationship['relationship_notes'];
					}																
				}
			}
			print "</span></div>";
		}	
		if ($vs_entity_pub = $t_entity->get('ca_objects.preferred_labels', array('restrictToTypes' => array('publication'), 'delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Light Work Publications</h6><span class='data'>".$vs_entity_pub."</span></div>";
		}
#					if ($vs_websites = $t_entity->get('ca_entities.website', array('returnAsArray' => true))) {
#						print "<div class='unit'><span class='metaLabel'>Website</span><span class='data'>";
#						foreach ($vs_websites as $vs_key => $vs_website) {
#							print "<a href='".$vs_website."' target='_blank'>".$vs_website."</a><br/>";
#						}				
#						print "</span></div>";
#	
		if ($vs_bio = $t_entity->get('ca_entities.biography', array('delimiter' => '<hr class="dark">'))) {
			print "<div class='unit'><h6>Biography</h6>".$vs_bio."</div>";
		}				
		if ($vs_essay = $t_entity->get('ca_entities.essays', array('delimiter' => '<hr>'))) {
			print "<div class='unit'><h6>Essays</h6>".strip_tags($vs_essay)."</div>";
		}																																					
	}
		
?>
	</div>
<?php	
	print $this->render("pdfEnd.php");