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
			<div class="sidebar hidden-sm hidden-xs">
				<div class='logo'>
					<a href='https://www.stormking.org'>
						<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 158 34.99"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><rect x="106.55" width="0.97" height="34.99"/><path d="M.34,8.56c0,2,1.07,3.14,4.31,3.65.6.09.84.26.84.55s-.26.51-.76.51a1.25,1.25,0,0,1-1.25-.95L0,13.56c.5,1.83,2.31,2.61,4.58,2.61,2.73,0,5-1,5-3.59,0-2.24-1.35-3.5-4.14-3.84-.9-.11-1.21-.29-1.21-.65s.24-.46.65-.46a.86.86,0,0,1,1,.78l3.67-.82C9.06,5.6,7.39,4.76,5,4.76S.34,5.69.34,8.56Z"/><polygon points="12.86 15.95 16.68 15.95 16.68 8.26 19.43 8.26 19.43 4.99 10.18 4.99 10.18 8.26 12.86 8.26 12.86 15.95"/><path d="M19.86,10.48c0,3.7,2,5.69,5.53,5.69s5.52-2,5.52-5.69-2-5.72-5.52-5.72S19.86,6.75,19.86,10.48ZM25.39,13c-1.16,0-1.55-.91-1.55-2.51s.39-2.54,1.55-2.54,1.54.92,1.54,2.54S26.54,13,25.39,13Z"/><path d="M36,12.88h.69c.54,0,.81.2.94.85l.19.86A2.57,2.57,0,0,0,38.45,16h4.19a2.87,2.87,0,0,1-.74-1.44l-.41-1.45a2,2,0,0,0-1.73-1.62v-.07A2.51,2.51,0,0,0,42,8.52C42,5.9,40.09,5,37.58,5h-5.3V16H36Zm0-4.67h1.15a.8.8,0,0,1,.89.87.82.82,0,0,1-.93.91H36Z"/><path d="M48.67,14h2l.63-1.35C51.67,12,52,11,52,11h.08s-.06.93-.06,1.93v3h3.82V5H51.71L50.57,7.37a16.63,16.63,0,0,0-.84,2h-.07a14.77,14.77,0,0,0-.84-2L47.69,5H43.54V16h3.81v-3c0-1-.05-1.93-.05-1.93h.07s.36,1,.67,1.63Z"/><polygon points="68.48 10.27 71.4 4.99 67.19 4.99 65.22 8.8 64.63 8.8 64.63 4.99 60.81 4.99 60.81 15.95 64.63 15.95 64.63 11.96 65.17 11.96 67.25 15.95 71.68 15.95 68.48 10.27"/><rect x="72.58" y="4.99" width="3.81" height="10.96"/><path d="M82,13.21c0-1.4,0-2.25,0-2.25h.08s.48.78,1.19,1.77L85.6,16h3.17V5H85V8.06c0,1,0,1.93,0,1.93h-.08s-.42-.74-1.15-1.78L81.57,5H78.22V16H82Z"/><path d="M90.13,10.51c0,4,2.21,5.66,4.91,5.66,1.55,0,2.55-.5,3-1.43L98.45,16H101V9.79H95.86v2.38h1.3v.09c0,.49-.44.86-1.34.86-1.28,0-1.73-.9-1.73-2.59,0-1.93.67-2.57,1.64-2.57s1.23.6,1.32,1.34l3.65-1.5c-.54-1.87-2.42-3-4.91-3C92.06,4.76,90.13,6.85,90.13,10.51Z"/><path d="M3.59,19,0,30H3.8l.44-1.49H7.85L8.34,30h3.94L8.67,19ZM5.1,25.67l.39-1.51C5.81,23,6,22,6,22h.08s.22.95.54,2.14L7,25.67Z"/><path d="M23,22.58C23,20,21.07,19,18.56,19H13.25V30H17V26.93h.69c.54,0,.82.21.95.86l.19.85A2.53,2.53,0,0,0,19.43,30h4.19a3,3,0,0,1-.75-1.43l-.41-1.45a1.92,1.92,0,0,0-1.73-1.62v-.08A2.51,2.51,0,0,0,23,22.58Zm-4.84,1.47H17V22.26h1.16a.81.81,0,0,1,.89.87A.82.82,0,0,1,18.11,24.05Z"/><polygon points="23.68 22.32 26.36 22.32 26.36 30 30.17 30 30.17 22.32 32.93 22.32 32.93 19.04 23.68 19.04 23.68 22.32"/><path d="M42.83,22c.84,0,1.23.59,1.32,1.34l3.65-1.51c-.54-1.86-2.42-3-4.92-3-3.72,0-5.65,2.08-5.65,5.75s2.21,5.65,5.45,5.65c2.7,0,4.3-1,5.14-2.95l-3.6-1.72c-.13,1-.53,1.49-1.45,1.49-1.15,0-1.58-1-1.58-2.45C41.19,22.65,41.86,22,42.83,22Z"/><polygon points="57.01 26.88 52.38 26.88 52.38 25.89 56.44 25.89 56.44 23.15 52.38 23.15 52.38 22.17 56.94 22.17 56.94 19.04 48.71 19.04 48.71 30 57.01 30 57.01 26.88"/><path d="M63.6,26.78,66,30h3.16V19H65.3v3.07c0,1,0,1.94,0,1.94h-.07s-.43-.75-1.16-1.79L61.91,19H58.56V30h3.81V27.27c0-1.4,0-2.26,0-2.26h.07S62.9,25.8,63.6,26.78Z"/><polygon points="76.87 30 76.87 22.32 79.63 22.32 79.63 19.04 70.38 19.04 70.38 22.32 73.06 22.32 73.06 30 76.87 30"/><polygon points="89.2 26.88 84.56 26.88 84.56 25.89 88.62 25.89 88.62 23.15 84.56 23.15 84.56 22.17 89.12 22.17 89.12 19.04 80.9 19.04 80.9 30 89.2 30 89.2 26.88"/><path d="M100,27.12a1.93,1.93,0,0,0-1.73-1.62v-.08a2.51,2.51,0,0,0,2.22-2.84c0-2.63-1.88-3.54-4.39-3.54H90.74V30h3.74V26.93h.69c.54,0,.82.21,1,.86l.19.85A2.53,2.53,0,0,0,96.92,30h4.19a3,3,0,0,1-.75-1.43ZM95.6,24.05H94.48V22.26h1.16a.81.81,0,0,1,.89.87A.82.82,0,0,1,95.6,24.05Z"/><path d="M122.72,17.56A3.67,3.67,0,0,0,119,21.24a3.81,3.81,0,1,0,3.74-3.68Zm0,6.56A2.77,2.77,0,0,1,120,21.24a2.71,2.71,0,0,1,2.77-2.71,2.8,2.8,0,1,1,0,5.59Z"/><path d="M151.84,17.53c0-4.28-3.11-7.63-7.08-7.63a7.22,7.22,0,0,0-7,7.53c0,4.37,3.06,7.66,7.13,7.66C148.77,25.09,151.84,21.77,151.84,17.53Zm-7,6.59c-3.57,0-6.16-2.82-6.16-6.69a6.26,6.26,0,0,1,6.06-6.56c3.43,0,6.11,2.92,6.11,6.66S148.29,24.12,144.86,24.12Z"/><path d="M158,17.33a13.2,13.2,0,0,0-26.33-1,7.84,7.84,0,0,0-7-4.2h-.26l5.3-7.21h-8.36l-6.15,9a11.81,11.81,0,0,0-2.3,6.73c0,5.78,4.12,9.81,10,9.81a9.55,9.55,0,0,0,9.64-7.64c2.13,4.85,7.38,7.64,12.5,7.64A12.91,12.91,0,0,0,158,17.33Zm-26.21,3.49a8.6,8.6,0,0,1-8.87,8.71c-5.32,0-9-3.64-9-8.84A10.85,10.85,0,0,1,116,14.51l5.85-8.6h5.93l-5,6.75.46.68.35-.11a3,3,0,0,1,1-.11,7.07,7.07,0,0,1,6.94,6c0,.38.08.76.14,1.13A6.08,6.08,0,0,1,131.79,20.82Zm.94-.73a8.54,8.54,0,0,0-.15-1.16c0-.29-.05-.58-.05-.88,0-7.3,5.15-12.59,12.23-12.59A12.08,12.08,0,0,1,157,17.33a12,12,0,0,1-12,12.2C139.51,29.53,133.81,26,132.73,20.09Z"/></g></g></svg>
						<!--<svg version="1.2" baseProfile="tiny" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 150 37.5">
						  <path fill="none" d="M37.8 4.7c-1.7 0-2.3 1.4-2.3 3.8s.6 3.7 2.3 3.7S40 10.8 40 8.5c0-2.4-.5-3.8-2.2-3.8zm-12.5 21v2.6H27c.8 0 1.4-.4 1.4-1.4 0-.8-.5-1.3-1.3-1.3h-1.8zM9.8 28.5c-.5-1.8-.8-3.2-.8-3.2h-.1s-.2 1.4-.7 3.2l-.6 2.2h2.8l-.6-2.2zM55.3 5.1h-1.7v2.6h1.7c.8 0 1.4-.4 1.4-1.4-.1-.7-.6-1.2-1.4-1.2zm86.2 20.6h-1.7v2.6h1.7c.8 0 1.4-.4 1.4-1.4-.1-.7-.6-1.2-1.4-1.2z"></path>
						  <path d="M86.4 37.2H92v-4.1c0-2.1-.1-3.3-.1-3.3h.1s.7 1.2 1.8 2.6l3.5 4.8h4.7V20.9h-5.7v4.6c0 1.5.1 2.9.1 2.9h-.1s-.6-1.1-1.7-2.6L91.3 21h-5v16.2zM35.2 25.8h4v11.4h5.6V25.8h4.1v-4.9H35.2m68.7 4.9h4v11.4h5.7V25.8h4.1v-4.9h-13.8m-84.2 0v16.3h5.5v-4.6h1c.8 0 1.2.3 1.4 1.3l.3 1.3c.2 1 .4 1.5.9 2H35c-.5-.6-.8-1.2-1-2.2l-.6-2.2c-.4-1.5-1.1-2.2-2.6-2.4v-.1c2-.3 3.3-1.5 3.3-4.2 0-3.9-2.8-5.2-6.5-5.2h-7.9zm8.6 6.1c0 1-.6 1.4-1.4 1.4h-1.7v-2.6H27c.8-.1 1.3.4 1.3 1.2zm103.5-1.4v-4.7h-12.2v16.3h12.3v-4.7H125v-1.4h6V27h-6v-1.4M5.6 37.2l.7-2.2h5.4l.7 2.2h5.9l-5.4-16.3H5.3L0 37.2h5.6zm2.5-8.7c.5-1.8.7-3.2.7-3.2H9s.3 1.4.8 3.2l.6 2.2H7.6l.5-2.2zm140.5-2.3c0-3.9-2.8-5.2-6.5-5.2h-7.9v16.3h5.5v-4.6h1c.8 0 1.2.3 1.4 1.3l.3 1.3c.2 1 .4 1.5.9 2h6.2c-.6-.6-.8-1.2-1.1-2.1l-.6-2.2c-.4-1.5-1.1-2.2-2.6-2.4v-.1c2.1-.5 3.4-1.6 3.4-4.3zm-7.2 2.1h-1.7v-2.6h1.7c.8 0 1.3.5 1.3 1.3.1 1-.4 1.3-1.3 1.3zm-86.8.8c0 5.4 3.3 8.4 8.1 8.4 4 0 6.4-1.4 7.6-4.4L65 30.6c-.2 1.5-.8 2.2-2.2 2.2-1.7 0-2.3-1.5-2.3-3.6 0-2.9 1-3.8 2.4-3.8 1.2 0 1.8.9 2 2l5.4-2.2c-.8-2.8-3.6-4.5-7.3-4.5-5.5-.1-8.4 3-8.4 8.4zm29.3-3.5v-4.7H71.7v16.3H84v-4.7h-6.9v-1.4h6.1V27h-6.1v-1.4M107.7.3h5.7v16.3h-5.7zM37.8 0c-5.2 0-8.2 3-8.2 8.5s3 8.4 8.2 8.4c5.2 0 8.2-3 8.2-8.4C45.9 3 42.9 0 37.8 0zm0 12.2c-1.7 0-2.3-1.4-2.3-3.7 0-2.4.6-3.8 2.3-3.8S40 6.1 40 8.5c0 2.3-.5 3.7-2.2 3.7zM90.3.3v16.3h5.6v-5.9h.8l3.1 5.9h6.6l-4.8-8.4L106 .3h-6.3L96.8 6h-.9V.3m28.5 4.8L121.1.3h-5v16.3h5.7v-4.1c0-2.1-.1-3.3-.1-3.3h.1s.7 1.2 1.8 2.6l3.5 4.8h4.7V.3h-5.7v4.6c0 1.5.1 2.9.1 2.9h-.1s-.6-1.1-1.7-2.7zm-109.2.1h3.9v11.4h5.7V5.2h4.1V.3H15.2M142.4 11h1.9v.1c0 .7-.7 1.3-2 1.3-1.9 0-2.6-1.3-2.6-3.8 0-2.9 1-3.8 2.4-3.8 1.2 0 1.8.9 2 2l5.4-2.2c-.7-2.9-3.5-4.6-7.2-4.6-5.5 0-8.4 3.1-8.4 8.5 0 5.9 3.3 8.4 7.3 8.4 2.3 0 3.8-.7 4.5-2.1l.6 1.8h3.8V7.5h-7.6V11zM75.2 3.9c-.9 1.9-1.2 3-1.2 3h-.1s-.3-1.1-1.2-3L71 .4h-6.2v16.3h5.7v-4.5c0-1.5-.1-2.9-.1-2.9h.1s.5 1.5 1 2.4l.9 2h3l.9-2c.5-1 1-2.4 1-2.4h.1s-.1 1.4-.1 2.9v4.5H83V.3h-6.2l-1.6 3.6zM7 12.6c-.9 0-1.5-.4-1.8-1.4L0 13.1C.7 15.8 3.4 17 6.8 17c4.1 0 7.4-1.4 7.4-5.3 0-3.3-2-5.2-6.2-5.7-1.3-.2-1.8-.4-1.8-1 0-.4.4-.7 1-.7.7 0 1.3.3 1.5 1.2l5.4-1.2C13.4 1.2 11 0 7.4 0 3.7 0 .5 1.4.5 5.6c0 3 1.6 4.7 6.4 5.4.9.1 1.2.4 1.2.8 0 .6-.3.8-1.1.8zm55.4-7c0-3.9-2.8-5.2-6.5-5.2H48v16.3h5.5V12h1c.8 0 1.2.3 1.4 1.3l.3 1.3c.2 1 .4 1.5.9 2h6.2c-.6-.6-.8-1.2-1.1-2.1l-.6-2.2c-.4-1.5-1.1-2.2-2.6-2.4v-.1c2.1-.3 3.4-1.5 3.4-4.2zm-7.2 2.2h-1.7V5.1h1.7c.8 0 1.3.5 1.3 1.3.1 1-.5 1.4-1.3 1.4z"></path>
						</svg>-->
					</a>			
                </div>	
				<div class="main-menu">
					<ul class="nav menuItems">
						<li><a href='https://stormking.org/about/'>About</a></li>
						<li><a href='https://stormking.org/visit/'>Visit</a></li>
					
						<li>
							<?php print caNavLink($this->request, _t("Collection"), "", "", "About", "collection"); ?>
