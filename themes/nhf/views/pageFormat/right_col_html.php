<?php
	require_once(__CA_MODELS_DIR__."/ca_collections.php");
	require_once(__CA_MODELS_DIR__.'/ca_sets.php');
 	require_once(__CA_MODELS_DIR__.'/ca_lists.php');
 	
 	$va_access_values = caGetUserAccessValues($this->request);
	
	# --- most popular collections
	$t_collections = new ca_collections();
	$va_user_favorites_collections = $t_collections->getHighestRated(null, 5, $va_access_values);
	if(is_array($va_user_favorites_collections) && (sizeof($va_user_favorites_collections) > 0)){
		$va_most_popular_collections = array();
		foreach($va_user_favorites_collections as $vn_fav_collection_id){
			$t_collection = new ca_collections($vn_fav_collection_id);
			if($t_collection->get("access") == 1){
				$va_most_popular_collections[$vn_fav_collection_id] = $t_collection->getLabelForDisplay();
			}
		}
	}
	
	# - get staff picks sets
	
	// get sets for public display
	$t_list = new ca_lists();
	$vn_public_set_type_id = $t_list->getItemIDFromList('set_types', 'Staff Pick');
	
	// get value for public access status value
	$va_tmp = $t_list->getItemFromList('access_statuses', 'public_access');
	$vn_public_access = $va_tmp['item_value'];
	
	$t_set = new ca_sets();
	$va_staff_picks_sets = array();
	#$va_staff_picks_sets = caExtractValuesByUserLocale($t_set->getSets('ca_collections', null, $va_access_values, null, $vn_public_set_type_id));
	$va_staff_picks_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_collections', 'checkAccess' => $va_access_values, "setType" => $vn_public_set_type_id)));


		if(is_array($va_most_popular_collections) && (sizeof($va_most_popular_collections) > 0)){
?>
			<div class="unit">
				<div class="heading">Most Popular Collections:</div>
				<ul class="crossList">
<?php
					foreach($va_most_popular_collections as $vn_pop_coll_id => $vs_pop_coll){
						print "<li>".caNavLink($this->request, $vs_pop_coll, '', 'Detail', 'Collection', 'Show', array('collection_id' => $vn_pop_coll_id))."</li>";
					}
?>			
				</ul>
			</div><!-- end unit -->
<?php
		}

		if(is_array($va_staff_picks_sets) && sizeof($va_staff_picks_sets)){
?>
			<div class="unit">
				<div class="heading"><?php print _t("STAFF PICKS"); ?></div>
				<div class="divide"><!-- empty --></div>
<?php
			foreach($va_staff_picks_sets as $vn_set_id => $va_set_info){
?>
				<div class="heading"><?php print $va_set_info["name"]; ?>:</div>
				<ul class="crossList">
<?php
				
				$t_set->load($vn_set_id);
				$va_set_items = caExtractValuesByUserLocale($t_set->getItems());
				foreach($va_set_items as $vn_item_id => $va_item_info){
					if($va_item_info["access"] == 1){
						print "<li>".caNavLink($this->request, $va_item_info["name"], '', 'Detail', 'Collection', 'Show', array('collection_id' => $va_item_info["row_id"]))."</li>";
					}
				}
?>
				</ul>
				<div class="divide"><!-- empty --></div>
<?php
			}
?>
			</div>
<?php
		}
?>