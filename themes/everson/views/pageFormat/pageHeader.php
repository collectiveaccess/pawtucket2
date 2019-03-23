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
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700' rel='stylesheet' type='text/css'>
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>
<?php
	if(Debug::isEnabled()) {		
		//
		// Pull in JS and CSS for debug bar
		// 
		$o_debugbar_renderer = Debug::$bar->getJavascriptRenderer();
		$o_debugbar_renderer->setBaseUrl(__CA_URL_ROOT__.$o_debugbar_renderer->getBaseUrl());
		print $o_debugbar_renderer->renderHead();
	}
?>
</head>
<body>

	
<div class="page">
  <div class="wrapper">
	<div class="sidebar">
<?php
		print "<a href='http://www.everson.org'>".caGetThemeGraphic($this->request, 'logo.svg')."</a>";
?>
		<span class="logo-description">Everson Museum of art</span>
		
		<nav>
    		<ul class="navigation">
    			<!--<li class="home"><a href="http://everson.org/" target="_self" class="home">Home</a></li>
    			<li class="about"><a href="http://everson.org/about" target="_self" class="about">About</a> 
    				<div class="sub-menu"> <i> </i>
						<ul class="left-links">
							<li class="about"><a href="http://everson.org/about" target="_self" class="about">About</a></li>
							<li class="history"><a href="http://everson.org/about/history-museum" target="_self" class="history">History</a></li>
							<li class="thebuilding"><a href="http://everson.org/about/history-architecture" target="_self" class="thebuilding">The Building</a></li>
							<li class="staff/leadership"><a href="http://everson.org/about/staff-board" target="_self" class="staff/leadership">Staff/Leadership</a></li>
							<li class="opportunities"><a href="http://everson.org/about/employment" target="_self" class="opportunities">Opportunities</a></li>
							<li class="museumpolicies"><a href="http://everson.org/about/policies" target="_self" class="museumpolicies">Museum Policies</a></li>
						</ul>
    				</div>
    			</li>
    			<li class="visit"><a href="http://everson.org/visit" target="_self" class="visit">Visit</a> 
    				<div class="sub-menu"> <i> </i>
    					<ul class="left-links">
    						<li class="visit"><a href="http://everson.org/visit" target="_self" class="visit">Visit</a></li>
    						<li class="groups"><a href="http://everson.org/visit/groups" target="_self" class="groups">Groups</a></li>
    						<li class="museummap"><a href="http://everson.org/visit/museum-map" target="_self" class="museummap">Museum Map</a></li>
    						<li class="photography"><a href="http://everson.org/visit/location-photos" target="_self" class="photography">Photography</a></li>
    					</ul>
    				</div>
    			</li>
    			<li class="explore"><a href="http://everson.org/explore" target="_self" class="explore">Explore</a> 
    				<div class="sub-menu"> <i> </i>
    					<ul class="left-links">
    						<li class="explore"><a href="http://everson.org/Explore" target="_self" class="explore">Explore</a></li>
    						<li class="permanentcollection"><a href="http://everson.org/explore/collections" target="_self" class="permanentcollection">Permanent Collection</a></li>
    						<li class="currentexhibitions"><a href="http://everson.org/explore/current-exhibitions" target="_self" class="currentexhibitions">CURRENT EXHIBITIONS</a></li>
    						<li class="policies"><a href="http://everson.org/explore/policies" target="_self" class="policies">Policies</a></li>
    						<li class="upcomingexhibitions"><a href="http://everson.org/explore/upcoming-exhibitions" target="_self" class="upcomingexhibitions">UPCOMING EXHIBITIONS</a></li>
    		    			<li class="searchcollection"><?php print caNavLink($this->request, "Search Collection and Archive", "searchcollection", '', '', '');?></li>
			
    					</ul>
    				</div>
    			</li>
    			<li class="learn"><a href="http://everson.org/learn" target="_self" class="learn">Learn</a> 
    				<div class="sub-menu"> <i> </i>
    					<ul class="left-links">
    						<li class="learn"><a href="http://everson.org/learn" target="_self" class="learn">Learn</a></li>
    						<li class="outreach"><a href="http://everson.org/learn/outreach" target="_self" class="outreach">Outreach</a></li>
    						<li class="classes"><a href="http://everson.org/learn/classes" target="_self" class="classes">Classes</a></li>
    						<li class="educators"><a href="http://everson.org/learn/educators" target="_self" class="educators">Educators</a></li>
    						<li class="familyprograms"><a href="http://everson.org/learn/family-programs" target="_self" class="familyprograms">Family Programs</a></li>
    						<li class="publictours"><a href="http://everson.org/visit/tours" target="_self" class="publictours">Public Tours</a></li>
    						<li class="talksandlectures"><a href="http://everson.org/connect/gallery-talks-lectures" target="_self" class="talksandlectures">Talks and Lectures</a></li>
    						<li class="docents"><a href="http://everson.org/learn/docent" target="_self" class="docents">Docents</a></li>
    						<li class="schooltours"><a href="http://everson.org/learn/school-tours" target="_self" class="schooltours">School Tours</a></li>
    					</ul>
    				</div>
    			</li>
    			<li class="connect"><a href="http://everson.org/connect" target="_self" class="connect">Connect</a> 
    				<div class="sub-menu"> <i> </i>
    					<ul class="left-links">
    						<li class="connect"><a href="http://everson.org/connect" target="_self" class="connect">Connect</a></li>
    						<li class="talksandlectures"><a href="http://everson.org/connect/gallery-talks-lectures" target="_self" class="talksandlectures">Talks and Lectures</a></li>
    						<li class="specialevents"><a href="http://everson.org/connect/events" target="_self" class="specialevents">Special Events</a></li>
    						<li class="trips"><a href="http://everson.org/connect/trips" target="_self" class="trips">Trips</a></li>
    						<li class="annualevents"><a href="http://everson.org/connect/annual-events" target="_self" class="annualevents">Annual Events</a></li>
    						<li class="films"><a href="http://everson.org/connect/film" target="_self" class="films">Films</a></li>
    						<li class="getinvolved"><a href="http://everson.org/connect/get-involved" target="_self" class="getinvolved">Get Involved</a></li>
    						<li class="publictours"><a href="http://207.58.191.75/~everson/index.php/visit/tours" target="_self" class="publictours">Public Tours</a></li>
    						<li class="callforartists"><a href="http://everson.org/connect/call-artists" target="_self" class="callforartists">Call For Artists</a></li>
    					</ul>
    				</div>
    			</li>
    			<li class="join"><a href="http://everson.org/join" target="_self" class="join">Join</a> 
    				<div class="sub-menu"> <i> </i>
    					<ul class="left-links">
    						<li class="join"><a href="http://everson.org/join" target="_self" class="join">Join</a></li>
    						<li class="reciprocalmuseums"><a href="http://everson.org/join/reciprocal-museums" target="_self" class="reciprocalmuseums">Reciprocal Museums</a></li>
    						<li class="individualmembership"><a href="http://everson.org/join/individual-membership" target="_self" class="individualmembership">Individual Membership</a></li>
    						<li class="giftmemberships"><a href="http://everson.org/join/gifts-memberships" target="_self" class="giftmemberships">Gift Memberships</a></li>
    						<li class="corporatemembership"><a href="http://everson.org/join/corporate-membership" target="_self" class="corporatemembership">Corporate Membership</a></li>
    					</ul>
    				</div>
    			</li>
    			<li class="shop"><a href="http://everson.org/shop" target="_self" class="shop">Shop</a></li>
    			<li class="contact"><a href="http://everson.org/contact" target="_self" class="contact">Contact</a></li>
    			<li class="support"><a href="http://everson.org/support" target="_self" class="support">Support</a> 
    				<div class="sub-menu"> <i> </i>
    					<ul class="left-links">
    						<li class="support"><a href="http://everson.org/support" target="_self" class="support">Support</a></li>
    						<li class="sponsorshipopportunities"><a href="http://everson.org/support/levels-giving" target="_self" class="sponsorshipopportunities">Sponsorship Opportunities</a></li>
    						<li class="oursponsors"><a href="http://everson.org/support/sponsors" target="_self" class="oursponsors">Our Sponsors</a></li>
    					</ul>
    				</div>
    			</li>-->
    		</ul>
    	</nav>		
		
		
	</div>
    <div class="content-wrapper">
      <div class="content-inner">
      

	
	<div class="container" style="padding:0px;"><div class="row" style="margin:0px;"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
<?php
			if ($this->request->getController() != "Front") {
				print '<div class="page-title-container clearfix">
    						<h1 class="page-title">'.caNavLink($this->request, 'American Ceramics & Ceramic National Exhibition Archive', '', '', '', '').'</h1>
						</div>';
?>						
	<nav class="navbar navbar-default yamm" role="navigation">
		<div class="container" style='padding-left:0px;padding-right:0px;'>
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
							<input type="text" class="form-control" placeholder="Search" name="search">
						</div>
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>
				<ul class="nav navbar-nav navbar-right">
					<li <?php print ($this->request->getController() == "Collection") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Collections"), "", "FindingAid", "Collection", "Index"); ?></li>				
					<?php print $this->render("pageFormat/browseMenu.php"); ?>	
					<li <?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/objects"); ?></li>
					<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Gallery"), "", "", "Gallery", "Index"); ?></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>						
<?php						
						
			}
?>		
