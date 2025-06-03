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
    	
    		jQuery('.more-button').on('click',function() { jQuery('.is-child').show(); jQuery('.more-button').hide(); jQuery('.less-button').show(); });
    		jQuery('.less-button').on('click',function() { jQuery('.is-child').hide(); jQuery('.less-button').hide(); jQuery('.more-button').show(); });
    	

                        
                        jQuery(".menu-button").on("click", function () {
                            jQuery("#main-menu .header-nav").hasClass("is-open")
                                ? (jQuery("body").removeClass("menu-is-open"), jQuery("#main-menu .header-nav").removeClass("is-open"), (jQuery(".menu-button").html("Menu")))
                                : (jQuery("body").addClass("menu-is-open"), jQuery("#main-menu .header-nav").css("display", "flex"), jQuery("#main-menu .header-nav").addClass("is-open"), (jQuery(".menu-button").html("Close")));
                        });
    		
    		
    	});
    	
    	
    	
    	
    	
    	
	</script>

</head>
<body>
	<div id="skipNavigation"><a href="#main">Skip to main content</a></div>
	<header id="masthead" class="header">
	<div class="header--container is-mobile">

    <button class="menu-button">Menu</button>

    <a class="logo center" href="https://centerforbookarts.org/">
      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1537.45 118.22"><g><path d="M101.64,79.36c-0.97,4.72-2.28,8.94-4.55,13.33c-5.2,10.08-17.72,25.04-45.2,25.04c-5.53,0-19.35-0.16-32.04-9.92 C0.17,92.53,0,65.54,0,59.36c0-4.55,0.17-24.23,10.41-39.03c2.93-4.39,6.66-7.97,11.06-11.22C33.99,0.16,47.65,0,53.01,0 c20.16,0,37.4,8.78,44.56,28.62c1.47,3.9,1.95,6.34,2.6,10.4l-15.45,1.47c-0.81-3.25-2.6-12.2-10.24-19.19 c-3.58-3.25-9.92-7.64-21.47-7.64c-4.07,0-14.15,0.32-22.93,7.81c-3.42,3.09-5.69,6.5-6.51,7.8c-3.25,5.04-7.32,15.45-7.32,30.41 c0,3.09,0.16,18.87,7.64,29.92c3.25,5.04,12.19,14.96,28.78,14.96s25.37-10.25,28.62-15.12c1.95-2.93,3.25-5.53,5.21-12.04 L101.64,79.36z"></path><path d="M130.08,78.06c0,1.14-0.17,2.44,0.16,4.72c0.97,8.29,5.37,17.23,13.33,20.81c2.28,1.14,5.69,1.95,11.38,1.95 c3.09,0,12.03-0.16,17.24-8.29c1.95-2.93,2.44-4.87,3.25-8.29l15.29,1.3c-1.62,8.62-4.87,13.01-7.32,15.94 c-10.08,11.87-24.39,11.7-29.11,11.7c-9.43,0-17.56-1.3-25.04-7.48c-14.15-11.55-14.63-31.06-14.63-35.62 c0-5.04,0.49-20.81,11.71-33.01c1.3-1.46,5.69-5.85,11.38-8.46c2.76-1.14,8.46-2.93,16.26-2.93c2.44,0,8.78,0,15.29,2.6 c22.12,9.11,22.12,35.12,22.12,40.49c0,1.46,0,3.09-0.16,4.55H130.08z M175.77,65.86c0-0.82-0.16-3.26-0.65-5.53 c-0.65-2.76-3.58-12.69-13.17-15.94c-1.63-0.65-3.74-1.14-7.81-1.14c-19.51,0-23.09,17.24-24.06,22.77L175.77,65.86z"></path><path d="M226.17,42.93c4.07-5.04,11.06-12.2,26.34-12.2c5.85,0,12.04,1.14,17.08,4.56c12.03,7.97,11.06,23.09,11.06,35.28v45.7 h-15.12V75.13c0-11.87,0.33-19.51-2.44-24.55c-1.46-2.76-5.53-7.16-13.5-7.16c-15.61,0-20.65,12.19-21.95,17.08 c-0.65,2.6-1.14,5.85-1.14,11.54v44.23h-14.96V32.03h14.63V42.93z"></path><path d="M340.31,32.03v12.36h-15.12v41.63c0,3.09,0,6.18,0.16,9.27c0.32,2.93,0.49,4.07,1.14,5.21c2.27,4.06,7.48,3.9,8.29,3.9 c2.93,0,6.18-0.49,6.83-0.65v12.04c-1.3,0.32-6.02,1.14-10.57,1.14c-1.46,0-8.62,0-13.82-3.42c-6.34-4.23-6.99-10.08-6.83-23.09 V44.39H296.4V32.03h13.98V6.83h14.8v25.2H340.31z"></path><path d="M371.85,78.06c0,1.14-0.16,2.44,0.16,4.72c0.98,8.29,5.37,17.23,13.34,20.81c2.28,1.14,5.69,1.95,11.38,1.95 c3.09,0,12.04-0.16,17.24-8.29c1.95-2.93,2.44-4.87,3.25-8.29l15.29,1.3c-1.62,8.62-4.88,13.01-7.32,15.94 c-10.08,11.87-24.39,11.7-29.11,11.7c-9.43,0-17.56-1.3-25.04-7.48C356.88,98.87,356.4,79.36,356.4,74.8 c0-5.04,0.49-20.81,11.71-33.01c1.3-1.46,5.69-5.85,11.39-8.46c2.76-1.14,8.46-2.93,16.26-2.93c2.44,0,8.78,0,15.29,2.6 c22.11,9.11,22.11,35.12,22.11,40.49c0,1.46,0,3.09-0.16,4.55H371.85z M417.54,65.86c0-0.82-0.16-3.26-0.65-5.53 c-0.65-2.76-3.58-12.69-13.17-15.94c-1.62-0.65-3.74-1.14-7.8-1.14c-19.51,0-23.09,17.24-24.07,22.77L417.54,65.86z"></path><path d="M467.29,46.35c1.46-3.25,3.09-5.53,5.53-7.97c4.88-4.88,10.57-6.83,17.57-6.83c1.62,0,3.25,0,6.5,0.49l-0.17,14.31 c-3.25-0.49-10.08-1.3-17.72,3.42c-3.58,2.28-8.62,6.51-10.25,16.43c-0.65,4.07-0.81,11.54-0.81,21.79v28.3H453.3V32.03h13.98 V46.35z"></path><path d="M581.59,44.39v71.88h-14.8V44.39h-13.66V32.03h13.66V28.3c0.17-6.99,0-14.15,4.88-20c3.41-4.07,8.62-6.99,19.51-6.99 c2.6,0,5.21,0.16,7.64,0.33v12.68c-7.48-0.49-12.85-0.49-15.29,2.44c-1.95,2.44-1.79,5.86-1.95,11.71v3.57h17.24v12.36H581.59z"></path><path d="M667.28,115.13c-5.69,2.28-11.87,2.76-18.05,2.76c-2.44,0-8.46,0-14.64-1.95c-11.54-3.9-24.39-14.96-24.39-41.47 c0-3.9,0-18.87,8.78-30.25c1.14-1.46,3.25-4.07,6.99-6.67c9.76-7.15,20.16-7.15,24.39-7.15c4.55,0,15.29,0,25.37,7.97 c14.47,11.54,14.63,31.06,14.63,35.94C690.36,99.36,677.03,111.07,667.28,115.13z M674.27,65.21 c-2.12-13.66-9.76-22.44-24.23-22.44c-7.48,0-11.87,2.6-14.47,4.55c-5.53,4.23-10.25,12.36-10.25,27.32 c0,10.41,2.44,17.4,4.72,21.14c1.14,1.79,3.09,4.39,7.32,6.99c5.37,3.09,11.06,3.25,13.01,3.25c2.44,0,8.29-0.16,13.98-4.06 c8.94-6.35,10.73-17.57,10.73-27.65C675.08,73.5,674.92,68.79,674.27,65.21z"></path><path d="M724.5,46.35c1.46-3.25,3.09-5.53,5.53-7.97c4.88-4.88,10.57-6.83,17.56-6.83c1.63,0,3.25,0,6.5,0.49l-0.16,14.31 c-3.25-0.49-10.08-1.3-17.73,3.42c-3.57,2.28-8.62,6.51-10.24,16.43c-0.65,4.07-0.81,11.54-0.81,21.79v28.3h-14.63V32.03h13.98 V46.35z"></path><path d="M847.09,1.46c6.66,0,13.33-0.16,20,0.17c7.32,0.16,14.8,0.97,21.3,4.72c11.87,6.66,12.52,19.51,12.52,23.58 c0,7.8-2.6,13.33-4.23,15.93c-0.49,0.65-1.46,2.12-3.25,3.58c-4.55,4.39-7.64,5.2-10.4,5.85c5.2,1.46,7.64,2.44,9.92,3.9 c4.55,2.93,11.87,10.24,11.87,24.23c0,3.09-0.49,12.85-6.83,20.98c-2.44,3.09-7.48,7.64-16.91,9.92 c-7.48,1.79-14.31,1.79-29.59,1.95h-31.22V1.46H847.09z M835.71,49.11h12.69c5.85,0,11.38,0,17.07-0.16 c6.83-0.33,12.84-0.81,17.24-6.5c1.3-1.95,3.09-5.04,3.09-10.25c0-7.8-2.93-11.22-5.53-13.33c-1.96-1.46-4.07-2.44-6.35-3.09 c-5.04-1.3-12.36-1.14-23.9-1.14h-14.31V49.11z M835.71,102.77h15.29c14.31,0,23.25-0.32,29.11-3.57 c3.42-1.79,9.27-6.83,9.27-16.75c0-1.95-0.16-6.5-2.93-10.89c-5.85-9.43-17.89-9.11-27.16-9.11c-3.74,0-7.48,0.16-11.22,0.16 h-12.36V102.77z"></path><path d="M978.63,115.13c-5.69,2.28-11.87,2.76-18.05,2.76c-2.44,0-8.46,0-14.63-1.95c-11.55-3.9-24.4-14.96-24.4-41.47 c0-3.9,0-18.87,8.78-30.25c1.14-1.46,3.25-4.07,7-6.67c9.76-7.15,20.16-7.15,24.39-7.15c4.55,0,15.29,0,25.37,7.97 c14.47,11.54,14.63,31.06,14.63,35.94C1001.72,99.36,988.39,111.07,978.63,115.13z M985.62,65.21 c-2.11-13.66-9.76-22.44-24.23-22.44c-7.48,0-11.87,2.6-14.47,4.55c-5.53,4.23-10.25,12.36-10.25,27.32 c0,10.41,2.44,17.4,4.72,21.14c1.14,1.79,3.09,4.39,7.32,6.99c5.37,3.09,11.06,3.25,13.01,3.25c2.44,0,8.29-0.16,13.98-4.06 c8.95-6.35,10.73-17.57,10.73-27.65C986.44,73.5,986.27,68.79,985.62,65.21z"></path><path d="M1075.05,115.13c-5.69,2.28-11.87,2.76-18.05,2.76c-2.44,0-8.46,0-14.63-1.95c-11.55-3.9-24.39-14.96-24.39-41.47 c0-3.9,0-18.87,8.78-30.25c1.14-1.46,3.26-4.07,7-6.67c9.76-7.15,20.16-7.15,24.39-7.15c4.55,0,15.29,0,25.37,7.97 c14.48,11.54,14.64,31.06,14.64,35.94C1098.14,99.36,1084.8,111.07,1075.05,115.13z M1082.04,65.21 c-2.11-13.66-9.76-22.44-24.23-22.44c-7.48,0-11.87,2.6-14.48,4.55c-5.53,4.23-10.24,12.36-10.24,27.32 c0,10.41,2.44,17.4,4.71,21.14c1.14,1.79,3.09,4.39,7.32,6.99c5.37,3.09,11.06,3.25,13.01,3.25c2.44,0,8.29-0.16,13.98-4.06 c8.94-6.35,10.73-17.57,10.73-27.65C1082.86,73.5,1082.69,68.79,1082.04,65.21z"></path><path d="M1133.25,116.27h-14.96V1.46h14.96v67.81l35.94-37.24h18.7l-33.66,33.83l36.1,50.41h-18.7l-27.97-40l-10.41,10.25V116.27z"></path><path d="M1273.07,81.47l-12.68,34.8h-16.1l42.77-114.81h15.29l43.42,114.81h-16.09l-13.01-34.8H1273.07z M1294.7,21.95 l-16.91,46.51h33.99L1294.7,21.95z"></path><path d="M1374.37,46.35c1.46-3.25,3.09-5.53,5.53-7.97c4.87-4.88,10.57-6.83,17.57-6.83c1.62,0,3.25,0,6.5,0.49l-0.16,14.31 c-3.25-0.49-10.08-1.3-17.73,3.42c-3.57,2.28-8.62,6.51-10.24,16.43c-0.65,4.07-0.82,11.54-0.82,21.79v28.3h-14.63V32.03h13.98 V46.35z"></path><path d="M1456.96,32.03v12.36h-15.12v41.63c0,3.09,0,6.18,0.16,9.27c0.33,2.93,0.49,4.07,1.14,5.21c2.28,4.06,7.48,3.9,8.29,3.9 c2.93,0,6.18-0.49,6.83-0.65v12.04c-1.3,0.32-6.01,1.14-10.57,1.14c-1.46,0-8.62,0-13.82-3.42c-6.34-4.23-6.99-10.08-6.82-23.09 V44.39h-13.99V32.03h13.99V6.83h14.79v25.2H1456.96z"></path><path d="M1522.81,59.19c-0.16-1.3-0.16-5.37-1.79-9.11c-1.79-3.9-6.51-8.13-15.93-8.13c-0.98,0-3.74,0-6.35,0.65 c-5.21,1.3-8.94,4.88-8.94,10.41c0,2.28,0.49,4.06,1.62,5.69c2.76,3.74,8.13,4.88,16.59,7.48l5.04,1.46 c1.3,0.32,10.9,3.09,16.43,7.64c5.37,4.23,7.97,10.73,7.97,17.4c0,2.44-0.49,8.62-4.55,14.31c-4.4,6.02-12.04,11.22-27.81,11.22 c-2.12,0-13.82,0-21.95-5.2c-1.62-1.14-4.23-2.93-6.83-7c-1.14-1.46-2.6-3.9-3.74-8.13c-0.81-3.09-1.14-6.35-1.3-9.43l13.98-1.62 c0,1.3,0,4.71,1.14,8.13c1.62,5.04,6.83,11.7,19.03,11.7c5.04,0,11.38-1.46,14.8-5.69c1.62-1.95,2.43-4.39,2.43-6.99 c0-1.62-0.49-5.69-3.9-8.29c-2.76-2.11-6.99-3.58-13.98-5.53l-4.71-1.46c-3.09-0.82-6.01-1.62-8.78-2.76 c-9.93-4.07-16.1-9.92-16.1-21.14c0-10.9,5.69-16.26,9.11-18.54c4.07-3.09,9.76-5.69,20.48-5.69c8.95,0,18.21,1.96,24.72,8.78 c6.51,6.99,6.67,14.63,6.67,18.22L1522.81,59.19z"></path></g></svg>
    </a>

    <div class="header--buttons">
      <div id="mobile-search-portal"><button class="button is-link search-button"><svg viewBox="0 0 32 32" class="search-icon"><g fill="none" fill-rule="evenodd"><g transform="translate(-1427 -36)" stroke="currentColor" stroke-width="2"><g transform="translate(1428 37)"><circle cx="18" cy="11" r="11"></circle><line x1="9" x2=".34615" y1="20.346" y2="29" stroke-linecap="square"></line></g></g></g></svg></button></div>
    </div>

  <div id="main-menu" class="menu-modal">
    <nav class="header-nav" style="display: flex;">
      <div class="bg"></div>
      <ul class="menu">
        <li class="menu-item"><a href="https://centerforbookarts.org/">Home</a></li>
        <li class=" menu-item menu-item-type-post_type menu-item-object-page"><a href="https://centerforbookarts.org/about">About</a></li>
