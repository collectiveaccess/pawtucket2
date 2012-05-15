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
 
	$va_facets 			= $this->getVar('available_facets');
	$va_facets_with_content		= $this->getVar('facets_with_content');
	$va_facet_info 			= $this->getVar('facet_info');
	$va_criteria 			= is_array($this->getVar('criteria')) ? $this->getVar('criteria') : array();
	$va_results 			= $this->getVar('result');
	$vs_browse_target		= $this->getVar('target');
	global $g_ui_locale;

	/* dirty hack to translate browse labels since I can't update po/mo files */
	$va_facet_code_to_label_map = array(
		'entity_facet' => array(
			"de_DE" => array("name_singular" => "Regie", "name_plural" => "Regie"),
			"en_US" => array("name_singular" => "Director", "name_plural" => "Directors"),
		),
		'country_facet' => array(
			"de_DE" => array("name_singular" => "Land", "name_plural" => "Länder"),
			"en_US" => array("name_singular" => "Country", "name_plural" => "Countries"),
		),
		'year_facet' => array(
			"de_DE" => array("name_singular" => "Jahr", "name_plural" => "Jahre"),
			"en_US" => array("name_singular" => "Year", "name_plural" => "Years"),
		),
		'forum_year_facet' => array(
			"de_DE" => array("name_singular" => "Forumsjahr", "name_plural" => "Forumsjahre"),
			"en_US" => array("name_singular" => "Forum year", "name_plural" => "Forum years"),
		),
		'format_facet' => array(
			"de_DE" => array("name_singular" => "Format", "name_plural" => "Formate"),
			"en_US" => array("name_singular" => "Format", "name_plural" => "Formats"),
		),
		'titleseries_facet' => array(
			"de_DE" => array("name_singular" => "Serientitel", "name_plural" => "Serientitel"),
			"en_US" => array("name_singular" => "Series title", "name_plural" => "Series titles"),
		),
	);
?>
	<div id="browse"><div id="resultBox"> 
<?php
	# --- we need to calculate the height of the box using the number of facets.
	$vn_boxHeight = 25 + ( sizeof($va_facets_with_content) * 18);
?>
		<div style="position: relative;">
			<div id="browseCriteria">
<?php
			if (sizeof($va_criteria)) {
				$vn_x = 0;
				foreach($va_criteria as $vs_facet_name => $va_row_ids) {
					$vn_x++;
					$vn_row_c = 0;
					foreach($va_row_ids as $vn_row_id => $vs_label) {
						$vs_facet_label = (isset($va_facet_info[$vs_facet_name]['label_singular'])) ? unicode_ucfirst($va_facet_info[$vs_facet_name]['label_singular']) : '???';
?>
						<div class="browseBox" style="height:<?php print $vn_boxHeight; ?>px;">
							<div class="heading"><?php print $va_facet_code_to_label_map[$vs_facet_name][$g_ui_locale]["name_singular"]; ?>:</div>
<?php 			
							print "<div class='browsingBy'>{$vs_label}".caNavLink($this->request, 'x', 'close', '', 'Browse', 'removeCriteria', array('facet' => $vs_facet_name, 'id' => $vn_row_id))."</div>\n";
?>
						</div>
<?php
						$vn_row_c++;
						if(($vn_x < sizeof($va_criteria)) || ($vn_row_c < sizeof($va_row_ids))){
?>
							<div class="browseWith" style="margin-top:<?php print ($vn_boxHeight/2)-4; ?>px;"><?php print ($g_ui_locale == "de_DE" ? "und" : 'with'); ?></div>
<?php
						}
					}
				}
				
				if (sizeof($va_facets)) { 
?>
					<div class="browseArrow" style="margin-top:<?php print ($vn_boxHeight/2)-4; ?>px;"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/browseArrow.gif' width='16' height='24' border='0'></div>
					<div class="browseBoxRefine"  style="height:<?php print $vn_boxHeight; ?>px;">
						<div class='heading'><?php print _t('Refine results by'); ?>:</div>
<?php
						$va_available_facets = $this->getVar('available_facets');
						foreach($va_available_facets as $vs_facet_code => $va_facet_info) {
							print "<div class='browseFacetLink'><a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");'>".$va_facet_code_to_label_map[$vs_facet_code][$g_ui_locale]["name_singular"]."</a></div>\n";
						}
?>
						<div class="startOver"><?php print ($g_ui_locale=="de_DE" ? "oder" : "or")." ";  print caNavLink($this->request, _t('start over'), '', '', 'Browse', 'clearCriteria', array()); ?></div>
					</div>
<?php
				} else {
?>
					<div class="browseArrow" style="margin-top:<?php print ($vn_boxHeight/2)-4; ?>px;"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/browseArrow.gif' width='16' height='24' border='0'></div>
					<div class="browseBoxRefine" style="height:<?php print $vn_boxHeight; ?>px;">
						<div class="startOver" style="margin-top:0px;"><?php  print caNavLink($this->request, _t('start over'), '', '', 'Browse', 'clearCriteria', array()); ?></div>
					</div>
<?php					
				}
			} else {
				if (sizeof($va_facets)) { 
?>
					<div class="browseBoxRefine" style="height:<?php print $vn_boxHeight; ?>px;">
						<div class="heading"><?php print _t("Start browsing by:"); ?></div>
<?php 
							$va_available_facets = $this->getVar('available_facets');
							foreach($va_available_facets as $vs_facet_code => $va_facet_info) {
								print "<div class='browseFacetLink'><a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");'>".$va_facet_code_to_label_map[$vs_facet_code][$g_ui_locale]["name_singular"]."</a></div>\n";
							}
?>
					</div>
<?php
				}
			}
?>
	<div style='clear:both;'><!-- empty --></div></div><!-- end browseCriteria -->
</div><!-- end position:relative -->
<?php
	if (sizeof($va_criteria) == 0) {
		print $this->render('Browse/browse_start_html.php');
	} else {
		print ($vs_paging_controls = $this->render('Results/paging_controls_html.php'));
?>
		<a href='#' id='showOptions' onclick='$("#searchOptionsBox").slideDown(250); $("#showOptions").hide(); return false;'><?php print _t("Options"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="6" height="7" border="0"></a>
<?php		
		print $this->render('Search/search_controls_html.php');
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