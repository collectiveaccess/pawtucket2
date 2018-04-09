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
 * @marginTop 1.25in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.5in 
 * @tables ca_objects
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_object = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");

	print $this->render($this->getVar('base_path')."/pdfStart.php");
	print $this->render($this->getVar('base_path')."/header.php");
	print $this->render($this->getVar('base_path')."/footer.php");	
?>
	<div class="representationList" style="margin-top:100px;">
		
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
		
<?php	
	$t_parent = new ca_objects($t_object->get('ca_objects.parent_id'));
	print "<div class='unit'>Title - ".$t_object->get('ca_objects.preferred_labels')."</div>";
	if ($va_date = $t_object->get('ca_objects.display_date')) {
		print "<div class='unit'>Date - ".$va_date."</div>";
	}
	if ($va_medium = $t_object->get('ca_objects.medium.medium_list', array('returnAsArray' => true, 'excludeIdnos' => array('null')))) {
		$va_media_links = array();
		foreach ($va_medium as $va_key => $va_medium_id) {
			$va_media_links[] = caNavLink($this->request, strtolower(caGetListItemByIDForDisplay($va_medium_id)), '', '', 'Browse', 'artworks/facet/medium_facet/id/'.$va_medium_id);	
		}
		if (sizeof($va_media_links) > 0) {
			print "<div class='unit'>Medium - ".join(', ', $va_media_links)."</div>";
		}
	}
	if ($va_paper = $t_parent->get('ca_objects.paper', array('returnAsArray' => true))) {
		$va_paper_links = array();
		foreach ($va_paper as $va_key => $va_paper_id) {
			$va_paper_links[] = caNavLink($this->request, ucfirst(caGetListItemByIDForDisplay($va_paper_id)), '', '', 'Browse', 'artworks/facet/paper_facet/id/'.$va_paper_id);	
		}
		print "<div class='unit'>Support - ".join(', ', $va_paper_links)."</div>";
	}				
	if ($va_mount = $t_parent->get('ca_objects.mount', array('returnAsArray' => true, 'excludeIdnos' => array('null')))) {
		$va_mount_links = array();
		foreach ($va_mount as $va_key => $va_mount_id) { 
			$va_mount_links[] = caNavLink($this->request, ucfirst(caGetListItemByIDForDisplay($va_mount_id)), '', '', 'Browse', 'artworks/facet/mount_facet/id/'.$va_mount_id);	
		}
		print "<div class='unit'>Mount - ".join(', ', $va_mount_links)."</div>";
	}
	if ($vs_dimensions = $t_object->getWithTemplate('<ifcount code="ca_objects.dimensions.display_dimensions" min="1"><unit delimiter="<br/>"><ifdef code="ca_objects.dimensions.display_dimensions">^ca_objects.dimensions.display_dimensions</ifdef><ifdef code="ca_objects.dimensions.dimensions_notes"> (^ca_objects.dimensions.dimensions_notes)</ifdef></unit></ifcount>')) {
		print "<div class='unit'>Dimensions - ".$vs_dimensions."</div>";
	}
	if ($va_collection = $t_parent->get('ca_objects_x_collections.relation_id', array('returnAsArray' => true))) {
		foreach ($va_collection as $va_key => $va_collection_relation_id) {
			$t_collection_rel = new ca_objects_x_collections($va_collection_relation_id);
		}
		if ($t_collection_rel->get('ca_objects_x_collections.current_collection', array('convertCodesToDisplayText' => true)) == 'yes') {
			print "<div class='unit'>Current Collection - ".$t_collection_rel->getWithTemplate('<unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels</l></unit>')."</div>";
			print "<div class='unit'>Credit - ".$t_collection_rel->get('ca_objects_x_collections.collection_line')."</div>";
		}
	}
	if ($va_institutional_id = $t_object->get('ca_objects.institutional_id')) {
		print "<div class='unit'>Institutional ID - ".$va_institutional_id."</div>";
	}	
