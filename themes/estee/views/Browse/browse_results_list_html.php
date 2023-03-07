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
	
	$va_browse_info = $this->getVar('browseInfo');
	
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
		$vn_col_span = 4;
		$vn_col_span_sm = 4;
		$vn_col_span_xs = 12;
		$vb_refine = false;
		if(is_array($va_facets) && sizeof($va_facets)){
			$vb_refine = true;
			$vn_col_span = 6;
			$vn_col_span_sm = 6;
			$vn_col_span_xs = 12;
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
				if(!$va_browse_info['noCache'] && ($o_config->get("cache_timeout") > 0) && ExternalCache::contains($vs_cache_key,'browse_result')){
					print ExternalCache::fetch($vs_cache_key, 'browse_result');
				}else{
				
					$vs_idno_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.idno"), '', $vs_table, $vn_id, array("last_tab" => "browse"));
					$vs_label_detail_link 	= caDetailLink($this->request, $qr_res->get("{$vs_table}.preferred_labels"), '', $vs_table, $vn_id, array("last_tab" => "browse"));
					$vs_thumbnail = "";
					$vs_type_placeholder = "";
					$vs_typecode = "";
					$vs_folder_class = "";
					
					$vs_image = ($vs_table === 'ca_objects') ? $qr_res->getMediaTag("ca_object_representations.media", 'medium', array("checkAccess" => $va_access_values)) : $va_images[$vn_id];
				
					if($vs_table != "ca_occurrences"){
						$t_list_item->load($qr_res->get("type_id"));
						$vs_typecode = $t_list_item->get("idno");
						if($vs_typecode == "bulk"){
							if(!$vs_image){
								if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
									$vs_image = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
								}else{
									$vs_image = $vs_default_placeholder_tag;
								}
							}else{
								$vs_image = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, "", "Detail", "GetMediaOverlay", array("id" => $qr_res->get("object_id"), "context" => "archival", "representation_id" => $qr_res->get("ca_object_representations.representation_id", array("checkAccess" => $va_access_values)), "overlay" => 1))."\"); return false;'>".$vs_image."</a>";
							}
?>
							<div class="row bBulkMediaResult">
								<div class="col-sm-6">
									<div class="bBulkMediaImage"><?php print $vs_image; ?></div>
								</div>
								<div class="col-sm-3">
<?php
									if($qr_res->get('ca_objects.preferred_labels') != "[BLANK]"){
										print "<H4>".$qr_res->get('ca_objects.preferred_labels')."</H4>";
									}
									if(($vs_brand = $qr_res->get("ca_objects.brand", array("convertCodesToDisplayText" => true))) || ($vs_subbrand = $qr_res->get("ca_objects.sub_brand", array("convertCodesToDisplayText" => true)))){
										print "<div class='unit'><H6>Brand</H6>".$vs_brand.(($vs_brand && $vs_subbrand) ? ", " : "").$vs_subbrand."</div>";
									}
									if(($vs_tmp = $qr_res->get("ca_objects.season_list", array("convertCodesToDisplayText" => true, "delimiter" => ", ")))){
										print "<div class='unit'><H6>Season</H6>".$vs_tmp."</div>";
									}
									if($vs_tmp = $qr_res->get('ca_objects.transferred_date', array("delimeter" => ", "))){
										print "<div class='unit'><H6>Publication Date</H6>".$vs_tmp."</div>";
									}
									if($vs_tmp = $qr_res->get('ca_objects.language', array("delimeter" => ", ", "convertCodesToDisplayText" => true))){
										print "<div class='unit'><H6>Language</H6>".$vs_tmp."</div>";
									}
									$va_entities = $qr_res->get("ca_entities", array('returnWithStructure' => true, 'checkAccess' => $va_access_values));
									if(is_array($va_entities) && sizeof($va_entities)){
										$va_entities_by_type = array();
										$va_entities_sort = array();
										foreach($va_entities as $va_entity){
											$va_entities_sort[$va_entity["relationship_typename"]][] = $va_entity["displayname"];	
										}
										foreach($va_entities_sort as $vs_entity_type => $va_entities_by_type){
											print "<div class='unit'><H6>".ucfirst($vs_entity_type)."</H6>";
											print join(", ", $va_entities_by_type);
											print "</div>";
										}
									}
									if($vs_tmp = $qr_res->get('ca_objects.page_number', array("delimeter" => ", "))){
										print "<div class='unit'><H6>Page Number</H6>".$vs_tmp."</div>";
									}
									if($vs_tmp = $qr_res->get('ca_objects.page_count', array("delimeter" => ", "))){
										print "<div class='unit'><H6>Page Count</H6>".$vs_tmp."</div>";
									}
									if($vs_tmp = $qr_res->getMediaInfo("ca_object_representations.media", 'ORIGINAL_FILENAME')){
										print "<div class='unit'><H6>File Name</H6>".$vs_tmp."</div>";
									}
?>
								</div>
								<div class="col-sm-3">
<?php
									print "<div class='detailTool'><i class='material-icons inline'>mail_outline</i>".caNavLink($this->request, "Inquire About this Item", "", "", "contact", "form", array('object_id' => $qr_res->get('ca_objects.object_id'), 'contactType' => 'inquiry'))."</div>";
									print "<div class='detailTool'><i class='material-icons inline'>bookmark</i><a href='#' onClick='caMediaPanel.showPanel(\"".caNavUrl($this->request, "", "Lightbox", "addItemForm", array('context' => $this->request->getAction(), 'object_id' => $qr_res->get('ca_objects.object_id')))."\"); return false;'> Add to My Projects</a></div>";
?>				
								</div>
							</div>
							<div class="row"><div class="col-sm-12"><br/><br/><HR/><br/><br/></div></div>
<?php
						}else{
							if($vs_table == "ca_objects"){
								# --- caption info
								
								$vs_caption = "<div class='resultType'>";
								$vs_caption .= $qr_res->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))." &rsaquo; ";
								$vs_brand = $qr_res->get("ca_objects.brand", array("convertCodesToDisplayText" => true, "delimiter" => ", "));
								$vs_subbrand = $qr_res->get("ca_objects.sub_brand", array("convertCodesToDisplayText" => true, "delimiter" => ", "));
								if($vs_brand || $vs_subbrand){
									$vs_caption .= $vs_brand.(($vs_brand && $vs_subbrand) ? " &rsaquo; " : "").$vs_subbrand;
								}
								$vs_caption .= "</div>";
								$vs_caption .= trim($qr_res->get('ca_objects.preferred_labels'));
								$vs_tmp = $qr_res->getWithTemplate('^ca_objects.manufacture_date');
								if(!$qr_res->get("ca_objects.manufacture_date")){
									$vs_tmp .= "undated";
								}
								if(trim($vs_tmp)){
									$vs_caption .= ", ".$vs_tmp;
								}
								if($vs_tmp = $qr_res->get("ca_objects.codes.product_code")){
									$vs_caption .= " (".$vs_tmp.")";
								}
								$vs_label_detail_link = caDetailLink($this->request, $vs_caption, '', $vs_table, $vn_id, array("last_tab" => "browse"));
							}
							if(!$vs_image){
								if ($vs_table == 'ca_objects') {
								
									if(($vs_typecode == "folder") && !($qr_res->get("ca_objects.children.object_id", array("checkAccess" => $va_access_values)))){
										$vs_typecode = "folder_empty";
									}
									if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
										$vs_image = "<div class='bResultItemImgPlaceholder".$vs_folder_class."'>".$vs_type_placeholder."</div>";
									}else{
										$vs_image = $vs_default_placeholder_tag;
									}
								}else{
									$vs_image = $vs_default_placeholder_tag;
								}
							}
							$vs_rep_detail_link 	= caDetailLink($this->request, $vs_image, '', $vs_table, $vn_id, array("last_tab" => "browse"));	
				
							$vs_add_to_set_link = "";
							if(($vs_table == 'ca_objects') && is_array($va_add_to_set_link_info) && sizeof($va_add_to_set_link_info)){
								$vs_add_to_set_link = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', $va_add_to_set_link_info["controller"], 'addItemForm', array($vs_pk => $vn_id))."\"); return false;' title='".$va_add_to_set_link_info["link_text"]."'>".$va_add_to_set_link_info["icon"]."</a>";
							}
				
							$vs_expanded_info = $qr_res->getWithTemplate($vs_extended_info_template);

							$vs_result_output = "
								<div class='bResultListItemCol col-xs-{$vn_col_span_xs} col-sm-{$vn_col_span_sm} col-md-{$vn_col_span}'>
									<div class='bResultListItem' id='row{$vn_id}' onmouseover='jQuery(\"#bResultListItemExpandedInfo{$vn_id}\").show();'  onmouseout='jQuery(\"#bResultListItemExpandedInfo{$vn_id}\").hide();'>
										<div class='bSetsSelectMultiple'><input type='checkbox' name='object_ids[]' value='{$vn_id}'></div>
										<div class='bResultListItemContent'><div class='text-center bResultListItemImg'>{$vs_rep_detail_link}</div>
											<div class='bResultListItemText'>
												{$vs_label_detail_link}
											</div><!-- end bResultListItemText -->
										</div><!-- end bResultListItemContent -->
										<div class='bResultListItemExpandedInfo' id='bResultListItemExpandedInfo{$vn_id}'>
											<hr>
											{$vs_expanded_info}{$vs_add_to_set_link}
										</div><!-- bResultListItemExpandedInfo -->
									</div><!-- end bResultListItem -->
								</div><!-- end col -->";
						}
					}else{

						$vs_result_output = "
							<div class='row'><div class='col-sm-12'>
								<div class='unit collectionChronology'>
									<div class='row'>
										<div class='col-sm-3 col-md-2'>
											<b>".(($qr_res->get("ca_occurrences.display_date")) ? $qr_res->get("ca_occurrences.display_date") : $qr_res->get("ca_occurrences.manufacture_date")).(($vs_season = $qr_res->get("ca_occurrences.season_list", array("convertCodesToDisplayText" => true))) ? ", ".$vs_season : "")."</b>
										</div>
										<div class='col-sm-8 col-sm-offset-1 col-md-9 col-md-offset-1'>".$qr_res->get("{$vs_table}.preferred_labels")."</div>
									</div>
								</div>
								
							</div><!-- end col --></div><!-- end row -->";					
					}
					ExternalCache::save($vs_cache_key, $vs_result_output, 'browse_result');
					print $vs_result_output;
				}				
				$vn_c++;
				$vn_results_output++;
			}
			
			print "<div style='clear:both'></div>".caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_results_output, 'key' => $vs_browse_key, 'view' => $vs_current_view, 'sort' => $vs_current_sort, '_advanced' => $this->getVar('is_advanced') ? 1  : 0, 'dontSetFind' => $this->request->getParameter('dontSetFind', pString)));
		}
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		if($("#bSetsSelectMultipleButton").is(":visible")){
			$(".bSetsSelectMultiple").show();
		}
	});
</script>