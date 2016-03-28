<?php
	Timer::start('page');
	Timer::disable('page');

	$t_object 			= $this->getVar("item");
	$va_comments 		= $this->getVar("comments");
	$vs_type 			= caNavLink($this->request, 'Books', '', '', 'Browse', 'objects');
	
	$vs_title 			= caTruncateStringWithEllipsis($t_object->get('ca_objects.preferred_labels.name'), 40);	
	$vs_parent_title 	= caTruncateStringWithEllipsis($t_object->get('ca_objects.parent.preferred_labels.name'), 40);	
	
	$va_entity_reading_list_cache = array();
	$va_access_values = $this->getVar('access_values');
	
	if ($vs_parent_title) {
		$vs_title = "{$vs_parent_title}: {$vs_title}";
	} 
	
	$vn_object_id = $t_object->getPrimaryKey();
	
	
	$vs_home = caNavLink($this->request, "City Readers", '', '', '', '');
	MetaTagManager::setWindowTitle($vs_home." > ".$vs_type." > ".$vs_title);
	
		# Circulation Records
		$va_obj_ids = $t_object->get('ca_objects_x_entities.relation_id', array('returnAsArray' => true));

		if ($va_children_ids = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true))) {	
			$qr_children = caMakeSearchResult('ca_objects', $va_children_ids);
			while($qr_children->nextHit()) {
				$va_obj_ids = array_merge($va_obj_ids, $qr_children->get('ca_objects_x_entities.relation_id', array('returnAsArray' => true)));
			}
		}
				
		$qr_rels = caMakeSearchResult('ca_objects_x_entities', $va_obj_ids, array('sort' => 'ca_objects_x_entities.date_out'));
		
		// set all of the page object_ids
		$va_page_ids = array();
		$va_entity_ids = array();
		$va_parents = array();
		if ($qr_rels) {
			$vn_result_count = $qr_rels->numHits();
		 
		
			while($qr_rels->nextHit()) {
				$va_page_ids[] = $qr_rels->get("ca_objects_x_entities.see_original_link", array('idsOnly' => 1));
				$va_entity_ids[$qr_rels->get('ca_objects_x_entities.entity_id')] = true;
			}
		}
		
		$va_entities = array();
		if ($qr_entities = caMakeSearchResult('ca_entities', array_keys($va_entity_ids))) {
			while($qr_entities->nextHit()) {
				if (!isset($va_entities[$vn_entity_id = $qr_entities->get('ca_entities.entity_id')])) {
					$va_entity = $qr_entities->get("ca_entities.preferred_labels", ['returnAsArray' => true, 'returnWithStructure' => false, 'assumeDisplayField' => false]);
		
					if (is_array($va_entity)) {
						$va_entity = array_shift($va_entity);
						$va_entities[$va_entity['entity_id']] = array(
							'forename' => $va_entity['forename'],
							'surname' => $va_entity['surname'],
							'displayname' => $va_entity['displayname'],
							'displayname_with_link' => array_shift(caCreateLinksFromText([$va_entity['displayname']], 'ca_entities', [$vn_entity_id]))
						);
					}
				}
			}
		}
		
		if(sizeof($va_page_ids)) { 
			$qr_pages = caMakeSearchResult('ca_objects', $va_page_ids);
	
			while($qr_pages->nextHit()) {
				$vn_parent_id = $qr_pages->get('ca_objects.parent_id');
				$vs_parent_title = $qr_pages->get('ca_objects.parent.preferred_labels.name');
				$vn_object_id = $qr_pages->get('ca_objects.object_id');
			
				$va_parents[$vn_object_id] = $va_ledger_links[$vn_parent_id] = caNavLink($this->request, $vs_parent_title, '', '', 'Detail', 'objects/'.$vn_parent_id);

			}
		}

		$vn_i = 0;
		$vs_buf = "";
		$vs_has_circulation = false;	
		$va_readers = array();
		$va_full_set_readers = array();
		$va_occupations = array();
		if($qr_rels) {
			$qr_rels->seek(0);	// reset the result to the beginning so we can run through it again
		

			$qr_rels->setOption('prefetchAttributes', ['see_original_link', 'see_original', 'date_in', 'date_out', 'book_title', 'representative', 'fine']); 
			$qr_rels->setOption('prefetch', 250);
			while($qr_rels->nextHit()) {
				if ((int)$qr_rels->get('ca_objects_x_entities.type_id') !== 100) {
					continue;
				}
				
					# Borrower Name
				
					$vn_borrower_entity_id = $qr_rels->get("ca_entities.entity_id");
					if (!$vn_borrower_entity_id) { continue; }
					
				$vs_buf.= "<tr class='ledgerRow'>";
					$vs_borrower_forename = $va_entities[$vn_borrower_entity_id]['forename']; //$qr_rels->get("ca_entities.preferred_labels.forename");
					$vs_borrower_surname = $va_entities[$vn_borrower_entity_id]['surname']; //$qr_rels->get("ca_entities.preferred_labels.surname");
					$vs_borrower_displayname = $va_entities[$vn_borrower_entity_id]['displayname']; //$qr_rels->get("ca_entities.preferred_labels.displayname");
					$vs_borrower_displayname_with_link = $va_entities[$vn_borrower_entity_id]['displayname_with_link']; //$qr_rels->get("ca_entities.preferred_labels.displayname", array('returnAsLink' => true));
	
					$vs_buf.= "<td id='entity".$vn_i."'>";
					$vs_buf.= "<span title='{$vs_borrower_surname}, {$vs_borrower_forename}'></span>";
					$vs_buf.= $vs_borrower_displayname_with_link;
					$vs_buf.= "</td>";
			
					#$vs_entity_info = null;
					#if ($qr_rels->getWithTemplate("^ca_entities.life_dates")) {
					#	$vs_entity_info = $qr_rels->getWithTemplate("^ca_entities.life_dates")."<br/>";
					#}
					#if (($qr_rels->get("ca_entities.industry_occupations")) && ($qr_rels->get("ca_entities.industry_occupations") != 551)) {
					#	$vs_entity_info.= $qr_rels->getWithTemplate("^ca_entities.industry_occupations", array('delimiter' => ', '))."<br/>";
					#}
					#if ($qr_rels->get("ca_entities.industry_occupations")) {
					#	$va_occupation_count = $qr_rels->get("ca_entities.industry_occupations", array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
					#	foreach ($va_occupation_count as $vs_occupations_type) {
							//foreach ($va_occupations_type as $va_occupation_key => $va_occupation) {
					#			$va_occupations[$vs_occupations_type][] = $qr_rels->get("ca_entities.entity_id");
							//}
					#	}
					#}
					#if ($vs_entity_info) {				
					#	TooltipManager::add('#entity'.$vn_i, "<div class='tooltipImage'>".$qr_rels->getWithTemplate('<unit relativeTo="ca_entities">^ca_object_representations.media.preview</unit>')."</div><b>".$qr_rels->get("ca_entities.preferred_labels.displayname")."</b><br/>".$vs_entity_info); 
					#}	
				
					# Volume		
					$vs_buf.= "<td>";
				
					$vs_volume_title = $qr_rels->get("ca_objects.preferred_labels.name");
				
					if (substr($vs_volume_title, 0, 6) == "Volume") {
						$vs_buf.= $vs_volume_title;
					}
					$vs_buf.= "</td>";			
				
					# Date Out
					$vs_buf.= "<td>";
					$vs_buf.= $vs_date_out = $qr_rels->get("ca_objects_x_entities.date_out");
					$vs_buf.= "</td>";	
				
					# Date In
					$vs_buf.= "<td>";
					$vs_buf.= $vs_date_in = $qr_rels->get("ca_objects_x_entities.date_in");
					$vs_buf.= "</td>";
				
					# Fine
					$vs_buf.= "<td>";
					$vs_buf.= $vs_fine = $qr_rels->get("ca_objects_x_entities.fine");
					$vs_buf.= "</td>";	
				
					# Title as Transcribed			
					$vn_see_original_link = $qr_rels->get("ca_objects_x_entities.see_original_link", array('idsOnly' => true));
			
					$vs_buf.= "<td>";
					$vs_buf.= $vs_book_title = $qr_rels->get("ca_objects_x_entities.book_title");
					if ($qr_rels->get("ca_objects_x_entities.see_original", array('convertCodesToDisplayText' => true)) == "Yes"){
						$vs_buf.= caNavLink($this->request, '&nbsp;<i class="fa fa-exclamation-triangle"></i>', '', '', 'Detail', 'objects/'.$vn_see_original_link);
						TooltipManager::add('.fa-exclamation-triangle', "Uncertain transcription. See scanned image."); 						
					}				
					$vs_buf.= "</td>";
				
					# Representative
					$vs_buf.= "<td>";
					$vs_buf.= $qr_rels->get("ca_objects_x_entities.representative");
					$vs_buf.= "</td>";
								
					# Ledger Page & sidebar related ledgers
					$vs_buf.= "<td>";
					$vs_buf.= caNavLink($this->request, '<i class="fa fa-file-text"></i>', '', '', 'Detail', 'objects/'.$vn_see_original_link);
					$va_related_ledgers[] = $va_parents[$vn_see_original_link];
					$vs_buf.= "</td>";													
				$vs_buf.= "</tr><!-- end ledgerRow -->";
			
	if(false) {		
				# Reader Count
					$va_readers[$vn_borrower_entity_id] = $vs_borrower_displayname;
			
					$vb_read_volume = false;
				
					if (isset($va_entity_reading_list_cache[$vn_borrower_entity_id])) {
						$va_volume_list = $va_entity_reading_list_cache[$vn_borrower_entity_id]['volume_list'];
						$va_reading_list = $va_entity_reading_list_cache[$vn_borrower_entity_id]['reading_list'];
					} else {
						$t_entity = new ca_entities($vn_borrower_entity_id);
						if ($t_entity->getPrimaryKey()) {
							$va_reading_list = $t_entity->get('ca_objects.object_id', array('returnAsArray' => true, 'restrictToRelationshipTypes' => array('reader')));
							$va_volume_list = $t_entity->get('ca_objects.children.object_id', array('returnAsArray' => true));
				
							$va_entity_reading_list_cache[$vn_borrower_entity_id] = array(
								'volume_list' => $va_volume_list,
								'reading_list' => $va_reading_list
							);
						}
					}
				
					if (is_array($va_reading_list)) {
						if(sizeof(array_intersect($va_volume_list, $va_reading_list))) {
							$vb_read_volume = true;
						}
					}
					if ($vb_read_volume) { $va_full_set_readers[$vn_borrower_entity_id] = $vs_borrower_displayname; }
				
	}			
				$vn_i++;
				$vs_has_circulation = true;
			}
		
		
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
							$vs_1813[] = caNavLink($this->request, $t_list->getItemForDisplayByItemID($vs_subjects_1813['subjects_1813']), '', '', 'Search', 'objects/search/ca_objects.subjects_1813:'.$vs_subjects_1813['subjects_1813']);
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
							$vs_1838[] = caNavLink($this->request, $t_list->getItemForDisplayByItemID($vs_subjects_1838['subjects_1838']), '', '', 'Search', 'objects/search/ca_objects.subjects_1838:'.$vs_subjects_1838['subjects_1838']);
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
							$vs_1850[] = caNavLink($this->request, $t_list->getItemForDisplayByItemID($vs_subjects_1850['Analytical_Catalog_1850']), '', '', 'Search', 'objects/search/ca_objects.Analytical_Catalog_1850:'.$vs_subjects_1850['Analytical_Catalog_1850']);
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
			if ($vs_subjects_lcsh = $t_object->get('ca_objects.LCSH', array('returnWithStructure' => 'true'))) {
				print "<div class='unit'><h6>Current Subjects</h6>";
				foreach ($vs_subjects_lcsh as $va_key => $vs_subject_lcsh_r) {
					foreach ($vs_subject_lcsh_r as $va_key => $vs_subject_lcsh_s) {
						foreach ($vs_subject_lcsh_s as $vs_subject_lcsh) {
							$va_subject = explode(' [', $vs_subject_lcsh);
							print caNavLink($this->request, $va_subject[0], '', '', 'Search', 'objects/search/'.$vs_subject_lcsh)."<br/>";
						}
					}
				}
				print "</div>";
			}

			$vs_sidebar_buf = null;
			if ($t_object->get("ca_objects.nysl_link")){
				if (($t_object->get("ca_objects.collection_status") == 687) | ($t_object->get("ca_objects.collection_status") == 689)) {
					$vs_sidebar_buf.= "<a href='".$t_object->get("ca_objects.nysl_link")."' target='_blank'>Catalog Record</a>";
				}
			}
			if ($va_collections_list = $t_object->get('ca_collections.hierarchy.collection_id', array('maxLevelsFromTop' => 1, 'returnAsArray' => true))) {
				$va_collections_for_display = array_unique(caProcessTemplateForIDs("<l>^ca_collections.preferred_labels.name</l>", "ca_collections", caFlattenArray($va_collections_list, array('unique' => true)), array('returnAsArray' => true)));
				$vs_sidebar_buf.= join("<br/>\n", $va_collections_for_display);
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
						if ($va_authors = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'delimiter' => ', ', 'returnAsLink' => true, 'checkAccess' => $va_access_values))) {
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
						if ($t_object->get('ca_objects.status', array('convertCodesToDisplayText' => true)) == 'new') {
							print "<div class='incomplete'><i class='fa fa-sticky-note'></i> <i>Metadata for this record is currently incomplete. Click Contribute to submit information for inclusion on this page. See the ".caNavLink($this->request, 'User Guide', '', '', 'About', 'userguide')." to learn more about Contributing.</i></div>";
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
						if ($va_children = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true, 'sort' => 'ca_objects.preferred_labels.name_sort'))) {
							print "<div class='unit'>";
							print "<a href='#' class='openRef' onclick='$(\"#volumes\").slideDown(); $(\".openRef\").hide(); $(\".closeRef\").show(); return false;'><h6 style='font-size:13px;'>Circulation by Volume&nbsp;<i class='fa fa-angle-down'></i></h6></a>"; 
							print "<a href='#' class='closeRef' style='display:none;' onclick='$(\"#volumes\").slideUp(); $(\".closeRef\").hide(); $(\".openRef\").show(); return false;'><h6 style='font-size:13px;'>Circulation by Volume&nbsp;<i class='fa fa-angle-up'></i></h6></a>";
							print "<div id='volumes' style='display:none;'>";					
							$va_volumes = array();
							
							if (sizeof($va_children) && ($qr_children = caMakeSearchResult('ca_objects', $va_children, array('sort' => 'ca_objects.preferred_labels.name_sort')))) {
								//foreach ($va_children as $va_key => $vs_child) {
								while($qr_children->nextHit()) {
									//$t_child = new ca_objects($vs_child);
									$va_volumes[] = $qr_children->get('ca_objects.preferred_labels.name')." (".sizeof($qr_children->get('ca_entities', array('returnAsArray' => true)))." checkouts) ";
								}
								print join('<br/>', $va_volumes);
							}
							print "</div>";
							print "</div>";
						}				

	
						#if ($vs_parent_id = $t_object->get('ca_objects.parent.object_id')) {
						#	$t_parent_bib = new ca_objects($vs_parent_id);
						#	$va_children_vol = $t_parent_bib->get('ca_objects.children.object_id', array('returnAsArray' => true, 'sort' => 'ca_objects.preferred_labels'));
						#	print "<div class='unit'><h6>Available Volumes</h6>";
						#	$va_other_volumes = array();
						#	foreach ($va_children_vol as $va_key => $vs_child) {
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
<?php
					if ($vs_has_circulation == false) {
						$va_class = "hideme";
					} else {
						$va_class = "";
					}
