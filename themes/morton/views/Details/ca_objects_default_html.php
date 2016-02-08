<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
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
				<div id="detailTools">
<?php if ($this->getVar('commentsEnabled')) { ?>
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
<?php } ?>
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
				print "<h4 class='entity'>".$t_object->get('ca_entities.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true, 'restrictToRelationshipTypes' => array('author', 'collected', 'creator', 'engraver', 'draftsmen_surveyor', 'lithographer', 'photographer')))."</h4>";
?>			
				<H4><i>{{{ca_objects.preferred_labels.name}}}</i></H4> 
				<HR>
<?php
					if ($vs_identifier = $t_object->get('ca_objects.idno')){
						print "<div class='unit'><h6>Identifier</h6>".$vs_identifier."</div>";
					}
					if ($vs_pub_description = $t_object->get('ca_objects.publication_description')){
						print "<div class='unit'><h6>Publication Information</h6>".$vs_pub_description."</div>";
					}
					$va_format_buf = null;
					if ($t_object->get('ca_objects.format')) {
						$va_format_buf .= "<div class='unit'><h6>Format</h6>".$t_object->get('ca_objects.format')."</div>";
					}
					if (($t_object->get('ca_objects.digitization_info.digital_status') != "-") && $t_object->get('ca_objects.digitization_info.digital_status')) {
						$va_format_buf .= "<div class='unit'><h6>Digitization Status</h6>".$t_object->get('ca_objects.digitization_info.digital_status', array('convertCodesToDisplayText' => true))."</div>";
					}
					if ($t_object->get('ca_objects.reproduction')) {
						$va_format_buf .= "<div class='unit'><h6>Reproduction: </h6>".$t_object->get('ca_objects.reproduction', array('convertCodesToDisplayText' => true, 'delimiter' => '<br/>'))."</div>";
					}
					$va_dims_buf = null;
					if ($t_object->get('ca_objects.dimensions')) {
						$va_dimensions_list = $t_object->get('ca_objects.dimensions', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true));
						$va_dims = array();
						foreach ($va_dimensions_list as $va_dims_key => $va_dimensions) {
							foreach ($va_dimensions as $va_dim => $va_dimension) {
								if ($va_dimension['is_primary'] == 'yes'){
									if ($va_dimension['dimensions_length']) {
										$va_dims[] = $va_dimension['dimensions_length']." L";
									}
									if ($va_dimension['dimensions_width']) {
										$va_dims[] = $va_dimension['dimensions_width']." W";
									}
									if ($va_dimension['dimensions_height']) {
										$va_dims[] = $va_dimension['dimensions_height']." H";
									}
									if ($va_dimension['dimensions_weight']) {
										$va_dims[] = $va_dimension['dimensions_weight']." Weight";
									}
									$va_dims_buf .= join(' x ', $va_dims)."<br/>";
									#if ($va_dimension['measurement_notes']) {
									#	$va_dims_buf .= "<b>Notes: </b>".$va_dimension['measurement_notes']."<br/>";
									#}
									#if ($va_dimension['measurement_type']) {
									#	$va_dims_buf .= "<b>Dimensions type: </b>".$va_dimension['measurement_type'];
									#}
								}																																								
							}
						}
						$va_format_buf .= "<div class='unit'><h6>Dimensions</h6>".$va_dims_buf."</div>";
					}
					if ($t_object->get('ca_objects.scale')) {
						 $va_format_buf .= "<div class='unit'><h6>Scale</h6>".$t_object->get('ca_objects.scale')."</div>";
					}
					if ($vs_extent = $t_object->get('ca_objects.extent_text')) {
						$va_format_buf .= "<div class='unit'><h6>Extent</h6>".$vs_extent."</div>";
					}																				
					if ($va_format_buf) {
						print "<div class='unit'>".$va_format_buf."</div>";
					}					
					#if ($vs_coll_identifier = $t_object->get('ca_collections.preferred_labels', array('returnAsLink' => true))){
					#	print "<div class='unit'><h6>Collection Identifier</h6>".$vs_coll_identifier."</div>";
					#}					
					if ($t_object->get('ca_objects.type_id')) {
						print "<div class='unit'><h6>Type</h6>".$t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))."</div>";
					}								
					if ($vs_date = $t_object->get('ca_objects.date_created')){
						print "<div class='unit'><h6>Date created</h6>".$vs_date."</div>";
					}
					if ($vs_description = $t_object->get('ca_objects.description.description_text')){
						print "<div class='unit'><h6>Description</h6>".$vs_description."</div>";
					}
					if ($vs_appeared = $t_object->get('ca_objects.appeared_in')){
						print "<div class='unit'><h6>Appeared In</h6>".$vs_appeared."</div>";
					}
					$va_subjects_list = array();
					if ($va_subject_terms = $t_object->get('ca_objects.lcsh_terms', array('returnAsArray' => true))) {
						foreach ($va_subject_terms as $va_term => $va_subject_term) {
							$va_subject_term_list = explode('[', $va_subject_term);
							$va_subjects_list[] = ucfirst($va_subject_term_list[0]);
						}
					}
					if ($va_subject_terms_text = $t_object->get('ca_objects.lcsh_terms_text', array('returnAsArray' => true))) {
						foreach ($va_subject_terms_text as $va_text => $va_subject_term_text) {
							$va_subjects_list[] = ucfirst($va_subject_term_text);
						}
					}
					if ($va_subject_genres = $t_object->get('ca_objects.lcsh_genres', array('returnAsArray' => true))) {
						foreach ($va_subject_genres as $va_text => $va_subject_genre) {
							$va_subjects_list[] = ucfirst($va_subject_genre);
						}
					}
					if ($va_subject_keywords = $t_object->get('ca_list_items.preferred_labels', array('returnAsArray' => true))) {
						foreach ($va_subject_keywords as $va_text => $va_subject_keyword) {
							$va_subjects_list[] = ucfirst($va_subject_keyword);
						}
					}																
					asort($va_subjects_list);
					if (sizeof($va_subjects_list) > 1) {
						print "<div class='unit'><h6>Subject - keywords and LC headings</h6>".join("<br/>", $va_subjects_list)."</div>";
					}																											
