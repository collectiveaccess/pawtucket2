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
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
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
	
	$vn_start 				= 0;
	
	$va_access_values = caGetUserAccessValues($this->request);

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");
?>
		<div id='body'>
<?php

		$vo_result->seek(0);
		
		$vn_line_count = 0;
		while($vo_result->nextHit()) {
			$vn_object_id = $vo_result->get('ca_objects.object_id');		
?>
			<div class="row">
			<table>
			<tr>
				<td width="120px">
<?php 
					if ($vs_path = $vo_result->getMediaPath('ca_object_representations.media', 'small')) {
						print "<div class=\"imageTiny\"><img src='{$vs_path}' style='max-width:120px;'/></div>";
					} else {
?>
						<div class="imageTinyPlaceholder">&nbsp;</div>
<?php					
					}	
?>								

				</td><td>
					<div class="metaBlock" style='font-family: Helvetica;'>
<?php				
					print "<div>".$vo_result->get("ca_objects.type_id", array("convertCodesToDisplayText" => true))."</div>";
					print "<div class='title'>".$vo_result->getWithTemplate('^ca_objects.preferred_labels.name (^ca_objects.idno)')."</div>"; 
					if($vs_entities = $vo_result->get("ca_entities", array("delimiter" => ", ", "restrictToRelationshipTypes" => array("creator"), "checkAccess" => $va_access_values))){
						print "<div><b>Creator:</b> ".$vs_entities."</div>";
					}
					if($vo_result->get("ca_objects.creation_date")){
						print "<div><b>Creation date:</b> ".$vo_result->get("ca_objects.creation_date")."</div>";
					}
					
					if($vo_result->get("ca_objects.dimensions.display_dimensions")){
						print "<div><b>Dimensions:</b> ".$vo_result->get("ca_objects.dimensions.display_dimensions")."</div>";
					}else{
						if($vo_result->get("ca_objects.dimensions.dimensions_height") || $vo_result->get("ca_objects.dimensions.dimensions_width") || $vo_result->get("ca_objects.dimensions.dimensions_depth") || $vo_result->get("ca_objects.dimensions.dimensions_length")){
							print "<div><b>Dimensions:</b> ";
							$va_dimension_pieces = array();
							if($vo_result->get("ca_objects.dimensions.dimensions_height")){
								$va_dimension_pieces[] = $vo_result->get("ca_objects.dimensions.dimensions_height");
							}
							if($vo_result->get("ca_objects.dimensions.dimensions_width")){
								$va_dimension_pieces[] = $vo_result->get("ca_objects.dimensions.dimensions_width");
							}
							if($vo_result->get("ca_objects.dimensions.dimensions_depth")){
								$va_dimension_pieces[] = $vo_result->get("ca_objects.dimensions.dimensions_depth");
							}
							if($vo_result->get("ca_objects.dimensions.dimensions_length")){
								$va_dimension_pieces[] = $vo_result->get("ca_objects.dimensions.dimensions_length");
							}
							if(sizeof($va_dimension_pieces)){
								print join(" x ", $va_dimension_pieces);
							}
							print "</div>";
						}
					}
					if($vo_result->get("ca_objects.dimensions_frame.display_dimensions_frame")){
						print "<div><b>Dimensions with frame:</b> ".$vo_result->get("ca_objects.dimensions_frame.display_dimensions_frame")."</div>";
					}else{
						if($vo_result->get("ca_objects.dimensions_frame.dimensions_frame_height") || $vo_result->get("ca_objects.dimensions_frame.dimensions_frame_width") || $vo_result->get("ca_objects.dimensions_frame.dimensions_frame_depth") || $vo_result->get("ca_objects.dimensions_frame.dimensions_frame_length")){
							print "<div><b>Dimensions with frame:</b> ";
							$va_dimension_pieces = array();
							if($vo_result->get("ca_objects.dimensions_frame.dimensions_frame_height")){
								$va_dimension_pieces[] = $vo_result->get("ca_objects.dimensions_frame.dimensions_frame_height");
							}
							if($vo_result->get("ca_objects.dimensions_frame.dimensions_frame_width")){
								$va_dimension_pieces[] = $vo_result->get("ca_objects.dimensions_frame.dimensions_frame_width");
							}
							if($vo_result->get("ca_objects.dimensions_frame.dimensions_frame_depth")){
								$va_dimension_pieces[] = $vo_result->get("ca_objects.dimensions_frame.dimensions_frame_depth");
							}
							if($vo_result->get("ca_objects.dimensions_frame.dimensions_frame_length")){
								$va_dimension_pieces[] = $vo_result->get("ca_objects.dimensions_frame.dimensions_frame_length");
							}
							if(sizeof($va_dimension_pieces)){
								print join(" x ", $va_dimension_pieces);
							}
							print "</div>";
						}
					}
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
							print "<div><b>Location: </b>".join(", ", $va_location_display)."</div>";
						}
					}

					
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