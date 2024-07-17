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
		#if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])) { $va_user_links[] = "<li>".caNavLink($this->request, _t("Register"), "", "", "LoginReg", "registerForm", array())."</li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
	<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-116910619-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-116910619-1');
	</script>

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
	<nav class="navbar navbar-default navbar-fixed-top yamm" role="navigation">
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
				print caNavLink($this->request, "Indian Residential School<br/>History & Dialogue Centre<br/><b>COLLECTIONS</b>", "navbar-brand", "", "","");
?>
			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
<?php
	if ($vb_has_user_links) {
?>
			<div class="collapse navbar-collapse" id="user-navbar-toggle">
				<ul class="nav navbar-nav">
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
				<ul class="nav navbar-nav navbar-right" id="user-navbar">
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span></a>
						<ul class="dropdown-menu"><?php print join("\n", $va_user_links); ?></ul>
					</li>
				</ul>
<?php
	}
?>
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="search">
						</div>
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>
				<ul class="nav navbar-nav navbar-right menuItems">
					<li class="dropdown <?php print ($this->request->getController() == "Explore") ? ' active"' : ''; ?>" style="position:relative;">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span>Learn</span></a>
						<ul class="dropdown-menu">
							<!--<li><?php print caNavLink($this->request, "<span>"._t("Narrative Threads")."</span>", "", "", "Explore", "narrativethreads"); ?></li>-->
							<li><?php print caNavLink($this->request, "<span>"._t("BC Schools")."</span>", "", "", "Explore", "schools"); ?></li>
							<li><?php print caNavLink($this->request, "<span>"._t("Featured")."</span>", "", "", "Gallery", "Index"); ?></li>
							<li><?php print caNavLink($this->request, "<span>"._t("Map")."</span>", "", "", "Browse", "schools", array("view" => "map")); ?></li>
							<li><?php print caNavLink($this->request, "<span>"._t("Resources")."</span>", "", "", "Listing", "Resources"); ?></li>
<?php
	if($this->request->isLoggedIn() && $this->request->user->hasRole("previewDigExh")){
?>
							<li><?php print caNavLink($this->request, "<span>"._t("Exhibitions")."</span>", "", "", "Listing", "exhibitions"); ?></li>
<?php
	}
	if($this->request->isLoggedIn() && $this->request->user->hasRole("previewEduRes")){
?>
							<li><?php print caNavLink($this->request, "<span>"._t("Educational Resources")."</span>", "", "", "Explore", "EducationalResources"); ?></li>
<?php
	}
?>					
							<li><a href='/UserGuide'><span><?php print _t("User Guide"); ?></span></a></li>
						</ul>
					</li>
					<?php print $this->render("pageFormat/browseMenu.php"); ?>	
					<li class="dropdown <?php print (in_array($this->request->getController(), array("AboutCollections", "CurrentProjects", "InformationResources"))) ? ' active"' : ''; ?>" style="position:relative;">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span>About</span></a>
						<ul class="dropdown-menu">
							<li><a href='/AboutCollections' <?php print ($this->request->getController() == "AboutCollections") ? 'class="active"' : ''; ?>><span><?php print _t("About the Collections "); ?></span></a></li>
							<li><a href='/CurrentProjects' <?php print ($this->request->getController() == "CurrentProjects") ? 'class="active"' : ''; ?>><span><?php print _t("Current Projects"); ?></span></a></li>
							<li><a href='/InformationResources' <?php print ($this->request->getController() == "InformationResources") ? 'class="active"' : ''; ?>><span><?php print _t("Resources for Information Professionals"); ?></span></a></li>
						</ul>
					</li>
					
					<li <?php print ($this->request->getController() == "Contact") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, "<span>"._t("Contact")."</span>", "", "", "Contact", "Form"); ?></li>
					<li><a href="http://irshdc.ubc.ca" target="_blank"><span>Centre Home</span></a></li>
					<li class='navLinkBorder'><a href="https://irshdc.ubc.ca/for-survivors/healing-and-wellness-resources/" target="_blank"><span>Wellness & Support</span></a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
<?php
if($this->request->getParameter('confirmEnter', pInteger)){
	Session::setVar('visited_time', time());
}
if(!Session::getVar('visited_time') || (Session::getVar('visited_time') < (time() - 86400))){
?>
	<div class="disclaimerAlert">
		<div class="disclaimerAlertMessage">
			<?php print Session::getVar('visited_time'); ?>{{{content_warning}}}
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-lg-5">
						<div class="enterButton"><a href="https://irshdc.ubc.ca/for-survivors/healing-and-wellness-resources/" class="btn btn-default">Wellness Resources</a></div>
					</div>
					<div class="col-md-6 col-lg-5 col-lg-offset-2">
						<div class="enterButton"><?php print caNavLink($this->request, "Enter", "btn btn-default", "*", "*", "*", array("confirmEnter" => 1)); ?></div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 text-center rshdcLogo">
						<?php print caGetThemeGraphic($this->request, 'IRSHDC_wordmark-white.png', array("alt" => "RSHDC logo")); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
