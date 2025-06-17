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
		#$va_user_links[] = '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
		#$va_user_links[] = '<li class="divider nav-divider"></li>';
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
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Lightbox")."</a></li>"; }
		#if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);
	$va_access_values = caGetUserAccessValues($this->request);

?><!DOCTYPE html>
<html lang="en">
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
	<!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather%3A300%2C400%2C700%2C900%2C300i%2C400i%2C700i%2C900i%7CRubik%3A300%2C400%2C500%2C600%2C700%2C800%2C900%2C300i%2C400i%2C500i%2C600i%2C700i%2C800i%2C900i&amp;display=swap&amp;subset=all&amp;ver=3.0.20" media="all">-->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Rubik:wght@300;350;400&display=swap" rel="stylesheet">
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>

</head> 

<body class='initial'>
	<div id="skipNavigation"><a href="#main">Skip to main content</a></div>
	<nav class="navbar navbar-default yamm" role="navigation">
		<div class="menuBar">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="https://www.uag.pitt.edu/" class="navbar-brand"><?php print caGetThemeGraphic($this->request, 'university_pittsburgh_university_art_gallery_white_logo.png', array("alt" => "University Art Gallery", "role" => "banner")); ?></a>

			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->

			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">				
				<ul class="nav navbar-nav navbar-right menuItems" role="list" aria-label="<?php print _t("Primary Navigation"); ?>">
					<li class="menuClose"><a href="#" class="menuCloseLink" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1"><?php print caGetThemeGraphic($this->request, 'close.png', array("alt" => "claose")); ?></a></li>
					<li class="dropdown" style="position:relative;"><a href="#" class="ddChevron"><span class="ticon ticon-angle-down wpex-transition-all wpex-duration-300" aria-hidden="true"></span></a><a href="https://www.uag.pitt.edu/about-the-uag" class="dropdown-toggle mainhead top">About the UAG</a>
						<ul class="dropdown-menu">
							<li><a href="https://www.uag.pitt.edu/about-the-uag/history-and-building">History and Building</a></li>
							<li><a href="https://www.uag.pitt.edu/about-the-uag/people">People</a></li>
							<li><a href="https://www.uag.pitt.edu/about-the-uag/diversity-accessibility">Diversity and Accessibility</a></li>
							<li><a href="https://www.uag.pitt.edu/about-the-uag/visit">Visit</a></li>
						</ul>	
					</li>
					<li class="dropdown<?php print (strToLower($this->request->getController()) == "gallery") ? " current" : ""; ?>" style="position:relative;"><a href="#" class="ddChevron"><span class="ticon ticon-angle-down wpex-transition-all wpex-duration-300" aria-hidden="true"></span></a><a href="https://www.uag.pitt.edu/exhibitions" class="dropdown-toggle mainhead top">Exhibitions</a>
						<ul class="dropdown-menu">
							<li><a href="https://www.uag.pitt.edu/exhibitions/current">Current Exhibitions</a></li>
							<li><a href="https://www.uag.pitt.edu/exhibitions/future">Future Exhibitions</a></li>
							<li><a href="https://www.uag.pitt.edu/exhibitions/past">Past Exhibitions</a></li>
							<li><a href="https://www.uag.pitt.edu/exhibitions/online">Online Exhibitions</a></li>
						</ul>	
					</li>
					<li class="dropdown" style="position:relative;"><a href="#" class="ddChevron"><span class="ticon ticon-angle-down wpex-transition-all wpex-duration-300" aria-hidden="true"></span></a><a href="https://www.uag.pitt.edu/events" class="dropdown-toggle mainhead top">Events</a>
						<ul class="dropdown-menu">
							<li><a href="https://uag.pitt.edu/events/#upcoming-events">Upcoming Events</a></li>
							<li><a href="https://uag.pitt.edu/events/#past-events">Past Events</a></li>
						</ul>	
					</li>
					<li class="dropdown<?php print (strToLower($this->request->getController()) != "gallery") ? " current" : ""; ?>" style="position:relative;"><?php print caNavLink($this->request, "Collections", "dropdown-toggle mainhead top", "", "", ""); ?></li>
					<li><a href="https://www.uag.pitt.edu/academic-programs">Academic Programs</a></li>
					<li><a href="https://www.uag.pitt.edu/look-listen-read">Look, Listen & Read</a></li>
					<li class="dropdown hideMobile" style="position:relative;"><a href="#" class="dropdown-toggle mainhead top searchicon" data-toggle="dropdown"><span class="wpex-menu-search-icon ticon ticon-search" aria-hidden="true"></span></a>
						<ul class="dropdown-menu searchformPITT">
							<li><form method="get" action="https://www.uag.pitt.edu/">
									<label>
										<span class="screen-reader-text">Search</span>
										<input type="search" class="field" name="s" placeholder="Search" autocomplete="off">
									</label>
									<button type="submit" class="searchform-submit"><span class="ticon ticon-search" aria-hidden="true"></span><span class="screen-reader-text">Submit</span></button>
								</form>
							</li>
						</ul>	
					</li>
					<li class="showMobile searchformPITTMobile">
						<form method="get" action="https://www.uag.pitt.edu/">
							<button type="submit" class="searchform-submit"><span class="ticon ticon-search" aria-hidden="true"></span><span class="screen-reader-text">Submit</span></button>
							<label>
								<span class="screen-reader-text">Search</span>
								<input type="search" class="field" name="s" placeholder="Search" autocomplete="off">
							</label>
						</form>	
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
<script type="text/javascript">
	$(document).ready(function(){
//		$(".dropdown").hover(function(){
//			var dropdownMenu = $(this).children(".dropdown-menu");
//			if(dropdownMenu.is(":visible")){
//				dropdownMenu.parent().toggleClass("open");
//			}
//		});
		$('.ddChevron').click(function(e) {
		   e.preventDefault();
		   $(this).parent().children("ul.dropdown-menu").slideToggle();
		   $(this).toggleClass("rotate");
		});
	});     
