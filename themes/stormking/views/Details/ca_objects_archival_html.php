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
	$va_access_values =		caGetUserAccessValues($this->request);
	$t_rep = 				$this->getVar("t_representation");
?>
<div class="row">
	<div class='col-xs-12 '>
		<div class="container"><div class="row">
			<div class='col-sm-12'>
				<div class='detailNav'>{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 objectInfo">
<?php
				$vs_record_title = $t_object->get('ca_objects.preferred_labels.name');
				if ($vs_record_title != "Untitled") {
					print "<i>".$vs_record_title."</i>";
				} else {
					print $vs_record_title;
				}
				if ($vs_date = $t_object->get('ca_objects.display_date')) {
					print ", ".$vs_date;
				}				
?>
			</div>		
		</div>
		<hr style='padding-bottom:5px;'>		
		<div class="row">
			<div class="col-sm-6">
				{{{representationViewer}}}	
			</div>					
			<div class="col-sm-6">
				<div class="container"><div class="row"><div class="col-sm-12">		
<?php
				if ($vs_date = $t_object->getWithTemplate('<unit relativeTo="ca_objects.unitdate" delimiter="<br/>"><ifdef code="ca_objects.unitdate.dacs_date_value">^ca_objects.unitdate.dacs_date_value<ifdef code="ca_objects.unitdate.dacs_dates_types"> (^ca_objects.unitdate.dacs_dates_types)</ifdef></ifdef></unit>')) {
					print "<div class='unit'><h6>Date</h6>".$vs_date."</div>";
				}
				if ($vs_extent = $t_object->get('ca_objects.extentDACS')) {
					print "<div class='unit'><h6>Extent</h6>".$vs_extent."</div>";
				}
				if ($va_medium = $t_object->get('ca_objects.medium')) {
					print "<div class='unit'><h6>Medium</h6>".$va_medium."</div>";
				}
				if ($vs_dimensions = $t_object->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_objects.dimensions"><ifdef code="ca_objects.dimensions.display_dimensions">^ca_objects.dimensions.display_dimensions <ifdef code="ca_objects.dimensions.dimensions_type">(^ca_objects.dimensions.dimensions_type)</ifdef></ifdef></unit>')) {
					print "<div class='unit'><h6>Dimensions</h6>".$vs_dimensions."</div>";
				}
				if ($va_creator = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('creator'), 'returnAsArray' => true, 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
					print "<div class='unit'><h6>Creator".((sizeof($va_creator) > 1) ? "s" : "")."</h6>".join("<br/>", $va_creator)."</div>";
				}
				if($t_rep){
					if ($vs_photographer = $t_rep->get('ca_entities.preferred_labels', array('checkAccess' => $va_access_values, 'delimiter' => '<br/>', 'restrictToRelationshipTypes' => array('photographer')))) {
						print "<div class='unit'><h6>Photographer</h6>".$vs_photographer."</div>";
					}
					if ($vs_credit = $t_rep->get('ca_object_representations.caption')) {
						print "<div class='unit'><h6>Image Credit Line</h6>".$vs_credit."</div>";
					}
					if ($va_photo_copyright = $t_rep->get('ca_object_representations.caption_copyright')) {
						print "<div class='unit'><h6>Copyright</h6>".$va_photo_copyright."</div>";   
					}
				}
				if ($vs_conditions_access = $t_object->get('ca_objects.accessrestrict')) {
					print "<div class='unit'><h6>Conditions Governing Access</h6>".$vs_conditions_access."</div>";
				}
				if ($vs_conditions_repro = $t_object->get('ca_objects.reproduction')) {
					print "<div class='unit'><h6>Conditions Governing Reproduction</h6>".$vs_conditions_repro."</div>";
				}																								
?>	
				</div></div></div>
			</div><!-- end col -->	
		</div><!-- end row -->
		<div class="row">					
			<div class="col-sm-6 ">
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><h6>Description</h6>
						<span >^ca_objects.description</span>
					</div>
				</ifdef>}}}
			</div>	
		</div><!-- end row -->		
		
