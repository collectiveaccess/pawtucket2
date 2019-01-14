<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-6'>
				{{{representationViewer}}}
				
				
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
<?php				
				if ($va_image_credit = $t_object->get('ca_objects.image_credit_line')) {
					print "<div class='caption unit'>Credit: ".$va_image_credit."</div>";
				}
?>				
				<div class='relatedInfo'>
<?php
				if ($va_exhibitions = $t_object->get('ca_occurrences.occurrence_id', array('restrictToTypes' => array('exhibition'), 'returnAsArray' => true))) {
					print "<h6>Related Exhibitions</h6>";
					foreach ($va_exhibitions as $va_key => $va_exhibition) {
						$t_exhibition = new ca_occurrences($va_exhibition);
						print "<div class='related'>";
						$vs_exibition = null;
						$vs_exibition.= "<p>".$t_exhibition->get('ca_occurrences.preferred_labels')."</p>";
						if ($vs_date = $t_exhibition->get('ca_occurrences.date.display_date')) {
							$vs_exibition.= "<p>".$vs_date."</p>";
						} elseif($vs_date = $t_exhibition->get('ca_occurrences.date.parsed_date')) {
							$vs_exibition.= "<p>".$vs_date."</p>";
						}
						print caNavLink($this->request, $vs_exibition, '', '', 'Detail', 'occurrences/'.$va_exhibition);
						print "</div>";
					}
				}
				if ($va_bibliographies = $t_object->get('ca_occurrences.occurrence_id', array('restrictToTypes' => array('bibliography'), 'returnAsArray' => true))) {
					print "<h6>Related Bibliography</h6>";
					foreach ($va_bibliographies as $va_key => $va_bibliography) {
						$t_bibliography = new ca_occurrences($va_bibliography);
						print "<div class='related'>";
						$vs_bibliography = null;
						$vs_bib_info = array();
						$vs_bibliography.= "<p>".$t_bibliography->get('ca_occurrences.preferred_labels')."</p>";
						if ($vs_author = $t_bibliography->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'delimiter' => ', '))) {
							$vs_bib_info[] = $vs_author;  
						}
						if ($vs_place = $t_bibliography->get('ca_occurrences.bib_place_published')) {
							$vs_bib_info[] = $vs_place;
						}
						if ($vs_date = $t_bibliography->get('ca_occurrences.bib_year_published')) {
							$vs_bib_info[] = $vs_date;
						}
						$vs_bibliography.= join(', ', $vs_bib_info);
						print caNavLink($this->request, $vs_bibliography, '', '', 'Detail', 'occurrences/'.$va_bibliography);
						print "</div>";
					}
				}
				if ($va_collections_list = $t_object->getWithTemplate('<unit delimiter=" > "><ifdef code="ca_collections.hierarchy.preferred_labels"><l>^ca_collections.hierarchy.preferred_labels</l></ifdef></unit>')) {
					print "<div class='unit'><h6>Part of Collection</h6>".$va_collections_list."</div>";
				}	
				if ($vs_physical_location = $t_object->get('ca_objects.physical_location')) {
					print "<div class='unit'><h6>Physical Location</h6>".$vs_physical_location."</div>";
				}
				if ($vs_scan_location = $t_object->get('ca_objects.scan_location')) {
					print "<div class='unit'><h6>Scan Location</h6>".$vs_scan_location."</div>";
				}							
