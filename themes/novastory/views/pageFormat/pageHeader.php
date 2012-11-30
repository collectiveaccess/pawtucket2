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
</head>
<body>
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
				print caHTMLSelect('lang', $va_locale_options, array('id' => 'caLocaleSelectorSelect', 'onchange' => 'window.location = \''.caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array('lang' => '')).'\' + jQuery(\'#caLocaleSelectorSelect\').val();'), array('value' => $g_ui_locale, 'dontConvertAttributeQuotesToEntities' => true));
				print "</form>\n";
			
			}
			
?>
		</div><!-- end topbar -->
		<div id="pageArea">
<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();
?>
			<div id="nav">
				<div id="logo">
<?php				
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/logo2.png' border='0'>", "", "", "", "");
?>				
				</div><!-- end header -->
				<div id="search"><form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
						<a href="#" style="position: absolute; z-index:1500; margin: 4px 0px 0px 132px;" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;"></a>
						<input type="text" name="search" value="search" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" size="100"/>
				</form></div>
<?php	
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("logout"), "", "", "LoginReg", "logout");
					if(!$this->request->config->get('disable_my_collections')){
						# --- get all sets for user
						$t_set = new ca_sets();
						$va_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_objects', 'user_id' => $this->request->getUserID())));

						print caNavLink($this->request, _t("lightbox"), "", "", "Sets", "Index");
						if(is_array($va_message_set_ids) && sizeof($va_message_set_ids)){
							print " <img src='".$this->request->getThemeUrlPath()."/graphics/icons/envelope.gif' border='0'>";
						}
						
					}
					
					if($this->request->config->get('enable_bookmarks')){
						print caNavLink($this->request, _t("my bookmarks"), "", "", "Bookmarks", "Index");
					}
					
				}else{
					print caNavLink($this->request, _t("login/register"), "", "", "LoginReg", "form");
				}
			}

				print join(" ", $this->getVar('nav')->getHTMLMenuBarAsLinkArray());
?>
			</div><!-- end nav -->
