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
			<div class="container-xl">
				<?php print caNavlink($this->request, caGetThemeGraphic($this->request, 'logo.svg', array("alt" => "Site Logo", "role" => "banner")), "navbar-brand", "", "", ""); ?>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				  <span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-4">
<!--- set aria-current -> page for the current page -->						
						<li class="nav-item">
							<?php print caNavlink($this->request, _t('Home'), "nav-link".((strToLower($this->request->getController()) == "front") ? " active" : ""), "", "Front", "Index", "", ((strToLower($this->request->getController()) == "front") ? array("aria-current" => "page") : null)); ?>
						</li>
						<li class="nav-item">
							<?php print caNavlink($this->request, _t('About'), "nav-link".((strToLower($this->request->getController()) == "about") ? " active" : ""), "", "About", "index", "", ((strToLower($this->request->getController()) == "about") ? array("aria-current" => "page") : null)); ?>
						</li>
						<?= $this->render("pageFormat/browseMenu.php"); ?>	
						<li class="nav-item">
							<?php print caNavlink($this->request, _t('Collections'), "nav-link".((strToLower($this->request->getController()) == "collections") ? " active" : ""), "", "Collections", "Index", "", ((strToLower($this->request->getController()) == "collections") ? array("aria-current" => "page") : null)); ?>
						</li>
						<li class="nav-item">
							<?php print caNavlink($this->request, _t('Gallery'), "nav-link".((strToLower($this->request->getController()) == "gallery") ? " active" : ""), "", "Gallery", "Index", "", ((strToLower($this->request->getController()) == "gallery") ? array("aria-current" => "page") : null)); ?>
						</li>
						<li class="nav-item">
							<?php print caNavlink($this->request, _t('Contact'), "nav-link".((strToLower($this->request->getController()) == "contact") ? " active" : ""), "", "Contact", "Form", "", ((strToLower($this->request->getController()) == "contact") ? array("aria-current" => "page") : null)); ?>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								<?= _t('Login'); ?>
							</a>
							<div class="dropdown-menu p-2">
								<form action="<?= caNavUrl($this->request, '', 'LoginReg', 'login'); ?>">
									<div class="form-group my-1">
										<input type="text" name="username" class="form-control form-control-sm" placeholder="Username" aria-label="Username Input">
									</div>
									<div class="input-group">
										<input type="password" name="password" class="form-control form-control-sm" placeholder="Password" aria-label="Password Input">
										<button class="btn btn-secondary btn-sm" type="submit" aria-label="Login Button"><i class="bi bi-arrow-right-circle-fill"></i></button>
									</div>
								</form>
<?php
								print caNavlink($this->request, _t('Forgot Password'), "small", "", "LoginReg", "resetForm")."<br/>";
								print caNavlink($this->request, _t('Register'), "small", "", "LoginReg", "register");
?>
							</div>
						</li>
					</ul>
					<form action="<?= caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>" role="search">
						<div class="input-group mt-4">
							<input type="text" name="search" class="form-control rounded-0 border-black" id="nav-search-input" placeholder="Search" aria-label="Search">
							<button type="submit" class="btn rounded-0" id="nav-search-btn" aria-label="Search button"><i class="bi bi-search"></i></button>
						</div>
						<div class="form-text"><?php print caNavLink($this->request, _t("Advanced search"), "", "", "Search", "advanced/objects"); ?></div>
				
					</form>
				</div>
			</div>
		</nav>	

	<main role="main" <?php print caGetPageCSSClasses(); ?>>
<?php
	if(strToLower($this->request->getController()) != "front"){
		print "<div class='container-xl pt-4'>";
	}
?>