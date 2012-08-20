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
	$vs_view = $vo_result_context->getCurrentView();
	
?>
<div style="clear:both; height:1px; width:100%;"></div>
<?php
	if (!$this->request->isAjax()) {
		print $this->render('Search/search_advanced_controls_html.php');
	}	
 ?>
 	<div id="resultBox">
<?php

	if($vo_result) {
?>
		<h1><?php print _t("Objects from the Digital Archive"); ?></h1>
<?php
		if($vo_result->numHits() > 0){
?>
		 <div id="showForm"><span style="text-decoration:none; font-weight:bold;">Advanced Search Form is Hidden: </span><a href="#" onclick='$("#caAdvancedSearchFormBorder").show(); $("#showForm").hide()'>Show Search Form</a> </div>
<?php
		}
		print $this->render('Results/paging_controls_html.php');
		if($vo_result->numHits() > 0){
?>
			<a href='#' id='showRefine' onclick='jQuery("#searchRefineBox").slideDown(250); jQuery("#showRefine").hide(); jQuery("#searchOptionsBox").slideUp(250); jQuery("#showOptions").show(); jQuery("#searchToolsBox").slideUp(250); jQuery("input.addItemToSetControl").hide(); jQuery("#showTools").show(); return false;'><?php print _t("Filter Search"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="6" height="7" border="0"></a>
			<a href='#' id='showOptions' style='margin-right:10px;' onclick='$("#searchOptionsBox").slideDown(250); $("#showOptions").hide();  $("#searchRefineBox").slideUp(250); $("#showRefine").show(); jQuery("#searchToolsBox").slideUp(250); jQuery("input.addItemToSetControl").hide(); jQuery("#showTools").show(); return false;'><?php print _t("Options"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="6" height="7" border="0"></a>
<?php
			if ($vs_view != 'map' && $this->request->isLoggedIn() && !$this->request->config->get('disable_my_collections') && is_array($va_sets = $this->getVar('available_sets')) && sizeof($va_sets)) {
?>
				<a href='#' id='showTools' style='margin-right:10px;' onclick='$("#searchToolsBox").slideDown(250); $("#showTools").hide();  jQuery("input.addItemToSetControl").show(); $("#searchRefineBox").slideUp(250); $("#showRefine").show(); jQuery("#searchOptionsBox").slideUp(250); jQuery("#showOptions").show(); return false;'><?php print _t("Tools"); ?> <img src="<?php print $this->request->getThemeUrlPath(); ?>/graphics/arrow_right_gray.gif" width="6" height="7" border="0"></a>
<?php
			}

			print $this->render('Search/search_controls_html.php');
			print $this->render('Search/search_refine_html.php');
			if ($vs_view != 'map' && $this->request->isLoggedIn() && !$this->request->config->get('disable_my_collections') && is_array($va_sets = $this->getVar('available_sets')) && sizeof($va_sets)) {
				print $this->render('Search/search_tools_html.php');
			}
		}
?>
	<div class="sectionBox">
<?php
		if ((!$vs_view) || ($vo_result->numHits() == 0) || (!in_array($vs_view, array_keys($this->getVar('result_views'))))) {
			print $this->render('Results/ca_objects_search_no_results_html.php');
		}else{
			print $this->render('Results/ca_objects_results_'.$vs_view.'_html.php');
			# -- hide form if there are results
?>
			<script type="text/javascript">
			jQuery("#caAdvancedSearchFormBorder").hide();
			jQuery("#advancedSearchFormContainerFormSelector").hide();
			
			</script>
<?php
		}		
?>		
	</div><!-- end sectionbox -->
<?php
	}
?>
	</div><!-- end resultbox -->