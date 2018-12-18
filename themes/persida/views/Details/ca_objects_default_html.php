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
	
	$t_list = new ca_lists();
	$vs_yes = $t_list->getItemIDFromList("yn", "yes");
	$vs_no = $t_list->getItemIDFromList("yn", "no");
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
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
<?php
				if ($va_related_object = $t_object->get('ca_objects.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Related Artworks</h6>".$va_related_object."</div>";
				}							
?>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
<?php
				if ($t_object->get('ca_objects.is_deaccessioned') == 1){
					print " (Deaccessioned)";
				}
				if ($vs_artist = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'), 'returnAsLink' => true))) {
					print "<div class='unit tombstone'>".$vs_artist."</div>";
				}
				print "<div class='unit tombstone'>".$t_object->get('ca_objects.preferred_labels')."</div>";
				if ($vs_medium = $t_object->get('ca_objects.medium')) {
					print "<div class='unit tombstone'>".$vs_medium."</div>";
				}
				if ($vs_year = $t_object->get('ca_objects.creation_date')) {
					print "<div class='unit tombstone'>".$vs_year."</div>";
				}	
				if ($vs_dimensions = $t_object->getWithTemplate('<ifcount code="ca_objects.dimensions" min="1"><unit><ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height H</ifdef><ifdef code="ca_objects.dimensions.dimensions_width"> x ^ca_objects.dimensions.dimensions_width W</ifdef><ifdef code="ca_objects.dimensions.dimensions_depth"> x ^ca_objects.dimensions.dimensions_depth D</ifdef> <ifdef code="ca_objects.dimensions.height_in|ca_objects.dimensions.width_in|ca_objects.dimensions.depth_in">(</ifdef><ifdef code="ca_objects.dimensions.height_in">^ca_objects.dimensions.height_in H</ifdef><ifdef code="ca_objects.dimensions.width_in"> x ^ca_objects.dimensions.width_in W</ifdef><ifdef code="ca_objects.dimensions.depth_in"> x ^ca_objects.dimensions.depth_in D</ifdef><ifdef code="ca_objects.dimensions.height_in|ca_objects.dimensions.width_in|ca_objects.dimensions.depth_in">)</ifdef><ifdef code="ca_objects.dimensions.dimensions_weight">, ^ca_objects.dimensions.dimensions_weight Weight</ifdef><ifdef code="ca_objects.dimensions.dimensions_notes"><br/>^ca_objects.dimensions.dimensions_notes</ifdef></unit></ifcount>')) {
					print "<div class='unit tombstone'>".$vs_dimensions."</div>";
				} elseif ($vs_dimensions = $t_object->get('ca_objects.dimensions_readOnly')) {
					print "<div class='unit tombstone'>".$vs_dimensions."</div>";
				}
				if ($vs_edition = $t_object->get('ca_objects.edition')) {
					print "<div class='unit'>Edition ".$vs_edition."</div>";
				}
				if ($vs_art = $t_object->get('ca_objects.art_types', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Art Type</h6>".$vs_art."</div>";
				}
				if ($vs_acq = $t_object->get('ca_objects.acquisition_date')) {
					print "<div class='unit'><h6>Date of Acquisition</h6>".$vs_acq."</div>";
				}	
				print "<hr/>";																			
				#if ($vs_idno = $t_object->get('ca_objects.idno')) {
				#	print "<div class='unit'><h6>Work Code</h6>".$vs_idno."</div>";
				#}
				if ($vs_crates = $t_object->get('ca_objects.crate_number')) {
					print "<div class='unit'><h6>Number of Crates</h6>".$vs_crates."</div>"; 
				}
				if ($va_crate_dimensions = $t_object->get('ca_objects.crate_dimensions', array('returnWithStructure' => true))) {
					$vs_buf = "";
					foreach ($va_crate_dimensions as $va_t => $va_crate_dimensions_array) {
						foreach ($va_crate_dimensions_array as $va_key => $va_crate_dimension) {
							$va_dims = array();
							if ($va_crate_dimension['cratedimensions_height']) {
								$va_dims[] = $va_crate_dimension['cratedimensions_height']." H";
							}
							if ($va_crate_dimension['cratedimensions_width']) {
								$va_dims[] = $va_crate_dimension['cratedimensions_width']." W";
							}
							if ($va_crate_dimension['cratedimensions_depth']) {
								$va_dims[] = $va_crate_dimension['cratedimensions_depth']." D";
							}
							$va_dims_in = array();
							if ($va_crate_dimension['cratedimensions_height_in']) {
								$va_dims_in[] = $va_crate_dimension['cratedimensions_height_in']." H";
							}
							if ($va_crate_dimension['cratedimensions_width_in']) {
								$va_dims_in[] = $va_crate_dimension['cratedimensions_width_in']." W";
							}
							if ($va_crate_dimension['cratedimensions_depth_in']) {
								$va_dims_in[] = $va_crate_dimension['cratedimensions_depth_in']." D";
							}							
							$vs_buf.= join(' x ', $va_dims);
							if (sizeof($va_dims_in) >= 1) {
								$vs_buf.= "(".join(' x ', $va_dims_in).")";	
							}
							if ($va_crate_dimension['cratedimensions_weight']) {
								$vs_buf.= ", ".$va_crate_dimension['cratedimensions_weight']." Weight";
							}
							if ($va_crate_dimension['cratedimensions_notes']) {
								$vs_buf.= "<p>".$va_crate_dimension['cratedimensions_notes']."</p>";
							}																											
						}
						if ($vs_buf != "") {
							print "<div class='unit'><h6>Crate Dimensions</h6>";
							print $vs_buf;
							print "</div>";
						}	
					}
				}
				if ($vs_notes = $t_object->get('ca_objects.notes')) {
					print "<div class='unit'><h6>Notes</h6>".$vs_notes."</div>";
				}
				
				# current location goes here
				
				print "<hr/>";
				
				$vs_buf_install = "";
				if ($vs_installation = $t_object->get('ca_objects.install_instructions_text')) {
					$vs_buf_install.= "<div class='unit'>".$vs_installation."</div>";
				}
				if ($va_doc_instructions = $t_object->get('ca_objects.installation_needs', array('returnWithStructure' => true, 'ignoreLocale' => true, 'version' => 'preview'))) {
					$vs_buf_install.= "<div class='unit'><h6>Installation Instructions and Equipment Needs</h6><div class='row'>";
					$o_db = new Db();
					$t_element = ca_attributes::getElementInstance('needs_media');
					$vn_media_element_id = $t_element->getElementID('needs_media');
					foreach ($va_doc_instructions as $vn_doc_obj_id => $va_doc_instructions_array) {
						foreach ($va_doc_instructions_array as $vn_doc_obj_media_id => $vn_doc_obj_image) {
							$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_doc_obj_media_id, $vn_media_element_id)) ;
							if ($qr_res->nextRow()) {
								$vs_buf_install.= "<div class='col-sm-4 docs'><p><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'object_id' => $vn_id, 'identifier' => 'attribute:'.$qr_res->get('value_id'), 'overlay' => 1))."\"); return false;'>".ucfirst($vn_doc_obj_image['needs_media'])."</a><br/>".$vn_doc_obj_image['media_date']."</p></div>";
							}
						}
					}
					$vs_buf_install.= "</div></div>";
				}
				
				$vs_buf_exam = "";				
				if ($va_visual_examination = $t_object->get('ca_objects.visual_examination', array('returnWithStructure' => true, 'ignoreLocale' => true, 'version' => 'preview'))) {
					$vs_buf_exam.= "<div class='unit'>";
					$o_db = new Db();
					$t_element_visual = ca_attributes::getElementInstance('visual_exam');
					$vn_media_element_id_visual = $t_element_visual->getElementID('visual_exam');
					foreach ($va_visual_examination as $vn_exam_obj_id => $va_exam_instructions_array) {
						foreach ($va_exam_instructions_array as $vn_exam_obj_media_id => $vn_exam_obj_image) {
							$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_exam_obj_media_id, $vn_media_element_id_visual)) ;
							if ($qr_res->nextRow()) {
								$vs_buf_exam.= "<div class='row'><div class='col-sm-4 docs'><p><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'object_id' => $vn_id, 'identifier' => 'attribute:'.$qr_res->get('value_id'), 'overlay' => 1))."\"); return false;'>".ucfirst($vn_exam_obj_image['visual_exam'])."</a>"."</p></div></div>";
							}
							$vs_buf_exam.= "<div class='row'><div class='col-sm-12'>".($vn_exam_obj_image['exam_date'] ? "<p>".$vn_exam_obj_image['exam_date']."</p>"  : "").($vn_exam_obj_image['visual_description'] ? "<p>".$vn_exam_obj_image['visual_description']."</p>" : "")."<hr></div></div>";
						}
					}
					$vs_buf_exam.= "</div>";
				}
				
				$vs_buf_packing = "";
				if ($vs_crate = $t_object->get('ca_objects.crate_yn', array('convertCodesToDisplayText' => true))) {
						$vs_buf_packing.= "<div class='unit'><h6>Crate</h6>".$vs_crate."</div>"; 
					}
					if ($vs_travel = $t_object->get('ca_objects.traveling_frame_yn', array('convertCodesToDisplayText' => true))) {
						$vs_buf_packing.= "<div class='unit'><h6>Traveling Frame?</h6>".$vs_travel."</div>"; 
					}	
					if ($vs_packing_desc = $t_object->get('ca_objects.soft_packed')) {
						$vs_buf_packing.= "<div class='unit'><h6>Packing Description</h6>".$vs_packing_desc."</div>"; 
					}	
					if ($vs_packing = $t_object->get('ca_objects.packing', array('convertCodesToDisplayText' => true))) {
						$vs_buf_packing.= "<div class='unit'><h6>Packing Materials</h6>".$vs_packing."</div>"; 
					}	

	#				if ($vs_crate_dimensions = $t_object->getWithTemplate('<ifcount code="ca_objects.crate_dimensions" min="1"><unit><ifdef code="ca_objects.crate_dimensions.cratedimensions_height">^ca_objects.crate_dimensions.cratedimensions_height H</ifdef><ifdef code="ca_objects.crate_dimensions.cratedimensions_width"> x ^ca_objects.crate_dimensions.cratedimensions_width W</ifdef><ifdef code="ca_objects.crate_dimensions.cratedimensions_depth"> x ^ca_objects.crate_dimensions.cratedimensions_depth D</ifdef> <ifdef code="ca_objects.crate_dimensions.crateheight_in|ca_objects.crate_dimensions.cratewidth_in|ca_objects.crate_dimensions.cratedepth_in">(</ifdef><ifdef code="ca_objects.crate_dimensions.crateheight_in">^ca_objects.crate_dimensions.crateheight_in H</ifdef><ifdef code="ca_objects.crate_dimensions.cratewidth_in"> x ^ca_objects.crate_dimensions.cratewidth_in W</ifdef><ifdef code="ca_objects.crate_dimensions.cratedepth_in"> x ^ca_objects.crate_dimensions.cratedepth_in D</ifdef><ifdef code="ca_objects.crate_dimensions.crateheight_in|ca_objects.crate_dimensions.cratewidth_in|ca_objects.crate_dimensions.cratedepth_in">)</ifdef><ifdef code="ca_objects.crate_dimensions.cratedimensions_weight">, ^ca_objects.crate_dimensions.cratedimensions_weight Weight</ifdef><ifdef code="ca_objects.crate_dimensions.cratedimensions_notes"><p>^ca_objects.crate_dimensions.cratedimensions_notes</p></ifdef></unit></ifcount>')) {
	#					print "<div class='unit'><h6>Crate Dimensions</h6>".$vs_crate_dimensions."</div>";
	#				}

					if ($va_packing_docs = $t_object->get('ca_objects.packing_upload', array('returnWithStructure' => true, 'ignoreLocale' => true, 'version' => 'preview'))) {
						$vs_buf_packing.= "<div class='unit'><h6>Packing Documents</h6><div class='row'>";
						$o_db = new Db();
						$t_packing = ca_attributes::getElementInstance('packing_upload');
						$vn_packing_element_id = $t_packing->getElementID('packing_upload');
						foreach ($va_packing_docs as $vn_media_id => $va_packing_docs_array) {
							foreach ($va_packing_docs_array as $vn_packing_media_id => $vn_packing_image) {
								$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_packing_media_id, $vn_packing_element_id)) ;
								if ($qr_res->nextRow()) {
									$vs_buf_packing.= "<div class='col-sm-4 docs'><p><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'object_id' => $vn_id, 'identifier' => 'attribute:'.$qr_res->get('value_id'), 'overlay' => 1))."\"); return false;'>".ucfirst($vn_packing_image['packing_upload'])."</a>"."</p></div>";
								}
							}
						}
						$vs_buf_packing.= "</div></div>";
					}
					$vs_buf_exh = "";
					if ($vs_exhibition = $t_object->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('exhibition'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
						$vs_buf_exh.= "<div class='unit'>".$vs_exhibition."</div>"; 
					}
					
					$vs_buf_biblio = "";
					if ($vs_biblio = $t_object->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('bibliography'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
						$vs_buf_biblio.= "<div class='unit'>".$vs_biblio."</div>"; 
					}
										
		print	'<div class="accordion" id="accordionExample">';
				if ($vs_buf_install != "") {
				  print '<div class="card">
					<div class="card-header" id="headingOne">
					  <h5 class="mb-0">
						<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						  <h6>Installation Instructions <i class="fa fa-chevron-down"></i></h6>
						</button>
					  </h5>
					</div>

					<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
					  <div class="card-body">'.$vs_buf_install.'</div>
					</div>
				  </div>';
				  }
				  if ($vs_buf_exam != "") {
				  print '<div class="card">
					<div class="card-header" id="headingTwo">
					  <h5 class="mb-0">
						<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						  <h6>Visual Examination <i class="fa fa-chevron-down"></i></h6>
						</button>
					  </h5>
					</div>
					<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
					  <div class="card-body">'.$vs_buf_exam.'</div>
					</div>
				  </div>';
				  }
				  if ($vs_buf_packing != "") {
				  print '<div class="card">
					<div class="card-header" id="headingThree">
					  <h5 class="mb-0">
						<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						  <h6>Packing instructions <i class="fa fa-chevron-down"></i></h6>
						</button>
					  </h5>
					</div>
					<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
					  <div class="card-body">'.$vs_buf_packing.' </div>
					</div>
				  </div>';
				  }
				  if ($vs_buf_exh != "") {
				  print '<div class="card">
					<div class="card-header" id="headingFour">
					  <h5 class="mb-0">
						<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
						  <h6>Related Exhibitions <i class="fa fa-chevron-down"></i></h6>
						</button>
					  </h5>
					</div>
					<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
					  <div class="card-body">'.$vs_buf_exh.' </div>
					</div>
				  </div>';
				  }
				  if ($vs_buf_biblio != "") {
				  print '<div class="card">
					<div class="card-header" id="headingFive">
					  <h5 class="mb-0">
						<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
						  <h6>Related Bibliography <i class="fa fa-chevron-down"></i></h6>
						</button>
					  </h5>
					</div>
					<div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
					  <div class="card-body">'.$vs_buf_biblio.' </div>
					</div>
				  </div>';
				  }				  				  
				print '</div>	';			
			
				
/*				
				if ($vs_cert = $t_object->getWithTemplate('<ifdef code="ca_objects.certificate_auth.certificate_auth_yn">^ca_objects.certificate_auth.certificate_auth_yn ^ca_objects.certificate_auth.certificate_auth_notes</ifdef>')) {
					print "<div class='unit'><h6>Certificate of Authenticity</h6>".$vs_cert."</div>";
				}
				if ($vs_parts = $t_object->get('ca_objects.children.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Parts</h6>".$vs_parts."</div>";
				}
				if ($vs_description = $t_object->get('ca_objects.description')) {
					print "<div class='unit'><h6>Description</h6>".$vs_description."</div>";
				}
				if ($vs_prov = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('provenance'), 'returnAsLink' => true))) {
					print "<div class='unit'><h6>Provenance</h6>".$vs_prov."</div>";
				}

				if ($vs_cat = $t_object->get('ca_objects.category', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Category</h6>".$vs_cat."</div>";
				}	
				if ($vs_group = $t_object->get('ca_objects.group', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))) {
					print "<div class='unit'><h6>Group</h6>".$vs_group."</div>";
				}				
				if ($vs_sound = $t_object->get('ca_objects.sound_types', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Sound Types</h6>".$vs_sound."</div>";
				}
				if ($vs_subtitles = $t_object->get('ca_objects.subtitles_yn', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Subtitles</h6>".$vs_subtitles."</div>";
				}	
				if ($vs_langsubtitles = $t_object->get('ca_objects.subtitles_language', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))) {
					print "<div class='unit'><h6>Language of Subtitles</h6>".$vs_langsubtitles."</div>";
				}
				if ($vs_equipment = $t_object->get('ca_objects.equipment')) {
					print "<div class='unit'><h6>Equipment</h6>".$vs_equipment."</div>";
				}
				if ($vs_copy = $t_object->get('ca_objects.video_copyright')) {
					print "<div class='unit'><h6>Copyright</h6>".$vs_copy."</div>";
				}
				if ($vs_general = $t_object->get('ca_objects.general_use')) {
					print "<div class='unit'><h6>General Terms of Use</h6>".$vs_general."</div>";
				}
				if ($vs_digit = $t_object->get('ca_objects.digitized_yn', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Digitized</h6>".$vs_digit."</div>";
				}
				if ($t_object->get('ca_objects.video_format.master_yn') == $vs_yes) {
					print "<div class='unit'><h6>Master</h6>".$t_object->get('ca_objects.video_format.master_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.org_master_yn') == $vs_yes) {
					print "<div class='unit'><h6>Original Master</h6>".$t_object->get('ca_objects.video_format.org_master_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.sub_master_yn') == $vs_yes) {
					print "<div class='unit'><h6>Submaster</h6>".$t_object->get('ca_objects.video_format.sub_master_text')."</div>";
				}	
				if ($t_object->get('ca_objects.video_format.suborg_master_yn') == $vs_yes) {
					print "<div class='unit'><h6>Original Submaster</h6>".$t_object->get('ca_objects.video_format.suborg_master_text')."</div>";
				}		
				if ($t_object->get('ca_objects.video_format.umatic_yn') == $vs_yes) {
					print "<div class='unit'><h6>Umatic</h6>".$t_object->get('ca_objects.video_format.umatic_text')."</div>";
				}	
				if ($t_object->get('ca_objects.video_format.beta_yn') == $vs_yes) {
					print "<div class='unit'><h6>Beta</h6>".$t_object->get('ca_objects.video_format.beta_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.vhs_yn') == $vs_yes) {
					print "<div class='unit'><h6>VHS</h6>".$t_object->get('ca_objects.video_format.vhs_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.floppy_yn') == $vs_yes) {
					print "<div class='unit'><h6>Floppy Disk</h6>".$t_object->get('ca_objects.video_format.floppy_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.cd_yn') == $vs_yes) {
					print "<div class='unit'><h6>CD</h6>".$t_object->get('ca_objects.video_format.cd_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.dvd_yn') == $vs_yes) {
					print "<div class='unit'><h6>DVD</h6>".$t_object->get('ca_objects.video_format.dvd_text')."</div>";
				}	
				if ($t_object->get('ca_objects.video_format.laser_yn') == $vs_yes) {
					print "<div class='unit'><h6>Laser Disk</h6>".$t_object->get('ca_objects.video_format.laser_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.digital_beta') == $vs_yes) {
					print "<div class='unit'><h6>Digital Betacam</h6>".$t_object->get('ca_objects.video_format.digital_beta_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.tape_yn') == $vs_yes) {
					print "<div class='unit'><h6>Digital Betacam</h6>".$t_object->get('ca_objects.video_format.tape_text')."</div>";
				}
				if ($t_object->get('ca_objects.video_format.other') == $vs_yes) {
					print "<div class='unit'><h6>Other</h6>".$t_object->get('ca_objects.video_format.other_text')."</div>";
				}
				if ($vs_content = $t_object->get('ca_objects.content')) {
					print "<div class='unit'><h6>Content</h6>".$vs_content."</div>";
				}
				if ($vs_historical = $t_object->get('ca_objects.historical_background')) {
					print "<div class='unit'><h6>Historical Background</h6>".$vs_historical."</div>";
				}
				if ($vs_descformats = $t_object->get('ca_objects.description_formats')) {
					print "<div class='unit'><h6>Description of the Formats</h6>".$vs_descformats."</div>";
				}
				if ($vs_elementsaudio = $t_object->get('ca_objects.elements_nonav')) {
					print "<div class='unit'><h6>Elements Non-audiovisual</h6>".$vs_elementsaudio."</div>";
				}					
				if ($vs_type_of_material = $t_object->get('ca_objects.type_of_material')) {
					print "<div class='unit'><h6>Type of Material</h6>".$vs_type_of_material."</div>";
				}
				if ($vs_number_of_material = $t_object->get('ca_objects.number_of_material')) {
					print "<div class='unit'><h6>Number of Material</h6>".$vs_number_of_material."</div>";
				}	
				if ($vs_original_trans = $t_object->get('ca_objects.original_trans')) {
					print "<div class='unit'><h6>Original transparencies</h6>".$vs_original_trans."</div>";
				}
				if ($vs_10125_original = $t_object->get('ca_objects.10125_original')) {
					print "<div class='unit'><h6>10x12.5 Original</h6>".$vs_10125_original."</div>";
				}
				if ($vs_10125_duplicates = $t_object->get('ca_objects.10125_duplicates')) {
					print "<div class='unit'><h6>10x12.5 Duplicates</h6>".$vs_10125_duplicates."</div>";
				}
				if ($vs_35mm_original = $t_object->get('ca_objects.35mm_original')) {
					print "<div class='unit'><h6>35mm Original</h6>".$vs_35mm_original."</div>";
				}	
				if ($vs_35mm_duplicates = $t_object->get('ca_objects.35mm_duplicates')) {
					print "<div class='unit'><h6>35mm Duplicates</h6>".$vs_35mm_duplicates."</div>";
				}
				if ($vs_large_trans = $t_object->get('ca_objects.large_trans')) {
					print "<div class='unit'><h6>Large Transparencies</h6>".$vs_large_trans."</div>";
				}
#				if ($vs_media_path = $t_object->get('ca_objects.media_path', array('delimiter' => '<br/>'))) {
#					print "<div class='unit'><h6>Path to media</h6>".$vs_media_path."</div>";
#				}					
				if ($vs_condition_report = $t_object->get('ca_objects.condition_yn', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Condition Report</h6>".$vs_condition_report."</div>";
				}				
				if ($vs_condition_date = $t_object->get('ca_objects.condition_report.date_condition_report')) {
					print "<div class='unit'><h6>Date of Condition Report</h6>".$vs_condition_date."</div>";
				}	
				if ($vs_condition_location = $t_object->get('ca_objects.condition_report.condition_location')) {
					print "<div class='unit'><h6>Location of Condition Report</h6>".$vs_condition_location."</div>";
				}	
				if ($vs_condition_conservator = $t_object->get('ca_objects.condition_report.conservator', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Conservator</h6>".$vs_condition_conservator."</div>";
				}
				if ($vs_condition_general = $t_object->get('ca_objects.condition_report.condition_description', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>General Description of Condition</h6>".$vs_condition_general."</div>";
				}	
				if ($vs_relative_humidity = $t_object->get('ca_objects.relative_humidity')) {
					print "<div class='unit'><h6>Relative Humidity (%)</h6>".$vs_relative_humidity."</div>";
				}	
				if ($vs_temperature = $t_object->get('ca_objects.temperature')) {
					print "<div class='unit'><h6>Temperature (C)</h6>".$vs_temperature."</div>";
				}	
				if ($vs_uv_filter = $t_object->get('ca_objects.uv_filter', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>UV Filters</h6>".$vs_uv_filter."</div>";
				}
				if ($vs_daylight = $t_object->get('ca_objects.daylight', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Daylight</h6>".$vs_daylight."</div>";
				}
				if ($vs_temperature = $t_object->get('ca_objects.temperature')) {
					print "<div class='unit'><h6>Temperature (C)</h6>".$vs_temperature."</div>";
				}	
				if ($vs_lighting_intensity = $t_object->get('ca_objects.lighting_intensity')) {
					print "<div class='unit'><h6>Lighting Intensity (Lux)</h6>".$vs_lighting_intensity."</div>";
				}	
				if ($vs_radiation = $t_object->get('ca_objects.radiation')) {
					print "<div class='unit'><h6>UV Radiation (μWatt/lumen)</h6>".$vs_radiation."</div>";
				}	
				if ($vs_exh_instructions = $t_object->get('ca_objects.exh_instructions')) {
					print "<div class='unit'><h6>Exhibition's Instructions for Staff</h6>".$vs_exh_instructions."</div>";
				}
#				if ($vs_recommendations_media = $t_object->get('ca_objects.recommendations_media')) {
#					print "<div class='unit'><h6>Recommendations media path</h6>".$vs_recommendations_media."</div>";
#				}				
				if ($vs_treatment = $t_object->get('ca_objects.treatment.executed')) {
					print "<div class='unit'><h6>Treatment Executed by</h6>".$vs_treatment."</div>";
				}	
				if ($vs_treatment_date = $t_object->get('ca_objects.treatment.treatment_date')) {
					print "<div class='unit'><h6>Treatment Date</h6>".$vs_treatment_date."</div>";
				}	
				if ($vs_treatment_active = $t_object->get('ca_objects.treatment.active_yn', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Active Conservation Treatment</h6>".$vs_treatment_active."</div>";
				}
				if ($vs_restoration = $t_object->get('ca_objects.treatment.restoration_yn', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Restoration</h6>".$vs_restoration."</div>";
				}
				if ($vs_preventive_conservation = $t_object->get('ca_objects.treatment.preventive_conservation', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Preventive Conservation</h6>".$vs_preventive_conservation."</div>";
				}	
				if ($vs_minimal = $t_object->get('ca_objects.treatment.minimal', array('convertCodesToDisplayText' => true))) {
					print "<div class='unit'><h6>Minimal Cons Treatment</h6>".$vs_minimal."</div>";
				}	
				if ($vs_execution_methods = $t_object->get('ca_objects.treatment.execution_methods')) {
					print "<div class='unit'><h6>Execution Methods</h6>".$vs_execution_methods."</div>";
				}	
				if ($vs_list_products = $t_object->get('ca_objects.treatment.list_products')) {
					print "<div class='unit'><h6>List of Products</h6>".$vs_list_products."</div>";
				}	
				if ($vs_material_parts = $t_object->get('ca_objects.treatment.material_parts')) {
					print "<div class='unit'><h6>Materials Parts Added to Object</h6>".$vs_material_parts."</div>";
				}
				if ($vs_treatment_notes = $t_object->get('ca_objects.treatment.treatment_notes')) {
					print "<div class='unit'><h6>Treatment Notes</h6>".$vs_treatment_notes."</div>";
				}
				if ($va_treatment_media = $t_object->get('ca_objects.treatment.treatment_media', array('returnWithStructure' => true, 'ignoreLocale' => true, 'version' => 'preview'))) {
					print "<div class='unit'><div class='row'>";
					$o_db = new Db();
					$t_treatment = ca_attributes::getElementInstance('treatment_media');
					$vn_treatment_element_id = $t_treatment->getElementID('treatment_media');
					foreach ($va_treatment_media as $vn_media_id => $va_media_array) {
						foreach ($va_media_array as $vn_treatment_media_id => $vn_treatment_image) {
							$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_treatment_media_id, $vn_treatment_element_id)) ;
							if ($qr_res->nextRow()) {
								print "<div class='col-sm-4 docs'><p><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', array('context' => 'objects', 'object_id' => $vn_id, 'identifier' => 'attribute:'.$qr_res->get('value_id'), 'overlay' => 1))."\"); return false;'>".ucfirst($vn_treatment_image['treatment_media'])."</a>"."</p></div>";
							}
						}
					}
					print "</div></div>";
				}				
#				if ($vs_treatment_path = $t_object->get('ca_objects.treatment.treatment_path')) {
#					print "<div class='unit'><h6>Filepath</h6>".$vs_treatment_path."</div>"; 
#				}	
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

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
		$('.collapse').collapse(){
			toggle: false
		})
	});
</script>