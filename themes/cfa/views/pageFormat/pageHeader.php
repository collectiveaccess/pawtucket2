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

# Collect the user links: they are output twice, once for toggle menu and once for nav
$va_user_links = array();
if($this->request->isLoggedIn()){
	$va_user_links[] = '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
	$va_user_links[] = '<li class="divider nav-divider"></li>';
	if(caDisplayLightbox($this->request)){
		$va_user_links[] = "<li>".caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
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
$va_access_values = caGetUserAccessValues($this->request);
?><!DOCTYPE html>

<html lang="en" <?php print ((strtoLower($this->request->getController()) == "front")) ? "class='frontContainer'" : ""; ?>>

<head>
	<meta charset="utf-8">
		
	<?= AssetLoadManager::getLoadHTML($this->request); ?>
	
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title><?= (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>

	<!-- Dynamic meta tags -->
	<?= MetaTagManager::getHTML(); ?>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.css" />
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-jgrowl/1.4.8/jquery.jgrowl.min.js"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
	
	<link rel="stylesheet" href="/themes/cfa/assets/pawtucket/css/theme.css">

	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon-precomposed" sizes="60x60" href="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/apple-touch-icon-152x152.png">
	<link rel="icon" type="image/png" href="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/favicon-196x196.png" sizes="196x196">
	<link rel="icon" type="image/png" href="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/favicon-16x16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/favicon-128.png" sizes="128x128">
	<meta name="msapplication-TileColor" content="#000000">
	<meta name="msapplication-TileImage" content="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/mstile-144x144.png">
	<meta name="msapplication-square70x70logo" content="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/mstile-70x70.png">
	<meta name="msapplication-square150x150logo" content="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/mstile-150x150.png">
	<meta name="msapplication-wide310x150logo" content="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/mstile-310x150.png">
	<meta name="msapplication-square310x310logo" content="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/favicon/mstile-310x310.png">

	<meta name="robots" content="noindex, nofollow">

	<!-- This site is optimized with the Yoast SEO plugin v20.9 - https://yoast.com/wordpress/plugins/seo/ -->
	<meta name="description" content="Dedicated to collecting, preserving and providing access to films that represent the Midwest. We hold over 30,000 films and 2,000 audio recordings, including thousands of media items accessible online.">
	<meta property="og:locale" content="en_US">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="Chicago Film Archives">
	<meta property="og:image:type" content="image/jpeg">

	
	<!-- <meta property="og:url" content="https://cfarchives.wpengine.com/">
	<meta property="article:modified_time" content="2023-06-13T16:03:32+00:00"> -->

	<meta name="twitter:card" content="summary_large_image">
	<script type="application/ld+json" class="yoast-schema-graph">{"@context":"https://schema.org","@graph":[{"@type":"WebPage","@id":"https://cfarchives.wpengine.com/","url":"https://cfarchives.wpengine.com/","name":"Chicago Film Archives","isPartOf":{"@id":"https://cfarchives.wpengine.com/#website"},"primaryImageOfPage":{"@id":"https://cfarchives.wpengine.com/#primaryimage"},"image":{"@id":"https://cfarchives.wpengine.com/#primaryimage"},"thumbnailUrl":"https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Image.jpg","datePublished":"2023-04-21T13:03:38+00:00","dateModified":"2023-06-13T16:03:32+00:00","description":"Dedicated to collecting, preserving and providing access to films that represent the Midwest. We hold over 30,000 films and 2,000 audio recordings, including thousands of media items accessible online.","breadcrumb":{"@id":"https://cfarchives.wpengine.com/#breadcrumb"},"inLanguage":"en-US","potentialAction":[{"@type":"ReadAction","target":["https://cfarchives.wpengine.com/"]}]},{"@type":"ImageObject","inLanguage":"en-US","@id":"https://cfarchives.wpengine.com/#primaryimage","url":"https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Image.jpg","contentUrl":"https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Image.jpg","width":464,"height":355},{"@type":"BreadcrumbList","@id":"https://cfarchives.wpengine.com/#breadcrumb","itemListElement":[{"@type":"ListItem","position":1,"name":"Home"}]},{"@type":"WebSite","@id":"https://cfarchives.wpengine.com/#website","url":"https://cfarchives.wpengine.com/","name":"Chicago Film Archives","description":"","potentialAction":[{"@type":"SearchAction","target":{"@type":"EntryPoint","urlTemplate":"https://cfarchives.wpengine.com/?s={search_term_string}"},"query-input":"required name=search_term_string"}],"inLanguage":"en-US"}]}</script>
	<!-- / Yoast SEO plugin. -->

	<link rel="stylesheet" id="style-all-0-css" href="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/dist/style.css?ver=404" type="text/css" media="all">
	<script src="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/js/libs/custom/slick-min.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/dist/app.min.esbuild.js?ver=404" id="script-1-0-js"></script>  

    <!-- Matomo -->
    <script>
    var _paq = window._paq = window._paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="https://chicagofilmarchives.matomo.cloud/";
        _paq.push(['setTrackerUrl', u+'matomo.php']);
        _paq.push(['setSiteId', '1']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.async=true; g.src='//cdn.matomo.cloud/chicagofilmarchives.matomo.cloud/matomo.js'; s.parentNode.insertBefore(g,s);
    })();
    </script>
    <!-- End Matomo Code -->

	<style>
		body {
			line-height: 1.15 !important;
		}
	</style>
</head>

<body class="vsc-initialized collective-access">
    <header id="header">
        <div class="max__site">
            <div class="row">
                <div class="wrap">
                    <a href="https://cfarchives.wpengine.com/" id="logo">
                        <img src="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/cfa-logo-desktop.svg"/>
                    </a>
                    <ul id="menu-extra" class="nav header-nav horizontal extra">
                        <li id="menu-item-34" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-34">
                            <a href="https://cfarchives.wpengine.com/calendar/">
                                Events
                            </a>
                        </li>
                        <li id="menu-item-33" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-33">
                            <a href="https://cfarchives.wpengine.com/news/">
                                News
                            </a>
                        </li>
                        <li id="menu-item-36" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-36">
                            <a href="https://cfarchives.wpengine.com/about/">
                                About
                            </a>
                        </li>
                        <li id="menu-item-35" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-35">
                            <a href="https://cfarchives.wpengine.com/support/">
                                Support
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row main">
                <div class="wrap">
                    <div class="layout-fixed-right dim-down">
                        <div>
                            <ul id="menu-main" class="nav header-nav horizontal main nav-color">
                                <li id="menu-item-28" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-8 current_page_item menu-item-28">
                                    <a href="https://cfarchives.wpengine.com/collections/" aria-current="page">
                                        Collections
                                    </a>
                                </li>
                                <li id="menu-item-31" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-31">
                                    <a href="https://cfarchives.wpengine.com/watch/">
                                        Watch
                                    </a>
                                </li>
                                <li id="menu-item-29" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-29">
                                    <a href="https://cfarchives.wpengine.com/services/">
                                        Services
                                    </a>
                                </li>
                                <li id="menu-item-32" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-32">
                                    <a href="https://cfarchives.wpengine.com/preservation/">
                                        Preservation
                                    </a>
                                </li>
                                <li id="menu-item-30" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-30">
                                    <a href="https://cfarchives.wpengine.com/digital-exhibitions/">
                                        Digital Exhibitions
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="module-search-form">
                            <form role="search" aria-label="Search For" method="get" class="search-form"
                            action="https://cfarchives.wpengine.com/results/">
                                <label for="search-form-1" class="visually-hidden">
                                    Search
                                </label>
                                <div class="search-container">
                                    <input type="search" id="search-form-1" class="search-field" value=""
                                    name="search" placeholder="Search" />
                                    <button type="submit" title="Submit Search" aria-label="Submit Search"
                                    class="search-submit icon">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="7.07143" cy="6.57143" r="6.07143" stroke="white">
                                            </circle>
                                            <path d="M11.4618 10.9618L15.9359 15.4359" stroke="white" stroke-linecap="square">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <nav id="compact-nav">
        <div class="int">
            <div class="layout wrap">
                <div class="max__site">
                    <div class="row layout-fixed-right dim-down">
                        <div>
                            <a href="https://cfarchives.wpengine.com/" id="compact-logo">
                                <img src="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/cfa-logo.svg"
                                />
                            </a>
                            <ul id="menu-main-1" class="nav header-nav horizontal main nav-color">
                                <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-8 current_page_item menu-item-28">
                                    <a href="https://cfarchives.wpengine.com/collections/" aria-current="page">
                                        Collections
                                    </a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-31">
                                    <a href="https://cfarchives.wpengine.com/watch/">
                                        Watch
                                    </a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-29">
                                    <a href="https://cfarchives.wpengine.com/services/">
                                        Services
                                    </a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-32">
                                    <a href="https://cfarchives.wpengine.com/preservation/">
                                        Preservation
                                    </a>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-30">
                                    <a href="https://cfarchives.wpengine.com/digital-exhibitions/">
                                        Digital Exhibitions
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="module-search-form">
                            <form role="search" aria-label="Search For" method="get" class="search-form"
                            action="https://cfarchives.wpengine.com/results/">
                                <label for="search-form-2" class="visually-hidden">
                                    Search
                                </label>
                                <div class="search-container">
                                    <input type="search" id="search-form-2" class="search-field" value=""
                                    name="search" placeholder="Search" />
                                    <button type="submit" title="Submit Search" aria-label="Submit Search"
                                    class="search-submit icon">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="7.07143" cy="6.57143" r="6.07143" stroke="white">
                                            </circle>
                                            <path d="M11.4618 10.9618L15.9359 15.4359" stroke="white" stroke-linecap="square">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <header id="mobile-header">
        <div class="int">
            <div class="row wrap">
                <a href="https://cfarchives.wpengine.com/" id="logo-mobile">
                    <img src="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/cfa-logo-mobile.svg"
                    />
                </a>
                <a href="#" id="burger">
                    <img src="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/burger.svg"
                    />
                </a>
            </div>
        </div>
    </header>
    <section id="mobile-panel">
        <div class="layout">
            <div class="row wrap">
                <a href="#" id="close-mobile-panel">
                    <img src="https://cfarchives.wpengine.com/wp-content/themes/Chicago-Film-Archives/assets/img/close-panel-icon.svg"
                    />
                </a>
            </div>
            <div class="scroll-layer">
                <div class="menu-container">
                    <div class="wrap">
                        <div class="module-search-form">
                            <form role="search" aria-label="Search For" method="get" class="search-form"
                            action="https://cfarchives.wpengine.com/">
                                <label for="search-form-3" class="visually-hidden">
                                    Search
                                </label>
                                <div class="search-container">
                                    <input type="search" id="search-form-3" class="search-field" value=""
                                    name="s" placeholder="Search" />
                                    <button type="submit" title="Submit Search" aria-label="Submit Search"
                                    class="search-submit icon">
                                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="7.07143" cy="6.57143" r="6.07143" stroke="white">
                                            </circle>
                                            <path d="M11.4618 10.9618L15.9359 15.4359" stroke="white" stroke-linecap="square">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <ul id="menu-main-mobile" class="nav header-nav main">
                            <li id="menu-item-265" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-265">
                                <a href="https://cfarchives.wpengine.com/">
                                    Home
                                </a>
                            </li>
                            <li id="menu-item-266" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-8 current_page_item menu-item-266">
                                <a href="https://cfarchives.wpengine.com/collections/" aria-current="page">
                                    Collections
                                </a>
                            </li>
                            <li id="menu-item-269" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-269">
                                <a href="https://cfarchives.wpengine.com/watch/">
                                    Watch
                                </a>
                            </li>
                            <li id="menu-item-267" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-267">
                                <a href="https://cfarchives.wpengine.com/services/">
                                    Services
                                </a>
                            </li>
                            <li id="menu-item-270" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-270">
                                <a href="https://cfarchives.wpengine.com/preservation/">
                                    Preservation
                                </a>
                            </li>
                            <li id="menu-item-268" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-268">
                                <a href="https://cfarchives.wpengine.com/digital-exhibitions/">
                                    Digital Exhibitions
                                </a>
                            </li>
                        </ul>
                        <ul id="menu-extra-1" class="nav header-nav extra">
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-34">
                                <a href="https://cfarchives.wpengine.com/calendar/">
                                    Events
                                </a>
                            </li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-33">
                                <a href="https://cfarchives.wpengine.com/news/">
                                    News
                                </a>
                            </li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-36">
                                <a href="https://cfarchives.wpengine.com/about/">
                                    About
                                </a>
                            </li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-35">
                                <a href="https://cfarchives.wpengine.com/support/">
                                    Support
                                </a>
                            </li>
                        </ul>
                        <ul class="module-socials menu horizontal">
                            <li>
                                <a href="https://instagram.com/chicagofilmarchives" target="_blank" aria-label="Open Icon-instagram in a new Window"
                                title="Open Icon-instagram in a new Window">
                                    <svg fill="none" height="30" viewBox="0 0 30 30" width="30" xmlns="http://www.w3.org/2000/svg">
                                        <g fill="#fff">
                                            <path d="m15.0002 17.6044c1.4383 0 2.6042-1.166 2.6042-2.6042 0-1.4383-1.1659-2.6042-2.6042-2.6042-1.4382 0-2.6042 1.1659-2.6042 2.6042 0 1.4382 1.166 2.6042 2.6042 2.6042z">
                                            </path>
                                            <g clip-rule="evenodd" fill-rule="evenodd">
                                                <path d="m15 0c-8.28427 0-15 6.71573-15 15 0 8.2843 6.71573 15 15 15 8.2843 0 15-6.7157 15-15 0-3.9783-1.5803-7.79357-4.3934-10.60662-2.813-2.81305-6.6283-4.39340072-10.6066-4.39338zm7.7655 18.2211c-.0131.6481-.1358 1.2893-.3632 1.8964-.4058 1.0494-1.2354 1.879-2.2848 2.2848-.6071.2273-1.2483.3501-1.8964.3631-.8332.0381-1.0994.0471-3.2211.0471s-2.3878-.009-3.2211-.047c-.6481-.013-1.2893-.1358-1.89639-.3632-1.04945-.4057-1.87905-1.2353-2.28482-2.2848-.22736-.607-.35015-1.2483-.36316-1.8964-.03806-.8333-.04703-1.0994-.04703-3.2211s.00897-2.3878.04702-3.2211c.01301-.6481.1358-1.2893.36315-1.8964.40577-1.04944 1.23537-1.87905 2.28482-2.28483.60711-.22736 1.24821-.35015 1.89641-.36315.8333-.03805 1.0994-.04702 3.2211-.04702s2.3879.00897 3.2211.04702c.6481.013 1.2893.13579 1.8964.36315 1.0494.40577 1.879 1.23538 2.2848 2.28481.2274.60702.3501 1.24832.3632 1.89642.038.8333.047 1.0994.047 3.2211s-.009 2.3878-.047 3.2211z">
                                                </path>
                                                <path d="m21.0897 10.3924c-.2628-.6813-.8014-1.21981-1.4826-1.48265-.4646-.17217-.9553-.26317-1.4507-.26903-.8239-.0376-1.0709-.04551-3.157-.04551-2.086 0-2.3329.00791-3.1569.04549-.4953.00586-.9861.09687-1.4506.26903-.68131.26284-1.21982.80136-1.48266 1.48267-.17217.4646-.26317.9553-.26903 1.4506-.03758.8239-.04548 1.0711-.04548 3.157s.00791 2.3331.04548 3.1569c.00585.4954.09685.9861.26903 1.4507.26284.6813.80135 1.2198 1.48266 1.4827.4645.1721.9553.2631 1.4506.269.8238.0375 1.0708.0455 3.1569.0455 2.0862 0 2.3333-.0079 3.157-.0455.4954-.0059.9861-.0969 1.4507-.269.6812-.2629 1.2198-.8014 1.4826-1.4827.1722-.4646.2632-.9553.269-1.4507.0376-.8238.0455-1.0708.0455-3.1569s-.0078-2.3331-.0455-3.157c-.0058-.4953-.0968-.986-.269-1.4506zm-6.0901 8.6195c-2.2156 0-4.0117-1.7961-4.0117-4.0118s1.7961-4.0118 4.0117-4.0118c2.2157 0 4.0119 1.7961 4.0119 4.0118 0 1.064-.4227 2.0844-1.175 2.8368-.7524.7524-1.7728 1.175-2.8369 1.175zm4.1703-7.2448c-.5178 0-.9375-.4197-.9375-.9375s.4197-.93748.9375-.93748.9376.41968.9376.93748-.4198.9375-.9376.9375z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/chicagofilmarchives/" target="_blank"
                                aria-label="Open Icon-facebook in a new Window" title="Open Icon-facebook in a new Window">
                                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.5527 10.3657H16.2973C16.0308 10.3657 15.7336 10.716 15.7336 11.1854V12.8138H18.5527V15.135H15.7336V22.1054H13.071V15.135H10.6577V12.8138H13.071V11.4475C13.071 9.48849 14.4311 7.89505 16.2973 7.89505H18.5527V10.3657ZM15 0C6.71564 0 0 6.71562 0 15C0 23.2847 6.71564 30 15 30C23.2844 30 30 23.2847 30 15C30 6.71562 23.2844 0 15 0Z"
                                        fill="white">
                                        </path>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.youtube.com/user/chicagofilmarchives" target="_blank"
                                aria-label="Open Icon-youtube in a new Window" title="Open Icon-youtube in a new Window">
                                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15 0C23.279 0 30 6.72129 30 15C30 23.2787 23.279 30 15 30C6.721 30 0 23.2787 0 15C0 6.72129 6.721 0 15 0ZM23.983 10.487C23.768 9.68022 23.132 9.045 22.326 8.82938C20.863 8.4375 15 8.4375 15 8.4375C15 8.4375 9.137 8.4375 7.674 8.82938C6.868 9.045 6.232 9.68022 6.017 10.487C5.625 11.9492 5.625 15.0001 5.625 15.0001C5.625 15.0001 5.625 18.0509 6.017 19.513C6.232 20.3198 6.868 20.9552 7.674 21.1708C9.137 21.5625 15 21.5625 15 21.5625C15 21.5625 20.863 21.5625 22.326 21.1708C23.132 20.9552 23.768 20.3198 23.983 19.513C24.375 18.0509 24.375 15.0001 24.375 15.0001C24.375 15.0001 24.375 11.9492 23.983 10.487ZM13.125 17.8126V12.1875L17.9961 15L13.125 17.8126Z"
                                        fill="white">
                                        </path>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/ChiFilmArchives" target="_blank" aria-label="Open Icon-twitter in a new Window"
                                title="Open Icon-twitter in a new Window">
                                    <svg width="31" height="30" viewBox="0 0 31 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <mask id="mask0_1078_692" style="mask-type: luminance" maskUnits="userSpaceOnUse"
                                        x="0" y="0" width="31" height="30">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 30H30.5555V0H0L0 30H0Z"
                                            fill="white">
                                            </path>
                                        </mask>
                                        <g mask="url(#mask0_1078_692)">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M21.4906 12.2882C21.4969 12.4151 21.4992 12.5426 21.4992 12.6707C21.4992 16.5748 18.4726 21.0766 12.9379 21.0766C11.2389 21.0766 9.65731 20.5873 8.32592 19.7488C8.56081 19.7766 8.80016 19.7904 9.04333 19.7904C10.453 19.7904 11.7504 19.3182 12.7807 18.5254C11.4639 18.5019 10.3524 17.6476 9.96955 16.4741C10.1535 16.5082 10.3419 16.5269 10.5358 16.5269C10.8098 16.5269 11.0759 16.4907 11.3283 16.4232C9.95204 16.1516 8.91443 14.9579 8.91443 13.5263C8.91443 13.5138 8.91443 13.5016 8.91506 13.4894C9.32056 13.7107 9.78494 13.8435 10.2776 13.8588C9.47016 13.3288 8.93925 12.4247 8.93925 11.3994C8.93925 10.8582 9.08726 10.351 9.34666 9.91442C10.8305 11.7019 13.048 12.8782 15.5488 13.0013C15.4972 12.7851 15.4711 12.5594 15.4711 12.3279C15.4711 10.6963 16.8181 9.37379 18.4799 9.37379C19.3453 9.37379 20.1274 9.73254 20.6761 10.3066C21.362 10.1741 22.0059 9.92848 22.5871 9.58973C22.362 10.2794 21.8853 10.8588 21.2643 11.2244C21.8728 11.1529 22.4528 10.9941 22.9926 10.7591C22.589 11.3513 22.0788 11.8719 21.4906 12.2882ZM15.2775 0C6.8391 0 -0.000244141 6.71565 -0.000244141 15C-0.000244141 23.2844 6.8391 30.0001 15.2775 30.0001C23.715 30.0001 30.5553 23.2844 30.5553 15C30.5553 6.71565 23.715 0 15.2775 0Z"
                                            fill="white">
                                            </path>
                                        </g>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

<div class="container-fluid gx-0">
	<div class="row">
		<div class="col-xs-12">
			<div role="main" id="main">
				<div id="pageArea" <?php print caGetPageCSSClasses(); ?>
