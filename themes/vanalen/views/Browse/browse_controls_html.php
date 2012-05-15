<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ca_objects_browse_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
 
	$va_facets 				= $this->getVar('available_facets');
	$va_facets_with_content	= $this->getVar('facets_with_content');
	$va_available_facets = $this->getVar('available_facets');
	$va_facet_info 			= $this->getVar('facet_info');
	$va_criteria 			= is_array($this->getVar('criteria')) ? $this->getVar('criteria') : array();
	$va_results 			= $this->getVar('result');
	
	$vs_browse_ui_style 	= $this->request->config->get('browse_ui_style');
	$vs_browse_target		= $this->getVar('target');
	
	$t_browse				= $this->getVar('browse');
?>
	<div id="browse"><div id="resultBox"> 
<?php
//
// BEGIN 'BUTTONS_WITH_OVERLAYS' browse UI
//

//
// BEGIN Van Alen html template for browse UI
//

?>
<ul id="MenuBar" class="MenuBarHorizontal">
<?php
	//
	// Output menus
	//
	foreach($va_facets_with_content as $vs_facet_code) {
		if (isset($va_facets[$vs_facet_code])) {
			if ($vs_facet_code == 'type_facet') { continue; }
			$va_facet = $va_facets[$vs_facet_code];
			$va_content= $t_browse->getFacetContent($vs_facet_code);
			
			if (is_array($va_content) && sizeof($va_content)) {
				print "<li><a class='MenuBarItemSubmenu' onmouseover='MM_swapImgRestore()' href='#'>".strtoupper($va_facet['label_plural'])."</a>";
				print "<ul>\n";
				
				$va_tmp = array();
				foreach($va_content as $vn_id => $va_item) {
					$va_tmp[strtolower($va_item['name_sort'] ? $va_item['name_sort'] : $va_item['label'])] = "<li>".caNavLink($this->request, ucfirst($va_item['label']), 'browseSelectPanelLink', $this->request->getModulePath(), $this->request->getController(), 'addCriteria', array_merge(array('facet' => $vs_facet_code, 'id' => $va_item['id'])))."</li>";
				}
				ksort($va_tmp);
				print join("\n", array_values($va_tmp));
				print "</ul>\n";
				print "</li>\n";
			}
		} else {
			print "<li><a class='MenuBarItemSubmenuDisabled' onmouseover='MM_swapImgRestore()' href='#'>".strtoupper($va_facet_info[$vs_facet_code]['label_plural'])."</a></li>";
			
		}
	}
	
?>
</ul>

<?php
	//
	// Output criteria
	//
	if (sizeof($va_criteria)) {
?>
		<div style="clear: both;"><!-- empty --></div>
		<div class="resetButton"><?php  print caNavLink($this->request, _t('START OVER'), '', '', 'Browse', 'clearCriteria', array()); ?></div>
		<div id="browseBreadcrumb"><b>Browsing By:</b>&nbsp; 
<?php
		$vn_x = 0;
		foreach($va_criteria as $vs_facet_name => $va_row_ids) {
			$vn_x++;
			$vn_row_c = 0;
			foreach($va_row_ids as $vn_row_id => $vs_label) {
				$vs_facet_label = (isset($va_facet_info[$vs_facet_name]['label_singular'])) ? unicode_ucfirst($va_facet_info[$vs_facet_name]['label_singular']) : '???';			
				print caNavLink($this->request, $vs_label, "", "", "Browse", "ClearAndAddCriteria", array('facet' => $vs_facet_name, 'id' => $vn_row_id))." ".caNavLink($this->request, 'x', 'close', '', 'Browse', 'removeCriteria', array('facet' => $vs_facet_name, 'id' => $vn_row_id))."\n";
				$vn_row_c++;
				if(($vn_x < sizeof($va_criteria)) || ($vn_row_c < sizeof($va_row_ids))){
					print "&nbsp; > &nbsp;";
				}
			}
		}
?>
		</div>
<?php
	}
?>

<script type="text/javascript">     
<!--
	var caMenuBar = new Spry.Widget.MenuBar("MenuBar", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
<?php

//
// END Van Alen html template for browse UI
//

	if (sizeof($va_criteria) == 0) {
		print $this->render('Browse/browse_start_html.php');
	} else {
		print ($vs_paging_controls = $this->render('Results/paging_controls_html.php'));
		print "<div class='sectionBox'>";
		print $this->render('Results/'.$vs_browse_target.'_results_'.$this->getVar('current_view').'_html.php');
		print "</div>";
		print $vs_paging_controls;
	}
?>
	</div><!-- end resultbox --></div><!-- end browse -->

<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
	<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton">&nbsp;</a>
	<div id="splashBrowsePanelContent">
	
	</div>
</div>
<script type="text/javascript">
	var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});

	//
	// Handle browse header scrolling
	//
	jQuery(document).ready(function() {
		jQuery("div.scrollableBrowseController").scrollable(); 
	});
</script>