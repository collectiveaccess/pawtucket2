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

?><!DOCTYPE html>
<html lang="en"  <?php print ((strtoLower($this->request->getController()) == "front")) ? "class='frontContainer animatedParallaxContainer'" : ""; ?>>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-W8XHQQD');</script>
<!-- End Google Tag Manager -->
</head>
<body class='<?php print (strtoLower($this->request->getController()) == "front") ? "frontContainer" : ""; ?>'>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W8XHQQD"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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
					<span class="glyphicon glyphicon-user" aria-label="<?php print _t("User options"); ?>></span>
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
				print caNavLink($this->request, "Kress Collection Digital Archive", "navbar-brand", "", "","");
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
	if ($vb_has_user_links) {
?>
				<ul class="nav navbar-nav navbar-right" id="user-navbar" role="list" aria-label="<?php print _t("User Navigation"); ?>">
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user" aria-label="<?php print _t("User options"); ?>"></span></a>
						<ul class="dropdown-menu" role="list"><?php print join("\n", $va_user_links); ?></ul>
					</li>
				</ul>
<?php
	}
?>
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" aria-label="<?php print _t("Search"); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" id="headerSearchInput" placeholder="Search" name="search" autocomplete="off" aria-label="<?php print _t("Search text"); ?>" />
						</div>
						<button type="submit" class="btn-search" id="headerSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit"); ?>"></span></button>
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
				<ul class="nav navbar-nav navbar-right menuItems" role="list" aria-label="<?php print _t("Primary Navigation"); ?>">
					<li <?php print ((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "objects")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Objects"), "", "", "Browse", "objects", array("view" => "images")); ?></li>
					<li <?php print ((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "archival")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Archival Materials"), "", "", "Browse", "archival"); ?></li>
					<li class="dropdown<?php print ((strToLower($this->request->getController()) == "browse") && in_array(strToLower($this->request->getAction()), array("acquisitions", "dispositions"))) ? ' active' : ''; ?>" style="position:relative;"><a href="#" class="dropdown-toggle mainhead top" data-toggle="dropdown"><?php print _t("Object History"); ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
<?php
							print "<li>".caNavLink($this->request, _t("Acquisitions"), '', '', 'Browse', 'acquisitions', '')."</li>";
							print "<li>".caNavLink($this->request, _t("Distributions"), '', '', 'Browse', 'distributions', '')."</li>";
?>
						</ul>	
					</li>
					<li class="dropdown<?php print ((strToLower($this->request->getController()) == "browse") && in_array(strToLower($this->request->getAction()), array("artists", "institutions", "dealers", "other_entities", "entities"))) ? ' active' : ''; ?>" style="position:relative;"><a href="#" class="dropdown-toggle mainhead top" data-toggle="dropdown"><?php print _t("People & Organizations"); ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
<?php
							print "<li>".caNavLink($this->request, _t("Artists"), '', '', 'Browse', 'artists', '')."</li>";
							print "<li>".caNavLink($this->request, _t("Institutions"), '', '', 'Browse', 'institutions', '')."</li>";
							print "<li>".caNavLink($this->request, _t("Dealers & Collectors"), '', '', 'Browse', 'dealers', '')."</li>";
							print "<li>".caNavLink($this->request, _t("Historians & Conservators"), '', '', 'Browse', 'other_entities', '')."</li>";
							print "<li>".caNavLink($this->request, _t("All Names"), '', '', 'Browse', 'entities', '')."</li>";
?>
						</ul>	
					</li>
					<li class="dropdown<?php print (in_array(strToLower($this->request->getController()), array("about")) ? ' active' : ''); ?>" style="position:relative;"><a href="#" class="dropdown-toggle mainhead top" data-toggle="dropdown"><?php print _t("About"); ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
<?php
							print "<li>".caNavLink($this->request, _t("Introduction"), '', '', 'About', 'Introduction', '')."</li>";
							print "<li>".caNavLink($this->request, _t("Kress Collection History"), '', '', 'About', 'History', '')."</li>";
							print "<li>".caNavLink($this->request, _t("Archival Materials Description"), '', '', 'About', 'Materials', '')."</li>";
							print "<li>".caNavLink($this->request, _t("Additional Resources"), '', '', 'About', 'Resources', '')."</li>";
							print "<li>".caNavLink($this->request, _t("Using the Site"), '', '', 'About', 'Guide', '')."</li>";
?>
						</ul>	
					</li>
					<!--<li <?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/objects"); ?></li>-->
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div role="main" id="main"><div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
