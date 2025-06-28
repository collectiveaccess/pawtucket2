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
				<div class="col-12 d-flex h-100 align-items-center">
					<div class="text-white p-5 text-center w-100">
						<div class="py-3">
							<div class="pt-2 display-3 fw-medium hpHeroText">{{{srsc_hp_search_text}}}</div>
						</div>
						<div class="row justify-content-center">
							<div class="col-12 col-lg-8 col-xl=6">
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
	</div>
</div>
<?php
	$vs_hp_intro_title = $this->getVar("srsc_hp_intro_title");
	$vs_hp_intro = $this->getVar("srsc_hp_intro");
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
<div class="bg-body-tertiary"><div class="container bg-body-tertiary">
	<div class="row justify-content-center text-center">
		<div class="col-lg-12 col-xl-10 my-5 hpBoxes">
			<div class="row">
				<div class="col-md-4">
					<?php print caNavLink($this->request, "<div class='hpBox position-relative'>".caGetThemeGraphic($this->request, "hpSchoolIllustration.jpg", array("alt" => "Illustration of Shingwauk Home in Sault Ste. Marie, Ontario", "class" => "object-fit-cover w-100 shadow"))."<div class='position-absolute top-0 w-100 h-100 fw-bold fs-3 text-white'>Schools</div></div>", "", "", "Schools", "index"); ?>
				</div>
				<div class="col-md-4">
					<?php print caNavLink($this->request, "<div class='hpBox position-relative'>".caGetThemeGraphic($this->request, "hpCollections.jpg", array("alt" => "Circle of people in field", "class" => "object-fit-cover w-100 shadow"))."<div class='position-absolute top-0 w-100 h-100 fw-bold fs-3 text-white'>Collections</div></div>", "", "", "Browse", "collections"); ?>
				</div>
				<div class="col-md-4">
					<?php print caNavLink($this->request, "<div class='hpBox position-relative'>".caGetThemeGraphic($this->request, "hpFiles.jpg", array("alt" => "Shingwauk Reunion '81 Schedule of Events cover", "class" => "object-fit-cover w-100 shadow"))."<div class='position-absolute top-0 w-100 h-100 fw-bold fs-2 text-white'>Files</div></div>", "", "", "Browse", "files"); ?>
				</div>
			</div>
		</div>
	</div>
</div></div>
<?php
	# --- display slideshow of random images
	#print $this->render("Front/featured_set_slideshow_html.php");
?>