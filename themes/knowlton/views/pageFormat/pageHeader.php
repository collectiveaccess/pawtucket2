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
$va_access_values = caGetUserAccessValues($this->request);

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
<body id="pawtucketApp" class="d-flex flex-column">
	<div role="navigation" id="osu_navbar" aria-labelledby="osu_navbar_heading" class="bg-black">
		<div id="osu_navbar_heading" class="visually-hidden text-white">Ohio State nav bar</div>
		<a href="#page-content" id="skip" class="visually-hidden">Skip to main content</a>
		<div class="container-fluid">
    		<div class="row">
    			<div class="col-4">
    				<a href="http://osu.edu"><?= caGetThemeGraphic($this->request, 'osu_name.png', array("alt" => "The Ohio State University")); ?></a>
    			</div>
    			<div class="col-8 text-end">
    				<ul class="list-inline mb-0">
						<li class="list-inline-item"><a href="http://www.osu.edu/help.php"><span>Help</span><?php print caGetThemeGraphic($this->request, "headerIcons/resp-help@2x.png", array("alt" => "Help")); ?></a></li>
						<li class="list-inline-item"><a href="http://buckeyelink.osu.edu/"><span>BuckeyeLink</span><?php print caGetThemeGraphic($this->request, "headerIcons/resp-buckeyelink@2x.png", array("alt" => "BuckeyeLink")); ?></a></li>
						<li class="list-inline-item"><a href="http://www.osu.edu/map/"><span>Map</span><?php print caGetThemeGraphic($this->request, "headerIcons/resp-map@2x.png", array("alt" => "Map")); ?></a></li>
						<li class="list-inline-item"><a href="http://www.osu.edu/findpeople.php"><span>Find People</span><?php print caGetThemeGraphic($this->request, "headerIcons/resp-findpeople@2x.png", array("alt" => "Find People")); ?></a></li>
						<li class="list-inline-item"><a href="https://email.osu.edu/"><span>Webmail</span><?php print caGetThemeGraphic($this->request, "headerIcons/resp-webmail@2x.png", array("alt" => "Webmail")); ?></a></li>
						<li class="list-inline-item"><a href="http://www.osu.edu/search/"><span>Search Ohio State</span><?php print caGetThemeGraphic($this->request, "headerIcons/resp-search@2x.png", array("alt" => "Search Ohio State")); ?></a></li>
					</ul>
    			</div>
    		</div>	
    	</div>
	</div>
	<nav class="navbar navbar-expand-md sticky-md-top">
		<div class="container-fluid px-md-0">
			<?= caNavlink($this->request, caGetThemeGraphic($this->request, 'knowlton_dl_logo_draft.svg', array("alt" => "Knowlton School Digital Library and Archive", "role" => "banner")), "navbar-brand  img-fluid p-0 m-0", "", "", ""); ?>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			  <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse mt-3 mt-md-0" id="navbarSupportedContent">
				<ul class="navbar-nav ms-auto mb-lg-0">				
					<li class="nav-item">
						<?= caNavlink($this->request, _t('About'), "nav-link".((strToLower($this->request->getController()) == "aboutcollection") ? " active" : ""), "", "AboutCollection", "", "", ((strToLower($this->request->getController()) == "about") ? array("aria-current" => "page") : null)); ?>
					</li>
					<?= $this->render("pageFormat/browseMenu.php"); ?>	
					<li class="nav-item d-none d-md-block">
						<button class="nav-link" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch,#navbarSearchClose" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search form">Search<span id="navbarSearchClose" class="collapse"> <i class="bi bi-x-lg"></i></span></button>
					</li>
					<li class="nav-item d-block d-md-none">
						<form action="<?= caNavUrl($this->request, '', 'Search', 'objects'); ?>">
							<div class="input-group mt-4">
								<label for="nav-search-input" class="form-label visually-hidden">Search</label>
								<input type="text" name="search" class="form-control rounded-0 border-black" id="nav-search-input" placeholder="Search...">
								<button type="submit" class="btn rounded-0" id="nav-search-btn" aria-label="Submit Search"><i class="bi bi-search"></i></button>
							</div>
						</form>
					</li>
				</ul>
			</div>
			<div class="collapse position-absolute end-0 start-0 vh-100 bg-white px-5 overflow-scroll" id="navbarSearch">
				<div class="row">
					<div class="col-12">
						<form action="<?= caNavUrl($this->request, '', 'Search', 'objects'); ?>">
							<div class="input-group mt-4">
								<label for="nav-search-input" class="form-label visually-hidden">Search</label>
								<input type="text" name="search" class="form-control rounded-0 border-black" id="nav-search-input" placeholder="Search...">
								<button type="submit" class="btn rounded-0" id="nav-search-btn" aria-label="Submit Search"><i class="bi bi-search"></i></button>
							</div>
						</form>
					</div>
				</div>
				<div class="row pt-5">
