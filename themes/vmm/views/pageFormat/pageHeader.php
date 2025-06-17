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
<html lang="en"  <?php print ((strtoLower($this->request->getController()) == "front") || (strtoLower($this->request->getAction()) == "parallax")) ? "class='frontContainer animatedParallaxContainer'" : ""; ?>>
	<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121899338-2"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-121899338-2');
	</script>
	<link rel="stylesheet" type="text/css" href="<?php print $this->request->getAssetsUrlPath(); ?>/mirador/css/mirador-combined.css">
	<link rel="shortcut icon" type="image/png" href="<?php print caGetThemeGraphicUrl($this->request, 'favicon.png'); ?>"/>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<meta property="og:url" content="<?php print $this->request->config->get("site_host").caNavUrl($this->request, "*", "*", "*"); ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:description" content="The Vancouver Maritime Museum's Open Collections is an online catalogue of Artifacts and Archival Material held at the museum." />
	<meta property="og:title" content="Vancouver Maritime Museum's Open Collections" />
	<meta property="og:image" content="<?php print $this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'shipShare.jpg'); ?>" />

	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@vanmaritime">
	<meta name="twitter:title" content="Vancouver Maritime Museum's Open Collections">
	<meta name="twitter:description" content="The Vancouver Maritime Museum's Open Collections is an online catalogue of Artifacts and Archival Material held at the museum.">
	<meta name="twitter:image" content="<?php print $this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'shipShare.jpg'); ?>">	

	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>

