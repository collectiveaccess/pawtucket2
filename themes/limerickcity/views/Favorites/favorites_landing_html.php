<?php
			$t_object = new ca_objects();
 			$t_featured = new ca_sets();
 			$t_featured->load(array('set_code' => $this->request->config->get('featured_set_name')));
 			 # Enforce access control on set
 			if(sizeof($va_access_values) && !in_array($t_featured->get("access"), $va_access_values)){
  				$t_featured = new ca_sets();
 			}
 			$va_featured = array();
			if(is_array($va_row_ids = $t_featured->getItemRowIDs(array('checkAccess' => $va_access_values)))){
				$va_featured_ids = array_keys($va_row_ids);	// These are the object ids in the set
				foreach($va_featured_ids as $vn_f_object_id){
					$t_object = new ca_objects($vn_f_object_id);
					$va_reps = $t_object->getPrimaryRepresentation(array('thumbnail', 'preview'), null, array('return_with_access' => $va_access_values));
					$va_featured[$vn_f_object_id] = $va_reps["tags"]["preview"];
					$vs_featured_content_label = $t_object->getLabelForDisplay();
				}
 			}else{
 				# --- get random objects
 				$va_random_ids = $t_object->getRandomItems(15, array('checkAccess' => $va_access_values, 'hasRepresentations' => 1));
				if(is_array($va_random_ids) && sizeof($va_random_ids) > 0){
					$va_random = array();
					foreach($va_random_ids as $va_item_info){
						$vn_rand_object_id = $va_item_info['object_id'];
						$t_object->load($vn_rand_object_id);
						$va_reps = $t_object->getPrimaryRepresentation(array('thumbnail', 'preview'), null, array('return_with_access' => $va_access_values));
						$va_random[$vn_rand_object_id] = $va_reps["tags"]["preview"];
						$vs_featured_content_label = $t_object->getLabelForDisplay();
					}
					$va_featured = $va_random;
				}
 			}

?>
	<div id="featuredHeader">Featured Objects</div>
	<div class="textContent">
<?php
		print $this->render('Favorites/favorites_intro_text_html.php');
?>
	</div><!-- end textContent -->
	<div class="favoritesColumn" id="featuredCol">
			<div id="scrollFeatured">
				<div id="scrollFeaturedContainer">
<?php
	$vn_featured_count = 0;
	if(is_array($this->getVar("featured")) && sizeof($this->getVar("featured")) > 0){
		foreach($this->getVar("featured") as $vn_object_id => $vs_thumb){
			if ($vn_featured_count <= 4){
			$va_featured_desc = $t_object->get("ca_objects.description");
			$va_featured_description = substr($va_featured_desc,0,485);
?>
		<div id="featuredWrapper">
			<div id="featuredImage"><table><tr><td><?php print caNavLink($this->request, $vs_thumb, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id)); ?></td></tr></table></div><div id="featuredText"><div id="featuredTextTitle"><?php print $vs_featured_content_label; ?></div>
				<?php print $va_featured_description; 
					if (strlen($va_featured_desc) > 480) {
						print "...";
					}
				
				
				?></div>
			<div class="divide"></div>
		</div>

<?php
			$vn_featured_count++;
			}
		}
	}
?>
				</div><!-- end scrollFeaturedContainer -->
			</div><!-- end scrollFeatured -->

	</div><!-- end favoritesColumn -->
<!-- <script type="text/javascript">
	var scrollFeaturedItemsCurrentPos = 0;
	function scrollFeaturedItems() {
		var t = parseInt(jQuery('#scrollFeaturedContainer').css('top'));
		if (!t) { t = 0; }
		if ((scrollFeaturedItemsCurrentPos + <?php print $vn_numItemsPerCol; ?>) >= <?php print $vn_featured_count; ?>) { 
			t = <?php print $vn_scrollingColHeight; ?>; scrollFeaturedItemsCurrentPos = -<?php print $vn_numItemsPerCol; ?>;
		}
		jQuery('#scrollFeaturedContainer').animate({'top': (t - <?php print $vn_scrollingColHeight; ?>) + 'px'}, {'queue':true, 'duration': 1000, 'complete': function() { jQuery('#scrollFeaturedContainer').stop(true); scrollFeaturedItemsCurrentPos += <?php print $vn_numItemsPerCol; ?>; }});
	}
</script>
-->