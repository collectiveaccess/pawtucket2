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
	<link rel="stylesheet" href="<?php print $this->request->getThemeUrlPath(true); ?>/css/jquery-ui-1.8.11.custom.css" rel="stylesheet" type="text/css" />
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
	<div id="pageArea">		
<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_occurrences', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();
?>
		<div id="search"><form name="header_search" action="<?php print caNavUrl($this->request, 'clir2', 'NYWFOccurrencesSearch', 'Index'); ?>" method="get"><input type="hidden" name="target" value="ca_occurrences">
				<div id="searchBox"><input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" size="100"/><a href="#" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/spacer.gif' border='0' width='18' height='18'></a></div><!-- end searchBox -->
				Search options: <select onChange="this.form.action=this.options[this.selectedIndex].value;" class="searchDD">
						<option value="<?php print caNavUrl($this->request, 'clir2', 'NYWFOccurrencesSearch', 'Index'); ?>">New York World's Fair Films</option>
						<option value="<?php print caNavUrl($this->request, 'clir2', 'PFCollectionsSearch', 'Index'); ?>">NHF 1938-1940 Collections</option>
					</select>&nbsp;&nbsp;
		</form></div>
		<div id="topBar">
<?php
			if (!$this->request->config->get('dont_allow_registration_and_login')) {
				if($this->request->isLoggedIn()){
					print caNavLink($this->request, _t("My Sets"), "", "clir2", "MySets", "Index");
					print caNavLink($this->request, _t("Logout"), "", "", "LoginReg", "logout");
				}else{
					print caNavLink($this->request, _t("Login/Register"), "", "", "LoginReg", "form");
				}
			}
			print caNavLink($this->request, _t("Search Tips"), "", "", "About", "SearchTips");
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
			<div id="header">
<?php
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/clir2/title2.gif' border='0' width='815' height='32'>", "subTitle", "", "", "");
?>				
			</div><!-- end header -->
			
			<div id="nav">
<?php
				print "<div class='navLink".(($this->request->getController() == "Splash") ? "Selected" : "")."'>".caNavLink($this->request, "Home", (($this->request->getController() == "Splash") ? "selected" : ""), "", "", "")."</div><div class='divide'><!--empty--></div>";
				print "<div class='navLink".((($this->request->getController() == "Collections") || ($this->request->getController() == "Browse") || ($this->request->getController() == "Search") || ($this->request->getController() == "Collection") || ($this->request->getController() == "Object")) ? "Selected" : "")."'>".caNavLink($this->request, "Explore the Collections", ((($this->request->getController() == "Collections") || ($this->request->getController() == "Browse") || ($this->request->getController() == "Search") || ($this->request->getController() == "Collection") || ($this->request->getController() == "Object")) ? "selected" : ""), "clir2", "Collections", "Index")."</div><div class='divide'><!--empty--></div>";
				#print "<div class='navLink".(($this->request->getController() == "Engage") ? "Selected" : "")."'>".caNavLink($this->request, "Engage", ((($this->request->getController() == "Engage") || ($this->request->getController() == "YourSets") || ($this->request->getController() == "Comments") || ($this->request->getController() == "Exhibits")) ? "selected" : ""), "clir2", "Engage", "Index")."</div><div class='divide'><!--empty--></div>";
				print "<div class='navLink".((($this->request->getController() == "Engage") || ($this->request->getController() == "YourSets") || ($this->request->getController() == "Comments") || ($this->request->getController() == "Exhibits")) ? "Selected" : "")."'>";