<?php
						if (((strtolower($this->request->getController()) == "featured") && (($this->request->getParameter('setMode', pString) == "archives") || (strtolower($this->request->getAction()) == "archives"))) || (($this->request->getController() == "Browse") && ($this->request->getAction() != "exhibitions")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "objects")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "entities")) | (($this->request->getController() == "About") && ($this->request->getAction() == "collection"))) {
?>								
							<ul class='subMenu'>
								<li style="padding-top:6px;" <?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "objects")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "objects"))) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Art"), "", "", "Browse", "objects"); ?></li>					
								<li <?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "entities")) || (($this->request->getController() == "Detail") && ($this->request->getAction() == "entities"))) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Artists"), "", "", "Browse", "entities"); ?></li>					
								<li <?php print ((strtolower($this->request->getController()) == "featured") && (($this->request->getParameter('setMode', pString) == "archives") || (strtolower($this->request->getAction()) == "archives"))) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Featured"), "", "", "Featured", "archives"); ?></li>					
							</ul>												
<?php						
						} 
?>							
						</li>					
						<li>
<?php 
							#print caNavLink($this->request, _t("Exhibitions"), "", "", "Listing", "exhibitions", array("sort" => "default", "direction" => "desc"));
							print caNavLink($this->request, _t("Exhibitions"), "", "", "About", "exhibitions");

							if (((strtolower($this->request->getController()) == "featured") && (($this->request->getParameter('setMode', pString) == "exhibitions") || (strtolower($this->request->getAction()) == "index") || (strtolower($this->request->getAction()) == "theme"))) || ((strtolower($this->request->getController()) == "about") && ($this->request->getAction() == "exhibitions")) | ((strtolower($this->request->getController()) == "browse") && ($this->request->getAction() == "exhibitions")) | ((strtolower($this->request->getController()) == "listing") && ($this->request->getAction() == "currentexhibitions"))  | ((strtolower($this->request->getController()) == "listing") && ($this->request->getAction() == "exhibitions")) | ((strtolower($this->request->getController()) == "detail") && ($this->request->getAction() == "occurrences"))) {
?>							
								<ul class='subMenu'>
									<li style="padding-top:6px;" <?php print ((($this->request->getAction() == "currentexhibitions") ) ? 'class="active"' : ''); ?>><?php print caNavLink($this->request, _t("Current & Upcoming"), "", "", "Listing", "currentexhibitions", array("sort" => "default", "direction" => "desc")); ?></li>					
									<li <?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "exhibitions")) ? 'class="active"' : ''); ?>><?php print caNavLink($this->request, _t("Past"), "", "", "Browse", "exhibitions"); ?></li>					
									<li <?php print ((strtolower($this->request->getController()) == "featured") && (($this->request->getParameter('setMode', pString) == "exhibitions") || (strtolower($this->request->getAction()) == "index") || (strtolower($this->request->getAction()) == "theme"))) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Online"), "", "", "Featured", "index"); ?></li>					
								</ul>
