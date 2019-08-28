<?php
/* ----------------------------------------------------------------------
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
?><!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
    <script src="<?php print $this->request->getThemeUrlPath(); ?>/assets/css.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    
	<?php print MetaTagManager::getHTML(); ?>
	
	<title><?php print MetaTagManager::getWindowTitle(); ?></title>
</head>
<body id="pawtucketApp" >
	<script type="text/javascript">
		let pawtucketUIApps = {
			'navscroll': {
				'selector': '#pageNav',
				'data': { 'offset': '10'}
			}
		};
	</script>
	
	<div class="search-wrapper">
		<div class="container">
			<div class="row">
				<div class="input-container col-md-10">
					<form action="/index.php/MultiSearch/Index">
						<div class="search-control">
							<input id="search-control" type="text" class="search-control" name="search" placeholder="Search the Archives" autocomplete="off">
						</div>
					</form>
					<img src="/themes/sva/images/icon-close.svg" alt="Close" class="icon-close search-wrapper-close"/>
				</div>
			</div>
		</div>
	</div>
	
	<div id="pageNav"></div>
	<div id="pageArea" role="main" id="main" <?php print caGetPageCSSClasses(); ?> >
