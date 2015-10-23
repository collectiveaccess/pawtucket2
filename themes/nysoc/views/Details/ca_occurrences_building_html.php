<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	include_once(__CA_LIB_DIR__."/ca/Search/InterstitialSearch.php");
	include_once(__CA_LIB_DIR__."/ca/Search/EntitySearch.php");

	
	$va_type = "Library Buildings";
	$va_title = ((strlen($t_item->get('ca_occurrences.preferred_labels')) > 40) ? substr($t_item->get('ca_occurrences.preferred_labels'), 0, 37)."..." : $t_item->get('ca_occurrences.preferred_labels'));	
	$va_home = caNavLink($this->request, "City Readers", '', '', '', '');
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
			if ($va_collections_list = $t_item->get('ca_collections.hierarchy.collection_id', array('maxLevelsFromTop' => 1, 'returnAsArray' => true))) {
				$va_collections_for_display = array_unique(caProcessTemplateForIDs("<l>^ca_collections.preferred_labels.name</l>", "ca_collections", caFlattenArray($va_collections_list, array('unique' => true)), array('returnAsArray' => true)));
				$vs_sidebar_buf .= join("<br/>\n", $va_collections_for_display);
			}						
			if ($vs_sidebar_buf != "") {
				print "<h6 style='margin-top:30px;'>In The Library</h6>	";	
				print $vs_sidebar_buf;
			}	
			$vs_learn_even = null;
			if ($va_links = $t_item->get('ca_occurrences.resources_link', array('returnWithStructure' => true))) {
				$vs_learn_even.= "<div class='unit'>";

				foreach ($va_links as $va_key => $va_link_a) {
					foreach ($va_link_a as $va_key => $va_link) {
						if ($va_link['resources_link_description']) {
							$vs_learn_even.= "<p><a href='".$va_link['resources_link_url']."' target='_blank'>".$va_link['resources_link_description']."</a></p>";
						} else {
							$vs_learn_even.= "<p><a href='".$va_link['resources_link_url']."' target='_blank'>".$va_link['resources_link_url']."</a></p>";							
						}
					}
				}
				$vs_learn_even.= "</div>";
			}			
			if ($vs_learn_even != "") {
				print "<h6 style='margin-top:30px;'>Learn Even More</h6>";	
				print $vs_learn_even;
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
									if ($vs_occ_dates = $t_item->get('ca_occurrences.NYSL_occupied_dates', array('format' => 'Y - Y'))) {
										print "<div class='unit'>Occupied by the New York Society Library ".$vs_occ_dates."</div>";
									}
									if ($vs_range = $t_item->get('ca_occurrences.building_range', array('format' => 'Y - Y'))) {
										print "<div class='unit'>Building extant ".$vs_range."</div>";
									}
									if ($t_item->get('ca_occurrences.buliding_history')) {
										$va_history = $t_item->get('ca_occurrences.buliding_history', array('delimiter' => '', 'convertCodesToDisplayText' => true));
										print "<div class='unit'>";
										print "<div id='history' class='trimText'>".$va_history."</div></div>";
									}																					
									if ($t_item->get('ca_occurrences.references.references_list')) {
										$va_references = $t_item->get('ca_occurrences.references', array('delimiter' => '', 'convertCodesToDisplayText' => true, 'template' => '<p style="padding-left:15px;">^ca_occurrences.references.references_list page ^ca_occurrences.references.references_page</p>'));
										print "<div class='unit'>";
										print "<a href='#' class='openRef' onclick='$(\"#references\").slideDown(); $(\".openRef\").hide(); $(\".closeRef\").show(); return false;'><h6><i class='fa fa-pencil-square-o'></i>&nbsp;Works Cited</h6></a>";
										print "<a href='#' class='closeRef' style='display:none;' onclick='$(\"#references\").slideUp(); $(\".closeRef\").hide(); $(\".openRef\").show(); return false;'><h6><i class='fa fa-pencil-square-o'></i>&nbsp;Works Cited</h6></a>";
										print "<div id='references' style='display:none;'>".$va_references."</div></div>";
									}
									
									$va_record_id = $t_item->get('ca_occurrences.idno');
?>
									<div id="detailTools">
										<!-- AddThis Button BEGIN -->
										<div class="detailTool"><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><span class="glyphicon glyphicon-share-alt"></span> Share</a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script></div><!-- end detailTool -->
										<!-- AddThis Button END -->										
										<div class="detailTool"><span class="glyphicon glyphicon-send"></span><a href='mailto:ledger@nysoclib.org?subject=CR%20User%20Contribution:%20<?php print $va_record_id; ?>&body='>Contribute</a></div><!-- end detailTool -->
										<!--<div class="detailTool"><a href='#detailComments' onclick='jQuery("#detailComments").slideToggle();return false;'><span class="glyphicon glyphicon-comment"></span>Comment <?php print (sizeof($va_comments) > 0 ? sizeof($va_comments) : ""); ?></a></div> -->
									</div><!-- end detailTools -->						
								</div><!-- end col -->
								<div class='col-md-6 col-lg-6'>							
									<div class='vizPlaceholder'><i class='fa fa-picture-o'></i></div>
									{{{map}}}					
								</div><!-- end col -->
							</div><!-- end row -->
						</div><!-- end container -->
					</div><!-- end col -->
				</div><!-- end row -->
<?Php
				#check people
				$vs_people_buf = null;
				$va_people_by_rels = array();
				if ($va_related_people = $t_item->get('ca_entities', array('returnWithStructure' => true, 'sort' => 'ca_entities.preferred_labels.surname'))) {
		
					foreach ($va_related_people as $va_key => $va_related_person) {
						$va_people_by_rels[$va_related_person['relationship_typename']][$va_related_person['entity_id']] = $va_related_person['label'];
					}
					$va_people_links = array();
					ksort($va_people_by_rels);
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
				#check docs	
				$vs_doc_buf = null;
				$va_docs_by_type = array();
				$vs_i_have_docs = false;
				if ($va_related_documents = $t_item->get('ca_objects.object_id', array('restrictToTypes' => array('document'), 'returnAsArray' => true))) {
					foreach ($va_related_documents as $va_key => $vn_doc_id) {
						$t_doc = new ca_objects($vn_doc_id);
						$vs_doc_type = $t_doc->get('ca_objects.document_type', array('convertCodesToDisplayText' => true));
						$va_docs_by_type[$vs_doc_type][$vn_doc_id] = "<div class='col-sm-3 col-md-3 col-lg-3'><div class='entityButton'>".caNavLink($this->request, $t_doc->get('ca_objects.preferred_labels'),'', '', 'Detail', 'objects/'.$vn_doc_id)."</div></div>";	
						$vs_i_have_docs = true;
					}
				}								
				if ($va_related_catalogs = $t_item->get('ca_objects.object_id', array('restrictToTypes' => array('catalog'), 'returnAsArray' => true))) {
					foreach ($va_related_catalogs as $va_key => $vn_cat_id) {
						$t_cat = new ca_objects($vn_cat_id);
						$vs_cat_type = $t_cat->get('ca_objects.document_type', array('convertCodesToDisplayText' => true));
						$va_docs_by_type[$vs_cat_type][$vn_cat_id] = "<div class='col-sm-3 col-md-3 col-lg-3'><div class='entityButton'>".caNavLink($this->request, $t_cat->get('ca_objects.preferred_labels'),'', '', 'Detail', 'objects/'.$vn_cat_id)."</div></div>";	
						$vs_i_have_docs = true;
					}
				}
				$va_ledger_list = array();
				if ($va_related_ledgers = $t_item->get('ca_objects.object_id', array('restrictToTypes' => array('ledger'), 'returnAsArray' => true))) {
					foreach ($va_related_ledgers as $va_key => $vn_ledger_id) {
						$t_ledger = new ca_objects($vn_ledger_id);
						$vs_ledger_type = $t_ledger->get('ca_objects.document_type', array('convertCodesToDisplayText' => true));
						$va_docs_by_type[$vs_ledger_type][$vn_ledger_id] = "<div class='col-sm-3 col-md-3 col-lg-3'><div class='entityButton'>".caNavLink($this->request, $t_ledger->get('ca_objects.preferred_labels'),'', '', 'Detail', 'objects/'.$vn_ledger_id)."</div></div>";	
						$vs_i_have_docs = true;
					}
				}						
				if ($vs_i_have_docs == true) {
					$vs_doc_buf.= "<div class='row'>";
						ksort($va_docs_by_type);
						foreach ($va_docs_by_type as $vs_doc_type => $vs_documents) {
							$vs_doc_buf.= "<h6>Related ".$vs_doc_type."</h6>";
							$vs_doc_buf.= "<div class='row'>";
							foreach ($vs_documents as $va_key => $vs_doc) {
								$vs_doc_buf.= $vs_doc;
							}
							$vs_doc_buf.= "</div>";
						}
					$vs_doc_buf.= "</div>";
				}
?>				
				<div id='buildingTable'>
					<ul class='row'>								
						<?php if ($vs_people_buf) {print '<li><a href="#entTab">Related People & Organizations</a></li>';} ?>			
						<?php if ($vs_doc_buf) {print '<li><a href="#docTab">Related Documents</a></li>';} ?>									
					</ul>
					<div id='entTab' >
						<div class='container'>
							<div class='row'>
								<div class='col-sm-12 col-md-12 col-lg-12'>
<?php			
								print $vs_people_buf;								
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
								print $vs_doc_buf;
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
</script>	
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 135
		});
		$('#buildingTable').tabs();
	});
</script>	

