<?php
/** ---------------------------------------------------------------------
 * app/helpers/lightboxHelpers.php : utility functions lightbox interface
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2024 Whirl-i-Gig
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
 
# ---------------------------------------
/**
 *
 */
function caGetLightboxPreviewImage(int $id, SearchResult $qr_res, ?array $options=null) {
	global $g_request;
	
	$access_values = caGetOption('checkAccess', $options, null);
	$class = caGetOption('class', $options, null);
	
	$table = Datamodel::getTableName($qr_res->get('table_num'));
	
	$o_icons_conf = caGetIconsConfig();
	if(!($default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$default_placeholder = "<div class='display-1 text-center d-flex bg-light ca-placeholder' aria-label='media placeholder image' aria-role='img'><i class='bi bi-card-image align-self-center w-100'></i></div>";
	}
	if ($table == 'ca_objects') {
		$t_set = $qr_res->getInstance();
		$set_items = caExtractValuesByUserLocale($t_set->getItems(["user_id" => $g_request->user->get("user_id"), "thumbnailVersions" => ["iconlarge", "icon", "small"], "class" => $class, "checkAccess" => $access_values, "limit" => 5]));
	
		$images = array_filter(array_map(function($v) {
			return $v['representation_tag_small'];
		}, $set_items), 'strlen');
	
		if(!($thumbnail = array_shift($images))) {
			$typecode = caGetListItemIdno($qr_res->get("type_id"));
			if($type_placeholder = caGetPlaceholder($typecode, "placeholder_media_icon")){
				$thumbnail = $type_placeholder;
			} else {
				$thumbnail = $default_placeholder;
			}
		}
		$rep_detail_link = caNavLink($g_request, $thumbnail, '', '*', '*', 'Detail/'.$id);				
	} else {
		// TODO: get reps for non-objects
		$vs_thumbnail = $default_placeholder;
		$rep_detail_link = caNavLink($g_request, $thumbnail, '', '*', '*', 'Detail/'.$id);			
	}
	return $rep_detail_link;
}
# ---------------------------------------
/**
 *
 */
function caGetLightboxesForUser(?int $user_id, ?array $check_access, ?array $options=null) : ?SearchResult {
	if(!$user_id) { return null; }
	$t_sets = new ca_sets();
	
	$sort = caGetOption('sort', $options, null);
	$sort_direction = caGetOption('sortDirection', $options, 'ASC');
	$access = caGetOption('access', $options, 1);
	$configured_tables = caGetOption('tables', $options, null);
	if(!is_array($configured_tables)) { $configured_tables = ['ca_objects']; }
	
	$sets = $t_sets->getSetsForUser([
		'tables' => $configured_tables, 
		"user_id" => $user_id, 
		"checkAccess" => $check_access, 
		"parents_only" => true, 
		'sort' => $sort, 
		'sortDirection' => $sort_direction
	]);
	
// 	$read_sets = $t_sets->getSetsForUser([
// 		'tables' => $configured_tables, 
// 		"user_id" => $user_id, 
// 		"checkAccess" => $check_access,
// 		"access" => $access, 
// 		"parents_only" => true, 
// 		'sort' => $sort, 
// 		'sortDirection' => $sort_direction]);
// 	foreach($write_sets as $id => $info) {
// 		unset($read_sets[$id]);
// 	}
	// $read_sets = array_map(function($v) { $v['writeable'] = false; return $v; }, $read_sets);		
// 	$write_sets = array_map(function($v) { $v['writeable'] = true; return $v; }, $write_sets);	
	
	$lightboxes = caMakeSearchResult('ca_sets', array_keys($sets), ['sort' => 'ca_sets.preferred_labels', 'sortDirection' => 'ASC']);
	return $lightboxes;
	//return caSortArrayByKeyInValue(array_merge($read_sets, $write_sets), ['label'], 'ASC', ['caseInsensitive' => true]);
}
# ---------------------------------------
/**
 *
 */
function caGetLightboxesForItem(BaseModel $t_subject) {
	$t_set = new ca_sets();
	$sets = $t_set->getSetsForItem($t_subject->tableName(), $t_subject->getPrimaryKey(), []);
	$sets = caExtractValuesByUserLocale($sets);
	return $sets;
}

# ---------------------------------------
/**
 *
 */
function caGetLightboxDisplayName($o_lightbox_config = null){
	if(!$o_lightbox_config){ $o_lightbox_config = caGetLightboxConfig(); }
	$lightbox_displayname_singular = $o_lightbox_config->get(["lightbox_displayname_singular", "lightboxDisplayName"]);
	if(!$lightbox_displayname_singular){
		$lightbox_displayname_singular = _t("lightbox");
	}
	$lightbox_displayname_plural = $o_lightbox_config->get(["lightbox_displayname_plural", "lightboxDisplayNamePlural"]);
	if(!$lightbox_displayname_plural){
		$lightbox_displayname_plural = _t("lightboxes");
	}
	$lightbox_section_heading = $o_lightbox_config->get(["lightbox_section_heading", "lightboxSectionHeading"]);
	if(!$lightbox_section_heading){
		$lightbox_section_heading = _t("lightboxes");
	}
	return ["singular" => $lightbox_displayname_singular, "plural" => $lightbox_displayname_plural, "section_heading" => $lightbox_section_heading];
}
# ---------------------------------------
/** 
 *
 */
function caDisplayLightbox(RequestHTTP $request) : bool {
	if($request->isLoggedIn() && !$request->config->get("disable_lightbox")) {
		return true;
	} else {
		return false;
	}
}
# ---------------------------------------
