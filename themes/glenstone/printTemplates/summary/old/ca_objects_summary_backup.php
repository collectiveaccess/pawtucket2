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

	<div class="representationList">
		
<?php
	//$va_reps = $t_item->getRepresentations(array("medium"), null, array('return_primary_only' => true));

	//foreach($va_reps as $va_rep) {
			# --- one rep - show medium rep
			//print $va_rep['tags']['medium']."\n";
			print $t_item->get('ca_object_representations.media.page', array('scaleCSSWidthTo' => '400px', 'scaleCSSHeightTo' => '400px'));
			//break;
	//}
?>
	</div>
	<table id="displayValues">
	
<?php
	if(is_array($va_placements)) {
		foreach($va_placements as $vn_placement_id => $va_bundle_info){
			if (!is_array($va_bundle_info)) break;
			if (in_array($va_bundle_info['bundle_name'], array('ca_object_representations.media.icon', 'ca_object_representations.media'))) { continue; }		// skip preferred labels because we always print it anyway
		
			if (($va_bundle_info['bundle_name'] == 'ca_objects.idno') | ($va_bundle_info['bundle_name'] == 'ca_objects.edition') | ($va_bundle_info['bundle_name'] == 'ca_objects.dimensions') | ($va_bundle_info['bundle_name'] ==  'ca_objects.medium') | ($va_bundle_info['bundle_name'] ==  'ca_objects.preferred_labels') | ($va_bundle_info['bundle_name'] ==  'ca_objects.preferred_labels') | ($va_bundle_info['bundle_name'] ==  'ca_entities')) {$va_skip_label = true;} else {$va_skip_label = false;}
			if (!strlen($vs_display_value = $t_display->getDisplayValue($t_item, $vn_placement_id, array('purify' => true)))) {
				if (!(bool)$t_display->getSetting('show_empty_values')) { continue; }
				$vs_display_value = "&lt;"._t('not defined')."&gt;";
			}
			if ($va_skip_label == false) {
				print '<tr class="data" ><td class="label" style="border-bottom:1px solid #eee;">'.$va_bundle_info['display'].'</td><td class="value" style="border-bottom:1px solid #eee;"> '.$vs_display_value.'</td></tr>';
			} else {
				print '<tr class="data"><td class="value tombstone" colspan="4"> '.$vs_display_value.'</td></tr>';
			}
		}
	}
?>
	</table>
<?php	
	print $this->render("pdfEnd.php");