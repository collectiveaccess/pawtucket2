<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_refine_subview_html.php : 
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
 
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_key 			= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vs_view			= $this->getVar('view');
	$vs_browse_type		= $this->getVar('browse_type');
	$o_browse			= $this->getVar('browse');
	
	$vn_facet_display_length_initial = 600;
	$vn_facet_display_length_maximum = 600;
	
	if(is_array($va_facets) && sizeof($va_facets)){
		print _t("Filter by").":";
		foreach($va_facets as $vs_facet_name => $va_facet_info) {
			
			if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { continue; }
			#if(($vs_facet_name == "century_facet") && is_array($va_facets["decade_facet"])){ continue; }
?>
				<div class="btn-group" style="float:right;">
				<a href="#" data-toggle="dropdown" class="filterOptions"><?php print $va_facet_info['label_singular']; ?></a>
				<ul class="dropdown-menu" role="menu"> 
<?php
				switch($va_facet_info["group_mode"]){
					case "alphabetical":
					case "list":
					default:
						$vn_facet_size = sizeof($va_facet_info['content']);
						foreach($va_facet_info['content'] as $va_item) {
						    $vs_content_count = (isset($va_item['content_count']) && ($va_item['content_count'] > 0)) ? " (".$va_item['content_count'].")" : "";
							print "<li>".caNavLink($this->request, $va_item['label'].$vs_content_count, '', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view))."</li>";
							
						}
						
					break;
					# ---------------------------------------------
				}
?>
				</ul>
				</div>
<?php
		}
?>

<?php	
	}
?>
