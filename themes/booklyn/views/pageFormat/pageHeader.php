<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<?php print MetaTagManager::getHTML(); ?>
	
 	
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/bookmarks.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/videojs/video-js.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-jplayer/jplayer.blue.monday.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-autocomplete/jquery.autocomplete.css" type="text/css" media="screen" />
 	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-tileviewer/jquery.tileviewer.css" type="text/css" media="screen" />
 	<link rel="stylesheet" href="http://booklyn.org/wp/wp-content/themes/baa-theme/css/fonts.css" type="text/css" media="screen" />
 	<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="<?php print $this->request->getThemeUrlPath(true); ?>/css/iestyles.css" />
	<![endif]-->

	<!--[if (!IE)|(gte IE 8)]><!-->
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/js/DV/viewer-datauri.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/js/DV/plain-datauri.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/js/DV/plain.css" media="screen" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="http://booklyn.org/wp/wp-content/themes/baa-theme/css/global.css" type="text/css" media="screen" />
	<!--<![endif]-->
	<!--[if lte IE 7]>
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/viewer.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/plain.css" media="screen" rel="stylesheet" type="text/css" />
	<![endif]-->
<?php
	print JavascriptLoadManager::getLoadHTML($this->request->getBaseUrlPath());
?>
	<script type="text/javascript">
		 jQuery(document).ready(function() {
			jQuery('#quickSearch').searchlight('<?php print $this->request->getBaseUrlPath(); ?>/index.php/Search/lookup', {showIcons: false, searchDelay: 100, minimumCharacters: 3, limitPerCategory: 3});
		});
	</script>
<?php
	//<script type="text/javascript">
	//	var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); '});
	//</script>
?>
</head>
<body>
		<div id='mainContainer'>
<?php
		#print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/logo-white.jpg' border='0'>", "logo", "", "", "");
?>		
		<a href='http://www.booklyn.org' class='logo'></a>		
		<div id='pageTitle'>Collection</div>
		<div id="content" class="collection">
		
			
<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();
?>
			<div id="sidebar">
				<div class='pageInfo'>
				<h1>Search Catalog</h1>
					<table id="searchTable">
						<tbody>
							<tr>
								<form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
								<td valign="center">
									<input type="text" name="search" class="textBox" value="<?php print ($vs_search) ? $vs_search : ''; ?>" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" size="100"/>
								</td>
								<td width="3" valign="center">&nbsp;</td>
								<td>
									<!--<a href="#" name="searchButtonSubmit" class="submitBox" onclick="document.forms.header_search.submit(); return false;">GO</a>-->
									<input type="submit" value="GO" class="submitBox">
								</td>
								</form>
							</tr>
						</tbody>
					</table>
				
<?php				
				#print join(" ", $this->getVar('nav')->getHTMLMenuBarAsLinkArray());
			
			print "<h1>".caNavLink($this->request, 'Browse Artists', '', 'Browse', 'Index', 'target/ca_entities')."</h1>";
			print "<h1>".caNavLink($this->request, 'Browse Artworks', '', 'Browse', 'Index', 'target/ca_objects')."</h1>";


	
#						$va_facets = $this->getVar('available_facets');
#						foreach($va_facets as $vs_facet_name => $va_facet_info) {
?>
<!--							<a href="#" style="white-space:nowrap;" onclick='caUIBrowsePanel.showBrowsePanel("<?php print $vs_facet_name; ?>")'><?php print ucwords($va_facet_info['label_plural']); ?></a>-->
<?php
#						}
?>
				<h1>
<?php
				print caNavLink($this->request, 'Advanced Search', '', 'AdvancedSearch', 'Index', '');
?>				
				</h1>
				
<?php
			if(!$this->request->isLoggedIn()){
				print "<h1>".caNavLink($this->request, 'Login/Register', '', 'LoginReg', 'form', '')."</h1>";
			} else {
				print "<h1>".caNavLink($this->request, 'My Collections', "", "", "Sets", "Index")."</h1>";
				print "<h1>".caNavLink($this->request, 'My Bookmarks', '', 'Bookmarks', 'index', '')."</h1>";
				print "<h1>".caNavLink($this->request, 'Logout', '', 'LoginReg', 'logout', '')."</h1>";
			}
?>				
													
				</div><!-- end pageInfo -->	

				
				<div class="nav">
				<ul> 
					<li><?php print caNavLink($this->request, 'Artists', '', 'About', 'Artists', '')?></li>
					<li><?php print caNavLink($this->request, 'Art + Books', '', '', '', '')?></li>
					<li><a href="http://booklyn.org/wp/education">Education</a></li>
					<li><a href="http://booklyn.org/wp/category/news">News</a></li>
					<li><a href="http://booklyn.org/wp/calendar">Calendar</a></li>
					<li><a href="http://booklyn.org/wp/about">About</a></li>
					<li><a href="http://booklyn.org/wp/donate">Donate</a></li>
				</ul> 
				</div>
			</div><!-- end sidebar -->
		<div id="main">