<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	
	$va_type = $t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true));
	$va_title = ((strlen($t_object->get('ca_objects.preferred_labels')) > 40) ? substr($t_object->get('ca_objects.preferred_labels'), 0, 37)."..." : $t_object->get('ca_objects.preferred_labels'));	
	$va_home = caNavLink($this->request, "Project Home", '', '', '', '');
	MetaTagManager::setWindowTitle($va_home." > ".$va_type." > ".$va_title);	
?>
<div class="page">
	<div class="wrapper">
		<div class="sidebar">
<?php
			if ($va_dc_type = $t_object->get('ca_objects.dc_type', array('convertCodesToDisplayText' => true))) {
				print "<div class='unit'><h6>Type</h6>".$va_dc_type."</div>";
			}
			if ($va_local = $t_object->get('ca_objects.local_subject', array('convertCodesToDisplayText' => true))) {
				print "<div class='unit'><h6>Subject</h6>".$va_local."</div>";
			}
			if ($va_genre = $t_object->get('ca_objects.document_type', array('convertCodesToDisplayText' => true))) {
				print "<div class='unit'><h6>Genre</h6>".$va_genre."</div>";
			}	
			if ($vs_subjects_lcsh = $t_object->get('ca_objects.LCSH', array('returnWithStructure' => 'true'))) {
				print "<div class='unit'><h6>LC Subject Headings</h6>";
				foreach ($vs_subjects_lcsh as $va_key => $vs_subject_lcsh_r) {
					foreach ($vs_subject_lcsh_r as $va_key => $vs_subject_lcsh_l) {
						foreach ($vs_subject_lcsh_l as $vs_subject_lcsh) {
							$va_subject = explode(' [', $vs_subject_lcsh);
							print caNavLink($this->request, $va_subject[0], '', '', 'Search', 'objects/search/'.$vs_subject_lcsh)."<br/>";
						}
					}
				}
				print "</div>";
			}
			if ($va_collection = $t_object->get('ca_collections.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
				print "<div class='unit'><h5 style='margin-top:30px;'>Learn More</h5><h6>Finding Aids</h6>".$va_collection."</div>";
			}											
?>
		</div>
		<div class="content-wrapper">
      		<div class="content-inner">
				<div class="container"><div class="row">
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
						<div class="row">
							<div class='col-md-12 col-lg-12'>
								<div class="detailNav">
									<div class='left'>
										<div class='resLink'>{{{resultsLink}}}</div>
									</div>
									<div class='right'>
										<div class='prevLink'>{{{previousLink}}}</div>
										<div class='nextLink'>{{{nextLink}}}</div>
									</div>
								</div>

							</div><!-- end col -->
						</div><!-- end row -->
						<div class="row">
							<div class='col-sm-6 col-md-6 col-lg-6'>
								{{{representationViewer}}}
								<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
							</div><!-- end col -->
							<div class='col-sm-6 col-md-6 col-lg-6'>	
<?php
								print "<h4>".$t_object->get('ca_objects.preferred_labels')."</h4>";
								
								if ($va_creator = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('creator'), 'delimiter' => ', ', 'returnAsLink' => true))) {
									print "<div class='unit'><h6>Creator</h6>".$va_creator."</div>";
								}								
								if ($va_contributor = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('contributor'), 'delimiter' => ', ', 'returnAsLink' => true))) {
									print "<div class='unit'><h6>Contributor</h6>".$va_contributor."</div>";
								}
								if ($va_publisher = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('printer', 'publisher'), 'delimiter' => ', ', 'returnAsLink' => true))) {
									print "<div class='unit'><h6>Printer/Publisher</h6>".$va_publisher."</div>";
								}
								if ($va_building = $t_object->get('ca_occurrences.preferred_labels', array('returnAsLink' => true, 'restrictToTypes' => array('building'), 'delimiter' => ', '))) {
									print "<div class='unit'><h6>Library Building</h6>".$va_building."</div>";
								}	
								if ($va_date = $t_object->get('ca_objects.dc_date', array('template' => '^ca_objects.dc_date.dates_value ^ca_objects.dc_date.dc_dates_types', 'delimiter' => ', ', 'convertCodesToDisplayText' => true))) {
									print "<div class='unit'><h6>Date</h6>".$va_date."</div>";
								}
								print "<hr/>";
								if ($va_description = $t_object->get('ca_objects.description.description_text')) {
									print "<div class='unit'>".$va_description."</div>";
								}
								if ($va_dims = $t_object->get('ca_objects.dimensions', array('returnWithStructure' => true))) {
									$va_dimensions_list = array();
									foreach ($va_dims as $va_key => $va_dim) {
										foreach ($va_dim as $va_dimensions) {
											if ($va_dimensions['dimensions_length']) {
												$va_dimensions_list[] = $va_dimensions['dimensions_length']." L";
											}	
											if ($va_dimensions['dimensions_width']) {
												$va_dimensions_list[] = $va_dimensions['dimensions_width']." W";
											}	
											if ($va_dimensions['dimensions_height']) {	
												$va_dimensions_list[] = $va_dimensions['dimensions_height']." H";
											}	
											if ($va_dimensions['dimensions_thickness']) {												
												$va_dimensions_list[] = $va_dimensions['dimensions_thickness']." T";
											}
										}
									}
									if ($va_dimensions_list) {
										print "<div class='unit'>";
										print "<h6>Dimensions</h6>";
										print join(' x ', $va_dimensions_list);
										print "</div>";
									}
								}																															
