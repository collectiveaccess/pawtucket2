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

<div class="container border-top border-black">
	<h1 class="pt-5">The Archives</h1>
	<form role="search" action="<?= caNavUrl($this->request, '', 'Search', 'GeneralSearch'); ?>">
		<div class="input-group pb-3 pt-5">
			<label for="heroSearchInput" class="form-label visually-hidden">Search</label>
			<input name="search" type="text" class="form-control rounded-0 border-black" id="heroSearchInput" placeholder="Search" aria-label="Search Bar">
			<button type="submit" class="btn btn-primary bg-black ms-2" aria-label="Search button">Search the Archive</button>
		</div>
	</form>
</div>
<div class="container pt-5 pb-5">
	<div class="row g-5">
		<div class="col-12 col-md-5 img-fluid">
			<?php print caGetThemeGraphic($this->request, 'jazz-in-july-concert-hall.jpg', array("alt" => "Image of performane")); ?>
		</div>
		<div class="col-12 col-md-7 display-4">
			{{{hp_intro}}}
		</div>
	</div>
</div>
<div class="container-fluid bg-light py-5 mt-5">
	<div class="container pb-5">
		<div class="row">
			<div class="col">
				<H2 class="mb-3 display-1">Explore</H2>
			</div>
		</div>
		<div class="row g-5">
			<div class="col-12 col-md-6"><?php print caNavLink($this->request, "Events", "btn btn-primary bg-black w-100 pt-3 pb-5 fs-3 text-start", "", "Browse", "events"); ?></div>
			<div class="col-12 col-md-6"><?php print caNavLink($this->request, "Performers", "btn btn-primary bg-black w-100 pt-3 pb-5 fs-3 text-start", "", "Browse", "entities"); ?></div>
		</div>
	</div>
</div>
<div class="container-flex">
	<div class="fade-out bg-black bg-opacity-25 text-bg-dark p-3 text-center shadow w-100 fixed-bottom display-4"><i class="bi bi-chevron-down"></i></div>
</div>