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
	$vs_lightbox_section_heading = ucFirst($va_lightboxDisplayName["section_heading"]);
	$vs_lightbox_displayname = ucFirst($va_lightboxDisplayName["singular"]);
	$vs_lightbox_displayname_plural = $va_lightboxDisplayName["plural"];

	# --- collect the user links - they are output twice - once for toggle menu and once for nav
	$vs_user_links = "";
	if($this->request->isLoggedIn()){
		$vs_user_links .= '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
		$vs_user_links .= '<li class="divider nav-divider"></li>';
		if(!$this->request->config->get("disable_lightbox")){
			$vs_user_links .= "<li>".caNavLink($this->request, $vs_lightbox_section_heading, '', '', 'Lightbox', 'Index', array())."</li>";
		}
		$vs_user_links .= "<li>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
		$vs_user_links .= "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		if (!$this->request->config->get('dont_allow_registration_and_login') || $this->request->config->get('pawtucket_requires_login')) { $vs_user_links .= "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Log In")."</a></li>"; }
		if (!$this->request->config->get('dont_allow_registration_and_login')) { $vs_user_links .= "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}

?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<meta name="google-translate-customization" content="6598f6e8856112f-6736157c5190a299-gae5b7c4a187f7a41-13">
	<script type="text/javascript">window.caBasePath = '<?php print $this->request->getBaseUrlPath(); ?>';</script>

	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	<link rel="shortcut icon" href="https://www.911memorial.org/sites/all/themes/national911/favicon.ico" type="image/x-icon" />
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#advancedSearch-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>
<?php
	//
	// Pull in JS and CSS for debug bar
	// 
	if(Debug::isEnabled()) {
		$o_debugbar_renderer = Debug::$bar->getJavascriptRenderer();
		$o_debugbar_renderer->setBaseUrl(__CA_URL_ROOT__.$o_debugbar_renderer->getBaseUrl());
		print $o_debugbar_renderer->renderHead();
	}
?>
</head>
<body>
<div id="off-canvas" class="mm-menu mm-menu_offcanvas mm-menu_keyboardfocus mm-menu_theme-white mm-menu_effect-slide-menu mm-menu_position-right mm-menu_fullscreen mm-menu_pagedim-black" aria-hidden="true"><button class="mm-tabstart" tabindex="0" type="button" aria-hidden="true" role="presentation"></button>
	<nav aria-labelledby="mobile-nav">
		<div class="mm-panels">
			<div id="mm-1" class="mm-panel mm-panel_has-navbar mm-panel_opened"><div id="mobile-u-c-wrapper" class="nav-mobile-custom-wrapper"></div>
			<div class="mm-navbar"><a class="mm-navbar__title">Menu</a><a href="#" onClick="$('#off-canvas').toggle('slide', {direction: 'left'}, 500); return false;" class="close-nav mobile-menu-mm-btn-close" aria-label="Close mobile menu" aria-controls="mobile-menu-item-control" role="button"></a></div>
			<ul class="menu menu-level-0 nav-menu mm-listview" aria-labelledby="site-nav-label">
      			<li class="nav-item menu-item menu-item--expanded mm-listitem">
        			<a href="https://www.911memorial.org/visit" class="nav-link" data-drupal-link-system-path="node/31">Visit</a>
        		</li>
          		<li class="nav-item menu-item menu-item--expanded mm-listitem">
        			<a href="https://www.911memorial.org/learn" class="nav-link" data-drupal-link-system-path="node/76">Learn</a>
        		</li>
          		<li class="nav-item menu-item menu-item--expanded mm-listitem">
        			<a href="https://www.911memorial.org/connect" class="nav-link" data-drupal-link-system-path="node/126">Connect</a>
        		</li>
          		<li class="nav-item menu-item menu-item--expanded mm-listitem">
        			<a href="https://www.911memorial.org/support" class="nav-link" data-drupal-link-system-path="node/81">Support</a>
        		</li>
      		</ul>
      		<div id="mobile-c-wrapper" class="nav-mobile-custom-wrapper"></div></div>
		</div>
	</nav>
	<button class="mm-tabend" tabindex="0" type="button" aria-hidden="true" role="presentation"></button>
</div>
	<header class="header">
		<a href="#main-content" class="visually-hidden focusable skip-link">
		  Skip to main content
		</a>
		<a class="logo" href="/" title="9/11 Memorial | Home" rel="home">9/11 Memorial | Home</a>
		<nav class="nav-main" aria-label="Site">
			<h2 id="site-nav-label" class="sr-only">Site Navigation</h2>
		
			<ul class="menu menu-level-0 nav-menu" data-region="nav" aria-labelledby="site-nav-label">  
				<li class="nav-item menu-item menu-item--expanded">
					<a href="https://www.911memorial.org/visit" class="nav-link" data-drupal-link-system-path="node/31">Visit</a>
				</li>
				<li class="nav-item menu-item menu-item--expanded">
					<a href="https://www.911memorial.org/learn" class="nav-link" data-drupal-link-system-path="node/76">Learn</a>
				</li>
				<li class="nav-item menu-item menu-item--expanded">
					<a href="https://www.911memorial.org/connect" class="nav-link" data-drupal-link-system-path="node/126">Connect</a>
				</li>
				<li class="nav-item menu-item menu-item--expanded">
					<a href="https://www.911memorial.org/support" class="nav-link" data-drupal-link-system-path="node/81">Support</a>
				</li>
			</ul>
		</nav>
		<div id="block-responsivemenumobileicon-2" class="responsive-menu-toggle-wrapper responsive-menu-toggle block block-responsive-menu block-responsive-menu-toggle">
			<a title="Menu" href="#" onClick="$('#off-canvas').toggle('slide', {direction: 'left'}, 500); return false;" id="toggle-icon" class="toggle responsive-menu-toggle-icon" aria-controls="mobile-main-menu" aria-expanded="false" role="button">
				<span class="icon"></span><span class="label">Menu</span>
			</a>
		</div>
	</header>


	
	<nav class="navbar navbar-default navbarSub yamm" role="navigation">
		<div class="container">
			<div class="breadcrumbs">
				<a href="https://www.911memorial.org/museum"><span>«</span>Museum</a><span>/</span><a href="https://www.911memorial.org/collection">Collections</a><span>/</span><?php print caNavLink($this->request, _("Inside the Collection"), "breadcrumbHome", "", "", ""); ?>
			</div>
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
				
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'Objects', array('sort' => 'relevance')); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="search">
						</div>
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>
				<ul class="nav navbar-nav navbar-right">
					<li <?php print ($this->request->getController() == "Front") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Home")."<span>/</span>", "", "", "", ""); ?></li>
					<li <?php print (($this->request->getController() == "Browse") || ($this->request->getController() == "Search")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Browse")."<span>/</span>", "", "", "Browse", "objects", array("sort" => "Most&nbsp;Views")); ?></li>
<?php
						#print $this->render("pageFormat/browseMenu.php");
						#print $this->render("pageFormat/advancedSearchMenu.php");
?>	
					<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Features")."<span>/</span>", "", "", "Gallery", "Index"); ?></li>
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php print _t('My Collection'); ?></a>
						<ul class="dropdown-menu collectionHeaderDD">
<?php
							print $vs_user_links;
?>
						</ul>
					</li>
					<!--<li class="navBarExtras<?php print ($this->request->getController() == "FAQ") ? ' active' : ''; ?>"><?php print caNavLink($this->request, _t("FAQ"), "", "", "FAQ", "Index"); ?></li>
					<li class="navBarExtras<?php print ($this->request->getController() == "Contact") ? ' active' : ''; ?>"><?php print caNavLink($this->request, _t("Ask a Reference Question"), "", "", "Contact", "Form"); ?></li>-->
					<li class="navBarExtras"><a href="#">Museum Home</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>





	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
			<!--<div class="header-social">
				<a class="fb" href="https://www.facebook.com/911memorial" target="_blank"></a>
				<a class="twit" href="https://twitter.com/sept11memorial" target="_blank"></a>
				<a class="instagram" href="https://instagram.com/911memorial/" target="_blank"></a>
				<a class="gplus" href="https://plus.google.com/+911Memorial/posts" target="_blank"></a>
        	</div>-->
