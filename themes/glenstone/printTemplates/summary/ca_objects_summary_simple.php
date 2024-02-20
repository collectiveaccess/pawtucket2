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
 * @name Full page [SIMPLE]
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @marginLeft 1 in
 * @marginRight 1 in
 * @marginTop 1 in
 * @marginBottom 1 in
 * @tables ca_objects
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	
	
	$va_access_values = caGetUserAccessValues($this->request);
?>
	<div class="representationList representationListFullpage">
		
<?php
	#print $t_item->get('ca_object_representations.media.page', array('scaleCSSWidthTo' => '400px', 'scaleCSSHeightTo' => '400px'));
	$va_rep = $t_item->getPrimaryRepresentation(array('page'), null, array('return_with_access' => $va_access_values, 'scaleCSSWidthTo' => '620px', 'scaleCSSHeightTo' => '480px'));
	print $va_rep['tags']['page'];
#	foreach($va_reps as $va_rep) {
#		if(sizeof($va_reps) > 1){
#			# --- more than one rep show thumbnails
#			$vn_padding_top = ((120 - $va_rep["info"]["thumbnail"]["HEIGHT"])/2) + 5;
#			print $va_rep['tags']['thumbnail']."\n";
#		}else{
#			# --- one rep - show medium rep
#			print $va_rep['tags']['medium']."\n";
#		}
#	}
?>
	</div>
	<div class='tombstone fullpageTombstone'>
		
	{{{<unit relativeTo='ca_entities' restrictToRelationshipTypes='artist'>^ca_entities.preferred_labels.displayname</unit>}}}
<?php	
	print "<div><i>".$t_item->get('ca_objects.preferred_labels')."</i>, ".$t_item->get('ca_objects.creation_date_display')."</div>";
	print "<div>".$t_item->get('ca_objects.medium')."</div>"; 	
	print "<div>".$t_item->get('ca_objects.dimensions.display_dimensions', array('delimiter' => '<br/>'))."</div>"; 				
	if ($t_item->get('ca_objects.edition.edition_number')) {
		print "<div class='unit'>Edition ".$t_item->get('ca_objects.edition.edition_number')." / ".$t_item->get('ca_objects.edition.edition_total');
		if ($t_item->get('ca_objects.edition.ap_total')) {
			print " + ".$t_item->get('ca_objects.edition.ap_total')." AP";
		}
		print "</div>";
	} elseif ($t_item->get('ca_objects.edition.ap_number')) {
		$ap_total = $t_item->get('ca_objects.edition.ap_total');
		print "<div class='unit'>AP ".((is_array($ap_total) && (sizeof($ap_total) >= 2)) ? $t_item->get('ca_objects.edition.ap_number') : "")." from an edition of ".$t_item->get('ca_objects.edition.edition_total')." + ".$t_item->get('ca_objects.edition.ap_total')." AP";
		print "</div>";					
	}
	if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("curatorial_advanced") || $this->request->user->hasUserRole("curatorial_basic_new") || $this->request->user->hasUserRole("archives_new") || $this->request->user->hasUserRole("library_new")){
		//print "<div>".$t_item->get('ca_objects.idno')."</div>"; 
		if ($t_item->get('is_deaccessioned') && ($t_item->get('deaccession_date', array('getDirectDate' => true)) <= caDateToHistoricTimestamp(_t('now')))) {
			print "<div style='font-style:italic; font-size:10px; color:red;'>"._t('Deaccessioned %1', $t_item->get('deaccession_date'))."</div>\n";
		}			
	}
?>	
	</div>
<?php						
	print $this->render("pdfEnd.php");