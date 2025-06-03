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
	if ($this->request->getController() == "Front") {
		$vs_body_class = 'class="noMargin"';
	}

?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>
	<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>

    <link rel="stylesheet" type="text/css" href="<?php print $this->request->getAssetsUrlPath(); ?>/mirador/css/mirador-combined.css">
    
<!-- Google Tag Manager --> <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src= 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f); })(window,document,'script','dataLayer','GTM-W8XHQQD');</script>
<!-- End Google Tag Manager -->
</head>
<body <?php print $vs_body_class;?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W8XHQQD" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> <!-- End Google Tag Manager (noscript) -->
<?php
	if ($this->request->getController() != "Front") {
?>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<div class="row">
				<div class="col-sm-1"></div>
				<div class="col-sm-10">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">

				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
<?php
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'logo-onwhite.png'), "navbar-brand", "", "","");

?>
			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->

			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
				<div class="navbar-right">
					<div class="menuRight"><?php print caNavLink($this->request, _t("Guide to Entries"), "", "", "About", "notes"); ?></div>									
					<div class="menuRight"><?php print caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/artworks"); ?></div>
					<div id="searchDiv">
						<form class="navbar-form"  role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
							<div class="formOutline">
								<div class="form-group">
									<div class='leftGlass'><?php print caGetThemeGraphic($this->request, 'search.png'); ?></div>
									<input type="text" class="form-control" placeholder="" name="search" autocomplete="off" />
								</div>
								<button type="submit" class="btn-search">Search</button>
							</div>
						</form>
					</div>
					<div id="searchToggle"><?php print caGetThemeGraphic($this->request, 'search.png');?></div>
				</div>
				<script type="text/javascript">
					$('#searchToggle').click(function(){ 
						if($('#searchDiv').css('display') === 'block') {
							
							$('#searchDiv').fadeOut(300);
							$('.nav.navbar-nav').fadeIn(300);
							$('#searchToggle').html("<?php print caGetThemeGraphic($this->request, 'search.png'); ?>");
						} else {
							if (window.innerWidth > 1126) {
								$('.nav.navbar-nav').fadeOut(300);
							}
							$('#searchDiv').fadeIn(300);
							$('#searchToggle').html("<?php print caGetThemeGraphic($this->request, 'close.png'); ?>");						
						}
					});

				</script>
				<ul class="nav navbar-nav">
					<li <?php print ((($this->request->getController() == "Detail") | ($this->request->getController() == "Browse") | ($this->request->getController() == "Search")) && (($this->request->getAction() != "advanced"))) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Catalog"), "", "", "Browse", "artworks"); ?></li>				
					<li <?php print (($this->request->getController() == "About") && ($this->request->getAction() == "Index")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Artist"), "", "", "About", "Index"); ?></li>
					<li <?php print (($this->request->getController() == "About") && ($this->request->getAction() == "commentary")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Essays"), "", "", "About", "commentary"); ?></li>
					<li class='collapseLink <?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'active' : ''; ?>'><?php print caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/artworks"); ?></li>
					<li class='collapseLink <?php print (($this->request->getController() == "About") && ($this->request->getAction() == "notes")) ? 'active' : ''; ?>'><?php print caNavLink($this->request, _t("Guide to Entries"), "", "", "About", "notes"); ?></li>					
					<li class='collapseSearch'>
						<form class="navbar-form"  role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
							<div class="formOutline">
								<div class="form-group">
									<div class='leftGlass'><?php print caGetThemeGraphic($this->request, 'search.png'); ?></div>
									<input type="text" class="form-control" placeholder="" name="search">
								</div>
								<button type="submit" class="btn-search">Search</button>
							</div>
						</form>
					</li>		
					<!--<li class="dropdown compare_menu_item" style='display: none;' >
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Compare <span class="caret"></span></a>
					  <ul class="dropdown-menu">
						
					  </ul>
					</li> -->
					
					
				</ul>
			</div><!-- /.navbar-collapse -->
			</div>
			<div class="col-sm-1"></div>
			</div>
		</div><!-- end container -->
	</nav>
<?php
	} else {
?>		
	<nav class="navbar front navbar-default" role="navigation">
		<div class="container">
			<div class="row">
				<div class="col-sm-1"></div>
				<div class="col-sm-10">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">

				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->

			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
				<div class="navbar-right">
					<div id="searchDiv">
						<form class="navbar-form"  role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
							<div class="formOutline">
								<div class="form-group">
									<div class='leftGlass'><?php print caGetThemeGraphic($this->request, 'search.png'); ?></div>
									<input type="text" class="form-control" placeholder="" name="search">
								</div>
								<button type="submit" class="btn-search">Search</button>
							</div>
						</form>
					</div>
					<div id="searchToggle"><?php print caGetThemeGraphic($this->request, 'search.png');?></div>
				</div>
				<script type="text/javascript">
					$('#searchToggle').click(function(){ 
						if($('#searchDiv').css('display') === 'block') {
							$('#searchDiv').fadeOut(300);
							if (window.innerWidth > 1120) {
								$('.nav.navbar-nav').fadeIn(300);
							}
							$('#searchToggle').html("<?php print caGetThemeGraphic($this->request, 'search.png'); ?>");
						} else {
							if (window.innerWidth > 1120) {
								$('.nav.navbar-nav').fadeOut(300);
							}
							$('#searchDiv').fadeIn(300);
							$('#searchToggle').html("<?php print caGetThemeGraphic($this->request, 'close.png'); ?>");						
						}
					});

				</script>
				<ul class="nav navbar-nav">
					<li <?php print ((($this->request->getController() == "Browse") | ($this->request->getController() == "Search")) && (($this->request->getAction() != "advanced"))) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Catalog"), "", "", "Browse", "artworks"); ?></li>				
					<li <?php print (($this->request->getController() == "About") && ($this->request->getAction() == "Index")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Artist"), "", "", "About", "Index"); ?></li>
					<li <?php print (($this->request->getController() == "About") && ($this->request->getAction() == "commentary")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Essays"), "", "", "About", "commentary"); ?></li>
				
					<!--<li class="dropdown compare_menu_item" style='display: none;' >
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Compare <span class="caret"></span></a>
					  <ul class="dropdown-menu">
						
					  </ul>
					</li> -->
					
					
				</ul>
			</div><!-- /.navbar-collapse -->
			</div>
			<div class="col-sm-1"></div>
			</div>
		</div><!-- end container -->
	</nav>
<?php	
	}
?>	
	<div class="container first"><div class="row first"><div class="col-xs-12 first">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
