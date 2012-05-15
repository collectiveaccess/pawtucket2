<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Results/ca_objects_results_full_html.php :
 * 		full search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2011 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
 
 	
$vo_result 					= $this->getVar('result');
$vn_items_per_page		= $this->getVar('current_items_per_page');
$va_access_values 		= $this->getVar('access_values');

if($vo_result) {
	$vn_item_count = 0;
	$va_tooltips = array();
	$t_list = new ca_lists();
	while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
		if (!$vs_idno = $vo_result->get('ca_objects.idno')) {
			$vs_idno = "???";
		}
		
		$vn_object_id = $vo_result->get('ca_objects.object_id');
		
		print "<div class='searchFullImageContainer'>";
		print caNavLink($this->request, $vo_result->getMediaTag('ca_object_representations.media', 'thumbnail', array('checkAccess' => $va_access_values)), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
		print "</div><!-- END searchFullImageContainer -->";
		print "<div class='searchFullText'>";
		$va_labels = $vo_result->getDisplayLabels($this->request);
		$vs_caption = join('<br/>', $va_labels);
		print "<div class='searchFullTitle'>".caNavLink($this->request, $vs_idno, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
		print "<div class='searchFullTextTextBlock'><b>"._t("Specimen Type").":</b> ".caReturnDefaultIfBlank($vo_result->get("ca_objects.specimenType"))."</div>";
		print "<div class='searchFullTextTextBlock'><b>"._t("Class").":</b> ".caReturnDefaultIfBlank($vo_result->get("ca_objects.class"))."</div>";
		print "<div class='searchFullTextTextBlock'><b>"._t("Order").":</b> ".caReturnDefaultIfBlank($vo_result->get("ca_objects.order"))."</div>";
		print "<div class='searchFullTextTextBlock'><b>"._t("Family").":</b> ".caReturnDefaultIfBlank($vo_result->get("ca_objects.family"))."</div>";
		print "<div class='searchFullTextTextBlock'><b>"._t("Genus").":</b> ".caReturnDefaultIfBlank($vo_result->get("ca_objects.genus"))."</div>";
		print "<div class='searchFullTextTextBlock'><b>"._t("Species").":</b> ".caReturnDefaultIfBlank($vo_result->get("ca_objects.species"))."</div>";
		print "</div><!-- END text1 -->";
		print "<div class='searchFullText2'>";
		print "<div class='searchFullTextTextBlock2'><b>"._t("Parataxon").":</b> ".caReturnDefaultIfBlank($vo_result->get("ca_objects.parataxon"))."</div>";
		print "<div class='searchFullTextTextBlock2'><b>"._t("Pore System").":</b> ".caReturnDefaultIfBlank($vo_result->get("ca_objects.poreSystem"))."</div>";
		print "<div class='searchFullTextTextBlock2'><b>"._t("Morphotype").":</b> ".caReturnDefaultIfBlank($vo_result->get("ca_objects.morphotype"))."</div>";
		
		$va_locality_hier = $vo_result->get("ca_places.hierarchy.preferred_labels", array('returnAsArray' => true, 'checkAccess' => $va_access_values));
		$va_locality_list = $vo_result->get("ca_places", array('returnAsArray' => true, 'checkAccess' => $va_access_values));
		
		$va_locality_display = array();
		
		if (is_array($va_locality_hier)) {
			$va_locality_hier = array_values($va_locality_hier);
			$va_locality_list = array_values($va_locality_list);
			foreach($va_locality_hier as $vn_index => $va_locality) {
				array_shift($va_locality); // get rid of root node
				$vs_locality_name = array_pop($va_locality);
				$va_locality[] = caNavLink($this->request, $vs_locality_name, '', 'Detail', 'Place', 'Index', array('place_id' => $va_locality_list[$vn_index]['place_id']));
				$va_locality_display[] = join(" / ", $va_locality);
			}
		}
		
		print "<div class='searchFullTextTextBlock2'><b>"._t("Locality").":</b> ".caReturnDefaultIfBlank(join("; ", $va_locality_display))."</div>";
		print "<div class='searchFullTextTextBlock2'><b>"._t("Locality Formation").":</b> ".caReturnDefaultIfBlank($vo_result->get("ca_places.formation"))."</div>";
		print "<div class='searchFullTextTextBlock2'><b>"._t("Locality Member").":</b> ".caReturnDefaultIfBlank($vo_result->get("ca_places.member"))."</div>";
		print "<div class='searchFullTextTextBlock2'><b>"._t("Locality Age").":</b> ".caReturnDefaultIfBlank($vo_result->get("ca_places.ageNALMA"))."</div>";
		print "</div><!-- END searchFullText -->\n";
		$vn_item_count++;
		if(!$vo_result->isLastHit()){
			print "<div class='divide' style='clear:left;'><!-- empty --></div>\n";
		}
		
	}
}
?>
