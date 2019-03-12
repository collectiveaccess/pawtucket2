<?php
/* ----------------------------------------------------------------------
 * app/templates/checklist.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2015 Whirl-i-Gig
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
 * @name Artworks (simple)
 * @type page
 * @pageSize A4
 * @pageOrientation portrait
 * @tables ca_objects
 *
 * @marginTop 0.75in
 * @marginLeft 0.25in
 * @marginBottom 0.75in
 * @marginRight 0.25in
 *
 * ----------------------------------------------------------------------
 */

	$t_display				= $this->getVar('t_display');
	$va_display_list 		= $this->getVar('display_list');
	$vo_result_int 				= $this->getVar('result');
	$vn_items_per_page 		= $this->getVar('current_items_per_page');
	$vs_current_sort 		= $this->getVar('current_sort');
	$vs_default_action		= $this->getVar('default_action');
	$vo_ar					= $this->getVar('access_restrictions');
	$vo_result_context 		= $this->getVar('result_context');
#	$vn_num_items			= (int)$vo_result->numHits();
	
	$vn_start 				= 0; 

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");
	
	$va_result_ids = array();
	while($vo_result_int->nextHit()) {
		$va_result_ids[] = $vo_result_int->get('ca_objects.object_id');
	}
	$vo_result = caMakeSearchResult('ca_objects', $va_result_ids, array('sort' => 'ca_objects.idno;ca_entities.preferred_labels.surname;ca_objects.creation_date'));
?>
		<div id='body large'>
<?php
		$vo_result->seek(0);
		
		$vn_line_count = 0;
		$vn_i = true;
		while($vo_result->nextHit()) {
			#if (($t_display->get('display_code') == "artwork_tomb")&&($vn_i == true)){
			#	print "<div class='heading'>".$vo_result->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist')))."</div>";
			#	$vn_i = false;
			#}		
			$vn_object_id = $vo_result->get('ca_objects.object_id');		
?>
			<div class="row">
			<table>
			<tr>
				<td>
					<div class="metaBlock">
<?php		
					print "<div class='data'>".$vo_result->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes'=> array('artist')))."</div>"; 		
					print "<div class='data'>".$vo_result->getWithTemplate('^ca_objects.preferred_labels.name')."</div>"; 
					print "<div class='data'>".$vo_result->getWithTemplate('^ca_objects.creation_date')."</div>";	
					print "<div class='data'>".$vo_result->getWithTemplate('^ca_objects.medium')."</div>";					
					if ($vs_dimensions = $vo_result->getWithTemplate('<ifcount code="ca_objects.dimensions" min="1"><unit><ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height H</ifdef><ifdef code="ca_objects.dimensions.dimensions_width"> x ^ca_objects.dimensions.dimensions_width W</ifdef><ifdef code="ca_objects.dimensions.dimensions_depth"> x ^ca_objects.dimensions.dimensions_depth D</ifdef> <ifdef code="ca_objects.dimensions.height_in|ca_objects.dimensions.width_in|ca_objects.dimensions.depth_in">(</ifdef><ifdef code="ca_objects.dimensions.height_in">^ca_objects.dimensions.height_in H</ifdef><ifdef code="ca_objects.dimensions.width_in"> x ^ca_objects.dimensions.width_in W</ifdef><ifdef code="ca_objects.dimensions.depth_in"> x ^ca_objects.dimensions.depth_in D</ifdef><ifdef code="ca_objects.dimensions.height_in|ca_objects.dimensions.width_in|ca_objects.dimensions.depth_in">)</ifdef><ifdef code="ca_objects.dimensions.dimensions_weight">, ^ca_objects.dimensions.dimensions_weight Weight</ifdef><ifdef code="ca_objects.dimensions.dimensions_notes"><br/>^ca_objects.dimensions.dimensions_notes</ifdef></unit></ifcount>')) {
						print "<div class='data'>".$vs_dimensions."</div>";
					} elseif ($vs_dimensions = $vo_result->get('ca_objects.dimensions_readOnly')) {
						print "<div class='data'>".$vs_dimensions."</div>";
					}
					print "<div class='data'>".$vo_result->getWithTemplate('^ca_objects.edition')."</div>";					
					
?>
					</div>				
				</td>
				<td>
<?php 
					if ($vs_path = $vo_result->getMediaPath('ca_object_representations.media', 'medium')) {
						print "<div class=\"imageTiny\" style='display:inline-block;'><img src='{$vs_path}' style='max-width:200px;height:auto;'/></div>";
					} else { 
?>
						<div class="imageTinyPlaceholder">&nbsp;</div>
<?php					
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