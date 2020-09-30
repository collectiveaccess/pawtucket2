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
 * @name Entity summary
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_entities
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
		<h1 class="title"><?php print $t_item->get('ca_entities.preferred_labels.displayname'); ?></H1>
	</div>
<?php
	$vs_tmp = $t_item->getWithTemplate('<ifdef code="ca_entities.idno"><div class="unit"><label>Identifier</label>^ca_entities.idno</div></ifdef>');
	if($vn_list_item_id = $t_item->get("ca_entities.Name_KressInstitutionType")){
		$t_list_item = new ca_list_items($vn_list_item_id);
		$vs_tmp .= '<div class="unit"><label>Institution Type</label>'.$t_list_item->get("ca_list_item_labels.name_singular").'</div>';
	}
	$vs_tmp .= $t_item->getWithTemplate('<ifdef code="ca_entities.nonpreferred_labels.displayname"><div class="unit"><label>Alternate Names</label>^ca_entities.nonpreferred_labels.displayname</div></ifdef>
									<ifdef code="ca_entities.Name_InstitutionStatus"><div class="unit"><label>Status</label>^ca_entities.Name_InstitutionStatus</div></ifdef>
									<ifdef code="ca_entities.Name_Nationality"><div class="unit"><label>Nationality</label>^ca_entities.Name_Nationality</div></ifdef>
									<ifdef code="ca_entities.Name_BirthDateFilter"><div class="unit"><label>Birth Date</label>^ca_entities.Name_BirthDateFilter</div></ifdef>
									<ifdef code="ca_entities.Name_DeathDateFilter"><div class="unit"><label>Death Date</label>^ca_entities.Name_DeathDateFilter</div></ifdef>
									<ifdef code="ca_entities.Name_InstitutionWeb"><div class="unit"><label>Web Address</label><a href="^ca_entities.Name_InstitutionWeb" target="_blank">^ca_entities.Name_InstitutionWeb</a> <i class="fa fa-external-link" aria-hidden="true"></i></div></ifdef>
									<ifdef code="ca_entities.Name_Location"><div class="unit"><label>Location</label>^ca_entities.Name_Location</div></ifdef>');
	$vs_links = $t_item->getWithTemplate('<ifdef code="ca_entities.Name_ULANURI"><div class="unit"><label>Union List of Artist Names record</label>^ca_entities.Name_ULANURI</div></ifdef>');
	if($vs_Name_VIAFURI = $t_item->get("ca_entities.Name_VIAFURI")){
		$va_Name_VIAFURI = explode(";", $vs_Name_VIAFURI);
		$vs_links .= '<div class="unit"><label>Virtual International Authority File record</label>'.join("<br/>", $va_Name_VIAFURI).'</div>';
	}
	$vs_links .= $t_item->getWithTemplate('<ifdef code="ca_entities.Name_LCCNURI"><div class="unit"><label>Library of Congress Name Authority File record</label>^ca_entities.Name_LCCNURI</div></ifdef>
								<ifdef code="ca_entities.NAME_wikipediaURL"><label>Wikipedia</label>^ca_entities.NAME_wikipediaURL</div></ifdef>');
	if($vs_links){
		$vs_tmp .= "<div class='unit'><br/><label>External Links</label>".$vs_links."</div>";
	}
	if(trim($vs_tmp)){
		print '<div class="grayBg">'.$vs_tmp.'</div>';
	}
	print $t_item->getWithTemplate('
		<ifcount code="ca_movements" min="1">
			<hr/>
			<label>^ca_movements._count Acquisition<ifcount code="ca_movements" min="2">s</ifcount></label>
			<unit relativeTo="ca_movements" delimiter=" " sort="ca_movements.Acquisition_DateFilter"><div class="unit">^ca_movements.preferred_labels</div></unit>
		</ifcount>
		<ifcount code="ca_loans" min="1">
			<hr/>
			<label>^ca_loans._count Distribution<ifcount code="ca_loans" min="2">s</ifcount></label>
			<unit relativeTo="ca_loans" delimiter=" " sort="ca_loans.Distribution_DateYearFilter"><div class="unit">^ca_loans.preferred_labels</div></unit>
		</ifcount>
		<if rule="^ca_entities.Name_Type !~ /Institution/"><ifcount code="ca_occurrences" min="1" restrictToTypes="documentation">
			<hr/><label>^ca_occurrences._count Archival Item<ifcount code="ca_occurrences" min="2" restrictToTypes="documentation">s</ifcount></label>						
			<unit relativeTo="ca_occurrences" restrictToTypes="documentation" delimiter=" " sort="ca_occurrences.Doc_DateFilter">
				<div class="grayBg">
					<div class="relatedThumbnail iconlarge">^ca_occurrences.media.media_media.iconlarge</div>
					<div class="relatedCaption">
						^ca_occurrences.preferred_labels
					</div>
					<div class="clear"></div>
				</div>
			</unit>		
		</ifcount></if>
		<ifcount code="ca_objects" min="1">
			<hr/><label>^ca_objects._count Related Art Object<ifcount code="ca_objects" min="2">s</ifcount></label>						
			<unit relativeTo="ca_objects" delimiter=" ">
				<div class="grayBg">
					<div class="relatedThumbnail">^ca_object_representations.media.thumbnail</div>
					<div class="relatedCaption">
						<ifdef code="ca_objects.Object_KressCatalogNumber"><small>^ca_objects.Object_KressCatalogNumber</small><br/></ifdef><ifdef code="ca_objects.Object_ArtistExpression">^ca_objects.Object_ArtistExpression<br/></ifdef><ifnotdef code="ca_objects.Object_ArtistExpression"><ifcount code="ca_entities" restrictToRelationshipTypes="artist" min="1"><unit relativeTo="ca_entities" restrictToRelationshipTypes="artist"><ifdef code="ca_entities.preferred_labels.forename">^ca_entities.preferred_labels.forename </ifdef><ifdef code="ca_entities.preferred_labels.surname">^ca_entities.preferred_labels.surname</ifdef><ifnotdef code="ca_entities.preferred_labels.surname,ca_entities.preferred_labels.forename">^ca_entities.preferred_labels.displayname</ifnotdef><br/></unit></ifcount></ifnotdef><i>^ca_objects.preferred_labels.name</i>
					</div>
					<div class="clear"></div>
				</div>
			</unit>		
		</ifcount>
		
		');

		print '<hr/><div class="unit"><label>Record Link</label>'.$this->request->config->get("site_host").caDetailUrl($this->request, $t_item->tableName(), $t_item->getPrimaryKey()).'</div>';

	
	print $this->render("pdfEnd.php");
?>