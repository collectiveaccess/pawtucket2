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
					{{{<div class="title"><h1 class="title">^ca_collections.preferred_labels <ifdef code="ca_collections.GMD">[<unit relativeTo="ca_collections.GMD" delimiter=", ">^ca_collections.GMD</unit>]</ifdef><ifdef code="ca_collections.OtherTitle">: ^ca_collections.OtherTitle </ifdef><ifdef code="ca_collections.nonpreferred_labels"> = ^ca_collections.nonpreferred_labels </ifdef><ifdef code="creator_name"> / ^ca_collections.creator_name</ifdef></H1></div>
						<ifdef code="ca_collections.suptitlnote"><div class="unit"><H6>Supplied title note</H6>^ca_collections.suptitlnote</div></ifdef>
					}}}
<?php					
					if($t_item->get("ca_collections.parent_id")){
						$va_path = explode(";", $t_item->getWithTemplate('<unit relativeTo="ca_collections.hierarchy" delimiter=";">^ca_collections.preferred_labels.name</unit>'));
						$va_path = array_slice($va_path, 0, (sizeof($va_path)-1));
						if(is_array($va_path) && sizeof($va_path)){
							print '<div class="unit"><H6>Part of</H6>'.implode(" > ", $va_path).'</div>';
						}
					}
?>					
					{{{<ifdef code="ca_collections.idno"><div class="unit"><H6>^ca_collections.type_id number</H6>^ca_collections.idno</div></ifdef>
						<ifdef code="ca_collections.archive_dates.archive_display"><div class="unit"><H6>Date(s)</H6>^ca_collections.archive_dates.archive_display</div></ifdef>
						<ifdef code="ca_collections.physical_description"><div class="unit"><H6>Physical description</H6><span class="trimText">^ca_collections.physical_description</span></div></ifdef>
						<ifdef code="ca_collections.physdesnote"><div class="unit"><H6>Physical description note</H6><span class="trimText">^ca_collections.physdesnote</span></div></ifdef>
						<ifdef code="ca_collections.history_bio"><div class="unit"><H6>Administrative history / Biographical sketch</H6><span class="trimText">^ca_collections.history_bio</span></div></ifdef>
						<ifdef code="ca_collections.scope_content"><div class="unit"><H6>Scope & content</H6><span class="trimText">^ca_collections.scope_content</span></div></ifdef>
						<ifdef code="ca_collections.arrangement"><div class="unit"><H6>Arrangement</H6><span class="trimText">^ca_collections.arrangement</span></div></ifdef>
						<ifdef code="ca_collections.language"><div class="unit"><H6>Languages</H6>^ca_collections.language%delimiter=,_</div></ifdef>
						<ifdef code="ca_collections.related_material"><div class="unit"><H6>Related materials</H6>^ca_collections.related_material</div></ifdef>
						<ifdef code="ca_collections.reproRestrictions.reproduction|ca_collections.reproRestrictions.access_restrictions"><div class="unit"><H6>Restrictions</H6><ifdef code="ca_collections.reproRestrictions.reproduction"><b>Reproductions: </b>^ca_collections.reproRestrictions.reproduction<br/></ifdef><ifdef code="ca_collections.reproRestrictions.access_restrictions"><b>Access: </b>^ca_collections.reproRestrictions.access_restrictions</ifdef></div></ifdef>
<<<<<<< HEAD
						<ifcount code="ca_entities" min="1"><H6>Related people</H6><unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit></ifcount>
						<ifcount code="ca_occurrences" min="1" restrictToTypes="vessel"><H6>Related vessels</H6><unit relativeTo="ca_occurrences" restrictToTypes="vessel"><ifdef code="ca_occurrences.vesprefix">^ca_occurrences.vesprefix </ifdef><l><i>^ca_occurrences.preferred_labels</i></l>  ^ca_occurrences.vessuffix</unit></ifcount>
=======
						<ifcount code="ca_entities" min="1"><div class="unit"><H6>Related people</H6><unit relativeTo="ca_entities" delimiter="<br/>">^ca_entities.preferred_labels.displayname</unit></div></ifcount>
						<ifcount code="ca_occurrences" min="1" restrictToTypes="vessel"><div class="unit"><H6>Related vessels</H6><unit relativeTo="ca_occurrences" restrictToTypes="vessel"><ifdef code="ca_occurrences.vesprefix">^ca_occurrences.vesprefix </ifdef><i>^ca_occurrences.preferred_labels</i>  ^ca_occurrences.vessuffix</unit></div></ifcount>
>>>>>>> host/banhammer
					}}}
<?php
				$va_lcsh = $t_item->get("ca_collections.lcsh_terms", array("returnAsArray" => true));
				if(is_array($va_lcsh) && sizeof($va_lcsh)){
					print '<div class="unit"><H6>LC Subject Headings</H6>';
					$va_terms = array();
					foreach($va_lcsh as $vs_term){
						$vn_pos = strpos($vs_term, "[");
						if ($vn_pos !== false) {
     						$vs_term = trim(substr($vs_term, 0, $vn_pos));
						}
<<<<<<< HEAD
						$va_terms[] = caNavLink($this->request, $vs_term, "", "", "MultiSearch", "Index", array("search" => $vs_term));
=======
						$va_terms[] = $vs_term;
>>>>>>> host/banhammer
						
					}
					print join("<br/>", $va_terms);
					print '</div>';
				}
?>



	
<?php
	if ($t_item->get("ca_collections.children.collection_id") || $t_item->get("ca_objects.object_id")){
		print "<hr/><br/>Collection Contents";
		if ($t_item->get('ca_collections.collection_id')) {
			print caGetCollectionLevelSummary($this->request, array($t_item->get('ca_collections.collection_id')), 1);
		}
	}
	print $this->render("pdfEnd.php");
?>
