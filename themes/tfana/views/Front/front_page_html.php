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

<div class="bg-dark">
	<div class="container-xxl pb-4">
		<div class="row">
			<div class="col-sm-12">
				<div class="bg-dark text-center pt-4 mt-2">
					<div class="row justify-content-center">
						<div class="col-sm-12">
							<h1 class="text-light">{{{hp_intro_title}}}</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div>		
	<div class="img-fluid">
<?php
			print caGetThemeGraphic($this->request, 'homeCollage2.jpg', array("alt" => "Collage of imagery from the TFANA collections"))
?>
	</div>
</div>
<div class="bg-dark">
	<div class="container-xxl mb-4">
		<div class="row">
			<div class="col-sm-12">
				<div class="bg-dark text-center pb-4 mb-2">
					<div class="row justify-content-center">
						<div class="col-sm-12 col-md-8 col-lg-6">
	
							<div class="text-white display-6 pt-4 mt-4 pb-4">{{{hp_intro}}}</div>
							<div class="row justify-content-center">
								<div class="col-sm-12 col-md-8 col-lg-6">
									<form role="search" class='py-4' action="<?= caNavUrl($this->request, '', 'Search', 'GeneralSearch'); ?>">
										<div class="input-group pb-3">
											<label for="heroSearchInput" class="form-label visually-hidden">Search</label>
											<input name="search" type="text" class="form-control rounded-0 border-0" id="heroSearchInput" placeholder="Search the archive" aria-label="Search Bar">
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
</div>
<?php



	# --- display galleries as a grid?
	#print $this->render("Front/gallery_grid_html.php");
	# --- display galleries as a slideshow?
	#print $this->render("Front/gallery_slideshow_html.php");
	# --- display 1 featured gallery
	#print $this->render("Front/featured_gallery_html.php");

?>
<div class="container-xxl text-center pb-4 mb-4">
	<div class="row pt-4 mt-4 mb-4 pb-4 justify-content-center">
		<div class="col-sm-12 col-md-8 col-lg-6">
			<h2 class="pt-4">{{{hp_productions_title}}}</h2>
			<div class="pb-4 mb-4">{{{hp_productions_text}}}</div>
			<div class="row justify-content-center">
				<div class="col-sm-12 col-md-12 col-lg-8 mb-4">
<?php
					print caNavLink($this->request, "Production Timeline<hr/>", "btn btn-featured btn-primary", "", "Browse", "seasons");
?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container-xxl sectionHighlight">
		<div class="container">
			<div class="hpExplore">
				<div class="row gx-5">
					<div class="col-md-6 mb-md-4 pb-md-4 mb-4 pb-4">
						<?php print caNavLink($this->request, caGetThemeGraphic($this->request, "featured.jpg", array("alt" => "black and white production still of dancers", "class" => "object-fit-cover w-100")), "", "", "Gallery", "Index"); ?>
						<hr/>
						<h3 class="mb-4">{{{hp_gallery_title}}}</h3>
						<div class="pb-4 mb-4">{{{hp_gallery_text}}}</div>
<?php
						print caNavLink($this->request, "View Features", "btn btn-primary", "", "Gallery", "index");
?>
					</div>
					<div class="col-md-6">
						<?php print caNavLink($this->request, caGetThemeGraphic($this->request, "collection.jpg", array("alt" => "black and white contact sheet", "class" => "object-fit-cover object-position-top w-100")), "", "", "Collections", "index"); ?>
						<hr/>
						<h3 class="mb-4">{{{hp_collections_title}}}</h3>
						<div class="pb-4 mb-4">{{{hp_collections_text}}}</div>
<?php
						print caNavLink($this->request, "View Collections", "btn btn-primary", "", "Collections", "index");
?>
					</div>
				</div>
			</div>
		</div>
</div>


<div class="container-fluid">
	<div class="fade-out bg-black bg-opacity-25 text-bg-dark p-3 text-center shadow w-100 fixed-bottom display-4"><i class="bi bi-chevron-down"></i></div>
</div>