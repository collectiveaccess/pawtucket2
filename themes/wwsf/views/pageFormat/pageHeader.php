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
<?php
	if (!$this->request->isAjax()) {
?>
		
		<div id ="topNavBg">	
			<div id="topBar">
			
<?php
			print caNavLink($this->request, _t("About"), "", "", "About", "Index");
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("My Sets"), "", "", "Sets", "Index");
					print caNavLink($this->request, _t("Logout"), "", "", "LoginReg", "logout");
				}else{
					print caNavLink($this->request, _t("Login/Register"), "", "", "LoginReg", "form");
				}
			}
			
			# Locale selection
			global $g_ui_locale;
			$vs_base_url = $this->request->getRequestUrl();
			$vs_base_url = ((substr($vs_base_url, 0, 1) == '/') ? $vs_base_url : '/'.$vs_base_url);
			$vs_base_url = str_replace("/lang/[A-Za-z_]+", "", $vs_base_url);
			
			if (is_array($va_ui_locales = $this->request->config->getList('ui_locales')) && (sizeof($va_ui_locales) > 1)) {
				print caFormTag($this->request, $this->request->getAction(), 'caLocaleSelectorForm', null, 'get', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true));
			
				$va_locale_options = array();
				foreach($va_ui_locales as $vs_locale) {
					$va_parts = explode('_', $vs_locale);
					$vs_lang_name = Zend_Locale::getTranslation(strtolower($va_parts[0]), 'language', strtolower($va_parts[0]));
					$va_locale_options[$vs_lang_name] = $vs_locale;
				}
				if ($g_ui_locale == de_DE) {
					print "<a href='".$vs_base_url."/lang/en_US'>English</a>";
				}
				if ($g_ui_locale == en_US) {
					print "<a href='".$vs_base_url."/lang/de_DE'>Deutsch</a>";
				}

				print "</form>";
			}
?>
		</div></div><!-- end topbar -->
		<div id="headerBg">
			<div id="header">
<?php
		if ($g_ui_locale == en_US) {
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/logo_eng.gif' border='0'>", "", "", "", "");
		} else {
?>		
				<img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/t_momentaufnahmen_1989_1990.gif" width="269" height="39" border="0" style="float:right;">
<?php				
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/logo.gif' border='0'>", "", "", "", "");
		}
?>				
			</div></div><!-- end header -->
<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();
?>
		<div id="navBg">
			<div id="nav">
				<div id="search"><form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
						<a href="#" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;"><?php print _t("Search"); ?></a>
						<input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : _t("enter search term"); ?>" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" size="100"/>
				</form></div>
<?php
				print caNavLink($this->request, _t("Library"), "", "", "Browse", "clearCriteria");
				print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath().'/graphics/memories_icon_navbar.gif" width="17" height="16" border="0"> '._t("Memories"), "", "wwsf", "Memories", "Index");
				print caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath().'/graphics/themes_icon_navbar.gif" width="17" height="16" border="0"> '._t("Themes"), "", "wwsf", "Themes", "Index");
				print caNavLink($this->request, _t("Places"), "", "wwsf", "Places", "Index");
				print caNavLink($this->request, _t("Favorites"), "", "", "Favorites", "Index");
?>
			</div><!-- end nav --></div><!-- end navBg -->
<?php
		# --- search page nav extends the full page width, so need to output pageArea later
		if($this->request->getController() != "Search"){
?>
			<div id="pageArea">
<?php
		}
}
?>
