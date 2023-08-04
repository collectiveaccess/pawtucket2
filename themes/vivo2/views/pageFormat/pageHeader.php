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
	
	# are we in a video out page or main site - 2 different nav bars
	$vs_contact_type = $this->request->getParameter("contactType", pString);
	$vb_video_out = false;
	if((in_array($this->request->getAction(), array("videooutartists", "videoout"))) || in_array($this->request->getController(), array("VideoOut", "VideoOutSubmit")) || (($this->request->getController() == "Contact") && (in_array($vs_contact_type, array("RentalPurchase"))))){
		$vb_video_out = true;
	}
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
	<style>
	@import url('https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500;1,600&display=swap');
	</style>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head> 

<body class='<?php print (strtoLower($this->request->getController()) == "front") ? "frontContainer" : ""; ?><?php print (in_array(strtoLower($this->request->getController()), array("search", "browse"))) ? " bgLightGrayBody" : ""; ?>'>
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
			if($vb_video_out){
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'VideoOutLogo.png', array("alt" => "Video Out", "role" => "banner")), "navbar-brand brandVideoOut", "", "VideoOut", "Index");
			}else{
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'ArchiveLogo.png', array("alt" => "VIVO Archive", "role" => "banner")), "navbar-brand", "", "","");
			}
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
				if($vb_video_out){
?>
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'videoout'); ?>" aria-label="<?php print _t("Search Video Out"); ?>">
					<div class="formOutline">
						<div class="form-group">
							<label for="headerSearchInput" class="sr-only">Search Video Out:</label>
							<input type="text" class="form-control" id="headerSearchInput" placeholder="<?php print _t("Search Video Out"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search text"); ?>" />
						</div><button type="submit" class="btn-search" id="headerSearchButton"><span class="material-symbols-outlined">search</span></button>
					</div>
				</form>

<?php
				}else{
?>
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" aria-label="<?php print _t("Search the Archive"); ?>">
					<div class="formOutline">
						<div class="form-group">
							<label for="headerSearchInput" class="sr-only">Search the Archive:</label>
							<input type="text" class="form-control" id="headerSearchInput" placeholder="<?php print _t("Search the Archive"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search text"); ?>" />
						</div><button type="submit" class="btn-search" id="headerSearchButton"><span class="material-symbols-outlined">search</span></button>
					</div>
				</form>
<?php
				}
?>
				<script type="text/javascript">
					$(document).ready(function(){
						$('#headerSearchButton').prop('disabled',true);
						$('#headerSearchInput').on('keyup', function(){
							$('#headerSearchButton').prop('disabled', this.value == "" ? true : false);     
						})
					});
				</script>

<?php
				if($vb_video_out){
?>
					<div class="vidOutArchiveSwitch">
						<?php print caNavLink($this->request, _t("Archive")." <span class='material-symbols-outlined'>arrow_outward</span>", "btn btn-default", "", "", ""); ?>				
					</div>
<?php				
				}else{
?>
					<div class="vidOutArchiveSwitch">
						<?php print caNavLink($this->request, _t("Video Out")." <span class='material-symbols-outlined'>arrow_outward</span>", "btn btn-default", "", "VideoOut", "Index"); ?>				
					</div>
<?php
				}
	if ($vb_has_user_links) {
?>
				<ul class="nav navbar-nav navbar-right" id="user-navbar" role="list" aria-label="<?php print _t("User Navigation"); ?>">
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php print ($this->request->isLoggedIn()) ? "User Options" : "Login"; ?></a>
						<ul class="dropdown-menu" role="list"><?php print join("\n", $va_user_links); ?></ul>
					</li>
				</ul>
<?php
	}
			if($vb_video_out){
?>
				<ul class="nav navbar-nav menuItems" role="list" aria-label="<?php print _t("Primary Navigation"); ?>">
					<li <?php print (strToLower($this->request->getAction()) == "videoout") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Browse"), "", "", "Browse", "videoout"); ?></li>
					<li <?php print (strToLower($this->request->getAction()) == "videooutartists") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Artists"), "", "", "Browse", "videooutartists"); ?></li>
					<li <?php print ($vs_contact_type == "RentalPurchase") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Rental & Sales"), "", "", "Contact", "form", array("contactType" => "RentalPurchase")); ?></li>
					<li <?php print (strToLower($this->request->getController()) == "VideoOutSubmit") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Submit for Distribution"), "", "", "VideoOutSubmit", ""); ?></li>
				</ul>
<?php
			}else{
?>
				
				<ul class="nav navbar-nav menuItems" role="list" aria-label="<?php print _t("Primary Navigation"); ?>">
					<?php print $this->render("pageFormat/browseMenu.php"); ?>	
					<li <?php print ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Collections"), "", "", "Collections", "index"); ?></li>					
					<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Projects"), "", "", "Gallery", "Index"); ?></li>
					<li class="dropdown <?php print ($this->request->getController() == "About") ? ' active' : ''; ?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php print _t("About"); ?></a>
						<ul class="dropdown-menu">
							<li><?php print caNavLink($this->request, _t("The Archive"), "", "", "About", "Index"); ?></li>
							<li><?php print caNavLink($this->request, _t("How to Use this Site"), "", "", "About", "Guide"); ?></li>
							<li><?php print caNavLink($this->request, _t("Research & Reproduction"), "", "", "About", "ResearchReproduction"); ?></li>
							<li><?php print caNavLink($this->request, _t("Policies"), "", "", "About", "Policies"); ?></li>
						</ul>
					</li>					
				</ul>
<?php
			}
?>

			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container <?php print (((strToLower($this->request->getController()) == "collections") && (strToLower($this->request->getAction()) == "index")) || (in_array(strToLower($this->request->getController()), array("front", "videoout"))) || ((strToLower($this->request->getController()) == "gallery") && (strToLower($this->request->getAction()) == "index"))) ? "wideContainer" : ""; ?>"><div class="row"><div class="col-xs-12">
		<div role="main" id="main"><div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
