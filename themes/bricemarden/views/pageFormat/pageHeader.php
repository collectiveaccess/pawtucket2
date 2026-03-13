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
if($this->request->isLoggedIn() && (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login'))){
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
	<a href="#page-content" id="skip" class="visually-hidden">Skip to main content</a>
	<nav class="navbar navbar-expand-lg">
		<div class="container-xl my-3">
			<?= caNavlink($this->request, caGetThemeGraphic($this->request, 'temp_logo.png', array("alt" => "Brice Marden", "role" => "banner")), "navbar-brand  img-fluid", "", "", ""); ?>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			  <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-4">				
					<li class="nav-item dropdown">
						<a class="text-nowrap nav-link<?php print (strToLower($this->request->getController()) == "About") ? " active" : ""; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php print _t('About'); ?><i class="bi bi-chevron-down ms-2 fs-6"></i></a>
						<ul class="dropdown-menu">
							<li><?= caNavlink($this->request, _t('Introduction'), "nav-link".(((strToLower($this->request->getController()) == "about") && (strToLower($this->request->getAction()) == "introduction")) ? " active" : ""), "", "About", "Introduction", "", (((strToLower($this->request->getController()) == "about") && (strToLower($this->request->getAction()) == "introduction")) ? array("aria-current" => "page") : null)); ?></li>
							<li><?= caNavlink($this->request, _t('Note to the Reader'), "nav-link".(((strToLower($this->request->getController()) == "about") && (strToLower($this->request->getAction()) == "note")) ? " active" : ""), "", "About", "NoteReader", "", (((strToLower($this->request->getController()) == "about") && (strToLower($this->request->getAction()) == "NoteReader")) ? array("aria-current" => "page") : null)); ?></li>
							<li><?= caNavlink($this->request, _t('Acknowledgements'), "nav-link".(((strToLower($this->request->getController()) == "about") && (strToLower($this->request->getAction()) == "acknowledgements")) ? " active" : ""), "", "About", "Acknowledgements", "", (((strToLower($this->request->getController()) == "about") && (strToLower($this->request->getAction()) == "acknowledgements")) ? array("aria-current" => "page") : null)); ?></li>
						</ul>
					</li>
					<li class="nav-item">
						<?= caNavlink($this->request, _t('Artworks'), "nav-link".(((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "artworks")) ? " active" : ""), "", "Browse", "artworks", "", (((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "artworks")) ? array("aria-current" => "page") : null)); ?>
					</li>
					<li class="nav-item dropdown">
						<a class="text-nowrap nav-link<?php print ((strToLower($this->request->getController()) == "browse") && (in_array(strToLower($this->request->getAction()), array("solo_exhibitions", "group_exhibitions")))) ? " active" : ""; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php print _t('Exhibitions'); ?><i class="bi bi-chevron-down ms-2 fs-6"></i></a>
						<ul class="dropdown-menu">
							<li><?= caNavlink($this->request, _t('Solo Exhibitions'), "nav-link".(((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "solo_exhibitions")) ? " active" : ""), "", "Browse", "solo_exhibitions", "", (((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "solo_exhibitions")) ? array("aria-current" => "page") : null)); ?></li>
							<li><?= caNavlink($this->request, _t('Group Exhibitions'), "nav-link".(((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "group_exhibitions")) ? " active" : ""), "", "Browse", "group_exhibitions", "", (((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "group_exhibitions")) ? array("aria-current" => "page") : null)); ?></li>
						</ul>
					</li>
					<li class="nav-item">
						<?= caNavlink($this->request, _t('Bibliography'), "nav-link".(((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "bibliography")) ? " active" : ""), "", "Browse", "bibliography", "", (((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "bibliography")) ? array("aria-current" => "page") : null)); ?>
					</li>
					<li class="nav-item">
						<a href="#" class="nav-link"><?php print _t('Chronology'); ?></a>
					</li>
<?php
					if($user_links){
						print $user_links;
					}
?>
				</ul>
				<form action="<?= caNavUrl($this->request, '', 'Search', 'GeneralSearch'); ?>" role="search">
					<div class="input-group">
						<label for="nav-search-input" class="form-label visually-hidden">Search</label>
						<input type="text" name="search" class="form-control rounded-0 border-black" id="nav-search-input" placeholder="Search">
						<button type="submit" class="btn rounded-0" id="nav-search-btn" aria-label="Submit Search"><i class="bi bi-search"></i></button>
					</div>
				</form>
			</div>
		</div>
	</nav>	

	<main <?= caGetPageCSSClasses(); ?>><a name="page-content"></a>
		<div class='container-xl pt-4'>