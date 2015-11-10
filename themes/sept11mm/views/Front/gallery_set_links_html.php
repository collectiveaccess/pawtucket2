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

		#print caGetGallerySetsAsList($this->request, "nav nav-pills nav-stacked");
		$o_config = caGetGalleryConfig();
		$va_access_values = caGetUserAccessValues($this->request);
 		$t_list = new ca_lists();
 		$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_config->get('gallery_set_type')); 			
 		if($vn_gallery_set_type_id){
			$t_set = new ca_sets();
			$va_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_objects', 'checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id)));
			
			$vn_limit = caGetOption('limit', $pa_options, 100);
			if(sizeof($va_sets)){
				# --- get first items from set
				$va_first_items = $t_set->getFirstItemsFromSets(array_keys($va_sets), array("checkAccess" => $va_access_values, "version" => "widepreview"));
				print "<ul class='nav nav-pills nav-stacked'>\n";
				$vn_c = 0;
				foreach($va_sets as $vn_set_id => $va_set){
					$vs_image = "";
					print "<li>";
					$va_first_item = array_pop($va_first_items[$vn_set_id]);
					if(is_array($va_first_item) && sizeof($va_first_item)){
						$vs_image = $va_first_item["representation_tag"];
					}
					print $vs_image."<div>".caNavLink($this->request, $va_set["name"]."  &raquo;", "", "", "Gallery", $vn_set_id)."</div></li>\n";
					$vn_c++;
					
					if ($vn_c >= $vn_limit) { break; }
				}
				print "</ul>\n";
			}
		}
?>