<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
	$va_access_values = caGetUserAccessValues($this->request);
?>
<div class="row">
	<div class='navLeftRight col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->	
<div class="row">	
	<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
		$va_reps = $t_object->getRepresentations(array("original"), null, array('restrict_to_types' => array('panorama')));
		if ($va_reps) {
			foreach ($va_reps as $va_key => $va_rep) {
				print "<div class='panoramaContainer'><a-scene>
					<a-sky src='".$va_rep['urls']['original']."' rotation='0 -130 0'></a-sky>

					</a-scene></div>";
			}	
		} else {
			print $this->getVar("representationViewer");	
			print "<div id='detailAnnotations'></div>";		
			print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0));
		}
		?>	

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
	
	<div class='col-sm-6 col-md-6 col-lg-6'>
		<H4>{{{ca_objects.preferred_labels.name}}}</H4>
		<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
		<HR>

		{{{<ifdef code="ca_objects.idno"><H6>Accession Number:</H6>^ca_objects.idno<br/></ifdef>}}}
		<?php
		if ($vs_artist = $t_object->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'restrictToRelationshipTypes' => array('artist'), 'delimiter' => ', '))) {
			print "<div class='unit'><h6>Artist</h6>".$vs_artist."</div>";
		}	
		?>
<?php
		if ($vs_date = $t_object->get('ca_objects.date')) {
			print "<div class='unit'><h6>Date</h6>".$vs_date."</div>";
		}		
		if ($vs_use = $t_object->get('ca_objects.historyUse')) {
			print "<div class='unit'><h6>History of Use</h6>".$vs_use."</div>";
		}	
		if ($vs_material = $t_object->get('ca_objects.materials', array('delimiter' => '; '))) {
			print "<div class='unit'><h6>Materials</h6>".$vs_material."</div>";
		}
?>
<!--	if ($va_dims = $t_object->get('ca_objects.dimensions', array('returnWithStructure' => true))) {
			$va_dim_array = array();
			foreach ($va_dims as $va_key => $va_dim_t) {
				foreach ($va_dim_t as $va_key => $va_dim) {
					if ($va_dim['dimensions_length']) {
						$va_dim_array[] = $va_dim['dimensions_length']." L ";
					}	
					if ($va_dim['dimensions_width']) {
						$va_dim_array[] = $va_dim['dimensions_width']." W ";
					}								
					if ($va_dim['dimensions_height']) {
						$va_dim_array[] = $va_dim['dimensions_height']." H ";
					}
				}
			}
			if (sizeof($va_dim_array) > 0) {
				print "<div class='unit'><h6>Measurements</h6>".join(' x ', $va_dim_array)."</div>";
			}
		}
		-->
		{{{<ifdef code="ca_objects.dimensions"><h6>Measurements</h6>}}}
		{{{<unit relativeTo="ca_objects.dimensions" delimiter="<br>">
		  <b>^ca_objects.dimensions.measurement_type%useSingular=1 <br></b> 
		  <ifdef code="ca_objects.dimensions.dimensions_width"><if rule="^ca_objects.dimensions.dimensions_width !~ /^0 cm$/">^ca_objects.dimensions.dimensions_width (width)</if></ifdef>
		  <ifdef code="ca_objects.dimensions.dimensions_length"><if rule="^ca_objects.dimensions.dimensions_length !~ /^0 cm$/">^ca_objects.dimensions.dimensions_length (length)</if></ifdef>
		  <ifdef code="ca_objects.dimensions.dimensions_height"> <if rule="^ca_objects.dimensions.dimensions_height !~ /^0 cm$/">^ca_objects.dimensions.dimensions_height (height)</if></ifdef>
		  <ifdef code="ca_objects.dimensions.dimensions_depth"><if rule="^ca_objects.dimensions.dimensions_depth !~ /^0 cm$/">^ca_objects.dimensions.dimensions_depth (depth)</if></ifdef>
		  <ifdef code="ca_objects.dimensions.dimensions_circ">^ca_objects.dimensions.dimensions_circ (circumference)</ifdef>
		  <ifdef code="ca_objects.dimensions.dimensions_thickness"><if rule="^ca_objects.dimensions.dimensions_thickness !~ /^0 cm$/">^ca_objects.dimensions.dimensions_thickness (thickness)</if></ifdef>
		  <ifdef code="ca_objects.dimensions.dimensions_weight">^ca_objects.dimensions.dimensions_weight (weight)</ifdef>
		 <ifdef code="ca_objects.dimensions.dimensions_diam"><if rule="^ca_objects.dimensions.dimensions_diam !~ /^0 cm$/">^ca_objects.dimensions.dimensions_diam (diameter)</if></ifdef>
		  </unit>}}}
		
<?php
		if ($vs_marks = $t_object->get('ca_objects.marksLabel')) {
			print "<div class='unit'><h6>Marks/Labels</h6>".$vs_marks."</div>";
		}
		if ($vs_cat = $t_object->get('ca_objects.ns_category', array('delimiter' => '<br/>', 'convertCodesToDisplayText' => true))) {
			print "<div class='unit'><h6>Category</h6>".$vs_cat."</div>";
		}									
		if ($vs_credit = $t_object->get('ca_objects.creditLine')) {
			print "<div class='unit'><h6>Credit Line</h6>".$vs_credit."</div>";
		}
		if ($this->request->isLoggedIn()) {
			if ($vs_entities = $t_object->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'checkAccess' => $va_access_values))) {
				print "<div class='unit'><h6>Related Entities</h6>".$vs_entities."</div>";
			}
			if ($vs_objects = $t_object->get('ca_objects.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'checkAccess' => $va_access_values))) {
				print "<div class='unit'><h6>Related Objects</h6>".$vs_objects."</div>";
			}			
		}
?>						
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