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
			<div id="featuredLabel">
				<?php print _t("Left").": ".$this->getVar("featured_content_label"); ?>
			</div><!-- end featuredLabel -->
		</div>
		<div id="hpFeatured">
			<div class="title"><?php print _t("Featured Item"); ?>:</div>
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("featured_content_mediumlarge"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("featured_content_id"))); ?></td></tr></table>
		</div>
		
		<div id="quickLinkItems">
			<div class="quickLinkItem">
				<div class="title"><?php print ($this->getVar("user_favorites_is_random")) ? _t("Random selection") : _t("User favorites"); ?>:</div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("user_favorites_preview"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("user_favorites_id"))); ?></td></tr></table>
				<div style="float:right; margin-top:4px;"><?php print caNavLink($this->request, _t("More &gt;"), "more", "", "Favorites", "Index"); ?></div>
			</div>
			<div class="quickLinkItem">
				<div class="title"><?php print _t("Most Viewed"); ?>:</div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("most_viewed_preview"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("most_viewed_id"))); ?></td></tr></table>
				<div style="float:right; margin-top:4px;"><?php print caNavLink($this->request, _t("More &gt;"), "more", "", "Favorites", "Index"); ?></div>
			</div>
			<div class="quickLinkItem" style="margin-right:0px;">
				<div class="title"><?php print _t("Recently Added"); ?>:</div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("recently_added_preview"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("recently_added_id"))); ?></td></tr></table>
				<div style="float:right; margin-top:4px;"><?php print caNavLink($this->request, _t("More &gt;"), "more", "", "Favorites", "Index"); ?></div>
			</div>
			<div id="hpBrowse">
				<div><b><?php print _t("Quickly browse by"); ?>:</b></div>
				<div style="margin-top:10px;">
<?php
					$va_facets = $this->getVar('available_facets');
					foreach($va_facets as $vs_facet_name => $va_facet_info) {
?>
						<a href="#" onclick='caUIBrowsePanel.showBrowsePanel("<?php print $vs_facet_name; ?>")'><?php print $va_facet_info['label_plural']; ?></a><br/>
<?php
					}
?>
				</div>
				<div style="margin-top:10px;" class="caption">
					<?php print _t("Or click \"Browse\" in the navigation bar to do a refined browse"); ?>
				</div>
			</div><!-- end hpBrowse-->
		</div><!-- end quickLinkItems -->
			
		<div class="hpRss"><?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath(true).'/graphics/feed.gif" border="0" title="'._t('Get alerted to newly added items by RSS').'" width="14" height="14"/> '._t('Get alerted to newly added items by RSS'), 'caption', '', 'Feed', 'recentlyAdded'); ?></div>