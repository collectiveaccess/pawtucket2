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
			<div class="col-sm-12 ">
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
			</div>		
		</div>
		<hr style='padding-bottom:5px;'>		
		<div class="row">	
			<div class='col-sm-12' style="text-align:center;">
<?php
				if ($vn_vimeo_id = $t_object->get('ca_objects.vimeo_id')) {			
					print '<iframe src="https://player.vimeo.com/video/'.$vn_vimeo_id.'?color=ffffff&title=0&byline=0&portrait=0" width="840" height="460" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
				}
?>			
			</div><!-- end col -->
		</div>	
		<hr>
		<div class="row">					
			<div class="col-sm-6 ">
<?php

?>
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><h6>Description</h6>
						<span >^ca_objects.description</span>
					</div>
				</ifdef>}}}
	

			</div>
			<div class="col-sm-5 col-sm-offset-1">		
<?php
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
							print "<div>".$va_entity_link."</div>";
						} 
					}
					print "</div>";
				}
				if ($va_date = $t_object->get('ca_objects.object_date')) {
					print "<div class='unit'><h6>Interview Date</h6>".$va_date."</div>";
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
			</div><!-- end col -->	
		</div><!-- end row -->
			
<?php
				$vs_related_art = null;
				if ($va_related_artworks = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'restrictToTypes' => array('loaned_artwork', 'sk_artwork')))) {
					print '<div class="row">	
							<div class="col-sm-12">	
								<hr>
								<h6>Related Artworks</h6>
							</div>
						  </div>
						  <div class="row" style="margin-bottom:50px;">	';
					foreach ($va_related_artworks as $va_id => $va_related_artwork_id) {
						$t_rel_obj = new ca_objects($va_related_artwork_id);
						print "<div class='col-sm-3'>";
						print "<div class='relImg'>".$t_rel_obj->get('ca_object_representations.media.iconlarge')."</div>";
						print $t_rel_obj->get('ca_objects.preferred_labels');
						print "</div>";
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