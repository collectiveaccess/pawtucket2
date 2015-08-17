<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	
	$va_docs = caNavLink($this->request, 'Digital Collections', '', '', 'Browse', 'docs');
	$va_type = caNavLink($this->request, 'Circulation Ledgers', '', '', 'Browse', 'docs/facet/document_type/id/652');
	$va_title = ((strlen($t_object->get('ca_objects.preferred_labels')) > 40) ? substr($t_object->get('ca_objects.preferred_labels'), 0, 37)."..." : $t_object->get('ca_objects.preferred_labels'));	
	$va_home = caNavLink($this->request, "Project Home", '', '', '', '');
	MetaTagManager::setWindowTitle($va_home." > ".$va_docs." > ".$va_type." > ".$va_title);	
?>
<div class="page">
	<div class="wrapper">
		<div class="sidebar">
<?php	
			if ($t_object->get('ca_objects.local_subject')) {
				print "<div class='unit'><H6>Local Subject</H6>";
				print "<div>".caNavLink($this->request, $t_object->get('ca_objects.local_subject', array('convertCodesToDisplayText' => true)), '', '', 'Browse', 'ledger/facet/local_subject/id/'.$t_object->get('ca_objects.local_subject'))."</a></div></div>";
			}
			if ($t_object->get('ca_objects.document_type')) {
				print "<div class='unit'><H6>Genre</H6>";
				print "<div>".caNavLink($this->request, $t_object->get('ca_objects.document_type', array('convertCodesToDisplayText' => true)), '', '', 'Browse', 'ledger/facet/document_type/id/'.$t_object->get('ca_objects.document_type'))."</a></div></div>";
			}
			if ($va_collections_list = $t_object->get('ca_collections.hierarchy.collection_id', array('maxLevelsFromTop' => 1, 'returnAsArray' => true))) {
				$va_collections_for_display = array_unique(caProcessTemplateForIDs("<l>^ca_collections.preferred_labels.name</l>", "ca_collections", caFlattenArray($va_collections_list, array('unique' => true)), array('returnAsArray' => true)));
				print "<div class='unit'><h6 style='margin-top:30px;'>In The Library</h6>";
				print join("<br/>\n", $va_collections_for_display);
				print "</div>";
			}																	
?>
		</div>
		<div class="content-wrapper">
      		<div class="content-inner">
				<div class="container"><div class="row">
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
						<div class="row">
							<div class='col-md-6 col-lg-6'>
								<div class="detailNav">
									<div class='left'>
										<div class='resLink'>{{{resultsLink}}}</div>
									</div>
									<div class='right'>
										<div class='prevLink'>{{{previousLink}}}</div>
										<div class='nextLink'>{{{nextLink}}}</div>
									</div>
								</div>
							</div>
							<div class='col-md-6 col-lg-6'>
							</div><!-- end col -->
						</div><!-- end row -->
						<div class="container"><div class="row">
							<div class='col-sm-12 col-md-12 col-lg-12 ledgerImage'>
								<H4>{{{ca_objects.preferred_labels.name}}}</H4>								
<?php
								if ($va_related_entities = $t_object->get('ca_entities.preferred_labels', array('excludeRelationshipTypes' => array('reader'), 'delimiter' => ', ', 'returnAsLink' => true))) {
									print "<h4>".$va_related_entities."</h4>";
								}
?>
								<div id="detailTools">
									<!-- AddThis Button BEGIN -->
									<div class="detailTool"><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><span class="glyphicon glyphicon-share-alt"></span> Share</a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script></div><!-- end detailTool -->
									<!-- AddThis Button END -->									
									<div class="detailTool"><span class="glyphicon glyphicon-send"></span><a href='#'>Contribute</a></div><!-- end detailTool -->
									<!--<div class="detailTool"><a href='#detailComments' onclick='jQuery("#detailComments").slideToggle();return false;'><span class="glyphicon glyphicon-comment"></span>Comment <?php print (sizeof($va_comments) > 0 ? sizeof($va_comments) : ""); ?></a></div> -->
								</div><!-- end detailTools -->
<?php								
								if ($vs_description = $t_object->get('ca_objects.description')) {
									print "<div>".$vs_description."</div>";
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
								<div id='leavemalone' style='clear:both;'>
								<div class="cycle-slideshow composite-example row" 
									data-cycle-fx="scrollHorz"
									data-cycle-speed="2000" 
									data-cycle-pause-on-hover="true"
									data-cycle-slides="> div"
									data-cycle-timeout="0"
									data-cycle-prev="#prev"
        							data-cycle-next="#next"
									>
									

<?php								
								$vn_i = 0;	
								$vn_skip_me = true;							
								$va_ledger_images = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true, 'sort' => 'ca_objects.preferred_labels.name'));			
								foreach ($va_ledger_images as $va_ledger_key => $va_ledger_image) {
									$t_item = new ca_objects($va_ledger_image);
									if ($vn_i == 0) { print "<div class='ledgerSlide' style='width:100%'>"; }
									if ($vn_skip_me == true) { print "<div class='col-sm-6 col-md-6 col-lg-6'></div>"; $vn_i++; $vn_skip_me = false;}	
									print "<div class='col-sm-6 col-md-6 col-lg-6'>".caNavLink($this->request, $t_item->get('ca_object_representations.media.large'), '', '', 'Detail', 'objects/'.$va_ledger_image)."<div class='caption'>".$t_item->get('ca_objects.preferred_labels')."<br/>".$t_item->get('ca_entities.preferred_labels', array('delimiter' => ', ', 'returnAsLink' => true))."</div></div>";
									$vn_i++;
									if ($vn_i == 2) { 
										print "<div style='clear:both;width:100%;'></div></div>"; 
										$vn_i = 0; 
									}	
								}
?>	

								</div>

    							</div><!-- leave me alone -->
    							<div class="ledger center">
        							<span id="prev">Previous </span>
        							<span id="next"> Next</span>
    							</div>
								 									
							</div><!-- end col -->
						</div><!-- end row -->
						<div class='row'>
							<div class='col-sm-12 col-md-12 col-lg-12'>	
								<div id='objectTable' style='margin-top:20px'>
									<ul class='row'>
										<li><a href="#entTab">Related People & Organizations</a></li>			
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
									</div><!-- end bookTab -->	
									<div id='docTab' >
										<div class='container'>
											<div class='row'>
												<div class='col-sm-12 col-md-12 col-lg-12'>
<?php
													if ($va_related_documents = $t_object->get('ca_objects.related', array('restrictToTypes' => array('document'), 'returnWithStructure' => true))) {
														$vs_doc_buf.= "<div class='row'><h6>Related Documents</h6>";
														foreach ($va_related_documents as $va_key => $va_related_document) {
															$vs_doc_buf.= "<div class='col-sm-4 col-md-4 col-lg-4'><div class='bookButton'>".caNavLink($this->request, $va_related_document['label'],'', '', 'Detail', 'objects/'.$va_related_document['object_id'])."</div></div>";	
														}
														$vs_doc_buf.= "</div>";
													}
?>										
												</div><!-- end col -->											
											</div><!-- end row -->
										</div><!-- end container -->
									</div><!-- end docTab -->																	
								</div><!-- end objectTable -->	
							</div><!-- end col -->	
						</div><!-- end row -->
						<div class='row'>
							<div class='col-sm-12 col-md-12 col-lg-12'>
								<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
							</div><!-- end col -->
						</div><!-- end row -->													
					</div><!-- end container -->
					</div><!-- end col -->
				</div><!-- end container -->
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