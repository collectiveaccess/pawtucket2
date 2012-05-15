<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ca_objects_browse_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2011 Whirl-i-Gig
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
?>
<div class="single-col">
<?php
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
					<div id="refineBrowse">
						<h3><?php print _t('Refine results by'); ?>:</h3>
<?php
						$vn_i = 1;
						$va_available_facets = $this->getVar('available_facets');
						foreach($va_available_facets as $vs_facet_code => $va_facet_info) {
							print "<a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");'>".$va_facet_info['label_plural']."</a>";
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
				print "<div id='browseCriteria'><p>"._t("You browsed for: ");
				
				foreach($va_criteria as $vs_facet_name => $va_row_ids) {
					$vn_x++;
					$vn_row_c = 0;
					foreach($va_row_ids as $vn_row_id => $vs_label) {
						print "&nbsp;&nbsp;&nbsp;&nbsp;<strong>"."{$vs_label}"."</strong> &nbsp;&nbsp;|&nbsp;&nbsp;".caNavLink($this->request, 'Remove', '', '', 'Browse', 'removeCriteria', array('facet' => $vs_facet_name, 'id' => $vn_row_id))."\n";
						$vn_row_c++;
					}
					
				}
				print "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				print caNavLink($this->request, _t('Start new search'), '', '', 'Browse', 'clearCriteria', array());
				print "</p>";
				print "</div><!-- end browseCriteria -->\n";
				print "</div><!-- end browseControls -->";
				
			} else {
?>
				<p class="intro">Choose a topic you would like to explore.</p>
<?php				
				if (sizeof($va_facets)) { 
					//Roundabout added config options
					$ra_categories = array(
						'artists' => $this->request->config->get('ra_browse_artists'),
						'costumes' => $this->request->config->get('ra_browse_costumes'),
						'orchestrations' => $this->request->config->get('ra_browse_orchestrations'),
						'photographs' => $this->request->config->get('ra_browse_photographs'),
						'playbills' => $this->request->config->get('ra_browse_playbills'),
						'posters' => $this->request->config->get('ra_browse_posters'),
						'productions' => $this->request->config->get('ra_browse_productions'),	
						'scripts' => $this->request->config->get('ra_browse_scripts'),
						'sketch' => $this->request->config->get('ra_browse_sketch'),
						'video' => $this->request->config->get('ra_browse_video')
					);
					$va_available_facets = $this->getVar('available_facets'); 
?>
					
					<ul class="browse-thumbs-list">
					
<?php
					//print "<div class='startBrowsingBy'>"._t("Start browsing by:")."</div>";
					//print "<div id='facetList'>";
					$array_categories = array();
					foreach($va_available_facets as $vs_facet_code => $va_facet_info) {
						if($va_facet_info['label_plural'] != 'Object types') {
							$desc = $ra_categories[strtolower($va_facet_info['label_plural'])]['description'];
							$newDesc = (strlen($desc) > 120) ? substr($desc, 0, 120).'...' : $desc;
							
?>
							
<?php 
							  
							$html =	"<li>";
							$html .= "<a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");' class='thumb-link'>";		
							$html .= 	"<img src='".$this->request->getThemeUrlPath()."/img/".$ra_categories[strtolower($va_facet_info['label_plural'])]['thumb']."' />";
							$html .= "</a>";

							$html .= "<a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");'>";	
							$html .=    "<h4>".$va_facet_info['label_plural']."</h4>";
							$html .= 	"<p>".$newDesc."</p>";
							$html .= "</a>"; 
							$html .= "</li>";
									
							$array_categories[$va_facet_info['label_plural']] = $html;
							/*	echo "<li>";
								echo "<a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");' class='thumb-link'>";		
								echo 	"<img src='".$this->request->getThemeUrlPath()."/img/".$ra_categories[strtolower($va_facet_info['label_plural'])]['thumb']."' />";
								echo "</a>";
								
								echo "<a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");'>";	
								echo    "<h4>".$va_facet_info['label_plural']."</h4>";
								echo 	"<p>".$newDesc."</p>";
								echo "</a>"; 
								echo "</li>";
							*/
?>
							
<?php
						} //end if
					} // end foreach
					
					foreach($ra_categories as $category => $value) { 
						if($category != 'artists' && $category != 'productions') {
							$desc = $value['description'];
							$newDesc = (strlen($desc) > 120) ? substr($desc, 0, 120).'...' : $desc;

							$html = '<li>';
							$html .=	'<a href="' .caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), 'modifyCriteria'). '/facet/objects_facet/id/' .$value['id']. '/mod_id/0" class="thumb-link">';
							$html .=		'<img src="' .$this->request->getThemeUrlPath(). '/img/' .$value['thumb']. '" />';
							$html .=	'</a>';
							$html .=	'<a href="' .caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), 'modifyCriteria'). '/facet/objects_facet/id/' .$value['id']. '/mod_id/0">';
							$html .=		'<h4>' .$value['title']. '</h4>';
							$html .=		'<p>' .$newDesc. '</p>';
							$html .=	'</a>';
							$html .='</li> ';
								
							$array_categories[$value['title']] = $html;
						} // end if
					} // end foreach
					ksort($array_categories, SORT_STRING);
					foreach($array_categories as $listItem) {
						print $listItem;
					}
?>
					</ul>
					
<?php 			} // end if
			}
?>
		</div><!-- end position:relative -->
		
<?php
	if (sizeof($va_criteria) > 0) {
		# --- show results
		print $this->render('Results/paging_controls_html.php');
?>
		
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
	</div><!-- end resultbox -->
</div><!-- end browse -->

<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
	<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton">&nbsp;</a>
	<div id="splashBrowsePanelContent">
	
	</div>
</div>

</div><!--end #single-col-->
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
		var ie7Overlay = function() {
			var overlayEl = $('#exposeMask');
			if(overlayEl.length < 1) {
				
			}
			
			return {
				
			}
		}
		jQuery("div.scrollableBrowseController").scrollable(); 
	});
</script>
<?php
	}
?>