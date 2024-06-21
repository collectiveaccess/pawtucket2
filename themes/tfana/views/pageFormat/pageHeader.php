<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2024 Whirl-i-Gig
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
$lightboxDisplayName = caGetLightboxDisplayName();
$lightbox_sectionHeading = ucFirst($lightboxDisplayName["section_heading"]);

# Collect the user links
$user_links = "";
if($this->request->isLoggedIn()){
	$user_links .= "<li class='nav-item dropdown'><a class='nav-link".(($this->request->getController() == 'LoginReg') ? ' active' : '')."' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'><i class='bi bi-person-circle' aria-label='"._t('User Options')."'></i></a>
						<ul class='dropdown-menu'>";
	
	$user_links .= '<li><div class="dropdown-header fw-medium">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).'<br>'.$this->request->user->get("email").'</div></li>';
	$user_links .= "<li><hr class='dropdown-divider'></li>";
	if(caDisplayLightbox($this->request)){
		$user_links .= "<li>".caNavLink($this->request, $lightbox_sectionHeading, 'dropdown-item', '', 'Lightbox', 'Index', array())."</li>";
	}
	$user_links .= "<li>".caNavLink($this->request, _t('User Profile'), 'dropdown-item', '', 'LoginReg', 'profileForm', array())."</li>";
	
	if ($this->request->config->get('use_submission_interface')) {
		$user_links .= "<li>".caNavLink($this->request, _t('Submit content'), 'dropdown-item', '', 'Contribute', 'List', array())."</li>";
	}
	$user_links .= "<li>".caNavLink($this->request, _t('Logout'), 'dropdown-item', '', 'LoginReg', 'Logout', array())."</li>";
	$user_links .= "</ul></li>";
} else {	
	if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $user_links = "<li class='nav-item'>".caNavlink($this->request, _t('Login'), "nav-link".((strToLower($this->request->getController()) == "loginreg") ? " active" : ""), "", "LoginReg", "LoginForm", "", ((strToLower($this->request->getController()) == "loginreg") ? array("aria-current" => "page") : null))."</li>"; }
}

?><!DOCTYPE html>
<html lang="en" class="h-100">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	<?= MetaTagManager::getHTML(); ?>
	<?= AssetLoadManager::getLoadHTML($this->request); ?>
	
	<title><?= (MetaTagManager::getWindowTitle()) ?: $this->request->config->get("app_display_name"); ?></title>

	<script>
		let pawtucketUIApps = {};
	</script>
	<link rel="stylesheet" href="https://tfana.slandstudios-staging.com/wp-content/cache/min/1/a0f436f62b5c1a0c45c92a0dc234e1b7.css">
	
	 <style id="wp-custom-css">
    /* .upcoming-events 
    .swiper-slide:first-child {
    	display: none !important;
    } */
    /* .events-carousel 
    .swiper-slide:first-child {
    	display: none !important;
    } */
    .past-events
    .swiper-slide:first-child {
        display: block !important;
    }

    .subscriptions #SpektrixIFrame {
    }/* .page-id-3389 .swiper-arrows {
    display: none;}
    @media all and (max-width: 992px) {
    .page-id-3389 .event-grid {
    	width: 100% ;
    }	
    }
    @media all and (min-width: 992px) and (max-width: 1200px) {
    	.page-id-3389 .event-grid {
    		width: 50%;
    	}		
    }
    @media all and (min-width: 1200px) {
    	.page-id-3389 .event-grid {
    		width: 33.333333%;
    	}	
    } *//*Donation Pages*/
    .benefits-btn a:hover {
        text-decoration: underline;
    }/*Blog*/
    span.post-navigation__arrow-wrapper.post-navigation__arrow-prev {
        background: #FEC02F;
        margin-right: 20px;
        padding-left: 14px;
    }

    span.post-navigation__arrow-wrapper.post-navigation__arrow-next {
        background: #FEC02F;
        margin-left: 20px;
        padding-right: 14px;
    }
    </style>
    <noscript>
        <style>
        .perfmatters-lazy[data-src] {
            display: none !important;
        }
        </style>
    </noscript>
