<?php
global $g_ui_locale;
?>
<div id="contentArea">
	<h1><?php print _t("Favorites"); ?></h1>
	<div class="favoritesColumn" style="margin-right:21px;" id="featuredCol">
		<div class="title"><?php print _t("Featured content"); ?></div>
		<div class="bg">
			<div id="scrollFeatured">
				<div id="scrollFeaturedContainer">
<?php
	$vn_featured_count = 0;
	if(is_array($this->getVar("featured")) && sizeof($this->getVar("featured")) > 0){
		foreach($this->getVar("featured") as $vn_object_id => $vs_thumb){
?>
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $vs_thumb, '', '', 'ObjectDetail', 'Show', array('object_id' => $vn_object_id, 'search_mode' => 'favorites_featured')); ?></td></tr></table>
<?php
			$vn_featured_count++;
		}
	}
?>
				</div>
			</div><!-- end scrollFeatured -->
		</div><!-- end bg -->
		<a href="#" class="more" onclick="scrollFeaturedItems(); return false;"><?php print _t("More"); ?> &gt;</a>
	</div>
<script type="text/javascript">
	var scrollFeaturedItemsCurrentPos = 0;
	function scrollFeaturedItems() {
		var t = parseInt(jQuery('#scrollFeaturedContainer').css('top'));
		if (!t) { t = 0; }
		if ((scrollFeaturedItemsCurrentPos + 4) >= <?php print $vn_featured_count; ?>) { 
			t = 560; scrollFeaturedItemsCurrentPos = -4;
		}
		jQuery('#scrollFeaturedContainer').animate({'top': (t - 560) + 'px'}, {'queue':true, 'duration': 1000, 'complete': function() { jQuery('#scrollFeaturedContainer').stop(true); scrollFeaturedItemsCurrentPos += 4; }});
	}
</script>
	<div class="favoritesColumn" style="margin-right:21px;" id="userFavsCol">
		<div class="title"><?php print _t("User favorites"); ?></div>
		<div class="bg">
			<div id="scrollUserFavs">
				<div id="scrollUserFavsContainer">
<?php
	$vn_user_favs_count = 0;
	if(is_array($this->getVar("user_favs")) && sizeof($this->getVar("user_favs")) > 0){
		foreach($this->getVar("user_favs") as $vn_object_id => $vs_thumb){
?>
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $vs_thumb, '', '', 'ObjectDetail', 'Show', array('object_id' => $vn_object_id, 'search_mode' => 'favorites_favorite')); ?></td></tr></table>
<?php
			$vn_user_favs_count++;
		}
	}
?>
				</div>
			</div><!-- end scrollUserfavs -->
		</div><!-- end bg -->
		<a href="#"  onclick="scrollUserFavsItems(); return false;"  class="more"><?php print _t("More"); ?> &gt;</a>
	</div>
<script type="text/javascript">
	var scrollUserFavsItemsCurrentPos = 0;
	function scrollUserFavsItems() {
		var t = parseInt(jQuery('#scrollUserFavsContainer').css('top'));
		if (!t) { t = 0; }
		if ((scrollUserFavsItemsCurrentPos + 4) >= <?php print $vn_user_favs_count; ?>) { 
			t = 560; scrollUserFavsItemsCurrentPos = -4;
		}
		jQuery('#scrollUserFavsContainer').animate({'top': (t - 560) + 'px'}, {'queue':true, 'duration': 1000, 'complete': function() { jQuery('#scrollUserFavsContainer').stop(true); scrollUserFavsItemsCurrentPos += 4;}});
	}
</script>
	<div class="favoritesColumn" style="margin-right:21px;" id="mostViewedCol">
		<div class="title"><?php print _t("Most viewed"); ?></div>
		<div class="bg">
			<div id="scrollMostViewed">
				<div id="scrollMostViewedContainer">
<?php
	$vn_most_viewed_count = 0;
	if(is_array($this->getVar("most_viewed")) && sizeof($this->getVar("most_viewed")) > 0){
		foreach($this->getVar("most_viewed") as $vn_object_id => $vs_thumb){
?>
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $vs_thumb, '', '', 'ObjectDetail', 'Show', array('object_id' => $vn_object_id, 'search_mode' => 'favorites_most_viewed')); ?></td></tr></table>
<?php
			$vn_most_viewed_count++;
		}
	}
?>
				</div>
			</div><!-- end scrollMostViewed -->
		</div><!-- end bg -->
		<a href="#" onclick="scrollMostViewedItems(); return false;" class="more"><?php print _t("More"); ?> &gt;</a>
<script type="text/javascript">
	var scrollMostViewedItemsCurrentPos = 0;
	function scrollMostViewedItems() {
		var t = parseInt(jQuery('#scrollMostViewedContainer').css('top'));
		if (!t) { t = 0; }
		if ((scrollMostViewedItemsCurrentPos + 4) >= <?php print $vn_most_viewed_count; ?>) { 
			t = 560; scrollMostViewedItemsCurrentPos = -4;
			
		}
		jQuery('#scrollMostViewedContainer').animate({'top': (t - 560) + 'px'}, {'queue':true, 'duration': 1000, 'complete': function() { jQuery('#scrollMostViewedContainer').stop(true); scrollMostViewedItemsCurrentPos += 4; }});
	}
</script>
	</div>
	<div class="favoritesTextColumn" id="intro">
<?php
		print _t("Favorites gives site visitors a look into your collection by presenting them with three groups of items to browse.<br/><br/>&rsaquo; <i>Featured Content</i> is a curated selection of items from the collection.<br/><br/>&rsaquo; <i>User Favorites</i> highlights the items that have been ranked the highest by the site's registered users.<br/><br/>&rsaquo; <i>Most Viewed</i> presents the most visited items from the collection.");
?>
	</div>
</div><!-- end contentArea -->