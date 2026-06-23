<?php
/* ----------------------------------------------------------------------
 * Browse/facet_hierarchy_ancestors_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2026 Whirl-i-Gig
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
$ancestors = 		$this->getVar('ancestors');
$facet_name = 		$this->getVar("facet_name");
$display_field = 	$this->getVar("display_field");
$primary_key = 		$this->getVar("primary_key");
$key = 				$this->getVar("key");
$browse_type = 		$this->getVar("browse_type");
$is_nav = 			(bool)$this->getVar('isNav');

if(is_array($ancestors) && sizeof($ancestors)){
	if (sizeof($ancestors) > 1) {
		$ancestor = $ancestors[0];
		print '<div style="float:right;"><a href="#" onClick=\'jQuery("#bHierarchyListMorePanel_'.$facet_name.(($is_nav) ? "Nav" : "").'").load("'.caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('facet' => $facet_name, 'key' => $key, 'browseType' => $browse_type, 'isNav' => $is_nav ? 1 : 0, 'id' => (int)$ancestor['parent_id'])).'"); jQuery(".bAncestorList_'.$facet_name.(($is_nav) ? "Nav" : "").'").load("'.caNavUrl($this->request, '*', '*', 'getFacetHierarchyAncestorList', array('facet' => $facet_name, 'browseType' => $browse_type, 'key' => $key, 'isNav' => $is_nav ? 1 : 0)).'"); return false;\'><span class="glyphicon glyphicon-arrow-up"></span></a> '._t('Top').'</div>';
	}	
	$vn_c = 0;
	foreach($ancestors as $ancestor){
		$ancestor = $ancestor['NODE'];
		
		print caNavLink($this->request, caTruncateStringWithEllipsis($ancestor[$display_field], 40), '', '*', '*', $browse_type, array('key' => $key, 'facet' => $facet_name, 'id' => $ancestor[$primary_key], 'isNav' => $is_nav ? 1 : 0));
		print '<a href="#" onClick=\'jQuery("#bHierarchyListMorePanel_'.$facet_name.(($is_nav) ? "Nav" : "").'").load("'.caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('facet' => $facet_name, 'key' => $key, 'browseType' => $browse_type, 'isNav' => $is_nav ? 1 : 0, 'id' => (int)$ancestor[$primary_key])).'"); jQuery(".bAncestorList_'.$facet_name.(($is_nav) ? "Nav" : "").'").load("'.caNavUrl($this->request, '*', '*', 'getFacetHierarchyAncestorList', array('facet' => $facet_name, 'browseType' => $browse_type, 'key' => $key, 'id' => $ancestor[$primary_key], 'isNav' => $is_nav ? 1 : 0)).'"); return false;\'><span class="glyphicon glyphicon-chevron-down"></span></a>';
		if ($vn_c < sizeof($ancestors) - 1) { print " <span class='glyphicon glyphicon-chevron-right'></span> "; }
		$vn_c++;
	}
}
