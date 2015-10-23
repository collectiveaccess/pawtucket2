<?php
	Timer::start('page');
	Timer::disable('page');
	$t_item 		= $this->getVar("item");
	$va_comments 	= $this->getVar("comments");
	$vs_type 		= caNavLink($this->request, 'People & Organizations', '', '', 'Browse', 'entities');
	$vs_title 		= caTruncateStringWithEllipsis($t_item->get('ca_entities.preferred_labels.displayname'), 40);	
	$vs_home 		= caNavLink($this->request, "City Readers", '', '', '', '');
	
	$vn_entity_id = $t_item->getPrimaryKey();

	
	MetaTagManager::setWindowTitle($vs_home." > ".$vs_type." > ".$vs_title);

	# Wikipedia Info
	if ($t_item->get("ca_entities.wikipedia_entry.image_thumbnail")) {
		$vs_wiki_thumb = "<img src='".$t_item->get("ca_entities.wikipedia_entry.image_thumbnail")."'/>";
	}
	if ($t_item->get("ca_entities.wikipedia_entry.extract")) {
		$vs_wiki_bio = $t_item->get("ca_entities.wikipedia_entry.abstract");
		$vs_wiki_bio = explode('<h2>', $vs_wiki_bio);
		$vs_wiki_bio = $vs_wiki_bio[0];
	}
	if ($t_item->get("ca_entities.wikipedia_entry.fullurl")) {	
		$vs_wiki_link = "<a href='".$t_item->get("ca_entities.wikipedia_entry.fullurl")."' target='_blank'>read this on wikipedia.org</a>";
	}
	
	# Circulation History
	$vs_first_date = null;
	$vs_buf = "";
	$va_rel_ids = $t_item->get('ca_objects_x_entities.relation_id', array('returnAsArray' => true, 'restrictToRelationshipTypes' => array('reader')));
	
	$qr_rels = caMakeSearchResult('ca_objects_x_entities', $va_rel_ids, array('sort' => 'ca_objects_x_entities.date_out'));
	
	$va_non_read_books = $t_item->get('ca_objects.object_id', array('restrictToTypes' => array('bib', 'volume'), 'excludeRelationshipTypes' => array('reader'), 'returnAsArray' => true));
	// set all of the page object_ids
	$va_page_ids = array();
	if ($qr_rels > 0) {
		$vn_result_count = $qr_rels->numHits();	
	
		$qr_rels->setOption('prefetch', 500);		
		while($qr_rels->nextHit()) {
			$va_page_ids[] = $qr_rels->get("ca_objects_x_entities.see_original_link", array('idsOnly' => 1));
		}

		$qr_pages = caMakeSearchResult('ca_objects', $va_page_ids);

		$va_parents = array();
		while($qr_pages->nextHit()) {
			$va_parents[$qr_pages->get('ca_objects.object_id')] = $qr_pages->get('ca_objects.parent.preferred_labels.name');
		}

		$qr_rels->seek(0);	// reset the result to the beginning so we can run through it again

		$vn_bib_type_id = caGetListItemID('object_types', 'bib');
		$vn_volume_type_id = caGetListItemID('object_types', 'volume');
		$vn_i = 0;
		$vb_has_circulation = false;
		
		$qr_rels->setOption('prefetchAttributes', ['see_original_link', 'see_original', 'date_in', 'date_out', 'book_title', 'representative', 'fine']); 
		$qr_rels->setOption('prefetch', 1000);
		
		
		while($qr_rels->nextHit()) {
			$vn_type_id = $qr_rels->get('ca_objects.type_id');
			if (($vn_type_id != $vn_bib_type_id)&&($vn_type_id != $vn_volume_type_id)) { continue; }
			if (in_array($vn_object_id = $qr_rels->get('ca_objects.object_id'), $va_non_read_books)) { continue; }
			
			$va_current_title = array_shift($qr_rels->get("ca_objects.preferred_labels", ['returnAsArray' => true, 'assumeDisplayField' => false]));
			$vs_current_title = $va_current_title['name'];
			
			$va_parent_title = array_shift($qr_rels->get("ca_objects.parent.preferred_labels", ['returnAsArray' => true, 'assumeDisplayField' => false]));
			$vs_parent_title = $va_parent_title['name'];
			
			$vs_see_original_link = $qr_rels->get("ca_objects_x_entities.see_original_link", array('idsOnly' => true));
			
			$vs_buf.= "<tr class='ledgerRow'>";
				$vs_buf.= "<td id='book".$vn_i."' style='max-width:200px;'>";
				$vs_buf.= "<div class='bookTitle'>";
					
				if ($vs_parent_title) {
					$va_label_trunk = explode(':', $vs_parent_title);
					$vs_buf.= caNavLink($this->request, $va_label_trunk[0], '', '', 'Detail', 'objects/'.$qr_rels->get("ca_objects.parent.object_id"));
					$vs_sort_title = $va_parent_title['name_sort'];
				} else {
					$va_label_trunk = explode(':', $vs_current_title);
					$vs_buf.= caNavLink($this->request, $va_label_trunk[0], '', '', 'Detail', 'objects/'.$vn_object_id);
					$vs_sort_title = $va_current_title['name_sort'];
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
				

				$vs_buf.= "</div>";

				$vs_buf.= "Transcribed: ".$qr_rels->get("ca_objects_x_entities.book_title");
				if ($qr_rels->get("ca_objects_x_entities.see_original", array('convertCodesToDisplayText' => true)) == "Yes"){
					$vs_buf.= "&nbsp;".caNavLink($this->request, "<i class='fa fa-exclamation-triangle'></i>", '', '', 'Detail', 'objects/'.$vs_see_original_link);
					TooltipManager::add('.fa-exclamation-triangle', "Uncertain transcription. See scanned image."); 						
				}
				
				$vs_buf.= "<span title='".addslashes($vs_sort_title)."'></span>";
				$vs_buf.= "</td>";
				
				
				$vs_name = '';
				if ($va_parent_title) {
					$vs_name = $qr_rels->getWithTemplate('<unit relativeTo="ca_objects.parent"><unit relativeTo="ca_entities" restrictToRelationshipTypes="author"><span title="^ca_entities.preferred_labels.surname, ^ca_entities.preferred_labels.forename"></span>^ca_entities.preferred_labels.displayname</unit></unit>');
				} else {
					$vs_name = $qr_rels->getWithTemplate('<unit relativeTo="ca_objects"><unit relativeTo="ca_entities" restrictToRelationshipTypes="author"><span title="^ca_entities.preferred_labels.surname, ^ca_entities.preferred_labels.forename"></span>^ca_entities.preferred_labels.displayname</unit></unit>');
				}
				if (!$vs_name) { $vs_name = "<span title=''></span>"; }
				
				$vs_buf.= "<td>{$vs_name}</td>";
					
				$vs_buf.= "<td>";
				if ($va_parent_title) {
					$vs_buf.= $vs_current_title;
				}
				$vs_buf.= "</td>";	

				$vs_buf.= "<td>";
				$vs_buf.= ($vs_date_out = $qr_rels->get("ca_objects_x_entities.date_out"));
				if (is_null($vs_first_date)) {
					$vs_first_date = $vs_date_out;
				}
				$vs_buf.= "</td>";

				$vs_buf.= "<td>";
				$vs_buf.= ($vs_date_in = $qr_rels->get("ca_objects_x_entities.date_in"));
				
				$vs_last_date = $vs_date_in ? $vs_date_in : $vs_date_out;
				$vs_buf.= "</td>";
				
				$vs_buf.= "<td>";
				$vs_buf.= $qr_rels->get("ca_objects_x_entities.representative");
				$vs_buf.= "</td>";
									
				$vs_buf.= "<td>";
				$vs_buf.= $qr_rels->get("ca_objects_x_entities.fine");
				$vs_buf.= "</td>";

				$vs_buf.= "<td>";
				$vs_buf.= caNavLink($this->request, '<i class="fa fa-file-text"></i>', '', '', 'Detail', 'objects/'.$vs_see_original_link);								
				$vs_buf.= "</td>";													
			$vs_buf.= "</tr>";

			$vn_i++;
			$vb_has_circulation = true;
		}
	}	
?>
<div class="page">
	<div class="wrapper">
		<div class="sidebar">
<?php	
			if ($this->getVar('representationViewer')) {			
				print $this->getVar('representationViewer');
				print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-xs-3 col-sm-3 col-md-3 col-xs-4"));
			} else {
				print "<div class='entityThumb'><a href='".$t_item->get("ca_entities.wikipedia_entry.image_viewer_url")."' target='_blank'>".$vs_wiki_thumb."</a></div>";
			}
			if ($va_occupations = $t_item->get('ca_entities.industry_occupations', array('returnAsArray' => true, 'convertCodesToDisplayText' => false))) {
				$va_as_text = $t_item->get('ca_entities.industry_occupations', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
				$va_occupations_list = array();
				foreach ($va_occupations as $vn_x => $vn_occupation_id) {
					if (($vn_occupation_id == 551) | ($vn_occupation_id == 0)){continue;}
					$va_occupations_list[] = caNavLink($this->request, ucfirst($va_as_text[$vn_x]), '', '', 'Browse', 'entities/facet/occupation_facet/id/'.$vn_occupation_id)."</a>";
				}
				if (sizeof($va_occupations_list) > 0) {
					print "<H6>Occupation</H6>";
					print "<div>";
					print join('<br/>', $va_occupations_list);
					print "</div>";
				}
			}
			if ($va_countries = $t_item->get('ca_entities.country_origin', array('returnWithStructure' => true, 'convertCodesToDisplayText' => false))) {
				$va_country_as_text = $t_item->get('ca_entities.country_origin', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true));
				$va_countries_list = array();
				foreach ($va_countries as $vn_x => $vn_country_id) {
					foreach ($vn_country_id as $va_key => $va_country_next) {
						if ($va_country_next['country_origin'] == 746){continue;}
						$va_countries_list[] = caNavLink($this->request, ucfirst($va_country_as_text[$va_key]['country_origin']), '', '', 'Browse', 'entities/facet/country_facet/id/'.$va_country_next['country_origin'])."</a>";
					}
				}
				if (sizeof($va_countries_list) > 1) {
					print "<H6>Country of Origin</H6>";
					print "<div>";
					print join(', ', $va_countries_list);
					print "</div>";
				}
			}				
			if ($va_gender = $t_item->get('ca_entities.gender')) {
				print "<H6>Gender</H6>";
				print "<div>".caNavLink($this->request, $t_item->get('ca_entities.gender', array('convertCodesToDisplayText' => true)), '', '', 'Browse', 'entities/facet/gender_facet/id/'.$t_item->get('ca_entities.gender'))."</a></div>";
			}		
#			$va_ledgers_by_parent = array();
#			if ($va_related_pages = $t_item->get('ca_objects', array('returnWithStructure' => true, 'restrictToTypes' => array('page')))) {
#				print "<div class='unit'><H6>Ledgers</H6>";
#
#				foreach ($va_related_pages as $va_key => $va_related_page) {
#					$t_page = new ca_objects($va_related_page['object_id']);
#					$va_parent_name = $t_page->get('ca_objects.parent.preferred_labels');
#					$va_ledgers_by_parent[$va_parent_name][$va_related_page['object_id']] = caNavLink($this->request, $t_page->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$t_page->get('ca_objects.object_id'));
#				}
#				$va_people_links = array();
#				$vn_i = 0;
#				foreach ($va_ledgers_by_parent as $va_parent => $va_page) {
#					print "<div>";
#						print "<a href='#' style='display:none;' class='closeLink".$vn_i."' onclick='$(\"#ent".$vn_i."\").slideUp();$(\".closeLink".$vn_i."\").hide();$(\".openLink".$vn_i."\").show();return false;'>".ucwords($va_parent)."<i class='fa fa-angle-up'></i></a>";
#						print "<a href='#'  class='openLink".$vn_i."' onclick='$(\"#ent".$vn_i."\").slideDown();$(\".openLink".$vn_i."\").hide();$(\".closeLink".$vn_i."\").show();return false;'>".ucwords($va_parent)."<i class='fa fa-angle-down'></i></a>";						
#						print "<div id='ent".$vn_i."' style='padding-left:10px; display:none;'>";
#							print join('<br/>', $va_page)."<br/>";
#						print "</div>";
#					print "</div>";
#					$vn_i++;
#				}
#				print "</div>";
#			}	
			$vs_sidebar_buf = "";
			$va_opac_by_type = array();
			if ($vs_nysl_links = $t_item->get('ca_entities.entity_opac', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))){
				foreach ($vs_nysl_links as $va_atr_id => $va_nysl_link_n) {
					foreach ($va_nysl_link_n as $va_id => $va_nysl_link) {
						$va_opac_by_type[$va_nysl_link['entity_opac_type']][] = $va_nysl_link['entity_opac_URL'];
					}
				}
				#if ($va_nysl_link['entity_opac_URL']) {$vs_sidebar_buf.= "<h6>Connect to the New York Society Library Catalog</h6>";}
				foreach ($va_opac_by_type as $vs_type => $va_opac_link) {
					foreach ($va_opac_link as $va_key => $va_link) {
						if ($vs_type == 'author') {
							$vs_sidebar_buf.= "<p><a href='".$va_link."' target='_blank'>Books by ".$t_item->get('ca_entities.preferred_labels')."</a></p>";
						}
						if ($vs_type == 'subject') {
							$vs_sidebar_buf.= "<p><a href='".$va_link."' target='_blank'>Books about ".$t_item->get('ca_entities.preferred_labels')."</a></p>";
						}
					}							
				}
			}


			if ($va_collections_list = $t_item->get('ca_collections.hierarchy.collection_id', array('maxLevelsFromTop' => 1, 'returnAsArray' => true))) {
				$va_collections_for_display = array_unique(caProcessTemplateForIDs("<l>^ca_collections.preferred_labels.name</l>", "ca_collections", caFlattenArray($va_collections_list, array('unique' => true)), array('returnAsArray' => true)));
				
				$vs_sidebar_buf .= join("<br/>\n", $va_collections_for_display);
			}	
			if ($vs_sidebar_buf) {
				print "<h6 style='margin-top:20px;'>In The Library</h6>	";	
				print $vs_sidebar_buf;
			}
			$vs_learn_even = null;
			if ($va_resource_links = $t_item->get('ca_entities.resources_link', array('returnWithStructure' => true))) {
				$va_link_list = array();
				foreach ($va_resource_links as $va_key => $va_resource_link_t) {
					foreach ($va_resource_link_t as $va_key2 => $va_resource_link) {
						if ($va_resource_link['resources_link_description']) {
							$va_link_list[]= "<a href='".$va_resource_link['resources_link_url']."' target='_blank'>".$va_resource_link['resources_link_description']."</a>";
						} elseif ($va_resource_link['resources_link_url']) {
							$va_link_list[]= "<a href='".$va_resource_link['resources_link_url']."' target='_blank'>".$va_resource_link['resources_link_url']."</a>";
						}
					}
				}
				if (sizeof($va_link_list) > 0) {
					$vs_learn_even.= "<div class='unit'>";
					$vs_learn_even.= join('<br/>', $va_link_list);
					$vs_learn_even.= "</div>";
				}
			}	
			if ($t_item->get("ca_entities.wikipedia_entry.fullurl")) {
				$vs_learn_even.= "<a href='".$t_item->get("ca_entities.wikipedia_entry.fullurl")."' target='_blank'>Wikipedia</a><br/>";
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
						
							<div class="row">
								<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6'>
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
								<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6'>
								</div>
							</div>
							<div class='row'>		
								<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>	
									<H4>
										{{{^ca_entities.preferred_labels.displayname}}}
<?php
										if ($va_life_dates = $t_item->get('ca_entities.life_dates', array('format' => 'Y - Y'))) {
											print "<small>(".$va_life_dates.")</small>";
										}
										if ($va_org_dates = $t_item->get('ca_entities.org_dates', array('rawDate' => true, 'returnAsArray' => true))) {
											foreach ($va_org_dates as $va_key => $va_org_date) {
												$va_start_date = explode('.',$va_org_date['start']);
												$va_end_date = explode('.',$va_end_date['end']);
											}
											if (($va_start_date[0]) && ($va_end_date[0] < date('Y'))){
												print "<small>(Active ".$va_start_date[0]." - ".$va_end_date[0].")</small>";
											} elseif ($va_start_date[0]) {
												print "<small>(Founded ".$va_start_date[0].")</small>";
											}
										}										
?>									
									</H4>
									
									<div class='unit'>{{{<ifdef code="ca_entities.nonpreferred_labels">Also Known As: <unit delimiter='; '>^ca_entities.nonpreferred_labels.displayname</unit></ifdef>}}}</div>
								</div><!-- end col -->
							</div><!-- end row -->
							<div class="row">			
								<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6'>
								
				<?php
									if ($vs_first_date && $vs_last_date) {
										print "<div class='unit'><i>".$t_item->get('ca_entities.relationship_to_library', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))."<br/>Borrowing activity from ".$vs_first_date." to ".$vs_last_date.".</i></div>";
									}
									if (($t_item->get('ca_entities.biography.biography_text')) && (($t_item->get('ca_entities.biography.bio_status', array('convertCodesToDisplayText' => true)) == "Full Completed") | ($t_item->get('ca_entities.biography.bio_status', array('convertCodesToDisplayText' => true)) == "Brief Completed"))) {
										print "<div class='unit trimText biography'>".$t_item->get('ca_entities.biography.biography_text')."</div>";
									} else {
										print "<div class='wikipedia'><div class='unit biography trimText'>".$vs_wiki_bio."</div><div>".$vs_wiki_link."</div></div>";
									}
									if ($t_item->get('ca_entities.status', array('convertCodesToDisplayText' => true)) == 'new') {
										print "<div class='incomplete'><i class='fa fa-sticky-note'></i> <i>Metadata for this record is currently incomplete. Click Contribute to submit information for inclusion on this page. See the ".caNavLink($this->request, 'User Guide', '', '', 'About', 'userguide')." to learn more about Contributing.</i></div>";
									}
									if ($t_item->get('ca_entities.references.references_list')) {
										$va_references = $t_item->get('ca_entities.references', array('delimiter' => '<br/><br/>', 'convertCodesToDisplayText' => true, 'template' => '<p style="padding-left:15px;">^ca_entities.references.references_list page ^ca_entities.references.references_page</p>'));
										print "<div class='unit'>";
										print "<a href='#' class='openRef' onclick='$(\"#references\").slideDown(); $(\".openRef\").hide(); $(\".closeRef\").show(); return false;'><h6><i class='fa fa-pencil-square-o'></i>&nbsp;Works Cited</h6></a>";
										print "<a href='#' class='closeRef' style='display:none;' onclick='$(\"#references\").slideUp(); $(\".closeRef\").hide(); $(\".openRef\").show(); return false;'><h6><i class='fa fa-pencil-square-o'></i>&nbsp;Works Cited</h6></a>";
										print "<div id='references' style='display:none;'>".$va_references."</div></div>";
									}																																																	
