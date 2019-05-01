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
		
	<div class="unit"><H6>{{{^ca_collections.type_id}}}{{{<ifdef code="ca_collections.idno">, ^ca_collections.idno</ifdef>}}}</H6></div>
	<div class="unit">
	{{{<ifdef code="ca_collections.parent_id"><div class="unit"><H6>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; ">^ca_collections.preferred_labels.name</unit></H6></ifdef>}}}
	{{{<ifdef code="ca_collections.label">^ca_collections.label<br/></ifdev>}}}
	</div>
	<div class="unit">
<?php
					if ($vs_altID_array = $t_item->get('ca_collections.alternateID', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
						print "<br/><H6>Alternate Identifier</H6>";
						$i = 1;
						foreach ($vs_altID_array as $va_key => $va_altID_t) {
							foreach ($va_altID_t as $va_key => $vs_altID) {
								print "<b class='gray'>".$vs_altID['alternateIDdescription']."</b>: ".$vs_altID['alternateID'];
								if($i < sizeof($va_altID_t)){
									print "<br/>";
								}
								$i++;
							}
						}
					}
					if ($vs_repo = $t_item->get('ca_collections.repository', array('convertCodesToDisplayText' => true))) {
						print "<br/><H6>Repository</H6>".$vs_repo;
					}		
					if ($va_relation = $t_item->get('ca_collections.relation', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
						$va_relation = array_pop($va_relation);
						$i = 1;
						$va_tmp = array();
						foreach($va_relation as $va_relation_info){
							$vs_tmp = "";
							if($va_relation_info["relationQualifier"]){
								$vs_tmp .= $va_relation_info["relationQualifier"].": ";
							}
							if($va_relation_info["relation"]){
								$vs_tmp .= $va_relation_info["relation"];
							}
							$va_tmp[] = $vs_tmp;
						}
						if(sizeof($va_tmp)){
							print "<br/><H6>Related Archival Materials</H6>";
							print join($va_tmp, "<br/><br/>");
						}
					}													
					# --- collections
					if ($vs_collections = $t_item->getWithTemplate("<ifcount code='ca_collections.related' min='1'><unit relativeTo='ca_collections'>^ca_collections.preferred_labels (^relationship_typename)</unit></ifcount>")){	
						print "<br/><H6>"._t("Related Series")."</H6>";
						print $vs_collections;
					}			
					# --- entities
					if ($vs_entities = $t_item->getWithTemplate("<ifcount code='ca_entities' min='1'><unit relativeTo='ca_entities'>^ca_entities.preferred_labels.displayname</unit></ifcount>")){	
						print "<br/><H6>"._t("Creator")."</H6>";
						print $vs_entities;
						print "</div><!-- end unit -->";
					}
					# --- places
					if ($vs_places = $t_item->getWithTemplate("<ifcount code='ca_places' min='1'><unit relativeTo='ca_places'>^ca_places.preferred_labels (^relationship_typename)</unit></ifcount>")){	
						print "<br/><H6>"._t("Geographic Locations")."</H6>";
						print $vs_places;
					}	
					if ($vs_description = $t_item->get('ca_collections.description')) {
						print "<br/><H6>Description</H6>".$vs_description;
					}
?>
				</div>
	
	
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><br/>Collection Contents";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
	}
	print $this->render("pdfEnd.php");
?>
