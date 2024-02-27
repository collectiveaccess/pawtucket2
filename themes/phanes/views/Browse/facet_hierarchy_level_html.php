<?php
/* ----------------------------------------------------------------------
 * Browse/facet_hierarchy_level_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
	$va_facet_list = 		$this->getVar('facet_list');
	$vs_facet_name = 		$this->getVar("facet_name");
	$vs_key = 				$this->getVar("key");
	$vs_browse_type = 		$this->getVar("browse_type");
	$vs_link_to = 			$this->request->getParameter('linkTo', pString);
	$vb_is_nav = 			(bool)$this->getVar('isNav');
	
	$va_links = array();
	
	foreach($va_facet_list as $vn_key => $va_facet){
		foreach($va_facet as $vn_id => $va_children){
			if (!is_array($va_children)) { continue; }
			
			$vs_content_count = (isset($va_children['content_count']) && ($va_children['content_count'] > 0)) ? " (".$va_children['content_count'].")" : "";
			$vs_name = caTruncateStringWithEllipsis($va_children["name"], 75);
			
			if(isset($vs_name)){
				$vs_buf = "<div>";
					# selectFacetMultiple function is located in browse_refine_subview_html.php so it's only loaded once for the facet - not with every ajax load
					$vs_buf .= "<div class='facetItem facetItemHier' style='display:inline; position:relative;' data-facet='".$vs_facet_name."' data-facet_item_id='".$vn_id."' onClick='selectFacetMultiple($(this));'>".$vs_name.$vs_content_count."</div>";
					if((int)$va_children["children"] > 0){
						$vs_buf .= ' <a href="#" title="'._t('View sub-items').'" onClick=\'jQuery("#children'.$vn_id.'").load("'.caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('facet' => $vs_facet_name, 'key' => $vs_key, 'browseType' => $vs_browse_type, 'id' => $vn_id, 'isNav' => $vb_is_nav ? 1 : 0)).'"); return false;\'><span class="glyphicon glyphicon-chevron-down"></span></a>';
						$vs_buf .= '<div id="children'.$vn_id.'" style="padding-left:10px;"></div>';
					}
				$vs_buf .= "</div>";
				$va_links[$va_children["name"]] = $vs_buf;
			}
		}
	}

	if(sizeof($va_links)){
		ksort($va_links);
		print join("\n", $va_links);
	}
?>
