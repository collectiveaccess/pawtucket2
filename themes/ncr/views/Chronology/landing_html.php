<?php
	JavascriptLoadManager::register("cycle");
	$va_jumpToList = $this->getVar("jumpToList");
?>
<div id="pageHeading"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/t_chronology.gif' width='141' height='23' border='0'></div><!-- end pageHeading -->
<div id="landing">
	<div id="landingImageContainer">
		<div id="slideShow">
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/landing/LP-11.jpg" width="300" height="375" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/landing/LP-8.jpg" width="300" height="375" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/landing/LP-6.jpg" width="300" height="375" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/landing/LP-3.jpg" width="300" height="375" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/landing/LP-7.jpg" width="300" height="375" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/landing/LP-4.jpg" width="300" height="375" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/landing/LP-2.jpg" width="300" height="375" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/landing/LP-1.jpg" width="300" height="375" border="0"></div>
		</div>
	</div><!-- end landingImageContainer -->
	<div id="landingText">
		The chronology presents seminal events in the life of Isamu Noguchi organized by year, and may be used as a tool to navigate <i>The Isamu Noguchi Catalogue Raisonné</i>, as each year includes links to artwork, exhibition, and bibliography entries. 
		<br/><br/>While research for <i>The Isamu Noguchi Catalogue Raisonné</i> is ongoing the chronology will continue to develop. New additions and changes will be made on an annual basis until research is complete. <?php print caNavLink($this->request, _t("Learn more &rsaquo;"), "", "", "About", "Intro"); ?></i>
		<div id="browseAll"><?php print caNavLink($this->request, _t("Browse Complete Chronology  &rsaquo;"), 'browseSelectPanelLink', 'Chronology', 'Detail', '', array('year' => 1904)); ?></div><!-- end browse all -->
	</div>
	<div id="bottomBox">
		<div id="search">
			<div id="title"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/t_search_chronology.gif' width='186' height='20' border='0'></div><!-- end title -->
			<form name="chronology_Search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
					<input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" autocomplete="off"/> <a href="#" name="searchButtonSubmit" onclick="document.forms.chronology_Search.submit(); return false;"><div class="form-submit"></div></a>
					<input type="hidden" name="target"  value="ca_occurrences" />
			</form></div><!-- end search -->

		<div id="browse">
			<div id="title"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/t_browse_chronology.gif' width='191' height='20' border='0'></div><!-- end title -->
			<div class="link"><a href='#' onclick='yearsListPanel.showPanel("<?php print caNavUrl($this->request, '', 'Chronology', 'YearsList'); ?>"); return false;' ><?php print _t("year"); ?></a></div>
			<div class="link"><a href='#' onclick='yearsListPanel.showPanel("<?php print caNavUrl($this->request, '', 'Chronology', 'PeriodsList'); ?>"); return false;' ><?php print _t("period"); ?></a></div>
		<div style="clear:left; height:1px;">&nbsp;</div></div><!-- end browse -->
		<div style="clear:left; height:10px;">&nbsp;</div>		
	</div><!-- end bottomBox -->
</div><!-- end landing -->
<script type="text/javascript">
$(document).ready(function() {
    $('#slideShow').cycle({
		fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
		speed:  1000,
		timeout: 4000
	});
});
</script>

	<div id="yearsListPanel" class="browseSelectPanel"> 
		<a href="#" onclick="yearsListPanel.hidePanel(); return false;" class="browseSelectPanelButton"></a>
		<div id="yearsListPanelContentArea">
			
		</div>
	</div>
	<script type="text/javascript">
	/*
		Set up the "yearsListPanel" panel that will be triggered by links on chronology landing page above
	*/
	var yearsListPanel;
	jQuery(document).ready(function() {
		if (caUI.initPanel) {
			yearsListPanel = caUI.initPanel({ 
				panelID: 'yearsListPanel',										/* DOM ID of the <div> enclosing the panel */
				panelContentID: 'yearsListPanelContentArea',		/* DOM ID of the content area <div> in the panel */
				exposeBackgroundColor: '#000000',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
				exposeBackgroundOpacity: 0.5,							/* opacity of background color masking out page content; 1.0 is opaque */
				panelTransitionSpeed: 200, 									/* time it takes the panel to fade in/out in milliseconds */
				allowMobileSafariZooming: true,
				mobileSafariViewportTagID: '_msafari_viewport'
			});
		}
	});
	</script>
