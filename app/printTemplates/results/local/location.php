<?php
/* ----------------------------------------------------------------------
 * app/templates/thumbnails.php
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
 * @name Location
 * @type page
 * @pageSize letter
 * @pageOrientation landscape
 * @tables ca_objects
 *
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
	$vs_color 				= ($this->request->config->get('report_text_color')) ? $this->request->config->get('report_text_color') : "FFFFFF";;
	
	$vn_start 				= 0;

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");
?>
		<div id='body'>
<?php

		$vo_result->seek(0);
		
		$vn_lines_on_page = 0;
		$vn_items_in_line = 0;
		
		$vn_left = $vn_top = 0;
		while($vo_result->nextHit()) {
			$vn_object_id = $vo_result->get('ca_objects.object_id');		
?>
			<div class="thumbnail" style="left: <?php print $vn_left; ?>px; top: <?php print $vn_top; ?>px; text-align:center;">
				<?php print "<div class='imgThumb'><img src='".$vo_result->getMediaPath('ca_object_representations.media', 'small')."' style='max-height:180px; max-width:160px;'/></div>"; ?>
				<br/>
<?php 
				print "<div class='caption'>".$vo_result->get("ca_objects.idno");
				$va_storage_locations = $vo_result->get("ca_storage_locations", array("returnAsArray" => true, "checkAccess" => $va_access_values));
				if(sizeof($va_storage_locations)){
					$t_location = new ca_storage_locations();
					$t_relationship = new ca_objects_x_storage_locations();
					$vn_now = date("Y.md");
					$va_location_display = array();
					foreach($va_storage_locations as $va_storage_location){
						$t_relationship->load($va_storage_location["relation_id"]);
						$va_daterange = $t_relationship->get("effective_daterange", array("rawDate" => true, "returnAsArray" => true));
						if(is_array($va_daterange) && sizeof($va_daterange)){
							foreach($va_daterange as $va_date){
								break;
							}
							#print $vn_now." - ".$va_date["effective_daterange"]["start"]." - ".$va_date["effective_daterange"]["end"];
							if(is_array($va_date)){
								if(($vn_now > $va_date["effective_daterange"]["start"]) && ($vn_now < $va_date["effective_daterange"]["end"])){
									# --- only display the top level from the hierarchy
									$va_hierarchy_ancestors = array_reverse(caExtractValuesByUserLocale($t_location->getHierarchyAncestors($va_storage_location["location_id"], array("includeSelf" => 1, "additionalTableToJoin" => "ca_storage_location_labels", "additionalTableSelectFields" => array("name")))));
									foreach($va_hierarchy_ancestors as $va_ancestor){
										$va_location_display[] = $va_ancestor["name"];
										break;
									}
								}
							}
						}else{
							# --- only display the top level from the hierarchy
							$va_hierarchy_ancestors = array_reverse(caExtractValuesByUserLocale($t_location->getHierarchyAncestors($va_storage_location["location_id"], array("includeSelf" => 1, "additionalTableToJoin" => "ca_storage_location_labels", "additionalTableSelectFields" => array("name")))));
							foreach($va_hierarchy_ancestors as $va_ancestor){
								$va_location_display[] = $va_ancestor["name"];
								break;
							}
							#$vs_location_display .= $va_storage_location["name"]."<br/>";
						}
					}
					if(sizeof($va_location_display)){
						print "<br/><b>Location: </b>".join(", ", $va_location_display);
					}
				}
				print "</div>";
?>
			</div>
<?php

			$vn_items_in_line++;
			$vn_left += 220;
			if ($vn_items_in_line >= 3) {
				$vn_items_in_line = 0;
				$vn_left = 0;
				$vn_top += 240;
				$vn_lines_on_page++;
				print "<br class=\"clear\"/>\n";
			}
			
			if ($vn_lines_on_page >= 2) { 
				$vn_lines_on_page = 0;
				$vn_left = $vn_top = 0;
				print "<div class=\"pageBreak\">&nbsp;</div>\n";
			}
		}
?>
		</div>
<?php
	print $this->render("pdfEnd.php");
?>
