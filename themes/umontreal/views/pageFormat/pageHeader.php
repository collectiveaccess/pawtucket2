<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2020 Whirl-i-Gig
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
		$va_user_links[] = "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		if (!$this->request->config->get('dont_allow_registration_and_login') || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get('dont_allow_registration_and_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
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
<body>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <div class="logo-section" style="display:inline-block;line-height: 0.9em;margin-top: 15px;">
				<a href="/"><img class="img-responsive" src="/themes/umontreal/assets/pawtucket/graphics/logo-collection-ethno.png"></a>
			</div>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		
		<div class="nav navbar-nav navbar-right">
		  <ul class="nav navbar-nav navbar-menus">
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">À propos <span class="caret"></span></a>
			  <ul class="dropdown-menu">
				<li class="element_menu"><?php print caNavLink($this->request, "Présentation", "", "", "About", "Le_laboratoire"); ?></li>														
				<li class="element_menu" ><?php print caNavLink($this->request, "Activités", "", "", "About", "Enseignement"); ?></li>
				<li class="element_menu"><?php print caNavLink($this->request, "Partenaires", "", "", "About", "Partenaires"); ?></li>
				<li class="element_menu"><?php print caNavLink($this->request, "Nous joindre", "", "", "About", "Contact"); ?></li>
			  </ul>
			</li>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Collections <span class="caret"></span></a>
			  <ul class="dropdown-menu">
				<li class="element_menu"><?php print caNavLink($this->request, "Présentation", "", "", "About", "Collections"); ?></li>
				<li class="element_menu"><?php print caNavLink($this->request, "Recherche", "", "", "Browse", "objets"); ?></li>
			  </ul>
			</li>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Explorer <span class="caret"></span></a>
			  <ul class="dropdown-menu">
				<li class="element_menu"><?php print caNavLink($this->request, "Expositions", "", "", "Browse","occurrences"); ?></li>
				<li class="element_menu"><?php print caNavLink($this->request, "Parcours", "", "", "Gallery","Index"); ?></li>
				<li class="element_menu"><?php print caNavLink($this->request, "Education", "", "", "Education","Index"); ?></li>
			  </ul>
			</li>
		  </ul>
		  <ul class="nav navbar-nav nav navbar-nav navbar-right" id="user-navbar">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><img src="/themes/umontreal/assets/pawtucket/graphics/petro.png" style="height:48px;width:auto;"/></a>
				<ul class="dropdown-menu"><?php print join("\n", $va_user_links); ?></ul>
			</li>
		</ul>
		  <form class="navbar-form navbar-right navbar-search" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'objets'); ?>">
			<div class="formOutline">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Rechercher dans la collection" style="width: 200px;" name="search">
				</div>
				<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
			</div>
		</form>
	</div>
		</div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
	
	
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>