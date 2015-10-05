<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	
	$va_type = caNavLink($this->request, 'Digital Collections', '', '', 'Browse', 'objects');
	$va_docs = caNavLink($this->request, 'Circulation Ledgers', '', '', 'Browse', 'docs/facet/document_type/id/652');
	$va_page = $t_object->get('ca_objects.preferred_labels');

	$va_ledger = caNavLink($this->request, ((strlen($t_object->get('ca_objects.parent.preferred_labels')) > 40) ? substr($t_object->get('ca_objects.parent.preferred_labels'), 0, 37)."..." : $t_object->get('ca_objects.parent.preferred_labels')), '', '', 'Detail', 'objects/'.$t_object->get('ca_objects.parent.object_id'));

	$va_home = caNavLink($this->request, "Project Home", '', '', '', '');
	MetaTagManager::setWindowTitle($va_home." > ".$va_type." > ".$va_docs." > ".$va_ledger." > ".$va_page);
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
												<!-- AddThis Button BEGIN -->
												<div class="detailTool"><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><span class="glyphicon glyphicon-share-alt"></span> Share</a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script></div><!-- end detailTool -->
												<!-- AddThis Button END -->
												<div class="detailTool"><span class="glyphicon glyphicon-send"></span><a href='#'>Contribute</a></div><!-- end detailTool -->
												<!--<div class="detailTool"><a href='#detailComments' onclick='jQuery("#detailComments").slideToggle();return false;'><span class="glyphicon glyphicon-comment"></span>Comment <?php print (sizeof($va_comments) > 0 ? sizeof($va_comments) : ""); ?></a></div> -->
											</div><!-- end detailTools -->											
										</div><!-- end col -->				
										<div class="col-sm-6 colBorderLeft">
											<div class='col-sm-6 col-md-6 col-lg-6'>
												<!-- New Overlay -->
												<div class="overlay overlay-corner">
													<div class='vizTitle'>Circulation Activity for <?php print $t_object->get('ca_objects.preferred_labels'); ?>
														<button type="button" class="overlay-close">Close</button>
													</div>																				
												</div>						
												Viz go here
												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 expand" >
														<section>
															<p><button id="trigger-overlay" type="button">Click to Expand</button></p>
														</section>
													</div>
												</div>								
											</div><!-- end col -->
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
						<table id='circTable' class="display" style='width:100%;'>
							<thead class='titleBar' >
								<tr>
									<th>Borrower Name<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
									<th>Book Title<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
									<th>Author<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
									<th>Date Out<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
									<th>Date In<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
									<th>Rep.<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
									<th>Fine<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
								</tr>
							</thead>
							<tbody>	
				<?php
							$vn_i = 0;
							$qr_rels = caMakeSearchResult('ca_objects_x_entities', $va_rel_ids);
							while($qr_rels->nextHit()) {
								print "<tr class='ledgerRow'>";
									print "<td id='entity".$vn_i."'>";
									print "<span title='".$qr_rels->get("ca_entities.preferred_labels.surname").", ".$qr_rels->get("ca_entities.preferred_labels.forename")."'><span>";

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
									print "</td>";

									print "<td id='book".$vn_i."' style='max-width:200px;'>";
					
									if ($qr_rels->get('ca_objects.parent.object_id')) {
										$vs_book_title = explode(':',$qr_rels->get('ca_objects.parent.preferred_labels.name'));
										if (strlen($vs_book_title[0]) > 110) {
											$vs_book_title = substr($vs_book_title[0], 0, 107)."... ".$qr_rels->get('ca_objects.preferred_labels.name');
										} else {
											$vs_book_title = $vs_book_title[0]." ".$qr_rels->get('ca_objects.preferred_labels.name');
										}
										$va_circ_id = $qr_rels->get('ca_objects.parent.object_id');
										$vs_sort_title = $qr_rels->get('ca_objects.parent.preferred_labels.name_sort');
									} else {
										$vs_book_title = explode(':',$qr_rels->get('ca_objects.preferred_labels.name'));
										if (strlen($vs_book_title[0]) > 120) {
											$vs_book_title = substr($vs_book_title[0], 0, 117)."...";
										} else {
											$vs_book_title = $vs_book_title[0];
										}
										$va_circ_id = $qr_rels->get('ca_objects.object_id');
										$vs_sort_title = $qr_rels->get('ca_objects.preferred_labels.name_sort');
									}
					
									print caNavLink($this->request, trim("{$vs_book_title}"), '', '', 'Detail', 'objects/'.$va_circ_id);
									if ($vs_title = $qr_rels->get("ca_objects_x_entities.book_title")) {
										print "<br/>transcribed: {$vs_title}";
									}
									print "<span title='".$vs_sort_title."'><span>";

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
									print "</td>";
									
									print "<td>";
									print "<span title='".$qr_rels->getWithTemplate('<unit relativeTo="ca_objects" ><unit relativeTo="ca_entities" restrictToRelationshipTypes="author">^ca_entities.preferred_labels.surname, ^ca_entities.preferred_labels.forename</unit></unit>')."'><span>";
									print $qr_rels->getWithTemplate('<unit relativeTo="ca_objects" ><unit relativeTo="ca_entities" restrictToRelationshipTypes="author">^ca_entities.preferred_labels</unit></unit>');
									print "</td>"; 
				
									print "<td>";
									print $qr_rels->get("ca_objects_x_entities.date_out");
									print "</td>";	
					
									print "<td>";
									print $qr_rels->get("ca_objects_x_entities.date_in");
									print "</td>";

									print "<td>";
									print $qr_rels->get("ca_objects_x_entities.representative");
									print "</td>";
											
									print "<td>";
									print $qr_rels->get("ca_objects_x_entities.fine");
									print "</td>";													
								print "</tr>";
								$vn_i++;
							}
?>							
							</tbody>
						</table>
<?php							
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
    	$('#circTable').dataTable({
    		"order": [[ 3, "asc" ]],
    		columnDefs: [{ 
       			type: 'title-string', targets: [0,1,2]
       		}, { 
       			type: 'natural', targets: [5,6] 
    		}],
     		paging: false
    	});
	});
</script>	
