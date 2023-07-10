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
	<link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    <script src="<?php print $this->request->getThemeUrlPath(); ?>/assets/css.js"></script>
    
	<?php print MetaTagManager::getHTML(); ?>
	
	<title><?php print MetaTagManager::getWindowTitle(); ?></title>
</head>
<body id="pawtucketApp">

    <script type="text/javascript">
        let pawtucketUIApps = {};
    </script>
    
	<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
		<?php print caNavLink(caGetThemeGraphic("metabolic/metabolicStudioLogo.png", array("alt" => "Metabolic Studio")), "navbar-brand", "", "Front", "Index"); ?>
		<button class="navbar-toggler p-2" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<ul class="navbar-nav ml-auto mr-3">
			  <?php print join("\n", caGetNavItemsForBootstrap([
				_t('Find') => ['controller' => 'Browse', 'action' => 'Objects'],
				_t('Actions') => ['controller' => 'Listing', 'action' => 'Actions'],
				_t('Chronology') => ['controller' => 'Chronology', 'action' => 'View'],
				//_t('Activity') => ['controller' => 'Activity', 'action' => 'View'],
				#_t('Collections') => ['controller' => 'Gallery', 'action' => 'Index'],
				#_t('About') => ['controller' => 'About', 'action' => 'Studio']
			  ])); ?>
		  
			  <?php print join("\n", caGetNavUserItemsForBootstrap(($this->request->isLoggedIn()) ? _t('My Metabolic') : _t('Login'), array("showLoginForm" => true))); ?>
			</ul>
			<form class="form-inline my-2 my-lg-0 navSearch" action="<?php print caNavUrl('', 'MultiSearch', 'Index'); ?>">
			  <input type="text" class="form-control" id="headerSearchInput" placeholder="Search" name="search" autocomplete="off" placeholder="Search" aria-label="Search" />
			  <button class="btn" type="submit"><i class="material-icons">search</i></button>
			</form>
      </div>
	</nav>
	
<div role="main" id="main">
	<div id="mediaDisplayFullscreen" class="mediaDisplayFullscreen">
		<!-- Used by MediaViewer.js React app -->
	</div>
	<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
		<div class="container-fluid"><div class="row"><div class="col-sm-12">
		
