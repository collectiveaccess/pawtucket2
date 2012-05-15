		<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
			<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton"></a>
			<div id="splashBrowsePanelContent">
			
			</div>
		</div>
		<script type="text/javascript">
			var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});
		</script>
		
		<div id="hpText">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum et lorem nunc. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec vulputate purus id velit fringilla non rutrum elit aliquet. Nullam lorem nunc, gravida nec rutrum eget, porttitor eget odio. Nullam mi sapien, convallis sed lobortis non, egestas vel ligula. Donec sollicitudin facilisis augue, quis ullamcorper urna pharetra ac. Suspendisse purus mi, vestibulum vel tempus eget, euismod sit amet nulla. Nam enim enim, mattis non accumsan sit amet, consequat ornare orci. Praesent ipsum justo, suscipit quis dapibus non, eleifend ac ipsum. Curabitur et quam nunc. Cras et enim sit amet justo auctor convallis.
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
			</div><!-- end hpText -->
			<div style="margin-top:10px;" class="caption">
				<?php print _t("Or click \"Browse\" in the navigation bar to do a refined browse"); ?>
			</div>
		</div><!-- end hpBrowse-->
		<div id="hpFeatured">
			<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $this->getVar("featured_content_mediumlarge"), '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("featured_content_id"))); ?></td></tr></table>
		</div>