<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2017 Whirl-i-Gig
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
	$va_lightboxDisplayName = caGetLightboxDisplayName();
	$vs_lightbox_sectionHeading = ucFirst($va_lightboxDisplayName["section_heading"]);
	$va_classroomDisplayName = caGetClassroomDisplayName();
	$vs_classroom_sectionHeading = ucFirst($va_classroomDisplayName["section_heading"]);
	
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
		
		if ($this->request->config->get('use_submission_interface')) {
			$va_user_links[] = "<li>".caNavLink($this->request, _t('Submit content'), '', '', 'Contribute', 'List', array())."</li>";
		}
		$va_user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);
	$va_access_values = caGetUserAccessValues($this->request);

?><!DOCTYPE html>
<html lang="en" <?php print ((strtoLower($this->request->getController()) == "front")) ? "class='frontContainer'" : ""; ?>>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	
	<meta property="og:url" content="<?php print $this->request->config->get("site_host").caNavUrl($this->request, "*", "*", "*"); ?>" />
	<meta property="og:type" content="website" />
<?php
	if(!in_array(strToLower($this->request->getAction), array("objects"))){
		# --- this is set on detail page
?>
	<meta property="og:description" content="<?php print htmlspecialchars((MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name")); ?>" />
	<meta property="og:title" content="<?php print $this->request->config->get("app_display_name"); ?>" />
<?php
	}
?>	

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic|PT+Sans:regular,italic,700,700italic&amp;subset=devanagari,latin,latin-ext,cyrillic,cyrillic-ext&amp;display=swap" type="text/css" media="all">

	<?php print AssetLoadManager::getLoadHTML($this->request); ?>
	
	<?php print MetaTagManager::getHTML(); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
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

<body class='page-template-default page page-id-1353 et_button_icon_visible et_button_custom_icon et_pb_button_helper_class et_fullwidth_nav et_fullwidth_secondary_nav et_non_fixed_nav et_show_nav et_primary_nav_dropdown_animation_slide et_secondary_nav_dropdown_animation_fade et_header_style_centered et_pb_footer_columns4 et_pb_gutter osx et_pb_gutters2 et_pb_pagebuilder_layout et_smooth_scroll et_no_sidebar et_divi_theme et-db gecko <?php print (strtoLower($this->request->getController()) == "front") ? "frontContainer" : ""; ?>'>

	<div id="skipNavigation"><a href="#main">Skip to main content</a></div>
	
	
	
	
	
	
	
	
	<header id="main-header" data-height-onload="123" data-height-loaded="true" data-fixed-height-onload="123">
			<div class="container clearfix et_menu_container et_pb_menu_visible et_pb_no_animation">
							<div class="logo_container">
					<span class="logo_helper"></span>
					<a href="https://www.blackmountaincollege.org/">
						<img src="<?php print caGetThemeGraphicUrl($this->request, "LogoBlackMountainCollegeMuseumWeb2.png"); ?>" alt="Black Mountain College Museum + Arts Center" id="logo" data-height-percentage="83" data-actual-width="730" data-actual-height="100" width="730" height="100">
					</a>
				</div>
							<div id="et-top-navigation" data-height="70" data-fixed-height="40">
											<nav id="top-menu-nav">
						<ul id="top-menu" class="nav"><li id="menu-item-4164" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4164"><a title="https://www.blackmountaincollege.org/visit/" href="https://www.blackmountaincollege.org/visit/">Visit</a></li>
<li id="menu-item-4165" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4165"><a>Programs</a>
<ul class="sub-menu">
	<li id="menu-item-8987" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8987"><a href="https://www.blackmountaincollege.org/events/">Events</a></li>
	<li id="menu-item-5724" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5724"><a href="https://www.blackmountaincollege.org/performance-initiative/">Performance Initiative</a></li>
	<li id="menu-item-4239" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4239"><a href="https://www.blackmountaincollege.org/reviewing/">ReViewing Conference</a></li>
	<li id="menu-item-24381" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-24381"><a href="https://www.blackmountaincollege.org/rehappening/">{Re}HAPPENING</a></li>
	<li id="menu-item-13277" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-13277"><a href="https://www.blackmountaincollege.org/museum-from-home/">Museum from Home</a></li>
	<li id="menu-item-21770" class="menu-item menu-item-type-post_type menu-item-object-post menu-item-21770"><a href="https://www.blackmountaincollege.org/faith-in-arts/">Faith in Arts</a></li>
	<li id="menu-item-21703" class="menu-item menu-item-type-post_type menu-item-object-post menu-item-21703"><a href="https://www.blackmountaincollege.org/lake-eden-tours/">BMC Campus Tours</a></li>
