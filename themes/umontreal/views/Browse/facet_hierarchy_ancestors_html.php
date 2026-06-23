<?php
/* ----------------------------------------------------------------------
 * Browse/facet_hierarchy_ancestors_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2015 Whirl-i-Gig
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

	$va_ancestors = 		$this->getVar('ancestors');
	$vs_facet_name = 		$this->getVar("facet_name");
	$vs_display_field = 	$this->getVar("display_field");
	$vs_primary_key = 		$this->getVar("primary_key");
	$vs_key = 				$this->getVar("key");
	$vs_browse_type = 		$this->getVar("browse_type");
	$vb_is_nav = 			(bool)$this->getVar('isNav');

	if(is_array($va_ancestors) && sizeof($va_ancestors)){
		#if (sizeof($va_ancestors) > 1) {
			$va_ancestor = $va_ancestors[0];
			print '<div style="float:right;"><a href="#" onClick=\'jQuery("#bHierarchyListMorePanel_'.$vs_facet_name.(($vb_is_nav) ? "Nav" : "").'").load("'.caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('facet' => $vs_facet_name, 'key' => $vs_key, 'browseType' => $vs_browse_type, 'isNav' => $vb_is_nav ? 1 : 0, 'id' => (int)$va_ancestor['parent_id'])).'"); jQuery(".bAncestorList_'.$vs_facet_name.(($vb_is_nav) ? "Nav" : "").'").load("'.caNavUrl($this->request, '*', '*', 'getFacetHierarchyAncestorList', array('facet' => $vs_facet_name, 'browseType' => $vs_browse_type, 'key' => $vs_key, 'isNav' => $vb_is_nav ? 1 : 0)).'"); return false;\'><span class="glyphicon glyphicon-arrow-up"></span></a> '._t('Top').'</div>';
		#}	
		$vn_c = 0;
		foreach($va_ancestors as $va_ancestor){
			$va_ancestor = $va_ancestor['NODE'];
			
			print '<a href="#" onClick=\'jQuery("#bHierarchyListMorePanel_'.$vs_facet_name.(($vb_is_nav) ? "Nav" : "").'").load("'.caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('facet' => $vs_facet_name, 'key' => $vs_key, 'browseType' => $vs_browse_type, 'isNav' => $vb_is_nav ? 1 : 0, 'id' => (int)$va_ancestor[$vs_primary_key])).'"); jQuery(".bAncestorList_'.$vs_facet_name.(($vb_is_nav) ? "Nav" : "").'").load("'.caNavUrl($this->request, '*', '*', 'getFacetHierarchyAncestorList', array('facet' => $vs_facet_name, 'browseType' => $vs_browse_type, 'key' => $vs_key, 'id' => $va_ancestor[$vs_primary_key], 'isNav' => $vb_is_nav ? 1 : 0)).'"); return false;\'>'.caTruncateStringWithEllipsis($va_ancestor[$vs_display_field], 40).'</a>';
			if ($vn_c < sizeof($va_ancestors) - 1) { print " <span class='glyphicon glyphicon-chevron-right'></span> "; }
			$vn_c++;
		}
	}