?>
				<ul class="sf-menu">
					<li><?php print caNavLink($this->request, "Engage", ((($this->request->getController() == "Engage") || ($this->request->getController() == "YourSets") || ($this->request->getController() == "Comments") || ($this->request->getController() == "Exhibits")) ? "selected" : ""), "clir2", "Engage", "Index"); ?>
						<ul>
							<li><?php print caNavLink($this->request, _t("Overview"), "submenu", "clir2", "Engage", "Index"); ?></li>
							<li><?php print caNavLink($this->request, _t("Your Sets"), "submenu", "clir2", "YourSets", "Index"); ?></li>
							<li><?php print caNavLink($this->request, _t("Comments"), "submenu", "clir2", "Comments", "Index"); ?></li>
							<li><?php print caNavLink($this->request, _t("Exhibits"), "submenu", "clir2", "Exhibits", "Index"); ?></li>
							<li><?php print caNavLink($this->request, _t("Essays"), "submenu", "clir2", "Engage", "Essays"); ?></li>
							<li><?php print caNavLink($this->request, _t("More"), "submenu", "clir2", "Engage", "More"); ?></li>
						</ul>
					</li>
				</ul>				
<?php
				print "</div><div class='divide'><!--empty--></div>";

				print "<div class='navLink".(($this->request->getController() == "NewsEvents") ? "Selected" : "")."'>".caNavLink($this->request, "News & Events", (($this->request->getController() == "NewsEvents") ? "selected" : ""), "clir2", "NewsEvents", "Index")."</div><div class='divide'><!--empty--></div>";
				#print "<div class='navLink".(($this->request->getController() == "Resources") ? "Selected" : "")."'>".caNavLink($this->request, "NYWF Resources", (($this->request->getController() == "Resources") ? "selected" : ""), "clir2", "Resources", "Index")."</div><div class='divide'><!--empty--></div>";
				print "<div class='navLink".(($this->request->getController() == "Resources") ? "Selected" : "")."'>";
?>
				<ul class="sf-menu">
					<li><?php print caNavLink($this->request, "NYWF Resources", (($this->request->getController() == "Resources") ? "selected" : ""), "clir2", "Resources", "Index"); ?>
						<ul>
							<li><?php print caNavLink($this->request, "Digital Video Online", "submenu", "clir2", "Resources", "Index#video"); ?></li>
							<li><?php print caNavLink($this->request, "Libraries and Archives", "submenu", "clir2", "Resources", "Index#library"); ?></li>
							<li><?php print caNavLink($this->request, "Bibliographies", "submenu", "clir2", "Resources", "Index#bib"); ?></li>
							<li><?php print caNavLink($this->request, "Audiovisual Productions", "submenu", "clir2", "Resources", "Index#audiovisual"); ?></li>
							<li><?php print caNavLink($this->request, "Books", "submenu", "clir2", "Resources", "Index#books"); ?></li>
							<li><?php print caNavLink($this->request, "Web Resources", "submenu", "clir2", "Resources", "Index#web"); ?></li>
							<li><?php print caNavLink($this->request, "Essays", "submenu", "clir2", "Resources", "Index#essays"); ?></li>							
						</ul>
					</li>
				</ul>				
<?php
				print "</div><div class='divide'><!--empty--></div>";
				#print "<div class='navLink".(($this->request->getController() == "About") ? "Selected" : "")."'>".caNavLink($this->request, "About", (($this->request->getController() == "About") ? "selected" : ""), "", "About", "Index")."</div>";
				print "<div class='navLink".(($this->request->getController() == "About") ? "Selected" : "")."'>";
?>
				<ul class="sf-menu">
					<li><?php print caNavLink($this->request, "About", (($this->request->getController() == "About") ? "selected" : ""), "", "About", "Index"); ?>
						<ul>
							<li><?php print caNavLink($this->request, _t("About the Project"), "submenu", "", "About", "Index"); ?></li>
							<li><?php print caNavLink($this->request, _t("Partners"), "submenu", "", "About", "Partners"); ?></li>
							<li><?php print caNavLink($this->request, _t("Participants"), "submenu", "", "About", "Participants"); ?></li>
							<li><?php print caNavLink($this->request, _t("Cataloging Resources"), "submenu", "", "About", "CatalogingResources"); ?></li>
							<li><?php print caNavLink($this->request, _t("Project Blog"), "submenu", "", "About", "ProjectBlog"); ?></li>
						</ul>
					</li>
				</ul>				
<?php
				print "</div>";
?>
			</div><!-- end nav -->
<script> 
 
    $(document).ready(function(){ 
        $("ul.sf-menu").superfish(); 
    }); 
 
</script>