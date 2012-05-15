<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
	<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton"></a>
	<div id="splashBrowsePanelContent">
	
	</div>
</div>
<script type="text/javascript">
	var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, 'clir2', 'NYWFOccurrencesBrowse', 'getFacet'); ?>'});
</script>
<div id="landingRightCol">
	<div class="boxHeadingExplore"><?php print _t("Explore 1938-1940 Films"); ?></div><!--end boxHeadingExplore -->
	<div class="browseOptions">
		<div>
			<b>Explore amateur filmmaking of the 1938-1940 period through these newly-described collections from Northeast Historic Film</b>
		</div>
		<div style="text-align:center;">
			<img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/clir2/explore_38-40.jpg" width="190" height="173" border="0">
		</div>
		<H3>Browse for</H3>
		<ul>
			<li><?php print caNavLink($this->request, _t("1938-1940 film reels"), "", "clir2", "PFOccurrencesBrowse", "clearCriteria"); ?></li>
			<li><?php print caNavLink($this->request, _t("collections containing<br/>1938-1940 film reels"), "", "clir2", "PFCollectionsBrowse", "clearCriteria"); ?></li>
		</ul>
		<div style="height:65px;">&nbsp;</div>
	</div><!-- browseOptions -->
</div><!-- end landingRightCol -->
<div id="landingLeftCol">
	<div class="boxHeadingExplore">
	Explore 1939-1940 New York World's Fair Films
	</div><!-- end boxHeadingExplore -->
	<div class="browseOptions">
		<div>
			<?php print caNavLink($this->request, _t("Click here to browse NYWF amateur films by subjects, people and organizations, NYWF features, and contributing institutions."), "", "clir2", "NYWFOccurrencesBrowse", "clearCriteria"); ?>
		</div>
	</div>
	<div id="fairMap">
	<?php print "<img src='".$this->request->getThemeUrlPath()."/graphics/clir2/NYWF_map.jpg' border='0' width='645' height='358' usemap='#fairMap'>"; ?>
		<div id="mapInfo"><div id="mapZone"><?php print _t("Use the map to browse NYWF<br/>amateur films by fairground location"); ?></div><!-- end mapZone --></div><!-- end mapInfo -->
	</div><!-- end fairMap -->
	<div class="caption"><a href="<?php print $this->request->getThemeUrlPath(); ?>/graphics/clir2/MM_CameraChart.pdf" class="mapCaption"><?php print _t("Map credit: Amateur Cinema League. (1939). A camera chart for the fair. <i>Movie Makers, 14</i>(6), 274-275, 326-327."); ?></a></div><!-- end caption -->
</div><!-- end landingLeftCol -->

<map name="fairMap" id="fairMap">
  <area shape="poly" coords="128,125,163,122,191,124,222,128,243,135,258,143,277,135,300,135,310,116,243,66,239,39,174,6,152,43,90,46,68,56,57,76,82,84,91,66,117,63,116,75,123,80,127,125"  onclick="caUIBrowsePanel.showBrowsePanel('place_facet', '', 6)" id="government2" title="Government Zone" />
  <area shape="poly" coords="303,257,336,293,391,320,466,332,578,322,640,305,640,171,544,171,438,144,373,139,323,117,304,147,301,207" onclick="caUIBrowsePanel.showBrowsePanel('place_facet', '', 12)" id="amusement" title="Amusement Zone" />
  <area shape="poly" coords="296,144,292,187,292,219,292,244,261,266,230,272,180,267,186,239,175,233,178,214,168,204,167,181,175,176,196,186,211,191,221,190,229,202,245,191,262,191,277,162,286,142" onclick="caUIBrowsePanel.showBrowsePanel('place_facet', '', 10)" id="production" title="Production and Distribution Zone" />
  <area shape="poly" coords="167,266,165,244,143,244,123,243,116,266,166,266"  onclick="caUIBrowsePanel.showBrowsePanel('place_facet', '', 6)" id="government" title="Government Zone"  />
  <area shape="poly" coords="4,266,100,266,117,238,125,236,131,209,106,191,73,207,61,198,55,211,27,206" onclick="caUIBrowsePanel.showBrowsePanel('place_facet', '', 9)" id="communication" title="Communication And Business Zone" />
  <area shape="poly" coords="3,284,2,341,229,355,258,334,243,296,186,282,36,281" onclick="caUIBrowsePanel.showBrowsePanel('place_facet', '', 11)" id="transportation" title="Transportation Zone" />
  <area shape="poly" coords="38,196,49,159,44,143,87,85,92,71,111,68,113,76,119,81,119,115,120,129,127,134,139,133,145,144,138,157,152,163,145,176,153,184,149,202,139,205,105,179,75,198,51,192"  onclick="caUIBrowsePanel.showBrowsePanel('place_facet', '', 7)" id="community" title="Community Interests Zone" />
  <area shape="poly" coords="147,132,154,127,206,131,234,139,255,147,266,144,277,144,270,157,264,167,255,186,230,194,214,181,207,183,164,168,152,154" id="food" title="Food Zone" onclick="caUIBrowsePanel.showBrowsePanel('place_facet', '', 8)" />
  <area shape="poly" coords="145,240,164,234,169,218,162,209,162,181,166,175,155,174,156,182,152,207,139,211,133,226,133,236" onclick="caUIBrowsePanel.showBrowsePanel('place_facet', '', 4)" id="themeCenter" title="Theme Center" />
</map>
<?php
	TooltipManager::add(
		"#themeCenter", "Theme Center"
	);
	TooltipManager::add(
		"#government2", "Government Zone"
	);
	TooltipManager::add(
		"#government", "Government Zone"
	);
	TooltipManager::add(
		"#amusement", "Amusement Zone"
	);
	TooltipManager::add(
		"#production", "Production and Distribution Zone"
	);
	TooltipManager::add(
		"#communication", "Communication And Business Zone"
	);
	TooltipManager::add(
		"#transportation", "Transportation Zone"
	);
	TooltipManager::add(
		"#community", "Community Interests Zone"
	);
	TooltipManager::add(
		"#food", "Food Zone"
	);
	TooltipManager::add(
		"#themeCenter", "Theme Center"
	);
?>