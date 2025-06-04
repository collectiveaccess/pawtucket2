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
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-F70G4D71ZM"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	
	  gtag('config', 'G-F70G4D71ZM');
	</script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?php print MetaTagManager::getHTML(); ?>
	<link rel="stylesheet" type="text/css" href="<?php print $this->request->getAssetsUrlPath(); ?>/mirador/css/mirador-combined.css">
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
<body class="initial">
	<div class="topbar">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-6  col-sm-6">
                </div>
                <div class="col-md-6 col-sm-6">
                	<ul class="pull-right social-icons-colored">
                    	<li class="facebook"><a href="https://www.facebook.com/hollandmuseum" target="_blank"><i class="fa fa-facebook"></i></a></li><li class="twitter"><a href="https://twitter.com/HollandMuseum" target="_blank"><i class="fa fa-twitter"></i></a></li><li class="pinterest"><a href="https://www.pinterest.com/holland_museum/" target="_blank"><i class="fa fa-pinterest"></i></a></li><li class="instagram"><a href="https://www.instagram.com/hollandmuseum/" target="_blank"><i class="fa fa-instagram"></i></a></li>                    </ul>
                </div>
            </div>
        </div>
    </div>
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
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'HMcolorRGB.png'), "navbar-brand", "", "","");
?>
				<div class="headerTagLine"><?php print caNavLink($this->request, $this->getVar("header_text"), "", "", "", ""); ?></div>
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
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="search" id="headerSearchInput">
						</div>
						<button type="submit" class="btn-search" id="headerSearchButton"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>
<script type="text/javascript">
	$(document).ready(function(){
		$('#headerSearchButton').prop('disabled',true);
		$('#headerSearchInput').keyup(function(){
			$('#headerSearchButton').prop('disabled', this.value == "" ? true : false);     
		})
	});
</script>
<?php
			if($vs_message = $this->getVar("header_message")){
?>
				<div class="headerMessage"><?= $vs_message; ?></div>
<?php
			}
?>
				<div class='menuContainer'><ul class="nav navbar-nav navbar-right menuItems">
					<li><a href="http://www.hollandmuseum.org" target="_blank">Museum Home</a></li>
					<li <?php print ($this->request->getController() == "About") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About the Collection"), "", "", "About", ""); ?></li>
					<li <?php print ($this->request->getController() == "Explore") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Explore the Collection"), "", "", "Explore", "Index"); ?></li>
					<?php print $this->render("pageFormat/browseMenu.php"); ?>
					<li class="browseAltLink <?php print (strToLower($this->request->getController()) == "browse") ? '' : ''; ?>"><?php print caNavLink($this->request, _t("Browse"), "", "", "Browse", "objects"); ?></li>	
					<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Featured Galleries"), "", "", "Gallery", "Index"); ?></li>
					<!--<li <?php print ($this->request->getController() == "ContactUs") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contact"), "", "", "ContactUs", ""); ?></li>-->
				</ul></div>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
<?php
	$vs_title = "";
	switch(strToLower($this->request->getController())){
		case "about":
			$vs_title = "About the Collection";
		break;
		case "browse":
		case "search":
		case "detail":
			$vs_title = "Find";
		break;
		case "gallery":
			$vs_title = "Featured Galleries";
		break;
		case "contactus":
			$vs_title = "Contact";
		break;
		case "explore":
			$vs_title = "Explore";
		break;
		case "lightbox":
			$vs_title = "Lightbox";
		break;
		case "loginreg":
			if(in_array(strToLower($this->request->getAction()), array("profileform", "profilesave"))){
				$vs_title = "Profile";
			}
			if(in_array(strToLower($this->request->getAction()), array("resetform", "resetsend", "resetsave"))){
				$vs_title = "Reset your password";
			}
		break;
	}
	if($vs_title){
?>
	<div class="row skewed-title-bar">
		<div class="col-xs-12 col-sm-offset-1 col-sm-10"><H4><span><?php print $vs_title; ?></span></H4></div>	
	</div>
<?php
	}
?>