<li class=" menu-item menu-item-type-post_type menu-item-object-page"><a href="https://centerforbookarts.org/classes">Classes</a></li>
<li class=" menu-item menu-item-type-post_type menu-item-object-page"><a href="https://centerforbookarts.org/events">Events</a></li>
<li class=" menu-item menu-item-type-post_type menu-item-object-page"><a href="https://centerforbookarts.org/book-shop">Book Shop</a></li>
<li class=" menu-item menu-item-type-post_type menu-item-object-page"><a href="https://centerforbookarts.org/support">Support</a></li>
<li class="hide-mobile menu-item menu-item-type-custom menu-item-object-custom current-menu-ancestor current-menu-parent menu-item-has-children"><a href="#more">More</a></li>
<li class=" menu-item menu-item-type-post_type menu-item-object-page"><a href="https://centerforbookarts.org/opportunities">Opportunities</a></li>
<li class=" menu-item menu-item-type-post_type menu-item-object-page"><a href="https://centerforbookarts.org/exhibitions">Exhibitions</a></li>
<li class=" menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-1170 current_page_item"><a href="https://centerforbookarts.org/collections">Collections</a></li>
<li class=" menu-item menu-item-type-post_type menu-item-object-page"><a href="https://centerforbookarts.org/resources">Resources</a></li>      </ul>
      <address class="address">
        28 West 27th St, 3rd Fl
