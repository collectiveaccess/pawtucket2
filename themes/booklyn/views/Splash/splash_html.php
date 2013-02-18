<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/Splash/splash_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2011 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
 
	JavascriptLoadManager::register("cycle");
	$t_object = new ca_objects();
	
	 $va_access_values = caGetUserAccessValues($this->request);

	$t_featured = new ca_sets();
	$t_featured->load(array('set_code' => $this->request->config->get('featured_set_name')));
	 # Enforce access control on set
	if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_featured->get("access"), $va_access_values))){
		$va_featured_ids = array_keys(is_array($va_tmp = $t_featured->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 0))) ? $va_tmp : array());	// These are the object ids in the set
	}
	
	$va_item_ids = $va_featured_ids;
	
	$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("mediumlarge", "widepreview", "splashpic"));
	$va_item_labels = $t_object->getPreferredDisplayLabelsForIDs($va_item_ids);

 	$title_id = array_shift(array_keys($va_item_media));
 	$t_object = new ca_objects($title_id);
 	$va_artist_name = $t_object->get('ca_entities.preferred_labels.displayname', array('restrictToRelationshipTypes' => array('artist'), 'delimiter' => ' and '));
 ?>

	<h1 class='results'>Featured Art: <?php print $va_artist_name;?></h1>
	<div style="height:25px;width:100%"></div>
<!--	<div id="hpFeatured">-->
<?php
#	foreach ($va_item_media as $vn_object_id => $va_media) {
#			$vs_image_tag = $va_media["tags"]["mediumlarge"];
#			$vn_padding_top = 0;
#			$vn_padding_top = ((450 - $va_media["info"]["mediumlarge"]["HEIGHT"]) / 2);
#			print "<div style='margin-top:10px;'><div id='featuredScroll' style='margin-top:".$vn_padding_top."px; margin-bottom:".$vn_padding_top."px;'>".caNavLink($this->request, $vs_image_tag, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
#			print "<div id='featuredScrollCaption'>".caNavLink($this->request, $va_item_labels[$vn_object_id], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div></div>";
#	}
?>
<!--</div>-->
<?php

#$va_media_array = array_slice($va_media_array, 0);
	$i = 0;
	foreach ($va_item_media as $vn_object_id => $va_media) {
#		print "<pre>";
#		print_r($va_media);
#		print "</pre>";
		if ($i != 0) {
			$t_object = new ca_objects($vn_object_id);
			$vs_image_tag = $va_media["tags"]["widepreview"];
			print "<div class='featuredImg'>".caNavLink($this->request, $vs_image_tag, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
			print "<div class='featuredTitleSmall'>".caNavLink($this->request, $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'))), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div></div>";

		} else {
			$t_object = new ca_objects($vn_object_id);
			print "<div id='hpFeatured'>";
			print "<div class='featuredImg' style='margin-bottom:5px'>".caNavLink($this->request, $va_media["tags"]["splashpic"], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
			print "<div class='featuredTitle'>".caNavLink($this->request, $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'))), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";

			print "</div>";
		}
		if ($i == 3) {
			print "<div style='clear:both;height:0px; width:100%'></div>";
		}
		$i++;
	}
?>
	
	
	<div id="newsList" style="width:200px; margin-top:30px;">
		<div class="item detail">
<?php
#		print $this->render('Splash/splash_intro_text_html.php');
?> 

		</div>			


			
		<div class="item detail"><div class="description" style="margin-top:20px;"><?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath(true).'/graphics/feed.gif" border="0" title="'._t('Get alerted to newly added items by RSS').'" width="14" height="14"/> '._t('Get alerted to newly added items by RSS'), '', '', 'Feed', 'recentlyAdded'); ?></div></div>
	</div>
	

<?php
	TooltipManager::add('#splashRandomObject', $this->getVar("random_object_medium")."<br/><div class='tooltipCaption'>".$this->getVar('random_object_title')."</div>");
	TooltipManager::add('#splashRecentlyViewed', $this->getVar("recently_viewed_medium")."<br/><div class='tooltipCaption'>".$this->getVar('recently_viewed_title')."</div>");
	TooltipManager::add('#splashRecentlyAdded', $this->getVar("recently_added_medium")."<br/><div class='tooltipCaption'>".$this->getVar('recently_added_title')."</div>");
?>
<!--<script type="text/javascript">
$(document).ready(function() {
   $('#hpFeatured').cycle({
               fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
               speed:  1000,
               timeout: 4000
       });
});
</script>-->