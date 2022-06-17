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
<body class="tm-sidebar-a-right tm-sidebars-1 tm-isblog home tm-navbar-fixed">
	<div id="skipNavigation"><a href="#main">Skip to main content</a></div>
	<div class="tm-toolbar uk-clearfix uk-hidden-small">
    	<div class="toolbar-container">        
			<div class="uk-float-right"><div class="uk-panel">
				<div class="header-text"><strong>ALUTIIQ MUSEUM &nbsp;<span class="header-small">215 Mission Road, Kodiak, Alaska 99615 &nbsp; |&nbsp; 844-425-8844&nbsp; |&nbsp; <a href="https://alutiiqmuseum.org/calendar">view calendar &gt;</a></span> | <a href="https://alutiiqmuseum.org/search" class="header-small">search &gt;</a></strong></div>
			</div></div>
        </div>
    </div>
    <nav class="tm-navbar uk-navbar uk-position-z-index">
    <div class="navbar-overhang">
    <div class="navbar-container">
    <div class="uk-flex uk-flex-middle uk-flex-center uk-flex-space-between">

        <a class="tm-logo uk-hidden-small" href="https://alutiiqmuseum.org"><?php print caGetThemeGraphic($this->request, 'AlutiiqMuseum_Logo.png', array("alt" => "Alutiiq Museum", "role" => "banner")); ?></a>
        
		<div class="tm-nav uk-hidden-small">
			<ul class="uk-navbar-nav uk-hidden-small">
				<li class="uk-parent" data-uk-dropdown="{'preventflip':'y'}" aria-haspopup="true" aria-expanded="false"><a href="#">VISIT</a>
					<div class="uk-dropdown uk-dropdown-navbar uk-dropdown-width-1 uk-dropdown-center"><div class="uk-grid uk-dropdown-grid"><div class="uk-width-1-1">
						<ul class="uk-nav uk-nav-navbar"><li><a href="https://alutiiqmuseum.org/visit/our-mission">Our Mission</a></li><li><a href="https://alutiiqmuseum.org/visit/location-hours-admission">Location, Hours, Admission</a></li><li><a href="https://forms.zohopublic.com/alutiiqm/form/TourReservationForm/formperma/G0EFrVHK1saQg_eNFd2tktuSFjZtoB5V3qwwU599gbs">Schedule a Tour</a></li><li><a href="https://alutiiqmuseum.org/visit/on-exhibit">Exhibits</a></li><li><a href="https://alutiiqmuseum.org/visit/upcoming-events">Events</a></li><li><a href="http://ancestorsmemorial.org/" target="_blank" rel="noopener noreferrer">Ancestors' Memorial</a></li></ul>
					</div></div></div>
				</li>
				<li class="uk-parent" data-uk-dropdown="{'preventflip':'y'}" aria-haspopup="true" aria-expanded="false"><a href="#">LEARN</a>
					<div class="uk-dropdown uk-dropdown-navbar uk-dropdown-width-1 uk-dropdown-center"><div class="uk-grid uk-dropdown-grid"><div class="uk-width-1-1">
						<ul class="uk-nav uk-nav-navbar"><li><a href="https://alutiiqmuseum.org/learn/the-alutiiq-sugpiaq-people">Alutiiq / Sugpiaq People</a></li><li><a href="https://alutiiqmuseum.org/learn/plant-gallery">Plant Gallery</a></li><li><a href="https://alutiiqmuseum.org/learn/contest">Coloring Alutiiq</a></li>
							<li><?php print caNavLink($this->request, "Alutiiq Word of the Week", "", "", "Word", "Index"); ?></li>
							<li><?php print caNavLink($this->request, "Word of the Week Archive", "", "", "browse", "words"); ?></li>
							<li><a href="https://alutiiqmuseum.org/teachers">For Teachers</a></li><li><a href="https://alutiiqmuseum.org/learn/history-of-the-alutiiq-museum">Museum History</a></li><li><a href="https://alutiiqmuseum.org/learn/ask-a-question">Ask A Question</a></li>
						</ul>
					</div></div></div>
				</li>
				<li class="uk-parent" data-uk-dropdown="{'preventflip':'y'}" aria-haspopup="true" aria-expanded="false"><a href="#">EXPLORE</a>
					<div class="uk-dropdown uk-dropdown-navbar uk-dropdown-width-1 uk-dropdown-center">
						<div class="uk-grid uk-dropdown-grid">
							<div class="uk-width-1-1">
								<ul class="uk-nav uk-nav-navbar"><li><a href="https://alutiiqmuseum.org/explore/collections">Collections</a></li><li><a href="https://alutiiqmuseum.org/explore/past-exhibits">Past Exhibits</a></li><li><a href="https://alutiiqmuseum.org/explore/crafts">Crafts</a></li><li><a href="https://alutiiqmuseum.org/explore/uswitusqaq-s-dream">Uswitusqaq's Dream</a></li><li><a href="https://alutiiqmuseum.org/explore/lecture-videos">Videos</a></li><li><a href="https://alutiiqmuseum.org/explore/virtual-tour">Virtual Tour</a></li><li><a href="https://alutiiqmuseum.org/explore/cultural-experiences">Cultural Experiences</a></li></ul>
							</div>
						</div>
					</div>
				</li>
				<li class="uk-parent" data-uk-dropdown="{'preventflip':'y'}" aria-haspopup="true" aria-expanded="false"><a href="#">RESEARCH</a>
					<div class="uk-dropdown uk-dropdown-navbar uk-dropdown-width-1 uk-dropdown-center uk-dropdown-bottom" aria-hidden="true" style="top: 30px; left: -43px;" tabindex=""><div class="uk-grid uk-dropdown-grid"><div class="uk-width-1-1">
						<ul class="uk-nav uk-nav-navbar"><li><a href="https://alutiiqmuseum.org/research/archeology">Archaeology</a></li><li><a href="http://languagearchive.alutiiqmuseum.org/home" target="_blank" rel="noopener noreferrer">Language Collections</a></li><li><a href="https://alutiiqmuseum.org/research/language-collections">Language Studies</a></li><li><a href="https://alutiiqmuseum.org/research/library">Library</a></li><li><a href="https://alutiiqmuseum.org/research/photos">Share Photos</a></li><li><?php print caNavLink($this->request, "Amutat Database", "", "", "", ""); ?></li></ul>
					</div></div></div>
				</li>
				<li class="uk-parent" data-uk-dropdown="{'preventflip':'y'}" aria-haspopup="true" aria-expanded="false"><a href="#">SHOP</a>
					<div class="uk-dropdown uk-dropdown-navbar uk-dropdown-width-1 uk-dropdown-center"><div class="uk-grid uk-dropdown-grid"><div class="uk-width-1-1">
						<ul class="uk-nav uk-nav-navbar"><li><a href="https://alutiiqmuseumstore.org" target="_blank" rel="noopener noreferrer">Museum Store</a></li><li><a href="https://alutiiqmuseum.org/shop/artist-bios">Artists</a></li><li><a href="https://alutiiqmuseum.org/shop/the-alutiiq-seal">The Alutiiq Seal</a></li><li><a href="https://alutiiqmuseum.org/shop/arts-advocacy">Arts Advocacy</a></li><li><a href="https://alutiiqmuseum.org/shop/info-for-artists">Sell &amp; Consign</a></li></ul>
					</div></div></div>
				</li>
				<li class="uk-parent" data-uk-dropdown="{'preventflip':'y'}" aria-haspopup="true" aria-expanded="false"><a href="https://alutiiqmuseum.org/give">GIVE</a>
					<div class="uk-dropdown uk-dropdown-navbar uk-dropdown-width-1 uk-dropdown-center"><div class="uk-grid uk-dropdown-grid"><div class="uk-width-1-1">
						<ul class="uk-nav uk-nav-navbar"><li><a href="https://alutiiqmuseum.org/give/donations">Donations</a></li><li><a href="https://alutiiqmuseum.org/give">Membership</a></li><li><a href="https://alutiiqmuseum.org/give/sponsor">Sponsor</a></li><li><a href="https://alutiiqmuseum.org/give/serve">Serve</a></li><li><a href="https://alutiiqmuseum.org/give/volunteers">Volunteer</a></li></ul>
					</div></div></div>
				</li>
			</ul>        
		</div>
        
                <a href="#offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas=""></a>
        
        
                <div class="uk-navbar-content uk-navbar-center uk-visible-small"><a class="tm-logo-small" href="https://alutiiqmuseum.org"><?php print caGetThemeGraphic($this->request, 'AlutiiqMuseum_Logo.png', array("alt" => "Alutiiq Museum", "role" => "banner")); ?></a></div>
    </div>
    </div>    
    </div>
    
    </nav>
	
	
	<div class="container" style="clear:both;"><div class="row"><div class="col-xs-12">
		<div role="main" id="main"><div id="pageArea" <?php print caGetPageCSSClasses(); ?>><div class="content-area">
