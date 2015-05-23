<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	include_once(__CA_LIB_DIR__."/ca/Search/InterstitialSearch.php");
	include_once(__CA_LIB_DIR__."/ca/Search/EntitySearch.php");

	
	$va_type = $t_item->get('ca_occurrences.type_id', array('convertCodesToDisplayText' => true));
	$va_title = ((strlen($t_item->get('ca_occurrences.preferred_labels')) > 40) ? substr($t_item->get('ca_occurrences.preferred_labels'), 0, 37)."..." : $t_item->get('ca_occurrences.preferred_labels'));	
	$va_home = caNavLink($this->request, "Project Home", '', '', '', '');
	MetaTagManager::setWindowTitle($va_home." > ".$va_type." > ".$va_title);	
?>
<div class="page">
	<div class="wrapper">
		<div class="sidebar">
			{{{representationViewer}}}
<?php
			if ($vs_ledger = $t_item->get('ca_objects.preferred_labels', array('returnAsLink' => true, 'delimiter' => ', ', 'sort' => 'ca_objects.preferred_labels', 'restrictToTypes' => array('ledger')))) {
				print "<div class='unit'><h6>Related Ledgers</h6>".$vs_ledger."</div>";
			}
			$vs_sidebar_buf = null;
			if ($vs_collections = $t_item->get('ca_collections.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
				$vs_sidebar_buf.= "<div class='unit'><h6>Related Collections</h6>".$vs_collections."</div>";
			}
			if ($va_links = $t_item->get('ca_occurrences.resources_link', array('returnAsArray' => true))) {
				$vs_sidebar_buf.= "<h6>External Resources</h6><div class='unit'>";
				foreach ($va_links as $va_key => $va_link) {
					if ($va_link['resources_link_description']) {
						$vs_sidebar_buf.= "<p><a href='".$va_link['resources_link_url']."' target='_blank'>".$va_link['resources_link_description']."</a></p>";
					} else {
						$vs_sidebar_buf.= "<p><a href='".$va_link['resources_link_url']."' target='_blank'>".$va_link['resources_link_url']."</a></p>";							
					}
				}
				$vs_sidebar_buf.= "</div>";
			}						
			if ($vs_sidebar_buf != "") {
				print "<h5 style='margin-top:30px;'>Learn More</h5>	";	
				print $vs_sidebar_buf;
			}			
?>			
		</div>
		<div class="content-wrapper">
      		<div class="content-inner">
				<div class="container"><div class="row">

					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
						<div class="container">
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
									<h4>{{{ca_occurrences.preferred_labels}}}</h4>
								</div><!-- end col -->
							</div><!-- end row -->
							<div class="row">			
								<div class='col-md-6 col-lg-6'>
			<?php
									if ($vs_occ_dates = $t_item->get('ca_occurrences.NYSL_occupied_dates')) {
										print "<div class='unit'>Occupied by the New York Society Library from ".$vs_occ_dates."</div>";
									}
									if ($vs_range = $t_item->get('ca_occurrences.building_range')) {
										print "<div class='unit'>Building extant from ".$vs_range."</div>";
									}
									if ($va_history = $t_item->get('ca_occurrences.building_history')) {
										print "<div class='unit'><h6>Building History</h6>".$va_history."</div>";
									}												
									if ($t_item->get('ca_occurrences.references.references_list')) {
										$va_references = $t_item->get('ca_occurrences.references', array('delimiter' => '', 'convertCodesToDisplayText' => true, 'template' => '<p style="padding-left:15px;">^references_list page ^references_page</p>'));
										print "<div class='unit'>";
										print "<a href='#' class='openRef' onclick='$(\"#references\").slideDown(); $(\".openRef\").hide(); $(\".closeRef\").show(); return false;'><h6><i class='fa fa-pencil-square-o'></i>&nbsp;Bibliography & Works Cited</h6></a>";
										print "<a href='#' class='closeRef' style='display:none;' onclick='$(\"#references\").slideUp(); $(\".closeRef\").hide(); $(\".openRef\").show(); return false;'><h6><i class='fa fa-pencil-square-o'></i>&nbsp;Bibliography & Works Cited</h6></a>";
										print "<div id='references' style='display:none;'>".$va_references."</div></div>";
									}
									if ($vs_docs = $t_item->get('ca_objects.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => ', ', 'sort' => 'ca_objects.preferred_labels', 'restrictToTypes' => array('document')))) {
										print "<div class='unit'>Related Institutional Documents: ".$vs_docs."</div>";
									}
									$va_people_by_rels = array();
									if ($va_related_people = $t_item->get('ca_entities', array('returnAsArray' => true))) {
										print "<div class='unit'>";
										foreach ($va_related_people as $va_key => $va_related_person) {
											$va_people_by_rels[$va_related_person['relationship_typename']][$va_related_person['entity_id']] = $va_related_person['label'];
										}
										$va_people_links = array();
										foreach ($va_people_by_rels as $va_role => $va_person) {
											print ucwords($va_role).": ";
											foreach ($va_person as $va_entity_id => $va_name) {
												$va_people_links[] = caNavLink($this->request, $va_name, '', '', 'Detail', 'entities/'.$va_entity_id)."<br/>";
											}
											print join(', ', $va_people_links);
										}
										print "</div>";
									}
									if ($vs_event = $t_item->get('ca_occurrences.related.preferred_labels', array('returnAsLink' => true, 'delimiter' => ', ', 'restrictToTypes' => array('personal', 'historic', 'membership')))) {
										print "<div class='unit'>Related Events: ".$vs_event."</div>";
									}
																				
			?>						
								</div><!-- end col -->
								<div class='col-md-6 col-lg-6'>
									<div id="detailTools">
										<div class="detailTool"><a href='#detailComments' onclick='jQuery("#detailComments").slideToggle();return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
										<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
										<div class="detailTool"><span class="glyphicon glyphicon-send"></span><a href='#'>Contribute</a></div><!-- end detailTool -->
									</div><!-- end detailTools -->								
									<div class='vizPlaceholder'><i class='fa fa-picture-o'></i></div>
									{{{map}}}					
								</div><!-- end col -->
							</div><!-- end row -->
						</div><!-- end container -->
					</div><!-- end col -->
				</div><!-- end row -->
				<div id='buildingTable'>
					<ul class='row'>								
						<li><a href="#entTab">Related People & Organizations</a></li>
						<li><a href="#docTab">Related Documents</a></li>			
					</ul>
					<div id='entTab' >
						<div class='container'>
							<div class='row'>
								<div class='col-sm-12 col-md-12 col-lg-12'>
<?php			
								$o_circulation_search = new EntitySearch();
								$qr_circ = $o_circulation_search->search("ca_objects_x_entities.date_out:\"{$vs_occ_dates}\"", array('sort' => 'ca_entities.preferred_labels.surname'));
								
								$va_readers = array();
								$va_alpha_list = array();
								
								$vn_c = 0;
								while ($qr_circ->nextHit()) {
									$vs_surname = ucfirst($qr_circ->get('ca_entities.preferred_labels.surname', array('restrictToRelationshipTypes' => array('reader'))));
									print $vs_surname;
									$va_readers[$vs_surname[0]][$qr_circ->get('ca_entities.entity_id', array('restrictToRelationshipTypes' => array('reader')))] = $qr_circ->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('reader')));
									$vn_c++;
									
									if ($vn_c > 5000) { break; } 	// limit to 100 max for now 
								}
								$vs_letter_bar = null;
								$vs_names = null;
								foreach ($va_readers as $va_reader_letter => $va_reader) {
									$vs_letter_bar.= "<li class='letterHeader' id='".$va_reader_letter."'><a href='#row".$va_reader_letter."'>".$va_reader_letter."<a></li>";
									$vs_names.= "<div class='row entityRow' id='row".$va_reader_letter."'>";
									foreach ($va_reader as $vn_entity_id => $vs_entity_name) {
										$vs_names.= '<div class="col-sm-3 col-md-3 col-lg-3"><div class="entityButton">'.caNavLink($this->request, $vs_entity_name, '', '', 'Detail', 'objects/'.$vn_entity_id)."</div></div>";
									}
									$vs_names.= "</div><!-- end row -->";
								}
								print "<div id='readerTable'>";
								print "<ul>".$vs_letter_bar."</ul>";
								print $vs_names;
								print "</div>";
									
?>								
								</div><!-- end col-->
							</div><!-- end row -->
						</div><!-- end container -->
					</div><!-- end entTab -->
					<div id='docTab'>
						<div class='container'>
							<div class='row'>
								<div class='col-sm-12 col-md-12 col-lg-12'>
<?php
								if ($va_documents = $t_item->get('ca_objects.preferred_labels', array('restrictToTypes' => array('document'), 'returnAsLink' => true))) {
									print "<div class='unit'><h6>Related Documents</h6>";
									print $va_documents;
									print "</div>";
								}
?>										
								</div><!-- end col -->
							</div><!-- end row -->
						</div><!-- end container -->
					</div><!-- end docTab -->
				</div><!-- end tabs -->	
				<div class='row'>
					<div class='col-sm-12 col-md-12 col-lg-12'>
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					</div><!-- end col -->
				</div><!-- end row --></div><!-- end container -->
			</div><!--end content-inner -->
		</div><!--end content-wrapper-->
	</div><!--end wrapper-->
</div><!--end page-->

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
	
	jQuery(document).ready(function() {
		$('#buildingTable').tabs();
		$('#readerTable').tabs();
	});
</script>