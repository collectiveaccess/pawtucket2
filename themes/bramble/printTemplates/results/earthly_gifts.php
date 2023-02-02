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
 * @name Earthly Gifts
 * @filename Earthly_Gifts.pdf
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
	
	$vn_set_id = $this->request->getParameter('set_id', pInteger);
	$vs_set_name = $vs_project_name = "";
	if($vn_set_id){
		$t_set = new ca_sets($vn_set_id);
		$vs_set_name = $t_set->getLabelForDisplay();
		if($t_set->get("parent_id")){
			$t_parent_set = new ca_sets($t_set->get("parent_id"));
			$vs_project_name = $t_parent_set->getLabelForDisplay();
		}
	}	
	if($vs_set_name || $vs_project_name){
		print "<div class='projectPaletteTitle'>";
		if($vs_project_name){
			print "<b>Project:</b> ".$vs_project_name."<br/>";
		}
		if($vs_set_name){
			print "<b>Palette:</b> ".$vs_set_name."<br/>";
		}
		print "</div>";
	}
	$va_fields = array();
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
				<td class="summaryColDescription">
<?php
					$vs_label = trim($vo_result->get("ca_objects.genus")." ".$vo_result->get("ca_objects.species"));
					$vs_variety = trim(str_replace("'", "", $vo_result->get("ca_objects.variety")));
					$vs_common_name = $vo_result->getWithTemplate("^ca_objects.preferred_labels.name<ifdef code='ca_objects.nonpreferred_labels.name'>(^ca_objects.nonpreferred_labels.name%delimiter=,_)</ifdef>");
					print "<div class='summaryBotanicalName'>".$vs_label.(($vs_variety) ? " '".$vs_variety."' " : "").(($vs_common_name) ? "<br/>".$vs_common_name : "" )."</div>";
					
					foreach($va_fields as $vs_template => $vs_label){
						$vs_tmp = $vo_result->getWithTemplate($vs_template, array("delimiter" => ", "));
						if($vs_tmp){
							print "<div class='summaryUnit'><b>".$vs_label.":</b> ".$vs_tmp."</div>";
						}
					}

					print $vo_result->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToTypes="pollinator"><div class="summaryUnit"><b>Pollinators That Use This Plant: </b><unit relativeTo="ca_entities" restrictToTypes="pollinator" deliiter="<br/>">^ca_entities.preferred_labels (^relationship_typename)</unit></div></ifcount>
														<ifdef code="ca_objects.wildlife_pollinator_benefits|ethnobotanical"><div class="summaryUnit"><b>Earthly Gifts: </b><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.wildlife_pollinator_benefits</unit><ifdef code="ca_objects.wildlife_pollinator_benefits,ethnobotanical">, </ifdef><unit relativeTo="ca_objects" delimiter=", ">^ca_objects.ethnobotanical</unit></div></ifdef>');
?>				
				</td>
			</tr>
			<tr class="summaryRow"><td class="summaryColRule" colspan="2"><br/><br/></td></tr>
<?php
		}
?>	
			</table>
		</div>
<?php
	print $this->render("pdfEnd.php");
?>