</ul>
</li>
<li id="menu-item-25413" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-25413"><a href="https://www.blackmountaincollege.org/art/">Art</a>
<ul class="sub-menu">
	<li id="menu-item-4222" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4222"><a href="https://www.blackmountaincollege.org/exhibitions/">Exhibitions</a></li>
	<li id="menu-item-14658" class="menu-item menu-item-type-post_type menu-item-object-post menu-item-14658"><?php print caNavLink($this->request, "Collections", "", "", "", ""); ?></li>
</ul>
</li>
<li id="menu-item-5604" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-5604"><a>Learn</a>
<ul class="sub-menu">
	<li id="menu-item-4172" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4172"><a href="https://www.blackmountaincollege.org/about/">About Us</a></li>
	<li id="menu-item-25455" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-25455"><a href="https://www.blackmountaincollege.org/education-resources/">Education Resources</a></li>
	<li id="menu-item-5603" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5603"><a href="https://www.blackmountaincollege.org/history/">A Brief History</a></li>
	<li id="menu-item-9844" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-9844"><a rel="noopener" href="https://www.bmcbooks.com/shop/museum-publications/16" onclick="javascript:window.open('https://www.bmcbooks.com/shop/museum-publications/16', '_blank', 'noopener'); return false;">Publications</a></li>
	<li id="menu-item-9881" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-9881"><a rel="noopener" href="http://www.blackmountainstudiesjournal.org/" onclick="javascript:window.open('http://www.blackmountainstudiesjournal.org/', '_blank', 'noopener'); return false;">Journal of BMC Studies</a></li>
	<li id="menu-item-4175" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4175"><a title="https://www.blackmountaincollege.org/resources/" href="https://www.blackmountaincollege.org/resources/">Research Resources</a></li>
	<li id="menu-item-4179" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4179"><a href="https://www.blackmountaincollege.org/the-jargon-society/">Jargon Society</a></li>
</ul>
</li>
<li id="menu-item-11407" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-11407"><a>Support</a>
<ul class="sub-menu">
	<li id="menu-item-5581" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5581"><a href="https://www.blackmountaincollege.org/donate/">Give A Gift</a></li>
	<li id="menu-item-10048" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-10048"><a rel="noopener" href="https://www.bmcbooks.com/membership" onclick="javascript:window.open('https://www.bmcbooks.com/membership', '_blank', 'noopener'); return false;">Membership</a></li>
	<li id="menu-item-5582" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5582"><a href="https://www.blackmountaincollege.org/volunteer/">Volunteer + Internships</a></li>
</ul>
</li>
<li id="menu-item-4252" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4252"><a>News</a>
<ul class="sub-menu">
	<li id="menu-item-23142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-23142"><a href="https://www.blackmountaincollege.org/news-room/">News Room</a></li>
	<li id="menu-item-10848" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-10848"><a href="https://www.blackmountaincollege.org/newsletter/">Newsletter</a></li>
	<li id="menu-item-6075" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6075"><a href="https://www.blackmountaincollege.org/news/">Blog</a></li>
