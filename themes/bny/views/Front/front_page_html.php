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
 		$vs_hero = rand(1, 1);
	}
?>

<div class="container-flex">
	<div class="parallax hero<?php print $vs_hero; ?>">
		<div class="container h-75">
			<div class="row justify-content-center h-100">
				<div class="col-md-12 d-flex h-100 align-items-center">
					<div class="w-100 text-center">
						<H1 class="text-white display-1">BNYDC Archives</H1>
						<div class="w-50 d-inline-block">
						<form role="search" action="<?= caNavUrl($this->request, '', 'Search', 'GeneralSearch'); ?>">
							<div class="input-group pt-1 pb-3">
								<label for="heroSearchInput" class="form-label visually-hidden">Search the Archives</label>
								<input name="search" type="text" class="bg-white form-control rounded-0 border-0" id="heroSearchInput" placeholder="Search the Archives" aria-label="Search Bar">
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
<div class="pt-1 pe-2 text-end"><?php print caDetailLink($this->request, "Brooklyn Navy Yard, Circa 1904", "", "ca_objects", "14473"); ?></div>

<?php
	$vs_hp_intro_title = $this->getVar("hp_intro_title");
	$vs_hp_intro = $this->getVar("hp_intro");
	if($vs_hp_intro_title || $vs_hp_intro){
?>
		<div class="container my-5 py-5">
			<div class="row gx-md-5 align-items-center">
				<div class="col-sm-12 col-md-6 text-start">
<?php
					if($vs_hp_intro_title){
						print "<H2>".$vs_hp_intro_title."</H2>";
					}
					if($vs_hp_intro){
						print "<div class='display-6 lh-base'>".$vs_hp_intro."</div>";
					}
					print "<div class='pt-4 mb-5 mb-md-0 text-center text-md-start'>".caNavLink($this->request, "Browse Objects", "btn btn-primary", "", "Browse", "objects")."</div>";
				
?>		
				</div>
				<div class="col-sm-12 col-md-6 img-fluid">
					<?= caGetThemeGraphic($this->request, 'women.jpeg', array("alt" => "Image of women at the Navy Yard")); ?>
					<div class="small pt-2 text-center">Antoinette Mauro and colleagues. Courtesy of the Antoinette Mauro collection, BNYDC Archives, Brooklyn, NY.</div>
				</div>
			</div>
		</div>
<?php
	}



	# --- display 1 featured gallery
	print $this->render("Front/featured_gallery_html.php");
	print $this->render("Front/featured_collections_set_grid_html.php");

	# --- display slideshow of random images
	#print $this->render("Front/featured_set_slideshow_html.php");
?>

<div class="container-flex">
	<div class="fade-out bg-black bg-opacity-25 text-bg-dark p-3 text-center shadow w-100 fixed-bottom display-4"><i class="bi bi-chevron-down"></i></div>
</div>