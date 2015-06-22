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
	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

	$vb_ajax			= (bool)$this->request->isAjax();
	
	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";
		
		$vn_col_span = 4;
		$vn_col_span_sm = 4;
		$vn_col_span_xs = 6;
		$vb_refine = false;
		if(is_array($va_facets) && sizeof($va_facets)){
			$vb_refine = true;
			$vn_col_span = 4;
			$vn_col_span_sm = 4;
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
				$va_images = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids, array('version' => 'medium'));
			
				$vn_c = 0;	
				$qr_res->seek($vn_start);
			}
			
			$vs_add_to_lightbox_msg = addslashes(_t('Add to lightbox'));
			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
				$vn_id 					= $qr_res->get("{$vs_table}.{$vs_pk}");
				if ($qr_res->get('ca_objects.type_id') == 30) {
					$vs_label_author	 	= "<p class='artist'>".$qr_res->get("ca_entities.preferred_labels.name", array('restrictToRelationshipTypes' => 'author', 'delimiter' => '; ', 'template' => '^ca_entities.preferred_labels.forename ^ca_entities.preferred_labels.middlename ^ca_entities.preferred_labels.surname'))."</p>";
					$vs_label_detail 	= "<p style='text-decoration:underline;'>".caDetailLink($this->request, $qr_res->get("{$vs_table}.preferred_labels.name"), '', $vs_table, $vn_id)."</p>";

					$vs_label_pub 	= "<p>".$qr_res->get("ca_objects.publication_description")."</p>";
					$vs_label_call 	= "<p>".$qr_res->get("ca_objects.call_number")."</p>";
					$vs_label_status 	= "<p>".$qr_res->get("ca_objects.purchase_status", array('convertCodesToDisplayText' => true))."</p>";
					$vs_idno_detail_link 	= "";
					$vs_label_detail_link = "";
					$vs_library_info = $vs_label_detail.$vs_label_author.$vs_label_pub.$vs_label_call.$vs_label_status;
				} elseif ($qr_res->get('ca_objects.type_id') == 1903) {
					$vs_label_author	 	= "<p class='artist'>".$qr_res->get("ca_entities.parent.preferred_labels.name", array('restrictToRelationshipTypes' => 'author', 'delimiter' => '; ', 'template' => '^ca_entities.parent.preferred_labels.forename ^ca_entities.parent.preferred_labels.middlename ^ca_entities.parent.preferred_labels.surname'))."</p>";
					$vs_label_detail 	= "<p style='text-decoration:underline;'>".$qr_res->get("{$vs_table}.parent.preferred_labels.name")."</p>";

					$vs_label_pub 	= "<p>".$qr_res->get("ca_objects.parent.publication_description")."</p>";
					$vs_label_call 	= "<p>".$qr_res->get("ca_objects.parent.call_number")."</p>";
					$vs_label_status 	= "<p>".$qr_res->get("ca_objects.parent.purchase_status", array('convertCodesToDisplayText' => true))."</p>";
					$vs_idno_detail_link 	= "";
					$vs_label_detail_link = "";
					$vs_library_info = $vs_label_detail.$vs_label_author.$vs_label_pub.$vs_label_call.$vs_label_status;				
				} elseif ($qr_res->get('ca_objects.type_id') == 28) {
					$vs_label_artist	 	= "<p class='artist lower'>".caDetailLink($this->request, $qr_res->get("ca_entities.preferred_labels.name", array('restrictToRelationshipTypes' => 'artist')), '', $vs_table, $vn_id)."</p>";
					$vs_label_detail_link 	= "<p><i>".caDetailLink($this->request, $qr_res->get("{$vs_table}.preferred_labels.name"), '', $vs_table, $vn_id)."</i>, ".$qr_res->get("ca_objects.creation_date")."</p>";
					if ($qr_res->get('is_deaccessioned') && ($qr_res->get('deaccession_date', array('getDirectDate' => true)) <= caDateToHistoricTimestamp(_t('now')))) {
						$vs_deaccessioned = "<div class='searchDeaccessioned'>"._t('Deaccessioned %1', $qr_res->get('deaccession_date'))."</div>\n";
					} else {
						$vs_deaccessioned = "";
					}
					if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatoral_all_new") || $this->request->user->hasUserRole("curatoral_basic_new")  || $this->request->user->hasUserRole("archives_new")  || $this->request->user->hasUserRole("library_new")){
						$vs_art_idno_link = "<p class='idno'>".$qr_res->get("ca_objects.idno")."</p>";
					} else {
						$vs_art_idno_link = "";
					}
				}else {
					#$vs_label_artist	 	= "<p class='artist lower'>".$qr_res->get("ca_entities.preferred_labels.name", array('restrictToRelationshipTypes' => 'artist'))."</p>";
					$vs_label_detail_link 	= "<p>".caDetailLink($this->request, $qr_res->get("{$vs_table}.preferred_labels.name"), '', $vs_table, $vn_id)."</p>";
					$vs_idno_detail_link 	= "<p class='idno'>".$qr_res->get("{$vs_table}.idno")."</p>";
					if ($qr_res->get('ca_objects.dc_date.dc_dates_value')) {
						$vs_date_link = "<p>".$qr_res->get('ca_objects.dc_date', array('returnAsLink' => true, 'delimiter' => '; ', 'template' => '^dc_dates_value'))."</p>";
					}else {
						$vs_date_link = "";
					}
					if ($qr_res->get('ca_objects.type_id') == 23 || $qr_res->get('ca_objects.type_id') == 26 || $qr_res->get('ca_objects.type_id') == 25 || $qr_res->get('ca_objects.type_id') == 24 || $qr_res->get('ca_objects.type_id') == 27){
						$vs_type_link = "<p>".$qr_res->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))."</p>";
					} else {
						$vs_type_link = "";
					}
					if ($qr_res->get('ca_objects.type_id') == 23 || $qr_res->get('ca_objects.type_id') == 26 || $qr_res->get('ca_objects.type_id') == 25 || $qr_res->get('ca_objects.type_id') == 24 || $qr_res->get('ca_objects.type_id') == 27){
						$va_collection_id = $qr_res->get('ca_collections.collection_id');
						$t_collection = new ca_collections($va_collection_id);
						$vn_parent_ids = $t_collection->getHierarchyAncestors($va_collection_id, array('idsOnly' => true));
						$vn_highest_level = end($vn_parent_ids);
						$t_top_level = new ca_collections($vn_highest_level);
						$vs_collection_link = "<p>".caNavLink($this->request, $t_top_level->get('ca_collections.preferred_labels'), '', 'Detail', 'collections', $vn_highest_level)."</p>";					
					}					
				}
				if ($vs_table == 'ca_objects') {
					if ($qr_res->get('ca_objects.type_id') == 25) {
						$va_icon = "<i class='glyphicon glyphicon-volume-up'></i>";
					} elseif ($qr_res->get('ca_objects.type_id') == 26){
						$va_icon = "<i class='glyphicon glyphicon-film'></i>";
					} elseif (($qr_res->get('ca_objects.type_id') == 30 && !($qr_res->getMediaTag('ca_object_representations.media', 'medium', array('checkAccess' => $va_access_values))))){
						$va_icon = "<i class='glyphicon glyphicon-book'></i>";	
					} elseif ($qr_res->get('ca_objects.type_id') == 1903){
						$vn_parent_id = $qr_res->get('ca_objects.parent_id');
						$t_copy = new ca_objects($vn_parent_id);
						if (!$t_copy->get('ca_object_representations.media.medium', array('checkAccess' => $va_access_values))) {
							$va_icon = "<i class='glyphicon glyphicon-book'></i>";
						} else {
							$va_icon = "";
						}
					} elseif ($qr_res->get('ca_objects.type_id') == 23 && !($qr_res->getMediaTag('ca_object_representations.media', 'medium', array('checkAccess' => $va_access_values)))){
						$va_icon = "<i class='fa fa-archive'></i>";
					} elseif ($qr_res->get('ca_objects.type_id') == 24 && !($qr_res->getMediaTag('ca_object_representations.media', 'medium', array('checkAccess' => $va_access_values)))){
						$va_icon = "<i class='fa fa-archive'></i>";
					} elseif ($qr_res->get('ca_objects.type_id') == 27 && !($qr_res->getMediaTag('ca_object_representations.media', 'medium', array('checkAccess' => $va_access_values)))){
						$va_icon = "<i class='fa fa-archive'></i>";
					} else {
						$va_icon = "";
					}
					if ($qr_res->get('ca_objects.type_id') == 1903){
						$vs_rep_detail_link 	= caDetailLink($this->request, $va_icon.$t_copy->get('ca_object_representations.media.medium', array('checkAccess' => $va_access_values)), '', $vs_table, $vn_parent_id);				
					} elseif ($qr_res->get('ca_objects.type_id') == 25) {
						$vs_rep_detail_link 	= caDetailLink($this->request, $va_icon, '', $vs_table, $vn_id);										
					} else {
						$vs_rep_detail_link 	= caDetailLink($this->request, $va_icon.$qr_res->getMediaTag('ca_object_representations.media', 'medium', array('checkAccess' => $va_access_values)), '', $vs_table, $vn_id);				
					}
				} else {
				
					$vs_rep_detail_link 	= caDetailLink($this->request, $va_icon.$va_images[$vn_id], '', $vs_table, $vn_id);			
				}
				$vs_add_to_set_url		= caNavUrl($this->request, '', 'Lightbox', 'addItemForm', array($vs_pk => $vn_id));

				$vs_expanded_info = $qr_res->getWithTemplate($vs_extended_info_template);
				print "
	<div class='bResultItemCol col-xs-{$vn_col_span_xs} col-sm-{$vn_col_span_sm} col-md-{$vn_col_span}'>
		<div class='bResultItem' onmouseover='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").show();'  onmouseout='jQuery(\"#bResultItemExpandedInfo{$vn_id}\").hide();'>
			<div class='bSetsSelectMultiple'><input type='checkbox' id='cResultSelected_{$vn_id}' name='object_ids[]' value='{$vn_id}'></div>
			<div class='bResultItemContent'><div class='text-center bResultItemImg'>{$vs_rep_detail_link}</div>
				<div class='bResultItemText'>
					{$vs_label_artist}{$vs_label_detail_link}{$vs_collection_link}{$vs_type_link}{$vs_date_link}{$vs_art_idno_link}{$vs_library_info}{$vs_deaccessioned}
				</div><!-- end bResultItemText -->
			</div><!-- end bResultItemContent -->
			<div class='bResultItemExpandedInfo' id='bResultItemExpandedInfo{$vn_id}'>
				<hr>
				{$vs_expanded_info}
				".(($this->request->config->get("disable_lightbox")) ? "" : "<a href='#' onclick='caMediaPanel.showPanel(\"{$vs_add_to_set_url}\"); return false;' title='{$vs_add_to_lightbox_msg}'><span class='glyphicon glyphicon-folder-open'></span></a>")."
			</div><!-- bResultItemExpandedInfo -->
		</div><!-- end bResultItem -->
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