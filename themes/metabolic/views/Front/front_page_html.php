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


<?php

	# --- display galleries as a grid?
	// print $this->render("Front/gallery_grid_html.php");
	# --- display galleries as a slideshow?
	#print $this->render("Front/gallery_slideshow_html.php");
	# --- display 1 featured gallery
	// print $this->render("Front/featured_gallery_html.php");

?>


<?php
	# --- display slideshow of random images
	print $this->render("Front/featured_set_slideshow_html.php");
?>

<div class="row justify-content-center my-5 py-5">
	<div class="col-md-9 col-lg-6 col-xl-5 d-flex">
		<form role="search" action="<?= caNavUrl($this->request, '', 'Search', 'GeneralSearch'); ?>">
			<div class="input-group pb-3">
				<label for="heroSearchInput" class="form-label mb-0 me-2 fs-3 pt-2">Search The Archive</label>
				<input name="search" type="text" class="form-control rounded-0 border-0" id="heroSearchInput" placeholder="" aria-label="Search Bar">
				<button type="submit" class="btn rounded-0 bg-white fs-3" id="heroSearchButton" aria-label="Search button">GO</button>
			</div>
		</form>
	</div>
</div>

<?php
	# --- display galleries as a grid?
	print $this->render("Front/gallery_grid_html.php");
?>

<div class="container-flex">
	<div class="fade-out bg-black bg-opacity-25 text-bg-dark p-3 text-center shadow w-100 fixed-bottom display-4"><i class="bi bi-chevron-down"></i></div>
</div>