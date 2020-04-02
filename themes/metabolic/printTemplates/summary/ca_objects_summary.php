<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/summary.php
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
 * @name Object tear sheet
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
 * @marginTop 1in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.75in
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	

?>
	<div class="title">
		<h1 class="title">{{{^ca_objects.idno}}}</h1>
	</div>
	<div class="representationList">
		
<?php
	$va_reps = $t_item->getRepresentations(array("thumbnail", "mediumlarge"));

	foreach($va_reps as $va_rep) {
		if(sizeof($va_reps) > 1){
			# --- more than one rep show thumbnails
			$vn_padding_top = ((120 - $va_rep["info"]["thumbnail"]["HEIGHT"])/2) + 5;
			print $va_rep['tags']['thumbnail']."\n";
		}else{
			# --- one rep - show medium rep
			print $va_rep['tags']['mediumlarge']."\n";
		}
	}
?>
	</div>
	<br/><br/><table style="width:100%;">
		<td style="width:50%;">
			{{{<ifdef code="ca_objects.preferred_labels.name">
				<div class="unit">
					<div class="label">Title</div>
					^ca_objects.preferred_labels.name
				</div>
			</ifdef>}}}
			{{{<ifdef code="ca_objects.altID">
				<div class="unit">
					<div class="label">Alternate Identifier</div>
					^ca_objects.altID
				</div>
			</ifdef>}}}
			{{{<ifdef code="ca_objects.date">
				<div class="unit">
					<div class="label">Date</div>
					^ca_objects.date%delimiter=,_
				</div>
			</ifdef>}}}
			{{{<ifdef code="ca_objects.item_subtype">
				<div class="unit">
					<div class="label">Type</div>
					^ca_objects.item_subtype
				</div>
			</ifdef>}}}
			{{{<ifcount code="ca_collections" min="1">
				<div class="unit">
					<div class="label">Project<ifcount code="ca_collections" min="2">s</ifcount></div>
					<unit relativeTo="ca_collections" delimiter=", ">^ca_collections.preferred_labels.name</unit>
				</div>
			</ifcount>}}}
			{{{<ifdef code="ca_objects.phase">
				<div class="unit">
					<div class="label">Phase</div>
					^ca_objects.phase%delimiter=,_
				</div>
			</ifdef>}}}
		
		</td>
		<td style="width:50%;">
						{{{<ifcount code="ca_occurrences" restrictToTypes="exhibition" min="1">
							<div class="unit">
								<div class="label">Exhibitions</div>
								<unit relativeTo="ca_occurrences" restrictToTypes="exhibition" delimiter=", ">^ca_occurrences.preferred_labels.name</unit>
							</div>
						</ifcount>}}}
						{{{<ifcount code="ca_occurrences" restrictToTypes="action" min="1">
							<div class="unit">
								<div class="label">Actions</div>
								<unit relativeTo="ca_occurrences" restrictToTypes="action" delimiter=", ">^ca_occurrences.preferred_labels.name</unit>
							</div>
						</ifcount>}}}
						{{{<ifcount code="ca_entities" min="1">
							<div class="unit">
								<div class="label">People/Organizations</div>
								<unit relativeTo="ca_entities" delimiter=", ">^ca_entities.preferred_labels</unit>
							</div>
						</ifcount>}}}
<?php
						$va_tags = $t_item->getTags();
						if(is_array($va_tags) && sizeof($va_tags)){
							$va_tags_processed = array();
							foreach($va_tags as $va_tag){
								$va_tags_processed[$va_tag["tag_id"]] = $va_tag["tag"];
							}
?>
							<div class="unit">
								<div class="label">Tags</div>
								<unit relativeTo="ca_item_tags" delimiter=", ">
<?php
									print join(", ", $va_tags_processed);
?>
								</unit>
							</div>
<?php
						}				
?>
		</td>
	</table>
<?php	
	print $this->render("pdfEnd.php");