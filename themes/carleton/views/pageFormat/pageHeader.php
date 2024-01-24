<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2017 Whirl-i-Gig
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
	<div id="skipNavigation"><a href="#main">Skip to main content</a></div>
<?php
	# --- if installed on apps.carleton.edu, change to echo file_get_contents(WEB_PATH . ‘/global_stock/bb/html/bluebar.html’);
	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_URL, "https://apps.carleton.edu/global_stock/bb-external/html/bluebar.html");
	print curl_exec($curl);
?>
<div id="bannerAndMeat" class="banner-and-meat">
	<header id="banner" role="banner" aria-label="site" class="banner--columns banner--background banner--overlay__blue banner--logo">
		<div class="banner__bg-img" role="img" aria-label="Langston Hughes"></div>
		<div class="banner__primary-content">
			<div class="site-name-wrapper">
				<div class="site-name site-name--logo"><a href="https://www.carleton.edu/library/"><span><picture>
					<source srcset="<?php print caGetThemeGraphicUrl($this->request, 'Gould-Library-logo-white.png'); ?>?resize=761,128&amp;crop=0,0,100,99 2x, <?php print caGetThemeGraphicUrl($this->request, 'Gould-Library-logo-white.png'); ?>?resize=380,64&amp;crop=0,0,99,100 1x">
					<?php print caGetThemeGraphic($this->request, 'Gould-Library-logo-white.png', array("alt" => "Gould Library", "role" => "banner")); ?><!-- height 64px -->
					</picture></span></a>
				</div>
			</div>
			<div class="pageTitleWrap">
				<h1 class="pageTitle"><div class="pageTitle--Main"><a href="https://www.carleton.edu/library/collections/archives/">Carleton College Archives</a></div></h1>
			</div>
		</div>
	</header>
</div>


	<nav class="navbar navbar-default yamm" role="navigation">
		<div class="container menuBar">
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
			<!-- bs-user-navbar-collapse is the user menu that shows up in the toggle menu - hidden at larger size -->
			<div class="collapse navbar-collapse" id="bs-main-navbar-collapse-1">				
				<ul id="topNavigation" class="nav navbar-nav menuItems" role="list" aria-label="<?php print _t("Primary Navigation"); ?>">
					<li <?php print ($this->request->getController() == "Front") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Home"), "", "", "", ""); ?></li>
					<?php print $this->render("pageFormat/browseMenu.php"); ?>	
					<li <?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/collections"); ?></li>
					<!--<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Gallery"), "", "", "Gallery", "Index"); ?></li>-->
					<li <?php print ($this->request->getController() == "Contact") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Contact"), "", "", "Contact", "Form"); ?></li>
					<li><a href="<?php print ($vs_guide_link = $this->getVar("guide_link")) ? $vs_guide_link : "https://www.carleton.edu/library/collections/archives/database-user-guide/"; ?>"><?php print _t("Guide"); ?></a></li>
					<li>
						<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" aria-label="<?php print _t("Search"); ?>">
							<div class="formOutline">
								<div class="form-group">
									<input type="text" class="form-control" id="headerSearchInput" placeholder="Search" name="search" autocomplete="off" aria-label="<?php print _t("Search text"); ?>" />
								</div>
								<button type="submit" class="btn-search" id="headerSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit"); ?>"></span></button>
							</div>
						</form>
						<script type="text/javascript">
							$(document).ready(function(){
								$('#headerSearchButton').prop('disabled',true);
								$('#headerSearchInput').on('keyup', function(){
									$('#headerSearchButton').prop('disabled', this.value == "" ? true : false);     
								})
							});
						</script>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div role="main" id="main"><div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
