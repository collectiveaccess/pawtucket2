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
	# --- collect the user links - they are output twice - once for toggle menu and once for nav
	$va_user_links = $va_responsive_login_form = array();
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
	    $va_responsive_login_form = null;
	} else {	
		$va_user_links[] = "<li><form class='LoginFormMenu' action='".caNavUrl($this->request, "", "LoginReg", "login")."' class='form-vertical' role='form' method='POST'><H1>Login</H1><div class='form-group'><label for='username' class='control-label'>Username</label><input type='text' class='form-control input-sm' name='username'></div><div class='form-group'><label for='password' class='control-label'>Password</label><input type='password' name='password' class='form-control input-sm' /></div><div class='form-group'><button type='submit' class='btn btn-default'>login</button></div></form></li>";
		$va_responsive_login_form[] = "<li><form id='LoginFormMenu' action='".caNavUrl($this->request, "", "LoginReg", "login")."' class='form-vertical' role='form' method='POST'><H1>Login</H1><div class='form-group'><label for='username_resp' class='control-label'>Username</label><input type='text' class='form-control input-sm' id='username_resp' name='username'></div><div class='form-group'><label for='password_resp' class='control-label'>Password</label><input type='password' name='password' class='form-control input-sm' id='password_resp' /></div><div class='form-group'><button type='submit' class='btn btn-default'>login</button></div></form></li>";
		
		#$va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>";	
		$va_user_links[] = $va_responsive_login_form[] = "<li>".caNavLink($this->request, _t('Forgot Password?'), '', '', 'LoginReg', 'resetForm')."</li>";
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<!-- Google Fonts embed code -->
	<script type="text/javascript">
		(function() {
			var link_element = document.createElement("link"),
				s = document.getElementsByTagName("script")[0];
			if (window.location.protocol !== "http:" && window.location.protocol !== "https:") {
				link_element.href = "http:";
			}
			link_element.href += "//fonts.googleapis.com/css?family=News+Cycle:400,700";
			link_element.rel = "stylesheet";
			link_element.type = "text/css";
			s.parentNode.insertBefore(link_element, s);
		})();
	</script>
	<script type="text/javascript" async src="https://platform.twitter.com/widgets.js"></script>	
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
	<div class="container-fluid" role="navigation">
	<div class="collapse navbar-collapse" id="header-nav-collapse">
		<div id="headerbar" class="yamm">
			<div class="navbar navbar-default">
				<ul class="nav navbar-nav">
				  <li><span class="skip"><a href="#main">Skip to main content</a></span></li>
				  <li><a href="/?current_theme=fic" id="fic-header" alt="Dragonfly Logo"><?php print caGetThemeGraphic($this->request, 'idp_logo_header_gold.png', array("alt" => "DragonFly Logo")); ?> <span class="header_text">Fossil Insect Collaborative</span></a></li>
				  <li><a href="/?current_theme=idigpaleo" id="idp-header" alt="Bird Fossil Logo"><?php print caGetThemeGraphic($this->request, 'idp_logo_header_alt.png',  array("alt" => "Bird Fossil Logo")); ?> <span class="header_text">iDigPaleo</span></a></li>
				  <li><a href="/?current_theme=cretaceous_world" id="cw-header" alt="Cretacean Fossil Logo"><?php print caGetThemeGraphic($this->request, 'cw_logo_header.png',  array("alt" => "Cretacean Fossil Logo")); ?> <span class="header_text">Cretaceous World</span></a></li>
				  <li><a href="/?current_theme=florissant" id="flfo-header" alt="Plant Fossil Logo"><?php print caGetThemeGraphic($this->request, 'flfo_logo_header.png',  array("alt" => "Plant Fossil Logo")); ?> <span class="header_text">Florissant Fossil Beds</span></a></li>
				</ul>
			</div>
		</div>
		</div>
		<script>
			$('#headerbar > .navbar-collapse > .nav > li').hover(function(){
				$(this).html();
			});
		</script>
	</div>
	<div class="container"><div class="navHeader" role="banner">
<?php
				print caNavLink($this->request, caGetThemeGraphic($this->request, 'fic_header.png', array("alt" => "Fossil Insect Collaborative")), "header-img", "", "", "", "", array("alt" => "Fossil Insect Collaborative")) ;
?>		
	</div><!-- end navHeader --></div><!-- end container -->
	<div class="container">
		<nav class="navbar navbar-default yamm" role="navigation">
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
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#header-nav-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="fa fa-university" aria-label="other sites"></span>
				</button>
			</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
<?php
	if ($vb_has_user_links) {
?>
			<div class="collapse navbar-collapse" id="user-navbar-toggle">
				<ul class="nav navbar-nav">					
<?php
							print join("\n", $va_user_links);
?>
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
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown" aria-label="User Login"><span class="glyphicon glyphicon-user"></span></a>
						<ul class="dropdown-menu">
<?php
							print join("\n", is_array($va_responsive_login_form) ? $va_responsive_login_form : $va_user_links);
?>
						</ul>
					</li>
				</ul>
<?php
	}
?>
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'objects'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" aria-label="Search" name="search">
						</div>
						<button type="submit" aria-label="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>
				<ul class="nav navbar-nav">
<?php
						#print $this->render("pageFormat/browseMenu.php");
?>	
					<li <?php print ($this->request->getController() == "Browse") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Browse"), "", "", "Browse", "objects"); ?></li>
					<li <?php print (($this->request->getController() == "About") && ($this->request->getAction() == "Index")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("About"), "", "", "About", "Index"); ?></li>
					<li <?php print ($this->request->getAction() == "Register") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Register"), "", "", "LoginReg", "RegisterForm"); ?></li>
					<li <?php print ($this->request->getAction() == "Educators") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Educators"), "", "", "About", "Education"); ?></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>
	</div><!-- end container -->
	<div class="container">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
