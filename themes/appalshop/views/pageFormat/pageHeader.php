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
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) && !$this->request->config->get('dontAllowRegistration')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
	<head>
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
	

?>
	<meta property="og:url" content="<?php print $this->request->config->get("site_host").caNavUrl($this->request, "*", "*", "*"); ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:description" content="<?php print htmlspecialchars((MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name")); ?>" />
	<meta property="og:title" content="<?php print $this->request->config->get("app_display_name"); ?>" />
<?php
	# --- what should the image to share be?
	# --- default to logo --- use image from detail page if on object page
	$vs_og_image = $this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'appalshopLogoShare.jpg'); # --- replace this with logos for institutions
	if((strToLower($this->request->getController()) == "detail") && (strToLower($this->request->getAction()) == "objects")){
		$ps_id = urldecode($this->request->getActionExtra());
		$vs_use_alt_identifier_in_urls = caUseAltIdentifierInUrls("ca_objects");
		$t_subject = new ca_objects();
		if ((($vb_use_identifiers_in_urls = caUseIdentifiersInUrls()) || ($vs_use_alt_identifier_in_urls)) && (substr($ps_id, 0, 3) == "id:")) {
			$va_tmp = explode(":", $ps_id);
			$ps_id = (int)$va_tmp[1];
			$vb_use_identifiers_in_urls = $vs_use_alt_identifier_in_urls = false;
		}

		if($vs_use_alt_identifier_in_urls && $t_subject->hasElement($vs_use_alt_identifier_in_urls)) {
			$va_load_params = [$vs_use_alt_identifier_in_urls => $ps_id];
		} elseif ($vb_use_identifiers_in_urls && $t_subject->getProperty('ID_NUMBERING_ID_FIELD')) {
			$va_load_params = [$t_subject->getProperty('ID_NUMBERING_ID_FIELD') => $ps_id];
		} else {
			$va_load_params = [$t_subject->primaryKey() => (int)$ps_id];
		}
		
		if (!($t_subject = call_user_func_array($t_subject->tableName().'::find', array($va_load_params, ['returnAs' => 'firstModelInstance'])))) {
			// invalid id - throw error
			throw new ApplicationException("Invalid id");
		}else{
			if($vs_rep = $t_subject->get("ca_object_representations.media.medium.url", array("checkAccess" => $va_access_values))){
				$vs_og_image = $vs_rep;
			}
			
		}
	}
?>
	<meta property="og:image" content="<?php print $vs_og_image; ?>" />


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
					<span class="glyphicon glyphicon-user"></span>
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
                <li><a href="/news/support">Support</a></li>
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
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span></a>
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
					<?php print $this->render("pageFormat/browseMenu.php"); ?>	
					<li <?php print ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Collections"), "", "", "Collections", "index"); ?></li>					
					<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Special Projects"), "", "", "Gallery", "Index"); ?></li>
					
					<?php if(caDisplayLightbox($this->request)){ ?>
					<li><?php print caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index') ?></li>   
					<?php } ?>      
	                <li><a href="https://donatenow.networkforgood.org/appalshop"><span class="donateButton">Donate</span></a></li>	
				    <li><a href="https://www.facebook.com/Appalshop"><span class="fa fa-facebook"></span></a></li>
                	<li><a href="https://twitter.com/AppalArchive"><span class="fa fa-twitter"></span></a></li>	
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
