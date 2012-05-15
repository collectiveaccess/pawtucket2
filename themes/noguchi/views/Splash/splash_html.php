<?php
	$vs_tag = "";
	if($vn_featured_content_id = $this->getVar("featured_content_id")){
		if($this->request->config->get("dont_enforce_access_settings")){
			$va_access_values = array();
		}else{
			$va_access_values = caGetUserAccessValues($this->request);
		}
		$t_object = new ca_objects($vn_featured_content_id);
		$va_rep = $t_object->getPrimaryRepresentation(array('large'), null, array('return_with_access' => $va_access_values));
		$vs_tag = $va_rep["tags"]["large"];
	}
	
?>
		<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
			<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton"></a>
			<div id="splashBrowsePanelContent">
			
			</div>
		</div>
		<script type="text/javascript">
			var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});
		</script>
		
		<div id="hpText">
			
			<div id="hpBrowse">
				<div style="color:#888"><b><?php print _t("QUICKLY BROWSE BY"); ?></b></div>
				<div style="margin-top:5px;">
<?php
					$va_facets = $this->getVar('available_facets');
					foreach($va_facets as $vs_facet_name => $va_facet_info) {
?>
						<a href="#" onclick='caUIBrowsePanel.showBrowsePanel("<?php print $vs_facet_name; ?>")'><?php print $va_facet_info['label_plural']; ?></a><br/>
<?php
					}
?>
				</div>
				

			</div><!-- end hpBrowse-->
			
		</div>
		<div id="hpFeatured">
			
				<table cellpadding="0" cellspacing="0"><tr><td valign="middle" align="center"><?php print caNavLink($this->request, $vs_tag, '', 'Detail', 'Object', 'Show', array('object_id' =>  $this->getVar("featured_content_id"))); ?></td></tr></table>
			<div class="title"><?php print _t("Highlights from the Archives"); ?></div>
		</div>
		

			
