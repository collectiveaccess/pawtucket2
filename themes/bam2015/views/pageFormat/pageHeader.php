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
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<meta name="Description" content="The BAM Hamm Archives is a rich resource documenting more than 150 years of BAM history.  The digital archive is generously funded by Shelby White & the Leon Levy Foundation" />
	<meta name="google-site-verification" content="CcHQy53x9290Po8xr15hksTxcMjkyPYQueI7fQyGD6M" />
	<script type="text/javascript">window.caBasePath = '<?php print $this->request->getBaseUrlPath(); ?>';</script>
	<link rel="icon" href="<?php print caGetThemeGraphicUrl($this->request, 'favicon.ico'); ?>">
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>
<?php
	//
	// Pull in JS and CSS for debug bar
	// 
	if(Debug::isEnabled()) {
		$o_debugbar_renderer = Debug::$bar->getJavascriptRenderer();
		$o_debugbar_renderer->setBaseUrl(__CA_URL_ROOT__.$o_debugbar_renderer->getBaseUrl());
		print $o_debugbar_renderer->renderHead();
	}
?>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-NJB5LF7');</script>
	<!-- End Google Tag Manager -->
</head>
<body>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NJB5LF7"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<nav class="navbar navbar-default yamm" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle navbar-toggle-user" data-toggle="collapse" data-target="#user-navbar-toggle">
					<span class="sr-only">User Options</span>
					<?php print ($this->request->isLoggedIn()) ? "<span class='icon-user-heart'></span>" : "<span class='icon-user'></span>"; ?>
				</button>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<i class="fa fa-bars"></i>

				</button>
<?php
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'bam_logo.png', array("title" => "Shelby White & Leon Levy BAM Digital Archive")), "navbar-brand", "", "","");
?>
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
						<a href="#" class="dropdown-toggle userIcon" data-toggle="dropdown"><?php print ($this->request->isLoggedIn()) ? "<span class='icon-user-heart'></span>" : "<span class='icon-user'></span>"; ?></a>
						<ul class="dropdown-menu"><?php print join("\n", $va_user_links); ?></ul>
					</li>
				</ul>
<?php
				TooltipManager::add('#userTooltip', "My Bam"); 						

	}
?>
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="search" id="navSearch">
						</div>
						<button type="submit" class="btn-search" id="navSearchButton"><span class="icon-magnifier"></span></button>
					</div>
				</form>
				<ul class="nav navbar-nav navbar-right">
<?php
					print "<li class='dropdown' style='position:relative;'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>Browse <span class='caret'></span></a>\n";
					print "<ul class='dropdown-menu'>\n<li>".caNavLink($this->request, 'People & Organizations', 'first', '', 'Browse', 'entities', array("view" => "list"))."</li>\n"; 
					print "<li>".caNavLink($this->request, 'Productions & Events', '', '', 'Browse', 'occurrences', array("view" => "list"))."</li>\n"; 
					print "<li>".caNavLink($this->request, 'Programming History', 'last', '', 'ProgramHistory', 'Index')."</li>\n"; 
					print "<li>".caNavLink($this->request, 'Archival Collections', '', '', 'Collections', 'Index')."</li>\n";
					print "</ul></li>";
					print "<li class='dropdown' style='position:relative;'><a href='#' class='dropdown-toggle' data-toggle='dropdown'>For Researchers <span class='caret'></span></a>\n";
					print "<ul class='dropdown-menu'>"; 
					print "<li>".caNavLink($this->request, 'Advanced Search', 'first', '', 'Search', 'advanced/objects')."</li>\n";
					#print "<li>".caNavLink($this->request, 'Archival Services', 'last', '', 'About', 'ArchivalServices')."</li>\n";					
					print "<li>".caNavLink($this->request, 'About BAM Hamm Archives', 'last', '', 'About', 'Index')."</li>\n";			
					print "</ul></li>";

					#print $this->render("pageFormat/browseMenu.php");
?>	
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
<script type="text/javascript">
	jQuery(document).ready(function() {
		$( "#navSearch" ).focus(function() {
		  $("#navSearchButton").addClass("navSearchButtonHighlight");
		});
		
		$( "#navSearch" ).focusout(function() {
		  $("#navSearchButton").removeClass("navSearchButtonHighlight");
		});
	});
</script>
<?php
	if($this->request->getController() != "Front"){
?>
	<div class="container"><div class="row"><div class="col-xs-12">
<?php
	}
?>
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
