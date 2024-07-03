<?php
# ---------------------------------------
/**
 * Used to display full collection hierarchy as list on detail pages
 * recursive loop to display all collection children
 * 
 */	
function caGetCollectionHierarchyList($po_request, $va_collection_ids, $vn_level, $options=null) {
	$o_collections_config = caGetCollectionsConfig();
	$start = caGetOption('start', $options, 0, ['castTo' => 'int']);
	$cache_key = caMakeCacheKeyFromOptions(array_merge($options ?? [], ['level' => $vn_level, 'ids' => $va_collection_ids, 'start' => $start]));
	
	$partial = caGetOption('partial', $options, false);
	
	if((bool)$o_collections_config->get('do_caching') && ExternalCache::contains($cache_key, 'collectionHierarchy')) {
		return ExternalCache::fetch($cache_key, 'collectionHierarchy');
	}
	$va_access_values = caGetUserAccessValues($po_request);
	# --- get collections configuration
	if($o_collections_config->get("export_max_levels") && ($vn_level > $o_collections_config->get("export_max_levels"))){
		return null;
	}
	
	if(!($max_items = $o_collections_config->get("max_items"))) { $max_items = 10; }
	
	$t_list = new ca_lists();
	$va_exclude_collection_type_ids = array();
	if($va_exclude_collection_type_idnos = $o_collections_config->get("export_exclude_collection_types")){
		# --- convert to type_ids
		$va_exclude_collection_type_ids = $t_list->getItemIDsFromList("collection_types", $va_exclude_collection_type_idnos, array("dontIncludeSubItems" => true));
	}
	$vs_output = "";
	$qr_collections = caMakeSearchResult("ca_collections", $va_collection_ids);
	
	$vs_sub_collection_label_template = $o_collections_config->get("sub_collection_label_template_list");
	$vs_sub_collection_desc_template = $o_collections_config->get("sub_collection_description_template_list");
	$vs_sub_collection_sort = $o_collections_config->get("sub_collection_sort_list");
	if(!$vs_sub_collection_sort){
		$vs_sub_collection_sort = "ca_collections.idno_sort";
	}
	$vb_dont_show_top_level_description = false;
	if($o_collections_config->get("dont_show_top_level_description") && ($vn_level == 1)){
		$vb_dont_show_top_level_description = true;
	}
	$va_collection_type_icons = array();
	$va_collection_type_icons_by_idnos = $o_collections_config->get("export_collection_type_icons");
	if(is_array($va_collection_type_icons_by_idnos) && sizeof($va_collection_type_icons_by_idnos)){
		foreach($va_collection_type_icons_by_idnos as $vs_idno => $vs_icon){
			$va_collection_type_icons[$t_list->getItemId("collection_types", $vs_idno)] = $vs_icon;
		}
	}
	if($n = $qr_collections->numHits()){
		$c = 0;
		if($start > 0) { $qr_collections->seek($start); }
		while($qr_collections->nextHit()) {
			if($va_exclude_collection_type_ids && is_array($va_exclude_collection_type_ids) && (in_array($qr_collections->get("ca_collections.type_id"), $va_exclude_collection_type_ids))){
				continue;
			}
	
			$vs_icon = "";
			if(is_array($va_collection_type_icons) && $va_collection_type_icons[$qr_collections->get("ca_collections.type_id")]){
				$vs_icon = $va_collection_type_icons[$qr_collections->get("ca_collections.type_id")];
			}	
			
			$collection_id = $qr_collections->get("ca_collections.collection_id");
					
			# --- related items?
			$va_item_ids = $qr_collections->get("ca_collections.children.collection_id", array("restrictToTypes" => array("item"), "returnAsArray" => true, 'checkAccess' => $va_access_values));
			$vn_rel_item_count = sizeof($va_item_ids);
			$va_child_ids = $qr_collections->get("ca_collections.children.collection_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "sort" => $vs_sub_collection_sort));
			
			$vs_output .= "<div id='hierLevelFor{$collection_id}' class='unit' style='margin-left:".(30*($vn_level - 1))."px;'>";
			if($vs_icon){
				$vs_output .= $vs_icon." ";
			}
			$vs_output .= "<b class='hierLevel{$vn_level}'>";
			if($vs_sub_collection_label_template){
				$vs_output .= $qr_collections->getWithTemplate($vs_sub_collection_label_template);
			}else{
				$vs_output .= $qr_collections->get("ca_collections.preferred_labels");
			}
			$vs_output .= "</b>";
	
			#if($vn_rel_item_count){
			#	$vs_output .= " <span class='small'>(".$vn_rel_item_count." item".(($vn_rel_item_count == 1) ? "" : "s").")</span>";
			#}
			$vs_output .= "<br/>";
		
			if(!$partial && !$vb_dont_show_top_level_description){
				$vs_desc = "";
				if($vs_sub_collection_desc_template && ($vs_desc = $qr_collections->getWithTemplate($vs_sub_collection_desc_template, array("truncate" => 550, "ellipsis" => true)))){
					$vs_output .= "<p>".$vs_desc."</p>";
				}
			}
			

			if(sizeof($va_child_ids)) {
				$vs_output .=  "<div class='levelChildren'>".caGetCollectionHierarchyList($po_request, $va_child_ids, $vn_level + 1)."</div>\n";
			}
			$vs_output .= "</div>";
			$c++;
			
			if($c >= $max_items) { 
				if(($n-$start-$c) > 0){
					$s = $start + $c;
					$parent_id = $qr_collections->get('ca_collections.parent_id');
					$vs_output .= "<div class='unit' style='margin-left:".(30*($vn_level - 1))."px;'><a href='#' class='loadMore' onclick='caHierarchyLoadMore(this, {$parent_id}, {$s}, {$vn_level}); return false;'>"._t('+ %1 more', ($n-$start-$c))."</a></div>\n";
				}
				break; 
			}
		}
	}
	ExternalCache::save($cache_key, $vs_output, 'collectionHierarchy');
	return $vs_output;
}