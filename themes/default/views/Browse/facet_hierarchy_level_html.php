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
$va_facet_list = $this->getVar('facet_list');
$vs_facet_name = $this->getVar("facet_name");
$vs_key = $this->getVar("key");
$vs_browse_type = $this->getVar("browse_type");
$vs_link_to = $this->request->getParameter('linkTo', pString);
$va_links = array();
foreach($va_facet_list as $vn_key => $va_facet){
	foreach($va_facet as $vn_id => $va_children){
		if(isset($va_children["name"])){
			$vs_tmp = "";
			$vs_tmp .= "<div>";
			if($vs_link_to == "morePanel"){
				if($va_children["children"]){
					$vs_tmp .= "<a href='#' onclick='jQuery(\"#bMorePanel\").load(\"".caNavUrl($this->request, '*', '*', $vs_browse_type, array('getFacet' => 1, 'facet' => $vs_facet_name, 'view' => $vs_view, 'key' => $vs_key, 'key' => $vs_key, 'browseType' => $vs_browse_type, 'id' => $vn_id))."\", function(){jQuery(\"#bMorePanel\").show(); jQuery(\"#bMorePanel\").mouseleave(function(){jQuery(\"#bMorePanel\").hide();});}); return false;'>".$va_children["name"]."</a>";
				}else{
					$vs_tmp .= caNavLink($this->request, $va_children["name"], '', '*', '*', $vs_browse_type, array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $vn_id));
				}
			}else{
				$vs_tmp .= caNavLink($this->request, $va_children["name"], '', '*', '*', $vs_browse_type, array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $vn_id));
				if($va_children["children"]){
					$vs_tmp .= ' <a href="#" title="'._t('View Children').'" onClick=\'jQuery("#bHierarchyList'.(($vs_link_to) ? '' : 'MorePanel').'_'.$vs_facet_name.'").load("'.caNavUrl($this->request, '*', '*', 'getFacetHierarchyLevel', array('facet' => $vs_facet_name, 'key' => $vs_key, 'browseType' => $vs_browse_type, 'id' => $vn_id)).'"); jQuery("#bAncestorList").load("'.caNavUrl($this->request, '*', '*', 'getFacetHierarchyAncestorList', array('facet' => $vs_facet_name, 'browseType' => $vs_browse_type, 'key' => $vs_key, 'id' => $vn_id)).'"); return false;\'><span class="glyphicon glyphicon-chevron-down"></span></a>';
				}
				#$vs_tmp .= " children: ".$va_children["children"];
			}
			$vs_tmp .= "</div>";
			$va_links[$va_children["name"]] = $vs_tmp;
		}
	}
}
if(sizeof($va_links)){
	ksort($va_links);
	print join($va_links, "\n");
}
?>