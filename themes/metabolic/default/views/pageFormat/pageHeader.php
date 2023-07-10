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
    
	<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
		<?php print caNavLink("CollectiveAccess", "navbar-brand", "", "Front", "Index"); ?>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <?php print join("\n", caGetNavItemsForBootstrap([
          	_t('About') => ['controller' => 'About', 'action' => 'Index'],
          	_t('Advanced Search') => ['controller' => 'Search', 'action' => 'advanced/objects'],
          	_t('Gallery') => ['controller' => 'Gallery', 'action' => 'Index'],
          	_t('Collections') => ['controller' => 'Collections', 'action' => 'Index'],
          	_t('Contact') => ['controller' => 'Contact', 'action' => 'Form']
          ])); ?>
          
          <?php print join("\n", caGetNavUserItemsForBootstrap(_t('User'))); ?>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="<?php print caNavUrl('', 'MultiSearch', 'Index'); ?>">
          <input type="text" class="form-control mr-sm-2" id="headerSearchInput" placeholder="Search" name="search" autocomplete="off" placeholder="Search" aria-label="Search" />
          <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
	</nav>
	

	<div class="container"><div class="row"><div class="col-xs-12">
		<div id="pageArea" <?php print caGetPageCSSClasses(); ?>>
