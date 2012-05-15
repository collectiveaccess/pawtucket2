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

	if($vo_result) {
		if (!$this->request->isAjax()) {
?>
			<h1><?php print _t("Objects from the Digital Archive"); ?></h1>
			<div class="sectionBox">
<?php
		}
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
		
		if ((!$this->request->isAjax()) || ($this->request->isAjax() && in_array($this->getVar("search_type"), array("ca_places", "ca_entities", "ca_collections", "ca_occurrences")))) {
			print $this->render('Results/ca_objects_search_secondary_results.php');
		}
		if (!$this->request->isAjax()) {
?>		
			</div><!-- end sectionbox -->
<?php
		}
	}
?>
