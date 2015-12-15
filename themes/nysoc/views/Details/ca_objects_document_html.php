<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	
	$va_type = caNavLink($this->request, 'Digital Collections', '', '', 'Browse', 'objects');
	$va_docs = caNavLink($this->request, 'Documents', '', '', 'Browse', 'docs/facet/document_type/id/663');
	$va_title = ((strlen($t_object->get('ca_objects.preferred_labels')) > 40) ? substr($t_object->get('ca_objects.preferred_labels'), 0, 37)."..." : $t_object->get('ca_objects.preferred_labels'));	
	$va_home = caNavLink($this->request, "City Readers", '', '', '', '');
	MetaTagManager::setWindowTitle($va_home." > ".$va_type." > ".$va_docs." > ".$va_title);	
?>
<div class="page">
	<div class="wrapper">
		<div class="sidebar">
<?php
			if ($va_dc_types = $t_object->get('ca_objects.dc_type', array('returnAsArray' => true))) {
				print "<div class='unit'><h6>Type</h6>";
					foreach ($va_dc_types as $va_dc_type) {
						print caNavLink($this->request, caGetListItemByIDForDisplay($va_dc_type), '', 'Browse', 'document', 'facet/dc_type/id/'.$va_dc_type)."<br/>";
					}
				print "</div>";
			}
			if ($va_local = $t_object->get('ca_objects.local_subject', array('returnAsArray' => true))) {
				print "<div class='unit'><h6>Subject</h6>";
					foreach ($va_local as $va_local_subject) {
						print caNavLink($this->request, caGetListItemByIDForDisplay($va_local_subject), '', 'Browse', 'document', 'facet/local_subject/id/'.$va_local_subject)."<br/>";
					}
				print "</div>";
			}
			if ($va_genres = $t_object->get('ca_objects.document_type', array('returnAsArray' => true))) {
				print "<div class='unit'><h6>Genre</h6>";
					foreach ($va_genres as $va_genre) {
						print caNavLink($this->request, caGetListItemByIDForDisplay($va_genre), '', 'Browse', 'document', 'facet/document_type/id/'.$va_genre)."<br/>";
					}
				print "</div>";
			}							
			if ($vs_subjects_lcsh = $t_object->get('ca_objects.LCSH', array('returnWithStructure' => 'true'))) {
				print "<div class='unit'><h6>LC Subject Headings</h6>";
				foreach ($vs_subjects_lcsh as $va_key => $vs_subject_lcsh_r) {
					foreach ($vs_subject_lcsh_r as $va_key => $vs_subject_lcsh_l) {
						foreach ($vs_subject_lcsh_l as $vs_subject_lcsh) {
							$va_subject = explode(' [', $vs_subject_lcsh);
							print caNavLink($this->request, $va_subject[0], '', '', 'Search', 'document/search/'.$va_subject[0])."<br/>";
						}
					}
				}
				print "</div>";
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
							</div><!-- end col -->
							<div class='col-md-6 col-lg-6'>
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
								if ($va_date_array = $t_object->get('ca_objects.dc_date', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
									$va_date_by_type = array();
									print "<div class='unit'>";
									foreach ($va_date_array as $va_key => $va_dates) {
										foreach ($va_dates as $va_key2 => $va_date) {
											$va_date_by_type[$va_date['dc_dates_types']][] = $va_date['dates_value'];
										}
									}
									foreach ($va_date_by_type as $va_date_type => $va_date) {
										print "<br/><span style='text-transform:uppercase;'>".$va_date_type."</span><br/>";
										foreach ($va_date as $va_key => $vn_date_value) {
											print $vn_date_value."<br/>";
										}
									}
									print "</div>";
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
									<!-- AddThis Button BEGIN -->
									<div class="detailTool"><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><span class="glyphicon glyphicon-share-alt"></span> Share</a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script></div><!-- end detailTool -->
									<!-- AddThis Button END -->									
									<div class="detailTool"><span class="glyphicon glyphicon-send"></span><a href='mailto:ledger@nysoclib.org?subject=CR%20User%20Contribution:%20<?php print $t_object->get('ca_objects.idno'); ?>&body='>Contribute</a></div><!-- end detailTool -->
									<!-- <div class="detailTool"><a href='#detailComments' onclick='jQuery("#detailComments").slideToggle();return false;'><span class="glyphicon glyphicon-comment"></span>Comment <?php print (sizeof($va_comments) > 0 ? sizeof($va_comments) : ""); ?></a></div> -->
								</div><!-- end detailTools -->						
							</div><!-- end col -->		
						</div><!-- end row -->
					</div><!-- end col -->		
				</div><!-- end row -->
<?php
				#check people
				$vs_people_buf = null;
				$va_people_by_rels = array();
				if ($va_related_people = $t_object->get('ca_entities', array('returnWithStructure' => true, 'sort' => 'ca_entities.type_id', 'excludeRelationshipTypes' => array('creator', 'publisher', 'contributor', 'printer')))) {
		
					foreach ($va_related_people as $va_key => $va_related_person) {
						$va_people_by_rels[$va_related_person['relationship_typename']][$va_related_person['entity_id']] = $va_related_person['label'];
					}
					$va_people_links = array();
					foreach ($va_people_by_rels as $va_role => $va_person) {
						$vs_people_buf.= "<div class='row'>";
							$vs_people_buf.= "<a href='#' class='closeLink".$va_role."' onclick='$(\"#ent".$va_role."\").slideUp();$(\".closeLink".$va_role."\").hide();$(\".openLink".$va_role."\").show();return false;'><h6>".ucwords($va_role)."&nbsp;<i class='fa fa-angle-down'></i></h6></a>";
							$vs_people_buf.= "<a href='#' style='display:none;' class='openLink".$va_role."' onclick='$(\"#ent".$va_role."\").slideDown();$(\".openLink".$va_role."\").hide();$(\".closeLink".$va_role."\").show();return false;'><h6>".ucwords($va_role)."&nbsp;<i class='fa fa-angle-up'></i></h6></a>";						
							$vs_people_buf.= "<div id='ent".$va_role."'>";
								foreach ($va_person as $va_entity_id => $va_name) {
									$vs_people_buf.= "<div class='col-sm-3 col-md-3 col-lg-3'><div class='entityButton'>".caNavLink($this->request, $va_name, 'entityName', '', 'Detail', 'entities/'.$va_entity_id)."</div></div>";
								}

							$vs_people_buf.= "</div><!-- end entrole -->";
						$vs_people_buf.= "</div><!-- end row -->";
					}
				}				
				#check books
				$vs_book_buf = null;
				if ($va_books = $t_object->get('ca_objects.related', array('restrictToTypes' => array('bib'), 'returnWithStructure' => true))) {
					foreach ($va_books as $va_book_id => $va_book) {
						$t_book = new ca_objects($va_book['object_id']);
						$va_title_trunk = explode(':',$va_book['label']);
						if ($t_book->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'delimiter' => ', '))) {
							$vs_author = $t_book->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'delimiter' => ', '))."<br/>";
						} else {$vs_author = null;}
						$vn_pub_date = $t_book->get('ca_objects.publication_date');
						$vs_book_buf.= "<div class='col-sm-4 col-md-4 col-lg-4'><div class='bookButton'>".caNavLink($this->request, "<div class='bookLabel'>".$va_title_trunk[0]."</div>".$vs_author.$vn_pub_date, '', '', 'Detail', 'objects/'.$va_book['object_id'])."</div></div>";
					}
				}
				#check docs	
				$vs_doc_buf = null;
				$va_docs_by_type = array();
				$vs_i_have_docs = false;
				if ($va_related_documents = $t_object->get('ca_objects.related.object_id', array('restrictToTypes' => array('document'), 'returnAsArray' => true))) {
					foreach ($va_related_documents as $va_key => $vn_doc_id) {
						$t_doc = new ca_objects($vn_doc_id);
						$vs_doc_type = $t_doc->get('ca_objects.document_type', array('convertCodesToDisplayText' => true));
						$va_docs_by_type[$vs_doc_type][$vn_doc_id] = "<div class='col-sm-3 col-md-3 col-lg-3'><div class='entityButton'>".caNavLink($this->request, $t_doc->get('ca_objects.preferred_labels'),'', '', 'Detail', 'objects/'.$vn_doc_id)."</div></div>";	
						$vs_i_have_docs = true;
					}
				}								
				if ($va_related_catalogs = $t_object->get('ca_objects.related.object_id', array('restrictToTypes' => array('catalog'), 'returnAsArray' => true))) {
					foreach ($va_related_catalogs as $va_key => $vn_cat_id) {
						$t_cat = new ca_objects($vn_cat_id);
						$vs_cat_type = $t_cat->get('ca_objects.document_type', array('convertCodesToDisplayText' => true));
						$va_docs_by_type[$vs_cat_type][$vn_cat_id] = "<div class='col-sm-3 col-md-3 col-lg-3'><div class='entityButton'>".caNavLink($this->request, $t_cat->get('ca_objects.preferred_labels'),'', '', 'Detail', 'objects/'.$vn_cat_id)."</div></div>";	
						$vs_i_have_docs = true;
					}
				}
				$va_ledger_list = array();
				if ($va_related_ledgers = $t_object->get('ca_objects.related.object_id', array('restrictToTypes' => array('ledger'), 'returnAsArray' => true))) {
					foreach ($va_related_ledgers as $va_key => $vn_ledger_id) {
						$t_ledger = new ca_objects($vn_ledger_id);
						$vs_ledger_type = $t_ledger->get('ca_objects.document_type', array('convertCodesToDisplayText' => true));
						$va_docs_by_type[$vs_ledger_type][$vn_ledger_id] = "<div class='col-sm-3 col-md-3 col-lg-3'><div class='entityButton'>".caNavLink($this->request, $t_ledger->get('ca_objects.preferred_labels'),'', '', 'Detail', 'objects/'.$vn_ledger_id)."</div></div>";	
						$vs_i_have_docs = true;
					}
				}						
				if ($vs_i_have_docs == true) {
					ksort($va_docs_by_type);
					foreach ($va_docs_by_type as $vs_doc_type => $vs_documents) {
						$vs_doc_buf.= "<div class='row'>";
						$vs_doc_buf.= "<h6>Related ".$vs_doc_type."</h6>";
						$vs_doc_buf.= "<div>";
						foreach ($vs_documents as $va_key => $vs_doc) {
							$vs_doc_buf.= $vs_doc;
						}
						$vs_doc_buf.= "</div>";
						$vs_doc_buf.= "</div>";
					}	
				}
?>
				<div class="row"><div class='col-sm-12 col-md-12 col-lg-12'>	
					<div id='objectTable'>
						<ul class='row'>
							<?php if ($vs_people_buf) {print '<li><a href="#entTab">Related People & Organizations</a></li>';} ?>			
							<?php if ($vs_book_buf) {print '<li><a href="#bookTab">Related Books</a></li>';} ?>
							<?php if ($vs_doc_buf) {print '<li><a href="#docTab">Related Documents</a></li>';} ?>	
						</ul>
						<div id='entTab' >
							<div class='container'>
								<div class='row'>
									<div class='col-sm-12 col-md-12 col-lg-12'>
	<?php
									print $vs_people_buf;
	?>										
									</div><!-- end col -->											
								</div><!-- end row -->
							</div><!-- end container -->
						</div><!-- end entTab -->	
						<div id='bookTab' >
							<h6></h6>
							<div class='container'>
								<div class='row'>
									<div class='col-sm-12 col-md-12 col-lg-12'>	
										<div class='row'>									
<?php
										print $vs_book_buf;
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
										print $vs_doc_buf;
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