?>					
					<div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 <?php print $va_class; ?>' style='border-left:1px solid #ddd;'>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<!-- open/close -->
								<div class="overlay overlay-corner">
									<div >
										<button type="button" class="overlay-close"><i class="fa fa-times"></i></button>
									</div>
									
									<div style="width:60%; height:400px; float:left; padding-right:10px;">
										
										<div id="stat_bib_checkout_distribution2" class="ct-chart ct-golden-section"> 
										<div class="ct-key">
											<span class="ct-series-a-key">
												<i class="fa fa-square"></i> 
												<span class='blacktext'>
													<?php print $t_object->get('ca_objects.preferred_labels'); ?>
												</span>
											</span> 
											<span class="ct-series-b-key average">
												<i class="fa fa-square"></i> 
												<span class='blacktext'>Library Average</span>
											</span>
										</div>	
										</div>
										<div class='ovcircNote'>Circulation records from 1793-1799 are lost.</div>
									
									</div>
									<div class='circles' style="width:40%; height:500px; float:left; border-left:1px solid #ddd; padding-left:20px;">
										<div style="width:80%; ">
											<div class='vizName'>Readers by Occupation</div>
											<div id="stat_bib_readers_by_occupation2" class="ct-chart ct-golden-section"></div>
										</div>
										<hr style='margin-top:20px;'>
										<div style="width:80%; ">
											<div class="vizName">Check out Duration</div> 
											<div id="stat_bib_checkout_durations2" class="ct-chart ct-golden-section"></div>
										</div>	
									</div>																				
								</div><!-- end overlay-->
							</div><!-- end col-->
						</div><!-- end row-->	
						<div class="row" id="trigger-overlay">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="vizTitle" >Check out distribution <button  type="button"><i class="fa fa-external-link"></i></button></div>
								<div class='col-sm-4 col-md-4 col-lg-4'>
									<div class="vizName">Check out duration</div>
									<div id="stat_bib_checkout_durations" class="ct-chart ct-square"></div>
									<div class="vizName">Readers by occupation</div>
									<div id="stat_bib_readers_by_occupation" class="ct-chart ct-square"></div>
								</div>								
								<div class='col-sm-8 col-md-8 col-lg-8'>
									<div id="stat_bib_checkout_distribution" class="ct-chart ct-golden-section"></div>
									<div class="ct-key objectsCirculation"><span class="ct-series-a-key"><i class="fa fa-square"></i> <span class='blacktext'>This Title</span></span> <span class="ct-series-b-key average" style="padding-right:10px;"><i class="fa fa-square"></i> <span class='blacktext'>Library Average</span></span></div>								
								</div>
							</div><!-- end col-->
						</div><!-- end row-->
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 expand " style="margin-top:-20px;padding-bottom:15px; border-bottom:1px solid #ccc;">
								<section>
