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
	
	$vs_browse_target		= $this->getVar('target');

	if (!$this->request->isAjax()) {
?>
<div id="browse">
	<div style="position: relative;">
		<div id="navSelectorBrowse"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/navSelector.png' width='25' height='14' border='0'></div><!-- end navSelectorBrowse -->
		
		<div id="browseCriteria">
			<?php
				if (sizeof($va_criteria)) {
			
					$vn_x = 0;
					foreach($va_criteria as $vs_facet_name => $va_row_ids) {
						foreach($va_row_ids as $vn_row_id => $vs_label) {
							$vs_facet_label = (isset($va_facet_info[$vs_facet_name]['label_singular'])) ? unicode_ucfirst($va_facet_info[$vs_facet_name]['label_singular']) : '???';
			?>
							<div class="browseBox">
								<div class="heading"><?php print $vs_facet_label; ?>:</div>
			<?php 			
								print "<div class='browsingBy'>{$vs_label}</div>\n";
			?>
							</div>
			<?php
							$vn_x++;
							if($vn_x < sizeof($va_criteria)){
			?>
								<div class="browseWith">with</div>
			<?php
							}
						}
					}
					
					if (sizeof($va_facets)) { 
?>
						<div class="browseArrow"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/browseArrow.png' width='16' height='24' border='0'></div>
						<div class="browseBoxRefine">
							<div class='heading'>Refine results by:</div>
<?php
							$va_available_facets = $this->getVar('available_facets');
							foreach($va_available_facets as $vs_facet_code => $va_facet_info) {
								print "<div class='browseFacetLink'><a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");'>".$va_facet_info['label_plural']."</a></div>\n";
							}
?>
							<div class="startOver">or <?php  print caNavLink($this->request, _t('start over'), '', '', 'Browse', 'clearCriteria', array()); ?></div>
						</div>
<?php
					}else{
?>
						<div class="browseArrow"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/browseArrow.png' width='16' height='24' border='0'></div>
						<div class="browseBoxRefine">
							<div class="startOver" style="margin-top:0px;"><?php  print caNavLink($this->request, _t('start over'), '', '', 'Browse', 'clearCriteria', array()); ?></div>
						</div>
<?php					
					}
				}else{
					if (sizeof($va_facets)) { 
?>
						<div class="browseBoxRefine">
							<div class="heading">Start browsing by:</div>
<?php 
								$va_available_facets = $this->getVar('available_facets');
								foreach($va_available_facets as $vs_facet_code => $va_facet_info) {
									print "<div class='browseFacetLink'><a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");'>".$va_facet_info['label_plural']."</a></div>\n";
								}
?>
						</div>
<?php
					}
				
				}
?>
		</div><!-- end browseCriteria -->
	</div><!-- end position relative --><div style='clear:both;'><!-- empty --></div></div><!-- end browse --></div><!-- end header --></div><!-- end headerBg -->
	<div id="pageBg">
		<div id="resultBox">
<?php
	}
	if (sizeof($va_criteria) == 0) {
?>
	<div id="browseIntroTitle">
		Browse the Archive
	</div>
	<div id="browseIntroText">
		<div>
<p>You can browse the Digital Archive through the following categories: </p>
<ul>
	<li>people (artists, curators, authors)</li>
	<li>exhibitions </li>
	<li>public programs (panels, performances) </li>
	<li>publications </li>
	<li>object types (images, sound, moving images, text documents) </li>
</ul>
<p>Each of these indexes can be re-sorted by qualifiers listed on the upper-right-hand corner of the box. </p>

Browsing the Digital Archive allows you to discover content or get a sense of what is contained in the database. There are several points of entry for the browse feature: people (artists, curators, authors); exhibitions; public programs (panels, performances); publications; and object types (images, sound, moving images, documents). Each of these indexes can be re-sorted by a variety of qualifiers listed on the upper-right-hand corner of the box. For a chronological list of exhibitions, public programs and books published by the New Museum, browse&mdash;and then sort by year. To see who has curated exhibitions at the Museum, browse by people and sort by role.	
<br />
<br />
The Digital Archive also allows you to browse within the record of an individual or exhibition, applying filters to locate the specific content you want to find. 
		</div>
	<div id="browseIntroTitle">
		Search the Digital Archive 
	</div>
	<div id="browseIntroText">
		<div>
<p>You can also search the Digital Archive using in the search box on the upper-right-hand corner of the screen. Search results will display all records of exhibitions, public programs, and publications, and any digital documents related to your search term. If you are having difficulty with your search, please double check for correct spelling, or try using our browse feature.</p>

	</div>
<?php
	} else {
?>
		<div id="resultsTitle">Results For&nbsp;&nbsp;
			<span id="browsingFor">
<?php
				$vn_c = 0;
				foreach($this->getVar('browse_criteria') as $vs_facet_name => $vs_criteria) {
					if($vn_c){
						print "&nbsp&nbsp;|&nbsp&nbsp;";
					}
					$vn_c = 1;
					print "<b>{$vs_facet_name}</b>: {$vs_criteria}";
				}
?>
			</span>
		</div>
<?php
		print $this->render('Results/ca_objects_results_'.$this->getVar('current_view').'_html.php');
	}
	if (!$this->request->isAjax()) {
?>
	</div><!-- end resultbox -->
	
	<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:auto;">
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
<div id="footerLogo"><img src='<?php print $this->request->getThemeUrlPath(); ?>/graphics/footerLogo.gif' width='149' height='85' border='0'></div><!-- end footerLogo --><div style="clear:both; height:1px;"><!-- empty --></div></div><!-- end pageBg-->
<?php
	}
?>