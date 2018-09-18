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
		$va_user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
    <link rel="stylesheet" href="https://www.osu.edu/assets/fonts/webfonts.css">
	<!-- Mobile Specific Metas ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- OSU Navbar CSS. Pick your flavor ================================================== -->
	<link rel="stylesheet" href="<?php print __CA_THEME_URL__."/assets/pawtucket/css/osu_navbar-resp.css" ?>">
	<!-- Favicons ================================================== -->
 	<link rel="shortcut icon" href="<?php print __CA_THEME_URL__."/assets/pawtucket/graphics/navbar/favicon.ico" ?>">
 	<link rel="apple-touch-icon" href="<?php print __CA_THEME_URL__."/assets/pawtucket/graphics/navbar/apple-touch-icon.png" ?>">

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
<body>
	<div role="navigation" id="osu_navbar" aria-labelledby="osu_navbar_heading">
    
		<h2 id="osu_navbar_heading" class="osu-semantic">Ohio State nav bar</h2>
		<a href="#page-content" id="skip" class="osu-semantic">Skip to main content</a>
	
		<div class="container">
			<div class="univ_info">
				<p class="univ_name"><a href="https://osu.edu" title="The Ohio State University">The Ohio State University</a></p>
			</div><!-- /univ_info -->
			<div class="univ_links">
				<div class="links">
					<ul>
						<li><a href="https://www.osu.edu/help.php" class="help">Help</a></li>
						<li><a href="https://buckeyelink.osu.edu/" class="buckeyelink" >BuckeyeLink</a></li>
						<li><a href="https://www.osu.edu/map/" class="map">Map</a></li>
						<li><a href="https://www.osu.edu/findpeople.php" class="findpeople">Find People</a></li>
						<li><a href="https://email.osu.edu/" class="webmail">Webmail</a></li> 
						<li><a href="https://www.osu.edu/search/" class="search">Search Ohio State</a></li>
					</ul>
				</div><!-- /links -->
			</div><!-- /univ_links -->
		</div><!-- /container -->

	</div><!-- /osu_navbar -->
	<nav class="navbar navbar-default yamm" role="navigation">
		<div class="container menuBar">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
<?php
	if ($vb_has_user_links) {
?>
				<button type="button" class="navbar-toggle navbar-toggle-user" data-toggle="collapse" data-target="#user-navbar-toggle">
					<span class="sr-only">User Options</span>
					<span class="glyphicon glyphicon-user"></span>
				</button>
				<button type="button" class="navbar-toggle navbar-toggle-user" data-toggle="collapse" data-target="#search-navbar-toggle">
					<span class="sr-only">Search</span>
					<span class="glyphicon glyphicon-search"></span>
				</button>
<?php
	}
?>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
<?php
				print caNavLink($this->request, '<span class="vrlLogo"><span class="vrlTop">VISUAL</span> <span class="vrlBottom">RESOURCES LIBRARY</span></span>', "vrlLogoLink", "", "","");
				print caNavLink($this->request, '<span class="vrlAltLogo">VRL</span>', "vrlLogoLink", "", "","");
?>
			</div>
<?php
	if ($vb_has_user_links) {
?>
			<div class="collapse navbar-collapse" id="user-navbar-toggle">
				<ul class="nav navbar-nav">
					<?php print join("\n", $va_user_links); ?>
				</ul>
			</div>
			<div class="collapse navbar-collapse" id="search-navbar-toggle">
				<ul class="nav navbar-nav">
					<li>
                        <form id="dropdown-search" class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>">
                            <div class="formOutline">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search" name="search">
                                </div>
                                <button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
                            </div>
            
                        </form>
                    </li>
				</ul>
			</div>
<?php
	}
?>
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
<?php
	if ($vb_has_user_links) {
?>
				<ul class="nav navbar-nav navbar-right" id="user-navbar">
				    <li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-search"></span></a>
						<ul class="dropdown-menu">
						    <li>
						        <form id="dropdown-search" class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>">
                                    <div class="formOutline">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Search" name="search">
                                        </div>
                                        <button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
                                    </div>
                    
                                </form>
                            </li>
                        </ul>
					</li>
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span></a>
						<ul class="dropdown-menu"><?php print join("\n", $va_user_links); ?></ul>
					</li>
					
				</ul>
<?php
	}
?>
                <!--<button type="button" class="navbar-toggle navbar-toggle-search" data-toggle="collapse" data-target="#search-navbar-toggle">
					<span class="sr-only">Search</span>
					<span class="glyphicon glyphicon-search"></span>
				</button>-->
				<!--<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="search">
						</div>
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
					
				</form>-->
				<ul class="nav navbar-nav navbar-right menuItems">
					<li <?php print ($this->request->getController() == "About") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About"), "", "", "About", ""); ?></li>
					<li <?php print ($this->request->getController() == "Browse") && strpos($this->request->getFullUrlPath(), 'objects') ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Browse"), "", "", "Browse", "objects/view/images"); ?></li>
					
					<li <?php print ($this->request->getController() == "Gallery") && strpos($this->request->getFullUrlPath(), 'Gallery') ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Special Collections"), "", "", "Gallery", "Index"); ?></li>
					<li <?php print ($this->request->getController() == "Contact") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contact"), "", "", "Contact", "Form"); ?></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
