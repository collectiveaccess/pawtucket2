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
 * @name Field Chart
 * @type page
 * @pageSize letter
 * @pageOrientation landscape
 * @tables ca_objects
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
			<table border="0">
				<tr class="fcRowTitle">
					<td class="fcColLarge">Genus, species, 'Variety/Cultivar'</td>
					<td class="fcColSmall">Height</td>
					<td class="fcColSmall">Width</td>
					<td class="fcColSmall">Spacing</td>
					<td class="fcColSmall">Light</td>
					<td class="fcColMedium">Water Use</td>
					<td class="fcColMedium">Soil Moisture</td>
					<td class="fcColMedium">Soil Type</td>
				</tr>
<?php
		$va_plants_by_type = array();
		$vo_result->seek(0);
		while($vo_result->nextHit()) {
			$vs_label = trim($vo_result->get("ca_objects.genus")." ".$vo_result->get("ca_objects.species"));
			$vs_variety = $vo_result->get("ca_objects.variety");
				
			$vs_name = "<b><i>".$vs_label.(($vs_variety) ? " ".$vs_variety." " : "")."</i></b>";	
			
			$va_plants_by_type[$vo_result->get("ca_objects.plant_type", array("convertCodesToDisplayText" => true))][$vo_result->get("ca_objects.object_id")] = array(
				"name" => $vs_name,
				"height" => $vo_result->get("ca_objects.height", array("delimiter" => ", ")),
				"width" => $vo_result->get("ca_objects.width", array("delimiter" => ", ")),
				"light" => $vo_result->get("ca_objects.light_needs", array("delimiter" => ", ", "convertCodesToDisplayText" => true)),
				"water" => $vo_result->get("ca_objects.water_use", array("delimiter" => ", ", "convertCodesToDisplayText" => true)),
				"soil_moisture" => $vo_result->get("ca_objects.soil_moisture", array("delimiter" => ", ", "convertCodesToDisplayText" => true)),
				"soil_type" => $vo_result->getWithTemplate("<ifdef code='ca_objects.soil_type_best'><unit relativeTo='ca_objects' delimiter=', '>^ca_objects.soil_type_best</unit> (best)</ifdef><ifdef code='ca_objects.soil_type_best|ca_objects.soil_type_tolerates'>; </ifdef><ifdef code='ca_objects.soil_type_tolerates'><unit relativeTo='ca_objects' delimiter=', '>^ca_objects.soil_type_tolerates</unit> (tolerates);</ifdef>")
				
			);
		}
	foreach($va_plants_by_type as $vs_type => $va_plants){
?>
			<tr class="fcRow"><td class="fcColRule" colspan="8"><b><?php print $vs_type; ?></b></td></tr>
<?php
		foreach($va_plants as $va_plant){	
?>
			<tr class="fcRow">
				<td class="fcColLarge">
<?php 
					print $va_plant["name"];	
?>								

				</td>
				<td class="fcColSmall">
<?php
					print $va_plant["height"];
?>							
				</td>
				<td class="fcColSmall">
<?php
					print $va_plant["width"];
?>							
				</td>
				<td class="fcColSmall">
<?php
					print $va_plant["spacing"];
?>							
				</td>
				<td class="fcColSmall">
<?php
					print $va_plant["light"];
?>							
				</td>
				<td class="fcColMedium">
<?php
					print $va_plant["water"];
?>							
				</td>
				<td class="fcColMedium">
<?php
					print $va_plant["soil_moisture"];
?>							
				</td>
				<td class="fcColMedium">
<?php
					print $va_plant["soil_type"];
?>							
				</td>
			</tr>
			<tr class="fcRow"><td class="fcColRule" colspan="8"> </td></tr>
<?php
		}
	}
?>	
			</table>
		</div>
<?php
	print $this->render("pdfEnd.php");
?>