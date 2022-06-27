<?php
	$t_list = new ca_lists();
	
	$va_access_values = caGetUserAccessValues($this->request);
	$t_set = new ca_sets();
 	$t_set->load(array('set_code' => 'featured_thumbs'));
 	$id =  $t_set->get('ca_sets.set_id');
 	$vn_set_item_ids = $t_set->getItems(array('checkAccess' => $va_access_values));
	
	include_once(__CA_LIB_DIR__."/Search/SetSearch.php");
?>

	<div class='row'>
		<div class='col-sm-12'>
			<h1>Galleries</h1>
		</div>
	</div>
	<div class='row'>
<?php
		$vs_theme_array = array( 0 => 'thematic_guide', 1 => 'timeline', 2 => 'in_focus');
		$vn_i = 0;
		if ($vn_set_item_ids) {
			foreach ($vn_set_item_ids as $va_key => $vn_set_item_id_t) {
				foreach ($vn_set_item_id_t as $va_key => $vn_set_item_id) {
					$t_set_item = new ca_set_items($vn_set_item_id['item_id']);
					$t_object = new ca_objects($vn_set_item_id['row_id']);
					print "<div class='col-sm-4'>";
					$vn_thematic_type_id = $t_list->getItemIDFromList("lightbox_cats", $vs_theme_array[$vn_i]);
					print "<div class='featuredGallery'>";
					print "<div class='featuredImage'>".caNavLink($this->request, $t_object->get('ca_object_representations.media.iconlarge'), '', '', 'Gallery', 'Index', array('theme' => $vn_thematic_type_id))."</div>";
					print "<div class='featuredTitle'>".caNavLink($this->request, $t_set_item->get('ca_set_items.preferred_labels'), '', '', 'Gallery', 'Index', array('theme' => $vn_thematic_type_id))."</div>";
					print "</div>";
					print "<div class='featuredCaption'><p>".caNavLink($this->request, $t_set_item->get('ca_set_items.preferred_labels'), '', '', 'Gallery', 'Index', array('theme' => $vn_thematic_type_id))."</p>".$t_set_item->get('ca_set_items.caption')."</div>";				
					print "</div>";
					$vn_i++;
				}
			}
		}
?>	
				
	</div>