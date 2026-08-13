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
	$user_links .= "<li class='nav-item dropdown'><a class='nav-link usericon".(($this->request->getController() == 'LoginReg') ? ' active' : '')."' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'><i class='bi bi-person-circle' aria-label='"._t('User Options')."'></i><span class='d-lg-none'> "._t('Your Account')."</span></a>
						<ul class='dropdown-menu dropdown-menu-end mt-lg-2'>";
	
	$user_links .= '<li><div class="dropdown-header fw-medium">'.trim($this->request->user->get("fname")." ".$this->request->user->get("lname")).'<br>'.$this->request->user->get("email").'</div></li>';
	$user_links .= "<li><hr class='dropdown-divider'></li>";
	if(caDisplayLightbox($this->request)){
		$user_links .= "<li>".caNavLink($this->request, $lightbox_sectionHeading, 'dropdown-item nav-link', '', 'Lightbox', 'Index', array())."</li>";
	}
	$user_links .= "<li>".caNavLink($this->request, _t('User Profile'), 'dropdown-item nav-link', '', 'LoginReg', 'profileForm', array())."</li>";
	
	if ($this->request->config->get('use_submission_interface')) {
		$user_links .= "<li>".caNavLink($this->request, _t('Submit content'), 'dropdown-item nav-link', '', 'Contribute', 'List', array())."</li>";
	}
	$user_links .= "<li>".caNavLink($this->request, _t('Logout'), 'dropdown-item nav-link', '', 'LoginReg', 'Logout', array())."</li>";
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
	<div class="titleBar bg-dark-blue px-2 pb-2 pt-2 text-center"><a href="https://www.whitehousehistory.org"><?= caGetThemeGraphic($this->request, 'WHHA_Logo_Alt-white.png', array("class" => "pb-1 pt-1", "alt" => "White House Historical Association")); ?></a></div>
	<nav class="navbar navbar-expand-lg shadow-sm bg-white px-md-4 z-2">
		<div class="container-fluid">
			<?= caNavlink($this->request, caGetThemeGraphic($this->request, 'WHWHP-TextLogo-Stacked-Lines.png', array("alt" => "White House Workers History Project", "role" => "banner")), "navbar-brand  img-fluid ms-md-2", "", "", ""); ?>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			  <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mainmenu ms-auto mb-2 mb-lg-0 me-4">				
					<?= $this->render("pageFormat/browseMenu.php"); ?>	
					<li class="nav-item dropdown py-3 py-lg-0">
						<a class="text-nowrap nav-link<?php print (in_array(strToLower($this->request->getController()), array("gallery"))) ? " active" : ""; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php print _t('Resources'); ?><i class="bi bi-chevron-down ms-1 fs-6"></i></a>
						<ul class="dropdown-menu text-nowrap lh-lg ps-2 ps-lg-0 border-0">
							<li><a href="#" class="nav-link"><?= _t("Using the Database"); ?></a></li>
							<li><?= caNavlink($this->request, _t('Collections'), "nav-link".((strToLower($this->request->getController()) == "gallery") ? " active" : ""), "", "Gallery", "Index", "", ((strToLower($this->request->getController()) == "gallery") ? array("aria-current" => "page") : null)); ?></li>
							<li><a href="{{{slavery_url}}}" class="nav-link"><?= _t("Slavery in the President's Neighborhood"); ?></a></li>
							<li><a href="{{{edu_resources_link}}}" class="nav-link"><?= _t('Educational Resources'); ?></a></li>
							<li><a href="{{{dig_archives_url}}}" class="nav-link"><?= _t("Digital Archives"); ?></a></li>
							
						</ul>
					</li>
					<li class="nav-item dropdown py-3 py-lg-0">
						<a class="text-nowrap nav-link<?php print (in_array(strToLower($this->request->getController()), array("about", "contact"))) ? " active" : ""; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php print _t('About'); ?><i class="bi bi-chevron-down ms-1 fs-6"></i></a>
						<ul class="dropdown-menu text-nowrap lh-lg ps-2 ps-lg-0 border-0">
							<li><?= caNavlink($this->request, _t('About the Project'), "nav-link".(((strToLower($this->request->getController()) == "about") && (strToLower($this->request->getAction()) == "project")) ? " active" : ""), "", "About", "project", "", (((strToLower($this->request->getController()) == "about") && (strToLower($this->request->getAction()) == "project")) ? array("aria-current" => "page") : null)); ?></li>
							<li><?= caNavlink($this->request, _t('Project Credits'), "nav-link".(((strToLower($this->request->getController()) == "about") && (strToLower($this->request->getAction()) == "projectCredits")) ? " active" : ""), "", "About", "projectCredits", "", (((strToLower($this->request->getController()) == "about") && (strToLower($this->request->getAction()) == "projectCredits")) ? array("aria-current" => "page") : null)); ?></li>
							<li><?= caNavlink($this->request, _t('Contact Us'), "nav-link".((strToLower($this->request->getController()) == "contact") ? " active" : ""), "", "Contact", "Form", "", ((strToLower($this->request->getController()) == "contact") ? array("aria-current" => "page") : null)); ?></li>
							<li><a href="{{{rights_repro_url}}}" class="nav-link"><?= _t("Usage Rights/Reproductions"); ?></a></li>
						</ul>
					</li>

				</ul>
				<form action="<?= caNavUrl($this->request, '', 'Search', 'GeneralSearch'); ?>" role="search">
					<div class="input-group ps-4 pe-4">
						<label for="nav-search-input" class="form-label visually-hidden">Search</label>
						<input type="text" name="search" class="form-control rounded-0 border-black me-2" id="nav-search-input" placeholder="Search">
						<button type="submit" class="btn btn-primary rounded-0" id="nav-search-btn" aria-label="Submit Search">Search</button>
					</div>
					<div class="form-text mt-0 ps-4"><?= caNavLink($this->request, _t("Advanced search"), "", "", "Search", "advanced/workers"); ?></div>
				</form>
