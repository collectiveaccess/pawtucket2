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
 * @name Occurrences tear sheet
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_occurrences
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

	<div class='tombstone'>
<?php
		if ($vs_pub_type = $t_item->get('ca_occurrences.bib_types', array('convertCodesToDisplayText' => true))) {
			print "<div class='unit'><h6>Type of Material</h6>".$vs_pub_type."</div>";
		}
		if ($vs_title = $t_item->get('ca_occurrences.preferred_labels')) {
			print "<div class='unit'><h6>Title</h6>".$vs_title."</div>";
		}	
		if ($vs_author = $t_item->get('ca_occurrences.author', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Author</h6>".$vs_author."</div>";
		}
		if ($vs_date = $t_item->get('ca_occurrences.occurrence_dates')) {
			print "<div class='unit'><h6>Date</h6>".$vs_date."</div>";
		}
		if ($vs_venue = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('venue')))) {
			print "<div class='unit'><h6>Venue</h6>".$vs_venue."</div>";
		}
		if ($vs_entities = $t_item->get('ca_entities.preferred_labels', array('excludeRelationshipTypes' => array('venue'), 'delimiter' => ', '))) {
			print "<div class='unit'><h6>Related People & Organizations</h6>".$vs_entities."</div>";
		}					
		if ($vs_travel = $t_item->get('ca_occurrences.traveling_yn', array('convertCodesToDisplayText' => true))) {
			print "<div class='unit'><h6>Traveling Exhibition?</h6>".$vs_travel."</div>";
		}						
		if ($vs_edition = $t_item->get('ca_occurrences.edition_bib', array('delimiter' => '<br/>'))) {
			print "<div class='unit'><h6>Edition</h6>".$vs_edition."</div>";
		}
		if ($vs_volume = $t_item->get('ca_occurrences.volume')) {
			print "<div class='unit'><h6>Volume</h6>".$vs_volume."</div>";
		}
		if ($vs_number = $t_item->get('ca_occurrences.number')) {
			print "<div class='unit'><h6>Number</h6>".$vs_number."</div>";
		}
		if ($vs_pages = $t_item->get('ca_occurrences.pages')) {
			print "<div class='unit'><h6>Pages</h6>".$vs_pages."</div>";
		}
		if ($vs_isbn = $t_item->get('ca_occurrences.isbn')) {
			print "<div class='unit'><h6>ISBN</h6>".$vs_isbn."</div>";
		}
		if ($vs_notes = $t_item->get('ca_occurrences.notes')) {
			print "<div class='unit'><h6>Notes</h6>".$vs_notes."</div>";
		}																																								

		$va_object_ids = $t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'sort' => 'ca_entities.preferred_labels.surname;ca_objects.object_id'));
		if ($va_object_ids) {	
			print "<hr/ style='border:0px;border-top:solid 1px #ccc;height:1px;'>";
			print "<table>";
			foreach ($va_object_ids as $va_key => $vn_object_id) {
				$t_object = new ca_objects($vn_object_id);
				print "<tr class='divide'>";
				print "<td class='metaData'>";
				print "<div>".$t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist')))."</div>";
				print "<div>".$t_object->get('ca_objects.preferred_labels')."</div>";
				print "<div>".$t_object->get('ca_objects.creation_date')."</div>";
				print "<div>".$t_object->get('ca_objects.medium')."</div>";
				if ($vs_dimensions = $t_object->getWithTemplate('<ifcount code="ca_objects.dimensions" min="1"><unit><ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height H</ifdef><ifdef code="ca_objects.dimensions.dimensions_width"> x ^ca_objects.dimensions.dimensions_width W</ifdef><ifdef code="ca_objects.dimensions.dimensions_depth"> x ^ca_objects.dimensions.dimensions_depth D</ifdef> <ifdef code="ca_objects.dimensions.height_in|ca_objects.dimensions.width_in|ca_objects.dimensions.depth_in">(</ifdef><ifdef code="ca_objects.dimensions.height_in">^ca_objects.dimensions.height_in H</ifdef><ifdef code="ca_objects.dimensions.width_in"> x ^ca_objects.dimensions.width_in W</ifdef><ifdef code="ca_objects.dimensions.depth_in"> x ^ca_objects.dimensions.depth_in D</ifdef><ifdef code="ca_objects.dimensions.height_in|ca_objects.dimensions.width_in|ca_objects.dimensions.depth_in">)</ifdef><ifdef code="ca_objects.dimensions.dimensions_weight">, ^ca_objects.dimensions.dimensions_weight Weight</ifdef><ifdef code="ca_objects.dimensions.dimensions_notes"><br/>^ca_objects.dimensions.dimensions_notes</ifdef></unit></ifcount>')) {
					print "<div >".$vs_dimensions."</div>";
				} elseif ($vs_dimensions = $t_object->get('ca_objects.dimensions_readOnly')) {
					print "<div >".$vs_dimensions."</div>";
				}
				print "<div>".$t_object->get('ca_objects.edition')."</div>";
				print "<div>".$t_object->get('ca_objects.art_types', array('convertCodesToDisplayText' => true))."</div>";	
				print "<div>".$t_object->get('ca_objects.ca_objects_location')."</div>";			
				print "</td>";
				print "<td class='objImage'>".$t_object->get('ca_object_representations.media.small')."</td>";
				print "</tr>";
			}
			print "</table>";
		}
?>
	</div>
<?php	
	print $this->render("pdfEnd.php");