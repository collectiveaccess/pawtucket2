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
			<div class="sidebar hidden-sm hidden-xs">
				<div class='logo'>
					<a href='http://www.stormking.org'>
						<svg version="1.2" baseProfile="tiny" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 37.5">
						  <path fill="none" d="M37.8 4.7c-1.7 0-2.3 1.4-2.3 3.8s.6 3.7 2.3 3.7S40 10.8 40 8.5c0-2.4-.5-3.8-2.2-3.8zm-12.5 21v2.6H27c.8 0 1.4-.4 1.4-1.4 0-.8-.5-1.3-1.3-1.3h-1.8zM9.8 28.5c-.5-1.8-.8-3.2-.8-3.2h-.1s-.2 1.4-.7 3.2l-.6 2.2h2.8l-.6-2.2zM55.3 5.1h-1.7v2.6h1.7c.8 0 1.4-.4 1.4-1.4-.1-.7-.6-1.2-1.4-1.2zm86.2 20.6h-1.7v2.6h1.7c.8 0 1.4-.4 1.4-1.4-.1-.7-.6-1.2-1.4-1.2z"></path>
						  <path d="M86.4 37.2H92v-4.1c0-2.1-.1-3.3-.1-3.3h.1s.7 1.2 1.8 2.6l3.5 4.8h4.7V20.9h-5.7v4.6c0 1.5.1 2.9.1 2.9h-.1s-.6-1.1-1.7-2.6L91.3 21h-5v16.2zM35.2 25.8h4v11.4h5.6V25.8h4.1v-4.9H35.2m68.7 4.9h4v11.4h5.7V25.8h4.1v-4.9h-13.8m-84.2 0v16.3h5.5v-4.6h1c.8 0 1.2.3 1.4 1.3l.3 1.3c.2 1 .4 1.5.9 2H35c-.5-.6-.8-1.2-1-2.2l-.6-2.2c-.4-1.5-1.1-2.2-2.6-2.4v-.1c2-.3 3.3-1.5 3.3-4.2 0-3.9-2.8-5.2-6.5-5.2h-7.9zm8.6 6.1c0 1-.6 1.4-1.4 1.4h-1.7v-2.6H27c.8-.1 1.3.4 1.3 1.2zm103.5-1.4v-4.7h-12.2v16.3h12.3v-4.7H125v-1.4h6V27h-6v-1.4M5.6 37.2l.7-2.2h5.4l.7 2.2h5.9l-5.4-16.3H5.3L0 37.2h5.6zm2.5-8.7c.5-1.8.7-3.2.7-3.2H9s.3 1.4.8 3.2l.6 2.2H7.6l.5-2.2zm140.5-2.3c0-3.9-2.8-5.2-6.5-5.2h-7.9v16.3h5.5v-4.6h1c.8 0 1.2.3 1.4 1.3l.3 1.3c.2 1 .4 1.5.9 2h6.2c-.6-.6-.8-1.2-1.1-2.1l-.6-2.2c-.4-1.5-1.1-2.2-2.6-2.4v-.1c2.1-.5 3.4-1.6 3.4-4.3zm-7.2 2.1h-1.7v-2.6h1.7c.8 0 1.3.5 1.3 1.3.1 1-.4 1.3-1.3 1.3zm-86.8.8c0 5.4 3.3 8.4 8.1 8.4 4 0 6.4-1.4 7.6-4.4L65 30.6c-.2 1.5-.8 2.2-2.2 2.2-1.7 0-2.3-1.5-2.3-3.6 0-2.9 1-3.8 2.4-3.8 1.2 0 1.8.9 2 2l5.4-2.2c-.8-2.8-3.6-4.5-7.3-4.5-5.5-.1-8.4 3-8.4 8.4zm29.3-3.5v-4.7H71.7v16.3H84v-4.7h-6.9v-1.4h6.1V27h-6.1v-1.4M107.7.3h5.7v16.3h-5.7zM37.8 0c-5.2 0-8.2 3-8.2 8.5s3 8.4 8.2 8.4c5.2 0 8.2-3 8.2-8.4C45.9 3 42.9 0 37.8 0zm0 12.2c-1.7 0-2.3-1.4-2.3-3.7 0-2.4.6-3.8 2.3-3.8S40 6.1 40 8.5c0 2.3-.5 3.7-2.2 3.7zM90.3.3v16.3h5.6v-5.9h.8l3.1 5.9h6.6l-4.8-8.4L106 .3h-6.3L96.8 6h-.9V.3m28.5 4.8L121.1.3h-5v16.3h5.7v-4.1c0-2.1-.1-3.3-.1-3.3h.1s.7 1.2 1.8 2.6l3.5 4.8h4.7V.3h-5.7v4.6c0 1.5.1 2.9.1 2.9h-.1s-.6-1.1-1.7-2.7zm-109.2.1h3.9v11.4h5.7V5.2h4.1V.3H15.2M142.4 11h1.9v.1c0 .7-.7 1.3-2 1.3-1.9 0-2.6-1.3-2.6-3.8 0-2.9 1-3.8 2.4-3.8 1.2 0 1.8.9 2 2l5.4-2.2c-.7-2.9-3.5-4.6-7.2-4.6-5.5 0-8.4 3.1-8.4 8.5 0 5.9 3.3 8.4 7.3 8.4 2.3 0 3.8-.7 4.5-2.1l.6 1.8h3.8V7.5h-7.6V11zM75.2 3.9c-.9 1.9-1.2 3-1.2 3h-.1s-.3-1.1-1.2-3L71 .4h-6.2v16.3h5.7v-4.5c0-1.5-.1-2.9-.1-2.9h.1s.5 1.5 1 2.4l.9 2h3l.9-2c.5-1 1-2.4 1-2.4h.1s-.1 1.4-.1 2.9v4.5H83V.3h-6.2l-1.6 3.6zM7 12.6c-.9 0-1.5-.4-1.8-1.4L0 13.1C.7 15.8 3.4 17 6.8 17c4.1 0 7.4-1.4 7.4-5.3 0-3.3-2-5.2-6.2-5.7-1.3-.2-1.8-.4-1.8-1 0-.4.4-.7 1-.7.7 0 1.3.3 1.5 1.2l5.4-1.2C13.4 1.2 11 0 7.4 0 3.7 0 .5 1.4.5 5.6c0 3 1.6 4.7 6.4 5.4.9.1 1.2.4 1.2.8 0 .6-.3.8-1.1.8zm55.4-7c0-3.9-2.8-5.2-6.5-5.2H48v16.3h5.5V12h1c.8 0 1.2.3 1.4 1.3l.3 1.3c.2 1 .4 1.5.9 2h6.2c-.6-.6-.8-1.2-1.1-2.1l-.6-2.2c-.4-1.5-1.1-2.2-2.6-2.4v-.1c2.1-.3 3.4-1.5 3.4-4.2zm-7.2 2.2h-1.7V5.1h1.7c.8 0 1.3.5 1.3 1.3.1 1-.5 1.4-1.3 1.4z"></path>
						</svg>
					</a>			
                </div>	
				<div class="main-menu">
					<ul class="nav menuItems">
						<li><a href='http://stormking.org/about/'>About</a></li>
						<li><a href='http://stormking.org/visit/'>Visit</a></li>
					
						<li>
							<?php print caNavLink($this->request, _t("Collection"), "", "", "About", "collection"); ?>
