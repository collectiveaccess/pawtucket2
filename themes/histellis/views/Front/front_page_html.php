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
		<div class="container">
			<div class="row justify-content-center my-5">
				<div class="col-md-6 text-left d-flex align-items-center">
					<div><h1 class="fw-bold">{{{hp_intro_title}}}</h1>
					<div class='fs-4'>{{{hp_intro}}}</div></div>
				</div>
				<div class="col-md-5 offset-md-1 text-left">
<?php
					print $this->render("Front/sets_list_html.php");
?>				
				</div>
			</div>
		</div>

<?php
print $this->render("Front/featured_set_grid_html.php");
?>
<div class="container my-3 py-3">
	<div class="row justify-content-center text-center">
		<div class="col-md-10 hpExplore">
			<H2 class="mb-3"><?= _t("Browse by Discipline"); ?></H2>
			<div class="row">
				<div class="col-md-6">
					<?php print caNavLink($this->request, "<div>".caGetThemeGraphic($this->request, "hero_1.jpg", array("alt" => "explore image", "class" => "object-fit-cover w-100 shadow"))."<div class='fw-medium fs-4 pt-1'>Humanities</div></div>", "", "", "Browse", "objects", array("facet" => "discipline_facet", "id" => "277")); ?>
				</div>
				<div class="col-md-6">
					<?php print caNavLink($this->request, "<div>".caGetThemeGraphic($this->request, "hero_1.jpg", array("alt" => "explore image", "class" => "object-fit-cover w-100 shadow"))."<div class='fw-medium fs-4 pt-1'>Natural Sciences</div></div>", "", "", "Browse", "objects", array("facet" => "discipline_facet", "id" => "278")); ?>
				</div>
			</div>
		</div>
	</div>
</div>