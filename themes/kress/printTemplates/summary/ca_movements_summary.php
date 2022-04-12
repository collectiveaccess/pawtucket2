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
 * @name Acquisitions summary
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_movements
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
		<h1 class="title"><?php print $t_item->getWithTemplate('^ca_movements.preferred_labels.name'); ?></H1>
	</div>
	<div class="representationList">
		
<?php
	print $t_item->get("ca_movements.media.media_media.medium");
?>
	</div>
<?php
			print $t_item->getWithTemplate('
					<div class="grayBg">
						<ifdef code="ca_movements.idno"><div class="unit"><label>Identifier</label>^ca_movements.idno</div></ifdef>	
						<ifcount code="ca_entities" restrictToRelationshipTypes="seller" min="1"><div class="unit unitHalf"><label>Seller</label><unit relativeTo="ca_entities" restrictToRelationshipTypes="seller" delimiter="<br/>">^ca_entities.preferred_labels.displayname</unit></div></ifcount>
						<ifdef code="ca_movements.Acquisition_Date"><div class="unit unitHalf"><label>Date</label>^ca_movements.Acquisition_Date</div></ifdef>							
						<div class="clear"></div>
						<ifdef code="ca_movements.Acquisition_ObjectCount"><div class="unit unitHalf"><label>Number of Objects</label>^ca_movements.Acquisition_ObjectCount</div></ifdef>
						<ifdef code="ca_movements.Acquisition_PriceUSD"><div class="unit unitHalf"><label>Group Purchase Price</label>^ca_movements.Acquisition_PriceUSD</div></ifdef>
						<div class="clear"></div>
						<ifdef code="ca_movements.Acquisition_FinalPayDate"><div class="unit unitHalf"><label>Final Payment Date</label>^ca_movements.Acquisition_FinalPayDate</div></ifdef>
						<ifdef code="ca_movements.Acquisition_Location"><div class="unit unitHalf"><label>Seller Location</label>^ca_movements.Acquisition_Location</div></ifdef>
						<div class="clear"></div>
						<ifdef code="ca_movements.Acquisition_Source"><div class="unit"><label>Citation</label>^ca_movements.Acquisition_Source</div></ifdef>
						<ifdef code="ca_movements.Acquisition_Note"><div class="unit"><label>Note</label>^ca_movements.Acquisition_Note</div></ifdef>
					
					</div>
					
					<ifcount code="ca_objects" min="1">
						<hr/><label>^ca_objects._count Related Art Object<ifcount code="ca_objects" min="2">s</ifcount></label>						
						<unit relativeTo="ca_objects" delimiter=" ">
							<div class="grayBg">
								<div class="relatedThumbnail">^ca_object_representations.media.thumbnail</div>
								<div class="relatedCaption">
									<ifdef code="ca_objects.Object_KressCatalogNumber"><small>^ca_objects.Object_KressCatalogNumber</small><br/></ifdef><ifdef code="ca_objects.Object_ArtistExpression">^ca_objects.Object_ArtistExpression<br/></ifdef><ifnotdef code="ca_objects.Object_ArtistExpression"><ifcount code="ca_entities" restrictToRelationshipTypes="artist" min="1"><unit relativeTo="ca_entities" restrictToRelationshipTypes="artist"><ifdef code="ca_entities.preferred_labels.forename">^ca_entities.preferred_labels.forename </ifdef><ifdef code="ca_entities.preferred_labels.surname">^ca_entities.preferred_labels.surname</ifdef><ifnotdef code="ca_entities.preferred_labels.surname,ca_entities.preferred_labels.forename">^ca_entities.preferred_labels.displayname</ifnotdef><br/></unit></ifcount></ifnotdef><i>^ca_objects.preferred_labels.name</i><ifcount code="ca_entities" restrictToRelationshipTypes="location"><br/><unit relativeTo="ca_entities" restrictToRelationshipTypes="location" delimiter="<br/>">^ca_entities.preferred_labels.displayname</unit></ifcount>
									<br/><br/><ifdef code="ca_movements_x_objects.AcqObjJoin_Type"><b>Type:</b> ^ca_movements_x_objects.AcqObjJoin_Type</ifdef><ifdef code="ca_movements_x_objects.AcqObjJoin_Attribution"><br><b>Attribution History:</b> ^ca_movements_x_objects.AcqObjJoin_Attribution</ifdef><ifdef code="ca_movements_x_objects.AcqObjJoin_PriceUSD"><br><b>Purchase Amount:</b> ^ca_movements_x_objects.AcqObjJoin_PriceUSD</ifdef><ifdef code="ca_movements_x_objects.AcqObjJoin_CreditUSD"><br><b>Credit Amount:</b> ^ca_movements_x_objects.AcqObjJoin_CreditUSD</ifdef><ifdef code="ca_movements_x_objects.AcqObjJoin_ReturnUSD"><br><b>Return Amount:</b> ^ca_movements_x_objects.AcqObjJoin_ReturnUSD</ifdef><ifdef code="ca_movements_x_objects.AcqObjJoin_InternalNote"><br><b>Note:</b> ^ca_movements_x_objects.AcqObjJoin_InternalNote</ifdef>
								</div>
								<div class="clear"></div>
							</div>
						</unit>		
					</ifcount>		
					
			');
			print '<hr/><div class="unit"><label>Record Link</label>'.$this->request->config->get("site_host").caDetailUrl($this->request, $t_item->tableName(), $t_item->getPrimaryKey()).'</div>';
	
	print $this->render("pdfEnd.php");
?>