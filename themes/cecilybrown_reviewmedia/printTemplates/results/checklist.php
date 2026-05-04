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
 * @name PDF Checklist
 * @filename Checklist
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
?>
		<div id='body'>
			<div class="row">
				<table>
<?php

		$vo_result->seek(0);
		
		$vn_line_count = 0;
		while($vo_result->nextHit()) {
			$vn_object_id = $vo_result->get('ca_objects.object_id');		
?>
			
			<tr>
				<td>
<?php 
					if ($vs_path = $vo_result->getMediaPath('ca_object_representations.media', 'thumbnail')) {
						print "<div class='imageTiny' style='padding-top: 25px;'><img src='{$vs_path}'/></div>";
					} else {
?>
						<div class="imageTinyPlaceholder" style='padding-top: 25px;'>&nbsp;</div>
<?php					
					}	
?>								

				</td><td>
					<div class="metaBlock" style='padding-top: 25px;'>
<?php				
					print "<div class='unit' style='font-size:11px; padding-left:30px;'>".$vo_result->getWithTemplate("<ifcount code='ca_entities' min='1' restrictToRelationshipTypes='artist'><unit relativeTo='ca_entities' restrictToRelationshipTypes='artist' delimiter=', '>^ca_entities.preferred_labels.displayname</unit><br/><br/></ifcount>
						<ifdef code='ca_objects.preferred_labels'><i>^ca_objects.preferred_labels</i></ifdef><ifdef code='ca_objects.date_container.date,ca_objects.preferred_labels'>, </ifdef><ifdef code='ca_objects.date_container.date'>^ca_objects.date_container.date</ifdef><ifdef code='ca_objects.date_container.date|ca_objects.preferred_labels'><br/></ifdef>
						<ifdef code='ca_objects.medium_container.medium'>^ca_objects.medium_container.medium<br/></ifdef>
						<ifdef code='ca_objects.dimensions_container.display_dimensions'>^ca_objects.dimensions_container.display_dimensions<br/></ifdef>
						<ifdef code='ca_objects.edition_size'>^ca_objects.edition_size</ifdef>
						<ifdef code='ca_objects.edition_item.edition_item_number'>^ca_objects.edition_item.edition_item_number</ifdef>")."</div>"; 						
?>
					</div>				
				</td>	
			</tr>
<?php
		}
?>
		
				</table>	
			</div>
		</div>
<?php
	print $this->render("pdfEnd.php");
?>