?>	
									<div id="detailTools">
										<!-- AddThis Button BEGIN -->
										<div class="detailTool"><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><span class="glyphicon glyphicon-share-alt"></span> Share</a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script></div><!-- end detailTool -->
										<!-- AddThis Button END -->
										<div class="detailTool"><span class="glyphicon glyphicon-send"></span><a href='mailto:ledger@nysoclib.org?subject=CR%20User%20Contribution:%20<?php print $t_item->get('ca_entities.idno'); ?>&body='>Contribute</a></div><!-- end detailTool -->
										<!-- <div class="detailTool"><a href='#detailComments' onclick='jQuery("#detailComments").slideToggle();return false;'><span class="glyphicon glyphicon-comment"></span>Comment <?php print (sizeof($va_comments) > 0 ? sizeof($va_comments) : ""); ?></a></div> -->
									</div><!-- end detailTools -->							
								</div><!-- end col -->
<?php
								if ($vb_has_circulation == false) {
									$va_class = "hideme";
								} else {
									$va_class = "";
								}
?>
								<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 <?php print $va_class; ?>' style='border-left:1px solid #ddd; margin-top:-30px;'>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<!-- open/close -->
											<div class="overlay overlay-corner">
												<div ><!--Circulation Activity for <?php print $t_item->get('ca_entities.preferred_labels'); ?>-->
													<button type="button" class="overlay-close"><i class="fa fa-times"></i></button>
												</div>
												
												<div style="width:60%; height:400px; float:left; padding-right:10px;">
													
													<div id="stat_entity_checkout_distribution2" class="ct-chart ct-golden-section"> 
													<div class="ct-key"><span class="ct-series-a-key"><i class="fa fa-square"></i> <span class='blacktext'><?php print $t_item->get('ca_entities.preferred_labels'); ?></span></span> <span class="ct-series-b-key average"><i class="fa fa-square"></i> <span class='blacktext'>Library Average</span></span></div>
													</div>
												</div>
												<div class='circles' style="width:40%; height:500px; float:left; border-left:1px solid #ddd; padding-left:20px;">
													<div style="width:80%; ">
														<div class='vizName'>Books by subject area 
															<div class='catalogInfo'>As classified in the <?php print caNavLink($this->request, "1838 Library Catalog.", '', '', 'Detail', 'objects/11555');?></div>
														</div>
														<div id="stat_bib_books_by_subject_area2" class="ct-chart ct-golden-section"></div>
													</div>	
													<hr style='margin-top:20px;'>						
													<div style="width:80%; ">
														<div class="vizName">Check out duration
															<div class='catalogInfo'></div>
														</div> 
														<div id="stat_entity_checkout_durations2" class="ct-chart ct-golden-section"></div>
													</div>	
												</div>																				
											</div>										
	<?php	
									$stat_entity_checkout_distribution = CompositeCache::fetch('stat_entity_checkout_distribution', 'vizData');
									$stat_avg_entity_checkout_distribution = CompositeCache::fetch('stat_avg_entity_checkout_distribution', 'vizData');
									if($stat_entity_checkout_distribution) {
	?>

									<div class='vizTitle'>Circulation Activity <button id="trigger-overlay" type="button"><i class="fa fa-external-link"></i></button></div>
			
									<div id="stat_entity_checkout_distribution" class="ct-chart ct-golden-section"></div> 
									<div class="ct-key entityCirculation"><span class="ct-series-a-key"><i class="fa fa-square"></i> <span class='blacktext'><?php print $t_item->get('ca_entities.preferred_labels'); ?></span></span> <span class="ct-series-b-key average"><i class="fa fa-square"></i> <span class='blacktext'>Library Average</span></span></div>
									<script type="text/javascript">
										var dataForCirculationActivity = {
										  labels: <?php print json_encode(array_keys($stat_entity_checkout_distribution[$vn_entity_id])); ?>,
										  series: [
													<?php print json_encode(array_values($stat_entity_checkout_distribution[$vn_entity_id])); ?>,
													<?php print json_encode(array_values($stat_avg_entity_checkout_distribution)); ?>
												]
										};
							
										var options = {
											fullWidth: true,
											// As this is axis specific we need to tell Chartist to use whole numbers only on the concerned axis
											axisY: {
												onlyInteger: true,
												offset: 20
											},
											axisY: {
												onlyInteger: true,
												offset: 20
											},
				
										};
							
										var responsiveOptions = [
										  ['screen and (min-width: 640px)', {
											chartPadding: 20,
											labelOffset: 30,
											labelDirection: 'explode'
										  }],
										  ['screen and (min-width: 1024px)', {
											labelOffset: 30,
											chartPadding: 20
										  }]
										];

										new Chartist.Line('#stat_entity_checkout_distribution', dataForCirculationActivity, options, responsiveOptions);
										new Chartist.Line('#stat_entity_checkout_distribution2', dataForCirculationActivity, options, responsiveOptions);
									</script>

	<?php
									}
	?>		
										</div><!-- end-col -->
									</div><!-- end row -->	
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 expand " style="margin-top:-20px;padding-bottom:15px;border-bottom:1px solid #ccc;">
											<section>
