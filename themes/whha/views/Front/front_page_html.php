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
?>


<!--<div class="container-lg mt-5">
	<div class="img-fluid shadow border border-white p-2"><?php print caGetThemeGraphic($this->request, "WHWHP_LandingPage_H.png", array("class" => "border border-white shadow", "alt" => "White House Workers History Project and collage of workers' silhouettes in window frame")); ?></div>
</div>-->
<div class="position-relative img-fluid">
	<?php print caGetThemeGraphic($this->request, "bg_windows_hero.png", array("alt" => "Workers in Windows")); ?>

	<div class="container-fluid h-100 position-absolute top-0">
		<div class="row h-100 justify-content-center align-items-center heroLogo">
			<div class="col-md-4 img-fluid">
				<?php print caGetThemeGraphic($this->request, "WHWHP_Text_Stacked.png", array("alt" => "White House Workers History Project")); ?>
				<div class="row justify-content-center heroSearch">
					<div class="col-md-10 pt-3 mt-3">
						<form role="search" action="<?= caNavUrl($this->request, '', 'Search', 'Workers'); ?>">
							<div class="input-group">
								<label for="heroSearchInput" class="form-label visually-hidden">Search</label>
								<input name="search" type="text" class="form-control rounded-0 border-black" id="heroSearchInput" placeholder="Find workers" aria-label="Search Bar">
								<button type="submit" class="btn btn-primary ms-3" id="heroSearchButton" aria-label="Search button">Search</button>
							</div>
							<div class="form-text mt-1"><?= caNavLink($this->request, _t("Advanced search"), "", "", "Search", "advanced/workers"); ?></div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	$vs_hp_intro = $this->getVar("hp_intro");
	if($vs_hp_intro){
?>
		<div class="container mt-n5">
			<div class="row justify-content-center mt-n5">
				<div class="col-md-6 mb-5 pb-5 text-center mt-n5">
<?php
					if($vs_hp_intro){
						print "<div class='display-3 lh-sm'>".$vs_hp_intro."</div>";
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
		<div class="col-md-10 hpExplore py-5">
			<H2 class="display-4 mb-3">Explore</H2>
			<div class="row g-5">
				<div class="col-md-6 mb-5">
					<?php print caNavLink($this->request, "<div class='exploreItem h-100'><div class='exploreItemImg large'>".caGetThemeGraphic($this->request, "explore_workers.jpg", array("alt" => "explore workers", "class" => "object-fit-cover w-100 shadow"))."</div><div class='exploreItemLabel large align-content-center'>Workers</div></div>", "text-decoration-none h-100", "", "Browse", "workers"); ?>	
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-12 pb-5 pb-lg-0 mb-5">
							<?php print caNavLink($this->request, "<div class='exploreItem'><div class='exploreItemImg'>".caGetThemeGraphic($this->request, "explore_occupations.jpg", array("alt" => "explore occupations", "class" => "object-fit-cover w-100 shadow"))."</div><div class='exploreItemLabel align-content-center'>Occupations</div></div>", "text-decoration-none h-100", "", "Occupations", "index"); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-12 pb-5 pb-lg-0 mb-5">
							<?php print caNavLink($this->request, "<div class='exploreItem'><div class='exploreItemImg'>".caGetThemeGraphic($this->request, "explore_presidencies.jpg", array("alt" => "explore presidencies", "class" => "object-fit-cover w-100 shadow"))."</div><div class='exploreItemLabel align-content-center'>Presidencies</div></div>", "text-decoration-none h-100", "", "Browse", "presidencies"); ?>
						</div>
					</div>
				</div>
			</div>
			<div class="row g-5">
				<div class="col-md-6 pb-5 pb-lg-0">
					<?php print caNavLink($this->request, "<div class='exploreItem'><div class='exploreItemImg'>".caGetThemeGraphic($this->request, "explore_birthplace.jpg", array("alt" => "explore birth and burial map", "class" => "object-fit-cover w-100 shadow"))."</div><div class='exploreItemLabel align-content-center'>Birth & Burial Map</div></div>", "text-decoration-none h-100", "", "Browse", "birth_burial_map"); ?>
				</div>
				<div class="col-md-6 pb-5 pb-lg-0">
					<?php print caNavLink($this->request, "<div class='exploreItem'><div class='exploreItemImg'>".caGetThemeGraphic($this->request, "explore_collections.jpg", array("alt" => "explore stories", "class" => "object-fit-cover w-100 shadow"))."</div><div class='exploreItemLabel align-content-center'>Collections</div></div>", "text-decoration-none h-100", "", "Gallery", "index"); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="section-dark-gray-linen">
	<div class="container-lg">
		<div class="row justify-content-center my-5">
			<div class="col-md-10">
				<div class="row">
					<div class="col-12">
						<h2 class="text-white display-4 mb-3">Featured Collection</h2>
					</div>
				</div>
<?php
	print $this->render("Front/featured_gallery_html.php");

?>
			</div>
		</div>
	</div>
</div>