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
		if ($this->request->config->get('use_submission_interface')) {
			$va_user_links[] = "<li>".caNavLink($this->request, _t('Submit materials'), '', '', 'Contribute', 'Index', array())."</li>";
		}
					
		$va_user_links[] = "<li>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
		$va_user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
	<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-158007471-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-158007471-1');
</script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<link rel='stylesheet' href='/assets/fontawesome/css/font-awesome.min.css' type='text/css' media='all'/>


	<link href="https://fonts.googleapis.com/css?family=Oswald:300,400" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Cabin:400,400i,600,600i" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Francois+One" rel="stylesheet">
<?php
	$app = AppController::getInstance();
	$resp = $app->getResponse();
	$resp->addHeader("Content-Security-Policy", "script-src 'self' connect.facebook.net maps.googleapis.com cdn.knightlab.com nominatim.openstreetmap.org  ajax.googleapis.com tagmanager.google.com www.googletagmanager.com www.google-analytics.com www.google.com/recaptcha/ www.gstatic.com 'unsafe-inline' 'unsafe-eval';"); 
	$resp->addHeader("X-Content-Security-Policy", "script-src 'self' connect.facebook.net maps.googleapis.com cdn.knightlab.com nominatim.openstreetmap.org  ajax.googleapis.com  tagmanager.google.com www.googletagmanager.com www.google-analytics.com www.google.com/recaptcha/ www.gstatic.com 'unsafe-inline' 'unsafe-eval';"); 
	
	MetaTagManager::addMetaProperty("og:url", $this->request->config->get("site_host").caNavUrl($this->request, "*", "*", "*"));
	MetaTagManager::addMetaProperty("og:type", "website");
	MetaTagManager::addMetaProperty("og:title", $this->request->config->get("app_display_name"));

	# --- what should the default image to share be?
	# --- default to logo --- use image from detail page if on object page - done on details
	if(!in_array(strToLower($this->request->getController()), array("detail", "gallery"))){
		$vs_og_image = $this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'defaultShareImage.jpg');
		MetaTagManager::addMetaProperty("og:image", $vs_og_image);
		MetaTagManager::addMetaProperty("og:description", htmlentities(strip_tags($this->getVar("hometagline"))));
		MetaTagManager::addMetaProperty("description", htmlentities(strip_tags($this->getVar("hometagline"))));
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

</head>
<body>
	<nav class="container navbar navbar-default yamm" role="navigation">		
		

			<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navLogo">
<?php
			print caNavLink($this->request, caGetThemeGraphic($this->request, 'appalshop_banner_lg.png'), "", "", "","");
?>
		</div>

<?php
	if ($vb_has_user_links) {
?>
				<button type="button" class="navbar-toggle navbar-toggle-user" data-toggle="collapse" data-target="#user-navbar-toggle">
					<span class="sr-only">User Options</span>
					<?php print ($this->request->isLoggedIn()) ? $this->request->user->get("fname") : "Log In"; ?>
				</button>
<?php
	}
?>
				<button type="button" class="navbar-toggle" data-toggle="collapse" id="appalshop" data-target="#bs-main-navbar-collapse-2">
					<span class="sr-only">Toggle navigation</span>
					<span class="glyphicon glyphicon-list-alt"></span>
				</button>
				<button type="button" class="navbar-toggle"  id="bars" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

			

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
		<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-2">
		    <div class="row" id="nav-external">
			  <ul class="nav navbar-nav navbar-right">
			    <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">About</a>
                  <ul class="dropdown-menu submenu">
                    <li><a href="/news/history-of-appalshop">History of Appalshop</a></li>
                    <li><a href="/news/the-archive">The Archive</a></li>
                    <li><a href="/news/supporters">Supporters</a><li>
                    <li><a href="/news/staff">Staff</a></li>
                  </ul>
                </li>
                <li><a href="/news/">News</a></li>
                <li><a href="/news/services"">Services</a></li>
                <li><a href="/news/support">Get Involved</a></li>
                <li><a href="/news/contact">Contact</a></li> 	
                <li><a href="https://www.appalshop.org" target="_blank">Appalshop</a></li>	
              </ul>	
            </div>
     </div>
<?php
	if ($vb_has_user_links) {
?>
				<ul class="nav navbar-nav navbar-right" id="user-navbar">
					<li class="dropdown" style="position:relative;">
						<a href="#" data-toggle="dropdown"><?php print ($this->request->isLoggedIn()) ? $this->request->user->get("fname") : "Log In"; ?></a>
						<ul class="dropdown-menu"><?php print join("\n", $va_user_links); ?></ul>
					</li>
				</ul>
<?php
	}
?>
<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
		    <div class="row">
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" id="headerSearchInput" placeholder="Search" name="search" autocomplete="off" />
						</div>
						<button type="submit" class="btn-search" id="headerSearchButton"><span class="glyphicon glyphicon-search"></span></button>
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

				<ul class="nav navbar-nav" id= "menuItems">
					<li <?php print ($this->request->getController() == "Browse") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Browse"), "", "", "Browse", "objects", array("facet" => "has_media_facet", "id" => "yes")); ?></li>					
					<li <?php print ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Collections"), "", "", "Collections", "index"); ?></li>					
					<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Special Projects"), "", "", "Gallery", "Index"); ?></li>
					
					<?php if(caDisplayLightbox($this->request)){ ?>
					<li><?php print caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index') ?></li>   
					<?php } ?>      
	                <li><a href="https://appalshop.networkforgood.com/projects/120995-neh-challenge-grant-safeguarding-appalachian-history" target="_blank"><span class="donateButton">Donate</span></a></li>	
				    <li><a href="https://www.facebook.com/appalarchive" target="_blank"><span class="fa fa-facebook"></span></a></li>
                	<li><a href="https://www.instagram.com/appalshop_archive/" target="_blank"><span class="fa fa-instagram"></span></a></li>	
                	<li><a href="https://www.youtube.com/channel/UCP6iF9cBLAfhP5ilDk8jH8g" target="_blank"><span class="fa fa-youtube"></span></a></li>	
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
<?php
		if((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "objects")){
			if(Session::getVar('visited') != 'has_visited_browse'){
?>
				<div class="browseIntroContainer">
					<div class="row">
						<div class="col-sm-12 col-md-6 col-md-offset-3 col-lg-8 col-lg-offset-2">
							<div class="browseIntro">
								<div class="closeButton"><a href="#" onClick="$('.browseIntroContainer').hide(); return false;" title="Close"><span class="glyphicon glyphicon-remove-circle"></span></a></div>
								{{{browseintroduction}}}
							</div>
						</div>
					</div>
					<HR/>
				</div>
<?php
			}
			Session::setVar('visited', 'has_visited_browse');
		}
?>
