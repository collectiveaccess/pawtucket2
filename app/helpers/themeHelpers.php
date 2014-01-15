<?php
/** ---------------------------------------------------------------------
 * app/helpers/configurationHelpers.php : utility functions for setting database-stored configuration values
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage utils
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 * 
 * ----------------------------------------------------------------------
 */

	/**
	*
	*/
   
   	
	# ---------------------------------------
	/**
	 * 
	 *
	 * @return Configuration 
	 */
	function caGetDetailConfig() {
		$o_config = Configuration::load();
		return Configuration::load($o_config->get('detail_config'));
	}
	# ---------------------------------------
	/**
	 * Returns associative array, keyed by primary key value with values being
	 * the preferred label of the row from a suitable locale, ready for display 
	 * 
	 * @param array $pa_ids indexed array of primary key values to fetch labels for
	 * @param array $pa_options
	 * @return array List of media
	 */
	function caGetPrimaryRepresentationsForIDs($pa_ids, $pa_options=null) {
		if (!is_array($pa_ids) && (is_numeric($pa_ids)) && ($pa_ids > 0)) { $pa_ids = array($pa_ids); }
		if (!is_array($pa_ids) || !sizeof($pa_ids)) { return array(); }
		
		$pa_access_values = caGetOption("checkAccess", $pa_options, array());
		$pa_versions = caGetOption("versions", $pa_options, array(), array('castTo' => 'array'));
		$ps_table = caGetOption("table", $pa_options, 'ca_objects');
		$pa_return = caGetOption("return", $pa_options, array(), array('castTo' => 'array'));
		
		$vs_access_where = '';
		if (isset($pa_access_values) && is_array($pa_access_values) && sizeof($pa_access_values)) {
			$vs_access_where = ' AND orep.access IN ('.join(',', $pa_access_values).')';
		}
		$o_db = new Db();
		$o_dm = Datamodel::load();
		
		if (!($vs_linking_table = RepresentableBaseModel::getRepresentationRelationshipTableName($ps_table))) { return null; }
		$vs_pk = $o_dm->getTablePrimaryKeyName($ps_table);
	
		$qr_res = $o_db->query("
			SELECT oxor.{$vs_pk}, orep.media
			FROM ca_object_representations orep
			INNER JOIN {$vs_linking_table} AS oxor ON oxor.representation_id = orep.representation_id
			WHERE
				(oxor.{$vs_pk} IN (".join(',', $pa_ids).")) AND oxor.is_primary = 1 AND orep.deleted = 0 {$vs_access_where}
		");
	
		$vb_return_tags = (sizeof($pa_return) == 0) || in_array('tags', $pa_return);
		$vb_return_info = (sizeof($pa_return) == 0) || in_array('info', $pa_return);
		$vb_return_urls = (sizeof($pa_return) == 0) || in_array('urls', $pa_return);
		
		$va_media = array();
		while($qr_res->nextRow()) {
			$va_media_tags = array();
			if ($pa_versions && is_array($pa_versions) && sizeof($pa_versions)) { $va_versions = $pa_versions; } else { $va_versions = $qr_res->getMediaVersions('media'); }
			
			$vb_media_set = false;
			foreach($va_versions as $vs_version) {
				if (!$vb_media_set && $qr_res->getMediaPath('ca_object_representations.media', $vs_version)) { $vb_media_set = true; }
				
				if ($vb_return_tags) {
					if (sizeof($va_versions) == 1) {
						$va_media_tags['tags'] = $qr_res->getMediaTag('ca_object_representations.media', $vs_version);
					} else {
						$va_media_tags['tags'][$vs_version] = $qr_res->getMediaTag('ca_object_representations.media', $vs_version);
					}
				}
				if ($vb_return_info) {
					if (sizeof($va_versions) == 1) {
						$va_media_tags['info'] = $qr_res->getMediaInfo('ca_object_representations.media', $vs_version);
					} else {
						$va_media_tags['info'][$vs_version] = $qr_res->getMediaInfo('ca_object_representations.media', $vs_version);
					}
				}
				if ($vb_return_urls) {
					if (sizeof($va_versions) == 1) {
						$va_media_tags['urls'] = $qr_res->getMediaUrl('ca_object_representations.media', $vs_version);
					} else {
						$va_media_tags['urls'][$vs_version] = $qr_res->getMediaUrl('ca_object_representations.media', $vs_version);
					}
				}
			}
			
			if (!$vb_media_set)  { continue; }
			
			if (sizeof($pa_return) == 1) {
				$va_media_tags = $va_media_tags[$pa_return[0]];
			}
			$va_media[$qr_res->get($vs_pk)] = $va_media_tags;
		}
	
		// Return empty array when there's no media
		if(!sizeof($va_media)) { return array(); }
	
		// Preserve order of input ids
		$va_media_sorted = array();
		foreach($pa_ids as $vn_id) {
			if(!isset($va_media[$vn_id]) || !$va_media[$vn_id]) { continue; }
			$va_media_sorted[$vn_id] = $va_media[$vn_id];
		} 
		
		return $va_media_sorted;
	}
	# ---------------------------------------
	/**
	 * Returns associative array, keyed by primary key value with values being
	 * the preferred label of the row from a suitable locale, ready for display 
	 * 
	 * @param array $pa_ids indexed array of primary key values to fetch labels for
	 * @param array $pa_options
	 * @return array List of media
	 */
	function caGetPrimaryRepresentationTagsForIDs($pa_ids, $pa_options=null) {
		$pa_options['return'] = array('tags');
		
		return caGetPrimaryRepresentationsForIDs($pa_ids, $pa_options);
	}
	# ---------------------------------------
	/**
	 * Returns associative array, keyed by primary key value with values being
	 * the preferred label of the row from a suitable locale, ready for display 
	 * 
	 * @param array $pa_ids indexed array of primary key values to fetch labels for
	 * @param array $pa_options
	 * @return array List of media
	 */
	function caGetPrimaryRepresentationInfoForIDs($pa_ids, $pa_options=null) {
		$pa_options['return'] = array('info');
		
		return caGetPrimaryRepresentationsForIDs($pa_ids, $pa_options);
	}
	# ---------------------------------------
	/**
	 * Returns associative array, keyed by primary key value with values being
	 * the preferred label of the row from a suitable locale, ready for display 
	 * 
	 * @param array $pa_ids indexed array of primary key values to fetch labels for
	 * @param array $pa_options
	 * @return array List of media
	 */
	function caGetPrimaryRepresentationUrlsForIDs($pa_ids, $pa_options=null) {
		$pa_options['return'] = array('urls');
		
		return caGetPrimaryRepresentationsForIDs($pa_ids, $pa_options);
	}
	# ---------------------------------------
	/**
	 * Returns the primary representation for display on the object detail page
	 * uses settings from media_display.conf
	 */
	function caObjectDetailMedia($o_request, $pn_object_id, $t_representation, $pa_options=null) {
		$va_access_values = caGetUserAccessValues($o_request);
		if (!sizeof($va_access_values) || in_array($t_representation->get('access'), $va_access_values)) { 		// check rep access
			$va_rep_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
			
			$va_rep_display_info['poster_frame_url'] = $t_representation->getMediaUrl('media', $va_rep_display_info['poster_frame_version']);
		
			$va_opts = array('display' => 'detail', 'object_id' => $pn_object_id, 'containerID' => 'cont');
			$vs_tool_bar = "<div id='detailMediaToolbar'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $pn_object_id, 'representation_id' => $t_representation->getPrimaryKey(), 'overlay' => 1))."\"); return false;' ><span class='glyphicon glyphicon-zoom-in'></span></a>\n";
			if ($o_request->isLoggedIn()) {
				$vs_tool_bar .= " <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'Sets', 'addItemForm', array("object_id" => $pn_object_id))."\"); return false;' ><span class='glyphicon glyphicon-folder-open'></span></a>\n";
			}
			if(caObjectsDisplayDownloadLink($o_request)){
				# -- get version to download configured in media_display.conf
				$va_download_display_info = caGetMediaDisplayInfo('download', $t_representation->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
				$vs_download_version = $va_download_display_info['display_version'];
				$vs_tool_bar .= caNavLink($o_request, " <span class='glyphicon glyphicon-download-alt'></span>", '', 'Detail', 'DownloadRepresentation', '', array('representation_id' => $t_representation->getPrimaryKey(), "object_id" => $pn_object_id, "download" => 1, "version" => $vs_download_version));
			}
			$vs_tool_bar .= "</div><!-- end detailMediaToolbar -->\n";
			return "<div id='cont'>".$t_representation->getRepresentationViewerHTMLBundle($o_request, $va_opts)."</div>".$vs_tool_bar;
			
		}else{
			return "representation is not accessible to the public";
		}
	}
	# ---------------------------------------
	/*
	 * list of comments and 
	 * comment form for all detail pages
	 *
	 */
	# ---------------------------------------
	function caDetailItemComments($o_request, $pn_item_id, $t_item, $va_comments, $va_tags){
		$vs_tmp = "";
		if(is_array($va_comments) && (sizeof($va_comments) > 0)){
			foreach($va_comments as $va_comment){
				$vs_tmp .= "<blockquote>";
				if($va_comment["media1"]){
					$vs_tmp .= '<div class="pull-right" id="commentMedia'.$va_comment["comment_id"].'">';
					$vs_tmp .= $va_comment["media1"]["tiny"]["TAG"];						
					$vs_tmp .= "</div><!-- end pullright commentMedia -->\n";
					TooltipManager::add(
						"#commentMedia".$va_comment["comment_id"], $va_comment["media1"]["large_preview"]["TAG"]
					);
				}
				if($va_comment["comment"]){
					$vs_tmp .= $va_comment["comment"];
				}				
				$vs_tmp .= "<small>".$va_comment["author"].", ".$va_comment["date"]."</small></blockquote>";
			}
		}
		if(is_array($va_tags) && sizeof($va_tags) > 0){
			$va_tag_links = array();
			foreach($va_tags as $vs_tag){
				$va_tag_links[] = caNavLink($o_request, $vs_tag, '', '', 'MultiSearch', 'Index', array('search' => $vs_tag));
			}
			$vs_tmp .= "<h2>"._t("Tags")."</h2>\n
				<div id='tags'>".implode($va_tag_links, ", ")."</div>";
		}		
		if($o_request->isLoggedIn()){
			$vs_tmp .= "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'Detail', 'CommentForm', array("tablename" => $t_item->tableName(), "item_id" => $t_item->getPrimaryKey()))."\"); return false;' >"._t("Add your tags and comment")."</button>";
		}else{
			$vs_tmp .= "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login/register to comment on this object")."</button>";
		}
		return $vs_tmp;
	}
	# ---------------------------------------
	/*
	 * Returns the info for each set
	 * 
	 * options: "write_access" = false
	 *
	 */
	function caLightboxSetListItem($o_request, $t_set, $va_check_access = array(), $va_options = array()) {
		if(!$t_set->get("set_id")){
			return false;
		}
		$vb_write_access = false;
		if($va_options["write_access"]){
			$vb_write_access = true;
		}

		$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("user_id" => $o_request->user->get("user_id"), "thumbnailVersions" => array("preview", "icon"), "checkAccess" => $va_check_access, "limit" => 4)));
		$vs_set_display = "";
		$vs_set_display .= "<div class='lbItem' onmouseover='jQuery(\"#lbExpandedInfo".$t_set->get("set_id")."\").show();'  onmouseout='jQuery(\"#lbExpandedInfo".$t_set->get("set_id")."\").hide();'><div class='lbItemContent'>\n";
			if(sizeof($va_set_items)){
				$vs_image_block = "";
				$vn_i = 1;
				foreach($va_set_items as $va_set_item){
					if($vn_i == 1){
						$vs_image_block .= "<div class='lbItemImg'>".$va_set_item["representation_tag_preview"]."</div><!-- end lbItemImg -->\n";
					}else{
						$vs_image_block .= "<div class='lbItemThumb'>".$va_set_item["representation_tag_icon"]."</div><!-- end lbItemThumb -->\n";
					}
					$vn_i++;
				}
			}else{
				$vs_image_block .= "no items in set";
			}
			$vs_set_display .= caNavLink($o_request, $vs_image_block, "", "", "Sets", "setDetail", array("set_id" => $t_set->get("set_id")));
			$vs_set_display .= "<div id='comment".$t_set->get("set_id")."' class='lbSetComment'><!-- load comments here --></div>\n";
			$vs_set_display .= "<div class='clearfix'><!-- empty --></div><div><small>".$t_set->getLabelForDisplay()."</small></div>\n";
			$vs_set_display .= "</div><!-- end lbItemContent -->\n";
			$vs_set_display .= "<div class='lbExpandedInfo' id='lbExpandedInfo".$t_set->get("set_id")."'>\n<hr><div><small>created by: ".trim($t_set->get("ca_users.fname")." ".$t_set->get("ca_users.lname"))."</small></div>\n";
			$vs_set_display .= "<div><small>Num items: ".$t_set->getItemCount(array("user_id" => $o_request->user->get("user_id"), "checkAccess" => $va_check_access))."</small></div>\n";
			if($vb_write_access){
				$vs_set_display .= "<div class='pull-right'>".caNavLink($o_request, '<span class="glyphicon glyphicon-remove"></span>', '', '', 'Sets', 'DeleteSet', array('set_id' => $t_set->get("set_id")), array("title" => _t("Delete")))."</div>\n";
			}
			$vs_set_display .= "<div><a href='#' onclick='jQuery(\"#comment".$t_set->get("set_id")."\").load(\"".caNavUrl($o_request, '', 'Sets', 'AjaxListComments', array('item_id' => $t_set->get("set_id"), 'tablename' => 'ca_sets'))."\", function(){jQuery(\"#comment".$t_set->get("set_id")."\").show();}); return false;' title='"._t("Comments")."'><span class='glyphicon glyphicon-comment'></span> <small>".$t_set->getNumComments()."</small></a></div>\n";
			$vs_set_display .= "</div><!-- end lbExpandedInfo --></div><!-- end lbItem -->\n";
		return $vs_set_display;
	}
	# ---------------------------------------
	/**
	 * Returns the info for each set item
	 * 
	 * options: "write_access" = false
	 * 
	 */
	function caLightboxSetDetailItem($o_request, $va_set_item = array(), $va_options = array()) {
		$t_set_item = new ca_set_items($va_set_item["item_id"]);
		if(!$t_set_item->get("item_id")){
			return false;
		}
		$vb_write_access = false;
		if($va_options["write_access"]){
			$vb_write_access = true;
		}
		$vs_set_item_display = "";
		$vs_set_item_display .= "<div class='lbItem' onmouseover='jQuery(\"#lbExpandedInfo".$t_set_item->get("item_id")."\").show();'  onmouseout='jQuery(\"#lbExpandedInfo".$t_set_item->get("item_id")."\").hide();'><div class='lbItemContent'>\n";
		$vs_set_item_display .= caDetailLink($o_request, "<div class='lbItemImg'>".$va_set_item["representation_tag_preview"]."</div>", '', 'ca_objects', $va_set_item["row_id"]);
		$vs_set_item_display .= "<div id='comment".$t_set_item->get("item_id")."' class='lbSetComment'><!-- load comments here --></div>\n";
		$vs_set_item_display .= "<div><small>".$va_set_item["set_item_label"]."</small></div>\n";
		$vs_set_item_display .= "</div><!-- end lbItemContent -->\n";
		$vs_set_item_display .= "<div class='lbExpandedInfo' id='lbExpandedInfo".$t_set_item->get("item_id")."'>\n<hr>\n";
		if($vb_write_access){
			$vs_set_item_display .= "<div class='pull-right'><a href='#' class='lbItemDeleteButton' id='lbItemDelete".$t_set_item->get("item_id")."' title='"._t("Remove")."'><span class='glyphicon glyphicon-remove'></a></div>\n";
		}
		$vs_set_item_display .= "<div><a href='#' onclick='jQuery(\"#comment".$t_set_item->get("item_id")."\").load(\"".caNavUrl($o_request, '', 'Sets', 'AjaxListComments', array('item_id' => $t_set_item->get("item_id"), 'tablename' => 'ca_set_items'))."\", function(){jQuery(\"#comment".$t_set_item->get("item_id")."\").show();}); return false;'><span class='glyphicon glyphicon-comment'></span> <small>".$t_set_item->getNumComments()."</small></a></div>\n";
		$vs_set_item_display .= "</div><!-- end lbExpandedInfo --></div><!-- end lbItem -->\n";
		return $vs_set_item_display;
	}
	# ---------------------------------------
?>