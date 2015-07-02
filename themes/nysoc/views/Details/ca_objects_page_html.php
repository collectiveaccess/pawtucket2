<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	
	$va_type = $t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true));
	if ($t_object->get('ca_objects.parent.preferred_labels')) {
		$va_title = ((strlen($t_object->get('ca_objects.parent.preferred_labels')) > 40) ? substr($t_object->get('ca_objects.parent.preferred_labels'), 0, 37)."..." : $t_object->get('ca_objects.parent.preferred_labels')).": ".$t_object->get('ca_objects.preferred_labels');
	} else {
		$va_title = ((strlen($t_object->get('ca_objects.preferred_labels')) > 40) ? substr($t_object->get('ca_objects.preferred_labels'), 0, 37)."..." : $t_object->get('ca_objects.preferred_labels'));	
	}
	$va_home = caNavLink($this->request, "Project Home", '', '', '', '');
	MetaTagManager::setWindowTitle($va_home." > ".$va_type." > ".$va_title);
?>
<div class="page">
	<div class="wrapper">
		<div class="sidebar">

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
							<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1 ledgerImage'>
								{{{representationViewer}}}				
							</div><!-- end col -->
			
							<div class='col-sm-6 col-md-6 col-lg-5'>
								<div class="detailNav">
									<div class='prevLink'>{{{previousLink}}}</div>
									<div class='nextLink'>{{{nextLink}}}</div>
								</div>
<?php								
								print "<h6>".$t_object->get('ca_objects.parent.preferred_labels', array('returnAsLink' => true))."</h6>";
