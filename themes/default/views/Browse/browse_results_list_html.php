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
	$browse_key 		= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	$row_id		 	= (int)$this->getVar('row_id');			// id of last visited detail item so can load to and jump to that result - passed in back button
	$vb_row_id_loaded 	= false;
	if(!$row_id){
		$vb_row_id_loaded = true;
	}
	
	$va_views			= $this->getVar('views');
	$current_view	= $this->getVar('view');
	$va_view_icons		= $this->getVar('viewIcons');
	$current_sort	= $this->getVar('sort');
	
	$t_instance			= $this->getVar('t_instance');
	$table 			= $this->getVar('table');
	$pk				= $this->getVar('primaryKey');
	$o_config = $this->getVar("config");	
	
	$va_options			= $this->getVar('options');
	$va_view_info 		= $va_views[$current_view];

	$vb_ajax			= (bool)$this->request->isAjax();

	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	if(!($default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$default_placeholder."</div>";
	$result_caption_template = caGetOption('result_caption', $va_view_info, null);
	$image_format = caGetOption('image_format', $va_view_info, 'cover');
	$image_class = "";
	if($image_format == "contain"){
		$image_class = "object-fit-contain py-3 ps-3 rounded-0";
	}else{
		$image_class = "card-img-top object-fit-cover rounded-0";
	}
	$image_format = caGetOption('list_format', $va_view_info, 'image');
	
	
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	
		$vb_refine = false;
		if(is_array($va_facets) && sizeof($va_facets)){
			$vb_refine = true;
		}
		if ($start < $qr_res->numHits()) {
			$c = 0;
			$results_output = 0;
			$qr_res->seek($start);
			
			if ($table != 'ca_objects') {
				$va_ids = array();
				while($qr_res->nextHit() && ($c < $hits_per_block)) {
					$va_ids[] = $qr_res->get("{$table}.{$pk}");
				}
			
				$qr_res->seek($start);
				$va_images = caGetDisplayImagesForAuthorityItems($table, $va_ids, array('version' => 'medium', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_options, null), 'objectTypes' => caGetOption('selectMediaUsingTypes', $va_options, null), 'checkAccess' => $va_access_values));
			} else {
				$va_images = null;
			}
			
			$t_list_item = new ca_list_items();
			while($qr_res->nextHit()) {
				if($c == $hits_per_block){
					if($vb_row_id_loaded){
						break;
					}else{
						$c = 0;
					}
				}
				$id 					= $qr_res->get("{$table}.{$pk}");
				if($id == $row_id){
					$vb_row_id_loaded = true;
				}
				# --- check if this result has been cached
				# --- key is MD5 of table, id, view, refine(vb_refine)
				$cache_key = md5($table.$id."list".$vb_refine);
				if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($cache_key,'browse_result')){
					print ExternalCache::fetch($cache_key, 'browse_result');
				}else{
				
					$caption 	= $qr_res->getWithTemplate($result_caption_template, array("checkAccess" => $va_access_values));
					
					if ($image_format == "image") {
						$thumbnail = "";
						$type_placeholder = "";
						$typecode = "";
						$image = ($table === 'ca_objects') ? $qr_res->get('ca_object_representations.media.medium', array("checkAccess" => $va_access_values, "class" => $image_class)) : $va_images[$id];
				
						if(!$image){
							if ($table == 'ca_objects') {
								$t_list_item->load($qr_res->get("type_id"));
								$typecode = $t_list_item->get("idno");
								if($type_placeholder = caGetPlaceholder($typecode, "placeholder_media_icon")){
									$image = "<div class='bResultItemImgPlaceholder'>".$type_placeholder."</div>";
								}else{
									$image = $default_placeholder_tag;
								}
							}else{
								$image = $default_placeholder_tag;
							}
						}
						$rep_detail_link 	= caDetailLink($this->request, $image, '', $table, $id);	
				
						if(($table == 'ca_objects') && caDisplayLightbox($this->request)){
							$select_button = "<button type='button' 
									id='result-select-btn-{$id}'
									onclick='toggleSelection({$id})'
									class='btn btn-white btn-select px-2' 
									title='"._t("Select record")."'
									aria-label='"._t("Select record")."'><i class='bi bi-check-circle'></i></button>";
						}
						$detail_button_link = caDetailLink($this->request, "<i class='bi bi-arrow-right-square'></i>", 'btn btn-white px-2 ms-1', $table, $id, null, array("title" => _t("View Record"), "aria-label" => _t("View Record")));
						$result_output = "
							<div class='col-md-12'>
								<div id='row{$id}' class='card width-100 rounded-0 shadow border-0 mb-4'>
									<div class='row g-0'>
										<div class='col-sm-3'>
											{$rep_detail_link}
										</div>
										<div class='col-sm-9'>
											<div class='card-body'>
												{$caption}
											</div>
										</div>
									</div>
									<div class='row g-0'>
										<div class='col-sm-12'>
											<div class='card-footer text-end bg-transparent'>
												{$select_button}{$detail_button_link}
											</div>
										</div>
									</div>
								 </div>	
							</div><!-- end col -->";
					}else{
						$result_output = "<div class='col-md-6 col-lg-4 d-flex'>".caDetailLink($this->request, "
							
								<div id='row{$id}' class='card flex-grow-1 width-100 rounded-0 shadow border-0 mb-4'>
									<div class='card-body'>
										{$caption}
									</div>
								 </div>", "w-100 d-flex", $table, $id)."</div><!-- end col -->";
					}
					
					ExternalCache::save($cache_key, $result_output, 'browse_result', $o_config->get("cache_timeout"));
					print $result_output;
				}				
				$c++;
				$results_output++;
			}
			
			print "<div style='clear:both' class='text-center m-3' hx-get='".caNavUrl($this->request, '*', '*', '*', array('s' => $start + $results_output, 'key' => $browse_key, 'view' => $current_view, 'sort' => $current_sort, '_advanced' => $this->getVar('is_advanced') ? 1  : 0))."' hx-trigger='revealed' hx-swap='afterend'>
						<div class='spinner-border htmx-indicator' role='status'><span class='visually-hidden'>Loading...</span></div>
					</div>";
		}
?>
