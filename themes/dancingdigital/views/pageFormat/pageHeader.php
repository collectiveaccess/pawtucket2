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
	
	<script type="text/javascript">
			let pawtucketUIApps = {};
	</script>

	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>
	
	<script src="<?= $this->request->getThemeUrlPath(); ?>/assets/css.js"></script>
	<script src="<?= $this->request->getThemeUrlPath(); ?>/assets/main.js"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" 
		integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/@barba/core"></script>
    <script src=" https://cdn.jsdelivr.net/npm/@barba/css@2.1.15/dist/barba-css.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    
    <link rel="stylesheet" href="https://cdn.knightlab.com/libs/storymapjs/latest/css/storymap.css">
	<script type="text/javascript" src="https://cdn.knightlab.com/libs/storymapjs/latest/js/storymap-min.js"></script>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
</head> 

<body data-barba="wrapper">
	<div id="skipNavigation"><a href="#main">Skip to main content</a></div>
	
			<?= $this->render("pageFormat/sidebar.php"); ?>
				<div id="main">