<?php
					if($user_links){
						print '<ul class="navbar-nav mb-2 mb-lg-3 mt-3 mt-lg-0">'.$user_links.'</ul>';
					}
?>
				
			</div>
		</div>
	</nav>	

	<main <?= caGetPageCSSClasses(); ?>><a name="page-content"></a>
<?php
	#if(!in_array(strToLower($this->request->getController()), array("front", "partners", "browse", "search", ""))){
	#	print "<div class='container-xl pt-4'>";
	#}
	switch(strToLower($this->request->getController())){
		case "front":
			# --- no container on front page
		break;
		case "browse": 
		case "partners": 
		case "occupations": 
		case "gallery":  
		case "search": 
			if((!in_array(strToLower($this->request->getController()), array("gallery", "search"))) ||
				(
					((strToLower($this->request->getController()) == "search") && (strToLower($this->request->getAction()) != "generalsearch")) ||
					((strToLower($this->request->getController()) == "gallery") && (strToLower($this->request->getAction()) == "index"))
				)
			){
			
			
			
?>
			<div class="section-dark-gray-linen p-0">
				<div class="page-header">
					<h1 class="text-center">
<?php
						switch(strToLower($this->request->getController())){
							case "partners":
								print _t("Partners");
							break;
							# -----------------------------
							case "gallery":
								print _t("Collections");
							break;
							# -----------------------------
							case "browse":
							case "search":
								switch(strToLower($this->request->getAction())){
									case "workers":
									case "advanced":
										print _t("Workers");
									break;
									# ----------------------
									case "presidencies":
										print _t("Presidencies");
									break;
									# ----------------------
									case "partners":
										print _t("Partners");
									break;
									# ----------------------
									case "birth_burial_map":
										print _t("Birth & Burial Map");
									break;
									# ----------------------
								}
							break;
							# -----------------------------
							case "occupations":
								print _t("Occupations");
							break;
							# -----------------------------							
						}
?>				
					</h1>
					<div class="divider">
					  <svg xmlns="http://www.w3.org/2000/svg" width="46" height="8" viewBox="0 0 46 8" fill="none"><path d="M45.0482 3.05535H41.7106L40.6795 0L39.6493 3.05535H36.3108L39.0116 4.94377L37.9787 8L40.6795 6.11069L43.3803 8L42.3483 4.94289L45.0482 3.05535ZM24.0303 3.05535L23.0001 0L21.9699 3.05535H18.6314L21.3322 4.94377L20.2994 8L23.0001 6.11069L25.7 8L24.668 4.94289L27.3688 3.05447L24.0303 3.05535ZM6.35095 3.05535L5.31986 0L4.28877 3.05535H0.951172L3.65194 4.94377L2.61909 8L5.31986 6.11069L8.01975 8L6.98778 4.94289L9.68855 3.05447L6.35095 3.05535Z" fill="#B0B6BD"></path></svg>
					</div>
				</div>
			</div>
			<div class='container-xl pt-4 mt-4'>
<?php
				if(strToLower($this->request->getAction()) == "birth_burial_map"){
					print "<div class='mb-4 mt-3 fs-4'>".$this->getVar("map_intro_text")."</div>";
				}		
			}else{
				print "<div class='container-xl pt-4'>";
			}
		break;
		# ---------------------------------------------
		default:
			print "<div class='container-xl pt-4'>";
		break;
		# ---------------------------------------------		
	}
?>
