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
<body id="pawtucketApp" class="d-flex flex-column h-100">
<?php
if($this->request->getParameter('confirmEnter', pInteger)){
	Session::setVar('visited_time', time());
}
if(!$this->request->isLoggedIn() && (!Session::getVar('visited_time') || (Session::getVar('visited_time') < (time() - 86400)))){
?>
		<div class="modal fade" id="contentWarning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="contentWarningLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
				<div class="modal-content">
					<div class="modal-header d-block border-0">
						<h1 class="modal-title fs-2 text-center w-100" id="contentWarningLabel">{{{srsc_content_warning_title}}}</h1>
					</div>
					<div class="modal-body text-center fs-4 pb-2">
						{{{srsc_content_warning_text}}}
					</div>
					<div class="modal-footer justify-content-center border-0">
							<form method="POST" action="<?php print caNavUrl($this->request, '*', '*', '*'); ?>">
							<input type="hidden" name="confirmEnter" value="1">
							<div class="enterButton"><button type="submit" class="btn btn-primary">Enter Site</button></div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<button id="contentWarningButton" type="button" class="visually-hidden btn btn-primary" data-bs-toggle="modal" data-bs-target="#contentWarning">
  			Launch content warning modal
		</button>
		<script>
			window.addEventListener('load', function() {
				var button = document.querySelector('#contentWarningButton');
				if (button) {
				button.click();
					button.style.display = 'none';
				}				
			});
		</script>
<?php
}
?>
	<a href="#page-content" id="skip" class="visually-hidden">Skip to main content</a>
	<nav class="navbar navbar-expand-xl nav-pills shadow-sm">
		<div class="container-fluid">
			<?= caNavlink($this->request, caGetThemeGraphic($this->request, 'srsc_logo.png', array("alt" => "Shingwauk Residential Schools Centre Logo", "role" => "banner"))."<div class='d-inline-block ms-3 lh-sm fw-bold giovanni fs-4'><span class='fs-3 red'>Shingwauk</span><br/>Residential Schools Centre</div>", "navbar-brand d-flex align-items-center", "", "", ""); ?>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			  <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-4">				
					<li class="nav-item dropdown">
						<a class="text-nowrap nav-link<?=((in_array(strToLower($this->request->getController()), array("aboutsrsc", "contact"))) ? " active" : ""); ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<?= _t("About"); ?><i class="bi bi-chevron-down ms-2 fs-6"></i>
						</a>
						<ul class="dropdown-menu">
							<li>
								<?= caNavlink($this->request, _t('About the Centre'), "dropdown-item".((strToLower($this->request->getController()) == "aboutsrsc") ? " active" : ""), "", "AboutSRSC", "", "", ((strToLower($this->request->getController()) == "aboutsrsc") ? array("aria-current" => "page") : null)); ?>
							</li>
							<li>
								<?= caNavlink($this->request, _t('Contact Us'), "dropdown-item".((strToLower($this->request->getController()) == "contact") ? " active" : ""), "", "Contact", "Form", "", ((strToLower($this->request->getController()) == "contact") ? array("aria-current" => "page") : null)); ?>
							</li>
											
						</ul>	
					</li>
					<?= $this->render("pageFormat/browseMenu.php"); ?>	
					<li class="nav-item">
						<?= caNavlink($this->request, _t('Schools'), "nav-link".((strToLower($this->request->getController()) == "schools") ? " active" : ""), "", "Schools", "List", "", ((strToLower($this->request->getController()) == "schools") ? array("aria-current" => "page") : null)); ?>
					</li>
					<li class="nav-item">
						<?= caNavlink($this->request, _t('Gallery'), "nav-link".((strToLower($this->request->getController()) == "gallery") ? " active" : ""), "", "Gallery", "Index", "", ((strToLower($this->request->getController()) == "gallery") ? array("aria-current" => "page") : null)); ?>
					</li>
<?php
					if($user_links){
						print $user_links;
					}
?>
				</ul>
				<form action="<?= caNavUrl($this->request, '', 'Search', 'all_collections'); ?>" role="search">
					<div class="input-group mt-4">
						<label for="nav-search-input" class="form-label visually-hidden">Search</label>
						<input type="text" name="search" class="form-control rounded-0 border-black" id="nav-search-input" placeholder="Search">
						<button type="submit" class="btn rounded-0" id="nav-search-btn" aria-label="Submit Search"><i class="bi bi-search"></i></button>
					</div>
					<div class="form-text"><?= caNavLink($this->request, _t("Advanced search"), "", "", "Search", "advanced/collections"); ?></div>
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
