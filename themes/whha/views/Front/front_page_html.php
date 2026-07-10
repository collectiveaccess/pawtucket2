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
<div class="img-fluid"><?php print caGetThemeGraphic($this->request, "WHWHP_LandingPage_H.png", array("alt" => "White House Workers History Project and collage of workers' silhouettes in window frame")); ?></div>

<?php
	$vs_hp_intro_title = $this->getVar("hp_intro_title");
	$vs_hp_intro = $this->getVar("hp_intro");
	if($vs_hp_intro_title || $vs_hp_intro){
?>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 my-5 pt-5 text-center">
<?php
					if($vs_hp_intro_title){
						print "<div class='display-5 pb-3'>".$vs_hp_intro_title."</div>";
					}
					if($vs_hp_intro){
						print "<div class='display-6'>".$vs_hp_intro."</div>";
					}
?>		
					<div class="pt-5">
						<form role="search" action="<?= caNavUrl($this->request, '', 'Search', 'Workers'); ?>">
							<div class="input-group pb-3">
								<label for="heroSearchInput" class="form-label visually-hidden">Search</label>
								<input name="search" type="text" class="form-control rounded-0 border-0" id="heroSearchInput" placeholder="Find workers" aria-label="Search Bar">
								<button type="submit" class="btn btn-primary ms-2" id="heroSearchButton" aria-label="Search button">Search</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
<?php
	}
?>
<div class="container">
	<div class="row justify-content-center text-center">
		<div class="col-md-10 hpExplore py-5">
			<H2 class="mb-3">Explore</H2>
			<div class="row">
				<div class="col-md-6 col-lg-3 pb-5 pb-lg-0">
					<?php print caNavLink($this->request, "<div class='exploreItem'><div class='exploreItemImg'>".caGetThemeGraphic($this->request, "explore_workers.jpg", array("alt" => "explore workers", "class" => "object-fit-cover w-100 shadow"))."</div><div class='exploreItemLabel'>Workers</div></div>", "text-decoration-none h-100", "", "Browse", "workers"); ?>
				</div>
				<div class="col-md-6 col-lg-3 pb-5 pb-lg-0">
					<?php print caNavLink($this->request, "<div class='exploreItem'><div class='exploreItemImg'>".caGetThemeGraphic($this->request, "explore_administrations.jpg", array("alt" => "explore administrations", "class" => "object-fit-cover w-100 shadow"))."</div><div class='exploreItemLabel'>Administrations</div></div>", "text-decoration-none h-100", "", "Browse", "administrations"); ?>
				</div>
				<div class="col-md-6 col-lg-3 pb-5 pb-lg-0">
					<?php print caNavLink($this->request, "<div class='exploreItem'><div class='exploreItemImg'>".caGetThemeGraphic($this->request, "explore_birthplace.jpg", array("alt" => "explore birth and burial map", "class" => "object-fit-cover w-100 shadow"))."</div><div class='exploreItemLabel'>Birth & Burial Map</div></div>", "text-decoration-none h-100", "", "Browse", "birth_burial_map"); ?>
				</div>
				<div class="col-md-6 col-lg-3 pb-5 pb-lg-0">
					<?php print caNavLink($this->request, "<div class='exploreItem'><div class='exploreItemImg'>".caGetThemeGraphic($this->request, "explore_stories.jpg", array("alt" => "explore stories", "class" => "object-fit-cover w-100 shadow"))."</div><div class='exploreItemLabel'>Stories</div></div>", "text-decoration-none h-100", "", "Gallery", "index"); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="section-blue-linen">
	<div class="container-lg">
		<div class="row justify-content-center my-5">
			<div class="col-md-10">
				<div class="row">
					<div class="col-6">
						<h2 class="text-white display-3">Stories</h2>
					</div>
					<div class="col-6 border-start border-white text-white fs-4">
						<?= $this->getVar("hp_stories_text"); ?>
					</div>
				</div>
<?php
	print $this->render("Front/gallery_grid_html.php");

?>
			</div>
		</div>
	</div>
</div>
<?php
	$t_list = new ca_lists();
	$occupations = $t_list->getItemsForList("occupation", array("labelsOnly" => true));
	if(is_array($occupations) && sizeof($occupations)){
?>
<div class="bg-white">
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-md-10 hpOccupation py-5">
				<H2 class="mb-3 text-center">Browse by Occupation</H2>
				<div class="row justify-content-center">
<?php
				foreach($occupations as $occ_id => $occ_name){
					print "<div class='col-6 col-sm-3'>".caNavLink($this->request, "<div class='hpOccupationItem'>".$occ_name."</div>", "h-100 display-block", "", "Browse", "workers", array("facet" => "occupation_facet", "id" => $occ_id))."</div>";
				
				}
?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	}
?>
<div class="container-flex">
	<div class="fade-out bg-black bg-opacity-25 text-bg-dark p-3 text-center shadow w-100 fixed-bottom display-4"><i class="bi bi-chevron-down"></i></div>
</div>