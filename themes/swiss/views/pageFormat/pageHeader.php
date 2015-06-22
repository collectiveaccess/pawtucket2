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
?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	
	<script type="text/javascript">window.caBasePath = '<?php print $this->request->getBaseUrlPath(); ?>';</script>

	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print $this->request->config->get('html_page_title'); ?></title>
	
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#browse-menu').on('click mouseover mouseout mousemove mouseenter',function(e) { e.stopPropagation(); });
    	});
	</script>
</head>
<body>
	<nav class="navbar navbar-default yamm" role="navigation">
		<div class="container">
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
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown" style="position:relative;">
						<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span></a>
						<ul class="dropdown-menu">
<?php
			if($this->request->isLoggedIn()){
				print '<li role="presentation" class="dropdown-header">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).', '.$this->request->user->get("email").'</li>';
				print '<li class="divider"></li>';
				print "<li>".caNavLink($this->request, _t('Lightbox'), '', '', 'Lightbox', 'Index', array())."</li>";
				print "<li>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
			} else {	
				print "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>";
				print "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>";
			}
?>
						</ul>
					</li>
					<!--<li class="dropdown">
					<a href="#" class="dropdown-toggle icon" data-toggle="dropdown"><span class="glyphicon glyphicon-unchecked"></span></a>
					<ul class="dropdown-menu">
					<li><a href="#">Action</a></li>
					<li><a href="#">Another action</a></li>
					<li><a href="#">Something else here</a></li>
					<li class="divider"></li>
					<li><a href="#">Separated link</a></li>
					<li class="divider"></li>
					<li><a href="#">One more separated link</a></li>
					</ul>
					</li>-->
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
<?php
						print $this->render("pageFormat/browseMenu.php");
?>	
					<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Gallery"), "", "", "Gallery", "Index"); ?></li>
					<li <?php print ($this->request->getController() == "Contact") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contact"), "", "", "Contact", "Form"); ?></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>

<div id="wrapper">	
	<header id="header">
		<hgroup>
			<a href="http://swiss.whirl-i-gig.com/">
				<img src="http://swissinstitute.net/wp-content/themes/mystile/logo.jpg" id="logo"> 
			</a>
			<div id="tagline">
				<h1 class="site-title">Swiss Institute</h1>
				<h2 class="site-description">CONTEMPORARY ART<br/>NEW YORK</h2>	
			</div>	
		</hgroup>
		<nav id="navigation">
			<ul id="main-nav" class="leftnav">
				<li>
					<a href="http://www.swissinstitute.net/">Home</a>
				</li>	
				<li>
					<a href="http://www.swissinstitute.net/exhibitions">Exhibitions</a>
				</li>		
				<li>
					<a href="http://www.swissinstitute.net/events">Events</a>
				</li>	
				<li>
					<a href="http://www.swissinstitute.net/press">Press</a>
				</li>	
				<li>
					<a href="http://www.swissinstitute.tumblr.com/">Blog</a>
				</li>
				<li>
					<a href="http://www.swissinstitute.net/support">Support</a>
				</li>	
				<li>
					<a href="http://www.swissinstitute.net/benefit-auction">Benefit 2014</a>
				</li>
				<li>
					<a href="http://www.swissinstitute.net/foundations">Foundations</a>
				</li>	
				<li>
					<a href="http://www.swissinstitute.net/sponsors">Sponsors</a>
				</li>	
				<li>
					<a href="http://www.swissinstitute.net/about/visiting-information">About</a>
				</li>	
				<li>
					<a href="http://www.swissinstitute.net/shop/books">Shop</a>
				</li>
			</ul>	
	</header>			
</div>				
				
				
				
			<div class="container" id="mainContent">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
