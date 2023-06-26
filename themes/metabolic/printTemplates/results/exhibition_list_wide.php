<?php
/* ----------------------------------------------------------------------
 * app/templates/exhibition_list_wide.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2021 Whirl-i-Gig
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
 * @name Exhibition list (Wide)
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
 * @marginTop 1in
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
				<div>
<?php 

					$exhibitions = $vo_result->getWithTemplate('<unit relativeTo="ca_occurrences" restrictToTypes="exhibition">^ca_occurrences.preferred_labels.name <unit relativeTo="ca_entities" restrictToRelationshipTypes="venue">, ^ca_entities.preferred_labels.displayname</unit>, <ifdef code="ca_occurrences.date">(^ca_occurrences.date)</ifdef></unit>', ['delimiter' => '<br/>', 'returnAsArray' => true]);

					if(is_array($exhibitions) && sizeof($exhibitions)) {
						print "<div class='exhibitions'>".join("<br/>", $exhibitions)."</div>\n";
					}
					
					if ($vs_path = $vo_result->getMediaPath('ca_object_representations.media', 'large')) {
						print "<div class=\"imageWide\"><img src='{$vs_path}' class=\"imageWide\"/></div>";
					} else {
?>
						<div class="imageWidePlaceholder">&nbsp;</div>
<?php					
					}	
?>								

				</div>
				<div>
					<div class="metaBlock">
<?php				
						
						print "<div class='metadata'>".$vo_result->getWithTemplate('
							^ca_objects.preferred_labels.name<br/>
							<ifcount code="ca_entities" restrictToRelationshipTypes="artist,related,photographer">Artist(s): <unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="artist,related,photographer">^ca_entities.preferred_labels.displayname</unit><br/></ifcount>
							<ifdef code="ca_objects.date">^ca_objects.date<br/></ifdef>
							<ifdef code="ca_objects.dimensions"><unit relativeTo="ca_objects.dimensions" delimiter="<br/>">^ca_objects.dimensions.dim_width x ^ca_objects.dimensions.dim_height <ifdef code="ca_objects.dimensions.note">^ca_objects.dimensions.note</ifdef></unit><br/></ifdef>
							<ifdef code="ca_objects.physical_media">^ca_objects.physical_media%delimiter=,_<br/></ifdef>
							<ifdef code="ca_objects.credit_line">Credit line: ^ca_objects.credit_line<br/></ifdef>
							^ca_objects.idno
							<ifdef code="ca_objects.altID">(^ca_objects.altID)</ifdef>
							')."</div>";
						
						print "<div class='metadata'>".$vo_result->getWithTemplate('
							^ca_objects.description<br/>
							<ifdef code="ca_objects.insurance_value">Insurance value: ^ca_objects.insurance_value<br/></ifdef>
							')."</div>";

?>
					</div>				
				</div>		
			</div>
<?php
		}
?>
		</div>
<?= $this->render("pdfEnd.php"); ?>