</head>
<body id="pawtucketApp" class="home page-template-default page page-id-9 wp-custom-logo wp-embed-responsive elementor-default elementor-kit-20 elementor-page elementor-page-9 ct-loading ct-elementor-default-template" data-link="type-2" data-prefix="single_page" data-header="type-1" data-footer="type-1" itemscope="itemscope" itemtype="https://schema.org/WebPage">

 <a class="skip-link show-on-focus" href="#main">
    	Skip to content</a>

       <div class="ct-drawer-canvas">
        <div id="offcanvas" class="ct-panel ct-header" data-behaviour="modal">
            <div class="ct-panel-actions">
                <button class="ct-toggle-close" data-type="type-1" aria-label="Close drawer">
                    <svg class="ct-icon" width="12" height="12" viewBox="0 0 15 15">
                        <path d="M1 15a1 1 0 01-.71-.29 1 1 0 010-1.41l5.8-5.8-5.8-5.8A1 1 0 011.7.29l5.8 5.8 5.8-5.8a1 1 0 011.41 1.41l-5.8 5.8 5.8 5.8a1 1 0 01-1.41 1.41l-5.8-5.8-5.8 5.8A1 1 0 011 15z"/>
                    </svg>
                </button>
            </div>
            <div class="ct-panel-content" data-device="desktop"></div>
            <div class="ct-panel-content" data-device="mobile">
                <nav class="mobile-menu has-submenu" data-id="mobile-menu" data-interaction="click" data-toggle-type="type-1" aria-label="Off Canvas Menu">
                    <ul id="menu-primary-menu-1" role="menubar">
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-3394" role="none">
                            <span class="ct-sub-menu-parent">
                                <a href="https://tfana.slandstudios-staging.com/current-season" class="ct-menu-link" role="menuitem">Current Season</a>
                                <button class="ct-toggle-dropdown-mobile" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem">
                                    <svg class="ct-icon toggle-icon-1" width="15" height="15" viewBox="0 0 15 15">
                                        <path d="M3.9,5.1l3.6,3.6l3.6-3.6l1.4,0.7l-5,5l-5-5L3.9,5.1z"/>
                                    </svg>
                                </button>
                            </span>
                            <ul class="sub-menu" role="menu">
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-3395" role="none">
                                    <span class="ct-sub-menu-parent">
                                        <a href="https://tfana.slandstudios-staging.com/current-season/24-25-season" class="ct-menu-link" role="menuitem">24/25 Season</a>
                                        <button class="ct-toggle-dropdown-mobile" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem">
                                            <svg class="ct-icon toggle-icon-1" width="15" height="15" viewBox="0 0 15 15">
                                                <path d="M3.9,5.1l3.6,3.6l3.6-3.6l1.4,0.7l-5,5l-5-5L3.9,5.1z"/>
                                            </svg>
                                        </button>
                                    </span>
                                    <ul class="sub-menu" role="menu">
                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3400" role="none">
                                            <a href="/events/calendar" class="ct-menu-link" role="menuitem">Calendar</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3399" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/current-season/subscriptions" class="ct-menu-link" role="menuitem">Subscriptions</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3398" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/current-season/group-sales" class="ct-menu-link" role="menuitem">Group Sales</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3397" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/current-season/20-new-deal-tickets" class="ct-menu-link" role="menuitem">$20 New Deal Tickets</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-11888" role="none">
                            <span class="ct-sub-menu-parent">
                                <a href="#" class="ct-menu-link" role="menuitem">Plan Your Visit</a>
                                <button class="ct-toggle-dropdown-mobile" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem">
                                    <svg class="ct-icon toggle-icon-1" width="15" height="15" viewBox="0 0 15 15">
                                        <path d="M3.9,5.1l3.6,3.6l3.6-3.6l1.4,0.7l-5,5l-5-5L3.9,5.1z"/>
                                    </svg>
                                </button>
                            </span>
                            <ul class="sub-menu" role="menu">
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3432" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/plan-your-visit/directions-parking" class="ct-menu-link" role="menuitem">Directions &#038; Parking</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3431" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/plan-your-visit/tickets-venue-policies" class="ct-menu-link" role="menuitem">Tickets &#038; Venue Policies</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3430" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/local-perks-dining" class="ct-menu-link" role="menuitem">Local Perks &#038; Dining</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3429" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/monica-and-ali-wambold-food-drinks" class="ct-menu-link" role="menuitem">Monica and Ali Wambold Food &#038; Drink</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3428" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/plan-your-visit/accommodation" class="ct-menu-link" role="menuitem">Accommodation</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-12912" role="none">
                            <span class="ct-sub-menu-parent">
                                <a href="#" class="ct-menu-link" role="menuitem">Humanities &#038; Studio</a>
                                <button class="ct-toggle-dropdown-mobile" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem">
                                    <svg class="ct-icon toggle-icon-1" width="15" height="15" viewBox="0 0 15 15">
                                        <path d="M3.9,5.1l3.6,3.6l3.6-3.6l1.4,0.7l-5,5l-5-5L3.9,5.1z"/>
                                    </svg>
                                </button>
                            </span>
                            <ul class="sub-menu" role="menu">
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12911" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/humanities-studio" class="ct-menu-link" role="menuitem">Humanities</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-11944" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/humanities-studio/bianca-vivion-reflections" class="ct-menu-link" role="menuitem">Bianca Vivion: Reflections</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12910" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/merle-debuskey-studio-fund" class="ct-menu-link" role="menuitem">Merle Debuskey Studio Fund</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-176" role="none">
                            <span class="ct-sub-menu-parent">
                                <a href="https://tfana.slandstudios-staging.com/education" class="ct-menu-link" role="menuitem">Arts Education</a>
                                <button class="ct-toggle-dropdown-mobile" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem">
                                    <svg class="ct-icon toggle-icon-1" width="15" height="15" viewBox="0 0 15 15">
                                        <path d="M3.9,5.1l3.6,3.6l3.6-3.6l1.4,0.7l-5,5l-5-5L3.9,5.1z"/>
                                    </svg>
                                </button>
                            </span>
                            <ul class="sub-menu" role="menu">
                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-12011" role="none">
                                    <span class="ct-sub-menu-parent">
                                        <a href="#" class="ct-menu-link" role="menuitem">School Programs</a>
                                        <button class="ct-toggle-dropdown-mobile" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem">
                                            <svg class="ct-icon toggle-icon-1" width="15" height="15" viewBox="0 0 15 15">
                                                <path d="M3.9,5.1l3.6,3.6l3.6-3.6l1.4,0.7l-5,5l-5-5L3.9,5.1z"/>
                                            </svg>
                                        </button>
                                    </span>
                                    <ul class="sub-menu" role="menu">
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3449" role="none">
                                            <a href="https://tfana.slandstudios-staging.com/education/school-programs/world-theatre-project" class="ct-menu-link" role="menuitem">World Theatre Project</a>
                                        </li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3448" role="none">
                                            <a href="https://tfana.slandstudios-staging.com/education/school-programs/new-voices-project" class="ct-menu-link" role="menuitem">New Voices Project</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-3446" role="none">
                                    <span class="ct-sub-menu-parent">
                                        <a href="https://tfana.slandstudios-staging.com/education/teacher-professional-development" class="ct-menu-link" role="menuitem">Teacher Professional Development</a>
                                        <button class="ct-toggle-dropdown-mobile" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem">
                                            <svg class="ct-icon toggle-icon-1" width="15" height="15" viewBox="0 0 15 15">
                                                <path d="M3.9,5.1l3.6,3.6l3.6-3.6l1.4,0.7l-5,5l-5-5L3.9,5.1z"/>
                                            </svg>
                                        </button>
                                    </span>
                                    <ul class="sub-menu" role="menu">
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3757" role="none">
                                            <a href="https://tfana.slandstudios-staging.com/education/teacher-professional-development/neh-summer-institute" class="ct-menu-link" role="menuitem">NEH Summer Institute</a>
                                        </li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3451" role="none">
                                            <a href="https://tfana.slandstudios-staging.com/education/teacher-professional-development/critically-conscious-shakespeare" class="ct-menu-link" role="menuitem">Critically Conscious Shakespeare</a>
                                        </li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3450" role="none">
                                            <a href="https://tfana.slandstudios-staging.com/education/teacher-professional-development/shakespeare-social-justice" class="ct-menu-link" role="menuitem">Shakespeare &#038; Social Justice</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-9945" role="none">
                            <span class="ct-sub-menu-parent">
                                <a href="/support-us/make-a-donation/" class="ct-menu-link" role="menuitem">Support Us</a>
                                <button class="ct-toggle-dropdown-mobile" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem">
                                    <svg class="ct-icon toggle-icon-1" width="15" height="15" viewBox="0 0 15 15">
                                        <path d="M3.9,5.1l3.6,3.6l3.6-3.6l1.4,0.7l-5,5l-5-5L3.9,5.1z"/>
                                    </svg>
                                </button>
                            </span>
                            <ul class="sub-menu" role="menu">
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3457" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/support-us/make-a-donation" class="ct-menu-link" role="menuitem">Make A Donation</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3459" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/support-us/our-supporters" class="ct-menu-link" role="menuitem">Our Supporters</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3458" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/support-us/events-annual-gala" class="ct-menu-link" role="menuitem">Events &#038; Annual Gala</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-111" role="none">
                            <span class="ct-sub-menu-parent">
                                <a href="https://tfana.slandstudios-staging.com/about" class="ct-menu-link" role="menuitem">About</a>
                                <button class="ct-toggle-dropdown-mobile" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem">
                                    <svg class="ct-icon toggle-icon-1" width="15" height="15" viewBox="0 0 15 15">
                                        <path d="M3.9,5.1l3.6,3.6l3.6-3.6l1.4,0.7l-5,5l-5-5L3.9,5.1z"/>
                                    </svg>
                                </button>
                            </span>
                            <ul class="sub-menu" role="menu">
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3487" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/about/polonsky-shakespeare-center" class="ct-menu-link" role="menuitem">Polonsky Shakespeare Center</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3486" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/about/leadership" class="ct-menu-link" role="menuitem">Leadership</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-13313" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/about/council-of-scholars" class="ct-menu-link" role="menuitem">Council of Scholars</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3485" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/about/staff" class="ct-menu-link" role="menuitem">Staff</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3484" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/about/awards-citations" class="ct-menu-link" role="menuitem">Awards &#038; Citations</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3483" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/about/production-history" class="ct-menu-link" role="menuitem">Production History</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3482" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/about/resident-artists" class="ct-menu-link" role="menuitem">Resident Artists</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3481" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/about/work-with-us" class="ct-menu-link" role="menuitem">Work With Us</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3480" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/about/racial-justice-anti-racism-resources" class="ct-menu-link" role="menuitem">Racial Justice &#038; Anti-Racism Resources</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12920" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/about/milton-glaser" class="ct-menu-link" role="menuitem">Milton Glaser</a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-11891" role="none">
                            <span class="ct-sub-menu-parent">
                                <a href="#" class="ct-menu-link" role="menuitem">Media</a>
                                <button class="ct-toggle-dropdown-mobile" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem">
                                    <svg class="ct-icon toggle-icon-1" width="15" height="15" viewBox="0 0 15 15">
                                        <path d="M3.9,5.1l3.6,3.6l3.6-3.6l1.4,0.7l-5,5l-5-5L3.9,5.1z"/>
                                    </svg>
                                </button>
                            </span>
                            <ul class="sub-menu" role="menu">
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3519" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/media/news-posts" class="ct-menu-link" role="menuitem">News Posts</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3518" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/digital-programs" class="ct-menu-link" role="menuitem">Digital Programs – 360° Viewfinder</a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-3517" role="none">
                                    <span class="ct-sub-menu-parent">
                                        <a href="https://tfana.slandstudios-staging.com/media/digital-content" class="ct-menu-link" role="menuitem">Digital Content</a>
                                        <button class="ct-toggle-dropdown-mobile" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem">
                                            <svg class="ct-icon toggle-icon-1" width="15" height="15" viewBox="0 0 15 15">
                                                <path d="M3.9,5.1l3.6,3.6l3.6-3.6l1.4,0.7l-5,5l-5-5L3.9,5.1z"/>
                                            </svg>
                                        </button>
                                    </span>
                                    <ul class="sub-menu" role="menu">
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3516" role="none">
                                            <a href="https://tfana.slandstudios-staging.com/media/digital-content/videos" class="ct-menu-link" role="menuitem">Videos</a>
                                        </li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3515" role="none">
                                            <a href="https://tfana.slandstudios-staging.com/media/digital-content/production-photos" class="ct-menu-link" role="menuitem">Production Photos</a>
                                        </li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3514" role="none">
                                            <a href="https://tfana.slandstudios-staging.com/media/digital-content/event-photos" class="ct-menu-link" role="menuitem">Event Photos</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-6330" role="none">
                            <span class="ct-sub-menu-parent">
                                <a href="/about/staff" class="ct-menu-link" role="menuitem">Contact</a>
                                <button class="ct-toggle-dropdown-mobile" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem">
                                    <svg class="ct-icon toggle-icon-1" width="15" height="15" viewBox="0 0 15 15">
                                        <path d="M3.9,5.1l3.6,3.6l3.6-3.6l1.4,0.7l-5,5l-5-5L3.9,5.1z"/>
                                    </svg>
                                </button>
                            </span>
                            <ul class="sub-menu" role="menu">
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3524" role="none">
                                    <a href="https://tfana.slandstudios-staging.com/contact/submission-policies" class="ct-menu-link" role="menuitem">Submission Policies</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
        <a href="#main-container" class="ct-back-to-top " data-shape="square" data-alignment="right" title="Go to top" aria-label="Go to top" hidden>

            <svg class="ct-icon" width="15" height="15" viewBox="0 0 20 20">
                <path d="M2.3 15.2L10 7.5l7.7 7.6c.6.7 1.2.7 1.8 0 .6-.6.6-1.3 0-1.9l-8.6-8.6c-.2-.3-.5-.4-.9-.4s-.7.1-.9.4L.5 13.2c-.6.6-.6 1.2 0 1.9.6.8 1.2.7 1.8.1z"/>
            </svg>
        </a>

    </div>
    <div id="main-container">
        <header id="header" class="ct-header" data-id="type-1" itemscope="" itemtype="https://schema.org/WPHeader">
            <div data-device="desktop">
                <div data-row="top" data-column-set="1">
                    <div class="ct-container">
                        <div data-column="end" data-placements="1">
                            <div data-items="primary">
                                <nav id="header-menu-2" class="header-menu-2" data-id="menu-secondary" data-interaction="hover" data-menu="type-1" data-dropdown="type-1:simple" data-responsive="no" itemscope="" itemtype="https://schema.org/SiteNavigationElement" aria-label="Header Menu">

                                    <ul id="menu-top-bar" class="menu" role="menubar">
                                        <li id="menu-item-2838" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2838" role="none">
                                            <a href="https://tfana.slandstudios-staging.com/support-us/make-a-donation" class="ct-menu-link" role="menuitem">Donate Today</a>
                                        </li>
                                        <li id="menu-item-194" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-194" role="none">
                                            <a href="https://tfana.slandstudios-staging.com/gift-vouchers" class="ct-menu-link" role="menuitem">Gift Vouchers</a>
                                        </li>
                                        <li id="menu-item-199" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-199" role="none">
                                            <a href="https://tfana.slandstudios-staging.com/account" class="ct-menu-link" role="menuitem">Account</a>
                                        </li>
                                        <li id="menu-item-198" class=" menu-item menu-item-type-post_type menu-item-object-page menu-item-198" role="none">
                                           <form action="<?= caNavUrl($this->request, '', 'Search', 'GeneralSearch'); ?>" role="search">
												<div class="input-group">
													<label for="nav-search-input" class="form-label visually-hidden">Search</label>
													<input type="text" name="search" class="form-control rounded-0 border-black" id="nav-search-input" placeholder="Search" aria-label="Search">
													<button type="submit" class="btn rounded-0" id="nav-search-btn" aria-label="Submit Search"><i class="bi bi-search"></i></button>
												</div>
											</form>
                                        </li>
                                    </ul>
                                </nav>

                            </div>
                        </div>
                    </div>
                </div>
                <div data-row="middle" data-column-set="2">
                    <div class="ct-container">
                        <div data-column="start" data-placements="1">
                            <div data-items="primary">
                                <div class="site-branding" data-id="logo" itemscope="itemscope" itemtype="https://schema.org/Organization">

                                    <a href="https://tfana.slandstudios-staging.com/" class="site-logo-container" rel="home">
                                        <img data-perfmatters-preload loading="lazy" width="231" height="92" src="https://tfana.slandstudios-staging.com/wp-content/uploads/2023/04/tfana-logo.jpg" class="default-logo" alt="Theatre for New Audience Logo"/>
                                    </a>
                                </div>

                            </div>
                        </div>
                        <div data-column="end" data-placements="1">
                            <div data-items="primary">
                                <nav id="header-menu-1" class="header-menu-1" data-id="menu" data-interaction="hover" data-menu="type-1" data-dropdown="type-1:simple" data-responsive="no" itemscope="" itemtype="https://schema.org/SiteNavigationElement" aria-label="Header Menu">

                                    <ul id="menu-primary-menu" class="menu" role="menubar">
                                        <li id="menu-item-3394" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-3394 animated-submenu" role="none">
                                            <a href="https://tfana.slandstudios-staging.com/current-season" class="ct-menu-link" role="menuitem">
                                                Current Season
                                                <span class="ct-toggle-dropdown-desktop">
                                                    <svg class="ct-icon" width="8" height="8" viewBox="0 0 15 15">
                                                        <path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/>
                                                    </svg>
                                                </span>
                                            </a>
                                            <button class="ct-toggle-dropdown-desktop-ghost" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem"></button>
                                            <ul class="sub-menu" role="menu">
                                                <li id="menu-item-3395" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-3395 animated-submenu" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/current-season/24-25-season" class="ct-menu-link" role="menuitem">
                                                        24/25 Season
                                                        <span class="ct-toggle-dropdown-desktop">
                                                            <svg class="ct-icon" width="8" height="8" viewBox="0 0 15 15">
                                                                <path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    <button class="ct-toggle-dropdown-desktop-ghost" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem"></button>
                                                    <ul class="sub-menu" role="menu">
                                                        <li id="menu-item-3400" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-3400" role="none">
                                                            <a href="/events/calendar" class="ct-menu-link" role="menuitem">Calendar</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li id="menu-item-3399" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3399" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/current-season/subscriptions" class="ct-menu-link" role="menuitem">Subscriptions</a>
                                                </li>
                                                <li id="menu-item-3398" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3398" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/current-season/group-sales" class="ct-menu-link" role="menuitem">Group Sales</a>
                                                </li>
                                                <li id="menu-item-3397" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3397" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/current-season/20-new-deal-tickets" class="ct-menu-link" role="menuitem">$20 New Deal Tickets</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li id="menu-item-11888" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-11888 animated-submenu" role="none">
                                            <a href="#" class="ct-menu-link" role="menuitem">
                                                Plan Your Visit
                                                <span class="ct-toggle-dropdown-desktop">
                                                    <svg class="ct-icon" width="8" height="8" viewBox="0 0 15 15">
                                                        <path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/>
                                                    </svg>
                                                </span>
                                            </a>
                                            <button class="ct-toggle-dropdown-desktop-ghost" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem"></button>
                                            <ul class="sub-menu" role="menu">
                                                <li id="menu-item-3432" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3432" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/plan-your-visit/directions-parking" class="ct-menu-link" role="menuitem">Directions &#038; Parking</a>
                                                </li>
                                                <li id="menu-item-3431" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3431" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/plan-your-visit/tickets-venue-policies" class="ct-menu-link" role="menuitem">Tickets &#038; Venue Policies</a>
                                                </li>
                                                <li id="menu-item-3430" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3430" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/local-perks-dining" class="ct-menu-link" role="menuitem">Local Perks &#038; Dining</a>
                                                </li>
                                                <li id="menu-item-3429" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3429" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/monica-and-ali-wambold-food-drinks" class="ct-menu-link" role="menuitem">Monica and Ali Wambold Food &#038; Drink</a>
                                                </li>
                                                <li id="menu-item-3428" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3428" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/plan-your-visit/accommodation" class="ct-menu-link" role="menuitem">Accommodation</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li id="menu-item-12912" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-12912 animated-submenu" role="none">
                                            <a href="#" class="ct-menu-link" role="menuitem">
                                                Humanities &#038; Studio
                                                <span class="ct-toggle-dropdown-desktop">
                                                    <svg class="ct-icon" width="8" height="8" viewBox="0 0 15 15">
                                                        <path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/>
                                                    </svg>
                                                </span>
                                            </a>
                                            <button class="ct-toggle-dropdown-desktop-ghost" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem"></button>
                                            <ul class="sub-menu" role="menu">
                                                <li id="menu-item-12911" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12911" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/humanities-studio" class="ct-menu-link" role="menuitem">Humanities</a>
                                                </li>
                                                <li id="menu-item-11944" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-11944" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/humanities-studio/bianca-vivion-reflections" class="ct-menu-link" role="menuitem">Bianca Vivion: Reflections</a>
                                                </li>
                                                <li id="menu-item-12910" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12910" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/merle-debuskey-studio-fund" class="ct-menu-link" role="menuitem">Merle Debuskey Studio Fund</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li id="menu-item-176" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-176 animated-submenu" role="none">
                                            <a href="https://tfana.slandstudios-staging.com/education" class="ct-menu-link" role="menuitem">
                                                Arts Education
                                                <span class="ct-toggle-dropdown-desktop">
                                                    <svg class="ct-icon" width="8" height="8" viewBox="0 0 15 15">
                                                        <path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/>
                                                    </svg>
                                                </span>
                                            </a>
                                            <button class="ct-toggle-dropdown-desktop-ghost" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem"></button>
                                            <ul class="sub-menu" role="menu">
                                                <li id="menu-item-12011" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-12011 animated-submenu" role="none">
                                                    <a href="#" class="ct-menu-link" role="menuitem">
                                                        School Programs
                                                        <span class="ct-toggle-dropdown-desktop">
                                                            <svg class="ct-icon" width="8" height="8" viewBox="0 0 15 15">
                                                                <path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    <button class="ct-toggle-dropdown-desktop-ghost" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem"></button>
                                                    <ul class="sub-menu" role="menu">
                                                        <li id="menu-item-3449" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3449" role="none">
                                                            <a href="https://tfana.slandstudios-staging.com/education/school-programs/world-theatre-project" class="ct-menu-link" role="menuitem">World Theatre Project</a>
                                                        </li>
                                                        <li id="menu-item-3448" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3448" role="none">
                                                            <a href="https://tfana.slandstudios-staging.com/education/school-programs/new-voices-project" class="ct-menu-link" role="menuitem">New Voices Project</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li id="menu-item-3446" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-3446 animated-submenu" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/education/teacher-professional-development" class="ct-menu-link" role="menuitem">
                                                        Teacher Professional Development
                                                        <span class="ct-toggle-dropdown-desktop">
                                                            <svg class="ct-icon" width="8" height="8" viewBox="0 0 15 15">
                                                                <path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    <button class="ct-toggle-dropdown-desktop-ghost" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem"></button>
                                                    <ul class="sub-menu" role="menu">
                                                        <li id="menu-item-3757" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3757" role="none">
                                                            <a href="https://tfana.slandstudios-staging.com/education/teacher-professional-development/neh-summer-institute" class="ct-menu-link" role="menuitem">NEH Summer Institute</a>
                                                        </li>
                                                        <li id="menu-item-3451" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3451" role="none">
                                                            <a href="https://tfana.slandstudios-staging.com/education/teacher-professional-development/critically-conscious-shakespeare" class="ct-menu-link" role="menuitem">Critically Conscious Shakespeare</a>
                                                        </li>
                                                        <li id="menu-item-3450" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3450" role="none">
                                                            <a href="https://tfana.slandstudios-staging.com/education/teacher-professional-development/shakespeare-social-justice" class="ct-menu-link" role="menuitem">Shakespeare &#038; Social Justice</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li id="menu-item-9945" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-9945 animated-submenu" role="none">
                                            <a href="/support-us/make-a-donation/" class="ct-menu-link" role="menuitem">
                                                Support Us
                                                <span class="ct-toggle-dropdown-desktop">
                                                    <svg class="ct-icon" width="8" height="8" viewBox="0 0 15 15">
                                                        <path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/>
                                                    </svg>
                                                </span>
                                            </a>
                                            <button class="ct-toggle-dropdown-desktop-ghost" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem"></button>
                                            <ul class="sub-menu" role="menu">
                                                <li id="menu-item-3457" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3457" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/support-us/make-a-donation" class="ct-menu-link" role="menuitem">Make A Donation</a>
                                                </li>
                                                <li id="menu-item-3459" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3459" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/support-us/our-supporters" class="ct-menu-link" role="menuitem">Our Supporters</a>
                                                </li>
                                                <li id="menu-item-3458" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3458" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/support-us/events-annual-gala" class="ct-menu-link" role="menuitem">Events &#038; Annual Gala</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li id="menu-item-111" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-111 animated-submenu" role="none">
                                            <a href="https://tfana.slandstudios-staging.com/about" class="ct-menu-link" role="menuitem">
                                                About
                                                <span class="ct-toggle-dropdown-desktop">
                                                    <svg class="ct-icon" width="8" height="8" viewBox="0 0 15 15">
                                                        <path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/>
                                                    </svg>
                                                </span>
                                            </a>
                                            <button class="ct-toggle-dropdown-desktop-ghost" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem"></button>
                                            <ul class="sub-menu" role="menu">
                                                <li id="menu-item-3487" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3487" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/about/polonsky-shakespeare-center" class="ct-menu-link" role="menuitem">Polonsky Shakespeare Center</a>
                                                </li>
                                                <li id="menu-item-3486" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3486" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/about/leadership" class="ct-menu-link" role="menuitem">Leadership</a>
                                                </li>
                                                <li id="menu-item-13313" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-13313" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/about/council-of-scholars" class="ct-menu-link" role="menuitem">Council of Scholars</a>
                                                </li>
                                                <li id="menu-item-3485" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3485" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/about/staff" class="ct-menu-link" role="menuitem">Staff</a>
                                                </li>
                                                <li id="menu-item-3484" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3484" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/about/awards-citations" class="ct-menu-link" role="menuitem">Awards &#038; Citations</a>
                                                </li>
                                                <li id="menu-item-3483" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3483" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/about/production-history" class="ct-menu-link" role="menuitem">Production History</a>
                                                </li>
                                                <li id="menu-item-3482" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3482" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/about/resident-artists" class="ct-menu-link" role="menuitem">Resident Artists</a>
                                                </li>
                                                <li id="menu-item-3481" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3481" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/about/work-with-us" class="ct-menu-link" role="menuitem">Work With Us</a>
                                                </li>
                                                <li id="menu-item-3480" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3480" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/about/racial-justice-anti-racism-resources" class="ct-menu-link" role="menuitem">Racial Justice &#038; Anti-Racism Resources</a>
                                                </li>
                                                <li id="menu-item-12920" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12920" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/about/milton-glaser" class="ct-menu-link" role="menuitem">Milton Glaser</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li id="menu-item-11891" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-11891 animated-submenu" role="none">
                                            <a href="#" class="ct-menu-link" role="menuitem">
                                                Media
                                                <span class="ct-toggle-dropdown-desktop">
                                                    <svg class="ct-icon" width="8" height="8" viewBox="0 0 15 15">
                                                        <path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/>
                                                    </svg>
                                                </span>
                                            </a>
                                            <button class="ct-toggle-dropdown-desktop-ghost" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem"></button>
                                            <ul class="sub-menu" role="menu">
                                                <li id="menu-item-3519" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3519" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/media/news-posts" class="ct-menu-link" role="menuitem">News Posts</a>
                                                </li>
                                                <li id="menu-item-3518" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3518" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/digital-programs" class="ct-menu-link" role="menuitem">Digital Programs – 360° Viewfinder</a>
                                                </li>
                                                <li id="menu-item-3517" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-3517 animated-submenu" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/media/digital-content" class="ct-menu-link" role="menuitem">
                                                        Digital Content
                                                        <span class="ct-toggle-dropdown-desktop">
                                                            <svg class="ct-icon" width="8" height="8" viewBox="0 0 15 15">
                                                                <path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    <button class="ct-toggle-dropdown-desktop-ghost" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem"></button>
                                                    <ul class="sub-menu" role="menu">
                                                        <li id="menu-item-3516" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3516" role="none">
                                                            <a href="https://tfana.slandstudios-staging.com/media/digital-content/videos" class="ct-menu-link" role="menuitem">Videos</a>
                                                        </li>
                                                        <li id="menu-item-3515" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3515" role="none">
                                                            <a href="https://tfana.slandstudios-staging.com/media/digital-content/production-photos" class="ct-menu-link" role="menuitem">Production Photos</a>
                                                        </li>
                                                        <li id="menu-item-3514" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3514" role="none">
                                                            <a href="https://tfana.slandstudios-staging.com/media/digital-content/event-photos" class="ct-menu-link" role="menuitem">Event Photos</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li id="menu-item-6330" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-6330 animated-submenu" role="none">
                                            <a href="/about/staff" class="ct-menu-link" role="menuitem">
                                                Contact
                                                <span class="ct-toggle-dropdown-desktop">
                                                    <svg class="ct-icon" width="8" height="8" viewBox="0 0 15 15">
                                                        <path d="M2.1,3.2l5.4,5.4l5.4-5.4L15,4.3l-7.5,7.5L0,4.3L2.1,3.2z"/>
                                                    </svg>
                                                </span>
                                            </a>
                                            <button class="ct-toggle-dropdown-desktop-ghost" aria-label="Expand dropdown menu" aria-haspopup="true" aria-expanded="false" role="menuitem"></button>
                                            <ul class="sub-menu" role="menu">
                                                <li id="menu-item-3524" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-3524" role="none">
                                                    <a href="https://tfana.slandstudios-staging.com/contact/submission-policies" class="ct-menu-link" role="menuitem">Submission Policies</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div data-device="mobile">
                <div data-row="middle" data-column-set="2">
                    <div class="ct-container">
                        <div data-column="start" data-placements="1">
                            <div data-items="primary">
                                <div class="site-branding" data-id="logo">

                                    <a href="https://tfana.slandstudios-staging.com/" class="site-logo-container" rel="home">
                                        <img data-perfmatters-preload loading="lazy" width="231" height="92" src="https://tfana.slandstudios-staging.com/wp-content/uploads/2023/04/tfana-logo.jpg" class="default-logo" alt="Theatre for New Audience Logo"/>
                                    </a>
                                </div>

                            </div>
                        </div>
                        <div data-column="end" data-placements="1">
                            <div data-items="primary">
                                <button data-toggle-panel="#offcanvas" class="ct-header-trigger ct-toggle " data-design="simple" data-label="right" aria-label="Open off canvas" data-id="trigger">

                                    <span class="ct-label ct-hidden-sm ct-hidden-md ct-hidden-lg">Menu</span>

                                    <svg class="ct-icon" width="18" height="14" viewBox="0 0 18 14" aria-hidden="true" data-type="type-1">

                                        <rect y="0.00" width="18" height="1.7" rx="1"/>
                                        <rect y="6.15" width="18" height="1.7" rx="1"/>
                                        <rect y="12.3" width="18" height="1.7" rx="1"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main id="main" class="site-main hfeed">
<?php
	if(strToLower($this->request->getController()) != "front"){
		print "<div class='container-xl pt-4'>";
	}
	