#	if ($va_catalog_id = $t_object->get('ca_objects.catalog_number')) {
#		print "<div class='unit'>Catalog ID - ".$va_catalog_id."</div>";
#	}
	if ($va_keywords = $t_object->get('ca_list_items.item_id', array('returnAsArray' => true))) {
		$va_keyword_links = array();
		foreach ($va_keywords as $va_key => $va_keyword_id) {
			$va_keyword_links[] = caNavLink($this->request, caGetListItemByIDForDisplay($va_keyword_id), '', '', 'Browse', 'artworks/facet/term_facet/id/'.$va_keyword_id);	
		}
		print "<div class='unit'>Tags - ".join(', ', $va_keyword_links)."</div>";
	}
	if ($vs_remarks = $t_object->get('ca_objects.remarks')) {
		print "<div class='unit'>";
		print "<h6>Remarks</h6>";
		print "<div >".$vs_remarks."</div>";
		
		if ($va_remarks_images = $t_object->get('ca_objects.remarks_images', array('returnWithStructure' => true, 'version' => 'medium'))) {
			print "<div class='unit'>";
			foreach ($va_remarks_images as $vn_attribute_id => $va_remarks_image_info) {
				foreach ($va_remarks_image_info as $vn_value_id => $va_remarks_image) {
					print "<div class='container remarksImg'>";
					print "<div style='width:300px;'>";
					print $va_remarks_image['remark_media'];
					print "<div class='remarkCaption' style='font-size:12px;'>".$va_remarks_image['remark_caption']."</div>";
					print "</div>";
					print "</div>";
				}
			}
			print "</div>";
		}				
		
		print "</div>";
		$vs_first = false;
	}
	$vs_provenance = "";
	if ($va_provenance = $t_parent->get('ca_collections.collection_id', array('returnAsArray' => true))) {
		foreach ($va_provenance as $va_key => $va_provenance_id) {
			$t_prov = new ca_collections($va_provenance_id);
			if ($t_prov->get('ca_collections.public_private', array('convertCodesToDisplayText' => true)) == 'private') {
				$vs_provenance.= "<div>Private Collection</div>";
			} else { //if ($t_prov->get('access') != 0 )
				$vs_provenance.= "<div>".caNavLink($this->request, $t_prov->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$va_provenance_id)."</div>";
			}
		}
	}
	if ($vs_provenance != "") {
		print "<div class='unit'>";
		print "<h6>Provenance</h6>";
		print "<div id='provenanceDiv'>".$vs_provenance."</div>";
		print "</div><!-- end unit -->";
	}	
	if ($vs_exhibitions = $t_object->getWithTemplate('<unit restrictToTypes="exhibition" delimiter="<br/>" relativeTo="ca_occurrences"><l>^ca_occurrences.preferred_labels</l><ifcount min="1" code="ca_entities.preferred_labels">, <unit relativeTo="ca_entities" restrictToRelationshipTypes="venue" delimiter=", "> ^ca_entities.preferred_labels<ifdef code="ca_entities.address.city">, ^ca_entities.address.city</ifdef><ifdef code="ca_entities.address.state">, ^ca_entities.address.state</ifdef><ifdef code="ca_entities.address.country">, ^ca_entities.address.country</ifdef></unit></ifcount><ifdef code="ca_occurrences.display_date">, ^ca_occurrences.display_date</ifdef><if rule="^ca_occurrences.exhibition_origination =~ /yes/"> (originating institution)</ifdef></unit>')) {
		print "<div class='unit'>";
		print "<h6>Exhibitions</h6>";
		print "<div id='exhibitionDiv'>".$vs_exhibitions."</div>";
		print "</div>";
	}
	if ($vs_reference = $t_object->getWithTemplate('<unit restrictToTypes="reference" delimiter="<br/>" relativeTo="ca_occurrences"><l>^ca_occurrences.preferred_labels<ifdef code="ca_occurrences.nonpreferred_labels">, ^ca_occurrences.nonpreferred_labels</ifdef></l><ifcount code="ca_entities.preferred_labels" min="1">, <unit relativeTo="ca_entities" restrictToRelationshipTypes="author" delimiter=", ">^ca_entities.preferred_labels</unit></ifcount><ifdef code="ca_occurrences.display_date">, ^ca_occurrences.display_date</ifdef></unit>')) {
		print "<div class='unit'>";
		print "<h6>References</h6>";
		print "<div id='referenceDiv'>".$vs_reference."</div>";
		print "</div>";
	}		

	print $this->render($this->getVar('base_path')."/pdfEnd.php");