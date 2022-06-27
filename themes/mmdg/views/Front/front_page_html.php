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
	if(!$section_name = $o_config->get('gallery_section_name_home_page')){
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
		$o_front_config = caGetFrontConfig();
		$vs_front_page_set = $o_front_config->get('front_page_set_code');
		$vb_omit_front_page_set = (bool)$o_config->get('omit_front_page_set_from_gallery');
		foreach($va_sets as $vn_set_id => $va_set) {
			if ($vb_omit_front_page_set && $va_set['set_code'] == $vs_front_page_set) { 
				unset($va_sets[$vn_set_id]); 
			}
		}
		shuffle($va_sets);
		$va_sets = array_slice($va_sets, 0, 1, true);
	}


	if(is_array($va_sets) && sizeof($va_sets)){
?>

			<div class="row">
				<div class="col-sm-12 col-md-10 col-md-offset-1"> 
					<H2><?php print $section_name; ?></H2>
				</div>
			</div>
				<div class="row featuredExhibition">
<?php
					$va_set = $va_sets[0];
					$vn_set_id = $va_set["set_id"];
					$va_set_first_items = $t_set->getPrimaryItemsFromSets(array($vn_set_id), array("version" => "large", "checkAccess" => $va_access_values));
					$t_set->load($vn_set_id);
					$va_first_item = array_shift($va_set_first_items[$vn_set_id]);
					print "<div class='col-sm-6 col-md-6 col-md-offset-1'>".caNavLink($this->request, $va_first_item["representation_tag"], "", "", "Gallery", $vn_set_id)."</div>";
					print "<div class='col-sm-6 col-md-4'>".caNavLink($this->request, $va_set["name"], "featuredExhibitionTitle", "", "Gallery", $vn_set_id);
					if($vs_desc = $t_set->get("ca_sets.set_description")){
						if(mb_strlen($vs_desc) > 400){
							$vs_desc = mb_substr($vs_desc, 0, 400)."...";						
						}
						print "<div class='featuredExhibitionDesc'>".$vs_desc."</div>";
					}
					print "<div class='text-center'>".caNavLink($this->request, "View Exhibition", "btn-default", "", "Gallery", $vn_set_id)."</div>";
					print "</div>"; 
					
					print "</div>";
?>
				</div>
<?php
	}
?>
		</div>
	</div>