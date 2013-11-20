<?php
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_key 			= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vs_view			= $this->getVar('view');
	
	$vn_facet_display_length_initial = 7;
	$vn_facet_display_length_maximum = 60;
	
	
	if (sizeof($va_criteria) > 0) { 
		print "<div class='facetLabel' style='margin-bottom:10px;'><a href='".caNavUrl($this->request, '', '*', '*', array('view' => $vs_view))."' >"._t("View All")."</a></div>";
	}
	foreach($va_facets as $vs_facet_name => $va_facet_info) {
		if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { continue; }
		
		print "<div class='facetLabel'>Filter by ".$va_facet_info['label_singular']."</div>"; 
		
		$vn_facet_size = sizeof($va_facet_info['content']);
		$vn_c = 0;
		foreach($va_facet_info['content'] as $va_item) {
			print "<div class='facet'>".caNavLink($this->request, $va_item['label'], '', '*', '*','*', array('key' => $vs_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => $vs_view))."</div>";
			$vn_c++;
			
			if (($vn_c == $vn_facet_display_length_initial) && ($vn_facet_size > $vn_facet_display_length_initial) && ($vn_facet_size <= $vn_facet_display_length_maximum)) {
				print "<div id='{$vs_facet_name}_more' style='display: none;'>";
			} else {
				if(($vn_c == $vn_facet_display_length_initial) && ($vn_facet_size > $vn_facet_display_length_maximum))  {
					break;
				}
			}
		}
		if (($vn_facet_size > $vn_facet_display_length_initial) && ($vn_facet_size <= $vn_facet_display_length_maximum)) {
			print "</div>\n";
			print "<div class='facet'><a href='#' onclick='jQuery(\"#{$vs_facet_name}_more\").slideToggle(250); return false;'><em>"._t("and %1 more", $vn_facet_size - $vn_facet_display_length_initial)."</em></a></div>";
		} elseif (($vn_facet_size > $vn_facet_display_length_initial) && ($vn_facet_size > $vn_facet_display_length_maximum)) {
			print "<div class='facet'><a href='#' onclick='caBrowsePanel.showPanel(\"".caNavUrl($this->request, '*', '*', '*', array('getFacet' => 1, 'facet' => $vs_facet_name, 'view' => $vs_view, 'key' => $vs_key))."\"); return false;'><em>"._t("and %1 more", $vn_facet_size - $vn_facet_display_length_initial)."</em></a></div>";
		}
	}	
?>