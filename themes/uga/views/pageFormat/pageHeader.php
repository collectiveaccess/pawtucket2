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
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>

<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//bmac.libs.uga.edu/pikwik/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '1']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
  
  caUI.initUtils();
</script>
<!-- End Piwik Code -->
</head>
<body>
<div id="header-top">
	<div class="container">
		<div id="ugalibs">
			<a href="http://www.libs.uga.edu/scl">University of Georgia Special Collections Libraries</a>
		</div>
	</div>
</div>

	<nav class="navbar navbar-default yamm" role="navigation">
		<div class="container">
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
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'ca_nav_logo300.png'), "navbar-brand", "", "","");
?>
				<div class="name"> The Walter J. Brown Media Archives <br> & Peabody Awards Collection</div>
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
				<ul class="nav navbar-nav navbar-right" id="main-menu">
					<li  <?php print ($this->request->getController() == "FindingAids") ? 'class="dropdown active"' : 'class="dropdown"'; ?>>
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Browse Collections<span class="caret"></span></a>
					  <ul class="dropdown-menu">
				
						
						<li <?php print ($this->request->getController() == "Browse All") ? 'class="active"' : ''; ?>>
						<?php print caNavLink($this->request, _t("Browse All"), "", "", "FindingAids", "Collections"); ?></li>
						<li><a href="https://bmac.libs.uga.edu/index.php/Peabody/Index">Peabody</a></li>
						<li><a href="https://bmac.libs.uga.edu/index.php/Newsfilm/Index">Newsfilm</a></li>
						<li <?php print ($this->request->getController() == "Audio/Radio") ? 'class="active"' : ''; ?>>
						<?php print caNavLink($this->request, _t("Audio/Radio"), "", "", "FindingAids", "Collections",
							 array('key' => '8e901317e36cd5591162a1079efcc97a', 'facet' => 'collection_area', 'id' => '1015', 'view' => 'images')); ?></li>
						<li <?php print ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>>
						<?php print caNavLink($this->request, _t("Educational"), "", "", "FindingAids", "Collections",
							 array('key' => '8e901317e36cd5591162a1079efcc97a', 'facet' => 'collection_area', 'id' => '1016', 'view' => 'images')); ?></li>
						<li <?php print ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>>
						<?php print caNavLink($this->request, _t("Georgia Related"), "", "", "FindingAids", "Collections",
							 array('key' => '8e901317e36cd5591162a1079efcc97a', 'facet' => 'collection_area', 'id' => '1017', 'view' => 'images')); ?></li>
						<li <?php print ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>>
						<?php print caNavLink($this->request, _t("Home Movies/Amateur Films"), "", "", "FindingAids", "Collections",
							 array('key' => '8e901317e36cd5591162a1079efcc97a', 'facet' => 'collection_area', 'id' => '1018', 'view' => 'images')); ?></li>
						<li <?php print ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>>
						<?php print caNavLink($this->request, _t("Interviews"), "", "", "FindingAids", "Collections",
							 array('key' => '8e901317e36cd5591162a1079efcc97a', 'facet' => 'collection_area', 'id' => '1019', 'view' => 'images')); ?></li>
							 	
						<li <?php print ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>>
						<?php print caNavLink($this->request, _t("Religious Broadcasting"), "", "", "FindingAids", "Collections",
							 array('key' => '8e901317e36cd5591162a1079efcc97a', 'facet' => 'collection_area', 'id' => '1022', 'view' => 'images')); ?></li>
						<li <?php print ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>>
						<?php print caNavLink($this->request, _t("Georgia Town Films"), "", "", "FindingAids", "Collections",
							 array('key' => '8e901317e36cd5591162a1079efcc97a', 'facet' => 'collection_area', 'id' => '1024', 'view' => 'images')); ?></li>
						<li <?php print ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>>
						<?php print caNavLink($this->request, _t("TV Broadcasting"), "", "", "FindingAids", "Collections",
							 array('key' => '8e901317e36cd5591162a1079efcc97a', 'facet' => 'collection_area', 'id' => '1023', 'view' => 'images')); ?></li>
						<li <?php print ($this->request->getController() == "Collections") ? 'class="active"' : ''; ?>>
						<?php print caNavLink($this->request, _t("UGA Related"), "", "", "FindingAids", "Collections",
							 array('key' => '8e901317e36cd5591162a1079efcc97a', 'facet' => 'collection_area', 'id' => '1025', 'view' => 'images')); ?></li>
						
					  </ul>
					</li>
					<li <?php print ($this->request->getController() == "Peabody") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Peabody"), "", "", "Peabody", "Index"); ?></li>
					<li <?php print ($this->request->getController() == "Newsfilm") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Newsfilm"), "", "", "Newsfilm", "Index"); ?></li>
					<li <?php print ($this->request->getController() == "Licensing") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Licensing"), "", "", "Licensing", "Index"); ?></li>
					<li <?php print ($this->request->getController() == "Donate") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Donate"), "", "", "Donate", "Index"); ?></li>
					<li <?php print ($this->request->getController() == "About") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About"), "", "", "About", "Index"); ?></li>
					<li <?php print ($this->request->getController() == "Contact") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contact"), "", "", "Contact", "Form"); ?></li>			
					<li <?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active"' : ''; ?>>
					<?php print caNavLink($this->request, _t("Search Collections"), "", "", "Search", "advanced/objects"); ?></li>
					<li>
						<form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>" class="form-inline menuSearch"
						style="background-color: white; border: 2px solid darkgray; margin-top: -3px;">
							<input class="form-control query width100" id="brownSearch" name="search" placeholder="Search" style="color: gray;text-align: right;" type="text">
							<button class="btn btn-primary" id="searchButton" name="rows" type="submit" value="20"><i class="fa fa-search"></i></button>
						</form>	
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
