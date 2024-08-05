<?php

/**
 *
 */
function caGetLightboxPreviewImage(int $id, SearchResult $qr_res, ?array $options=null) {
	global $g_request;
	
	$access_values = caGetOption('checkAccess', $options, null);
	
	$table = Datamodel::getTableName($qr_res->get('table_num'));
	
	$o_icons_conf = caGetIconsConfig();
	if(!($default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$default_placeholder = "<div class='display-1 text-center d-flex bg-light ca-placeholder' aria-label='media placeholder image' aria-role='img'><i class='bi bi-card-image align-self-center w-100'></i></div>";
	}
	if ($table == 'ca_objects') {
		$t_set = $qr_res->getInstance();
		$set_items = caExtractValuesByUserLocale($t_set->getItems(["user_id" => $g_request->user->get("user_id"), "thumbnailVersions" => ["iconlarge", "icon"], "checkAccess" => $access_values, "limit" => 5]));
	
		$images = array_filter(array_map(function($v) {
			return $v['representation_tag_iconlarge'];
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
		if($images[$id]){
			$thumbnail = $images[$id];
		}else{
			$vs_thumbnail = $default_placeholder;
		}
		$rep_detail_link = caNavLink($g_request, $thumbnail, '', '*', '*', 'Detail/'.$id);			
	}
	return $rep_detail_link;
}
