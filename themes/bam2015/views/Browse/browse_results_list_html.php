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
		$this->request->session->setVar('lastProYear', "");
	}
	$vs_last_pro_year = $this->request->session->getVar('lastProYear');
		if ($vn_start < $qr_res->numHits()) {
			$vn_c = 0;
			$qr_res->seek($vn_start);
			$vs_add_to_lightbox_msg = addslashes(_t('Add to %1', $vs_lightbox_display_name));
			while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
				$vn_id 					= $qr_res->get("{$vs_table}.{$vs_pk}");
				$vs_idno_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.idno"), '', $vs_table, $vn_id);
				$vs_label_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.preferred_labels"), '', $vs_table, $vn_id);
				if(is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
					$vs_add_to_set_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array($vs_pk => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a>";
				}
				$vs_expanded_info = $qr_res->getWithTemplate($vs_extended_info_template);
				if($vs_table == 'ca_occurrences'){
					$vn_str_len_date = 0;
					$vs_pro_date = $qr_res->get("ca_occurrences.productionDate");
					#if($vs_pro_date){
					#	$vn_str_len_date = mb_strlen($vs_pro_date);
					#}
					#$vn_chop_len = 100 - $vn_str_len_date;
					$vn_chop_len = 100;
					$vs_date_conjunction = ", ";
					$vs_series_info = "";
					if($qr_res->get("ca_occurrences.series", array("convertCodesToDisplayText" => true))){
						$vs_series_info = "<span class='series'><i class='fa fa-ticket'></i> ".$qr_res->get("ca_occurrences.series", array("convertCodesToDisplayText" => true, "delimiter" => ", "))."</span> ";
					}elseif($qr_res->get("ca_occurrences.Minor_BAM_Programming", array("convertCodesToDisplayText" => true))){
						$vs_series_info = "<span class='series'>".$qr_res->get("ca_occurrences.Minor_BAM_Programming", array("convertCodesToDisplayText" => true, "delimiter" => ", "))."</span> ";
					}
					$vs_link_text = (($qr_res->get("{$vs_table}.preferred_labels")) ? $qr_res->get("{$vs_table}.preferred_labels") : $qr_res->get("{$vs_table}.idno"));
					if(mb_strlen($vs_link_text) > $vn_chop_len){
						$vs_link_text = mb_substr($vs_link_text, 0, $vn_chop_len)."...";
					}						
					#if($vs_pro_date){
					#	$vs_link_text = $vs_link_text.$vs_date_conjunction.$qr_res->get("ca_occurrences.productionDate", array("delimiter" => ", "));
					#}
					#$vs_link_text = $vs_series_info.$vs_link_text;
					if($vs_pro_date || $vs_series_info){
						$vs_link_text = $vs_link_text."<br/>".$vs_series_info.str_replace("-", "&mdash;", $qr_res->get("ca_occurrences.productionDate", array("delimiter" => ", ")));
					}
					# --- if sort is date, get the date as a year so you can display a year heading
					$vs_start_year = "";
					$vb_show_year = false;
					if((!$this->request->getParameter("openResultsInOverlay", pInteger)) && ($vs_current_sort == "Date")){
						$va_pro_date_raw = $qr_res->get("ca_occurrences.productionDate", array("returnWithStructure" => true, "rawDate" => true));
						if(is_array($va_pro_date_raw) && sizeof($va_pro_date_raw)){
							$va_pro_date_raw = array_shift($va_pro_date_raw[$qr_res->get("ca_occurrences.occurrence_id")]);
							$vs_start_year = floor($va_pro_date_raw["productionDate"]["start"]);
							if($vs_start_year && ($vs_start_year != $this->request->session->getVar('lastProYear')) && (!$this->request->session->getVar('lastProYear') || ((($vs_sort_dir == 'asc') && ($vs_start_year > $this->request->session->getVar('lastProYear'))) || (($vs_sort_dir == 'desc') && ($vs_start_year < $this->request->session->getVar('lastProYear')))))){
								$this->request->session->setVar('lastProYear', $vs_start_year);
								$vb_show_year = true;
							}
						}
					}					
				}else{
					$vs_link_text = ($qr_res->get("{$vs_table}.preferred_labels")) ? $qr_res->get("{$vs_table}.preferred_labels") : $qr_res->get("{$vs_table}.idno");
				}
				if($vs_table == 'ca_collections'){ 
					if ($qr_res->get('ca_collections.parent.preferred_labels')) {
						$vs_collection_parent = $qr_res->get('ca_collections.parent.preferred_labels')." > ";
					} else {
						$vs_collection_parent = null;
					}
				} 
				$vs_detail_link = "";
				if(!$this->request->getParameter("openResultsInOverlay", pInteger) || ($this->request->getParameter("openResultsInOverlay", pInteger) && $vs_table == "ca_occurrences")){
					$vs_detail_link	= caDetailLink($this->request, $vs_collection_parent.$vs_link_text, '', $vs_table, $vn_id);
				}else{
					$vs_detail_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, 'Detail', 'objects', $vn_id, array('overlay' => 1))."\"); return false;'>".$vs_link_text."</a>";
				}
				$vs_cols = "";
				$vs_occ_class = "";
				if($vs_table == 'ca_occurrences'){
					$vs_occ_class = " occItem";
					if($this->request->getParameter("openResultsInOverlay", pInteger)){
						$vs_cols = 4;
					}else{
						$vs_cols = 12;
					}
				}elseif($this->request->getParameter("openResultsInOverlay", pInteger)){
					$vs_cols = 4;
				}else{
					$vs_cols = 6;
				}
				if($vb_show_year){
					print "<div class='col-xs-12' style='clear:left'><br/><H4>".$this->request->session->getVar('lastProYear')."</H4></div>";
				}
				print "
	<div class='col-xs-12 col-sm-".$vs_cols."'>
		<div class='bBAMResultListItem".$vs_occ_class."'><span class='pull-right icon-arrow-up-right'></span>
			<div class='bSetsSelectMultiple bSetsSelectMultipleCheckbox'><input type='checkbox' name='object_ids[]' value='{$vn_id}'></div>
			".$vs_detail_link."
		</div><!-- end bBAMResultListItem -->
	</div><!-- end col -->";
				
				$vn_c++;
			}
			
			print caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view, 'openResultsInOverlay' => (int)$this->request->getParameter("openResultsInOverlay", pInteger)));
		}
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		if($("#bSetsSelectMultipleButton").is(":visible")){
			$(".bSetsSelectMultiple").show();
		}
	});
</script>