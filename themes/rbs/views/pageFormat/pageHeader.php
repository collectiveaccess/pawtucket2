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
		if(caDisplayLightbox($this->request)){
			$va_user_links[] = "<li>".caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
		}
		if(caDisplayClassroom($this->request)){
			$va_user_links[] = "<li>".caNavLink($this->request, $vs_classroom_sectionHeading, '', '', 'Classroom', 'Index', array())."</li>";
		}
		$va_user_links[] = "<li>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
		$va_user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
#		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
#		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
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
	<link href="https://fonts.googleapis.com/css?family=Lato|Montserrat" rel="stylesheet">

</head>
<body>

<div class="page">
	<div class="wrapper">
		<div class="sidebar">     
<?php
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'silva_400.jpg'), "navbar-brand", "", "","");
?>
		<form class="searchForm" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
			<div class="formOutline">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Search" name="search">
					<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
				</div>
			</div>
		</form>
		<ul class="nav navbar-nav menuLinks">
			<li <?php print ($this->request->getController() == "About") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About"), "", "", "About", "Index"); ?></li>
			<li <?php print (($this->request->getController() == "About") && ($this->request->getAction() == "browse")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Browse"), "", "", "Browse", "objects"); ?></li>			
			<li <?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/objects"); ?></li>
			<?php print join("\n", $va_user_links); ?>
		</ul>
	</div><!-- end sidebar -->
	<div class="content-wrapper">
      	<div class="content-inner">
			<div class="container"><div class="row"><div class="col-xs-12" style="padding-top:15px;">
				<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
