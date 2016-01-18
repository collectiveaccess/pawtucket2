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
	$o_config = $this->getVar("config");	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

	$vb_ajax			= (bool)$this->request->isAjax();

	if(!($vs_placeholder = $o_config->get("placeholder_media_icon"))){
		$vs_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_placeholder."</div>";
	
	$o_lightbox_config = caGetLightboxConfig();
	$vs_lightbox_icon = $o_lightbox_config->get("addToLightboxIcon");
	if(!$vs_lightbox_icon){
		$vs_lightbox_icon = "<i class='fa fa-suitcase'></i>";
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
				$va_images = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids, array('version' => 'small', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_options, null), 'checkAccess' => $va_access_values));
			} else {
				$va_images = null;
			}
			
			$vs_add_to_lightbox_msg = addslashes(_t('Add to lightbox'));
			$vn_bg = 1;
			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
				$vn_id 					= $qr_res->get("{$vs_table}.{$vs_pk}");
				$vs_idno_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.idno"), '', $vs_table, $vn_id);
				$vs_label_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.preferred_labels"), '', $vs_table, $vn_id);
				
				$vs_image = ($vs_table === 'ca_objects') ? $qr_res->getMediaTag("ca_object_representations.media", 'small', array("checkAccess" => $va_access_values)) : $va_images[$vn_id];
				
				if(!$vs_image){
					$vs_image = $vs_placeholder_tag;
				}
				$vs_rep_detail_link 	= caDetailLink($this->request, $vs_image, '', $vs_table, $vn_id);	
				
				$vs_add_to_set_url		= caNavUrl($this->request, '', 'Lightbox', 'addItemForm', array($vs_pk => $vn_id));

				$vs_expanded_info = $qr_res->getWithTemplate($vs_extended_info_template);

				print "
	<div class='col-xs-12'>
		<div class='bResultListRow ".(($vn_bg == 1) ? "bResultListRowBg" : "")."'>{$vs_label_detail_link}";
				switch($vs_table){
					case "ca_objects":
						print "<small>";
						if($qr_res->get("ca_objects.description")){
							print "<p>".((mb_strlen($qr_res->get("ca_objects.description")) > 250) ? mb_substr($qr_res->get("ca_objects.description"), 0, 250)."..." : $qr_res->get("ca_objects.description"))."</p>";
						}
						if($qr_res->get("ca_objects.regions")){
							print "<div><b>"._t("Applicable region(s):")." </b>".$qr_res->get("ca_objects.regions", array("delimiter" => ", ", "convertCodesToDisplayText" => true))."&nbsp;&nbsp;&nbsp;</div>";
						}
						if($qr_res->get("ca_objects.language")){
							print "<div><b>"._t("Language:")." </b>".$qr_res->get("ca_objects.language", array("convertCodesToDisplayText" => true))."</div>";
						}
						print "</small>";
					break;
					# -----------------
					case "ca_entities":
						print "<small>";
						if($qr_res->get("ca_entities.biography")){
							print "<p>".((mb_strlen($qr_res->get("ca_entities.biography")) > 250) ? mb_substr($qr_res->get("ca_entities.biography"), 0, 250)."..." : $qr_res->get("ca_entities.biography"))."</p>";
						}
						if($qr_res->get("ca_entities.regions")){
							print "<div><b>"._t("Applicable region(s):")." </b>".$qr_res->get("ca_entities.regions", array("delimiter" => ", ", "convertCodesToDisplayText" => true))."&nbsp;&nbsp;&nbsp;</div>";
						}
						if($qr_res->get("ca_entities.language")){
							print "<div><b>"._t("Language:")." </b>".$qr_res->get("ca_entities.language", array("convertCodesToDisplayText" => true))."</div>";
						}
						print "</small>";
					break;
					# -----------------
				}
				print ((($vs_table != 'ca_objects') || ($this->request->config->get("disable_lightbox"))) ? "" : "<a href='#' onclick='caMediaPanel.showPanel(\"{$vs_add_to_set_url}\"); return false;' title='{$vs_add_to_lightbox_msg}'>".$vs_lightbox_icon."</i></a>")."
		</div><!-- end bResultListItemContent -->
	</div><!-- end col -->";
				$vn_bg++;
				if($vn_bg > 2){
					$vn_bg = 1;
				}
				$vn_c++;
			}
			
			print caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view));
		}
?>