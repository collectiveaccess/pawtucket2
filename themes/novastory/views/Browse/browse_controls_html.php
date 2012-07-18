<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ca_objects_browse_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2012 Whirl-i-Gig
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
 
	require_once(__CA_MODELS_DIR__.'/ca_objects.php');
	
	$va_facets 				= $this->getVar('available_facets');
	$va_facets_with_content	= $this->getVar('facets_with_content');
	$va_facet_info 			= $this->getVar('facet_info');
	$va_criteria 			= is_array($this->getVar('criteria')) ? $this->getVar('criteria') : array();
	$va_results 			= $this->getVar('result');
	
	$vs_browse_target		= $this->getVar('target');
	
	$t_object = new ca_objects();
	$va_random_items = $t_object->getRandomItems(10, array('checkAccess' => $this->getVar('access_values'), 'hasRepresentations' => 1));
	$va_labels = array();
	$va_media = array();
	if(is_array($va_random_items) && sizeof($va_random_items)){
		$va_labels = $t_object->getPreferredDisplayLabelsForIDs(array_keys($va_random_items));
		$va_media = $t_object->getPrimaryMediaForIDs(array_keys($va_random_items), array('medium'), array('checkAccess' => $this->getVar('access_values')));
	}
	JavascriptLoadManager::register('cycle');
	
	if (!$this->request->isAjax()) {
		if ($this->getVar('browse_selector')) {
	?>
			<div class="browseTargetSelect"><?php print _t('Browse for').' '.$this->getVar('browse_selector'); ?></div>
	<?php
		}
?>
	<h1><?php print _t('Browse the Archive'); ?></h1>
	<div id="browse"><div id="resultBox"> 
<?php
	}
?>
		<div style="position: relative;">
<?php
			if (sizeof($va_criteria)) {
				print "<div id='browseControls'>";
				if (sizeof($va_facets)) { 
?>
					<div id="refineBrowse"><span class='refineHeading'><?php print _t('Refine results by'); ?>:</span>
<?php
						$vn_i = 1;
						$va_available_facets = $this->getVar('available_facets');
						foreach($va_available_facets as $vs_facet_code => $va_facet_info) {
							print "<a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");' class='facetLink'>".$va_facet_info['label_plural']."</a>";
							if($vn_i < sizeof($va_available_facets)){
								print ", ";
							}
							$vn_i++;
						}
?>
					</div><!-- end refineBrowse -->
<?php
				}

				$vn_x = 0;
				print "<div id='browseCriteria'><span class='criteriaHeading'>"._t("You browsed for: ")."</span>";
				foreach($va_criteria as $vs_facet_name => $va_row_ids) {
					$vn_x++;
					$vn_row_c = 0;
					foreach($va_row_ids as $vn_row_id => $vs_label) {
						print "{$vs_label}".caNavLink($this->request, 'x', 'close', '', 'Browse', 'removeCriteria', array('facet' => $vs_facet_name, 'id' => $vn_row_id))."\n";
						$vn_row_c++;
					}
					
				}
				print caNavLink($this->request, _t('start new search')." &rsaquo;", 'startOver', '', 'Browse', 'clearCriteria', array());
				print "</div><!-- end browseCriteria -->\n";
				print "</div><!-- end browseControls -->";
				
			} else {
				print $this->render('Browse/browse_intro_text_html.php');
				print"<div style='clear:both; width: 100%; height: 15px;'></div>";
				if (sizeof($va_facets)) { 
					print "<div class='startBrowsingBy'>"._t("Start browsing by:")."</div>";
					print "<div id='facetList'>";
					$va_available_facets = $this->getVar('available_facets');
					foreach($va_available_facets as $vs_facet_code => $va_facet_info) {
						print "<div class='facetHeadingLink'><h1><a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");'>".$va_facet_info['label_plural']."</a></h1></div>\n";
						print "<div class='facetDescription'>".$va_facet_info["description"]."</div>";
					}
					print "</div><!-- end facetList -->";
				}
				if(is_array($va_random_items) && sizeof($va_random_items)){
					print "<div id='browseSlideshow'>";
					foreach($va_random_items as $vn_object_id => $va_object_info) {
						$randomImageHeight = $va_media[$va_object_info['object_id']]["info"]["medium"]["HEIGHT"];
						$randomImagePadding = ((410 - $randomImageHeight) / 2);
						$va_object_info['title'] = $va_labels[$vn_object_id];
						$va_object_info['media'] = $va_media[$vn_object_id];
						$va_random_items[$vn_object_id] = $va_object_info;
						print "<div id='browseRandomImage' style='padding:".$randomImagePadding."px 0px ".$randomImagePadding."px 0px;'>";
						print caNavLink($this->request, $va_media[$va_object_info['object_id']]["tags"]["medium"], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
						print "<div id='browseRandomCaption'>".caNavLink($this->request, $va_object_info['title'], '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div></div>";
					}
					print "</div>";
?>
					<script type="text/javascript">
					$(document).ready(function() {
					   $('#browseSlideshow').cycle({
								   fx: 'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
								   speed:  1000,
								   timeout: 4000
						   });
					});
					</script>
<?php
				}
			}

?>
		</div><!-- end position:relative -->
<?php
	if (sizeof($va_criteria) > 0) {
		# --- show results
		print $this->render('Results/paging_controls_html.php');
?>
		<a href='#' id='showOptions' onclick='$("#searchOptionsBox").slideDown(250); $("#showOptions").hide(); return false;'><?php print _t("Options"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="6" height="7" border="0"></a>
<?php		
		print $this->render('Search/search_controls_html.php');
		print "<div class='sectionBox'>";
		$vs_view = $this->getVar('current_view');
		if(in_array($vs_view, array_keys($this->getVar('result_views')))){
			print $this->render('Results/'.$vs_browse_target.'_results_'.$vs_view.'_html.php');
		}
		print "</div>";
	}
	if (!$this->request->isAjax()) {
?>
	</div><!-- end resultbox --></div><!-- end browse -->

<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
	<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton">&nbsp;</a>
	<div id="splashBrowsePanelContent">
	
	</div>
</div>
<script type="text/javascript">
	var caUIBrowsePanel = caUI.initBrowsePanel({ 
		facetUrl: '<?php print caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), 'getFacet'); ?>',
		addCriteriaUrl: '<?php print caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), 'addCriteria'); ?>',
		singleFacetValues: <?php print json_encode($this->getVar('single_facet_values')); ?>
	});
	
	//
	// Handle browse header scrolling
	//
	jQuery(document).ready(function() {
		jQuery("div.scrollableBrowseController").scrollable(); 
	});
</script>

<?php
	}
?>
