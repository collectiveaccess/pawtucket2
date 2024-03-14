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
	$user_links .= "<li class='nav-item dropdown'><a class='nav-link".(($this->request->getController() == 'LoginReg') ? ' active' : '')."' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'><i class='bi bi-person-circle' aria-label='"._t('User Options')."'></i></a>
						<ul class='dropdown-menu'>";
	
	$user_links .= '<li><div class="dropdown-header fw-medium">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).'<br>'.$this->request->user->get("email").'</div></li>';
	// $user_links .= "<li><hr class='dropdown-divider'></li>";
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
	

<nav class="navbar navbar-expand-lg">
  <div class="container-xl">

   	<!-- <?= caNavlink($this->request, caGetThemeGraphic($this->request, 'samek_logo.png', array("alt" => "Logo", "role" => "banner")), "", "", "", ""); ?> -->

	<a href="https://museum.bucknell.edu/"><?= caGetThemeGraphic($this->request, 'samek_logo.png', array("alt" => "Logo", "role" => "banner")) ?></a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Visit</a>
          <ul class="dropdown-menu">
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/plan-a-visit/">Plan A Visit</a></li>
			<ul class="dropdown-menu"><a>About</a>
				<li class="dropdown-item"><a href="https://museum.bucknell.edu/about/about-us/">Mission</a></li>
				<li class="dropdown-item"><a href="https://museum.bucknell.edu/our-spaces/">Our Spaces</a></li>
				<li class="dropdown-item"><a href="https://museum.bucknell.edu/contact-and-staff/">Contact and Staff</a></li>
			</ul>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Exhibitions</a>
          <ul class="dropdown-menu">
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/category/upcoming-exhibitions/">Upcoming Exhibitions</a></li>
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/category/current-exhibitions/">Current Exhibitions</a></li>
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/category/past-exhibtions/">Past Exhibitions</a></li>
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/catalogs/">Exhibition Catalogs</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Collection</a>
          <ul class="dropdown-menu">
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/collection-2/">About the Collection</a></li>
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/collection-highlights/">Selected Works</a></li>
			<!-- <li class="dropdown-item"><a href="https://museum.bucknell.edu/search-collection/">Search The Collection</a></li> -->
			<li class="dropdown-item">
				<?= caNavlink($this->request, _t('Search The Collection'), ((strToLower($this->request->getController()) == "browse") ? " active" : ""), "", "Browse", "objects", "", ((strToLower($this->request->getController()) == "browse") ? array("aria-current" => "page") : null)); ?>
			</li>
			<li class="dropdown-item">
				<?= caNavlink($this->request, _t('Themes'), ((strToLower($this->request->getController()) == "gallery") ? " active" : ""), "", "Gallery", "Index", "", ((strToLower($this->request->getController()) == "gallery") ? array("aria-current" => "page") : null)); ?>
			</li>

			<li class="dropdown-item"><a href="https://museum.bucknell.edu/2020/06/04/rights-and-reproduction/">Rights and Reproduction Requests</a></li>
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/2020/04/08/samek-zoom-backgrounds/">Artful BU Zoom Backgrounds</a></li>
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/2023/05/09/samek-poster-program/">Samek Poster Program</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Events</a>
          <ul class="dropdown-menu">
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/category/upcoming-events/">Upcoming Events</a></li>
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/category/past-events/">Past Events</a></li>
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/samek-distinguished-art-lecture-series/">Samek Distinguished Art Lecture Series</a></li>
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/2022/07/22/samek-art-museum-video-library/">Samek Art Museum Video Library</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Engage</a>
          <ul class="dropdown-menu">
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/category/samek-news/">Samek Voices</a></li>
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/2020/03/27/bucknell-community-art-wall-2/">Community Art Wall</a></li>
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/join-our-team/">Join Our Team</a></li>
			<li class="dropdown-item"><a href="http://museum.bucknell.edu/samek-art-museum-mailing-list/">Subscribe</a></li>
			<li class="dropdown-item"><a href="https://museum.bucknell.edu/support-the-galleries/">Support the Galleries</a></li>
          </ul>
        </li>
       
      </ul>
    </div>
  </div>
