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
			
			<?php if($t_object->get("ca_object_representations") || $t_object->get("3D_Scan_URL")){ ?>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-lg-2 col-xs-3", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
				
			    <?php
			        if($vs_3dURL = $t_object->get("3D_Scan_URL")){
			            print '<div class="sketchfab-embed-wrapper"><iframe width="100%" height="360" src=" '.$vs_3dURL.'/embed" frameborder="0" allow="autoplay; fullscreen; vr" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe> <p style="font-size: 13px; font-weight: normal; margin: 5px; color: #4A4A4A;"> <a href="'.$vs_3dURL.'?utm_medium=embed&utm_source=website&utm_campain=share-popup" target="_blank" style="font-weight: bold; color: #1CAAD9;">'.$t_object->get("ca_objects.preferred_labels").' ('.$t_object->get("ca_objects.idno").')</a> by <a href="https://sketchfab.com/mfmaritimemuseum?utm_medium=embed&utm_source=website&utm_campain=share-popup" target="_blank" style="font-weight: bold; color: #1CAAD9;">The Mel Fisher Maritime Museum</a> on <a href="https://sketchfab.com?utm_medium=embed&utm_source=website&utm_campain=share-popup" target="_blank" style="font-weight: bold; color: #1CAAD9;">Sketchfab</a> </p> </div>';
			        }
			    } else {
			    	print "<div class='mediaPlaceholder text-center'><i class='fa fa-photo fa-5x'></i></div>";
			    }
			    ?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
				{{{<ifdef code="ca_objects.preferred_labels.name"><H1>^ca_objects.preferred_labels.name</H1></ifdef>}}}
				<H2>{{{^ca_objects.type_id}}}</H2>
				<HR>
<?php				
				if ($vs_title = $t_object->get('ca_objects.title')){
				    print "<div class='unit'><label>Title</label>".$vs_title."</div>";
				}
				
				if ($vs_idno = $t_object->get('ca_objects.idno')) {
					print "<div class='unit'><label>Accession Number</label>".$vs_idno."</div>";
				}
				
				if ($vs_vessel = $t_object->getWithTemplate('^ca_objects.vessel')) {
					print "<div class='unit'><label>Vessel</label>".$vs_vessel."</div>";
				}		
					
				if ($vs_date = $t_object->get('ca_objects.date_created', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><label>Date</label>".$vs_date."</div>";
				}
				if ($va_material_ids = $t_object->get('ca_objects.material', array('returnAsArray' => true))) {
					print "<div class='unit'><label>Materials</label>";
					foreach ($va_material_ids as $va_key => $vs_material) {
						print "<div>".caNavLink($this->request, caGetListItemByIDForDisplay($vs_material, true), '', '', 'Browse', 'objects', array('facet' => 'material_facet', 'id' => $vs_material))."</div>";
					}
					print "</div>";
				}									
				if ($vs_description = $t_object->get('ca_objects.description', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><label>Description</label>".$vs_description."</div>";
				}
				if ($va_dimensions = $t_object->get('ca_objects.dimensions', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
					$va_dims = array();
					$vs_dims = "";
					foreach ($va_dimensions as $va_key => $va_dimensions_t) {
						foreach ($va_dimensions_t as $va_key => $va_dimension) {
							if ($va_dimension['dimensions_height']) {
								$va_dims[] = $va_dimension['dimensions_height']." H ";
							}
							if ($va_dimension['dimensions_width']) {
								$va_dims[] = $va_dimension['dimensions_width']." W ";
							}							
							if ($va_dimension['dimensions_depth']) {
								$va_dims[] = $va_dimension['dimensions_depth']." D ";
							}							
							if ($va_dimension['dimensions_length']) {
								$va_dims[] = $va_dimension['dimensions_length']." L ";
							}	
							if (sizeof($va_dims) > 0) {						
								$vs_dims.= "<p>".join(' x ', $va_dims);
								if ($va_dimension['measurement_type']) {
									$vs_dims.= ", ".$va_dimension['measurement_type'];
								}
								print "</p>";
							}
							if ($va_dimension['dimensions_weight']) {
								$vs_dims.= "<p>".$va_dimension['dimensions_weight']." Weight </p>";
							}
							if ($va_dimension['dimensions_diameter']) {
								$vs_dims.= "<p>".$va_dimension['dimensions_diameter']." Diameter </p>";
							}
							if ($va_dimension['dimensions_circumference']) {
								$vs_dims.= "<p>".$va_dimension['dimensions_circumference']." Circumference </p>";
							}
							if ($va_dimension['dimensions_thickness']) {
								$vs_dims.= "<p>".$va_dimension['dimensions_thickness']." Thickness </p>";
							}
																																			
						}
					}
					if ($vs_dims != "") {
						print "<div class='unit'><label>Dimensions</label>".$vs_dims."</div>";
					}
				}
								
?>	
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
