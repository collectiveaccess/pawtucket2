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
#		if(caDisplayLightbox($this->request)){
#			$va_user_links[] = "<li>".caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
#		}
#		if(caDisplayClassroom($this->request)){
#			$va_user_links[] = "<li>".caNavLink($this->request, $vs_classroom_sectionHeading, '', '', 'Classroom', 'Index', array())."</li>";
#		}
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
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'HFF_DB_logoFinal.png'), "navbar-brand", "", "","");
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
							<input type="text" class="form-control" id="headerSearchInput" placeholder="Search" name="search">
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
					<li class="<?php print ((strToLower($this->request->getController()) == "browse") && (in_array(strToLower($this->request->getAction()), array("artworks", "artworks_hff", "artworks_nonhff")))) ? 'active' : ''; ?> dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Artworks</a>
						<ul class='dropdown-menu'>
							<li <?php print ((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "artworks")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("All Artworks"), "", "", "Browse", "artworks"); ?></li>
							<li <?php print ((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "artworks_HFF")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("HFF Artworks"), "", "", "Browse", "artworks_HFF"); ?></li>
							<li <?php print ((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "artworks_nonHFF")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Non HFF Artworks"), "", "", "Browse", "artworks_nonHFF"); ?></li>
						</ul>
					</li>
					<li class="<?php print (((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "digital_items")) || (strToLower($this->request->getController()) == "collections")) ? 'active' : ''; ?> dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Archives</a>
						<ul class='dropdown-menu'>
							<li <?php print ((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "digital_items")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Digital Items"), "", "", "Browse", "digital_items"); ?></li>
							<li <?php print (strToLower($this->request->getController()) == "collections") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Finding Aids"), "", "", "Collections", "index"); ?></li>					
						</ul>
					</li>
					<li <?php print ((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "library")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Library"), "", "", "Browse", "library"); ?></li>
					<li <?php print ((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "exhibitions")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Exhibitions"), "", "", "Browse", "exhibitions"); ?></li>
					<li <?php print ((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "chronology")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Chronology"), "", "", "Browse", "chronology"); ?></li>
					<li <?php print ((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "references")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("References"), "", "", "Browse", "references"); ?></li>
					<li <?php print (strToLower($this->request->getController()) == "gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Features"), "", "", "Gallery", "Index"); ?></li>
<?php
					if($this->request->isLoggedIn()){
						if(caDisplayLightbox($this->request)){
							print "<li>".caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
						}
					}
?>					
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
