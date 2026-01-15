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
	if (!$this->request->config->get(['dontAllowRegistrationAndLogin', 'dont_allow_registration_and_login']) || $this->request->config->get('pawtucket_requires_login')) { $user_links = "<li class='nav-item'>".caNavlink($this->request, "<span>"._t('Login')."</span>", "nav-link".((strToLower($this->request->getController()) == "loginreg") ? " active" : ""), "", "LoginReg", "LoginForm", "", ((strToLower($this->request->getController()) == "loginreg") ? array("aria-current" => "page") : null))."</li>"; }
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
<body id="pawtucketApp" class="d-flex flex-column h-100"><a name="pageTop"></a>
	<a href="#page-content" id="skip" class="visually-hidden">Skip to main content</a>
	<div class="bg-dark topBar">
		<div class="container">
			<div class="row">
				<div class="col-8">
					<a href="https://sa.gov/"><?php print caGetThemeGraphic($this->request, 'CityQuad-SM.svg', array("class" => "me-1", "alt" => "COSA quatrefoil")); ?></a>
					<a href="https://sa.gov/" class="fw-bold small">Official website of the City of San Antonio</a>
				</div>
				<div class="col-4 text-end">
					<?= caNavlink($this->request, _t('Help'), "", "", "Help", "", ""); ?>
				</div>
			</div>
		</div>
	</div>
	<nav class="navbar navbar-expand-lg bg-light">
		<div class="container-xl">
			<?= caNavlink($this->request, caGetThemeGraphic($this->request, 'COSA_quatrefoil.png', array("class" => "pe-2", "alt" => "City of San Antonio Texas", "role" => "banner"))."<span>Art Collection</span>", "navbar-brand", "", "", ""); ?>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			  <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-4">				
					<li class='nav-item'><?php print caNavLink($this->request, "<span>"._t("Artworks")."</span>", 'nav-link'.((strToLower($this->request->getAction()) == "artworks") ? " active" : ""), '', 'Browse', 'artworks', ''); ?></li>
					<li class="nav-item dropdown">
						<a class="text-nowrap nav-link<?php print (((strToLower($this->request->getController()) == "browse") && (strToLower($this->request->getAction()) == "browse")) || (strToLower($this->request->getController()) == "listing")) ? ' active' : ''; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><span>Exhibitions</span> <i class="bi bi-chevron-down fs-6"></i></a>
						<ul class="dropdown-menu">
							<li class='nav-item'><?php print caNavLink($this->request, _t("Current Exhibitions"), 'nav-link'.((strToLower($this->request->getController()) == "listing") ? " active" : ""), '', 'Listing', 'current_exhibitions', ''); ?></li>
							<li class='nav-item'><?php print caNavLink($this->request, _t("Past Exhibitions"), 'nav-link'.((strToLower($this->request->getAction()) == "exhibitions") ? " active" : ""), '', 'Browse', 'exhibitions', ''); ?></li>
						</ul>	
					</li>
					<li class="nav-item">
						<?= caNavlink($this->request, "<span>"._t('Collection Highlights')."</span>", "nav-link".((strToLower($this->request->getController()) == "gallery") ? " active" : ""), "", "Gallery", "Index", "", ((strToLower($this->request->getController()) == "gallery") ? array("aria-current" => "page") : null)); ?>
					</li>
<?php
					if($user_links){
						print $user_links;
					}
?>
				</ul>
			</div>
				<form action="<?= caNavUrl($this->request, '', 'Search', 'GeneralSearch'); ?>" role="search">
					<div class="input-group">
						<label for="nav-search-input" class="form-label visually-hidden">Search</label>
						<input type="text" name="search" class="bg-white form-control rounded-0  border-0" id="nav-search-input" placeholder="Search Art Collection">
						<button type="submit" class="btn btn-primary text-white rounded-0" id="nav-search-btn" aria-label="Submit Search"><i class="bi bi-search"></i></button>
					</div>
				</form>
			</div>
		
	</nav>	

	<main <?= caGetPageCSSClasses(); ?>><a name="page-content"></a>
<?php
	if(strToLower($this->request->getController()) != "detail"){
		# --- output in detail views so have back link and record title
?>
		<div class="breadcrumb"><div class='container-xl'><div class="py-2 fs-6">
<?php
			print caNavLink($this->request, _t("Art Collection"), '', '', '', '', '');
			switch(strToLower($this->request->getController())){
				case "search":
				case "browse":
					switch(strToLower($this->request->getAction())){
						case "artworks":
							#print " / ".caNavLink($this->request, _t("Artworks"), '', '', 'Browse', 'artworks', '');			
							print " / "._t("Artworks");			
						break;
						# ----------------
						case "exhibitions":
							#print " / ".caNavLink($this->request, _t("Past Exhibitions"), '', '', 'Browse', 'exhibitions', '');
							print " / "._t("Past Exhibitions");		
						break;
						# ----------------
						case "artists":
							#print " / ".caNavLink($this->request, _t("Artists"), '', '', 'Browse', 'artists', '');			
							print " / "._t("Artists");			
						break;
						# ----------------
						case "exhibitions":
							#print " / ".caNavLink($this->request, _t("Past Exhibitions"), '', '', 'Browse', 'exhibitions', '');				
							print " / "._t("Past Exhibitions");				
						break;
						# ----------------
						case "advanced":
							#print " / ".caNavLink($this->request, _t("Advanced Search"), '', 'Search', 'advanced', 'objects', '');			
							print " / "._t("Advanced Search");			
						break;
						# ----------------
					}
				break;
				# ------------------------------
				case "listing":
					switch(strToLower($this->request->getAction())){
						case "current_exhibitions":
							#print " / ".caNavLink($this->request, _t("Current Exhibitions"), '', '', 'Listing', 'current_exhibitions', '');		
							print " / "._t("Current Exhibitions");
						break;
					}
				break;
				# ------------------------------
				case "gallery":
					#print " / ".caNavLink($this->request, _t("Collection Highlights"), '', '', 'Gallery', 'index', '');	
					print " / "._t("Collection Highlights");	
				break;		
				# ------------------------------
				case "loginreg":
					switch(strToLower($this->request->getAction())){
						case "loginform":
						case "login":
							print " / "._t("Login");
						break;
						# ----------------
						case "registerform":
						case "register":
							print " / "._t("Register");			
						break;
						# ----------------
						case "resetform":
						case "resetsend":
							print " / "._t("Reset Your Password");			
						break;
						# ----------------
						case "profileform":
						case "profilesave":
							print " / "._t("Profile");
						break;
						# ----------------
					}
				break;		
				# ------------------------------
				case "lightbox":
					print " / ".$lightbox_sectionHeading;	
				break;		
				# ------------------------------
				
			}
?>
		</div></div></div>
<?php
	}
	if(!in_array(strToLower($this->request->getController()), array("front", "detail"))){
		# --- this is output on detail pages after the breadcrumb trail
		print "<div class='container-xl pt-4'>";
	}
?>
