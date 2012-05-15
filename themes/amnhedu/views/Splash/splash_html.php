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
			<div class="hpRss"><?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath(true).'/graphics/feed.gif" border="0" title="'._t('Get alerted to newly added items by RSS').'" width="14" height="14"/> '._t('Get alerted to newly added items by RSS'), 'caption', '', 'Feed', 'recentlyAdded'); ?></div>
		</div>
		<div id="hpFeatured">
		<div class="title"><?php print _t("Natural History"); ?></div>
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center">
				<div id="hpSlider">
					<?php print caNavLink($this->request, $this->getVar("featured_content_widesplash"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("featured_content_id"))); ?>
				</div>
				<div id="naturalBrowse"> 
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/171/mod_id/0">Birds</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/172/mod_id/0">Mammals</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/173/mod_id/0">Fish</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/174/mod_id/0">Marine Invertebrates</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/175/mod_id/0">Insects</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/176/mod_id/0">Reptiles</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/177/mod_id/0">Rocks and Minerals</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/178/mod_id/0">Soils</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/179/mod_id/0">Meteorites</a>	
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/184/mod_id/0">Plants</a>	
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/181/mod_id/0">Plant Fossils</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/182/mod_id/0">Animal Fossils</a>	
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/183/mod_id/0">Trace Fossils</a>	
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/180/mod_id/0">Skeletons</a>
				</div>	
			</td></tr></table>	
		</div>
		<div id="hpFeatured2">
			<div class="title"><?php print _t("Cultural History"); ?></div>
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center">
				<div id="hpSlider2">
					<?php print caNavLink($this->request, $this->getVar("culture_content_widesplash"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("culture_content_id"))); ?>
				</div>
				<div id="naturalBrowse" style='height:77px;'>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/196/mod_id/0">Jewelry</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/198/mod_id/0">Art</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/191/mod_id/0">Clothing</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/199/mod_id/0">Games</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/189/mod_id/0">Tools</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/190/mod_id/0">Weapons</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/194/mod_id/0">Floral Remains</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/193/mod_id/0">Seeds</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/192/mod_id/0">Shells</a>
					<a href="/index.php/Browse/modifyCriteria/facet/spec_cat_facet/id/195/mod_id/0">Soil Remains</a>
				</div>
			</td></tr></table>	
		</div>	
		<div style="clear:both; height:50px;"></div>
		<div id="quickLinkItems">
			<div class="quickLinkItem">
				<div class="title"><?php print _t("Recently Viewed"); ?>:</div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("recently_viewed_widepreview"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("recently_viewed_id"))); ?></td></tr></table>
				<div style="float:right; margin-top:4px;"><?php print caNavLink($this->request, _t("More Items &gt;"), "more", "", "Favorites", "Index"); ?></div>
			</div>
			<div class="quickLinkItem">
				<div class="title"><?php print _t("Current Temporary Exhibit"); ?>:</div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("temp_content_widepreview"), '', 'simpleGallery', 'Show', 'displaySet', array('set_id' =>  $this->getVar("temp_set_id"))); ?></td></tr></table>
				<div style="float:right; margin-top:4px;"><?php print caNavLink($this->request, _t("View Collection &gt;"), "more", 'simpleGallery', 'Show', 'displaySet', array('set_id' =>  $this->getVar("temp_set_id"))); ?></div>
			</div>
			<div class="quickLinkItem" style="margin-right:0px;">
				<div class="title"><?php print _t("Featured Permanent Exhibit"); ?>:</div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("perm_content_widepreview"), '', 'simpleGallery', 'Show', 'displaySet', array('set_id' =>  $this->getVar("perm_set_id"))); ?></td></tr></table>
				<div style="float:right; margin-top:4px;"><?php print caNavLink($this->request, _t("View Collection &gt;"), "more", 'simpleGallery', 'Show', 'displaySet', array('set_id' =>  $this->getVar("perm_set_id"))); ?></div>
			</div>
			<div class="quickLinkItem" style="margin-right:0px;">
				<div class="title"><?php print _t("Upcoming Exhibit"); ?>:</div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("upcoming_content_widepreview"), '', 'simpleGallery', 'Show', 'displaySet', array('set_id' =>  $this->getVar("upcoming_set_id"))); ?></td></tr></table>
				<div style="float:right; margin-top:4px;"><?php print caNavLink($this->request, _t("View Collection &gt;"), "more", 'simpleGallery', 'Show', 'displaySet', array('set_id' =>  $this->getVar("upcoming_set_id"))); ?></div>
			</div>
			<div class="quickLinkItem" style="margin-right:0px;">
				<div class="title"><?php print _t("Recently Added"); ?>:</div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("recently_added_widepreview"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("recently_added_id"))); ?></td></tr></table>
				<div style="float:right; margin-top:4px;"><?php print caNavLink($this->request, _t("More Items &gt;"), "more", "", "Favorites", "Index"); ?></div>
			</div>
			<!--
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
			</div> -->
		</div><!-- end quickLinkItems -->
<?php
	JavascriptLoadManager::register('cycle');

	 	$t_slider = new ca_sets();
	 	$t_slider->load(array('set_code' => 'siteFeatured'));
 		//$va_items = $t_slider->getItems(array('thumbnailVersions' => array('medium', 'mediumlarge'), 'checkAccess' => $va_access_values));
 		$va_images = $t_slider->getRepresentationTags('widesplash', array('checkAccess' => $va_access_values, 'quote' => true));

	 	$t_slider = new ca_sets();
	 	$t_slider->load(array('set_code' => 'cultureFeatured'));
 		//$va_items = $t_slider->getItems(array('thumbnailVersions' => array('medium', 'mediumlarge'), 'checkAccess' => $va_access_values));
 		$va_images2 = $t_slider->getRepresentationTags('widesplash', array('checkAccess' => $va_access_values, 'quote' => true));		
?>		
<script type="text/javascript">
	caUI.initCycle('#hpSlider', { 
				fx: 'fade', 
				imageList: [
<?php
	print join(",\n", $va_images);
?>
				],
				duration: 30000, 
				rewindDuration: 30000,
				delay:	-1500,
				repetitions: 5 
			});
</script>
<script type="text/javascript">
	caUI.initCycle('#hpSlider2', { 
				fx: 'fade', 
				imageList: [
<?php
	print join(",\n", $va_images2);
?>
				],
				duration: 30000, 
				rewindDuration: 30000, 
				repetitions: 5 
			});
</script>
		