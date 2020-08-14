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
	<br/><br/><div style="text-align:center; padding-right:35px; padding-left:35px;"><table style="width:100%;">
				<tr><td colspan="2"><hr/></td></tr>
<?php
	if($vs_metapoetics = strip_tags($t_item->get('ca_objects.metapoetics.metapoetics_text'), '<b><em><i><strong><ul><ol><li><blockquote><u><s><sup><sub>')){
?>
		<tr>
			<td class="metapoetics" colspan="2">
<?php
				print $vs_metapoetics;
?>
			</td>
		</tr>
<?php
	}
?>
	</table>
	<table style="width:100%;">
		<tr>
			<td style="width:45%; vertical-align:top;">
<?php
				$vs_title = $t_item->get("ca_objects.preferred_labels.name");
				if($vs_title && (strToLower($vs_title) != "[no title]") && (strToLower($vs_title) != "[blank]")){
?>
					<div class="unit">
						<div class="label">Title</div><?php print $vs_title; ?>
					</div>
<?php							
				}
?>
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
				{{{<ifdef code="ca_objects.dim_width|ca_objects.dim_height|ca_objects.dim_depth|ca_objects.note">
					<div class="unit">
						<div class="label">Dimensions</div>
						<unit relativeTo="ca_objects.dimensions" delimiter="; ">^dim_width x ^dim_height<ifdef code="dim_depth"> x ^dim_depth</ifdef><ifdef code="note">(^note)</ifdef></unit>
					</div>
				</ifdef>}}}
				{{{<ifcount code="ca_collections" min="1">
					<div class="unit">
						<div class="label">Project<ifcount code="ca_collections" min="2">s</ifcount></div>
						<unit relativeTo="ca_collections" delimiter=", ">^ca_collections.preferred_labels.name</unit>
					</div>
				</ifcount>}}}
		
			</td>
			<td style="width:10%; vertical-align:top;"> </td>
			<td style="width:45%; vertical-align:top;">
							{{{<ifcount code="ca_occurrences" restrictToTypes="exhibition" min="1">
								<div class="unit">
									<div class="label">Exhibitions</div>
									<unit relativeTo="ca_occurrences" restrictToTypes="exhibition" delimiter="<br/><br/>">
										^ca_occurrences.preferred_labels.name<case><ifcount code="ca_entities" restrictToTypes="org" restrictToRelationshipTypes="venue" min="1"><br/></ifcount><ifdef code="ca_occurrences.date"><br/></ifdef></case><ifcount code="ca_entities" restrictToTypes="org" restrictToRelationshipTypes="venue" min="1"><unit relativeTo="ca_entities" restrictToTypes="org" restrictToRelationshipTypes="venue" delimiter=", ">^ca_entities.preferred_labels</unit><ifdef code="ca_occurrences.date">, </ifdef></ifcount><ifdef code="ca_occurrences.date">^ca_occurrences.date</ifdef>
									</unit>
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
		</tr>
	</table></div>
<?php	
	print $this->render("pdfEnd.php");