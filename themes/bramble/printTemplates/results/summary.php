<?php
/* ----------------------------------------------------------------------
 * app/templates/summary.php
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
 * @name Summary
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
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
	
	$va_fields = array("^ca_objects.usda_zones" => "USDA Hardiness Zones", "^ca_objects.plant_type" => "Plant Type", "^ca_objects.duration" => "Duration", "^ca_objects.height" => "Height", "^ca_objects.width" => "Width", "^ca_objects.spacing" => "Spacing", "^ca_objects.light_needs" => "Exposure (light needs)", "^ca_objects.water_use" => "Water Use", '<ifdef code="ca_objects.soil_type_best"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.soil_type_best</unit> (best)</ifdef><ifdef code="ca_objects.soil_type_best|ca_objects.soil_type_tolerates">; </ifdef><ifdef code="ca_objects.soil_type_tolerates"><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.soil_type_tolerates</unit> (tolerates);</ifdef>' => "Spoil Type", "^ca_objects.soil_ph" => "Soil Salinity Tolerance", "^ca_objects.soil_type_description" => "Soil Description",
						"^ca_objects.resistance" => "Resistance", "^ca_objects.form_habit" => "Form/Habit", "^ca_objects.height_weeks" => "Time to Ultimate Height", "^ca_objects.height_years" => "Time to Ultimate Height", "^ca_objects.growth_rate" => "Growth Rate",
						"^ca_objects.maintenance" => "Maintenance", "^ca_objects.usda_link" => "USDA Link", "^ca_objects.native_state" => "Native to State", "^ca_objects.native_country" => "Native to Country", "^ca_objects.distribution_state" => "Distribution State", "^ca_objects.wetland_indicator_status" => "Wetland Indicator Status", "^ca_objects.native_habitat_type" => "Native Habitat Type", "^ca_objects.found" => "Plant Community");
?>
		<div id='body'>
			<table border="0">
<?php

		$vo_result->seek(0);
		
		$vn_line_count = 0;
		while($vo_result->nextHit()) {
			$vn_object_id = $vo_result->get('ca_objects.object_id');		
?>
			<tr class="summaryRow">
				<td class="summaryColImage">
					<img src='<?php print $vo_result->getMediaPath('ca_object_representations.media', 'medium'); ?>'/>							
				</td>
				<td class="summaryColDescription">
<?php
					$vs_label = trim($vo_result->get("ca_objects.genus")." ".$vo_result->get("ca_objects.species"));
					$vs_variety = trim(str_replace("'", "", $vo_result->get("ca_objects.variety")));
					print "<div class='summaryBotanicalName'>".$vs_label.(($vs_variety) ? " '".$vs_variety."' " : "")."</div>";
					
					foreach($va_fields as $vs_template => $vs_label){
						$vs_tmp = $vo_result->getWithTemplate($vs_template, array("delimiter" => ", "));
						if($vs_tmp){
							print "<div class='summaryUnit'><b>".$vs_label.":</b> ".$vs_tmp."</div>";
						}
					}
?>							
				</td>
			</tr>
			<tr class="summaryRow"><td class="summaryColRule" colspan="2"> </tr>
<?php
		}
?>	
			</table>
		</div>
<?php
	print $this->render("pdfEnd.php");
?>