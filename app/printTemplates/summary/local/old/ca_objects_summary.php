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
 * @name Summary
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");

	print $this->render("pdfStart.php");
	print $this->render("../header.php");
	print $this->render("../footer.php");	
?>
	<div class="representationList">
		
<?php
	print $t_item->get('ca_object_representations.media.page', array('scaleCSSWidthTo' => '400px', 'scaleCSSHeightTo' => '400px'));

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
	<div class='tombstone'>
		
	{{{<unit relativeTo='ca_entities' restrictToRelationshipTypes='artist'>^ca_entities.preferred_labels.displayname</unit>}}}
<?php	
	print "<div><i>".$t_item->get('ca_objects.preferred_labels')."</i>, ".$t_item->get('ca_objects.creation_date')."</div>";
	print "<div>".$t_item->get('ca_objects.medium')."</div>"; 	
	print "<div>".$t_item->get('ca_objects.dimensionsdisplay_dimensions')."</div>"; 				
	if ($t_item->get('ca_objects.edition.edition_number')) {
		print "<div>".$t_item->get('ca_objects.edition.edition_number')." / ".$t_item->get('ca_objects.edition.edition_total')."</div>"; 	
	}
	if ($t_item->get('ca_objects.edition.ap_number')) {
		print "<div>".$t_item->get('ca_objects.edition.ap_number')." / ".$t_item->get('ca_objects.edition.ap_total')."</div>"; 	
	}	
	if ($this->request->user->hasUserRole("founder") || $this->request->user->hasUserRole("supercurator") || $this->request->user->hasUserRole("collection")){
		print "<div>".$t_item->get('ca_objects.idno')."</div>"; 
	}
?>	
	</div>
<?php						
	print $this->render("pdfEnd.php");