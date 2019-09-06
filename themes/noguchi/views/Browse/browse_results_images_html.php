<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_images_html.php : 
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
	$va_view_info = $va_views[$vs_current_view];
	$va_view_icons		= $this->getVar('viewIcons');
	$vs_current_sort	= $this->getVar('sort');
	
	$t_instance			= $this->getVar('t_instance');
	$vs_table 			= $this->getVar('table');
	$vs_pk				= $this->getVar('primaryKey');
	$va_access_values = caGetUserAccessValues();
	$o_config = $this->getVar("config");	
	
	$va_options			= $this->getVar('options');
	$vs_caption_template = caGetOption('captionTemplate', $va_view_info, null);
	$vb_ajax			= (bool)$this->request->isAjax();
	

	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);

	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
		
	$vs_placeholder = $this->request->config->get("site_host").caGetThemeGraphicUrl("placeholder.png");
	$vs_placeholder_tag = '<img nopin="nopin"  src="'.$vs_placeholder.'" />';



		if ($vn_start < $qr_res->numHits()) {
			$vn_c = 0;
			$vn_results_output = 0;
			$qr_res->seek($vn_start);
			
			$t_list_item = new ca_list_items();
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
				# --- key is MD5 of table, id, list, refine(vb_refine)
				$vs_cache_key = md5($vs_table.$vn_id."images".$vb_refine);
				if(($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_result')){
					print ExternalCache::fetch($vs_cache_key, 'browse_result');
				}else{			
#					$vs_thumbnail = "";
#					$vs_type_placeholder = "";
#					$vs_typecode = "";
#						if(!($vs_thumbnail = $qr_res->get('ca_object_representations.media.medium', array("checkAccess" => $va_access_values, "class" => "card-img-top")))){
#							$t_list_item->load($qr_res->get("type_id"));
#							$vs_typecode = $t_list_item->get("idno");
#							if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
#								$vs_thumbnail = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
#							}else{
#								$vs_thumbnail = $vs_default_placeholder_tag;
#							}
#						}
#					$vs_rep_detail_link 	= caDetailLink($vs_thumbnail, '', $vs_table, $vn_id);
					$vs_result_output = $qr_res->getWithTemplate("
					<div class='item-grid'>
                        <l>
                            <div class='img-wrapper archive_thumb block-quarter'>
                                <ifdef code='ca_object_representations.media.medium.url'><div class='bg-image' style='background-image: url(^ca_object_representations.media.medium.url)'></div></ifdef>
                                <ifnotdef code='ca_object_representations.media.medium.url'>".$vs_placeholder_tag."</ifnotdef>
                                
                            </div>
                            <div class='text'>
                                <div class='text_position'>
                                    <div class='ca-identifier text-gray'>^ca_objects.idno<if rule='^ca_objects.status =~ /pending/'>*</if></div>
                                    <div class='thumb-text clamp' data-lines='3'>^ca_objects.preferred_labels.name</div>
                                    <ifdef code='ca_objects.date.display_date'><div class='ca-identifier text-gray'>^ca_objects.date.display_date</div></ifdef>
                                    <ifnotdef code='ca_objects.date.display_date'><ifdef code='ca_objects.date.parsed_date'><div class='ca-identifier text-gray'>^ca_objects.date.parsed_date</div></ifdef></ifnotdef>
                                    <div class='text_full'>
                                        <!-- This duplicate content is required for interaction on long titles -->
                                        <div class='ca-identifier text-gray'>^ca_objects.idno<if rule='^ca_objects.status =~ /pending/'>*</if></div>
                                        <div class='thumb-text'>^ca_objects.preferred_labels.name</div>
                                        <ifdef code='ca_objects.date.display_date'><div class='ca-identifier text-gray'>^ca_objects.date.display_date</div></ifdef>
                                   		<ifnotdef code='ca_objects.date.display_date'><ifdef code='ca_objects.date.parsed_date'><div class='ca-identifier text-gray'>^ca_objects.date.parsed_date</div></ifdef></ifnotdef>                                    
                                    </div>
                                </div>
                            </div>
                        </l>
                    </div>");
                    # --- need to check access here , array("checkAccess" => $va_access_values )
					
					ExternalCache::save($vs_cache_key, $vs_result_output, 'browse_result', $o_config->get("cache_timeout"));
					print $vs_result_output;
				}				
				$vn_c++;
				$vn_results_output++;
			}
			
		}
?>
