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
	$va_featured_sets = array();
	if($vn_gallery_set_type_id){
		$va_tmp = array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id, 'table' => "ca_objects");
		$va_sets = caExtractValuesByUserLocale($t_set->getSets($va_tmp));
		$va_set_first_items = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "large", "checkAccess" => $va_access_values));
		$o_set_res = caMakeSearchResult("ca_sets", array_keys($va_sets), array("checkAccess" => $va_access_values));
		
		if($o_set_res->numHits()){
			while($o_set_res->nextHit()){
				if($o_set_res->get('ca_sets.show_homepage', array('convertCodesToDisplayText' => true)) == 'Ja'){
					$va_first_item = array_shift($va_set_first_items[$o_set_res->get('ca_sets.set_id')]);
					$va_featured_sets[$o_set_res->get('ca_sets.set_id')] = array("set_id" => $o_set_res->get("ca_sets.set_id"), "name" => $o_set_res->get("ca_sets.preferred_labels.name"), "description" => $o_set_res->get("ca_sets.set_description"), "image" => $va_first_item["representation_tag"], "item_count" => $va_sets[$o_set_res->get('ca_sets.set_id')]['item_count']); 	
				}
			}
		}
	}
	if(is_array($va_featured_sets) && sizeof($va_featured_sets)){
?>
<div class="row"><div class="col-sm-12 col-md-12 col-lg-10 col-lg-offset-1 frontFeaturedExpo">
	<h2>Expo's - in de kijker<br/><hr/></h2>
<?php
		$i = 0;
		foreach($va_featured_sets as $vn_featured_set_id => $va_set_info){
			$i++;
			$vs_image_col = '<div class="col-sm-5 col-md-5 col-md-5 col-lg-7 text-center"><div class="frontFeaturedExpoImg">'.caNavLink($this->request, $va_set_info["image"], "", "", "Gallery", $vn_featured_set_id).'</div></div>';
			$vs_desc_col = '<div class="col-sm-7 col-md-7 col-lg-5">
								<div class="frontFeaturedExpoText'.(($i > 1) ? " text-right" : "").'">
									<div class="frontFeaturedExpoTitle">'.caNavLink($this->request, $va_set_info["name"], "", "", "Gallery", $vn_featured_set_id).'</div>
									<div><i>'.$va_set_info["item_count"].' objecten</i></div>
									<p>'.((mb_strlen($va_set_info["description"]) > 400) ? mb_substr(strip_tags($va_set_info["description"]), 0, 400)."..." : $va_set_info["description"]).'</p>
									<p>'.caNavLink($this->request, _t("Bezoek de expo"), "btn btn-default", "", "Gallery", $vn_featured_set_id).'</p>
								</div>
							</div>';
?>
	<div class="row frontFeaturedExpoBlock">
<?php
			if($i == 1){
				print $vs_image_col.$vs_desc_col;
			}else{
				print $vs_desc_col.$vs_image_col;
				$i = 0;
			}
?>
	</div>
<?php
		}
?>
	<div class="frontFeaturedExpoLink"><?php print caNavLink($this->request, "Zin in meer? Bezoek ook onze andere expo's.", "", "", "Gallery", "Index"); ?><br/><hr/></div>
</div></div>
<?php
	}
?>