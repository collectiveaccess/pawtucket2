<?php
/* ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2019 Whirl-i-Gig
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
	
    <script src="<?php print $this->request->getThemeUrlPath(); ?>/assets/css.js"></script>
    
	<?php print MetaTagManager::getHTML(); ?>
	
	<title><?php print MetaTagManager::getWindowTitle(); ?></title>
</head>
<body id="pawtucketApp">
    <script type="text/javascript">
        let pawtucketUIApps = {};
    </script>   
	<nav class="navbar navbar-expand-lg justify-content-between">
		<div class="col-md-4"><?php print caNavLink(caGetThemeGraphic("roundaboutlogo.png"), "navbar-brand", "", "Front", "Index"); ?></div>		
		<div class="col-lg-4 header-title"><h1>Archives</h1></div>
		<form class="form-inline my-2 my-lg-0 navSearch" action="<?php print caNavUrl('', 'MultiSearch', 'Index'); ?>">
		  <input type="text" class="form-control" id="headerSearchInput" placeholder="Search" name="search" autocomplete="off" placeholder="Search" aria-label="Search" />
		  <button class="btn" type="submit"><i class="material-icons">search</i></button>
		</form>
	</nav>
	<nav class="lowernav">
		<!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
	   		<span class="navbar-toggler-icon"></span>
    	</button> -->
			<ul class="navbar-nav flex-row">
			  <?php print join("\n", caGetNavItemsForBootstrap([
			    _t('People') => ['controller' => 'Browse', 'action' => 'People'],
			    _t('Productions') => ['controller' => 'Browse', 'action' => 'Occurrences'],
				_t('Objects') => ['controller' => 'Browse', 'action' => 'Objects'],
				_t('Collections') => ['controller' => 'Browse', 'action' => 'Collections'],
				_t('About') => ['controller' => 'About', 'action' => 'Index']
			  ])); ?>
		  
			<!--  <?php print join("\n", caGetNavUserItemsForBootstrap(($this->request->isLoggedIn()) ? _t('My Metabolic') : _t('Login'), array("showLoginForm" => true))); ?> -->
			</ul>
	</nav>	
<div id="pageArea" <?php print caGetPageCSSClasses(); ?>


	<div class="container-fluid"><div class="row"><div class="col-sm-12">
		
