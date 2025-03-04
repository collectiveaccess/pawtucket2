<?php
	$t_collection 			= $this->getVar('t_collection');
	$ps_template 			= $this->getVar('display_template');
	$ps_ancestor_template 	= $this->getVar('ancestor_template');
	$vs_page_title 			= $this->getVar('page_title');
	$vs_intro_text 			= $this->getVar('intro_text');
	$va_open_by_default 	= $this->getVar('open_by_default');
	
	$va_user_access = caGetUserAccessValues($this->request);
	
	$pn_parent_id = $this->getVar('parent_id');
	$t_parent = $this->getVar('t_parent');
	
	$qr_top_level_collections = ca_collections::find(array('parent_id' => $pn_parent_id), array('returnAs' => 'searchResult', 'sort' => 'ca_collections.idno_sort'));
	
?>

	<div id='findingAidCont'>
<?php	

	print "<div class='selected'><ol class='breadcrumb'><li><a href='#'>Milton Glaser Archives</a></li><li><a href='#'>Collections </a></li><li class='active'>Finding Aid</li></ol>";


	if ($t_parent) {
		print "<h1>".$t_parent->get('ca_collections.preferred_labels')."</h1>";
	} else {
		print "<h1>".$t_collection->get('ca_collections.preferred_labels')."</h1>";
	}
	
	/*
	print "<h6>Finding Aid</h6>"; 
	
	print "<div class='collHeader' style='margin: 5px 0 30px 0px'>";
	$va_links = array(caNavLink($this->request, _t('Library &amp; Archive'), '', '*', '*' ,'*'));
	
	*/
	
