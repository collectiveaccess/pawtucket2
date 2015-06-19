<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	
	$va_type = $t_item->get('ca_entities.type_id', array('convertCodesToDisplayText' => true));
	$va_title = ((strlen($t_item->get('ca_entities.preferred_labels')) > 40) ? substr($t_item->get('ca_entities.preferred_labels'), 0, 37)."..." : $t_item->get('ca_entities.preferred_labels'));	
	$va_home = caNavLink($this->request, "Project Home", '', '', '', '');
	MetaTagManager::setWindowTitle($va_home." > ".$va_type." > ".$va_title);	
?>
<div class="page">
	<div class="wrapper">
		<div class="sidebar">
			<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
				<div class='resLink'>{{{resultsLink}}}</div>

			</div><!-- end detailTop -->		
			{{{representationViewer}}}
			<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
		</div>
		<div class="content-wrapper">
      		<div class="content-inner">
				<div class="container"><div class="row">
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
						<div class="container">
							<div class="row">
								<div class='col-md-12 col-lg-12'>
									<div class="detailNav">
										<div class='prevLink'>{{{previousLink}}}</div>
										<div class='nextLink'>{{{nextLink}}}</div>
									</div>
									<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
									<H4>{{{^ca_entities.nonpreferred_labels.displayname}}}</H4>
								</div><!-- end col -->
							</div><!-- end row -->
							<div class="row">			
								<div class='col-md-6 col-lg-6'>
				<?php
									if ($va_life_dates = $t_item->get('ca_entities.life_dates')) {
										print "<H6 style='padding-bottom:20px;'>".$va_life_dates."</H6>";
									}
									if ($va_org_dates = $t_item->get('ca_entities.org_dates')) {
										print "<H6 style='padding-bottom:20px;'>".$va_org_dates."</H6>";
									}					
				?>				
									<div class='unit'>{{{<ifdef code="ca_entities.gender"><span class='metaTitle'>Gender: </span>^ca_entities.gender</ifdef>}}}</div>
					
									<div class='unit'>{{{<ifdef code="ca_entities.country_origin"><span class='metaTitle'>Country of Origin: </span>^ca_entities.country_origin</ifdef>}}}</div>
				<?php
									if ($va_occupations = $t_item->get('ca_entities.industry_occupations', array('returnAsArray' => true))) {
										print "<div class='unit'><span class='metaTitle'>Occupation: </span>";
										$va_as_text = $t_item->get('ca_entities.industry_occupations', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
										$va_occupations_list = array();
										foreach ($va_occupations as $va_key => $va_occupation) {
											foreach ($va_occupation as $va_key2 => $va_occupation_id) {
												$va_occupations_list[] = caNavLink($this->request, $va_as_text[$va_key][$va_key2], '', '', 'Browse', 'entities/facet/occupation_facet/id/'.$va_occupation_id)."</a>";
											}
										}
										print join(', ', $va_occupations_list);
										print "</div>";
									}
									if ($t_item->get('ca_entities.idno')) {
										print "<div class='unit'>Identifier: ".$t_item->get('ca_entities.idno')."</div>";
									}
				?>						
									<div class='unit trimText'>{{{<ifdef code="ca_entities.biography.biography_text"><H6>Biography</H6>^ca_entities.biography.biography_text<br/></ifdef>}}}</div>
				<?php
									$va_books_by_rels = array();
									if ($va_related_books = $t_item->get('ca_objects', array('excludeRelationshipTypes' => array('reader'), 'restrictToTypes' => array('bib'),'returnAsArray' => true))) {
										print "<div class='unit'>";
										foreach ($va_related_books as $va_key => $va_related_book) {
											$va_books_by_rels[$va_related_book['relationship_typename']][$va_related_book['object_id']] = $va_related_book['label'];
										}
										$va_book_links = array();
										foreach ($va_books_by_rels as $va_role => $va_book) {
											print "<h6>".ucwords($va_role)." of</h6>";
											foreach ($va_book as $va_book_id => $va_title) {
												print caNavLink($this->request, $va_title, '', '', 'Detail', 'objects/'.$va_book_id)."<br/><br/>";
											}
										}
										print "</div>";
									}

									$va_people_by_rels = array();
									if ($va_related_people = $t_item->get('ca_entities', array('returnAsArray' => true))) {
										print "<div class='unit'><H6>Related People</H6>";
										foreach ($va_related_people as $va_key => $va_related_person) {
											$va_people_by_rels[$va_related_person['relationship_typename']][$va_related_person['entity_id']] = $va_related_person['label'];
										}
										$va_people_links = array();
										foreach ($va_people_by_rels as $va_role => $va_person) {
											print ucwords($va_role).": ";
											foreach ($va_person as $va_entity_id => $va_name) {
												$va_people_links[] = caNavLink($this->request, $va_name, '', '', 'Detail', 'entities/'.$va_entity_id);
											}
											print join(', ', $va_people_links)."<br/>";
										}
										print "</div>";
									}

									if ($t_item->get('ca_entities.resources_link.resources_link_url') && $t_item->get('ca_entities.resources_link.resources_link_description')) {
										print "<br/><div class='unit'><span class='metaTitle'>External Resource: </span>";
										print "<a href='".$t_item->get('ca_entities.resources_link.resources_link_url')."'>".$t_item->get('ca_entities.resources_link.resources_link_description')."</a>";
										print "</div>";
									} elseif ($t_item->get('ca_entities.resources_link.resources_link_url')) {
										print "<br/><div class='unit'><span class='metaTitle'>External Resource: </span>";
										print "<a href='".$t_item->get('ca_entities.resources_link.resources_link_url')."'>".$t_item->get('ca_entities.resources_link.resources_link_url')."</a>";
										print "</div>";					
									}
									if ($va_documents = $t_item->get('ca_objects.preferred_labels', array('restrictToTypes' => array('document'), 'returnAsLink' => true))) {
										print "<div class='unit'><h6>Related Documents</h6>";
										print $va_documents;
										print "</div>";
									}
									if ($va_catalog = $t_item->get('ca_objects.preferred_labels', array('restrictToTypes' => array('catalog'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
										print "<div class='unit'><h6>Related Catalog</h6>".$va_catalog."</div>";
									}
									$va_opac_by_type = array();
									if ($vs_nysl_links = $t_item->get('ca_entities.entity_opac', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))){
						
										foreach ($vs_nysl_links as $va_atr_id => $va_nysl_link) {
											$va_opac_by_type[$va_nysl_link['entity_opac_type']][] = $va_nysl_link['entity_opac_URL'];
										}
										if ($va_nysl_link['entity_opac_URL']) {print "<h6>Explore the library catalog</h6>";}
										foreach ($va_opac_by_type as $va_type => $va_opac_link) {
											foreach ($va_opac_link as $va_key => $va_link) {
												if ($va_type == 'author') {
													print "<a href='".$va_link."'>View books by ".$t_item->get('ca_entities.preferred_labels')." in the Library catalog</a><br/>";
												}
												if ($va_type == 'subject') {
													print "<a href='".$va_link."'>View books about ".$t_item->get('ca_entities.preferred_labels')." in the Library catalog</a><br/>";
												}
											}							
										}
									}					
									if ($t_item->get('ca_entities.references.references_list')) {
										$va_references = $t_item->get('ca_entities.references', array('delimiter' => '<br/>', 'convertCodesToDisplayText' => true, 'template' => '^references_list page ^references_page'));
										print "<div class='unit'><h6>References</h6>".$va_references."</div>";
									}																				
				?>	
									{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
									{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
									{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}						
							
								</div><!-- end col -->
								<div class='col-md-6 col-lg-6'>

									<div id="detailTools">
										<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
										<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
										<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
									</div><!-- end detailTools -->
									
									{{{map}}}
				<?php
									if ($t_item->get('ca_entities.ind_georeference.city')) {
										$va_locations = $t_item->get('ca_entities.ind_georeference', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
										print "<div class='unit'><h6>Locations</h6>";
											foreach ($va_locations as $va_key => $va_location) {
												if ($va_location['address_dates'] || $va_location['address_types']) {
													print $va_location['address_types']." ".$va_location['address_dates']."<br/>";
												}
												if ($va_location['address1']) {
													print $va_location['address1']."<br/>";
												}
												if ($va_location['city'] || $va_location['stateprovince'] || $va_location['country']) {
													print $va_location['city']." ".$va_location['stateprovince']." ".$va_location['country']."<br/>";
												}
												if ($va_location['address_references']) {
													print "Source: ".$va_location['address_references']."<br/>";
												}
												if ($va_location['ind_address_notes']) {
													print $va_location['ind_address_notes'];
												}
												print "<br/>";																																
											}
										print "</div>";
									}
									if ($va_buildings = $t_item->get('ca_occurrences.preferred_labels', array('restrictToTypes' => array('building'), 'returnAsLink' => true, 'delimiter' => '<br/>'))) {
										print "<div class='unit'><h6>Related Building</h6>".$va_buildings."</div>";
									}						
				?>				
								</div><!-- end col -->
							</div><!-- end row -->
							<hr/ style='margin-left:-15px; margin-right:-15px;'>
				{{{<ifcount code="ca_objects" min="1">
							<div class="row titleBar">
								<div class='col-sm-3 col-md-3 col-lg-3'>
									Full Title
								</div>
								<div class='col-sm-2 col-md-2 col-lg-2'>
									Volume
								</div>
								<div class='col-sm-2 col-md-2 col-lg-2'>
									Date Out
								</div>
								<div class='col-sm-2 col-md-2 col-lg-2'>
									Date In
								</div>	
								<div class='col-sm-1 col-md-1 col-lg-1'>
									Fine
								</div>		
								<div class='col-sm-2 col-md-2 col-lg-2'>
									Ledger
								</div>
							</div><!-- end row -->
				</ifcount>}}}
									<?php 
										//print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); 
						
							$va_rel_ids = $t_item->get('ca_objects_x_entities.relation_id', array('returnAsArray' => true));
							$qr_rels = caMakeSearchResult('ca_objects_x_entities', $va_rel_ids, array('sort' => 'ca_objects_x_entities.date_out'));
			
							// set all of the page object_ids
							$va_page_ids = array();
							$va_result_count = $qr_rels->numHits();
							if ($va_result_count > 0) {			
								while($qr_rels->nextHit()) {
									$va_page_ids[] = $qr_rels->get("ca_objects_x_entities.see_original_link", array('idsOnly' => 1));
								}
			
								$qr_pages = caMakeSearchResult('ca_objects', $va_page_ids);
			
								$va_parents = array();
								while($qr_pages->nextHit()) {
									$va_parents[$qr_pages->get('ca_objects.object_id')] = $qr_pages->get('ca_objects.parent.preferred_labels.name');
								}
			
								$qr_rels->seek(0);	// reset the result to the beginning so we can run through it again
			
								$vn_page_type_id = caGetListItemID('object_types', 'page');
								$vn_i = 0;
								while($qr_rels->nextHit()) {
									if ($qr_rels->get('ca_objects.type_id') == $vn_page_type_id) { continue; }
									print "<div class='row ledgerRow'>";
										print "<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3  bookTitle' id='book".$vn_i."'>";
											if ($qr_rels->get("ca_objects.parent.preferred_labels")) {
												$va_label_trunk = explode(':', $qr_rels->get("ca_objects.parent.preferred_labels"));
												print caNavLink($this->request, $va_label_trunk[0], '', '', 'Detail', 'objects/'.$qr_rels->get("ca_objects.parent.object_id"));
											} else {
												$va_label_trunk = explode(':', $qr_rels->get("ca_objects.preferred_labels"));
												print caNavLink($this->request, $va_label_trunk[0], '', '', 'Detail', 'objects/'.$qr_rels->get("ca_objects.object_id"));
											}
						
											$va_book_info = array();
											if ($va_author = $qr_rels->getWithTemplate('<unit relativeTo="ca_objects" ><unit relativeTo="ca_entities" restrictToRelationshipTypes="author">^ca_entities.preferred_labels</unit></unit>')) {
												$va_book_info[] = $va_author;
											} else {$va_author = null;}
											if ($va_publication_date = $qr_rels->get("ca_objects.publication_date")) {
												$va_book_info[] = $va_publication_date;
											} else { $va_publication_date = null; }
											if ($va_publisher = $qr_rels->get("ca_objects.publisher")) {
												$va_book_info[] = $va_publisher;
											} else { $va_publisher = null; }
											TooltipManager::add('#book'.$vn_i, $qr_rels->get('ca_objects.parent.preferred_labels.name')." ".$qr_rels->get('ca_objects.preferred_labels.name')."<br/>".join('<br/>', $va_book_info)); 						
				
										print "</div>";
			
										print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
										if ($qr_rels->get("ca_objects.parent.preferred_labels")) {
											print $qr_rels->get("ca_objects.preferred_labels", array('returnAsLink' => true));
										}
										print "</div>";	
					
										print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
										print $qr_rels->get("ca_objects_x_entities.date_out");
										print "</div>";

										print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
										print $qr_rels->get("ca_objects_x_entities.date_in");
										print "</div>";
											
										print "<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>";
										print $qr_rels->get("ca_objects_x_entities.fine");
										print "</div>";
					
										print "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
										print $va_parents[$qr_rels->get("ca_objects_x_entities.see_original_link", array('idsOnly' => true))]." ".$qr_rels->get("ca_objects_x_entities.see_original_link", array('returnAsLink' => true));
										print "</div>";													
									print "</div>";
				
									$vn_i++;
								}
							}		
									?>
							<script type="text/javascript">
				//				jQuery(document).ready(function() {
				//					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
				//						jQuery('#browseResultsContainer').jscroll({
				//							autoTrigger: true,
				//							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
				//							padding: 20,
				//							nextSelector: 'a.jscroll-next'
				//						});
				//					});					
				//				});
							</script>
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
		  maxHeight: 135
		});
	});
</script>
