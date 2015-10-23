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
	# --- collect the user links - they are output twice - once for toggle menu and once for nav
	$vs_user_links = "";
	if($this->request->isLoggedIn()){
		$vs_user_links .= '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
		$vs_user_links .= '<li class="divider nav-divider"></li>';
		$vs_user_links .= "<li>".caNavLink($this->request, _t('Lightbox'), '', '', 'Lightbox', 'Index', array())."</li>";
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
<?php
				#print caNavLink($this->request, caGetThemeGraphic($this->request, 'ca_nav_logo300.png'), "navbar-brand", "", "","");
?>
			<span class='navbar-brand'><?php print caNavLink($this->request, "School of Visual Arts <span class='red'>Exhibition Archive</span>", '', '', '', '');?></span>
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
					<li class="dropdown" style="position:relative; display: none">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span></a>
						<ul class="dropdown-menu">
<?php
							print $vs_user_links;
?>
						</ul>
					</li>
					<li>
						<?php print caNavLink($this->request, "<i class='fa fa-ellipsis-h'></i>", "", "", "Search/advanced", "objects"); ?>
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

			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
			<div class="row">
				<div class="col-sm-8">
				<ul class='svaMenu'>
				<li>BROWSE...<li>
				<li <?php print ($this->request->getAction() == 'objects' ? 'class="active"': ""); ?>>
					<?php print caNavLink($this->request, "Objects", "", "", "Browse", "objects"); ?>
				</li>
				<li <?php print ($this->request->getAction() == 'entities' ? 'class="active"': ""); ?>>
					<?php print caNavLink($this->request, "People", "", "", "Browse", "entities"); ?>
				</li>
				<li <?php print ($this->request->getAction() == 'departments' ? 'class="active"': ""); ?>>
					<?php print caNavLink($this->request, "Departments", "", "", "Browse", "departments"); ?>
				</li>	
				<li <?php print ($this->request->getAction() == 'exhibitions' ? 'class="active"': ""); ?>>
					<?php print caNavLink($this->request, "Exhibitions", "", "", "Browse", "exhibitions"); ?>
				</li>
				<li <?php print ($this->request->getController() == 'Collection' ? 'class="active"': ""); ?>>
					<?php print caNavLink($this->request, "Finding Aid", "", "FindingAid", "Collection", "Index"); ?>
				</li>							
<?php
						#print $this->render("pageFormat/browseMenu.php");
?>	

				</ul>	
				</div>
				<div class="col-sm-3 col-sm-offset-1">
							<h2 class='about'><?php print caNavLink($this->request, _t("About the archives"), "", "", "About", "Index"); ?></h2>
				</div>
			</div><!-- end row -->