<?php
						if ((($this->request->getController() == "Browse") && ($this->request->getAction() != "exhibitions")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "objects")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "entities")) | (($this->request->getController() == "About") && ($this->request->getAction() == "collection"))) {
?>								
							<ul class='subMenu'>
								<li style="padding-top:6px;" <?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "objects")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "objects"))) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Art"), "", "", "Browse", "objects"); ?></li>					
								<li <?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "entities")) || (($this->request->getController() == "Detail") && ($this->request->getAction() == "entities"))) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Artists"), "", "", "Browse", "entities"); ?></li>					
								<!--<li><a href="https://stormking.org/sarah-sze/">Commissions</a></li>-->
							</ul>												
<?php						
						} 
?>							
						</li>					
						<li>
<?php 
							#print caNavLink($this->request, _t("Exhibitions"), "", "", "Listing", "exhibitions", array("sort" => "default", "direction" => "desc"));
							print caNavLink($this->request, _t("Exhibitions"), "", "", "About", "exhibitions");

							if (((strtolower($this->request->getController()) == "about") && ($this->request->getAction() == "exhibitions")) | ((strtolower($this->request->getController()) == "browse") && ($this->request->getAction() == "exhibitions")) | ((strtolower($this->request->getController()) == "listing") && ($this->request->getAction() == "currentexhibitions"))  | ((strtolower($this->request->getController()) == "listing") && ($this->request->getAction() == "exhibitions")) | ((strtolower($this->request->getController()) == "detail") && ($this->request->getAction() == "occurrences"))) {
?>							
								<ul class='subMenu'>
									<li style="padding-top:6px;" <?php print ((($this->request->getAction() == "currentexhibitions") ) ? 'class="active"' : ''); ?>><?php print caNavLink($this->request, _t("Current & Upcoming"), "", "", "Listing", "currentexhibitions", array("sort" => "default", "direction" => "desc")); ?></li>					
									<li <?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "exhibitions")) ? 'class="active"' : ''); ?>><?php print caNavLink($this->request, _t("Past"), "", "", "Browse", "exhibitions"); ?></li>					
								</ul>
