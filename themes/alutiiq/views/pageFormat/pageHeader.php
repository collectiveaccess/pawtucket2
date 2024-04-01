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
<body class="page-template-default page ">
	<div class="uk-hidden-visually uk-notification uk-notification-top-left uk-width-auto">
		<div class="uk-notification-message">
			<a href="#tm-main">Skip to main content</a>
		</div>
	</div>
	<!--- Mobile Header --->
	<div id="tm-dialog-mobile" uk-offcanvas="container: true; overlay: true" mode="slide" flip="" class="uk-offcanvas" tabindex="-1">
		<div class="uk-offcanvas-bar uk-flex uk-flex-column uk-offcanvas-bar-animation uk-offcanvas-slide" role="dialog" aria-modal="true" style="max-width: 452px;">
			<button class="uk-offcanvas-close uk-close-large uk-icon uk-close" type="button" uk-close="" uk-toggle="cls: uk-close-large; mode: media; media: @s" aria-label="Close"><svg width="20" height="20" viewBox="0 0 20 20"><line fill="none" stroke="#000" stroke-width="1.4" x1="1" y1="1" x2="19" y2="19"></line><line fill="none" stroke="#000" stroke-width="1.4" x1="19" y1="1" x2="1" y2="19"></line></svg></button>
			<div class="uk-margin-auto-bottom">
				<div class="uk-grid uk-child-width-1-1 uk-grid-stack" uk-grid="">
					<div class="uk-first-column">
						<div class="uk-panel">
							<a href="https://alutiiqmuseum.org/" aria-label="Back to home" class="uk-logo">
								<?php print caGetThemeGraphic($this->request, "AlutiiqMuseum_Logo.png", array("alt" => "Alutiiq Museum Logo")); ?>
							</a>
						</div>
					</div>
					<div class="uk-grid-margin uk-first-column">
						<div class="uk-panel widget widget_nav_menu" id="nav_menu-2">   
							<ul class="uk-nav uk-nav-default">    
								<li class="menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor menu-item-has-children uk-active uk-parent"><a href="https://alutiiqmuseum.org/alutiiq-people/"> Alutiiq People</a>
								<ul class="uk-nav-sub">

									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/alutiiq-people/history/"> History</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/alutiiq-people/subsistence/"> Subsistence</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor uk-active"><a href="https://alutiiqmuseum.org/alutiiq-people/language/"> Language</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/alutiiq-people/art/"> Art</a></li></ul></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children uk-parent"><a href="https://alutiiqmuseum.org/museum/"> Museum</a>
								<ul class="uk-nav-sub">

									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/about/"> About</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/visit/"> Visit</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/renovation/"> Renovation</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/artist-services/"> Artist Services</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/collections/"> Collections</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/library/"> Library</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/repatriation/"> Repatriation</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/archaeology/"> Archaeology</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/education/"> Education</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/exhibits/"> Exhibits</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/publications/"> Publications</a></li></ul></li>
								<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="https://alutiiqmuseum.myshopify.com/" target="_blank"> Shop</a></li>
								<li class="red-nav-button menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children uk-parent"><a href="https://alutiiqmuseum.org/give/"> Give</a>
								<ul class="uk-nav-sub">

									<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="https://alutiiqmuseum.org/give/membership/"> Membership</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/give/donate/"> Donations</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/give/sponsor/"> Sponsorships</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/give/volunteer/"> Volunteering</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/give/quyanaa/"> Quyanaasinaq</a></li>
								</ul></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> 
	<!--- END Mobile Header --->
	<div class="tm-page">
		<div class="tm-toolbar tm-toolbar-default uk-visible@m">
    		<div class="uk-container uk-flex uk-flex-middle uk-flex-center">
				<div>
            		<div class="uk-grid-medium uk-child-width-auto uk-flex-middle uk-grid uk-grid-stack" uk-grid="margin: uk-margin-small-top">
						<div class="uk-first-column">
							<div class="uk-panel widget widget_custom_html" id="custom_html-3">
								<div class="textwidget custom-html-widget">&nbsp;</div>
							</div>
						</div>                                
					</div>
				</div>
			</div>
		</div>
		<header class="tm-header-mobile uk-hidden@m">
			<div class="uk-navbar-container">
				<div class="uk-container uk-container-expand">
					<nav class="uk-navbar" uk-navbar="{&quot;container&quot;:&quot;.tm-header-mobile&quot;,&quot;boundary&quot;:&quot;.tm-header-mobile .uk-navbar-container&quot;}">
						<div class="uk-navbar-left">
								<a href="https://alutiiqmuseum.org/" aria-label="Back to home" class="uk-logo uk-navbar-item"><picture>
								<source type="image/webp" srcset="https://alutiiqmuseum.org/wp-admin/admin-ajax.php?action=kernel&amp;p=image&amp;src=%7B%22file%22%3A%22wp-content%2Fuploads%2F2023%2F08%2FAlutiiq-Museum-Logo.png%22%2C%22type%22%3A%22webp%2C100%22%2C%22thumbnail%22%3A%22%2C98%22%7D&amp;hash=4b20a6ad 134w, /wp-content/themes/yootheme/cache/4b/Alutiiq-Museum-Logo-4b8bdcea.webp 268w" sizes="(min-width: 134px) 134px">
								<img alt="Alutiiq Museum &amp; Archaeological Repository" loading="eager" src="https://alutiiqmuseum.org/wp-admin/admin-ajax.php?action=kernel&amp;p=image&amp;src=%7B%22file%22%3A%22wp-content%2Fuploads%2F2023%2F08%2FAlutiiq-Museum-Logo.png%22%2C%22thumbnail%22%3A%22%2C98%22%7D&amp;hash=def9242d" width="134" height="98">
								</picture><picture>
								<source type="image/webp" srcset="https://alutiiqmuseum.org/wp-admin/admin-ajax.php?action=kernel&amp;p=image&amp;src=%7B%22file%22%3A%22wp-content%2Fuploads%2F2023%2F08%2FAlutiiq-Museum-Logo-Inverse.png%22%2C%22type%22%3A%22webp%2C100%22%2C%22thumbnail%22%3A%22%2C98%22%7D&amp;hash=858cccaf 134w, /wp-content/themes/yootheme/cache/f9/Alutiiq-Museum-Logo-Inverse-f9f1b723.webp 268w" sizes="(min-width: 134px) 134px">
								<img class="uk-logo-inverse" alt="Alutiiq Museum &amp; Archaeological Repository" loading="eager" src="https://alutiiqmuseum.org/wp-admin/admin-ajax.php?action=kernel&amp;p=image&amp;src=%7B%22file%22%3A%22wp-content%2Fuploads%2F2023%2F08%2FAlutiiq-Museum-Logo-Inverse.png%22%2C%22thumbnail%22%3A%22%2C98%22%7D&amp;hash=cb6f67a8" width="134" height="98">
								</picture></a>                        
						</div>
						<div class="uk-navbar-right">
							<a uk-toggle="" href="#tm-dialog-mobile" class="uk-navbar-toggle" role="button" aria-label="Open menu">
								<div uk-navbar-toggle-icon="" class="uk-icon uk-navbar-toggle-icon"><svg width="20" height="20" viewBox="0 0 20 20"><style>.uk-navbar-toggle-animate svg&gt;[class*="line-"]{transition:0.2s ease-in-out;transition-property:transform, opacity;transform-origin:center;opacity:1}.uk-navbar-toggle-animate svg&gt;.line-3{opacity:0}.uk-navbar-toggle-animate[aria-expanded="true"] svg&gt;.line-3{opacity:1}.uk-navbar-toggle-animate[aria-expanded="true"] svg&gt;.line-2{transform:rotate(45deg)}.uk-navbar-toggle-animate[aria-expanded="true"] svg&gt;.line-3{transform:rotate(-45deg)}.uk-navbar-toggle-animate[aria-expanded="true"] svg&gt;.line-1,.uk-navbar-toggle-animate[aria-expanded="true"] svg&gt;.line-4{opacity:0}.uk-navbar-toggle-animate[aria-expanded="true"] svg&gt;.line-1{transform:translateY(6px) scaleX(0)}.uk-navbar-toggle-animate[aria-expanded="true"] svg&gt;.line-4{transform:translateY(-6px) scaleX(0)}</style><rect class="line-1" y="3" width="20" height="2"></rect><rect class="line-2" y="9" width="20" height="2"></rect><rect class="line-3" y="9" width="20" height="2"></rect><rect class="line-4" y="15" width="20" height="2"></rect></svg></div>
							</a>
						</div>
					</nav>
				</div>
			</div>
		</header>
		<header class="tm-header uk-visible@m">
			<div uk-sticky="" media="@m" show-on-up="" animation="uk-animation-slide-top" cls-active="uk-navbar-sticky" sel-target=".uk-navbar-container" class="uk-sticky" style="">
    			<div class="uk-navbar-container">
					<div class="uk-container">
                		<nav class="uk-navbar" uk-navbar="{&quot;align&quot;:&quot;center&quot;,&quot;container&quot;:&quot;.tm-header > [uk-sticky]&quot;,&quot;boundary&quot;:&quot;.tm-header .uk-navbar-container&quot;}">
							<div class="uk-navbar-left">
								<a href="https://alutiiqmuseum.org/" aria-label="Back to home" class="uk-logo uk-navbar-item"><picture>
								<source type="image/webp" srcset="https://alutiiqmuseum.org/wp-admin/admin-ajax.php?action=kernel&amp;p=image&amp;src=%7B%22file%22%3A%22wp-content%2Fuploads%2F2023%2F08%2FAlutiiq-Museum-Logo.png%22%2C%22type%22%3A%22webp%2C100%22%2C%22thumbnail%22%3A%22%2C98%22%7D&amp;hash=4b20a6ad 134w, /wp-content/themes/yootheme/cache/4b/Alutiiq-Museum-Logo-4b8bdcea.webp 268w" sizes="(min-width: 134px) 134px">
								<img alt="Alutiiq Museum &amp; Archaeological Repository" loading="eager" src="https://alutiiqmuseum.org/wp-admin/admin-ajax.php?action=kernel&amp;p=image&amp;src=%7B%22file%22%3A%22wp-content%2Fuploads%2F2023%2F08%2FAlutiiq-Museum-Logo.png%22%2C%22thumbnail%22%3A%22%2C98%22%7D&amp;hash=def9242d" width="134" height="98">
								</picture><picture>
								<source type="image/webp" srcset="https://alutiiqmuseum.org/wp-admin/admin-ajax.php?action=kernel&amp;p=image&amp;src=%7B%22file%22%3A%22wp-content%2Fuploads%2F2023%2F08%2FAlutiiq-Museum-Logo-Inverse.png%22%2C%22type%22%3A%22webp%2C100%22%2C%22thumbnail%22%3A%22%2C98%22%7D&amp;hash=858cccaf 134w, /wp-content/themes/yootheme/cache/f9/Alutiiq-Museum-Logo-Inverse-f9f1b723.webp 268w" sizes="(min-width: 134px) 134px">
								<img class="uk-logo-inverse" alt="Alutiiq Museum &amp; Archaeological Repository" loading="eager" src="https://alutiiqmuseum.org/wp-admin/admin-ajax.php?action=kernel&amp;p=image&amp;src=%7B%22file%22%3A%22wp-content%2Fuploads%2F2023%2F08%2FAlutiiq-Museum-Logo-Inverse.png%22%2C%22thumbnail%22%3A%22%2C98%22%7D&amp;hash=cb6f67a8" width="134" height="98">
								</picture></a>                        
                    		</div>
                    		<div class="uk-navbar-center">
								<ul class="uk-navbar-nav">
    
									<li class="menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor menu-item-has-children uk-active uk-parent"><a href="https://alutiiqmuseum.org/alutiiq-people/" role="button" aria-haspopup="true"> Alutiiq People</a>
									<div class="uk-navbar-dropdown uk-navbar-dropdown-width-2 uk-drop" style="width: 500px;"><div class="uk-drop-grid uk-child-width-1-2 uk-grid uk-grid-stack" uk-grid=""><div><ul class="uk-nav uk-navbar-dropdown-nav">

										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/alutiiq-people/history/"> History</a></li>
										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/alutiiq-people/subsistence/"> Subsistence</a></li></ul></div><div><ul class="uk-nav uk-navbar-dropdown-nav">

										<li class="menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor uk-active"><a href="https://alutiiqmuseum.org/alutiiq-people/language/"> Language</a></li>
										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/alutiiq-people/art/"> Art</a></li></ul></div></div></div></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children uk-parent"><a href="https://alutiiqmuseum.org/museum/" role="button" aria-haspopup="true"> Museum</a>
									<div class="uk-navbar-dropdown uk-navbar-dropdown-width-3 uk-drop" style="width: 700px;"><div class="uk-drop-grid uk-child-width-1-3 uk-grid uk-grid-stack" uk-grid=""><div><ul class="uk-nav uk-navbar-dropdown-nav">

										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/about/"> About</a></li>
										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/visit/"> Visit</a></li>
										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/renovation/"> Renovation</a></li>
										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/artist-services/"> Artist Services</a></li></ul></div><div><ul class="uk-nav uk-navbar-dropdown-nav">

										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/collections/"> Collections</a></li>
										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/library/"> Library</a></li>
										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/repatriation/"> Repatriation</a></li>
										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/archaeology/"> Archaeology</a></li></ul></div><div><ul class="uk-nav uk-navbar-dropdown-nav">

										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/education/"> Education</a></li>
										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/exhibits/"> Exhibits</a></li>
										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/museum/publications/"> Publications</a></li></ul></div></div></div></li>
									<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="https://alutiiqmuseum.myshopify.com/" target="_blank"> Shop</a></li>
									<li class="red-nav-button menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children uk-parent"><a href="https://alutiiqmuseum.org/give/" role="button" aria-haspopup="true"> Give</a>
									<div class="uk-navbar-dropdown uk-drop"><div><ul class="uk-nav uk-navbar-dropdown-nav">

										<li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="https://alutiiqmuseum.org/give/membership/"> Membership</a></li>
										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/give/donate/"> Donations</a></li>
										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/give/sponsor/"> Sponsorships</a></li>
										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/give/volunteer/"> Volunteering</a></li>
										<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://alutiiqmuseum.org/give/quyanaa/"> Quyanaasinaq</a></li></ul></div></div></li>
								</ul>
                        	</div>
                    		<div class="uk-navbar-right">
								<div class="uk-navbar-item widget widget_search" id="search-4">
									<form id="search-4" action="https://alutiiqmuseum.or" method="get" role="search" class="uk-search uk-search-default"><span uk-search-icon="" class="uk-icon uk-search-icon"><svg width="20" height="20" viewBox="0 0 20 20"><circle fill="none" stroke="#000" stroke-width="1.1" cx="9" cy="9" r="7"></circle><path fill="none" stroke="#000" stroke-width="1.1" d="M14,14 L18,18 L14,14 Z"></path></svg></span><input name="s" placeholder="Search" required="" aria-label="Search" type="search" class="uk-search-input"></form>
								</div>
                        	</div>
                		</nav>
           			</div>
				</div>
			</div><div class="uk-sticky-placeholder" style="height: 132px; width: 1715px; margin: 0px;" hidden=""></div>
		</header>
	
	
	
	
	
	
	
	
	
	
	
		<div role="main" id="tm-main">
