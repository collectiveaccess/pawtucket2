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
<?php
		if ($this->getVar('browse_selector') && sizeof($va_criteria) == 0) {
?>
			<div class="browseTargetSelect"><?php print _t('Browse for').' '.$this->getVar('browse_selector'); ?></div>
<?php
		}
?>
	<h1><?php print _t('Browse the Archive'); ?></h1>
<?php
			if (sizeof($va_criteria)) {
				$vn_x = 0;
				print "<div id='browseCriteria'>";
				print "<div class='startOver'>".caNavLink($this->request, _t('Start over'), '', '', 'Browse', 'clearCriteria', array())." &rsaquo;</div>";
				print "<span class='criteriaHeading'>"._t("Browsing by: ")."</span>";
				foreach($va_criteria as $vs_facet_name => $va_row_ids) {
					$vn_x++;
					$vn_row_c = 0;
					foreach($va_row_ids as $vn_row_id => $vs_label) {
						print $vs_label;
						$vn_row_c++;
						if(($vn_x < sizeof($va_criteria)) || ($vn_row_c < sizeof($va_row_ids))){
							", ";
						}
					}
					
				}
				print "</div><!-- end browseCriteria -->\n";
				
			} else {
?>
				<div id="browseList"><div class='textContent' id='introtext'>
<?php
				print $this->render('Browse/browse_intro_text_html.php');
?>
				</div>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery('#introText').expander({
							slicePoint: 250,
							expandText: '<?php print _t('more &rsaquo;'); ?>',
							userCollapse: false
						});
					});
				</script>
<?php
				if (sizeof($va_facets)) { 
					print "<div class='listHeading'>"._t("Browse by:")."</div>";
					print "<div class='listItems'>";
					$va_available_facets = $this->getVar('available_facets');
					foreach($va_available_facets as $vs_facet_code => $va_facet_info) {
						#print "<div class='item'><a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");'>".$va_facet_info['label_plural']."</a></div>\n";
						print "<div class='item'><a href='#' onclick='jQuery(\"#browseList\").load(\"".caNavUrl($this->request, '', 'Browse', 'getFacet', array('facet' => $vs_facet_code))."\"); jQuery(\".browseTargetSelect\").hide(); return false;'>".$va_facet_info['label_plural']."</a></div>\n";
						#print "<div class='facetDescription'>".$va_facet_info["description"]."</div>";
					}
					print "</div><!-- end listItems -->";
				}
?>
				</div><!-- end browseList -->
<?php
			}
	}
	if (sizeof($va_criteria) > 0) {
		# --- show results
		print "<div class='sectionBox'>";
		print $this->render('Results/'.$vs_browse_target.'_results_'.$this->getVar('current_view').'_html.php');
		print "</div>";
	}
	if (!$this->request->isAjax()) {
?>
	</div><!-- end browse -->
<?php
	}
?>