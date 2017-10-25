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
 * @marginTop 0.75in
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
		<h1 class="title"><?php print $t_item->getLabelForDisplay();?></h1>
	</div>
	<div class="representationList">
		
<?php
	$va_reps = $t_item->getRepresentations(array("thumbnail", "medium"));

	foreach($va_reps as $va_rep) {
		if(sizeof($va_reps) > 1){
			# --- more than one rep show thumbnails
			$vn_padding_top = ((120 - $va_rep["info"]["thumbnail"]["HEIGHT"])/2) + 5;
			print $va_rep['tags']['thumbnail']."\n";
		}else{
			# --- one rep - show medium rep
			print $va_rep['tags']['medium']."\n";
		}
	}
?>
	</div>
	<div class='tombstone'>	
		{{{<ifcount min="1" code="ca_collections"><div class='unit'><H6>Collection</H6><unit relativeTo="ca_collections" delimiter="<br/>">^ca_collections.preferred_labels.name</unit></div></ifcount>}}}
		{{{<ifdef code="ca_objects.idno"><div class='unit'><H6>Identifier</H6>^ca_objects.idno</div></ifdef>}}}			
		<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
		<HR>
		{{{<ifdef code="ca_objects.description">
			<div class='unit'><h6>Description</h6>
				<span class="trimText">^ca_objects.description</span>
			</div>
			<HR>
		</ifdef>}}}
				
		{{{<ifdef code="ca_objects.date"><div class='unit'><H6>Date</H6><unit relativeTo="ca_objects.date" delimiter="<br/>">^ca_objects.date.date_value ^ca_objects.date.date_types</unit></div></ifdev>}}}
		{{{<ifdef code="ca_objects.dimensions.dimensions_length|ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_height|ca_objects.dimensions.dimensions_thickness|ca_objects.dimensions.dimensions_diameter|ca_objects.dimensions.dimensions_weight"><div class='unit'><H6>Dimensions</H6></ifdef>
			<ifdef code="ca_objects.dimensions.dimensions_length">^ca_objects.dimensions.dimensions_length (length)<ifdef code="ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_height|ca_objects.dimensions.dimensions_thickness|ca_objects.dimensions.dimensions_diameter|ca_objects.dimensions.dimensions_weight"> x </ifdef></ifdef>
			<ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width (width)<ifdef code="ca_objects.dimensions.dimensions_height|ca_objects.dimensions.dimensions_thickness|ca_objects.dimensions.dimensions_diameter|ca_objects.dimensions.dimensions_weight"> x </ifdef></ifdef>
			<ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height (height)<ifdef code="ca_objects.dimensions.dimensions_thickness|ca_objects.dimensions.dimensions_diameter|ca_objects.dimensions.dimensions_weight"> x </ifdef></ifdef>
			<ifdef code="ca_objects.dimensions.dimensions_thickness">^ca_objects.dimensions.dimensions_thickness (thickness)<ifdef code="ca_objects.dimensions.dimensions_diameter|ca_objects.dimensions.dimensions_weight"> x </ifdef></ifdef>
			<ifdef code="ca_objects.dimensions.dimensions_diameter">^ca_objects.dimensions.dimensions_diameter (diameter)<ifdef code="ca_objects.dimensions.dimensions_weight"> x </ifdef></ifdef>
			<ifdef code="ca_objects.dimensions.dimensions_weight">^ca_objects.dimensions.dimensions_weight (weight)</ifdef>
			</div>}}}
		{{{<ifdef code="ca_objects.curatorial_category"><div class='unit'><H6>Curatorial Category</H6>^ca_objects.curatorial_category%delimiter=,_</div></ifdef>}}}
		<hr/>
		<div class='unit'>{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><div class='unit'><H6>Related people</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="1"><unit relativeTo="ca_objects_x_entities" delimiter="<br/>"><unit relativeTo="ca_entities">^ca_entities.preferred_labels</unit> (^relationship_typename)</unit><br/><br/></ifcount>}}}
							
							{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related exhibition/event</H6></ifcount>}}}
							{{{<ifcount code="ca_occurrences" min="2"><H6>Related exhibitions/events</H6></ifcount>}}}
							{{{<unit relativeTo="ca_objects_x_occurrences" delimiter="<br/>"><unit relativeTo="ca_occurrences">^ca_occurrences.preferred_labels</unit> (^relationship_typename)</unit>}}}
							</div>
	</div>							

<?php	
	print $this->render("pdfEnd.php");