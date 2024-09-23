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
				<div class="col-md-8 col-lg-6 col-xl-5 d-flex h-100 align-items-center">
					<div class="text-center w-100">
						<h1 class="text-white text-center">
							<div class="fs-2 fw-medium aleo">Theater for a New Audience</div>
							<div class="pt-2">Archives Online Collection</div>
						</h1>
						</h1>
						
						<div class="fs-4 pt-1 text-white">{{{hp_search_text}}}</div>
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
						print "<div class='display-3 lh-base aleo'>".$vs_hp_intro_title."</div>";
					}
					if($vs_hp_intro){
						print "<div class='display-5 lh-base aleo'>".$vs_hp_intro."</div>";
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
	#print $this->render("Front/featured_gallery_html.php");

?>
<div class="bg-body-tertiary"><div class="container bg-body-tertiary">
	<div class="row justify-content-center text-center">
		<div class="col-lg-12 col-xl-10 my-5 hpBoxes">
			<div class="row">
				<div class="col-md-4">
					<?php print caNavLink($this->request, "<div class='hpBox position-relative'>".caGetThemeGraphic($this->request, "blank.jpg", array("alt" => "productions image", "class" => "object-fit-cover w-100 shadow"))."<div class='position-absolute top-0 w-100 h-100 fw-bolder fs-3 text-white'>Productions</div></div>", "", "", "Browse", "Collections"); ?>
				</div>
				<div class="col-md-4">
					<?php print caNavLink($this->request, "<div class='hpBox position-relative'>".caGetThemeGraphic($this->request, "blankjpg", array("alt" => "people image", "class" => "object-fit-cover w-100 shadow"))."<div class='position-absolute top-0 w-100 h-100 fw-bolder fs-3 text-white'>People</div></div>", "", "", "Browse", "People"); ?>
				</div>
				<div class="col-md-4">
					<?php print caNavLink($this->request, "<div class='hpBox position-relative'>".caGetThemeGraphic($this->request, "blank.jpg", array("alt" => "archival items image", "class" => "object-fit-cover w-100 shadow"))."<div class='position-absolute top-0 w-100 h-100 fw-bolder fs-3 text-white'>Archival items</div></div>", "", "", "Browse", "Objects"); ?>
				</div>
			</div>
		</div>
	</div>
</div></div>

<!--<div class="container">
	<div class="row justify-content-center text-center">
		<div class="col-sm-8 col-md-12 col-lg-10 my-5 pt-5 hpExploreBoxes">
			<H2 class="mb-3">Explore</H2>
			<div class="row">
				<div class="col-md-6">
					<?php print caNavLink($this->request, "<div class='hpExploreBox hpExploreBoxLg position-relative'>".caGetThemeGraphic($this->request, "ElderProcessingFish.jpeg", array("alt" => "Woman with fish", "class" => "object-fit-cover w-100 shadow"))."<div class='position-absolute top-0 w-100 h-100 fw-bolder fs-3 text-white'>Photo</div></div>", "", "", "Browse", "archives", array("facet" => "material_designations_facet", "id" => "430")); ?>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-6">
							<?php print caNavLink($this->request, "<div class='hpExploreBox position-relative'>".caGetThemeGraphic($this->request, "hp_sound.jpg", array("alt" => "Person interviewing", "class" => "object-fit-cover w-100 shadow"))."<div class='position-absolute top-0 w-100 h-100 fw-bolder fs-3 text-white'>Sound</div></div>", "", "", "Browse", "archives", array("facet" => "material_designations_facet", "id" => "431")); ?>
						</div>
						<div class="col-md-6">
							<?php print caNavLink($this->request, "<div class='hpExploreBox position-relative'>".caGetThemeGraphic($this->request, "video.jpg", array("alt" => "Man using camera", "class" => "object-fit-cover w-100 shadow"))."<div class='position-absolute top-0 w-100 h-100 fw-bolder fs-3 text-white'>Video</div></div>", "", "", "Browse", "archives", array("facet" => "material_designations_facet", "id" => "432")); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<?php print caNavLink($this->request, "<div class='hpExploreBox position-relative'>".caGetThemeGraphic($this->request, "maps.jpg", array("alt" => "Man presenting with a map", "class" => "object-fit-cover w-100 shadow"))."<div class='position-absolute top-0 w-100 h-100 fw-bolder fs-3 text-white'>Maps</div></div>", "", "", "Browse", "archives", array("facet" => "material_designations_facet", "id" => "427")); ?>
						</div>
						<div class="col-md-6">
							<?php print caNavLink($this->request, "<div class='hpExploreBox position-relative'>".caGetThemeGraphic($this->request, "textual.jpg", array("alt" => "3 people reading a document", "class" => "object-fit-cover w-100 shadow"))."<div class='position-absolute top-0 w-100 h-100 fw-bolder fs-3 text-white'>Textual</div></div>", "", "", "Browse", "archives", array("facet" => "material_designations_facet", "id" => "426")); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>-->


<div class="container-flex">
	<div class="fade-out bg-black bg-opacity-25 text-bg-dark p-3 text-center shadow w-100 fixed-bottom display-4"><i class="bi bi-chevron-down"></i></div>
</div>