<?php											
									print '<p ><div class="button">'.caNavLink($this->request, '<i class="fa fa-plus"></i> Compare Books', '', '', 'Circulation', 'Books', ['id' => $t_object->getPrimaryKey()]).'</div></p>';
?>											
								</section>
							</div>
						</div>												
<?php
	$stat_bib_readers_by_occupation = CompositeCache::fetch('stat_bib_readers_by_occupation', 'vizData');

	$vn_bib_id = $t_object->getPrimaryKey();
	if ($stat_bib_readers_by_occupation[$vn_bib_id]) {
		$va_series_labels = array_keys($stat_bib_readers_by_occupation[$vn_bib_id]);
		$va_series = array_values($stat_bib_readers_by_occupation[$vn_bib_id]);
?>
						
		<script type="text/javascript">
			var occupationIDs = <?php print json_encode(CompositeCache::fetch('stat_bib_occupation_ids', 'vizData')); ?>;
			var dataForReadersByOccupation = {
			  labels: <?php print json_encode($va_series_labels); ?>,
			  series: <?php print json_encode($va_series); ?>
			};

			var options = {
				labelInterpolationFnc: function(value, index) {
					var t=0;
				  for(var x in dataForReadersByOccupation.series) { t += dataForReadersByOccupation.series[x] }
				  if(dataForReadersByOccupation.series[index]/t <= 0.1) { return ''; }
				  return value;
				}
			};
			var $chart = $('#stat_bib_readers_by_occupation2');

			var $subjectAreaToolTip = $chart
			  .append('<div class="tooltip"></div>')
			  .find('.tooltip')
			  .hide();

			$chart.on('mouseenter', '.ct-series', function() {
				var $slice = $(this),
				value = $slice.find('path').attr('ct:value');
				var l = $slice.attr("class").replace("ct-series ct-series-", "").charCodeAt(0) - 97;
			
				sliceName = dataForReadersByOccupation.labels[l] + " (" + value + ")";	// $slice.find('text.ct-label').text() 
				$subjectAreaToolTip.html(sliceName).show();
			});

			$chart.on('mouseleave', '.ct-series', function() {
			  $subjectAreaToolTip.hide();
			});

			$chart.on('mousemove', function(event) {
				var l = (event.originalEvent.layerX >= 0) ? event.originalEvent.layerX : event.offsetX;
				var t = (event.originalEvent.layerY >= 0) ? event.originalEvent.layerY : event.offsetY;
			  $subjectAreaToolTip.css({
				left: l - $subjectAreaToolTip.width() / 2 - 10,
				top: t - $subjectAreaToolTip.height() - 40
			  });
			});
			
			$chart.on('click', '.ct-series', function() {
				var $slice = $(this),
				value = $slice.find('path').attr('ct:value');
				
				var l = $slice.attr("class").replace("ct-series ct-series-", "").charCodeAt(0) - 97;
				var label = dataForReadersByOccupation.labels[l];
				
				if (parseInt(occupationIDs[label]) > 0) {
					window.location = '<?php print caNavUrl($this->request, '', 'Browse', 'entities', array('facet' => 'occupation_facet')); ?>/id/' + occupationIDs[label];
				}
			});
			
			var responsiveOptions = [
			  ['screen and (min-width: 640px)', {
				chartPadding: 20,
				labelOffset: 60,
				labelDirection: 'explode'
			  }],
			  ['screen and (min-width: 1024px)', {
				labelOffset: 60,
				chartPadding: 20
			  }]
			];

			new Chartist.Pie('#stat_bib_readers_by_occupation', dataForReadersByOccupation, options, responsiveOptions);
			new Chartist.Pie('#stat_bib_readers_by_occupation2', dataForReadersByOccupation, options, responsiveOptions);

		</script>	
		<!-- Chartist -->
<?php
	}

	$stat_bib_checkout_durations = CompositeCache::fetch('stat_bib_checkout_durations', 'vizData');
	
	if ($stat_bib_checkout_durations[$vn_bib_id]) {
		$va_series_labels = array_keys($stat_bib_checkout_durations[$vn_bib_id]);
		$va_series = array_values($stat_bib_checkout_durations[$vn_bib_id]);
?>
		<script type="text/javascript">
			var dataForCheckoutDurations = {
			  labels: <?php print json_encode($va_series_labels); ?>,
			  series: <?php print json_encode($va_series); ?>
			};

			var options = {
			 	labelInterpolationFnc: function(value, index) {
			 	  var t=0;
			 	  for(var x in dataForCheckoutDurations.series) { t += dataForCheckoutDurations.series[x]; }
				  if(dataForCheckoutDurations.series[index]/t <= 0.1) { return ''; }
				  return value;
				}
			};
			var $chart = $('#stat_bib_checkout_durations2');

			var $durationToolTip = $chart
			  .append('<div class="tooltip"></div>')
			  .find('.tooltip')
			  .hide();

			$chart.on('mouseenter', '.ct-series', function() {
				var $slice = $(this),
				value = $slice.find('path').attr('ct:value');
				var l = $slice.attr("class").replace("ct-series ct-series-", "").charCodeAt(0) - 97;
			
				sliceName = dataForCheckoutDurations.labels[l] + " (" + value + ")";		//$slice.find('text.ct-label').text()
				$durationToolTip.html(sliceName).show();
				
				
			});

			$chart.on('mouseleave', '.ct-series', function() {
			  $durationToolTip.hide();
			});

			$chart.on('mousemove', function(event) {
				var l = (event.originalEvent.layerX >= 0) ? event.originalEvent.layerX : event.offsetX;
				var t = (event.originalEvent.layerY >= 0) ? event.originalEvent.layerY : event.offsetY;
			  $durationToolTip.css({
				left: l - $durationToolTip.width() / 2 - 10,
				top: t - $durationToolTip.height() - 40
			  });
			});
			var responsiveOptions = [
			  ['screen and (min-width: 640px)', {
				chartPadding: 20,
				labelOffset: 60,
				labelDirection: 'explode'
			  }],
			  ['screen and (min-width: 1024px)', {
				labelOffset: 60,
				chartPadding: 20
			  }]
			];

			new Chartist.Pie('#stat_bib_checkout_durations', dataForCheckoutDurations, options, responsiveOptions);
			new Chartist.Pie('#stat_bib_checkout_durations2', dataForCheckoutDurations, options, responsiveOptions);

		</script>	
		<!-- Chartist -->					
<?php
	}
	
	$stat_bib_checkout_distribution = CompositeCache::fetch('stat_bib_checkout_distribution', 'vizData');
	$stat_avg_checkout_distribution = CompositeCache::fetch('stat_avg_checkout_distribution', 'vizData');
	if(is_array($stat_bib_checkout_distribution) && is_array($stat_avg_checkout_distribution)) {
?>
		<script type="text/javascript">
			var dataForCheckoutDistribution = {
			  labels: <?php print json_encode(array_keys($stat_bib_checkout_distribution[$vn_bib_id])); ?>,
			  series: [
						<?php print json_encode(array_values($stat_bib_checkout_distribution[$vn_bib_id])); ?>,
						<?php print json_encode(array_values($stat_avg_checkout_distribution)); ?>
					]
			};
			
			var options = {
				fullWidth: true,
				// As this is axis specific we need to tell Chartist to use whole numbers only on the concerned axis
				axisX: {
					onlyInteger: true
				},
				axisY: {
					onlyInteger: true
				},
			};
			
			
			var $chart = $('#stat_bib_checkout_distribution2');
			
			var $distToolTip = $chart
			  .append('<div class="tooltip"></div>')
			  .find('.tooltip')
			  .hide();

			$chart.on('mouseenter', '.ct-point', function() {
				var $pt = $(this),
				value = $pt.attr('ct:value');
				$distToolTip.html(value).show();
			});

			$chart.on('mouseleave', '.ct-series', function() {
			  $distToolTip.hide();
			});

			$chart.on('mousemove', function(event) {
				var l = (event.originalEvent.layerX >= 0) ? event.originalEvent.layerX : event.offsetX;
				var t = (event.originalEvent.layerY >= 0) ? event.originalEvent.layerY : event.offsetY;
			  $distToolTip.css({
				left: l - $distToolTip.width() / 2,
				top: t - $distToolTip.height()
			  });
			});
			
			var responsiveOptions = [
			  ['screen and (min-width: 640px)', {
				chartPadding: 0,
				labelOffset: 30,
				labelDirection: 'explode'
			  }],
			  ['screen and (min-width: 1024px)', {
				labelOffset: 30,
				chartPadding: 0
			  }]
			];

			new Chartist.Line('#stat_bib_checkout_distribution', dataForCheckoutDistribution, options, responsiveOptions);
			new Chartist.Line('#stat_bib_checkout_distribution2', dataForCheckoutDistribution, options, responsiveOptions);
		</script>
<?php
	}
