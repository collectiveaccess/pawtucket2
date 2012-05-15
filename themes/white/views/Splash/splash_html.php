		<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
			<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton"></a>
			<div id="splashBrowsePanelContent">
			
			</div>
		</div>
		<script type="text/javascript">
			var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});
		</script>
		
		<div id="hpText">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum et lorem nunc. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec vulputate purus id velit fringilla non rutrum elit aliquet. Nullam lorem nunc, gravida nec rutrum eget, porttitor eget odio. Nullam mi sapien, convallis sed lobortis non, egestas vel ligula. Donec sollicitudin facilisis augue, quis ullamcorper urna pharetra ac. Suspendisse purus mi, vestibulum vel tempus eget, euismod sit amet nulla. Nam enim enim, mattis non accumsan sit amet,
		</div>
		<div id="hpFeatured">
			<div class="title"><?php print _t("Featured Item"); ?>:</div>
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("featured_content_medium"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("featured_content_id"))); ?></td></tr></table>
		</div>
		
		<!-- end hpBrowse-->
		</div><!-- end hpContent -->
			
		