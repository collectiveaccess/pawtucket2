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

	$t_set = ca_sets::findAsInstance(['set_code' => 'selina_test_set'], ['checkAccess' => caGetUserAccessValues($this->request)]);
 	$set_items = $t_set ? $t_set->getItems(['thumbnailVersion' => 'medium', 'shuffle' => true]) : [];
?>

<div class="container">
	<form class="pb-3" role="search" action="<?= caNavUrl($this->request, '', 'Search', 'objects'); ?>">
		<label for="heroSearchInput" class="form-label display-5 text-secondary">Search the Collection</label>
		<div class="input-group">
			<input name="search" type="text" class="form-control me-1" id="heroSearchInput" placeholder="Search" aria-label="Search" aria-label="Search Bar">
			<button type="submit" class="btn rounded-0 bg-white" id="heroSearchButton" aria-label="Search button"><i class="bi bi-search"></i></button>
		</div>
		<div class="form-text"><?= caNavLink($this->request, _t("Advanced search"), "", "", "Search", "advanced/objects"); ?></div>
	</form>

	<div class="row">
		<div class="masonry-container">
			<?php
				foreach($set_items as $item) {	
					$item = array_shift($item);
					// print_R($item);
			?>
				<div class="masonry-item">
					<?= caDetailLink($this->request, $item['representation_tag'], 'link-text', 'ca_objects', $item['row_id']); ?>
					<?= caDetailLink($this->request, $item['name'], 'item-overlay-text fs-4 text-center text-white', 'ca_objects', $item['row_id']); ?>
				</div>
			<?php
				}
			?>
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
?>



<div class="container-flex">
	<div class="fade-out bg-black bg-opacity-25 text-bg-dark p-3 text-center shadow w-100 fixed-bottom display-4"><i class="bi bi-chevron-down"></i></div>
</div>