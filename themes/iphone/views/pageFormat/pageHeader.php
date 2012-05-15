<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<?php print MetaTagManager::getHTML(); ?>
	
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/iphone.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />	
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/videojs/video-js.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-jplayer/jplayer.blue.monday.css" type="text/css" media="screen" />


<?php
	print JavascriptLoadManager::getLoadHTML($this->request->getBaseUrlPath());
?>
	<meta name="viewport" id="_msafari_viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="apple-touch-icon" href="images/myiphone_ico.png"/>
	<script type="text/javascript">
		window.addEventListener('load', setOrientation, false);  
		window.addEventListener('orientationchange', setOrientation, false);
		function setOrientation() {  
			var orient = Math.abs(window.orientation) === 90 ? 'landscape' : 'portrait';  
			var cl = document.body.className;  
			cl = cl.replace(/portrait|landscape/, orient);  
 			document.body.className = cl; 
 			window.scrollTo(0, pageYOffset);
		}
	</script>
</head>
<body onload="setTimeout(function() { window.scrollTo(0, 1) }, 100);" class="portrait">
		<div id="pageWidth"><div id="pageArea">
<?php
		if ($this->request->getController() != "Splash"){
?>
			<div id="header">
<?php
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/".$this->request->config->get('header_img')."' border='0'>", "", "", "", "");
?>				
			</div><!-- end header -->
<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();
?>
			<div id="nav">
				<div id="search"><form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
						<a href="#" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/spacer.gif' border='0' width='17' height='16'></a><input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" autocomplete="off" size="100"/>
				</form></div>
				<a href="#" onclick='$("#navMenu").slideToggle(250); return false;'><?php print _t("Menu"); ?>&darr;</a>
			</div><!-- end nav -->
			<div id="navMenu">
<?php
				print "<div>".caNavLink($this->request, _t("Home"), "", "", "", "")."</div>";
				print "<div>".caNavLink($this->request, _t("Browse"), "", "", "Browse", "clearCriteria")."</div>";
				print "<div>".caNavLink($this->request, _t("Gallery"), "", "simpleGallery", "Show", "Index")."</div>";
				print "<div>".caNavLink($this->request, _t("About"), "", "", "About", "Index")."</div>";
				if (!$this->request->config->get('dont_allow_registration_and_login')) {
					if($this->request->isLoggedIn()){
						print "<div>".caNavLink($this->request, _t("My Collections"), "", "", "Sets", "Index")."</div>";
						print "<div>".caNavLink($this->request, _t("Logout"), "", "", "LoginReg", "logout")."</div>";
					}else{
						print "<div>".caNavLink($this->request, _t("Login/Register"), "", "", "LoginReg", "form")."</div>";
					}
				}
				# Locale selection
				global $g_ui_locale;
				if (is_array($va_ui_locales = $this->request->config->getList('ui_locales')) && (sizeof($va_ui_locales) > 1)) {
					foreach($va_ui_locales as $vs_locale) {
						if($g_ui_locale != $vs_locale){
							$va_parts = explode('_', $vs_locale);
							$vs_lang_name = Zend_Locale::getTranslation(strtolower($va_parts[0]), 'language', strtolower($va_parts[0]));
							print "<div>".caNavLink($this->request, $vs_lang_name, "", "", $this->request->getController(), $this->request->getAction(), array("lang" => $vs_locale))."</div>";
						}
					}
				
				}
?>
				<div><a href="#" onclick='$("#navMenu").slideUp(250); return false;'><?php print _t("Close Menu"); ?></a></div>
			</div><!-- end navMenu -->
<?php
	}else{
?>
			<div id="header">
<?php
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/".$this->request->config->get('header_img')."' border='0'>", "", "", "", "");
?>				
			</div><!-- end header -->
<?php
	}
?>