<?php
	if(in_array(strToLower($this->request->getController()), array("word", "about")) || in_array(strToLower($this->request->getAction()), array("words", "word"))){
?>
		<div class="uk-section-secondary uk-section uk-section-xsmall">
    		<div class="uk-container">                
                <div class="uk-grid tm-grid-expand uk-child-width-1-1 uk-grid-margin">
					<div class="uk-width-1-1@m">
						 <nav aria-label="Breadcrumb">
							<ul class="uk-breadcrumb uk-margin-remove-bottom" vocab="https://schema.org/" typeof="BreadcrumbList">
	
									<li property="itemListElement" typeof="ListItem">            <a href="https://alutiiqmuseum.org" property="item" typeof="WebPage"><span property="name">Home</span></a>
									<meta property="position" content="1">
									</li>    
									<li property="itemListElement" typeof="ListItem">            <a href="https://alutiiqmuseum.org/alutiiq-people/" property="item" typeof="WebPage"><span property="name">Alutiiq People</span></a>
									<meta property="position" content="2">
									</li>    
									<li property="itemListElement" typeof="ListItem">            <a href="https://alutiiqmuseum.org/alutiiq-people/language/" property="item" typeof="WebPage"><span property="name">Language</span></a>
									<meta property="position" content="3">
									</li>    
									<li property="itemListElement" typeof="ListItem">            <span property="name">Alutiiq Word of the Week</span>            <meta property="position" content="4">
									</li>    
							</ul>
						</nav>
						<h1 class="uk-heading-medium uk-margin-small" uk-parallax="y: 0,-75; easing: 1; media: @m" style="transform: translateY(0px); will-change: transform;">        Alutiiq Word of the Week    </h1>
					</div>
				</div>
            </div>                
		</div>
		<div class="uk-section-muted uk-section">
			<div class="uk-container">                
                <div class="uk-grid tm-grid-expand uk-child-width-1-1 uk-grid-margin">
					<div class="uk-width-1-1">
						<nav class="uk-text-center">
							<ul class="uk-margin-remove-bottom uk-subnav  uk-subnav-divider uk-flex-center" uk-margin="">        <li class="el-item uk-first-column">
							<a class="el-link" href="https://alutiiqmuseum.org/alutiiq-people/language/lessons/">Lessons</a></li>
								<li class="el-item ">
									<?php print caNavLink($this->request, _t("Word of the Week"), "el-link", "", "Word", "Index"); ?>
								<li class="el-item ">
							<a class="el-link" href="https://languagearchive.alutiiqmuseum.org/home">Language Collections</a></li>
								<li class="el-item ">
							<a class="el-link" href="https://alutiiqmuseum.org/alutiiq-people/language/language-research/">Research</a></li>
								<li class="el-item ">
							<a class="el-link" href="https://alutiiqmuseum.org/alutiiq-people/language/language-history/">Language History</a></li>
								</ul>
						</nav>
					</div>
				</div>
            </div>                
		</div>
<?php	
	}else{
?>
		<div class="uk-section-secondary uk-section uk-section-xsmall">
			<div class="uk-container">                
				<div class="uk-grid tm-grid-expand uk-child-width-1-1 uk-grid-margin">
					<div class="uk-width-1-1@m">
						<nav aria-label="Breadcrumb">
							<ul class="uk-breadcrumb uk-margin-remove-bottom" vocab="https://schema.org/" typeof="BreadcrumbList">
	
									<li property="itemListElement" typeof="ListItem">            <a href="https://alutiiqmuseum.org" property="item" typeof="WebPage"><span property="name">Home</span></a>
									<meta property="position" content="1">
									</li>    
									<li property="itemListElement" typeof="ListItem">            <a href="https://alutiiqmuseum.org/museum/" property="item" typeof="WebPage"><span property="name">Museum</span></a>
									<meta property="position" content="2">
									</li>    
									<li property="itemListElement" typeof="ListItem">            <a href="https://alutiiqmuseum.org/museum/collections/" property="item" typeof="WebPage"><span property="name">Collections</span></a>
									<meta property="position" content="3">
									</li>    
									<li property="itemListElement" typeof="ListItem">            <span property="name">Amutat</span>            <meta property="position" content="4">
									</li>    
							</ul>
						</nav>
						<h1 class="uk-heading-medium uk-margin-small" uk-parallax="y: 0,-75; easing: 1; media: @m" style="transform: translateY(0px); will-change: transform;">        Amutat    </h1>
					</div>
				</div>
			</div>                
		</div>
<?php
	}
?>
	<div id="pageArea" <?php print caGetPageCSSClasses(); ?>><div class="content-area">
<?php
	if(!in_array(strToLower($this->request->getController()), array("word", "detail"))){
?>
		<div class="container" style="clear:both;"><div class="row"><div class="col-xs-12">
<?php	
	}
?>