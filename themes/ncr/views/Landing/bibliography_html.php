<?php
	JavascriptLoadManager::register("cycle");
	
	$t_list = new ca_lists();
	$vn_type_id = $t_list->getItemIDFromList('occurrence_types', 'bibliography');
?>
<div id="pageHeading"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/t_bibliography.gif' width='146' height='23' border='0'></div><!-- end pageHeading -->
<?php
	$o_result_context = new ResultContext($this->request, 'ca_occurrences', 'bibliographySearch');
	$vs_search = $o_result_context->getSearchExpression();
?>
		<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
			<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton"></a>
			<div id="splashBrowsePanelContent">
			
			</div>
		</div>
		<script type="text/javascript">
			var caUIBrowsePanel = caUI.initBrowsePanel({ 
				facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet', array('target' => 'ca_occurrences', 'type_id' => $vn_type_id, 'target' => 'ca_occurrences')); ?>',
				addCriteriaUrl: '<?php print caNavUrl($this->request, $this->request->getModulePath(), 'Browse', 'modifyCriteria', array('type_id' => $vn_type_id, 'target' => 'ca_occurrences')); ?>',
				singleFacetValues: <?php print json_encode($this->getVar('single_facet_values')); ?>
			});
		</script>
<div id="landing">
	<div id="landingImageContainer">
		<div id="slideShow">
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/landing/LP-10.jpg" width="300" height="375" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/landing/03776.jpg" width="300" height="375" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/landing/03625.jpg" width="300" height="375" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/landing/03314.jpg" width="300" height="375" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/landing/03716.jpg" width="300" height="375" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/landing/06477.jpg" width="300" height="375" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/landing/03923.jpg" width="300" height="375" border="0"></div>
			<div><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/landing/03270.jpg" width="300" height="375" border="0"></div>
			
		</div>
	</div><!-- end landingImageContainer -->
	<div id="landingText">
		The bibliography is comprised of writings by and about Isamu Noguchi including books, essays, articles, exhibition catalogues, monographs, and other literature. For information on the configuration of bibliography entries see the <?php print caNavLink($this->request, _t("Guide to Entries"), "", "", "About", "Guide"); ?>. 
		<br/><br/>While research for <i>The Isamu Noguchi Catalogue Raisonné</i> is ongoing the current bibliography includes both published and research-pending entries. New additions and changes will be made on an annual basis until research is complete. <?php print caNavLink($this->request, _t("Learn more &rsaquo;"), "", "", "About", "Intro"); ?>
	</div>
	<div id="browseAll"><?php print caNavLink($this->request, _t("Browse the Bibliography &rsaquo;"), "", "", "Search", "Index",  array("search" => "*", "target" => "ca_occurrences")); ?></div><!-- end browse all -->
	<div id="bottomBox">
		<div id="search">
			<div id="title"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/t_search_bibliography.gif' width='191' height='20' border='0'></div><!-- end title -->
			<form name="bibliography_Search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
				<input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" autocomplete="off"/> <a href="#" name="searchButtonSubmit" onclick="document.forms.bibliography_Search.submit(); return false;"><div class="form-submit"></div></a>
				<input type="hidden" name="target"  value="ca_occurrences" />
		</form></div><!-- end search -->
		<div id="browse">
			<div id="title"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/ncr/t_browse_bibliography.gif' width='196' height='20' border='0'></div><!-- end title -->
<?php
			$va_facets = $this->getVar('available_facets');
			foreach($va_facets as $vs_facet_name => $va_facet_info) {
?>
				<div class="link"><a href="#" onclick='caUIBrowsePanel.showBrowsePanel("<?php print $vs_facet_name; ?>")'><?php print $va_facet_info['label_plural']; ?></a></div>
<?php
			}
?>		
		</div><!-- end browse -->
		<div style="clear:left;">&nbsp;</div>
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