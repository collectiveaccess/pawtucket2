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
	$va_access_values = caGetUserAccessValues($this->request);

?><!DOCTYPE html>
<html lang="en">
	<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-19709178-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-19709178-1');
	</script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	
	<meta property="og:url" content="<?php print $this->request->config->get("site_host").caNavUrl($this->request, "*", "*", "*"); ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:description" content="<?php print htmlspecialchars((MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name")); ?>" />
	<meta property="og:title" content="<?php print $this->request->config->get("app_display_name"); ?>" />
<?php
	# --- what should the image to share be?
	# --- default to logo --- use image from detail page if on object page
	$vs_og_image = $this->request->config->get("site_host").caGetThemeGraphicUrl($this->request, 'NOORDERKEMPEN_logo.jpg'); # --- replace this with logos for institutions
	if((strToLower($this->request->getController()) == "detail") && (strToLower($this->request->getAction()) == "objects")){
		$ps_id = str_replace("~", "/", urldecode($this->request->getActionExtra()));
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
    <link rel="stylesheet" type="text/css" href="<?php print $this->request->getAssetsUrlPath(); ?>/mirador/css/mirador-combined.css">
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>

</head>
<body>
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
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'NOORDERKEMPEN_logo.jpg'), "navbar-brand", "", "","");
				#print caNavLink($this->request, _t("Erfgoed Noorderkempen"), "navbar-brand", "", "","");
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
							<input type="text" class="form-control" id="headerSearchInput" placeholder="Zoek" name="search">
						</div>
						<button type="submit" class="btn-search" id="headerSearchButton"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>
				<script type="text/javascript">
					$(document).ready(function(){
						$('#headerSearchButton').prop('disabled',true);
						$('#headerSearchInput').keyup(function(){
							$('#headerSearchButton').prop('disabled', this.value == "" ? true : false);     
						})
					});
				</script>
				<ul class="nav navbar-nav navbar-right menuItems">
					<li class="dropdown<?php print ($this->request->getController() == "About") ? ' active' : ''; ?>" style="position:relative;">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Over ons</a>
						<ul class="dropdown-menu">
							<li><?php print caNavLink($this->request, "Over deze website", "", "", "About", "About"); ?></li>
							<li><?php print caNavLink($this->request, "Handleiding", "", "", "About", "Guide"); ?></li>
						</ul>
					</li>
					<?php print $this->render("pageFormat/browseMenu.php"); ?>	
					<li <?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, "Zoeken", "", "", "Search", "advanced/objects"); ?></li>
					<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, "THEMA'S", "", "", "Gallery", "Index"); ?></li>
					<li <?php print ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, "Collecties", "", "", "Collections", "index"); ?></li>					
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
