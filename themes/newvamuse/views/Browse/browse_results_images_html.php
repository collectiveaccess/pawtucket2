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
	

	$o_lightbox_config = caGetLightboxConfig();
	$vs_lightbox_icon = $o_lightbox_config->get("addToLightboxIcon");
	if(!$vs_lightbox_icon){
		$vs_lightbox_icon = "<i class='fa fa-suitcase'></i>";
	}
	$va_lightboxDisplayName = caGetLightboxDisplayName($o_lightbox_config);
	$vs_lightbox_displayname = $va_lightboxDisplayName["singular"];
	$vs_lightbox_displayname_plural = $va_lightboxDisplayName["plural"];

	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";

	$va_business_categories = $this->request->config->get('manufacturer_categories');
	
	$va_categories_list = array();
	foreach ($va_business_categories as $va_category => $va_list_ids) {
		foreach ($va_list_ids as $va_key => $va_category_idno) {
			$t_list = new ca_lists();
			$vn_list_item_id = $t_list->getItemID('business_categories', $va_category_idno);
			$va_categories_list[$vn_list_item_id] = $va_category;
		}
	}

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
			$vs_add_to_lightbox_msg = addslashes(_t('Add to %1', $vs_lightbox_displayname));
			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
				$vn_id 					= $qr_res->get("{$vs_table}.{$vs_pk}");
				$vs_idno_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.idno"), '', $vs_table, $vn_id);
				$vs_label_detail_link 	= "<p>".caDetailLink($this->request, $qr_res->get("{$vs_table}.preferred_labels"), '', $vs_table, $vn_id)."</p>";
				$vs_thumbnail = "";
				$vs_type_placeholder = "";
				$vs_typecode = "";
				if ($vs_table == 'ca_objects') {
					if(!($vs_thumbnail = $qr_res->getMediaTag('ca_object_representations.media', 'medium', array("checkAccess" => $va_access_values)))){
						# --- get the placeholder graphic from the novamuse theme
						$va_themes = $qr_res->get("novastory_category", array("returnAsArray" => true));
						$vs_placeholder = "";
						if(sizeof($va_themes)){
							$t_list_item = new ca_list_items();
							foreach($va_themes as $k => $vs_list_item_id){
								$t_list_item->load($vs_list_item_id);
								if(caGetThemeGraphic($this->request, $t_list_item->get("idno").'.png')){
									$vs_thumbnail = caGetThemeGraphic($this->request, $t_list_item->get("idno").'.png');
									$vn_padding_top_bottom = 5;
								}
							}
						}
						if(!$vs_thumbnail){
							$vs_thumbnail = caGetThemeGraphic($this->request, 'placeholders/placeholder.png');
							$vn_padding_top_bottom = 5;
						}
					}					
					$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', $vs_table, $vn_id);				

					$vs_label_detail_link .= "<p>".$qr_res->get('ca_objects.idno')."</p>";
					$vs_label_detail_link .= "<p>".$qr_res->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('repository')))."</p>";
				} else {
					if($va_images[$vn_id]){
						$vs_thumbnail = $va_images[$vn_id];
					}else{
						$vs_business_cat_id = $qr_res->get('ca_entities.business_category', array('returnAsArray' => true));
						if ($va_categories_list[$vs_business_cat_id[0]]) {	
							$vs_thumbnail = caGetThemeGraphic($this->request, $va_categories_list[$vs_business_cat_id[0]].'.png');
						} else {
							$vs_thumbnail = $vs_default_placeholder_tag;
						}
					}
					$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', $vs_table, $vn_id);			
				}
				$vs_add_to_set_url		= caNavUrl($this->request, '', 'Lightbox', 'addItemForm', array($vs_pk => $vn_id));

				$vs_expanded_info = $qr_res->getWithTemplate($vs_extended_info_template);

				print "
	<div class='bResultItemCol col-xs-{$vn_col_span_xs} col-sm-{$vn_col_span_sm} col-md-{$vn_col_span}'>
		<div class='bResultItem' onmouseover='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").show();'  onmouseout='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").hide();'>
			<div class='bSetsSelectMultiple'><input type='checkbox' name='object_ids' value='{$vn_id}'></div>
			<div class='bResultItemContent'><div class='text-center bResultItemImg'>{$vs_rep_detail_link}</div>
				<div class='bResultItemText'>
					{$vs_label_detail_link}
				</div><!-- end bResultItemText -->
			</div><!-- end bResultItemContent -->
			<div class='bResultItemExpandedInfo' id='bResultItemExpandedInfo{$vn_id}'>
				<hr>
				{$vs_expanded_info}
				".((($vs_table != 'ca_objects') || ($this->request->config->get("disable_lightbox"))) ? "" : "<a href='#' onclick='caMediaPanel.showPanel(\"{$vs_add_to_set_url}\"); return false;' title='{$vs_add_to_lightbox_msg}'>".$vs_lightbox_icon."</i></a>")."
			</div><!-- bResultItemExpandedInfo -->
		</div><!-- end bResultItem -->
	</div><!-- end col -->";
				
				$vn_c++;
			}
			
			print "<div style='clear:both'></div>";
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