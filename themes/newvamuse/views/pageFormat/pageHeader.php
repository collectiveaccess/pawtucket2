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

	global $g_ui_locale;
	$cur_locale = str_replace("_CA", "", $g_ui_locale);
	
	# Collect the user links: they are output twice, once for toggle menu and once for nav
	$va_user_links = array();
		if(caDisplayLightbox($this->request)){
			$va_user_links[] = "<li>".caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
		}	
		$va_user_links[] = '<li class="divider nav-divider"></li>';
	if($this->request->isLoggedIn()){

		$va_user_links[] = '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';

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
	
	if (($this->request->getController() == "Detail") && ($this->request->getAction() == "objects")){
		$vn_object_meta_id = $this->request->getActionExtra();
		$t_meta_object = new ca_objects($vn_object_meta_id);
		$va_reps = $t_meta_object->getPrimaryRepresentation(array('large'), null, array('return_with_access' => $va_access_values));
		$va_og_tag = $va_reps['urls']['large']; 
		$va_og_url = caNavUrl($this->request, 'Detail', 'objects', $vn_object_meta_id, array(), array('absolute' => 1));
		$va_og_title = $t_meta_object->get('ca_objects.preferred_labels');
	}
	
	$params = $this->request->getParameters(['PATH', 'GET']);
	unset($params['lang']);
?><!DOCTYPE html>
<html lang="en"
	xmlns:fb="http://ogp.me/ns/fb#">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<meta property="og:image" content="<?= $va_og_tag;?>"/>
	<meta property="og:url" content="<?= $va_og_url;?>"/>
	<meta property="og:title" content="<?= $va_og_title;?>"/>
	<meta property="og:site_name" content="Novamuse"/>
	<meta property="og:type" content="website"/> 	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<link rel="shortcut icon" href="/favicon.png">
	<?= MetaTagManager::getHTML(); ?>
	<?= AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?= (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>
	<!-- wig account <script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5935c2532e01ff00121c67cf&product=inline-share-buttons"></script>-->
	<script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5941a2411684e40011e407a5&product=social-ab' async='async'></script>
	<link rel="icon" type="image/png" href="/favico.ico">

</head>
<body>
<?php
	if ($this->request->getController() == "Front") {
		$vs_class_logo = "frontNav";
	}
?>	
	<nav class="navbar navbar-default yamm <?= $vs_class_logo;?> " role="navigation">
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
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'novamuse.png'), "navbar-brand", "", "","");
?>
			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
				<!--<form class="navbar-form navbar-right" role="search" action="<?= caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="search">
						</div>
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>-->
				<ul class="nav navbar-nav navbar-right menuItems">
					<li class="<?= (($this->request->getController() == "About")  && (($this->request->getAction() == "Index") | ($this->request->getAction() == "support")))? 'active' : ''; ?> dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= _t('About'); ?></a>
						<ul class='dropdown-menu'>
							<li><?= caNavLink($this->request, _t("About"), "", "", "About", "Index"); ?></li>
							<li><?= caNavLink($this->request, _t("Land Acknowledgement"), "", "", "About", "land"); ?></li>
							<li><?= caNavLink($this->request, _t("Land Acknowledgement (Mi'kmaq)"), "", "", "About", "landmi"); ?></li>
							<li><?= caNavLink($this->request, _t("Land Acknowledgement (Gaelic)"), "", "", "About", "landgael"); ?></li>
							<li><?= caNavLink($this->request, _t("Support Us"), "", "", "About", "support"); ?></li>
						</ul>
					</li>
					<li <?= ($this->request->getController() == 'MemberMap') ? 'class="active"' : ""; ?>><?= caNavLink($this->request, _t("Contributors"), "", "NovaMuse", "MemberMap", "Index"); ?></li>
					<li class="<?= (($this->request->getController() == "Browse")) ? 'active' : ''; ?> dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= _t('Explore'); ?></a>
						<ul class='dropdown-menu'>
							<li><?= caNavLink($this->request, _t("Browse"), "", "", "Browse", "objects"); ?></li>
							<li><?= caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/objects"); ?></li>
							<li><?= caNavLink($this->request, _t("Made in Nova Scotia"), "", "", "Browse", "entities"); ?></li>
							<li><?= caNavLink($this->request, _t("Nova Scotia Place Names"), "", "NovaMuse", "PlaceNames", "Index"); ?></li>
						</ul>
					</li>
					<li <?= ($this->request->getController() == "Transcribe") ? 'class="active"' : ''; ?>><?= caNavLink($this->request, _t("Transcribe"), "", "", "Transcribe", "Index"); ?></li>
					<li <?= (($this->request->getController() == "About") && ($this->request->getAction() == "teachers")) ? 'class="active"' : ''; ?>><?= caNavLink($this->request, _t("For Teachers"), "", "", "EducationalResources", "Index"); ?></li>
					<li class="<?= (($this->request->getController() == "About") && ($this->request->getAction() != "teachers") && ($this->request->getAction() != "support") && ($this->request->getAction() != "Index")) ? 'active' : ''; ?> dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= _t('Help'); ?></a>
						<ul class='dropdown-menu'>
							<li><?= caNavLink($this->request, _t("Guide"), "", "", "About", "guide"); ?></li>
							<li><?= caNavLink($this->request, _t("FAQ"), "", "", "About", "questions"); ?></li>
							<li><?= caNavLink($this->request, _t("Terms of Use"), "", "", "About", "termsou"); ?></li>
							<li><?= caNavLink($this->request, _t("Plan Your Visit"), "", "", "About", "planyv"); ?></li>
						</ul>
					</li>
					<li class="<?= (($this->request->getController() == "Gallery")) ? 'active' : ''; ?> dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span style='text-transform:lowercase;'>my</span>Novamuse</a>
						<ul class='dropdown-menu'>
							<li><?= caNavLink($this->request, _t("Featured Galleries"), "", "", "Gallery", "Index"); ?></li>
							<?= join("\n", $va_user_links); ?>
						</ul>
					</li>
					
					<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= $cur_locale; ?></a>
						<ul class='dropdown-menu'>
							<li class="<?= ($g_ui_locale === 'en_CA') ? 'active' : ''; ?>"><?= caNavLink($this->request, "EN", "", "*", "*", "*", array_merge(['lang' => 'en_CA'], $params)); ?></li>
							<li class="<?= ($g_ui_locale === 'fr_CA') ? 'active' : ''; ?>"><?= caNavLink($this->request, "FR", "", "*", "*", "*", array_merge(['lang' => 'fr_CA'], $params)); ?></li>
						</ul>
					</li>
<?php
					if ($this->request->getController() != "Front") {
?>					
					<li class='bigGlass'><a href="#" onclick="$('.navbar-form.big.notFront').toggle( 200 );return false;" ><i style='font-size:30px;' class="glyphicon glyphicon-search"></i></a></li>
<?php
						$vs_class = "notFront";
					}
?>						
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?= caGetPageCSSClasses(); ?>>
			<form class="navbar-form big <?= $vs_class; ?>" role="search" action="<?= caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
				<div class="formOutline">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="<?= _t('Search our collections'); ?>" name="search">
					</div>
					<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
				</div>
			</form>
