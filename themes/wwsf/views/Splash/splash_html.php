		<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
			<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton"></a>
			<div id="splashBrowsePanelContent">
			
			</div>
		</div>
		<script type="text/javascript">
			var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});
		</script>
		
		<div id="hpText">
				<div style="float:left;">
					<a href="http://www.bpb.de" target="_blank"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/bpb_logo_final.jpg' width='113' height='47' border='0'></a>
				</div>
				<div style="float:right;">
					<a href="http://www.deutsche-kinemathek.de" target="_blank"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/dk_logo.gif' width='120' height='47' border='0'></a>
				</div>
				<div style="clear:both; height:5px;"><!-- empty --></div>
<?php
		print $this->render('Splash/splash_intro_text_html.php');
?> 
				<div style="margin:40px 0px 10px 20px;">
					<a href="http://www.freiheit-und-einheit.de" target="_blank"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/Signet6020_Web_dt_WBI.gif' width='119' height='102' border='0'></a>
				</div>

		</div>
		<div id="hpFeatured">
			<div class="title"><?php print caNavLink($this->request, $this->getVar("featured_content_label"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("featured_content_id"))); ?></div>
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("featured_content_medium"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("featured_content_id"))); ?></td></tr></table>
		</div>
		
		<div id="quickLinkItems">
<?php
	# --- exhibition themes
	$va_exhibition_ids = array(300, 302, 303, 304, 305, 306);
	shuffle($va_exhibition_ids);
	$t_set = new ca_sets();
	$t_set->load($va_exhibition_ids[0]);
	$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("thumbnailVersion" => "thumbnail", 'checkAccess' => caGetUserAccessValues($this->request))));
	foreach($va_set_items as $va_set_item){
		$vs_exhibition_themes = $va_set_item["representation_tag"];
		break;
	}
	
	// get random memory
	$t_list = new ca_lists();
	$vn_set_type_memory = $t_list->getItemIDFromList('set_types', 'memory');
	
 	$va_access_values = caGetUserAccessValues($this->request);
	$vn_disp_set_id = $t_set->getRandomSetID(array("table" => "ca_objects", "checkAccess" => $va_access_values, "setType" => $vn_set_type_memory));
	$va_set_first_items = $t_set->getFirstItemsFromSets(array($vn_disp_set_id), array("version" => "thumbnail", "checkAccess" => $va_access_values));
	
	$va_random_memory = array_pop($va_set_first_items[$vn_disp_set_id]);
?>
			<div class="quickLinkItem">
				<div class="title"><?php print _t("Exhibition Themes"); ?></div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $vs_exhibition_themes, '', '', 'Favorites', 'Index'); ?></td></tr></table>
			</div>
			<div class="quickLinkItem">
				<div class="title"><?php print ($this->getVar("user_favorites_is_random")) ? _t("Random selection") : _t("User favorites"); ?></div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, (($this->getVar("user_favorites_is_random")) ? $this->getVar("random_object_thumb") : $this->getVar("user_favorites_thumb")), '', 'Detail', 'Object', 'Index', array('object_id' => (($this->getVar("user_favorites_is_random")) ? $this->getVar('random_object_id') : $this->getVar('user_favorites_id')))); ?></td></tr></table>
			</div>
			<div class="quickLinkItem">
				<div class="title"><?php print _t("Memories"); ?></div>
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $va_random_memory['representation_tag'], '', 'Detail', 'Object', 'Index', array('set_id' => $va_random_memory['set_id'], 'object_id' => $va_random_memory['object_id'])); ?></td></tr></table>
			</div>
			

		</div><!-- end quickLinkItems -->
			
		<div class="hpRss"><?php print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath(true).'/graphics/feed.gif" border="0" alt="'._t('Get alerted to newly added items by RSS').'" width="14" height="14"/> '._t('Get alerted to newly added items by RSS'), 'caption', '', 'Feed', 'recentlyAdded'); ?></div>