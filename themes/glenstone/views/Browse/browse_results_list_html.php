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
	
		$vn_col_span = 4;
		$vn_col_span_sm = 4;
		$vn_col_span_xs = 4;
		$vb_refine = false;
		if(is_array($va_facets) && sizeof($va_facets)){
			$vb_refine = true;
			$vn_col_span = 6;
			$vn_col_span_sm = 6;
			$vn_col_span_xs = 6;
		}
		if ($vn_start < $qr_res->numHits()) {
			$vn_c = 0;
			$qr_res->seek($vn_start);
			
			if ($vs_table != 'ca_objects') {
				$va_ids = array();
				while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
					$va_ids[] = $qr_res->get("{$vs_table}.{$vs_pk}");
				}
			
				$qr_res->seek($vn_start);
				$va_images = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids);
			} else {
				$va_images = null;
			}
			
			$vs_add_to_lightbox_msg = addslashes(_t('Add to lightbox'));
			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
			$vn_id 					= $qr_res->get("{$vs_table}.{$vs_pk}");
				if ($qr_res->get('ca_objects.type_id') == 30) {
					$vs_label_author	 	= "<p class='artist'>".$qr_res->get("ca_entities.preferred_labels.name", array('restrictToRelationshipTypes' => 'author'))."</p>";
					$vs_label_detail 	= "<p style='text-decoration:underline;'>".$qr_res->get("{$vs_table}.preferred_labels.name")."</p>";
					$vs_label_pub 	= "<p>".$qr_res->get("ca_objects.publication_description")."</p>";
					$vs_label_call 	= "<p>".$qr_res->get("ca_objects.call_number")."</p>";
					$vs_label_status 	= "<p>".$qr_res->get("ca_objects.purchase_status")."</p>";
					$vs_idno_detail_link 	= "";
					$vs_library_info = $vs_label_detail.$vs_label_author.$vs_label_pub.$vs_label_call.$vs_label_status;

				} elseif ($qr_res->get('ca_objects.type_id') == 28) {
					$vs_label_artist	 	= "<p class='artist lower'>".$qr_res->get("ca_entities.preferred_labels.name", array('restrictToRelationshipTypes' => 'artist'))."</p>";
					$vs_label_detail_link 	= "<p><i>".$qr_res->get("{$vs_table}.preferred_labels.name")."</i>, ".$qr_res->get("ca_objects.creation_date")."</p>";
					if ($qr_res->get('is_deaccessioned') && ($qr_res->get('deaccession_date', array('getDirectDate' => true)) <= caDateToHistoricTimestamp(_t('now')))) {
						$vs_idno_detail_link = "<div class='searchDeaccessioned'>"._t('Deaccessioned %1', $qr_res->get('deaccession_date'))."</div>\n";
					} else {
						$vs_idno_detail_link = "";
					}				
				}else {
					$vs_label_artist	 	= "<p class='artist lower'>".$qr_res->get("ca_entities.preferred_labels.name", array('restrictToRelationshipTypes' => 'artist'))."</p>";
					$vs_label_detail_link 	= "<p>".$qr_res->get("{$vs_table}.preferred_labels.name")."</p>";
					$vs_idno_detail_link 	= "<p class='idno'>".$qr_res->get("{$vs_table}.idno")."</p>";
				}
				$vs_image = ($vs_table === 'ca_objects') ? $qr_res->getMediaTag("ca_object_representations.media", 'small', array('checkAccess' => $va_access_values)) : $va_images[$vn_id];
				
				$vs_rep_detail_link 	= caDetailLink($this->request, $vs_image, '', $vs_table, $vn_id);	
				
				$vs_add_to_set_url		= caNavUrl($this->request, '', 'Sets', 'addItemForm', array($vs_pk => $vn_id));

				$vs_expanded_info = $qr_res->getWithTemplate($vs_extended_info_template);

				print "
	<div class='bResultListItemCol col-xs-{$vn_col_span_xs} col-sm-{$vn_col_span_sm} col-md-{$vn_col_span}'>
		<div class='bResultListItem' onmouseover='jQuery(\"#bResultListItemExpandedInfo{$vn_id}\").show();'  onmouseout='jQuery(\"#bResultListItemExpandedInfo{$vn_id}\").hide();'>
			<div class='bResultListItemContent'><div class='text-center bResultListItemImg'>{$vs_rep_detail_link}</div>
				<div class='bResultListItemText'>
					{$vs_label_artist}{$vs_label_detail_link}{$vs_idno_detail_link}{$vs_library_info}
				</div><!-- end bResultListItemText -->
			</div><!-- end bResultListItemContent -->
			<div class='bResultListItemExpandedInfo' id='bResultListItemExpandedInfo{$vn_id}'>
				<hr>
				{$vs_expanded_info}
				<a href='#' onclick='caMediaPanel.showPanel(\"{$vs_add_to_set_url}\"); return false;' title='{$vs_add_to_lightbox_msg}'><span class='glyphicon glyphicon-folder-open'></span></a>
			</div><!-- bResultListItemExpandedInfo -->
		</div><!-- end bResultListItem -->
	</div><!-- end col -->";
				
				$vn_c++;
			}
			
			print caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view));
		}
?>