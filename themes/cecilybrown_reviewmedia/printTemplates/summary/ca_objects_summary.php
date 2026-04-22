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
	<HR/>
	{{{<ifdef code="ca_objects.idno"><div class='unit'>^ca_objects.type_id, ^ca_objects.idno</div></ifdef>}}}
	
	<div class="representationList">
		
<?php
	$va_reps = $t_item->getRepresentations(array("small", "large"));

	foreach($va_reps as $va_rep) {
		if(sizeof($va_reps) > 1){
			# --- more than one rep show thumbnails
			print $va_rep['tags']['small']."\n";
		}else{
			# --- one rep - show medium rep
			print "<div class='largeImage'>".$va_rep['tags']['large']."</div>\n";
		}
	}
?>
	</div>
	<div>
		<div class='tombstone' style="text-align:center;">
			{{{<div class='unit'><ifcount code="ca_entities" min="1" restrictToRelationshipTypes="artist"><unit relativeTo="ca_entities" restrictToRelationshipTypes="artist" delimiter=", ">^ca_entities.preferred_labels.displayname</unit><br/><br/></ifcount>
			<ifdef code="ca_objects.preferred_labels"><i>^ca_objects.preferred_labels</i></ifdef><ifdef code="ca_objects.date_container.date,ca_objects.preferred_labels">, </ifdef><ifdef code="ca_objects.date_container.date">^ca_objects.date_container.date</ifdef><ifdef code="ca_objects.date_container.date|ca_objects.preferred_labels"><br/></ifdef>
			<ifdef code="ca_objects.medium_container.medium">^ca_objects.medium_container.medium<br/></ifdef>
			<ifdef code="ca_objects.dimensions_container.display_dimensions">^ca_objects.dimensions_container.display_dimensions<br/></ifdef>
			<ifdef code="ca_objects.edition_size">^ca_objects.edition_size</ifdef>
			<ifdef code="ca_objects.edition_item.edition_item_number">^ca_objects.edition_item.edition_item_number</ifdef></div>}}}
		</div>
	</div>
<?php	
	print $this->render("pdfEnd.php");