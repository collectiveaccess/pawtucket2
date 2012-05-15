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
	$vs_search = $vo_result_context->getSearchExpression();

 ?>
 		<div id="breadcrumbTrail">
<?php
		print caNavLink($this->request, "&gt; "._t("Freie Suche"), '', '', 'Search', 'Index');
		print caNavLink($this->request, "&gt; "._t("Ergebnisliste"), '', '', 'Search', 'Index');
?>
		</div><!-- end breadcrumbTrail -->
 	<div id="resultBox">
<?php
	if($vo_result) {
?>
		<h1><?php print ("Ergebnisliste"); ?></h1>
		<div id="searchedFor">
<?php
			print _t("Suche nach").": ".$vs_search;
?>
		</div>
<?php
		print $this->render('Results/paging_controls_html.php');
?>
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
		
		print $this->render('Results/ca_objects_search_secondary_results.php');
?>		
	</div><!-- end sectionbox -->
<?php
	}
?>
	</div><!-- end resultbox -->