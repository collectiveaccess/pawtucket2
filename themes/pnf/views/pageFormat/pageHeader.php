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
	global $g_ui_locale;
	$va_lightboxDisplayName = caGetLightboxDisplayName();
	$vs_lightbox_sectionHeading = ucFirst($va_lightboxDisplayName["section_heading"]);
	$va_classroomDisplayName = caGetClassroomDisplayName();
	$vs_classroom_sectionHeading = ucFirst($va_classroomDisplayName["section_heading"]);
	
	# Collect the user links: they are output twice, once for toggle menu and once for nav
	$va_user_links = array();
#	if($this->request->isLoggedIn()){
#		$va_user_links[] = '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
#		$va_user_links[] = '<li class="divider nav-divider"></li>';
#		if(caDisplayLightbox($this->request)){
#			$va_user_links[] = "<li>".caNavLink($this->request, $vs_lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
#		}
#		if(caDisplayClassroom($this->request)){
#			$va_user_links[] = "<li>".caNavLink($this->request, $vs_classroom_sectionHeading, '', '', 'Classroom', 'Index', array())."</li>";
#		}
#		$va_user_links[] = "<li>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
#		$va_user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
#	} else {	
#		if (!$this->request->config->get('dont_allow_registration_and_login') || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
#		if (!$this->request->config->get('dont_allow_registration_and_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
#	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<link rel="stylesheet" id="twentyfifteen-style-css" href="/wp-content/themes/twentyfifteen-child-01/style.css?ver=4.4.3" type="text/css" media="all">
	
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
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4CLSP0B9W0"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
 
  gtag('config', 'G-4CLSP0B9W0');
</script>
</head>
<body>
	<div id="page" class="hfeed">
	<header id="head" class="site-header" role="banner">
		<div class="responsive-top clearfix">
			<a href="" class="logo">Comedias Sueltas</a>			
			<ul class="qtranxs_language_chooser" id="qtranslate-chooser">
				<li class="lang-en <?php print ($g_ui_locale == 'en_US') ? 'active' : ''; ?>"><?php print caChangeLocaleLink($this->request, 'en_US', '<span>ENG</span>', 'qtranxs_text qtranxs_text_en', ['hreflang' => 'en', 'title' => 'English']); ?></li>
				<li class="lang-es <?php print ($g_ui_locale == 'es_ES') ? 'active' : ''; ?>"><?php print caChangeLocaleLink($this->request, 'es_ES', '<span>ESP</span>', 'qtranxs_text qtranxs_text_es', ['hreflang' => 'es', 'title' => 'Español']); ?></li>
			</ul>
			<div class="qtranxs_widget_end"></div>
		</div>
		<div class="responsive-nav">
			<a href="#" >NAVIGATION</a>
		</div>	
<script>
$( document ).ready(function() {
	$(".responsive-nav a").click(function(){
	    if($('.main_menu').css('display') == "none") {
			$('.main_menu').show();
			$('ul#menu-main-menu').show();
			$('.responsive-nav a').addClass('active');
		} else {
			$('ul#menu-main-menu').slideUp(400);
			$('.main_menu').slideUp(400);
			$('.responsive-nav a').removeClass('active');		
		};
	});
	$("#menu-item-208 a").click(function(){
	    if($('#menu-item-208 .sub-menu').css('display') == "none") {
			$('#menu-item-208 .sub-menu').show();
		} else {
			$('#menu-item-208 .sub-menu').hide();	
		};	
	});
	$( window ).resize(function() {
		if(window.innerWidth > 1025) {
			$('.main_menu').show();
			$('ul#menu-main-menu').show();
		} else {
			$('.main_menu').hide();
			$('ul#menu-main-menu').hide();		
		}
	});
});	
</script>					
		<div class="main_menu">
			<div class="menu-main-menu-container">
				<ul id="menu-main-menu" class="menu">
