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
		#$va_user_links[] = '<li class="divider nav-divider"></li>';
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
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<link rel="stylesheet" type="text/css" href="<?php print $this->request->getAssetsUrlPath(); ?>/mirador/css/mirador-combined.css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>

</head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-135762716-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
 
  gtag('config', 'UA-135762716-2');
</script>
<body>
	<div class="verytop">
		<div class="container">
			<div class="menu-top-menu-container">
				<ul id="menu-top-menu" class="menu">
					<li class="menu-item"><a href="https://www.nationalhellenicmuseum.org">NHM Home</a></li>
					<li class="menu-item"><a href="https://www.nationalhellenicmuseum.org/visit/">Visit</a></li>
					<li class="menu-item"><a href="https://www.nationalhellenicmuseum.org/support/become-a-member/">Become a Member</a></li>
					<li class="menu-item"><a href="https://www.nationalhellenicmuseum.org/visit/tours/">Tours</a></li>
				</ul>
			</div>	
		</div>
	</div>
	
	
	
	
	
	
	
	
	
	
	<nav class="navbar navbar-default yamm" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<div class="container">
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
				print "<a href='https://www.nationalhellenicmuseum.org' class='navbar-brand'>".caGetThemeGraphic($this->request, 'logo.jpg')."</a>";
?>


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
								<input type="text" class="form-control" placeholder="Search..." name="search">
							</div>
							<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
						</div>
					</form>
					<ul class="nav navbar-nav navbar-right menuItems">
						<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Themes"), "", "", "Gallery", "Index"); ?></li>					
						<li>
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Search <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><?php print caNavLink($this->request, _t("Browse All"), "", "", "Browse", "objects"); ?></li>
								<li><?php print caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/objects"); ?></li>	
								<li><?php print caNavLink($this->request, _t("Finding Aids"), "", "", "Collections", "Index"); ?></li>		
							</ul>
						</li>
						<li >
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Resources <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><?php print caNavLink($this->request, _t("About the Collection"), "", "", "About", "collection"); ?></li>
								<li><?php print caNavLink($this->request, _t("Schedule a Research Visit"), "", "", "Contact", "form", array("mode" => "research")); ?></li>
								<li><?php print caNavLink($this->request, _t("Contact"), "", "", "Contact", "form"); ?></li>
								<li><?php print caNavLink($this->request, _t("Helpful Information"), "", "", "About", "links"); ?></li>
								<li><?php print caNavLink($this->request, _t("Acknowledgements"), "", "", "About", "acknowledgements"); ?></li>			
							</ul>
						</li>
						<li >
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Contribute <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><?php print "<a href='https://www.nationalhellenicmuseum.org/support/'>Support our Work</a>";?></li>
								<li><?php print caNavLink($this->request, _t("Grow the Collection"), "", "", "About", "donate"); ?></li>				
							</ul>
						</li>										
					</ul>
				
				</div><!-- /.navbar-collapse -->
			</div><!-- end container -->
		</div>
	</nav>
	<div class="banner"><div class="container"><?php print caNavLink($this->request, "NHM COLLECTIONS & ARCHIVES", "", "", "",""); ?></div></div>
	<div class="bannerImg"></div>
<?php
	#if (strToLower($this->request->getController()) == "front") {
	#	$vs_style = "nomax";
	#} 
	# print '<div class="container '.$vs_style.'" style="padding:0px;"><div class="row"><div class="col-xs-12">';
?>	
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