</nav>



	<!-- <div class="pt-2 px-3 display-5 fw-medium">Samek Collection</div> -->
	<nav class="navbar navbar-expand-lg subnav">
		<div class="container-xl">
			<!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			  <span class="navbar-toggler-icon"></span>
			</button> -->
			<!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
				<ul class="navbar-nav mb-2 mb-lg-0 me-4 flex-row">
					<li class="nav-item">
						<?= caNavlink($this->request, _t('Home'), "nav-link home-link".((strToLower($this->request->getController()) == "") ? " active" : ""), "", "", "", "", ((strToLower($this->request->getController()) == "") ? array("aria-current" => "page") : null)); ?>
					</li>
					<li class="nav-item">
						<?= caNavlink($this->request, _t('About'), "nav-link".((strToLower($this->request->getController()) == "about") ? " active" : ""), "", "About", "index", "", ((strToLower($this->request->getController()) == "about") ? array("aria-current" => "page") : null)); ?>
					</li>
					<?= $this->render("pageFormat/browseMenu.php"); ?>	
					<li class="nav-item">
						<?= caNavlink($this->request, _t('Gallery'), "nav-link".((strToLower($this->request->getController()) == "gallery") ? " active" : ""), "", "Gallery", "Index", "", ((strToLower($this->request->getController()) == "gallery") ? array("aria-current" => "page") : null)); ?>
					</li>
					<li class="nav-item">
						<?= caNavlink($this->request, _t('Contact'), "nav-link".((strToLower($this->request->getController()) == "contact") ? " active" : ""), "", "Contact", "Form", "", ((strToLower($this->request->getController()) == "contact") ? array("aria-current" => "page") : null)); ?>
					</li>

					<?php
						if($user_links){
							print $user_links;
						}
					?>
					
				</ul>
			<!-- </div> -->
		</div>
	</nav>	
	
	<!-- <nav class="navbar navbar-expand-lg shadow-sm">
		<div class="container-xl">
			<?= caNavlink($this->request, caGetThemeGraphic($this->request, 'samek_logo.png', array("alt" => "Logo", "role" => "banner")), "navbar-brand img-fluid", "", "", ""); ?>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			  <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-4">
					<li class="nav-item">
						<?= caNavlink($this->request, _t('About'), "nav-link".((strToLower($this->request->getController()) == "about") ? " active" : ""), "", "About", "index", "", ((strToLower($this->request->getController()) == "about") ? array("aria-current" => "page") : null)); ?>
					</li>
					<?= $this->render("pageFormat/browseMenu.php"); ?>	
					<li class="nav-item">
						<?= caNavlink($this->request, _t('Collections'), "nav-link".((strToLower($this->request->getController()) == "collections") ? " active" : ""), "", "Collections", "Index", "", ((strToLower($this->request->getController()) == "collections") ? array("aria-current" => "page") : null)); ?>
					</li>
					<li class="nav-item">
						<?= caNavlink($this->request, _t('Gallery'), "nav-link".((strToLower($this->request->getController()) == "gallery") ? " active" : ""), "", "Gallery", "Index", "", ((strToLower($this->request->getController()) == "gallery") ? array("aria-current" => "page") : null)); ?>
					</li>
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
					<div class="input-group mt-4">
						<label for="nav-search-input" class="form-label visually-hidden">Search</label>
						<input type="text" name="search" class="form-control rounded-0 border-black" id="nav-search-input" placeholder="Search" aria-label="Search">
						<button type="submit" class="btn rounded-0" id="nav-search-btn" aria-label="Submit Search"><i class="bi bi-search"></i></button>
					</div>
					<div class="form-text"><?= caNavLink($this->request, _t("Advanced search"), "", "", "Search", "advanced/objects"); ?></div>
				</form>
			</div>
		</div>
	</nav>	 -->

	<main <?= caGetPageCSSClasses(); ?>>
<?php
	if(strToLower($this->request->getController()) != "front"){
		print "<div class='container-xl pt-4'>";
	}
?>
