<?php
 	AssetLoadManager::register('leaflet');
 	AssetLoadManager::register('slider');
	
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	
	$va_type = caNavLink($this->request, 'Digital Collections', '', '', 'Browse', 'objects');
	$va_docs = caNavLink($this->request, 'Catalogs', '', '', 'Browse', 'docs/facet/document_type/id/650');
	$va_title = ((strlen($t_object->get('ca_objects.preferred_labels')) > 40) ? substr($t_object->get('ca_objects.preferred_labels'), 0, 37)."..." : $t_object->get('ca_objects.preferred_labels'));	

	$va_home = caNavLink($this->request, "City Readers", '', '', '', '');
	MetaTagManager::setWindowTitle($va_home." > ".$va_type." > ".$va_docs." > ".$va_title);
	
		#Circulation Records
		$va_obj_ids = $t_object->get('ca_objects_x_entities.relation_id', array('returnAsArray' => true));
		
		if ($va_children_ids = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true))) {	
			foreach ($va_children_ids as $va_id => $va_children_id) {
				$t_child = new ca_objects($va_children_id);
				$va_child_rel_ids = $t_child->get('ca_objects_x_entities.relation_id', array('returnAsArray' => true));
				if (sizeof($va_child_rel_ids) > 0) {
					foreach ($va_child_rel_ids as $vn_id => $va_children_rel_id) {
						$va_obj_ids[] = $va_children_rel_id;
					}
				}
			}
		}
				
		$qr_rels = caMakeSearchResult('ca_objects_x_entities', $va_obj_ids, array('sort' => 'ca_objects_x_entities.date_out'));
		
		// set all of the page object_ids
		$va_page_ids = array();
		if ($qr_rels) {
			$va_result_count = $qr_rels->numHits();
		} 
				
		while($qr_rels->nextHit()) {
			$va_page_ids[] = $qr_rels->get("ca_objects_x_entities.see_original_link", array('idsOnly' => 1));
		}
		$qr_pages = caMakeSearchResult('ca_objects', $va_page_ids);
	
		$va_parents = array();
		while($qr_pages->nextHit()) {
			$va_parents[$qr_pages->get('ca_objects.object_id')] = caNavLink($this->request, $qr_pages->get('ca_objects.parent.preferred_labels.name'), '', '', 'Detail', 'objects/'.$qr_pages->get('ca_objects.parent.object_id'));
			$va_ledger_links[$qr_pages->get('ca_objects.parent.object_id')] = caNavLink($this->request, $qr_pages->get('ca_objects.parent.preferred_labels.name'), '', '', 'Detail', 'objects/'.$qr_pages->get('ca_objects.parent.object_id'));

		}

		$qr_rels->seek(0);	// reset the result to the beginning so we can run through it again
		$vn_i = 0;
		$vs_buf = "";
		$vs_has_circulation = false;	
		$va_readers = array();
		$va_full_set_readers = array();
		$va_occupations = array();
	
		while($qr_rels->nextHit()) {
			if ($qr_rels->get('ca_objects_x_entities.type_id') != 100) {
				continue;
			}
			$vs_buf.= "<div class='row ledgerRow'>";
				
				# Borrower Name
				$vs_buf.= "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2' id='entity".$vn_i."'>";
				$vs_buf.= $qr_rels->get("ca_entities.preferred_labels.displayname", array('returnAsLink' => true));
				$vs_buf.= "</div>";
			
				$vs_entity_info = null;
				if ($qr_rels->getWithTemplate("^ca_entities.life_dates")) {
					$vs_entity_info = $qr_rels->getWithTemplate("^ca_entities.life_dates")."<br/>";
				}
				if (($qr_rels->get("ca_entities.industry_occupations")) && ($qr_rels->get("ca_entities.industry_occupations") != 551)) {
					$vs_entity_info.= $qr_rels->getWithTemplate("^ca_entities.industry_occupations", array('delimiter' => ', '))."<br/>";
				}
				if ($qr_rels->get("ca_entities.industry_occupations")) {
					$va_occupation_count = $qr_rels->get("ca_entities.industry_occupations", array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
					foreach ($va_occupation_count as $vs_occupations_type) {
						//foreach ($va_occupations_type as $va_occupation_key => $va_occupation) {
							$va_occupations[$vs_occupations_type][] = $qr_rels->get("ca_entities.entity_id");
						//}
					}
				}
				if ($vs_entity_info) {				
					TooltipManager::add('#entity'.$vn_i, "<div class='tooltipImage'>".$qr_rels->getWithTemplate('<unit relativeTo="ca_entities">^ca_object_representations.media.preview</unit>')."</div><b>".$qr_rels->get("ca_entities.preferred_labels.displayname")."</b><br/>".$vs_entity_info); 
				}	
				
				# Volume		
				$vs_buf.= "<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>";
				if (substr($qr_rels->get("ca_objects.preferred_labels"), 0, 6) == "Volume") {
					$vs_buf.= $qr_rels->get("ca_objects.preferred_labels");
				}
				$vs_buf.= "</div>";			
				
				# Date Out
				$vs_buf.= "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
				$vs_buf.= $qr_rels->get("ca_objects_x_entities.date_out");
				$vs_buf.= "</div>";	
				
				# Date In
				$vs_buf.= "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
				$vs_buf.= $qr_rels->get("ca_objects_x_entities.date_in");
				$vs_buf.= "</div>";
				
				# Fine
				$vs_buf.= "<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>";
				$vs_buf.= $qr_rels->get("ca_objects_x_entities.fine");
				$vs_buf.= "</div>";	
				
				# Title as Transcribed			
				$vs_buf.= "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
				$vs_buf.= $qr_rels->get("ca_objects_x_entities.book_title");
				if ($qr_rels->get("ca_objects_x_entities.see_original", array('convertCodesToDisplayText' => true)) == "Yes"){
					$vs_buf.= caNavLink($this->request, '&nbsp;<i class="fa fa-exclamation-triangle"></i>', '', '', 'Detail', 'objects/'.$qr_rels->get("ca_objects_x_entities.see_original_link", array('idsOnly' => true)));
					TooltipManager::add('.fa-exclamation-triangle', "Uncertain transcription. See scanned image."); 						
				}				
				$vs_buf.= "</div>";
				
				# Representative
				$vs_buf.= "<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>";
				$vs_buf.= $qr_rels->get("ca_objects_x_entities.representative");
				$vs_buf.= "</div>";
								
				# Ledger Page & sidebar related ledgers
				$vs_buf.= "<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>";
				$vs_buf.= caNavLink($this->request, '<i class="fa fa-file-text"></i>', '', '', 'Detail', 'objects/'.$qr_rels->get("ca_objects_x_entities.see_original_link", array('idsOnly' => true)));
				$va_related_ledgers[] = $va_parents[$qr_rels->get("ca_objects_x_entities.see_original_link", array('idsOnly' => true))];
				$vs_buf.= "</div>";													
			$vs_buf.= "</div>";
		
			# Reader Count
				$vn_entity_id = $qr_rels->get("ca_entities.entity_id");
				$va_readers[$vn_entity_id] = $qr_rels->get("ca_entities.preferred_labels.displayname");
			
				$t_entity = new ca_entities($vn_entity_id);
				$va_reading_list = $t_entity->get('ca_objects.object_id', array('returnAsArray' => true, 'restrictToRelationshipTypes' => array('reader')));
				$va_volume_list = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true));
				foreach ($va_volume_list as $va_volume_key => $va_volume_list_id) {
					$vn_read_volume = false;
					foreach ($va_reading_list as $va_reading_key => $va_reading_id) {
						if ($va_reading_id == $va_volume_list_id) {
							$vn_read_volume = true;
						}
					}
				}
				if ($vn_read_volume == true) {
					$va_full_set_readers[$vn_entity_id] = $qr_rels->get("ca_entities.preferred_labels.displayname");
				}
			$vn_i++;
			$vs_has_circulation = true;
		}
		# Occupation Pie Chart data
		$vn_all_professions = 0;
		foreach ($va_occupations as $va_occupation_name => $va_occupation_count) {
			$vn_all_professions = $vn_all_professions+sizeof($va_occupation_count);
		}
		$va_js_stuff = array();
		$va_labels = array();
		$va_class_count = 1;
		foreach ($va_occupations as $va_occupation_name => $va_occupation_count) {
			$vn_fraction = round((sizeof($va_occupation_count) / $vn_all_professions)*100);
			$va_labels[$va_class_count] = "'$va_occupation_name'";
			$va_js_stuff[$va_class_count] = "{data: ".$vn_fraction.", className: 'color".$va_class_count."'}";
			$va_class_count++;
		}	
	
	
