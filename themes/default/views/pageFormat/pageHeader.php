<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2022 Whirl-i-Gig
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
$lightboxDisplayName = caGetLightboxDisplayName();
$lightbox_sectionHeading = ucFirst($lightboxDisplayName["section_heading"]);

# Collect the user links: they are output twice, once for toggle menu and once for nav
$user_links = array();
if($this->request->isLoggedIn()){
	$user_links[] = '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
	$user_links[] = '<li class="divider nav-divider"></li>';
	if(caDisplayLightbox($this->request)){
		$user_links[] = "<li>".caNavLink($this->request, $lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
	}
	$user_links[] = "<li>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
	
	if ($this->request->config->get('use_submission_interface')) {
		$user_links[] = "<li>".caNavLink($this->request, _t('Submit content'), '', '', 'Contribute', 'List', array())."</li>";
	}
	$user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
} else {	
	if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
	if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) { $user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
}
$has_user_links = (sizeof($user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?= MetaTagManager::getHTML(); ?>
	<?= AssetLoadManager::getLoadHTML($this->request); ?>

	<link rel="stylesheet" href="http://pawtucket2/themes/default/assets/pawtucket/css/fonts.css" type="text/css" media="all">	
	<link rel="stylesheet" href="http://pawtucket2/themes/default/assets/pawtucket/css/main.css" type="text/css" media="all">


	<title><?= (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
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
	<div id="skipNavigation"><a href="#main">Skip to main content</a></div>
	<!-- <nav class="navbar navbar-default yamm" role="navigation"> -->
		<div class="container menuBar">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
<?php
	if ($has_user_links) {
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
				print caNavLink($this->request, caGetMenuBarLogo(), "navbar-brand", "", "","");
?>
			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
<?php
	if ($has_user_links) {
?>
			<div class="collapse navbar-collapse" id="user-navbar-toggle">
				<ul class="nav navbar-nav" role="list" aria-label="<?= _t("Mobile User Navigation"); ?>">
					<?= join("\n", $user_links); ?>
				</ul>
			</div>
<?php
	}
?>
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
<?php
	if ($has_user_links) {
?>
				<ul class="nav navbar-nav navbar-right" id="user-navbar" role="list" aria-label="<?= _t("User Navigation"); ?>">
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user" aria-label="<?= _t("User options"); ?>"></span></a>
						<ul class="dropdown-menu" role="list"><?= join("\n", $user_links); ?></ul>
					</li>
				</ul>
<?php
	}
?>
				<form class="navbar-form navbar-right" role="search" action="<?= caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" aria-label="<?= _t("Search"); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" id="headerSearchInput" placeholder="Search" name="search" autocomplete="off" aria-label="<?= _t("Search text"); ?>" />
						</div>
						<button type="submit" class="btn-search" id="headerSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?= _t("Submit"); ?>"></span></button>
					</div>
				</form>
				<script type="text/javascript">
					$(document).ready(function(){
						$('#headerSearchButton').prop('disabled',true);
						$('#headerSearchInput').on('keyup', function(){
							$('#headerSearchButton').prop('disabled', this.value == "" ? true : false);     
						})
					});
				</script>
				<ul class="nav navbar-nav navbar-right menuItems" role="list" aria-label="<?= _t("Primary Navigation"); ?>">
					<li <?= ($this->request->getController() == "About") ? 'class="active"' : ''; ?>><?= caNavLink($this->request, _t("About"), "", "", "About", "Index"); ?></li>
					<?= $this->render("pageFormat/browseMenu.php"); ?>	
					<li <?= (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active"' : ''; ?>><?= caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/objects"); ?></li>
					<li <?= ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?= caNavLink($this->request, _t("Gallery"), "", "", "Gallery", "Index"); ?></li>
					<li <?= ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>><?= caNavLink($this->request, _t("Collections"), "", "", "Collections", "index"); ?></li>					
					<li <?= ($this->request->getController() == "Contact") ? 'class="active"' : ''; ?>><?= caNavLink($this->request, _t("Contact"), "", "", "Contact", "Form"); ?></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div role="main" id="main"><div id="pageArea" <?= caGetPageCSSClasses(); ?>>
