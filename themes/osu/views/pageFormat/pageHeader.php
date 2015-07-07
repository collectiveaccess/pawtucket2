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
	$vs_lightbox_displayname = $va_lightboxDisplayName["singular"];
	$vs_lightbox_displayname_plural = $va_lightboxDisplayName["plural"];
	# --- collect the user links - they are output twice - once for toggle menu and once for nav
	$vs_user_links = "";
	if($this->request->isLoggedIn()){
		$vs_user_links .= '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
		$vs_user_links .= '<li class="divider nav-divider"></li>';
		if(!$this->request->config->get("disable_lightbox")){
			$vs_user_links .= "<li>".caNavLink($this->request, $vs_lightbox_displayname, '', '', 'Lightbox', 'Index', array())."</li>";
		}
		$vs_user_links .= "<li>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
		$vs_user_links .= "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	} else {	
		if (!$this->request->config->get('dont_allow_registration_and_login') || $this->request->config->get('pawtucket_requires_login')) { $vs_user_links .= "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get('dont_allow_registration_and_login')) { $vs_user_links .= "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}

?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	
	<script type="text/javascript">window.caBasePath = '<?php print $this->request->getBaseUrlPath(); ?>';</script>

	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
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
	<div id="masthead">
		<h1 class="masttitle"><a href="http://www.osu.edu/" title="The Ohio State University">The Ohio State University</a></h1>
		<div style="display:none;">|</div>
		<h2 class="masturl"><a href="http://www.osu.edu/" title="The Ohio State University">www.osu.edu</a></h2>
		<div style="display:none;">|</div>
		<form id="mastnavigation" name="gs" method="get" action="http://www.osu.edu/search/index.php">
			<ol>
				<li><a href="http://www.osu.edu/help.php" title="Help">Help</a></li>
				<li><a href="http://www.osu.edu/map/" title="Campus Map">Campus map</a></li>
				<li><a href="http://www.osu.edu/findpeople.php" title="Find people">Find people</a></li>
				<li><a href="https://webmail.osu.edu" title="Webmail">Webmail</a></li>
				<li>
					<div class="label"><label for="search">Search Ohio State</label></div>
					<input class="textfield" type="text" name="searchOSU" value="Search OSU" size="14" accesskey="s" tabindex="1" id="search-field" onfocus="this.value='';">
					<input type="image" name="submit" src='<?php print $this->request->getThemeUrlPath();?>/assets/pawtucket/graphics/go_button.gif' accesskey="return" tabindex="2" alt="Submit">
				</li>
			</ol>
			<input value="date:D:L:d1" name="sort" type="hidden">
			<input value="xml_no_dtd" name="output" type="hidden">
			<input value="UTF-8" name="ie" type="hidden">
			<input value="UTF-8" name="oe" type="hidden">
			<input value="default_frontend" name="client" type="hidden">
			<input value="default_frontend" name="proxystylesheet" type="hidden">
			<input value="default_collection" name="site" type="hidden">
		</form>
		<br class="clearall">
	</div>
	<div id="header">
		<a href="/" title="Return to Home Page" id="logoCsuri"></a><br>
		<a href="http://arts.osu.edu" title="OSU The College of the Arts" id="logoSub"></a><br>
		<a href="http://accad.osu.edu" title="The Advanced Computing Center for Arts and Design" id="logoSub2"></a>
	</div>	
	<nav class="navbar navbar-default yamm" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle navbar-toggle-user" data-toggle="collapse" data-target="#user-navbar-toggle">
					<span class="sr-only">User Options</span>
					<span class="glyphicon glyphicon-user"></span>
				</button>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
			<div class="collapse navbar-collapse" id="user-navbar-toggle">
				<ul class="nav navbar-nav">					
<?php
							print $vs_user_links;
?>
				</ul>
			</div>
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right" id="user-navbar">
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span></a>
						<ul class="dropdown-menu">
<?php
							print $vs_user_links;
?>
						</ul>
					</li>
				</ul>
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="search">
						</div>
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>
				<ul class="nav navbar-nav navbar-right">
					<li <?php print ($this->request->getController() == "Front") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Home"), "", "", "", ""); ?></li>				
					<li <?php print (($this->request->getController() == "About") && ($this->request->getAction() == "Index")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About"), "", "", "About", "Index"); ?></li>
<?php
						print $this->render("pageFormat/browseMenu.php");
?>	
					<li <?php print ($this->request->getAction() == "explore") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Browse"), "", "", "About", "explore"); ?></li>

					<li <?php print ($this->request->getAction() == "arthistory") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Art History"), "", "", "About", "arthistory"); ?></li>
					<li <?php print ($this->request->getAction() == "biography") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Biography"), "", "", "About", "biography"); ?></li>

					<li <?php print ($this->request->getAction() == "contact") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contact"), "", "", "About", "contact"); ?></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
