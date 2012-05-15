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
	$va_facet_info 			= $this->getVar('facet_info');
	$va_criteria 			= is_array($this->getVar('criteria')) ? $this->getVar('criteria') : array();
	$va_results 			= $this->getVar('result');
	
	$vs_browse_ui_style 	= $this->request->config->get('browse_ui_style');
	$vs_browse_target		= $this->getVar('target');
	$o_browse				= $this->getVar('browse');
	# --- we need to set a mode to distinguish btw the 2 layouts - one for results from the lists of People, Places, Genres, subjects etc and one for browses off the home page
	# --- clearCriteria is passed through the home page, so use that to set session var
	if(in_array($this->request->getAction(), array("clearCriteria"))){
		$this->request->session->setVar("browseDisplayMode", "showFacets");
	}elseif(in_array($this->request->getAction(), array("clearAndAddCriteria"))){
		$this->request->session->setVar("browseDisplayMode", "noFacets");
	}
	$vs_browseMode = $this->request->session->getVar("browseDisplayMode");
	
	if($vs_browseMode == "noFacets"){
		# --- layout for results clicked off lists
			if (!$this->request->isAjax()) {
?>
			<div id="browseLeftCol" style='margin-right:30px;'><div id="browse">
<?php
			}
?>
			<div id="resultBox"> 
<?php
		
			if (sizeof($va_criteria) == 0) {
				print $this->render('Browse/browse_start_html.php');
			} else {
				#print $this->render('Search/search_controls_html.php');
				print "<div class='sectionBox'>";
				print "<div id='searchFor'>"._t("Results for ");
				$vn_c = 0;
				foreach($this->getVar('browse_criteria') as $vs_facet_name => $vs_criteria) {
					if($vn_c){
						print " and ";
					}
					$vn_c = 1;
					print "\"$vs_criteria\"";
				}
				print "</div><!-- end searchFor -->\n";
				print $this->render('Results/'.$vs_browse_target.'_results_'.$this->getVar('current_view').'_html.php');
				print "</div><!-- end sectionBox-->\n";
				print $this->render('Results/paging_controls_html.php');
			}
?>
			</div><!-- end resultbox -->
<?php
			if (!$this->request->isAjax()) {
?>
			</div><!-- end browse --></div><!-- end browseLeftCol -->
		
			<div id="rightCol" style="margin-top:40px;">
<?php
			print $this->render('/pageFormat/right_col_html.php');
?>
			</div><!-- end rightCol -->
<?php
			}
	}else{
		
		if (!$this->request->isAjax()) {
				print $this->render('Browse/browse_start_html.php');
		}
?>
		<div id="resultBox"> 
		<div id="browseLeftColWide"><div id="browseFacetCol">
<?php
				if (sizeof($va_criteria) > 0) {
					print "<div class='criteriaList'>";
					print _t("Showing:")."<br/><br/>";
					foreach($va_criteria as $vs_facet_name => $va_row_ids) {
						foreach($va_row_ids as $vn_row_id => $vs_label) {
							print "<div>";
							$vs_facet_label = (isset($va_facet_info[$vs_facet_name]['label_singular'])) ? unicode_ucfirst($va_facet_info[$vs_facet_name]['label_singular']) : '???';
							print $vs_facet_label.": ".$vs_label.caNavLink($this->request, '<img src="'.$this->request->getThemeUrlPath().'/graphics/nhf/close.gif" width="17" height="17" border="0" style="margin: 0px 0px 0px 5px; vertical-align:middle;">', '', '', 'Browse', 'removeCriteria', array('facet' => $vs_facet_name, 'id' => $vn_row_id));
							print "</div>";
						}	
					}
					print "<div>".caNavLink($this->request, _t('start new search'), '', '', 'Browse', 'clearCriteria', array())."</div>";
					print "</div><!-- end criteriaList -->";
				}
				
				$o_browse = $this->getVar('browse');
				$va_available_facets = $this->getVar('available_facets');
				if(is_array($va_available_facets) && sizeof($va_available_facets) > 0){
					print "<div class='mainHeading'>"._t("Browse the Collections")."</div>";
					foreach($va_available_facets as $vs_facet_code => $va_facet_info) {
						print "<div class='facetHeading'>".$va_facet_info['label_plural']."</div>\n";
						$va_facet = $o_browse->getFacet($vs_facet_code, array('checkAccess' => array(1)));
						print "<div class='facets'>";
						$i = 0;
						foreach($va_facet as $vn_item_id => $va_item_info){
							print "<div><a href='#' onclick='jQuery(\"#resultBox\").load(\"".caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), 'addCriteria', array('facet' => $vs_facet_code, 'id' => $va_item_info['id']))."\"); return false;'>".$va_item_info['label']."</a></div>";
							$i++;
							if(($i == 10) && ($vs_facet_code != "decade_facet")){
								print "<div class='moreFacets'><img src='".$this->request->getThemeUrlPath()."/graphics/nhf/more_cross.gif' width='14' height='16' border='0' style='margin: 0px 5px 0px 0px; vertical-align:middle;'>";
								print "<a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");' class='facetLink'>"._t("More ").$va_facet_info['label_plural']."</a>";
								print "</div>";
								break;
							}
						}
						print "</div><!-- end facets -->";
					}
				}
	?>
		</div>
			<div id="browseLeftCol" style="margin-top:20px;"><div id="browse">
	<?php
		if (sizeof($va_criteria) > 0) {
			print "<div class='sectionBox'>";
			print "<div id='searchFor'>"._t("Results for ");
			$vn_c = 0;
			foreach($this->getVar('browse_criteria') as $vs_facet_name => $vs_criteria) {
				if($vn_c){
					print " and ";
				}
				$vn_c = 1;
				print "\"$vs_criteria\"";
			}
			print "</div><!-- end searchFor -->\n";
			print $this->render('Results/'.$vs_browse_target.'_results_'.$this->getVar('current_view').'_html.php');
			print "</div><!-- end sectionBox-->\n";
			print $this->render('Results/paging_controls_html.php');
		}else{
			print "<div class='sectionBox'><div id='searchFor'>"._t("Choose from the options at left to start browsing the collections.")."</div></div>";
		}
	?>
			</div><!-- end browse --></div><!-- end browseLeftCol --></div><!-- end browseLeftColWide -->
		</div><!-- end resultbox -->
	<?php
		if (!$this->request->isAjax()) {
	?>
		<div id="rightCol" style="margin-top:40px;">
	<?php
		print $this->render('/pageFormat/right_col_html.php');
	?>
		</div><!-- end rightCol -->
		<div style="clear:both;">
	<?php
		}
?>		
		<div id="splashBrowsePanel" class="browsePanel" style="z-index:1000;">
			<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browsePanelButton">&nbsp;</a>
			<div id="splashBrowsePanelContent">
			
			</div>
		</div>
		<script type="text/javascript">
			var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', 'Browse', 'getFacet'); ?>'});
		</script>
<?php		
	}
?>