?>
<div class="page">
	<div class="wrapper">
		<div class="sidebar">
			{{{representationViewer}}}
			<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>	
<?php

			$t_list = new ca_lists();
			$vs_subj_buf = "";
			if ($vs_subjects_1813 = $t_object->get('ca_objects.subjects_1813', array('returnWithStructure' => 'true', 'convertCodesToDisplayText' => false))) {
				$vs_1813 = array();
				foreach ($vs_subjects_1813 as $va_key => $vs_subjects_1813_t) {
					foreach ($vs_subjects_1813_t as $vs_subjects_1813) {
						if (($vs_subjects_1813['subjects_1813'] != 528) && ($vs_subjects_1813['subjects_1813'])) {
							$vs_1813[] = caNavLink($this->request, $t_list->getItemForDisplayByItemID($vs_subjects_1813['subjects_1813']), '', '', 'Search', 'objects/search/ca_objects.subjects_1813:"'.$vs_subjects_1813['subjects_1813'].'"');
						}
					}
				}
				if ($vs_1813) {
					$vs_subj_buf.= "<div class='unit'>1813: ";
					$vs_subj_buf.= join(', ', $vs_1813);
					$vs_subj_buf.= "</div>";
				}
			}
			if (($vs_subjects_1838 = $t_object->get('ca_objects.subjects_1838', array('returnWithStructure' => 'true', 'convertCodesToDisplayText' => false)))) {
				$vs_1838 = array();
				foreach ($vs_subjects_1838 as $va_key => $vs_subjects_1838_t) {
					foreach ($vs_subjects_1838_t as $vs_subjects_1838) {
						if (($vs_subjects_1838['subjects_1838'] != 235) && ($vs_subjects_1838['subjects_1838'])) {
							$vs_1838[] = caNavLink($this->request, $t_list->getItemForDisplayByItemID($vs_subjects_1838['subjects_1838']), '', '', 'Search', 'objects/search/ca_objects.subjects_1838:"'.$vs_subjects_1838['subjects_1838'].'"');
						}
					}
				}
				if ($vs_1838) {
					$vs_subj_buf.= "<div class='unit'>1838: ";
					$vs_subj_buf.= join(', ', $vs_1838);
					$vs_subj_buf.= "</div>";
				}
			}						
			if ($vs_subjects_1850 = $t_object->get('ca_objects.Analytical_Catalog_1850', array('returnWithStructure' => 'true', 'convertCodesToDisplayText' => false))) {
				$vs_1850 = array();
				foreach ($vs_subjects_1850 as $va_key => $vs_subjects_1850_t) {
					foreach ($vs_subjects_1850_t as $vs_subjects_1850) {
						if (($vs_subjects_1850['Analytical_Catalog_1850'] != 964) && ($vs_subjects_1850['Analytical_Catalog_1850'])) {
							$vs_1850[] = caNavLink($this->request, $t_list->getItemForDisplayByItemID($vs_subjects_1850['Analytical_Catalog_1850']), '', '', 'Search', 'objects/search/ca_objects.Analytical_Catalog_1850:"'.$vs_subjects_1850['Analytical_Catalog_1850'].'"');
						}
					}
				}
				if ($vs_1850) {
					$vs_subj_buf.= "<div class='unit'>1850: ";
					$vs_subj_buf.= join(', ', $vs_1850);
					$vs_subj_buf.= "</div>";
				}
			}	
			if ($vs_subj_buf) {
				print "<h6>19TH C. SUBJECTS</h6>";
				print $vs_subj_buf;
			}
			$vs_curr_buf = null;
			if ($vs_subjects_lcsh = $t_object->get('ca_objects.LCSH', array('returnWithStructure' => 'true'))) {
				foreach ($vs_subjects_lcsh as $va_key => $vs_subject_lcsh_r) {
					foreach ($vs_subject_lcsh_r as $va_key => $vs_subject_lcsh_s) {
						foreach ($vs_subject_lcsh_s as $vs_subject_lcsh) {
							$va_subject = explode(' [', $vs_subject_lcsh);
							$vs_curr_buf.= caNavLink($this->request, $va_subject[0], '', 'Browse', 'docs', 'facet/LC_subject/id/'.urlencode(str_replace('/', '&#47;', $vs_subject_lcsh)))."<br/>";
						} 
					}
				}
			}
			if ($va_local = $t_object->get('ca_objects.local_subject', array('returnAsArray' => true))) {
				foreach ($va_local as $va_local_subject) {
					$vs_curr_buf.= caNavLink($this->request, caGetListItemByIDForDisplay($va_local_subject), '', 'Browse', 'docs', 'facet/local_subject/id/'.$va_local_subject)."<br/>";
				}
			}
			if ($va_genres = $t_object->get('ca_objects.document_type', array('returnAsArray' => true))) {
				foreach ($va_genres as $va_genre) {
					$vs_curr_buf.= caNavLink($this->request, caGetListItemByIDForDisplay($va_genre), '', 'Browse', 'docs', 'facet/document_type/id/'.$va_genre)."<br/>";
				}
			}
			if ($vs_curr_buf) {
				print "<div class='unit'><h6>Current Subjects</h6>";
				print $vs_curr_buf;
				print "</div>";
			}
			$vs_sidebar_buf = null;
			if ($t_object->get("ca_objects.nysl_link")){
				$vs_sidebar_buf.= "<a href='".$t_object->get("ca_objects.nysl_link")."' target='_blank'>Catalog Record</a>";
			}
			if ($va_collections_list = $t_object->get('ca_collections.hierarchy.collection_id', array('maxLevelsFromTop' => 1, 'returnAsArray' => true))) {
				$va_collections_for_display = array_unique(caProcessTemplateForIDs("<l>^ca_collections.preferred_labels.name</l>", "ca_collections", caFlattenArray($va_collections_list, array('unique' => true)), array('returnAsArray' => true)));
				$vs_sidebar_buf.= "<div class='unit'>";
				$vs_sidebar_buf.= join("<br/>\n", $va_collections_for_display);
				$vs_sidebar_buf.= "</div>";
			}						
			if ($vs_sidebar_buf != "") {
				print "<h6 style='margin-top:30px;'>In The Library</h6>	";	
				print $vs_sidebar_buf;
			}		
			$vs_learn_even = null;
			if ($vs_etsc = $t_object->get('ca_objects.ETSC_container.ETSC_link')) {
				$va_etsc_links = $t_object->get('ca_objects.ETSC_container', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true));
				foreach ($va_etsc_links as $va_key => $va_etsc_link_t) {
					foreach ($va_etsc_link_t as $va_key => $va_etsc_link) {
						$vs_learn_even.= "<a href='".$va_etsc_link['ETSC_link']."' target='_blank'>".$va_etsc_link['ESTC_link_type']."</a><br/>";
					}
				}
			}				
			if ($vs_digilink = $t_object->get('ca_objects.Digital_link')) {
				$vs_learn_even.=  "<div class='unit'><a href='".$vs_digilink."' target='_blank'>Digital Copy</a></div>";
			}				
			if ($vs_learn_even != "") {
				print "<h6 style='margin-top:30px;'>Learn Even More</h6>";	
				print $vs_learn_even;
			}												
