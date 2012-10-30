<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<?php print MetaTagManager::getHTML(); ?>
	
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/bookmarks.css" rel="stylesheet" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/videojs/video-js.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-autocomplete/jquery.autocomplete.css" type="text/css" media="screen" />
 	<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="<?php print $this->request->getThemeUrlPath(true); ?>/css/iestyles.css" />
	<![endif]-->

	<!--[if (!IE)|(gte IE 8)]><!-->
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/js/DV/viewer-datauri.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/js/DV/plain-datauri.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/js/DV/plain.css" media="screen" rel="stylesheet" type="text/css" />
	<!--<![endif]-->
	<!--[if lte IE 7]>
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/viewer.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/plain.css" media="screen" rel="stylesheet" type="text/css" />
	<![endif]-->
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-tileviewer/jquery.tileviewer.css" type="text/css" media="screen" />
<?php
	print JavascriptLoadManager::getLoadHTML($this->request->getBaseUrlPath());
?>
	<script type="text/javascript">
		 jQuery(document).ready(function() {
			jQuery('#quickSearch').searchlight('<?php print $this->request->getBaseUrlPath(); ?>/index.php/Search/lookup', {showIcons: false, searchDelay: 100, minimumCharacters: 3, limitPerCategory: 3});
		});
		// initialize CA Utils
			caUI.initUtils();
	</script>
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/eastend.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>
<div id="container">
	<div id="topnav">
		<div class="leftnav"><a href="http://www.parrishart.org" />Back to Parrish Art Museum Site</a></div>
			<div class="rightnav">
				<div class="social"><a href="http://www.facebook.com/pages/Parrish-Art-Museum/33655647667?ref=ts"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/eastend/fbookicon.gif" title="facebook" width="21" height="20" alt="facebook" /></a><a href="http://twitter.com/parrishart"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/eastend/twittericon.gif" title="twitter" width="21" height="20" alt="twitter" /></a><a href="http://vimeo.com/parrishartmuseum"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/eastend/vimeoicon.gif" title="vimeo" width="21" height="20" alt="vimeo" /></a><a href="http://www.flickr.com/photos/parrishart/sets/"><img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/eastend/flickricon.gif" title="flickr" width="21" height="20" alt="flickr" /></a></div>
				<form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
					<input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" />
				</form>
			</div>
	</div><!--end topnav-->

	<div id="header">
		<div id="logo"><?php print caNavLink($this->request, _t("Parrish East End Stories"), "", "", "", ""); ?></div>
		<div id="mainnav">
		<ul>
			<li><?php print caNavLink($this->request, _t("Chronology"), "", "eastend", "Chronology", "Index"); ?></li>
			<li><?php print caNavLink($this->request, _t("Artists"), "", "eastend", "ArtistBrowser", "Index"); ?></li>
			<!--<li><a href="#">Map</a></li>-->
<?php
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				if($this->request->isLoggedIn()){
					print "<li>".caNavLink($this->request, _t("Lightbox"), "", "", "Sets", "Index")."</li>";
					print "<li>".caNavLink($this->request, _t("Logout"), "", "", "LoginReg", "Logout")."</li>";
				}else{
					print "<li>".caNavLink($this->request, _t("Login"), "", "", "LoginReg", "form")."</li>";
				}
			}
?>
		</ul>
	</div><!--end header-->

<div id="maincontent">