<?php											
												print '<p ><div class="button">'.caNavLink($this->request, '<i class="fa fa-plus"></i> Compare Readers', '', '', 'Circulation', 'readers', ['id' => $t_item->getPrimaryKey()]).'</div></p>';
?>											
											</section>
										</div>
									</div>
									<div class="row">	
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
<?php
									$stat_bib_books_by_subject_area = CompositeCache::fetch('stat_bib_books_by_subject_area', 'vizData');

									$vn_entity_id = $t_item->getPrimaryKey();
									if ($stat_bib_books_by_subject_area[$vn_entity_id]) {
?>
										<div class='vizName'>Books by subject area 
											<!--<div class='catalogInfo'><i class='fa fa-info-circle'></i> As classified in the <?php print caNavLink($this->request, "1838 Library Catalog.", '', '', 'Detail', 'objects/11555');?></div>-->
										</div>
										<div id="stat_bib_books_by_subject_area" class="ct-chart ct-square"></div>
										<script type="text/javascript">
											var dataForSubjectAreas = {
											  labels: <?php print json_encode(array_keys($stat_bib_books_by_subject_area[$vn_entity_id])); ?>,
											  series: <?php print json_encode(array_values($stat_bib_books_by_subject_area[$vn_entity_id])); ?>
											};

											var options = {
												labelInterpolationFnc: function(value, index) {
												  if(dataForSubjectAreas.series[index] <= 1) { return ''; }
												  return value;
												}
											};
											var $chart = $('#stat_bib_books_by_subject_area2');

											var $subjectAreaToolTip = $chart
											  .append('<div class="tooltip"></div>')
											  .find('.tooltip')
											  .hide();

											$chart.on('mouseenter', '.ct-series', function() {
												var $slice = $(this),
												value = $slice.find('path').attr('ct:value');
												var l = $slice.attr("class").replace("ct-series ct-series-", "").charCodeAt(0) - 97;
												
												sliceName = dataForSubjectAreas.labels[l] + " (" + value + ")";		// $slice.find('text.ct-label').text()
												$subjectAreaToolTip.html(sliceName).show();
											});

											$chart.on('mouseleave', '.ct-series', function() {
											  $subjectAreaToolTip.hide();
											});

											$chart.on('mousemove', function(event) {
											  $subjectAreaToolTip.css({
												left: (event.offsetX || event.originalEvent.layerX) - $subjectAreaToolTip.width() / 2 - 10,
												top: (event.offsetY || event.originalEvent.layerY) - $subjectAreaToolTip.height() - 40
											  });
											});
											var responsiveOptions = [
											  ['screen and (min-width: 640px)', {
												chartPadding: 30,
												labelOffset: 30,
												labelDirection: 'explode'
											  }],
											  ['screen and (min-width: 1024px)', {
												labelOffset: 60,
												chartPadding: 20
											  }]
											];

											new Chartist.Pie('#stat_bib_books_by_subject_area', dataForSubjectAreas, options, responsiveOptions);
											new Chartist.Pie('#stat_bib_books_by_subject_area2', dataForSubjectAreas, options, responsiveOptions);

										</script>	
										<!-- Chartist -->
<?php
									}