?>														
		
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
								if ($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true)) == 'bib') {
									if ($va_author_ids = $t_object->get('ca_entities.entity_id', array('returnWithStructure' => true, 'restrictToRelationshipTypes' => array('author')))){
										foreach ($va_author_ids as $va_key => $va_author_id) {
											$t_entity = new ca_entities($va_author_id);
											$va_related_books[] = $t_entity->get('ca_objects', array('restrictToTypes' => array('bib'), 'restrictToRelationshipTypes' => array('author'), 'returnWithStructure' => true, 'sort' => 'ca_objects.preferred_labels.name_sort'));
										}
										$vs_book_buf.= "<div class='row'>";
										foreach ($va_related_books as $va_key => $va_related_book_pl) {
											foreach ($va_related_book_pl as $va_book_id => $va_related_book) {
												if ($va_related_book['object_id'] == $t_object->get('ca_objects.object_id')) { continue; }
												$vs_book_label = explode(':', $va_related_book['label']);
												$vs_author = $t_entity->get('ca_entities.preferred_labels');
												$t_book = new ca_objects($va_related_book['object_id']);
												$vs_pub_date = $t_book->get('ca_objects.publication_date');
												$vs_book_buf.= "<div class='col-sm-4 col-md-4 col-lg-4'><div class='bookButton'>".caNavLink($this->request, "<div class='bookLabel'>".$vs_book_label[0].'</div>'.$vs_author.'<br/>'.$vs_pub_date, '', '', 'Detail', 'objects/'.$va_related_book['object_id'])."</div></div>";
												$vs_is_related = true;
											}
										}
										$vs_book_buf.= "</div><!-- end row -->";
									}
								} else {
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
								<?php if ($vs_people_buf) {print '<li><a href="#entTab">Related People & Organizations</a></li>';} ?>			
								<?php if ($vs_book_buf && $vs_is_related) {print '<li><a href="#bookTab">Related Books</a></li>';} ?>
								<?php if ($vs_doc_buf) {print '<li><a href="#docTab">Related Documents</a></li>';} ?>
							</ul>
							<div id='circTab' <?php print $vs_style; ?>>
								<table id='circTable' class="display" style='width:100%;'>
									<thead class='titleBar' >
										<tr>
											<th>Borrower Name<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>											
											<th>Volume<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
											<th>Date Out<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
											<th>Date In<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
											<th>Fine<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></div>
											<th>Transcribed<br/>Title<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>				
											<th>Rep.<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
											<th>Ledger<i class='fa fa-chevron-up'></i><i class='fa fa-chevron-down'></i></th>
										</tr>
										
									</thead><!-- end row -->
									<tbody>
<?php			
									print $vs_buf;
?>		
									</tbody>
								</table><!-- end row -->
							</div><!-- end circTab -->			
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
    	$('#circTable').dataTable({
    		"order": [[ 2, "asc" ]],
    		columnDefs: [{ 
       			type: 'title-string', targets: [0]
       		}, { 
       			type: 'natural', targets: [1,4,5] 
    		}],
     		paging: false
    	});
	});
	
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