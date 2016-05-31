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
	<link rel="icon" href="<?php print caGetThemeGraphicURL($this->request, 'favicon.png'); ?>">
	<script type="text/javascript">window.caBasePath = '<?php print $this->request->getBaseUrlPath(); ?>';</script>
	<link href='http://fonts.googleapis.com/css?family=Gudea:400,700,400italic' rel='stylesheet' type='text/css'>
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print strip_tags(MetaTagManager::getWindowTitle()); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>
  <script>
	  $(function() {
		$( "#entityTable" ).tabs();
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
	<div id="mainContent">
	<div id="headerArea">
		<div id="logoArea">
			<div id="site-filagree"></div>
			<div id="site-logo">
				<div id="logo1"></div>
				<div id="logoMain"><a href="http://www.nysoclib.org">The New York Society Library</a></div>
			</div>
			<form class="navbar-form navbar-right" id="colSearch" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
				<div class="formOutline">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search Digital Collections" name="search">
					</div>
					<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
				</div>
			</form>
		</div>
		
		<div id="columnRight">
			<div class="topMain">
				<div id="searchArea" class="searchArea" style="display: block;">
					<div class="globalLinks"><a href="http://nysoclib.org/about/join-mailing-list">Join the Mailing List</a> | Find us on <a href="http://www.facebook.com/nysoclib" class="sbIcon facebook" target="_blank">Facebook</a> <a href="http://twitter.com/#!/nysoclib" class="sbIcon twitter" target="_blank">Twitter</a></div>
					<div id="globalSearch">
						<!--<form class="navbar-form navbar-right" id="colSearch" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
							<div class="formOutline">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Search Digital Collections" name="search">
								</div>
							</div>		
						</form>-->
					</div>
				</div>
			</div>
			<div id="topMenu">
				<nav class="navbar navbar-default yamm" role="navigation">
				<ul class="menu" id="mainMenu">
					<li class="item" id="menuId-1"><a href="https://www.nysoclib.org/">Library Home</a></li>
					<li <?php print ($this->request->getController() == "Front") ? 'class="active item"' : 'class="item"'; ?> id="menuId-2"><?php print caNavLink($this->request, _t("City Readers Home"), "", "", "", ""); ?></li>
					
<?php
					print $this->render("pageFormat/browseMenu.php");
?>		
					<li <?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active item"' : 'class="item"'; ?> id="menuId-4"><?php print caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/objects"); ?></li>
			
					<li <?php print ($this->request->getController() == "Gallery") ? 'class="active item"' : 'class="item"'; ?> id="menuId-5"><?php print caNavLink($this->request, _t("Featured"), "", "", "Gallery", "Index"); ?></li>
					<li <?php print ($this->request->getController() == "Collection") ? 'class="active item"' : 'class="item"'; ?> id="menuId-6"><?php print caNavLink($this->request, _t("Finding Aids"), "", "FindingAid", "Collection", "Index"); ?></li>
					
					<li <?php print (($this->request->getController() == "About") && ($this->request->getAction() == "Index")) ? 'class="active item"' : 'class="item"'; ?> id="menuId-7"><?php print caNavLink($this->request, _t("About this Project"), "", "", "About", "Index"); ?></li>
					<li <?php print (($this->request->getController() == "About")  && ($this->request->getAction() == "userguide"))? 'class="active item"' : 'class="item"'; ?> id="menuId-8"><?php print caNavLink($this->request, _t("User Guide"), "", "", "About", "userguide"); ?></li>
					
					
				</ul>
				</nav>
			</div>	
			<div id="topSection">
				<div id="pageTitle">
					<h1>City Readers <span class='headerSmall'>Digital Historic Collections at the New York Society Library</span></h1>					
					<div class="breadcrumb"><?php print MetaTagManager::getWindowTitle(); ?></div>
				</div>
			</div>		
		</div><!-- end columnRight-->
		<div class="rightMenu">
			<!--<form class="navbar-form navbar-right" id="colSearch" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
				<div class="formOutline">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search Digital Collections" name="search">
					</div>
					<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
				</div>
				<ul class="nav navbar-nav navbar-right" id="user-navbar">
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span></a>
						<ul class="dropdown-menu">

							print $vs_user_links;

						</ul>
					</li>
				</ul>				
			</form>-->
		</div>	
	</div><!-- end headerArea-->
	<div style="clear:both;"></div>
	<div class="container" >
	<div class="row">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
