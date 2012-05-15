<?php
	$vn_scrollingColHeight = 600;
	$vn_numItemsPerCol = 3;
?>
	<h1><?php print _t("Favorites"); ?></h1>
<?php
# --- exhibition themes
	$va_exhibition_ids = array(300, 302, 303, 304, 305, 306);
	$va_exhibition_themes = array();
	foreach($va_exhibition_ids as $vn_set_id){
		$t_set = new ca_sets();
		$t_set->load($vn_set_id);
		$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("thumbnailVersion" => "preview", 'checkAccess' => caGetUserAccessValues($this->request))));
		foreach($va_set_items as $va_set_item){
			$va_exhibition_themes[$vn_set_id] = array("image" => $va_set_item["representation_tag"], "title" => $t_set->getLabelForDisplay(), "object_id" => $va_set_item["row_id"]);
			break;
		}
	}
	
?>
	<div class="favoritesColumn" id="featuredCol">
		<div class="title"><?php print _t("Exhibition Themes"); ?></div>
		<div class="bg">
			<div id="scrollFeatured">
				<div id="scrollFeaturedContainer">
<?php
	$vn_featured_count = 0;
	if(is_array($va_exhibition_themes) && sizeof($va_exhibition_themes) > 0){
		foreach($va_exhibition_themes as $vn_set_id => $va_info){
?>
			<table cellpadding="0" cellspacing="0" id="exhibitionTheme<?php print $vn_set_id; ?>"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $va_info["image"], '', 'Detail', 'Object', 'Show', array('set_id' => $vn_set_id, 'object_id' => $va_info["object_id"])); ?></td></tr></table>
<?php
			$vn_featured_count++;
			TooltipManager::add(
				"#exhibitionTheme{$vn_set_id}", "<div><b>".$va_info["title"]."</b></div>"
			);
		}
	}
?>
				</div><!-- end scrollFeaturedContainer -->
			</div><!-- end scrollFeatured -->
		</div><!-- end bg -->
		<a href="#" class="more" onclick="scrollFeaturedItems(); return false;"><?php print _t("More"); ?> &gt;</a>
	</div><!-- end favoritesColumn -->
	<div class="favoritesSpacerColumn"><!-- empty --></div><!-- end favoritesSpacerColumn -->
<script type="text/javascript">
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
<div class="favoritesColumn" id="recentlyAddedCol">
		<div class="title"><?php print _t("User Favorites"); ?></div>
		<div class="bg">
			<div id="scrollRecentlyAdded">
				<div id="scrollRecentlyAddedContainer">
<?php
	$vn_recently_added_count = 0;
	if(is_array($this->getVar("user_favs")) && sizeof($this->getVar("user_favs")) > 0){
		foreach($this->getVar("user_favs") as $vn_object_id => $vs_thumb){
?>
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $vs_thumb, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id)); ?></td></tr></table>
<?php
			$vn_recently_added_count++;
		}
	}
?>
				</div><!-- end scrollRecentlyAddedContainer -->
			</div><!-- end scrollRecentlyAdded -->
		</div><!-- end bg -->
		<a href="#" onclick="scrollRecentlyAddedItems(); return false;" class="more"><?php print _t("More"); ?> &gt;</a>
	</div><!-- end favoritesColumn -->
<div class="favoritesSpacerColumn"><!-- empty --></div><!-- end favoritesSpacerColumn -->	
<script type="text/javascript">
	var scrollRecentlyAddedItemsCurrentPos = 0;
	function scrollRecentlyAddedItems() {
		var t = parseInt(jQuery('#scrollRecentlyAddedContainer').css('top'));
		if (!t) { t = 0; }
		if ((scrollRecentlyAddedItemsCurrentPos + <?php print $vn_numItemsPerCol; ?>) >= <?php print $vn_recently_added_count; ?>) { 
			t = <?php print $vn_scrollingColHeight; ?>; scrollRecentlyAddedItemsCurrentPos = -<?php print $vn_numItemsPerCol; ?>;
			
		}
		jQuery('#scrollRecentlyAddedContainer').animate({'top': (t - <?php print $vn_scrollingColHeight; ?>) + 'px'}, {'queue':true, 'duration': 1000, 'complete': function() { jQuery('#scrollRecentlyAddedContainer').stop(true); scrollRecentlyAddedItemsCurrentPos += <?php print $vn_numItemsPerCol; ?>; }});
	}
</script>
	<div class="favoritesColumn" id="mostViewedCol">
		<div class="title"><?php print _t("Most viewed"); ?></div>
		<div class="bg">
			<div id="scrollMostViewed">
				<div id="scrollMostViewedContainer">
<?php
	$vn_most_viewed_count = 0;
	if(is_array($this->getVar("most_viewed")) && sizeof($this->getVar("most_viewed")) > 0){
		foreach($this->getVar("most_viewed") as $vn_object_id => $vs_thumb){
?>
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $vs_thumb, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id)); ?></td></tr></table>
<?php
			$vn_most_viewed_count++;
		}
	}
?>
				</div><!-- end scrollMostViewedContainer -->
			</div><!-- end scrollMostViewed -->
		</div><!-- end bg -->
		<a href="#" onclick="scrollMostViewedItems(); return false;" class="more"><?php print _t("More"); ?> &gt;</a>
	</div><!-- end favoritesColumn -->

<script type="text/javascript">
	var scrollMostViewedItemsCurrentPos = 0;
	function scrollMostViewedItems() {
		var t = parseInt(jQuery('#scrollMostViewedContainer').css('top'));
		if (!t) { t = 0; }
		if ((scrollMostViewedItemsCurrentPos + <?php print $vn_numItemsPerCol; ?>) >= <?php print $vn_most_viewed_count; ?>) { 
			t = <?php print $vn_scrollingColHeight; ?>; scrollMostViewedItemsCurrentPos = -<?php print $vn_numItemsPerCol; ?>;
			
		}
		jQuery('#scrollMostViewedContainer').animate({'top': (t - <?php print $vn_scrollingColHeight; ?>) + 'px'}, {'queue':true, 'duration': 1000, 'complete': function() { jQuery('#scrollMostViewedContainer').stop(true); scrollMostViewedItemsCurrentPos += <?php print $vn_numItemsPerCol; ?>; }});
	}
</script>
	
	<div class="textContentFavorites">
<?php
		print $this->render('Favorites/favorites_intro_text_html.php');
?>
	</div><!-- end textContent -->