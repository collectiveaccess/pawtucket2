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
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
				
			    <?php
			        $va_3dURL = $t_object->get("ca_objects.3D_Scan_URL", array("returnAsArray" => true));
			        if(is_array($va_3dURL) && sizeof($va_3dURL)){
			            foreach($va_3dURL as $vs_3dURL){
			            	print '<div class="sketchfab-embed-wrapper"><iframe width="100%" height="360" src=" '.$vs_3dURL.'/embed" frameborder="0" allow="autoplay; fullscreen; vr" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe> <p style="font-size: 13px; font-weight: normal; margin: 5px; color: #4A4A4A;"> <a href="'.$vs_3dURL.'?utm_medium=embed&utm_source=website&utm_campain=share-popup" target="_blank" style="font-weight: bold; color: #1CAAD9;">'.$t_object->get("ca_objects.preferred_labels").' ('.$t_object->get("ca_objects.idno").')</a> by <a href="https://sketchfab.com/mfmaritimemuseum?utm_medium=embed&utm_source=website&utm_campain=share-popup" target="_blank" style="font-weight: bold; color: #1CAAD9;">The Mel Fisher Maritime Museum</a> on <a href="https://sketchfab.com?utm_medium=embed&utm_source=website&utm_campain=share-popup" target="_blank" style="font-weight: bold; color: #1CAAD9;">Sketchfab</a> </p> </div>';
			        	}
			        }
			    } else {
			    	print "<div class='mediaPlaceholder text-center'><i class='fa fa-photo fa-5x'></i></div>";
			    }
			    ?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<H4>{{{ca_objects.preferred_labels.name}}} <small>{{{<unit>^ca_objects.type_id</unit>}}}</small></H4>
				<HR>
<?php				
				if ($vs_title = $t_object->get('ca_objects.title')){
				    print "<div class='unit'><h6>Title</h6>".$vs_title."</div>";
				}
				
				if ($vs_idno = $t_object->get('ca_objects.idno')) {
					print "<div class='unit'><h6>Accession Number</h6>".$vs_idno."</div>";
				}		
					
				if ($va_chenhall_ids = $t_object->get('ca_objects.chenhall', array('returnAsArray' => true))) {
					print "<div class='unit'><h6>Category</h6>";
					foreach ($va_chenhall_ids as $va_key => $vs_chenhall) {
						print "<div>".caNavLink($this->request, caGetListItemByIDForDisplay($vs_chenhall, true), '', '', 'Browse', 'objects', array('facet' => 'chenhall_facet', 'id' => $vs_chenhall))."</div>";
					}
					print "</div>";
				}
				if ($vs_alt = $t_object->get('ca_objects.alternate_object_name')) {
					print "<div class='unit'><h6>Alternate object names</h6>".$vs_alt."</div>";
				}
				if ($vs_date = $t_object->get('ca_objects.date_created', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Creation Date</h6>".$vs_date."</div>";
				}
				if ($va_material_ids = $t_object->get('ca_objects.material', array('returnAsArray' => true))) {
					print "<div class='unit'><h6>Materials</h6>";
					foreach ($va_material_ids as $va_key => $vs_material) {
						print "<div>".caNavLink($this->request, caGetListItemByIDForDisplay($vs_material, true), '', '', 'Browse', 'objects', array('facet' => 'material_facet', 'id' => $vs_material))."</div>";
					}
					print "</div>";
				}								
				if ($vs_description = $t_object->get('ca_objects.description', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Description</h6>".$vs_description."</div>";
				}
				if ($va_lang_ids = $t_object->get('ca_objects.language', array('returnAsArray' => true))) {
					print "<div class='unit'><h6>Language</h6>";
					foreach ($va_lang_ids as $va_key => $vs_lang) {
						print "<div>".caNavLink($this->request, caGetListItemByIDForDisplay($vs_lang, true), '', '', 'Browse', 'objects', array('facet' => 'lang_facet', 'id' => $vs_lang))."</div>";
					}
					print "</div>";
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
							if ($va_dimension['measurement_notes']) {
								$vs_dims.= "<p>".$va_dimension['measurement_notes']."</p>";
							}
																																			
						}
					}
					if ($vs_dims != "") {
						print "<div class='unit'><h6>Dimensions</h6>".$vs_dims."</div>";
					}
				}
				if ($vs_inscription = $t_object->get('ca_objects.inscription', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Inscription</h6>".$vs_inscription."</div>";
				}
				if ($vs_signature = $t_object->getWithTemplate('<if code="ca_objects.signature"><unit>^ca_objects.signature.signedname, ^ca_objects.signature.signloc</unit></if>')) {
					print "<div class='unit'><h6>Signature</h6>".$vs_signature."</div>";
				}								
				if ($vs_ex_label = $t_object->get('ca_objects.exhibition_label', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Exhibition Label</h6>".$vs_ex_label."</div>";
				}									
				if ($va_entity_rels = $t_object->get('ca_objects_x_entities.relation_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => ['author', 'collector', 'contributor', 'creator', 'related', 'publisher']))) {
					$va_entities_by_type = array();
					foreach ($va_entity_rels as $va_key => $va_entity_rel) {
						$t_rel = new ca_objects_x_entities($va_entity_rel);
						if ($t_rel->get('ca_objects.access') != 0){ continue;}
						$vn_type_id = $t_rel->get('ca_relationship_types.preferred_labels');
						$va_entities_by_type[$vn_type_id][] = caDetailLink($this->request, $t_rel->get('ca_entities.preferred_labels'), '', 'ca_entities', $t_rel->get('ca_entities.entity_id'));
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
				if ($va_list_items = $t_object->get('ca_list_items.item_id', array('returnAsArray' => true))) {
					print "<div class='unit'><h6>Keywords</h6>";
					foreach ($va_list_items as $va_key => $va_list_item_id) {
						print "<div>".caNavLink($this->request, caGetListItemByIDForDisplay($va_list_item_id, true), '', '', 'Browse', 'objects', array('facet' => 'term_facet', 'id' => $va_list_item_id))."</div>";
					}
					print "</div>";
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