?>								
				<hr></hr>
					<div class="row">
						<div class="col-sm-12">		
<?php
							if ($va_related_entities = $t_object->getWithTemplate('<unit relativeTo="ca_objects_x_entities" delimiter="<br/>" excludeRelationshipTypes="author,accession,collected,creator,donor,engraver,draftsmen_surveyor,lithographer,origin,photographer"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit> (^relationship_typename)</unit>')) {
								print "<div class='unit'><h6>Related Entities</h6>".$va_related_entities."</div>";
							}
							if ($va_related_objects = $t_object->get('ca_objects.related.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true))) {
								print "<div class='unit'><h6>Related Objects</h6>".$va_related_objects."</div>";
							}
							if ($va_related_collections = $t_object->get('ca_collections.preferred_labels', array('delimiter' => '<br/>', 'returnAsLink' => true))) {
								print "<div class='unit'><h6>Related Collections</h6>".$va_related_collections."</div>";
							}
							if ($t_object->get('ca_objects.coverageSpatial')) {
								print "<div class='unit'><h6>Spatial Coverage</h6>".$t_object->get('ca_objects.coverageSpatial')."</div>";
							}
							if ($t_object->get('ca_objects.coverageDates')) {
								print "<div class='unit'><h6>Coverage dates</h6>".$t_object->get('ca_objects.coverageDates')."</div>";
							}	
							if ($t_object->get('ca_objects.coverageNotes')) {
								print "<div class='unit'><h6>Coverage notes</h6>".$t_object->get('ca_objects.coverageNotes')."</div>";
							}					
							if ($vs_language = $t_object->get('ca_objects.language', array('convertCodesToDisplayText' => true))) {
								print "<div class='unit'><h6>Language</h6>".$vs_language."</div>";
							}
							if ($vs_credit_line = $t_object->get('ca_objects.credit_line')) {
								print "<div class='unit'><h6>Credit Line</h6>".$vs_credit_line."</div>";
							}
							
							$vs_rights_buf = null;

							if (($va_rights_bundle = $t_object->get('ca_objects.rights', array('returnWithStructure' => true))) | ($t_object->get('ca_objects.public_domain', array('convertCodesToDisplayText' => true)) == "yes")) {
								foreach ($va_rights_bundle as $va_att_key => $va_rights_list) {
									foreach ($va_rights_list as $va_key => $va_rights) {
										if ($va_rights['rightsText']) {
											$vs_rights_buf.= "<div><b>Rights & Restrictions: </b>".$va_rights['rightsText']."</div>";
										}
										if ($va_rights['endRestriction']) {
											$vs_rights_buf.= "<div><b>End of restriction: </b>".$va_rights['endRestriction']."</div>";
										}
										if ($va_rights['endRestrictionNotes']) {
											$vs_rights_buf.= "<div><b>End of restriction notes: </b>".$va_rights['endRestrictionNotes']."</div>";
										}
										if ($va_rights['rightsHolder']) {
											$vs_rights_buf.= "<div><b>Rights Holder: </b>".$va_rights['rightsHolder']."</div>";
										}
										if ($va_rights['copyrightStatement']) {
											$vs_rights_buf.= "<div><b>Copyright statement: </b>".$va_rights['copyrightStatement']."</div>";
										}																																								
									}
								}
								if ($vs_rights_buf  | ($t_object->get('ca_objects.public_domain', array('convertCodesToDisplayText' => true)) == "yes")) {
									print "<div class='unit'><h6>Rights & User Restrictions</h6>".$vs_rights_buf."</div>";
								}
								if ($t_object->get('ca_objects.public_domain', array('convertCodesToDisplayText' => true)) == "yes") {
									print "Public Domain";
								}								
							}
							if (($vs_appeared = $t_object->get('ca_objects.appeared_in')) | ($va_appears = $t_object->get('ca_objects.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'restrictToRelationshipTypes' => array('appears'))))) {
								print "<div class='unit'><h6>Appeared In</h6>".$vs_appeared."<br/>".$va_appears."</div>";
							}
?>
						
						</div>
					</div><!-- end row -->
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