<?php
	if ($g_ui_locale == 'en_US'){
?>
					<li id="menu-item-453" class="menu-item menu-item-type-post_type  current-menu-item  menu-item-object-page menu-item-453"><?php print caNavLink($this->request, _t('Database'), '', '', '', '');?></a></li>
					<li id="menu-item-450" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-450"><a href="/ornaments/"><?php print  _t('Ornaments');?></a></li>
					<li id="menu-item-208" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-ancestor current-menu-parent menu-item-has-children menu-item-208"><a href="#"><?php print _t('Resources');?></a>
						<ul class="sub-menu">
							<li id="menu-item-410" class="menu-item menu-item-type-post_type menu-item-object-lists menu-item-410"><a href="/lists/about-these-lists/"><?php print _t('About these resources');?></a></li>
							<li id="menu-item-191" class="menu-item menu-item-type-post_type menu-item-object-lists menu-item-191"><?php print caNavLink($this->request, _t('Authority File: Playwrights, translators, adaptors'), '', '', 'Listing', 'playwrights'); ?></a></li>
							<li id="menu-item-198" class="menu-item menu-item-type-post_type menu-item-object-lists menu-item-198"><?php print caNavLink($this->request, _t('Authority File: Printers, publishers, booksellers, bookstores'), '', '', 'Listing', 'printers');?></a></li>
							<li id="menu-item-444" class="menu-item menu-item-type-post_type menu-item-object-page"><?php print caNavLink($this->request, _t('Bibliography'), '', '', 'Listing', 'bibliography');?></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-lists"><?php print caNavLink($this->request, _t('Dates of Printers & Booksellers'), '', '', 'Listing', 'printers_booksellers_dates');?></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-lists"><?php print caNavLink($this->request, _t('Glossary'), '', '', 'Listing', 'glossary');?></li>		
<?php
if($this->request->isLoggedIn()){
?>
							<li class="menu-item menu-item-type-post_type menu-item-object-lists"><?php print caNavLink($this->request, _t("Illustrations"), '', '', 'Pictorials', 'Illustrations');?></li>
<?php
}
?>
							<li id="menu-item-199" class="menu-item menu-item-type-post_type menu-item-object-lists menu-item-199"><?php print caNavLink($this->request, _t('Institutions'), '', '', 'Browse', 'collections');?></li>													
							<li class="menu-item menu-item-type-post_type menu-item-object-lists"><?php print caNavLink($this->request, _t('Miscellany'), '', '', 'Listing', 'miscellanies');?></li>							
							<li id="menu-item-444" class="menu-item menu-item-type-post_type menu-item-object-page"><?php print caNavLink($this->request, _t('Modernized editions of plays'), '', '', 'Listing', 'modern_editions');?></li>
<?php
if($this->request->isLoggedIn()){
?>
							<li class="menu-item menu-item-type-post_type menu-item-object-lists"><?php print caNavLink($this->request, _t('Ornaments'), '', '', 'Pictorials', 'ornaments');?></li>
<?php
}
?>
							<li id="menu-item-200" class="menu-item menu-item-type-post_type menu-item-object-lists menu-item-200"><a href="/lists/us-catalogs/"><?php print _t('Printed catalogs of Spanish drama & comedias sueltas');?></a></li>						
<?php
if($this->request->isLoggedIn()){
?>
							<li class="menu-item menu-item-type-post_type menu-item-object-lists"><?php print caNavLink($this->request, _t("Printer's Marks & Devices"), '', '', 'Pictorials', 'PrintersDevices');?></li>	

<?php
}
?>
							<li class="menu-item menu-item-type-post_type menu-item-object-lists"><?php print caNavLink($this->request, _t('Titles modernized'), '', '', 'Listing', 'ccssusa');?></li>						
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://www.comediassueltasusa.org/other-websites-of-interest/"><?php print _t('Websites of Interest');?></a></li>
						</ul>
					</li>
					<li id="menu-item-206" class="menu-item menu-item-type-post_type_archive menu-item-object-essays menu-item-206"><a href="/essays/"><?php print _t('Essays');?></a></li>
					<li id="menu-item-911" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children current-menu-parent current-menu-ancestor menu-item-911"><a href="#">Zarzuela</a>
						<ul class="sub-menu">
							<li id="menu-item-207" class="menu-item menu-item-type-post_type_archive menu-item-object-news current-menu-item menu-item-207"><a href="/news/">News &amp; Updates</a></li>
							<li id="menu-item-ca1" class="menu-item menu-item-type-post_type menu-item-object-news menu-item-ca1"><?php print caNavLink($this->request, _t('Statistical Table'), '', '', 'About', 'Statistics');?></a></li>
							
						</ul>
					</li>
					
					<li id="menu-item-523" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-ancestor current-menu-parent menu-item-has-children menu-item-523 aboutMenu"><a href="#"><?php print _t('About');?></a>
						<ul class="sub-menu">
							<li id="menu-item-441" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-441"><a href="/about-2/"><?php print _t('About this website');?></a></li> 
							<li id="menu-item-442" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-442"><?php print caNavLink($this->request, _t('Participating Institutions'), '', '', 'Browse', 'collections');?></li>
							<li id="menu-item-445" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-445"><a href="/contributors-and-team/"><?php print _t('Contributors and team');?></a></li>
							<li id="menu-item-445" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-445"><a href="/contact/"><?php print _t('Contact');?></a></li>					
						</ul>
					</li>	
					<!--<li id="menu-item-189" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-189"><a href="/contact/">Contact</a></li>-->
					<li class="divider divider-responsive"></li>
				</ul>
<?php
	}else{
?>
					<li id="menu-item-453" class="menu-item menu-item-type-post_type  current-menu-item  menu-item-object-page menu-item-453"><?php print caNavLink($this->request, _t('Database'), '', '', '', '');?></a></li>
					<li id="menu-item-450" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-450"><a href="/ornaments/"><?php print  _t('Ornaments');?></a></li>
					<li id="menu-item-208" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-ancestor current-menu-parent menu-item-has-children menu-item-208"><a href="#">Recursos</a>
						<ul class="sub-menu">
							<li id="menu-item-410" class="menu-item menu-item-type-post_type menu-item-object-lists menu-item-410"><a href="/lists/about-these-lists/">ACERCA DE ESTOS RECURSOS</a></li>
							<li id="menu-item-444" class="menu-item menu-item-type-post_type menu-item-object-page"><?php print caNavLink($this->request, 'Bibliografia', '', '', 'Listing', 'bibliography');?></li>
							<li id="menu-item-191" class="menu-item menu-item-type-post_type menu-item-object-lists menu-item-191"><?php print caNavLink($this->request, 'CATALOGO DE AUTORIDADES: AUTORES, TRADUCTORES, ADAPTADORES', '', '', 'Listing', 'playwrights'); ?></a></li>
							<li id="menu-item-198" class="menu-item menu-item-type-post_type menu-item-object-lists menu-item-198"><?php print caNavLink($this->request, 'CATALOGO DE AUTORIDADES: IMPRESORES, LIBREROS, LIBRERIAS', '', '', 'Listing', 'printers');?></a></li>
							<li id="menu-item-200" class="menu-item menu-item-type-post_type menu-item-object-lists menu-item-200"><a href="/lists/us-catalogs/">CATALOGOS IMPRESOS DE COLECCIONES DE COMEDIAS Y DE SUELTAS</a></li>						
							<li id="menu-item-444" class="menu-item menu-item-type-post_type menu-item-object-page"><?php print caNavLink($this->request, 'EDICIONES MODERNIZDAS DE COMEDIAS', '', '', 'Listing', 'modern_editions');?></li>
<?php
if($this->request->isLoggedIn()){
?>
							<li class="menu-item menu-item-type-post_type menu-item-object-lists"><?php print caNavLink($this->request, 'ESCUDOS Y MARCAS DE IMPRESORES', '', '', 'Pictorials', 'PrintersDevices');?></li>	
<?php
}
?>
							<li class="menu-item menu-item-type-post_type menu-item-object-lists"><?php print caNavLink($this->request, _t('FECHAS DE IMPRESORES Y LIBREROS'), '', '', 'Listing', 'printers_booksellers_dates');?></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-lists"><?php print caNavLink($this->request, 'GLOSARIO', '', '', 'Listing', 'glossary');?></li>		
<?php
if($this->request->isLoggedIn()){
?>
							<li class="menu-item menu-item-type-post_type menu-item-object-lists"><?php print caNavLink($this->request, 'ILUSTRACIONES', '', '', 'Pictorials', 'Illustrations');?></li>
<?php
}
?>
							<li id="menu-item-199" class="menu-item menu-item-type-post_type menu-item-object-lists menu-item-199"><?php print caNavLink($this->request, 'INSTITUCIONES', '', '', 'Browse', 'collections');?></li>
							<li class="menu-item menu-item-type-post_type menu-item-object-lists"><?php print caNavLink($this->request, 'MISCELÁNEA', '', '', 'Listing', 'miscellanies');?></li>							
<?php
if($this->request->isLoggedIn()){
?>
							<li class="menu-item menu-item-type-post_type menu-item-object-lists"><?php print caNavLink($this->request, 'ORNAMENTOS', '', '', 'Pictorials', 'ornaments');?></li>
<?php
}
?>
							
							<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="https://www.comediassueltasusa.org/other-websites-of-interest/">PAGINAS WEB DE INTERES</a></li>

							<li class="menu-item menu-item-type-post_type menu-item-object-lists"><?php print caNavLink($this->request, 'TITULOS MODERNIZADOS', '', '', 'Listing', 'ccssusa');?></li>						

						</ul>
					</li>
					<li id="menu-item-206" class="menu-item menu-item-type-post_type_archive menu-item-object-essays menu-item-206"><a href="/essays/"><?php print _t('Essays');?></a></li>
					<li id="menu-item-911" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children current-menu-parent current-menu-ancestor menu-item-911"><a href="#">Zarzuela</a>
						<ul class="sub-menu">
							<li id="menu-item-207" class="menu-item menu-item-type-post_type_archive menu-item-object-news current-menu-item menu-item-207"><a href="/news/">Novedades</a></li>
							<li id="menu-item-ca1" class="menu-item menu-item-type-post_type menu-item-object-news menu-item-ca1"><?php print caNavLink($this->request, 'Tabla de Estadistica', '', '', 'About', 'Statistics');?></a></li>
							
						</ul>
					</li>
					
					<li id="menu-item-523" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-ancestor current-menu-parent menu-item-has-children menu-item-523 aboutMenu"><a href="#"><?php print _t('About');?></a>
						<ul class="sub-menu">
							<li id="menu-item-441" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-441"><a href="/about-2/"><?php print _t('About this website');?></a></li> 
							<li id="menu-item-442" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-442"><?php print caNavLink($this->request, _t('Participating Institutions'), '', '', 'Browse', 'collections');?></li>
							<li id="menu-item-445" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-445"><a href="/contributors-and-team/"><?php print _t('Contributors and team');?></a></li>
							<li id="menu-item-445" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-445"><a href="/contact/"><?php print _t('Contact');?></a></li>					
						</ul>
					</li>	
					<!--<li id="menu-item-189" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-189"><a href="/contact/">Contact</a></li>-->
					<li class="divider divider-responsive"></li>
				</ul>	
<?php
	}
