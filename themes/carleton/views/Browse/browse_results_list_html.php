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

	$o_icons_conf = caGetIconsConfig();
	$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";

	
	$va_add_to_set_link_info = caGetAddToSetInfo($this->request);
	
		if(in_array($vs_table, array("ca_collections", "ca_object_lots"))){
			$vn_col_span = 12;
			$vn_col_span_sm = 12;
			$vn_col_span_xs = 12;
			$vb_refine = false;
			if(is_array($va_facets) && sizeof($va_facets)){
				$vb_refine = true;
				$vn_col_span = 12;
				$vn_col_span_sm = 12;
				$vn_col_span_xs = 12;
			}
		}else{
			$vn_col_span = 6;
			$vn_col_span_sm = 6;
			$vn_col_span_xs = 12;
			$vb_refine = false;
			if(is_array($va_facets) && sizeof($va_facets)){
				$vb_refine = true;
				$vn_col_span = 6;
				$vn_col_span_sm = 6;
				$vn_col_span_xs = 12;
			}
		}
		if ($vn_start < $qr_res->numHits()) {
			$vn_c = 0;
			$vn_results_output = 0;
			$qr_res->seek($vn_start);
			
			#if ($vs_table != 'ca_objects') {
			#	$va_ids = array();
			#	while($qr_res->nextHit() && ($vn_c < $vn_hits_per_block)) {
			#		$va_ids[] = $qr_res->get("{$vs_table}.{$vs_pk}");
			#	}
			#
			#	$qr_res->seek($vn_start);
			#	$va_images = caGetDisplayImagesForAuthorityItems($vs_table, $va_ids, array('version' => 'small', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_options, null), 'objectTypes' => caGetOption('selectMediaUsingTypes', $va_options, null), 'checkAccess' => $va_access_values));
			#} else {
			#	$va_images = null;
			#}
			
			$t_list_item = new ca_list_items();
			$qr_res->filterNonPrimaryRepresentations(false);
			while($qr_res->nextHit()) {
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
				
					$vs_idno_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.idno"), '', $vs_table, $vn_id);
					$vs_desc = "";
					$vs_multiple_media = "";
					switch($vs_table){
						case "ca_collections":
							$vs_parent_path = $qr_res->getWithTemplate("<unit relativeTo='ca_collections.parent'><unit relativeTo='ca_collections.hierarchy' delimiter=' &gt; '>^ca_collections.type_id ^ca_collections.id_number<if rule='^ca_collections.preferred_labels.name !~ /BLANK/'>: ^ca_collections.preferred_labels</if><ifdef code='ca_collections.display_date'>, ^ca_collections.display_date%delimiter=,_</ifdef><ifnotdef code='ca_collections.display_date'><ifdef code='ca_collections.inclusive_dates'>, ^ca_collections.inclusive_dates%delimiter=,_</ifdef></ifnotdef></unit></unit>");
							if($vs_parent_path){
								$vs_parent_path .= " >";
							}
				#print "<div class='collectionsResult authorityResult'>".$qr_results->getWithTemplate("<l>".$vs_parent_path."<b>^ca_collections.type_id ^ca_collections.id_number<if rule='^ca_collections.preferred_labels.name !~ /BLANK/'>: ^ca_collections.preferred_labels</if><ifdef code='ca_collections.inclusive_dates'>, ^ca_collections.inclusive_dates%delimiter=,_</ifdef></b></l>", array('returnAsLink' => true))."</div>";

							
							$vs_label_detail_link = $vs_thumbnail = "";
							if($vs_tmp = $qr_res->getWithTemplate("^ca_collections.col_classification%delimiter=,_")){
								$vs_label_detail_link = "<div class='resultClassification'>".$vs_tmp."</div>";
							}
							if(strToLower($qr_res->getWithTemplate("^ca_collections.type_id")) == "collection"){
								$vs_label_detail_link 	.= $qr_res->getWithTemplate("<div class='collectionID'>^ca_collections.type_id ^ca_collections.id_number</div>^ca_collections.preferred_labels<ifdef code='ca_collections.display_date'><br/>^ca_collections.display_date%delimiter=,_</ifdef><ifnotdef code='ca_collections.display_date'><ifdef code='ca_collections.inclusive_dates'><br/>^ca_collections.inclusive_dates%delimiter=,_</ifdef></ifnotdef>");
							}else{
								$vs_label_detail_link 	.= "<div class='collectionPath'>".$vs_parent_path."</div>".$qr_res->getWithTemplate("^ca_collections.type_id ^ca_collections.id_number<if rule='^ca_collections.preferred_labels.name !~ /BLANK/'>: ^ca_collections.preferred_labels</if><ifdef code='ca_collections.display_date'>, ^ca_collections.display_date%delimiter=,_</ifdef><ifnotdef code='ca_collections.display_date'><ifdef code='ca_collections.inclusive_dates'>, ^ca_collections.inclusive_dates%delimiter=,_</ifdef></ifnotdef>");
							}
							if(strToLower($qr_res->getWithTemplate("^ca_collections.type_id")) == "item"){
								$vs_thumbnail = $qr_res->getWithTemplate("<ifcount code='ca_object_representations' min='1'><l><unit relativeTo='ca_object_representations' length='1'><div class='bResultCollectionListItemImg'>^ca_object_representations.media.iconlarge</div></unit><l></ifcount>");
								$vs_desc = $qr_res->getWithTemplate("^ca_collections.description");
								if($qr_res->getWithTemplate("<unit relativeTo='ca_object_representations' filterNonPrimaryRepresentations='0' length='1'>^count</unit>", array("checkAccess" => $va_access_values)) > 1){
									$vs_multiple_media = '<div class="multipleMediaIcon"><i class="fa fa-files-o" aria-hidden="true" title="multiple media"></i></div>';
								}
							}else{
								$vs_desc = strip_tags($qr_res->getWithTemplate("^ca_collections.scope_content%convertLineBreaks=1&truncate=500&ellipsis=1"));
							}
							
							$vs_desc .= caGetTextExcerpt($qr_res->get('ca_object_representations.media_content', ['highlight' => false]), MetaTagManager::getHighlightText());
						break;
						# ---------
						case "ca_object_lots":
							$vs_date = $qr_res->get("ca_object_lots.inclusive_dates", array("delimiter" => ", "));
							$vs_label_detail_link 	= $qr_res->get("{$vs_table}.preferred_labels").(($vs_date) ? ", ".$vs_date : "");
						break;
						# ---------
						default:
							$vs_label_detail_link 	= $qr_res->get("{$vs_table}.preferred_labels");
						break;
						# ---------
					}
					
					#$vs_thumbnail = "";
					$vs_type_placeholder = "";
					$vs_typecode = "";
					#$vs_image = ($vs_table === 'ca_objects') ? $qr_res->getMediaTag("ca_object_representations.media", 'small', array("checkAccess" => $va_access_values)) : $va_images[$vn_id];
				
					#if(!$vs_image){
					#	if ($vs_table == 'ca_objects') {
					#		$t_list_item->load($qr_res->get("type_id"));
					#		$vs_typecode = $t_list_item->get("idno");
					#		if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
					#			$vs_image = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
					#		}else{
					#			$vs_image = $vs_default_placeholder_tag;
					#		}
					#	}else{
					#		$vs_image = $vs_default_placeholder_tag;
					#	}
					#}
					#$vs_rep_detail_link 	= caDetailLink($this->request, $vs_image, '', $vs_table, $vn_id);	
				
					$vs_add_to_set_link = "";
					if(($vs_table == 'ca_objects') && is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
						$vs_add_to_set_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array($vs_pk => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a>";
					}
				
					$vs_expanded_info = $qr_res->getWithTemplate($vs_extended_info_template);

					$vs_result_output = caDetailLink($this->request, "
		<div class='bResultListItemCol col-xs-{$vn_col_span_xs} col-sm-{$vn_col_span_sm} col-md-{$vn_col_span}'>
			<div class='bResultListItem' id='row{$vn_id}'>
				<div class='bSetsSelectMultiple'><input type='checkbox' name='object_ids[]' value='{$vn_id}'></div>
				<div class='bResultListItemContent'>
					<div class='bResultListItemText'>
						{$vs_multiple_media}{$vs_thumbnail}{$vs_label_detail_link}<div class='bResultListItemTextDesc'>{$vs_desc}</div>
					</div><!-- end bResultListItemText -->
				</div><!-- end bResultListItemContent -->
			</div><!-- end bResultListItem -->
		</div><!-- end col -->", '', $vs_table, $vn_id);
					ExternalCache::save($vs_cache_key, $vs_result_output, 'browse_result', $o_config->get("cache_timeout"));
					print $vs_result_output;
				}				
				$vn_c++;
				$vn_results_output++;
			}
			print "<div style='clear:both'></div>".caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_results_output, 'key' => $vs_browse_key, 'view' => $vs_current_view, 'sort' => $vs_current_sort, '_advanced' => $this->getVar('is_advanced') ? 1  : 0));
		}
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		if($("#bSetsSelectMultipleButton").is(":visible")){
			$(".bSetsSelectMultiple").show();
		}
	});
</script>