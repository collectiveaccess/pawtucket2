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
	<link href="http://fonts.googleapis.com/css?family=Gudea:400,400italic,700" rel="stylesheet" type="text/css">
	
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
	<div class="headerContainer">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-10">
<?php
					print "<div class='headerTitle'>".caNavLink($this->request, caGetThemeGraphic($this->request, 'hgsh_title2.png', array('title' => _t('Hampstead Garden Suburb Heritage'))), "", "", "","")."</div>";
?>		
				</div><!-- end col -->
				<div class="col-sm-2">
					<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
						<div class="formOutline">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Search this site" name="search">
							</div>
							<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
						</div>
					</form>
				</div><!-- end col -->
			</div><!-- end row -->
		</div><!-- end container -->
	</div><!-- end headerContainer -->
	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="search">
						</div>
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>
				
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
				<ul class="nav navbar-nav">
					<li <?php print ($this->request->getController() == "Front") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Home"), "", "", "", ""); ?></li>
					<li><a href="<?php print $this->request->config->get("site_host"); ?>/wordpress/index.php/about/"><?php print _t("About"); ?></a></li>
<?php
						print $this->render("pageFormat/browseMenu.php");
?>
					<li><a href="<?php print $this->request->config->get("site_host"); ?>/wordpress/index.php/links/"><?php print _t("Links"); ?></a></li>
					<li><a href="<?php print $this->request->config->get("site_host"); ?>/wordpress/index.php/help/"><?php print _t("Help"); ?></a></li>
					<li><a href="<?php print $this->request->config->get("site_host"); ?>/wordpress/index.php/contact-us/"><?php print _t("Contact Us"); ?></a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- end container -->
	</nav>
	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
