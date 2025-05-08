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
	$vs_hero = $this->request->getParameter("hero", pString);
	if(!$vs_hero){
 		$vs_hero = rand(1, 1);
	}
	
	$t_list = new ca_lists();
	
	$themes = $t_list->getItemsForList("hp_types", array("directChildrenOnly" => "1", "checkAccess" => $access_values));
	$themes_for_display = array();
	if(is_array($themes) && sizeof($themes)){
		$t_list_item = new ca_list_items();
		foreach($themes as $item_id => $theme){
			$theme = array_pop($theme);
			$t_list_item->load($item_id);
			$themes_for_display[$item_id] = array("name" => $theme["name_singular"], "image" => $t_list_item->get("ca_list_items.icon.large", array("alt" => "Image for ".$theme["name_singular"], "class" => "object-fit-cover w-100 shadow rounded-3")));
		}
?>
<div class="container-flex">
	<div class="parallax hero<?php print $vs_hero; ?>">
		<div class="container h-100">
			<div class="row h-100">
				<div class="col-md-12 col-lg-10 col-xl-10 d-flex h-100 align-items-center">
					<div class="text-white p-5 text-left w-100">
						<div class="py-3">
							<div class="fw-light "><span class="fs-2">Welcome to the</span></div>
							<div class="display-2 fw-medium">Appalshop Archive</div>
						</div>
						<form role="search" action="<?= caNavUrl($this->request, '', 'Search', 'GeneralSearch'); ?>">
							<div class="input-group pb-3 w-50">
								<label for="heroSearchInput" class="form-label visually-hidden">Search</label>
								<input name="search" type="text" class="form-control rounded-0 border-0" id="heroSearchInput" placeholder="Search" aria-label="Search Bar">
								<button type="submit" class="btn rounded-0 bg-white text-primary" id="heroSearchButton" aria-label="Search button"><i class="bi bi-search"></i></button>
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
				<div class="col-md-10 my-5 pt-5 text-center">
<?php
					if($vs_hp_intro){
						print "<div class='display-6 lh-base fw-medium'>".$vs_hp_intro."</div>";
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
		<div class="col-md-10 my-5 py-2">
			<H1 class="mb-4 green">Explore The Archive</H1>
			<div class="row">
<?php
		foreach($themes_for_display as $item_id => $theme_for_display){
			$img = $theme_for_display["image"];
			if(!$img){
				$img = caGetThemeGraphic($this->request, "hero_1.jpg", array("alt" => "explore image", "class" => "object-fit-cover w-100 shadow rounded-3"));
			}
			print '<div class="col-md-4 mb-4 text-center">'.caNavLink($this->request, "<div class='linkBox position-relative rounded-3'>".$img."<div class='position-absolute top-0 w-100 h-100 display-3 fs-3 text-white rounded-3'>".$theme_for_display["name"]."</div></div>", "", "", "Themes", "theme", array("item_id" => $item_id)).'</div>';
				
		}
				
?>
			</div>
		</div>
	</div>
</div>

<?php		
	}


?>
