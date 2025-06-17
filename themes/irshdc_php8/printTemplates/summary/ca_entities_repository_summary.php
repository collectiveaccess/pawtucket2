n<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/ca_entities_summary.php
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
 * @name Collection Finding Aid
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_entities
 * @restrictToTypes repository
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
	$va_access_values = 	$this->getVar("access_values");

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	

	$vs_entity_image = $t_item->getWithTemplate("<ifdef code='ca_object_representations.media.medium'>^ca_object_representations.media.medium<if rule='^ca_object_representations.preferred_labels.name !~ /BLANK/'><div class='small text-center'>^ca_object_representations.preferred_labels.name</div></if><br/><br/></ifdef>", array("checkAccess" => $va_access_values, "limit" => 1));

?>
	<div class="title">
		<h1 class="title"><?php print $t_item->getLabelForDisplay();?></h1>
		{{{<ifdef code="ca_entities.link"><div class="source"><a href="^ca_entities.link" target="_blank">^ca_entities.link</a></div></ifdef>}}}
	</div>

	<div class="representationList">		
<?php
		if($vs_entity_image){
			print $vs_entity_image;
		}
?>
	</div>
				{{{<ifcount code="ca_entities.related" restrictToTypes="school" min="1"><div class="unit"><H6>Related School<ifcount code="ca_entities.related" restrictToTypes="school" min="2">s</ifcount></H6><unit relativeTo="ca_entities.related" restrictToTypes="school" delimiter=", ">^ca_entities.preferred_labels.displayname</unit></div></ifcount>}}}
					{{{<ifdef code="ca_entities.description_new.description_new_txt">
						<div class="unit"><h6>Description</h6>
							^ca_entities.description_new.description_new_txt
							<ifdef code="ca_entities.description_new.description_new_source"><div class="source">Source: ^ca_entities.description_new.description_new_source</div></ifdef>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_entities.public_notes|ca_entities.nonpreferred_labels.displayname">
						<div class="unit">
							<h3>More Information <span class="glyphicon glyphicon-collapse-down" aria-hidden="true"></span></H3>
							<div>
								<ifdef code="ca_entities.nonpreferred_labels.displayname"><div class='unit'><H6>Alternate Name(s)</H6><unit relativeTo="ca_entities" delimiter="<br/>">^ca_entities.nonpreferred_labels.displayname</unit></div></ifdef>
								<ifdef code="ca_entities.public_notes"><div class='unit'><h6>Notes</h6>^ca_entities.public_notes%delimiter=<br/></div></ifdef>
								
							</div>
						</div>
					</ifdef>}}}
<?php
	print $this->render("entities_summary_related_records.php");
	print $this->render("pdfEnd.php");
?>