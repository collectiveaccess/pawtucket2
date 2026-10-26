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
		if (!$this->request->config->get('dont_allow_registration_and_login') || $this->request->config->get('pawtucket_requires_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."</a></li>"; }
		if (!$this->request->config->get('dont_allow_registration_and_login')) { $va_user_links[] = "<li><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'RegisterForm', array())."\"); return false;' >"._t("Register")."</a></li>"; }
	}
	$vb_has_user_links = (sizeof($va_user_links) > 0);

?><!DOCTYPE html>
<html lang="en">
	<head>
	<link rel="icon" href="http://www.seattle.gov/favicon.ico" type="image/x-icon">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?php print MetaTagManager::getHTML(); ?>
	<?php print AssetLoadManager::getLoadHTML($this->request); ?>

	<title><?php print (MetaTagManager::getWindowTitle()) ? MetaTagManager::getWindowTitle() : $this->request->config->get("app_display_name"); ?></title>
	<!-- Global Site Tag (gtag.js) - Google Analytics -->
<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-42479108-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments)};
  gtag('js', new Date());

  gtag('config', 'UA-42479108-1');
</script>
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
	<nav class="navbar navbar-default yamm" role="navigation">
		<div class="container menuBar" style="background-color:#003DA5;">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header" style="width:auto;padding-left:5%" >
<?php
	if ($vb_has_user_links) {
?>
				
<?php
	}
?>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-main-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
<?php
				//print caNavLink($this->request, caGetThemeGraphic($this->request, 'ca_nav_logo300.png'), "navbar-brand", "", "","");
				print '<div class="nav navbar-nav" style="width:auto;padding-left:5px;"><img src="'.__CA_URL_ROOT__.'/themes/default/assets/pawtucket/graphics/seattle_icon.jpg" style="padding-top:5px;padding-bottom:5px;"><a href="'.__CA_URL_ROOT__.'" style="font-family:lato;font-size:21px;font-weight:bold;color:white;padding-left:5px; padding-top:10px;margin-top:60px;">Seattle Municipal Archives Digital Collections</a></div>';
?>
				</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
<?php
	if ($vb_has_user_links) {
?>
			
<?php
	}
?>
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">
<?php
	if ($vb_has_user_links) {
?>
				
<?php
	}
?>
				<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
					<div class="formOutline" style="background-color:white;">
						<div class="form-group" >
							<input type="text" class="form-control" placeholder="Search" name="search">
						</div>
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>
				<ul class="nav navbar-nav navbar-right menuItems" style="font-color:white;">
			
			
				
					<li> <a href="http://www.seattle.gov/cityarchives/about-the-sma" style="color:white;">About</a></li>
					<li> <!--<a href="http://legwina112:8081/" style="color:white;">Go to Finding Aids</a>--></li>
					<li class="dropdown yamm-fw"> <!-- add class yamm-fw for full width-->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:white">Browse</a>
					<ul class="dropdown-menu" id="browse-menu">
						<li class="browseNavFacet">			
							<div class="browseMenuContent container">
	
								<div class="row">
									<div class="mainfacet col-sm-12">
										<ul class="nav nav-pills">			
										</ul>
									</div><!--end main facet-->
								</div>
								<div id="browseMenuTypeFacet" class="row">			
	<div style="padding:25px;">
		
		<ul style="padding-left:5%">
			<h1><!--<a style="padding-right:50px;" href="<?php print __CA_URL_ROOT__?>/index.php/Browse/objects"> All Objects</a> <span class="rwd-line"><br/></span>-->

			<a style="padding-right:50px;" href="<?php print __CA_URL_ROOT__?>/index.php/Search/objects/search/ca_objects.type_id%3A23">Images</a><span class="rwd-line"><br/></span>
			<a style="padding-right:50px;" href="<?php print __CA_URL_ROOT__?>/index.php/Search/objects/search/ca_objects.type_id%3A26">Maps</a><span class="rwd-line"><br/></span>
			
			<a style="padding-right:50px;" href="<?php print __CA_URL_ROOT__?>/index.php/Search/objects/search/ca_objects.type_id%3A25">Textual Records</a><span class="rwd-line"><br/></span>
		
			<a style="padding-right:50px;" href="<?php print __CA_URL_ROOT__?>/index.php/Browse/Collections/facet/type_facet/id/116/view/images">Series</a><span class="rwd-line"><br/></span>
			
			<a style="padding-right:50px;" href="<?php print __CA_URL_ROOT__?>/index.php/Browse/Collections/facet/type_facet/id/2302/view/images">Virtual Collections</a></h1> 
		</ul>
	</div>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#browseMenuFacetSearchInput").on("keyup", function(e) {
			var s = jQuery(this).val().toLowerCase();
			jQuery(".browseMenuFacet div.browseFacetItem").each(function(k, v) {
				var item = jQuery(v).find("a").text().toLowerCase();
				(item.indexOf(s) == -1) ? jQuery(v).hide() : jQuery(v).show();
			});
		}).on("focus click", function(e) { jQuery(this).val("").trigger("keyup"); });
	});
</script>
</div>
							</div><!-- end browseMenuContent container -->		
						</li><!-- end browseNavFacet -->
					</ul> <!--end dropdown-browse-menu -->	
				 </li>
					
					
					
						
					<li ><a href="<?php print __CA_URL_ROOT__?>/index.php/Search/advanced/objects" style="color:white;">Advanced Search</a></li>
					<li ><a href="http://www.seattle.gov/cityarchives" style="color:white;">SMA Home</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<br>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