New York, NY 10001<br><a href="tel:212-481-0295">212-481-0295</a>      </address>
    </nav>
  </div>
</div>
<div class="header--container is-desktop">

    <a class="logo" href="https://centerforbookarts.org/">
      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 496.88 266.94"><g><path d="M101.63,79.36c-0.98,4.71-2.28,8.94-4.55,13.33c-5.21,10.08-17.73,25.04-45.21,25.04c-5.53,0-19.35-0.16-32.03-9.92 C0.16,92.53,0,65.53,0,59.35c0-4.55,0.16-24.23,10.4-39.03c2.93-4.39,6.67-7.97,11.06-11.22C33.98,0.16,47.64,0,53.01,0 c20.16,0,37.4,8.78,44.56,28.62c1.46,3.9,1.95,6.34,2.6,10.41l-15.45,1.47c-0.82-3.25-2.6-12.2-10.25-19.19 c-3.58-3.25-9.92-7.64-21.47-7.64c-4.07,0-14.15,0.33-22.93,7.81c-3.42,3.09-5.69,6.5-6.5,7.8c-3.25,5.04-7.32,15.45-7.32,30.41 c0,3.09,0.17,18.86,7.64,29.92c3.25,5.04,12.2,14.96,28.78,14.96s25.37-10.24,28.62-15.12c1.95-2.93,3.25-5.53,5.2-12.03 L101.63,79.36z"></path><path d="M130.07,78.05c0,1.14-0.16,2.44,0.16,4.71c0.98,8.29,5.37,17.24,13.34,20.81c2.28,1.14,5.69,1.95,11.38,1.95 c3.09,0,12.04-0.16,17.24-8.29c1.95-2.93,2.44-4.88,3.25-8.29l15.29,1.3c-1.62,8.62-4.88,13.01-7.32,15.94 c-10.08,11.87-24.39,11.71-29.11,11.71c-9.43,0-17.56-1.3-25.04-7.48c-14.15-11.55-14.63-31.06-14.63-35.61 c0-5.04,0.49-20.81,11.71-33.01c1.3-1.46,5.69-5.85,11.39-8.46c2.76-1.14,8.46-2.93,16.26-2.93c2.44,0,8.78,0,15.29,2.6 c22.11,9.11,22.11,35.12,22.11,40.49c0,1.46,0,3.09-0.16,4.55H130.07z M175.77,65.86c0-0.81-0.16-3.25-0.65-5.53 c-0.65-2.76-3.58-12.68-13.17-15.94c-1.62-0.65-3.74-1.14-7.8-1.14c-19.51,0-23.09,17.24-24.07,22.76L175.77,65.86z"></path><path d="M226.17,42.93c4.06-5.04,11.05-12.2,26.34-12.2c5.86,0,12.03,1.14,17.08,4.55c12.03,7.97,11.06,23.09,11.06,35.29v45.7 h-15.12V75.13c0-11.87,0.32-19.51-2.44-24.55c-1.46-2.76-5.53-7.16-13.5-7.16c-15.61,0-20.65,12.2-21.95,17.07 c-0.65,2.6-1.14,5.85-1.14,11.55v44.23h-14.96V32.03h14.64V42.93z"></path><path d="M340.3,32.03v12.36h-15.12v41.63c0,3.09,0,6.18,0.16,9.27c0.33,2.93,0.49,4.06,1.14,5.2c2.28,4.06,7.48,3.9,8.29,3.9 c2.93,0,6.18-0.49,6.83-0.65v12.03c-1.3,0.33-6.01,1.14-10.57,1.14c-1.46,0-8.62,0-13.82-3.42c-6.34-4.23-6.99-10.08-6.83-23.09 V44.39H296.4V32.03h13.98V6.83h14.8v25.2H340.3z"></path><path d="M371.85,78.05c0,1.14-0.17,2.44,0.16,4.71c0.97,8.29,5.37,17.24,13.33,20.81c2.28,1.14,5.69,1.95,11.38,1.95 c3.09,0,12.03-0.16,17.24-8.29c1.95-2.93,2.44-4.88,3.25-8.29l15.29,1.3c-1.62,8.62-4.87,13.01-7.32,15.94 c-10.08,11.87-24.39,11.71-29.11,11.71c-9.43,0-17.56-1.3-25.04-7.48c-14.15-11.55-14.63-31.06-14.63-35.61 c0-5.04,0.49-20.81,11.71-33.01c1.3-1.46,5.69-5.85,11.38-8.46c2.76-1.14,8.46-2.93,16.26-2.93c2.44,0,8.78,0,15.29,2.6 c22.12,9.11,22.12,35.12,22.12,40.49c0,1.46,0,3.09-0.16,4.55H371.85z M417.54,65.86c0-0.81-0.16-3.25-0.65-5.53 c-0.65-2.76-3.58-12.68-13.17-15.94c-1.62-0.65-3.74-1.14-7.8-1.14c-19.51,0-23.09,17.24-24.06,22.76L417.54,65.86z"></path><path d="M467.29,46.34c1.46-3.25,3.09-5.53,5.53-7.97c4.87-4.88,10.57-6.83,17.56-6.83c1.63,0,3.26,0,6.51,0.49l-0.16,14.31 c-3.25-0.49-10.08-1.3-17.73,3.42c-3.58,2.28-8.62,6.51-10.24,16.43c-0.65,4.06-0.82,11.55-0.82,21.79v28.3H453.3V32.03h13.99 V46.34z"></path><path d="M173.08,193.44v71.88h-14.8v-71.88h-13.66v-12.36h13.66v-3.74c0.17-6.99,0-14.15,4.88-20c3.41-4.07,8.62-6.99,19.51-6.99 c2.6,0,5.21,0.16,7.64,0.33v12.68c-7.48-0.49-12.85-0.49-15.29,2.44c-1.95,2.44-1.79,5.85-1.95,11.71v3.58h17.24v12.36H173.08z"></path><path d="M258.77,264.17c-5.69,2.28-11.87,2.76-18.05,2.76c-2.44,0-8.46,0-14.63-1.95c-11.55-3.9-24.4-14.96-24.4-41.47 c0-3.9,0-18.86,8.78-30.25c1.14-1.46,3.25-4.06,7-6.67c9.76-7.15,20.16-7.15,24.39-7.15c4.55,0,15.29,0,25.37,7.97 c14.47,11.55,14.63,31.06,14.63,35.94C281.86,248.4,268.52,260.11,258.77,264.17z M265.76,214.25 c-2.11-13.66-9.76-22.44-24.23-22.44c-7.48,0-11.87,2.6-14.47,4.55c-5.53,4.23-10.25,12.36-10.25,27.32 c0,10.41,2.44,17.4,4.72,21.14c1.14,1.79,3.09,4.39,7.32,6.99c5.37,3.09,11.06,3.25,13.01,3.25c2.44,0,8.29-0.16,13.98-4.06 c8.95-6.34,10.73-17.56,10.73-27.65C266.57,222.54,266.41,217.83,265.76,214.25z"></path><path d="M315.99,195.39c1.46-3.25,3.09-5.53,5.53-7.97c4.88-4.88,10.57-6.83,17.56-6.83c1.63,0,3.25,0,6.5,0.49l-0.16,14.31 c-3.25-0.49-10.08-1.3-17.73,3.42c-3.57,2.28-8.62,6.51-10.24,16.43c-0.65,4.06-0.81,11.55-0.81,21.79v28.3h-14.63v-84.23h13.98 V195.39z"></path></g></svg>
    </a>

    <nav class="header-nav">
      <ul class="menu">
        <li class=" menu-item menu-item-type-post_type menu-item-object-page"><a href="https://centerforbookarts.org/about">About</a></li>
