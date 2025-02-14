<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/gallery_slideshow_html : Front page of site 
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
	
	# --- which type of set is configured for display in gallery section
 	$t_list = new ca_lists();
 	$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_config->get('gallery_set_type')); 			
 	$t_set = new ca_sets();
	$va_sets = array();
	if($vn_gallery_set_type_id){
		$va_tmp = array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id, 'table' => "ca_objects");
		$va_sets = caExtractValuesByUserLocale($t_set->getSets($va_tmp));
		$va_set_first_items = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "iconlarge", "checkAccess" => $va_access_values));
		
		$o_front_config = caGetFrontConfig();
		$vs_front_page_set = $o_front_config->get('ca_objects_set_code');
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
<div class="container-fluid pb-5">
	<div class="row">
		<div class="col-sm-12"><H2 class="pb-2"><?= $section_name; ?></H2></div>
	</div>
	<div class="row">
		<div class="col-sm-12">
<?php
		
					foreach($va_sets as $vn_set_id => $va_set){
						$va_first_item = array_shift($va_set_first_items[$vn_set_id]);
						if($vn_col == 0){
							print "<div class='row g-5 mb-5'>";
						}
						print "<div class='col-sm-3 col-xs-6 img-fluid'>";
						if($va_set["name"]){
							$vs_name = "<div class='text-center text-black sansserif fs-5 pt-2'>".$va_set["name"]."</div>"; 
						}
						print caNavLink($this->request, $va_first_item["representation_tag"].$vs_name, "", "", "Gallery", $vn_set_id);
						print "</div>";						
						$i++;
						$vn_col++;
						if($vn_col == 4){
							print "</div>";
							$vn_col = 0;
						}
						if($i == 4){
							break;
						}
					}
					if($vn_col > 0){
						print "</div><!-- end row -->";
					}
					print "<div class='text-center pb-2'>".caNavLink($this->request, "All ".$section_name, "btn btn-primary", "", "Gallery", "Index")."</div>";
?>
		
		</div>
	</div>
</div>
<?php
	}
?>