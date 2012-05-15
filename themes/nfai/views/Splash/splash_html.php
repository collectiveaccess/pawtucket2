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
 
	$t_object = new ca_objects();
	
	$va_item_ids = $this->getVar('featured_content_slideshow_id_list');
	$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("medium"));
	$va_item_labels = $t_object->getPreferredDisplayLabelsForIDs($va_item_ids);
 ?>
	<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
		<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton"></a>
		<div id="splashBrowsePanelContent">
		
		</div>
	</div>
	<script type="text/javascript">
		var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});
	</script>
	

	<div id="hpFeatured">
<?php
	foreach ($va_item_media as $vn_object_id => $va_media) {
			$vs_image_tag = $va_media["tags"]["medium"];
			$vn_padding_top = 0;
			$vn_padding_top = ((410 - $va_media["info"]["medium"]["HEIGHT"]) / 2);
			print "<div style='margin-top:10px;'><div id='featuredScroll' style='margin-top:".$vn_padding_top."px; margin-bottom:".$vn_padding_top."px;'>".caNavLink($this->request, $vs_image_tag, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
			print "<div id='featuredScrollCaption'>".caNavLink($this->request, $va_item_labels[$vn_object_id], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div></div>";
	}
?>
	</div>
	<div id="hpTextContainer">
		<div id="hpText">
<?php
		print $this->render('Splash/splash_intro_text_html.php');
?> 
<div class="hpRss"><?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath(true).'/graphics/feed.gif" border="0" title="'._t('Get alerted to newly added items by RSS').'" width="14" height="14"/> '._t('Get alerted to newly added items by RSS'), 'caption', '', 'Feed', 'recentlyAdded'); ?></div>
		</div>			

		<div id="hpBrowseDiv">
			<div id="hpBrowse">
			<div class="hpBrowseTitle"><?php print _t("Quickly browse by"); ?>:</div>
				<div id="hpBrowseFacet">
<?php

					$va_facets = $this->getVar('available_facets');
					foreach($va_facets as $vs_facet_name => $va_facet_info) {
?>
						<a href="#" style="white-space:nowrap;" onclick='caUIBrowsePanel.showBrowsePanel("<?php print $vs_facet_name; ?>"); return false;'><?php print ucwords($va_facet_info['label_plural']); ?></a>
<?php
					}
?>
				</div>
			</div><!-- end hpBrowse-->
		</div>
			
		
	</div>
	
	<div id="quickLinkItems">
		<div class="quickLinkItem">			
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("random_object_splashthumb"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("random_object_id")), array('id' => 'splashRandomObject')); ?></td></tr></table>
			<div class="title"><?php print _t("Random Object") ?></div>
		</div>
		<div class="quickLinkItem">
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("recently_viewed_splashthumb"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("recently_viewed_id")), array('id' => 'splashRecentlyViewed')); ?></td></tr></table>
			<div class="title"><?php print _t("Recently Viewed"); ?></div>
		</div>
		<div class="quickLinkItem" style="margin-right:0px;">
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("recently_added_splashthumb"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("recently_added_id")), array('id' => 'splashRecentlyAdded')); ?></td></tr></table>
			<div class="title"><?php print _t("Recently Added"); ?></div>
		</div>	
	</div>
<?php
	TooltipManager::add('#splashRandomObject', $this->getVar("random_object_medium")."<br/><div class='tooltipCaption'>".$this->getVar('random_object_title')."</div>");
	TooltipManager::add('#splashRecentlyViewed', $this->getVar("recently_viewed_medium")."<br/><div class='tooltipCaption'>".$this->getVar('recently_viewed_title')."</div>");
	TooltipManager::add('#splashRecentlyAdded', $this->getVar("recently_added_medium")."<br/><div class='tooltipCaption'>".$this->getVar('recently_added_title')."</div>");
?>
<script type="text/javascript">
$(document).ready(function() {
   $('#hpFeatured').cycle({
               fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
               speed:  1000,
               timeout: 4000
       });
});
</script>