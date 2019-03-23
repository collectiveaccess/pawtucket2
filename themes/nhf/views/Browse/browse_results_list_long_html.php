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
	$vn_row_id		 	= (int)$this->getVar('row_id');			// id of last visited detail item so can load to and jump to that result - passed in back button
	$vb_row_id_loaded 	= false;
	if(!$vn_row_id){
		$vb_row_id_loaded = true;
	}
	
	$va_views			= $this->getVar('views');
	$vs_current_view	= $this->getVar('view');
	$va_view_icons		= $this->getVar('viewIcons');
	$vs_current_sort	= $this->getVar('sort');
	
	$t_instance			= $this->getVar('t_instance');
	$vs_table 			= $this->getVar('table');
	$vs_pk				= $this->getVar('primaryKey');
	$o_config = $this->getVar("config");	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

	$vb_ajax			= (bool)$this->request->isAjax();

	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";

	
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	$va_ids_with_video = array();
	if($vs_table == "ca_collections"){
		$va_ids_with_video = nhfCollectionsWithClips($this->request);
	}else{
		$va_ids_with_video = nhfOccWithClips($this->request);
	}
	$vs_search_term = "";
	$va_search_term_pieces = array();
	$va_search_term_pieces_replace = array();
	foreach($va_criteria as $va_criterion) {
		if ($va_criterion['facet_name'] == '_search') {
			$vs_search_term = $va_criterion['value'];
			break;
		}
	}
	if($vs_search_term){
		$va_search_term_pieces = explode(" ", $vs_search_term);
		if(sizeof($va_search_term_pieces)){
			foreach($va_search_term_pieces as $vs_search_term_piece){
				$va_search_term_pieces_replace[] = "<span class='highlightSearchTerm'>".$vs_search_term_piece."</span>";
			}
		}
	}
		if ($vn_start < $qr_res->numHits()) {
			$vn_item_num_label = $vn_start + 1;
			$vn_c = 0;
			$vn_results_output = 0;
			$qr_res->seek($vn_start);
			
			$t_list_item = new ca_list_items();
			$vs_last_letter = "";
			while($qr_res->nextHit()) {
				if($vn_c == $vn_hits_per_block){
					if($vb_row_id_loaded){
						break;
					}else{
						$vn_c = 0;
					}
				}
				
				$vn_id = $qr_res->get("{$vs_table}.{$vs_pk}");
				if($vn_id == $vn_row_id){
					$vb_row_id_loaded = true;
				}
				# --- check if this result has been cached
				# --- key is MD5 of table, id, view, refine(vb_refine)
				$vs_cache_key = md5($vs_table.$vn_id."list_long".$vb_refine);
				if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_result')){
					print ExternalCache::fetch($vs_cache_key, 'browse_result');
				}else{
					$vs_collection = "";
					$vs_label = $qr_res->get("{$vs_table}.preferred_labels");
					# --- bold term in label
					if(sizeof($va_search_term_pieces)){
						$vs_label = str_ireplace($va_search_term_pieces, $va_search_term_pieces_replace, $vs_label);
					}
					
					$vs_label_detail_link 	= caDetailLink($this->request, $vs_label, '', $vs_table, $vn_id);
					if($vs_table == "ca_collections"){
						$vs_description =  $qr_res->get('ca_collections.collection_summary');
					}else{
						$vs_description =  $qr_res->get('ca_occurrences.pbcoreDescription.description_text');
						$vs_collection = $qr_res->getWithTemplate("<unit relativeTo='ca_collections' delimiter=', '><l>^ca_collections.preferred_labels.name</l></unit>");
						if($vs_collection){
							$vs_collection = "<br/><b>Part of:</b> ".$vs_collection;
						}
					}
					if(strlen($vs_description) > 185){
						$vs_description = trim(mb_substr($vs_description, 0, 185))."...";
					}
					# --- bold term in description
					if(sizeof($va_search_term_pieces)){
						$vs_description = str_ireplace($va_search_term_pieces, $va_search_term_pieces_replace, $vs_description);
					}
					$vs_has_video = "";
					if(in_array($vn_id, $va_ids_with_video)){
						$vs_has_video = "<span class='glyphicon glyphicon-facetime-video'></span>";
					}
					$vs_result_output = "<div class='result'>".$vn_item_num_label.") ".$vs_label_detail_link." ".$vs_has_video."
						<div class='resultDescription'>".$vs_description.caGetThemeGraphic($this->request, 'cross.gif', array('style' => 'margin: 0px 3px 0px 15px;')).caDetailLink($this->request, _t("more"), '', $vs_table, $vn_id).$vs_collection."</div><!-- end description --></div>\n";
					
					ExternalCache::save($vs_cache_key, $vs_result_output, 'browse_result');
					print $vs_result_output;
				}	
				$vn_item_num_label++;			
				$vn_c++;
				$vn_results_output++;
			}
			
			print "<div style='clear:both'></div>".caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_results_output, 'key' => $vs_browse_key, 'view' => $vs_current_view));
		}
?>