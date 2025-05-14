<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (https://www.whirl-i-gig.com)
 * Copyright 2014-2017 Whirl-i-Gig
 *
 * For more information visit https://www.CollectiveAccess.org
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
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-125575750-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
 
	  gtag('config', 'UA-125575750-1');
	</script>
	<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-W2MDBZ7');</script>
	<!-- End Google Tag Manager -->	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?php print MetaTagManager::getHTML(); ?>
	<link rel="stylesheet" type="text/css" href="<?php print $this->request->getAssetsUrlPath(); ?>/mirador/css/mirador-combined.css">
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>

	<!-- what should we include from the WP site for JS -->
	<script type='text/javascript'>
		jQuery(document).ready(function($){

			//mobile menu
			$('#header-mobile-content-trigger').on('click', function(){
				$(this).toggleClass('active');
				$('#header-mobile-content').scrollTop(0);
				$('#header-mobile-content').toggleClass('active');
				$('#header-mobile').toggleClass('active');
			});

			var headerMobileContent = $('#header-mobile-content'),
				headerMobile = $('#header-mobile');

			headerMobileContent.on('scroll', function(){
				if ( headerMobileContent.hasClass('active') )
				{
					if ( headerMobileContent.scrollTop() > 0 ) headerMobile.addClass('content-under');
					else headerMobile.removeClass('content-under');
				}
				else headerMobile.removeClass('content-under');
			});

			//submenu togglers
			var subMenuParents = $('.menu-item-has-children');

			subMenuParents.each(function(){
				var subMenuParent = $(this),
					subMenu = subMenuParent.find('.sub-menu');
					subMenuToggle = $('<span class="submenu-toggle"><span class="line line-horizontal"></span><span class="line line-vertical"></span></span>');

				subMenuParent.prepend(subMenuToggle);

				if ( subMenuParent.hasClass('current-menu-ancestor') || subMenuParent.hasClass('current-menu-item') )
				{
					subMenu.addClass('active');
					subMenuToggle.addClass('active');

					subMenuParent.removeClass('current-menu-item current-menu-ancestor');
				}

				subMenuToggle.on('click', function(){
					subMenuParents.find('.sub-menu').not($(this).parent().find('.sub-menu')).removeClass('active');
					subMenuParents.find('.submenu-toggle').not($(this)).removeClass('active');

					$(this).toggleClass('active');
					subMenu.toggleClass('active');

				});

			});
		});
	</script>

	
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
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W2MDBZ7"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<div class="page <?php print $this->request->getController();?>" >
		<div class="wrapper">
			<div class="sidebar hidden-sm hidden-xs"><div class="inner">
				<div class='custom-logo'>
					<a href='https://www.stormking.org'><?php print caGetThemeGraphic($this->request, '2021_SKAC_Logo_Website.svg'); ?></a>			
                </div>	
				<div class="main-menu">
					<ul class="nav menuItems">
						<li><a href='https://stormking.org/visit/'>Visit</a></li>
						<li><a href='#'>Art</a>
							<ul class='subMenu'>
								<li>
									<?php print caNavLink($this->request, _t("Collection"), "", "", "About", "collection"); ?>
<?php
								if ((($this->request->getController() == "Browse") && ($this->request->getAction() == "entities")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "entities")) | (($this->request->getController() == "About") && ($this->request->getAction() == "collection"))) {
?>								
									<ul class='subMenu'>
										<li <?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "entities")) || (($this->request->getController() == "Detail") && ($this->request->getAction() == "entities"))) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Artists"), "", "", "Browse", "entities"); ?></li>					
									</ul>												
<?php						
								} 
?>							
								</li>
