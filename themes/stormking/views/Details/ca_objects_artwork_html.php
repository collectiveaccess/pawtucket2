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
/*				if ($va_artist = $t_object->get('ca_entities.preferred_labels', array('checkAccess' => $va_access_values, 'returnAsLink' => true, 'restrictToRelationshipTypes' => array('artist')))) {
					print $va_artist."<br/>";
				}
				$vs_record_title = $t_object->get('ca_objects.preferred_labels.name');
				if ($vs_record_title != "Untitled") {
					print "<i>".$vs_record_title."</i>";
				} else {
					print $vs_record_title;
				}
				if ($vs_date = $t_object->get('ca_objects.display_date')) {
					print ", ".$vs_date;
				} */
				$t_list = new ca_lists();
				$vn_view_on_status_id = $t_list->getItemIDFromList("view_status", "on_view");
				$vn_view_off_status_id = $t_list->getItemIDFromList("view_status", "off_view");
				
				$vs_view_status_id = $t_object->get('ca_objects.view_status');
				if ($vs_view_status_id == $vn_view_on_status_id) {
					print "<div style='color:green;'>On view</div>";
				} elseif ($vs_view_status_id  == $vn_view_off_status_id) {
					print "<div style='color:red;'>Off view</div>";
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
			<div class="col-sm-6">
					
<?php
				if ($vs_artist = $t_object->getWithTemplate('<unit relativeTo="ca_entities"><div class="artistName"><l>^ca_entities.preferred_labels</l></div><div>^ca_entities.nationality_text, ^ca_entities.entity_display_date</div></unit>')) { 
					print "<div class='tombstone'>".$vs_artist."</div>";
				}
				print "<div class='tombstone artTitle'><i>".$t_object->get('ca_objects.preferred_labels')."</i>";
				if ($va_date = $t_object->get('ca_objects.display_date')) {
					print ", ".$va_date;
				}
				print "</div>";
				if ($va_medium = $t_object->get('ca_objects.medium')) {
					print "<div class='tombstone'>".$va_medium."</div>";
				}
				if ($vs_dimensions = $t_object->getWithTemplate('<unit delimiter="<br/>" relativeTo="ca_objects.dimensions">^ca_objects.dimensions.display_dimensions <ifdef code="ca_objects.dimensions.dimensions_type">(^ca_objects.dimensions.dimensions_type)</ifdef></unit>')) {
					print "<div class='tombstone'>".$vs_dimensions."</div>";
				}				
#				if ($va_type = $t_object->get('ca_objects.artwork_type', array('convertCodesToDisplayText' => true))) {
#					print "<div class='unit'><h6>Artwork Type</h6>".$va_type."</div>";
#				}	
				if ($va_credit = $t_object->get('ca_objects.credit_line')) {
					print "<div class='tombstone'>".$va_credit."</div>";
				}	
				print "<div class='spacer'></div>";	
				if ($va_photo_credit = $t_object->get('ca_object_representations.caption')) {
					print "<div class='tombstone'>".$va_photo_credit."</div>";
				}	
				if ($va_photo_name = $t_object->getWithTemplate('<unit relativeTo="ca_object_representations"><unit relativeTo="ca_entities" restrictToRelationshipTypes="photographer">^ca_entities.preferred_labels</unit></unit>')) {
					print "<div class='tombstone'>".$va_photo_name."</div>";
				}				
								
?>					
			</div><!-- end col -->
			<div class='col-sm-6'>
<?php
				if ($va_extended = $t_object->getWithTemplate('<unit delimiter="<br/>"><ifdef code="ca_objects.plaque.plaque_text">^ca_objects.plaque.plaque_text</ifdef><ifdef code="ca_objects.plaque.plaque_exh"><h6>Related Exhibition</h6>^ca_objects.plaque.plaque_exh</ifdef></unit>')) {
					print "<div class='unit'>".$va_extended."</div>";
				}	
				if ($vs_map = $this->getVar('map')) {	
					if ($va_extended) {
						print "<hr>";
					}			
					print '<h6 class="header">Location</h6>';
					print $vs_map;
				}
?>				
			</div>
		</div> <!-- end row -->
		<div class="row objInfo">	
			<div class="col-sm-12">			
<?php
				if ($va_related_ex_ids = $t_object->get('ca_occurrences.occurrence_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('exhibition', 'public_program')))) {
					
					print "<hr/>";

					print '<div class="unit"><h6>Related Exhibitions & Programs</h6>';
					foreach ($va_related_ex_ids as $va_id => $va_related_ex_id) {
						$t_rel_ex = new ca_occurrences($va_related_ex_id);
						print "<div class='detailLine'>";
						print "<p><i>".caDetailLink($this->request, $t_rel_ex->get('ca_occurrences.preferred_labels'), '', 'ca_occurrences', $t_rel_ex->get('ca_occurrences.occurrence_id'))."</i></p>";
						print "<p>".$t_rel_ex->get('ca_occurrences.exhibition_dates', array('delimiter' => '<br/>'))."</p>";
						print "</div>";
					}
					print "</div>";
				}
?>
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row objInfo">
			<div class="col-sm-12">	
<?php				
				if ($va_related_artworks = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('loaned_artwork', 'sk_artwork')))) {

					print "<hr>";

					print '	<h6 class="header">Related Artworks</h6>';
					foreach ($va_related_artworks as $va_id => $va_related_artwork_id) {
						$t_rel_obj = new ca_objects($va_related_artwork_id);
						print "<div class='col-sm-6'>";
						print "<div class='relatedArtwork'>";
						print "<div class='relImg'>".caDetailLink($this->request, $t_rel_obj->get('ca_object_representations.media.iconlarge'), '', 'ca_objects', $t_rel_obj->get('ca_objects.object_id'))."</div>";
						print "<p>".caDetailLink($this->request, "<i>".$t_rel_obj->get('ca_objects.preferred_labels')."</i>", '', 'ca_objects', $t_rel_obj->get('ca_objects.object_id'))."</p>";
						print "</div>";
					}			
				}
?>
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row objInfo">
			<div class="col-sm-12">	
<?php							
				if ($va_related_or_history = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToTypes' => array('oral_history')))) {
					print '<div class="unit"><h6>Related Oral Histories</h6>';
					foreach ($va_related_or_history as $va_id => $va_related_or_history_id) {
						$t_rel_or = new ca_objects($va_related_or_history_id);
						print "<div class='detailLine'>";
						print "<p>".caDetailLink($this->request, $t_rel_or->get('ca_objects.preferred_labels'), '', 'ca_objects', $t_rel_or->get('ca_objects.object_id'))."</p>";
						print "</div>";
					}
					print "</div>";
				}				
?>				
			</div><!-- end col -->	
		</div><!-- end row --></div><!-- end container -->
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