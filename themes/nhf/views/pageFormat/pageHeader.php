<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
?>
<?php	
	$va_lightboxDisplayName = caGetLightboxDisplayName();
	$vs_lightbox_sectionHeading = ucFirst($va_lightboxDisplayName["section_heading"]);
	$va_classroomDisplayName = caGetClassroomDisplayName();
	$vs_classroom_sectionHeading = ucFirst($va_classroomDisplayName["section_heading"]);
	
	# --- last search term
	$o_result_context = new ResultContext($this->request, "ca_collections", "multisearch");
	$vs_last_search = $o_result_context->getSearchExpression();
	
	# Collect the user links: they are output twice, once for toggle menu and once for nav
	$va_user_links = array();
	if($this->request->isLoggedIn()){
		$va_user_links[] = '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
		$va_user_links[] = '<li class="divider nav-divider"></li>';
		if(caDisplayLightbox($this->request)){
			$va_user_links[] = "<li>".caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
		}
		if(caDisplayClassroom($this->request)){
			$va_user_links[] = "<li>".caNavLink($this->request, $vs_classroom_sectionHeading, '', '', 'Classroom', 'Index', array())."</li>";
		}
		$va_user_links[] = "<li>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
		$va_user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);

?>	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="/sites/all/themes/nhf_vone/favicon.ico" type="image/x-icon" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<title>Moving Images | Northeast Historic Film<?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<link type="text/css" rel="stylesheet" media="all" href="/modules/aggregator/aggregator.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/modules/node/node.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/modules/system/defaults.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/modules/system/system.css?j" />

	<link type="text/css" rel="stylesheet" media="all" href="/modules/system/system-menus.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/modules/user/user.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/modules/cck/theme/content-module.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/modules/date/date.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/modules/filefield/filefield.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/modules/views_slideshow/contrib/views_slideshow_singleframe/views_slideshow.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/modules/views_slideshow/contrib/views_slideshow_thumbnailhover/views_slideshow.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/modules/views/css/views.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/modules/node_import/node_import.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/nhf_vone/html-elements.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/zen/zen/tabs.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/zen/zen/messages.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/zen/zen/block-editing.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/zen/zen/wireframes.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/nhf_vone/layout.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/nhf_vone/nhf_vone.css?j" />
	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/nhf_vone/sidebars.css?j" />

	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/nhf_vone/nhf_vone-fresh.css?j" />
	<link type="text/css" rel="stylesheet" media="print" href="/sites/all/themes/nhf_vone/print.css?j" />
	<!--[if IE]>
	<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/zen/zen/ie.css?j" />
	<![endif]-->
			<script type="text/javascript" src="/misc/jquery.js?j"></script>
	<script type="text/javascript" src="/misc/drupal.js?j"></script>
	<script type="text/javascript" src="/sites/all/modules/rounded_corners/jquery.corner.js?j"></script>
	<script type="text/javascript" src="/sites/all/modules/views_slideshow/js/jquery.cycle.all.min.js?j"></script>
	<script type="text/javascript" src="/sites/all/modules/views_slideshow/contrib/views_slideshow_singleframe/views_slideshow.js?j"></script>
	<script type="text/javascript" src="/sites/all/modules/views_slideshow/contrib/views_slideshow_thumbnailhover/views_slideshow.js?j"></script>
	<script type="text/javascript" src="/sites/all/modules/image_caption/image_caption.js?j"></script>

	<script type="text/javascript" src="/sites/all/themes/nhf_vone/script.js?j"></script>
	
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	
	<script type="text/javascript">
	<!--//--><![CDATA[//><!--
	jQuery.extend(Drupal.settings, { "basePath": "/" });
	//--><!]]>
	</script>
	
	
	
	
	
	
	

<?php
	if(Debug::isEnabled()) {		
		//
		// Pull in JS and CSS for debug bar
		// 
		$o_debugbar_renderer = Debug::$bar->getJavascriptRenderer();
		$o_debugbar_renderer->setBaseUrl(__CA_URL_ROOT__.$o_debugbar_renderer->getBaseUrl());
		print $o_debugbar_renderer->renderHead();
	}