<?php
				# --- Suggested search terms
				# --- entity set
				$access_values = caGetUserAccessValues($this->request);
				if($search_terms_entity_set_code = $this->request->config->get("search_terms_entity_set")){
					$search_terms_entity_ids =array();
					$t_set = new ca_sets();
					$t_set->load(['set_code' => $search_terms_entity_set_code]);
					// Enforce access control on set
					if((sizeof($access_values) == 0) || (sizeof($access_values) && in_array($t_set->get("access"), $access_values))){
						$search_terms_entity_ids = array_keys(is_array($tmp = $t_set->getItemRowIDs(['checkAccess' => $access_values, 'shuffle' => false])) ? $tmp : []);
						$entity_results = caMakeSearchResult('ca_entities', $search_terms_entity_ids);
						if($entity_results->numHits()){
?>
							<div class="col-12 col-md-4">
								<ul class="list-unstyled">
									<li><div class="text-body-tertiary">Featured Faculty:</div></li>
<?php
									while($entity_results->nextHit()){
										print "<li>&mdash; ".caNavlink($this->request, $entity_results->get("ca_entities.preferred_labels.displayname"), "", "", "Browse", "objects", array("facet" => "entity_facet", "id" => $entity_results->get("ca_entities.entity_id")))."</li>";
										
									}
?>
								</ul>
							</div>

<?php				
						}
					}
				}
				# worktypes
				$t_list = new ca_lists();
				$va_list_items = $t_list->getItemsForList("work_type", array("checkAccess" => $va_access_values));
				if(is_array($va_list_items) && sizeof($va_list_items)){
?>
							<div class="col-12 col-md-4">
								<ul class="list-unstyled">
									<li><div class="text-body-tertiary">Work Types:</div></li>
<?php
										foreach($va_list_items as $va_list_item){
											$va_list_item = array_pop($va_list_item);
											print "<li>&mdash; ".caNavlink($this->request, $va_list_item["name_singular"], "", "", "Browse", "objects", array("facet" => "work_type_facet", "id" => $va_list_item["item_id"]))."</li>";										
										}
?>
								</ul>
							</div>
<?php
				}		
				# --- collections set - same as one shown on home page
				if($search_terms_collection_set_code = $this->request->config->get("search_terms_collections_set")){
					$search_terms_collection_ids =array();
					$t_set = new ca_sets();
					$t_set->load(['set_code' => $search_terms_collection_set_code]);
					// Enforce access control on set
					if((sizeof($access_values) == 0) || (sizeof($access_values) && in_array($t_set->get("access"), $access_values))){
						$search_terms_collection_ids = array_keys(is_array($tmp = $t_set->getItemRowIDs(['checkAccess' => $access_values, 'shuffle' => false])) ? $tmp : []);
						$collection_results = caMakeSearchResult('ca_collections', $search_terms_collection_ids);
						if($collection_results->numHits()){
?>
							<div class="col-12 col-md-4">
								<ul class="list-unstyled">
									<li><div class="text-body-tertiary">Collections:</div></li>
<?php
									$i = 0;
									while($collection_results->nextHit()){
										print "<li>&mdash; ".caNavlink($this->request, $collection_results->get("ca_collections.preferred_labels.name"), "", "", "Browse", "objects", array("facet" => "collection_facet", "id" => $collection_results->get("ca_collections.collection_id")))."</li>";
										$i++;
										if($i == 10){
											break;
										}
									}
?>
								</ul>
							</div>
<?php				
						}
					}
				}
?>
				</div>
			</div>
		</div>
	</nav>	

	<main <?= caGetPageCSSClasses(); ?>><a name="page-content"></a>
		<div class='container-xxl main-container'>