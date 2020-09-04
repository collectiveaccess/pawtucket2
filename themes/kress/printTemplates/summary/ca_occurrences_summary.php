<?php
/* ----------------------------------------------------------------------
 * /printTemplates/summary/ca_occurrences_summary.php
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
 * @name Archival Item tear sheet
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_occurrences
 * @types documentation
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
		<h1 class="title"><?php print $t_item->getWithTemplate('^ca_occurrences.preferred_labels.name'); ?></H1>
	</div>
	<div class="representationList">
		
<?php
	print $t_item->get("ca_occurrences.media.media_media.medium");
?>
	</div>
<?php
			print $t_item->getWithTemplate('
					<div class="grayBg">
						<ifdef code="ca_occurrences.idno"><div class="unit unitHalf"><label>Identifier</label>^ca_occurrences.idno</div></ifdef>	
						<ifdef code="ca_occurrences.Doc_type"><div class="unit unitHalf"><label>Document Type</label>^ca_occurrences.Doc_type</div></ifdef>
						
						<ifcount code="ca_entities" min="1"><div class="unit"><label>Creator<ifcount code="ca_entities" min="2">s</ifcount></label><unit relativeTo="ca_entities" delimiter=", ">^ca_entities.preferred_labels.displayname</unit></div></ifcount>
						<ifdef code="ca_occurrences.Doc_Photographer"><div class="unit"><label>Photographer</label>^ca_occurrences.Doc_Photographer</div></ifdef>
						<ifdef code="ca_occurrences.Doc_Date"><div class="unit"><label>Date</label>^ca_occurrences.Doc_Date</div></ifdef>
						<ifdef code="ca_occurrences.Doc_Source"><div class="unit"><label>Citation</label>^ca_occurrences.Doc_Source</div></ifdef>
					</div>
					
					<ifdef code="ca_occurrences.Doc_Note"><div class="unit"><label>Note</label>^ca_occurrences.Doc_Note</div></ifdef>
					<ifcount code="ca_objects" min="1">
						<hr/><label>^ca_objects._count Related Art Object<ifcount code="ca_objects" min="2">s</ifcount></label>						
						<unit relativeTo="ca_objects" delimiter=" ">
							<div class="grayBg">
								<ifdef code="ca_object_representations.media.thumbnail"><div class="relatedThumbnail">^ca_object_representations.media.thumbnail</div></ifdef>
								<div class="relatedCaption">
									<ifdef code="ca_objects.Object_KressCatalogNumber"><small>^ca_objects.Object_KressCatalogNumber</small><br/></ifdef><ifdef code="ca_objects.Object_ArtistExpression">^ca_objects.Object_ArtistExpression<br/></ifdef><ifnotdef code="ca_objects.Object_ArtistExpression"><ifcount code="ca_entities" restrictToRelationshipTypes="artist" min="1"><unit relativeTo="ca_entities" restrictToRelationshipTypes="artist"><ifdef code="ca_entities.preferred_labels.forename">^ca_entities.preferred_labels.forename </ifdef><ifdef code="ca_entities.preferred_labels.surname">^ca_entities.preferred_labels.surname</ifdef><ifnotdef code="ca_entities.preferred_labels.surname,ca_entities.preferred_labels.forename">^ca_entities.preferred_labels.displayname</ifnotdef><br/></unit></ifcount></ifnotdef><i>^ca_objects.preferred_labels.name</i><ifcount code="ca_entities" restrictToRelationshipTypes="location"><br/><unit relativeTo="ca_entities" restrictToRelationshipTypes="location" delimiter="<br/>">^ca_entities.preferred_labels.displayname</unit></ifcount>
								</div>
								<div class="clear"></div>
							</div>
						</unit>		
					</ifcount>
					
			');
	
	print $this->render("pdfEnd.php");
?>