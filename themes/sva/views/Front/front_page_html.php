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
					<div class="bg-body p-5 text-center shadow w-100">
						<div class="py-3 display-4 text-center">
							<div>Milton Glacier<br/>Design Study Center<br/>and Archives</div><div class='divide border-bottom border-black mt-2 mb-3 d-inline-block'></div><div>SVA Archives</div>
						</div>
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



	# --- display galleries as a slideshow?
	#print $this->render("Front/gallery_slideshow_html.php");
	# --- display 1 featured gallery
	#print $this->render("Front/featured_gallery_html.php");

?>

<div class="px-3"><div class="container-xxl">
	<div class="row justify-content-center text-center">
		<div class="col-xl-10 hpExplore my-5 py-5">
			<H2 class="mb-3">Collections</H2>
			<div class="row g-5">
				<div class="col-md-6">
					<?php print caDetailLink($this->request, "<div class='position-relative'>".caGetThemeGraphic($this->request, "homepage_milton_archives.jpg", array("alt" => "Colorful image of jazz musicians", "class" => "object-fit-cover w-100"))."<div class='position-absolute bottom-0 w-100'><div class='mb-4 mx-4'><div class='fw-medium fs-2 p-3 bg-body text-black'>Milton Glaser Design Archive</div></div></div></div>", "", "ca_collections", 369); ?>
					<div class='pt-3 text-start fs-4'>The Milton Glaser Design Study Center and Archives is dedicated to preserving and making accessible design works of significant artistic, cultural, and historical value by preeminent designers, illustrators, and art directors who have close ties to the School of Visual Arts.</div>
				</div>
				<div class="col-md-6">
					<?php print caDetailLink($this->request, "<div class='position-relative'>".caGetThemeGraphic($this->request, "homepage_sva_archives2.jpg", array("alt" => "Graphic design example displaying SVA", "class" => "object-fit-cover w-100"))."<div class='position-absolute bottom-0 w-100'><div class='mb-4 mx-4'><div class='fw-medium fs-2 p-3 bg-body text-black'>School of Visual Arts Collection</div></div></div></div>", "", "ca_collections", 368); ?>
					<div class='pt-3 text-start fs-4'>The School of Visual Arts Archives documents the history of the College and provides source material for those who seek to evaluate the impact of its activities within the context of the institution as well as on the art and design communities at large.</div>
				</div>
			</div>
		</div>
	</div>
</div></div>
<?php
	print $this->render("Front/featured_set_grid_html.php");
?>
<div class="container-xxl">
	<div class="fade-out bg-black bg-opacity-25 text-bg-dark p-3 text-center shadow w-100 fixed-bottom display-4"><i class="bi bi-chevron-down"></i></div>
</div>