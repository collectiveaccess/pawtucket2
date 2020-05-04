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
			$vn_object_id = $vo_result->get('ca_objects.object_id');		
?>
			<div class="row">
			<table>
			<tr>
				<td>
<?php 
					if ($vs_path = $vo_result->get('ca_object_representations.media.preview170', ['usePath' => 'true'])) {
						print "<div class=\"imageTiny\">".$vs_path."</div>";
					} else {
?>
						<div class="imageTinyPlaceholder">&nbsp;</div>
<?php					
					}	
?>								

				</td><td>
					<div class="metaBlock">
<?php				
						if ($va_entities = $vo_result->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist')))) {
							print "<div class='unit'><h6>Artist</H6>".$va_entities."</div>";
						}
						print "<div class='unit'><h6>Title</h6>".$vo_result->get('ca_objects.preferred_labels')."</div>";
						if ($va_date = $vo_result->get('ca_objects.date')) {
							print "<div class='unit'><h6>Date</h6>".$va_date."</div>";
						}
						if ($va_dimensions = $vo_result->get('ca_objects.dimensions', array('returnWithStructure' => true))) {		
							print "<div class='unit'><h6>Dimensions</h6>";
							foreach ($va_dimensions as $va_key => $va_dimension_t) {
								foreach ($va_dimension_t as $va_key => $va_dimension) {
									$va_dims = array();
									if ($va_dimension['dimensions_height']) {
										$va_dims[] = $va_dimension['dimensions_height']." H";
									}
									if ($va_dimension['dimensions_width']) {
										$va_dims[] = $va_dimension['dimensions_width']." W";
									}
									if ($va_dimension['dimensions_length']) {
										$va_dims[] = $va_dimension['dimensions_length']." L";
									}
									if ($va_dimension['dimensions_thickness']) {
										$va_dims[] = $va_dimension['dimensions_thickness']." thick";
									}	
									print join(' x ', $va_dims);
									if ($va_dimension['dimensions_weight']) {
										$va_dims[] = "<br/>".$va_dimension['dimensions_weight']." weight";
									}
									if ($va_dimension['measurement_notes']) {
										$va_dims[] = "<br/>".$va_dimension['measurement_notes'];
									}																																			
								}						
							}
							print "</div>";
						}
						if ($va_mediums = $vo_result->get('ca_objects.medium', array('delimiter' => ', ', 'convertCodesToDisplayText' => true))) {
							print "<div class='unit'><h6>Medium</h6>".$va_mediums."</div>";
						}
						if ($va_idno = $vo_result->get('ca_objects.accession', array('delimiter' => ', '))) {
							print "<div class='unit'><h6>Catalog Number</h6>".$va_idno."</div>";
						}	
						if ($va_location = $vo_result->get('ca_objects.current_location', array('delimiter' => ', ', 'convertCodesToDisplayText' => true))) {
							print "<div class='unit'><h6>Current Location</h6>".$va_location."</div>";
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