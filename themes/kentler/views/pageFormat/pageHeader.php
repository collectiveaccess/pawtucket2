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
		if (!$this->request->config->get('dont_allow_registration_and_login') || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get('dont_allow_registration_and_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);
	# --- hide user links - we have benefit patrons login to site, but this is done through a direct link to login page
	$vb_has_user_links = false;
?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,300,700,800,300italic,400italic,600italic,700italic,800italic' rel='stylesheet' type='text/css'>
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
		<div class="container">
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
				print caNavLink($this->request, "<div class='line1'>"._t("Kentler")."</div><div class='line2'>"._t("International")."</div><div class='line3'>"._t("Drawing Space")."</div>", "navbar-brand", "", "","");
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
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search redText"></span></button>
					</div>
				</form>
				<ul class="nav navbar-nav navbar-right">
					<li class='dropdown' style='position:relative;'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>Exhibitions <span class='caret'></span></a>
						<ul class='dropdown-menu'> 
							<li><?php print caNavLink($this->request, _t("Current/Upcoming"), "", "", "Listing", "upcoming_exhibitions"); ?></li>
							<li><?php print caNavLink($this->request, _t("Past"), "", "", "Listing", "past_exhibitions"); ?></li>
							<li><a href="/news/index.php/proposals">Proposals</a></li>
						</ul>
					</li>
					<li class='dropdown' style='position:relative;'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>Flatfiles <span class='caret'></span></a>
						<ul class='dropdown-menu'> 
							<li><?php print caNavLink($this->request, _t("Flatfiles Digital Archive"), "", "", "Listing", "flatfileArtists"); ?></li>
							<li><?php print caNavLink($this->request, _t("Browse Flatfile Artworks"), "", "", "Browse", "objects"); ?></li>
							<li><a href="/news/index.php/traveling-shows">Traveling Shows</a></li>
							<li><a href="/news/index.php/red-hook">Red Hook Archives</a></li>
							<li><a href="/news/index.php/visit">Visit the Flatfiles</a></li>
							<li><a href="/news/index.php/proposals">Proposals</a></li>
						</ul>					
					</li>
					<li class='dropdown' style='position:relative;'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>Education <span class='caret'></span></a>
						<ul class='dropdown-menu'> 
							<li><a href="/news/index.php/about-kids">About K.I.D.S. Art Education</a></li>
							<li><a href="/news/index.php/youth-programs">Youth Programs</a></li>
							<li><a href="/news/index.php/family-programs">Family Programs</a></li>
							<li><a href="/news/index.php/adult-programs">Adult Programs</a></li>
							<li><a href="http://kidsarteducation.blogspot.com/" target="_blank">K.I.D.S. Art Education Blog</a></li>
						</ul>					
					</li>
					<li><li class='dropdown' style='position:relative;'><?php print caNavLink($this->request, _t("Events"), "", "", "Listing", "events"); ?></li>
					<!--<li class='dropdown' style='position:relative;'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>Events <span class='caret'></span></a>
						<ul class='dropdown-menu'>
							<li><a href="#">Upcoming</a></li>
							<li><a href="#">Past</a></li>
						</ul>				
					</li>	-->															
					<li class='dropdown' style='position:relative;'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>About <span class='caret'></span></a>
						<ul class='dropdown-menu'> 
							<li><a href="/news/index.php/mission">Mission & History</a></li>
							<li><a href="/news/index.php/staff">Staff & Boards</a></li>
							<li><a href="/news/index.php/press">Press</a></li>
							<li><a href="/news/index.php/contact">Contact Us</a></li>
							<li><a href="/news/index.php/visit-us">Visit</a></li>
						</ul>					
					</li>
					<li class='dropdown' style='position:relative;'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>Support <span class='caret'></span></a>
						<ul class='dropdown-menu'> 
							<li><a href="/news/index.php/donate">Donate</a></li>
							<li><a href="/news/index.php/volunteer">Volunteer</a></li>
							<li><a href="/news/index.php/supporters">Supporters</a></li> 
							<li><a href="/news/index.php/benefit">Benefit</a></li>
						</ul>					
					</li>					
					<?php #print $this->render("pageFormat/browseMenu.php"); ?>	
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
<?php
	if(strtolower($this->request->getController()) != "front"){
?>
		<div class="container"><div class="row"><div class="col-xs-12">
<?php	
	}
?>
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
