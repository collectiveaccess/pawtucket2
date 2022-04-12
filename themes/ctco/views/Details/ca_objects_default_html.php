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

?>
<div class="container">
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
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					#if ($vn_share_enabled) {
					#	print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					#}
					print '</div><!-- end detailTools -->';
				}				
?>
				<div class="sharethis-inline-share-buttons"></div>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<HR/>
				<h5>From <?php print caDetailLink($this->request, caGetListItemByIDForDisplay($vn_source_id = $t_object->get('source_id')), '', 'ca_entities', ca_entities::getIDForIdno(caGetListItemIdno($vn_source_id))); ?></h5>
				<HR/>
<?php
				if ($va_dates = $t_object->get('ca_objects.date', array('returnWithStructure' => true))) {

					$t_list = new ca_lists();
					$va_date_types = array();
					$va_date_types[] = $t_list->getItemIDFromList("date_types", "published"); //published date
					$va_date_types[] = $t_list->getItemIDFromList("date_types", "created"); //creation date
					$va_date_types[] = $t_list->getItemIDFromList("date_types", "patent_date"); //patented date
					$va_date_types[] = $t_list->getItemIDFromList("date_types", "patent_date"); //patented date

					foreach ($va_dates as $va_key => $va_dates_t) {
						foreach ($va_dates_t as $va_key => $va_date) {
							if ( !in_array($va_date['date_types'], $va_date_types) ) { continue; }
							print "<div class='unit'><h6>".caGetListItemByIDForDisplay($va_date['date_types'], true)."</h6>".$va_date['date_value']."</div>";
						}
					}
				}
				if ($va_creator = $t_object->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'restrictToRelationshipTypes' => array('creator')))) {
					print "<div class='unit'><h6>Created by</H6>".$va_creator."</div>";
				}
				if ($va_owned = $t_object->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'restrictToRelationshipTypes' => array('owner')))) {
					print "<div class='unit'><h6>Owned by</H6>".$va_owned."</div>";
				}	
				if ($va_description = $t_object->get('ca_objects.public_description', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Description</H6>".$va_description."</div>";
				} elseif ($va_exhibition_label = $t_object->get('ca_objects.exhibition_label', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Exhibition Label</H6>".$va_exhibition_label."</div>";
				}
				if (!$va_exhibition_label && !$va_description && ($vs_curatorial_description = $t_object->get('ca_objects.description', array('delimiter' => '<br/>')))) {
					print "<div class='unit'><h6>Curatorial Description</H6>".$vs_curatorial_description."</div>";
				}
				if ($va_aat = $t_object->get('ca_objects.aat', array('returnAsArray' => true))) {
					if ($va_aat[0] != "") {
						print "<div class='unit'><h6>Object Type</H6>";
						foreach ($va_aat as $va_key => $va_aat_term) {
							print caNavLink($this->request, $va_aat_term, '', '', 'Search', 'objects', array('search' => 'ca_objects.aat:'.$va_aat_term));
						}
						print "</div>";
					}
				}
				if ($va_ulan = $t_object->get('ca_objects.ulan', array('returnAsArray' => true))) {
					if ($va_ulan[0] != ""){
						print "<div class='unit'><h6>Artist Name</H6>";
						foreach ($va_ulan as $va_key => $va_ulan_term) {
							$vs_ulan_no_numbers = explode(']', $va_ulan_term);
							print caNavLink($this->request, $va_ulan_term, '', '', 'Search', 'objects', array('search' => 'ca_objects.ulan:"'.$vs_ulan_no_numbers[1].'"'));
						}
						print "</div>";
					}
				}
				if ($va_tgn = $t_object->get('ca_objects.tgn', array('returnAsArray' => true))) {
					if ($va_tgn[0] != ""){
						print "<div class='unit'><h6>Places</H6>";
						foreach ($va_tgn as $va_key => $va_tgn_term) {
							print caNavLink($this->request, $va_tgn_term, '', '', 'Search', 'objects', array('search' => 'ca_objects.tgn:"'.$va_tgn_term.'"'));
						}
						print "</div>";
					}
				}								
				if ($va_lcsh = $t_object->get('ca_objects.lcsh_terms', array('returnAsArray' => true))) {
					if ($va_lcsh[0] != ""){
						print "<div class='unit'><h6>Subjects</H6>";
						foreach ($va_lcsh as $va_key => $va_lcsh_term) {
							$vn_no_numbers = explode('[' , $va_lcsh_term);
							print caNavLink($this->request, $va_lcsh_term, '', '', 'Search', 'objects', array('search' => 'ca_objects.lcsh:"'.$vn_no_numbers[0].'"'));
						}
						print "</div>";
					}
				}
				if ($va_lc_names = $t_object->get('ca_objects.lc_names', array('returnAsArray' => true))) {
					if ($va_lc_names[0] != ""){
						print "<div class='unit'><h6>Names & Organizations</H6>";
						foreach ($va_lc_names as $va_key => $va_lc_names_term) {
							$vn_lc_no_numbers = explode('[' , $va_lc_names_term);
							print caNavLink($this->request, $va_lc_names_term, '', '', 'Search', 'objects', array('search' => 'ca_objects.lc_names:"'.$vn_lc_no_numbers[0].'"'));
						}
						print "</div>";
					}
				}	
				if ($va_graphic = $t_object->get('ca_objects.tgm', array('returnAsArray' => true))) {
					if ($va_graphic[0] != ""){
						print "<div class='unit'><h6>Format</H6>";
						foreach ($va_graphic as $va_key => $va_graphic_term) {
							$vn_graphic_no_numbers = explode('[' , $va_graphic_term);
							print caNavLink($this->request, $va_graphic_term, '', '', 'Search', 'objects', array('search' => 'ca_objects.tgm:"'.$vn_graphic_no_numbers[0].'"'));
						}
						print "</div>";
					}
				}
				#if ($va_tgm = $t_object->get('ca_objects.tgm', array('delimiter' => '<br/>'))) {
				#	print "<div class='unit'><h6>Library of Congress Thesaurus of Graphic Materials</H6>".$va_tgm."</div>"; 
				#}																
				if ($va_entity_rels = $t_object->get('ca_objects_x_entities.relation_id', array('returnAsArray' => true, 'excludeRelationshipTypes' => array('creator', 'owner', 'donor', 'provider')))) {
					$va_entities_by_type = array();
					foreach ($va_entity_rels as $va_key => $va_entity_rel) {
						$t_rel = new ca_objects_x_entities($va_entity_rel);
						$vn_type_id = $t_rel->get('ca_relationship_types.preferred_labels');
						$va_entities_by_type[$vn_type_id][] = $t_rel->get('ca_entities.preferred_labels');
					}
					print "<div class='unit'>";
					foreach ($va_entities_by_type as $va_type => $va_entity_id) {
						print "<h6>".$va_type."</h6>";
						foreach ($va_entity_id as $va_key => $va_entity_link) {
							print "<div>".caDetailLink($this->request, $va_entity_link, '', 'ca_entities', $t_rel->get('ca_entities.entity_id'))."</div>";
						} 
					}
					print "</div>";
				}
				if ($va_dimensions = $t_object->getWithTemplate('<ifcount code="ca_objects.dimensions" min="1"><unit delimiter="<br/>"><ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height H</ifdef><ifdef code="ca_objects.dimensions.dimensions_height,ca_objects.dimensions.dimensions_width"> X </ifdef><ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width W</ifdef><ifdef code="ca_objects.dimensions.dimensions_depth,ca_objects.dimensions.dimensions_width"> X </ifdef><ifdef code="ca_objects.dimensions.dimensions_depth">^ca_objects.dimensions.dimensions_depth D</ifdef><ifdef code="ca_objects.dimensions.dimensions_depth,ca_objects.dimensions.dimensions_length"> X </ifdef><ifdef code="ca_objects.dimensions.dimensions_length">^ca_objects.dimensions.dimensions_length L</ifdef><ifdef code="ca_objects.dimensions.dimensions_weight">, ^ca_objects.dimensions.dimensions_weight Weight</ifdef><ifdef code="ca_objects.dimensions.dimensions_diameter">, ^ca_objects.dimensions.dimensions_diameter Diameter</ifdef><ifdef code="ca_objects.dimensions.dimensions_circumference">, ^ca_objects.dimensions.dimensions_circumference Circumference</ifdef><ifdef code="ca_objects.dimensions.measurement_notes"><br/>Measurement Notes: ^ca_objects.dimensions.measurement_notes</ifdef><ifdef code="ca_objects.dimensions.measurement_type"><br/>Measurement Types: ^ca_objects.dimensions.measurement_type</ifdef></unit></ifcount>')) {
					print "<div class='unit'><h6>Dimensions</H6>".$va_dimensions."</div>"; 
				}				
				if ($va_credit_line = $t_object->get('ca_objects.credit_line', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Credit Line</H6>".$va_credit_line."</div>";
				}				
				if ($va_idno = $t_object->get('ca_objects.idno', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Accession/ID number</H6>".$va_idno."</div>";
				}					
				
								
/*				if ($va_alt_title = $t_object->get('ca_objects.nonpreferred_labels', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Alternate Titles</H6>".$va_alt_title."</div>";
				}
				if ($va_alt_id = $t_object->getWithTemplate('<ifcount min="1" code="ca_objects.other_identifiers"><unit delimiter=", "><ifdef code="ca_objects.other_identifiers.legacy_identifier">^ca_objects.other_identifiers.legacy_identifier (^ca_objects.other_identifiers.other_identifier_type)</ifdef></unit></ifcount>')) { 
					print "<div class='unit'><h6>Other Identifiers</H6>".$va_alt_id."</div>";
				}

				if ($va_accessory = $t_object->get('ca_objects.accessory', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Accessory</H6>".$va_accessory."</div>";
				}
				if ($va_material = $t_object->get('ca_objects.material', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Material</H6>".$va_material."</div>";
				}	
				if ($va_technique = $t_object->get('ca_objects.technique', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Technique</H6>".$va_technique."</div>";
				}
				if ($va_medium = $t_object->get('ca_objects.medium', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Medium</H6>".$va_medium."</div>";
				}
				if ($va_format = $t_object->get('ca_objects.format', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Format</H6>".$va_format."</div>";
				}	
				if ($va_inscription = $t_object->get('ca_objects.inscription', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Inscription</H6>".$va_inscription."</div>";
				}	
				if ($va_signature = $t_object->getWithTemplate('<unit delimiter="<br/>"><ifdef code="ca_objects.signature.signedname"><b>name:</b> ^ca_objects.signature.signedname </ifdef><ifdef code="ca_objects.signature.signloc"><b>location:</b> ^ca_objects.signature.signloc</ifdef></unit>')) {
					print "<div class='unit'><h6>Signature</H6>".$va_signature."</div>";  
				}
				if ($va_geo_notes = $t_object->get('ca_objects.geo_notes', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Geographic Notes</H6>".$va_geo_notes."</div>";
				}
				if ($va_culture = $t_object->get('ca_objects.culture', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Culture</H6>".$va_culture."</div>";
				}	
				if ($va_school = $t_object->get('ca_objects.school', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>School</H6>".$va_school."</div>";
				}
				if ($va_style = $t_object->get('ca_objects.style', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Style</H6>".$va_style."</div>";
				}	
				if ($va_rights = $t_object->getWithTemplate('<unit delimiter="<br/>"><ifdef code="ca_objects.rights.rightsText"><b>Rights:</b> ^ca_objects.rights.rightsText</ifdef><ifdef code="ca_objects.rights.rightsHolder"><br/><b>Rights Holder:</b> ^ca_objects.rights.rightsHolder</ifdef><ifdef code="ca_objects.rights.copyrightStatement"><br/><b>Copyright Statement:</b> ^ca_objects.rights.copyrightStatement</ifdef><ifdef code="ca_objects.rights.rightsNotes"><br/><b>Rights Notes:</b> ^ca_objects.rights.rightsNotes</ifdef></unit>')) {
					print "<div class='unit'><h6>Rights</H6>".$va_rights."</div>";  
				}
				if ($va_publication_notes = $t_object->get('ca_objects.publication_notes', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Publication Notes</H6>".$va_publication_notes."</div>";
				}
*/																																																				
?>
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
</div><!-- end container -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>