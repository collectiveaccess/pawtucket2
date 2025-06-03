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

	
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Mono:wght@300;400&display=swap" rel="stylesheet">
</head> 

<body class='<?php print (strtoLower($this->request->getController()) == "front") ? "frontContainer" : ""; ?>'>
	<div id="skipNavigation"><a href="#main">Skip to main content</a></div>
	<nav class="navbar navbar-default yamm" role="navigation">
		<div class="container menuBar"><div class="navBarBorder">
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
				print "<a href='https://www.vivomediaarts.com/' class='navbar-brand'>".caGetThemeGraphic($this->request, 'vivoLogo.png', array("alt" => $this->request->config->get("app_display_name"), "role" => "banner"))."</a>";
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
				<form class="navbar-form navbar-left" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" aria-label="<?php print _t("Search"); ?>">
					<input type="text" class="form-control" id="headerSearchInput" placeholder="<?php print _t("Search the Archive"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search text"); ?>" />
					<button type="submit" class="btn-search" id="headerSearchButton">Search</span></button>
					
					<!--<div class="headerAdvancedSearch"><?php print caNavLink($this->request, _t("Advanced search"), "", "", "Search", "advanced/objects"); ?></div>-->
				</form>
				<script type="text/javascript">
					$(document).ready(function(){
						$('#headerSearchButton').prop('disabled',true);
						$('#headerSearchInput').on('keyup', function(){
							$('#headerSearchButton').prop('disabled', this.value == "" ? true : false);     
						})
					});
				</script>
				<ul class="nav navbar-nav navbar-left menuItems" role="list" aria-label="<?php print _t("Primary Navigation"); ?>">
					<li class="subTitle"><?php print caNavLink($this->request, _t("Archive"), "", "", "", ""); ?></li>
					
					<?php print $this->render("pageFormat/browseMenu.php"); ?>	
					<li <?php print ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Collections"), "", "", "Collections", "index"); ?></li>
					<li <?php print ($this->request->getController() == "Activations") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Activations"), "", "", "Activations", "Index"); ?></li>
					<li <?php print ($this->request->getController() == "VideoOut") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Video Out"), "", "", "VideoOut", "Index"); ?></li>
					<li <?php print ($this->request->getController() == "About") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About"), "", "", "About", "Index"); ?></li>
<?php
	if ($vb_has_user_links) {
?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php print ($this->request->isLoggedIn()) ? "Lightbox" : "Login"; ?></a>
						<ul class="dropdown-menu" role="list"><?php print join("\n", $va_user_links); ?></ul>
					</li>
<?php
	}
?>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div></div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div role="main" id="main"><div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
<?php
		$vs_contactType = $this->request->getParameter("contactType", pString);
		if((in_array($this->request->getAction(), array("videooutartists", "videoout"))) || (in_array($this->request->getController(), array("About", "VideoOut", "VideoOutAbout", "VideoOutSubmit", "VideoOutNews"))) || (($this->request->getController() == "Contact") && (in_array($vs_contactType, array("ResearchRequest", "Reproduction", "RentalPurchase"))))){
?>
			<div class="row">
				<div class='col-sm-3'>
<?php
				if(($this->request->getController() == "About") || (($this->request->getController() == "Contact") && (in_array($vs_contactType, array("ResearchRequest", "Reproduction"))))){
?>
					<ul class="sectionSubNav">
						<li><?php print caNavLink($this->request, "About", "", "", "About", "Index"); ?></li>
						<li><?php print caNavLink($this->request, "How to Use this Site", "", "", "About", "Guide"); ?></li>
						<li><?php print caNavLink($this->request, "Research Requests", "", "", "Contact", "Form", array("contactType" => "ResearchRequest")); ?></li>
						<li><?php print caNavLink($this->request, "Reproduction Requests", "", "", "Contact", "Form", array("contactType" => "Reproduction")); ?></li>
						<li><?php print caNavLink($this->request, "Rights & Reproduction", "", "", "About", "RightsReproduction"); ?></li>
						<li><?php print caNavLink($this->request, "Policies", "", "", "About", "Policies"); ?></li>
						<li><?php print caNavLink($this->request, "Donating to the Archive", "", "", "About", "Donate"); ?></li>
					</ul>
<?php
				}elseif((in_array($this->request->getAction(), array("videooutartists", "videoout"))) || in_array($this->request->getController(), array("VideoOut", "VideoOutAbout", "VideoOutSubmit", "VideoOutNews")) || (($this->request->getController() == "Contact") && (in_array($vs_contactType, array("RentalPurchase"))))){
?>
					<ul class="sectionSubNav">
						<li><?php print caNavLink($this->request, "Video Out", "", "", "VideoOut", "Index"); ?></li>
						<li><?php print caNavLink($this->request, "Artists", "", "", "Browse", "videooutartists"); ?></li>
						<li><?php print caNavLink($this->request, "Browse Videos", "", "", "Browse", "videoout"); ?></li>
						<li><?php print caNavLink($this->request, "About Video Out", "", "", "VideoOutAbout", ""); ?></li>
						<li><?php print caNavLink($this->request, "Rental & Purchase", "", "", "Contact", "Form", array("contactType" => "RentalPurchase")); ?></li>
						<li><?php print caNavLink($this->request, "Submit for Distribution", "", "", "VideoOutSubmit", ""); ?></li>
						<li><?php print caNavLink($this->request, "News & Projects", "", "", "VideoOutNews", ""); ?></li>
					</ul>
<?php				
				}
?>
				</div>
				<div class='col-sm-9'>
<?php
		}
?>