<?php
							}
?>							
						
						</li>
						<li><a href='http://stormking.org/education-2/'>Education</a></li>
						<li>
							<?php print caNavLink($this->request, _t("Archives"), "", "", "About", "archives"); ?> 
<?php
							if (($this->request->getController() == "Gallery") | ($this->request->getController() == "Collections") | (($this->request->getController() == "Listing") && ($this->request->getAction() == "oralhistory")) | (($this->request->getController() == "About") && ($this->request->getAction() == "archives")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "collections")) | ($this->request->getAction() == "oralhistory") | (($this->request->getController() == "Detail") && ($this->request->getAction() == "archival"))) {
?>							
								<ul class='subMenu'>
									<li style="padding-top:6px;" <?php print (($this->request->getController() == "Listing")| ($this->request->getAction() == "oralhistory") ) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Oral History"), "", "", "Listing", "oralhistory"); ?></li>					
									<!--<li <?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Search"), "", "", "Search", "advanced/objects"); ?></li>-->
									<li <?php print ( (($this->request->getController() == "Detail") && ($this->request->getAction() == "archival")) | ($this->request->getController() == "Collections") | ($this->request->getAction() == "collections")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Special Collections"), "", "", "Collections", "index"); ?></li>					
									<!--<li <?php print (strToLower($this->request->getController()) == "gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Featured"), "", "", "Gallery", "index"); ?></li>-->				
								</ul>
<?php
							}
