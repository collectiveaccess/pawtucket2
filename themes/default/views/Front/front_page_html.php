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
		<div class="container h-75">
			<div class="row justify-content-center h-100">
				<div class="col-md-9 col-lg-6 col-xl-5 d-flex h-100 align-items-center">
					<div class="bg-black bg-opacity-75 text-bg-dark p-5 text-center shadow w-100">
						<div class="py-3">
							<div class="fs-2 fw-light ">Welcome to</div>
							<div class="pt-2 display-3 fw-medium">Site Name</div>
						</div>
						<div class="fs-4 pt-1">{{{hp_search_text}}}</div>
						<form role="search" action="<?= caNavUrl($this->request, '', 'Search', 'GeneralSearch'); ?>">
							<div class="input-group pb-3">
								<label for="heroSearchInput" class="form-label visually-hidden">Search</label>
								<input name="search" type="text" class="form-control rounded-0 border-0" id="heroSearchInput" placeholder="Search" aria-label="Search Bar">
								<button type="submit" class="btn rounded-0 bg-white" id="heroSearchButton" aria-label="Search button"><i class="bi bi-search"></i></button>
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



	# --- display galleries as a grid?
	#print $this->render("Front/gallery_grid_html.php");
	# --- display galleries as a slideshow?
	#print $this->render("Front/gallery_slideshow_html.php");
	# --- display 1 featured gallery
	print $this->render("Front/featured_gallery_html.php");

?>
<div class="container">
	<div class="row justify-content-center text-center">
		<div class="col-md-10 hpExplore my-5 py-5">
			<H2 class="mb-3">Explore The Archive</H2>
			<div class="row">
				<div class="col-md-4">
					<?php print caNavLink($this->request, "<div>".caGetThemeGraphic($this->request, "hero_1.jpg", array("alt" => "explore image", "class" => "object-fit-cover w-100 shadow"))."<div class='fw-medium fs-4 pt-1'>Browse Objects</div></div>", "", "", "Browse", "objects"); ?>
				</div>
				<div class="col-md-4">
					<?php print caNavLink($this->request, "<div>".caGetThemeGraphic($this->request, "hero_1.jpg", array("alt" => "explore image", "class" => "object-fit-cover w-100 shadow"))."<div class='fw-medium fs-4 pt-1'>Gallery</div></div>", "", "", "Gallery", "Index"); ?>
				</div>
				<div class="col-md-4">
					<?php print caNavLink($this->request, "<div>".caGetThemeGraphic($this->request, "hero_1.jpg", array("alt" => "explore image", "class" => "object-fit-cover w-100 shadow"))."<div class='fw-medium fs-4 pt-1'>Collections</div></div>", "", "", "Collections", "Index"); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	# --- display slideshow of random images
	print $this->render("Front/featured_set_slideshow_html.php");
?>
<div class="container">
	<div class="row justify-content-center my-5">
		<div class="col-10">
			<div id="carouselExampleIndicators" class="carousel slide">
				<div class="carousel-indicators">
					<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
					<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
					<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
				</div>
				<div class="carousel-inner">
					<div class="carousel-item active">
						<?php print caGetThemeGraphic($this->request, "hero_1.jpg", array("alt" => "explore image", "class" => "d-block w-100")); ?>
					</div>
					<div class="carousel-item">
						<?php print caGetThemeGraphic($this->request, "hero_1.jpg", array("alt" => "explore image", "class" => "d-block w-100")); ?>
					</div>
					<div class="carousel-item">
						<?php print caGetThemeGraphic($this->request, "hero_1.jpg", array("alt" => "explore image", "class" => "d-block w-100")); ?>
					</div>
				</div>
				<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</button>
			</div>
		</div>
	</div>
</div>
<div class="container-flex">
	<div class="fade-out bg-black bg-opacity-25 text-bg-dark p-3 text-center shadow w-100 fixed-bottom display-4"><i class="bi bi-chevron-down"></i></div>
</div>