<li class=" menu-item menu-item-type-post_type menu-item-object-page"><a href="https://centerforbookarts.org/classes">Classes</a></li>
<li class=" menu-item menu-item-type-post_type menu-item-object-page"><a href="https://centerforbookarts.org/events">Events</a></li>
<li class=" menu-item menu-item-type-post_type menu-item-object-page"><a href="https://centerforbookarts.org/book-shop">Book Shop</a></li>
<li class=" menu-item menu-item-type-post_type menu-item-object-page"><a href="https://centerforbookarts.org/support">Support</a></li>
<li class="menu-item more-button"><button><span>More</span> →</button></li>
<li class=" menu-item menu-item-type-post_type menu-item-object-page is-child"><a href="https://centerforbookarts.org/opportunities">Opportunities</a></li>
<li class=" menu-item menu-item-type-post_type menu-item-object-page is-child"><a href="https://centerforbookarts.org/exhibitions">Exhibitions</a></li>
<li class=" menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-1170 current_page_item is-child"><a href="https://centerforbookarts.org/collections">Collections</a></li>
<li class=" menu-item menu-item-type-post_type menu-item-object-page is-child"><a href="https://centerforbookarts.org/resources">Resources</a></li>
<li class="menu-item less-button"><button>← <span>Less</span></button></li>      </ul>
    </nav>

    <a class="logo right" href="https://centerforbookarts.org/">
      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 370.06 265.84"><g><path d="M26.83,0.04c6.67,0,13.34-0.16,20.01,0.16c7.32,0.16,14.79,0.97,21.3,4.71c11.87,6.67,12.52,19.51,12.52,23.58 c0,7.81-2.6,13.34-4.23,15.94c-0.49,0.65-1.46,2.11-3.25,3.58c-4.55,4.39-7.64,5.2-10.41,5.85c5.21,1.46,7.65,2.44,9.92,3.9 C77.24,60.7,84.56,68.01,84.56,82c0,3.09-0.49,12.85-6.83,20.98c-2.44,3.09-7.48,7.64-16.91,9.92c-7.48,1.79-14.31,1.79-29.6,1.95 H0V0.04H26.83z M15.45,47.69h12.68c5.86,0,11.38,0,17.08-0.16c6.83-0.33,12.85-0.81,17.24-6.51c1.3-1.95,3.09-5.04,3.09-10.24 c0-7.81-2.93-11.22-5.53-13.34c-1.95-1.46-4.07-2.44-6.34-3.09c-5.04-1.3-12.36-1.14-23.91-1.14H15.45V47.69z M15.45,101.35h15.29 c14.31,0,23.26-0.33,29.11-3.58c3.42-1.79,9.27-6.83,9.27-16.75c0-1.95-0.17-6.5-2.93-10.89c-5.86-9.43-17.88-9.11-27.16-9.11 c-3.74,0-7.48,0.16-11.22,0.16H15.45V101.35z"></path><path d="M158.37,113.71c-5.69,2.28-11.87,2.76-18.05,2.76c-2.44,0-8.46,0-14.64-1.95c-11.54-3.9-24.39-14.96-24.39-41.47 c0-3.9,0-18.86,8.78-30.25c1.14-1.46,3.25-4.06,6.99-6.67c9.76-7.16,20.17-7.16,24.4-7.16c4.55,0,15.29,0,25.37,7.97 c14.47,11.55,14.63,31.06,14.63,35.94C181.46,97.93,168.13,109.64,158.37,113.71z M165.36,63.79 c-2.11-13.66-9.76-22.44-24.23-22.44c-7.48,0-11.87,2.6-14.47,4.55c-5.53,4.23-10.24,12.36-10.24,27.32 c0,10.41,2.44,17.4,4.71,21.14c1.14,1.79,3.09,4.39,7.32,6.99c5.37,3.09,11.06,3.25,13.01,3.25c2.44,0,8.29-0.16,13.98-4.06 c8.94-6.34,10.73-17.56,10.73-27.65C166.17,72.08,166.01,67.36,165.36,63.79z"></path><path d="M254.79,113.71c-5.69,2.28-11.87,2.76-18.05,2.76c-2.44,0-8.46,0-14.63-1.95c-11.55-3.9-24.4-14.96-24.4-41.47 c0-3.9,0-18.86,8.78-30.25c1.14-1.46,3.25-4.06,7-6.67c9.76-7.16,20.16-7.16,24.39-7.16c4.55,0,15.29,0,25.37,7.97 c14.47,11.55,14.63,31.06,14.63,35.94C277.88,97.93,264.54,109.64,254.79,113.71z M261.78,63.79 c-2.11-13.66-9.76-22.44-24.23-22.44c-7.48,0-11.87,2.6-14.47,4.55c-5.53,4.23-10.25,12.36-10.25,27.32 c0,10.41,2.44,17.4,4.72,21.14c1.14,1.79,3.09,4.39,7.32,6.99c5.37,3.09,11.06,3.25,13.01,3.25c2.44,0,8.29-0.16,13.98-4.06 c8.95-6.34,10.73-17.56,10.73-27.65C262.59,72.08,262.43,67.36,261.78,63.79z"></path><path d="M312.98,114.85h-14.96V0.04h14.96v67.81l35.94-37.24h18.7l-33.66,33.82l36.1,50.41h-18.7l-27.97-40l-10.41,10.24V114.85z"></path><path d="M59.43,229.09l-12.68,34.8h-16.1l42.77-114.81H88.7l43.42,114.81h-16.1l-13.01-34.8H59.43z M81.06,169.57l-16.91,46.51 h33.99L81.06,169.57z"></path><path d="M160.72,193.96c1.46-3.25,3.09-5.53,5.53-7.97c4.88-4.88,10.57-6.83,17.56-6.83c1.62,0,3.25,0,6.51,0.49l-0.17,14.31 c-3.25-0.49-10.08-1.3-17.72,3.42c-3.58,2.28-8.62,6.51-10.25,16.43c-0.65,4.06-0.81,11.55-0.81,21.79v28.3h-14.64v-84.23h13.99 V193.96z"></path><path d="M243.32,179.65v12.36H228.2v41.63c0,3.09,0,6.18,0.16,9.27c0.32,2.93,0.49,4.06,1.14,5.2c2.27,4.06,7.48,3.9,8.29,3.9 c2.93,0,6.18-0.49,6.83-0.65v12.03c-1.3,0.33-6.02,1.14-10.57,1.14c-1.46,0-8.62,0-13.82-3.42c-6.34-4.23-6.99-10.08-6.83-23.09 v-46.02h-13.98v-12.36h13.98v-25.2h14.8v25.2H243.32z"></path><path d="M309.17,206.81c-0.16-1.3-0.16-5.37-1.79-9.11c-1.79-3.9-6.5-8.13-15.94-8.13c-0.97,0-3.74,0-6.34,0.65 c-5.2,1.3-8.94,4.88-8.94,10.41c0,2.28,0.49,4.06,1.62,5.69c2.76,3.74,8.13,4.88,16.59,7.48l5.04,1.46 c1.3,0.33,10.9,3.09,16.43,7.64c5.36,4.23,7.97,10.73,7.97,17.4c0,2.44-0.49,8.62-4.55,14.31c-4.39,6.02-12.03,11.22-27.81,11.22 c-2.11,0-13.82,0-21.95-5.2c-1.62-1.14-4.23-2.93-6.83-6.99c-1.14-1.46-2.6-3.9-3.73-8.13c-0.82-3.09-1.14-6.34-1.3-9.43 l13.98-1.63c0,1.3,0,4.72,1.14,8.13c1.62,5.04,6.83,11.71,19.02,11.71c5.04,0,11.39-1.46,14.8-5.69c1.62-1.95,2.44-4.39,2.44-6.99 c0-1.63-0.49-5.69-3.9-8.29c-2.76-2.11-6.99-3.58-13.98-5.53l-4.72-1.46c-3.09-0.81-6.02-1.63-8.78-2.76 c-9.92-4.07-16.1-9.92-16.1-21.14c0-10.9,5.69-16.26,9.11-18.54c4.07-3.09,9.76-5.69,20.49-5.69c8.94,0,18.21,1.95,24.72,8.78 c6.5,6.99,6.66,14.63,6.66,18.21L309.17,206.81z"></path></g></svg>
    </a>

    <div class="header--buttons">
      <div id="search-root"><button class="button is-link search-button"><svg viewBox="0 0 32 32" class="search-icon"><g fill="none" fill-rule="evenodd"><g transform="translate(-1427 -36)" stroke="currentColor" stroke-width="2"><g transform="translate(1428 37)"><circle cx="18" cy="11" r="11"></circle><line x1="9" x2=".34615" y1="20.346" y2="29" stroke-linecap="square"></line></g></g></g></svg></button></div>
    </div>