?>								
								<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
								<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
								<HR>				
				
								{{{<ifdef code="ca_objects.idno"><H6>Identifer:</H6>^ca_objects.idno<br/></ifdef>}}}
			
								<hr></hr>
									<div class="row">
										<div class="col-sm-6">		
											{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
											{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
											{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}				
							
											{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
											{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
											{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
							
											{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
											{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
											{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name</unit>}}}
							
											{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
											{{{<unit delimiter="<br/>">^ca_objects.LcshNames</unit>}}}
											
											<div id="detailTools">
												<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
												<div class="detailTool"><span class="glyphicon glyphicon-send"></span><a href='#'>Contribute</a></div><!-- end detailTool -->
												<div class="detailTool"><a href='#detailComments' onclick='jQuery("#detailComments").slideToggle();return false;'><span class="glyphicon glyphicon-comment"></span>Comment <?php print (sizeof($va_comments) > 0 ? sizeof($va_comments) : ""); ?></a></div><!-- end detailTool -->
											</div><!-- end detailTools -->											
										</div><!-- end col -->				
										<div class="col-sm-6 colBorderLeft">
											{{{map}}}
										</div>
									</div><!-- end row -->
							</div><!-- end col -->
						</div><!-- end row -->
		
			
				<?php
					$va_references = $t_object->getAuthorityElementReferences();
					if (is_array($va_object_entity_rels = $va_references[$t_object->getAppDatamodel()->getTableNum('ca_objects_x_entities')])) {
						$va_rel_ids = array_keys($va_object_entity_rels);
						if(sizeof($va_rel_ids) > 0) {
				?>
							<div class='row titleBar' >
								<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Borrower Name</div>
								<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Book Title</div>
								<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Author</div>
								<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Date Out</div>
								<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Date In</div>
								<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>Rep.</div>
								<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>Fine</div>
							</div>
				<?php
							$vn_i = 0;
							$qr_rels = caMakeSearchResult('ca_objects_x_entities', $va_rel_ids);
							while($qr_rels->nextHit()) {
								print "<div class='row ledgerRow'>";
									print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2' id='entity".$vn_i."'>";
									print $qr_rels->get("ca_entities.preferred_labels.displayname", array('returnAsLink' => true));
									$vs_entity_info = null;
									if ($qr_rels->getWithTemplate("^ca_entities.life_dates")) {
										$vs_entity_info = $qr_rels->getWithTemplate("^ca_entities.life_dates")."<br/>";
									}
									if ($qr_rels->getWithTemplate("^ca_entities.industry_occupations")) {
										$vs_entity_info.= $qr_rels->getWithTemplate("^ca_entities.industry_occupations", array('delimiter' => ', '))."<br/>";
									}
									if ($vs_entity_info) {					
										TooltipManager::add('#entity'.$vn_i, "<div class='tooltipImage'>".$qr_rels->getWithTemplate('<unit relativeTo="ca_entities">^ca_object_representations.media.preview</unit>')."</div><b>".$qr_rels->get("ca_entities.preferred_labels.displayname")."</b><br/>".$vs_entity_info); 
 									}
									print "</div>";

									print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2' id='book".$vn_i."'>";
					
									if ($qr_rels->get('ca_objects.parent.object_id')) {
										$vs_book_title = explode(':',$qr_rels->get('ca_objects.parent.preferred_labels.name'));
										if (strlen($vs_book_title[0]) > 110) {
											$vs_book_title = substr($vs_book_title[0], 0, 107)."... ".$qr_rels->get('ca_objects.preferred_labels.name');
										} else {
											$vs_book_title = $vs_book_title[0]." ".$qr_rels->get('ca_objects.preferred_labels.name');
										}
										$va_circ_id = $qr_rels->get('ca_objects.parent.object_id');
									} else {
										$vs_book_title = explode(':',$qr_rels->get('ca_objects.preferred_labels.name'));
										if (strlen($vs_book_title[0]) > 120) {
											$vs_book_title = substr($vs_book_title[0], 0, 117)."...";
										} else {
											$vs_book_title = $vs_book_title[0];
										}
										$va_circ_id = $qr_rels->get('ca_objects.object_id');
									}
					
									print caNavLink($this->request, trim("{$vs_book_title}"), '', '', 'Detail', 'objects/'.$va_circ_id);
									if ($vs_title = $qr_rels->get("ca_objects_x_entities.book_title")) {
										print "<br/>transcribed: {$vs_title}";
									}
									#$va_book_info = array();
									#if ($va_author = $qr_rels->getWithTemplate('<unit relativeTo="ca_objects" ><unit relativeTo="ca_entities" restrictToRelationshipTypes="author">^ca_entities.preferred_labels</unit></unit>')) {
									#	$va_book_info[] = $va_author;
									#} else {$va_author = null;}
									#if ($va_publication_date = $qr_rels->get("ca_objects.publication_date")) {
									#	$va_book_info[] = $va_publication_date;
									#} else { $va_publication_date = null; }
									#if ($va_publisher = $qr_rels->get("ca_objects.publisher")) {
									#	$va_book_info[] = $va_publisher;
									#} else { $va_publisher = null; }
									#TooltipManager::add('#book'.$vn_i, $qr_rels->get('ca_objects.parent.preferred_labels.name')." ".$qr_rels->get('ca_objects.preferred_labels.name')."<br/>".join('<br/>', $va_book_info)); 
									print "</div>";
									
									print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
									print $qr_rels->getWithTemplate('<unit relativeTo="ca_objects" ><unit relativeTo="ca_entities" restrictToRelationshipTypes="author">^ca_entities.preferred_labels</unit></unit>');
									print "</div>";	
				
									print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
									print $qr_rels->get("ca_objects_x_entities.date_out");
									print "</div>";	
					
									print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
									print $qr_rels->get("ca_objects_x_entities.date_in");
									print "</div>";

									print "<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>";
									print $qr_rels->get("ca_objects_x_entities.representative");
									print "</div>";
											
									print "<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>";
									print $qr_rels->get("ca_objects_x_entities.fine");
									print "</div>";													
								print "</div>";
								$vn_i++;
							}
						}
					}
				?>				
	
					</div><!-- end container -->
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
	});
</script>