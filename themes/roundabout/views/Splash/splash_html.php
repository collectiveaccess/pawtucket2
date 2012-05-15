<?php
	$va_access_values = $this->getVar("access_values");
?>
<div id="right-col">
	<div class="promo-block">
		<div class="shadow"></div>
		<h3>Contact the Archivist</h3>
		<p>Call 212-719-9393 or <a href="mailto:archives@roundabouttheatre.org">email us</a>.</p>
		<p>Want access to our physical archives?</p>
		<a href="<?php print $this->request->getBaseUrlPath(); ?>/pdf/RoundaboutTheatreCompany_Archives_PhysicalAccessForm.pdf" target="_blank" class="block-btn">Download Form</a>
		
    <!--end .promo-block -->
    </div>

	<div class="promo-block recently-added added-<?php echo $num_thumbs; ?>">
		<div class="shadow"></div>
		<h3><?php print _t("Recently Added"); ?></h3>
		<!-- RECENTLY ADDED-->
		
		<div class="favoritesColumn" id="recentlyAddedCol">
			<div id="scrollRecentlyAdded">
				<div id="scrollRecentlyAddedContainer">
					<?php
						$vn_scrollingColHeight = 600;
						$vn_numItemsPerCol = 3;
					?>
					<?php
						$vn_recently_added_count = 0;
						$va_recently_added = $this->getVar("recently_added_objects");
						if(is_array($va_recently_added) && sizeof($va_recently_added) > 0){
							foreach($va_recently_added as $vn_object_id => $va_recently_added_item){
								#print_r($va_recently_added_item);
								if($va_recently_added_item['media']['tags']['preview']){
					?>

								<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $va_recently_added_item['media']['tags']['preview'], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id)); ?></td></tr></table>
					<?php
								$vn_recently_added_count++;
								} //endif
							} //end foreach
						} //endif
					?>
				</div><!-- end scrollRecentlyAddedContainer -->
			</div><!-- end scrollRecentlyAdded -->

			<?php if($vn_recently_added_count > $vn_numItemsPerCol) { ?>
				<a href="#" onclick="scrollRecentlyAddedItems(); return false;" class="block-btn hide-no-js"><?php print _t("View More"); ?></a>
			<?php } ?>
		</div><!-- end favoritesColumn -->
		<?php if($vn_recently_added_count > $vn_numItemsPerCol) { ?>
			<script type="text/javascript">
				var scrollRecentlyAddedItemsCurrentPos = 0;
				function scrollRecentlyAddedItems() {
					var t = parseInt(jQuery('#scrollRecentlyAddedContainer').css('top'));
					if (!t) { t = 0; }
					if ((scrollRecentlyAddedItemsCurrentPos + <?php print $vn_numItemsPerCol; ?>) >= <?php print $vn_recently_added_count; ?>) { 
						t = <?php print $vn_scrollingColHeight; ?>; scrollRecentlyAddedItemsCurrentPos = -<?php print $vn_numItemsPerCol; ?>;

					}
					jQuery('#scrollRecentlyAddedContainer').animate({'top': (t - <?php print $vn_scrollingColHeight; ?>) + 'px'}, {'queue':true, 'duration': 600, 'complete': function() { jQuery('#scrollRecentlyAddedContainer').stop(true); scrollRecentlyAddedItemsCurrentPos += <?php print $vn_numItemsPerCol; ?>; }});
				}
			</script>
		<?php } ?>
		<div class="clearfix"></div>
		
    <!--end .promo-block -->
    </div>

<!--end .right-col-->
</div>

<div id="left-col">
	
	<h1 class="visuallyhidden">Roundabout Theatre Archives</h1>
	<div class="search-callout hide-no-js">
		<h3>Search the Archives</h3>
		<form name="header_search_home" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
			<input type="text" name="search" placeholder="" onclick='jQuery("#quickSearch_home").select();' id="quickSearch_home"  autocomplete="off" />
			<a href="#" class="block-btn" name="searchButtonSubmit" onclick="document.forms.header_search_home.submit(); return false;">Go</a>
		</form>

		<a href="<?php print caNavUrl($this->request, '', 'AdvancedSearch', 'Index'); ?>" class="advanced-search-link">Advanced Search</a>
	<!--end .search-callout-->
	</div>
	
	<h2>Highlights from the Collection</h2>
	
	<?php
	$t_featured = new ca_sets();
	$featured_sets = $this->request->config->get('featured_sets');
	$len = count($featured_sets);
	if($len > 3) { $len = 3; }
	for($i = 0; $i < $len; $i++) {
		$t_featured->load(array('set_code' => $featured_sets[$i]));
		$set_id = $t_featured->getPrimaryKey();
		$set_title = $t_featured->getLabelForDisplay();
		$set_desc = $t_featured->getAttributeFromSets('description', Array(0 => $set_id ) );
		$va_featured_ids = array_keys(is_array($va_tmp = $t_featured->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 0))) ? $va_tmp : array());	// These are the object ids in the set
		if(is_array($va_featured_ids) && (sizeof($va_featured_ids) > 0)){
			$t_object = new ca_objects($va_featured_ids[0]);
			$va_rep = $t_object->getPrimaryRepresentation(array('preview', 'preview170'), null, array('return_with_access' => $va_access_values));
			$featured_set_id_array[$i] = array(
				'featured_set_code' => $featured_sets[$i],
				'featured_content_id' => $va_featured_ids[0],
				'featured_content_small' => $va_rep["tags"]["preview"],
				'featured_content_label' => $set_title,
				'featured_content_description' => $set_desc[$set_id][0],
				'featured_set_id' => $set_id
			);
		}
	}
	?>
	
	<?php if(isset($featured_set_id_array)) { ?>
	<table class="featured-list" cell-padding="0" cell-spacing="0">
		<tr>
			<?php
			foreach($featured_set_id_array as $feature_array) {
				//echo '<th><h3>'.$feature_array['featured_content_label'].'</h3></th>';
				echo '<th><h3>'.caNavLink($this->request, $feature_array['featured_content_label'], '', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $feature_array['featured_set_id'])).'</h3></th>';
			} ?>
		</tr>
		<tr>
			<?php
			foreach($featured_set_id_array as $feature_array) {
				echo '<td>'.caNavLink($this->request, $feature_array['featured_content_small'], 'thumb-link', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $feature_array['featured_set_id'])).'</td>';
			} ?>
		</tr>
		<tr>
			<?php
			foreach($featured_set_id_array as $feature_array) {
				echo '<td class="featured-desc">';
				echo 	'<div class="desc">'.(strlen($feature_array['featured_content_description']) > 120 ? substr(strip_tags($feature_array['featured_content_description']), 0, 120)."..." : $feature_array['featured_content_description']);
				echo 	'</div>';
				echo caNavLink($this->request, 'More', 'more-link', 'simpleGallery', 'Show', 'displaySet', array('set_id' => $feature_array['featured_set_id']));
				echo '</td>';
			} ?>
		</tr>
	</table>
	<?php }else { ?>
		<p>No Featured items available</p>
	<?php } ?>
	
	
	
	
	
<!--end #left-col-->	
</div>	