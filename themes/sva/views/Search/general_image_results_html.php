<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_entities_search_subview_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2014 Whirl-i-Gig
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
 
	$qr_results 		= $this->getVar('result');
	$va_block_info 		= $this->getVar('blockInfo');
	$vs_block 			= $this->getVar('block');
	$vn_num_items_to_show 	= (int)$this->getVar('numItemsToShow');
$vb_has_more 		= (bool)$this->getVar('hasMore');
	$vs_search 			= (string)$this->getVar('search');
	$o_config = $this->getVar("config");
	$o_browse_config = caGetBrowseConfig();
	$va_browse_types = array_keys($o_browse_config->get("browseTypes"));
	$vs_caption_template = $this->getVar('resultCaption');
	$va_access_values = caGetUserAccessValues($this->request);
	$vs_table 			= $this->getVar('table');
	$vs_pk				= $this->getVar('primaryKey');
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	$va_options = $va_block_info["options"];
	
	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<div class='display-1 text-center d-flex bg-light ca-placeholder'><i class='bi bi-card-image align-self-center w-100' aria-label='media placeholder'></i></div>";
	}
	$vs_image_format = $this->getVar('imageFormat');
	$vs_image_class = "";
	if($vs_image_format == "contain"){
		$vs_image_class = "card-img-top object-fit-contain px-3 pt-3 rounded-0";
	}else{
		$vs_image_class = "card-img-top object-fit-cover rounded-0";
	}
	

	if ($qr_results->numHits() > 0) {
		$vn_c = 0;
		print "<div class='row'><div class='col-12 mt-3 mb-2 text-capitalize fw-semibold'>".$qr_results->numHits()." ".(($qr_results->numHits() == 1) ? $va_block_info["labelSingular"] : $va_block_info["labelPlural"])."</div></div>";
		print "<div class='row'>";
		if ($vs_table != 'ca_objects') {
			$va_ids = array();
			while($qr_results->nextHit() && ($vn_c < $vn_num_items_to_show)) {
				$va_ids[] = $qr_results->get($vs_pk);
				$vn_c++;
			}
			$va_images = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids, array('version' => 'small', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_options, null), 'objectTypes' => caGetOption('selectMediaUsingTypes', $va_options, null), 'checkAccess' => $va_access_values));
		
			$vn_c = 0;	
			$qr_results->seek(1);
		}
		
		$t_list_item = new ca_list_items();
		while($qr_results->nextHit()) {
			$vn_id = $qr_results->get("{$vs_table}.{$vs_pk}");
			
			$vs_caption 	= $qr_results->getWithTemplate($vs_caption_template, array("checkAccess" => $va_access_values));
			$vs_thumbnail = "";
			$vs_type_placeholder = "";
			$vs_typecode = "";
			
			if ($vs_table == 'ca_objects') {
				if(!($vs_thumbnail = $qr_results->get('ca_object_representations.media.medium', array("checkAccess" => $va_access_values, "class" => $vs_image_class)))){
					$t_list_item->load($qr_results->get("type_id"));
					$vs_typecode = $t_list_item->get("idno");
					if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
						$vs_thumbnail = $vs_type_placeholder;
					}else{
						$vs_thumbnail = $vs_default_placeholder;
					}
				}
				$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', $vs_table, $vn_id);				
			} else {
				if($va_images[$vn_id]){
					$vs_thumbnail = $va_images[$vn_id];
				}else{
					$vs_thumbnail = $vs_default_placeholder;
				}
				$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', $vs_table, $vn_id);			
			}
			$vs_add_to_set_link = "";
			$vs_thumbnail_caption_link = caDetailLink($this->request, $vs_thumbnail."<div class='card-body'>".$vs_caption."</div>", 'link-dark mx-1', $vs_table, $vn_id, null);
			$vs_detail_button_link = caDetailLink($this->request, "<i class='bi bi-arrow-right-square'></i>", 'link-dark mx-1', $vs_table, $vn_id, null, array("title" => _t("View Record"), "aria-label" => _t("View Record")));
			print "
		<div class='col-md-4 col-lg-3 d-flex'>
			<div id='row{$vn_id}' class='card flex-grow-1 width-100 rounded-0 border-0 mb-4 bg-white'>
			  {$vs_thumbnail_caption_link}
			 </div>	
		</div><!-- end col -->";				
			$vn_c++;
			if($vn_c == $vn_num_items_to_show){
				if($qr_results->numHits() > $vn_num_items_to_show){
					print "<div class='row justify-content-center'><div class='col-12 col-sm-6 col-md-4 col-lg-3 mb-3 text-center'>".caNavLink($this->request, _t("Full Results")."  <i class='ps-2 bi bi-box-arrow-up-right'></i>", "pt-4 pb-4 d-flex align-items-center justify-content-center h-100 w-100 btn btn-dark", "", "Search", $vs_block, array("search" => $vs_search))."</div></div>";
				}
				
				break;
			}
		}
		
		
		print "</div>";
	}
?>
