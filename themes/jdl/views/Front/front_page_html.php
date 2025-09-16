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

	$access_values = $this->getVar("access_values");
	$o_config = $this->getVar("config");
	$vs_hero = $this->request->getParameter("hero", pString);
	if(!$vs_hero){
 		$vs_hero = rand(1, 3);
	}
?>

<div class="container-flex">
	<div class="parallax hero<?php print $vs_hero; ?>">
		<div class="container-fluid h-100">
			<div class="row justify-content-end h-100">
				<div class="col-md-6 col-lg-6 col-xl-5 d-flex h-100 bg-dark shadow align-items-center">
					<div class="text-bg-dark text-center w-100 parallax-search">
						<div class="pb-3">
							<div class="fs-3 Gotham-Book">Welcome to</div>
							<div class="pt-2 display-5">Jackson District Library<br/>Local History Archive</div>
						</div>
						<form role="search" action="<?= caNavUrl($this->request, '', 'Search', 'GeneralSearch'); ?>">
							<div class="input-group px-4">
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
						print "<div class='display-4 lh-base'>".$vs_hp_intro_title."</div>";
					}
					if($vs_hp_intro){
						print "<div class='display-6 lh-base Gotham-Book'>".$vs_hp_intro."</div>";
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
	#TODO: this is broken
	#print $this->render("Front/gallery_slideshow_html.php");

	# --- display 1 featured gallery
	#print $this->render("Front/featured_gallery_html.php");

?>
<div class="container">
	<div class="row justify-content-center text-center">
		<div class="col-md-10 hpExplore my-5 pb-5">
			<H2 class="mb-3">Explore The Archive</H2>
			<div class="row g-0">
				<div class="col-md-4 hpExploreBlock hpExploreBlock bg-darkblue">
					<?php print caNavLink($this->request, "<div class='p-5'>".caGetThemeGraphic($this->request, "hero_1.jpg", array("alt" => "explore image", "class" => "object-fit-cover w-100 shadow"))."<div class='fw-medium fs-4 pt-2'>AV Materials</div><div class='py-1'>&mdash;</div><div>".$this->getVar("hp_av_materials_desc")."</div></div>", "", "", "Browse", "objects"); ?>
				</div>
				<div class="col-md-4 hpExploreBlock bg-lightblue">
					<?php print caNavLink($this->request, "<div class='p-5'>".caGetThemeGraphic($this->request, "hero_1.jpg", array("alt" => "explore image", "class" => "object-fit-cover w-100 shadow"))."<div class='fw-medium fs-4 pt-2'>Documents</div><div class='py-1'>&mdash;</div><div>".$this->getVar("hp_documents_desc")."</div><div></div></div>", "", "", "Gallery", "Index"); ?>
				</div>
				<div class="col-md-4 hpExploreBlock bg-lightgreen">
					<?php print caNavLink($this->request, "<div class='p-5'>".caGetThemeGraphic($this->request, "hero_1.jpg", array("alt" => "explore image", "class" => "object-fit-cover w-100 shadow"))."<div class='fw-medium fs-4 pt-2'>Ephemera</div><div class='py-1'>&mdash;</div><div>".$this->getVar("hp_ephemera_desc")."</div><div></div></div>", "", "", "Collections", "Index"); ?>
				</div>
			</div>
			<div class="row g-0">
				<div class="col-md-4 hpExploreBlock hpExploreBlock bg-darkgreen">
					<?php print caNavLink($this->request, "<div class='p-5'>".caGetThemeGraphic($this->request, "hero_1.jpg", array("alt" => "explore image", "class" => "object-fit-cover w-100 shadow"))."<div class='fw-medium fs-4 pt-2'>Images</div><div class='py-1'>&mdash;</div><div>".$this->getVar("hp_images_desc")."</div></div>", "", "", "Browse", "objects"); ?>
				</div>
				<div class="col-md-4 hpExploreBlock bg-orange">
					<?php print caNavLink($this->request, "<div class='p-5'>".caGetThemeGraphic($this->request, "hero_1.jpg", array("alt" => "explore image", "class" => "object-fit-cover w-100 shadow"))."<div class='fw-medium fs-4 pt-2'>Publications</div><div class='py-1'>&mdash;</div><div>".$this->getVar("hp_publications_desc")."</div><div></div></div>", "", "", "Gallery", "Index"); ?>
				</div>
				<div class="col-md-4 hpExploreBlock bg-purple">
					<?php print caNavLink($this->request, "<div class='p-5'>".caGetThemeGraphic($this->request, "hero_1.jpg", array("alt" => "explore image", "class" => "object-fit-cover w-100 shadow"))."<div class='fw-medium fs-4 pt-2'>Scrapbooks</div><div class='py-1'>&mdash;</div><div>".$this->getVar("hp_scrapbooks_desc")."</div><div></div></div>", "", "", "Collections", "Index"); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid bg-light py-5 mb-5">
<div class="container hpNewsCollections">
	<div class="row">









<?php
	
if($collection_set_code = $o_config->get("collection_set_code")){
	$t_set = new ca_sets();
	$t_set->load(['set_code' => $collection_set_code]);
	$shuffle = (bool)$o_config->get("collection_set_random");
	
	if($t_set->get("ca_sets.set_id")){
		// Enforce access control on set
		if((sizeof($access_values) == 0) || (sizeof($access_values) && in_array($t_set->get("access"), $access_values))){
			$featured_ids = array_keys(is_array($tmp = $t_set->getItemRowIDs(['checkAccess' => $access_values, 'shuffle' => $shuffle])) ? $tmp : []);
		}
		if(sizeof($featured_ids)){
?>
			<div class="col-12 col-md-4">
				<H3 class="fs-4 pb-1">Featured Collections</H3>

<?php
			$qr_res = caMakeSearchResult("ca_collections", $featured_ids);
			if($qr_res && $qr_res->numHits()){
				while($qr_res->nextHit()){
					print "<div class='pt-2'>".$qr_res->getWithTemplate("<l>^ca_collections.preferred_labels</l>")."</div>";					
				}
			}
			print "<div class='pt-4'>".caNavLink($this->request, "All Collections", "btn btn-primary", "", "Collections", "Index")."</div>";
?>
			</div>
<?php
		}
	}
}
?>
		<div class="col-12 col-md-8 border-start">
			<H4 class="fs-4">Latest News</H4>
			{{{hp_latest_news}}}
		</div>
	</div>
</div></div>
<div class="container my-5 pt-5">
	<div class="row justify-content-center"><div class="col-12 col-xl-10">
<?php
	#TODO: this does not render
	print $this->render("Front/featured_set_grid_html.php");

?>
	</div></div>
</div>
<div class="container-flex">
	<div class="fade-out bg-black bg-opacity-25 text-bg-dark p-3 text-center shadow w-100 fixed-bottom display-4"><i class="bi bi-chevron-down"></i></div>
</div>