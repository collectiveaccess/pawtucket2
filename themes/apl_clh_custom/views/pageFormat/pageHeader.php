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
	$vs_current_page = $this->request->getController();
	$ca_home_link = caNavLink($this->request, _t("Community Archives"), "", "", "", ""); 
	$ca_about_link = caNavLink($this->request, _t("About"), "", "", "About", "Index");
	$ca_browse_link = caNavLink($this->request, _t("Browse"), "", "", "Browse", "Collections", array('view' => 'list'));
	$ca_search_link = caNavLink($this->request, _t("Search"), "", "", "Search", "advanced/objects");

	$va_lightbox_display_name = caGetLightboxDisplayName();
	$vs_lightbox_display_name = ucFirst($va_lightbox_display_name["singular"]);
	$vs_lightbox_display_name_plural = $va_lightbox_display_name["plural"];
	# --- collect the user links - they are output twice - once for toggle menu and once for nav
	$vs_user_links = "";
	if($this->request->isLoggedIn()){
		$vs_user_links .= '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
		$vs_user_links .= '<li class="divider nav-divider"></li>';
		if(!$this->request->config->get("disable_my_collections")){
			$vs_user_links .= "<li>".caNavLink($this->request, $vs_lightbox_display_name, '', '', 'Sets', 'Index', array())."</li>";
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

</head>
<body>
	<div id="tophat">
		<a title="arlington county web site link" href="http://www.arlingtonva.us"></a>
	</div>
	<nav class="navbar navbar-inverse yamm" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				
				<!-- <button type="button" class="navbar-toggle navbar-toggle-user" data-toggle="collapse" data-target="#user-navbar-toggle">
					<span class="sr-only">User Options</span>
					<span class="glyphicon glyphicon-user"></span>
				</button> -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand navbar-right" id="apl-banner" href="http://library.arlingtonva.us">
					<img src="/themes/apl_clh_custom/assets/pawtucket/graphics/arlpl.png"></img>
				</a>

<?php
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'clhheader.png'), "navbar-brand", "", "","");
?>
			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
			<!-- <div class="collapse navbar-collapse" id="user-navbar-toggle">
				<ul class="nav navbar-nav">					
<?php
							print $vs_user_links;
?>
				</ul>
			</div> -->
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
				<!--<ul class="nav navbar-nav navbar-right" id="user-navbar">
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span></a>
						<ul class="dropdown-menu">
<?php
							print $vs_user_links;
?>
						</ul>
					</li>
				</ul>-->

				<ul class="nav navbar-nav navbar-right">
					<li <?php print ($this->request->getController() == "About") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About"), "", "", "About", "Index"); ?></li>
<?php
						//print $this->render("pageFormat/browseMenu.php");
?>						
					<li <?php print ($this->request->getController() == "Browse") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Browse"), "", "", "Browse", "Collections", array('view' => 'list')); ?></li>
					<li <?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/objects"); ?></li>
					
					<!-- <li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Gallery"), "", "", "Gallery", "Index"); ?></li>
					<li <?php print ($this->request->getController() == "Contact") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contact"), "", "", "Contact", "Form"); ?></li> -->
				</ul>
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Search Arlington History" name="search">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
						</span>
					</div>					
				</form>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
<?php
	# --- display breadcrumb trail on interior pages
	$breadcrumb_link = '';
	if ($vs_current_page === "Front"){
		$breadcrumb_link = '<li class="active">' . $ca_home_link . '</li>';
	} elseif ($vs_current_page === "About") {
		$breadcrumb_link = '<li>' . $ca_home_link . '</li>' . '<li class="active">' . $ca_about_link . '</li>';
	} elseif ($vs_current_page === "Browse"){
		$breadcrumb_link = '<li>' . $ca_home_link . '</li>' . '<li class="active">' . $ca_browse_link . '</li>';
	} elseif ($vs_current_page === "Search") {
		$breadcrumb_link = '<li>' . $ca_home_link . '</li>' . '<li class="active">' . $ca_search_link . '</li>';
	} else {
		$breadcrumb_link = '<li>' . $ca_home_link . '</li>' . '<li class="active"><a href="#">' . $vs_current_page . '</a></li>';
	}
?>		
	<div class="container">
		<ol class="breadcrumb">
			<li><a href="http://library.arlingtonva.us/">Home</a></li>
			<?php print $breadcrumb_link; ?>
		</ol>
	</div>		
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
