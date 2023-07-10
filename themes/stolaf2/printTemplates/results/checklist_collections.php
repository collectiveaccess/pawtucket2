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
 * @name Checklist
 * @filename Checklist
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_collections
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
	
	$vn_start 				= 0;

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");
?>
		<div id='body'>
<?php

		$vo_result->seek(0);
		
		$vn_line_count = 0;
		while($vo_result->nextHit()) {
			$vn_collection_id = $vo_result->get('ca_collections.collection_id');		
?>
			<div class="row">
			<table>
			<tr>
				<td>
<?php				
					print "<div class='title'>".$vo_result->getWithTemplate('^ca_collections.hierarchy.preferred_labels%delimiter=_>_')."</div>"; 
					$vs_date = $vo_result->getWithTemplate("<unit relativeTo='ca_collections.unitdate' delimiter='; '><ifdef code='ca_collections.unitdate.dacs_dates_labels'>^ca_collections.unitdate.dacs_dates_labels: </ifdef>^ca_collections.unitdate.dacs_date_text <ifdef code='ca_collections.unitdate.dacs_dates_types'>^ca_collections.unitdate.dacs_dates_types</ifdef></unit>");
					if(trim($vs_date)){
						print "<div class='unit'><span class='displayHeader'>Date</span>: <span class='displayValue'>".$vs_date."</span></div>";
					}
					$vs_extent = $vo_result->getWithTemplate("<unit relativeTo='ca_collections.extentDACS'><ifdef code='ca_collections.extentDACS.extent_number'>^ca_collections.extentDACS.extent_number </ifdef><ifdef code='ca_collections.extentDACS.portion_label'>^ca_collections.extentDACS.portion_label </ifdef><ifdef code='ca_collections.extentDACS.extent_type'>^ca_collections.extentDACS.extent_type</ifdef><ifdef code='ca_collections.extentDACS.container_summary'><ifdef code='ca_collections.extentDACS.extent_number|ca_collections.extentDACS.portion_label|ca_collections.extentDACS.extent_type'>; </ifdef>^ca_collections.extentDACS.container_summary</ifdef><ifdef code='ca_collections.extentDACS.physical_details'><ifdef code='ca_collections.extentDACS.extent_number|ca_collections.extentDACS.portion_label|ca_collections.extentDACS.extent_type'>; </ifdef>^ca_collections.extentDACS.physical_details</ifdef></unit>");
					if($vs_extent){
						print "<div class='unit'><span class='displayHeader'>Extent</span>: <span class='displayValue'>".$vs_extent."</span></div>";
					}
					$vs_location = $vo_result->getWithTemplate("<unit relativeTo='ca_storage_locations' delimiter='; '>^ca_storage_locations.hierarchy.preferred_labels%delimiter=_>_</unit>");
					if($vs_location){
						print "<div class='unit'><span class='displayHeader'>Location</span>: <span class='displayValue'>".$vs_location."</span></div>";
					}
?>		
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