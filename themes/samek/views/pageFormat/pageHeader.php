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
$lightboxDisplayName = caGetLightboxDisplayName();
$lightbox_sectionHeading = ucFirst($lightboxDisplayName["section_heading"]);

# Collect the user links
$user_links = "";
if($this->request->isLoggedIn()){
	$user_links .= "<li class='dropdown-item dropdown position-relative'><a class='".(($this->request->getController() == 'LoginReg') ? ' active' : '')."' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>User Options <i class='bi bi-person-circle' aria-label='"._t('User Options')."'></i></a>
						<ul class='dropdown-menu dropdown-menu-sub'>";
	
	$user_links .= '<li class="dropdown-item"><a class="dropdown-header fs-5 text-wrap pe-none text-break">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).'<br>'.$this->request->user->get("email").'</a></li>';
	// $user_links .= "<li><hr class='dropdown-divider'></li>";
	if(caDisplayLightbox($this->request)){
		$user_links .= "<li class='dropdown-item'>".caNavLink($this->request, $lightbox_sectionHeading, '', '', 'Lightbox', 'Index', array())."</li>";
	}
	$user_links .= "<li class='dropdown-item'>".caNavLink($this->request, _t('User Profile'), '', '', 'LoginReg', 'profileForm', array())."</li>";
	
	if ($this->request->config->get('use_submission_interface')) {
		$user_links .= "<li class='dropdown-item'>".caNavLink($this->request, _t('Submit content'), '', '', 'Contribute', 'List', array())."</li>";
	}
	$user_links .= "<li class='dropdown-item'>".caNavLink($this->request, _t('Logout'), '', '', 'LoginReg', 'Logout', array())."</li>";
	$user_links .= "</ul></li>";
} else {	
	if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $user_links = "<li class='dropdown-item'>".caNavlink($this->request, _t('Login'), ((strToLower($this->request->getController()) == "loginreg") ? " active" : ""), "", "LoginReg", "LoginForm", "", ((strToLower($this->request->getController()) == "loginreg") ? array("aria-current" => "page") : null))."</li>"; }
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
	
	<div class="container">
	
		<nav class="navbar navbar-expand-sm">
		
			<a class="navbar-brand" href="https://museum.bucknell.edu/"><?= caGetThemeGraphic($this->request, 'SamekLogo_Transparent_svg.png', array("alt" => "Logo", "role" => "banner")) ?></a>

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-lg-auto mb-2 mb-lg-0 flex-lg-wrap flex-sm-wrap">

					<!-- <li class="nav-item dropdown">
						<a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Visit</a>
						<ul class="dropdown-menu">
							<li class="dropdown-item"><a href="https://museum.bucknell.edu/plan-a-visit/">Plan A Visit</a></li>
							<li class="dropdown-item dropdown position-relative"><a class="secondary">About</a>
								<ul class="dropdown-menu dropdown-menu-sub">
									<li class="dropdown-item"><a href="https://museum.bucknell.edu/about/about-us/">Mission</a></li>
									<li class="dropdown-item"><a href="https://museum.bucknell.edu/our-spaces/">Our Spaces</a></li>
									<li class="dropdown-item"><a href="https://museum.bucknell.edu/contact-and-staff/">Contact and Staff</a></li>
								</ul>
							</li>
						</ul>
					</li> -->

					<li class="nav-item dropdown">
						<a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">About</a>
						<ul class="dropdown-menu">
							<li class="dropdown-item"><a href="https://museum.bucknell.edu/about/mission/">Mission</a></li>
							<li class="dropdown-item"><a href="https://museum.bucknell.edu/spaces/">Spaces</a></li>
							<li class="dropdown-item"><a href="https://museum.bucknell.edu/contact/">Contact and Staff</a></li>
						</ul>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Visit</a>
						<ul class="dropdown-menu">
							<li class="dropdown-item"><a href="https://museum.bucknell.edu/visit/">Plan A Visit</a></li>
						</ul>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Exhibitions</a>
						<ul class="dropdown-menu">
							<li class="dropdown-item"><a href="https://museum.bucknell.edu/category/upcoming-exhibitions/">Upcoming Exhibitions</a></li>
							<li class="dropdown-item"><a href="https://museum.bucknell.edu/category/current-exhibitions/">Current Exhibitions</a></li>
							<li class="dropdown-item"><a href="https://museum.bucknell.edu/category/past-exhibtions/">Past Exhibitions</a></li>
							<li class="dropdown-item"><a href="https://museum.bucknell.edu/catalogs/">Exhibition Catalogs</a></li>
						</ul>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Collection</a>
						<ul class="dropdown-menu">
							<li class="dropdown-item">
								<?= caNavlink($this->request, _t('Search'), ((strToLower($this->request->getController()) == "") ? " active" : ""), "", "", "", "", ((strToLower($this->request->getController()) == "") ? array("aria-current" => "page") : null)); ?>
							</li>
							<!-- <li class="dropdown-item">
								<a href="https://museum.bucknell.edu/collection-2/">About the Collection</a>
								<?php print caNavlink($this->request, _t('About the Collection'), ((strToLower($this->request->getController()) == "about") ? " active" : ""), "", "About", "index", "", ((strToLower($this->request->getController()) == "about") ? array("aria-current" => "page") : null)); ?>
							</li> -->
							<li class="dropdown-item">
								<?= caNavlink($this->request, _t('Browse'), ((strToLower($this->request->getController()) == "browse") ? " active" : ""), "", "Browse", "objects", "", ((strToLower($this->request->getController()) == "browse") ? array("aria-current" => "page") : null)); ?>
							</li>
							<li class="dropdown-item">
								<?= caNavlink($this->request, _t('Advanced Search'), ((strToLower($this->request->getController()) == "Search") ? " active" : ""), "", "Search", "advanced/objects", "", ((strToLower($this->request->getController()) == "Search") ? array("aria-current" => "page") : null)); ?>
							</li>
							<li class="dropdown-item">
								<?= caNavlink($this->request, _t('Object Groups'), ((strToLower($this->request->getController()) == "gallery") ? " active" : ""), "", "Gallery", "Index", "", ((strToLower($this->request->getController()) == "gallery") ? array("aria-current" => "page") : null)); ?>
							</li>
							<li class="dropdown-item">
								<?= caNavlink($this->request, _t('Collection Contact'), ((strToLower($this->request->getController()) == "contact") ? " active" : ""), "", "Contact", "Form", "", ((strToLower($this->request->getController()) == "contact") ? array("aria-current" => "page") : null)); ?>
							</li>

							<?php
								if($user_links){
									print $user_links;
								}
							?>
						</ul>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Events</a>
						<ul class="dropdown-menu">
							<li class="dropdown-item"><a href="https://museum.bucknell.edu/category/upcoming-events/">Upcoming Events</a></li>
							<li class="dropdown-item"><a href="https://museum.bucknell.edu/category/past-events/">Past Events</a></li>
							<li class="dropdown-item"><a href="https://museum.bucknell.edu/samek-distinguished-art-lecture-series/">Samek Distinguished Art Lecture Series</a></li>
						</ul>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Engage</a>
						<ul class="dropdown-menu">
							<li class="dropdown-item"><a href="https://museum.bucknell.edu/category/samek-voices/">Samek Voices</a></li>
							<li class="dropdown-item"><a href="https://museum.bucknell.edu/join-our-team/">Join Our Team</a></li>
							<li class="dropdown-item"><a href="https://museum.bucknell.edu/samek-art-museum-mailing-list/">Subscribe</a></li>
							<li class="dropdown-item"><a href="https://museum.bucknell.edu/support-the-museum/s">Support the Museum</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</div>

	<main <?= caGetPageCSSClasses(); ?>>

<?php
	if(strToLower($this->request->getController()) != "front"){
		print "<div class='container'>";
	}
?>
