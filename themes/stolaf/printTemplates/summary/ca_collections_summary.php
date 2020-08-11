<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/ca_collections_summary.php
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
 * @tables ca_collections
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
		
	<div class="unit"><H6>{{{^ca_collections.repository.repository_country}}}</H6></div>
	<div class="unit">
	{{{<ifdef code="ca_collections.parent_id"><div class="unit"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></H6></ifdef>}}}
	{{{<ifdef code="ca_collections.label">^ca_collections.label<br/></ifdev>}}}
	</div>

					{{{<ifdef code="ca_collections.adminbiohist"><div class="unit"><H6>Administrative/Biographical History</H6>^ca_collections.adminbiohist%delimiter=,_</div></ifdef>}}}
				
					{{{<ifdef code="ca_collections.abstract"><div class="unit"><H6>Abstract</H6>^ca_collections.abstract%delimiter=,_</div></ifdef>}}}
				
					{{{<ifdef code="ca_collections.scopecontent"><div class="unit"><H6>Scope and Content</H6>^ca_collections.scopecontent%delimiter=,_</div></ifdef>}}}
				
					{{{<ifdef code="ca_collections.unitdate.dacs_date_text"><div class="unit"><H6>Date</H6><unit relativeTo="ca_collections.unitdate" delimiter="<br/>"><ifdef code="ca_collections.unitdate.dacs_dates_labels">^ca_collections.unitdate.dacs_dates_labels: </ifdef>^ca_collections.unitdate.dacs_date_text <ifdef code="ca_collections.unitdate.dacs_dates_types">^ca_collections.unitdate.dacs_dates_types</ifdef></unit></div></ifdef>}}}
				
					{{{<ifdef code="ca_collections.extentDACS">
						<div class="unit"><H6>Extent</H6>
							<unit relativeTo="ca_collections.extentDACS">
								<ifdef code="ca_collections.extentDACS.extent_number">^ca_collections.extentDACS.extent_number </ifdef>
								<ifdef code="ca_collections.extentDACS.extent_type">^ca_collections.extentDACS.extent_type</ifdef>
								<ifdef code="ca_collections.extentDACS.container_summary"><br/>^ca_collections.extentDACS.container_summary</ifdef>
								<ifdef code="ca_collections.extentDACS.physical_details"><br/>^ca_collections.extentDACS.physical_details</ifdef>
							</unit>
						</div>
					</ifdef>}}}
				
					{{{<if rule="^ca_collections.type_id =~ /Folder/"><ifcount code="ca_storage_locations" min="1"><div class="unit"><H6>Location</H6>
						<unit relativeTo="ca_storage_locations" delimiter="<br/>">^ca_storage_locations.hierarchy.preferred_labels%delimiter=_➔_</unit>
					</div>/ifcount></if>}}}
				
					{{{<ifdef code="ca_collections.material_type"><div class="unit"><H6>Material Format</H6>^ca_collections.material_type%delimiter=,_</div></ifdef>}}}
					
					{{{<ifdef code="ca_collections.LcshSubjects"><div class="unit"><H6>Subjects</H6><unit relativeTo="ca_collections.LcshSubjects" delimiter="<br>">^ca_collections.LcshSubjects</unit></div></ifdef>}}}
					
					{{{<ifdef code="ca_collections.relation"><div class="unit"><H6>Related Collections</H6>^ca_collections.relation%delimiter=,_</div></ifdef>}}}
					
					{{{<ifdef code="ca_collections.accessrestrict"><div class="unit"><H6>Restrictions</H6>^ca_collections.accessrestrict%delimiter=,_</div></ifdef>}}}
					
					{{{<ifdef code="ca_collections.physaccessrestrict"><div class="unit"><H6>Physical access</H6>^ca_collections.physaccessrestrict%delimiter=,_</div></ifdef>}}}
					
					{{{<ifdef code="ca_collections.LcshGenre|ca_collections.aat"><div class="unit"><H6>Genres</H6><unit delimiter="<br/>">^ca_collections.LcshGenre</unit><ifdef code="ca_collections.LcshGenre"><br/></ifdef><unit delimiter="<br/>">^ca_collections.aat</unit></div></ifdef>}}}
				
					{{{<ifdef code="ca_collections.preferCite"><div class="unit"><H6>Preferred citation</H6>^ca_collections.preferCite%delimiter=,_</div></ifdef>}}}
									
					{{{<ifcount code="ca_entities" min="1" max="1" restrictToTypes="ind"><H6>Related person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2" restrictToTypes="ind"><H6>Related people</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" restrictToTypes="ind" delimiter=" "><div class="unit">^ca_entities.preferred_labels (^relationship_typename)</div></unit>}}}
				
					{{{<ifcount code="ca_entities" min="1" max="1" restrictToTypes="org"><H6>Related organization</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2" restrictToTypes="org"><H6>Related organizations</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" restrictToTypes="org" delimiter=" "><div class="unit">^ca_entities.preferred_labels (^relationship_typename)</div></unit>}}}
				
					{{{<ifcount code="ca_entities" min="1" max="1" restrictToTypes="fam"><H6>Related family</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2" restrictToTypes="fam"><H6>Related families</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" restrictToTypes="fam" delimiter=" "><div class="unit">^ca_entities.preferred_labels (^relationship_typename)</div></unit>}}}
	
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter=" "><div class="unit">^ca_places.preferred_labels (^relationship_typename)</div></unit>}}}
	
	
	
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><br/>Collection Contents";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
	}
	print $this->render("pdfEnd.php");
?>
