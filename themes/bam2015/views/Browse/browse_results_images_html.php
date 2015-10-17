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
	$va_access_values = caGetUserAccessValues($this->request);
	$o_config = $this->getVar("config");	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

	$vb_ajax			= (bool)$this->request->isAjax();
	

	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);

	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";
		

		if ($vn_start < $qr_res->numHits()) {
			$vn_c = 0;
			$qr_res->seek($vn_start);
			
			if ($vs_table != 'ca_objects') {
				$va_ids = array();
				while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
					$va_ids[] = $qr_res->get($vs_pk);
					$vn_c++;
				}
				$va_images = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids, array('version' => 'small', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_options, null), 'checkAccess' => $va_access_values));
			
				$vn_c = 0;	
				$qr_res->seek($vn_start);
			}
			
			$t_list_item = new ca_list_items();
			$vs_add_to_lightbox_msg = addslashes(_t('Add to %1', $vs_lightbox_display_name));
			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
				$vn_id 					= $qr_res->get("{$vs_table}.{$vs_pk}");
				$vs_idno_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.idno"), '', $vs_table, $vn_id);
				$vs_label_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.preferred_labels.name"), '', $vs_table, $vn_id);
				$vs_link_text = ($qr_res->get("{$vs_table}.preferred_labels")) ? $qr_res->get("{$vs_table}.preferred_labels") : $qr_res->get("{$vs_table}.idno");
				$vs_thumbnail = "";
				$vs_type_placeholder = "";
				$vs_typecode = "";
				if ($vs_table == 'ca_objects') {
					$t_list_item->load($qr_res->get("type_id"));
					$vs_typecode = $t_list_item->get("idno");
					$vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon");
					if(!($vs_thumbnail = $qr_res->getMediaTag('ca_object_representations.media', 'small', array("checkAccess" => $va_access_values)))){
						if($vs_type_placeholder){
							$vs_thumbnail = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
						}else{
							$vs_thumbnail = $vs_default_placeholder_tag;
						}
					}
					$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', $vs_table, $vn_id);
					$vs_add_to_set_link = "";
					if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
						$vs_add_to_set_link = "<div class='bBAMResultLB'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array($vs_pk => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a></div>";
					}				
				} else {
					if($va_images[$vn_id]){
						$vs_thumbnail = $va_images[$vn_id];
					}else{
						$vs_thumbnail = $vs_default_placeholder_tag;
					}
					$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', $vs_table, $vn_id);			
				}
				
				print "
	<div class='col-xs-12 col-sm-3'>
		<div class='bBAMResultItem'>
			<div class='bSetsSelectMultiple bSetsSelectMultipleCheckbox'><input type='checkbox' name='object_ids' value='{$vn_id}'></div>
			<div class='bBAMResultItemImg'>{$vs_add_to_set_link}{$vs_rep_detail_link}</div>
			<div class='bBAMResultItemText'>
				<div class='bBAMIcon'>{$vs_type_placeholder}</div>
				".caDetailLink($this->request, $vs_link_text, '', $vs_table, $vn_id)."
			</div>
		</div><!-- end bBAMResultItem -->
	</div><!-- end col -->";
				
				$vn_c++;
			}
			
			print caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view));
		}
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		if($("#bSetsSelectMultipleButton").is(":visible")){
			$(".bSetsSelectMultiple").show();
		}
	});
</script>