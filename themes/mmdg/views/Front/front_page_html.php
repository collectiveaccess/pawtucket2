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
 	$va_access_values = $this->getVar("access_values");
	$o_config = caGetGalleryConfig();
	
	# --- what is the gallery section called
	if(!$section_name = $o_config->get('gallery_section_name')){
		$section_name = _t("Featured Galleries");
	}
		print $this->render("Front/featured_set_slideshow_html.php");
?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-8 col-md-offset-2">
				<H1>{{{home_intro_text}}}</H1>
			</div><!--end col-sm-8-->
		</div><!-- end row -->
	</div><!-- end container -->
	<div class="grayBg">
		<div class="container">
<?php

	
	# --- which type of set is configured for display in gallery section
 	$t_list = new ca_lists();
 	$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_config->get('gallery_set_type')); 			
 	$t_set = new ca_sets();
	$va_sets = array();
	if($vn_gallery_set_type_id){
		$va_tmp = array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id, 'table' => "ca_objects");
		$va_sets = caExtractValuesByUserLocale($t_set->getSets($va_tmp));
		
		krsort($va_sets);
		$va_sets = array_slice($va_sets, 0, 6, true);
		$va_set_first_items = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "medium", "checkAccess" => $va_access_values));
		
		$o_front_config = caGetFrontConfig();
		$vs_front_page_set = $o_front_config->get('front_page_set_code');
		$vb_omit_front_page_set = (bool)$o_config->get('omit_front_page_set_from_gallery');
		foreach($va_sets as $vn_set_id => $va_set) {
			if ($vb_omit_front_page_set && $va_set['set_code'] == $vs_front_page_set) { 
				unset($va_sets[$vn_set_id]); 
			}
			$va_first_item = $va_set_first_items[$vn_set_id];
			$va_first_item = array_shift($va_first_item);
			$vn_item_id = $va_first_item["item_id"];
		}
	}


	if(is_array($va_sets) && sizeof($va_sets)){
?>

			<div class="row">
				<div class="col-sm-12"> 
					<H2><?php print $section_name; ?></H2>
				</div>
			</div>
				<div class="row galleryGrid">
<?php
					$i = 0;
					foreach($va_sets as $vn_set_id => $va_set){
						$va_first_item = array_shift($va_set_first_items[$vn_set_id]);
						print "<div class='col-sm-12 col-md-4'>";
						print caNavLink($this->request, $va_first_item["representation_tag"], "", "", "Gallery", $vn_set_id);
						if($va_set["name"]){
							print "<div class='galleryGridText'>".caNavLink($this->request, $va_set["name"], "", "", "Gallery", $vn_set_id)."</div>"; 
						}
						print "</div>";
						$vb_item_output = 1;
						$i++;
						if($i == 6){
							break;
						}
					}
?>
				</div>
<?php
	}
?>
		</div>
	</div>