<?php
								print "<li>".caNavLink($this->request, _t("Exhibitions"), "", "", "About", "exhibitions");

						if (((strtolower($this->request->getController()) == "featured") && (($this->request->getParameter('setMode', pString) == "exhibitions") || (strtolower($this->request->getAction()) == "index") || (strtolower($this->request->getAction()) == "theme"))) || ((strtolower($this->request->getController()) == "about") && ($this->request->getAction() == "exhibitions")) | ((strtolower($this->request->getController()) == "browse") && ($this->request->getAction() != "entities")) | ((strtolower($this->request->getController()) == "listing") && ($this->request->getAction() == "currentexhibitions"))  | ((strtolower($this->request->getController()) == "listing") && ($this->request->getAction() == "exhibitions")) | ((strtolower($this->request->getController()) == "detail") && ($this->request->getAction() == "occurrences"))) {
?>							
									<ul class='subMenu'>
										<li <?php print ((($this->request->getAction() == "currentexhibitions") ) ? 'class="active"' : ''); ?>><?php print caNavLink($this->request, _t("Current & Upcoming"), "", "", "Listing", "currentexhibitions", array("sort" => "default", "direction" => "desc")); ?></li>					
										<li <?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "exhibitions")) ? 'class="active"' : ''); ?>><?php print caNavLink($this->request, _t("Past"), "", "", "Browse", "exhibitions"); ?></li>					
										<li <?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "objects")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "objects"))) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Art"), "", "", "Browse", "objects"); ?></li>					
										<li <?php print ((strtolower($this->request->getController()) == "featured") && (($this->request->getParameter('setMode', pString) == "exhibitions") || (strtolower($this->request->getAction()) == "index") || (strtolower($this->request->getAction()) == "theme"))) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Digital"), "", "", "Featured", "index"); ?></li>					
									</ul>
<?php
						}
?>							
						
								</li>
								<li>