</ul>
</li>
<li id="menu-item-4237" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4237"><a rel="noopener" href="https://www.bmcbooks.com/" onclick="javascript:window.open('https://www.bmcbooks.com/', '_blank', 'noopener'); return false;">Store</a></li>
<li id="menu-item-4174" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4174"><a rel="noopener" href="https://www.bmcbooks.com/product/donate/396" onclick="javascript:window.open('https://www.bmcbooks.com/product/donate/396', '_blank', 'noopener'); return false;"><button id="donate">DONATE!</button></a></li>
</ul>						</nav>
					
					
					
											<div id="et_top_search">
							<span id="et_search_icon"></span>
						</div>
					
					<div id="et_mobile_nav_menu">
				<div class="mobile_nav closed">
					<span class="select_page">Select Page</span>
					<span class="mobile_menu_bar mobile_menu_bar_toggle" onClick="$('#mobile_menu').toggle(); return false;"></span>
				<ul id="mobile_menu" class="et_mobile_menu"><li id="menu-item-4164" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4164 et_first_mobile_item"><a title="https://www.blackmountaincollege.org/visit/" href="https://www.blackmountaincollege.org/visit/">Visit</a></li>
<li id="menu-item-4165" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4165"><a>Programs</a>
<ul class="sub-menu">
	<li id="menu-item-8987" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8987"><a href="https://www.blackmountaincollege.org/events/">Events</a></li>
	<li id="menu-item-5724" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5724"><a href="https://www.blackmountaincollege.org/performance-initiative/">Performance Initiative</a></li>
	<li id="menu-item-4239" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4239"><a href="https://www.blackmountaincollege.org/reviewing/">ReViewing Conference</a></li>
	<li id="menu-item-24381" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-24381"><a href="https://www.blackmountaincollege.org/rehappening/">{Re}HAPPENING</a></li>
	<li id="menu-item-13277" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-13277"><a href="https://www.blackmountaincollege.org/museum-from-home/">Museum from Home</a></li>
	<li id="menu-item-21770" class="menu-item menu-item-type-post_type menu-item-object-post menu-item-21770"><a href="https://www.blackmountaincollege.org/faith-in-arts/">Faith in Arts</a></li>
	<li id="menu-item-21703" class="menu-item menu-item-type-post_type menu-item-object-post menu-item-21703"><a href="https://www.blackmountaincollege.org/lake-eden-tours/">BMC Campus Tours</a></li>
</ul>
</li>
<li id="menu-item-25413" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-25413"><a href="https://www.blackmountaincollege.org/art/">Art</a>
<ul class="sub-menu">
	<li id="menu-item-4222" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4222"><a href="https://www.blackmountaincollege.org/exhibitions/">Exhibitions</a></li>
	<li id="menu-item-14658" class="menu-item menu-item-type-post_type menu-item-object-post menu-item-14658"><?php print caNavLink($this->request, "Collections", "", "", "", ""); ?></li>
</ul>
</li>
<li id="menu-item-5604" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-5604"><a>Learn</a>
<ul class="sub-menu">
	<li id="menu-item-4172" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4172"><a href="https://www.blackmountaincollege.org/about/">About Us</a></li>
	<li id="menu-item-25455" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-25455"><a href="https://www.blackmountaincollege.org/education-resources/">Education Resources</a></li>
	<li id="menu-item-5603" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5603"><a href="https://www.blackmountaincollege.org/history/">A Brief History</a></li>
	<li id="menu-item-9844" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-9844"><a rel="noopener" href="https://www.bmcbooks.com/shop/museum-publications/16" onclick="javascript:window.open('https://www.bmcbooks.com/shop/museum-publications/16', '_blank', 'noopener'); return false;">Publications</a></li>
	<li id="menu-item-9881" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-9881"><a rel="noopener" href="http://www.blackmountainstudiesjournal.org/" onclick="javascript:window.open('http://www.blackmountainstudiesjournal.org/', '_blank', 'noopener'); return false;">Journal of BMC Studies</a></li>
	<li id="menu-item-4175" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4175"><a title="https://www.blackmountaincollege.org/resources/" href="https://www.blackmountaincollege.org/resources/">Research Resources</a></li>
	<li id="menu-item-4179" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4179"><a href="https://www.blackmountaincollege.org/the-jargon-society/">Jargon Society</a></li>
