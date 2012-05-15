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
	<script type="text/javascript" src="<?php print $this->request->getThemeUrlPath(true); ?>/js/jquery/superfish.js"></script>
	<script> 
 
    $(document).ready(function() { 
        $('ul.sf-menu').superfish(); 
    }); 
 
	</script>
</head>
<body>
		<div id="topBar">
<?php
/*
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("My Collections"), "", "", "Sets", "Index");
					print caNavLink($this->request, _t("Logout"), "", "", "LoginReg", "logout");
				}else{
					print caNavLink($this->request, _t("Login/Register"), "", "", "LoginReg", "form");
				}
			}
*/
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
			<div id="nav">
				<div id="search"><form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
						<a href="#" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;"><?php print _t("Search"); ?></a>
						<input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" size="100"/>
				</form></div>
<?php
				print caNavLink($this->request, "Home", "", "", "", "");
				print join(" ", $this->getVar('nav')->getHTMLMenuBarAsLinkArray());
				print caNavLink($this->request, "Credits", "", "About", "credits", "");
				print "<a href='http://photographersubject.com/'>Blog</a>";
?>
			</div><!-- end nav -->
		</div><!-- end topbar -->
		<div id="pageArea">
			<div id="header">
<?php
				print "<img src='".$this->request->getThemeUrlPath()."/graphics/logo_01.png' border='0'>";
?>
			<ul class="sf-menu" id="headermenu">
				<li style="width: 84px;">
<?php
					print "<a href='#'><img src='".$this->request->getThemeUrlPath()."/graphics/logo_02.png' border='0'></a>";
?>
					<ul>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/129/mod_id/0">Animations</a>
						</li>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/120/mod_id/0">Documentaries</a>
						</li>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/121/mod_id/0">Feature Films</a>
						</li>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/125/mod_id/0">Short Films</a>
						</li>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/126/mod_id/0">Television</a>
						</li>
					</ul>					
				</li>
<?php
				print "<li class='and'><img src='".$this->request->getThemeUrlPath()."/graphics/logo_03.png' border='0'></li>";
?>
				<li style="width: 136px;">
<?php
					print "<a href='#'><img src='".$this->request->getThemeUrlPath()."/graphics/logo_04.png' border='0'></a>";
?>					
					<ul>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/137/mod_id/0">Comics</a>
						</li>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/115/mod_id/0">Novels</a>
						</li>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/131/mod_id/0">Poetry</a>
						</li>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/138/mod_id/0">Short Stories</a>
						</li>
					</ul>		
				</li>
<?php
				print "<li class='and'><img src='".$this->request->getThemeUrlPath()."/graphics/logo_05.png' border='0'></li>";
?>
				<li style="width: 92px;">
<?php
					print "<a href='#'><img src='".$this->request->getThemeUrlPath()."/graphics/logo_06.png' border='0'></a>";
?>
					<ul>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/136/mod_id/0">Advertisements</a>
						</li>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/113/mod_id/0">Essays</a>
						</li>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/122/mod_id/0">News</a>
						</li>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/116/mod_id/0">Nonfiction Books</a>
						</li>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/118/mod_id/0">Opinions</a>
						</li>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/114/mod_id/0">Profiles</a>
						</li>
					</ul>					
				</li>
<?php
				print "<li class='and'><img src='".$this->request->getThemeUrlPath()."/graphics/logo_07.png' border='0'></li>";
?>
				<li style="width: 160px;">
<?php
					print "<a href='#'><img src='".$this->request->getThemeUrlPath()."/graphics/logo_08.jpg' border='0'></a>";
?>
					<ul>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/117/mod_id/0">Exhibitions</a>
						</li>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/139/mod_id/0">Performances</a>
						</li>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/128/mod_id/0">Songs</a>
						</li>
						<li>
							<a href="/index.php/Browse/modifyCriteria/facet/category_facet/id/119/mod_id/0">Theatre</a>
						</li>
					</ul>		
				</li>
			</ul>
			<div style="clear:both;"><!-- empty --></div>
			</div><!-- end header -->
<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();
?>

