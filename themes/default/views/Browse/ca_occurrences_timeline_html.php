<?php
	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_browse_key 		= $this->getVar('key');					// cache key for current browse
	$va_access_values 	= $this->getVar('access_values');		// list of access values for this user
	$vn_hits_per_block 	= (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results

	$vb_ajax			= (bool)$this->request->isAjax();
	
	AssetLoadManager::register('timeline');
if (!$vb_ajax) {	// !ajax
?>
<div id='pageArea' class='browse'>
	<div id='pageTitle'>
<?php 
		print _t('Browse Productions');
		
		if (sizeof($va_criteria) > 0) { 
			print "<div class='facetLabel' style='margin-bottom:10px;'><a href='".caNavUrl($this->request, '', 'Browse', 'Productions', array('view' => 'timeline'))."' >View All</a></div>";
		}
		foreach($va_facets as $vs_facet_name => $va_facet_info) {
			if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { continue; }
			
			print "<div class='facetLabel'>Filter by ".$va_facet_info['label_singular']."</div>"; 
			
			$vn_facet_size = sizeof($va_facet_info['content']);
			$vn_c = 0;
			foreach($va_facet_info['content'] as $va_item) {
				print "<div class='facet'>".caNavLink($this->request, $va_item['label'], '', '*', '*','*', array('key' => $vs_browse_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'view' => 'timeline'))."</div>";
				$vn_c++;
				
				if (($vn_c == 7) && ($vn_facet_size > 7) && ($vn_facet_size <= 60)) {
					print "<div id='{$vs_facet_name}_more' style='display: none;'>";
				} else {
					if(($vn_c == 7) && ($vn_facet_size > 60))  {
						break;
					}
				}
			}
			if (($vn_facet_size > 7) && ($vn_facet_size <= 60)) {
				print "</div>\n";
				print "<div class='facet'><a href='#' onclick='jQuery(\"#{$vs_facet_name}_more\").slideToggle(250); return false;'><em>"._t("and %1 more", $vn_facet_size - 7)."</em></a></div>";
			} elseif (($vn_facet_size > 7) && ($vn_facet_size > 60)) {
				print "<div class='facet'><a href='#' onclick='caBrowsePanel.showPanel(\"".caNavUrl($this->request, '*', '*', '*', array('getFacet' => 1, 'facet' => $vs_facet_name, 'view' => 'timeline', 'key' => $vs_browse_key))."\"); return false;'><em>"._t("and %1 more", $vn_facet_size - 7)."</em></a></div>";
			}
		}		
?>		
		
		
	</div>
	<div id='timelineContentArea'>
		
	<?php
		$vn_criteria_count = 0;
		if (sizeof($va_criteria) > 0) {
			foreach($va_criteria as $va_criterion) {
				if ($va_criterion['facet_name'] == '_search') { continue; }
				print "<div class='chosenFacet'>".$va_criterion['facet'].': '.$va_criterion['value'].'   '."</div>";
			}
			print "<div style='float: right;' class='startOver'>".caNavLink($this->request, _t('Start over'), '', '*', '*','*', array('clear' => 1, 'view' => 'timeline'))."</div>";
		}
?>
		<div class='browseResults'>
<?php
		} // !ajax
		
		
?>

<div id="timeline-embed"></div>
    <script>
		$(document).ready(function() {
			createStoryJS({
				type:       'timeline',
				width:      '900',
				height:     '600',
				source:     '<?php print caNavUrl($this->request, '*', '*', '*', array('view' => 'timelineData', 'key' => $vs_browse_key)); ?>',
				embed_id:   'timeline-embed'
			});
		});
	</script>

<?php
		if (!$vb_ajax) {	// !ajax
?>
		</div>

	</div><!-- end contentArea-->
</div><!-- end pageArea-->	

<div id="caBrowsePanel"> 
	<div id="caBrowsePanelContentArea">
	
	</div>
</div>
<script type="text/javascript">
/*
	Set up the "caBrowsePanel" panel that will be triggered by links in object detail
	Note that the actual <div>'s implementing the panel are located here in views/pageFormat/pageFooter.php
*/
var caBrowsePanel;
jQuery(document).ready(function() {
	if (caUI.initPanel) {
		caBrowsePanel = caUI.initPanel({ 
			panelID: 'caBrowsePanel',										/* DOM ID of the <div> enclosing the panel */
			panelContentID: 'caBrowsePanelContentArea',		/* DOM ID of the content area <div> in the panel */
			exposeBackgroundColor: '#000000',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
			exposeBackgroundOpacity: 0.8,							/* opacity of background color masking out page content; 1.0 is opaque */
			panelTransitionSpeed: 400, 									/* time it takes the panel to fade in/out in milliseconds */
			allowMobileSafariZooming: true,
			mobileSafariViewportTagID: '_msafari_viewport',
			closeButtonSelector: '.close'					/* anything with the CSS classname "close" will trigger the panel to close */
		});
	}
});
</script>
<?php
		} //!ajax
?>