</script>
<?php
		switch(strToLower($this->request->getController())){
			case "gallery":
				if(strToLower($this->request->getAction()) == "index"){
					print '<div class="heroExhibitions"></div>';
				}
			break;
			# ---------------------------
			case "front":
				print '<div class="heroCollections"></div>';
			break;
			# ---------------------------
		}
?>
	<div class="pageTitle"><div class="container"><div class="row"><div class="col-sm-12">
<?php
		if(!in_array(strToLower($this->request->getController()), array("front", "gallery"))){
?>
			<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" aria-label="<?php print _t("Search"); ?>">
				<div class="formOutline">
					<div class="form-group">
						<input type="text" class="form-control" id="headerSearchInput" placeholder="<?php print _t("Search the Collection"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search text"); ?>" />
					</div>
					<button type="submit" class="btn-search" id="headerSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit"); ?>"></span></button>
				</div>
				<div class="headerAdvancedSearch"><?php print caNavLink($this->request, _t("Advanced search"), "", "", "Search", "advanced/objects"); ?></div>
			</form>
			<script type="text/javascript">
				$(document).ready(function(){
					$('#headerSearchButton').prop('disabled',true);
					$('#headerSearchInput').on('keyup', function(){
						$('#headerSearchButton').prop('disabled', this.value == "" ? true : false);     
					})
				}); 
			</script>
<?php
		}
		switch(strToLower($this->request->getController())){
			case "gallery":
				print "Online Exhibitions";
			break;
			# ---------------------------
			default:
				print "Collections";
			break;
			# ---------------------------
		}
?>
	</div></div></div></div>
<?php
		if(strToLower($this->request->getController()) != "gallery"){
?>
		<div class="subNav">
			<div class="container"><div class="row"><div class="col-sm-12">
				
				
				<ul role="list" aria-label="<?php print _t("Secondary Navigation"); ?>">			
					<li><?php print caNavLink($this->request, "Search the Collection", "", "", "", ""); ?></li>		
					<li><?php print caNavLink($this->request, "Creators", "", "", "Browse", "creators"); ?></li>		
					<li><?php print caNavLink($this->request, "Objects", "", "", "Browse", "objects"); ?></li>
<?php
	if ($vb_has_user_links) {
?>
					<?php print join("\n", $va_user_links); ?>
<?php
	}
?>
				</ul>
			</div></div></div>	
		</div>
<?php
		}
?>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div role="main" id="main"><div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
