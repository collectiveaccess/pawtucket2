<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<?php print MetaTagManager::getHTML(); ?>
	
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/bookmarks.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/cfa.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/videojs/video-js.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-jplayer/jplayer.blue.monday.css" type="text/css" media="screen" />
   	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/ia/BookReader.css" type="text/css" media="screen"/>
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
<div id="container">

<div id="chi_header">

<div id="chi_logo"><a href="http://www.chicagofilmarchives.org/" title="Chicago Film Archives" rel="home"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/cfa/chi_film_archives.png" width="230" height="70" border="0" alt="Chicago Film Archives" /></a></div>
<div id="top_nav">

<div class="top1"><ul><li><a href="http://www.chicagofilmarchives.org/">Home</a></li>
<li><a href="http://www.chicagofilmarchives.org/about-2">About CFA</a></li>
<li><a href="http://www.chicagofilmarchives.org/category/news">News</a></li>
</ul></div>
<div class="top2"><ul><li><a href="http://chicagofilmarchives.org/2011?cat=19">Calendar &#038; Events</a></li>
<li><a href="http://www.chicagofilmarchives.org/services">Services</a></li>
<li><a href="http://www.chicagofilmarchives.org/donate">Support/Donate</a></li>

</ul></div>
<div id="searchwrapper"><form id="searchform" class="blog-search" method="get" action="http://www.chicagofilmarchives.org">
<input type="text" id="s" name="s" class="searchbox" value="" />
<input type="image" src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/cfa/invis_button.png" class="searchbox_submit" value="Find" />
</form>
</div>
</div><!--end top_nav-->

</div><!--end chi_header-->

<div class="clearline"></div>

<div id="sidenav">

<div class="menu-main-side-nav-container"><ul id="menu-main-side-nav" class="menu"><li id="menu-item-264" class="current_page_item"><?php print caNavLink($this->request, _t("Explore Collections"), "", "", "", ""); ?></li>
<li><a href="http://www.chicagofilmarchives.org/pres-projects">Preservation Projects</a></li>
<li><a href="http://www.chicagofilmarchives.org/midwest-stories">Midwest Stories</a></li>
<li><a href="http://www.chicagofilmarchives.org/home-movies">Home Movies</a></li>
<!--<li><a href="<?php print $this->request->config->get("cfa_stock_url"); ?>">Stock Footage Library</a></li>-->
<li><a href="http://www.chicagofilmarchives.org/stock-footage-library">Stock Footage Library</a></li>

</ul></div>

<div class="adunit_left"><a href="http://www.chicagofilmarchives.org/donate" title="Chicago Film Archives" rel="home"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/cfa/donate2.png" border="0" alt="dontate now"  /></a>
</div><!--end adunit_left -->

<div id="side_bottom_nav">
<p class="morespace">
<a href="http://www.chicagofilmarchives.org/contact">Contact</a><br />
<a href="http://eepurl.com/e-eZA">Join Email List</a><br />

</p>
<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td style="padding-bottom:4px;"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/cfa/facebook_icon.gif" border="0"  alt="Facebook" /></td><td>&nbsp;&nbsp;<a href="http://www.facebook.com/pages/Chicago-Film-Archives/77924363258">Become a Fan on Facebook</a></td></tr>
<tr><td><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/cfa/twitter_icon.gif" border="0"  alt="twitter" /></td><td>&nbsp;&nbsp;<a href="http://twitter.com/#!/ChiFilmArchives">Follow Us on Twitter</a></td></tr>
</table>


<p class="smaller morespace">329 West 18th Street Suite 3A<br />
Chicago, Illinois 60616<br />
(312) 243-1808<br />
info@chicagofilmarchives.org</p>



</div>

</div> <!--end sidenav-->





<?php
	# --- get the list collection_genres and loop through it to make side nav options
	$t_list = new ca_lists();
 	$va_collection_genres = caExtractValuesByUserLocale($t_list->getItemsForList('collection_genres'));

	# --- get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();
?>


<div id="leftnav_coll">	
  <ul class="rightheaders">
  	<li class="page_item <?php print (($this->request->getController() == "CollectionsList") && (!$this->request->getParameter("collection_genre_id", pInteger))) ? "current_page_item" : ""; ?>"><?php print caNavLink($this->request, _t("All Collections"), "", "cfa", "collectionsList", "Index"); ?></li>
<?php
	foreach($va_collection_genres as $vn_genre_id => $va_genre_info){
		print '<li class="page_item '.((($this->request->getController() == "CollectionsList") && ($this->request->getParameter("collection_genre_id", pInteger) == $vn_genre_id)) ? "current_page_item" : "").'">'.caNavLink($this->request, $va_genre_info["name_plural"], "", "cfa", "collectionsList", "Index", array("collection_genre_id" => $vn_genre_id)).'</li>';
	}
	$vs_facet_group = $this->request->getParameter('group', pString);
?>
	<li class="page_item <?php print ($vs_facet_group == "collection") ? "current_page_item" : ""; ?>"><?php print caNavLink($this->request, _t("Browse Finding Aids"), "", "", "Browse", "clearCriteria", array('group' => 'collection')); ?></li>
	<li class="page_item <?php print ($vs_facet_group == "item") ? "current_page_item" : ""; ?>"><?php print caNavLink($this->request, _t("Browse Items"), "", "", "Browse", "clearCriteria", array('group' => 'item')); ?></li>
	<li class="page_item <?php print ($vs_facet_group == "type") ? "current_page_item" : ""; ?>"><?php print caNavLink($this->request, _t("Record Types"), "", "", "Browse", "clearCriteria", array('group' => 'type')); ?></li>

  </ul>
    <?php print "<div id='collectionSearchHeading'>"._t("Search Collections")."</div>"; ?>
    <div id="searchwrapperCollectionSearch"><form id="collectionSearchform" class="blog-search" method="get" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>">
		<input type="text" id="s" name="search" class="searchbox" value="<?php print $vs_search ?>" autocomplete="off" />
		<input type="image" src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/cfa/invis_button.png" class="searchbox_submit" value="Find" />
		</form>
	</div><!-- end searchwrapperCollectionSearch -->
	<div id="collectionSearchHelpLink"><a href="http://www.chicagofilmarchives.org/search-instructions"><?php print _t("search instructions"); ?></a></div>
		
  
</div> <!--end leftnav_coll-->

	<div id="main_content_preservation">
