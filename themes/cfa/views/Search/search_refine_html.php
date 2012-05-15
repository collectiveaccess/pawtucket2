<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/search_refine_html.php 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010-2011 Whirl-i-Gig
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
 
	$o_browse = $this->getVar('browse');
	
	$va_available_facets = $o_browse->getInfoForAvailableFacets();
	if (sizeof($va_available_facets)) { 
?>
		<div id="searchRefineBox"><div class="bg">
			<a href='#' id="hideRefine" onclick='$("#searchRefineBox").slideUp(250); $("#showRefine").show(); return false;'><?php print _t("Hide"); ?> &rsaquo;</a>
		<?php 
					print "<b>"._t('Filter results by').":</b> ";
					$c = 0;
					foreach($va_available_facets as $vs_facet_code => $va_facet_info) {
						$c++;
						print "<a href='#' onclick='caUIBrowsePanel.showBrowsePanel(\"{$vs_facet_code}\");'>".$va_facet_info['label_plural']."</a>";
						if($c < sizeof($va_available_facets)){
							print ", ";
						}
					}
		?>
		</div><!-- end bg --></div><!-- end searchRefineBox -->
		<?php
	}else{
		#if there are no criteria, hide the filter search button
?>
		<script type="text/javascript">
			jQuery('#showRefine').hide(0);
		</script>
<?php
	}
		$va_criteria = $o_browse->getCriteriaWithLabels();
		$va_facet_info = $o_browse->getInfoForFacets();
if(sizeof($va_criteria) > 1){
?>
	<div id="searchRefineParameters"><span class="heading"><?php print _t("Filtering results by"); ?>:</span>&nbsp;&nbsp;

<?php
		foreach($va_criteria as $vs_facet_name => $va_row_ids) {
			foreach($va_row_ids as $vn_row_id => $vs_label) {
				if ($vs_facet_name != '_search') {
					print $vs_label;
					print caNavLink($this->request, 'x', 'close', '', $this->request->getController(), 'removeCriteria', array('facet' => $vs_facet_name, 'id' => $vn_row_id));
				}
			}
		}
	print caNavLink($this->request, _t('clear all filters'), 'button', '',  $this->request->getController(), 'clearCriteria', array()).' <img src="'.$this->request->getThemeUrlPath().'/graphics/arrow_right_gray.gif" width="7" height="8" border="0">';
?>
</div><!-- end searchRefineParameters -->
<?php
}

	if (!$this->request->isAjax()) {
?>
	<script type="text/javascript">
		var caUIBrowsePanel = caUI.initBrowsePanel({ facetUrl: '<?php print caNavUrl($this->request, '', $this->request->getController(), 'getFacet'); ?>'});
	
		//
		// Handle browse header scrolling
		//
		jQuery(document).ready(function() {
			jQuery("div.scrollableBrowseController").scrollable(); 
		});
		
		//jQuery(document).ready(function() { jQuery('#showRefine').click(); });
	</script>
<?php
	}
?>

<div id="splashBrowsePanel" class="browseSelectPanel" style="z-index:1000;">
	<a href="#" onclick="caUIBrowsePanel.hideBrowsePanel()" class="browseSelectPanelButton">&nbsp;</a>
	<div id="splashBrowsePanelContent">
	
	</div>
</div>
<?php
	# keep the refine box open if there are more criteria to refine by and you just did a refine or cleared an option
	if (sizeof($va_available_facets)) { 
?>
	<script type="text/javascript">
	<?php
		if ($this->getVar('open_refine_controls')) {
	?>
		jQuery("#searchRefineBox").show(0);
		jQuery("#showRefine").hide(0); 
		jQuery("#searchOptionsBox").hide(0); 
		jQuery("#showOptions").show(0);
	<?php
		}
	?>
	</script>
<?php
	}
?>