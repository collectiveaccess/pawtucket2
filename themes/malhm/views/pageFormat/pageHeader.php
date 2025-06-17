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
	
	$class = null;
	
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
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119818753-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-119818753-1');
	</script>	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?php print MetaTagManager::getHTML(); ?>
	<meta name="description" content="Search the collections of dozens of Minnesota's Historical Societies and History Organizations through one site.">
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>

	<link href="//fonts.googleapis.com/css?family=Merriweather:400,300,300italic,700,400italic,700italic&amp;subset=latin,latin-ext" rel="stylesheet" type="text/css">
	<link href="//fonts.googleapis.com/css?family=Montserrat:400,700&amp;subset=latin,latin-ext" rel="stylesheet" type="text/css">
	<link href="//fonts.googleapis.com/css?family=Josefin+Sans:700&amp;subset=latin,latin-ext" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Goudy+Bookletter+1911" rel="stylesheet"> 
</head>
<body>
	<nav class="navbar navbar-default yamm" role="navigation">
		<div class="container" style='max-width:none;'><div class="row grayBack"><div class="col-sm-12">
			<ul class='socialRow'>
				<li><span class="connect">Connect with us!</span></li>
				<li><a href='mailto:gibson@mnhistoryalliance.org' target='_blank'><i class='fa fa-envelope-o'></i></a></li>
				<li><a href='https://www.instagram.com/mnhistoryalliance/' target='_blank'><i class='fa fa-instagram'></i></a></li>
				<li><a href='https://www.facebook.com/MNHistoryAlliance/' target='_blank'><i class='fa fa-facebook'></i></a></li>
			</ul>
		</div></div></div>
		<div class='containerWrapper'>
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

				<div id="wsite-title"><?php print caNavLink($this->request, 'MN Collections', '', '', '', '');?></div>

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

				<ul class="nav navbar-nav navbar-right menuItems">
					<li <?php print ($this->request->getController() == "About") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About"), "", "", "About", ""); ?></li>
					<li <?php print ((strToLower($this->request->getController()) == "browse") &&  (strToLower($this->request->getAction()) == "contributors")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contributors"), "", "", "Browse", "Contributors"); ?></li>
					<li class="dropdown <?php print ((strToLower($this->request->getController()) == "collections") || ((strToLower($this->request->getController()) == "search") && (strToLower($this->request->getAction()) == "advanced")) || ((strToLower($this->request->getController()) == "browse") &&  (strToLower($this->request->getAction()) == "objects"))) ? 'active"' : ''; ?>" style="position:relative;">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Explore</a>
						<ul class="dropdown-menu">
							<li <?php print ((strToLower($this->request->getController()) == "browse") &&  (strToLower($this->request->getAction()) == "objects")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Browse"), "", "", "Browse", "objects"); ?></li>
							<li <?php print ((strToLower($this->request->getController()) == "search") && (strToLower($this->request->getAction()) == "advanced")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/objects"); ?></li>
						</ul>
					</li>
							
					<li <?php print (strToLower($this->request->getController()) == "gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Featured"), "", "", "Gallery", "Index"); ?></li>
					<li class="dropdown <?php print (strToLower($this->request->getController()) == "help") ? 'active"' : ''; ?>" style="position:relative;">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Help</a>
						<ul class="dropdown-menu">
							<li <?php print ((strToLower($this->request->getController()) == "help") &&  (strToLower($this->request->getAction()) == "guide")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Guide"), "", "", "Help", "guide"); ?></li>
							<li <?php print ((strToLower($this->request->getController()) == "help") && (strToLower($this->request->getAction()) == "faq")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("FAQ"), "", "", "Help", "faq"); ?></li>
							<li <?php print ((strToLower($this->request->getController()) == "help") && (strToLower($this->request->getAction()) == "terms")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Terms of Use"), "", "", "Help", "terms"); ?></li>
							<li <?php print ((strToLower($this->request->getController()) == "help") && (strToLower($this->request->getAction()) == "visit")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Plan Your Visit"), "", "", "Help", "visit"); ?></li>
						</ul>
					</li>	
<?php
	if ($vb_has_user_links) {
?>
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">MyMNCollections</span></a>
						<ul class="dropdown-menu"><?php print join("\n", $va_user_links); ?></ul>
					</li>
<?php
	}
?>
<?php	
	if(!($this->request->getController() === 'Front')) {
?>
				<li class='bigGlass'><a href="#" onclick="$('.navbar-form.big.notFront').slideToggle( 200 ).find('input').focus();return false;" ><i style='font-size:30px;' class="glyphicon glyphicon-search"></i></a></li>
				</ul>
<?php
		$class = "notFront";
	}			
?>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
		</div><!-- end wrapper -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>

			<form class="navbar-form big <?= $class; ?>" role="search" action="<?= caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
				<div class="formOutline">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search All Collections" name="search">
					</div>
					<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
				</div>
			</form>