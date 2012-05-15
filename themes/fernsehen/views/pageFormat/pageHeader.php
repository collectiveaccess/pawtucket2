<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<?php print MetaTagManager::getHTML(); ?>
	
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/videojs/video-js.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-jplayer/jplayer.blue.monday.css" type="text/css" media="screen" />
	<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="<?php print $this->request->getThemeUrlPath(true); ?>/css/iestyles.css" />
	<![endif]-->
<?php
	print JavascriptLoadManager::getLoadHTML($this->request->getBaseUrlPath());
?>
	<script type="text/javascript">
		 jQuery(document).ready(function() {
			jQuery('#quickSearch').searchlight('<?php print $this->request->getBaseUrlPath(); ?>/index.php/Search/lookup', {showIcons: false, searchDelay: 100, minimumCharacters: 3, limitPerCategory: 3});
		});
	</script>
</head>
<body>
		<div id="pageArea"><div id="pageAreaPadding">
			<div id="header">
<?php
				print "<img src='".$this->request->getThemeUrlPath()."/graphics/fernsehen/sdk_logo.png' width='91' height='128' border='0' id='logo'>";
				print "<div id='title'>".caNavLink($this->request, "Programmgalerie Fernsehen", "title", "", "", "")."</div>";
?>				
			</div><!-- end header -->
<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();

	if ($this->request->getController() != 'Browse') {
?>
<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
	<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton"></a>
	<div id="splashBrowsePanelContent">
	
	</div>
</div>
<script type="text/javascript">
	var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});
</script>
<?php
	}
?>
			<div id="leftBar">
				<div id="searchBox">
					<div class="boxHeading"><?php print "Suche"; ?></div><!-- end browseHeading -->
					<div id="searchForm"><form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get"><input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" size="100"/> <a href="#" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;">&rsaquo;</a></form></div><!-- end searchForm -->
				</div><!-- end browse Box -->
<?php
				require_once(__CA_LIB_DIR__."/ca/Browse/ObjectBrowse.php");
				
				#$o_browse_context = new ResultContext($this->request, 'ca_objects', 'basic_browse');
				#$o_browse = new ObjectBrowse($o_browse_context->getSearchExpression(true), 'pawtucket2');
				$o_browse = new ObjectBrowse(null, 'pawtucket2');
				$o_browse->execute();
				$va_facets = $o_browse->getInfoForAvailableFacets();
				
				foreach($va_facets as $vs_facet_name => $va_facet_info) {
					if ($vs_facet_name == 'title_facet') { continue; }
?>
					<div class="browseBox">
						<div class="boxHeading"><?php print "Suche nach"; ?></div><!-- end browseHeading -->
						<div class="browseLink"><?php print ($this->request->getController() != 'Browse') ? "<a href=\"#\" onclick='caUIBrowsePanel.showBrowsePanel(\"".$vs_facet_name."\", null, null, null, 1)'>".$va_facet_info['label_plural']."</a>" : $va_facet_info['label_plural']; ?></div><!-- end browseLink -->
					</div><!-- end browse Box -->
<?php					
				}
?>
			</div><!-- end leftBar -->
			<div id="rightBar">
				<div class="browseBox">
					<div class="boxHeading">
						<?php print caNavLink($this->request, "Kunst &amp; Kultur", '', '', 'Search', 'Index', array('search' => "ca_list_items:Kultur")); ?>
					</div><!-- end browseHeading -->
					<div>
						<?php print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/fernsehen/kunst-und-kultur.jpg' width='255' height='112' border='0' id='logo'>", '', '', 'Search', 'Index', array('search' => "ca_list_items:Kultur")); ?>
					</div>
				</div><!-- end browse Box -->
				<div class="browseBox">
					<div class="boxHeading">
						<?php print caNavLink($this->request, "Zeitgeschehen", '', '', 'Search', 'Index', array('search' => 'ca_list_items:Politik')); ?>
					</div><!-- end browseHeading -->
					<div>
						<?php print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/fernsehen/politik_und_zeitgeschehen.jpg' width='255' height='112' border='0' id='logo'>", '', '', 'Search', 'Index', array('search' => 'ca_list_items:Politik')); ?>
					</div>
				</div><!-- end browse Box -->
				<div class="browseBox">
					<div class="boxHeading">
						<?php print caNavLink($this->request, "Tatort Fernsehen", '', '', 'Search', 'Index', array('search' => '"Polizeiruf" OR "Tatort"')); ?>
					</div><!-- end browseHeading -->
					<div>
						<?php print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/fernsehen/programmgalerie-krimi.jpg' width='255' height='112' border='0' id='logo'>", '', '', 'Search', 'Index', array('search' => '"Polizeiruf" OR "Tatort"')); ?>
					</div>
				</div><!-- end browse Box -->
<?php

				$vs_fernsehgroessen_query = '"Georg Stefan Troller" OR "Vicco von Bülow"';

?>
				<div class="browseBox">
					<div class="boxHeading">
						<?php print caNavLink($this->request, "Fernsehgr&ouml;ssen", '', '', 'Search', 'Index', array('search' => $vs_fernsehgroessen_query)); ?>
					</div>
					<div>
						<?php print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/fernsehen/fernsehgroessen.jpg' width='255' height='112' border='0' id='logo'>", '', '', 'Search', 'Index', array('search' => $vs_fernsehgroessen_query)); ?>
					</div>
				</div><!-- end browse Box -->
				<div class="browseBox">
					<div class="boxHeading"><a href="#"><?php print "<a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"title_facet\", null, null, null, 1)'>"."Titel Von A-Z"; ?></a></div><!-- end browseHeading -->
				</div><!-- end browse Box -->
			</div><!-- end rightBar -->
			<div id="contentArea">