?>
			</div>			
		</div>	
		<div class="site_banner_mask"></div>
		<div class="site_banner" style="background:url(/wp-content/uploads/Comedias-Sueltas_01.jpg) no-repeat center center fixed;"></div>
		<div class="language_selector">	
			<ul class="qtranxs_language_chooser" id="qtranslate-chooser">
				<li class="lang-en <?php print ($g_ui_locale == 'en_US') ? 'active' : ''; ?>"><?php print caChangeLocaleLink($this->request, 'en_US', '<span>English</span>', 'qtranxs_text qtranxs_text_en', ['hreflang' => 'en', 'title' => 'English']); ?></li>
				<li class="lang-es <?php print ($g_ui_locale == 'es_ES') ? 'active' : ''; ?>"><?php print caChangeLocaleLink($this->request, 'es_ES', '<span>Espa&ntilde;ol</span>', 'qtranxs_text qtranxs_text_es', ['hreflang' => 'es', 'title' => 'Español']); ?></li>
			</ul>
			<div class="qtranxs_widget_end"></div>
		</div>
		<div class="logo_container">
			<div class="logo_positioner">
				<div class="logo">
					<a href="/"><div class="homeLink"><?php print ($g_ui_locale == 'en_US') ? 'HOME' : 'Inicio'; ?></div><img src="/wp-content/themes/twentyfifteen-child-01/img/sidebarimg.jpg" scale="0" style="border-width: 0px;"></a>
				</div>
				<div class="tagline"></div>
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
							<input type="text" class="form-control" placeholder="<?php print _t('Search Sueltas');?>" name="search">
						</div>
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>
				<ul class="navbar-left navTitle"><li><?php print _t('Search The Database');?></li></ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="mobileNavLink"><?php print caNavLink($this->request, _t("Browse"), "", "", "Browse", "objects"); ?></li>
					<?php print $this->render("pageFormat/browseMenu.php"); ?>	
					<li <?php print (($this->request->getController() == "Browse") && ($this->request->getAction() == "institutions")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Institutions"), "", "", "Browse", "collections"); ?></li>
					<li <?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/objects"); ?></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	</header>
	<div id="content" class="site-content">
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