?>										
										</div><!-- end col-->
										<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
<?php
										$stat_entity_checkout_durations = CompositeCache::fetch('stat_entity_checkout_durations', 'vizData');

										if ($stat_entity_checkout_durations[$vn_entity_id]) {
?>
										<div class="vizName">Check out duration</div> 
										<div id="stat_entity_checkout_durations" class="ct-chart ct-square"></div>
										<script type="text/javascript">
											var dataForCheckoutDuration = {
											  labels: <?php print json_encode(array_keys($stat_entity_checkout_durations[$vn_entity_id])); ?>,
											  series: <?php print json_encode(array_values($stat_entity_checkout_durations[$vn_entity_id])); ?>
											};

											var options = {
												labelInterpolationFnc: function(value, index) {
												  if(dataForCheckoutDuration.series[index] <= 5) { return ''; }
												  return value;
												}
											};
											
											var $chart = $('#stat_entity_checkout_durations2');

											var $durationToolTip = $chart
											  .append('<div class="tooltip"></div>')
											  .find('.tooltip')
											  .hide();

											$chart.on('mouseenter', '.ct-series', function() {
												var $slice = $(this),
												value = $slice.find('path').attr('ct:value');
												var l = $slice.attr("class").replace("ct-series ct-series-", "").charCodeAt(0) - 97;
												sliceName = dataForCheckoutDuration.labels[l] + " (" + value + ")";		// $slice.find('text.ct-label').text()
												$durationToolTip.html(sliceName).show();
											});

											$chart.on('mouseleave', '.ct-series', function() {
											  $durationToolTip.hide();
											});

											$chart.on('mousemove', function(event) {
											  $durationToolTip.css({
												left: (event.offsetX || event.originalEvent.layerX) - $durationToolTip.width() / 2 - 10,
												top: (event.offsetY || event.originalEvent.layerY) - $durationToolTip.height() - 40
											  });
											});
											var responsiveOptions = [
											  ['screen and (min-width: 640px)', {
												chartPadding: 30,
												labelOffset: 30,
												labelDirection: 'explode'
											  }],
											  ['screen and (min-width: 1024px)', {
												labelOffset: 60,
												chartPadding: 20
											  }]
											];

											new Chartist.Pie('#stat_entity_checkout_durations', dataForCheckoutDuration, options, responsiveOptions);
											new Chartist.Pie('#stat_entity_checkout_durations2', dataForCheckoutDuration, options, responsiveOptions);

										</script>	
										<!-- Chartist -->
				
									
<?php
										}