?>	
								<div id="detailTools">
									<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
									<div class="detailTool"><span class="glyphicon glyphicon-send"></span><a href='#'>Contribute</a></div><!-- end detailTool -->
									<div class="detailTool"><a href='#detailComments' onclick='jQuery("#detailComments").slideToggle();return false;'><span class="glyphicon glyphicon-comment"></span>Comment <?php print (sizeof($va_comments) > 0 ? sizeof($va_comments) : ""); ?></a></div><!-- end detailTool -->
								</div><!-- end detailTools -->						
							</div><!-- end col -->		
						</div><!-- end row -->
					</div><!-- end col -->		
				</div><!-- end row -->

				<div class="row"><div class='col-sm-12 col-md-12 col-lg-12'>	
					<div id='objectTable'>
						<ul class='row'>
							<li><a href="#entTab">Related People & Organizations</a></li>
							<li><a href="#bookTab">Related Books</a></li>													
							<li><a href="#docTab">Related Documents</a></li>	
						</ul>
						<div id='entTab' >
							<div class='container'>
								<div class='row'>
									<div class='col-sm-12 col-md-12 col-lg-12'>
	<?php
										$va_people_by_rels = array();
										if ($va_related_people = $t_object->get('ca_entities', array('returnWithStructure' => true, 'sort' => 'ca_entities.type_id'))) {
								
											foreach ($va_related_people as $va_key => $va_related_person) {
												$va_people_by_rels[$va_related_person['relationship_typename']][$va_related_person['entity_id']] = $va_related_person['label'];
											}
											$va_people_links = array();
											foreach ($va_people_by_rels as $va_role => $va_person) {
												print "<div class='row'>";
													print "<a href='#' class='closeLink".$va_role."' onclick='$(\"#ent".$va_role."\").slideUp();$(\".closeLink".$va_role."\").hide();$(\".openLink".$va_role."\").show();return false;'><h6>".ucwords($va_role)."&nbsp;<i class='fa fa-angle-down'></i></h6></a>";
													print "<a href='#' style='display:none;' class='openLink".$va_role."' onclick='$(\"#ent".$va_role."\").slideDown();$(\".openLink".$va_role."\").hide();$(\".closeLink".$va_role."\").show();return false;'><h6>".ucwords($va_role)."&nbsp;<i class='fa fa-angle-up'></i></h6></a>";						
													print "<div id='ent".$va_role."'>";
														foreach ($va_person as $va_entity_id => $va_name) {
															print "<div class='col-sm-3 col-md-3 col-lg-3'><div class='entityButton'>".caNavLink($this->request, $va_name, 'entityName', '', 'Detail', 'entities/'.$va_entity_id)."</div></div>";
														}

													print "</div><!-- end entrole -->";
												print "</div><!-- end row -->";
											}
										}
	?>										
									</div><!-- end col -->											
								</div><!-- end row -->
							</div><!-- end container -->
						</div><!-- end entTab -->	
						<div id='bookTab' >
							<h6>Related Books</h6>
							<div class='container'>
								<div class='row'>
									<div class='col-sm-12 col-md-12 col-lg-12'>	
										<div class='row'>									
<?php
										if ($va_books = $t_object->get('ca_objects.related', array('restrictToTypes' => array('bib'), 'returnWithStructure' => true))) {
											foreach ($va_books as $va_book_id => $va_book) {
												print "<div class='col-sm-4 col-md-4 col-lg-4'><div class='bookButton'>".caNavLink($this->request, "<i class='fa fa-book'></i>".$va_book['label'], '', '', 'Detail', 'objects/'.$va_book['object_id'])."</div></div>";
											}
										}

?>												
										</div><!-- end row -->
									</div><!-- end col -->
								</div><!-- end row -->
							</div><!-- end container -->
						</div><!-- end bookTab -->	
						<div id='docTab' >
							<div class='container'>
								<div class='row'>
									<div class='col-sm-12 col-md-12 col-lg-12'>
	<?php
										if ($vs_docs = $t_object->get('ca_objects.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => ', ', 'sort' => 'ca_objects.preferred_labels', 'restrictToTypes' => array('document')))) {
											print "<div class='unit'>Related Institutional Documents: ".$vs_docs."</div>";
										}
	?>										
									</div><!-- end col -->											
								</div><!-- end row -->
							</div><!-- end container -->
						</div><!-- end docTab -->																	
					</div><!-- end objectTable -->	</div><!-- end col -->
			</div><!-- end row -->
			<div class='row'>
				<div class='col-sm-12 col-md-12 col-lg-12'>
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
				</div><!-- end col -->
			</div><!-- end row --></div><!-- end container -->
			</div><!--end content-inner -->
		</div><!--end content-wrapper-->
	</div><!--end wrapper-->
</div><!--end page-->



<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
		$('#objectTable').tabs();
	});
</script>
<script>
	$('a[href^="#"]').on('click', function(event) {

		var target = $( $(this).attr('href') );

		if( target.length ) {
			event.preventDefault();
			$('html, body').animate({
				scrollTop: target.offset().top
			}, 1000);
		}

	});
</script>