?>
				</div>			

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
<?php
				if ($va_dates = $t_object->get('ca_objects.date.display_date', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Date</h6>".$va_dates."</div>";
				} elseif ($va_dates_and_type = $t_object->getWithTemplate('<unit>^ca_objects.date.parsed_date</unit>')) {
					print "<div class='unit'><h6>Date</h6>".$va_dates_and_type."</div>";
				}				
				if ($va_category = $t_object->get('ca_objects.archive_category', array('convertCodesToDisplayText' => true))){
					print "<div class='unit'><h6>Archive Category</h6>".$va_category."</div>";
				}
				if ($va_doc_type = $t_object->get('ca_objects.document_type', array('convertCodesToDisplayText' => true))){
					print "<div class='unit'><h6>Document Type</h6>".$va_doc_type."</div>";
				}				
				if ($va_alt_title = $t_object->get('ca_objects.nonpreferred_labels', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Alternate Titles</h6>".$va_alt_title."</div>";
				}			 			
				if ($va_technique = $t_object->get('ca_objects.technique', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Technique</h6>".$va_technique."</div>";
				}
				if ($va_dims = $t_object->get('ca_objects.display_dimensions', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Dimensions</h6>".$va_dims."</div>";
				}
				if ($va_insc = $t_object->get('ca_objects.inscriptions', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Inscriptions</h6>".$va_insc."</div>";
				}
				if ($va_num = $t_object->get('ca_objects.num_of_elements', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Number of Elements</h6>".$va_num."</div>";
				}
				if ($va_base = $t_object->get('ca_objects.base', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Base</h6>".$va_base."</div>";
				}
				if ($va_edition = $t_object->get('ca_objects.edition', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Edition</h6>".$va_edition."</div>";
				}	
				if ($va_desc = $t_object->get('ca_objects.description', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Description</h6>".$va_desc."</div>";
				}	
				if ($va_catno = $t_object->get('ca_objects.catalogue_notes', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Catalogue raisonné notes</h6>".$va_catno."</div>";
				}
				if ($va_coll = $t_object->get('ca_objects.current_collection', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Current Collection</h6>".$va_coll."</div>";
				}
				if ($va_prov = $t_object->get('ca_objects.provenance', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Provenance</h6>".$va_prov."</div>";
				}
				if ($va_image_id = $t_object->get('ca_objects.image_id', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Image Identifier</h6>".$va_image_id."</div>";
				}									
				if ($va_published = $t_object->get('ca_objects.published_on_text', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Published On</h6>".$va_published."</div>";
				}
				if ($va_last = $t_object->get('ca_objects.last_updated_on_text', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Last Updated</h6>".$va_last."</div>";
				}

				$va_entities_array = array();
				if ($va_entities = $t_object->get('ca_entities', array('returnWithStructure' => true))) {
					foreach ($va_entities as $va_key => $va_entity) {
						$va_entities_array[$va_entity['relationship_typename']][] = caNavLink($this->request, $va_entity['displayname'], '', '', 'Detail', 'entities/'.$va_entity['entity_id']);
					}
				}
				foreach ($va_entities_array as $va_typename => $va_entity_list) {
					print "<h6>".ucfirst($va_typename)."</h6>";
					foreach ($va_entity_list as $va_key => $va_entity_link) {
						print "<p>".$va_entity_link."</p>";
					}
				}
				if ($va_related_objects = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
					print "<div class='unit relatedObjects'><h6>Related Objects</h6><div class='row'>";
					$vn_i = 0;
					foreach ($va_related_objects as $va_key => $va_related_object) {
						$t_rel = new ca_objects($va_related_object);
						if ($t_rel->get('ca_object_representations.media.iconlarge', array('checkAccess' => $va_access_values))) {
							print "<div class='col-sm-3 relatedObj'><span class='relatedObj' data-toggle='popover' data-trigger='hover' data-content='".$t_rel->get('ca_objects.preferred_labels').", ".$t_rel->get('ca_objects.date.display_date')."'>".caNavLink($this->request, $t_rel->get('ca_object_representations.media.iconlarge'), '', '', 'Detail', 'objects/'.$va_related_object)."</span></div>";
							$vn_i++;
							if ($vn_i == 4) {
								print "<div class='clearfix'></div>";
								$vn_i = 0;
							}								
						}

					}
					print "</div></div>";
				}				
			
																																																	
?>	
				{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Keyword</H6></ifcount>}}}
				{{{<ifcount code="ca_list_items" min="2"><H6>Keywords</H6></ifcount>}}}
				{{{<unit relativeTo="ca_objects_x_vocabulary_terms" delimiter=", "><unit relativeTo="ca_list_items">^ca_list_items.preferred_labels.name_plural</unit></unit>}}}
							
				
				<div class="row">
					<div class="col-sm-12">	
<?php	
						print "<hr></hr>";
						$t_list = new ca_lists();
						$vn_object_typeid = $t_object->get('ca_objects.type_id');
						$va_types_array = array();
						$va_types_array[] = $t_list->getItemIDFromList("object_types", "archival_item");	
						$va_types_array[] = $t_list->getItemIDFromList("object_types", "document");
						$va_types_array[] = $t_list->getItemIDFromList("object_types", "objects");	
						$va_types_array[] = $t_list->getItemIDFromList("object_types", "photographs");	
						$va_types_array[] = $t_list->getItemIDFromList("object_types", "digital");	
						$va_types_array[] = $t_list->getItemIDFromList("object_types", "print");
						$va_types_array[] = $t_list->getItemIDFromList("object_types", "strip");	
						$va_types_array[] = $t_list->getItemIDFromList("object_types", "transparency");	
						$va_types_array[] = $t_list->getItemIDFromList("object_types", "strip_image");		
						if (!in_array($vn_object_typeid, $va_types_array)) {						
							if ($va_status = $t_object->get('ca_objects.status', array('delimiter' => '<br/>', 'convertCodesToDisplayText' => true))) {
								print "<div class='unit'><h6>Status</h6>".$va_status."</div>";
							}	
						}							
						if ($vs_idno = $t_object->get('ca_objects.idno')) {
							print "<div class='unit' style='color:#999;'>Identifier: ".$vs_idno."</div>";
						}	
?>		
					</div><!-- end col -->	
				</div><!-- end row -->								
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>