/*	if ($t_parent) {
		//
		// Print ancestor collections if parent is set
		//
		$va_ancestor_ids = array_reverse($t_parent->getHierarchyAncestors($pn_parent_id, array('includeSelf' => false, 'idsOnly' => true, 'checkAccess' => $va_user_access)));
		if (is_array($va_ancestor_ids) && sizeof($va_ancestor_ids)) {
			$qr_ancestors = caMakeSearchResult('ca_collections', $va_ancestor_ids);
			while($qr_ancestors->nextHit()) {
				$va_links[] = $qr_ancestors->getWithTemplate($ps_ancestor_template, array('linkTarget' => 'findingaid'));
			}
		}
	}
	$va_links[sizeof($va_links)-1] = "<span class='findingAidSelectedParent'>".$va_links[sizeof($va_links)-1]."</span>";
	print join("<br/><i class='fa fa-arrow-right collection'></i> ", $va_links);
	print "</div>"; */

	//
	// Output metadata
	//
	if ($t_parent) {
/*		if ($t_parent->get('ca_collections.extent.extent_amount')) {
			print "<h6>Extent</h6>";
			print "<p>".$t_parent->getWithTemplate('^ca_collections.extent.extent_amount')."</p>";
		}		*/
		if ($va_abstract = $t_parent->get('ca_collections.abstract')) {
			print "<h6>Abstract</h6>";
			print "<p>".$va_abstract."</p>";
		}
		if ($t_parent->get('ca_collections.dates.dates_value')) {
			print "<h6>Dates</h6>";
			print "<p>".$t_parent->getWithTemplate('^ca_collections.dates.dates_value')."</p>";
		}	
		if ($va_description = $t_parent->get('ca_collections.gen_physical_description')) {
			print "<h6>General Physical Description</h6>";
			print "<p>".$va_description."</p>";
		} 

/*		
		if ($va_processor = $t_parent->get('ca_collections.processor')) {
			print "<h6>Processed</h6>";
			print "<p>".$va_processor."</p>";
		} 
*/
		if ($va_scope_contents = $t_parent->get('ca_collections.scope_contents')) {
			print "<h6>Scope and Contents</h6>";
			print "<p>".$va_scope_contents."</p>";
		}		

		if ($va_arrangement = $t_parent->get('ca_collections.arrangement')) {
			print "<h6>Arrangement</h6>";
			print "<p>".$va_arrangement."</p>";
		}

		if ($va_restriction = $t_parent->get('ca_collections.restrictions')) {
			print "<h6>Restrictions</h6>";
			print "<p>".$va_restriction."</p>";
		}
		if ($va_copyright = $t_parent->get('ca_collections.copyright_text')) {
			print "<h6>Copyright</h6>";
			print "<p>".$va_copyright."</p>";
		}	
		if ($va_citation = $t_parent->get('ca_collections.citation')) {
			print "<h6>Citation</h6>";
			print "<p>".$va_citation."</p>";
		}
		if ($va_acquisition = $t_parent->get('ca_collections.acquisition_info')) {
			print "<h6>Acquisition Information</h6>";
			print "<p>".$va_acquisition."</p>";
		}

	}
	
	
	print "<br><br><h6>Container list</h6>";
	
	print "<div id='findingaid-toc'></div>";
	
	//
	// Output the hierarchy down to lowest collection level
	//
	if ($qr_top_level_collections) {
		while($qr_top_level_collections->nextHit()) { 
			$vn_top_level_collection_id = $qr_top_level_collections->get('ca_collections.collection_id', array('checkAccess' => $va_user_access));
			$va_hierarchy = $t_collection->hierarchyWithTemplate($ps_template, array('sort' => 'ca_collections.idno_sort', 'includeRoot' => true, 'linkTarget' => 'findingaid', 'collection_id' => $vn_top_level_collection_id, 'checkAccess' => $va_user_access));


			$vn_last_level = 0;
			foreach($va_hierarchy as $vn_i => $va_hierarchy_item) {

				$vn_id = $va_hierarchy_item['id'];

				if ((!$t_parent) && ($va_hierarchy_item['level'] != 0) && ($va_hierarchy_item['level'] != 1)) {
					continue;
				}
				print "<div class='collHeader' >"; //style='margin-left: ".($va_hierarchy_item['level'] * 35)."px; clear:both;'
				if (($va_hierarchy_item['level']) == 0) {
					print "<div id='series-collection-{$vn_id}' class='toc-series'>";
				} else {
					// $va_opacity = "style='opacity: .".(90 - ($va_hierarchy_item['level'] * 10))."' ";
					$vn_ilevel = ($va_hierarchy_item['level'] ? $va_hierarchy_item['level'] : 0);
					print "<div id='series-collection-{$vn_id}' class='toc-series' data-level='".$vn_ilevel."'>"; // <i class='fa fa-angle-right finding-aid' {$va_opacity}></i>
				}
				print "{$va_hierarchy_item['display']}\n";
						
				if ($va_hierarchy_item['level'] == 0) {
					print "</div><div class='collBlock".$vn_top_level_collection_id."'>";
				} else {
					print "</div>";
				}
				//
				// Output objects
				//
				
				$t_this_level = new ca_collections($va_hierarchy_item['id']);
				if ($t_parent) {
					if (($t_this_level)) { //  && ($t_parent->get('ca_collections.type_id') != 104) && ($t_parent->get('ca_collections.type_id') != 281)
						if (is_array($va_ids = $t_this_level->get('ca_objects.object_id', array('returnAsArray'=> true, 'sort' => 'ca_objects.preferred_labels', 'checkAccess' => array(1,2)))) && sizeof($va_ids)) {
							$qr_objects = caMakeSearchResult('ca_objects', $va_ids);
							
							print '<table class="table findingaid">
								<thead>
									<tr>
										<th class="col_box_location" colspan="2">LOC</th>
										<th class="col_title">TITLE</th>
										<th class="col_date">DATE</th>
									</tr>
								</thead>
								<tbody>';

								while($qr_objects->nextHit()) {

									print "<tr>";
										print "<td>".($qr_objects->get('ca_objects.location.box') ? "B".$qr_objects->get('ca_objects.location.box'): "").' '.($qr_objects->get('ca_objects.location.drawer') ? "D".$qr_objects->get('ca_objects.location.drawer') : "")."</td>";
										print "<td>".($qr_objects->get('ca_objects.location.folder') ? "F".$qr_objects->get('ca_objects.location.folder') : "").' '.($qr_objects->get('ca_objects.location.item_location') ? "I".$qr_objects->get('ca_objects.location.item_location') : "")."</td>"; 
										if ($qr_objects->get('access') == 1) {
											// returnAsLink to TRUE in order to link object records after finding aids are live
											print "<td>".$qr_objects->get('ca_objects.preferred_labels.name', array('returnAsLink' => false));
										} else {
											print "<td>".$qr_objects->get('ca_objects.preferred_labels.name');
										}
										if ($vs_description_public = $qr_objects->get('ca_objects.description_public')) {
											print ", {$vs_description_public}";
										}						
										if ($vs_materials = $qr_objects->get('ca_objects.materials')) {
											print ", {$vs_materials}";
										}

										if ($vs_dimensions_width = $qr_objects->get('ca_objects.dimensions.dimensions_width')) {

										print ", <span style='white-space: nowrap'>";
											$vs_dimensions_height = $qr_objects->get('ca_objects.dimensions.dimensions_height');
											print "{$vs_dimensions_width} &times; {$vs_dimensions_height}";
											if ($vs_dimensions_depth = $qr_objects->get('ca_objects.dimensions.dimensions_depth')) { print " &times; {$vs_dimensions_depth}"; }
										print "</span>";

										} elseif ($vs_dimensions = $qr_objects->get('ca_objects.dimensions_as_text')) { 
										print ", <span style='white-space: nowrap'>";
											print ", {$vs_dimensions}";										
										print "</span>";

										}


										print "</td>";
								
										print "<td>".(($vs_date = $qr_objects->get('ca_objects.dates.dates_value', ['returnAsArray' => true])) ? join("; ", $vs_date) : $qr_objects->get('ca_objects.date_as_text'))."</td>"; 
									print "</tr>\n";

								}

								print "</tbody>
							</table>";
						}
					} 
				} // end output objects	
				
				print "</div><!-- end collHeader -->";				
				$v_i++;			
			}
			print "</div><!-- end collBlock-->";
		}
	} else {
		//print _t('No collections available');
	}
	
	//
	// Output objects
	//
	if (!$qr_top_level_collections) {
		if (($t_parent) && ($t_parent->get('ca_collections.type_id') != 104)) {
			if (is_array($va_ids = $t_parent->get('ca_objects.object_id', array('returnAsArray'=> true, 'sort' => 'ca_objects.idno', 'checkAccess' => array(1,2)))) && sizeof($va_ids)) {
				$qr_objects = caMakeSearchResult('ca_objects', $va_ids);
?>
		<table class="table findingaid" style='margin-left:0px;'>
			<thead>
				<tr>
					<th>&nbsp;</th>
					<th>&nbsp;</th>
					<th>TITLE</th>
					<th>DATE</th>
				</tr>
			</thead>
			<tbody>
<?php
				while($qr_objects->nextHit()) {
?>
			<tr>
<?php			
				print "<td>".($qr_objects->get('ca_objects.location.box') ? "B".$qr_objects->get('ca_objects.location.box'): "").' '.($qr_objects->get('ca_objects.location.drawer') ? "D".$qr_objects->get('ca_objects.location.drawer') : "")."</td>";
				print "<td>".($qr_objects->get('ca_objects.location.folder') ? "F".$qr_objects->get('ca_objects.location.folder') : "").' '.($qr_objects->get('ca_objects.location.item_location') ? "I".$qr_objects->get('ca_objects.location.item_location') : "")."</td>";
?>				
				<td>
<?php
					if ($qr_objects->get('access') == 1) {
						print $qr_objects->get('ca_objects.preferred_labels.name', array('returnAsLink' => true));
					} else {
						print $qr_objects->get('ca_objects.preferred_labels.name');
					}
					if ($vs_description_public = $qr_objects->get('ca_objects.description_public')) {
						print ", {$vs_description_public}";
					}							
					if ($vs_materials = $qr_objects->get('ca_objects.materials')) {
						print ", {$vs_materials}";
					}
					if ($vs_dimensions = $qr_objects->get('ca_objects.dimensions_as_text')) {
						print ", {$vs_dimensions}";
					}

?>
				</td>
				<td><?php print ($vs_date = $qr_objects->get('ca_objects.dates_value')) ? $vs_date : $qr_objects->get('ca_objects.date_as_text'); ?></td>
			</tr>
<?php
				}
?>

			</tbody>
		</table>
<?php
			}
		} // end output objects	
	}						
?>
	</div>
