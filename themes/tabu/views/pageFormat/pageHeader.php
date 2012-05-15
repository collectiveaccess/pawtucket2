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
		<a name="top"></a><div id="header">
			<div id="logo">
<?php
			print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/logo.gif' border='0'>", "", "", "", "");
?>				
			</div>
			<div id="headerwrapper">
				<div id="headertopbar">
<?php
				if (!$this->request->config->get('dont_allow_registration_and_login')) {
					if($this->request->isLoggedIn()){
						print caNavLink($this->request, _t("Merkliste"), "", "", "Sets", "Index");
						print "&nbsp;&nbsp;|&nbsp;&nbsp;".caNavLink($this->request, _t("Logout"), "", "", "LoginReg", "logout");
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
					#print caFormTag($this->request, $this->request->getAction(), 'caLocaleSelectorForm', null, 'get', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true));
				
					$va_locale_options = array();
					foreach($va_ui_locales as $vs_locale) {
						$va_parts = explode('_', $vs_locale);
						$vs_lang_name = Zend_Locale::getTranslation(strtolower($va_parts[0]), 'language', strtolower($va_parts[0]));
						$va_locale_options[$vs_lang_name] = $vs_locale;
					}
					if ($g_ui_locale == de_DE) {
						print "&nbsp;&nbsp;|&nbsp;&nbsp;<a href='".$vs_base_url."/lang/en_US'>"._t("English")."</a>";
					}
					if ($g_ui_locale == en_US) {
						print "&nbsp;&nbsp;|&nbsp;&nbsp;<a href='".$vs_base_url."/lang/de_DE'>"._t("Deutsch")."</a>";
					}
	
					#print "</form>";
				}else{
					# --- make link to page that has message the English version is coming soon
					print "&nbsp;&nbsp;|&nbsp;&nbsp;".caNavLink($this->request, _t("English"), "", "", "About", "english");
				}
	
		// get last search ('basic_search' is the find type used by the SearchController)
		$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
		$vs_search = $o_result_context->getSearchExpression();
?>
				</div><!-- end headertopbar -->
				<div id="titlebar">
					<?php print _t("Zur Entstehung von F. W. Murnaus TABU"); ?><br/>
					<?php print _t("Edition der Outtakes"); ?>
				</div>
				<form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get"><div id="nav">
					<a href="http://www.tabu.deutsche-kinemathek.de"><?php print _t("Zur Edition"); ?></a><span class='navDivide'>|</span>
<?php
					$va_nav_bar = array();
					foreach($this->getVar('nav')->getHTMLMenuBarAsLinkArray() as $vs_k => $vs_link) {
						$va_nav_bar[] = ($vs_k === 'SELECTED') ? "<span class='selected'>{$vs_link}</span>" : $vs_link;
					}
					print join("<span class='navDivide'>|</span>", $va_nav_bar);
?>
					<span class='navDivide'>|</span><?php print _t("Freie Suche"); ?><input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" size="100"/><a href="#" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;" class="search"><?php print _t("Go"); ?></a>
				</div><!-- end nav --></form>
			</div><!-- end headerwrapper -->
		</div><!-- end header -->
<?php
		# --- obj detail page shows related objects in this left col, so code is output in object detail view
		if($this->request->getController() != "Object"){
?>
			<div id="pageAreaLeft">
				<img src='<?php print $this->request->getThemeUrlPath() ?>/graphics/spear.jpg' border='0'>
			</div><div id="pageArea"><div id="contentArea">
<?php
		}
?>