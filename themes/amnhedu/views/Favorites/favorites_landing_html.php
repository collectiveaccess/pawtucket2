<?php
	$vn_scrollingColHeight = 600;
	$vn_numItemsPerCol = 3;
?>
	<h1><?php print _t("Favorites"); ?></h1>
	<div class="textContent">
<?php
		print $this->render('Favorites/favorites_intro_text_html.php');
?>
	</div><!-- end textContent -->
	<div class="favoritesColumn" id="featuredCol">
		<div class="title"><?php print _t("Featured specimens"); ?></div>
		<div class="bg">
			<div id="scrollFeatured">
				<div id="scrollFeaturedContainer">
<?php
	$vn_featured_count = 0;
	if(is_array($this->getVar("featured")) && sizeof($this->getVar("featured")) > 0){
		foreach($this->getVar("featured") as $vn_object_id => $vs_thumb){
?>
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $vs_thumb, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id)); ?></td></tr></table>
<?php
			$vn_featured_count++;
		}
	}
?>
				</div><!-- end scrollFeaturedContainer -->
			</div><!-- end scrollFeatured -->
		</div><!-- end bg -->
		<a href="#" class="more" onclick="scrollFeaturedItems(); return false;"><?php print _t("more"); ?> &gt;</a>
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
	<div class="favoritesColumn" id="userFavsCol">
		<div class="title"><?php print ($this->getVar("user_favorites_is_random")) ? _t("Random selection") : _t("User favorites"); ?></div>
		<div class="bg">
			<div id="scrollUserFavs">
				<div id="scrollUserFavsContainer">
<?php
	$vn_user_favs_count = 0;
	if(is_array($this->getVar("user_favs")) && sizeof($this->getVar("user_favs")) > 0){
		foreach($this->getVar("user_favs") as $vn_object_id => $vs_thumb){
?>
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $vs_thumb, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id)); ?></td></tr></table>
<?php
			$vn_user_favs_count++;
		}
	}
?>
				</div><!-- end scrollUserFavsContainer -->
			</div><!-- end scrollUserfavs -->
		</div><!-- end bg -->
		<a href="#"  onclick="scrollUserFavsItems(); return false;"  class="more"><?php print _t("more"); ?> &gt;</a>
	</div><!-- end favoritesColumn -->
	<div class="favoritesSpacerColumn"><!-- empty --></div><!-- end favoritesSpacerColumn -->
<script type="text/javascript">
	var scrollUserFavsItemsCurrentPos = 0;
	function scrollUserFavsItems() {
		var t = parseInt(jQuery('#scrollUserFavsContainer').css('top'));
		if (!t) { t = 0; }
		if ((scrollUserFavsItemsCurrentPos + <?php print $vn_numItemsPerCol; ?>) >= <?php print $vn_user_favs_count; ?>) { 
			t = <?php print $vn_scrollingColHeight; ?>; scrollUserFavsItemsCurrentPos = -<?php print $vn_numItemsPerCol; ?>;
		}
		jQuery('#scrollUserFavsContainer').animate({'top': (t - <?php print $vn_scrollingColHeight; ?>) + 'px'}, {'queue':true, 'duration': 1000, 'complete': function() { jQuery('#scrollUserFavsContainer').stop(true); scrollUserFavsItemsCurrentPos += <?php print $vn_numItemsPerCol; ?>;}});
	}
</script>
	<div class="favoritesColumn" id="mostViewedCol">
		<div class="title"><?php print _t("Recently viewed"); ?></div>
		<div class="bg">
			<div id="scrollMostViewed">
				<div id="scrollMostViewedContainer">
<?php
	$vn_most_viewed_count = 0;
	if(is_array($this->getVar("recently_viewed")) && sizeof($this->getVar("recently_viewed")) > 0){
		foreach($this->getVar("recently_viewed") as $vn_object_id => $vs_thumb){
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
		<a href="#" onclick="scrollMostViewedItems(); return false;" class="more"><?php print _t("more"); ?> &gt;</a>
	</div><!-- end favoritesColumn -->
	<div class="favoritesSpacerColumn"><!-- empty --></div><!-- end favoritesSpacerColumn -->
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
	<div class="favoritesColumn" id="recentlyAddedCol">
		<div class="title"><?php print _t("Recently Added"); ?></div>
		<div class="bg">
			<div id="scrollRecentlyAdded">
				<div id="scrollRecentlyAddedContainer">
<?php
	$vn_recently_added_count = 0;
	if(is_array($this->getVar("recently_added")) && sizeof($this->getVar("recently_added")) > 0){
		foreach($this->getVar("recently_added") as $vn_object_id => $vs_thumb){
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
		<a href="#" onclick="scrollRecentlyAddedItems(); return false;" class="more"><?php print _t("more"); ?> &gt;</a>
	</div><!-- end favoritesColumn -->
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
