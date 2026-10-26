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
		
	{{{<ifdef code="ca_collections.repository.repository_country"><div class="unit"><H6 style="display:inline;">Collection Number: </H6>^ca_collections.repository.repository_country</div></ifdef>}}}
	<div class="unit">
	{{{<ifdef code="ca_collections.parent_id"><div class="unit"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></H6></ifdef>}}}
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
					{{{<ifdef code="ca_collections.material_type"><div class="unit"><H6>Material Format</H6>^ca_collections.material_type%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_collections.accessrestrict"><div class="unit"><H6>Restrictions</H6>^ca_collections.accessrestrict%delimiter=,_</div></ifdef>}}}
					
					{{{<ifdef code="ca_collections.physaccessrestrict"><div class="unit"><H6>Physical Access</H6>^ca_collections.physaccessrestrict%delimiter=,_</div></ifdef>}}}

					{{{<ifdef code="ca_collections.preferCite"><div class="unit"><H6>Preferred Citation</H6>^ca_collections.preferCite%delimiter=,_</div></ifdef>}}}
					
					{{{<ifcount code="ca_storage_locations" min="1"><div class="unit"><H6>Location</H6>
						<unit relativeTo="ca_storage_locations" delimiter="<br/>">^ca_storage_locations.hierarchy.preferred_labels%delimiter=_➔_</unit>
					</div></ifcount>}}}
				
					
<?php
					# --- entity name should be the loc name when Entity Source is LCNAF - LcshNames - /\[[^)]+\]/
					print preg_replace('/\[[^)]+\]/', '', $t_item->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToTypes="ind"><div class="unit"><ifcount code="ca_entities" min="1" max="1" restrictToTypes="ind"><H6>Related person</H6></ifcount><ifcount code="ca_entities" min="2" restrictToTypes="ind"><H6>Related people</H6></ifcount><unit relativeTo="ca_entities" restrictToTypes="ind" delimiter="<br/>"><if rule="^ca_entities.entity_source =~ /LCNAF/">^ca_entities.LcshNames<ifnotdef code="ca_entities.LcshNames">^ca_entities.preferred_labels</ifnofdef></if><if rule="^ca_entities.entity_source !~ /LCNAF/">^ca_entities.preferred_labels</if> (^relationship_typename)</unit></div></ifcount>'));
					print preg_replace('/\[[^)]+\]/', '', $t_item->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToTypes="org"><div class="unit"><ifcount code="ca_entities" min="1" max="1" restrictToTypes="org"><H6>Related organization</H6></ifcount><ifcount code="ca_entities" min="2" restrictToTypes="org"><H6>Related organizations</H6></ifcount><unit relativeTo="ca_entities" restrictToTypes="org" delimiter="<br/>"><if rule="^ca_entities.entity_source =~ /LCNAF/">^ca_entities.LcshNames<ifnotdef code="ca_entities.LcshNames">^ca_entities.preferred_labels</ifnofdef></if><if rule="^ca_entities.entity_source !~ /LCNAF/">^ca_entities.preferred_labels</if> (^relationship_typename)</unit></div></ifcount>'));
					print preg_replace('/\[[^)]+\]/', '', $t_item->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToTypes="fam"><div class="unit"><ifcount code="ca_entities" min="1" max="1" restrictToTypes="fam"><H6>Related family</H6></ifcount><ifcount code="ca_entities" min="2" restrictToTypes="fam"><H6>Related families</H6></ifcount><unit relativeTo="ca_entities" restrictToTypes="fam" delimiter="<br/>"><if rule="^ca_entities.entity_source =~ /LCNAF/">^ca_entities.LcshNames<ifnotdef code="ca_entities.LcshNames">^ca_entities.preferred_labels</ifnofdef></if><if rule="^ca_entities.entity_source !~ /LCNAF/">^ca_entities.preferred_labels</if> (^relationship_typename)</unit></div></ifcount>'));
					
					$va_LcshNames = $t_item->get("ca_collections.LcshNames", array("returnAsArray" => true));
					$va_LcshNames_processed = array();
					if(is_array($va_LcshNames) && sizeof($va_LcshNames)){
						foreach($va_LcshNames as $vs_LcshNames){
							if($vs_LcshNames && (strpos($vs_LcshNames, " [") !== false)){
								$va_LcshNames_processed[] = mb_substr($vs_LcshNames, 0, strpos($vs_LcshNames, " ["));
							}else{
								$va_LcshNames_processed[] = $vs_LcshNames;
							}
						}
						$vs_LcshNames = join("<br/>", $va_LcshNames_processed);
					}
					if($vs_LcshNames){
						print "<div class='unit'><H6>Library of Congress Names</H6>".$vs_LcshNames."</div>";	
					}

					$va_LcshSubjects = $t_item->get("ca_collections.LcshSubjects", array("returnAsArray" => true));
					$va_LcshSubjects_processed = array();
					if(is_array($va_LcshSubjects) && sizeof($va_LcshSubjects)){
						foreach($va_LcshSubjects as $vs_LcshSubjects){
							if($vs_LcshSubjects && (strpos($vs_LcshSubjects, " [") !== false)){
								$va_LcshSubjects_processed[] = mb_substr($vs_LcshSubjects, 0, strpos($vs_LcshSubjects, " ["));
							}else{
								$va_LcshSubjects_processed[] = $vs_LcshSubjects;
							}
						}
						$vs_LcshSubjects = join("<br/>", $va_LcshSubjects_processed);
					}
					if($vs_LcshSubjects){
						print "<div class='unit'><H6>Subjects</H6>".$vs_LcshSubjects."</div>";	
					}

					$va_LcshGenre = $t_item->get("ca_collections.LcshGenre", array("returnAsArray" => true));
					$va_LcshGenre_processed = array();
					if(is_array($va_LcshGenre) && sizeof($va_LcshGenre)){
						foreach($va_LcshGenre as $vs_LcshGenre){
							if($vs_LcshGenre && (strpos($vs_LcshGenre, " [") !== false)){
								$va_LcshGenre_processed[] = mb_substr($vs_LcshGenre, 0, strpos($vs_LcshGenre, " ["));
							}else{
								$va_LcshGenre_processed[] = $vs_LcshGenre;
							}
						}
						$vs_LcshGenre = join("<br/>", $va_LcshGenre_processed);
					}
					$va_aat = $t_item->get("ca_collections.aat", array("returnAsArray" => true));
					$va_aat_processed = array();
					if(is_array($va_aat) && sizeof($va_aat)){
						foreach($va_aat as $vs_aat){
							if($vs_aat && (strpos($vs_aat, " [") !== false)){
								$va_aat_processed[] = mb_substr($vs_aat, 0, strpos($vs_aat, " ["));
							}else{
								$va_aat_processed[] = $vs_aat;
							}
						}
						$vs_aat = join("<br/>", $va_aat_processed);
					}
					if($vs_LcshGenre || $vs_aat){
						print "<div class='unit'><H6>Genres</H6>";
						if($vs_LcshGenre){
							print $vs_LcshGenre;
						}
						if($vs_LcshGenre && $vs_aat){
							print "<br/>";
						}
						if($vs_aat){
							print $vs_aat;
						}
						print "</div>";	
					}
?>
					
					{{{<ifdef code="ca_collections.relation"><div class="unit"><H6>Related Collections</H6>^ca_collections.relation%delimiter=,_</div></ifdef>}}}
										
					{{{<ifcount code="ca_places" min="1"><div class="unit"><ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount><ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount><unit relativeTo="ca_places" delimiter="<br/>">^ca_places.preferred_labels (^relationship_typename)</unit></div></ifcount>}}}
	
	
	
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><br/>Collection Contents";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
	}
	print $this->render("pdfEnd.php");
?>