</ul>
</li>
<li id="menu-item-11407" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-11407"><a>Support</a>
<ul class="sub-menu">
	<li id="menu-item-5581" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5581"><a href="https://www.blackmountaincollege.org/donate/">Give A Gift</a></li>
	<li id="menu-item-10048" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-10048"><a rel="noopener" href="https://www.bmcbooks.com/membership" onclick="javascript:window.open('https://www.bmcbooks.com/membership', '_blank', 'noopener'); return false;">Membership</a></li>
	<li id="menu-item-5582" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-5582"><a href="https://www.blackmountaincollege.org/volunteer/">Volunteer + Internships</a></li>
</ul>
</li>
<li id="menu-item-4252" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4252"><a>News</a>
<ul class="sub-menu">
	<li id="menu-item-23142" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-23142"><a href="https://www.blackmountaincollege.org/news-room/">News Room</a></li>
	<li id="menu-item-10848" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-10848"><a href="https://www.blackmountaincollege.org/newsletter/">Newsletter</a></li>
	<li id="menu-item-6075" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-6075"><a href="https://www.blackmountaincollege.org/news/">Blog</a></li>
</ul>
</li>
<li id="menu-item-4237" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4237"><a rel="noopener" href="https://www.bmcbooks.com/" onclick="javascript:window.open('https://www.bmcbooks.com/', '_blank', 'noopener'); return false;">Store</a></li>
<li id="menu-item-4174" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4174"><a rel="noopener" href="https://www.bmcbooks.com/product/donate/396" onclick="javascript:window.open('https://www.bmcbooks.com/product/donate/396', '_blank', 'noopener'); return false;"><button id="donate">DONATE!</button></a></li>
</ul></div>
			</div>				</div> <!-- #et-top-navigation -->
			</div> <!-- .container -->
						<div class="et_search_outer">
				<div class="container et_search_form_container et_pb_search_form_hidden et_pb_no_animation" style="height: 123px; max-width: 839.533px;">
					<form role="search" method="get" class="et-search-form" action="https://www.blackmountaincollege.org/">
					<input type="search" class="et-search-field" placeholder="Search …" value="" name="s" title="Search for:" style="font-size: 14px;">					</form>
					<span class="et_close_search_field"></span>
				</div>
			</div>
					</header>
	
	
	
<?php
		print "<div>".caNavLink($this->request, caGetThemeGraphic($this->request, 'XantiSchawinskyUntitled.jpg', array("alt" => "Xanti Schawinsky, Untitled", "role" => "banner")), "", "", "", "")."</div>";
		print "<div class='frontHeroCaption'><i>Untitled</i>, Xanti Schawinsky</div>";
?>
	
	
	<nav class="navbar navbar-default" role="navigation">
		<div class="container menuBar">
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="menuContainer">
						<form class="navbar-form" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" aria-label="<?php print _t("Search"); ?>">
							<div class="formOutline">
								<div class="form-group">
									<input type="text" class="form-control" id="headerSearchInput" placeholder="<?php print _t("Search the Collection"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search text"); ?>" />
								</div>
								<button type="submit" class="btn-search" id="headerSearchButton"><span></span></button>
							</div>
						</form>
						<ul class="nav navbar-nav navbar-right" role="list" aria-label="<?php print _t("Primary Navigation"); ?>">
							<li><?php print caNavLink($this->request, _t("Objects"), "", "", "Browse", "Objects"); ?></li>
							<li><?php print caNavLink($this->request, _t("Collections"), "", "", "Browse", "Collections"); ?></li>
							<li><?php print caNavLink($this->request, _t("People & Organizations"), "", "", "Browse", "People"); ?></li>
							<li><?php print caNavLink($this->request, _t("Programs"), "", "", "Browse", "Programs"); ?></li>
						</ul>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
							$('#headerSearchButton').prop('disabled',true);
							$('#headerSearchInput').on('keyup', function(){
								$('#headerSearchButton').prop('disabled', this.value == "" ? true : false);     
							})
						});
					</script>
				</div>
			</div>
		</div>
	</nav>
	
	
	
	
	
	
	<div class="container"><div class="row"><div class="col-xs-12">
		<div role="main" id="main"><div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
