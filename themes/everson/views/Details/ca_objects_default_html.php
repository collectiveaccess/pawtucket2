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
<div class="row" >
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-6 ' style='min-height:600px;'>
				{{{representationViewer}}}			

				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<HR>
<?php
				if ($va_idno = $t_object->get('ca_objects.idno')) {
					print "<div class='unit'><h6>Identifier</h6>".$va_idno."</div>";
				}
				if ($va_entities = $t_object->getWithTemplate('<unit delimiter="<br/>" restrictToRelationshipTypes="creator,manufacturer" relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>')) {
					print "<div class='unit'><h6>Artist/Maker/Manufacturer</h6>".$va_entities."</div>";
				}
				if ($vs_date = $t_object->getWithTemplate('<unit delimiter="<br/>"><ifdef code="ca_objects.date.dates_value">^ca_objects.date.dates_value (^ca_objects.date.dc_dates_types)</ifdef></unit>')) {
					print "<div class='unit'><h6>Date</h6>".$vs_date."</div>";
				}
				if ($va_types = $t_object->get('ca_objects.object_type', array('returnAsArray' => true))) {
					print "<div class='unit'><h6>Object Type</h6>";
					foreach ($va_types as $va_key => $va_type ) {
						print "<div>".caNavLink($this->request, caGetListItemByIDForDisplay($va_type), '', '', 'Browse', 'objects/facet/type_facet/id/'.$va_type)."</div>";
					}
					print "</div>";
				}
				if ($va_extent = $t_object->get('ca_objects.extent')) {
					print "<div class='unit'><h6>Extent</h6>".$va_extent."</div>";
				}
				if ($va_dig_extent = $t_object->get('ca_objects.dig_extent')) {
					print "<div class='unit'><h6>Digital Extent</h6>".$va_dig_extent."</div>";
				}				
				if ($va_materials = $t_object->get('ca_objects.materials', array('returnAsArray' => true))) {
					$va_materials = array();
					foreach ($va_materials as $va_key => $va_material ) {
						$va_materials[] = "<div>".caNavLink($this->request, caGetListItemByIDForDisplay($va_material), '', '', 'Browse', 'objects/facet/material_facet/id/'.$va_material)."</div>";
					}
					if (sizeof($va_materials) > 0) {
						print "<div class='unit'><h6>Materials</h6>";
						print join(', ', $va_materials);
						print "</div>";
					}
				}
				if ($va_measurements = $t_object->get('ca_objects.measurements', array('returnWithStructure' => true))) {
					$vs_buf = "";
					foreach ($va_measurements as $va_key => $va_measurement_t) {
						
						foreach ($va_measurement_t as $va_key => $va_measurement) {
							$va_meas = array();
							if ($va_measurement['length']) {
								$va_meas[] = $va_measurement['length']." L";
							}
							if ($va_measurement['height']) {
								$va_meas[] = $va_measurement['height']." H";
							}
							if ($va_measurement['width']) {
								$va_meas[] = $va_measurement['width']." W";
							}
							if ($va_measurement['diameter']) {
								$va_meas[] = $va_measurement['diameter']." diameter";
							}
							if ($va_measurement['depth']) {
								$va_meas[] = $va_measurement['depth']." D";
							}
							if ($va_measurement['circumference']) {
								$va_meas[] = $va_measurement['circumference']." circumference";
							}	
							$vs_buf.= join($va_meas, ' x ');
							if ($va_measurement['dimension_remarks']) {
								$vs_buf.= "<b>Notes: </b>".$va_measurement['dimension_remarks'];
							}																											
						}
					}
					if ($vs_buf != "") {
						print "<div class='unit'><h6>Measurements</h6>";
						print $vs_buf;
						print "</div>";
					}
				}								
				if ($vs_description = $t_object->get('ca_objects.description')) {
					print "<div class='unit'><h6>Description</h6>".$vs_description."</div>";
				}
				if ($vs_credit_line = $t_object->get('ca_objects.credit_line')) {
					print "<div class='unit'><h6>Credit Line</h6>".$vs_credit_line."</div>";
				}
				if ($va_series_name = $t_object->getWithTemplate('<unit delimiter="<br/>"><b>Series Name</b> ^ca_objects.series_name.series_name <br/><b>Series Number</b> ^ca_objects.series_name.series_number</unit>')) {
					print "<div class='unit'><h6>Series</h6>".$va_series_name."</div>";
				}			
				if ($va_subseries_name = $t_object->getWithTemplate('<unit delimiter="<br/>"><b>Subseries Name</b> ^ca_objects.subseries_name.subseries_name <br/><b>Subseries Number</b> ^ca_objects.subseries_name.subseries_number</unit>')) {
					print "<div class='unit'><h6>Subseries</h6>".$va_subseries_name."</div>";
				}
				if ($vs_arrangement = $t_object->get('ca_objects.arrangement')) {
					print "<div class='unit'><h6>Arrangement</h6>".$vs_arrangement."</div>";
				}
				if ($va_terms = $t_object->getWithTemplate('<unit><ifdef code="ca_objects.reproRestrictions.reproduction"><b>Reproduction</b> ^ca_objects.reproRestrictions.reproduction </ifdef><ifdef code="ca_objects.reproRestrictions.access_restrictions"><br/><b>Access</b> ^ca_objects.reproRestrictions.access_restrictions</ifdef></unit>')) {
					print "<div class='unit'><h6>Terms of Use</h6>".$va_terms."</div>";
				}
				if ($va_finding = $t_object->get('ca_objects.finding_aid')) {
					print "<div class='unit'><h6>Finding Aid</h6>".$va_finding."</div>";
				}												
?>												

				
				
				
				<hr></hr>
					<div class="row" style='margin-bottom:20px;'>
						<div class="col-sm-12">		
							{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related entity</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><H6>Related entities</H6></ifcount>}}}
							{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
							
							{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related exhibition</H6></ifcount>}}}
							{{{<ifcount code="ca_occurrences" min="2"><H6>Related exhibitions</H6></ifcount>}}}
							{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l></unit>}}}
							
<?php
							if ($va_collections = $t_object->getWithTemplate('<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels</l> (^relationship_typename)</unit>')) {
								print "<div class='unit'><h6>Related Collections</h6>".$va_collections."</div>";
							}
?>
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name_plural</unit>}}}
							
							{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
							{{{<unit delimiter="<br/>"><l>^ca_objects.LcshNames</l></unit>}}}
						</div><!-- end col -->				
					</div><!-- end row -->
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