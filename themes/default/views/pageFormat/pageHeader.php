<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageHeader.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2024 Whirl-i-Gig
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
<html lang="en" class="h-100">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0"/>
	<?= MetaTagManager::getHTML(); ?>
	<?= AssetLoadManager::getLoadHTML($this->request); ?>
	
	<title><?= (MetaTagManager::getWindowTitle()) ?: $this->request->config->get("app_display_name"); ?></title>

	<script type="text/javascript">
		let pawtucketUIApps = {};
	</script>
</head>
<body id="pawtucketApp" class="d-flex flex-column h-100">
	
		<nav class="navbar navbar-expand-lg shadow-sm">
			<div class="container">
				<?php print caNavlink($this->request, caGetThemeGraphic($this->request, 'logo.svg', array("alt" => "Logo", "role" => "banner")), "navbar-brand", "", "", ""); ?>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-4">
<!--- set aria-current -> page for the current page -->						
						<li class="nav-item">
							<?php print caNavlink($this->request, _t('Home'), "nav-link active", "", "", "", "", array("aria-current" => "page")); ?></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/About"><?= _t('About'); ?></a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								<?= _t('Browse'); ?>
							</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="/Browse/objects"><?= _t('Objects'); ?></a></li>
								<li><a class="dropdown-item" href="/Browse/entities"><?= _t('Entities'); ?></a></li>
								<li><a class="dropdown-item" href="/Browse/occurrences"><?= _t('Occurrences'); ?></a></li>
								<li><a class="dropdown-item" href="/Browse/places"><?= _t('Places'); ?></a></li>
							</ul>
						</li>
						<li class="nav-item">
							<?php print caNavLink($this->request, _t('Collections'), "nav-link", "", "Collections", "Index"); ?>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/Contact"><?= _t('Contact'); ?></a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								<?= _t('Login'); ?>
							</a>
							<div class="dropdown-menu p-2">
								<form action="<?= caNavUrl($this->request, '', 'LoginReg', 'login'); ?>">
									<div class="form-group my-1">
										<input type="text" name="username" class="form-control form-control-sm" placeholder="Username">
									</div>
									<div class="input-group">
										<input type="password" name="password" class="form-control form-control-sm" placeholder="Password">
										<button class="btn btn-secondary btn-sm" type="submit"><i class="bi bi-arrow-right-circle-fill"></i></button>
									</div>
								</form>
								<a href="" class="dropdown-item p-2"><?= _t('Forgot Password'); ?></a>
								<a href="" class="dropdown-item p-2"><?= _t('Register'); ?></a>
							</div>
						</li>
					</ul>
					<form action="<?= caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" role="search">
						<div class="input-group">
							<input type="text" name="search" class="form-control rounded-0" id="nav-search-input" placeholder="Search" aria-label="Search">
							<button type="submit" class="btn rounded-0" id="nav-search-btn"><i class="bi bi-search"></i></button>
						</div>
					</form>
				</div>
			</div>
		</nav>	

	<main role="main">
