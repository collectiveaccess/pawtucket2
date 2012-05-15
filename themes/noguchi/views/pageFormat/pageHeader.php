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
				print caHTMLSelect('lang', $va_locale_options, array('id' => 'caLocaleSelectorSelect', 'onclick' => 'jQuery(document).attr("location", "'.caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array('lang' => '')).'" + jQuery("#caLocaleSelectorSelect").val());'), array('value' => $g_ui_locale));
				print "</form>\n";
			
			}
?>
		</div><!-- end topbar -->
		<div id="pageArea">
		<div id="nav">
			<div id="header">
<?php
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/noguchi.png'  border='0' style='margin-bottom:10px'>", "", "", "", "");
?>				
			</div><!-- end header -->
<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();
?>
			
				
<?php
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/nav_home.gif'  border='0'>", "", "", "", "")."<div class='navDivide'></div>";
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/nav_browse.gif'  border='0'>", "", "", "Browse", "clearCriteria")."<div class='navDivide'></div>";
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/nav_view.gif'  border='0'>", "", "", "Sets", "index")."<div class='navDivide'></div>";
			
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/nav_logout.gif'  border='0'>", "", "", "LoginReg", "logout");
				}else{
					print caNavLink($this->request,"<img src='".$this->request->getThemeUrlPath()."/graphics/nav_login.gif'  border='0'>", "", "", "LoginReg", "form");
				}
			}
				
				
				
?>
			<div id="search"><form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
						<a href="#" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;"> > </a>
						<input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" size="100"/>
				</form>&copy; The Noguchi Museum</div>
				
			</div><!-- end nav -->
<?php
}
?>
