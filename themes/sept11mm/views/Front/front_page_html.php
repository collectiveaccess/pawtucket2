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
					<div class="bg-white p-5 text-center shadow w-100">
						<div class="pb-3">
							<div class="display-4 fw-medium">Inside the Collection</div>
						</div>
						<div class="fs-4 pt-1">{{{hp_search_text}}}</div>
						<form role="search" action="<?= caNavUrl($this->request, '', 'Search', 'GeneralSearch'); ?>">
							<div class="input-group pb-3">
								<label for="heroSearchInput" class="form-label visually-hidden">Search</label>
								<input name="search" type="text" class="form-control rounded-0 border-black" id="heroSearchInput" placeholder="Search" aria-label="Search Bar">
								<button type="submit" class="btn bg-primary text-white ms-1" id="heroSearchButton" aria-label="Search button"><i class="bi bi-search"></i></button>
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
				<div class="col-md-8 mt-5 pt-5 text-left">
<?php
					if($vs_hp_intro_title){
						print "<div class='display-1 lh-base border-bottom border-black pb-4 mb-4'>".$vs_hp_intro_title."</div>";
					}
					if($vs_hp_intro){
						print "<div class='display-6 lh-base pt-2'>".$vs_hp_intro."</div>";
					}
?>		
				</div>
			</div>
		</div>
<?php
	}
?>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 mt-5 pt-5 text-left">
			<div class="img-fluid pb-2">
				<?php print caGetThemeGraphic($this->request, "hp_objects.jpg", array("alt" => "Image of evidence tag, hat and badge")); ?>
			</div>
			<div class="small pb-4 fw-bold fs-6"><div class="float-end ps-3">Photo by Matt Flynn</div>Collection 9/11 Memorial Museum, Gift of Retired Port Authority of NY&NJ Police Officer Sharon A. Miller.</div>
			<H2 class="pt-2">Archival Objects</H2>
			<div class="fs-5 pb-2">
				{{{hp_objects}}}
			</div>
			<div class="mb-5 mt-2">
				<?php print caNavLink($this->request, "Browse Archival Objects", "btn btn-primary", "", "Browse", "objects"); ?>
			</div>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-md-8 mt-5 pt-5 text-left">
			<div class="img-fluid pb-2">
				<?php print caGetThemeGraphic($this->request, "hp_OralHistories.jpg", array("alt" => "Image of oral history being recorded")); ?>
			</div>
			<div class="small pb-4 fw-bold fs-6 text-end">Photo by Jin S. Lee</div>
			<H2 class="pt-2">Oral Histories</H2>
			<div class="fs-5 pb-2">
				{{{hp_oral_histories}}}
			</div>
			<div class="mb-5 mt-2">
				<?php print caNavLink($this->request, "Browse Oral Histories", "btn btn-primary", "", "Browse", "oral_histories"); ?>
			</div>
		</div>
	</div>	
	<div class="row justify-content-center">
		<div class="col-md-8 mt-5 pt-5 text-left">
			<div class="img-fluid pb-2">
				<?php print caGetThemeGraphic($this->request, "hp_boards.jpg", array("alt" => "Image of LMDC Board")); ?>
			</div>
			<div class="small pb-4 fw-bold fs-6">"Reflecting Absence" by Michael Arad</div>
			<H2 class="pt-2">LMDC Boards</H2>
			<div class="fs-5 pb-2">
				{{{hp_boards}}}
			</div>
			<div class="mb-5 mt-2">
				<?php print caNavLink($this->request, "Browse LMDC Boards", "btn btn-primary", "", "Browse", "boards"); ?>
			</div>
		</div>
	</div>
</div>
<?php
	# --- display galleries as a grid?
	print $this->render("Front/gallery_grid_html.php");
?>
<div class="container-flex">
	<div class="fade-out bg-black bg-opacity-25 text-bg-dark p-3 text-center shadow w-100 fixed-bottom display-4"><i class="bi bi-chevron-down"></i></div>
</div>