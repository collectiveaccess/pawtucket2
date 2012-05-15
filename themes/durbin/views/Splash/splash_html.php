		<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
			<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton"></a>
			<div id="splashBrowsePanelContent">
			
			</div>
		</div>
		<script type="text/javascript">
			var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});
		</script>
		
		<div id="hpText">
<?php
		print $this->render('Splash/splash_intro_text_html.php');
?> 

		</div>
		
		<div id="quickLinkItems">
			<div class="quickLinkItem">
				<div class="title"><?php print _t("Featured Content"); ?></div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("featured_content_label"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("featured_content_id"))); ?></td></tr></table>
<!--			<div style="float:right; margin-top:4px;"><?php print caNavLink($this->request, _t("More &gt;"), "more", "", "Favorites", "Index"); ?></div>
-->
			</div>
			<div class="quickLinkItem">
				<div class="title"><?php print _t("Random Selection"); ?></div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("random_item_label"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("most_viewed_id"))); ?></td></tr></table>
<!--			<div style="float:right; margin-top:4px;"><?php print caNavLink($this->request, _t("More &gt;"), "more", "", "Favorites", "Index"); ?></div>
-->
			</div>
			<div class="quickLinkItem" style="margin-right:0px;">
				<div class="title"><?php print _t("Recently Added"); ?></div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("recently_added_label"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("recently_added_id"))); ?></td></tr></table>
<!--			<div style="float:right; margin-top:4px;"><?php print caNavLink($this->request, _t("More &gt;"), "more", "", "Favorites", "Index"); ?></div>
-->
			</div>


			
		</div><!-- end quickLinkItems -->
			
		<div class="hpRss"><?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath(true).'/graphics/feed.gif" border="0" title="'._t('Get alerted to newly added items by RSS').'" width="14" height="14"/> '._t('Get alerted to newly added items by RSS'), 'caption', '', 'Feed', 'recentlyAdded'); ?></div>