<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<?php print MetaTagManager::getHTML(); ?>
	
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/MyFontsWebfontsKit.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/novamuse.css" rel="stylesheet" type="text/css" />
	<script src="<?php print $this->request->getThemeUrlPath(true); ?>/css/view.js" type="text/javascript"></script>
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/bookmarks.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/videojs/video-js.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-jplayer/jplayer.blue.monday.css" type="text/css" media="screen" />
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
	# --- since the catalogin plugin on the default page is loaded with Ajax, I check to see if we need to load it's stylesheet here
	if(($this->request->isLoggedIn()) && ($this->request->hasRole("admin")) && ($this->request->getController() == "Object")){
?>
		<link href="<?php print $this->request->getBaseUrlPath(); ?>/app/plugins/Cataloging/themes/default/css/cataloging.css" rel="stylesheet" type="text/css" />
<?php
	}
	print JavascriptLoadManager::getLoadHTML($this->request->getBaseUrlPath());
?>
	<script type="text/javascript">
		 jQuery(document).ready(function() {
			jQuery('#quickSearch').searchlight('<?php print $this->request->getBaseUrlPath(); ?>/index.php/Search/lookup', {showIcons: false, searchDelay: 100, minimumCharacters: 3, limitPerCategory: 3});
		});
		// initialize CA Utils
			caUI.initUtils();
	</script>
</head>
<body>
<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();
?>
<div id="pageArea"><div id="container">

	<div id="header">
	
		<div id="logo"><?php print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/novamuse/novamuse.png' width='233' height='130' alt='Nova Muse' />", "", "", "", ""); ?></div>
		
		<div id="mainmenu">
			<div class="navButtonFirst<?php print ($this->request->getController() == 'Splash') ? "Highlight" : ""; ?>"><?php print caNavLink($this->request, _t("Home"), "", "", "", ""); ?></div>
			<div class="navButton<?php print ($this->request->getController() == 'About') ? "Highlight" : ""; ?>"><?php print caNavLink($this->request, _t("About"), "", "", "About", "Index"); ?></div>
			<div class="navButton<?php print ($this->request->getController() == 'MemberMap') ? "Highlight" : ""; ?>"><?php print caNavLink($this->request, _t("Contributor Map"), "", "NovaMuse", "MemberMap", "Index"); ?></div>
			<div class="navButton<?php print ($this->request->getController() == 'Browse') ? "Highlight" : ""; ?>"><?php print caNavLink($this->request, _t("Browse"), "", "", "Browse", "clearCriteria"); ?></div>
			<div class="navButton<?php print (($this->request->getController() == 'Sets') || ($this->request->getController() == 'LoginReg')) ? "Highlight" : ""; ?>">
<?php
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("Your Lightbox"), "", "", "Sets", "Index");
				}else{
					print caNavLink($this->request, _t("Login/Register"), "", "", "LoginReg", "form");
				}
?>
			</div>
			<div class="navButton-search"><form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get"><input name="search" type="text" value="<?php print ($vs_search) ? $vs_search : _t("Search"); ?>" size="18" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" /></form></div>
		</div><!--end main menu-->
	</div><!--end header-->
	<div class="clear"></div>