?>							
						</li>
						<li><a href='http://stormking.org/support/'>Support</a></li>
						<li><a href='http://stormking.org/calendar/'>Calendar</a></li>
						<li><a href='http://shop.stormking.org/'>Shop</a></li>
					</ul>
				</div>
				<form class="navbar-form " role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>"> 
					<div class="formOutline">
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search..." name="search">
						</div>						
					</div>
				</form>
				<div class="copyright">©2018 Storm King Art Center</div>
				<nav class="secondary-menu"><ul id="menu-secondary-menu" class="menu"><li id="menu-item-345" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-345"><a href="http://stormking.org/termsprivacycredits/">Terms/Privacy/Credits</a></li>
					<li id="menu-item-348" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-348"><a href="http://stormking.org/job-opportunities/">Job Opportunities</a></li>
					<li id="menu-item-15356" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-15356"><a href="https://visitor.r20.constantcontact.com/d.jsp?llr=zkiggxcab&amp;p=oi&amp;m=1102437359961&amp;sit=o5slr77db&amp;f=08547c94-ef10-4ab8-a2c7-141650bcbd20">Join Mailing List</a></li>
				</ul></nav>	
				<div class="social">
					<ul>
						<li>
							<a class="instagram" href="https://www.instagram.com/stormkingartcenter/" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
								  <path d="M91.871,135.881H79.196v-7.718h0.991a5.521,5.521,0,1,0,10.692,0h0.992v7.718Zm-6.338-9.518a3.181,3.181,0,1,1-3.181,3.181,3.18461,3.18461,0,0,1,3.181-3.181m3.444-3.011a0.75177,0.75177,0,0,1,.752-0.752h1.984a0.75241,0.75241,0,0,1,.752.752v1.984a0.75177,0.75177,0,0,1-.752.752H89.729a0.75113,0.75113,0,0,1-.752-0.752v-1.984ZM76.533,138.544h18v-18h-18v18Z" transform="translate(-76.53295 -120.544)" fill="#231f20"></path>
								</svg>
							</a>
						</li>
						<li>
							<a class="twitter" href="https://twitter.com/stormkingartctr" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
								  <path d="M122.744,145.232a3.54841,3.54841,0,0,0,2.987-.187,1.45532,1.45532,0,1,1,1.355,2.576,6.69563,6.69563,0,0,1-3.115.77,5.62356,5.62356,0,0,1-2.598-.591c-2.344-1.251-2.332-3.652-2.305-8.911,0.004-.675.008-1.408,0.007-2.204a1.456,1.456,0,0,1,2.912,0c0,0.801-.004,1.539-0.008,2.219,0,0.084-.001.16-0.001,0.242h4.437a1.4555,1.4555,0,1,1,0,2.911h-4.424c0.047,1.962.219,2.89,0.753,3.175M113.999,151h18V133h-18v18Z" transform="translate(-113.999 -133)" fill="#231f20"></path>
								</svg>
							</a>
						</li>
						<li>
							<a class="facebook" href="https://www.facebook.com/StormKingArtCenter/" target="_blank">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
								  <path d="M143.9996,133v18h9.276v-7.058h-1.505v-2.595h1.505v-0.44a5.24083,5.24083,0,0,1,1.414-3.799,4.6451,4.6451,0,0,1,3.15-1.136,7.70461,7.70461,0,0,1,1.853.232l-0.139,2.71a3.85652,3.85652,0,0,0-1.135-.161c-1.158,0-1.645.904-1.645,2.016v0.578h2.27v2.595h-2.246V151h5.202V133h-18Z" transform="translate(-143.9996 -133)" fill="#231f20"></path>
								</svg>
							</a>
						</li>
						<li>
							<a class="email" href="mailto:info@stormkingartcenter.org" target="_blank">
								<svg style="width:28px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25.00009 18.0001">
								  <path fill="#231f20" d="M23.2 0H1.8l10.7 10.868L23.2 0M0 1.828V15.89l6.055-7.91L0 1.827"></path>
								  <path fill="#231f20" d="M12.5 14.525l-4.63-4.7L1.615 18h21.77L17.13 9.823l-4.63 4.702m6.445-6.547L25 15.89V1.828l-6.055 6.15"></path>
								</svg>
							</a>
						</li>
					</ul>
				</div>							
			</div>	









		<!-- mobile header -->
		<header id="header-mobile" class="hidden-lg hidden-md <?php print ($this->request->getController() == "About") ? "header-white" : ""; ?>">
			<div class="top">
				<div class="container">

					<div id="header-mobile-content-trigger">
						<svg version="1.2" baseProfile="tiny" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28.9 23">
						  <path d="M0 0h28.9v5.4H0zm0 8.8h28.9v5.4H0zm0 8.7h28.9v5.4H0z"></path>
						</svg>
					</div>

					<a class="logo" href="http://stormking.org">
						<svg version="1.2" baseProfile="tiny" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 150 37.5">
						  <path fill="none" d="M37.8 4.7c-1.7 0-2.3 1.4-2.3 3.8s.6 3.7 2.3 3.7S40 10.8 40 8.5c0-2.4-.5-3.8-2.2-3.8zm-12.5 21v2.6H27c.8 0 1.4-.4 1.4-1.4 0-.8-.5-1.3-1.3-1.3h-1.8zM9.8 28.5c-.5-1.8-.8-3.2-.8-3.2h-.1s-.2 1.4-.7 3.2l-.6 2.2h2.8l-.6-2.2zM55.3 5.1h-1.7v2.6h1.7c.8 0 1.4-.4 1.4-1.4-.1-.7-.6-1.2-1.4-1.2zm86.2 20.6h-1.7v2.6h1.7c.8 0 1.4-.4 1.4-1.4-.1-.7-.6-1.2-1.4-1.2z"></path>
						  <path class="fill-me" d="M86.4 37.2H92v-4.1c0-2.1-.1-3.3-.1-3.3h.1s.7 1.2 1.8 2.6l3.5 4.8h4.7V20.9h-5.7v4.6c0 1.5.1 2.9.1 2.9h-.1s-.6-1.1-1.7-2.6L91.3 21h-5v16.2zM35.2 25.8h4v11.4h5.6V25.8h4.1v-4.9H35.2m68.7 4.9h4v11.4h5.7V25.8h4.1v-4.9h-13.8m-84.2 0v16.3h5.5v-4.6h1c.8 0 1.2.3 1.4 1.3l.3 1.3c.2 1 .4 1.5.9 2H35c-.5-.6-.8-1.2-1-2.2l-.6-2.2c-.4-1.5-1.1-2.2-2.6-2.4v-.1c2-.3 3.3-1.5 3.3-4.2 0-3.9-2.8-5.2-6.5-5.2h-7.9zm8.6 6.1c0 1-.6 1.4-1.4 1.4h-1.7v-2.6H27c.8-.1 1.3.4 1.3 1.2zm103.5-1.4v-4.7h-12.2v16.3h12.3v-4.7H125v-1.4h6V27h-6v-1.4M5.6 37.2l.7-2.2h5.4l.7 2.2h5.9l-5.4-16.3H5.3L0 37.2h5.6zm2.5-8.7c.5-1.8.7-3.2.7-3.2H9s.3 1.4.8 3.2l.6 2.2H7.6l.5-2.2zm140.5-2.3c0-3.9-2.8-5.2-6.5-5.2h-7.9v16.3h5.5v-4.6h1c.8 0 1.2.3 1.4 1.3l.3 1.3c.2 1 .4 1.5.9 2h6.2c-.6-.6-.8-1.2-1.1-2.1l-.6-2.2c-.4-1.5-1.1-2.2-2.6-2.4v-.1c2.1-.5 3.4-1.6 3.4-4.3zm-7.2 2.1h-1.7v-2.6h1.7c.8 0 1.3.5 1.3 1.3.1 1-.4 1.3-1.3 1.3zm-86.8.8c0 5.4 3.3 8.4 8.1 8.4 4 0 6.4-1.4 7.6-4.4L65 30.6c-.2 1.5-.8 2.2-2.2 2.2-1.7 0-2.3-1.5-2.3-3.6 0-2.9 1-3.8 2.4-3.8 1.2 0 1.8.9 2 2l5.4-2.2c-.8-2.8-3.6-4.5-7.3-4.5-5.5-.1-8.4 3-8.4 8.4zm29.3-3.5v-4.7H71.7v16.3H84v-4.7h-6.9v-1.4h6.1V27h-6.1v-1.4M107.7.3h5.7v16.3h-5.7zM37.8 0c-5.2 0-8.2 3-8.2 8.5s3 8.4 8.2 8.4c5.2 0 8.2-3 8.2-8.4C45.9 3 42.9 0 37.8 0zm0 12.2c-1.7 0-2.3-1.4-2.3-3.7 0-2.4.6-3.8 2.3-3.8S40 6.1 40 8.5c0 2.3-.5 3.7-2.2 3.7zM90.3.3v16.3h5.6v-5.9h.8l3.1 5.9h6.6l-4.8-8.4L106 .3h-6.3L96.8 6h-.9V.3m28.5 4.8L121.1.3h-5v16.3h5.7v-4.1c0-2.1-.1-3.3-.1-3.3h.1s.7 1.2 1.8 2.6l3.5 4.8h4.7V.3h-5.7v4.6c0 1.5.1 2.9.1 2.9h-.1s-.6-1.1-1.7-2.7zm-109.2.1h3.9v11.4h5.7V5.2h4.1V.3H15.2M142.4 11h1.9v.1c0 .7-.7 1.3-2 1.3-1.9 0-2.6-1.3-2.6-3.8 0-2.9 1-3.8 2.4-3.8 1.2 0 1.8.9 2 2l5.4-2.2c-.7-2.9-3.5-4.6-7.2-4.6-5.5 0-8.4 3.1-8.4 8.5 0 5.9 3.3 8.4 7.3 8.4 2.3 0 3.8-.7 4.5-2.1l.6 1.8h3.8V7.5h-7.6V11zM75.2 3.9c-.9 1.9-1.2 3-1.2 3h-.1s-.3-1.1-1.2-3L71 .4h-6.2v16.3h5.7v-4.5c0-1.5-.1-2.9-.1-2.9h.1s.5 1.5 1 2.4l.9 2h3l.9-2c.5-1 1-2.4 1-2.4h.1s-.1 1.4-.1 2.9v4.5H83V.3h-6.2l-1.6 3.6zM7 12.6c-.9 0-1.5-.4-1.8-1.4L0 13.1C.7 15.8 3.4 17 6.8 17c4.1 0 7.4-1.4 7.4-5.3 0-3.3-2-5.2-6.2-5.7-1.3-.2-1.8-.4-1.8-1 0-.4.4-.7 1-.7.7 0 1.3.3 1.5 1.2l5.4-1.2C13.4 1.2 11 0 7.4 0 3.7 0 .5 1.4.5 5.6c0 3 1.6 4.7 6.4 5.4.9.1 1.2.4 1.2.8 0 .6-.3.8-1.1.8zm55.4-7c0-3.9-2.8-5.2-6.5-5.2H48v16.3h5.5V12h1c.8 0 1.2.3 1.4 1.3l.3 1.3c.2 1 .4 1.5.9 2h6.2c-.6-.6-.8-1.2-1.1-2.1l-.6-2.2c-.4-1.5-1.1-2.2-2.6-2.4v-.1c2.1-.3 3.4-1.5 3.4-4.2zm-7.2 2.2h-1.7V5.1h1.7c.8 0 1.3.5 1.3 1.3.1 1-.5 1.4-1.3 1.4z"></path>
						</svg>
					</a>

				</div>
			</div>
			<div id="header-mobile-content">
				<div class="container">
					<nav class="main-menu"><ul id="menu-main-menu-1" class="menu">
						<li class="menu-item menu-item-type-post_type menu-item-object-page page_item page-item-30 current_page_item menu-item-has-children menu-item-32"><a href="http://stormking.org/about/">About</a>
							<ul class="sub-menu">
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-59"><a href="http://stormking.org/about/history/">History</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16643"><a href="http://stormking.org/town-of-cornwall/">Town of Cornwall</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-64"><a href="http://stormking.org/about/landscape/">Landscape</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-72"><a href="http://stormking.org/about/press/">Press</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-105"><a href="http://stormking.org/about/leadership/">Leadership</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15419"><a href="http://stormking.org/about/donors/">Donors</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-113"><a href="http://stormking.org/about/contact/">Contact</a></li>
							</ul>
						</li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-130"><a href="http://stormking.org/visit/">Visit</a>
							<ul class="sub-menu">
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-156"><a href="http://stormking.org/visit/plan-your-visit/">Plan your visit</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17310"><a href="http://stormking.org/visit/groups/">Groups</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16572"><a href="http://stormking.org/visit/food/">Food</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-186"><a href="http://stormking.org/visit/bikes/">Bikes</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-189"><a href="http://stormking.org/visit/local-amenities/">Local Amenities</a></li>
							</ul>
						</li>


						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children">
							<?php print caNavLink($this->request, _t("Collection"), "", "", "About", "collection"); ?>
							<ul class='sub-menu <?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() != "exhibitions")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "objects")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "entities")) | (($this->request->getController() == "About") && ($this->request->getAction() == "collection"))) ? ' active' : ''; ?>'>
								<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "objects")) || (($this->request->getController() == "Detail") && ($this->request->getAction() == "objects"))) ? ' current-menu-item' : ''; ?>'><?php print caNavLink($this->request, _t("Art"), "", "", "Browse", "objects"); ?></li>					
								<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "entities")) || (($this->request->getController() == "Detail") && ($this->request->getAction() == "entities"))) ? ' current-menu-item' : ''; ?>'><?php print caNavLink($this->request, _t("Artists"), "", "", "Browse", "entities"); ?></li>					
							</ul>												
						</li>					
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children">
							<?php print caNavLink($this->request, _t("Exhibitions"), "", "", "Listing", "exhibitions", array("sort" => "default", "direction" => "desc")); ?>
							<ul class='sub-menu <?php print (((($this->request->getController() == "Browse") && ($this->request->getAction() == "exhibitions")) | (($this->request->getController() == "Listing") && ($this->request->getAction() == "currentexhibitions"))  | (($this->request->getController() == "Listing") && ($this->request->getAction() == "exhibitions")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "occurrences"))) ? ' active' : ''); ?>'>
								<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ((($this->request->getAction() == "currentexhibitions") ) ? ' current-menu-item' : ''); ?>'><?php print caNavLink($this->request, _t("Current & Upcoming"), "", "", "Listing", "currentexhibitions", array("sort" => "default", "direction" => "desc")); ?></li>					
								<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "exhibitions")) ? ' current-menu-item' : ''); ?>'><?php print caNavLink($this->request, _t("Past"), "", "", "Browse", "exhibitions"); ?></li>					
							</ul>
						</li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-15458"><a href="http://stormking.org/education-2/">Education</a>
							<ul class="sub-menu">
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15447"><a href="http://stormking.org/education-2/public-programs/">Public Programs</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15448"><a href="http://stormking.org/education-2/family-programs/">Children and Families Programs</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16252"><a href="http://stormking.org/education-2/students-teachers/">Schools &amp; Teachers</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-241"><a href="http://stormking.org/education-2/summercamp/">Summer Camps</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-252"><a href="http://stormking.org/education-2/artist-residency/">Artist Residency</a></li>
							</ul>
						</li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children">
							<?php print caNavLink($this->request, _t("Archives"), "", "", "About", "archives"); ?> 
							<ul class='sub-menu<?php print (($this->request->getController() == "Collections") | (($this->request->getController() == "Listing") && ($this->request->getAction() == "oralhistory")) | (($this->request->getController() == "About") && ($this->request->getAction() == "archives")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "collections")) | ($this->request->getAction() == "oralhistory") | (($this->request->getController() == "Detail") && ($this->request->getAction() == "archival"))) ? " active" : ""; ?>'>
								<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print (($this->request->getController() == "Listing")| ($this->request->getAction() == "oralhistory") ) ? ' current-menu-item' : ''; ?>'><?php print caNavLink($this->request, _t("Oral History"), "", "", "Listing", "oralhistory"); ?></li>					
								<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ( (($this->request->getController() == "Detail") && ($this->request->getAction() == "archival")) | ($this->request->getController() == "Collections") | ($this->request->getAction() == "collections")) ? ' current-menu-item' : ''; ?>'><?php print caNavLink($this->request, _t("Special Collections"), "", "", "Collections", "index"); ?></li>					
								<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print (strToLower($this->request->getController()) == "gallery") ? ' current-menu-item' : ''; ?>'><?php print caNavLink($this->request, _t("Featured"), "", "", "Gallery", "index"); ?></li>					
							</ul>
						</li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-264"><a href="http://stormking.org/support/">Support</a>
							<ul class="sub-menu">
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16799"><a href="http://stormking.org/support/annualfund/">Annual Fund</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-269"><a href="http://stormking.org/support/membership/">Membership</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16595"><a href="http://stormking.org/support/council/">Council</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-328"><a href="http://stormking.org/support/gala2017/">Annual Gala</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-322"><a href="http://stormking.org/support/summer-solstice/">Summer Solstice</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-14645"><a href="http://stormking.org/support/project-support/">Project Support</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-290"><a href="http://stormking.org/support/corporate-support/">Corporate Support</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15233"><a href="http://stormking.org/support/planned-giving/">Planned Giving</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-314"><a href="http://stormking.org/support/host-an-event/">Host an Event</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-285"><a href="http://stormking.org/support/donate/">Donate</a></li>
							</ul>
						</li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-14503"><a href="http://stormking.org/calendar/">Calendar</a></li>
						<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-12"><a target="_blank" href="http://shop.stormking.org/">Shop</a></li>
					</ul>
				</nav>
					<div class="search">
						<form role="search" method="get" class="search-form" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" autocomplete="off">
							<span class="icon">
								<svg version="1.2" baseProfile="tiny" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
								  <path fill="none" d="M7.7 2.7c-1.3 0-2.6.5-3.5 1.5-1 .9-1.5 2.2-1.5 3.5 0 1.3.5 2.6 1.5 3.5 2 1.9 5.1 1.9 7.1 0 .9-.9 1.5-2.2 1.5-3.5 0-1.3-.5-2.6-1.5-3.5-1-1-2.3-1.5-3.6-1.5z"></path>
								  <path d="M7.7 0c-2.1 0-4 .8-5.5 2.3C.8 3.7 0 5.7 0 7.7c0 2.1.8 4 2.3 5.5 3 3 7.9 3 10.9 0 1.5-1.5 2.3-3.4 2.2-5.5 0-2.1-.8-4-2.3-5.5C11.7.8 9.8 0 7.7 0zm3.6 11.3c-1.9 2-5.1 2-7.1 0-.9-.9-1.5-2.2-1.5-3.5 0-1.3.5-2.6 1.5-3.5.9-.9 2.2-1.5 3.5-1.5 1.3 0 2.6.5 3.5 1.5.9.9 1.5 2.2 1.5 3.5 0 1.2-.5 2.5-1.4 3.5z"></path>
								  <path d="M11.333 13.54l2.263-2.263 6.435 6.435-2.26 2.263z"></path>
								</svg>
							</span>
							<input class="search-field" placeholder="Search…" value="" name="s" type="search">
							<button type="submit" class="search-submit">
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 477.175 477.175">
									<path fill="#000" d="M360.7 229L135.7 4c-5.4-5.3-14-5.3-19.2 0s-5.3 13.8 0 19L332 238.7 116.5 454c-5.3 5.4-5.3 14 0 19.2 2.6 2.6 6 4 9.5 4 3.4 0 7-1.3 9.5-4l225-225c5.4-5.3 5.4-14 .2-19z"></path>
								</svg>
							</button>
						</form>
					</div>

					<div class="copyright">©2018 Storm King Art Center</div>
				

					<nav class="secondary-menu">
						<ul id="menu-secondary-menu-1" class="menu"><li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-345"><a href="http://stormking.org/termsprivacycredits/">Terms/Privacy/Credits</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-348"><a href="http://stormking.org/job-opportunities/">Job Opportunities</a></li>
							<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-15356"><a href="https://visitor.r20.constantcontact.com/d.jsp?llr=zkiggxcab&amp;p=oi&amp;m=1102437359961&amp;sit=o5slr77db&amp;f=08547c94-ef10-4ab8-a2c7-141650bcbd20">Join Mailing List</a></li>
						</ul>
					</nav>
					<div class="social">
						<ul>
							<li>
								<a class="instagram" href="https://www.instagram.com/stormkingartcenter/" target="_blank">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
									  <path d="M91.871,135.881H79.196v-7.718h0.991a5.521,5.521,0,1,0,10.692,0h0.992v7.718Zm-6.338-9.518a3.181,3.181,0,1,1-3.181,3.181,3.18461,3.18461,0,0,1,3.181-3.181m3.444-3.011a0.75177,0.75177,0,0,1,.752-0.752h1.984a0.75241,0.75241,0,0,1,.752.752v1.984a0.75177,0.75177,0,0,1-.752.752H89.729a0.75113,0.75113,0,0,1-.752-0.752v-1.984ZM76.533,138.544h18v-18h-18v18Z" transform="translate(-76.53295 -120.544)" fill="#231f20"></path>
									</svg>
								</a>
							</li>
							<li>
								<a class="twitter" href="https://twitter.com/stormkingartctr" target="_blank">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
									  <path d="M122.744,145.232a3.54841,3.54841,0,0,0,2.987-.187,1.45532,1.45532,0,1,1,1.355,2.576,6.69563,6.69563,0,0,1-3.115.77,5.62356,5.62356,0,0,1-2.598-.591c-2.344-1.251-2.332-3.652-2.305-8.911,0.004-.675.008-1.408,0.007-2.204a1.456,1.456,0,0,1,2.912,0c0,0.801-.004,1.539-0.008,2.219,0,0.084-.001.16-0.001,0.242h4.437a1.4555,1.4555,0,1,1,0,2.911h-4.424c0.047,1.962.219,2.89,0.753,3.175M113.999,151h18V133h-18v18Z" transform="translate(-113.999 -133)" fill="#231f20"></path>
									</svg>
								</a>
							</li>
							<li>
								<a class="facebook" href="https://www.facebook.com/StormKingArtCenter/" target="_blank">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
									  <path d="M143.9996,133v18h9.276v-7.058h-1.505v-2.595h1.505v-0.44a5.24083,5.24083,0,0,1,1.414-3.799,4.6451,4.6451,0,0,1,3.15-1.136,7.70461,7.70461,0,0,1,1.853.232l-0.139,2.71a3.85652,3.85652,0,0,0-1.135-.161c-1.158,0-1.645.904-1.645,2.016v0.578h2.27v2.595h-2.246V151h5.202V133h-18Z" transform="translate(-143.9996 -133)" fill="#231f20"></path>
									</svg>
								</a>
							</li>
							<li>
								<a class="email" href="mailto:info@stormkingartcenter.org" target="_blank">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25.00009 18.0001">
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
