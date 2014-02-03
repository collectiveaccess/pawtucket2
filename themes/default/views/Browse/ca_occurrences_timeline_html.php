<?php
/* ----------------------------------------------------------------------
 * views/Browse/ca_occurrences_timeline_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 
	$qr_res 			= $this->getVar('result');				// browse results (subclass of SearchResult)
	$va_facets 			= $this->getVar('facets');				// array of available browse facets
	$va_criteria 		= $this->getVar('criteria');			// array of browse criteria
	$vs_key 			= $this->getVar('key');					// cache key for current browse
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
		
		print $this->render("Browse/browse_refine_subview_html.php");	
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
				source:     '<?php print caNavUrl($this->request, '*', '*', '*', array('view' => 'timelineData', 'key' => $vs_key)); ?>',
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
			print $this->render('Browse/browse_panel_subview_html.php');
		} //!ajax
?>