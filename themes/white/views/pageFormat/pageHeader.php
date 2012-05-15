<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<META NAME="Description" CONTENT="">
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/global.css" rel="stylesheet" type="text/css" />
	<link href="<?php print $this->request->getThemeUrlPath(true); ?>/css/sets.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/videojs/video-js.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $this->request->getBaseUrlPath(); ?>/js/jquery/jquery-jplayer/jplayer.blue.monday.css" type="text/css" media="screen" />
	
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
	</script>
	
	<script type="text/javascript" src="/GLOBAL/JS/prototype.js"></script>
	<script type="text/javascript" src="/GLOBAL/JS/effects.js"></script>
	<script type="text/javascript" src="/GLOBAL/JS/scripts.js"></script>

<script type="text/javascript">
<!--
	selectedImg = "image1";
	
	function initImages() {
		Element.show('images');
		Element.hide('loading');
		Element.hide('image1');
		Element.show('image1-hi');
	}
	
	Event.observe(window, 'load', initImages, false);
//-->
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
			<div id="header">

				<a href="http://www.whitecolumns.org"><img class="wclogo" src="<?php print $this->request->getThemeUrlPath()?>/graphics/wc-sans.gif" width='156' height='22' border='0'></a>
				
			</div><!-- end header -->
			<div id="menu">
    <div style="float: left; margin-right: 15px; width: 110px;">
        <ul>
            <li><a id="exhibitions" href="#" onclick="selectMenu(this.id); return false;">Exhibitions</a></li>
        </ul>
        <ul id="exhibitions-sub" class="sublist" style="display: none;">

            <li><a id="exhibitions-current" href="http://www.whitecolumns.org/exhibitions.html?type=current">Current</a></li>
            <li><a id="exhibitions-past" href="http://www.whitecolumns.org/exhibitions.html?type=past">Past</a></li>
            <li><a id="exhibitions-upcoming" href="http://www.whitecolumns.org/exhibitions.html?type=upcoming">Upcoming</a></li>
        </ul>
        <ul>
            <li><a id="projects" href="#" onclick="selectMenu(this.id); return false;">Projects</a></li>
        </ul>

        <ul id="projects-sub" class="sublist" style="display: none;">
            <li><a id="projects-editions" href="http://www.whitecolumns.org/text.html?type=editions">Editions</a></li>
            <li><a id="projects-publications" href="http://www.whitecolumns.org/text.html?type=publications">Publications</a></li>
            <li><a id="projects-the_sound" href="http://www.whitecolumns.org/text.html?type=the_sound">TSoWC</a></li>
			<li><a id="projects-other" href="http://www.whitecolumns.org/text.html?type=other">Other Projects</a></li>
        </ul>
    </div>

    <div style="float: left; margin-right: 15px; width: 110px;">
        <ul>
            <li><a id="information" href="#" onclick="selectMenu(this.id); return false;">Information</a></li>
        </ul>
        <ul id="information-sub" class="sublist" style="display: none;">
            <li><a id="information-history" href="http://www.whitecolumns.org/text.html?type=history">History</a></li>
            <li><a id="information-contact" href="http://www.whitecolumns.org/text.html?type=contact">Contact</a></li>

            <li><a id="information-staff_board" href="http://www.whitecolumns.org/text.html?type=staff_board">Staff &amp; Board</a></li>
            <li><a id="information-mailing_list" href="http://www.whitecolumns.org/text.html?type=mailing_list">Mailing List</a></li>
        </ul>
        <ul>
            <li><a id="support" href="#" onclick="selectMenu(this.id); return false;">Support</a></li>
        </ul>

        <ul id="support-sub" class="sublist" style="display: none;">
            <li><a id="support-membership" href="http://www.whitecolumns.org/text.html?type=membership">Membership</a></li>
            <li><a id="support-funders" href="http://www.whitecolumns.org/text.html?type=funders">Funders</a></li>
            <li><a id="support-artists_for_wc" href="http://www.whitecolumns.org/text.html?type=artists_for_wc">Artists for<br />White Columns</a></li>
        </ul>
    </div>
    <div style="float: left; margin-right: 15px; width: 110px;">

        <ul>
            <li><a id="artists-registry" href="http://www.whitecolumns.org/text.html?type=artists_registry">Artists Registry</a></li>
        </ul>
        <ul>
            <li><a id="submissions" href="#" onclick="selectMenu(this.id); return false;">Submissions</a></li>
        </ul>
        <ul id="submissions-sub" class="sublist" style="display: none;">
            <li><a id="submissions-artists_guide" href="http://www.whitecolumns.org/text.html?type=artists_guide">Artists Submission Guidelines</a></li>

            <li><a id="submissions-exhibition_guide" href="http://www.whitecolumns.org/text.html?type=exhibition_guide">Exhibition Proposal Guidelines</a></li>
        </ul>
    </div>
    <div style="float: left; width: 110px; ">
        <ul>
            <li><a id="news" href="http://www.whitecolumns.org/text.html?type=news">News</a></li>
        </ul>
        <ul>

            <li><a id="links" href="http://www.whitecolumns.org/text.html?type=links">Links</a></li>
        </ul>
    </div>
    <div style="float: left; width: 50px; margin-left:-30px;">
        <ul>

            <li><a id="archive1" href="http://www.whitecolumns.org/archive">Archive</a></li>
        </ul>
    </div>
</div>

<?php
	// get last search ('basic_search' is the find type used by the SearchController)
	$o_result_context = new ResultContext($this->request, 'ca_objects', 'basic_search');
	$vs_search = $o_result_context->getSearchExpression();
?>
			<div id="nav">
				<div id="search"><form name="header_search" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
						<a href="#" name="searchButtonSubmit" onclick="document.forms.header_search.submit(); return false;">Search</a>
						<input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" size="100"/>
				</form></div>
<?php
				print caNavLink($this->request, _t("Archive in Progress"), "", "", "Browse", "clearCriteria");
				// print caNavLink($this->request, _t("Features"), "", "", "Features", "index");
				//print caNavLink($this->request, _t("About"), "", "", "About", "index");
?>
			</div><!-- end nav -->
<?php
}
?>
