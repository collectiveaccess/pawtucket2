<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_objects_search_html.php 
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
 
	$vo_result 				= $this->getVar('result');
	$vo_result_context 		= $this->getVar('result_context');
	$vo_result 				= $this->getVar('result');
	$vo_result_context 		= $this->getVar('result_context');
	$vs_last_search			= $vo_result_context->getSearchExpression();

 	if (!$this->request->isAjax()) {
?>
	<div id="searchLeftCol">
<?php
	}
?>

 	<div id="searchSearch"><form name="hp_search2" action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get">
			Search: <input type="text" name="search" value="<?php print $vs_last_search; ?>" autocomplete="off" size="100"/><input type="submit" name="op" id="edit-submit" value="GO"  class="form-submit" /><input type="hidden" name="target"  value="ca_objects" />
	</form></div><!-- end searchSearch -->
<?php
	if($vo_result) {
		if($vo_result->numHits()){
			print "<div id='searchFor'>"._t("Results for ")."\"$vs_last_search\"</div><!-- end searchFor -->\n";
		}
		$vo_collection_result = $this->getVar('secondary_search_ca_collections');
		$vn_num_collection_results = $vo_collection_result->numHits();
		$vo_occurrence_result = $this->getVar('secondary_search_ca_occurrences');
		$vn_num_occurrence_results = $vo_occurrence_result->numHits();
?>
 <script type="text/javascript">
  $(document).ready(function() {
    $("#tabs").tabs();
  });
  </script>

	<div id="tabs">
		<ul>
<?php
	if($showObjectResults){
?>
			<li class="ui-corner-top"><a href="#resultBox"><span>Objects (<?php print $this->getVar('num_hits'); ?>)</span></a></li>
<?php
	}
?>
			<li class="ui-corner-top"><a href="#collectionResults"><span>Collections (<?php print $vn_num_collection_results; ?>)</span></a></li>
			<li class="ui-corner-top"><a href="#occurrenceResults"><span>Films (<?php print $vn_num_occurrence_results; ?>)</span></a></li>
		</ul>
<?php
	if($showObjectResults){
?>
		<div id="resultBox">
	
			<div class="sectionBox">
<?php
			$vs_view = $vo_result_context->getCurrentView();
			if ($vo_result->numHits() == 0) { $vs_view = 'no_results'; }
			switch($vs_view) {
				case 'full':
				default:
					print $this->render('Results/ca_objects_results_full_html.php');
					break;
				case 'no_results':
					print $this->render('Results/ca_objects_search_no_results_html.php');
					break;
			}
			print $this->render('Results/paging_controls_html.php');
?>
			</div><!-- end sectionbox -->
		</div><!-- end resultBox -->
<?php
	}
?>
		<div id="collectionResults">
			<div class="sectionBox">
<?php
				print $this->render('Results/search_secondary_results/ca_collections_html.php');
?>		
			</div><!-- end sectionBox -->
		</div><!-- end collectionResults -->
		<div id="occurrenceResults">
			<div class="sectionBox">
<?php
				print $this->render('Results/search_secondary_results/ca_occurrences_html.php');
?>		
			</div><!-- end sectionBox -->
		</div><!-- end occurrenceResults -->

	</div><!-- end tabs -->
<?php
	}

	if (!$this->request->isAjax()) {
?>
	</div><!-- end searchLeftCol -->

	<div id="rightCol" style="margin-top:40px;">
<?php
	print $this->render('/pageFormat/right_col_html.php');
?>
	</div><!-- end rightCol -->
<?php
	}
?>
