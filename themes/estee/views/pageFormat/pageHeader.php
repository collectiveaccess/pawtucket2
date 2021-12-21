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
		if (!$this->request->config->get('dont_allow_registration_and_login') || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get('dont_allow_registration_and_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
	<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-67371779-14"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
 
  gtag('config', 'UA-67371779-14');
</script>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!--<base href="<?= $this->request->config->get('site_host').$this->request->config->get('ca_url_root'); ?>"/>-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?php print MetaTagManager::getHTML(); ?>
    <meta name="pinterest" content="nopin" />
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
<body>
<?php
	if(strtoLower($this->request->getController()) == "front"){
		print "<div class='heroFixed'><div class='container'><div class='row'><div class='col-sm-12'>".caGetThemeGraphic($this->request, 'hero_3.jpg')."</div></div></div></div>";
	}
?>
	<nav class="navbar navbar-default yamm" role="navigation">
		<div class="topNav">
			<div class="row text-center">
				<div class="col-sm-12 col-md-4 col-md-offset-4 esteeBrand">
					<?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'ELC_LOGO_dblue.png'), "", "", "", ""); ?>
				</div>
				<div class="col-sm-12 col-md-4">
					<div class="collapse navbar-collapse bs-main-navbar-collapse-2 navbar-search">
						<form class="navbar-form" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
							<div class="formOutline">
								<div class="form-group">
									<input type="text" class="form-control" id="headerSearchInput" placeholder="Search Archives" name="search" autocomplete="off" />
								</div>
								<button type="submit" class="btn-search" id="headerSearchButton"><i class='material-icons'>search</i></button>
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
					</div>
				</div>
			</div>
		</div>
		<div class="container menuBar">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="row">
				<div class="col-sm-12 col-md-3 col-lg-2 col-lg-offset-1 text-center">
					
					<button type="button" class="navbar-toggle navbar-toggle-menu" data-toggle="collapse" data-target=".bs-main-navbar-collapse-1" onClick="$('.navbar-toggle-showhide').toggle(); if($('.bs-main-navbar-collapse-2').hasClass('in')){ $('.bs-main-navbar-collapse-2').collapse('hide'); }">
						<span class="sr-only">Toggle navigation</span>
						<span class="navbar-toggle-showhide"><i class='material-icons'>menu</i></span>
						<span style="display:none;" class="navbar-toggle-showhide navbar-toggle-showhide-x"><i class='material-icons'>close</i></span>
					</button>
					<button type="button" class="navbar-toggle navbar-toggle-search" data-toggle="collapse" data-target=".bs-main-navbar-collapse-2" onClick="if($('.bs-main-navbar-collapse-1').hasClass('in')){ $('.bs-main-navbar-collapse-1').collapse('hide'); } $('.navbar-toggle-showhide').show(); $('.navbar-toggle-showhide-x').hide();">
						<span class="sr-only">Toggle search</span>
						<i class='material-icons'>search</i>
					</button>
<?php
					print caNavLink($this->request, "Archives", "navbar-brand", "", "","");
?>					
				</div>
				<div class="col-md-6 text-center">
					<div class="collapse navbar-collapse bs-main-navbar-collapse-1 navbar-menu">
						<ul class="nav navbar-nav menuItems">
							<li <?php print (strToLower($this->request->getController()) == "about") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About"), "", "", "About", ""); ?></li>
							<li <?php print ((strToLower($this->request->getController()) == "collections") || ((strToLower($this->request->getController()) == "detail") && (strToLower($this->request->getAction()) == "collections"))) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Collections"), "", "", "Collections", "Index"); ?></li>
							<li <?php print (strToLower($this->request->getController()) == "gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Stories"), "", "", "Gallery", "Index"); ?></li>
							<li <?php print (strToLower($this->request->getController()) == "contact") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Inquire"), "", "", "Contact", "Form"); ?></li>
<?php
							if($this->request->isLoggedIn()){
								if(caDisplayLightbox($this->request)){
									print "<li class='collapsed-project-link".((strToLower($this->request->getController()) == "lightbox") ? " active" : "")."'>".caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
								}		
								print "<li class='collapsed-project-link'>".caNavLink($this->request, 'Logout', '', '', 'LoginReg', 'Logout')."</li>";
							}else{
								print "<li class='collapsed-project-link'><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>";
							}
?>
						</ul>
					</div><!-- /.navbar-collapse -->
				
				</div>
				<div class="col-md-3 col-lg-2 text-center">
				<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse navbar-projects bs-main-navbar-collapse-1">
						<!--- this is not shown in collapsed menu - .collapsed-project-link is instead --->
<?php
							if($this->request->isLoggedIn()){
								print "<ul class='nav navbar-nav menuItems'>";
									if(caDisplayLightbox($this->request)){
									print "<li ".((strToLower($this->request->getController()) == "lightbox") ? 'class="active"' : '').">".caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
							
								}
								print "<li class='logout'>".caNavLink($this->request, "<i class='material-icons'>input</i>", 'logout', '', 'LoginReg', 'Logout', array(), array('title' => 'Logout'))."</li>";
								print "</ul>";	
							}else{
								print "<ul class='nav navbar-nav menuItems navbar-right'><li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li></ul>";
							}
?>
					</div>

				</div>
			</div>
		</div><!-- end container -->
		</nav>
		
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
