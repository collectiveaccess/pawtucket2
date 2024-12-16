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
	$access_values = caGetUserAccessValues($this->request);

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
	
						{{{<dl class="mb-0">
							<ifdef code="ca_objects.idno">
								<dt><?= _t('Bringing History Home ID'); ?></dt>
								<dd>^ca_objects.idno</dd>
							</ifdef>
							<ifdef code="ca_objects.accession_num">
								<dt><?= _t('Accession Number'); ?></dt>
								<dd>^ca_objects.accession_num</dd>
							</ifdef>
							<ifdef code="ca_objects.nonpreferred_labels">
								<dt><?= _t('Alternate Title(s)'); ?></dt>
								<dd>^ca_objects.nonpreferred_labels%delimiter=,_</dd>
							</ifdef>
<?php
							#$this->setVar("restrict_to_relationship_types", array("creator", "designer", "author", "artist"));
							$va_entities = $t_item->get("ca_entities", array("returnWithStructure" => 1, "checkAccess" => $access_values, "restrictToRelationshipTypes" => $va_restrict_to_relationship_types));
							if(is_array($va_entities) && sizeof($va_entities)){
								$va_entities_by_type = array();
								foreach($va_entities as $va_entity_info){
									$va_entities_by_type[$va_entity_info["relationship_typename"]][] = $va_entity_info["displayname"];
								}
								foreach($va_entities_by_type as $vs_type => $va_entity_links){
									print "<dt>".$vs_type."</dt><dd>".join(", ", $va_entity_links)."</dd>";
								}
							}

?>
							<ifdef code="ca_objects.description">
								<dt><?= _t('Description'); ?></dt>
								<dd>
									^ca_objects.description
								</dd>
							</ifdef>
							<ifdef code="ca_objects.material">
								<dt><?= _t('Material(s)'); ?></dt>
								<unit relativeTo="ca_objects.material" delimiter=" ">
									<dd>
										<ifdef code="ca_objects.material.material_text">^ca_objects.material.material_text</ifdef><ifdef code="ca_objects.material.material_text,ca_objects.material.material_generated">, </ifdef>
										<ifdef code="ca_objects.material.material_generated">^ca_objects.material.material_generated</ifdef>
									</dd>
								</unit>
							</ifdef>
							<ifdef code="ca_objects.dimensions.dimensions_height|ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_depth">
								<dt><?= _t('Dimensions'); ?></dt>
								<unit relativeTo="ca_objects.dimensions" delimiter=" ">
									<dd>
										<ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height<ifdef code="ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_depth"> x </ifdef></ifdef>
										<ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width<ifdef code="ca_objects.dimensions.dimensions_depth"> x </ifdef></ifdef>
										<ifdef code="ca_objects.dimensions.dimensions_depth">^ca_objects.dimensions.dimensions_depth</ifdef>
									</dd>
								</unit>
							</ifdef>
							<ifdef code="ca_objects.date.range">
								<dt><?= _t('Date(s)'); ?></dt>
								<unit relativeTo="ca_objects.date.range" delimiter=" ">
									<dd>^ca_objects.date.range</dd>
								</unit>
							</ifdef>
							<ifcount code="ca_entities" restrictToRelationshipTypes="home" min="1">
								<dt><?= _t('Originating Home Community'); ?></dt>
								<unit relativeTo="ca_entities" restrictToRelationshipTypes="home" delimiter=" ">
									<dd>^ca_entities.preferred_labels</dd>
								</unit>
							</ifcount>
							<ifdef code="ca_objects.culture">
								<dt><?= _t('Indigenous Culture'); ?></dt>
								<unit relativeTo="ca_objects.culture" delimiter=" ">
									<dd>^ca_objects.culture</dd>
								</unit>
							</ifdef>
							<ifdef code="ca_objects.place">
								<dt><?= _t('Geographic Place'); ?></dt>
								<unit relativeTo="ca_objects.place" delimiter=" ">
									<dd>^ca_objects.place</dd>
								</unit>
							</ifdef>
							<ifcount code="ca_entities" restrictToRelationshipTypes="home" min="1">
								<dt><?= _t('Holding Repository'); ?></dt>
								<unit relativeTo="ca_entities" restrictToRelationshipTypes="repository" delimiter=" ">
									<dd>^ca_entities.preferred_labels</dd>
								</unit>
							</ifcount>
						</dl>}}}
<?php	
	print $this->render("pdfEnd.php");