?>										
										</div><!-- end col-->
									</div>	<!-- end row -->

																												
									<!--<div class='vizPlaceholder'><i class='fa fa-picture-o'></i></div>-->
									<!--{{{map}}}-->
<?php
									#if ($t_item->get('ca_entities.ind_georeference.city')) {
									#	$va_locations = $t_item->get('ca_entities.ind_georeference', array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
									#	print "<div class='unit'><h6>Locations</h6>";
									#		foreach ($va_locations as $va_key => $va_location) {
									#			if ($va_location['address_dates'] || $va_location['address_types']) {
									#				print $va_location['address_types']." ".$va_location['address_dates']."<br/>";
									#			}
									#			if ($va_location['address1']) {
									#				print $va_location['address1']."<br/>";
									#			}
									#			if ($va_location['city'] || $va_location['stateprovince'] || $va_location['country']) {
									#				print $va_location['city']." ".$va_location['stateprovince']." ".$va_location['country']."<br/>";
									#			}
									#			if ($va_location['address_references']) {
									#				print "Source: ".$va_location['address_references']."<br/>";
									#			}
									#			if ($va_location['ind_address_notes']) {
									#				print $va_location['ind_address_notes'];
									#			}
									#			print "<br/>";																																
									#		}
									#	print "</div>";
									#}
