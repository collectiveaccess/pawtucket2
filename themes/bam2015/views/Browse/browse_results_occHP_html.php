<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_images_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2016 Whirl-i-Gig
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
	$vs_sort_dir		= $this->getVar('sort_direction');
	
	$t_instance			= $this->getVar('t_instance');
	$vs_table 			= $this->getVar('table');
	$vs_pk				= $this->getVar('primaryKey');
	$o_config = $this->getVar("config");	
	
	$va_options			= $this->getVar('options');
	$vs_extended_info_template = caGetOption('extendedInformationTemplate', $va_options, null);

	$vb_ajax			= (bool)$this->request->isAjax();

	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	if(($vs_current_sort != "Date") || (($vs_current_sort == "Date") && !$vn_start)){
		Session::setVar('lastProYear', "");
	}
	$vs_last_pro_year = Session::getVar('lastProYear');
		if ($vn_start < $qr_res->numHits()) {
			$vn_c = 0;
			$qr_res->seek($vn_start);
			$vs_add_to_lightbox_msg = addslashes(_t('Add to %1', $vs_lightbox_display_name));
			
			# --- grab the related images
			$va_ids = array();
			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
				$va_ids[] = $qr_res->get($vs_pk);
				$vn_c++;
			}
			$va_images = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids, array('version' => 'iconlarge', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_options, null), 'checkAccess' => $va_access_values));
			$va_images_1 = array();
			# --- default to secondary choice
			if($vs_other_rel_type = caGetOption('selectMediaUsingRelationshipTypes2', $va_options, null)){
				$va_images_1 = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids, array('version' => 'iconlarge', 'relationshipTypes' => $vs_other_rel_type, 'checkAccess' => $va_access_values));	
			}
			$va_images_2 = array();
			# --- default to any related image if the configured relationship type is not available
			if(caGetOption('selectMediaUsingRelationshipTypes', $va_options, null)){
				$va_images_2 = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids, array('version' => 'iconlarge', null, 'checkAccess' => $va_access_values));	
			}
			$vn_c = 0;	
			$qr_res->seek($vn_start);
			$o_icons_conf = caGetIconsConfig();
			$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
			switch($vs_table){
				case "ca_entities":
					$vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon_entity");
				break;
				# ----------------------
				case "ca_occurrences":
					$vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon_occ");
				break;
				# ----------------------
				default:
					$vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon");
				break;
				# ----------------------
			}
			if(!$vs_default_placeholder){
				$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
			}
			$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";
			
			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
				$vn_id 					= $qr_res->get("{$vs_table}.{$vs_pk}");
				$vs_idno_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.idno"), '', $vs_table, $vn_id);
				$vs_label_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.preferred_labels"), '', $vs_table, $vn_id);
				if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
					$vs_add_to_set_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array($vs_pk => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a>";
				}
				$vs_expanded_info = $qr_res->getWithTemplate($vs_extended_info_template);

				$vs_pro_date = $qr_res->get("ca_occurrences.productionDate");
				$vn_chop_len = 70;
				$vs_date_conjunction = ", ";
				$vs_series_info = "";
				$va_series = $qr_res->get("ca_occurrences.series", array("convertCodesToDisplayText" => true, "returnAsArray" => true));
				$va_series_filtered = array();
				foreach($va_series as $vs_series){
					if(trim($vs_series)){
						$va_series_filtered[] = $vs_series;
					}
				}
				if(sizeof($va_series_filtered)){
					$vs_series_info = "<br/><span class='series'>".join(", ", $va_series_filtered)."</span> ";
				}elseif($qr_res->get("ca_occurrences.Minor_BAM_Programming", array("convertCodesToDisplayText" => true))){
					$vs_minor_info = "";
					$va_minor = $qr_res->get("ca_occurrences.Minor_BAM_Programming", array("convertCodesToDisplayText" => true, "returnAsArray" => true));
					$va_minor_filtered = array();
					foreach($va_minor as $vs_minor){
						if(trim($vs_minor)){
							$va_minor_filtered[] = $vs_minor;
						}
					}
					$vs_series_info = "<br/><span class='series'>".join(", ", $va_minor_filtered)."</span> ";
				}
				$vs_link_text = (($qr_res->get("{$vs_table}.preferred_labels")) ? $qr_res->get("{$vs_table}.preferred_labels") : $qr_res->get("{$vs_table}.idno"));
				if(mb_strlen($vs_link_text) > $vn_chop_len){
					$vs_link_text = mb_substr($vs_link_text, 0, $vn_chop_len)."...";
				}						
				if($vs_pro_date || $vs_series_info){
					$vs_link_text = $vs_link_text."<br/><span><span class='date'>".str_replace(" - ", "&mdash;", $qr_res->get("ca_occurrences.productionDate", array("delimiter" => ", ")))."</span>".$vs_series_info."</span>";
				}
				# --- if sort is date, get the date as a year so you can display a year heading
				$vs_start_year = "";
				$vb_show_year = false;
				if((!$this->request->getParameter("openResultsInOverlay", pInteger)) && ($vs_current_sort == "Date")){
					$va_pro_date_raw = $qr_res->get("ca_occurrences.productionDate", array("returnWithStructure" => true, "rawDate" => true));
					if(is_array($va_pro_date_raw) && sizeof($va_pro_date_raw)){
						$va_pro_date_raw = array_shift($va_pro_date_raw[$qr_res->get("ca_occurrences.occurrence_id")]);
						$vs_start_year = floor($va_pro_date_raw["productionDate"]["start"]);
						if($vs_start_year && ($vs_start_year != Session::getVar('lastProYear')) && (!Session::getVar('lastProYear') || ((($vs_sort_dir == 'asc') && ($vs_start_year > Session::getVar('lastProYear'))) || (($vs_sort_dir == 'desc') && ($vs_start_year < Session::getVar('lastProYear')))))){
							Session::setVar('lastProYear', $vs_start_year);
							$vb_show_year = true;
						}
					}
				}					
				if($va_images[$vn_id] || $va_images_2[$vn_id] || $va_images_1[$vn_id]){
					if($va_images[$vn_id]){
						$vs_thumbnail = $va_images[$vn_id];
					}elseif($va_images_1[$vn_id]){
						$vs_thumbnail = $va_images_1[$vn_id];
					}else{
						$vs_thumbnail = $va_images_2[$vn_id];
					}
				}else{
					$vs_thumbnail = $vs_default_placeholder_tag;
				}
				$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', $vs_table, $vn_id);
				$vs_detail_link = "";
				$vs_detail_link	= caDetailLink($this->request, $vs_collection_parent.$vs_link_text, '', $vs_table, $vn_id);
				$vs_cols = "";
				$vs_cols = 6;
				#if($vb_show_year){
				#	print "<div class='col-xs-12' style='clear:left'><br/><H4>".Session::getVar('lastProYear')."</H4></div>";
				#}
				print "
	<div class='col-xs-12 col-sm-6'>
		<div class='row'><div class='col-sm-12'><H4>".(($vb_show_year) ? Session::getVar('lastProYear') : "&nbsp;")."</H4></div></div>
		<div class='row'>
			<div class='col-xs-12 col-sm-4'>
				<div class='bBAMResultItemOccCircle OccHPCircleImage'>
					<div class='bBAMResultItemImgContainerOccCircle'>{$vs_rep_detail_link}</div>
				</div>
			</div>
			<div class='col-xs-12 col-sm-8'>
				<div class='bBAMResultListItemOccHP'>
					".$vs_detail_link."
				</div>
			</div>
		</div>
		</div><!-- end bBAMResultListItem -->
	</div><!-- end col -->";
				
				$vn_c++;
			}
			
			print "<div style='clear:both;'></div>".caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view, 'openResultsInOverlay' => (int)$this->request->getParameter("openResultsInOverlay", pInteger)));
		}
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		if($("#bSetsSelectMultipleButton").is(":visible")){
			$(".bSetsSelectMultiple").show();
		}
	});
</script>