<?php	
			# Related Artworks			
			if ($va_related_artworks = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('loaned_artwork', 'sk_artwork'), 'sort' => 'ca_object_labels.name'))) {
				print '<div class="row objInfo">';
				print "<hr>";

				print '	<div class="col-sm-12"><h6 class="header">Artworks</h6></div>';
				foreach ($va_related_artworks as $va_id => $va_related_artwork_id) {
					$t_rel_obj = new ca_objects($va_related_artwork_id);
					print "<div class='col-sm-3'>";
					print "<div class='relatedArtwork'>";
					print "<div class='relImg'>".caDetailLink($this->request, $t_rel_obj->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values)), '', 'ca_objects', $t_rel_obj->get('ca_objects.object_id'))."</div>";
					print "<p>".$t_rel_obj->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'), 'checkAccess' => $va_access_values, 'delimiter' => ', '))."</p>";
					print "<p>".caDetailLink($this->request, ( $t_rel_obj->get('ca_objects.preferred_labels') == "Untitled" ? $t_rel_obj->get('ca_objects.preferred_labels') : "<i>".$t_rel_obj->get('ca_objects.preferred_labels')."</i>"), '', 'ca_objects', $t_rel_obj->get('ca_objects.object_id'));
					if ($vs_art_date = $t_rel_obj->get('ca_objects.display_date')) {
						print ", ".$vs_art_date;
					}
					print "</p></div>";
					print "</div><!-- end col -->";
				}
				print "</div><!-- end row -->";			
			}
			if ($va_related_library = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('library'), 'sort' => 'ca_object_labels.name'))) {
				print '<div class="row objInfo">';
				print "<hr>";

				print '	<div class="col-sm-12"><h6 class="header">Library</h6></div>';
				foreach ($va_related_library as $va_id => $va_related_library_id) {
					$t_rel_lib = new ca_objects($va_related_library_id);
					print "<div class='col-sm-3'>";
					print "<div class='relatedArtwork'>";
					print "<div class='relImg'>".caDetailLink($this->request, $t_rel_lib->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values)), '', 'ca_objects', $t_rel_lib->get('ca_objects.object_id'))."</div>";
					print "<p>".$t_rel_lib->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'checkAccess' => $va_access_values))."</p>";
					print "<p>".caDetailLink($this->request, $t_rel_lib->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_rel_lib->get('ca_objects.object_id'));
					if ($vs_lib_date = $t_rel_lib->get('ca_objects.display_date')) {
						print ", ".$vs_lib_date;
					}
					print "</p></div>";
					print "</div><!-- end col -->";
				}
				print "</div><!-- end row -->";			
			}		
	
			# Related Exhibitions
			if ($va_related_exhibitions = $t_object->get('ca_occurrences.occurrence_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('exhibition', 'program'), 'sort' => 'ca_occurrences.exhibition_dates', 'sortDirection' => 'desc'))) {
				$va_ex_images = caGetDisplayImagesForAuthorityItems('ca_occurrences', $va_related_exhibitions, array('version' => 'iconlarge', 'relationshipTypes' => 'includes', 'objectTypes' => 'artwork', 'checkAccess' => $va_access_values));
				print "<div class='row relatedExhibitions'><hr>";
				print '<div class="col-sm-12"><h6 class="header">Exhibitions and Programs</h6></div>';
				foreach ($va_related_exhibitions as $va_key => $va_related_exhibition_id) {
					$t_exhibition = new ca_occurrences($va_related_exhibition_id);
					print "<div class='col-sm-12'> <div class='relatedArtwork' style='margin-bottom:20px;'>";
					print "<p>".caDetailLink($this->request, "<i>".$t_exhibition->get('ca_occurrences.preferred_labels')."</i>", '', 'ca_occurrences', $t_exhibition->get('ca_occurrences.occurrence_id'))."</p>";
					print "<p>".$t_exhibition->get('ca_occurrences.exhibition_dates', array('delimiter' => '<br/>'))."</p>";
					print "</div><!-- end relArtwork --></div><!-- end col -->";
				}
				print "</div><!-- end row -->";
			}
	
?>			

							
		</div><!-- end container -->
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