?>															
								</div><!-- end col -->
							</div><!-- end row -->							
						
						
						<div id='entityTable'>
							<ul class='row'>
<?php
								if ($vb_has_circulation == true) {
									print '<li><a href="#circTab">Borrowing History</a></li>';
									$vs_style = "style='display:block;'";												
								} else {
									$vs_style = "style='display:none;'";
								}
								
								// Check entities
								$vs_people_buf = null;
								$va_people_by_rels = array();
								if ($va_related_people = $t_item->get('ca_entities.related', array('returnWithStructure' => true, 'checkAccess'=> $this->getVar('access_values')))) {
									foreach ($va_related_people as $va_key => $va_related_person) {
										if ($vn_entity_id == $va_related_person['entity_id']) { continue; }
										$va_people_by_rels[$va_related_person['relationship_typename']][$va_related_person['entity_id']] = $va_related_person['label'];
									}
									$va_people_links = array();
									foreach ($va_people_by_rels as $va_role => $va_person) {
										$vs_people_buf.= "<div class='row'>";
											$vs_people_buf.= "<a href='#' class='closeLink".$va_role."' onclick='$(\"#ent".$va_role."\").slideUp();$(\".closeLink".$va_role."\").hide();$(\".openLink".$va_role."\").show();return false;'><h6>".ucwords($va_role)."&nbsp;<i class='fa fa-angle-down'></i></h6></a>";
											$vs_people_buf.= "<a href='#' style='display:none;' class='openLink".$va_role."' onclick='$(\"#ent".$va_role."\").slideDown();$(\".openLink".$va_role."\").hide();$(\".closeLink".$va_role."\").show();return false;'><h6>".ucwords($va_role)."&nbsp;<i class='fa fa-angle-up'></i></h6></a>";						
											$vs_people_buf.= "<div id='ent".$va_role."'>";
												foreach ($va_person as $va_entity_id => $va_name) {
													$vs_people_buf.= "<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'><div class='entityButton'>".caNavLink($this->request, $va_name, 'entityName', '', 'Detail', 'entities/'.$va_entity_id)."</div></div>";
												}

											$vs_people_buf.= "</div><!-- end entrole -->";
										$vs_people_buf.= "</div><!-- end row -->";
									}
								}
									
								// Check books	
								$vs_book_buf = null;
								$va_books_by_rels = array();
								if ($va_related_books = $t_item->get('ca_objects', array('excludeRelationshipTypes' => array('reader'), 'restrictToTypes' => array('bib'),'returnWithStructure' => true))) {
									$vs_book_buf.= "<div class='unit row'>";
									foreach ($va_related_books as $va_key => $va_related_book) {
										$va_books_by_rels[$va_related_book['relationship_typename']][$va_related_book['object_id']] = $va_related_book['label'];
									}
									$va_book_links = array();
									foreach ($va_books_by_rels as $va_role => $va_book) {
										$vs_book_buf.= "<div class='container'>";
										$vs_book_buf.= "<div class='row'>";
										$vs_book_buf.= "<h6>".ucwords($va_role)." of</h6>";
										foreach ($va_book as $va_book_id => $vs_title) {
											$t_book = new ca_objects($va_book_id);
											$vs_title_trunk = explode(':',$vs_title);
											if (!($vs_author = $t_book->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'delimiter' => ', ')))) {
												$vs_author = null;
											}											
											$vn_pub_date = $t_book->get('ca_objects.publication_date');
											$vs_book_buf.= "<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'><div class='bookButton'>".caNavLink($this->request, '<div class="bookLabel">'.$vs_title_trunk[0]."</div>".$vs_author.$vn_pub_date, '', '', 'Detail', 'objects/'.$va_book_id)."</div></div>";
										}
										$vs_book_buf.= "</div>";
										$vs_book_buf.= "</div>";
									}
									$vs_book_buf.= "</div>";
								}	
								
								// Check docs	
								$vs_doc_buf = null;
								$va_docs_by_type = array();
								$vs_i_have_docs = false;
								if ($va_related_documents = $t_item->get('ca_objects.object_id', array('restrictToTypes' => array('document'), 'returnAsArray' => true))) {
									foreach ($va_related_documents as $va_key => $vn_doc_id) {
										$t_doc = new ca_objects($vn_doc_id);
										$vs_doc_type = $t_doc->get('ca_objects.document_type', array('convertCodesToDisplayText' => true));
										$va_docs_by_type[$vs_doc_type][$vn_doc_id] = "<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'><div class='entityButton'>".caNavLink($this->request, $t_doc->get('ca_objects.preferred_labels'),'', '', 'Detail', 'objects/'.$vn_doc_id)."</div></div>";	
										$vs_i_have_docs = true;
									}
								}								
								if ($va_related_catalogs = $t_item->get('ca_objects.object_id', array('restrictToTypes' => array('catalog'), 'returnAsArray' => true))) {
									foreach ($va_related_catalogs as $va_key => $vn_cat_id) {
										$t_cat = new ca_objects($vn_cat_id);
										$vs_cat_type = $t_cat->get('ca_objects.document_type', array('convertCodesToDisplayText' => true));
										$va_docs_by_type[$vs_cat_type][$vn_cat_id] = "<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'><div class='entityButton'>".caNavLink($this->request, $t_cat->get('ca_objects.preferred_labels'),'', '', 'Detail', 'objects/'.$vn_cat_id)."</div></div>";	
										$vs_i_have_docs = true;
									}
								}
								$va_ledger_list = array();
								if ($va_related_ledgers = $t_item->get('ca_objects.object_id', array('restrictToTypes' => array('page'), 'returnAsArray' => true))) {
									foreach ($va_related_ledgers as $va_key => $vn_page_id) {
										$t_page = new ca_objects($vn_page_id);
										$t_ledger = new ca_objects($t_page->get('ca_objects.parent.object_id'));
										$vs_ledger_type = $t_ledger->get('ca_objects.document_type', array('convertCodesToDisplayText' => true));
										$vn_ledger_id = $t_ledger->get('ca_objects.object_id');
										$va_docs_by_type[$vs_ledger_type][$vn_ledger_id] = "<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3'><div class='entityButton'>".caNavLink($this->request, $t_ledger->get('ca_objects.preferred_labels'),'', '', 'Detail', 'objects/'.$vn_ledger_id)."</div></div>";	
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
								<?php if ($vs_book_buf) {print '<li><a href="#bookTab">Related Books</a></li>';} ?>
								<?php if ($vs_people_buf) {print '<li><a href="#entTab">Related People & Organizations</a></li>';} ?>			
								<?php if ($vs_doc_buf) {print '<li><a href="#docTab">Related Documents</a></li>';} ?>
								
							  </ul>
<?php
	if ($vb_has_circulation) {
?>	
							<div id='circTab' <?php print $vs_style; ?>>
								<table id='circTable' class="display" style='width:100%;'>
									<thead class='titleBar' >									
										<tr>
											<th>Full Title<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
											<th>Author<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>										
											<th>Volume<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
											<th>Date Out<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
											<th>Date In<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
											<th>Rep.<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>											
											<th>Fine<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>		
											<th>Ledger<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
										</tr><!-- end row -->
									</thead>
									<tbody>
		<?php 
									print $vs_buf;								
		?>
									</tbody>
								</table><!-- end table -->
							</div><!-- end circTab -->
<?php
	}
?>						
							<div id='entTab' >
								<div class='container'>
									<div class='row'>
										<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
	<?php						
											print $vs_people_buf;
	?>									
										</div>	<!-- end col -->
									</div>	<!-- end row -->
								</div>	<!-- end container -->		
							</div><!-- end entTab -->
							<div id='bookTab'>
								<div class='container'>
									<div class='row'>
										<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
<?php
										print $vs_book_buf;
?>										
										</div><!-- end col -->
									</div><!-- end row -->
								</div><!-- end container -->
							</div><!-- end bookTab -->
							<div id='docTab'>
								<div class='container'>
									<div class='row'>
										<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
<?php
										print $vs_doc_buf;
?>										
										</div><!-- end col -->
									</div><!-- end row -->
								</div><!-- end container -->
							</div><!-- end docTab -->							
						</div><!-- end entityTable -->
					</div><!-- end col -->
				</div><!-- end row -->
				<div class='row'>
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
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
		  maxHeight: 135
		});
		$('#entityTable').tabs();
    	$('#circTable').dataTable({
    		"order": [[ 3, "asc" ]],
    		columnDefs: [{ 
       			type: 'title-string', targets: [0,1]
       		}, { 
       			type: 'natural', targets: [2,5,6] 
    		}],
     		paging: false
    	});		
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
<?php
	Timer::p('page');