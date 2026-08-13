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
 * @name Worker Summary (PDF)
 * @filename WorkerSummary
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_entities
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
			$id = $vo_result->get('ca_entities.entity_id');		
?>
			<div class="summaryTitle"><?= $vo_result->get('ca_entities.preferred_labels'); ?></div>
			<div class="representationList">		
<?php
				$primary_rep = $vo_result->getWithTemplate("^ca_object_representations.media.large.path");
				if($primary_rep){
					$primary_rep = "<img src='".$primary_rep."' width='50%' height='auto'>";
					print $primary_rep;
				}
?>
			</div>
<?php
		print $vo_result->getWithTemplate('
			<table style="width:100%; border:0px">
				<tr>
					<td style="width:50%; vertical-align: top;">
						<ifdef code="ca_entities.positions">
							<div class="summaryUnit">
								<div class="summaryLabel"><ifcount code="ca_entities.positions" max="1">Position</ifcount><ifcount code="ca_entities.positions" min="2">Positions</ifcount></div>
								<unit relativeTo="ca_entities.positions" delimiter="">
									<div><ifdef code="ca_entities.positions.position">^ca_entities.positions.position </ifdef><if rule="^ca_entities.positions.unclear !~ /No/">Unclear from Context</if></div>
								</unit>
							</div>
						</ifdef>
						<ifdef code="ca_entities.service_years">
							<div class="summaryUnit">
								<div class="summaryLabel">Years in President\'s House</div>
								<unit relativeTo="ca_entities.service_years" delimiter="">
									<div>^ca_entities.service_years</div>
								</unit>
							</div>
						</ifdef>
						<ifdef code="ca_entities.legal_status">
							<div class="summaryUnit">
								<div class="summaryLabel"><ifcount code="ca_entities.legal_status" max="1">Legal Status</ifcount><ifcount code="ca_entities.legal_status" min="2">Legal Statuses</ifcount></div>
								<unit relativeTo="ca_entities.legal_status" delimiter="">
									<div>^ca_entities.legal_status</div>
								</unit>
							</div>
						</ifdef>
						<ifdef code="ca_entities.gender">
							<div class="summaryUnit">
								<div class="summaryLabel">Gender</div>
								<unit relativeTo="ca_entities.gender" delimiter="">
									<div>^ca_entities.gender</div>
								</unit>
							</div>
						</ifdef>
						<ifdef code="ca_entities.race_ethnicity">
							<div class="summaryUnit">
								<div class="summaryLabel"><ifcount code="ca_entities.race_ethnicity" max="1">Race/Ethnicity</ifcount><ifcount code="ca_entities.race_ethnicity" min="2">Races/Ethnicities</ifcount></div>
								<unit relativeTo="ca_entities.race_ethnicity" delimiter="">
									<div>^ca_entities.race_ethnicity</div>
								</unit>
							</div>
						</ifdef>
						<ifdef code="ca_entities.birthplace">
							<div class="summaryUnit">
								<div class="summaryLabel">Birthplace</div>
								<unit relativeTo="ca_entities.birthplace" delimiter="">
									<div>^ca_entities.birthplace</div>
								</unit>
							</div>
						</ifdef>
						<ifdef code="ca_entities.burial_place">
							<div class="summaryLabel">Burial Place</div>
							<unit relativeTo="ca_entities.burial_place" delimiter="">
								<div>^ca_entities.burial_place</div>
							</unit>
						</ifdef>
					</td>
					<td style="width:50%; vertical-align: top;">
						<ifcount code="ca_entities.related" restrictToTypes="administration" min="1">
							<div class="summaryUnit">
								<div class="summaryLabel"><ifcount code="ca_entities.related" restrictToTypes="administration" min="1" max="1">Presidency</ifcount><ifcount code="ca_entities.related" restrictToTypes="administration" min="2">Presidencies</ifcount></div>
								<unit relativeTo="ca_entities.related" restrictToTypes="administration" delimiter=""><div>^ca_entities.preferred_labels</div></unit>
							</div>
						</ifcount>
					</td>
				</tr>
			</table>				
				<ifdef code="ca_entities.biography">
					<div class="summaryUnit">
						<div class="summaryLabel">Biography</div>
						<div>^ca_entities.biography</div>
					</div>
				</ifdef>
				<ifdef code="ca_entities.sources">
					<div class="summaryUnit">
						<div class="summaryLabel">Footnotes</div>
						<unit relativeTo="ca_entities.sources" delimiter="">
							<div>^ca_entities.sources</div>
						</unit>	
					</div>
				</ifdef>');
?>
						
			<div class="pageBreak"></div>
<?php
		}
?>
		</div>
<?php
	print $this->render("pdfEnd.php");
?>