<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */

	// print $this->render("Front/featured_set_slideshow_html.php");

	$va_access_values = $this->getVar("access_values");
	$vs_hero = $this->request->getParameter("hero", pString);
	if(!$vs_hero){
 		$vs_hero = rand(1, 3);
	}
?>

<div class="container-flex">
	<div class="parallax hero<?php print $vs_hero; ?>">
		<div class="container h-100">
			<div class="row h-100">
				<div class="col-md-12 col-lg-10 col-xl-10 d-flex h-100 align-items-center">
					<div class="text-white p-5 text-left w-100">
						<div class="py-3">
							<div class="fs-2 fw-light ">Welcome to the</div>
							<div class="pt-2 display-4 fw-medium">Engracia De Jesus Matias Archives & Special Collections at the Arthur A. Wishart Library</div>
						</div>
						<form role="search" action="<?= caNavUrl($this->request, '', 'Search', 'all_collections'); ?>">
							<div class="input-group pb-3 w-50">
								<label for="heroSearchInput" class="form-label visually-hidden">Search</label>
								<input name="search" type="text" class="form-control rounded-0 border-0" id="heroSearchInput" placeholder="Search" aria-label="Search Bar">
								<button type="submit" class="btn rounded-0 bg-white text-primary" id="heroSearchButton" aria-label="Search button"><i class="bi bi-search"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	$vs_hp_intro_title = $this->getVar("hp_intro_title");
	$vs_hp_intro = $this->getVar("hp_intro");
	if($vs_hp_intro_title || $vs_hp_intro){
?>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-10 my-5 py-5 text-center">
<?php
					if($vs_hp_intro_title){
						print "<div class='display-3 lh-base'>".$vs_hp_intro_title."</div>";
					}
					if($vs_hp_intro){
						print "<div class='display-5 lh-base'>".$vs_hp_intro."</div>";
					}
?>		
				</div>
			</div>
		</div>
<?php
	}
	print $this->render("Front/featured_collections_set_grid_html.php");
?>

	<div class="container pt-5">
		<div class="row align-items-center mb-5 pb-5">
			<div class="col-md-5 mb-3 mb-md-0">
				<H2 class="fw-semibold fs-3">Find Collections</H2>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				<div class="text-center my-4">
					<?= caNavLink($this->request, "Browse Collections", "btn btn-primary", "", "Browse", "collections"); ?>
				</div>
			</div>
			<div class="col-md-6 offset-md-1 img-fluid">
				<?= caNavLink($this->request, caGetThemeGraphic($this->request, 'frontCollections.jpg', array("alt" => "Page from CAS information sheets")), "", "", "Browse", "collections"); ?>
			</div>
		</div>
		<div class="row align-items-center mb-5 pb-5">
			<div class="col-md-6 img-fluid mb-3 mb-md-0">
				<?= caNavLink($this->request, caGetThemeGraphic($this->request, 'frontFiles.jpg', array("alt" => "Photo album image in balck and white")), "", "", "Browse", "files"); ?>
			</div>
			<div class="col-md-5 offset-md-1">
				<H2 class="fw-semibold fs-3">Explore Files</H2>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				
				<div class="text-center my-4">
					<?= caNavLink($this->request, "Browse Files", "btn btn-primary", "", "Browse", "files"); ?>
				</div>
			</div>
		</div>
		<div class="row align-items-center mb-5 pb-5">
			<div class="col-md-5 mb-3 mb-md-0">
				<H2 class="fw-semibold fs-3">About the Archive</H2>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				
				<div class="text-center my-4">
					<?= caNavLink($this->request, "Learn More", "btn btn-primary", "", "About", "index"); ?>
				</div>
			</div>
			<div class="col-md-6 offset-md-1 img-fluid">
				<?= caNavLink($this->request, caGetThemeGraphic($this->request, 'algoma-uni-fall.jpg', array("alt" => "Algoma University in the fall")), "", "", "About", "index"); ?>
			</div>
		</div>
	</div>
<div class="container-flex">
	<div class="fade-out bg-black bg-opacity-25 text-bg-dark p-3 text-center shadow w-100 fixed-bottom display-4"><i class="bi bi-chevron-down"></i></div>
</div>