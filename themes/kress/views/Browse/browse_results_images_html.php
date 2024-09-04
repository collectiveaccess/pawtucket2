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

	AssetLoadManager::register('mirador');	
 
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
	$va_access_values = caGetUserAccessValues($this->request);
	$o_config = $this->getVar("config");	
	
	$va_options			= $this->getVar('options');
	$vs_result_text_template = caGetOption('imageResultTextTemplate', $va_options, null);
	
	$vs_detail_type = $this->request->getParameter("detailType", pString);
	if($vs_detail_type){
		$vb_dontSetFind = 1;
	}
	
	$vb_ajax			= (bool)$this->request->isAjax();

	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);

	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x' aria-label='placeholder image'></i>";
	}
	$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";
		

		$vn_col_span = 3;
		$vn_col_span_sm = 4;
		$vb_refine = false;
		if(is_array($va_facets) && sizeof($va_facets)){
			$vb_refine = true;
			$vn_col_span = 3;
			$vn_col_span_sm = 6;
			$vn_col_span_xs = 6;
		}
		if ($vn_start < $qr_res->numHits()) {
			$vn_c = 0;
			$vn_results_output = 0;
			$qr_res->seek($vn_start);
			
			#if ($vs_table != 'ca_objects') {
			#	$va_ids = array();
			#	while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
			#		$va_ids[] = $qr_res->get($vs_pk);
			#		$vn_c++;
			#	}
			#	$va_images = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids, array('version' => 'small', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_options, null), 'objectTypes' => caGetOption('selectMediaUsingTypes', $va_options, null), 'checkAccess' => $va_access_values));
			#
			#	$vn_c = 0;	
			#	$qr_res->seek($vn_start);
			#}
			
			$t_list_item = new ca_list_items();
			while($qr_res->nextHit()) {
				$vs_compare_link = "";
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
				# --- key is MD5 of table, id, list, refine(vb_refine)
				$vb_no_media = false;
				$vs_cache_key = md5($vs_table.$vn_id."images".$vb_refine);
				if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_result')){
					print ExternalCache::fetch($vs_cache_key, 'browse_result');
				}else{			
					$vs_idno_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.idno"), '', $vs_table, $vn_id);
					$vs_thumbnail = "";
					$vs_type_placeholder = "";
					$vs_typecode = "";
					if ($vs_table == 'ca_objects') {
						if(!($vs_thumbnail = $qr_res->get('ca_object_representations.media.medium', array("checkAccess" => $va_access_values)))){
							$t_list_item->load($qr_res->get("type_id"));
							$vs_typecode = $t_list_item->get("idno");
							if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
								$vs_thumbnail = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
							}else{
								$vs_thumbnail = $vs_default_placeholder_tag;
							}
							$vb_no_media = true;
						}
					} else {
						# archival materials and acquisitions have media in field not reps
						if($vs_tmp = $qr_res->get($vs_table.'.media.media_media.medium')){
							$vs_thumbnail = $vs_tmp;
						}else{
							$vs_thumbnail = $vs_default_placeholder_tag;
							$vb_no_media = true;
						}
					}
					$vs_add_to_set_link = "";
					if(($vs_table == 'ca_objects') && is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
						$vs_add_to_set_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array($vs_pk => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a>";
					}
					
#$vs_rep_detail_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'objects', $vn_id, array('overlay' => 1))."\"); return false;'>".$vs_thumbnail."</a>";

					if(!$vb_no_media){
						if($vs_table == "ca_objects"){
							$vs_compare_link = "<a href='#' class='compare_link btn btn-default btn-small' data-id='object:{$vn_id}' title='Compare Images'><i class='fa fa-clone' aria-hidden='true'></i></a>";
						}else{
							$media_value_ids = $qr_res->get($vs_table.".media.media_media.value_id", ["returnAsArray" => true]);
							if(is_array($media_value_ids) && sizeof($media_value_ids)){
								$vs_compare_link = "<a href='#' class='compare_link btn btn-default btn-small' data-id='attribute:{$media_value_ids[0]}' title='Compare Images'><i class='fa fa-clone' aria-hidden='true'></i></a>";
							}
						}
					}

# --- link to preview in overlay
#					$vs_result_output = "
#						<div class='resultItemColImg col-xs-{$vn_col_span_xs} col-sm-{$vn_col_span_sm} col-md-{$vn_col_span}'><a href='#' onclick='caMediaPanel.showPanel(\"".
#						caDetailUrl($this->request, $vs_table, $vn_id)."\"); return false;'><div class='resultContentImg'>
#								<div class='resultImageImg'>".$vs_thumbnail."</div>
#								<div class='resultTextImg'>".$qr_res->getWithTemplate($vs_result_text_template)."</div>
#								{$vs_add_to_set_link}<div class='bSetsSelectMultiple'><input type='checkbox' name='object_ids' value='{$vn_id}'></div>
#							</div></a>
#						</div><!-- end col -->\n";
					
# --- link to detail
					$vs_result_output = "
						<div class='resultItemColImg col-xs-{$vn_col_span_xs} col-sm-{$vn_col_span_sm} col-md-{$vn_col_span}'>".
						caDetailLink($this->request, 
							"<div class='resultContentImg'>
								<div class='resultImageImg'>".$vs_thumbnail."</div>
								<div class='resultTextImg'>".$qr_res->getWithTemplate($vs_result_text_template)."</div>
								{$vs_add_to_set_link}<div class='bSetsSelectMultiple'><input type='checkbox' name='object_ids' value='{$vn_id}'></div>
							</div>", '', $vs_table, $vn_id, null, array("title" => "View: ".strip_tags($qr_res->get($vs_table.".preferred_labels"))))."
						".$vs_compare_link."</div><!-- end col -->\n";
					ExternalCache::save($vs_cache_key, $vs_result_output, 'browse_result', $o_config->get("cache_timeout"));
					print $vs_result_output;
				}				
				$vn_c++;
				$vn_results_output++;
			}
			
			$params = array('s' => $vn_start + $vn_results_output, 'key' => $vs_browse_key, 'view' => $vs_current_view, 'sort' => $vs_current_sort, '_advanced' => $this->getVar('is_advanced') ? 1  : 0, "dontSetFind" => $vb_dontSetFind);
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