<?php
									print caNavLink($this->request, _t("Archives"), "", "", "About", "archives");

						if (((($this->request->getParameter('setMode', pString) == "archives") || (strtolower($this->request->getAction()) == "archives"))) || ($this->request->getController() == "Collections") | (($this->request->getController() == "Listing") && ($this->request->getAction() == "oralhistory")) | (($this->request->getController() == "About") && ($this->request->getAction() == "archives")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "collections")) | ($this->request->getAction() == "oralhistory") | (($this->request->getController() == "Detail") && ($this->request->getAction() == "archival"))) {
?>							
										<ul class='subMenu'>
											<li style="padding-top:6px;" <?php print (($this->request->getController() == "Listing")| ($this->request->getAction() == "oralhistory") ) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Oral History"), "", "", "Listing", "oralhistory"); ?></li>					
											<li <?php print ( (($this->request->getController() == "Detail") && ($this->request->getAction() == "archival")) | ($this->request->getController() == "Collections") | ($this->request->getAction() == "collections")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Special Collections"), "", "", "Collections", "index"); ?></li>					
										</ul>
<?php
						}
?>							
								</li>
							</ul>
						</li>					
						<li><a href='https://stormking.org/learning/'>Programs</a></li>
						<li><a href='https://stormking.org/support/'>Join</a></li>
						<li class="smallLinks first"><a href='https://stormking.org/about/'>About</a></li>
						<li class="smallLinks"><a href='https://stormking.org/calendar/'>Calendar</a></li>
						<li class="smallLinks"><a href='https://shop.stormking.org/'>Shop</a></li>
					</ul>	
						

				</div>
				<footer class="nav-footer">
					<form class="navbar-form " role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>"> 
						<div class="formOutline">
							<button type="submit" class="btn-search"><span class="icon">
								<svg version="1.2" baseProfile="tiny" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
								  <path fill="none" d="M7.7 2.7c-1.3 0-2.6.5-3.5 1.5-1 .9-1.5 2.2-1.5 3.5 0 1.3.5 2.6 1.5 3.5 2 1.9 5.1 1.9 7.1 0 .9-.9 1.5-2.2 1.5-3.5 0-1.3-.5-2.6-1.5-3.5-1-1-2.3-1.5-3.6-1.5z"></path>
								  <path d="M7.7 0c-2.1 0-4 .8-5.5 2.3C.8 3.7 0 5.7 0 7.7c0 2.1.8 4 2.3 5.5 3 3 7.9 3 10.9 0 1.5-1.5 2.3-3.4 2.2-5.5 0-2.1-.8-4-2.3-5.5C11.7.8 9.8 0 7.7 0zm3.6 11.3c-1.9 2-5.1 2-7.1 0-.9-.9-1.5-2.2-1.5-3.5 0-1.3.5-2.6 1.5-3.5.9-.9 2.2-1.5 3.5-1.5 1.3 0 2.6.5 3.5 1.5.9.9 1.5 2.2 1.5 3.5 0 1.2-.5 2.5-1.4 3.5z"></path>
								  <path d="M11.333 13.54l2.263-2.263 6.435 6.435-2.26 2.263z"></path>
								</svg>
							</span></button>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Search..." name="search">
							</div>						
						</div>
					</form>
					<nav class="secondary-menu"><ul id="menu-secondary-menu" class="menu">
						<li><a href="https://stormking.org/press/">Press</a></li>
						<li><a href="https://lp.constantcontactpages.com/su/1eyaAGn">Subscribe</a></li>
						<li><a href="https://stormking.org/jobs/">Careers</a></li>
						<li><a href="https://stormking.org/contact/">Contact</a></li>
						<li><a href="https://stormking.org/termsprivacycredits/">Terms &amp; Privacy Policy</a></li>
						<li><a href="https://stormking.org">©<?php print date("Y"); ?> Storm King Art Center</a></li>
					</ul></nav>	
					<div class="social">
						<ul>
							<li>
								<a class="instagram" href="https://www.instagram.com/stormkingartcenter/" target="_blank">
									<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 18 18">
									  <path d="M91.871,135.881H79.196v-7.718h0.991a5.521,5.521,0,1,0,10.692,0h0.992v7.718Zm-6.338-9.518a3.181,3.181,0,1,1-3.181,3.181,3.18461,3.18461,0,0,1,3.181-3.181m3.444-3.011a0.75177,0.75177,0,0,1,.752-0.752h1.984a0.75241,0.75241,0,0,1,.752.752v1.984a0.75177,0.75177,0,0,1-.752.752H89.729a0.75113,0.75113,0,0,1-.752-0.752v-1.984ZM76.533,138.544h18v-18h-18v18Z" transform="translate(-76.53295 -120.544)" fill="#231f20"></path>
									</svg>
								</a>
							</li>
							<li>
								<a class="twitter" href="https://twitter.com/stormkingartctr" target="_blank">
									<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 18 18">
									  <path d="M122.744,145.232a3.54841,3.54841,0,0,0,2.987-.187,1.45532,1.45532,0,1,1,1.355,2.576,6.69563,6.69563,0,0,1-3.115.77,5.62356,5.62356,0,0,1-2.598-.591c-2.344-1.251-2.332-3.652-2.305-8.911,0.004-.675.008-1.408,0.007-2.204a1.456,1.456,0,0,1,2.912,0c0,0.801-.004,1.539-0.008,2.219,0,0.084-.001.16-0.001,0.242h4.437a1.4555,1.4555,0,1,1,0,2.911h-4.424c0.047,1.962.219,2.89,0.753,3.175M113.999,151h18V133h-18v18Z" transform="translate(-113.999 -133)" fill="#231f20"></path>
									</svg>
								</a>
							</li>
							<li>
								<a class="facebook" href="https://www.facebook.com/StormKingArtCenter/" target="_blank">
									<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 18 18">
									  <path d="M143.9996,133v18h9.276v-7.058h-1.505v-2.595h1.505v-0.44a5.24083,5.24083,0,0,1,1.414-3.799,4.6451,4.6451,0,0,1,3.15-1.136,7.70461,7.70461,0,0,1,1.853.232l-0.139,2.71a3.85652,3.85652,0,0,0-1.135-.161c-1.158,0-1.645.904-1.645,2.016v0.578h2.27v2.595h-2.246V151h5.202V133h-18Z" transform="translate(-143.9996 -133)" fill="#231f20"></path>
									</svg>
								</a>
							</li>
							<li>
								<a class="email" href="mailto:info@stormkingartcenter.org" target="_blank">
									<svg style="width:28px;" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 25.00009 18.0001">
									  <path fill="#231f20" d="M23.2 0H1.8l10.7 10.868L23.2 0M0 1.828V15.89l6.055-7.91L0 1.827"></path>
									  <path fill="#231f20" d="M12.5 14.525l-4.63-4.7L1.615 18h21.77L17.13 9.823l-4.63 4.702m6.445-6.547L25 15.89V1.828l-6.055 6.15"></path>
									</svg>
								</a>
							</li>
						</ul>
					</div>
				</footer>							
			</div></div>	









		<!-- mobile header -->
		<header id="header-mobile" class="hidden-lg hidden-md <?php print ($this->request->getController() == "About") ? "header-white" : ""; ?>">
			<div class="top">
				<div class="container">

					<div id="header-mobile-content-trigger">
						<svg version="1.2" baseProfile="tiny" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 28.9 23">
						  <path d="M0 0h28.9v5.4H0zm0 8.8h28.9v5.4H0zm0 8.7h28.9v5.4H0z"></path>
						</svg>
					</div>

					<a class="logo" href="https://stormking.org"><?php print caGetThemeGraphic($this->request, '2021_SKAC_Logo_Website.svg'); ?></a>

				</div>
			</div>
			<div id="header-mobile-content">
				<div class="container">
					<nav class="main-menu"><ul id="menu-main-menu-1" class="menu">
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-130"><a href="https://stormking.org/visit/">Visit</a>
							<ul class="sub-menu">
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/visit/tickets/">Tickets</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/visit/plan-your-visit/">Plan Your Visit</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/visit/groups/">Group Visits</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/visit/accessibility/">Accessibility</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/visit/policies/">Visitor Policies</a></li>
							</ul>
						</li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-130"><a href="#">Art</a>
							<ul class="sub-menu">
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children">
									<?php print caNavLink($this->request, _t("Collection"), "", "", "About", "collection"); ?>
									<ul class='sub-sub-menu<?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "entities")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "entities")) | (($this->request->getController() == "About") && ($this->request->getAction() == "collection"))) ? ' active' : ''; ?>'>
										<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "entities")) || (($this->request->getController() == "Detail") && ($this->request->getAction() == "entities"))) ? ' current-menu-item' : ''; ?>'><?php print caNavLink($this->request, _t("Artists"), "", "", "Browse", "entities"); ?></li>
									</ul>												
								</li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children">
									<?php print caNavLink($this->request, _t("Exhibitions"), "", "", "Listing", "exhibitions", array("sort" => "default", "direction" => "desc")); ?>
									<ul class='sub-sub-menu <?php print (((strtolower($this->request->getController()) == "featured") && (($this->request->getParameter('setMode', pString) == "exhibitions") || (strtolower($this->request->getAction()) == "index") || (strtolower($this->request->getAction()) == "theme"))) || ((strtolower($this->request->getController()) == "about") && ($this->request->getAction() == "exhibitions")) | ((strtolower($this->request->getController()) == "browse") && ($this->request->getAction() == "exhibitions")) | ((strtolower($this->request->getController()) == "listing") && ($this->request->getAction() == "currentexhibitions"))  | ((strtolower($this->request->getController()) == "listing") && ($this->request->getAction() == "exhibitions")) | ((strtolower($this->request->getController()) == "detail") && ($this->request->getAction() == "occurrences")) || (($this->request->getController() == "Browse") && ($this->request->getAction() == "objects")) || (($this->request->getController() == "Detail") && ($this->request->getAction() == "objects"))) ? ' active' : ''; ?>'>
										<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ((($this->request->getAction() == "currentexhibitions") ) ? ' current-menu-item' : ''); ?>'><?php print caNavLink($this->request, _t("Current & Upcoming"), "", "", "Listing", "currentexhibitions", array("sort" => "default", "direction" => "desc")); ?></li>					
										<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "exhibitions")) ? ' current-menu-item' : ''); ?>'><?php print caNavLink($this->request, _t("Past"), "", "", "Browse", "exhibitions"); ?></li>					
										<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "objects")) || (($this->request->getController() == "Detail") && ($this->request->getAction() == "objects"))) ? ' current-menu-item' : ''; ?>'><?php print caNavLink($this->request, _t("Art"), "", "", "Browse", "objects"); ?></li>					
										<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ((strtolower($this->request->getController()) == "featured") && (($this->request->getParameter('setMode', pString) == "exhibitions") || (strtolower($this->request->getAction()) == "index") || (strtolower($this->request->getAction()) == "theme"))) ? ' current-menu-item' : ''; ?>'><?php print caNavLink($this->request, _t("Digital"), "", "", "Featured", "index"); ?></li>					
									</ul>
								</li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children">
									<?php print caNavLink($this->request, _t("Archives"), "", "", "About", "archives"); ?> 
									<ul class='sub-sub-menu<?php print (((strtolower($this->request->getController()) == "featured") && (($this->request->getParameter('setMode', pString) == "archives") || (strtolower($this->request->getAction()) == "archives"))) | ($this->request->getController() == "Collections") | (($this->request->getController() == "Listing") && ($this->request->getAction() == "oralhistory")) | (($this->request->getController() == "About") && ($this->request->getAction() == "archives")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "collections")) | ($this->request->getAction() == "oralhistory") | (($this->request->getController() == "Detail") && ($this->request->getAction() == "archival"))) ? " active" : ""; ?>'>
										<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print (($this->request->getAction() == "oralhistory") ) ? ' current-menu-item' : ''; ?>'><?php print caNavLink($this->request, _t("Oral History"), "", "", "Listing", "oralhistory"); ?></li>					
										<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ( (($this->request->getController() == "Detail") && ($this->request->getAction() == "archival")) | ($this->request->getController() == "Collections") | ($this->request->getAction() == "collections")) ? ' current-menu-item' : ''; ?>'><?php print caNavLink($this->request, _t("Special Collections"), "", "", "Collections", "index"); ?></li>					
									</ul>
								</li>
							</ul>
						</li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-15458"><a href="https://stormking.org/learning/">Programs</a>
							<ul class="sub-menu">
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/education-2/public-programs/">Public Programs</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/education-2/family-programs/">Children &amp; Families</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/education-2/students-teachers/">Schools &amp; Teachers</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/education-2/artist-residency/">Artist Residency</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/education-2/digital-highlights/">Digital Highlights</a></li>
							</ul>
						</li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-20416"><a href="https://stormking.org/support/">Join</a>
							<ul class="sub-menu">
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/donate/">Donate – Annual Fund</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/membership/">Membership</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/council/">Council Membership</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/gala/">Gala</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/corporatemembership/">Corporate Support</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/support/donors/">Donor List</a></li>
							</ul>
						</li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-20797"><a href="https://stormking.org/about/">About</a>
							<ul class="sub-menu">
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/about/mission/">Mission &amp; Values</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/about/leadership/">Leadership</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://stormking.org/capitalproject/">Capital Project</a></li>
							</ul>
						</li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-14503"><a href="https://stormking.org/calendar/">Calendar</a></li>
						<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-12"><a href="http://shop.stormkingst.wpengine.com/">Shop</a></li>
					</ul>
				</nav>
					<div class="search">
						<form role="search" method="get" class="search-form" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" autocomplete="off">
							<span class="icon">
								<svg version="1.2" baseProfile="tiny" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 20 20">
								  <path fill="none" d="M7.7 2.7c-1.3 0-2.6.5-3.5 1.5-1 .9-1.5 2.2-1.5 3.5 0 1.3.5 2.6 1.5 3.5 2 1.9 5.1 1.9 7.1 0 .9-.9 1.5-2.2 1.5-3.5 0-1.3-.5-2.6-1.5-3.5-1-1-2.3-1.5-3.6-1.5z"></path>
								  <path d="M7.7 0c-2.1 0-4 .8-5.5 2.3C.8 3.7 0 5.7 0 7.7c0 2.1.8 4 2.3 5.5 3 3 7.9 3 10.9 0 1.5-1.5 2.3-3.4 2.2-5.5 0-2.1-.8-4-2.3-5.5C11.7.8 9.8 0 7.7 0zm3.6 11.3c-1.9 2-5.1 2-7.1 0-.9-.9-1.5-2.2-1.5-3.5 0-1.3.5-2.6 1.5-3.5.9-.9 2.2-1.5 3.5-1.5 1.3 0 2.6.5 3.5 1.5.9.9 1.5 2.2 1.5 3.5 0 1.2-.5 2.5-1.4 3.5z"></path>
								  <path d="M11.333 13.54l2.263-2.263 6.435 6.435-2.26 2.263z"></path>
								</svg>
							</span>
							<input class="search-field" placeholder="Search…" value="" name="s" type="search">
							<button type="submit" class="search-submit">
								<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 477.175 477.175">
									<path fill="#000" d="M360.7 229L135.7 4c-5.4-5.3-14-5.3-19.2 0s-5.3 13.8 0 19L332 238.7 116.5 454c-5.3 5.4-5.3 14 0 19.2 2.6 2.6 6 4 9.5 4 3.4 0 7-1.3 9.5-4l225-225c5.4-5.3 5.4-14 .2-19z"></path>
								</svg>
							</button>
						</form>
					</div>

					<nav class="secondary-menu">
						<ul id="menu-secondary-menu-1" class="menu"><li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-20534"><a href="https://stormking.org/press/">Press</a></li>
							<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-15356"><a href="https://lp.constantcontactpages.com/su/1eyaAGn">Subscribe</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-348"><a href="https://stormking.org/jobs/">Careers</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-20535"><a href="https://stormking.org/contact/">Contact</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-345"><a href="https://stormking.org/termsprivacycredits/">Terms &amp; Privacy Policy</a></li>
							<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-20504"><a href="https://stormkingst.wpengine.com">©<?php print date("Y"); ?> Storm King Art Center</a></li>
						</ul>
					</nav>
					<div class="social">
						<ul>
							<li>
								<a class="instagram" href="https://www.instagram.com/stormkingartcenter/" target="_blank">
									<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 18 18">
									  <path d="M91.871,135.881H79.196v-7.718h0.991a5.521,5.521,0,1,0,10.692,0h0.992v7.718Zm-6.338-9.518a3.181,3.181,0,1,1-3.181,3.181,3.18461,3.18461,0,0,1,3.181-3.181m3.444-3.011a0.75177,0.75177,0,0,1,.752-0.752h1.984a0.75241,0.75241,0,0,1,.752.752v1.984a0.75177,0.75177,0,0,1-.752.752H89.729a0.75113,0.75113,0,0,1-.752-0.752v-1.984ZM76.533,138.544h18v-18h-18v18Z" transform="translate(-76.53295 -120.544)" fill="#231f20"></path>
									</svg>
								</a>
							</li>
							<li>
								<a class="twitter" href="https://twitter.com/stormkingartctr" target="_blank">
									<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 18 18">
									  <path d="M122.744,145.232a3.54841,3.54841,0,0,0,2.987-.187,1.45532,1.45532,0,1,1,1.355,2.576,6.69563,6.69563,0,0,1-3.115.77,5.62356,5.62356,0,0,1-2.598-.591c-2.344-1.251-2.332-3.652-2.305-8.911,0.004-.675.008-1.408,0.007-2.204a1.456,1.456,0,0,1,2.912,0c0,0.801-.004,1.539-0.008,2.219,0,0.084-.001.16-0.001,0.242h4.437a1.4555,1.4555,0,1,1,0,2.911h-4.424c0.047,1.962.219,2.89,0.753,3.175M113.999,151h18V133h-18v18Z" transform="translate(-113.999 -133)" fill="#231f20"></path>
									</svg>
								</a>
							</li>
							<li>
								<a class="facebook" href="https://www.facebook.com/StormKingArtCenter/" target="_blank">
									<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 18 18">
									  <path d="M143.9996,133v18h9.276v-7.058h-1.505v-2.595h1.505v-0.44a5.24083,5.24083,0,0,1,1.414-3.799,4.6451,4.6451,0,0,1,3.15-1.136,7.70461,7.70461,0,0,1,1.853.232l-0.139,2.71a3.85652,3.85652,0,0,0-1.135-.161c-1.158,0-1.645.904-1.645,2.016v0.578h2.27v2.595h-2.246V151h5.202V133h-18Z" transform="translate(-143.9996 -133)" fill="#231f20"></path>
									</svg>
								</a>
							</li>
							<li>
								<a class="email" href="mailto:info@stormkingartcenter.org" target="_blank">
									<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 25.00009 18.0001">
									  <path fill="#231f20" d="M23.2 0H1.8l10.7 10.868L23.2 0M0 1.828V15.89l6.055-7.91L0 1.827"></path>
									  <path fill="#231f20" d="M12.5 14.525l-4.63-4.7L1.615 18h21.77L17.13 9.823l-4.63 4.702m6.445-6.547L25 15.89V1.828l-6.055 6.15"></path>
									</svg>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</header>
    	<!-- end mobile header -->
	
	<div class="content-wrapper">
      	<div class="content" >
	
			<div class="container noLeftPadding"><div class="row"><div class="col-xs-12">
				<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