?>										
		</div><!-- end sideBar -->
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
				<div class="row">			
					<div class='col-sm-6 col-md-6 col-lg-6'>			
		<?php
						if ($va_authors = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'delimiter' => ', ', 'returnAsLink' => true))) {
							print "<h4 style='font-size:16px;'>".$va_authors."</h4>";
						}
						if ($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == 'Bib') {
							if ($va_parent_label = $t_object->get('ca_objects.parent.preferred_labels')) {
								print "<h4 style='font-size:16px;'>".caNavLink($this->request, $t_object->get('ca_objects.parent.preferred_labels'), '', '', 'Detail', 'objects/'.$t_object->get('ca_objects.parent.object_id'))." ".$t_object->get('ca_objects.preferred_labels')."</h4>";					
							} else {
								print "<h4 style='font-size:16px;'>".$t_object->get('ca_objects.preferred_labels')."</h4>";
							}
							if ($vs_alt_title = $t_object->get('ca_objects.nonpreferred_labels')) {
								print "<a href='#' onclick='$(\".altTitle\").slideDown();'><h6><i class='fa fa-pencil'></i> Alternate Titles</h6></a><div class='altTitle' style='display:none;'>".$vs_alt_title."</div>";
							}
						} else {
							if ($vs_alt_title = $t_object->get('ca_objects.nonpreferred_labels')) {
								print "<h4>".$vs_alt_title."</h4>";
							}
						}	
							
						print "<div class='unit'>";
							if ($vs_place = $t_object->get('ca_objects.publication_place.publication_place_text')) {
								print $vs_place.": ";
							}
							if ($vs_pub_details = $t_object->get('ca_objects.printing_pub_details')) {
								print $vs_pub_details.", ";
							}				
							if ($vs_date = $t_object->get('ca_objects.publication_date')) {
								print $vs_date.".";
							}
						print "</div>";
						if ($vs_public_notes = $t_object->get('ca_objects.public_notes')) {
							print "<div class='unit'><h6>Note</h6>".$vs_public_notes."</div>";
						}	
						if ($vs_collection_status = $t_object->get('ca_objects.collection_status', array('convertCodesToDisplayText' => true))) {
							if (($vs_collection_status == 'Copy in collection is a later acquisition')|($vs_collection_status == 'In Collection')) {
								if ($va_opac_link = $t_object->get('ca_objects.nysl_link')) {
									print "<div class='unit'><a href='".$va_opac_link."' target='_blank'>".$vs_collection_status."</a></div>";
								} else {
									print "<div class='unit'>".$vs_collection_status."</div>";
								}
							} else {
								print "<div class='unit'>".$vs_collection_status."</div>";
							}
						}					
						if ($vs_children = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true, 'sort' => 'ca_objects.preferred_labels'))) {
							print "<div class='unit'>";
							print "<a href='#' class='openRef' onclick='$(\"#volumes\").slideDown(); $(\".openRef\").hide(); $(\".closeRef\").show(); return false;'><h6 style='font-size:13px;'>Circulation by Volume&nbsp;<i class='fa fa-angle-down'></i></h6></a>"; 
							print "<a href='#' class='closeRef' style='display:none;' onclick='$(\"#volumes\").slideUp(); $(\".closeRef\").hide(); $(\".openRef\").show(); return false;'><h6 style='font-size:13px;'>Circulation by Volume&nbsp;<i class='fa fa-angle-up'></i></h6></a>";
							print "<div id='volumes' style='display:none;'>";					
							$va_volumes = array();
							foreach ($vs_children as $va_key => $vs_child) {
								$t_child = new ca_objects($vs_child);
								$va_volumes[] = $t_child->get('ca_objects.preferred_labels')." (".sizeof($t_child->get('ca_entities', array('returnAsArray' => true)))." checkouts) ";
							}
							sort($va_volumes);
							print join('<br/>', $va_volumes);
							print "</div>";
							print "</div>";
						}				

	
						#if ($vs_parent_id = $t_object->get('ca_objects.parent.object_id')) {
						#	$t_parent_bib = new ca_objects($vs_parent_id);
						#	$vs_children_vol = $t_parent_bib->get('ca_objects.children.object_id', array('returnAsArray' => true, 'sort' => 'ca_objects.preferred_labels'));
						#	print "<div class='unit'><h6>Available Volumes</h6>";
						#	$va_other_volumes = array();
						#	foreach ($vs_children_vol as $va_key => $vs_child) {
						#		$t_child = new ca_objects($vs_child);
						#		$va_other_volumes[] = caNavLink($this->request, $t_child->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$t_child->get('ca_objects.object_id'))." (".sizeof($t_child->get('ca_entities', array('returnAsArray' => true)))." checkouts) ";
						#	}
						#	sort($va_other_volumes);
						#	print join('<br/>', $va_other_volumes);
						#	print "</div>";
						#}															
						#if ($vs_bib_catalog = $t_object->get('ca_objects.bib_catalog_details', array('returnAsArray' => true, 'sort' => 'ca_objects.bib_catalog_details.catalog_list'))) {
						#	print "<div class='unit'>Bib Catalog: ";
						#	foreach ($vs_bib_catalog as $va_key => $va_bib) {
						#		print $va_bib['catalog_list'].", Page ".$va_bib['page_number'].", Size: ".$va_bib['bib_size'].", Volumes: ".$va_bib['volumes_recorded'];
						#	}
							#print_r($vs_bib_catalog);
						#	print "</div>";
						#}																																																						
		?>	
						<div id="detailTools">
							<!-- AddThis Button BEGIN -->
							<div class="detailTool"><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><span class="glyphicon glyphicon-share-alt"></span> Share</a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script></div><!-- end detailTool -->
							<!-- AddThis Button END -->
							<div class="detailTool"><span class="glyphicon glyphicon-send"></span><a href='mailto:ledger@nysoclib.org?subject=CR%20User%20Contribution:%20<?php print $t_object->get('ca_objects.idno'); ?>&body='>Contribute</a></div><!-- end detailTool -->
							<!-- <div class="detailTool"><a href='#detailComments' onclick='jQuery("#detailComments").slideToggle();return false;'><span class="glyphicon glyphicon-comment"></span>Comment <?php print (sizeof($va_comments) > 0 ? sizeof($va_comments) : ""); ?></a></div> -->
						</div><!-- end detailTools -->																			
					</div><!-- end col -->
					<div class='col-sm-6 col-md-6 col-lg-6'>					