<?php
							}
?>							
						
						</li>
						<li><a href='https://stormking.org/education-2/'>Education</a></li>
						<li>
							<?php print caNavLink($this->request, _t("Archives"), "", "", "About", "archives"); ?> 
<?php
							if (($this->request->getController() == "Collections") | (($this->request->getController() == "Listing") && ($this->request->getAction() == "oralhistory")) | (($this->request->getController() == "About") && ($this->request->getAction() == "archives")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "collections")) | ($this->request->getAction() == "oralhistory") | (($this->request->getController() == "Detail") && ($this->request->getAction() == "archival"))) {
?>							
								<ul class='subMenu'>
									<li style="padding-top:6px;" <?php print (($this->request->getController() == "Listing")| ($this->request->getAction() == "oralhistory") ) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Oral History"), "", "", "Listing", "oralhistory"); ?></li>					
									<!--<li <?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Search"), "", "", "Search", "advanced/objects"); ?></li>-->
									<li <?php print ( (($this->request->getController() == "Detail") && ($this->request->getAction() == "archival")) | ($this->request->getController() == "Collections") | ($this->request->getAction() == "collections")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Special Collections"), "", "", "Collections", "index"); ?></li>					
								</ul>
<?php
							}
?>							
						</li>
						<li><a href='https://stormking.org/support/'>Support</a></li>
						<li><a href='https://stormking.org/calendar/'>Calendar</a></li>
						<li><a href='https://shop.stormking.org/'>Shop</a></li>
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
				<nav class="secondary-menu"><ul id="menu-secondary-menu" class="menu"><li id="menu-item-345" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-345"><a href="https://stormking.org/termsprivacycredits/">Terms/Privacy/Credits</a></li>
					<li id="menu-item-348" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-348"><a href="https://stormking.org/job-opportunities/">Job Opportunities</a></li>
					<li id="menu-item-15356" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-15356"><a href="https://visitor.r20.constantcontact.com/d.jsp?llr=zkiggxcab&amp;p=oi&amp;m=1102437359961&amp;sit=o5slr77db&amp;f=08547c94-ef10-4ab8-a2c7-141650bcbd20">Join Mailing List</a></li>
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
			</div>	









		<!-- mobile header -->
		<header id="header-mobile" class="hidden-lg hidden-md <?php print ($this->request->getController() == "About") ? "header-white" : ""; ?>">
			<div class="top">
				<div class="container">

					<div id="header-mobile-content-trigger">
						<svg version="1.2" baseProfile="tiny" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 28.9 23">
						  <path d="M0 0h28.9v5.4H0zm0 8.8h28.9v5.4H0zm0 8.7h28.9v5.4H0z"></path>
						</svg>
					</div>

					<a class="logo" href="https://stormking.org">
						<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 158 34.99"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><rect x="106.55" width="0.97" height="34.99"/><path d="M.34,8.56c0,2,1.07,3.14,4.31,3.65.6.09.84.26.84.55s-.26.51-.76.51a1.25,1.25,0,0,1-1.25-.95L0,13.56c.5,1.83,2.31,2.61,4.58,2.61,2.73,0,5-1,5-3.59,0-2.24-1.35-3.5-4.14-3.84-.9-.11-1.21-.29-1.21-.65s.24-.46.65-.46a.86.86,0,0,1,1,.78l3.67-.82C9.06,5.6,7.39,4.76,5,4.76S.34,5.69.34,8.56Z"/><polygon points="12.86 15.95 16.68 15.95 16.68 8.26 19.43 8.26 19.43 4.99 10.18 4.99 10.18 8.26 12.86 8.26 12.86 15.95"/><path d="M19.86,10.48c0,3.7,2,5.69,5.53,5.69s5.52-2,5.52-5.69-2-5.72-5.52-5.72S19.86,6.75,19.86,10.48ZM25.39,13c-1.16,0-1.55-.91-1.55-2.51s.39-2.54,1.55-2.54,1.54.92,1.54,2.54S26.54,13,25.39,13Z"/><path d="M36,12.88h.69c.54,0,.81.2.94.85l.19.86A2.57,2.57,0,0,0,38.45,16h4.19a2.87,2.87,0,0,1-.74-1.44l-.41-1.45a2,2,0,0,0-1.73-1.62v-.07A2.51,2.51,0,0,0,42,8.52C42,5.9,40.09,5,37.58,5h-5.3V16H36Zm0-4.67h1.15a.8.8,0,0,1,.89.87.82.82,0,0,1-.93.91H36Z"/><path d="M48.67,14h2l.63-1.35C51.67,12,52,11,52,11h.08s-.06.93-.06,1.93v3h3.82V5H51.71L50.57,7.37a16.63,16.63,0,0,0-.84,2h-.07a14.77,14.77,0,0,0-.84-2L47.69,5H43.54V16h3.81v-3c0-1-.05-1.93-.05-1.93h.07s.36,1,.67,1.63Z"/><polygon points="68.48 10.27 71.4 4.99 67.19 4.99 65.22 8.8 64.63 8.8 64.63 4.99 60.81 4.99 60.81 15.95 64.63 15.95 64.63 11.96 65.17 11.96 67.25 15.95 71.68 15.95 68.48 10.27"/><rect x="72.58" y="4.99" width="3.81" height="10.96"/><path d="M82,13.21c0-1.4,0-2.25,0-2.25h.08s.48.78,1.19,1.77L85.6,16h3.17V5H85V8.06c0,1,0,1.93,0,1.93h-.08s-.42-.74-1.15-1.78L81.57,5H78.22V16H82Z"/><path d="M90.13,10.51c0,4,2.21,5.66,4.91,5.66,1.55,0,2.55-.5,3-1.43L98.45,16H101V9.79H95.86v2.38h1.3v.09c0,.49-.44.86-1.34.86-1.28,0-1.73-.9-1.73-2.59,0-1.93.67-2.57,1.64-2.57s1.23.6,1.32,1.34l3.65-1.5c-.54-1.87-2.42-3-4.91-3C92.06,4.76,90.13,6.85,90.13,10.51Z"/><path d="M3.59,19,0,30H3.8l.44-1.49H7.85L8.34,30h3.94L8.67,19ZM5.1,25.67l.39-1.51C5.81,23,6,22,6,22h.08s.22.95.54,2.14L7,25.67Z"/><path d="M23,22.58C23,20,21.07,19,18.56,19H13.25V30H17V26.93h.69c.54,0,.82.21.95.86l.19.85A2.53,2.53,0,0,0,19.43,30h4.19a3,3,0,0,1-.75-1.43l-.41-1.45a1.92,1.92,0,0,0-1.73-1.62v-.08A2.51,2.51,0,0,0,23,22.58Zm-4.84,1.47H17V22.26h1.16a.81.81,0,0,1,.89.87A.82.82,0,0,1,18.11,24.05Z"/><polygon points="23.68 22.32 26.36 22.32 26.36 30 30.17 30 30.17 22.32 32.93 22.32 32.93 19.04 23.68 19.04 23.68 22.32"/><path d="M42.83,22c.84,0,1.23.59,1.32,1.34l3.65-1.51c-.54-1.86-2.42-3-4.92-3-3.72,0-5.65,2.08-5.65,5.75s2.21,5.65,5.45,5.65c2.7,0,4.3-1,5.14-2.95l-3.6-1.72c-.13,1-.53,1.49-1.45,1.49-1.15,0-1.58-1-1.58-2.45C41.19,22.65,41.86,22,42.83,22Z"/><polygon points="57.01 26.88 52.38 26.88 52.38 25.89 56.44 25.89 56.44 23.15 52.38 23.15 52.38 22.17 56.94 22.17 56.94 19.04 48.71 19.04 48.71 30 57.01 30 57.01 26.88"/><path d="M63.6,26.78,66,30h3.16V19H65.3v3.07c0,1,0,1.94,0,1.94h-.07s-.43-.75-1.16-1.79L61.91,19H58.56V30h3.81V27.27c0-1.4,0-2.26,0-2.26h.07S62.9,25.8,63.6,26.78Z"/><polygon points="76.87 30 76.87 22.32 79.63 22.32 79.63 19.04 70.38 19.04 70.38 22.32 73.06 22.32 73.06 30 76.87 30"/><polygon points="89.2 26.88 84.56 26.88 84.56 25.89 88.62 25.89 88.62 23.15 84.56 23.15 84.56 22.17 89.12 22.17 89.12 19.04 80.9 19.04 80.9 30 89.2 30 89.2 26.88"/><path d="M100,27.12a1.93,1.93,0,0,0-1.73-1.62v-.08a2.51,2.51,0,0,0,2.22-2.84c0-2.63-1.88-3.54-4.39-3.54H90.74V30h3.74V26.93h.69c.54,0,.82.21,1,.86l.19.85A2.53,2.53,0,0,0,96.92,30h4.19a3,3,0,0,1-.75-1.43ZM95.6,24.05H94.48V22.26h1.16a.81.81,0,0,1,.89.87A.82.82,0,0,1,95.6,24.05Z"/><path d="M122.72,17.56A3.67,3.67,0,0,0,119,21.24a3.81,3.81,0,1,0,3.74-3.68Zm0,6.56A2.77,2.77,0,0,1,120,21.24a2.71,2.71,0,0,1,2.77-2.71,2.8,2.8,0,1,1,0,5.59Z"/><path d="M151.84,17.53c0-4.28-3.11-7.63-7.08-7.63a7.22,7.22,0,0,0-7,7.53c0,4.37,3.06,7.66,7.13,7.66C148.77,25.09,151.84,21.77,151.84,17.53Zm-7,6.59c-3.57,0-6.16-2.82-6.16-6.69a6.26,6.26,0,0,1,6.06-6.56c3.43,0,6.11,2.92,6.11,6.66S148.29,24.12,144.86,24.12Z"/><path d="M158,17.33a13.2,13.2,0,0,0-26.33-1,7.84,7.84,0,0,0-7-4.2h-.26l5.3-7.21h-8.36l-6.15,9a11.81,11.81,0,0,0-2.3,6.73c0,5.78,4.12,9.81,10,9.81a9.55,9.55,0,0,0,9.64-7.64c2.13,4.85,7.38,7.64,12.5,7.64A12.91,12.91,0,0,0,158,17.33Zm-26.21,3.49a8.6,8.6,0,0,1-8.87,8.71c-5.32,0-9-3.64-9-8.84A10.85,10.85,0,0,1,116,14.51l5.85-8.6h5.93l-5,6.75.46.68.35-.11a3,3,0,0,1,1-.11,7.07,7.07,0,0,1,6.94,6c0,.38.08.76.14,1.13A6.08,6.08,0,0,1,131.79,20.82Zm.94-.73a8.54,8.54,0,0,0-.15-1.16c0-.29-.05-.58-.05-.88,0-7.3,5.15-12.59,12.23-12.59A12.08,12.08,0,0,1,157,17.33a12,12,0,0,1-12,12.2C139.51,29.53,133.81,26,132.73,20.09Z"/></g></g></svg>
						<!--<svg version="1.2" baseProfile="tiny" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 150 37.5">
						  <path fill="none" d="M37.8 4.7c-1.7 0-2.3 1.4-2.3 3.8s.6 3.7 2.3 3.7S40 10.8 40 8.5c0-2.4-.5-3.8-2.2-3.8zm-12.5 21v2.6H27c.8 0 1.4-.4 1.4-1.4 0-.8-.5-1.3-1.3-1.3h-1.8zM9.8 28.5c-.5-1.8-.8-3.2-.8-3.2h-.1s-.2 1.4-.7 3.2l-.6 2.2h2.8l-.6-2.2zM55.3 5.1h-1.7v2.6h1.7c.8 0 1.4-.4 1.4-1.4-.1-.7-.6-1.2-1.4-1.2zm86.2 20.6h-1.7v2.6h1.7c.8 0 1.4-.4 1.4-1.4-.1-.7-.6-1.2-1.4-1.2z"></path>
						  <path class="fill-me" d="M86.4 37.2H92v-4.1c0-2.1-.1-3.3-.1-3.3h.1s.7 1.2 1.8 2.6l3.5 4.8h4.7V20.9h-5.7v4.6c0 1.5.1 2.9.1 2.9h-.1s-.6-1.1-1.7-2.6L91.3 21h-5v16.2zM35.2 25.8h4v11.4h5.6V25.8h4.1v-4.9H35.2m68.7 4.9h4v11.4h5.7V25.8h4.1v-4.9h-13.8m-84.2 0v16.3h5.5v-4.6h1c.8 0 1.2.3 1.4 1.3l.3 1.3c.2 1 .4 1.5.9 2H35c-.5-.6-.8-1.2-1-2.2l-.6-2.2c-.4-1.5-1.1-2.2-2.6-2.4v-.1c2-.3 3.3-1.5 3.3-4.2 0-3.9-2.8-5.2-6.5-5.2h-7.9zm8.6 6.1c0 1-.6 1.4-1.4 1.4h-1.7v-2.6H27c.8-.1 1.3.4 1.3 1.2zm103.5-1.4v-4.7h-12.2v16.3h12.3v-4.7H125v-1.4h6V27h-6v-1.4M5.6 37.2l.7-2.2h5.4l.7 2.2h5.9l-5.4-16.3H5.3L0 37.2h5.6zm2.5-8.7c.5-1.8.7-3.2.7-3.2H9s.3 1.4.8 3.2l.6 2.2H7.6l.5-2.2zm140.5-2.3c0-3.9-2.8-5.2-6.5-5.2h-7.9v16.3h5.5v-4.6h1c.8 0 1.2.3 1.4 1.3l.3 1.3c.2 1 .4 1.5.9 2h6.2c-.6-.6-.8-1.2-1.1-2.1l-.6-2.2c-.4-1.5-1.1-2.2-2.6-2.4v-.1c2.1-.5 3.4-1.6 3.4-4.3zm-7.2 2.1h-1.7v-2.6h1.7c.8 0 1.3.5 1.3 1.3.1 1-.4 1.3-1.3 1.3zm-86.8.8c0 5.4 3.3 8.4 8.1 8.4 4 0 6.4-1.4 7.6-4.4L65 30.6c-.2 1.5-.8 2.2-2.2 2.2-1.7 0-2.3-1.5-2.3-3.6 0-2.9 1-3.8 2.4-3.8 1.2 0 1.8.9 2 2l5.4-2.2c-.8-2.8-3.6-4.5-7.3-4.5-5.5-.1-8.4 3-8.4 8.4zm29.3-3.5v-4.7H71.7v16.3H84v-4.7h-6.9v-1.4h6.1V27h-6.1v-1.4M107.7.3h5.7v16.3h-5.7zM37.8 0c-5.2 0-8.2 3-8.2 8.5s3 8.4 8.2 8.4c5.2 0 8.2-3 8.2-8.4C45.9 3 42.9 0 37.8 0zm0 12.2c-1.7 0-2.3-1.4-2.3-3.7 0-2.4.6-3.8 2.3-3.8S40 6.1 40 8.5c0 2.3-.5 3.7-2.2 3.7zM90.3.3v16.3h5.6v-5.9h.8l3.1 5.9h6.6l-4.8-8.4L106 .3h-6.3L96.8 6h-.9V.3m28.5 4.8L121.1.3h-5v16.3h5.7v-4.1c0-2.1-.1-3.3-.1-3.3h.1s.7 1.2 1.8 2.6l3.5 4.8h4.7V.3h-5.7v4.6c0 1.5.1 2.9.1 2.9h-.1s-.6-1.1-1.7-2.7zm-109.2.1h3.9v11.4h5.7V5.2h4.1V.3H15.2M142.4 11h1.9v.1c0 .7-.7 1.3-2 1.3-1.9 0-2.6-1.3-2.6-3.8 0-2.9 1-3.8 2.4-3.8 1.2 0 1.8.9 2 2l5.4-2.2c-.7-2.9-3.5-4.6-7.2-4.6-5.5 0-8.4 3.1-8.4 8.5 0 5.9 3.3 8.4 7.3 8.4 2.3 0 3.8-.7 4.5-2.1l.6 1.8h3.8V7.5h-7.6V11zM75.2 3.9c-.9 1.9-1.2 3-1.2 3h-.1s-.3-1.1-1.2-3L71 .4h-6.2v16.3h5.7v-4.5c0-1.5-.1-2.9-.1-2.9h.1s.5 1.5 1 2.4l.9 2h3l.9-2c.5-1 1-2.4 1-2.4h.1s-.1 1.4-.1 2.9v4.5H83V.3h-6.2l-1.6 3.6zM7 12.6c-.9 0-1.5-.4-1.8-1.4L0 13.1C.7 15.8 3.4 17 6.8 17c4.1 0 7.4-1.4 7.4-5.3 0-3.3-2-5.2-6.2-5.7-1.3-.2-1.8-.4-1.8-1 0-.4.4-.7 1-.7.7 0 1.3.3 1.5 1.2l5.4-1.2C13.4 1.2 11 0 7.4 0 3.7 0 .5 1.4.5 5.6c0 3 1.6 4.7 6.4 5.4.9.1 1.2.4 1.2.8 0 .6-.3.8-1.1.8zm55.4-7c0-3.9-2.8-5.2-6.5-5.2H48v16.3h5.5V12h1c.8 0 1.2.3 1.4 1.3l.3 1.3c.2 1 .4 1.5.9 2h6.2c-.6-.6-.8-1.2-1.1-2.1l-.6-2.2c-.4-1.5-1.1-2.2-2.6-2.4v-.1c2.1-.3 3.4-1.5 3.4-4.2zm-7.2 2.2h-1.7V5.1h1.7c.8 0 1.3.5 1.3 1.3.1 1-.5 1.4-1.3 1.4z"></path>
						</svg>-->
					</a>

				</div>
			</div>
			<div id="header-mobile-content">
				<div class="container">
					<nav class="main-menu"><ul id="menu-main-menu-1" class="menu">
						<li class="menu-item menu-item-type-post_type menu-item-object-page page_item page-item-30 current_page_item menu-item-has-children menu-item-32"><a href="https://stormking.org/about/">About</a>
							<ul class="sub-menu">
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-59"><a href="https://stormking.org/about/history/">History</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16643"><a href="https://stormking.org/town-of-cornwall/">Town of Cornwall</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-64"><a href="https://stormking.org/about/landscape/">Landscape</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-72"><a href="https://stormking.org/about/press/">Press</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-105"><a href="https://stormking.org/about/leadership/">Leadership</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15419"><a href="https://stormking.org/about/donors/">Donors</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-113"><a href="https://stormking.org/about/contact/">Contact</a></li>
							</ul>
						</li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-130"><a href="https://stormking.org/visit/">Visit</a>
							<ul class="sub-menu">
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-156"><a href="https://stormking.org/visit/plan-your-visit/">Plan your visit</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17310"><a href="https://stormking.org/visit/groups/">Groups</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16572"><a href="https://stormking.org/visit/food/">Food</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-186"><a href="https://stormking.org/visit/bikes/">Bikes</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-189"><a href="https://stormking.org/visit/local-amenities/">Local Amenities</a></li>
							</ul>
						</li>


						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children">
							<?php print caNavLink($this->request, _t("Collection"), "", "", "About", "collection"); ?>
							<ul class='sub-menu <?php print (((strtolower($this->request->getController()) == "featured") && (($this->request->getParameter('setMode', pString) == "archives") || (strtolower($this->request->getAction()) == "archives"))) | (($this->request->getController() == "Browse") && ($this->request->getAction() != "exhibitions")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "objects")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "entities")) | (($this->request->getController() == "About") && ($this->request->getAction() == "collection"))) ? ' active' : ''; ?>'>
								<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "objects")) || (($this->request->getController() == "Detail") && ($this->request->getAction() == "objects"))) ? ' current-menu-item' : ''; ?>'><?php print caNavLink($this->request, _t("Art"), "", "", "Browse", "objects"); ?></li>					
								<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "entities")) || (($this->request->getController() == "Detail") && ($this->request->getAction() == "entities"))) ? ' current-menu-item' : ''; ?>'><?php print caNavLink($this->request, _t("Artists"), "", "", "Browse", "entities"); ?></li>					
								<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ((strtolower($this->request->getController()) == "featured") && (($this->request->getParameter('setMode', pString) == "archives") || (strtolower($this->request->getAction()) == "archives"))) ? ' current-menu-item' : ''; ?>'><?php print caNavLink($this->request, _t("Featured"), "", "", "Featured", "archives"); ?></li>					
							
							</ul>												
						</li>					
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children">
							<?php print caNavLink($this->request, _t("Exhibitions"), "", "", "Listing", "exhibitions", array("sort" => "default", "direction" => "desc")); ?>
							<ul class='sub-menu <?php print (((strtolower($this->request->getController()) == "featured") && (($this->request->getParameter('setMode', pString) == "exhibitions") || (strtolower($this->request->getAction()) == "index") || (strtolower($this->request->getAction()) == "theme"))) || ((strtolower($this->request->getController()) == "about") && ($this->request->getAction() == "exhibitions")) | ((strtolower($this->request->getController()) == "browse") && ($this->request->getAction() == "exhibitions")) | ((strtolower($this->request->getController()) == "listing") && ($this->request->getAction() == "currentexhibitions"))  | ((strtolower($this->request->getController()) == "listing") && ($this->request->getAction() == "exhibitions")) | ((strtolower($this->request->getController()) == "detail") && ($this->request->getAction() == "occurrences"))) ? ' active' : ''; ?>'>
								<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ((($this->request->getAction() == "currentexhibitions") ) ? ' current-menu-item' : ''); ?>'><?php print caNavLink($this->request, _t("Current & Upcoming"), "", "", "Listing", "currentexhibitions", array("sort" => "default", "direction" => "desc")); ?></li>					
								<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ((($this->request->getController() == "Browse") && ($this->request->getAction() == "exhibitions")) ? ' current-menu-item' : ''); ?>'><?php print caNavLink($this->request, _t("Past"), "", "", "Browse", "exhibitions"); ?></li>					
								<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ((strtolower($this->request->getController()) == "featured") && (($this->request->getParameter('setMode', pString) == "exhibitions") || (strtolower($this->request->getAction()) == "index") || (strtolower($this->request->getAction()) == "theme"))) ? ' current-menu-item' : ''; ?>'><?php print caNavLink($this->request, _t("Online"), "", "", "Featured", "index"); ?></li>					
							</ul>
						</li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-15458"><a href="https://stormking.org/education-2/">Education</a>
							<ul class="sub-menu">
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15447"><a href="https://stormking.org/education-2/public-programs/">Public Programs</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15448"><a href="https://stormking.org/education-2/family-programs/">Children and Families Programs</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16252"><a href="https://stormking.org/education-2/students-teachers/">Schools &amp; Teachers</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-241"><a href="https://stormking.org/education-2/summercamp/">Summer Camps</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-252"><a href="https://stormking.org/education-2/artist-residency/">Artist Residency</a></li>
							</ul>
						</li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children">
							<?php print caNavLink($this->request, _t("Archives"), "", "", "About", "archives"); ?> 
							<ul class='sub-menu<?php print (($this->request->getController() == "Collections") | (($this->request->getController() == "Listing") && ($this->request->getAction() == "oralhistory")) | (($this->request->getController() == "About") && ($this->request->getAction() == "archives")) | (($this->request->getController() == "Detail") && ($this->request->getAction() == "collections")) | ($this->request->getAction() == "oralhistory") | (($this->request->getController() == "Detail") && ($this->request->getAction() == "archival"))) ? " active" : ""; ?>'>
								<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print (($this->request->getController() == "Listing")| ($this->request->getAction() == "oralhistory") ) ? ' current-menu-item' : ''; ?>'><?php print caNavLink($this->request, _t("Oral History"), "", "", "Listing", "oralhistory"); ?></li>					
								<li class='menu-item menu-item-type-post_type menu-item-object-page<?php print ( (($this->request->getController() == "Detail") && ($this->request->getAction() == "archival")) | ($this->request->getController() == "Collections") | ($this->request->getAction() == "collections")) ? ' current-menu-item' : ''; ?>'><?php print caNavLink($this->request, _t("Special Collections"), "", "", "Collections", "index"); ?></li>					
							</ul>
						</li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-264"><a href="https://stormking.org/support/">Support</a>
							<ul class="sub-menu">
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16799"><a href="https://stormking.org/support/annualfund/">Annual Fund</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-269"><a href="https://stormking.org/support/membership/">Membership</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16595"><a href="https://stormking.org/support/council/">Council</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-328"><a href="https://stormking.org/support/gala2017/">Annual Gala</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-322"><a href="https://stormking.org/support/summer-solstice/">Summer Solstice</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-14645"><a href="https://stormking.org/support/project-support/">Project Support</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-290"><a href="https://stormking.org/support/corporate-support/">Corporate Support</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15233"><a href="https://stormking.org/support/planned-giving/">Planned Giving</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-314"><a href="https://stormking.org/support/host-an-event/">Host an Event</a></li>
								<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-285"><a href="https://stormking.org/support/donate/">Donate</a></li>
							</ul>
						</li>
						<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-14503"><a href="https://stormking.org/calendar/">Calendar</a></li>
						<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-12"><a target="_blank" href="https://shop.stormking.org/">Shop</a></li>
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

					<div class="copyright">©2018 Storm King Art Center</div>
				

					<nav class="secondary-menu">
						<ul id="menu-secondary-menu-1" class="menu"><li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-345"><a href="https://stormking.org/termsprivacycredits/">Terms/Privacy/Credits</a></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-348"><a href="https://stormking.org/job-opportunities/">Job Opportunities</a></li>
							<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-15356"><a href="https://visitor.r20.constantcontact.com/d.jsp?llr=zkiggxcab&amp;p=oi&amp;m=1102437359961&amp;sit=o5slr77db&amp;f=08547c94-ef10-4ab8-a2c7-141650bcbd20">Join Mailing List</a></li>
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
