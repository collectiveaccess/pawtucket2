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
	
	# --- which type of set is configured for display in gallery section
 	$t_list = new ca_lists();
 	$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_config->get('gallery_set_type')); 			
 	$t_set = new ca_sets();
	$va_sets = array();
	$vn_featured_set_id = "";
	if($vn_gallery_set_type_id){
		$va_tmp = array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id, 'table' => "ca_objects");
		$va_sets = caExtractValuesByUserLocale($t_set->getSets($va_tmp));
		$va_set_first_items = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "iconlarge", "checkAccess" => $va_access_values));
		
		$o_set_res = caMakeSearchResult("ca_sets", array_keys($va_sets), array("checkAccess" => $va_access_values));
		
		$o_front_config = caGetFrontConfig();
		$vs_front_page_set = $o_front_config->get('front_page_set_code');
		$vb_omit_front_page_set = (bool)$o_config->get('omit_front_page_set_from_gallery');
		
		if($o_set_res->numHits()){
			while($o_set_res->nextHit()){
				if ($vb_omit_front_page_set && $o_set_res->get('ca_sets.set_code') == $vs_front_page_set) { 
					unset($va_sets[$o_set_res->get('ca_sets.set_id')]);
				}
				if($o_set_res->get('ca_sets.show_homepage', array('convertCodesToDisplayText' => true)) == 'Nee'){
					unset($va_sets[$o_set_res->get('ca_sets.set_id')]);
					$vn_featured_set_id = $o_set_res->get('ca_sets.set_id');	
				}
			}
		}
	}
	if($vn_featured_set_id){
?>
		<div class="row bgOffWhiteLight"><div class="col-sm-12"><h2>Expo's</h2></div></div>
<?php	
	}
	if($vn_featured_set_id){
		$t_featured = new ca_sets($vn_featured_set_id);
		$va_featured_set_first_item = $t_set->getPrimaryItemsFromSets(array($vn_featured_set_id), array("version" => "large", "checkAccess" => $va_access_values));
		$va_first_item = array_shift($va_featured_set_first_item[$vn_featured_set_id]);
?>
<div class="row bgOffWhiteLight"><div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 frontFeaturedExpo">
	<div class="container">
		<div class="row bgWhite">
			<div class="col-sm-5 col-md-5 col-md-5 col-lg-7 colNoPadding frontFeaturedExpoImg">
				<?php print caNavLink($this->request, $va_first_item["representation_tag"], "", "", "Gallery", $vn_featured_set_id); ?>
			</div>
			<div class="col-sm-7 col-md-7 col-lg-5 colNoPadding">
				<div class="frontFeaturedExpoText">
					<h3><?php print caNavLink($this->request, $t_featured->get("ca_sets.preferred_labels.name"), "", "", "Gallery", $vn_featured_set_id); ?></h3>
					<p><?php print (mb_strlen($t_featured->get("ca_sets.set_description")) > 600) ? mb_substr(strip_tags($t_featured->get("ca_sets.set_description")), 0, 600)."..." : $t_featured->get("ca_sets.set_description"); ?></p>
					<p class="text-center"><?php print caNavLink($this->request, _t("Meer"), "btn btn-default", "", "Gallery", $vn_featured_set_id); ?></p>
				</div>
			</div>
		</div>
		<div class="row bgWhite">
			<div class="col-sm-12 text-center">
				<p><br/><br/><?php print caNavLink($this->request, "Meer Expo's", "btn btn-default", "", "Gallery", "Index"); ?></p>
			</div>
		</div>
	</div>
</div></div>
<?php		
		
	}
?>