?>
</head>
<body class="not-front not-logged-in node-type-page one-sidebar sidebar-left page-node-19 section-node">

  <div id="page"><div id="page-inner">

    <a name="navigation-top" id="navigation-top"></a>

          <div id="skip-to-nav"><a href="#navigation">Skip to Navigation</a></div>
    
    <div id="header"><div id="header-inner" class="clear-block">

              <div id="header-blocks" class="region region-header">
          <div id="block-search-0" class="block block-search region-odd odd region-count-1 count-1"><div class="block-inner">

  
<div class="content">
    <div id="search-box-3">
	<form action="/sites/all/search_gate.php"  accept-charset="UTF-8" method="post" id="search-theme-form-3">

		<div>
			<div id="search-3" class="container-inline">
				Search:
				<div class="form-item" id="edit-search-theme-form-1-wrapper-3">
					<label for="edit-search-theme-form-3">Search this site: </label>
					<input type="text" maxlength="128" name="search_theme_form" id="edit-search-theme-form-3" size="15" value="" title="Enter the terms you wish to search for." class="form-text" />
				</div>
				<select name="scope">
					<option value="site">search site</option>
					<option value="store">search store</option>
					<option value="collections">search collections</option>
				</select>
				<input type="submit" name="op" id="edit-submit-3" value="GO"  class="form-submit" />
			</div>
		</div>
	</form>
</div> <!-- /#search-box -->
  </div>


  
</div></div> <!-- /block-inner, /block -->

        </div> <!-- /#header-blocks -->
      
    </div></div> <!-- /#header-inner, /#header -->

    <div id="main"><div id="main-inner" class="clear-block with-navbar">

		<div id="banner" class="region region-banner">
				</div>



              <div id="navbar"><div id="navbar-inner" class="clear-block region region-navbar">

              <div id="logo-title">

                      <div id="logo"><a href="/" title="Home" rel="home"><img src="/sites/all/themes/nhf_vone/logo.png" alt="Home" id="logo-image" /></a></div>
          
                                    <div id="site-name"><strong>
                <a href="/" title="Home" rel="home">
                Northeast Historic Film                </a>
              </strong></div>

                      
          
        </div> <!-- /#logo-title -->
      



          <a name="navigation" id="navigation"></a>

                      <div id="search-box">
										<form action="/node/3"  accept-charset="UTF-8" method="post" id="search-theme-form">

<div><div id="search" class="container-inline">
  <div class="form-item" id="edit-search-theme-form-1-wrapper">
 <label for="edit-search-theme-form-1">Search this site: </label>
 <input type="text" maxlength="128" name="search_theme_form" id="edit-search-theme-form-1" size="15" value="" title="Enter the terms you wish to search for." class="form-text" />
</div>
<input type="submit" name="op" id="edit-submit" value="Search"  class="form-submit" />
<input type="hidden" name="form_build_id" id="form-c1597103dca63c6571c31e43119ce040" value="form-c1597103dca63c6571c31e43119ce040"  />
<input type="hidden" name="form_id" id="edit-search-theme-form" value="search_theme_form"  />
</div>

</div></form>
									</div> <!-- /#search-box -->

          

          
          
          <div id="block-menu-primary-links" class="block block-menu region-odd even region-count-1 count-2">
	
	<div class="block-inner">

  
 <div class="content">
    <ul class="menu"><li id="home" class="leaf first"><div class="left"></div><div class="right"></div><a href="/" title="">Home</a></li>

<li id="join" class="collapsed"><div class="left"></div><div class="right"></div><a href="/node/2" title="">Join &amp; Engage</a></li>
<li id="collections" class="expanded active-trail"><div class="left"></div><div class="right"></div><?php print caNavLink($this->request, _t('Moving Images'), 'active', '', '', ''); ?>
<ul class="menu">
<?php
	# --- get the section to highlight nav
	$vs_section = "";
	switch($this->request->getController()){
		case "About":
		case "Browse":
			$vs_section = $this->request->getAction();
		break;
		# ----------------
		default:
			$vs_section = $this->request->getController();
		break;
		# ----------------
	}
