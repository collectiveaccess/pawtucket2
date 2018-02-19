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
				if ($va_artist = $t_object->get('ca_entities.preferred_labels', array('checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('artist')))) {
					print $va_artist."<br/>";
				}
				print "<i>".$t_object->get('ca_objects.preferred_labels')."</i>";
				if ($vs_date = $t_object->get('ca_objects.object_date')) {
					print ", ".$vs_date;
				}
?>
			</div>		
		</div>
		<hr style='padding-bottom:5px;'>		
		<div class="row">	
			<div class='col-sm-12' style="text-align:center;">
				{{{representationViewer}}}	
			</div><!-- end col -->
		</div>	
		<hr>
		<div class="row">					
			<div class="col-sm-6 ">
				<div class="container"><div class="row"><div class="col-sm-12">	
				{{{map}}}
	
				</div></div></div>
			</div>
			<div class="col-sm-6">
				<div class="container"><div class="row"><div class="col-sm-12">		
<?php
				if ($vs_idno = $t_object->get('ca_objects.idno')) {
					print "<div class='unit'><h6>Identifier</h6>".$vs_idno."</div>";
				}
				if ($va_entity_rels = $t_object->get('ca_objects_x_entities.relation_id', array('returnAsArray' => true, 'excludeRelationshipTypes' => array('publisher')))) {
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
				if ($va_date = $t_object->get('ca_objects.object_date')) {
					print "<div class='unit'><h6>Date</h6>".$va_date."</div>";
				}
				if ($va_medium = $t_object->get('ca_objects.medium')) {
					print "<div class='unit'><h6>Medium</h6>".$va_medium."</div>";
				}
				if ($vs_dimensions = $t_object->getWithTemplate('<unit delimiter="<br/>">^ca_objects.dimensions.display_dimensions <ifdef code="ca_objects.dimensions.display_dimensions.dimensions_type">(^ca_objects.dimensions.display_dimensions.dimensions_type)</ifdef></unit>')) {
					print "<div class='unit'><h6>Dimensions</h6>".$vs_dimensions."</div>";
				}				
				if ($va_type = $t_object->get('ca_objects.artwork_type', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Artwork Type</h6>".$va_type."</div>";
				}	
				if ($va_credit = $t_object->get('ca_objects.credit_line')) {
					print "<div class='unit'><h6>Credit Line</h6>".$va_credit."</div>";
				}							
				#if ($va_reps = $t_object->representationsWithMimeType(array('application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',' application/vnd.ms-excel', 'application/pdf'), array('return_with_access' => $va_access_values))) {
				#	foreach ($va_reps as $va_rep_num => $va_rep) {
				#	print "<h6><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay/context/objects', array('id' => $vn_id, 'representation_id' => $va_rep['representation_id'], 'overlay' => 1))."\"); return false;'><span class='glyphicon glyphicon-file'></span>Interview Transcript</a></h6>";
				#	}
				#}
				if ($va_reps_transcript = $t_object->representationsWithMimeType(array('application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',' application/vnd.ms-excel', 'application/pdf'), array('versions' => array('original'), 'return_with_access' => $va_access_values))) {
					foreach ($va_reps_transcript as $va_rep_num => $va_rep) {
						print "<h6><span class='glyphicon glyphicon-file'></span><a href='".$va_rep['urls']['original']."'>Interview Transcript</a></h6>";
					}
				}				
?>	
				</div></div></div>
			</div><!-- end col -->	
		</div><!-- end row -->
			
<?php
			print '<div class="row">';
			
			$vs_related_exhibitions = null;
			if ($va_related_ex_ids = $t_object->get('ca_occurrences.occurrence_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('exhibition', 'public_program')))) {
				print "<div class='col-sm-6'>";
				print '<div class="col-sm-12">	
							<hr>
							<h6 class="header">Related Exhibitions & Programs</h6>
						</div>';
				foreach ($va_related_ex_ids as $va_id => $va_related_ex_id) {
					$t_rel_ex = new ca_occurrences($va_related_ex_id);
					print "<div class='col-sm-12'>";
					print "<div class='detailLine'>";
					print "<p><i>".caDetailLink($this->request, $t_rel_ex->get('ca_occurrences.preferred_labels'), '', 'ca_occurrences', $t_rel_ex->get('ca_occurrences.occurrence_id'))."</i></p>";
					print "<p>".$t_rel_ex->get('ca_occurrences.exhibition_dates', array('delimiter' => '<br/>'))."</p>";
					print "</div>";
					print "</div>";
				}
				print "</div>";
			}			
			$vs_related_art = null;
			if ($va_related_artworks = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('loaned_artwork', 'sk_artwork')))) {
				print "<div class='col-sm-6'>";
				print '<div class="col-sm-12">	
							<hr>
							<h6 class="header">Related Artworks</h6>
						</div>';
				foreach ($va_related_artworks as $va_id => $va_related_artwork_id) {
					$t_rel_obj = new ca_objects($va_related_artwork_id);
					print "<div class='col-sm-6'>";
					print "<div class='relatedArtwork'>";
					print "<div class='relImg'>".caDetailLink($this->request, $t_rel_obj->get('ca_object_representations.media.iconlarge'), '', 'ca_objects', $t_rel_obj->get('ca_objects.object_id'))."</div>";
					print "<p>".caDetailLink($this->request, $t_rel_obj->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_rel_obj->get('ca_objects.object_id'))."</p>";
					print "</div>";
					print "</div>";
				}
				print "</div>";				
			}

			print "</div><!-- end row -->";	
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