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
		<h1 class="title"><?php print $t_item->getWithTemplate('<ifdef code="ca_objects.Object_ArtistExpression">^ca_objects.Object_ArtistExpression<br/></ifdef><ifnotdef code="ca_objects.Object_ArtistExpression"><ifcount code="ca_entities" restrictToRelationshipTypes="artist" min="1"><unit relativeTo="ca_entities" restrictToRelationshipTypes="artist"><ifdef code="ca_entities.preferred_labels.forename">^ca_entities.preferred_labels.forename </ifdef><ifdef code="ca_entities.preferred_labels.surname">^ca_entities.preferred_labels.surname</ifdef><ifnotdef code="ca_entities.preferred_labels.surname,ca_entities.preferred_labels.forename">^ca_entities.preferred_labels.displayname</ifnotdef><ifdef code="ca_entities.preferred_labels.forename|ca_entities.preferred_labels.surname|ca_entities.preferred_labels.displayname">, </ifdef><ifdef code="ca_entities.Name_DateExpression">^ca_entities.Name_DateExpression</ifdef><br/></unit></ifcount></ifnotdef><i>^ca_objects.preferred_labels.name</i>'); ?></H1>
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
<?php
			print $t_item->getWithTemplate('
					<div class="grayBg">
						<ifdef code="ca_objects.Object_KressCatalogNumber"><div class="unit unitHalf"><label>Kress Number</label>^ca_objects.Object_KressCatalogNumber</div></ifdef>
						<ifdef code="ca_objects.idno"><div class="unit unitHalf"><label>Identifier</label>^ca_objects.idno</div></ifdef>
						<div class="clear"></div>
						<ifcount code="ca_entities" restrictToRelationshipTypes="artist,artist_additional" min="1"><div class="unit unitHalf"><label>Artist</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="artist,artist_additional" delimiter="<br/>">^ca_entities.preferred_labels.displayname</unit></div></ifcount>
						<ifdef code="ca_objects.Object_Nationality"><div class="unit unitHalf"><label>Nationality</label>^ca_objects.Object_Nationality</div></ifdef>
						<div class="clear"></div>
						<ifdef code="ca_objects.Object_DateExpression"><div class="unit unitHalf"><label>Date</label>^ca_objects.Object_DateExpression</div></ifdef>
						<ifdef code="ca_objects.Object_Medium"><div class="unit unitHalf"><label>Medium</label>^ca_objects.Object_Medium</div></ifdef>
						<div class="clear"></div>
						<ifdef code="ca_objects.Object_Classification"><div class="unit"><label>Type of Object</label>^ca_objects.Object_Classification</div></ifdef>
						<ifdef code="ca_objects.Object_Dimensions"><div class="unit"><label>Dimensions</label>^ca_objects.Object_Dimensions</div></ifdef>
						<ifcount code="ca_entities" restrictToRelationshipTypes="location"><div class="unit"><label>Location</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="location" delimiter="<br/>">^ca_entities.preferred_labels.displayname</unit></div></ifcount>
					</div>
					
					<ifcount code="ca_entities" restrictToRelationshipTypes="attribution" min="1"><div class="unit"><label>Historical Attribution</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="attribution" delimiter="<br/>">^ca_entities.preferred_labels.displayname</unit></div></ifcount>
					<ifdef code="ca_objects.Object_Provenance">
						<div class="unit"><label>Provenance</label>
							<span class="trimText">^ca_objects.Object_Provenance</span>
						</div>
					</ifdef>
					<ifdef code="ca_objects.Object_Note">
						<div class="unit"><label>Note</label>
							<span class="trimText">^ca_objects.Object_Note</span>
						</div>
					</ifdef>
				
					<ifdef code="ca_objects.Object_CurrentAccNo"><div class="unit"><label>Accession Number</label>^ca_objects.Object_CurrentAccNo</div></ifdef>
					<ifdef code="ca_objects.Object_AltKressNumber"><div class="unit"><label>Legacy Kress Number</label>^ca_objects.Object_AltKressNumber</div></ifdef>
					<ifdef code="ca_objects.Object_PichettoNo"><div class="unit"><label>Pichetto Number</label>^ca_objects.Object_PichettoNo</div></ifdef>
					<ifdef code="ca_objects.Object_DreyfusNumber"><div class="unit"><label>Dreyfus Number</label>^ca_objects.Object_DreyfusNumber</div></ifdef>
					<ifdef code="ca_objects.Object_NGAOldNumber"><div class="unit"><label>Legacy NGA Number</label>^ca_objects.Object_NGAOldNumber</div></ifdef>
					<ifdef code="ca_objects.Object_NGAOldLoanNumber"><div class="unit"><label>NGA Loan Number</label>^ca_objects.Object_NGAOldLoanNumber</div></ifdef>
					
					<ifcount code="ca_movements" min="1">
						<hr/>
						<label>^ca_movements._count Acquisition<ifcount code="ca_movements" min="2">s</ifcount></label>
						<unit relativeTo="ca_movements" delimiter="<br/>" sort="ca_movements.Acquisition_DateFilter"><div class="unit">^ca_movements.preferred_labels</div></unit>
					</ifcount>
					<ifcount code="ca_loans" min="1">
						<hr/>
						<label>^ca_loans._count Distribution<ifcount code="ca_loans" min="2">s</ifcount></label>
						<unit relativeTo="ca_loans" delimiter="<br/>" sort="ca_loans.Distribution_DateYearFilter"><div class="unit">^ca_loans.preferred_labels</div></unit>
					</ifcount>
					<ifdef code="ca_objects.Object_URLCollectionRecord|ca_objects.Object_URLNGALibraryImageURL">
						<hr/><label>External Links</label>					
						<ifdef code="ca_objects.Object_URLCollectionRecord"><div class="unit"><b>Related Collection Record</b><br/>^ca_objects.Object_URLCollectionRecord</div></ifdef>
						<ifdef code="ca_objects.Object_URLNGALibraryImageURL"><div class="unit"><b>Related National Gallery of Art Library Image Collections Record</b><div class="longLink">^ca_objects.Object_URLNGALibraryImageURL</div></div></ifdef>
					</ifdef>
					<ifcount code="ca_occurrences" min="1">
						<hr/><label>^ca_occurrences._count Archival Item<ifcount code="ca_occurrences" min="2">s</ifcount></label>						
						<unit relativeTo="ca_occurrences" delimiter=" " sort="ca_occurrences.Doc_DateFilter">
							<div class="grayBg">
								<div class="relatedThumbnail iconlarge">^ca_occurrences.media.media_media.iconlarge</div>
								<div class="relatedCaption">
									^ca_occurrences.preferred_labels
								</div>
								<div class="clear"></div>
							</div>
						</unit>		
					</ifcount>
					
					<ifcount code="ca_objects.related" min="1">
						<hr/><label>^ca_objects._count Related Art Object<ifcount code="ca_objects.related" min="2">s</ifcount></label>						
						<unit relativeTo="ca_objects" delimiter=" ">
							<div class="grayBg">
								<div class="relatedThumbnail">^ca_object_representations.media.thumbnail</div>
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