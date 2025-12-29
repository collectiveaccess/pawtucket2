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
	$vn_id = 				$this->getVar("id");

	if(is_array($va_ancestors) && sizeof($va_ancestors)){
		$vn_c = 0;
		foreach($va_ancestors as $va_ancestor){
			$va_ancestor = $va_ancestor['NODE'];
			if($vn_id == (int)$va_ancestor[$vs_primary_key]){
				print caTruncateStringWithEllipsis($va_ancestor[$vs_display_field], 40);
			}else{
				print "<a href='#' class='' hx-trigger='click' hx-target='#bMorePanel' hx-get='".caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('getFacet' => 1, 'facet' => $vs_facet_name, 'key' => $vs_key, 'id' => (int)$va_ancestor[$vs_primary_key], "browseType" => $vs_browse_type, "morePanel" => 1))."' type='button' aria-controls='bMorePanel' role='button' onClick='document.getElementById(\"bMorePanel\").focus();'>".caTruncateStringWithEllipsis($va_ancestor[$vs_display_field], 40)."</a>";
			}
			if ($vn_c < sizeof($va_ancestors) - 1) { print " <i class='bi bi-chevron-right fs-6'></i> "; }
			$vn_c++;
		}
	}