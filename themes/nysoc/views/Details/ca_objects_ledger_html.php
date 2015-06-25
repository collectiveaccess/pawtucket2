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
			if ($va_local_subject = $t_object->get('ca_objects.local_subject', array('convertCodesToDisplayText' => true))) {
				print "<div class='unit'><h6>Local Subject</h6>".$va_local_subject."</div>";
			}
			if ($va_genre = $t_object->get('ca_objects.document_type', array('convertCodesToDisplayText' => true))) {
				print "<div class='unit'><h6>Genre</h6>".$va_genre."</div>";
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
						<div class="container"><div class="row">
							<div class='col-sm-12 col-md-12 col-lg-12 ledgerImage'>
								<H4>{{{ca_objects.preferred_labels.name}}}</H4>
<?php
								if ($va_related_entities = $t_object->get('ca_entities.preferred_labels', array('excludeRelationshipTypes' => array('reader'), 'delimiter' => ', ', 'returnAsLink' => true))) {
									print "<h4>".$va_related_entities."</h4>";
								}
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
								#$vn_i = 0;								
								#$va_ledger_images = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true, 'sort' => 'ca_objects.preferred_labels.name'));			
								#foreach ($va_ledger_images as $va_ledger_key => $va_ledger_image) {
								#	$t_item = new ca_objects($va_ledger_image);	
								#	print "<div style='width:50%; float:left;'>".$t_item->get('ca_object_representations.media.large')."</div>";
								#	$vn_i++;
								#	if ($vn_i == 2) {
								#		break;
								#	}			
								#}
?>	
								{{{representationViewer}}}
								
									<div id="detailTools">
										<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
										<div class="detailTool"><span class="glyphicon glyphicon-send"></span><a href='#'>Contribute</a></div><!-- end detailTool -->
										<div class="detailTool"><a href='#detailComments' onclick='jQuery("#detailComments").slideToggle();return false;'><span class="glyphicon glyphicon-comment"></span>Comment <?php print (sizeof($va_comments) > 0 ? sizeof($va_comments) : ""); ?></a></div><!-- end detailTool -->
									</div><!-- end detailTools -->
								 									
								<HR>										
							</div><!-- end col -->
						</div><!-- end row -->
						<div class='row'>
							<div class='col-sm-12 col-md-12 col-lg-12'>	
								<div id='objectTable'>
									<ul class='row'>
										<li><a href="#circTab">Circulation History</a></li>													
										<li><a href="#entTab">Related People & Organizations</a></li>			
										<li><a href="#docTab">Related Documents</a></li>	
									</ul>
									<div id='circTab' >
										<div class='container'>
											<div class='row'>
<?php
												$va_ledger_pages = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true, 'sort' => 'ca_objects.preferred_labels.name'));			
												foreach ($va_ledger_pages as $va_ledger_key => $va_ledger_page) {
													$t_page = new ca_objects($va_ledger_page);
													print "<div class='row ledgerRow'>";
			
													print "<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>";
													print caNavLink($this->request, $t_page->get('ca_object_representations.media.icon'), '', '', 'Detail', 'objects/'.$va_ledger_page);
													print "</div>";
			
													print "<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>";
													print caNavLink($this->request, $t_page->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_ledger_page);
													print "</div>";
			
													print "<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>";
													print $t_page->get('ca_entities.preferred_labels', array('delimiter' => ', ', 'returnAsLink' => true));
													print "</div>";	
			
													print "</div>";				
												}
?>											
											</div><!-- end row -->
										</div><!-- end container -->
									</div><!-- end entTab -->
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
													if ($vs_docs = $t_object->get('ca_objects.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => ', ', 'sort' => 'ca_objects.preferred_labels', 'restrictToTypes' => array('document')))) {
														print "<div class='unit'>Related Institutional Documents: ".$vs_docs."</div>";
													}
?>										
												</div><!-- end col -->											
											</div><!-- end row -->
										</div><!-- end container -->
									</div><!-- end docTab -->																	
								</div><!-- end objectTable -->	
							</div><!-- end col -->	
						</div><!-- end row -->													
					</div><!-- end container -->
					</div><!-- end col -->
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