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

<div class="bg-black">
<div class="container-flex mx-4 pt-4">
	<div class="parallax hero<?php print $vs_hero; ?>">
		<div class="row h-100">
			<div class="col-md-9 col-lg-6 col-xl-5">
				<div class="bg-black text-bg-dark p-5 shadow w-100 h-100 align-items-center">
					<div class="py-5 my-5">
						<div class="py-3">
							<div class="fs-2 fw-light ">Welcome to the</div>
							<div class="pt-2 display-3 fw-medium">Art21 Archive</div>
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
	if($x && ($vs_hp_intro_title || $vs_hp_intro)){
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

?>
	<div class="container-flex mx-4">
		<div class="row justify-content-center">
			<div class="col-12 hpExplore mb-5 pb-5 mt-3">
				<hr class="border-white"/>
				<div class="mx-4 pt-1">
					<H2 class="mb-3 text-white fs-4 fw-bold mb-5">Explore The Art21 Archive</H2>
					<div class="row g-5">
						<div class="col-md-4">
							<?php print caNavLink($this->request, "<div>".caGetThemeGraphic($this->request, "explore1.jpg", array("alt" => "explore image", "class" => "object-fit-cover w-100 shadow"))."<div class='fw-bold fs-4 mt-3'>Footage Archive</div><div>".$this->getVar("hp_footage")."</div></div>", "text-white text-decoration-none", "", "Browse", "projects"); ?>
						</div>
						<div class="col-md-4">
							<?php print caNavLink($this->request, "<div>".caGetThemeGraphic($this->request, "explore2.jpg", array("alt" => "explore image", "class" => "object-fit-cover w-100 shadow"))."<div class='fw-bold fs-4 mt-3'>Film Library</div><div>".$this->getVar("hp_film_library")."</div></div>", "text-white text-decoration-none", "", "Collections", "Index"); ?>
						</div>
						<div class="col-md-4">
							<?php print caNavLink($this->request, "<div>".caGetThemeGraphic($this->request, "explore3.jpg", array("alt" => "explore image", "class" => "object-fit-cover w-100 shadow"))."<div class='fw-bold fs-4 mt-3'>Artists</div><div>".$this->getVar("hp_artists")."</div></div>", "text-white text-decoration-none", "", "Browse", "Artists"); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	# --- display grid of featured set of finished films
	print $this->render("Front/featured_set_grid_html.php");
	# --- display grid of featured set of artists
	print $this->render("Front/featured_set_grid_entities_html.php");
?>

<div class="container-flex">
	<div class="fade-out bg-black bg-opacity-25 text-bg-dark p-3 text-center shadow w-100 fixed-bottom display-4"><i class="bi bi-chevron-down"></i></div>
</div>