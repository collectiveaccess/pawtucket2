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
 ?>
 <?php
	if (!$this->request->isAjax()) {
?>
<div style="float:left;">
 	<!--div class="maincolimage" style="margin-top:16px;">
		<img class="showcase" src="<?php print $this->request->getThemeUrlPath()?>/graphics/city/the-jim-kemmy-municipal-museum-02.jpg" alt="The Jim Kemmy Municipal Museum" title="" />
	</divi-->
	<div class="maincol">	
		<h1 style="margin-top:10px;">Catalogue</h1>
		
		<a class="searchbox-button" style="float:right; margin:18px 10px 20px 0px;" href="/index.php">Back to Catalogue</a><br/>

 	<div id="resultBox">
<?php 	
	}
	if($vo_result) { 	
?>
 	<div class="searchsearchbox">
					<form action="<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>" method="get" id="searchform1">
						<fieldset style="border:0px">
							<p><label for="keyword">by keyword</label><input type="text" name="search" value="<?php print ($vs_search) ? $vs_search : ''; ?>" onclick='jQuery("#quickSearch").select();' id="quickSearch"  autocomplete="off" /><input type="hidden" name="searchtype" value="keyword" /><input class="button" type="image" src="<?php print $this->request->getThemeUrlPath()?>/graphics/city/search-button.png" alt="search" /></p>
						</fieldset>
					</form>
	</div>
<?php
 	
		$vn_num_hits = $this->getVar('num_hits');
		if (ResultContext::getLastFind($this->request, 'ca_objects') != 'basic_browse') {
			print '<div style="margin-top:2px; clear:left;">'._t('Your %1 for <b>'.ucfirst($vo_result_context->getSearchExpression()).'</b> returned %2 %3.', $this->getVar('mode_type_singular'), $vn_num_hits, ($vn_num_hits == 1) ? _t('result') : _t('results'))."</div>";
		} else {
			print '<div style="margin-top:2px; clear:left;">'._t('Your %1 returned %2 %3.', $this->getVar('mode_type_singular'), $vn_num_hits, ($vn_num_hits == 1) ? _t('result') : _t('results'))."</div>";
		}
		if(($this->getVar('num_pages') > 1)){	
			print $this->render('Results/paging_controls_html.php');
		} else {
			print "<div class='divide'></div>";
		}
		if($vo_result->numHits() > 0){
?>
			<a href='#' id='showRefine' onclick='jQuery("#searchRefineBox").slideDown(250); jQuery("#showRefine").hide(); jQuery("#searchOptionsBox").slideUp(250); jQuery("#showOptions").show(); return false;'><?php print _t("Filter Search"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="6" height="7" border="0"></a>
<?php
		}
		print $this->render('Search/search_controls_html.php');
?>
		<a href='#' id='showOptions' onclick='$("#searchOptionsBox").slideDown(250); $("#showOptions").hide();  $("#searchRefineBox").slideUp(250); $("#showRefine").show(); return false;'><?php print _t("Options"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="6" height="7" border="0"></a>
<?php
		if($vo_result->numHits() > 0){
			print $this->render('Search/search_refine_html.php');
		}
?>
	<div class="sectionBox">
<?php
		$vs_view = $vo_result_context->getCurrentView();
		if ($vo_result->numHits() == 0) { $vs_view = 'no_results'; }
		switch($vs_view) {
			case 'full':
				print $this->render('Results/ca_objects_results_full_html.php');
				break;
			case 'map':
				print $this->render('Results/ca_objects_results_map_html.php');
				break;
			case 'no_results':
				print $this->render('Results/ca_objects_search_no_results_html.php');
				break;
			default:
				print $this->render('Results/ca_objects_results_thumbnail_html.php');
				break;
		}
		
		print $this->render('Results/ca_objects_search_secondary_results.php');
		if(($this->getVar('num_pages') > 1)){	
			print $this->render('Results/paging_controls_html.php');
		}
?>		
	</div><!-- end sectionbox -->
<?php
	}
	if (!$this->request->isAjax()) {
?>
	</div><!-- end resultbox -->
<?php
	}
?>
	</div><!-- end searchboxes -->
	</div><!-- end maincol -->
</div>
