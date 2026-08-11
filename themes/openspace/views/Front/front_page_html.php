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
$access_values = $this->getVar("access_values");
$hero = $this->request->getParameter("hero", pString);
if(!$hero){
	$hero = rand(1, 3);
}
?>

<div class="container-flex">
	<div class="parallax hero<?= $hero; ?>">
		<div class="container h-75">
			<div class="row justify-content-center h-100">
				<div class="col-md-9 col-lg-6 col-xl-5 d-flex h-100 align-items-center">
					<div class="bg-black bg-opacity-75 text-bg-dark p-5 text-center shadow w-100">
						<div class="py-3">
							<div class="fs-2 fw-light ">Welcome to the</div>
							<div class="pt-2 display-3 fw-medium">Open Space Archive</div>
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
	$hp_intro_title = $this->getVar("hp_intro_title");
	$hp_intro = $this->getVar("hp_intro");
	if($hp_intro_title || $hp_intro){
?>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-10 my-5 py-5 text-center">
<?php
					if($hp_intro_title){
						print "<div class='display-3 lh-base'>".$hp_intro_title."</div>";
					}
					if($hp_intro){
						print "<div class='display-5 lh-base'>".$hp_intro."</div>";
					}
?>		
				</div>
			</div>
		</div>
<?php
	}

?>
<?php
	# --- display slideshow of random images
	print $this->render("Front/featured_set_slideshow_html.php");

	#TODO: this does not render
	print $this->render("Front/featured_set_grid_html.php");

?>

<div class="container-flex">
	<div class="fade-out bg-black bg-opacity-25 text-bg-dark p-3 text-center shadow w-100 fixed-bottom display-4"><i class="bi bi-chevron-down"></i></div>
</div>