</div>
</header>
<div class="container containerMain">	
	<div class="row">
		<div class="col-sm-12">	
			<h2 class="is-style-title">Collections</h2>
			<div class="collectionHeader">	
				<?php print caNavLink($this->request, _t("Browse All"), "btn btn-default", "", "Browse", "objects"); ?>
				<?php print caNavLink($this->request, _t("Advanced Search"), "btn btn-default", "", "Search", "advanced/objects"); ?>
				<?php print caNavLink($this->request, _t("Highlights From CBA"), "btn btn-default", "", "Browse", "objects", array("facet" => "has_cba_highlight_facet", "id" => 1)); ?>
				<form class="navbar-form" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>" aria-label="<?php print _t("Search"); ?>" method="post">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" id="headerSearchInput" placeholder="Search" name="search" autocomplete="off" aria-label="<?php print _t("Search text"); ?>" />
						</div>
						<!--<button type="submit" class="btn-search" id="headerSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit"); ?>"></span></button>-->
					</div>
				</form>
				<script type="text/javascript">
					$(document).ready(function(){
						$('#headerSearchButton').prop('disabled',true);
						$('#headerSearchInput').on('keyup', function(){
							$('#headerSearchButton').prop('disabled', this.value == "" ? true : false);     
						})
					});
				</script>
			</div>
		</div>
	</div>
	<div class="row"><div class="col-xs-12">
		<div role="main" id="main"><div id="pageArea" <?php print caGetPageCSSClasses(); ?>>