?>
	<li class="leaf first <?php print ($vs_section == "Front") ? "active-trail" : ""; ?>"><?php print caNavLink($this->request, _t('Overview'), ($vs_section == "front") ? "active" : "", '', '', ''); ?></li>
	<li class="leaf <?php print ($vs_section == "Collections") ? "active-trail" : ""; ?>"><?php print caNavLink($this->request, _t('Collections'), ($vs_section == "Collections") ? "active" : "", '', 'Browse', 'Collections'); ?></li>
	<li class="leaf <?php print (in_array($vs_section, array("FeaturedCollections", "FeaturedCollectionsList"))) ? "active-trail" : ""; ?>"><?php print caNavLink($this->request, _t('Highlighted Films'), (in_array($vs_section, array("FeaturedCollections", "FeaturedCollectionsList"))) ? "active" : "", '', 'About', 'FeaturedCollections'); ?></li>
	<li class="leaf"><a href="/node/26" title="">Archival Moments</a></li>
	<li class="collapsed"><a href="/content/exhibits" title="">Exhibits</a></li>

	<li class="leaf"><a href="/node/13" title="" class="">Donate Film or Equipment</a></li>
	<li class="leaf"><a href="/node/23" title="">Collecting Policy</a></li>
	<li class="leaf"><a href="/content/stock-footage-or-research-request-form" title="">Request Footage or Research</a></li>
<?php
	if($vs_section != "Front"){
?>
	<li class="leaf last">
		<div id="navSearch"><form name="hp_search2" action="<?php print caNavUrl($this->request, '', 'Search', 'Occurrences'); ?>" method="get">
			Search Works: <input type="text" name="search" value="<?php print $vs_last_search; ?>" autocomplete="off" size="100"/><input type="submit" name="op" id="edit-submit" value="GO"  class="form-submit" /> <span class="searchHelpLink"><?php print caGetThemeGraphic($this->request, 'b_info.gif'); ?><div class="searchHelp"><div class="searchHelpTitle">Search Tips</div><b>Boolean combination:</b> Search expressions can be combined using the standard boolean "AND" and "OR" operators.<br/><br/><b>Exact phase matching:</b> Surround a search term in quotes to find exact matches.<br/><br/><b>Wildcard matching:</b> Use an asterisk (*) as a wildcard character to match any text. Wildcards may only be used at the end of a word, to match words that start your search term.</div></span>
	</form></div><!-- end hpSearch --></li>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			$(function () {
			  $('[data-toggle="popover"]').popover({
				trigger: 'hover',
				title: ''
			  })
			})
		
		});
	</script>

<?php
	}
?>
</ul></li>
<li id="studycenter" class="collapsed"><div class="left"></div><div class="right"></div><a href="/node/4" title="">Study Center</a></li>
<li id="services" class="collapsed"><div class="left"></div><div class="right"></div><a href="/node/5" title="">Services</a></li>

<li id="store" class="leaf"><div class="left"></div><div class="right"></div><a href="http://oldfilm.org/store/" title="">Store</a></li>
<li id="alamo" class="collapsed"><div class="left"></div><div class="right"></div><a href="/node/7" title="">Alamo Theatre</a></li>
<li id="about" class="collapsed last"><div class="left"></div><div class="right"></div><a href="/node/8" title="">About Us</a></li>
</ul>  </div>


  
</div></div> <!-- /block-inner, /block -->
</div></div> <!-- /#navbar-inner, /#navbar -->
<?php
	if(!in_array(strtolower($this->request->getController()), array("browse", "detail", "search", "multisearch"))){
?>

<div id="sidebar-left"><div id="sidebar-left-inner" class="region region-left">
	<div id="block-menu-menu-interior-callouts" class="block block-menu region-odd odd region-count-1 count-3" ><div class="block-inner">
		<div class="content"><!-- from here:  -->
			<ul class="menu"><li class="leaf first"><a href="/node/14" title=""><span class='hidden'>Donate!</span></a></li>
			<li class="leaf last"><a href="/node/2" title=""><span class='hidden'>Join Us!</span></a></li>
			</ul>
		</div><!-- to here -->
	</div></div> <!-- /block-inner, /block -->
</div></div> <!-- /#sidebar-left-inner, /#sidebar-left -->

     	<div id="content"><div id="content-inner">        
        <div id="content-area">
          <div id="node-19" class="node node-type-page"><div class="node-inner">
<?php
	}
?>
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>