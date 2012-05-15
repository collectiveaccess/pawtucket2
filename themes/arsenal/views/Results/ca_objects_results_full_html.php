<?php
/* ----------------------------------------------------------------------
 * themes/default/views/ca_objects_full_html.php :
 * 		full search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2009 Whirl-i-Gig
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
 
 	
$vo_result 				= $this->getVar('result');
$vn_items_per_page		= $this->getVar('current_items_per_page');
global $g_ui_locale;

if($vo_result) {
	$vn_item_count = 0;
	$va_tooltips = array();
	$t_list = new ca_lists();
	while(($vn_item_count < $vn_items_per_page) && ($vo_result->nextHit())) {
		if (!$vs_idno = $vo_result->get('ca_objects.idno')) {
			$vs_idno = "???";
		}
		
		$vn_object_id = $vo_result->get('ca_objects.object_id');
		$directors = $vo_result->get('ca_entities.preferred_labels.displayname', array('returnAsArray' => true));
		$entitiesr = $vo_result->get('ca_objects_x_entities.type_id', array('returnAsArray' => true));
		include_once(__CA_MODELS_DIR__.'/ca_relationship_types.php'); // make sure the model class is loaded
		$t_rel_type = new ca_relationship_types();
	
	//	while($vo_result->nextHit()) {

			print "<div id='fullWrapper'><div class='searchFullText'>";
			$va_labels = $vo_result->getDisplayLabels($this->request);
			$vs_caption = join("<br />",$va_labels);
			print "<div class='searchFullTitle'>".caNavLink($this->request, $vs_caption, '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id))."</div>";
			$va_alternate_titles = $vo_result->get('ca_objects.nonpreferred_labels.name', array('returnAsArray' => true));
			if ($va_alternate_titles) {
				print "<div class='searchFullTextTextBlock'><b>".($g_ui_locale=="de_DE" ? "Weitere Titel" : "Other titles").":</b> ".join('; ', $va_alternate_titles)."</div>";
			}
			$va_entities = $vo_result->get('ca_entities', array('returnAsArray' => true));
			$va_entity_labels = array();
			foreach($va_entities as $va_entity){
				$va_entity_labels[] = $va_entity["displayname"];
			}
			print "<div class='searchFullTextTextBlock'><b>".($g_ui_locale=="de_DE" ? "Regie" : "Director").":</b> ";
			print join(', ', $va_entity_labels);
			print "</div>";
			print "<div class='searchFullTextTextBlock'><b>".($g_ui_locale=="de_DE" ? "Land" : "Country").":</b> ".$vo_result->get("ca_objects.country", array('convertCodesToDisplayText' => true))."</div>";
			print "<div class='searchFullTextTextBlock'><b>".($g_ui_locale=="de_DE" ? "Jahr" : "Year").":</b> ".$vo_result->get("ca_objects.production_year")."</div>";
			print "<div class='searchFullTextTextBlock'><b>".($g_ui_locale=="de_DE" ? "Format" : "Format").":</b> ".$vo_result->get("ca_objects.format", array('convertCodesToDisplayText' => true))."</div>";
			if($this->request->config->get("dont_enforce_access_settings")){
				print "<div class='searchFullTextTextBlock'><b>OA3 ID</b>: ".$vo_result->get('ca_objects.idno')."</div><!-- end unit -->";
			}
	
	
			
			print "<div class='searchFullTextTextBlock'>"."</div>";
			print "</div><!-- END searchFullText -->\n";
			print "<div class='searchFullImageContainer'>";
			print caNavLink($this->request, $vo_result->getMediaTag('ca_object_representations.media', 'preview'), '', 'Detail', 'Object', 'Show', array('object_id' => $vn_object_id));
			print "</div></div><!-- END searchFullImageContainer -->";
			$vn_item_count++;
			if($vn_item_count < $vn_items_per_page){
				print "<div class='divide' style='clear:left;'><!-- empty --></div>\n";
			}
		
		//}
	}
}
?>