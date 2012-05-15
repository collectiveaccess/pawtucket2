<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<?php print MetaTagManager::getHTML(); ?>
	
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />
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
		
		<div id="topBar">
<?php
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("My Sets"), "", "", "Sets", "index");
					print caNavLink($this->request, _t("Logout"), "", "", "LoginReg", "logout");
				}else{
					print caNavLink($this->request, _t("Login/Register"), "", "", "LoginReg", "form");
				}
			}
			
			# Locale selection
			global $g_ui_locale;
			$vs_base_url = $this->request->getRequestUrl();
			$vs_base_url = ((substr($vs_base_url, 0, 1) == '/') ? $vs_base_url : '/'.$vs_base_url);
			$vs_base_url = str_replace("/lang/de_DE", "", $vs_base_url);
			$vs_base_url = str_replace("/lang/en_US", "", $vs_base_url);
			
			if (is_array($va_ui_locales = $this->request->config->getList('ui_locales')) && (sizeof($va_ui_locales) > 1)) {
				if ($g_ui_locale == "de_DE") {
                                        print "<a href='".$vs_base_url."/lang/en_US'>English version</a>";
                                }
                                if ($g_ui_locale == "en_US") {
                                        print "<a href='".$vs_base_url."/lang/de_DE'>Deutsche Version</a>";
                                }
			}
?>
		</div><!-- end topbar -->
		<div id="pageArea">
			<div id="header">
<?php
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/logo.jpg' width='790' height='100' border='0'>", "", "", "", "");
?>				
			</div><!-- end header -->
<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();
?>
			<div id="nav">
				<div id="search">
				<form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
						<a href="#" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;"><?php print _t("Search");?></a>
						<input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" size="100"/>
				</form>
				</div>
<?php
				print caNavLink($this->request, ($g_ui_locale=="en_US" ? "Home" : "Home"), "", "", "", "");
				print caNavLink($this->request, ($g_ui_locale=="en_US" ? "Browse" : "Alle Filme"), "", "", "Browse", "clearCriteria");
				print caNavLink($this->request, ($g_ui_locale=="en_US" ? "About" : "Information"), "", "", "About", "index");
?>
				<a href="http://www.arsenal-berlin.de/de/"><?php print ($g_ui_locale=="en_US" ? "Main Site" : "Arsenal Website"); ?></a>
			</div><!-- end nav -->
<?php
}
?>
