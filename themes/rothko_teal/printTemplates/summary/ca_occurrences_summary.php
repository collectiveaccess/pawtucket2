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
 *
 * @marginTop 0.5in
 * @marginLeft 0.25in
 * @marginBottom 0.5in
 * @marginRight 0.25in
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");
	$va_access_values = caGetUserAccessValues($this->request);

	print $this->render($this->getVar('base_path')."/pdfStart.php");
	print $this->render($this->getVar('base_path')."/header.php");
	print $this->render($this->getVar('base_path')."/footer.php");	
?>
	<div class="representationList" style="margin-top:50px;">
		
<?php
	$va_reps = $t_item->getRepresentations(array("medium", "small"));

	foreach($va_reps as $va_rep) {
		if(sizeof($va_reps) > 1){
			# --- more than one rep show thumbnails
			$vn_padding_top = ((120 - $va_rep["info"]["small"]["HEIGHT"])/2) + 5;
			print $va_rep['tags']['small']."\n";
		}else{
			# --- one rep - show medium rep
			print $va_rep['tags']['medium']."\n";
		}
	}
?>
	</div>
		
<?php
		print "<div class='unit' style='padding-bottom:0px;'>";	
		print "<i>".$t_item->get('ca_occurrences.preferred_labels')."</i>";
		if ($vs_venue = $t_item->getWithTemplate('<unit restrictToRelationshipTypes="venue">, ^ca_entities.preferred_labels<ifdef code="ca_entities.address.city">, ^ca_entities.address.city</ifdef><ifdef code="ca_entities.address.state">, ^ca_entities.address.state</ifdef><ifdef code="ca_entities.address.country">, ^ca_entities.address.country</ifdef></unit>')) {
			print $vs_venue;
		}
		print "</div>";
		if ($va_date = $t_item->get('ca_occurrences.display_date')) {
			print "<div class='unit' style='padding-bottom:20px;'>".$va_date."</div>";
		}
		if ($vs_remarks = $t_item->get('ca_occurrences.occurrence_notes')) {
			print "<div class='unit'>";
			print "<h6>Remarks</h6>";
			print "<div id='remarksDiv'>".$vs_remarks."</div>";
			print "</div>";
		}				
		if ($vs_exhibitions = $t_item->getWithTemplate('<unit restrictToTypes="exhibition" delimiter="<br/>" relativeTo="ca_occurrences.related"><l>^ca_occurrences.preferred_labels</l><ifcount min="1" code="ca_entities.preferred_labels">, <unit relativeTo="ca_entities" restrictToRelationshipTypes="venue" delimiter=", "> ^ca_entities.preferred_labels<ifdef code="ca_entities.address.city">, ^ca_entities.address.city</ifdef><ifdef code="ca_entities.address.state">, ^ca_entities.address.state</ifdef><ifdef code="ca_entities.address.country">, ^ca_entities.address.country</ifdef></unit></ifcount><ifdef code="ca_occurrences.display_date">, ^ca_occurrences.display_date</ifdef><if rule="^ca_occurrences.exhibition_origination =~ /yes/"> (originating institution)</ifdef></unit>')) {
			print "<div class='unit'>";
			print "<h6>Exhibitions</h6>";
			print "<div id='exhibitionDiv'>".$vs_exhibitions."</div>";
			print "</div>";
		}
		if ($vs_reference = $t_item->getWithTemplate('<unit restrictToTypes="reference" delimiter="<br/>" relativeTo="ca_occurrences.related"><l>^ca_occurrences.preferred_labels<ifdef code="ca_occurrences.nonpreferred_labels">, ^ca_occurrences.nonpreferred_labels</ifdef></l><ifcount code="ca_entities.preferred_labels" min="1">, <unit relativeTo="ca_entities" restrictToRelationshipTypes="author" delimiter=", ">^ca_entities.preferred_labels</unit></ifcount><ifdef code="ca_occurrences.display_date">, ^ca_occurrences.display_date</ifdef></unit>')) {
			print "<div class='unit'>";
			print "<h6>Exhibition Catalog</h6>";
			print "<div id='referenceDiv'>".$vs_reference."</div>";
			print "</div>";
		}	
		if ($va_related_objects = $t_item->get('ca_objects.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
			$vs_count = 0;
			print "<div class='unit' class='page-break-inside: avoid;'><h6>Related Objects</h6>";
			foreach ($va_related_objects as $va_key => $va_related_object_id) {
				$t_obj = new ca_objects($va_related_object_id);
				if ($vs_count == 0) {
					print "<table class='relObjects'><tr>";
				}
				print "<td>".$t_obj->get('ca_object_representations.media.small');
					print "<div>".$t_obj->get('ca_objects.preferred_labels')."</div>";
					if ($va_date = $t_obj->get('ca_objects.display_date')) {
						print "<div>".$va_date."</div>";
					}
					$vs_parent_id = $t_obj->get('ca_objects.parent_id');
					$t_parent = new ca_objects($vs_parent_id);
					if ($va_collection = $t_parent->getWithTemplate('<unit relativeTo="ca_objects_x_collections"><if rule="^ca_objects_x_collections.current_collection =~ /yes/"><unit relativeTo="ca_collections">^ca_collections.preferred_labels</unit></if></unit>')) {
						print "<div>".$va_collection."</div>";
					}
					print "<div>".$t_obj->get('ca_objects.institutional_id')."</div>";
				print "</td>";
				$vs_count++;
				if ($vs_count == 4) {
					print "<tr/></table>";
					$vs_count = 0;
				}
			}
			if (($vs_count < 4) && ($vs_count != 0)) {
				while ($vs_count < 4) {
					print "<td></td>";
					$vs_count++;
				}
				print "</tr></table>";
			}
			print "</div><!-- end unit -->";
		}	
		
		
	print $this->render("pdfEnd.php");
?>	