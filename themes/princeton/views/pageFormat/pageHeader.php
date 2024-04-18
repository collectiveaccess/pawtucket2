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
	if(!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && $this->request->isLoggedIn()){
		$va_user_links[] = '<li role="presentation" class="dropdown-header" role="none">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
		$va_user_links[] = '<li class="divider nav-divider" role="none"></li>';
		if(caDisplayLightbox($this->request)){
			$va_user_links[] = "<li role='none'>".caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array(), array("role" => "menuitem"))."</li>";
		}
		if(caDisplayClassroom($this->request)){
			$va_user_links[] = "<li role='none'>".caNavLink($this->request, $vs_classroom_sectionHeading, '', '', 'Classroom', 'Index', array(), array("role" => "menuitem"))."</li>";
		}
		$va_user_links[] = "<li role='none'>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array(), array("role" => "menuitem"))."</li>";
		
		if ($this->request->config->get('use_submission_interface')) {
			$va_user_links[] = "<li role='none'>".caNavLink($this->request, _t('Submit content'), '', '', 'Contribute', 'List', array(), array("role" => "menuitem"))."</li>";
		}
		$va_user_links[] = "<li role='none'>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array(), array("role" => "menuitem"))."</li>";
	} else {	
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li role='none'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' role='menuitem'>"._t("Login")."</a></li>"; }
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) { $va_user_links[] = "<li role='none'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' role='menuitem'>"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);
	$va_access_values = caGetUserAccessValues($this->request);

?><!DOCTYPE html>
<html lang="en" <?php print ((strtoLower($this->request->getController()) == "front")) ? "class='frontContainer'" : ""; ?>>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	
	<meta property="og:url" content="<?php print $this->request->config->get("site_host").caNavUrl($this->request, "*", "*", "*"); ?>" >
	<meta property="og:type" content="website" >
<?php
	if(!in_array(strToLower($this->request->getAction), array("objects"))){
		# --- this is set on detail page
?>
	<meta property="og:description" content="<?php print htmlspecialchars((MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name")); ?>" >
	<meta property="og:title" content="<?php print $this->request->config->get("app_display_name"); ?>" >
<?php
	}
?>	

	
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script>
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

<body class='<?php print (strtoLower($this->request->getController()) == "front") ? "frontContainer" : ""; ?>'>
	<div id="skipNavigation"><a href="#main">Skip to main content</a></div>
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
				print "<div class='departmentLogo'><a href='https://visualresources.princeton.edu/' target='_blank'>".caGetThemeGraphic($this->request, 'VR_LOGO.png', array("alt" => "Department of Art & Archaeology", "role" => "banner"))."</a></div>";
				print caNavLink($this->request, "Visual Resources Collections", "navbar-brand", "", "","");
?>
			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
<?php
	if ($vb_has_user_links) {
?>
			<div class="collapse navbar-collapse" id="user-navbar-toggle">
				<ul class="nav navbar-nav" role="menu" aria-label="<?php print _t("Mobile User Navigation"); ?>">
					<?php print join("\n", $va_user_links); ?>
				</ul>
			</div>
<?php
	}
?>
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
<?php
	if ($vb_has_user_links) {
?>
				<ul class="nav navbar-nav navbar-right" id="user-navbar" role="list" aria-label="<?php print _t("User Navigation"); ?>">
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown" role="button" aria-label="<?php print _t("User options"); ?>"><span class="glyphicon glyphicon-user"></span></a>
						<ul class="dropdown-menu" role="menu"><?php print join("\n", $va_user_links); ?></ul>
					</li>
				</ul>
<?php
	}
?>
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" aria-label="<?php print _t("Search"); ?>">
					<div class="formOutline">
						<div class="form-group">
							<label for="headerSearchInput" class="sr-only">Search</label>
							<input type="text" class="form-control" id="headerSearchInput" placeholder="<?php print _t("Search"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search text"); ?>" >
						</div>
						<button type="submit" class="btn-search" id="headerSearchButton" aria-label="<?php print _t("Submit"); ?>"><span class="glyphicon glyphicon-search"></span></button>
					</div>
					<div class="headerAdvancedSearch"><?php print caNavLink($this->request, _t("Advanced search"), "", "", "Search", "advanced/objects"); ?></div>
				</form>
				<script>
					$(document).ready(function(){
						$('#headerSearchButton').prop('disabled',true);
						$('#headerSearchInput').on('keyup', function(){
							$('#headerSearchButton').prop('disabled', this.value == "" ? true : false);     
						})
					});
				</script>
				<ul class="nav navbar-nav navbar-right menuItems" role="menu" aria-label="<?php print _t("Primary Navigation"); ?>">
					<li <?php print ($this->request->getController() == "About") ? 'class="active"' : ''; ?> role="none"><?php print caNavLink($this->request, _t("About"), "", "", "About", "index", null, array("role" => "menuitem")); ?></li>					
					<li <?php print ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?> role="none"><?php print caNavLink($this->request, _t("Collections"), "", "", "Collections", "index", null, array("role" => "menuitem")); ?></li>					
					<li class="dropdown-container<?php print ((strToLower($this->request->getController()) == "explore")) ? ' active' : ''; ?>" role="none">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="menuitem" aria-haspopup="true">Explore <i class='fa fa-chevron-down' aria-hidden='true'></i></a>
						<ul class="dropdown-menu" role="menu">
							<li role="none"><?php print caNavLink($this->request, _t("Places"), "", "", "Explore", "places", null, array("role" => "menuitem")); ?></li>
							<li role="none"><?php print caNavLink($this->request, _t("People"), "", "", "Browse", "people", null, array("role" => "menuitem")); ?></li>
							<li role="none"><?php print caNavLink($this->request, _t("Types"), "", "", "Explore", "types", null, array("role" => "menuitem")); ?></li>
							<li role="none"><?php print caNavLink($this->request, _t("Works"), "", "", "Browse", "works", null, array("role" => "menuitem")); ?></li>
						</ul>
					</li>
					<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?> role="none"><?php print caNavLink($this->request, _t("Gallery"), "", "", "Gallery", "Index", null, array("role" => "menuitem")); ?></li>
					<li <?php print ($this->request->getController() == "Contact") ? 'class="active"' : ''; ?> role="none"><?php print caNavLink($this->request, _t("Contact"), "", "", "Contact", "form", null, array("role" => "menuitem")); ?></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div role="main" id="main"><div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
