<?php
/* ----------------------------------------------------------------------
 * app/templates/checklist.php
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
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Chronology
 * @filename Brand Chronology
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_occurrences
 * @marginTop 0.75in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.5in
 * ----------------------------------------------------------------------
 */

	$t_display				= $this->getVar('t_display');
	$va_display_list 		= $this->getVar('display_list');
	$vo_result 				= $this->getVar('result');
	$vn_items_per_page 		= $this->getVar('current_items_per_page');
	$vs_current_sort 		= $this->getVar('current_sort');
	$vs_default_action		= $this->getVar('default_action');
	$vo_ar					= $this->getVar('access_restrictions');
	$vo_result_context 		= $this->getVar('result_context');
	$vn_num_items			= (int)$vo_result->numHits();
	
	$va_access_values = caGetUserAccessValues($this->request);
	
	$vn_start 				= 0;
	
	$vs_brand = urldecode($this->request->getParameter('brand', pString));

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");
?>
		<div id='body'>
			<div class="chronologyTitle">
				<?php print $vs_brand; ?> Chronology
			</div>
			<div>
				Exported on: <?php print date("d/m/Y"); ?>
			</div><br/>
<?php

		$vo_result->seek(0);
		
		$vn_line_count = 0;
		while($vo_result->nextHit()) {
			$vn_object_id = $vo_result->get('ca_objects.object_id');		
?>
			<div class="row">
			<table style="width:100%">
				<td style="width:25%;">
					<div class="metaBlock" style="width:100%;">
<?php 
					print "<b>".(($vo_result->get("ca_occurrences.display_date")) ? $vo_result->get("ca_occurrences.display_date") : $vo_result->get("ca_occurrences.manufacture_date")).(($vs_season = $vo_result->get("ca_occurrences.season_list", array("convertCodesToDisplayText" => true))) ? ", ".$vs_season : "")."</b>";
?>								

					</div>
				</td><td style="width:75%;">
					<div class="metaBlock" style="width:100%;">
<?php				
						print $vo_result->get('ca_occurrences.preferred_labels');
?>
					</div>				
				</td>	
			</tr>
			</table>	
			</div>
<?php
		}
?>
		</div>
<?php
	print $this->render("pdfEnd.php");
?>