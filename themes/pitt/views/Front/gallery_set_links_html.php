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
?>
			<h2>Browse Featured Exhibitions</h2>
<?php
		$o_config = caGetGalleryConfig();
		$va_access_values = caGetUserAccessValues($this->request);
 		$t_list = new ca_lists();
		$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_config->get('gallery_set_type'));
 		$vs_set_list = "";
    	if($vn_gallery_set_type_id){
			$t_set = new ca_sets();
			$va_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_objects', 'checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id)));

			if(sizeof($va_sets)){
			
				$vs_set_list = "<ul class='nav nav-pills nav-stacked'>\n";

				foreach($va_sets as $vn_set_id => $va_set){
					$t_set = new ca_sets($va_set['set_id']);
					if ($t_set->get('ca_sets.set_theme', array('convertCodesToDisplayText' => true)) == "Theme guided slideshow") {
						$vs_set_list .= "<li>".caNavLink($this->request, $va_set["name"], "", "", "Gallery", $vn_set_id, array('theme' => 1))."</li>\n";
					} else {
						$vs_set_list .= "<li>".caNavLink($this->request, $va_set["name"], "", "", "Gallery", $vn_set_id)."</li>\n";
					}
				}
				$vs_set_list .= "</ul>\n";
			}
		}
		print $vs_set_list;
?>