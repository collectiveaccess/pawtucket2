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
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
				
				{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.idno"><div class='unit'><H6>Object Identifier</H6>^ca_objects.idno</div></ifdef>}}}
				{{{<ifdef code="ca_objects.digitalcontent_identifier"><div class='unit'><H6>Digital media identifier</H6>^ca_objects.digitalcontent_identifier</div></ifdef>}}}
				
				{{{<ifdef code="ca_objects.description">
					<div class='unit'><h6>Description</h6>
						<span class="trimText">^ca_objects.description</span>
					</div>
				</ifdef>}}}
<?php
				if ($va_admin_notes = $t_object->get('ca_objects.internal_notes')) {
					print "<div class='unit'><h6>Notes</h6>".strip_tags($va_admin_notes)."</div>";
				}
?>								
				{{{<ifcount min="1" code="ca_objects.date"><div class='unit'><H6>Date</H6><unit delimiter="<br/>">^ca_objects.date</unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.source"><div class='unit'><H6>Source</H6>^ca_objects.source</div></ifdev>}}}
				{{{<ifcount min="1" code="ca_objects.language"><div class='unit'><H6>Language</H6><unit delimiter="<br/>">^ca_objects.language</unit></div></ifcount>}}}

				
				{{{<ifcount min="1" code="ca_objects.format_notes"><div class='unit'><H6>Format Notes</H6><unit delimiter="<br/>">^ca_objects.format_notes</unit></div></ifcount>}}}
				{{{<ifcount min="1" code="ca_objects.medium"><ifdef code="ca_objects.medium"><div class='unit'><H6>Medium</H6><unit delimiter="<br/>">^ca_objects.medium</unit></div></ifdef></ifcount>}}}
<?php
				if ($va_entity_rels = $t_object->get('ca_objects_x_entities.relation_id', array('returnAsArray' => true))) {
					$va_entities_by_type = array();
					foreach ($va_entity_rels as $va_key => $va_entity_rel) {
						$t_rel = new ca_objects_x_entities($va_entity_rel);
						$vn_type_id = $t_rel->get('ca_relationship_types.preferred_labels');
						$va_entities_by_type[$vn_type_id][] = caNavLink($this->request, $t_rel->get('ca_entities.preferred_labels'), '', '', 'Detail', 'entities/'.$t_rel->get('ca_entities.entity_id'));
					}
					print "<div class='unit'>";
					foreach ($va_entities_by_type as $va_type => $va_entity_id) {
						print "<h6>".$va_type."</h6>";
						foreach ($va_entity_id as $va_key => $va_entity_link) {
							print "<p>".$va_entity_link."</p>";
						} 
					}
					print "</div>";
				}
				if ($va_edition = $t_object->get('ca_objects.edition')) {
					print "<div class='unit'><h6>Edition</h6>".$va_edition."</div>";
				}
				if ($va_call = $t_object->get('ca_objects.call_number')) {
					print "<div class='unit'><h6>Call Number</h6>".$va_call."</div>";
				}
				if ($va_copy = $t_object->get('ca_objects.copy_number')) {
					print "<div class='unit'><h6>Copy Number</h6>".$va_copy."</div>";
				}
				if ($va_place = $t_object->get('ca_objects.placePub')) {
					print "<div class='unit'><h6>Place of Publication</h6>".$va_place."</div>";
				}
				if ($va_number = $t_object->get('ca_objects.numberOfPages')) {
					print "<div class='unit'><h6>Number of Pages</h6>".$va_number."</div>";
				}
				if ($va_series = $t_object->get('ca_objects.series')) {
					print "<div class='unit'><h6>Series</h6>".$va_series."</div>";
				}																					
				if ($va_dimensions = $t_object->get('ca_objects.dimensions', array('returnWithStructure' => true))) {
					$va_dims = array();
					$va_dimsnotes = "";
					foreach ($va_dimensions as $va_key => $va_dimension_t) {
						foreach ($va_dimension_t as $va_key => $va_dimension) {
							if ($va_dimension['dimensions_length']) {
								$va_dims[] = $va_dimension['dimensions_length']." L";
							}
							if ($va_dimension['dimensions_width']) {
								$va_dims[] = $va_dimension['dimensions_width']." W";
							}
							if ($va_dimension['dimensions_height']) {
								$va_dims[] = $va_dimension['dimensions_height']." H";
							}
							if ($va_dimension['dimensions_thickness']) {
								$va_dims[] = $va_dimension['dimensions_thickness']." D";
							}
							if ($va_dimension['dimensions_diameter']) {
								$va_dimsnotes.= "<br/>".$va_dimension['dimensions_diameter']." (diameter)";
							}						
							if ($va_dimension['dimensions_weight']) {
								$va_dimsnotes.= "<br/>".$va_dimension['dimensions_weight']." (weight)";
							}
							if ($va_dimension['measurement_notes']) {
								$va_dimsnotes.= "<br/>".$va_dimension['measurement_notes'];
							}																																		
						}
					}
					print "<div class='unit'><h6>Dimensions</h6>".join(" X ", $va_dims ).$va_dimsnotes."</div>";
				}
?>
				{{{<ifcount min="1" code="ca_objects.conservation_notes"><ifdef code="ca_objects.conservation_notes"><div class='unit'><H6>Conservation Notes</H6><unit delimiter="<br/>">^ca_objects.conservation_notes</unit></div></ifdef></ifcount>}}}

				<hr></hr>
				
				{{{<ifcount min="1" code="ca_objects.rights"><ifdef code="ca_objects.rights"><div class='unit'><H6>Rights Statement</H6><unit delimiter="<br/>">^ca_objects.rights</unit></div></ifdef></ifcount>}}}
				{{{<ifcount min="1" code="ca_objects.rights_notes"><ifdef code="ca_objects.rights_notes"><div class='unit'><H6>Rights Notes</H6><unit delimiter="<br/>">^ca_objects.rights_notes</unit></div></ifdef></ifcount>}}}
				
				{{{<ifcount min="1" code="ca_objects.lcsh_terms"><ifdef code="ca_objects.lcsh_terms"><div class='unit'><H6>Library of Congress Subject Headings</H6><unit delimiter="<br/>">^ca_objects.lcsh_terms</unit></div></ifdef></ifcount>}}}
				
				{{{<ifcount min="1" code="ca_objects.lc_names"><ifdef code="ca_objects.lc_names"><div class='unit'><H6>Library of Congress Name Authority File</H6><unit delimiter="<br/>">^ca_objects.lc_names</unit></div></ifdef></ifcount>}}}
				
	
				
				{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
				{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
				{{{<unit relativeTo="ca_objects_x_places" delimiter="<br/>"><unit relativeTo="ca_places"><l>^ca_places.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
				
				{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
				{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
				{{{<unit relativeTo="ca_objects_x_vocabulary_terms" delimiter="<br/>"><unit relativeTo="ca_list_items">^ca_list_items.preferred_labels.name_plural</unit></unit>}}}
			
				{{{map}}}	 

						
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