</head>
<body class='initial <?php print (strtoLower($this->request->getController()) == "front") ? "frontContainer" : ""; ?>'>
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
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'VMM_Logo_'.((strtoLower($this->request->getController()) == "front") ? "Red" : "Navy").'.png'), "navbar-brand initialLogo", "", "","");
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'VMM_Circle_Logo_small.jpg'), "navbar-brand scrollLogo", "", "","");
?>
			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
			<div class="navbar-collapse-container">
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
							<input type="text" class="form-control" id="headerSearchInput" placeholder="Search" name="search" autocomplete="off" />
						</div>
						<button type="submit" class="btn-search" id="headerSearchButton"><span class="glyphicon glyphicon-search"></span></button>
					</div>
					<div class="advancedSearch"><?php print caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/archival_items"); ?></div>
				</form>
				<script type="text/javascript">
					$(document).ready(function(){
						$('#headerSearchButton').prop('disabled',true);
						$('#headerSearchInput').on('keyup', function(){
							$('#headerSearchButton').prop('disabled', this.value == "" ? true : false);     
						})
					});
				</script>
				<ul class="nav navbar-nav navbar-right menuItems">
					
					<li <?php print ((strtoLower($this->request->getController()) == "browse") && (strtoLower($this->request->getAction()) == "artifacts")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Artifacts"), "", "", "Browse", "artifacts"); ?></li>
					
					<li class="dropdown <?php print ((strtoLower($this->request->getController()) == "browse") && (strtoLower($this->request->getAction()) == "archival_items") || (strtoLower($this->request->getController()) == "collections")) ? 'active' : ''; ?>" style="position:relative;">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Archives</a>
						<ul class="dropdown-menu">	
							<li <?php print ((strtoLower($this->request->getController()) == "browse") && (strtoLower($this->request->getAction()) == "archival_items")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Archival Items"), "", "", "Browse", "archival_items"); ?></li>
							<li <?php print (strtoLower($this->request->getController()) == "collections") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Archival Fonds and Collections"), "", "", "Collections", "index"); ?></li>	
							
						</ul>
					</li>
					<li <?php print ((strtoLower($this->request->getController()) == "browse") && (strtoLower($this->request->getAction()) == "vessels")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Vessels"), "", "", "Browse", "vessels"); ?></li>
							
					<li <?php print (strtoLower($this->request->getController()) == "gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Highlights"), "", "", "Gallery", "Index"); ?></li>
					
					
					<li class="dropdown <?php print (in_array(strToLower($this->request->getController()), array("about"))) ? 'active"' : ''; ?>" style="position:relative;">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">About</a>
						<ul class="dropdown-menu">
							<li <?php print ((strToLower($this->request->getController()) == "about") &&  (strToLower($this->request->getAction()) == "museum")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About the Museum"), "", "", "About", "Museum"); ?></li>
							<li <?php print ((strToLower($this->request->getController()) == "about") &&  (strToLower($this->request->getAction()) == "collection")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About the Collection"), "", "", "About", "Collection"); ?></li>
							<li <?php print ((strToLower($this->request->getController()) == "about") &&  (strToLower($this->request->getAction()) == "ReproLicenseFees")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Reproduction Services"), "", "", "About", "ReproLicenseFees"); ?></li>
							<li <?php print ((strToLower($this->request->getController()) == "about") && (strToLower($this->request->getAction()) == "faq")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("FAQ"), "", "", "About", "FAQ"); ?></li>
							<li <?php print ((strToLower($this->request->getController()) == "about") && (strToLower($this->request->getAction()) == "contact")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contact"), "", "", "About", "Contact"); ?></li>
							<li><a href="https://www.vancouvermaritimemuseum.com/" target="_blank">Museum Home</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- relative -->
		</div><!-- end container -->
	</nav>
<?php
	if(strToLower($this->request->getController()) != "front"){
		print '<div class="container"><div class="row"><div class="col-xs-12">';
	}


	$va_breadcrumb = array(caNavLink($this->request, _t("Home"), "", "", "", ""));
	
	switch(strToLower($this->request->getController())){
		case "gallery":
			# --- detail done in that view
			$va_breadcrumb[] = caNavLink($this->request, _t("Highlights"), "", "", "Gallery", "Index");
			
		break;
		# -----------------------------------------------------
		case "about":
			$vs_section = "";
			switch(strToLower($this->request->getAction())){
				case "museum":
					$vs_section = "About the Museum";
				break;
				# ---------------------------
				case "collection":
					$vs_section = "About the Collection";
				break;
				# ---------------------------
				case "faq":
					$vs_section = "FAQ";
				break;
				# ---------------------------
				case "contact":
					$vs_section = "Contact";
				break;
				# ---------------------------
				case "repoductionservicesfees":
					$vs_section = "Schedule of Fees for Reproduction Services";
				break;
				# ---------------------------
			}
			$va_breadcrumb[] = caNavLink($this->request, "About: ".$vs_section, "", "", "About", $this->request->getAction());			
		break;
		# -----------------------------------------------------
		case "browse":
		case "search":
			$vs_section = "";
			switch(strToLower($this->request->getAction())){
				case "artifacts":
					$vs_section = "Find: Artifacts";
				break;
				# ---------------------------
				case "archival_items":
					$vs_section = "Find: Archival Items";
				break;
				# ---------------------------
				case "archives":
					$vs_section = "Find: Archival Fonds and Collections";
				break;
				# ---------------------------
				case "vessels":
					$vs_section = "Find: Vessels";
				break;
				# ---------------------------
				case "advanced":
					switch(strToLower($this->request->getActionExtra())){
						case "archival_items":
							$vs_section = "Advanced Search: Archival Items";
						break;
						# ---------------------------
						case "artifacts":
							$vs_section = "Advanced Search: Artifacts";
						break;
						# ---------------------------
						case "archives":
							$vs_section = "Advanced Search: Archival Fonds and Collections";
						break;
						# ---------------------------
					}
				break;
				# ---------------------------
			}
			$va_breadcrumb[] = $vs_section;			
		break;
		# -----------------------------------------------------
		case "collections":
			# --- detail done in that view
			$va_breadcrumb[] = caNavLink($this->request, _t("Archival Fonds and Collections"), "", "", "Collections", "Index");
			
		break;
		# -----------------------------------------------------
		
	}
	if(sizeof($va_breadcrumb) > 1){
		print "<div class='breadcrumb'>".join(" > ", $va_breadcrumb)."</div>";
	}
?>
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
