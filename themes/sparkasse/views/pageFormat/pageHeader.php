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
<?php 
	print caNavLink($this->request, "<div style='position:absolute; top:0; left:0; width: 150px; height: 300px;'></div>", "", "", "", "");
?>
		
			<div id="header">
			
<?php
			$vs_action = $this->request->getAction();
			$vs_controller = $this->request->getController();
			if ($vs_controller == 'Browse' | $vs_action == 'Show' | $vs_controller == 'Search') {
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/Header-Archiv-B.jpg' border='0'>", "", "", "", "");
			} else if ($vs_action == 'museum' | $vs_action == 'soll' | $vs_action == '1825' | $vs_action == 'spare' | $vs_action == 'nah' | $vs_action == 'soll' | $vs_action == 'klingende' | $vs_action == 'sicher' | $vs_action == 'giro' | $vs_action == 'rechnen' | $vs_action == 'abfertigen') {
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/Header-Museum-B.jpg' border='0'>", "", "", "", "");
			} else if ($vs_action == 'hintergrund') {
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/Header-Hintergrung-B.jpg' border='0'>", "", "", "", "");
			} else if ($vs_action == 'impressum') {
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/Header-Impressum-B.jpg' border='0'>", "", "", "", "");
			} else {
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/Header-splash.jpg' border='0' height='146px' usemap='#splashMap'>", "", "", "", "");
			}
?>				
			</div><!-- end header -->
<map name="splashMap" id="splashMap" >
  <area shape="rect" coords="0,0,182,145"  href="<?php print caNavUrl($this->request, '', 'About','museum'); ?>" id="museum" title="Museum" />
  <area shape="rect" coords="195,0,375,145"  href="<?php print caNavUrl($this->request, '', 'Browse','clearCriteria'); ?>"  id="archiv" title="Archiv" />
  <area shape="rect" coords="388,0,570,145"  href="<?php print caNavUrl($this->request, '', 'About','hintergrund'); ?>"  id="hintergrund" title="Hintergrund" />
  <area shape="rect" coords="581,0,504,764"  href="<?php print caNavUrl($this->request, '', 'About','impressum'); ?>"  id="impressum" title="Impressum" />
</map>
			<div style="height:1px; clear:both; width:100%; margin-top:180px;"></div>
<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();

?>

			<div id="nav">

<?php				
				$vs_action = $this->request->getAction();
				$vs_controller = $this->request->getController();
				print "<div class='museumLink ".(($vs_action == 'museum' | $vs_action == 'soll' | $vs_action == '1825' | $vs_action == 'spare' | $vs_action == 'nah' | $vs_action == 'soll' | $vs_action == 'klingende' | $vs_action == 'sicher' | $vs_action == 'giro' | $vs_action == 'rechnen' | $vs_action == 'abfertigen') ? 'activeLink' : '')."'>".caNavLink($this->request, _t("Museum"), "", "", "About", "museum")."</div>";
				print "<div class='archivLink ".(($vs_controller == 'Browse' | $vs_action == 'Show' | $vs_controller == 'Search') ? 'activeLink' : '')."'>".caNavLink($this->request, _t("Archiv"), "", "", "Browse", "clearCriteria")."</div>";
				print "<div class='hintergrundLink ".(($vs_action == 'hintergrund') ? 'activeLink' : '')."'>".caNavLink($this->request, _t("Hintergrund"), "", "", "About", "hintergrund")."</div>";
				print "<div class='impressumLink ".(($vs_action == 'impressum') ? 'activeLink' : '')."'>".caNavLink($this->request, _t("Impressum"), "", "", "About", "impressum")."</div>";
?>
			</div><!-- end nav -->
<?php
	if ($this->request->getController() == 'About') {
		print "<div style='height:70px; width: 100%; clear:both;'></div>";
	}
	if (($this->request->getController() != 'Splash') && ($this->request->getController() != 'About')) {

?>
		<div id="topBar">
				<div id="search">
				<form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
						<a href="#" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;">Freitextsuche</a>
						<input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : 'Suchtext eingeben'; ?>" onfocus="if(this.value == this.defaultValue) this.value = '';" onblur="if(!this.value) this.value = this.defaultValue;" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" size="100"/>
				</form>
				</div>	
		<div class='loginLink'>&nbsp;</div>
<?php			
			/*# Locale selection
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
				print caHTMLSelect('lang', $va_locale_options, array('id' => 'caLocaleSelectorSelect', 'onchange' => 'window.location = \''.caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array('lang' => '')).'\' + jQuery(\'#caLocaleSelectorSelect\').val();'), array('value' => $g_ui_locale, 'dontConvertAttributeQuotesToEntities' => true));
				print "</form>\n";
			
			}*/
?>
		</div><!-- end topbar -->
<?php
	}
?>
		<div id="pageArea">