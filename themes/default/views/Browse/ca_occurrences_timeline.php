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
<div id='pageArea' class='browseOccurrences'>
	<div id='pageTitle'>
<?php 
		print _t('Browse Productions');
		
		print "<div class='facetLabel' style='margin-bottom:10px;'><a href='".caNavUrl($this->request, '', 'Browse', 'Productions', array('format' => 'timeline'))."' >View All</a></div>";
		foreach($va_facets as $vs_facet_name => $va_facet_info) {
			
			print "<div class='facetLabel'>Filter by ".$va_facet_info['label_singular']."</div>"; 

			foreach($va_facet_info['content'] as $va_item) {
				print "<div class='facet'>".caNavLink($this->request, $va_item['label'], '', '*', '*','*', array('key' => $vs_browse_key, 'facet' => $vs_facet_name, 'id' => $va_item['id'], 'format' => 'timeline'))."</div>";
			}
		}		
?>		
		
		
	</div>
	<div id='contentArea'>
		
	<?php
		if (sizeof($va_criteria) > 0) {
			foreach($va_criteria as $va_criterion) {
				print "<div class='chosenFacet'>".$va_criterion['facet'].': '.$va_criterion['value'].'   '."</div>";
			}
			print "<div class='startOver'>".caNavLink($this->request, _t('Start over'), '', '*', '*','*', array('clear' => 1))."</div>";
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
				source:     '<?php print caNavUrl($this->request, '*', '*', '*', array('format' => 'timelineJSON', 'key' => $vs_browse_key)); ?>',
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
<?php
		} //!ajax
?>