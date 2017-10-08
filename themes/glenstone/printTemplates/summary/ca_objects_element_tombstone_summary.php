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
 * @name Object summary
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
 * @disabled 1
 *
 * ----------------------------------------------------------------------
 */
 
 	$t_item = $this->getVar('t_subject');
	
	$va_bundle_displays = $this->getVar('bundle_displays');
	$t_display = $this->getVar('t_display');
	$va_placements = $this->getVar("placements");

	print $this->render("pdfStart.php");
	print $this->render("header.php");
	print $this->render("footer.php");	
	
	
 	

?>

	<div class="representationList" <?php print $vs_media_style; ?>>
		
<?php
			#print $t_item->get('ca_object_representations.media.page', array('scaleCSSWidthTo' => '400px', 'scaleCSSHeightTo' => '400px'));
			$va_reps = $t_item->getRepresentations(array("page"), null, array('return_primary_only' => true, 'scaleCSSWidthTo' => '400px', 'scaleCSSHeightTo' => '400px'));
			foreach ($va_reps as $va_rep) {
				print $va_rep['tags']['page'];
			}
			//break;
		
?>
	</div>
	<div id="displayValues">
<?php
				$vs_parent = $t_item->get('ca_objects.parent.object_id');	
				$t_parent = new ca_objects($vs_parent);
				$vs_artist = $t_parent->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist')));
				$vs_title = "<i>".$t_parent->get('ca_objects.preferred_labels')."</i>";
				$vs_date = ", ".$t_parent->get('ca_objects.creation_date_display');
				print "<div style='margin:0px 0px 20px 5px;'>";
				print '<div class="value tombstone"><span>'.$vs_artist.'</span></div>';
				print '<div class="value tombstone"><span>'.$vs_title.$vs_date.'</span></div>';
				print "</div>";

?>	

	
<?php
	
	foreach($va_placements as $vn_placement_id => $va_bundle_info){
	
		
		
		if (!strlen($vs_display_value = trim($t_display->getDisplayValue($t_item, $vn_placement_id, $va_opts)))) {
			if (!(bool)$t_display->getSetting('show_empty_values')) { continue; }
			$vs_display_value = "&lt;"._t('not defined')."&gt;";
		}	

		//print '<div class="data" ><div class="label" style="border-bottom:1px solid #eee;">'.$va_bundle_info['display'].'</div><div class="value" style="border-bottom:1px solid #eee;"> '.$vs_display_value.'</div>';
		print '<table><tr class="data" ><td class="label" style="border-bottom:1px solid #eee;">'.$va_bundle_info['display'].'</td><td class="value" style="border-bottom:1px solid #eee;"> '.$vs_display_value.'</td></tr></table>';
	
	}
?>
	</div>
<?php	
	print $this->render("pdfEnd.php");