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
	$vs_result_text_template = caGetOption('listResultTextTemplate', $va_options, null);
	$vs_interstitial_text_template = caGetOption('interstitialMovementTextTemplate', $va_options, null);
	
	$vb_ajax			= (bool)$this->request->isAjax();
	$vb_show_filter_panel = $this->request->getParameter("showFilterPanel", pInteger);
	$vn_acquisition_movement_id = (int)$this->request->getParameter("acquisition_movement_id", pInteger);
	$vs_detail_type = $this->request->getParameter("detailType", pString);
	if($vs_detail_type){
		$vb_dontSetFind = 1;
	}

	$o_icons_conf = caGetIconsConfig();
	#$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	#if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
	#	$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	#}
	#$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";
	
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	
		$vn_col_span = 6;
		$vn_col_span_sm = 12;
		$vn_col_span_xs = 12;
		$vb_refine = false;
		if(is_array($va_facets) && sizeof($va_facets)){
			$vb_refine = true;
			$vn_col_span = 6;
			$vn_col_span_sm = 12;
			$vn_col_span_xs = 12;
		}
		if ($vn_start < $qr_res->numHits()) {
			$vn_c = 0;
			$vn_results_output = 0;
			$qr_res->seek($vn_start);
			
			if ($vs_table != 'ca_objects') {
				$va_ids = array();
				while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
					$va_ids[] = $qr_res->get("{$vs_table}.{$vs_pk}");
				}
			
				$qr_res->seek($vn_start);
				$va_images = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids, array('version' => 'small', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_options, null), 'objectTypes' => caGetOption('selectMediaUsingTypes', $va_options, null), 'checkAccess' => $va_access_values));
			} else {
				$va_images = null;
			}
			
			$t_list_item = new ca_list_items();
			while($qr_res->nextHit()) {
				if($vn_c == $vn_hits_per_block){
					if($vb_row_id_loaded){
						break;
					}else{
						$vn_c = 0;
					}
				}
				$vn_id 					= $qr_res->get("{$vs_table}.{$vs_pk}");
				if($vn_id == $vn_row_id){
					$vb_row_id_loaded = true;
				}
				# --- check if this result has been cached
				# --- key is MD5 of table, id, view, refine(vb_refine)
				$vs_cache_key = md5($vs_table.$vn_id."list".$vb_refine);
				if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_result')){
					print ExternalCache::fetch($vs_cache_key, 'browse_result');
				}else{
				
					$vs_idno_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.idno"), '', $vs_table, $vn_id);
					#$vs_type_placeholder = "";
					$vs_typecode = "";
					switch($vs_table){
						case "ca_objects":
							$vs_image = $qr_res->getMediaTag("ca_object_representations.media", 'small', array("checkAccess" => $va_access_values));
						break;
						# ---------------------
						case "ca_occurrences":
						case "ca_movements":	
							# archival materials and acquisitions have media in field not reps
							$vs_image = $qr_res->get($vs_table.'.media.media_media.large');
						break;
						# ---------------------
						case "ca_entities":
							$vs_image = $va_images[$vn_id];
						break;
						# ---------------------
					} 
				
					#if(!$vs_image){
					#	if ($vs_table == 'ca_objects') {
					#		$t_list_item->load($qr_res->get("type_id"));
					#		$vs_typecode = $t_list_item->get("idno");
					#		if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
					#			$vs_image = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
					#		}else{
					#			$vs_image = $vs_default_placeholder_tag;
					#		}
					#	}else{
					#		$vs_image = $vs_default_placeholder_tag;
					#	}
					#}
					
					$vs_add_to_set_link = "";
					if(($vs_table == 'ca_objects') && is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
						$vs_add_to_set_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array($vs_pk => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a>";
					}
					if($vn_acquisition_movement_id){
						# --- results are being loaded on Acquisition detail (ca_movement detail) so need to show interstitial information
						$t_obj_x_movement = new ca_movements_x_objects(array("movement_id" => $vn_acquisition_movement_id, "object_id" => $vn_id));
						$vs_interstitial = "<br/>".$t_obj_x_movement->getWithTemplate($vs_interstitial_text_template);
					}
					$vs_result_output = "
						<div class='resultItemColList ".(($vn_acquisition_movement_id) ? "resultItemDetailExtended " : "")."col-xs-{$vn_col_span_xs} col-sm-{$vn_col_span_sm} col-md-{$vn_col_span}'>".
						caDetailLink($this->request, 
							"<div class='resultContentList'>
								<div class='resultImageList'>".$vs_image."</div>
								<div class='resultTextList'>".$qr_res->getWithTemplate($vs_result_text_template).$vs_interstitial."</div>
								{$vs_add_to_set_link}<div class='bSetsSelectMultiple'><input type='checkbox' name='object_ids' value='{$vn_id}'></div>
								<div style='clear:both;'></div>
							</div>", '', $vs_table, $vn_id, null, array("title" => "View: ".strip_tags($qr_res->get($vs_table.".preferred_labels"))))."
						</div><!-- end col -->\n";
						
					ExternalCache::save($vs_cache_key, $vs_result_output, 'browse_result', $o_config->get("cache_timeout"));
					print $vs_result_output;
				}				
				$vn_c++;
				$vn_results_output++;
			}
			
			$params = array('s' => $vn_start + $vn_results_output, 'key' => $vs_browse_key, 'view' => $vs_current_view, 'sort' => $vs_current_sort, 'acquisition_movement_id' => $vn_acquisition_movement_id, '_advanced' => $this->getVar('is_advanced') ? 1  : 0, "dontSetFind" => $vb_dontSetFind);
			if($vs_detail_type) {
				$params["detailType"] = $vs_detail_type;
			}
			print "<div style='clear:both'></div>".caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', $params);
		}
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		if($("#bSetsSelectMultipleButton").is(":visible")){
			$(".bSetsSelectMultiple").show();
		}
	});
</script>
