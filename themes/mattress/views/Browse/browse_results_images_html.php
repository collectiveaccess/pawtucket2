<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_images_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_hits_per_block  = 48;
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	
	$va_views			= $this->getVar('views');
	$vs_current_view	= $this->getVar('view');
	$va_view_icons		= $this->getVar('viewIcons');
	$vs_current_sort	= $this->getVar('sort');
	
	$t_instance			= $this->getVar('t_instance');
	$vs_table 			= $this->getVar('table');
	$vs_pk				= $this->getVar('primaryKey');
	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

	$vb_ajax			= (bool)$this->request->isAjax();
	
		$vn_col_span = 3;
		$vn_col_span_sm = 4;
		$vn_col_span_sm = 2;
		$vb_refine = false;
		if(is_array($va_facets) && sizeof($va_facets)){
			$vb_refine = true;
			$vn_col_span = 3;
			$vn_col_span_sm = 6;
			$vn_col_span_xs = 6;
		}
		if ($vn_start < $qr_res->numHits()) {
			$vn_c = 0;
			$qr_res->seek($vn_start);
			
			$vs_add_to_lightbox_msg = addslashes(_t('Add to lightbox'));
			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
				$vn_id 					= $qr_res->get("{$vs_table}.{$vs_pk}");
				$vs_idno_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.idno"), '', $vs_table, $vn_id);
				if($vs_table == "ca_entities") {
					$va_related_objects = $qr_res->get('ca_objects.object_id', array('returnAsArray' => true, 'restrictToTypes' => array('image')));
					$va_first_object_id = $va_related_objects[0];
					$t_object = new ca_objects($va_first_object_id);
					$va_rep = $t_object->get('ca_object_representations.media.browse');
				} else if ($vs_table == "ca_occurrences") {
					$va_related_objects = $qr_res->get('ca_objects.object_id', array('returnAsArray' => true, 'restrictToTypes' => array('image')));
					$va_first_object_id = $va_related_objects[0];
					$t_object = new ca_objects($va_first_object_id);
					$va_rep = $t_object->get('ca_object_representations.media.browse');
				} else if ($vs_table == "ca_collections") {
					$va_related_objects = $qr_res->get('ca_objects.object_id', array('returnAsArray' => true, 'restrictToTypes' => array('image')));
					$va_first_object_id = $va_related_objects[0];
					$t_object = new ca_objects($va_first_object_id);
					$va_rep = $t_object->get('ca_object_representations.media.browse');				
				} else {
					$va_rep = $qr_res->get('ca_object_representations.media.browse');	
				}
				$va_label_text = $qr_res->get("{$vs_table}.preferred_labels.name");
				$va_label_text_str = strlen($va_label_text) > 75 ? substr($va_label_text,0,70)."..." : $va_label_text;
				$vs_label_detail_link 	= caDetailLink($this->request, $va_label_text_str, '', $vs_table, $vn_id);
				
				$vs_rep_detail_link 	= caDetailLink($this->request, $va_rep, '', $vs_table, $vn_id);				
				$vs_add_to_set_url		= caNavUrl($this->request, '', 'Lightbox', 'addItemForm', array($vs_pk => $vn_id));

				$vs_expanded_info = $qr_res->getWithTemplate($vs_extended_info_template);

				print "
	<div class='bResultItemCol '>
		<div class='bResultItem' {$va_cell_width}>
			<div class='bResultItemContent'><div class='text-center bResultItemImg' >{$vs_rep_detail_link}</div>
				<div class='bResultItemText'>";
				if ($vs_table == "ca_entities") {	
					print "<div class='artistName'>".$vs_label_detail_link."</div>";	
				} else if ($vs_table == "ca_occurrences") {
					print $vs_label_detail_link;
					if ($qr_res->get('ca_occurrences.event_dates')) {
						print "<div class='date'>".$qr_res->get('ca_occurrences.event_dates')."</div>";
					}
				} else {
					print $vs_label_detail_link;
				}
				print "					
				</div><!-- end bResultItemText -->
			</div><!-- end bResultItemContent -->
			<div class='bResultItemExpandedInfo' id='bResultItemExpandedInfo{$vn_id}'>
				<hr>
				{$vs_expanded_info}
				<a href='#' onclick='caMediaPanel.showPanel(\"{$vs_add_to_set_url}\"); return false;' title='{$vs_add_to_lightbox_msg}'></a>
			</div><!-- bResultItemExpandedInfo -->
		</div><!-- end bResultItem -->
	</div><!-- end col -->";
				
				$vn_c++;
			}
			print "<div class='clearfix'></div>";
			print caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view, 'l' => $this->getVar('letter')));
		}
?>