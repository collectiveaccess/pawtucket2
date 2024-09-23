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

	$action = $this->request->getAction();	// form type (Eg. "combined")
	
	$va_views			= $this->getVar('views');
	$vs_current_view	= $this->getVar('view');
	$va_view_icons		= $this->getVar('viewIcons');
	$vs_current_sort	= $this->getVar('sort');
	
	$t_instance			= $this->getVar('t_instance');
	$vs_table 			= $this->getVar('table');
	$vs_pk				= $this->getVar('primaryKey');
	$o_config = $this->getVar("config");	
	
	$va_options			= $this->getVar('options');
	$va_view_info 		= $va_views[$vs_current_view];

	$vb_ajax			= (bool)$this->request->isAjax();

	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";
	$vs_result_caption_template = caGetOption('result_caption', $va_view_info, null);
	$vs_image_format = caGetOption('image_format', $va_view_info, 'cover');
	$vs_image_class = "";
	if($vs_image_format == "contain"){
		$vs_image_class = "object-fit-contain py-3 ps-3 rounded-0";
	}else{
		$vs_image_class = "card-img-top object-fit-cover rounded-0";
	}
	
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	
		$vb_refine = false;
		if(is_array($va_facets) && sizeof($va_facets)){
			$vb_refine = true;
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

			$count = $vn_start;

			while($qr_res->nextHit()) {
				// var_dump($qr_res);
				$count = $count + 1;

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
				
					$vs_caption 	= $qr_res->getWithTemplate($vs_result_caption_template, array("checkAccess" => $va_access_values));

					$vs_thumbnail = "";
					$vs_type_placeholder = "";
					$vs_typecode = "";
					$vs_image = ($vs_table === 'ca_objects') ? $qr_res->get('ca_object_representations.media.medium', array("checkAccess" => $va_access_values, "class" => $vs_image_class)) : $va_images[$vn_id];
			
					if(!$vs_image){
						if ($vs_table == 'ca_objects') {
							$t_list_item->load($qr_res->get("type_id"));
							$vs_typecode = $t_list_item->get("idno");
							if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
								$vs_image = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
							}else{
								$vs_image = $vs_default_placeholder_tag;
							}
						}else{
							$vs_image = $vs_default_placeholder_tag;
						}
					}
					$vs_rep_detail_link 	= caDetailLink($this->request, $vs_image, '', $vs_table, $vn_id);	
			
					$vs_add_to_set_link = "";
					if(($vs_table == 'ca_objects') && is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
						$vs_add_to_set_link = "<a href='#' class='link-dark mx-1' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array($vs_pk => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a>";
					}
					$vs_detail_button_link = caDetailLink($this->request, "<i class='bi bi-arrow-right-square'></i>", 'link-dark mx-1', $vs_table, $vn_id, null, array("title" => _t("View Record"), "aria-label" => _t("View Record")));

						$id_field_codes = [
							'ordinance' => 'ca_objects.ORDN',
							'resolution' => 'ca_objects.RESN',
							'clerk_file' => 'ca_objects.CFN',
							'comptroller_file' => 'ca_objects.CFN',
							'council_bill' => 'ca_objects.CBN',
						];


						$result = $count;
						$file_type = $qr_res->get("type_id", ['convertCodesToDisplayText' => true]);
						$number = $qr_res->get("idno");
						$filed = $qr_res->get("DTF");
						$title = $qr_res->get("preferred_labels");


						$meeting_date = $qr_res->get("DATE");
						$committee = $qr_res->get("COMM");

						$ordinance_num = $qr_res->get("ORDN");
						$council_bill_num = $qr_res->get("CBN");
						$passed = $qr_res->get("DTSI");

						$occurrence_meeting_date = $qr_res->get("ca_occurrences.DATE");
						$committee_date = $qr_res->get("ca_entities.comm_date");
						
						$type_idno = $qr_res->get("type_id", ['convertCodesToIdno' => true]);
						$id_num = $qr_res->get($id_field_codes[$type_idno] ?? null);
						
					
								switch(strToLower($action)) {
									case 'combined':
										$vs_result_output = "
											<tr>
												<td>{$result}</td>
												<td>{$file_type}</td>
												<td>{$id_num}</td>
												<td>{$filed}</td>
												<td>{$vs_caption}</td>
											</tr>
										";
									break;
									case 'agenda':
										$vs_result_output = "
											<tr>
												<td>{$result}</td>
												<td>{$meeting_date}</td>
												<td>{$committee}</td>
												<td>{$vs_caption}</td>
											</tr>
										";
									break;
									case 'bills':
										$vs_result_output = "
											<tr>
												<td>{$result}</td>
												<td>{$ordinance_num}</td>
												<td>{$council_bill_num}</td>
												<td>{$filed}</td>
												<td>{$passed}</td>
												<td>{$vs_caption}</td>
											</tr>
										";
									break;
									case 'resolutions':
										$vs_result_output = "
											<tr>
												<td>{$result}</td>
												<td>{$id_num}</td>
												<td>{$filed}</td>
												<td>{$vs_caption}</td>
											</tr>
										";
									break;
									case 'clerk':
										$vs_result_output = "
											<tr>
												<td>{$result}</td>
												<td>{$file_type}</td>
												<td>{$id_num}</td>
												<td>{$filed}</td>
												<td>{$vs_caption}</td>
											</tr>
										";
									break;
									case 'minutes':
										$vs_result_output = "
											<tr>
												<td>{$result}</td>
												<td>{$meeting_date}</td>
												<td>{$committee}</td>
												<td>{$vs_caption}</td>
											</tr>
										";
									break;
									case 'meetings':
										$vs_result_output = "
											<tr>
												<td>{$result}</td>
												<td>{$occurrence_meeting_date}</td>
												<td>{$vs_caption}</td>
											</tr>
										";
									break;
									case 'committees':
										$vs_result_output = "
											<tr>
												<td>{$result}</td>
												<td>{$committee_date}</td>
												<td>{$vs_caption}</td>
											</tr>
										";
								}
							

						// $vs_result_output = "
						// 	<tr>
						// 		<td>{$result}</td>
						// 		<td>{$file_type}</td>
						// 		<td>{$id_num}</td>
						// 		<td>{$filed}</td>
						// 		<td>{$vs_caption}</td>
						// 	</tr>
						// ";

					ExternalCache::save($vs_cache_key, $vs_result_output, 'browse_result', $o_config->get("cache_timeout"));
					print $vs_result_output;
				}				
				$vn_c++;
				$vn_results_output++;
			}

		}
?>