<?php
	if(in_array(strToLower($this->request->getController()), array("word", "about")) || in_array(strToLower($this->request->getAction()), array("words", "word"))){
?>
			<div class="subNav">
				<div class="row">
					<div class="col-xs-12 col-sm-6">
						<ul class="uk-breadcrumb"><li><a href="https://alutiiqmuseum.org/">Home</a></li><li><span>LEARN</span></li><li class="uk-active"><span><?php print caNavLink($this->request, "Alutiiq Work of the Week", "", "", "Word", "Index"); ?></span></li></ul>
					</div>
					<div class="col-xs-12 col-sm-6">
						<div class="subNavJumpTo">Jump to: <?php print caNavLink($this->request, "Lesson", "", "", "Word", "Index")." | ".caNavLink($this->request, "Archive", "", "", "browse", "words")." | ".caNavLink($this->request, "About", "", "", "About", ""); ?></div>
					</div>
				</div>
			</div>
<?php	
	}else{
?>
			<div class="subNav">
				<div class="row">
					<div class="col-xs-12 col-sm-6">
						<ul class="uk-breadcrumb"><li><a href="https://alutiiqmuseum.org/">Home</a></li><li><span>RESEARCH</span></li><li class="uk-active"><span><?php print caNavLink($this->request, "Amutat", "", "", "", ""); ?></span></li></ul>
					</div>
					<div class="col-xs-12 col-sm-6">
						<div class="subNavJumpTo">Jump to: <?php print caNavLink($this->request, "Amutat Home", "", "", "", "")." | ".caNavLink($this->request, "Institutions", "", "", "browse", "institutions")." | ".caNavLink($this->request, "Objects", "", "", "browse", "amutatObjects"); ?></div>
					</div>
				</div>
			</div>
<?php
	}
?>