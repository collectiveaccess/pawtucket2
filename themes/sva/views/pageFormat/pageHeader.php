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
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $vs_user_links .= "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login'])) { $vs_user_links .= "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
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
<!--
        <link rel="stylesheet" href="http://svaca.sva.edu/ca_new/pawtucket/themes/sva/assets/pawtucket/css/reset.css">
-->
		<link rel='stylesheet' href='http://svaca.sva.edu/ca_new/pawtucket/themes/default/assets/pawtucket/css/Font-Awesome/css/font-awesome.css' type='text/css' media='all'/>
		<link type="text/css" rel="stylesheet" href="http://fast.fonts.net/cssapi/08d66479-d029-4b18-b2e5-1459df4ebe21.css"/>
        <link rel="stylesheet" href="http://svaca.sva.edu/ca_new/pawtucket/themes/sva/assets/pawtucket/css/main.css">
		<script type="text/javascript" src="http://svaca.sva.edu/ca_new/pawtucket/themes/sva/assets/sva.js"></script>


</head>
<body id="index">
	<div class="container">

        <div id="header" class="">
			<ul class="nav nav-tabs hidden-xs">
				<li class="active"><a href="#">Glaser Archives</a></li> 
				<li><a href="http://svaarchives.org/">SVA Archives</a></li> 
				
				<li class="navbar-right" id="social-bar">
					<i onclick="window.location='http://twitter.com/glaserarchives'" class="fa fa-twitter  fa-lg"></i>
					<i onclick="window.location='http://instagram.com/glaserarchives'" class="fa fa-instagram  fa-lg"></i>
					<i onclick="window.location='http://www.flickr.com/photos/mgdsca/albums'" class="fa fa-flickr  fa-lg"></i>
					<i onclick="doSearch();'" class="fa fa-search fa-lg"></i></a>
				</li>	

			</ul>


        </div>

        <div id="main">
            
            <div class="wrapper">



	
<!--			<div class="row">
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
				</div> -->
	<!--			<div class="col-sm-3 col-sm-offset-1">
							<h2 class='about'><?php print caNavLink($this->request, _t("About the archives"), "", "", "About", "Index"); ?></h2>
				</div> -->
			</div><!-- end row -->