<?php
						// map
						$this->setVar('dont_show_catalogue_list', true);
						$this->setVar('map_css_id', 'publisherMapCatalogueDetail');
						$this->setVar('show_catalogue_id', $t_object->get('ca_objects.object_id'));
						
						print "<div class='vizTitle'>Publication Places in this catalog</div>";
						print $this->render('Map/index_html.php');
?>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 expand" >
								<section>
									<!--<p><button id="trigger-overlay" type="button">Click to Expand</button></p>-->
									<p><?php print caNavLink($this->request, '<i class="fa fa-book"></i> Compare Catalogs', '', '', 'Map', 'Index'); ?></p> 
								</section>
							</div>
						</div>					
					</div><!-- end col -->			
				</div><!-- end row -->
		
				<div class='row'>
					<div class='col-sm-12 col-md-12 col-lg-12'>	
						<div id='objectTable'>
							<ul class='row'>
<?php
								#Check borrowing history
								if ($vs_has_circulation == true) {
									print '<li><a href="#circTab">Borrowing History</a></li>';
									$vs_style = "style='display:block;'";												
								} else {
									$vs_style = "style='display:none;'";
								}
								
								#Check related entities
								$vs_people_buf = null;
								$va_people_by_rels = array();
								if ($va_related_people = $t_object->get('ca_entities', array('returnWithStructure' => true, 'sort' => 'ca_entities.type_id', 'excludeRelationshipTypes' => array('reader')))) {
									
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
								#Check related books
								$vs_book_buf = null;
								$vs_is_related = false;
								$va_related_books = array();

								if ($va_related_books = $t_object->get('ca_objects.related', array('returnWithStructure' => true, 'sort' => 'ca_objects.preferred_labels.name_sort','restrictToTypes' => array('bib')))){
									$vs_book_buf.= "<div class='row'>";
									foreach ($va_related_books as $va_book_id => $va_related_book) {
										if ($va_related_book['object_id'] == $t_object->get('ca_objects.object_id')) { continue; }
										$vs_book_label = explode(':', $va_related_book['label']);
										$t_book = new ca_objects($va_related_book['object_id']);
										$vs_author = $t_book->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author')));
										$vs_pub_date = $t_book->get('ca_objects.publication_date');
										$vs_book_buf.= "<div class='col-sm-4 col-md-4 col-lg-4'><div class='bookButton'>".caNavLink($this->request, "<div class='bookLabel'>".$vs_book_label[0].'</div>'.$vs_author.'<br/>'.$vs_pub_date, '', '', 'Detail', 'objects/'.$va_related_book['object_id'])."</div></div>";
										$vs_is_related = true;
									}
									$vs_book_buf.= "</div><!-- end row -->";
								}											
								#Check related documents
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
								if (sizeof($va_ledger_links) > 0) {
									foreach ($va_ledger_links as $vn_ledger_id => $vs_ledger_link) {
										$t_ledger = new ca_objects($vn_ledger_id);
										$vs_ledger_type = $t_ledger->get('ca_objects.document_type', array('convertCodesToDisplayText' => true));
										$va_docs_by_type[$vs_ledger_type][$vn_ledger_id] = "<div class='col-sm-3 col-md-3 col-lg-3'><div class='entityButton'>".$vs_ledger_link."</div></div>";	
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
								<?php if ($vs_book_buf && $vs_is_related) {print '<li><a href="#bookTab">Related Books</a></li>';} ?>				
								<?php if ($vs_people_buf) {print '<li><a href="#entTab">Related People & Organizations</a></li>';} ?>			
								<?php if ($vs_doc_buf) {print '<li><a href="#docTab">Related Documents</a></li>';} ?>
							</ul>
							<div id='circTab' <?php print $vs_style; ?>>
								<div class='container'>
									<div class='row'>
										<div class='row titleBar' >
											<hr></hr>
											<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Borrower Name</div>											
											<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>Volume</div>
											<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Date Out</div>
											<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Date In</div>
											<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>Fine</div>
											<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Transcribed Title</div>				
											<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>Repr.</div>
											<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>Ledger</div>

										</div><!-- end row -->
				<?php			
										print $vs_buf;
				?>		
									</div><!-- end row -->
								</div><!-- end container -->
							</div><!-- end circTab -->
							<div id='bookTab' >
<?Php 
								if ($vs_book_buf && $vs_is_related && $t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == 'bib') {
									print '<h6>Books by this author</h6>';
								} else if ($vs_book_buf && $vs_is_related) {
									print '<h6>Books in this catalog</h6>';
								}
?>
								<div class='container'>
									<div class='row'>
										<div class='col-sm-12 col-md-12 col-lg-12'>									
<?php
											print $vs_book_buf;
?>												
										</div><!-- end col -->
									</div><!-- end row -->
								</div><!-- end container -->
							</div><!-- end bookTab -->										
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
						</div><!-- end objectTable-->	  

					</div><!-- end col -->
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