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
			return "<div id='cont'>".$t_representation->getRepresentationViewerHTMLBundle($o_request, $va_opts)."</div>";
		}else{
			return "representation is not accessible to the public";
		}
	}
	# ---------------------------------------
	/**
	 * Returns the info for each set
	 */
	function caLightboxSetListItem($o_request, $t_set, $va_check_access = array()) {
		if(!$t_set->get("set_id")){
			return false;
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
			$vs_set_display .= "<div><small>".$t_set->get("ca_sets.preferred_labels.name")."</small></div>\n";
			$vs_set_display .= "</div><!-- end lbItemContent -->\n";
			$vs_set_display .= "<div class='lbExpandedInfo' id='lbExpandedInfo".$t_set->get("set_id")."'>\n<hr><div><small>created by: ".trim($t_set->get("ca_users.fname")." ".$t_set->get("ca_users.lname"))."</small></div>\n";
			$vs_set_display .= "<div><small>Num items: ".$t_set->getItemCount(array("user_id" => $o_request->user->get("user_id"), "checkAccess" => $va_check_access))."</small></div>\n";
			$vs_set_display .= "<div><a href='#' onclick='jQuery(\"#comment".$t_set->get("set_id")."\").load(\"".caNavUrl($o_request, '', 'Sets', 'AjaxListComments', array('item_id' => $t_set->get("set_id"), 'tablename' => 'ca_sets'))."\", function(){jQuery(\"#comment".$t_set->get("set_id")."\").show();}); return false;'><span class='glyphicon glyphicon-comment'></span> <small>".$t_set->getRatingsCount()."</small></a></div>\n";
			$vs_set_display .= "</div><!-- end lbExpandedInfo --></div><!-- end lbItem -->\n";
		return $vs_set_display;
	}
	# ---------------------------------------
	/**
	 * Returns the info for each set item
	 */
	function caLightboxSetDetailItem($o_request, $va_set_item = array()) {
		$t_set_item = new ca_set_items($va_set_item["item_id"]);
		if(!$t_set_item->get("item_id")){
			return false;
		}
		$vs_set_item_display = "";
		$vs_set_item_display .= "<div class='lbItem' onmouseover='jQuery(\"#lbExpandedInfo".$t_set_item->get("item_id")."\").show();'  onmouseout='jQuery(\"#lbExpandedInfo".$t_set_item->get("item_id")."\").hide();'><div class='lbItemContent'>\n";
		$vs_set_item_display .= caNavLink($o_request, "<div class='lbItemImg'>".$va_set_item["representation_tag_preview"]."</div>", "", "", "Detail", "Object", array("object_id" => $va_set_item["row_id"]));
		$vs_set_item_display .= "<div id='comment".$t_set_item->get("item_id")."' class='lbSetComment'><!-- load comments here --></div>\n";
		$vs_set_item_display .= "<div><small>".$va_set_item["set_item_label"]."</small></div>\n";
		$vs_set_item_display .= "</div><!-- end lbItemContent -->\n";
		$vs_set_item_display .= "<div class='lbExpandedInfo' id='lbExpandedInfo".$t_set_item->get("item_id")."'>\n<hr>\n";
		$vs_set_item_display .= "<div><a href='#' onclick='jQuery(\"#comment".$t_set_item->get("item_id")."\").load(\"".caNavUrl($o_request, '', 'Sets', 'AjaxListComments', array('item_id' => $t_set_item->get("item_id"), 'tablename' => 'ca_set_items'))."\", function(){jQuery(\"#comment".$t_set_item->get("item_id")."\").show();}); return false;'><span class='glyphicon glyphicon-comment'></span> <small>".$t_set_item->getRatingsCount()."</small></a></div>\n";
		$vs_set_item_display .= "</div><!-- end lbExpandedInfo --></div><!-- end lbItem -->\n";
		return $vs_set_item_display;
	}
	# ---------------------------------------