<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<?php print MetaTagManager::getHTML(); ?>
	<!--[if (!IE)|(gte IE 8)]><!-->
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/js/DV/viewer-datauri.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/js/DV/plain-datauri.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/js/DV/plain.css" media="screen" rel="stylesheet" type="text/css" />
	<!--<![endif]-->
	<!--[if lte IE 7]>
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/viewer.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getBaseUrlPath(); ?>/plain.css" media="screen" rel="stylesheet" type="text/css" />
	<![endif]-->
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" type="text/css" />
<?php
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') && !strpos($_SERVER['HTTP_USER_AGENT'], 'Macintosh')){
    	// User agent is Google Chrome on a PC
?>
		<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/chromePC.css" rel="stylesheet" type="text/css" />
<?php
	}
?>
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/vkh7naz-d.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/bookmarks.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/videojs/video-js.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-jplayer/jplayer.blue.monday.css" type="text/css" media="screen" />
  
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
<div id='bodyDiv'>
			<div id="header">
			  <div class="logo">
				
<?php
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/metabolic_logo.png' border='0'>", "", "", "", "");
?>
				
			
			  </div>
			  <div class="portal">

				<div id="search">
					<form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
					
						<!-- <div id="searchButton"><input style='width:47px' type="submit" value="Search" /></div> -->
						<div id="searchElement">
							<input type="search" placeholder="Search" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" size="30"/>
							<div class='advancedSearch'><?php print caNavLink($this->request, _t("advanced search"), "", "", "AdvancedSearch", "Index", array('reset' => 1));?></div>
						</div>
						
					</form>
					
				</div><!-- end search -->
				
			  </div><!-- end portal -->
			  <div id="nav">
				
	<?php				

					print "<div style='float:left; text-transform:uppercase;'>";
					#join(" ", $this->getVar('nav')->getHTMLMenuBarAsLinkArray());
					print caNavLink($this->request, _t("About"), "", "", "About", "Index");
					print caNavLink($this->request, _t("Browse"), "", "", "Browse", "Index");
					print caNavLink($this->request, _t("My Sets"), "", "", "Sets", "Index");
					print caNavLink($this->request, _t("Chronology"), "", "MetabolicChronology", "Show", "Index");
					print caNavLink($this->request, _t("Contribute"), "", "Contribute", "Form", "Edit");
					if($this->request->isLoggedIn()){
						print caNavLink($this->request, _t("Logout"), "", "", "LoginReg", "logout");
					}else{
						print caNavLink($this->request, _t("Login"), "", "", "LoginReg", "form");
					}
					print "</div>";


					if($this->request->isLoggedIn()){
						print "<div style='float:right; text-transform:lowercase;' class='navLink'>".caNavLink($this->request, _t("(bookmarks)"), "", "", "Bookmarks", "Index")."</div>";
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
					print caHTMLSelect('lang', $va_locale_options, array('id' => 'caLocaleSelectorSelect', 'onchange' => 'window.location = \''.caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), $this->request->getAction(), array('lang' => '')).'\' + jQuery(\'#caLocaleSelectorSelect\').val();'), array('value' => $g_ui_locale, 'dontConvertAttributeQuotesToEntities' => true));
					print "</form>\n";
				
				}
?>		
				</div><!-- end nav -->
			</div><!-- end header -->
<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();

	$vs_controller = $this->request->getController();
	if (in_array($vs_controller, array('Object', 'Entity', 'Occurrence', 'Collection', 'Place', 'Form', 'Share'))) {
		print "<div id='detailPageAreaBorder'><div id='detailPageArea'>";
	} else {
		print "<div id='pageArea'>";
	}
?>

		
