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
 
 function caGetGallerySetsAsList2($po_request, $vs_class, $pa_options=null){
		$o_config = caGetGalleryConfig();
		$va_access_values = caGetUserAccessValues($po_request);
 		$t_list = new ca_lists();
 		$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_config->get('gallery_set_type'));
 		$vs_set_list = "";
		if($vn_gallery_set_type_id){
			$t_set = new ca_sets();
			$va_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_objects', 'checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id)));

			$vn_limit = caGetOption('limit', $pa_options, 100);
			$vs_role = caGetOption('role', $pa_options, null);
			if(sizeof($va_sets)){
				$vs_set_list = "<ul".(($vs_class) ? " class='".$vs_class."'" : "").(($vs_role) ? " role='".$vs_role."'" : "").">\n";
				
				$vn_c = 0;
				foreach($va_sets as $vn_set_id => $va_set){
					$vt_set = new ca_sets($va_set["set_id"]);//die();
					$icon_url=$vt_set->get("ca_sets.image_illustration.media.icon.url");
					$vs_set_list .= "<li>".caNavLink($po_request, "<img src=\"".$icon_url."\" style='float: left; margin-right: 10px;'> ".$va_set["name"], "", "", "Gallery", $vn_set_id, null, ['style' => 'min-height: 96px; width: 278px;'])."<br style='clear: both;'/></li>\n";
					$vn_c++;

					if ($vn_c >= $vn_limit) { break; }
				}
				$vs_set_list .= "</ul>\n";
			}
		}
		return $vs_set_list;
	}
?>
			<h2>Parcours Thématiques</h2>
<?php
			print caGetGallerySetsAsList2($this->request, "nav nav-pills nav-stacked");
?>