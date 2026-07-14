<?php
/** ----------------------------------------------------------------------
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
$lightboxDisplayName = caGetLightboxDisplayName();
$lightbox_sectionHeading = ucFirst($lightboxDisplayName["section_heading"]);

# Collect the user links
$user_links = "";
if($this->request->isLoggedIn()){
	$user_links .= "<li class='nav-item dropdown'><a class='nav-link".(($this->request->getController() == 'LoginReg') ? ' active' : '')."' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'><i class='bi bi-person-circle' aria-label='"._t('User Options')."'></i></a>
						<ul class='dropdown-menu'>";
	
	$user_links .= '<li><div class="dropdown-header fw-medium">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).'<br>'.$this->request->user->get("email").'</div></li>';
	$user_links .= "<li><hr class='dropdown-divider'></li>";
	if(caDisplayLightbox($this->request)){
		$user_links .= "<li>".caNavLink($this->request, $lightbox_sectionHeading, 'dropdown-item', '', 'Lightbox', 'Index', array())."</li>";
	}
	$user_links .= "<li>".caNavLink($this->request, _t('User Profile'), 'dropdown-item', '', 'LoginReg', 'profileForm', array())."</li>";
	
	if ($this->request->config->get('use_submission_interface')) {
		$user_links .= "<li>".caNavLink($this->request, _t('Submit content'), 'dropdown-item', '', 'Contribute', 'List', array())."</li>";
	}
	$user_links .= "<li>".caNavLink($this->request, _t('Logout'), 'dropdown-item', '', 'LoginReg', 'Logout', array())."</li>";
	$user_links .= "</ul></li>";
} else {	
	if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $user_links = "<li class='nav-item'>".caNavlink($this->request, _t('Login'), "nav-link".((strToLower($this->request->getController()) == "loginreg") ? " active" : ""), "", "LoginReg", "LoginForm", "", ((strToLower($this->request->getController()) == "loginreg") ? array("aria-current" => "page") : null))."</li>"; }
}

?><!DOCTYPE html>
<html lang="en" class="h-100">
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
	<?= MetaTagManager::getHTML(); ?>
	<?= AssetLoadManager::getLoadHTML($this->request); ?>
	
	<title><?= (MetaTagManager::getWindowTitle()) ?: $this->request->config->get("app_display_name"); ?></title>

	<script>
		let pawtucketUIApps = {};
	</script>
</head>
<?php
	$nav_border = "";
	if(strToLower($this->request->getController()) != "front"){
		$nav_border = "border-bottom border-3 border-black";
	}
?>
<body id="pawtucketApp" class="d-flex flex-column h-100">
	<a href="#page-content" id="skip" class="visually-hidden">Skip to main content</a>
	<nav class="navbar navbar-light navbar-expand-lg mx-4 px-4<?php print $nav_border; ?>">
		<div class="container-fluid my-1">
<?php
			$logo = '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="54" viewBox="0 0 100 54" class="art21logo">
						<path d="M32,25.3c0-4.5-2.6-6.8-7.8-6.8c-2.5,0-4.7,0.3-6.9,1.1L17,19.7l0.8,2.8l0.4-0.1c1.3-0.4,3.4-1,6-1c3.8,0,4.4,1.8,4.5,3.1v0.2c-7.7-0.1-10.4,0.7-12,2.3c-0.9,0.9-1.4,2.4-1.4,3.9c0,3.4,2.7,5.5,7.2,5.5c3.3,0,6.5-2.5,6.5-2.5l1.1,2.3h2.6l-0.6-4V25.3zM28.8,31.8c-1.9,1.2-3.5,1.8-6.2,1.8c-2.5,0-4-1-4-2.6c0-0.9,0.2-1.5,0.8-2c1-1,3.1-1.7,9.4-1.7L28.8,31.8zM48.7,17.8v3.6l-8,2.9v12h-3.3V18.5h2.3l0.5,3.1L48.7,17.8zM65.8,33.1l0.5,2.8c0,0-2,0.5-3.4,0.5c-4.7,0-7.2-2.4-7.2-6.9v-8.2h-3.5v-2.9h3.5v-5.3h3.3v5.3h6.7v2.9h-6.7v8c0,2.8,1.3,4.1,4.1,4.1C63.9,33.4,65.8,33.1,65.8,33.1zM86.8,33.4v2.9h-16l-0.5-3.1l8.6-4.8c3-1.7,4-2.8,4-4.4c0-1.6-1.5-2.6-4.1-2.6c-1.9,0-4,0.5-6,1.6l-0.4,0.2l-1.3-2.6l0.4-0.2c2.5-1.3,4.9-1.9,7.4-1.9c4.5,0,7.2,2,7.2,5.3c0,3.1-2.1,4.9-5.8,6.8l-6,3.2L86.8,33.4zM98.9,18.5v17.8h-3.3l0-14.3l-4.5,1.5l-1-2.2l6.5-2.9H98.9z"></path>
					</svg>';
?>
			<?= caNavlink($this->request, $logo, "navbar-brand  img-fluid", "", "", ""); ?>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			  <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-4">				
					<li class="nav-item">
						<?= caNavlink($this->request, _t('Footage Archive'), "nav-link".(((strToLower($this->request->getController()) == "browse") && ((strToLower($this->request->getAction())) == "projects")) ? " active" : ""), "", "Browse", "projects", "", (((strToLower($this->request->getController()) == "browse") && ((strToLower($this->request->getAction())) == "projects")) ? array("aria-current" => "page") : null)); ?>
					</li>
					<li class="nav-item">
						<?= caNavlink($this->request, _t('Film Library'), "nav-link".((strToLower($this->request->getController()) == "collections") ? " active" : ""), "", "Collections", "Index", "", ((strToLower($this->request->getController()) == "collections") ? array("aria-current" => "page") : null)); ?>
					</li>
					<?= $this->render("pageFormat/browseMenu.php"); ?>	
					<li class="nav-item">
						<?= caNavlink($this->request, _t('Contact'), "nav-link".((strToLower($this->request->getController()) == "contact") ? " active" : ""), "", "Contact", "Form", "", ((strToLower($this->request->getController()) == "contact") ? array("aria-current" => "page") : null)); ?>
					</li>
<?php
					if($user_links){
						print $user_links;
					}
?>
				</ul>
				<form action="<?= caNavUrl($this->request, '', 'Search', 'GeneralSearch'); ?>" role="search">
					<div class="input-group my-4">
						<label for="nav-search-input" class="form-label visually-hidden">Search</label>
						<input type="text" name="search" class="form-control rounded-0 border-black" id="nav-search-input" placeholder="Search">
						<button type="submit" class="btn" id="nav-search-btn" aria-label="Submit Search"><i class="bi bi-search"></i></button>
					</div>
				</form>
			</div>
		</div>
	</nav>	

	<main <?= caGetPageCSSClasses(); ?>><a name="page-content"></a>
<?php
	if(strToLower($this->request->getController()) != "front"){
		print "<div class='container-xl pt-4'>";
	}
?>
