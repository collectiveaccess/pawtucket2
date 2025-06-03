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

?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>

<!-- Google tag (gtag.js) --> <script async src=https://www.googletagmanager.com/gtag/js?id=G-SWZTWQ6YLR></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-SWZTWQ6YLR'); </script>
</head>
<body>
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
				print "<a href='https://www.washcoll.edu/people_departments/offices/miller-library/archives-special-collections/index.php' class='navbar-brand'>".caGetThemeGraphic($this->request, 'main-logo.svg', array("alt" => $this->request->config->get("app_display_name"), "role" => "banner"))."<span class='logoMiller'>".caGetThemeGraphic($this->request, 'archives.png', array("alt" => "Archives & Special Collections", "role" => "banner"))."</span></a>";

				#print caNavLink($this->request, caGetThemeGraphic($this->request, 'WC_logo_library.png', array("alt" => $this->request->config->get("app_display_name"), "role" => "banner")), "navbar-brand", "", "","");
?>
			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
<?php
	if ($vb_has_user_links) {
?>
			<div class="collapse navbar-collapse" id="user-navbar-toggle">
				<ul class="nav navbar-nav" role="list" aria-label="<?php print _t("Mobile User Navigation"); ?>">
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
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user" aria-label="<?php print _t("User options"); ?>"></span></a>
						<ul class="dropdown-menu" role="list"><?php print join("\n", $va_user_links); ?></ul>
					</li>
				</ul>
<?php
	}
?>
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" aria-label="<?php print _t("Search"); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" id="headerSearchInput" placeholder="Search" name="search" autocomplete="off" aria-label="<?php print _t("Search text"); ?>" />
						</div>
						<button type="submit" class="btn-search" id="headerSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit"); ?>"></span></button>
					</div>
					<?php print caNavLink($this->request, _t("Advanced Search"), "advancedSearchLink", "", "Search", "advanced/objects"); ?>
					
				</form>
				<script type="text/javascript">
					$(document).ready(function(){
						$('#headerSearchButton').prop('disabled',true);
						$('#headerSearchInput').on('keyup', function(){
							$('#headerSearchButton').prop('disabled', this.value == "" ? true : false);     
						})
					});
				</script>
				<ul class="nav navbar-nav navbar-right menuItems" role="list" aria-label="<?php print _t("Primary Navigation"); ?>">
					<li <?php print (strToLower($this->request->getController()) == "front") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Home"), "", "", "", ""); ?></li>
					<li <?php print ((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "objects")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Browse"), "", "", "Browse", "objects"); ?></li>
					<li <?php print ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Collections"), "", "", "Collections", "index"); ?></li>
					<li <?php print ($this->request->getController() == "Capstones") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Capstones"), "", "", "Capstones", "index"); ?></li>
					<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Gallery"), "", "", "Gallery", "Index"); ?></li>
					<li class="dropdown<?php print ($this->request->getController() == "About") ? ' active' : ''; ?>" style="position:relative;"><a href="#" class="dropdown-toggle mainhead top" data-toggle="dropdown"><?php print _t("About"); ?></a>
						<ul class="dropdown-menu">
							<li><?php print caNavLink($this->request, _t("About"), "", "", "About", "AboutUs"); ?></li>
							<li><?php print caNavLink($this->request, _t("FAQ"), "", "", "About", "FAQ"); ?></li>
						</ul>	
					</li>					
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div role="main" id="main"><div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
